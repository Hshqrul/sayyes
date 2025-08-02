<script setup lang="ts">
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { parseDate, type DateValue } from '@internationalized/date'
import CalendarWidget from './dashboard-items/CalendarWidget.vue'
import FormRsvp from './rsvp/FormRsvp.vue'
import AppLayout from '@/layouts/AppLayout.vue'
import { MoveRight } from 'lucide-vue-next'
import Button from '@/components/ui/button/Button.vue'
import Card from '@/components/ui/card/Card.vue'
import CardHeader from '@/components/ui/card/CardHeader.vue'
import CardContent from '@/components/ui/card/CardContent.vue'
import CardFooter from '@/components/ui/card/CardFooter.vue'

// Convert DateValue to JS Date manually
function dateValueToDate(dateValue: DateValue): Date {
    return new Date(dateValue.year, dateValue.month - 1, dateValue.day)
}

const selectedDate = ref<DateValue>(parseDate('2025-12-27'))
const now = ref(new Date())

let interval: number
onMounted(() => {
    interval = setInterval(() => {
        now.value = new Date()
    }, 1000)
})
onUnmounted(() => clearInterval(interval))

const jsSelectedDate = computed(() => dateValueToDate(selectedDate.value))

const countdown = computed(() => {
    const diffMs = jsSelectedDate.value.getTime() - now.value.getTime()
    const totalHours = Math.max(Math.floor(diffMs / (1000 * 60 * 60)), 0)
    const months = Math.floor(totalHours / 24 / 30)
    const days = Math.floor(totalHours / 24)
    const hours = totalHours % 24
    const minutes = Math.floor((diffMs % (1000 * 60 * 60)) / (1000 * 60))
    const seconds = Math.floor((diffMs % (1000 * 60)) / 1000)
    return { months, days, hours, minutes, seconds }
})
</script>


<template>

    <Head title="Dashboard" />
    <AppLayout>
        <div class="grid gap-4 p-4 md:grid-cols-2">
            <!-- Welcome Card -->
            <div
                class="relative min-h-[200px] col-span-1 aspect-video rounded-2xl border border-sidebar-border/70 dark:border-sidebar-border overflow-hidden">
                <div class="flex h-full flex-col justify-center px-6 py-6">
                    <h1 class="text-4xl font-extrabold tracking-tight lg:text-5xl">
                        Hi There!
                    </h1>
                    <p class="mt-2 text-muted-foreground">
                        Welcome to the rsvp page!
                    </p>
                    <div class="mt-4">
                        <Button variant="default" as-child class="w-full sm:w-auto">
                            <a href="#rsvp-form">
                                Fill out your RSVP
                                <MoveRight class="size-4" />
                            </a>
                        </Button>
                    </div>
                </div>
            </div>
            <!-- Date Card -->
            <div>
                <Card
                    class="min-h-[200px] rounded-2xl border border-sidebar-border/70 dark:border-sidebar-border shadow-none">
                    <CardContent>
                        <div
                            class="grid gap-4 sm:grid-cols-1 md:grid-cols-3 justify-items-center items-center text-center">

                            <!-- Calendar -->
                            <div class="flex flex-grow lg:col-span-2">
                                <CalendarWidget v-model="selectedDate" readonly />
                            </div>

                            <!-- Title -->
                            <div class="flex flex-col flex-none lg:text-left">
                                <h1 class="text-xl font-extrabold tracking-tight lg:text-3xl">
                                    Save the Date!
                                </h1>
                                <h2 class="text-md text-muted-foreground font-semibold tracking-tight">
                                    Our Event Date
                                </h2>
                            </div>

                        </div>
                    </CardContent>
                </Card>
            </div>

            <div class="lg:col-span-2">
                <Card class="rounded-2xl border border-sidebar-border/70 dark:border-sidebar-border shadow-none">
                    <div class="flex flex-col items-center justify-center px-4 py-4">
                        <CardContent
                            class="grid gap-4 sm:grid-cols-2 lg:grid-cols-5 justify-items items-center text-center">
                            <div
                                class="flex flex-col items-center lg:col-span-1 flex-none"
                                v-for="(value, label) in countdown"
                                :key="label">
                                <h1 class="text-6xl font-extrabold tracking-tight lg:text-8xl">
                                    {{ value }}
                                </h1>
                                <span class="text-md text-muted-foreground tracking-tight lg:text-lg">{{ label }}</span>
                            </div>
                            <div class="col-span-full">
                                <p class="text-md text-muted-foreground tracking-tight lg:text-lg">until our event</p>
                            </div>
                        </CardContent>
                        <CardFooter></CardFooter>
                    </div>
                </Card>
            </div>

            <!-- RSVP Form Section -->
            <div id="rsvp-form"
                class="relative min-h-[200px] col-span-full rounded-2xl border border-sidebar-border/70 dark:border-sidebar-border overflow-hidden">
                <FormRsvp />
            </div>
        </div>
    </AppLayout>
</template>

<!-- <div>
                <Card class="min-h-[200px] rounded-2xl border border-sidebar-border/70 dark:border-sidebar-border shadow-none">
                    <CardContent class="flex h-full flex-col justify-center px-6 py-6">
                        <h1 class="text-4xl font-extrabold tracking-tight lg:text-5xl">
                            Hi There!
                        </h1>
                        <p class="mt-2 text-muted-foreground">
                            Manage your profile and account settings from here.
                        </p>
                        <div class="mt-4">
                            <Button variant="default" as-child class="w-full sm:w-auto">
                                <a :href="route('login')">
                                    Sign up now!
                                    <ArrowRight class="size-4" />
                                </a>
                            </Button>
                        </div>
                    </CardContent>
                </Card>
            </div> -->

<!-- Spacer for column 3 or any other widget -->
<!-- <div class="relative min-h-[200px] col-span-1 aspect-video rounded-2xl border border-sidebar-border/70 dark:border-sidebar-border overflow-hidden">
                <div class="flex h-full flex-col justify-center px-6 py-6">
                    <h2 class="text-2xl font-semibold">Upcoming Features</h2>
                    <p class="text-muted-foreground">More to come soon!</p>
                </div>
            </div> -->