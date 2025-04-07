<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';

const props = defineProps({
  client: Object,
});

const breadcrumbs = [
  {
    title: 'Dashboard',
    href: '/dashboard',
  },
  {
    title: 'Clients',
    href: '/clients',
  },
  {
    title: props.client.name,
  },
];
</script>

<template>
  <AppLayout title="Client Details" :breadcrumbs="breadcrumbs">
    <Head :title="`Client: ${client.name}`" />

    <div class="py-6">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <div class="p-6">
            <div class="flex justify-between items-start">
              <h1 class="text-2xl font-semibold text-[#28536B]">{{ client.name }}</h1>
              <div class="flex gap-2">
                <Link
                  :href="route('clients.edit', client.id)"
                  class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#19647E] hover:bg-[#28536B] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#19647E]"
                >
                  <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                  </svg>
                  Edit
                </Link>
              </div>
            </div>

            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- Basic Information -->
              <div class="bg-gray-50 border rounded-lg p-4 shadow-sm">
                <h2 class="text-lg font-medium text-[#28536B] mb-4">Basic Information</h2>
                <div class="space-y-3">
                  <div class="grid grid-cols-3 gap-4">
                    <div class="text-sm font-medium text-gray-500">Name:</div>
                    <div class="text-sm text-gray-900 col-span-2">{{ client.name }}</div>
                  </div>
                  <div class="grid grid-cols-3 gap-4">
                    <div class="text-sm font-medium text-gray-500">Contact Person:</div>
                    <div class="text-sm text-gray-900 col-span-2">{{ client.contact_person || 'N/A' }}</div>
                  </div>
                  <div class="grid grid-cols-3 gap-4">
                    <div class="text-sm font-medium text-gray-500">Email:</div>
                    <div class="text-sm text-gray-900 col-span-2">{{ client.email || 'N/A' }}</div>
                  </div>
                  <div class="grid grid-cols-3 gap-4">
                    <div class="text-sm font-medium text-gray-500">Phone:</div>
                    <div class="text-sm text-gray-900 col-span-2">{{ client.phone || 'N/A' }}</div>
                  </div>
                  <div class="grid grid-cols-3 gap-4">
                    <div class="text-sm font-medium text-gray-500">Address:</div>
                    <div class="text-sm text-gray-900 col-span-2">{{ client.address || 'N/A' }}</div>
                  </div>
                  <div class="grid grid-cols-3 gap-4">
                    <div class="text-sm font-medium text-gray-500">Status:</div>
                    <div class="text-sm col-span-2">
                      <span
                        :class="[
                          'px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full',
                          client.is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'
                        ]"
                      >
                        {{ client.is_active ? 'Active' : 'Inactive' }}
                      </span>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Financial Information -->
              <div class="bg-gray-50 border rounded-lg p-4 shadow-sm">
                <h2 class="text-lg font-medium text-[#28536B] mb-4">Financial Information</h2>
                <div class="space-y-3">
                  <div class="grid grid-cols-3 gap-4">
                    <div class="text-sm font-medium text-gray-500">TIN Number:</div>
                    <div class="text-sm text-gray-900 col-span-2">{{ client.tin_number || 'N/A' }}</div>
                  </div>
                  <div class="grid grid-cols-3 gap-4">
                    <div class="text-sm font-medium text-gray-500">VAT Registration:</div>
                    <div class="text-sm text-gray-900 col-span-2">{{ client.vat_registration || 'N/A' }}</div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Notes -->
            <div v-if="client.notes" class="mt-6 bg-gray-50 border rounded-lg p-4 shadow-sm">
              <h2 class="text-lg font-medium text-[#28536B] mb-2">Notes</h2>
              <p class="text-sm text-gray-700 whitespace-pre-line">{{ client.notes }}</p>
            </div>

            <!-- Recent Invoices -->
            <div v-if="client.recent_invoices && client.recent_invoices.length > 0" class="mt-6">
              <h2 class="text-lg font-medium text-[#28536B] mb-4">Recent Invoices</h2>
              <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                  <thead class="bg-gray-50">
                    <tr>
                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Invoice #
                      </th>
                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Date
                      </th>
                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Amount
                      </th>
                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                      </th>
                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                      </th>
                    </tr>
                  </thead>
                  <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="invoice in client.recent_invoices" :key="invoice.id" class="hover:bg-gray-50">
                      <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-[#28536B]">{{ invoice.invoice_number }}</div>
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500">{{ invoice.invoice_date }}</div>
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ invoice.total_amount }}</div>
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap">
                        <span
                          :class="[
                            'px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full',
                            {
                              'bg-green-100 text-green-800': invoice.status === 'paid',
                              'bg-yellow-100 text-yellow-800': invoice.status === 'pending',
                              'bg-red-100 text-red-800': invoice.status === 'overdue',
                              'bg-gray-100 text-gray-800': invoice.status === 'cancelled'
                            }
                          ]"
                        >
                          {{ invoice.status.charAt(0).toUpperCase() + invoice.status.slice(1) }}
                        </span>
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <Link :href="route('invoices.show', invoice.id)" class="text-[#19647E] hover:text-[#28536B]">
                          View
                        </Link>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="mt-4 flex justify-end">
                <Link
                  :href="route('invoices.create')"
                  class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#19647E] hover:bg-[#28536B] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#19647E]"
                >
                  <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                  </svg>
                  Create New Invoice
                </Link>
              </div>
            </div>
            <div v-else class="mt-6 border rounded-lg p-8 text-center">
              <h2 class="text-lg font-medium text-[#28536B] mb-2">No Invoices Yet</h2>
              <p class="text-gray-500 mb-4">This client doesn't have any invoices yet.</p>
              <Link
                :href="route('invoices.create')"
                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#19647E] hover:bg-[#28536B] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#19647E]"
              >
                <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Create First Invoice
              </Link>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
