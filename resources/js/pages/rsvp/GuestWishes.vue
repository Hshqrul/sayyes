<script setup lang="ts">
import FormSimpleLayout from '@/layouts/widget/FormCardLayout.vue'
import { Head, usePage } from '@inertiajs/vue3'
import ListParticipants from './ListParticipants.vue'
import RsvpCard from '@/components/ui/marquee/RsvpCard.vue'

const page = usePage<Props>()
const rsvps = page.props.rsvps
const event = page.props.event
</script>

<template>

    <Head title="Guest Book" />

    <FormSimpleLayout :title="event.event_name" :description="event.description">
        <div class="flex flex-col gap-4 mb-4">
            <div class="border-b border-sidebar-border/70"></div>
            <div class="flex flex-row items-center justify-between">
                <h1 class="text-xl font-extrabold tracking-tight lg:text-2xl">Guests Book</h1>
                <ListParticipants :rsvps="rsvps" />
            </div>
            <div class="border-b border-sidebar-border/70"></div>
            <div class="grid grid-cols-1 gap-4 overflow-y-auto max-h-full lg:max-h-[300px]">
                <RsvpCard v-for="(rsvp, index) in rsvps" :key="index" :name="rsvp.name"
                    :body="rsvp.notes || `No message left`" :attendance="rsvp.attendence" :no_of_pax="rsvp.no_of_pax"
                    :created_at="rsvp.created_at" />
            </div>
        </div>
    </FormSimpleLayout>
</template>
