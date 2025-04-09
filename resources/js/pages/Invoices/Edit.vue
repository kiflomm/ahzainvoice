<template>
  <AppLayout title="Edit Invoice">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Edit Invoice
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <InvoiceForm 
              :clients="clients" 
              :invoice="invoice"
              :is-editing="true"
            />
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import InvoiceForm from './Form.vue';

interface Client {
  id: number;
  name: string;
}

interface InvoiceItem {
  id?: number;
  description: string;
  quantity: number;
  rate: number;
  amount: number;
}

interface Invoice {
  id: number;
  client_id: number;
  invoice_number: string;
  invoice_date: string;
  due_date: string;
  subtotal: number;
  tax_rate: number;
  tax_amount: number;
  total: number;
  notes?: string;
  items: InvoiceItem[];
}

interface Props {
  clients: Client[];
  invoice: Invoice;
}

defineProps<Props>();
</script> 