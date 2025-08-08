<script setup lang="ts">
import { toTypedSchema } from "@vee-validate/zod"
import { Check, Circle, Dot } from "lucide-vue-next"
import { ref } from "vue"
import * as z from "zod"
import { Button } from "@/components/ui/button"
import { Form, FormControl, FormField, FormItem, FormLabel, FormMessage } from "@/components/ui/form"
import { Input } from "@/components/ui/input"
import { Stepper, StepperDescription, StepperItem, StepperSeparator, StepperTitle, StepperTrigger } from "@/components/ui/stepper"
import { toast } from "vue-sonner"
import AppSidebarLayout from "@/layouts/app/AppSidebarLayout.vue"
import { Head } from "@inertiajs/vue3"
import { BreadcrumbItem } from "@/types"
import Heading from "@/components/Heading.vue"
import Card from "@/components/ui/card/Card.vue"
import CardContent from "@/components/ui/card/CardContent.vue"
import Textarea from "@/components/ui/textarea/Textarea.vue"
import { useForm as useVeeForm } from "vee-validate"
import { router } from "@inertiajs/vue3"

const formSchema = [
    z.object({
        event_name: z.string().min(1).max(255),
        description: z.string().nullable(),
    }),
    z.object({
        event_date: z.string().min(1, "Please pick a date"),
    }),
    z.object({
        allowed_pax: z.number().min(1).nullable(),
    })
]

const stepIndex = ref(1)

const steps = [
    { step: 1, title: "Basic Info", description: "Event name & description" },
    { step: 2, title: "Dates", description: "Event date" },
    { step: 3, title: "Pax", description: "Allowed pax" },
]


const { handleSubmit, setFieldValue, values } = useVeeForm({
    validationSchema: toTypedSchema(formSchema[stepIndex.value - 1]),
    initialValues: {
        event_name: "",
        description: "",
        event_date: "",
        allowed_pax: null,
    },
})


function onSubmit(values: any) {
    router.post(route('events.store'), values, {
        onSuccess: () => {
            toast({
                title: "Event successfully created!",
                description: ""
            })
        },
        onError: (errors) => {
            toast({
                title: "Please fix the errors in the form.",
                description: ""
            })
        }
    })
}
</script>

