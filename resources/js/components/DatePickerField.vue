<script setup lang="ts">
import { CalendarDate, DateFormatter, parseDate } from "@internationalized/date"
import { CalendarIcon } from "lucide-vue-next"
import { toDate } from "reka-ui/date"
import { computed, ref } from "vue"
import { Button } from "@/components/ui/button"
import { Calendar } from "@/components/ui/calendar"
import {
    FormControl,
    FormDescription,
    FormField,
    FormItem,
    FormLabel,
    FormMessage,
} from "@/components/ui/form"
import { Popover, PopoverContent, PopoverTrigger } from "@/components/ui/popover"
import { cn } from "@/lib/utils"
import CalendarMonthYear from "./ui/calendar/CalendarMonthYear.vue"

type Props = {
    /** The VeeValidate field name */
    name: string
    /** The label text */
    label?: string
    /** Optional description under the field */
    description?: string
    /** Minimum date allowed */
    minDate?: CalendarDate
    /** Maximum date allowed */
    maxDate?: CalendarDate
    /** Placeholder text when no date selected */
    placeholderText?: string
    /** class */
    class?: string
    /** Can select month and year */
    isSelectMY?: boolean
    /** Can select month and year */
    isRange?: boolean
}

const props = withDefaults(defineProps<Props>(), {
    label: "Select date",
    placeholderText: "Pick a date",
})

const df = new DateFormatter("en-US", { dateStyle: "long" })

const placeholder = ref()

/**
 * For VeeValidate: the parent form provides values and setFieldValue via useForm
 */
const modelValue = defineModel<string | undefined>("modelValue")

const value = computed({
    get: () => modelValue.value ? parseDate(modelValue.value) : undefined,
    set: (val) => {
        modelValue.value = val ? val.toString() : undefined
    },
})
</script>

<template>
    <FormField :name="name">
        <FormItem class="flex flex-col">
            <FormLabel>{{ label }}</FormLabel>
            <Popover>
                <PopoverTrigger as-child>
                    <FormControl>
                        <Button variant="outline" class="w-full" :class="cn(
                            'ps-3 text-start font-normal',
                            !value && 'text-muted-foreground',
                        )">
                            <span>{{ value ? df.format(toDate(value)) : placeholderText }}</span>
                            <CalendarIcon class="ms-auto h-4 w-4 opacity-50" />
                        </Button>
                        <input hidden>
                    </FormControl>
                </PopoverTrigger>
                <PopoverContent class="w-auto p-0" v-if="isSelectMY">
                    <CalendarMonthYear v-model:placeholder="placeholder" :model-value="value" :min-value="minDate"
                        :max-value="maxDate" initial-focus @update:model-value="v => value = v" />
                </PopoverContent>
                <PopoverContent class="w-auto p-0" v-else>
                    <Calendar v-model:placeholder="placeholder" :model-value="value" :min-value="minDate"
                        :max-value="maxDate" initial-focus @update:model-value="v => value = v" />
                </PopoverContent>
            </Popover>
            <FormDescription v-if="description">
                {{ description }}
            </FormDescription>
            <FormMessage />
        </FormItem>
    </FormField>
</template>
