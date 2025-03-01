<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import Heading from '@/components/Heading.vue';
import { trans } from 'laravel-vue-i18n';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import TanStackTable from '@/components/TanStackTable.vue';
import DataTableIndexOptions from './partials/DataTableIndexOptions.vue';
import type { ColumnDef } from '@tanstack/vue-table'
import { Button } from '@/components/ui/button'
import { Plus, ArrowUpDown } from 'lucide-vue-next';
import { h } from 'vue'
import { Link } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: trans('Users'),
        href: '/users',
    },
];

defineProps<{
    name?: string;
}>();

const UserModel = {
    id: 0,
    name: '',
    email: '',
    created_at: '',
    updated_at: '',
    deleted_at: '',
    roles: []
}

const columns: ColumnDef<typeof UserModel>[] = [
  {
    accessorKey: 'name',
    header: ({ column }) => {
      return h(Button, {
        variant: 'ghost',
        onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
      }, () => [trans('Name'), h(ArrowUpDown, { class: 'ml-2 h-4 w-4' })])
    },
    cell: ({ row }) => h('div', {class: 'text-left font-medium' }, row.getValue('name')),
  },
  {
    accessorKey: 'email',
    header: ({ column }) => {
      return h(Button, {
        variant: 'ghost',
        onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
      }, () => ['Email', h(ArrowUpDown, { class: 'ml-2 h-4 w-4' })])
    },
    cell: ({ row }) => h('div', { class: 'text-left font-medium lowercase' }, row.getValue('email')),
  },
  {
    accessorKey: 'deleted_at',
    header: () => h('div', { class: 'text-left' }, 'Estatus'),
    cell: ({ row }) => {
      const status = row.getValue('deleted_at') ? trans('Deleted') : trans('Active')
      return h('div', { class: 'text-left font-medium' }, status)
    },
  },
  {
    accessorKey: 'roles',
    header: () => h('div', { class: 'text-left' }, 'Rol'),
    cell: ({ row }) => {
      const roles = row.getValue('roles') as { name: string }[]
      return h('div', { class: 'text-left font-medium' }, roles[0].name)
    },
  },
  {
    accessorKey: 'created_at',
    header: () => h('div', { class: 'text-left' }, trans('Created At')),
    cell: ({ row }) => {
      const createdAt = new Date(row.getValue('created_at'));
      const formattedDate = createdAt.toISOString().split('T')[0];
      return h('div', { class: 'text-left font-medium' }, formattedDate)
    },
  },
  {
    id: 'actions',
    enableHiding: false,
    cell: ({ row }) => {
      const dataRow = row.original
      return h(DataTableIndexOptions, {
        dataRow,
        onExpand: row.toggleExpanded,
      })
    },
  },
]

</script>

<template>
    <Head :title="$t('Users')" />
    
    <AppLayout :breadcrumbs="breadcrumbs">
      <div class="px-4 py-6">
        <Heading :title="$t('Users')" description="Manage your profile and account settings" />

        <div class="flex justify-end mb-4">
          <Button as-child>
            <Link :href="route('administration.users.create')">
              <Plus class="w-4 h-4 mr-2" /> {{ $t('New :object', { object: $t('User') }) }}
            </Link>
          </Button>
        </div>

        <TanStackTable
          :url="route('administration.users.data-table')"
          :model="UserModel"
          :columns="columns"
        />
      </div> 

    </AppLayout>
</template>
