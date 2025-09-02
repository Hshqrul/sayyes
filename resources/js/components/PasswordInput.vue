<script setup lang="ts">
import { ref } from 'vue'
import { EyeClosedIcon, EyeIcon, EyeOffIcon } from 'lucide-vue-next'
import Input from './ui/input/Input.vue'

const props = defineProps<{
	modelValue?: string
	disabled?: boolean
	class?: string
	placeholder?: string
}>()

const emit = defineEmits(['update:modelValue'])

const showPassword = ref(false)
</script>

<template>
	<div class="relative">
		<Input :type="showPassword ? 'text' : 'password'" class="hide-password-toggle pr-10" :class="class" required
			:model-value="modelValue" @update:model-value="emit('update:modelValue', $event)" :disabled="disabled" :placeholder="placeholder" />

		<button type="button" class="absolute right-0 top-0 h-full px-3 py-2 hover:bg-transparent transition"
			@click="showPassword = !showPassword" :disabled="!modelValue || disabled">
			<component :is="showPassword && modelValue && !disabled ? EyeClosedIcon : EyeIcon"
				class="w-4 h-4 transition-transform duration-200" aria-hidden="true" />
			<span class="sr-only">{{ showPassword ? 'Hide password' : 'Show password' }}</span>
		</button>
	</div>
</template>

<style>
.hide-password-toggle::-ms-reveal,
.hide-password-toggle::-ms-clear {
	visibility: hidden;
	pointer-events: none;
	display: none;
}
</style>
