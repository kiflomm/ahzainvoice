<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem, type SharedData } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import { Folder, LayoutGrid, Plus, Users, UserCircle } from 'lucide-vue-next';
import { computed } from 'vue';
import AppLogo from './AppLogo.vue';

// Access auth user from page props
const page = usePage<SharedData>();
const authUser = computed(() => page.props.auth.user);

// Define dashboard item (for all users)
const dashboardItem: NavItem = {
    title: 'Dashboard',
    href: '/dashboard',
    icon: LayoutGrid
};

// Define User Management item (admin only)
const userManagementItem: NavItem = {
    title: 'User Management',
    href: '/users',
    icon: Users
};

// Define employee menu items
const employeeItems: NavItem[] = [
    {
        title: 'Invoices',
        href: '/invoices',
        icon: Folder,
        action: {
            title: 'New Invoice',
            href: '/invoices/create',
            icon: Plus,
        }
    },
    {
        title: 'Bills',
        href: '/bills',
        icon: Folder,
        action: {
            title: 'New Bill',
            href: '/bills/create',
            icon: Plus,
        }
    },
    {
        title: 'Clients',
        href: '/clients',
        icon: UserCircle
    }
];

// Create main nav items based on role
const mainNavItems = computed(() => {
    // For admin users, only show Dashboard and User Management
    if (authUser.value.role === 'admin') {
        return [dashboardItem, userManagementItem];
    }
    
    // For employee users, show all employee-related items
    if (authUser.value.role === 'employee') {
        return [dashboardItem, ...employeeItems];
    }
    
    // For any other user, just show Dashboard
    return [dashboardItem];
});

const footerNavItems: NavItem[] = [];
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
