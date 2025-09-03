<script setup lang="ts">
import { Head, router, useForm } from '@inertiajs/vue3'
import AppSidebarLayout from "@/layouts/app/AppSidebarLayout.vue"
import Card from '@/components/ui/card/Card.vue'
import CardContent from '@/components/ui/card/CardContent.vue'
import Label from '@/components/ui/label/Label.vue'
import Input from '@/components/ui/input/Input.vue'
import InputError from '@/components/InputError.vue'
import Button from '@/components/ui/button/Button.vue'
import Textarea from '@/components/ui/textarea/Textarea.vue'
import NumberField from '@/components/ui/number-field/NumberField.vue'
import NumberFieldContent from '@/components/ui/number-field/NumberFieldContent.vue'
import NumberFieldDecrement from '@/components/ui/number-field/NumberFieldDecrement.vue'
import NumberFieldIncrement from '@/components/ui/number-field/NumberFieldIncrement.vue'
import NumberFieldInput from '@/components/ui/number-field/NumberFieldInput.vue'
import Layout from '@/layouts/settings/EditLayout.vue'
import HeadingSmall from '@/components/HeadingSmall.vue'
import ToggleGroup from '@/components/ui/toggle-group/ToggleGroup.vue'
import ToggleGroupItem from '@/components/ui/toggle-group/ToggleGroupItem.vue'
import { BadgeCheckIcon, CloudMoonIcon } from 'lucide-vue-next'
import { h, watch } from 'vue'
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from "@/components/ui/select"
import Separator from '@/components/ui/separator/Separator.vue'
import { toast } from 'vue-sonner'

interface Rsvp {
    id: number
    name: string
    no_of_pax: number
    attendence: boolean
    notes: string
    event_id: number
    created_at: string
}

interface Event {
    id: number
    event_name: string
    slug: string
    description: string
    event_date: string
    allowed_pax: number
}

const props = defineProps<{
    rsvp: Rsvp,
    event: Event,
    eventList: { id: number, event_name: string }[]
}>()

const form = useForm({
    id: props.rsvp.id,
    name: props.rsvp.name,
    no_of_pax: props.rsvp.no_of_pax,
    attendence: props.rsvp.attendence,
    notes: props.rsvp.notes,
    event_id: props.rsvp.event_id ? String(props.rsvp.event_id) : '',
    created_at: props.rsvp.created_at,
});

function handleSubmit(values) {
    form.put(route('rsvps.update', props.rsvp.id));
}

watch(() => form.attendence, (isAttending) => {
    if (!isAttending) {
        form.no_of_pax = 0
    } else {
        form.no_of_pax = 1
    }
})
</script>

