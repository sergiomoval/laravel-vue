<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import Heading from '@/components/Heading.vue';
import { trans } from 'laravel-vue-i18n';
import { type BreadcrumbItem } from '@/types';
import FormEdit from './partials/FormEdit.vue';
import FormDelete from './partials/FormDelete.vue';
import { onMounted, ref } from 'vue';
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
    user: any,
    roles: any
}>();

const action = ref('');

onMounted(() => {
    if(props.user.deleted_at === null){
        action.value = 'DELETE';
    }else{
        action.value = 'RESTORE';
    }
});



</script>

<template>
    <Head :title="$t('New :object', {object: $t('User')})" />
    
    <AppLayout :breadcrumbs="breadcrumbs">
      <div class="px-4 py-6">
        <Heading :title="$t('Users')" description="Manage your profile and account settings" />
        

        <Tabs default-value="edit" class="w-[400px]">
            <TabsList class="grid w-full grid-cols-2">
                <TabsTrigger value="edit">{{ $t('Edit :object', { object: $t('User') }) }}</TabsTrigger>
                <TabsTrigger v-if="action == 'DELETE'"  value="action">{{ $t('Delete') }}</TabsTrigger>
                <TabsTrigger v-else value="action">{{ $t('Restore') }}</TabsTrigger>
            </TabsList>
            <TabsContent value="edit">
                <FormEdit :user="props.user" :roles="props.roles" />
            </TabsContent>
            <TabsContent value="action">
                <FormDelete :user="props.user" :action="action" />
            </TabsContent>
        </Tabs>
        
      </div> 

    </AppLayout>
</template>