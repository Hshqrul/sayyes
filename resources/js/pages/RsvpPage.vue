<script setup lang="ts">
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { parseDate, type DateValue } from '@internationalized/date'
import CalendarWidget from './dashboard-items/CalendarWidget.vue'
import FormRsvp from './rsvp/FormRsvp.vue'
import AppLayout from '@/layouts/GuestLayout.vue'
import { ArrowRight } from 'lucide-vue-next'
import Button from '@/components/ui/button/Button.vue'
import Card from '@/components/ui/card/Card.vue'
import CardContent from '@/components/ui/card/CardContent.vue'
import GuestBook from './rsvp/GuestBook.vue'
import { Head, Link, usePage } from '@inertiajs/vue3'
import GuestBookMarquee from './rsvp/GuestBookMarquee.vue'
import TextLink from '@/components/TextLink.vue'
import NumberTicker from '@/components/ui/number-ticker/NumberTicker.vue'
import { Motion } from 'motion-v'
import CustomLogoIcon from '@/components/CustomLogoIcon.vue'
interface Rsvp {
    name: string
    attendance: boolean
    no_of_pax: number
    notes: string
}

interface Event {
    id: number
    event_name: string
    description: string
    event_date: string
    user_id: string
}

interface User {
    id: string
    name: string
    email: string
}

interface Props {
    rsvps: Rsvp[]
    events: Event
    user: User
}

const page = usePage<Props>()
const rsvps = page.props.rsvps
const event = page.props.event
const user = page.props.user
function dateValueToDate(dateValue: DateValue): Date {
    return new Date(dateValue.year, dateValue.month - 1, dateValue.day)
}

const selectedDate = ref<DateValue>(
    parseDate(
        new Date(event.event_date)
            .toLocaleDateString("en-CA", { timeZone: "Asia/Kuala_Lumpur" })
    )
)

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

    <Head title="Répondez S'il Vous Plaît" />
    <AppLayout>
        <div class="grid gap-4 p-4 md:grid-cols-2">
            <Card
                class="min-h-[200px] rounded-2xl border border-sidebar-border/70 dark:border-sidebar-border shadow-none">
                <CardContent class="flex h-full flex-col justify-center px-6 py-6">
                    <Motion :initial="{ opacity: 0, y: 40, filter: 'blur(10px)' }"
                        :while-in-view="{ opacity: 1, y: 0, filter: 'blur(0px)', }"
                        :transition="{ delay: 0.3, duration: 0.8, ease: 'easeInOut', }">
                        <h1 class="text-4xl font-extrabold tracking-tight lg:text-5xl">
                            Hi There!
                        </h1>
                        <p class="mt-2 text-muted-foreground font-semibold tracking-tight">
                            Please enter your name and let us know if you can attend
                        </p>
                        <div class="mt-4">
                            <Button variant="default" as-child class="w-full sm:w-auto">
                                <a href="#rsvp-form">
                                    Click Here
                                    <ArrowRight class="size-4" />
                                </a>
                            </Button>
                        </div>
                    </Motion>
                </CardContent>
            </Card>
            <Card
                class="min-h-[200px] rounded-2xl border border-sidebar-border/70 dark:border-sidebar-border shadow-none">
                <Motion :initial="{ opacity: 0, y: 40, filter: 'blur(10px)' }"
                    :while-in-view="{ opacity: 1, y: 0, filter: 'blur(0px)', }"
                    :transition="{ delay: 0.3, duration: 0.8, ease: 'easeInOut', }">
                    <CardContent>
                        <div
                            class="grid gap-4 sm:grid-cols-1 md:grid-cols-3 justify-items-center items-center text-center">

                            <div class="flex flex-grow lg:col-span-2">
                                <CalendarWidget v-model="selectedDate" readonly />
                            </div>

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
                </Motion>
            </Card>
            <div class="lg:col-span-2">
                <Card
                    class="relative min-h-[200px] rounded-2xl border border-sidebar-border/70 dark:border-sidebar-border shadow-none overflow-hidden">
                    <CardContent class="flex h-full flex-col justify-center px-6 py-6">
                        <CustomLogoIcon
                            class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 blur-sm opacity-50" />
                        <Motion :initial="{ opacity: 0, y: 40, filter: 'blur(10px)' }"
                            :while-in-view="{ opacity: 1, y: 0, filter: 'blur(0px)', }"
                            :transition="{ delay: 0.3, duration: 0.8, ease: 'easeInOut', }">
                            <h1 class="text-4xl font-extrabold tracking-tight lg:text-5xl">
                                {{ event.event_name }}
                            </h1>
                            <p class="mt-2 text-muted-foreground font-semibold tracking-tight">
                                With heartfelt gratitude and joy, we wish to share this special moment with you. It
                                would be our greatest honor if you could kindly respond to our invitation, so that we
                                may reserve your seat accordingly.
                            </p>
                        </Motion>
                    </CardContent>
                </Card>
            </div>
            <div class="lg:col-span-2">
                <Card class="rounded-2xl border border-sidebar-border/70 dark:border-sidebar-border shadow-none">
                    <div class="flex flex-col items-center justify-center px-4 py-4">
                        <CardContent
                            class="grid gap-4 sm:grid-cols-2 lg:grid-cols-5 justify-items items-center text-center">
                            <div class="flex flex-col items-center lg:col-span-1 flex-none"
                                v-for="(value, label) in countdown" :key="label">
                                <h1 class="text-6xl font-extrabold tracking-tight lg:text-8xl">
                                    <NumberTicker :value="value" :decimal-places="0" :duration="3000" />
                                </h1>
                                <span class="text-md text-muted-foreground tracking-tight lg:text-lg">{{ label }}</span>
                            </div>
                            <div class="col-span-full">
                                <p class="text-md text-muted-foreground tracking-tight lg:text-lg">until our event</p>
                            </div>
                        </CardContent>
                    </div>
                </Card>
            </div>

            <div id="rsvp-form"
                class="pt-6 col-span-full rounded-2xl border border-sidebar-border/70 dark:border-sidebar-border overflow-hidden">
                <FormRsvp />
            </div>

            <div id="guestbook"
                class="relative min-h-[200px] col-span-full rounded-2xl border border-sidebar-border/70 dark:border-sidebar-border overflow-hidden">
                <!-- <GuestBook :rsvps="rsvps" :event="event" /> -->
                <GuestBookMarquee :rsvps="rsvps" :event="event" />
            </div>
        </div>
    </AppLayout>
    <footer
        class="bottom-0 w-full text-sm mx-auto flex items-center justify-between sm:px-16 py-6 md:flex-row flex flex-col gap-2 md:gap-0">
        <div class="flex items-center gap-2 ">
            <div class="flex items-center gap-1">
                <span>
                    &copy; {{ new Date().getFullYear() }} <TextLink :href="route('dashboard')" class="font-semibold">{{
                        page.props.name }}</TextLink>
                </span>
            </div>
            <span> · </span>
            <div class="flex items-center gap-1">
                <span class="rounded-sm italic">
                    Built with
                    <svg class="inline-block h-4 w-4 text-red-500" fill="currentColor" viewBox="0 0 24 24"
                        aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"
                            clip-rule="evenodd" />
                    </svg>
                    by
                    <a class="underline decoration-neutral-300 underline-offset-4 transition-colors duration-300 ease-out hover:decoration-current! dark:decoration-neutral-500 underline-offset-4"
                        target="_blank" href="https://buymeacoffee.com/hashaqirul">Hashaqirul.</a>
                </span>
            </div>
        </div>
    </footer>
</template>