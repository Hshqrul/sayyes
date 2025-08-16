<script lang="ts" setup>
import { format } from 'date-fns'
import { MailOpen, Trash2 } from 'lucide-vue-next'
import { computed } from 'vue'
import { Avatar, AvatarFallback } from '@/components/ui/avatar'
import { Button } from '@/components/ui/button'
import { Separator } from '@/components/ui/separator'
import { Tooltip, TooltipContent, TooltipTrigger } from '@/components/ui/tooltip'
import { toast } from 'vue-sonner'
import DeleteConfirmDialog from '@/components/DeleteConfirmDialog.vue'

interface MailUser {
    name: string
    email: string
}

interface Mail {
    id: string | null
    user: MailUser | null
    subject: string | null
    text: string | null
    read: boolean
    labels: string[] | null
    created_at: string | null
}

interface MailDisplayProps {
    mail: Mail | null
}

const props = defineProps<MailDisplayProps>()

const emit = defineEmits<{
    (e: 'delete', id: string | null): void
    (e: 'markUnread', id: string | null): void
}>()

const mailFallbackName = computed(() => {
    return props.mail?.user?.name
        ?.split(' ')
        .map(chunk => chunk[0])
        .join('') || ''
})

function markAsUnread() {
    if (!props.mail?.id) return
    emit('markUnread', props.mail.id)
}

function deleteMail() {
    if (!props.mail?.id) return
    // if (confirm('Are you sure you want to delete this email?')) {
    emit('delete', props.mail.id)
    // }
}

function handleDelete() {
    // Call API or action to delete
    console.log('User deleted!')
}
</script>

<template>
    <div class="flex h-full flex-col">
        <div class="flex items-center p-2">
            <div class="ml-auto flex items-center gap-2">
                <Tooltip>
                    <TooltipTrigger as-child>
                        <Button variant="ghost" size="icon" :disabled="!mail" @click="markAsUnread">
                            <MailOpen class="size-4" />
                            <span class="sr-only">Mark as unread</span>
                        </Button>
                    </TooltipTrigger>
                    <TooltipContent>Mark as unread</TooltipContent>
                </Tooltip>
                <Tooltip>
                    <TooltipTrigger>
                        <!-- <Button variant="ghost" size="icon" :disabled="!mail" @click="deleteMail">
                            <Trash2 class="size-4" />
                            <span class="sr-only">Move to trash</span>
                        </Button> -->
                        <DeleteConfirmDialog :itemName="mail?.subject" @confirm="deleteMail">
                            <template #trigger>
                                <Button variant="ghost" size="icon" :disabled="!mail">
                                    <Trash2 class="size-4" />
                                    <span class="sr-only">Move to trash</span>
                                </Button>
                            </template>
                        </DeleteConfirmDialog>
                    </TooltipTrigger>
                    <TooltipContent>Move to trash</TooltipContent>
                </Tooltip>
            </div>
        </div>
        <Separator />

        <!-- Only render mail if available -->
        <div v-if="mail" class="flex flex-1 flex-col">
            <div class="flex items-start p-4">
                <div class="flex items-start gap-4 text-sm">
                    <Avatar>
                        <AvatarFallback>{{ mailFallbackName }}</AvatarFallback>
                    </Avatar>
                    <div class="grid gap-1">
                        <div class="font-semibold">{{ mail.user?.name }}</div>
                        <div class="line-clamp-1 text-xs">{{ mail.subject }}</div>
                        <div class="line-clamp-1 text-xs">
                            <span class="font-medium">From:</span> {{ mail.user?.email }}
                        </div>
                    </div>
                </div>
                <div v-if="mail.created_at" class="ml-auto text-xs text-muted-foreground">
                    {{ format(new Date(mail.created_at), "PPpp") }}
                </div>
            </div>
            <Separator />
            <div class="flex-1 whitespace-pre-wrap p-4 text-sm">
                {{ mail.text }}
            </div>
            <Separator class="mt-auto" />
        </div>

        <!-- Empty state -->
        <div v-else class="p-8 text-center text-muted-foreground">
            No message selected
        </div>
    </div>
</template>
