<script setup lang="ts">
import { DropdownMenuItem, DropdownMenuLabel, DropdownMenuSeparator } from '@/components/ui/dropdown-menu';
import { Link, router } from '@inertiajs/vue3';
import { LogIn } from 'lucide-vue-next';
import Avatar from './ui/avatar/Avatar.vue';
import AvatarFallback from './ui/avatar/AvatarFallback.vue';
import { getInitials } from '@/composables/useInitials';
import AppearanceTabs from './AppearanceTabs.vue';
import SwitchTheme from './SwitchTheme.vue';

interface Props {
    // user: User;
}

const handleLogout = () => {
    router.flushAll();
};

defineProps<Props>();
</script>

<template>
    <DropdownMenuLabel class="p-0 font-normal">
        <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
            <Avatar class="h-8 w-8 overflow-hidden rounded-lg">
                <AvatarFallback class="rounded-lg text-black dark:text-white">
                    {{ getInitials('G') }}
                </AvatarFallback>
            </Avatar>

            <div class="grid flex-1 text-left text-sm leading-tight">
                <span class="truncate font-medium">{{ 'Guest' }}</span>
                <span class="truncate text-xs text-muted-foreground">{{ 'Hello there!' }}</span>
            </div>
        </div>
    </DropdownMenuLabel>
    <DropdownMenuSeparator />
    <DropdownMenuItem :as-child="true">
        <Link class="block w-full" method="get" :href="route('login')" as="button">
        <LogIn class="mr-2 h-4 w-4" />
        Login
        </Link>
    </DropdownMenuItem>
</template>
