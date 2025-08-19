<script setup lang="ts">
import {
    Sheet,
    SheetContent,
    SheetDescription,
    SheetHeader,
    SheetTitle,
    SheetTrigger,
} from '@/components/ui/sheet'
import Button from '@/components/ui/button/Button.vue'
import { UsersIcon } from '@heroicons/vue/24/outline'
import { computed } from 'vue'
import {
    Tabs,
    TabsContent,
    TabsList,
    TabsTrigger,
} from "@/components/ui/tabs"
import ScrollArea from '@/components/ui/scroll-area/ScrollArea.vue'
import Avatar from '@/components/ui/avatar/Avatar.vue'
import AvatarFallback from '@/components/ui/avatar/AvatarFallback.vue'
import { BadgeCheckIcon, BadgeXIcon } from 'lucide-vue-next'

interface Rsvp {
    id: number
    name: string
    attendence: boolean
    created_at: string
}

const props = defineProps<{
    rsvps: Rsvp[]
}>()

const attendList = computed(() => props.rsvps.filter(r => r.attendence))
const absentList = computed(() => props.rsvps.filter(r => !r.attendence))

function getInitials(name: string): string {
    return name
        .split(' ')
        .map(n => n[0])
        .join('')
        .toUpperCase()
}
</script>

<template>
    <Sheet>
        <SheetTrigger class="flex items-center gap-2">
            <Button variant="ghost" size="icon">
                <UsersIcon class="w-4 h-4" />
            </Button>
        </SheetTrigger>

        <SheetContent>
            <SheetHeader>
                <SheetTitle>Participants List</SheetTitle>
                <SheetDescription>
                    {{ props.rsvps.length }} person has been respond for this event
                </SheetDescription>
            </SheetHeader>

            <Tabs default-value="attend" class="w-auto p-4">
                <TabsList class="grid w-full grid-cols-2">
                    <TabsTrigger value="attend">
                        Attend
                    </TabsTrigger>
                    <TabsTrigger value="absent">
                        Absent
                    </TabsTrigger>
                </TabsList>

                <TabsContent value="attend" class="border border-sidebar-border rounded-lg">
                    <ScrollArea class="h-screen flex">
                        <div class="grid gap-6 p-2">
                            <div v-for="rsvp in attendList" :key="rsvp.id" class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <Avatar>
                                        <AvatarFallback>{{ getInitials(rsvp.name) }}</AvatarFallback>
                                    </Avatar>
                                    <div class="space-y-1">
                                        <p class="text-xs font-medium leading-none">
                                            {{ rsvp.name }}
                                        </p>
                                        <p class="text-xs text-muted-foreground">
                                            {{ new Intl.DateTimeFormat('en-US', {
                                                year: 'numeric', month: 'short', day:
                                                    '2-digit', hour: '2-digit', minute: '2-digit'
                                            }).format(new
                                                Date(rsvp.created_at)) }}
                                        </p>
                                    </div>
                                </div>
                                <BadgeCheckIcon class="size-4 text-green-600" />
                            </div>
                        </div>
                    </ScrollArea>
                </TabsContent>

                <TabsContent value="absent" class="border border-sidebar-border rounded-lg">
                    <ScrollArea class="h-screen flex">
                        <div class="grid gap-6 p-2">
                            <div v-for="rsvp in absentList" :key="rsvp.id" class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <Avatar>
                                        <AvatarFallback>{{ getInitials(rsvp.name) }}</AvatarFallback>
                                    </Avatar>
                                    <div class="space-y-1">
                                        <p class="text-xs font-medium leading-none">
                                            {{ rsvp.name }}
                                        </p>
                                        <p class="text-xs text-muted-foreground">
                                            {{ new Intl.DateTimeFormat('en-US', {
                                                year: 'numeric', month: 'short', day:
                                                    '2-digit', hour: '2-digit', minute: '2-digit'
                                            }).format(new
                                                Date(rsvp.created_at)) }}
                                        </p>
                                    </div>
                                </div>
                                <BadgeXIcon class="size-4 text-red-600" />
                            </div>
                        </div>
                    </ScrollArea>
                </TabsContent>
            </Tabs>
        </SheetContent>
    </Sheet>
</template>
