<script setup lang="ts">
import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
    AlertDialogTrigger,
} from '@/components/ui/alert-dialog'

const props = defineProps<{
    itemName?: string // e.g. "user", "product", "post"
    triggerText?: string // default: "Delete"
}>()

const emit = defineEmits<{
    (e: 'confirm'): void
}>()
</script>

<template>
    <AlertDialog>
        <!-- Trigger button -->
        <AlertDialogTrigger>
            <slot />
                <!-- <button
                    class="flex items-center justify-center w-full py-1.5 px-2 rounded-sm text-sm hover:bg-muted"
                    type="button"
                >
                    {{ props.triggerText || 'Delete' }}
                </button>

            </slot> -->
        </AlertDialogTrigger>

        <AlertDialogContent>
            <AlertDialogHeader>
                <AlertDialogTitle>
                    Are you sure you want to delete
                    <span v-if="props.itemName">{{ props.itemName }}</span>?
                </AlertDialogTitle>
                <AlertDialogDescription>
                    This action cannot be undone. The selected
                    <span v-if="props.itemName">{{ props.itemName }}</span>
                    will be permanently removed from our servers.
                </AlertDialogDescription>
            </AlertDialogHeader>

            <AlertDialogFooter>
                <AlertDialogCancel>Cancel</AlertDialogCancel>
                <AlertDialogAction class="bg-red-600 text-white hover:bg-red-700" @click="emit('confirm')">
                    Delete
                </AlertDialogAction>
            </AlertDialogFooter>
        </AlertDialogContent>
    </AlertDialog>
</template>
