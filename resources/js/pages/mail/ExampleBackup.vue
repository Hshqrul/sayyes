<script lang="ts" setup>
import Mail from './components/MailBackup.vue'
import { accounts, mails } from './data/mail';
</script>

<template>
  <div class="md:hidden">
    <VPImage
      alt="Mail"
      width="1280"
      height="727"
      class="block"
      :image="{
        dark: '/examples/mail-dark.png',
        light: '/examples/mail-light.png',
      }"
    />
  </div>
  <div class="hidden flex-col md:flex">
    <Mail
      :accounts="accounts"
      :mails="mails"
      :nav-collapsed-size="4"
    />
  </div>
</template>