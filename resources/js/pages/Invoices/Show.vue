<template>
  <AppLayout :title="`Invoice #${invoice.record_number}`">
    <template #header>
      <div class="flex justify-between items-center">
        <div class="flex items-center space-x-4">
          <Button variant="outline" asChild>
            <Link :href="route('invoices.index')" class="flex items-center">
              <ArrowLeft class="h-4 w-4 mr-2" />
              Back to Invoices
            </Link>
          </Button>
          <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Invoice #{{ invoice.record_number }}
          </h2>
        </div>
        <div class="flex space-x-2">
          <Link
            :href="route('invoices.edit', invoice.id)"
            class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded"
          >
            Edit
          </Link>
          <button
            @click="deleteInvoice"
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
              <!-- Client Information -->
              <div>
                <h4 class="text-sm font-medium text-gray-500">Client</h4>
                <p class="mt-1 text-sm text-gray-900">{{ invoice.client.name }}</p>
              </div>

              <!-- Status Information -->
              <div>
                <h4 class="text-sm font-medium text-gray-500">Status</h4>
                <span
                  :class="{
                    'bg-green-100 text-green-800': invoice.status === 'paid',
                    'bg-yellow-100 text-yellow-800': invoice.status === 'pending',
                    'bg-red-100 text-red-800': invoice.status === 'overdue'
                  }"
                  class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                >
                  {{ invoice.status }}
                </span>
              </div>

              <!-- Dates -->
              <div>
                <h4 class="text-sm font-medium text-gray-500">Start Date</h4>
                <p class="mt-1 text-sm text-gray-900">{{ invoice.start_date }}</p>
              </div>

              <div>
                <h4 class="text-sm font-medium text-gray-500">Invoice Date</h4>
                <p class="mt-1 text-sm text-gray-900">{{ invoice.end_date }}</p>
              </div>

              <!-- Purchase Type -->
              <div>
                <h4 class="text-sm font-medium text-gray-500">Purchase Type</h4>
                <p class="mt-1 text-sm text-gray-900">{{ invoice.purchase_type }}</p>
              </div>

              <!-- Unit Details -->
              <div>
                <h4 class="text-sm font-medium text-gray-500">Unit</h4>
                <p class="mt-1 text-sm text-gray-900">{{ invoice.unit }}</p>
              </div>

              <!-- Quantity -->
              <div>
                <h4 class="text-sm font-medium text-gray-500">Quantity</h4>
                <p class="mt-1 text-sm text-gray-900">{{ invoice.quantity }}</p>
              </div>

              <!-- Unit Price -->
              <div>
                <h4 class="text-sm font-medium text-gray-500">Unit Price</h4>
                <p class="mt-1 text-sm text-gray-900">{{ formatCurrency(invoice.unit_price) }}</p>
              </div>

              <!-- VAT -->
              <div>
                <h4 class="text-sm font-medium text-gray-500">VAT Rate</h4>
                <p class="mt-1 text-sm text-gray-900">{{ invoice.vat }}%</p>
              </div>

              <!-- Total Values -->
              <div class="col-span-2 mt-4">
                <div class="bg-gray-50 p-4 rounded-md">
                  <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                      <span class="text-sm text-gray-500">Subtotal:</span>
                      <p class="text-lg font-semibold">{{ formatCurrency(invoice.value) }}</p>
                    </div>
                    <div>
                      <span class="text-sm text-gray-500">VAT Amount:</span>
                      <p class="text-lg font-semibold">{{ formatCurrency(invoice.value_after_vat - invoice.value) }}</p>
                    </div>
                    <div>
                      <span class="text-sm text-gray-500">Total:</span>
                      <p class="text-lg font-semibold">{{ formatCurrency(invoice.value_after_vat) }}</p>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Description -->
              <div class="col-span-2">
                <h4 class="text-sm font-medium text-gray-500">Description</h4>
                <p class="mt-1 text-sm text-gray-900">{{ invoice.description || 'No description provided' }}</p>
              </div>

              <!-- Reference Numbers -->
              <div>
                <h4 class="text-sm font-medium text-gray-500">MRC Number</h4>
                <p class="mt-1 text-sm text-gray-900">{{ invoice.mrc_number || 'N/A' }}</p>
              </div>

              <div>
                <h4 class="text-sm font-medium text-gray-500">CDN Number</h4>
                <p class="mt-1 text-sm text-gray-900">{{ invoice.cdn_number || 'N/A' }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Link, router } from '@inertiajs/vue3';
import { ArrowLeft } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import { formatCurrency } from '@/composables/useCurrency';

interface Client {
  id: number;
  name: string;
}

interface Invoice {
  id: number;
  client: Client;
  record_number: string;
  start_date: string;
  end_date: string;
  purchase_type: string;
  status: 'pending' | 'paid' | 'overdue';
  description?: string;
  unit: string;
  quantity: number;
  unit_price: number;
  value: number;
  vat: number;
  value_after_vat: number;
  mrc_number?: string;
  cdn_number?: string;
}

const props = defineProps<{
  invoice: Invoice;
}>();

const deleteInvoice = () => {
  if (confirm('Are you sure you want to delete this invoice?')) {
    router.delete(route('invoices.destroy', props.invoice.id));
  }
};
</script> 