<template>
  <AppLayout title="Super Admin Dashboard">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Super Admin Dashboard
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <div class="flex items-center">
              <div class="p-3 rounded-full bg-blue-100 text-blue-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
              </div>
              <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-700">Total Admins</h3>
                <p class="text-2xl font-bold text-gray-900">{{ pendingAdmins.length + verifiedAdmins.length }}</p>
              </div>
            </div>
          </div>

          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <div class="flex items-center">
              <div class="p-3 rounded-full bg-yellow-100 text-yellow-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
              <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-700">Pending Approvals</h3>
                <p class="text-2xl font-bold text-gray-900">{{ pendingAdmins.length }}</p>
              </div>
            </div>
          </div>

          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <div class="flex items-center">
              <div class="p-3 rounded-full bg-green-100 text-green-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
              <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-700">Verified Admins</h3>
                <p class="text-2xl font-bold text-gray-900">{{ verifiedAdmins.length }}</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Pending Admins Section -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
          <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Pending Admin Approvals</h3>
            <div class="overflow-x-auto">
              <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                  <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  <tr v-for="admin in pendingAdmins" :key="admin.id">
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm font-medium text-gray-900">{{ admin.name }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm text-gray-500">{{ admin.email }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm text-gray-500">{{ formatDate(admin.created_at) }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                      <button @click="verifyAdmin(admin.id)" class="text-green-600 hover:text-green-900 mr-3">
                        Verify
                      </button>
                      <button @click="rejectAdmin(admin.id)" class="text-red-600 hover:text-red-900">
                        Reject
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- Verified Admins Section -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Verified Admins</h3>
            <div class="overflow-x-auto">
              <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                  <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Verified At</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  <tr v-for="admin in verifiedAdmins" :key="admin.id">
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm font-medium text-gray-900">{{ admin.name }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm text-gray-500">{{ admin.email }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm text-gray-500">{{ formatDate(admin.updated_at) }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                      <button @click="removeAdmin(admin.id)" class="text-red-600 hover:text-red-900">
                        Remove
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { defineProps } from 'vue'
import AppLayout from '@/layouts/AppLayout.vue'
import { router } from '@inertiajs/vue3'

const props = defineProps({
  pendingAdmins: Array,
  verifiedAdmins: Array,
})

const formatDate = (date) => {
  return new Date(date).toLocaleDateString()
}

const verifyAdmin = (id) => {
  router.post(route('super-admin.verify', id))
}

const rejectAdmin = (id) => {
  router.post(route('super-admin.reject', id))
}

const removeAdmin = (id) => {
  if (confirm('Are you sure you want to remove this admin?')) {
    router.delete(route('super-admin.remove', id))
  }
}
</script>
