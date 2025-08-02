<script setup lang="ts">
import AppLayout from '@/layouts/app/FormSimpleLayout.vue'
import { Head, useForm, usePage } from '@inertiajs/vue3'
import Button from '@/components/ui/button/Button.vue'
import Label from '@/components/ui/label/Label.vue'
import Input from '@/components/ui/input/Input.vue'
import InputError from '@/components/InputError.vue'
import TextLink from '@/components/TextLink.vue'
import ToggleGroup from '@/components/ui/toggle-group/ToggleGroup.vue'
import ToggleGroupItem from '@/components/ui/toggle-group/ToggleGroupItem.vue'
import RadioGroup from '@/components/ui/radio-group/RadioGroup.vue'
import RadioGroupItem from '@/components/ui/radio-group/RadioGroupItem.vue'
import { BadgeCheck, CloudMoon, LoaderCircle } from 'lucide-vue-next'
import Textarea from '@/components/ui/textarea/Textarea.vue'
import { watch } from 'vue'

const page = usePage()

console.log(page.props.flash)

const form = useForm({
    name: '',
    attendence: 0,
    no_of_pax: 0,
    notes: 'I am sorry, but wishing you both....'
})

const handleSubmit = () => {
    form.post(route('rsvp.store'));
}

watch(() => form.attendence, (newValue) => {
    if (newValue === 0) {
        form.no_of_pax = 0
        form.notes = 'I am sorry, but wishing you both....'
    } else {
        form.no_of_pax = 1
        form.notes = ''
    }
})
</script>

<template>

    <Head title="RSVP" />
    <AppLayout title="Create an account" description="Enter your details below to create your account">
        <form @submit.prevent="handleSubmit" class="flex flex-col gap-6">
            <div class="grid gap-6">
                <div class="space-y-2">
                    <Label for="name">Full Name</Label>
                    <Input id="name" type="text" v-model="form.name" placeholder="Na.." required autofocus
                        autocomplete="name" tabindex="1" />
                    <InputError :message="form.errors.name" />
                </div>

                <div class="space-y-2">
                    <Label for="attendance">Will you attend?</Label>
                    <ToggleGroup id="attendance" variant="outline" type="single" v-model="form.attendence"
                        class="w-full">
                        <ToggleGroupItem :value="1">
                            <BadgeCheck class="mr-2 h-4 w-4 text-green-500" />
                            Yes
                        </ToggleGroupItem>
                        <ToggleGroupItem :value="0">
                            <CloudMoon class="mr-2 h-4 w-4 text-indigo-500" />
                            No
                        </ToggleGroupItem>
                    </ToggleGroup>
                    <InputError :message="form.errors.attendence" />
                </div>

                <div class="space-y-2">
                    <Label for="no_of_pax">Number of Guests</Label>
                    <RadioGroup id="no_of_pax" direction="row" v-model="form.no_of_pax">
                        <div class="flex items-center space-x-2">
                            <RadioGroupItem id="pax1" value="1" :disabled="form.attendence === 0" />
                            <Label for="pax1">1</Label>
                        </div>
                        <div class="flex items-center space-x-2">
                            <RadioGroupItem id="pax2" value="2" :disabled="form.attendence === 0" />
                            <Label for="pax2">2</Label>
                        </div>
                    </RadioGroup>
                    <InputError :message="form.errors.no_of_pax" />
                </div>

                <div class="space-y-2">
                    <Label for="notes">Wishes</Label>
                    <Textarea id="notes" type="text" v-model="form.notes" placeholder="I wish to..." tabindex="4" />
                    <InputError :message="form.errors.notes" />
                </div>

                <Button type="submit" class="mt-2 w-full" tabindex="5" :disabled="form.processing">
                    <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                    Submit
                </Button>
            </div>

            <!-- <div class="text-center text-sm text-muted-foreground dark:text-zinc-300">
                Already have an account?
                <TextLink :href="route('login')" class="underline underline-offset-4" :tabindex="6">
                    Log in
                </TextLink>
            </div> -->
        </form>
    </AppLayout>
</template>
