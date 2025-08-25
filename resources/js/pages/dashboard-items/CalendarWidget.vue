<script setup lang="ts">
import { type DateValue, getLocalTimeZone, parseDate, today } from '@internationalized/date'
import { ref, watch } from 'vue'
import { Calendar } from '@/components/ui/calendar'

const props = defineProps<{
  modelValue?: DateValue
  readonly?: boolean
}>()

const emit = defineEmits<{
  (e: 'update:modelValue', value: DateValue): void
}>()

// Default to 27/12/2025 if modelValue is not provided
const value = ref<DateValue>(props.modelValue ?? today(getLocalTimeZone()))
// const value = ref<{ start: DateValue; end: DateValue }>({
//   start: today(getLocalTimeZone()),
//   end: props.modelValue ?? today(getLocalTimeZone()),
// })

// Emit updates to parent
watch(value, (newVal) => {
  emit('update:modelValue', newVal)
})

// Update local value if parent prop changes
watch(() => props.modelValue, (newVal) => {
  if (newVal) value.value = newVal
})
</script>

<template>
  <Calendar v-model="value" :weekday-format="'short'" class="rounded-md border" :readonly="readonly" />
  <!-- <RangeCalendar v-model="value" :weekday-format="'short'" class="rounded-md border" :readonly="readonly" /> -->
</template>