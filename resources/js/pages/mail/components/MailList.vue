<script lang="ts" setup>
import { ref } from "vue"
import { useMediaQuery } from "@vueuse/core"
// import { Mail } from "../data/mail"
import { router } from '@inertiajs/vue3'
import { formatDistanceToNow } from "date-fns"
import { cn } from "@/lib/utils"
import { Badge } from "@/components/ui/badge"
import { ScrollArea } from "@/components/ui/scroll-area"
import { Button } from "@/components/ui/button"
import MailDisplay from "./MailDisplay.vue"

import {
    Dialog,
    DialogContent,
    DialogHeader,
    DialogTitle,
} from "@/components/ui/dialog"

import {
    Drawer,
    DrawerClose,
    DrawerContent,
    DrawerHeader,
    DrawerTitle,
} from "@/components/ui/drawer"
import DialogFooter from "@/components/ui/dialog/DialogFooter.vue"
import DialogClose from "@/components/ui/dialog/DialogClose.vue"
import { toast } from "vue-sonner"

interface Mail {
    id: string | null
    user: string | null
    subject: string | null
    text: string | null
    read: boolean
    labels: string | null // using text in DB
    created_at: string | null
}

interface MailListProps {
    items: Mail[]
    selectedMail?: string | null
}

const props = defineProps<MailListProps>()
const emit = defineEmits<{
    (e: 'update:selectedMail', value: string | null): void
}>()

const localSelectedMail = ref<string | null>(props.selectedMail || null)

const selectedMail = ref<Mail | null>(null)
const isOpen = ref(false)

// Detect desktop vs mobile
const isDesktop = useMediaQuery("(min-width: 768px)")

function getBadgeVariantFromLabel(label: string) {
    const variants = ["default", "outline", "secondary"]
    const randomIndex = Math.floor(Math.random() * variants.length)
    return variants[randomIndex]
}

function openMail(mail: Mail) {
    selectedMail.value = mail
    localSelectedMail.value = mail.id
    emit('update:selectedMail', mail.id) // notify parent
    isOpen.value = true

    if (!mail.read) {
        mail.read = true

        router.patch(route('note.unread', mail.id), {}, {
            preserveState: true,
            preserveScroll: true,
            onError: (errors) => {
                toast.error(errors.message)
            },
        })
    }
}

function onDeleteMail(id: string | null) {
    if (!id) return

    if (selectedMail.value?.id === id) {
        selectedMail.value = null
        isOpen.value = false
    }

    router.delete(route('note.destroy', id), {
        preserveScroll: true,
        onSuccess: () => {
            selectedMail.value = null;
            isOpen.value = false;
            router.visit(route('mail.index'), {
                only: ['mails'],
            })
            toast.success('Note deleted successfully.');
        },
        onError: () => toast.error('Failed to delete mail'),
    });
}

function onMarkUnread(id: string | null) {
    if (!id) return

    const mail = props.items.find(m => m.id === id)
    if (mail) mail.read = false

    router.patch(route('note.unread', id), {}, {
        preserveScroll: true,
        onSuccess: () => {
            selectedMail.value = null;
            isOpen.value = false;
            toast.success('Note marked as read.',
                {
                    description: 'The note has been marked as read.'
                }
            );
        },
        onError: () => toast.error('Failed to mark unread')
    })
}
</script>

<template>
    <ScrollArea class="h-110 flex">
        <!-- <div v-if="items && items.length > 0" class="flex-1 flex flex-col gap-2 p-4 pt-0"> -->
        <div class="flex-1 flex flex-col gap-2 p-4 pt-0">
            <TransitionGroup name="list" appear>
                <button v-for="item of items" :key="item.id" :class="cn(
                    'flex flex-col items-start gap-2 rounded-lg border p-3 text-left text-sm transition-all hover:bg-accent',
                    selectedMail?.id === item.id && 'bg-muted',
                )" @click="openMail(item)">
                    <div class="flex w-full flex-col gap-1">
                        <div class="flex items-center">
                            <div class="flex items-center gap-2">
                                <div class="font-semibold">{{ item.user.name }}</div>
                                <span v-if="!item.read" class="flex h-2 w-2 rounded-full bg-blue-600" />
                            </div>
                            <div :class="cn(
                                'ml-auto text-xs',
                                selectedMail?.id === item.id
                                    ? 'text-foreground'
                                    : 'text-muted-foreground',
                            )">
                                {{ formatDistanceToNow(new Date(item.created_at), { addSuffix: true }) }}
                            </div>
                        </div>

                        <div class="text-xs font-medium">{{ item.subject }}</div>
                    </div>

                    <div class="line-clamp-2 text-xs text-muted-foreground">
                        {{ item.text.substring(0, 300) }}
                    </div>

                    <div class="flex items-center gap-2">
                        <Badge v-for="label of item.labels" :key="label" :variant="getBadgeVariantFromLabel(label)">
                            {{ label }}
                        </Badge>
                    </div>
                </button>
            </TransitionGroup>
        </div>
        <!-- <div v-else class="flex-1 flex flex-col gap-2 p-4 pt-0">
                <div
                    class="flex flex-col items-start gap-2 rounded-lg border p-3 text-left text-sm transition-all hover:bg-accent">
                    <p class="text-sm text-muted-foreground">
                        No mails found.
                    </p>
                    <p class="text-sm text-muted-foreground">
                        Please create a mail to get started.
                    </p>
                </div>
            </div> -->
    </ScrollArea>

    <Dialog v-if="isDesktop" v-model:open="isOpen">
        <DialogContent v-if="isOpen && selectedMail" class="max-w-7xl">
            <DialogHeader>
                <DialogTitle>{{ selectedMail.subject }}</DialogTitle>
            </DialogHeader>
            <MailDisplay :mail="selectedMail" @markUnread="onMarkUnread" @delete="onDeleteMail" />
            <DialogFooter>
                <DialogClose>
                    <Button variant="secondary">Close</Button>
                </DialogClose>
            </DialogFooter>
        </DialogContent>
    </Dialog>

    <Drawer v-else v-model:open="isOpen">
        <DrawerContent v-if="isOpen && selectedMail" class="max-w-full h-screen">
            <DrawerHeader>
                <DrawerTitle>{{ selectedMail.subject }}</DrawerTitle>
            </DrawerHeader>
            <div class="overflow-y-auto">
                <MailDisplay :mail="selectedMail" @markUnread="onMarkUnread" @delete="onDeleteMail" />
            </div>
            <div class="p-4 flex justify-end">
                <DrawerClose>
                    <Button variant="secondary">Close</Button>
                </DrawerClose>
            </div>
        </DrawerContent>
    </Drawer>
</template>

<style scoped>
.list-move,
.list-enter-active,
.list-leave-active {
    transition: all 0.5s ease;
}

.list-enter-from,
.list-leave-to {
    opacity: 0;
    transform: translateY(15px);
}

.list-leave-active {
    position: absolute;
}
</style>
