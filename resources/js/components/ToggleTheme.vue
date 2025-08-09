<script setup lang="ts">
import { useColorMode, useDark } from '@vueuse/core';
import Switch from './ui/switch/Switch.vue';
import Label from './ui/label/Label.vue';
import Icon from './Icon.vue';
import Toggle from './ui/toggle/Toggle.vue';

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
    <div class="flex items-center px-2 space-x-2 group-data-[collapsible=icon]:p-0">
        <Toggle v-model="isDark" @change="toggleTheme" size="sm">
            <Icon v-if="isDark" name="moon" class="size-4" />
            <Icon v-else name="sun" class="size-4" />
        </Toggle>
        <Label v-if="isDark" class="group-data-[collapsible=icon]:hidden">Dark Mode</Label>
        <Label v-else class="group-data-[collapsible=icon]:hidden">Light Mode</Label>
    </div>
    <!-- <Switch :model-value="isDark" @update:model-value="toggleTheme" /> -->
</template>

<!-- <script setup lang="ts">
import { useColorMode, useDark } from '@vueuse/core';
import Switch from './ui/switch/Switch.vue';
import Label from './ui/label/Label.vue';
import Icon from './Icon.vue';
import Toggle from './ui/toggle/Toggle.vue';

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
    <div class="flex flex-row items-center p-2 group-data-[collapsible=icon]:p-0">
        <Toggle v-model="isDark" @change="toggleTheme" size="sm" class="flex w-full justify-start space-x-1" :tooltip="isDark ? 'Dark Mode' : 'Light Mode'">
            <Icon v-if="isDark" name="moon" class="size-4" />
            <Icon v-else name="sun" class="size-4" />
            <Label v-if="isDark" class="group-data-[collapsible=icon]:hidden">Dark Mode</Label>
            <Label v-else class="group-data-[collapsible=icon]:hidden">Light Mode</Label>
        </Toggle>
    </div>
</template> -->