<template>
    <AppSidebarLayout
        :breadcrumbs="[{ title: 'Event List', href: '/events' }, { title: 'Create Event', href: '/events/create' }]">

        <Head title="Create Event" />

        <div class="flex flex-col px-6 py-4">
            <Heading :title="`${steps[stepIndex - 1].title}`" :description="`${steps[stepIndex - 1].description}`" />

            <Card class="px-6 py-12 shadow-xs">
                <CardContent>
                    <!-- <section class="w-full"> -->
                    <Form v-slot="{ meta, values, validate }" as="" keep-values
                        :validation-schema="toTypedSchema(formSchema[stepIndex - 1])">
                        <Stepper v-slot="{ isNextDisabled, isPrevDisabled, nextStep, prevStep }" v-model="stepIndex"
                            class="block w-full">
                            <form @submit="(e) => {
                                e.preventDefault()
                                validate()

                                // console.log(values)
                                if (stepIndex === steps.length && meta.valid) {
                                    // console.log(values)
                                    onSubmit(values)
                                }
                            }" class="flex flex-col gap-6">
                                <div class="flex w-full flex-start gap-2">
                                    <StepperItem v-for="step in steps" :key="step.step" v-slot="{ state }"
                                        class="relative flex w-full flex-col items-center justify-center"
                                        :step="step.step">
                                        <StepperSeparator v-if="step.step !== steps[steps.length - 1].step"
                                            class="absolute left-[calc(50%+20px)] right-[calc(-50%+10px)] top-5 block h-0.5 shrink-0 rounded-full bg-muted group-data-[state=completed]:bg-primary" />

                                        <StepperTrigger as-child>
                                            <Button
                                                :variant="state === 'completed' || state === 'active' ? 'default' : 'outline'"
                                                size="icon" class="z-10 rounded-full shrink-0"
                                                :class="[state === 'active' && 'ring-2 ring-ring ring-offset-2 ring-offset-background']"
                                                :disabled="state !== 'completed' && !meta.valid">
                                                <Check v-if="state === 'completed'" class="size-5" />
                                                <Circle v-if="state === 'active'" />
                                                <Dot v-if="state === 'inactive'" />
                                            </Button>
                                        </StepperTrigger>

                                        <div class="mt-5 flex flex-col items-center text-center">
                                            <StepperTitle :class="[state === 'active' && 'text-primary']"
                                                class="text-sm font-semibold transition lg:text-base">
                                                {{ step.title }}
                                            </StepperTitle>
                                            <StepperDescription :class="[state === 'active' && 'text-primary']"
                                                class="sr-only text-xs text-muted-foreground transition md:not-sr-only lg:text-sm">
                                                {{ step.description }}
                                            </StepperDescription>
                                        </div>
                                    </StepperItem>
                                </div>

                                <div class="flex flex-col gap-4 mt-4">
                                    <template v-if="stepIndex === 1">
                                        <FormField v-slot="{ componentField }" name="event_name">
                                            <FormItem>
                                                <FormLabel>Event Name</FormLabel>
                                                <FormControl>
                                                    <Input type="text" v-bind="componentField"
                                                        placeholder="Your event name" />
                                                </FormControl>
                                                <FormMessage />
                                            </FormItem>
                                        </FormField>

                                        <FormField v-slot="{ componentField }" name="description">
                                            <FormItem>
                                                <FormLabel>Description</FormLabel>
                                                <FormControl>
                                                    <Textarea type="text" v-bind="componentField"
                                                        placeholder="Your event description" />
                                                </FormControl>
                                                <FormMessage />
                                            </FormItem>
                                        </FormField>
                                    </template>

                                    <template v-if="stepIndex === 2">
                                        <FormField v-slot="{ componentField }" name="event_date">
                                            <FormItem>
                                                <FormLabel>Event Date</FormLabel>
                                                <FormControl>
                                                    <Input type="date" v-bind="componentField" />
                                                    <!-- <Popover>
                                                        <PopoverTrigger as-child>
                                                            <FormControl>
                                                                <Button variant="outline" :class="cn(
                                                                    'w-[240px] ps-3 text-start font-normal w-full',
                                                                    !calendarValue && 'text-muted-foreground'
                                                                )">
                                                                    <span>
                                                                        {{ calendarValue ?
                                                                            df.format(toDate(calendarValue)) : "Pick a date"
                                                                        }}
                                                                    </span>
                                                                    <CalendarIcon class="ms-auto h-4 w-4 opacity-50" />
                                                                </Button>
                                                                <Input type="date" v-bind="componentField" />
                                                            </FormControl>
                                                        </PopoverTrigger>
                                                        <PopoverContent class="w-auto p-0">
                                                            <Calendar :model-value="calendarValue"
                                                                calendar-label="Date of Event" initial-focus
                                                                @update:model-value="(v) => {
                                                                    if (v) {
                                                                        calendarValue = v
                                                                        const iso = v.toString()
                                                                        componentField.value = iso
                                                                        setFieldValue('event_date', iso)
                                                                    }
                                                                }" />
                                                        </PopoverContent>
                                                    </Popover> -->
                                                </FormControl>
                                                <FormMessage />
                                            </FormItem>
                                        </FormField>

                                    </template>

                                    <template v-if="stepIndex === 3">
                                        <FormField v-slot="{ componentField }" name="allowed_pax">
                                            <FormItem>
                                                <FormLabel>Allowed pax</FormLabel>
                                                <FormControl>
                                                    <Input type="number" v-bind="componentField" />
                                                </FormControl>
                                                <FormMessage />
                                            </FormItem>
                                        </FormField>
                                    </template>
                                </div>

                                <div class="flex items-center justify-between mt-4">
                                    <Button :disabled="isPrevDisabled" variant="outline" size="sm" @click="prevStep()">
                                        Back
                                    </Button>
                                    <div class="flex items-center gap-3">
                                        <Button v-if="stepIndex !== 3" :type="meta.valid ? 'button' : 'submit'"
                                            :disabled="isNextDisabled" size="sm" @click="meta.valid && nextStep()">
                                            Next
                                        </Button>
                                        <Button v-if="stepIndex === 3" size="sm" type="submit">
                                            Submit
                                        </Button>
                                    </div>
                                </div>
                            </form>
                        </Stepper>
                    </Form>
                    <!-- </section> -->
                </CardContent>
            </Card>
        </div>
    </AppSidebarLayout>
</template>