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
            <Form :clients="clients" :record="invoice" />
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/app/AppSidebarLayout.vue';
import Form from './Form.vue';

interface Client {
  id: number;
  name: string;
}

interface Invoice {
  id: number;
  client_id: number;
  record_number: string;
  start_date: string;
  end_date: string;
  purchase_type: string;
  status: string;
  description?: string;
  unit: string;
  quantity: number;
  unit_price: number;
  vat: number;
  value: number;
  value_after_vat: number;
  mrc_number?: string;
  cdn_number?: string;
}

interface Props {
  clients: Client[];
  invoice: Invoice;
}

defineProps<Props>();
</script> 