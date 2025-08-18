<script setup lang="ts">
import { SidebarGroup, SidebarGroupLabel, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import SidebarMenuBadge from './ui/sidebar/SidebarMenuBadge.vue';

defineProps<{
    items: NavItem[];
}>();

const page = usePage();
</script>

<template>
    <SidebarGroup class="px-2 py-0">
        <SidebarGroupLabel>Menu</SidebarGroupLabel>
        <SidebarMenu>
            <SidebarMenuItem v-for="item in items" :key="item.title">
                <SidebarMenuButton as-child :is-active="item.href === page.url" :tooltip="item.title" :tooltipBadge="item.badge">
                    <Link :href="item.href">
                        <component :is="item.icon" />
                        {{ item.title }}
                    </Link>
                </SidebarMenuButton>
                <SidebarMenuBadge>
                    <span class="ml-auto text-muted-foreground">
                        {{ item.badge }}
                    </span>
                </SidebarMenuBadge>
            </SidebarMenuItem>
        </SidebarMenu>
    </SidebarGroup>
</template>
