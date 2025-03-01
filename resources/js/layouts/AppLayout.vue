<script setup lang="ts">
import AppLayout from '@/layouts/app/AppSidebarLayout.vue';
import type { BreadcrumbItemType } from '@/types';

import { Toaster } from '@/components/ui/sonner'
import { toast } from 'vue-sonner'
import { usePage } from '@inertiajs/vue3';
import { onMounted, computed } from 'vue';

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});

const flashMessage = computed(() => usePage().props.flash);
onMounted(() => {
    if (flashMessage.value) {
        if(flashMessage.value.success) {
            toast.success(flashMessage.value.success)
        }else if(flashMessage.value.error) {
            toast.error(flashMessage.value.error)
        }
    }
});

</script>

<template>

    <AppLayout :breadcrumbs="breadcrumbs">
        <Toaster position="top-center"/>
        <slot />
    </AppLayout>
</template>
