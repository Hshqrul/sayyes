<script setup lang="ts">
import AppSidebarLayout from '@/layouts/app/AppSidebarLayout.vue';
import StatsWidget from './dashboard-items/StatsWidget.vue';
import { usePage } from '@inertiajs/vue3';
import { UserCircle } from 'lucide-vue-next';
import Card from '@/components/ui/card/Card.vue';
import CardContent from '@/components/ui/card/CardContent.vue';
import Avatar from '@/components/ui/avatar/Avatar.vue';
import AvatarImage from '@/components/ui/avatar/AvatarImage.vue';
import AvatarFallback from '@/components/ui/avatar/AvatarFallback.vue';
import Button from '@/components/ui/button/Button.vue';
import { computed } from 'vue';
import { User } from '@/types';
import { getInitials } from '@/composables/useInitials';

const page = usePage();
const user = page.props.auth.user as User;
interface Stats {
  attend: number;
  absent: number;
  total: number;
}

const stats = computed<Stats>(() => page.props.stats);

const showAvatar = computed(() => user.avatar && user.avatar !== '');
</script>

<template>
  <AppSidebarLayout :breadcrumbs="[{
    title: 'Dashboard',
    href: '/user/dashboard',
  }]">
    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
      <Card class="shadow-none">
        <CardContent class="flex items-center gap-x-3">
          <Avatar class="h-10 w-10 overflow-hidden rounded-lg">
            <AvatarImage v-if="showAvatar" :src="user.avatar!" :alt="user.username" />
            <AvatarFallback class="bg-black rounded-lg border text-white">
              {{ getInitials(user.username) }}
            </AvatarFallback>
          </Avatar>
          <div class="flex-1">
            <h1 class="grid flex-1 text-md font-semibold leading-6">
              Welcome
            </h1>
            <p class="mt-1 text-muted-foreground text-sm">
              {{ page.props.auth.user.username }}
            </p>
          </div>
          <div class="flex items-end gap-2">
            <Button variant="outline" class="w-full" as-child>
              <a :href="route('profile.edit')">
                <UserCircle class="size-4" />
                Profile
              </a>
            </Button>
          </div>
        </CardContent>
      </Card>
      <StatsWidget :attend-count="stats.attend" :absent-count="stats.absent" :total-guests="stats.total" />
    </div>
  </AppSidebarLayout>
</template>