<template>
    <AppSidebarLayout
        :breadcrumbs="[{ title: 'Guest List', href: `/events/${props.event.slug}/rsvps` }, { title: 'Edit Rsvp', href: `/rsvps/${props.rsvp.event_id}/edit` }]">

        <Head title="Edit Rsvp" />
        <Layout>
            <div class="flex flex-col gap-4 lg:gap-6 lg:flex-row">
                <div class="w-78">
                    <HeadingSmall title="Rsvp information" description="Update rsvp details" />
                </div>
                <Card class="w-full">
                    <CardContent class="space-y-6">
                        <form @submit.prevent="handleSubmit" class="space-y-6">
                            <div class="grid gap-6">
                                <div class="space-y-4">
                                    <Label for="name">Guest Name</Label>
                                    <Input type="text" id="name" v-model="form.name" />
                                    <InputError :message="form.errors.name" />
                                </div>
                            </div>
                            <div class="grid gap-6">
                                <div class="space-y-4">
                                    <Label for="attendence">Guest Attendance</Label>
                                    <ToggleGroup id="attendence" variant="outline" type="single"
                                        v-model="form.attendence" class="w-full">
                                        <ToggleGroupItem :value="true">
                                            <BadgeCheckIcon class="mr-2 h-4 w-4 text-green-500" />
                                            Yes
                                        </ToggleGroupItem>
                                        <ToggleGroupItem :value="false">
                                            <CloudMoonIcon class="mr-2 h-4 w-4 text-indigo-500" />
                                            No
                                        </ToggleGroupItem>
                                    </ToggleGroup>
                                    <InputError :message="form.errors.attendence" />
                                </div>
                            </div>
                            <div class="grid gap-6">
                                <div class="space-y-4">
                                    <Label for="no_of_pax">Number of Guests</Label>
                                    <NumberField id="no_of_pax" :default-value="1" :min="form.attendence ? 1 : 0"
                                        :max="event.allowed_pax" :disabled="!form.attendence" v-model="form.no_of_pax">
                                        <NumberFieldContent>
                                            <NumberFieldDecrement />
                                            <NumberFieldInput />
                                            <NumberFieldIncrement />
                                        </NumberFieldContent>
                                    </NumberField>
                                    <InputError :message="form.errors.no_of_pax" />
                                </div>
                            </div>
                            <div class="grid gap-6">
                                <div class="space-y-4">
                                    <Label for="notes">Guest Wish for bride & groom</Label>
                                    <Textarea id="notes" type="text" v-model="form.notes"
                                        placeholder="Your wish for bride & groom" />
                                    <InputError :message="form.errors.notes" />
                                </div>
                            </div>
                            <div class="grid gap-6">
                                <div class="space-y-4">
                                    <Label for="event_id">Event</Label>
                                    <Select v-model="form.event_id">
                                        <SelectTrigger class="w-full">
                                            <SelectValue placeholder="Choose an event" />
                                        </SelectTrigger>
                                        <SelectContent>
                                            <SelectGroup>
                                                <SelectItem v-for="event in props.eventList" :key="event.id"
                                                    :value="event.id.toString()">
                                                    {{ event.event_name }}
                                                </SelectItem>
                                            </SelectGroup>
                                        </SelectContent>
                                    </Select>
                                    <InputError :message="form.errors.event_id" />
                                </div>
                            </div>
                            <div class="flex justify-start space-x-2">
                                <Button type="submit">Save</Button>
                                <Button type="button" variant="outline"
                                    @click="router.visit(`/events/${props.event.slug}/rsvps`)">
                                    Cancel
                                </Button>
                            </div>
                        </form>
                    </CardContent>
                </Card>
            </div>
            <!-- <Separator class="my-8" />
            <div class="flex flex-col gap-4 lg:col-span-2 lg:flex-row">
                <div class="w-78">
                    <HeadingSmall title="Rsvp information" description="Update rsvp details" />
                </div>
                <Card class="w-full">
                    <CardContent class="space-y-6">
                        <form @submit.prevent="handleSubmit" class="space-y-6">
                            <div class="grid gap-6">
                                <div class="space-y-4">
                                    <Label for="name">Name</Label>
                                    <Input type="text" id="name" v-model="form.name" />
                                    <InputError :message="form.errors.name" />
                                </div>
                            </div>
                            <div class="grid gap-6">
                                <div class="space-y-4">
                                    <Label for="attendence">Will you attend?</Label>
                                    <ToggleGroup id="attendence" variant="outline" type="single"
                                        v-model="form.attendence" class="w-full">
                                        <ToggleGroupItem :value="true">
                                            <BadgeCheckIcon class="mr-2 h-4 w-4 text-green-500" />
                                            Yes
                                        </ToggleGroupItem>
                                        <ToggleGroupItem :value="false">
                                            <CloudMoonIcon class="mr-2 h-4 w-4 text-indigo-500" />
                                            No
                                        </ToggleGroupItem>
                                    </ToggleGroup>
                                    <InputError :message="form.errors.attendence" />
                                </div>
                            </div>
                            <div class="grid gap-6">
                                <div class="space-y-4">
                                    <Label for="no_of_pax">Number of Guests</Label>
                                    <NumberField id="no_of_pax" :default-value="1" :min="form.attendence ? 1 : 0"
                                        :max="event.allowed_pax" :disabled="!form.attendence" v-model="form.no_of_pax">
                                        <NumberFieldContent>
                                            <NumberFieldDecrement />
                                            <NumberFieldInput />
                                            <NumberFieldIncrement />
                                        </NumberFieldContent>
                                    </NumberField>
                                    <InputError :message="form.errors.no_of_pax" />
                                </div>
                            </div>
                            <div class="grid gap-6">
                                <div class="space-y-4">
                                    <Label for="notes">Wish for bride & groom</Label>
                                    <Textarea id="notes" type="text" v-model="form.notes"
                                        placeholder="Your wish for bride & groom" />
                                    <InputError :message="form.errors.notes" />
                                </div>
                            </div>
                            <div class="grid gap-6">
                                <div class="space-y-4">
                                    <Label for="event_id">Event ID</Label>
                                    <Input type="text" id="event_id" v-model="form.event_id" readonly
                                        class="text-gray-500" />
                                    <InputError :message="form.errors.event_id" />
                                </div>
                            </div>
                            <div class="flex justify-start space-x-2">
                                <Button type="submit">Save</Button>
                                <Button type="button" variant="outline"
                                    @click="router.visit(`/events/${props.event.slug}/rsvps`)">
                                    Cancel
                                </Button>
                            </div>
                        </form>
                    </CardContent>
                </Card>
            </div> -->
        </Layout>
    </AppSidebarLayout>
</template>