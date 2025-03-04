<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import { Users, Folder, LayoutGrid, Settings } from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';
import { trans } from 'laravel-vue-i18n';

const mainNavItems: NavItem[] = [
    {
        title: trans('Administration'),
        href: '/administration',
        icon: Settings,
        permission: 'users_view',
        items: [
            {
                title: trans('Users'),
                href: '/administration/users',
                permission: 'users_view',
            }
        ]
    },
    {
        title: 'Dashboard',
        href: '/dashboard',
        icon: LayoutGrid,
        permission: 'dashboard_view',
    },
];

const footerNavItems: NavItem[] = [
    {
        title: 'WhatsApp',
        href: 'https://github.com/laravel/vue-starter-kit',
        icon: Folder,
    }
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="route('dashboard')">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
