<template>
    <div class="flex w-full max-w-7xl flex-col items-center justify-center p-4">
        <!-- <div class="py-12 text-3xl font-semibold sm:text-4xl">
            Loved by community <span class="text-4xl"> ❤️</span>
        </div> -->
        <div class="flex flex-col gap-4 py-12 text-center">
            <div class="text-4xl font-extrabold tracking-tight lg:text-5xl">Guests Book</div>
            <div class="text-muted-foreground font-semibold tracking-tight">
                All wishes for bride & groom
                <span class="text-lg">
                    ❤️
                </span>
            </div>
        </div>
        <div class="relative h-[430px] w-full overflow-hidden rounded-xl border bg-white shadow-xs dark:bg-background">


            <!-- Center Text -->
            <div class="absolute inset-0 z-10 mt-20 flex flex-col items-center justify-center px-4 text-center">
                <!-- Logo -->
                <div
                    class="absolute left-1/2 top-8 z-20 my-4 -translate-x-1/2 rounded-3xl border bg-white/30 p-3 backdrop-blur-md">
                    <CustomLogoIcon class="size-10 fill-current text-[var(--foreground)] dark:text-white" />
                    <h3 class="mb-2 text-2xl font-bold sm:text-3xl">What are you waiting for?</h3>
                    <p class="m-4 text-base sm:text-lg">Get started and share your wishes 😄</p>
                </div>
                <!-- <NuxtLink to="getting-started/installation"> -->
                <!-- <UiButton variant="default"> Get Started → </UiButton> -->
                <!-- </NuxtLink> -->
            </div>

            <!-- Tilted Marquees -->
            <div class="absolute inset-0 overflow-hidden gap-5">

                <Marquee pause-on-hover pause-on-click
                    :style="{ '--duration': `${dur}s`, transform: 'translateY(-11.5rem) rotate(-16deg)' }"
                    class="marquee">
                    <WishesCard v-for="(rsvp, index) in rsvps" :key="index" :name="rsvp.name"
                        :body="rsvp.notes || `No message left`" :attendence="rsvp.attendence"
                        :created_at="rsvp.created_at" />
                </Marquee>

                <Marquee pause-on-hover pause-on-click reverse
                    :style="{ '--duration': `${dur}s`, transform: 'translateY(5rem) rotate(-16deg)' }" class="marquee">
                    <WishesCard v-for="(rsvp, index) in rsvps" :key="index" :name="rsvp.name"
                        :body="rsvp.notes || `No message left`" :attendence="rsvp.attendence"
                        :created_at="rsvp.created_at" />
                </Marquee>

                <Marquee pause-on-hover pause-on-click
                    :style="{ '--duration': `${dur}s`, transform: 'translateY(21.5rem) rotate(-16deg)' }"
                    class="marquee">
                    <WishesCard v-for="(rsvp, index) in rsvps" :key="index" :name="rsvp.name"
                        :body="rsvp.notes || `No message left`" :attendence="rsvp.attendence"
                        :created_at="rsvp.created_at" />
                </Marquee>
            </div>

            <!-- Gradient overlay to fade to white at the bottom -->
            <div
                class="pointer-events-none absolute inset-0 bg-gradient-to-t from-white to-transparent dark:from-background">
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import CustomLogoIcon from '@/components/CustomLogoIcon.vue';
import Marquee from '@/components/ui/marquee/Marquee.vue';
import ReviewCard from '@/components/ui/marquee/ReviewCard.vue';
import WishesCard from '@/components/ui/marquee/WishesCard.vue';
import { useColorMode } from '@vueuse/core';
import { computed, ref } from 'vue';

const isDark = computed(() => useColorMode().value == "dark");

const props = defineProps<{
    event: {
        event_name: string
        description?: string
        marquee_duration?: number
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

// Reviews data
// const reviews = [
//     {
//         name: "kiri",
//         username: "@kiruba_selvi6",
//         body: "Oooohhh wowww...!!",
//         img: "https://cdn.inspira-ui.com/images/x-logo.svg",
//     },
//     {
//         name: "Sébastien Chopin",
//         username: "@Atinux",
//         body: "You ship 🚢",
//         img: "https://cdn.inspira-ui.com/images/x-logo.svg",
//     },
//     {
//         name: "Mattia Guariglia",
//         username: "@matt_guariglia",
//         body: "Omg 🥰",
//         img: "https://cdn.inspira-ui.com/images/x-logo.svg",
//     },
//     {
//         name: "Nelson🐐",
//         username: "@Mathiasokafor3",
//         body: "Thank you so much for all you do for the Vue/nuxt eco system.",
//         img: "https://cdn.inspira-ui.com/images/x-logo.svg",
//     },
//     {
//         name: "Premdas Vm",
//         username: "@premdasvm",
//         body: "Man, this is soo good! I've been jealous of React because their eco-system had Magic UI and other ones like this. Inspira UI is 🔥🙌🏼",
//         img: "https://cdn.inspira-ui.com/images/x-logo.svg",
//     },
//     {
//         name: "Pierre",
//         username: "@PierreHenryBap",
//         body: "It looks really awesome! Just noticed it a couple of days ago and I can’t wait to try it out.",
//         img: "https://cdn.inspira-ui.com/images/x-logo.svg",
//     },
//     {
//         name: "Waldemar Enns",
//         username: "@WaldemarEnns",
//         body: "Awesome! ⭐️ed it immediately",
//         img: "https://cdn.inspira-ui.com/images/x-logo.svg",
//     },
// ];

// Rows
// const firstRow = ref(props.rsvps.slice(0, 4));
const dur = props.event.marquee_duration > 0 ? props.event.marquee_duration : 40
</script>

<style scoped>
.marquee {
    /* --duration: 40s; */
    position: absolute;
    left: -10%;
    width: 120%;
    padding: 0.5rem 0;
}
</style>
