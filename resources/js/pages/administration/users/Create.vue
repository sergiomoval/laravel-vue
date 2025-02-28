<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import Heading from '@/components/Heading.vue';
import { trans } from 'laravel-vue-i18n';
import { type BreadcrumbItem } from '@/types';
import FormCreate from './partials/FormCreate.vue';
import FormInvite from './partials/FormInvite.vue';
import {
  Tabs,
  TabsContent,
  TabsList,
  TabsTrigger,
} from '@/components/ui/tabs'


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: trans('Users'),
        href: route('administration.users.index'),
    },
    {
        title: trans('New :object', { object: trans('User')}),
        href: '/users',
    },
];

const props = defineProps<{
    roles: any;
}>();



</script>

<template>
    <Head :title="$t('New :object', {object: $t('User')})" />
    
    <AppLayout :breadcrumbs="breadcrumbs">
      <div class="px-4 py-6">
        <Heading :title="$t('Users')" description="Manage your profile and account settings" />

        <Tabs default-value="account" class="w-[400px]">
            <TabsList class="grid w-full grid-cols-2">
                <TabsTrigger value="account">{{ $t('Register :object', { object: $t('User') }) }}</TabsTrigger>
                <TabsTrigger value="password">{{ $t('Invite') }}</TabsTrigger>
            </TabsList>
            <TabsContent value="account">
                <FormCreate :roles="props.roles" />
            </TabsContent>
            <TabsContent value="password">
                <FormInvite :roles="props.roles" />
            </TabsContent>
        </Tabs>

      </div> 

    </AppLayout>
</template>