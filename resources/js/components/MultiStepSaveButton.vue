<script setup lang="ts">
import { ref } from 'vue'
import MultiStepLoader from '@/components/ui/multi-step-loader/MultiStepLoader.vue'

const props = defineProps<{
    steps: {
        text: string
        afterText?: string
        duration?: number
        action?: () => Promise<void>
    }[]
    triggerAction?: () => Promise<void>
    onFinish?: () => void
}>()

const uiState = ref({
    isAfterTextLoading: false,
    hasError: false,
    errorMessage: '',
})

const asyncLoadingSteps = ref(props.steps)

const closeAsync = () => {
    uiState.value.isAfterTextLoading = false
}

const start = async () => {
    uiState.value.hasError = false
    uiState.value.errorMessage = ''
    uiState.value.isAfterTextLoading = true

    try {
        for (const step of asyncLoadingSteps.value) {
            // ⛔ if already has error, stop loop
            if (uiState.value.hasError) break

            if (step.action) {
                await step.action().catch((error: any) => {
                    uiState.value.hasError = true
                    uiState.value.errorMessage =
                        error?.message || 'Validation failed at step: ' + step.text
                    throw error // abort loader
                })
            }

            if (step.duration) {
                await new Promise(resolve => setTimeout(resolve, step.duration))
            }
        }

        // ⛔ only continue if no error
        if (!uiState.value.hasError && props.triggerAction) {
            await props.triggerAction()
        }

        if (!uiState.value.hasError) {
            props.onFinish?.()
        }
    } catch (error) {
        // error already handled above, just stop loader
    } finally {
        uiState.value.isAfterTextLoading = false
    }
}

defineExpose({ start, closeAsync })
</script>

<template>
    <MultiStepLoader :steps="asyncLoadingSteps" :loading="uiState.isAfterTextLoading" @close="closeAsync" />
    <div v-if="uiState.hasError" class="mt-2 text-sm text-red-500">
        {{ uiState.errorMessage }}
    </div>
    <slot name="button" :loading="uiState.isAfterTextLoading" :start="start" />
</template>
