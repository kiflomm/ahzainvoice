<script setup lang="ts">
import { SidebarGroup, SidebarGroupContent, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';

interface Props {
    items: NavItem[];
    class?: string;
}

defineProps<Props>();
</script>

<template>
    <SidebarGroup :class="`group-data-[collapsible=icon]:p-0 ${$props.class || ''}`">
        <SidebarGroupContent>
            <SidebarMenu>
                <SidebarMenuItem v-for="item in items" :key="item.title">
                    <div class="flex items-center justify-between w-full">
                        <SidebarMenuButton class="text-neutral-600 hover:text-neutral-800 dark:text-neutral-300 dark:hover:text-neutral-100" as-child>
                            <a :href="item.href" rel="noopener noreferrer">
                                <component :is="item.icon" />
                                <span>{{ item.title }}</span>
                            </a>
                        </SidebarMenuButton>
                        <SidebarMenuButton v-if="item.action" class="text-neutral-600 hover:text-neutral-800 dark:text-neutral-300 dark:hover:text-neutral-100" as-child>
                            <a :href="item.action.href" :title="item.action.title" rel="noopener noreferrer">
                                <component :is="item.action.icon" class="w-4 h-4" />
                            </a>
                        </SidebarMenuButton>
                    </div>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarGroupContent>
    </SidebarGroup>
</template>
