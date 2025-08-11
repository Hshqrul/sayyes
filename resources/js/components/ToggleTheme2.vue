<script setup lang="ts">
import { ToggleGroup, ToggleGroupItem } from "@/components/ui/toggle-group"
import { useAppearance } from '@/composables/useAppearance'
import { Monitor, Moon, Sun } from 'lucide-vue-next'

const { appearance, updateAppearance } = useAppearance()

const tabs = [
  { value: 'light', Icon: Sun, label: 'Light' },
  { value: 'dark', Icon: Moon, label: 'Dark' },
  { value: 'system', Icon: Monitor, label: 'System' },
] as const

function handleAppearanceChange(val: string | string[] | null) {
  if (typeof val === 'string') {
    updateAppearance(val as typeof tabs[number]['value'])
  }
}
</script>

<template>
  <ToggleGroup
    v-model="appearance"
    @update:modelValue="handleAppearanceChange"
    type="single"
    size="sm"
    class="w-full"
  >
    <ToggleGroupItem
      v-for="{ value, Icon } in tabs"
      :key="value"
      :value="value"
      :aria-label="`Switch to ${value} mode`"
    >
      <component :is="Icon" class="h-4 w-4" />
    </ToggleGroupItem>
  </ToggleGroup>
</template>
