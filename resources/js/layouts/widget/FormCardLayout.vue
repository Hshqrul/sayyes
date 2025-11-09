<script setup lang="ts">
// import AppLogoIcon from '@/components/AppLogoIcon.vue';
import CustomLogoIcon from '@/components/CustomLogoIcon.vue';
import TextLink from '@/components/TextLink.vue';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Link, usePage } from '@inertiajs/vue3';

const page = usePage();

defineProps<{
    title?: string;
    description?: string;
}>();
</script>

<template>
    <div class="flex min-h-svh flex-col items-center justify-center gap-6 bg-transparent p-6 md:p-10">
        <div class="flex w-full max-w-5xl">
            <div class="flex flex-col gap-6">
                <div class="isolate md:isolate-auto flex flex-col gap-4">
                    <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80"
                        aria-hidden="true">
                        <div class="relative left-1/2 -z-10 aspect-[1155/678] w-[36.125rem] max-w-none -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%-40rem)] sm:w-[72.1875rem]"
                            style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)">
                        </div>
                    </div>

                    <Card class="rounded-xl backdrop-blur-md bg-white/20 dark:bg-zinc-950/20">
                        <div class="flex items-center justify-center pt-10">
                            <Link :href="route('dashboard')" class="flex items-center gap-2 self-center font-medium">
                            <div class="flex h-9 w-9 items-center justify-center">
                                <!-- <AppLogoIcon class="size-14 fill-current text-black dark:text-white" /> -->
                                <CustomLogoIcon class="size-30 fill-current text-black dark:text-white" />
                            </div>
                            </Link>
                        </div>
                        <CardHeader class="px-10 pt-2 pb-0 text-center">
                            <CardTitle class="text-xl">{{ title }}</CardTitle>
                            <CardDescription>
                                {{ description }}
                            </CardDescription>
                        </CardHeader>
                        <CardContent class="px-10 py-4">
                            <slot />
                        </CardContent>
                    </Card>

                    <div class="bottom-0 w-full text-sm mx-auto flex items-center justify-center sm:px-16 py-6 md:flex-row flex flex-col gap-2 md:gap-0">
                        <div class="flex items-center gap-2 ">
                            <div class="flex items-center gap-1">
                                <span>
                                    &copy; {{ new Date().getFullYear() }} <TextLink :href="route('dashboard')"
                                        class="font-semibold">{{
                                            page.props.name }}</TextLink>
                                </span>
                            </div>
                            <span> · </span>
                            <div class="flex items-center gap-1">
                                <span class="rounded-sm italic">
                                    Built with
                                    <svg class="inline-block h-4 w-4 text-red-500" fill="currentColor"
                                        viewBox="0 0 24 24" aria-hidden="true">
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
                    </div>

                    <div aria-hidden="true"
                        class="absolute inset-x-0 top-[calc(80%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(80%-30rem)]">
                        <div style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"
                            class="relative left-[calc(50%+3rem)] aspect-1155/678 w-144.5 -translate-x-1/2 bg-linear-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%+36rem)] sm:w-288.75">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
