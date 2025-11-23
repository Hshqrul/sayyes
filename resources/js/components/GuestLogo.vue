<script setup lang="ts">
import AppLogoIcon from '@/components/AppLogoIcon.vue';
import { usePage } from '@inertiajs/vue3';

const page = usePage();
</script>

<template>
    <div class="flex aspect-square size-8 items-center justify-center rounded-md text-sidebar-primary-foreground"
        v-if="!page.props.event">
        <AppLogoIcon class="size-6 fill-current text-black dark:text-white" />
    </div>
    <div class="ml-1 grid flex-1 text-left text-sm">
        <div v-if="page.props.event">
            <span class="mb-0.5 truncate leading-tight font-semibold text-wrap">{{ page.props.event?.event_name }}</span>
        </div>
        <div v-else>
            <span class="mb-0.5 truncate leading-tight font-semibold">AECH</span>
        </div>
    </div>
</template>
