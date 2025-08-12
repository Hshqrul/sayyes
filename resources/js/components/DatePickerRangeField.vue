<script setup lang="ts">
import type { DateRange } from "reka-ui"

import {
    CalendarDate,
    DateFormatter,
    getLocalTimeZone,
} from "@internationalized/date"
import { CalendarIcon } from "lucide-vue-next"
import { computed } from "vue"
import { cn } from "@/lib/utils"
import { Button } from "@/components/ui/button"
import {
    FormControl,
    FormDescription,
    FormField,
    FormItem,
    FormLabel,
    FormMessage,
} from "@/components/ui/form"
import { Popover, PopoverContent, PopoverTrigger } from "@/components/ui/popover"
import { RangeCalendar } from "@/components/ui/range-calendar"

type Props = {
    startName: string
    endName: string
    label?: string
    description?: string
    placeholderText?: string
    minDate?: CalendarDate
    maxDate?: CalendarDate
}

const props = withDefaults(defineProps<Props>(), {
    label: "Select date range",
    placeholderText: "Pick a date range",
})

const df = new DateFormatter("en-US", { dateStyle: "medium" })

// Bind both fields from the parent form
const startModel = defineModel<string | undefined>("startDate")
const endModel = defineModel<string | undefined>("endDate")

// Computed range for <RangeCalendar>
const rangeValue = computed<DateRange | undefined>({
    get: () => {
        if (!startModel.value) return undefined
        return {
            // start: CalendarDate.fromString(startModel.value),
            // end: endModel.value ? CalendarDate.fromString(endModel.value) : undefined,
        }
    },
    set: (val) => {
        startModel.value = val?.start ? val.start.toString() : undefined
        endModel.value = val?.end ? val.end.toString() : undefined
    }
})

// Display formatted range text
const displayValue = computed(() => {
    if (!rangeValue.value?.start) return props.placeholderText
    const start = df.format(rangeValue.value.start.toDate(getLocalTimeZone()))
    if (rangeValue.value.end) {
        const end = df.format(rangeValue.value.end.toDate(getLocalTimeZone()))
        return `${start} - ${end}`
    }
    return start
})
</script>

<template>
    <FormItem class="flex flex-col">
        <FormLabel>{{ label }}</FormLabel>
        <Popover>
            <PopoverTrigger as-child>
                <FormControl>
                    <Button variant="outline" :class="cn(
                        'w-[280px] justify-start text-left font-normal',
                        !rangeValue?.start && 'text-muted-foreground',
                    )">
                        <CalendarIcon class="mr-2 h-4 w-4" />
                        {{ displayValue }}
                    </Button>
                </FormControl>
            </PopoverTrigger>
            <PopoverContent class="w-auto p-0">
                <RangeCalendar v-model="rangeValue" :min-value="minDate" :max-value="maxDate" initial-focus
                    :number-of-months="2" />
            </PopoverContent>
        </Popover>
        <FormDescription v-if="description">
            {{ description }}
        </FormDescription>
        <!-- Individual messages for each field -->
        <FormMessage :name="props.startName" />
        <FormMessage :name="props.endName" />
    </FormItem>
</template>
