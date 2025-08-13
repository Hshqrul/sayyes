<script lang="ts" setup>
import { Mail } from '../data/mail'
import { formatDistanceToNow } from 'date-fns'
import { cn } from '@/lib/utils'
import { Badge } from '@/components/ui/badge'
import { ScrollArea } from '@/components/ui/scroll-area'
import { Drawer, DrawerClose, DrawerContent, DrawerHeader, DrawerTitle, DrawerTrigger } from '@/components/ui/drawer'
import { Button } from '@/components/ui/button'
import MailDisplay from './MailDisplay.vue'
import { ref } from 'vue'
import TooltipProvider from '@/components/ui/tooltip/TooltipProvider.vue'

interface MailListProps {
    items: Mail[]
}

defineProps<MailListProps>()

const selectedMail = ref<Mail | null>(null)

function getBadgeVariantFromLabel(label: string) {
    if (['work'].includes(label.toLowerCase())) return 'default'
    if (['personal'].includes(label.toLowerCase())) return 'outline'
    return 'secondary'
}
</script>

<template>
    <ScrollArea class="h-screen flex">
        <div class="flex-1 flex flex-col gap-2 p-4 pt-0">
            <TransitionGroup name="list" appear>
                <Drawer v-for="item in items" :key="item.id">
                    <DrawerTrigger as-child>
                        <button :class="cn(
                            'flex flex-col items-start gap-2 rounded-lg border p-3 text-left text-sm transition-all hover:bg-accent w-full',
                            selectedMail?.id === item.id && 'bg-muted',
                        )" @click="selectedMail = item">
                            <div class="flex w-full flex-col gap-1">
                                <div class="flex items-center">
                                    <div class="flex items-center gap-2">
                                        <div class="font-semibold">{{ item.name }}</div>
                                        <span v-if="!item.read" class="flex h-2 w-2 rounded-full bg-blue-600" />
                                    </div>
                                    <div :class="cn(
                                        'ml-auto text-xs',
                                        selectedMail?.id === item.id ? 'text-foreground' : 'text-muted-foreground'
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
                                <Badge v-for="label of item.labels" :key="label"
                                    :variant="getBadgeVariantFromLabel(label)">
                                    {{ label }}
                                </Badge>
                            </div>
                        </button>
                    </DrawerTrigger>

                    <DrawerContent class="max-w-3xl mx-auto">
                        <DrawerHeader>
                            <DrawerTitle>{{ selectedMail?.subject }}</DrawerTitle>
                        </DrawerHeader>

                        <!-- Your full mail display here -->
                        <TooltipProvider :delay-duration="0">
                            <div class="overflow-y-scroll">
                                <MailDisplay :mail="selectedMail" />
                            </div>
                        </TooltipProvider>

                        <div class="p-4 flex justify-end">
                            <DrawerClose>
                                <Button variant="outline">Close</Button>
                            </DrawerClose>
                        </div>
                    </DrawerContent>
                </Drawer>
            </TransitionGroup>
        </div>
    </ScrollArea>
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
