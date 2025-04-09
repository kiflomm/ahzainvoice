import AppLayout from '@/layouts/AppLayout.vue';
import Form from './Form.vue';

<template>
  <AppLayout title="Edit Bill">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Edit Bill
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <Form :clients="clients" :record="record" />
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
interface Client {
  id: number;
  name: string;
}

interface Props {
  clients: Client[];
  record: {
    id: number;
    client_id: number;
    bill_number: string;
    start_date: string;
    end_date: string;
    purchase_type: string;
    status: string;
    unit_details: string;
    vat_percentage: number;
    mrc_number?: string;
    cdn_number?: string;
    description?: string;
    subtotal: number;
    vat_amount: number;
    total_amount: number;
  };
}

defineProps<Props>();
</script> 