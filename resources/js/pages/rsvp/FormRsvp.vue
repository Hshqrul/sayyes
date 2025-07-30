<script setup lang="ts">
import AppLayout from '@/layouts/auth/FormAuthCardLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import Button from '@/components/ui/button/Button.vue';
import { ArrowRight, LoaderCircle } from 'lucide-vue-next';
import Label from '@/components/ui/label/Label.vue';
import Input from '@/components/ui/input/Input.vue';
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <AppLayout title="Create an account" description="Enter your details below to create your account">

        <Head title="RSVP" />
        <form @submit.prevent="submit" class="flex flex-col gap-6">
            <div class="grid gap-6">
                <div class="grid gap-2">
                    <Label for="name">Name</Label>
                    <Input id="name" type="text" required autofocus :tabindex="1" autocomplete="name"
                        v-model="form.name" placeholder="Full name" />
                    <InputError :message="form.errors.name" />
                </div>

                <div class="grid gap-2">
                    <Label for="email">Email address</Label>
                    <Input id="email" type="email" required :tabindex="2" autocomplete="email" v-model="form.email"
                        placeholder="email@example.com" />
                    <InputError :message="form.errors.email" />
                </div>

                <div class="grid gap-2">
                    <Label for="password">Password</Label>
                    <Input id="password" type="password" required :tabindex="3" autocomplete="new-password"
                        v-model="form.password" placeholder="Password" />
                    <InputError :message="form.errors.password" />
                </div>

                <div class="grid gap-2">
                    <Label for="password_confirmation">Confirm password</Label>
                    <Input id="password_confirmation" type="password" required :tabindex="4" autocomplete="new-password"
                        v-model="form.password_confirmation" placeholder="Confirm password" />
                    <InputError :message="form.errors.password_confirmation" />
                </div>

                <Button type="submit" class="mt-2 w-full" tabindex="5" :disabled="form.processing">
                    <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                    Create account
                </Button>
            </div>

            <div class="text-center text-sm text-muted-foreground">
                Already have an account?
                <TextLink :href="route('login')" class="underline underline-offset-4" :tabindex="6">Log in</TextLink>
            </div>
        </form>
        <!-- <div class="flex min-h-full items-center justify-center px-4 py-12 sm:px-6 lg:px-8">
            <div class="w-full max-w-md space-y-8">
                <div>
                    <h2 class="mt-6 text-center text-3xl font-extrabold tracking-tight text-gray-900">
                        RSVP for the Event
                    </h2>
                    <p class="mt-2 text-center text-sm text-gray-600">
                        Please fill out the form below to confirm your attendance.
                    </p>
                </div>
                <form class="mt-8 space-y-6" action="#" method="POST">
                    <input type="hidden" name="remember" value="true" />
                    <div class="-space-y-px rounded-md shadow-sm">
                        <div>
                            <label for="name" class="sr-only">Name</label>
                            <input id="name" name="name" type="text" autocomplete="name" required
                                class="relative block w-full appearance-none rounded-t-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                                placeholder="Your Name">
                        </div>
                        <div>
                            <label for="email-address" class="sr-only">Email address</label>
                            <input id="email-address" name="email" type="email" autocomplete="email" required
                                class="relative block w-full appearance-none rounded-b-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                                placeholder="Email address">
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="flex h-5 items-center">
                            <input id="attendence" name="attendence" type="checkbox" value="1"
                                class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="attendence" class="font-medium text-gray-700">Will you attend?</label>
                        </div>
                    </div>
                    <div>
                        <label for="no_of_pax" class="sr-only">Number of Guests</label>
                        <input id="no_of_pax" name="no_of_pax" type="number" min="1" required
                            class="relative block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                            placeholder="Number of Guests">
                    </div>
                    <div>
                        <Button type="submit" class="w-full justify-center">
                            Submit RSVP
                            <ArrowRight class="size-4 ml-2" />
                        </Button>
                    </div>
                </form>
            </div>
        </div>  -->
    </AppLayout>
</template>
