<script setup lang="ts">
import AppSidebarLayout from '@/layouts/app/AppSidebarLayout.vue';
import StatsWidget from './dashboard-items/StatsWidget.vue';
import { usePage } from '@inertiajs/vue3';
import { MessageCircleDashedIcon, PlusIcon, UserCircle } from 'lucide-vue-next';
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

interface EventStat {
  event_name: string
  attend: number
  absent: number
  total: number
}

// const stats = computed(() => page.props.stats as EventStat[]);
const stats = page.props.stats as EventStat[];
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
      <div v-if="stats && stats.length > 0">
        <StatsWidget :event-stats="stats" />
      </div>
      <div v-else class="text-center text-muted-foreground py-8">
        <Card class="shadow-none">
          <CardContent class="flex flex-col items-center py-8">
            <MessageCircleDashedIcon class="size-6 text-muted-foreground mb-4" />
            <p class="text-muted-foreground text-center">
              You haven't created any events yet.
            </p>
            <Button class="mt-4" as-child>
              <a :href="route('events.create')">
                <PlusIcon class="size-4 mr-2" />
                Create Event
              </a>
            </Button>
          </CardContent>
        </Card>
      </div>
    </div>
  </AppSidebarLayout>
</template>