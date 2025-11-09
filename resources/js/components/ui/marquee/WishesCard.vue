<template>
    <figure
        class="relative flex h-full w-68 md:w-80 cursor-pointer flex-col overflow-hidden rounded-xl border p-4 
         border-gray-950/[.1] bg-gray-950/[.01] hover:bg-gray-950/[.05] 
         dark:border-gray-50/[.1] dark:bg-gray-50/[.10] dark:hover:bg-gray-50/[.15] hover:scale-105 transition-all select-none">
        <div class="flex items-center gap-2">
            <Avatar>
                <AvatarFallback class="text-sm font-semibold bg-primary text-primary-foreground">
                    {{ getInitials(name) }}
                </AvatarFallback>
            </Avatar>

            <div class="flex flex-1 items-center justify-between">
                <span class="text-sm font-medium">
                    {{ name }}
                </span>
                <Badge v-if="attendence" variant="default" class="text-xs">Attend</Badge>
                <Badge v-else variant="secondary" class="text-xs">Absent</Badge>
            </div>
        </div>

        <blockquote class="mt-2 text-sm italic">
            <svg class="w-4 h-4 mb-2 text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                <path
                    d="M7.17 3.1C4.57 5.08 3 8.03 3 11v7a3 3 0 0 0 3 3h3v-7H7v-2c0-1.61.79-3.09 2.11-4.03l-1.94-1.87zm9 0C13.57 5.08 12 8.03 12 11v7a3 3 0 0 0 3 3h3v-7h-2v-2c0-1.61.79-3.09 2.11-4.03l-1.94-1.87z" />
            </svg>
            {{ body }}
        </blockquote>

        <div class="mt-auto flex justify-between pt-2">
            <label v-if="no_of_pax > 1" class="text-xs font-medium text-gray-500 dark:text-white/40">
                Single
            </label>
            <label v-else class="text-xs font-medium text-gray-500 dark:text-white/40">With Partner</label>
            <p class="text-xs font-medium text-gray-500 dark:text-white/40">
                {{
                    new Intl.DateTimeFormat("en-US", {
                        year: "numeric",
                        month: "short",
                        day: "2-digit",
                        hour: "2-digit",
                        minute: "2-digit",
                    }).format(new Date(created_at))
                }}
            </p>
        </div>
    </figure>
</template>
<!-- <Card>
            <CardHeader class="flex flex-row items-center justify-between">
                <div class="flex flex-row items-center gap-2">
                    <Avatar>
                        <AvatarFallback class="text-xs">{{ getInitials(name) }}</AvatarFallback>
                    </Avatar>
                    <div class="flex flex-col">
                        <span class="text-sm font-medium">
                            {{ name }}
                        </span>
                        <p class="text-xs font-medium dark:text-white/40">
                            {{ new Intl.DateTimeFormat('en-US', {
                                year: 'numeric', month: 'short', day:
                                    '2-digit', hour: '2-digit', minute: '2-digit'
                            }).format(new
                                Date(created_at)) }}
                        </p>
                    </div>
                </div>
            </CardHeader>
            <CardContent class="mt-2">
                <blockquote class="mt-2 text-sm italic">
                    {{ body }}
                </blockquote>
            </CardContent>
            <CardFooter>
                <Badge v-if="attendence" variant="default">Attending</Badge>
                <Badge v-else variant="secondary">Absent</Badge>
            </CardFooter>
        </Card> -->
<script lang="ts" setup>
import Avatar from '../avatar/Avatar.vue';
import AvatarFallback from '../avatar/AvatarFallback.vue';
import { getInitials } from '@/composables/useInitials';
import Badge from '../badge/Badge.vue';

interface Props {
    name: string
    body: string
    attendence: boolean
    no_of_pax: number
    created_at: string
}

defineProps<Props>()
</script>
