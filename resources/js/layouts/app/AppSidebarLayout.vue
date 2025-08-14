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
    <Toaster closeButton :theme="appearance" position="top-right" />
    <AppShell variant="sidebar">
        <AppSidebar />
        <AppContent variant="sidebar" class="overflow-x-hidden bg-sidebar dark:border">
            <AppSidebarHeader :breadcrumbs="breadcrumbs" />
            <slot />
        </AppContent>
    </AppShell>
</template>
