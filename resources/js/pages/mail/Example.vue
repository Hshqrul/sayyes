<script lang="ts" setup>
import Card from '@/components/ui/card/Card.vue';
import Mail from './components/Mail.vue';
import { accounts, mails } from './data/mail';
import BaseLayout from '@/layouts/app/AppSidebarLayout.vue';
import AccountSwitcher from './components/AccountSwitcher.vue';
import Button from '@/components/ui/button/Button.vue';
import { Plus } from 'lucide-vue-next';
import ComposeButton from './components/ComposeButton.vue';
</script>

<template>
  <BaseLayout :breadcrumbs="[{ title: 'Inbox', href: '/mail' }]">
    <div class="flex h-full flex-1 flex-col gap-4 p-4 overflow-x-auto md:p-6">
      <div class="flex flex-row items-center justify-between px-2 md:p-2">
        <h1 class="text-2xl font-bold leading-tight tracking-tight">Compose</h1>
        <div class="flex flex-row gap-2">
          <!-- <AccountSwitcher :is-collapsed="false" :accounts="accounts" /> -->
          <ComposeButton />
        </div>
      </div>
      <Card class="md:w-full shadow-none">
        <Mail :accounts="accounts" :mails="mails" :nav-collapsed-size="4" />
      </Card>
    </div>
  </BaseLayout>
</template>