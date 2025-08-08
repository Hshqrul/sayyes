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

interface Event {
    id: number
    event_name: string
    slug: string
    description: string
    event_date: string
    allowed_pax: number
}

const props = defineProps<{ event: Event }>();

const form = useForm({
    event_name: props.event.event_name,
    slug: props.event.slug,
    description: props.event.description,
    event_date: new Date(props.event.event_date)
        .toLocaleDateString("en-CA", { timeZone: "Asia/Kuala_Lumpur" }), // 'YYYY-MM-DD'
    allowed_pax: props.event.allowed_pax,
});

function handleSubmit() {
    form.put(route('events.update', { event: props.event }));
}
</script>

<template>
    <AppSidebarLayout
        :breadcrumbs="[{ title: 'Event List', href: '/events' }, { title: 'Edit Event', href: `/events/${props.event.id}/edit` }]">

        <Head title="Edit Event" />
        <Layout>
            <div class="flex flex-col gap-4 lg:flex-row">
                <div class="w-78">
                    <HeadingSmall title="Event information" description="Update your event details" />
                </div>
                <Card class="w-full">
                    <CardContent class="space-y-6">
                        <form @submit.prevent="handleSubmit" class="space-y-6">
                            <div class="grid gap-6">
                                <div class="space-y-2">
                                    <Label for="event_name">Event Name</Label>
                                    <Input type="text" id="event_name" v-model="form.event_name" />
                                    <InputError :message="form.errors.event_name" />
                                </div>
                            </div>
                            <div class="grid gap-6">
                                <div class="space-y-2">
                                    <Label for="slug">Slug Name</Label>
                                    <Input type="text" id="slug" v-model="form.slug" readonly class="text-gray-500" />
                                    <InputError :message="form.errors.slug" />
                                </div>
                            </div>
                            <div class="grid gap-6">
                                <div class="space-y-2">
                                    <Label for="event_date">Event Date</Label>
                                    <Input type="date" id="event_date" v-model="form.event_date" />
                                    <InputError :message="form.errors.event_date" />
                                </div>
                            </div>
                            <div class="grid gap-6">
                                <div class="space-y-2">
                                    <Label for="allowed_pax">Allowed Pax</Label>
                                    <NumberField id="allowed_pax" :default-value="0" v-model="form.allowed_pax">
                                        <NumberFieldContent>
                                            <NumberFieldDecrement />
                                            <NumberFieldInput class="shadow-xs text-lg" />
                                            <NumberFieldIncrement />
                                        </NumberFieldContent>
                                    </NumberField>
                                    <InputError :message="form.errors.allowed_pax" />
                                </div>
                            </div>
                            <div class="grid gap-6">
                                <div class="space-y-2">
                                    <Label for="description">Description</Label>
                                    <Textarea type="text" id="description" v-model="form.description" />
                                    <InputError :message="form.errors.description" />
                                </div>
                            </div>
                            <div class="flex justify-start space-x-2">
                                <Button type="submit">Submit</button>
                            </div>
                        </form>
                    </CardContent>
                </Card>
            </div>
        </Layout>
    </AppSidebarLayout>
</template>