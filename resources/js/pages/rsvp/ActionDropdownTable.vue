<script setup lang="ts">
import { Eye, MoreHorizontal, Trash2 } from 'lucide-vue-next'
import { Button } from '@/components/ui/button'
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuGroup,
    DropdownMenuTrigger
} from '@/components/ui/dropdown-menu'
import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
    AlertDialogTrigger
} from '@/components/ui/alert-dialog'
import { Link } from '@inertiajs/vue3';

const props = defineProps<{
    id: number
    name: string
    no_of_pax: number
    attendence: boolean
    notes: string
    created_at: string
}>()

function onEdit() {
    console.log('Edit', props.name)
}

function onDelete() {
    console.log('Delete', props.name)
}

function copy(id: string) {
    navigator.clipboard.writeText(id)
}

function confirmDelete(eventId: number) {
    if (confirm("Are you sure you want to delete this rsvp?")) {
        //
    }
}
</script>

<template>
    <DropdownMenu>
        <DropdownMenuTrigger as-child>
            <Button variant="ghost" class="w-8 h-8 p-0">
                <span class="sr-only">Open menu</span>
                <MoreHorizontal class="w-4 h-4" />
            </Button>
        </DropdownMenuTrigger>

        <DropdownMenuContent align="end">
            <DropdownMenuGroup>
                <DropdownMenuItem as-child>
                    <AlertDialog>
                        <AlertDialogTrigger class="flex w-full items-center justify-center p-2 text-sm hover:bg-muted">
                            <Eye class="size-4 mr-2" />
                            Show Dialog
                        </AlertDialogTrigger>

                        <AlertDialogContent :class="{
                            'bg-indigo-200 border-indigo-200 dark:bg-indigo-900 dark:border-indigo-600': attendence == true,
                            'bg-yellow-200 border-amber-200 dark:bg-yellow-900 dark:border-yellow-600': attendence == false,
                        }">
                            <AlertDialogHeader>
                                <AlertDialogTitle>From {{ name }}</AlertDialogTitle>

                                <AlertDialogDescription>
                                    <p class="italic text-lg break-words" :class="{
                                        'text-indigo-600 dark:text-indigo-300': attendence == true,
                                        'text-yellow-600 dark:text-yellow-300': attendence == false,
                                    }">
                                        <svg class="w-4 h-4 mb-2 text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M7.17 3.1C4.57 5.08 3 8.03 3 11v7a3 3 0 0 0 3 3h3v-7H7v-2c0-1.61.79-3.09 2.11-4.03l-1.94-1.87zm9 0C13.57 5.08 12 8.03 12 11v7a3 3 0 0 0 3 3h3v-7h-2v-2c0-1.61.79-3.09 2.11-4.03l-1.94-1.87z" />
                                        </svg>
                                        {{ notes }}
                                    </p>
                                </AlertDialogDescription>
                            </AlertDialogHeader>

                            <AlertDialogFooter>
                                <AlertDialogAction>Close</AlertDialogAction>
                            </AlertDialogFooter>
                        </AlertDialogContent>
                    </AlertDialog>
                </DropdownMenuItem>
                <!-- <DropdownMenuItem :as-child="true">
                    <Link :href="route('events.edit', { event: event.slug })" class="block w-full" prefetch as="button">
                    <PencilIcon class="size-4" />
                    <span>Edit</span>
                    </Link>
                </DropdownMenuItem> -->
                <!-- <DropdownMenuItem :as-child="true">
                    <Link :href="route('rsvps.destroy', { rsvp: id })" @click="confirmDelete()"
                        class="block w-full hover:text-red-500" method="delete" as="button">
                    <Trash2 class="size-4" />
                    <span>Delete</span>
                    </Link>
                </DropdownMenuItem> -->
            </DropdownMenuGroup>
        </DropdownMenuContent>
    </DropdownMenu>
</template>
