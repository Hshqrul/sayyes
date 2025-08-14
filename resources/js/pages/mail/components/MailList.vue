<script lang="ts" setup>
import { ref } from 'vue'
import { Mail } from '../data/mail'
import { formatDistanceToNow } from 'date-fns'
import { cn } from '@/lib/utils'
import { Badge } from '@/components/ui/badge'
import { ScrollArea } from '@/components/ui/scroll-area'
import { Drawer, DrawerClose, DrawerContent, DrawerHeader, DrawerTitle, DrawerTrigger } from '@/components/ui/drawer'
import { Button } from '@/components/ui/button'
import MailDisplay from './MailDisplay.vue'

interface MailListProps {
    items: Mail[]
}

defineProps<MailListProps>()

const selectedMail = ref<Mail | null>(null)
const drawerOpen = ref(false)

function getBadgeVariantFromLabel(label: string) {
    if (['work'].includes(label.toLowerCase())) return 'default'
    if (['personal'].includes(label.toLowerCase())) return 'outline'
    return 'secondary'
}

function openMail(mail: Mail) {
    selectedMail.value = mail
    drawerOpen.value = true
}
</script>

<template>
    <Drawer v-model:open="drawerOpen">
        <ScrollArea class="h-screen flex">
            <div class="flex-1 flex flex-col gap-2 p-4 pt-0">
                <TransitionGroup name="list" appear>
                    <button v-for="item of items" :key="item.id" :class="cn(
                        'flex flex-col items-start gap-2 rounded-lg border p-3 text-left text-sm transition-all hover:bg-accent',
                        selectedMail?.id === item.id && 'bg-muted',
                    )" @click="openMail(item)">
                        <div class="flex w-full flex-col gap-1">
                            <div class="flex items-center">
                                <div class="flex items-center gap-2">
                                    <div class="font-semibold">{{ item.name }}</div>
                                    <span v-if="!item.read" class="flex h-2 w-2 rounded-full bg-blue-600" />
                                </div>
                                <div :class="cn(
                                    'ml-auto text-xs',
                                    selectedMail?.id === item.id
                                        ? 'text-foreground'
                                        : 'text-muted-foreground',
                                )">
                                    {{ formatDistanceToNow(new Date(item.date), { addSuffix: true }) }}
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
        </ScrollArea>

        <DrawerContent class="max-w-full mx-auto">
            <DrawerHeader>
                <DrawerTitle>{{ selectedMail?.subject }}</DrawerTitle>
            </DrawerHeader>

            <div class="overflow-y-auto">
                <MailDisplay :mail="selectedMail" />
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
