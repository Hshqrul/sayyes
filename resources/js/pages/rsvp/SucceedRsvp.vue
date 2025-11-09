<script setup lang="ts">
import { computed, onMounted } from 'vue'
import { Head, useForm, usePage } from '@inertiajs/vue3'
import AppLayout from '@/layouts/widget/FormCardLayout.vue'
import Alert from '@/components/ui/alert/Alert.vue'
import AlertTitle from '@/components/ui/alert/AlertTitle.vue'
import AlertDescription from '@/components/ui/alert/AlertDescription.vue'
import { BadgeCheck, Moon, Sparkles } from 'lucide-vue-next'
import moment from 'moment';
import TextLink from '@/components/TextLink.vue'
import { Toaster, toast } from 'vue-sonner'
import 'vue-sonner/style.css'
import { useAppearance } from '@/composables/useAppearance'
import ListParticipants from './ListParticipants.vue'
import RsvpCard from '@/components/ui/marquee/RsvpCard.vue'

const page = usePage()
console.log(page.props)
const toastMethods = {
    success: toast.success,
    error: toast.error,
    warning: toast.warning,
    info: toast.info,
    message: toast.message
} as const

onMounted(() => {
    const toastData = page.props.flash?.toast
    if (toastData?.title && toastData.type in toastMethods) {
        toastMethods[toastData.type as keyof typeof toastMethods](
            toastData.title,
            { description: toastData.description ?? '' }
        )
    }
})

const { appearance } = useAppearance()

interface Rsvp {
    name: string;
    attendence: boolean;
    no_of_pax: number;
    notes: string;
    created_at: string;
    event_id: number;
}

interface Props {
    rsvp: Rsvp,
    rsvps: Rsvp[],
    event: {
        id: number;
        event_name: string;
        description: string;
        slug: string;
    };
}

const props = defineProps<Props>();
const limitedRsvps = computed(() => props.rsvps.slice(0, 5))

const currentForm = useForm({
    name: props.rsvp.name,
    attendence: props.rsvp.attendence,
    no_of_pax: props.rsvp.no_of_pax,
    notes: props.rsvp.notes,
    created_at: props.rsvp.created_at,
    event_id: props.rsvp.event_id
});
</script>

<template>
    <Toaster closeButton :theme="appearance" />

    <Head title="Success Response" />
    <AppLayout :title="event.event_name" :description="event.description">
        <Alert :class="{
            'bg-indigo-300/20 border-indigo-700 text-indigo-600 dark:bg-indigo-700/20 dark:border-indigo-600 dark:text-indigo-400':
                currentForm.attendence == true,
            'bg-gray-300/20 border-gray-700 text-gray-600 dark:bg-gray-700/20 dark:border-gray-600 dark:text-gray-400':
                currentForm.attendence == false,
        }">
            <Sparkles />
            <AlertTitle>Thank you for your response {{ currentForm.name }}!</AlertTitle>
            <AlertDescription class="space-y-2">
                {{ currentForm.attendence ? `We are so excited to see you${currentForm.no_of_pax > 1 ? ', both of you!'
                    : (', ' + currentForm.name)} 👋` : 'We really hope that you are coming. ☹️' }}
            </AlertDescription>
        </Alert>
        <div class="flex flex-col gap-4 mb-4">
            <div class="border-b border-sidebar-border/70"></div>
            <div class="flex flex-row items-center justify-between">
                <h1 class="text-xl font-extrabold tracking-tight lg:text-2xl">Guests Book</h1>
                <ListParticipants :rsvps="props.rsvps" />
            </div>
            <div class="border-b border-sidebar-border/70"></div>
            <div class="grid grid-cols-1 gap-4 overflow-y-auto max-h-[300px] pr-2">
                <RsvpCard v-for="(rsvp, index) in limitedRsvps" :key="index" :name="rsvp.name"
                    :body="rsvp.notes || `No message left`" :attendance="rsvp.attendence" :no_of_pax="rsvp.no_of_pax"
                    :created_at="rsvp.created_at" />
                <!-- <template v-for="(rsvps, index) in limitedRsvps" :key="index">
                    <Alert :class="{
                        'bg-indigo-300/20 border-indigo-700 text-indigo-600 dark:bg-indigo-700/20 dark:border-indigo-600 dark:text-indigo-400':
                            rsvps.attendence == true,
                        'bg-yellow-300/20 border-yellow-700 text-yellow-600 dark:bg-yellow-700/20 dark:border-yellow-600 dark:text-yellow-400':
                            rsvps.attendence == false,
                    }">
                        <AlertDescription class="pt-2 pb-2">
                            <p class="italic text-md" :class="{
                                'text-indigo-600 dark:text-indigo-400':
                                    rsvps.attendence == true,
                                'text-yellow-600 dark:text-yellow-400':
                                    rsvps.attendence == false,
                            }">
                                "{{ rsvps.notes }}"
                            </p>
                        </AlertDescription>
                        <AlertTitle>
                            <div class="flex items-center text-xs text-gray-800 dark:text-gray-200 gap-1">
                                {{ rsvps.name }}
                                <component :is="rsvps.attendence == true ? BadgeCheck : Moon"
                                    :class="rsvps.attendence == true ? 'text-green-500' : 'text-gray-500'"
                                    class="h-3 w-3 flex shrink-0" aria-hidden="true" />
                            </div>
                        </AlertTitle>
                        <AlertTitle class="text-muted-foreground dark:text-muted-foreground/80 text-xs">
                            {{ moment(rsvps?.created_at).startOf('hour').fromNow() }}
                        </AlertTitle>
                    </Alert>
                </template> -->
            </div>
        </div>
        <div class="text-center text-sm text-muted-foreground">
            See more guest book
            <TextLink :href="route('guest_wishes', { event: props.event })">
                here
            </TextLink>
        </div>
    </AppLayout>
</template>
