<template>
    <div class="flex w-full max-w-7xl flex-col items-center justify-center p-4">
        <div class="flex flex-col gap-4 py-12 text-center">
            <div class="text-4xl font-extrabold tracking-tight lg:text-5xl">Guests Book</div>
            <div class="text-muted-foreground font-semibold tracking-tight">
                All wishes for bride & groom
                <span class="text-lg">
                    ❤️
                </span>
            </div>
        </div>
        <div class="relative flex w-full flex-col items-center justify-center overflow-hidden">
            <!-- First Marquee -->
            <!-- @todo dynamic duration and paused when hover-->
            <Marquee pause-on-hover pause-on-click class="[--duration:20s]">
                <WishesCard v-for="(rsvp, index) in rsvps" :key="index" :name="rsvp.name"
                    :body="rsvp.notes || `No message left`" :attendence="rsvp.attendence"
                    :created_at="rsvp.created_at" />
            </Marquee>

            <!-- Second Marquee (reverse) -->
            <Marquee reverse pause-on-hover pause-on-click class="[--duration:20s]">
                <WishesCard v-for="(rsvp, index) in rsvps" :key="index" :name="rsvp.name"
                    :body="rsvp.notes || `No message left`" :attendence="rsvp.attendence"
                    :created_at="rsvp.created_at" />
            </Marquee>

            <!-- Left Gradient -->
            <div
                class="pointer-events-none absolute inset-y-0 left-0 w-1/5 md:w-1/3 bg-gradient-to-r from-white dark:from-background">
            </div>

            <!-- Right Gradient -->
            <div
                class="pointer-events-none absolute inset-y-0 right-0 w-1/5 md:w-1/3 bg-gradient-to-l from-white dark:from-background">
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import Marquee from '@/components/ui/marquee/Marquee.vue';
import WishesCard from '@/components/ui/marquee/WishesCard.vue';

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

</script>

<style scoped>
.marquee {
    --duration: 40s;
    position: absolute;
    left: -10%;
    width: 120%;
    padding: 0.5rem 0;
}
</style>