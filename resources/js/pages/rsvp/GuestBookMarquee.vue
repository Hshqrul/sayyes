<template>
    <div class="flex w-full max-w-7xl flex-col items-center justify-center p-4">
        <div class="flex flex-col gap-4 py-12 text-center">
            <div class="text-3xl font-semibold sm:text-4xl">Guests Book</div>
            <div class="text-lg font-light sm:text-xl">
                All wishes for bride & groom
                <span class="text-xl">
                    ❤️
                </span>
            </div>
        </div>
        <div class="relative flex w-full flex-col items-center justify-center overflow-hidden">
            <!-- First Marquee -->
             <!-- @todo dynamic duration -->
            <Marquee pause-on-hover class="[--duration:20s]"> 
                <WishesCard v-for="(rsvp, index) in rsvps" :key="index" :name="rsvp.name"
                    :body="rsvp.notes || `No message left`"
                    :attendence="rsvp.attendence" :created_at="rsvp.created_at" />
            </Marquee>

            <!-- Second Marquee (reverse) -->
            <Marquee reverse pause-on-hover class="[--duration:20s]">
                <WishesCard v-for="(rsvp, index) in rsvps" :key="index" :name="rsvp.name"
                    :body="rsvp.notes || `No message left`"
                    :attendence="rsvp.attendence" :created_at="rsvp.created_at" />
            </Marquee>

            <!-- Left Gradient -->
            <div
                class="pointer-events-none absolute inset-y-0 left-0 w-1/3 bg-gradient-to-r from-white dark:from-background">
            </div>

            <!-- Right Gradient -->
            <div
                class="pointer-events-none absolute inset-y-0 right-0 w-1/3 bg-gradient-to-l from-white dark:from-background">
            </div>
        </div>
        <!-- <div class="relative h-[430px] w-full overflow-hidden rounded-xl border bg-white dark:bg-background">
            <div class="absolute inset-0 overflow-hidden">
                <Marquee :style="{ transform: 'translateY(-11.5rem) rotate(-16deg)' }" class="marquee"
                    :pauseOnHover="true">
                    <WishesCard v-for="(rsvp, index) in rsvps" :key="index" :name="rsvp.name"
                        :body="rsvp.notes || `No message left`"
                        :attendence="rsvp.attendence ? '✅ Attending' : '❌ Not Attending'"
                        :created_at="rsvp.created_at" />
                </Marquee>

                <Marquee :style="{ transform: 'translateY(1rem) rotate(-16deg)' }" reverse class="marquee"
                    :pauseOnHover="true">
                    <WishesCard v-for="(rsvp, index) in rsvps" :key="index" :name="rsvp.name"
                        :body="rsvp.notes || `No message left`"
                        :attendence="rsvp.attendence ? '✅ Attending' : '❌ Not Attending'"
                        :created_at="rsvp.created_at" />
                </Marquee>

                <Marquee :style="{ transform: 'translateY(13.5rem) rotate(-16deg)' }" class="marquee"
                    :pauseOnHover="true">
                    <WishesCard v-for="(rsvp, index) in rsvps" :key="index" :name="rsvp.name"
                        :body="rsvp.notes || `No message left`"
                        :attendence="rsvp.attendence ? '✅ Attending' : '❌ Not Attending'"
                        :created_at="rsvp.created_at" />
                </Marquee>

                <Marquee :style="{ transform: 'translateY(26rem) rotate(-16deg)' }" reverse class="marquee"
                    :pauseOnHover="true">
                    <WishesCard v-for="(rsvp, index) in rsvps" :key="index" :name="rsvp.name"
                        :body="rsvp.notes || `No message left`"
                        :attendence="rsvp.attendence ? '✅ Attending' : '❌ Not Attending'"
                        :created_at="rsvp.created_at" />
                </Marquee>
            </div>

            <div class="absolute inset-0 bg-gradient-to-t from-white to-transparent dark:from-background">
            </div>
        </div> -->
    </div>
</template>

<script setup lang="ts">
import Marquee from '@/components/ui/marquee/Marquee.vue';
import ReviewCard from '@/components/ui/marquee/ReviewCard.vue';
import WishesCard from '@/components/ui/marquee/WishesCard.vue';
import { usePage } from '@inertiajs/vue3';
import { useColorMode } from '@vueuse/core';
import { computed, ref } from 'vue';

// const isDark = computed(() => useColorMode().value == "dark");

// Reviews data
const reviews = [
    {
        name: "kiri",
        username: "@kiruba_selvi6",
        body: "Oooohhh wowww...!!",
        img: "https://cdn.inspira-ui.com/images/x-logo.svg",
    },
    {
        name: "Sébastien Chopin",
        username: "@Atinux",
        body: "You ship 🚢",
        img: "https://cdn.inspira-ui.com/images/x-logo.svg",
    },
    {
        name: "Mattia Guariglia",
        username: "@matt_guariglia",
        body: "Omg 🥰",
        img: "https://cdn.inspira-ui.com/images/x-logo.svg",
    },
    {
        name: "Nelson🐐",
        username: "@Mathiasokafor3",
        body: "Thank you so much for all you do for the Vue/nuxt eco system.",
        img: "https://cdn.inspira-ui.com/images/x-logo.svg",
    },
    {
        name: "Premdas Vm",
        username: "@premdasvm",
        body: "Man, this is soo good! I've been jealous of React because their eco-system had Magic UI and other ones like this. Inspira UI is 🔥🙌🏼",
        img: "https://cdn.inspira-ui.com/images/x-logo.svg",
    },
    {
        name: "Pierre",
        username: "@PierreHenryBap",
        body: "It looks really awesome! Just noticed it a couple of days ago and I can’t wait to try it out.",
        img: "https://cdn.inspira-ui.com/images/x-logo.svg",
    },
    {
        name: "Waldemar Enns",
        username: "@WaldemarEnns",
        body: "Awesome! ⭐️ed it immediately",
        img: "https://cdn.inspira-ui.com/images/x-logo.svg",
    },
];

// Rows
const firstRow = ref(reviews);

const page = usePage()

const props = defineProps<{
    event: {
        event_name: string
        description?: string
    }
    rsvps: {
        id: string
        name: string
        attendence: boolean
        no_of_pax?: number
        notes: string
        created_at: string
    }[]
}>()

console.log('rsvps', props.rsvps)
console.log('event', props.event)
</script>

<style scoped>
.marquee {
    --duration: 500s;
    /* position: absolute;
    left: -10%;
    width: 120%;
    padding: 0.5rem 0; */
}

/* .marquee:hover,
.marquee:focus {
    animation-play-state: paused !important;
} */
</style>