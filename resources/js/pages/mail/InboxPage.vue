<script lang="ts" setup>
import Card from '@/components/ui/card/Card.vue';
import Mail from './components/Mail.vue';
// import { accounts, mails } from './data/mail';
import BaseLayout from '@/layouts/app/AppSidebarLayout.vue';
import ComposeButton from './components/ComposeButton.vue';
import { usePage } from '@inertiajs/vue3';
import { AppPageProps } from '@/types';
import Alert from '@/components/ui/alert/Alert.vue';
import AlertTitle from '@/components/ui/alert/AlertTitle.vue';
import AlertDescription from '@/components/ui/alert/AlertDescription.vue';
import Icon from '@/components/Icon.vue';

interface Mail {
  id: string | null
  user: string | null
  subject: string | null
  text: string | null
  read: boolean
  labels: string | null // using text in DB
  created_at: string | null
}

const page = usePage<AppPageProps & { mails: Mail[] }>()
const mails = page.props.mails

console.log(page.props.mails)
</script>

<template>
  <BaseLayout :breadcrumbs="[{ title: 'Inbox', href: '/mail' }]">
    <div class="flex flex-1 flex-col gap-4 p-4 overflow-x-auto md:p-6">
      <div class="flex flex-row items-center justify-between px-2 md:p-2">
        <div class="flex flex-col gap-2">
          <h1 class="text-2xl font-bold leading-tight tracking-tight">Hello, {{ page.props.auth.user.username }}</h1>
          <p class="text-muted-foreground text-sm leading-tight tracking-tight">
            What's happening today?
          </p>
        </div>
        <div class="flex flex-row-reverse gap-2" v-if="page.props.mails.length > 0">
          <!-- <AccountSwitcher :is-collapsed="false" :accounts="accounts" /> -->
          <ComposeButton />
        </div>
      </div>
      <Card class="md:w-full shadow-none">
        <template v-if="page.props.mails.length > 0">
          <Mail :mails="mails" />
        </template>
        <template v-else>
          <div class="flex flex-1 flex-col items-center justify-center gap-4 p-4">
            <Alert>
              <Icon name="Rocket" class="h-4 w-4" />
              <AlertTitle>
                Heads up!
              </AlertTitle>
              <AlertDescription>
                You can add components to your app using the cli.
                <div class="flex mt-2 gap-2">
                  <ComposeButton />
                </div>
              </AlertDescription>
            </Alert>
          </div>
        </template>
      </Card>
    </div>
  </BaseLayout>
</template>