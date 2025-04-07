<template>
  <AuthenticatedLayout>
    <template #header>
      <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ record.record_type === 'invoice' ? 'Invoice' : 'Bill' }} Details
        </h2>
        <div class="flex space-x-2">
          <Link
            :href="route('records.edit', record.id)"
            class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded"
          >
            Edit
          </Link>
          <button
            @click="deleteRecord"
            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
          >
            Delete
          </button>
        </div>
      </div>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- Header Information -->
              <div class="col-span-2">
                <h3 class="text-lg font-medium text-gray-900">
                  {{ record.record_type === 'invoice' ? 'Invoice' : 'Bill' }} #{{ record.record_number }}
                </h3>
                <p class="text-sm text-gray-500">
                  Created on {{ record.created_at }}
                </p>
              </div>

              <!-- Client Information -->
              <div>
                <h4 class="text-sm font-medium text-gray-500">Client</h4>
                <p class="mt-1 text-sm text-gray-900">{{ record.client.name }}</p>
                <p class="text-sm text-gray-500">{{ record.client.address }}</p>
                <p class="text-sm text-gray-500">{{ record.client.phone }}</p>
              </div>

              <!-- Status Information -->
              <div>
                <h4 class="text-sm font-medium text-gray-500">Status</h4>
                <span
                  :class="{
                    'bg-green-100 text-green-800': record.status === 'paid',
                    'bg-yellow-100 text-yellow-800': record.status === 'pending',
                    'bg-red-100 text-red-800': record.status === 'overdue'
                  }"
                  class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                >
                  {{ record.status }}
                </span>
              </div>

              <!-- Dates -->
              <div>
                <h4 class="text-sm font-medium text-gray-500">Start Date</h4>
                <p class="mt-1 text-sm text-gray-900">{{ record.start_date }}</p>
              </div>

              <div>
                <h4 class="text-sm font-medium text-gray-500">End Date</h4>
                <p class="mt-1 text-sm text-gray-900">{{ record.end_date }}</p>
              </div>

              <!-- Purchase Type -->
              <div>
                <h4 class="text-sm font-medium text-gray-500">Purchase Type</h4>
                <p class="mt-1 text-sm text-gray-900 capitalize">{{ record.purchase_type }}</p>
              </div>

              <!-- Description -->
              <div class="col-span-2">
                <h4 class="text-sm font-medium text-gray-500">Description</h4>
                <p class="mt-1 text-sm text-gray-900">{{ record.description }}</p>
              </div>

              <!-- Financial Details -->
              <div>
                <h4 class="text-sm font-medium text-gray-500">Unit</h4>
                <p class="mt-1 text-sm text-gray-900">{{ record.unit }}</p>
              </div>

              <div>
                <h4 class="text-sm font-medium text-gray-500">Quantity</h4>
                <p class="mt-1 text-sm text-gray-900">{{ record.quantity }}</p>
              </div>

              <div>
                <h4 class="text-sm font-medium text-gray-500">Unit Price</h4>
                <p class="mt-1 text-sm text-gray-900">{{ record.unit_price }}</p>
              </div>

              <div>
                <h4 class="text-sm font-medium text-gray-500">VAT</h4>
                <p class="mt-1 text-sm text-gray-900">{{ record.vat }}</p>
              </div>

              <div class="col-span-2">
                <div class="mt-4 border-t pt-4">
                  <div class="flex justify-between">
                    <p class="text-sm font-medium text-gray-500">Subtotal</p>
                    <p class="text-sm text-gray-900">{{ record.value }}</p>
                  </div>
                  <div class="flex justify-between mt-2">
                    <p class="text-sm font-medium text-gray-500">VAT Amount</p>
                    <p class="text-sm text-gray-900">{{ record.vat }}</p>
                  </div>
                  <div class="flex justify-between mt-2">
                    <p class="text-sm font-medium text-gray-500">Total</p>
                    <p class="text-sm font-medium text-gray-900">{{ record.value_after_vat }}</p>
                  </div>
                </div>
              </div>

              <!-- Reference Numbers -->
              <div>
                <h4 class="text-sm font-medium text-gray-500">MRC Number</h4>
                <p class="mt-1 text-sm text-gray-900">{{ record.mrc_number }}</p>
              </div>

              <div>
                <h4 class="text-sm font-medium text-gray-500">CDN Number</h4>
                <p class="mt-1 text-sm text-gray-900">{{ record.cdn_number }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
  record: {
    type: Object,
    required: true,
  }
});

const deleteRecord = () => {
  if (confirm('Are you sure you want to delete this record?')) {
    router.delete(route('records.destroy', props.record.id));
  }
};
</script>
