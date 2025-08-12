<script setup lang="ts">
import AppContent from '@/components/AppContent.vue';
import AppShell from '@/components/AppShell.vue';
import AppSidebar from '@/components/AppSidebar.vue';
import AppSidebarHeader from '@/components/AppSidebarHeader.vue';
import { useAppearance } from '@/composables/useAppearance';
import type { BreadcrumbItemType } from '@/types';
import { usePage } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import { Toaster, toast } from 'vue-sonner';
import 'vue-sonner/style.css';

const page = usePage()

const toastMethods = {
    success: toast.success,
    error: toast.error,
    warning: toast.warning,
    info: toast.info,
    message: toast.message
} as const

onMounted(() => {
    const toastData = page.props.flash?.toast
    console.log(page.props)
    if (toastData?.title && toastData.type in toastMethods) {
        toastMethods[toastData.type as keyof typeof toastMethods](
            toastData.title,
            { description: toastData.description ?? '' }
        )
    }
})

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});

const { appearance } = useAppearance()
</script>
<!-- old no bg-sidebar -->
<template>
    <!-- richColors -->
    <Toaster closeButton :theme="appearance" /> 
    <AppShell variant="sidebar">
        <AppSidebar />
        <AppContent variant="sidebar" class="overflow-x-hidden bg-sidebar">
            <AppSidebarHeader :breadcrumbs="breadcrumbs" />
            <slot />
        </AppContent>
    </AppShell>
    <!-- <footer
        class="bottom-0 w-full text-sm mx-auto flex items-center justify-between sm:px-16 py-1.5 md:flex-row flex flex-col gap-2 md:gap-0">
        <div class="flex items-center gap-2">
            <div class="flex items-center gap-1">
                <span>
                    &copy; {{ new Date().getFullYear() }} <span class="font-semibold">{{ page.props.name }}</span>
                </span>
            </div>
            <span> · </span>
            <div class="flex items-center gap-1">
                <span class="rounded-sm italic">
                    Built with
                    <svg class="inline-block h-4 w-4 text-red-500" fill="currentColor" viewBox="0 0 24 24"
                        aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"
                            clip-rule="evenodd" />
                    </svg>
                    by
                    <TextLink href="https://buymeacoffee.com/hashaqirul">Hashaqirul.</TextLink>
                </span>
            </div>
        </div>
    </footer> -->
</template>
