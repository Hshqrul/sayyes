<script setup lang="ts">
import { Minus, Plus } from "lucide-vue-next"
import { ref, h } from "vue"
import { Button } from "@/components/ui/button"
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

const goal = ref(0)
const step = 1
const minGoal = 0
const maxGoal = 400

const increaseGoal = () => {
    if (goal.value + step <= maxGoal) {
        goal.value += step
    }
}

const decreaseGoal = () => {
    if (goal.value - step >= minGoal) {
        goal.value -= step
    }
}

const submitGoal = () => {
    toast.success('Goal submitted', {
        description: `Your goal is ${goal.value} calories/day`
    })
}
</script>

<template>
    <Drawer>
        <DrawerTrigger as-child>
            <Button>
                <Plus class="size-4" />
                <p class="hidden md:block">
                    New Compose
                </p>
            </Button>
        </DrawerTrigger>
        <DrawerContent>
            <div class="mx-auto w-full max-w-sm">
                <DrawerHeader>
                    <DrawerTitle>Move Goal</DrawerTitle>
                    <DrawerDescription>Set your daily activity goal.</DrawerDescription>
                </DrawerHeader>

                <div class="p-4 pb-0">
                    <div class="flex items-center justify-center space-x-2">
                        <Button variant="outline" size="icon" class="h-8 w-8 shrink-0 rounded-full"
                            :disabled="goal <= minGoal" @click="decreaseGoal">
                            <Minus class="h-4 w-4" />
                            <span class="sr-only">Decrease</span>
                        </Button>

                        <div class="flex-1 text-center">
                            <div class="text-7xl font-bold tracking-tighter">
                                {{ goal }}
                            </div>
                            <div class="text-[0.70rem] uppercase text-muted-foreground">
                                Calories/day
                            </div>
                        </div>

                        <Button variant="outline" size="icon" class="h-8 w-8 shrink-0 rounded-full"
                            :disabled="goal >= maxGoal" @click="increaseGoal">
                            <Plus class="h-4 w-4" />
                            <span class="sr-only">Increase</span>
                        </Button>
                    </div>
                </div>

                <DrawerFooter>
                    <Button @click="submitGoal">Submit</Button>
                    <DrawerClose as-child>
                        <Button variant="outline">Cancel</Button>
                    </DrawerClose>
                </DrawerFooter>
            </div>
        </DrawerContent>
    </Drawer>
</template>
