<template>
  <AppLayout title="Users">
    <template #header>
      <div class="flex justify-between items-center">
        <div>
          <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Users
          </h2>
          <p class="mt-1 text-sm text-gray-600">Manage system users</p>
        </div>
      </div>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Pending Employees Section -->
        <div v-if="pendingEmployees.length > 0" class="mb-8">
          <h3 class="text-lg font-medium text-gray-900 mb-4">Pending Verification</h3>
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
              <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                  <thead class="bg-gray-50">
                    <tr>
                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Name
                      </th>
                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Email
                      </th>
                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Role
                      </th>
                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                      </th>
                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Joined
                      </th>
                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                      </th>
                    </tr>
                  </thead>
                  <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="user in pendingEmployees" :key="user.id" class="hover:bg-gray-50">
                      <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ user.name }}</div>
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500">{{ user.email }}</div>
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap">
                        <Badge :variant="getRoleBadgeVariant(user.role)">
                          {{ user.role }}
                        </Badge>
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap">
                        <Badge variant="warning">
                          Pending Verification
                        </Badge>
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ user.created_at }}
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <div class="flex space-x-2">
                          <Button 
                            variant="outline" 
                            size="sm"
                            @click="verifyUser(user.id)"
                            :disabled="isProcessing"
                          >
                            <Loader2 v-if="isProcessing && processingUserId === user.id" class="h-4 w-4 mr-1 animate-spin" />
                            <CheckCircle2 v-else class="h-4 w-4 mr-1 text-green-600" />
                            Verify
                          </Button>
                          <Button 
                            variant="outline" 
                            size="sm"
                            @click="rejectUser(user.id)"
                            :disabled="isProcessing"
                          >
                            <Loader2 v-if="isProcessing && processingUserId === user.id" class="h-4 w-4 mr-1 animate-spin" />
                            <XCircle v-else class="h-4 w-4 mr-1 text-red-600" />
                            Reject
                          </Button>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        <!-- Verified Employees Section -->
        <div>
          <h3 class="text-lg font-medium text-gray-900 mb-4">Verified Users</h3>
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
              <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                  <thead class="bg-gray-50">
                    <tr>
                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Name
                      </th>
                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Email
                      </th>
                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Role
                      </th>
                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                      </th>
                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Joined
                      </th>
                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                      </th>
                    </tr>
                  </thead>
                  <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="user in verifiedEmployees" :key="user.id" class="hover:bg-gray-50">
                      <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ user.name }}</div>
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500">{{ user.email }}</div>
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap">
                        <Badge :variant="getRoleBadgeVariant(user.role)">
                          {{ user.role }}
                        </Badge>
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap">
                        <Badge variant="success">
                          Verified
                        </Badge>
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ user.created_at }}
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <div class="flex space-x-2">
                          <Button 
                            variant="outline" 
                            size="sm"
                            @click="removeUser(user.id)"
                            :disabled="isProcessing"
                          >
                            <Loader2 v-if="isProcessing && processingUserId === user.id" class="h-4 w-4 mr-1 animate-spin" />
                            <XCircle v-else class="h-4 w-4 mr-1 text-red-600" />
                            Remove
                          </Button>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/app/AppSidebarLayout.vue';
import Badge from '@/components/ui/badge/Badge.vue';
import { Button } from '@/components/ui/button';
import { CheckCircle2, XCircle, Loader2 } from 'lucide-vue-next';
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import { useToast } from '@/composables/useToast';

interface User {
  id: number;
  name: string;
  email: string;
  role: string;
  is_verified: boolean;
  email_verified_at: string | null;
  created_at: string;
}

defineProps<{
  pendingEmployees: User[];
  verifiedEmployees: User[];
}>();

const toast = useToast();
const isProcessing = ref(false);
const processingUserId = ref<number | null>(null);

const getRoleBadgeVariant = (role: string) => {
  switch (role) {
    case 'admin':
      return 'destructive';
    case 'employee':
      return 'secondary';
    default:
      return 'outline';
  }
};

const verifyUser = async (userId: number) => {
  isProcessing.value = true;
  processingUserId.value = userId;
  
  router.post(route('users.verify', userId), {}, {
    onSuccess: () => {
      toast({
        title: 'Success',
        description: 'User has been verified',
        variant: 'default',
      });
    },
    onError: () => {
      toast({
        title: 'Error',
        description: 'Failed to verify user',
        variant: 'destructive',
      });
    },
    onFinish: () => {
      isProcessing.value = false;
      processingUserId.value = null;
    },
  });
};

const rejectUser = async (userId: number) => {
  isProcessing.value = true;
  processingUserId.value = userId;
  
  router.post(route('users.reject', userId), {}, {
    onSuccess: () => {
      toast({
        title: 'Success',
        description: 'User has been rejected',
        variant: 'default',
      });
    },
    onError: () => {
      toast({
        title: 'Error',
        description: 'Failed to reject user',
        variant: 'destructive',
      });
    },
    onFinish: () => {
      isProcessing.value = false;
      processingUserId.value = null;
    },
  });
};

const removeUser = async (userId: number) => {
  if (!confirm('Are you sure you want to remove this user?')) {
    return;
  }
  
  isProcessing.value = true;
  processingUserId.value = userId;
  
  router.delete(route('users.remove', userId), {
    onSuccess: () => {
      toast({
        title: 'Success',
        description: 'User has been removed',
        variant: 'default',
      });
    },
    onError: () => {
      toast({
        title: 'Error',
        description: 'Failed to remove user',
        variant: 'destructive',
      });
    },
    onFinish: () => {
      isProcessing.value = false;
      processingUserId.value = null;
    },
  });
};
</script> 