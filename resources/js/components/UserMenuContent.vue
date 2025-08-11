<script setup lang="ts">
import UserInfo from '@/components/UserInfo.vue';
import { DropdownMenuGroup, DropdownMenuItem, DropdownMenuLabel, DropdownMenuSeparator } from '@/components/ui/dropdown-menu';
import type { User } from '@/types';
import { Link, router } from '@inertiajs/vue3';
import { LayoutDashboardIcon, LogOut, UserCircle } from 'lucide-vue-next';
import ToggleTheme2 from './ToggleTheme2.vue';

interface Props {
    user: User;
}

const handleLogout = () => {
    router.flushAll();
};

defineProps<Props>();
</script>

<template>
    <DropdownMenuLabel class="p-0 font-normal">
        <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
            <UserInfo :user="user" :show-email="false" />
        </div>
    </DropdownMenuLabel>
    <DropdownMenuSeparator />
    <DropdownMenuGroup>
        <DropdownMenuItem>
            <ToggleTheme2 />
        </DropdownMenuItem>
    </DropdownMenuGroup>
    <DropdownMenuSeparator />
    <DropdownMenuGroup>
        <DropdownMenuItem :as-child="true">
            <Link class="block w-full hover:bg-muted" :href="route('profile.edit')" prefetch as="button">
                <UserCircle class="mr-2 h-4 w-4" />
                Account
            </Link>
        </DropdownMenuItem>
        <!-- <DropdownMenuItem :as-child="true">
            <Link class="block w-full hover:bg-muted" :href="route('user_dashboard')" prefetch as="button">
                <LayoutDashboardIcon class="mr-2 h-4 w-4" />
                Dashboard
            </Link>
        </DropdownMenuItem> -->
    </DropdownMenuGroup>
    <DropdownMenuSeparator />
    <DropdownMenuItem :as-child="true">
        <Link class="block w-full" method="post" :href="route('logout')" @click="handleLogout" as="button">
            <LogOut class="mr-2 h-4 w-4" />
            Log out
        </Link>
    </DropdownMenuItem>
</template>
