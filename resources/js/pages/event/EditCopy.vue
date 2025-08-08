<script setup lang="ts">
import { ref, watch } from "vue"
import { useForm as useVeeForm } from "vee-validate"
import { toTypedSchema } from "@vee-validate/zod"
import * as z from "zod"
import { router, Head } from "@inertiajs/vue3"
import { toast } from "vue-sonner"
import { Check, Circle, Dot } from "lucide-vue-next"

import AppSidebarLayout from "@/layouts/app/AppSidebarLayout.vue"
import Heading from "@/components/Heading.vue"
import Card from "@/components/ui/card/Card.vue"
import CardContent from "@/components/ui/card/CardContent.vue"
import { Button } from "@/components/ui/button"
import { Input } from "@/components/ui/input"
import Textarea from "@/components/ui/textarea/Textarea.vue"
import {
    Form,
    FormControl,
    FormField,
    FormItem,
    FormLabel,
    FormMessage
} from "@/components/ui/form"
import {
    Stepper,
    StepperDescription,
    StepperItem,
    StepperSeparator,
    StepperTitle,
    StepperTrigger
} from "@/components/ui/stepper"

interface Event {
    id: number
    event_name: string
    description: string | null
    event_date: string
    allowed_pax: number | null
}

const props = defineProps<{ event: Event }>()

const stepIndex = ref(1)

const steps = [
    { step: 1, title: "Basic Info", description: "Event name & description" },
    { step: 2, title: "Dates", description: "Event date" },
    { step: 3, title: "Pax", description: "Allowed pax" }
]

const fullSchema = z.object({
    event_name: z.string().min(1, "Event name is required"),
    description: z.string().nullable(),
    event_date: z.string().min(1, "Please pick a date"),
    allowed_pax: z
        .number({ invalid_type_error: "Must be a number" })
        .min(1, "At least 1 pax required")
        .nullable()
})

const { handleSubmit, values, meta, validate } = useVeeForm({
    validationSchema: toTypedSchema(fullSchema),
    initialValues: {
        event_name: props.event.event_name,
        description: props.event.description,
        event_date: props.event.event_date.split("T")[0],
        allowed_pax: props.event.allowed_pax
    }
})

// auto-validate on step change
watch(stepIndex, () => {
    validate()
})

const onSubmit = handleSubmit((formData) => {
    router.put(route("events.update", props.event.id), formData, {
        preserveScroll: true,
        onSuccess: () => toast.success("Event successfully updated!"),
        onError: () => toast.error("Please fix the errors and try again.")
    })
})
</script>

<template>
    <AppSidebarLayout :breadcrumbs="[{ title: 'Edit Event', href: `/events/${props.event.id}/edit` }]">

        <Head title="Edit Event" />

        <div class="flex flex-col px-6 py-4">
            <Heading :title="steps[stepIndex - 1].title" :description="steps[stepIndex - 1].description" />

            <Card class="px-6 py-12 shadow-xs">
                <CardContent>
                    <Form :validation-schema="toTypedSchema(fullSchema)">
                        <Stepper v-slot="{ isNextDisabled, isPrevDisabled, nextStep, prevStep }" v-model="stepIndex"
                            class="block w-full">
                            <form @submit.prevent="() => {
                                if (stepIndex === steps.length) {
                                    onSubmit()
                                }
                            }" class="flex flex-col gap-6">
                                <!-- Stepper UI -->
                                <div class="flex w-full flex-start gap-2">
                                    <StepperItem v-for="step in steps" :key="step.step" :step="step.step"
                                        v-slot="{ state }"
                                        class="relative flex w-full flex-col items-center justify-center">
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

                                <!-- Step Content -->
                                <div class="flex flex-col gap-4 mt-4">
                                    <template v-if="stepIndex === 1">
                                        <FormField name="event_name" v-slot="{ componentField }">
                                            <FormItem>
                                                <FormLabel>Event Name</FormLabel>
                                                <FormControl>
                                                    <Input type="text" v-bind="componentField" />
                                                </FormControl>
                                                <FormMessage />
                                            </FormItem>
                                        </FormField>

                                        <FormField name="description" v-slot="{ componentField }">
                                            <FormItem>
                                                <FormLabel>Description</FormLabel>
                                                <FormControl>
                                                    <Textarea v-bind="componentField" />
                                                </FormControl>
                                                <FormMessage />
                                            </FormItem>
                                        </FormField>
                                    </template>

                                    <template v-if="stepIndex === 2">
                                        <FormField name="event_date" v-slot="{ componentField }">
                                            <FormItem>
                                                <FormLabel>Event Date</FormLabel>
                                                <FormControl>
                                                    <Input type="date" v-bind="componentField" />
                                                </FormControl>
                                                <FormMessage />
                                            </FormItem>
                                        </FormField>
                                    </template>

                                    <template v-if="stepIndex === 3">
                                        <FormField name="allowed_pax" v-slot="{ componentField }">
                                            <FormItem>
                                                <FormLabel>Allowed Pax</FormLabel>
                                                <FormControl>
                                                    <Input type="number" v-bind="componentField" />
                                                </FormControl>
                                                <FormMessage />
                                            </FormItem>
                                        </FormField>
                                    </template>
                                </div>

                                <!-- Navigation Buttons -->
                                <div class="flex items-center justify-between mt-4">
                                    <Button :disabled="isPrevDisabled" variant="outline" size="sm"
                                        @click="prevStep()">Back</Button>
                                    <div class="flex items-center gap-3">
                                        <Button v-if="stepIndex !== steps.length" :disabled="isNextDisabled"
                                            type="button" size="sm"
                                            @click="validate().then(result => result.valid && nextStep())">
                                            Next
                                        </Button>
                                        <Button v-if="stepIndex === steps.length" size="sm"
                                            type="submit">Submit</Button>
                                    </div>
                                </div>
                            </form>
                        </Stepper>
                    </Form>
                </CardContent>
            </Card>
        </div>
    </AppSidebarLayout>
</template>
