<script setup lang="ts">
import { defineProps, computed, ref, onMounted } from 'vue'
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card'
import { Button } from '@/components/ui/button'
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuGroup,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuPortal,
    DropdownMenuSeparator,
    DropdownMenuShortcut,
    DropdownMenuSub,
    DropdownMenuSubContent,
    DropdownMenuSubTrigger,
    DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu"
import AppSidebarLayout from '@/layouts/app/AppSidebarLayout.vue';
import { EllipsisIcon, PencilIcon, Plus, SquareArrowOutUpRightIcon, TimerIcon, Trash2Icon } from 'lucide-vue-next';
import { UserGroupIcon } from '@heroicons/vue/24/outline';
import CardAction from '@/components/ui/card/CardAction.vue';
import moment from 'moment';
import CardFooter from '@/components/ui/card/CardFooter.vue';
import { Link, router, usePage } from '@inertiajs/vue3';
import Skeleton from '@/components/ui/skeleton/Skeleton.vue';
import { toast } from 'vue-sonner';

const props = defineProps<{
    events: {
        id: number
        event_name: string
        slug: string
        description: string
        event_date: string
        created_at: string
        updated_at: string
        rsvps?: any[]
    }[]
}>()

const hasEvents = computed(() => props.events.length > 0)
const page = usePage();

const loading = ref(true)
onMounted(() => {
    setTimeout(() => {
        loading.value = false
    }, 1000)
})

function confirmDelete(eventSlug: string) {
    const eventDelete = props.events.find(event => event.slug === eventSlug);

    if (eventDelete?.rsvps?.length) {
        toast.warning('Unable to delete the event.', {
            description: 'This event has RSVPs.'
        });
    } else if (confirm(`Are you sure you want to delete "${eventDelete?.event_name}"?`)) {
        router.delete(route('events.destroy', { event: eventSlug }), {
            preserveScroll: true,
            onSuccess: () => {
                toast.success('Event deleted successfully.');
            },
            onError: () => {
                toast.error('Failed to delete the event.');
            }
        });
    }
}

</script>

<template>
    <AppSidebarLayout :breadcrumbs="[{ title: 'Event List', href: '/event' }]">
        <div class="flex h-full flex-1 flex-col gap-4 p-4 overflow-x-auto md:p-6">
            <div class="flex flex-row items-center justify-between p-2">
                <h1 class="text-2xl font-bold leading-tight tracking-tight">Event List</h1>
                <div class="flex flex-row gap-2">
                    <Button as-child v-if="props.events.length > 0">
                        <a :href="route('events.create')">
                            <Plus class="size-4" />
                            <p class="hidden md:block">
                                Create Event
                            </p>
                        </a>
                    </Button>
                </div>
            </div>
            <div v-if="loading" class="grid gap-4 md:grid-cols-1 lg:grid-cols-2">
                <Card v-for="n in props.events.length" :key="n" class="md:w-full shadow-xs">
                    <CardHeader class="flex flex-row items-center justify-between">
                        <Skeleton class="w-[200px] h-6 rounded-full" />
                        <Skeleton class="w-5 h-5 rounded" />
                    </CardHeader>
                    <CardContent>
                        <Skeleton class="w-full h-4 rounded mb-2" />
                        <Skeleton class="w-3/4 h-4 rounded" />
                    </CardContent>
                    <CardFooter>
                        <Skeleton class="w-[120px] h-4 rounded" />
                    </CardFooter>
                </Card>
            </div>

            <div v-else-if="hasEvents" class="w-full">
                <div class="grid gap-4 md:grid-cols-1 lg:grid-cols-2">
                    <Card v-for="event in props.events" :key="event.event_name" class="md:w-full shadow-xs">
                        <CardHeader class="flex flex-row items-center justify-between space-y-0">
                            <CardTitle>
                                <h1 class="text-2xl font-bold leading-none tracking-tight">
                                    {{ event.event_name }}
                                </h1>
                            </CardTitle>
                            <CardAction>
                                <DropdownMenu>
                                    <DropdownMenuTrigger :as-child="true">
                                        <Button variant="ghost">
                                            <EllipsisIcon class="size-4" />
                                        </Button>
                                    </DropdownMenuTrigger>
                                    <DropdownMenuContent class="w-50" align="start">
                                        <DropdownMenuGroup>
                                            <DropdownMenuItem :as-child="true">
                                                <Link :href="route('event_rsvp', { event: event.slug })"
                                                    class="block w-full" prefetch as="button">
                                                <SquareArrowOutUpRightIcon class="size-4" />
                                                <span>Open Rsvp</span>
                                                </Link>
                                            </DropdownMenuItem>
                                            <DropdownMenuItem :as-child="true">
                                                <Link :href="route('events.edit', { event: event.slug })"
                                                    class="block w-full" prefetch as="button">
                                                <PencilIcon class="size-4" />
                                                <span>Edit</span>
                                                </Link>
                                            </DropdownMenuItem>
                                            <DropdownMenuItem :as-child="true">
                                                <Link :href="route('rsvps.index', { event: event.slug })"
                                                    class="block w-full" prefetch as="button">
                                                <UserGroupIcon class="size-4" />
                                                <span>Guest List</span>
                                                </Link>
                                            </DropdownMenuItem>
                                        </DropdownMenuGroup>
                                        <DropdownMenuSeparator />
                                        <DropdownMenuGroup>
                                            <DropdownMenuItem :as-child="true">
                                                <!-- <Link :href="route('events.destroy', { event: event.slug })" -->
                                                <button @click="confirmDelete(event.slug)"
                                                    class="block w-full hover:text-red-500" method="delete" as="button">
                                                    <Trash2Icon class="size-4" />
                                                    <span>Delete</span>

                                                </button>
                                                <!-- </Link> -->
                                            </DropdownMenuItem>
                                        </DropdownMenuGroup>
                                    </DropdownMenuContent>
                                </DropdownMenu>
                            </CardAction>
                        </CardHeader>
                        <CardContent>
                            <p class="text-md text-base">{{ event.description }}</p>
                        </CardContent>
                        <CardFooter class="flex flex-row items-center justify-end space-x-2 space-y-0">
                            <TimerIcon class="size-4" />
                            <p class="text-sm text-muted-foreground">
                                {{ moment(event.event_date).format('MMMM D, YYYY') }}
                            </p>
                        </CardFooter>
                    </Card>
                </div>
            </div>

            <div v-else class="flex justify-center items-center h-full">
                <div class="flex flex-col gap-2">
                    <p class="text-center text-xl text-muted-foreground">No events available</p>
                    <Button as-child>
                        <a :href="route('events.create')">
                            <Plus class="size-4" />
                            Create Event
                        </a>
                    </Button>
                </div>
            </div>
        </div>
    </AppSidebarLayout>
</template>