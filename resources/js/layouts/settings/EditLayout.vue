<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';

const page = usePage();
</script>

<template>
    <div class="px-6 py-8 h-full">
        <slot />
    </div>
</template>
