<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import Button from '@/components/ui/button/Button.vue';
import { ArrowRight } from 'lucide-vue-next';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/',
    },
];

</script>

<template>
    <Head title="Dashboard" />

    <AppLayout>
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
            <div class="grid auto-rows-min gap-4 md:grid-cols-2">
                <div
                    class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <div class="flex h-full flex-col items-start justify-center px-6 py-4">
                        <h1 class="text-4xl font-extrabold tracking-tight lg:text-5xl">
                            Welcome to the Dashboard
                        </h1>
                        <p class="mt-2 text-muted-foreground">
                            Manage your profile and account settings from here.
                        </p>
                        <div class="flex items-end gap-2 mt-4">
                            <Button variant="default" class="w-full" as-child>
                                <a :href="route('login')">
                                    Sign up now!
                                    <ArrowRight class="size-4" />
                                </a>
                            </Button>
                        </div>
                    </div>
                </div>
                <div
                    class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <div class="flex h-full flex-col items-start justify-center px-6 py-12">
                        <h2 class="text-2xl font-bold">Recent Activity</h2>
                        <p class="text-muted-foreground">
                            This is where your recent activity will be displayed.
                        </p>
                    </div>
                    <PlaceholderPattern />
                </div>
            </div>
            <!-- <div
                class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                <FormRsvp />
            </div> -->
            <div
                class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
                    <h2 class="text-center text-2xl font-bold">Dashboard Content</h2>
                    <p class="text-center text-muted-foreground">
                        This is where your dashboard content will go.
                    </p>
                </div>
                <PlaceholderPattern />
            </div>
        </div>
    </AppLayout>
</template>
