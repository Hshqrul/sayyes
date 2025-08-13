<script lang="ts" setup>
import Mail from './components/Mail.vue'
import { accounts, mails } from './data/mail';
</script>

<template>
  <div class="flex flex-col">
    <Mail :accounts="accounts" :mails="mails" :nav-collapsed-size="4" />
  </div>
</template>