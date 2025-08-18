<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import Button from '@/components/ui/button/Button.vue';
import { ArrowRight } from 'lucide-vue-next';
import Card from '@/components/ui/card/Card.vue';
import TextGenerateEffect from '@/components/ui/text-generate-effect/TextGenerateEffect.vue';
import FlickeringGrid from '@/components/ui/flickering-grid/FlickeringGrid.vue';

// const sceneUrl = 'https://prod.spline.design/kZDDjO5HuC9GJUM2/scene.splinecode'

// function onError(err: Error) {
//     console.error('Error loading Spline scene', err)
// }

// const breadcrumbs: BreadcrumbItem[] = [
//     {
//         title: 'Dashboard',
//         href: '/',
//     },
// ];

</script>

<template>

    <Head title="Dashboard" />

    <AppLayout>
        <div class="container mx-auto px-4 pb-4">
            <div class="relative grid h-lvh place-content-center overflow-hidden">
                <p
                    class="z-10 whitespace-pre-wrap text-center text-4xl md:text-5xl font-extrabold tracking-tight text-black dark:text-white">
                    <TextGenerateEffect words="Your Journey Starts Here" :delay="0" />
                </p>
                <p class="z-10 text-center text-xl font-semibold tracking-tighter text-muted-foreground mt-2">
                    <TextGenerateEffect words="Get started by signing up." :delay="900" />
                </p>
                <div class="z-10 flex items-end justify-center gap-2 mt-4">
                    <Button variant="default" as-child>
                        <a :href="route('login')">
                            Sign up now!
                            <ArrowRight class="size-4" />
                        </a>
                    </Button>
                </div>
                <!-- <div class="flex flex-col items-center justify-center space-y-4">
                    <HyperText text="Welcome to the Dashboard" class="text-2xl font-black md:text-4xl" :duration="600"
                        :animate-on-load="true" />
                </div> -->

                <!-- <Spline :scene="sceneUrl" @load="() => console.log('Loaded')" @error="onError" /> -->
                <!-- <InteractiveGridPattern :squares="[40, 40]" :width="50" :height="50" :class="[
                    '[mask-image:radial-gradient(400px_circle_at_center,white,transparent)]',
                    'inset-0 h-[200%] skew-y-12',
                ]" /> -->
                <FlickeringGrid
                    class="absolute inset-0 [mask-image:radial-gradient(480px_circle_at_center,white,transparent)]"
                    :square-size="6" :grid-gap="6" color="#64748b" :max-opacity="0.5" :flicker-chance="0.2"
                    :height="1000" />
            </div>
            <div class="grid auto-rows-min gap-4 md:grid-cols-2">
                <Card class="relative aspect-video overflow-hidden">
                    <div class="flex h-full flex-col items-start justify-center px-6 py-4">
                        <h2 class="text-2xl font-bold">Stats Overview</h2>
                        <p class="text-muted-foreground">
                            This is where your stats will be displayed.
                        </p>
                        <PlaceholderPattern />
                    </div>
                </Card>
                <Card class="relative aspect-video overflow-hidden">
                    <div class="flex h-full flex-col items-start justify-center px-6 py-12">
                        <h2 class="text-2xl font-bold">Recent Activity</h2>
                        <p class="text-muted-foreground">
                            This is where your recent activity will be displayed.
                        </p>
                    </div>
                    <PlaceholderPattern />
                </Card>
            </div>
        </div>
    </AppLayout>
</template>
