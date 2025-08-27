<script lang="ts" setup>
import { createReusableTemplate, useMediaQuery } from "@vueuse/core"
import { computed, ref } from "vue"
import { Button } from "@/components/ui/button"
import { toast } from "vue-sonner"
import * as yup from "yup"
import { router, useForm, usePage } from "@inertiajs/vue3"
import { AppPageProps } from "@/types"
import InputError from "@/components/InputError.vue"
import Icon from "@/components/Icon.vue"

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
import Label from "@/components/ui/label/Label.vue"
import Input from "@/components/ui/input/Input.vue"
import Textarea from "@/components/ui/textarea/Textarea.vue"
import { TagsInput, TagsInputInput, TagsInputItem, TagsInputItemDelete, TagsInputItemText } from "@/components/ui/tags-input"
import { Combobox, ComboboxAnchor, ComboboxEmpty, ComboboxGroup, ComboboxInput, ComboboxItem, ComboboxList } from "@/components/ui/combobox"
import { useFilter } from "reka-ui"

const page = usePage<AppPageProps>()

const [UseTemplate, ComposeForm] = createReusableTemplate()
const isDesktop = useMediaQuery("(min-width: 768px)")
const isOpen = ref(false)

const form = useForm({
    user_id: page.props.auth.user.id,
    subject: "",
    text: "",
    labels: [],
})

const submitCompose = () => {
    form.post(route('note.store'), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            toast.success('Message submitted successfully!', {
                description: 'Your message has been submitted successfully.'
            })

            router.visit(route('mail.index'), {
                only: ['mails'],
            })

            isOpen.value = false
            form.reset()
        },
    })
}

const modalTitle = 'Compose'
const modalDescription = 'Start a new notes'
</script>

<template>
    <UseTemplate>
        <form @submit.prevent="submitCompose" class="space-y-4 px-4 pt-4 pb-6 md:p-0">
            <div class="space-y-2">
                <Label class="block text-sm font-medium mb-1">Subject</Label>
                <Input type="text" v-model="form.subject" class="w-full border rounded p-2" />
                <InputError name="subject" :message="form.errors.subject" />
            </div>

            <div class="space-y-2">
                <Label class="block text-sm font-medium mb-1">Notes</Label>
                <Textarea v-model="form.text" class="w-full border rounded p-2" rows="5" />
                <InputError name="text" :message="form.errors.text" />
            </div>

            <div class="space-y-2">
                <Label class="block text-sm font-medium mb-1">Labels</Label>
                <TagsInput v-model="form.labels">
                    <TagsInputItem v-for="item in form.labels" :key="item" :value="item">
                        <TagsInputItemText />
                        <TagsInputItemDelete />
                    </TagsInputItem>

                    <TagsInputInput placeholder="Add label" />
                </TagsInput>
                <InputError name="labels" :message="form.errors.labels" />
            </div>

            <input type="hidden" :value="form.user_id" />

            <div class="flex flex-col md:flex-row-reverse gap-2 mt-4">
                <Button type="submit">Send</Button>
                <Button type="button" variant="outline" @click="form.reset()">Reset</Button>
            </div>
        </form>
    </UseTemplate>


    <Dialog v-if="isDesktop" v-model:open="isOpen">
        <DialogTrigger as-child>
            <Button>
                <Icon name="Plus" />
                Compose
            </Button>
        </DialogTrigger>
        <DialogContent class="sm:max-w-2xl">
            <DialogHeader>
                <DialogTitle>{{ modalTitle }}</DialogTitle>
                <DialogDescription>
                    {{ modalDescription }}
                </DialogDescription>
            </DialogHeader>
            <ComposeForm />
        </DialogContent>
    </Dialog>

    <Drawer v-else v-model:open="isOpen">
        <DrawerTrigger as-child>
            <Button>
                <Icon name="Plus" />
                <p class="hidden md:block">
                    Compose
                </p>
            </Button>
        </DrawerTrigger>
        <DrawerContent>
            <DrawerHeader>
                <DrawerTitle>{{ modalTitle }}</DrawerTitle>
                <DrawerDescription>
                    {{ modalDescription }}
                </DrawerDescription>
            </DrawerHeader>
            <ComposeForm />
            <!-- <DrawerFooter>
                <DrawerClose as-child>
                    <Button variant="outline">Cancel</Button>
                </DrawerClose>
            </DrawerFooter> -->
        </DrawerContent>
    </Drawer>
</template>
