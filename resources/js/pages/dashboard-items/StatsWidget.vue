<script setup lang="ts">
import {
    Card,
    CardContent,
    CardHeader,
    CardTitle,
} from '@/components/ui/card'
import {
    BadgeCheckIcon,
    MoonIcon,
    Users2Icon
} from 'lucide-vue-next'
import { ref, onMounted } from 'vue'
import Skeleton from '@/components/ui/skeleton/Skeleton.vue'
import Badge from '@/components/ui/badge/Badge.vue';
import { Link } from '@inertiajs/vue3';

defineProps<{
    eventStats: Array<{
        event_name: string
        event_slug: string
        attend: number
        absent: number
        total: number
    }>
}>()

const loading = ref(true)

onMounted(() => {
    setTimeout(() => {
        loading.value = false
    }, 1000)
})
</script>

<template>
    <div class="space-y-6">
        <template v-if="loading">
            <div class="flex flex-col">
                <div class="flex flex-row justify-end pb-2">
                    <Badge>
                        <Skeleton class="w-16 h-4 rounded" />
                    </Badge>
                </div>
                <div v-for="n in 1" :key="n" class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                    <Card class="shadow-none">
                        <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                            <Skeleton class="w-[80px] h-4 rounded-full" />
                            <Skeleton class="w-4 h-4 rounded-full" />
                        </CardHeader>
                        <CardContent>
                            <Skeleton class="w-16 h-8 rounded" />
                            <Skeleton class="w-3/4 h-3 mt-1 rounded" />
                        </CardContent>
                    </Card>

                    <Card class="shadow-none">
                        <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                            <Skeleton class="w-[80px] h-4 rounded-full" />
                            <Skeleton class="w-4 h-4 rounded-full" />
                        </CardHeader>
                        <CardContent>
                            <Skeleton class="w-16 h-8 rounded" />
                            <Skeleton class="w-3/4 h-3 mt-1 rounded" />
                        </CardContent>
                    </Card>

                    <Card class="shadow-none">
                        <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                            <Skeleton class="w-[100px] h-4 rounded-full" />
                            <Skeleton class="w-4 h-4 rounded-full" />
                        </CardHeader>
                        <CardContent>
                            <Skeleton class="w-16 h-8 rounded" />
                            <Skeleton class="w-3/4 h-3 mt-1 rounded" />
                        </CardContent>
                    </Card>
                </div>
            </div>
        </template>

        <template v-else>
            <!-- <div class="flex flex-col"> -->

            <div v-for="(event, index) in eventStats" :key="index" class="flex flex-col">
                <div class="flex flex-row justify-end p-2 pt-0">
                    <Link :href="route('event_rsvp', { event: event.event_slug })">
                    <Badge>
                        {{ eventStats[index].event_name }}
                    </Badge>
                    </Link>
                </div>
                <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                    <Card class="shadow-none">
                        <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                            <CardTitle class="text-sm font-medium">Attend</CardTitle>
                            <BadgeCheckIcon class="h-4 w-4 text-green-500/60" />
                        </CardHeader>
                        <CardContent>
                            <div class="text-3xl font-bold">{{ event.attend }}</div>
                            <p class="text-xs text-muted-foreground">Total of attendees</p>
                        </CardContent>
                    </Card>

                    <Card class="shadow-none">
                        <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                            <CardTitle class="text-sm font-medium">Absent</CardTitle>
                            <MoonIcon class="h-4 w-4 text-yellow-500/60" />
                        </CardHeader>
                        <CardContent>
                            <div class="text-3xl font-bold">{{ event.absent }}</div>
                            <p class="text-xs text-muted-foreground">Total of absentees</p>
                        </CardContent>
                    </Card>

                    <Card class="shadow-none">
                        <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                            <CardTitle class="text-sm font-medium">Total Guest</CardTitle>
                            <Users2Icon class="h-4 w-4 text-indigo-500/60" />
                        </CardHeader>
                        <CardContent>
                            <div class="text-3xl font-bold">{{ event.total }}</div>
                            <p class="text-xs text-muted-foreground">Sum of guests</p>
                        </CardContent>
                    </Card>
                </div>
            </div>
            <!-- </div> -->
        </template>
    </div>
</template>