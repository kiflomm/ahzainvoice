<script setup lang="ts">
import UserInfo from '@/components/UserInfo.vue';
import Badge from '@/components/ui/badge/Badge.vue';
import { DropdownMenuGroup, DropdownMenuItem, DropdownMenuLabel, DropdownMenuSeparator } from '@/components/ui/dropdown-menu';
import type { User } from '@/types';
import { Link } from '@inertiajs/vue3';
import { LogOut, Settings, Shield } from 'lucide-vue-next';
import { computed } from 'vue';

interface Props {
    user: User;
}

const props = defineProps<Props>();

// Get role badge variant based on role
const getRoleBadgeVariant = computed(() => {
    switch (props.user.role) {
        case 'admin':
            return 'destructive';
        case 'employee':
            return 'secondary';
        default:
            return 'outline';
    }
});

// Format role for display (capitalize, handle null)
const displayRole = computed(() => {
    if (!props.user.role) return 'User';
    return props.user.role.charAt(0).toUpperCase() + props.user.role.slice(1);
});
</script>

<template>
    <DropdownMenuLabel class="p-0 font-normal">
        <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
            <UserInfo :user="user" :show-email="true" />
        </div>
    </DropdownMenuLabel>
    
    <!-- User Role -->
    <div class="px-2 py-1.5 text-sm">
        <div class="flex items-center">
            <Shield class="mr-2 h-4 w-4 text-muted-foreground" />
            <span class="text-sm text-muted-foreground mr-2">Role:</span>
            <Badge :variant="getRoleBadgeVariant">{{ displayRole }}</Badge>
        </div>
    </div>
    
    <DropdownMenuSeparator />
    <DropdownMenuGroup>
        <DropdownMenuItem :as-child="true">
            <Link class="block w-full" :href="route('profile.edit')" as="button">
                <Settings class="mr-2 h-4 w-4" />
                Settings
            </Link>
        </DropdownMenuItem>
    </DropdownMenuGroup>
    <DropdownMenuSeparator />
    <DropdownMenuItem :as-child="true">
        <Link class="block w-full" method="post" :href="route('logout')" as="button">
            <LogOut class="mr-2 h-4 w-4" />
            Log out
        </Link>
    </DropdownMenuItem>
</template>
