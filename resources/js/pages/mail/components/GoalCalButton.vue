<script lang="ts" setup>
import { createReusableTemplate, useMediaQuery } from "@vueuse/core"
import { ref, watch } from "vue"
import { Button } from "@/components/ui/button"
import { Minus, Plus } from "lucide-vue-next"
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from "@/components/ui/dialog"
import {
    Drawer,
    DrawerClose,
    DrawerContent,
    DrawerDescription,
    DrawerFooter,
    DrawerHeader,
    DrawerTitle,
    DrawerTrigger,
} from "@/components/ui/drawer"
import { toast } from "vue-sonner"
import { useForm } from "vee-validate"
import InputError from "@/components/InputError.vue"
import Icon from "@/components/Icon.vue"

const step = 1
const minGoal = 1
const maxGoal = 400

const [UseTemplate, GoalForm] = createReusableTemplate()
const isDesktop = useMediaQuery("(min-width: 768px)")
const isOpen = ref(false)

const form = useForm({
    initialValues: {
        goal_number: 0,
    },
})

const goal = ref(form.values.goal_number)
watch(goal, (val) => {
    form.setFieldValue("goal_number", val)
})

const increaseGoal = () => {
    if (goal.value + step <= maxGoal) goal.value += step
}
const decreaseGoal = () => {
    if (goal.value - step >= minGoal) goal.value -= step
}
const resetGoal = () => {
    goal.value = minGoal
    form.resetForm({ values: { goal_number: minGoal } })
}
const submitGoal = form.handleSubmit(
    async (values) => {
        toast.success("Goal submitted", {
            description: `Your goal is ${values.goal_number} calories/day`,
        })
        isOpen.value = false
    },
    () => {
        toast.error("Submission failed", {
            description: "Please check your inputs and try again.",
        })
    }
)
</script>

<template>
    <!-- Reusable Form -->
    <UseTemplate>
        <form @submit.prevent="submitGoal" class="p-4">
            <div class="flex items-center justify-center space-x-2">
                <Button variant="outline" size="icon" class="h-8 w-8 rounded-full" :disabled="goal <= minGoal"
                    @click.prevent="decreaseGoal">
                    <Minus class="h-4 w-4" />
                    <span class="sr-only">Decrease</span>
                </Button>

                <div class="flex-1 text-center">
                    <input type="number" disabled v-model="goal" :min="minGoal" :max="maxGoal"
                        class="text-7xl font-bold tracking-tighter text-center w-full" />
                    <InputError name="goal_number" />
                    <div class="text-[0.70rem] uppercase text-muted-foreground">
                        Calories/day
                    </div>
                </div>

                <Button variant="outline" size="icon" class="h-8 w-8 rounded-full" :disabled="goal >= maxGoal"
                    @click.prevent="increaseGoal">
                    <Plus class="h-4 w-4" />
                    <span class="sr-only">Increase</span>
                </Button>
            </div>
            <div class="flex flex-col justify-center gap-2 mt-4">
                <Button type="submit">Submit</Button>
                <Button type="button" variant="outline" @click="resetGoal">Reset</Button>
            </div>

        </form>
    </UseTemplate>

    <!-- Desktop Dialog -->
    <Dialog v-if="isDesktop" v-model:open="isOpen">
        <DialogTrigger as-child>
            <Button>
                <Icon name="Plus" />
                Create Compose
            </Button>
        </DialogTrigger>
        <DialogContent class="sm:max-w-[425px]">
            <DialogHeader>
                <DialogTitle>Move Goal</DialogTitle>
                <DialogDescription>
                    Set your daily activity goal.
                </DialogDescription>
            </DialogHeader>
            <GoalForm />
        </DialogContent>
    </Dialog>

    <!-- Mobile Drawer -->
    <Drawer v-else v-model:open="isOpen">
        <DrawerTrigger as-child>
            <Button>
                <Icon name="Plus" />
                <p class="hidden md:block">
                    Create Compose
                </p>
            </Button>
        </DrawerTrigger>
        <DrawerContent>
            <DrawerHeader>
                <DrawerTitle>Move Goal</DrawerTitle>
                <DrawerDescription>
                    Set your daily activity goal.
                </DrawerDescription>
            </DrawerHeader>
            <GoalForm />
            <DrawerFooter>
                <DrawerClose as-child>
                    <Button variant="outline">Cancel</Button>
                </DrawerClose>
            </DrawerFooter>
        </DrawerContent>
    </Drawer>
</template>
