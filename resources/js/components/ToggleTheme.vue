<script setup lang="ts">
import { useColorMode, useDark } from '@vueuse/core';
import Switch from './ui/switch/Switch.vue';
import Label from './ui/label/Label.vue';
import Icon from './Icon.vue';

const isDark = useDark({
    selector: 'body',
    attribute: 'data-theme',
    valueDark: 'dark',
    valueLight: 'light',
});

const mode = useColorMode();

const toggleTheme = () => {
    mode.value = isDark.value ? 'light' : 'dark';
};
</script>

<template>
    <div class="flex items-center px-2 py-1 space-x-3 group-data-[collapsible=icon]:hidden">
        <Switch :model-value="isDark" @update:model-value="toggleTheme" />
        <!-- <template #thumb>
            <Icon v-if="isDark" name="moon" class="size-4" />
            <Icon v-else name="sun" class="size-4" />
        </template> -->
        <!-- </Switch> -->
        <Label v-if="isDark">Dark Mode</Label>
        <Label v-else>Light Mode</Label>
    </div>
</template>