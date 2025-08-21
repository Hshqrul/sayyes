<script setup lang="ts">
import AppLogoIcon from '@/components/AppLogoIcon.vue';
import { usePage } from '@inertiajs/vue3';

const page = usePage();
const name = page.props.name;
const quote = page.props.quote;

defineProps<{
    title?: string;
    description?: string;
}>();
</script>

<template>
    <div class="grid min-h-svh lg:grid-cols-2">
        <div class="flex flex-col gap-4 p-6 md:p-10">
            <div class="flex justify-center gap-2 md:justify-start">
                <a :href="route('user_dashboard')" class="flex items-center gap-2 font-medium">
                    <div class="flex h-8 w-8 items-center justify-center rounded-md bg-primary text-primary-foreground">
                        <AppLogoIcon class="size-5 fill-current stroke-current" />
                    </div>
                    {{ name }}
                </a>
            </div>
            <div class="flex flex-1 items-center justify-center">
                <div class="flex w-full max-w-sm flex-col gap-8">
                    <div class="flex flex-col space-y-2 text-center">
                        <h1 class="text-xl font-medium tracking-tight" v-if="title">{{ title }}</h1>
                        <p class="text-sm text-muted-foreground" v-if="description">{{ description }}</p>
                    </div>
                    <slot />
                </div>
            </div>
        </div>
        <div class="relative hidden h-full flex-col bg-muted p-10 text-white lg:flex dark:border-r">
            <div class="absolute inset-0 bg-zinc-900" />
            <div v-if="quote" class="relative z-20 mt-auto text-right">
                <blockquote class="space-y-2">
                    <p class="text-lg">&ldquo;{{ quote.message }}&rdquo;</p>
                    <footer class="text-sm text-neutral-300">{{ quote.author }}</footer>
                </blockquote>
            </div>
        </div>
    </div>
</template>
