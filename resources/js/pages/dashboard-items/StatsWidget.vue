<script setup lang="ts">
import {
    Card,
    CardContent,
    CardHeader,
    CardTitle,
} from '@/components/ui/card'
import { BadgeCheckIcon, MoonIcon, Users2Icon } from 'lucide-vue-next'

defineProps<{
    attendCount: number
    absentCount: number
    totalGuests: number
}>()
</script>

<template>
    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
        <Card class="shadow-none">
            <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                <CardTitle class="text-sm font-medium">Attend</CardTitle>
                <BadgeCheckIcon class="h-4 w-4 text-green-500/60" />
            </CardHeader>
            <CardContent>
                <div class="text-3xl font-bold">
                    {{ attendCount }}
                </div>
                <p class="text-xs text-muted-foreground">
                    Total of attendees
                </p>
            </CardContent>
        </Card>

        <Card class="shadow-none">
            <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                <CardTitle class="text-sm font-medium">Absent</CardTitle>
                <MoonIcon class="h-4 w-4 text-yellow-500/60" />
            </CardHeader>
            <CardContent>
                <div class="text-3xl font-bold">
                    {{ absentCount }}
                </div>
                <p class="text-xs text-muted-foreground">
                    Total of absentees
                </p>
            </CardContent>
        </Card>

        <Card class="shadow-none">
            <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                <CardTitle class="text-sm font-medium">Total Guest</CardTitle>
                <Users2Icon class="h-4 w-4 text-indigo-500/60" />
            </CardHeader>
            <CardContent>
                <div class="text-3xl font-bold">
                    {{ totalGuests }}
                </div>
                <p class="text-xs text-muted-foreground">
                    Sum of guests
                </p>
            </CardContent>
        </Card>
    </div>
</template>
