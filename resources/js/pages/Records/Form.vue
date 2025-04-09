<template>
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ isEdit ? 'Edit' : 'Create' }} Record
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <form @submit.prevent="submitForm">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Client Selection -->
                <div class="col-span-2">
                  <label class="block text-sm font-medium text-gray-700">Client</label>
                  <select
                    v-model="form.client_id"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    :class="{ 'border-red-500': errors.client_id }"
                  >
                    <option value="">Select a client</option>
                    <option v-for="client in clients" :key="client.id" :value="client.id">
                      {{ client.name }}
                    </option>
                  </select>
                  <p v-if="errors.client_id" class="mt-1 text-sm text-red-600">
                    {{ errors.client_id }}
                  </p>
                </div>

                <!-- Record Number -->
                <div>
                  <label class="block text-sm font-medium text-gray-700">Record Number</label>
                  <input
                    type="text"
                    v-model="form.record_number"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    :class="{ 'border-red-500': errors.record_number }"
                  />
                  <p v-if="errors.record_number" class="mt-1 text-sm text-red-600">
                    {{ errors.record_number }}
                  </p>
                </div>

                <!-- Record Type -->
                <div>
                  <label class="block text-sm font-medium text-gray-700">Record Type</label>
                  <select
                    v-model="form.record_type"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    :class="{ 'border-red-500': errors.record_type }"
                  >
                    <option value="invoice">Invoice</option>
                    <option value="bill">Bill</option>
                  </select>
                  <p v-if="errors.record_type" class="mt-1 text-sm text-red-600">
                    {{ errors.record_type }}
                  </p>
                </div>

                <!-- Start Date -->
                <div>
                  <label class="block text-sm font-medium text-gray-700">Start Date</label>
                  <input
                    type="date"
                    v-model="form.start_date"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    :class="{ 'border-red-500': errors.start_date }"
                  />
                  <p v-if="errors.start_date" class="mt-1 text-sm text-red-600">
                    {{ errors.start_date }}
                  </p>
                </div>

                <!-- End Date -->
                <div>
                  <label class="block text-sm font-medium text-gray-700">End Date</label>
                  <input
                    type="date"
                    v-model="form.end_date"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    :class="{ 'border-red-500': errors.end_date }"
                  />
                  <p v-if="errors.end_date" class="mt-1 text-sm text-red-600">
                    {{ errors.end_date }}
                  </p>
                </div>

                <!-- Purchase Type -->
                <div>
                  <label class="block text-sm font-medium text-gray-700">Purchase Type</label>
                  <select
                    v-model="form.purchase_type"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    :class="{ 'border-red-500': errors.purchase_type }"
                  >
                    <option value="goods">Goods</option>
                    <option value="services">Services</option>
                  </select>
                  <p v-if="errors.purchase_type" class="mt-1 text-sm text-red-600">
                    {{ errors.purchase_type }}
                  </p>
                </div>

                <!-- Status -->
                <div>
                  <label class="block text-sm font-medium text-gray-700">Status</label>
                  <select
                    v-model="form.status"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    :class="{ 'border-red-500': errors.status }"
                  >
                    <option value="pending">Pending</option>
                    <option value="paid">Paid</option>
                    <option value="overdue">Overdue</option>
                  </select>
                  <p v-if="errors.status" class="mt-1 text-sm text-red-600">
                    {{ errors.status }}
                  </p>
                </div>

                <!-- Description -->
                <div class="col-span-2">
                  <label class="block text-sm font-medium text-gray-700">Description</label>
                  <textarea
                    v-model="form.description"
                    rows="3"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    :class="{ 'border-red-500': errors.description }"
                  ></textarea>
                  <p v-if="errors.description" class="mt-1 text-sm text-red-600">
                    {{ errors.description }}
                  </p>
                </div>

                <!-- Unit -->
                <div>
                  <label class="block text-sm font-medium text-gray-700">Unit</label>
                  <input
                    type="text"
                    v-model="form.unit"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    :class="{ 'border-red-500': errors.unit }"
                  />
                  <p v-if="errors.unit" class="mt-1 text-sm text-red-600">
                    {{ errors.unit }}
                  </p>
                </div>

                <!-- Quantity -->
                <div>
                  <label class="block text-sm font-medium text-gray-700">Quantity</label>
                  <input
                    type="number"
                    v-model="form.quantity"
                    min="1"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    :class="{ 'border-red-500': errors.quantity }"
                  />
                  <p v-if="errors.quantity" class="mt-1 text-sm text-red-600">
                    {{ errors.quantity }}
                  </p>
                </div>

                <!-- Unit Price -->
                <div>
                  <label class="block text-sm font-medium text-gray-700">Unit Price</label>
                  <input
                    type="number"
                    v-model="form.unit_price"
                    min="0"
                    step="0.01"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    :class="{ 'border-red-500': errors.unit_price }"
                  />
                  <p v-if="errors.unit_price" class="mt-1 text-sm text-red-600">
                    {{ errors.unit_price }}
                  </p>
                </div>

                <!-- VAT -->
                <div>
                  <label class="block text-sm font-medium text-gray-700">VAT (%)</label>
                  <input
                    type="number"
                    v-model="form.vat"
                    min="0"
                    step="0.01"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    :class="{ 'border-red-500': errors.vat }"
                  />
                  <p v-if="errors.vat" class="mt-1 text-sm text-red-600">
                    {{ errors.vat }}
                  </p>
                </div>

                <!-- MRC Number -->
                <div>
                  <label class="block text-sm font-medium text-gray-700">MRC Number</label>
                  <input
                    type="text"
                    v-model="form.mrc_number"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    :class="{ 'border-red-500': errors.mrc_number }"
                  />
                  <p v-if="errors.mrc_number" class="mt-1 text-sm text-red-600">
                    {{ errors.mrc_number }}
                  </p>
                </div>

                <!-- CDN Number -->
                <div>
                  <label class="block text-sm font-medium text-gray-700">CDN Number</label>
                  <input
                    type="text"
                    v-model="form.cdn_number"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    :class="{ 'border-red-500': errors.cdn_number }"
                  />
                  <p v-if="errors.cdn_number" class="mt-1 text-sm text-red-600">
                    {{ errors.cdn_number }}
                  </p>
                </div>

                <div class="col-span-2 flex justify-end space-x-3">
                  <Link
                    :href="route('records.index')"
                    class="px-4 py-2 bg-gray-300 rounded-md text-gray-800 hover:bg-gray-400"
                  >
                    Cancel
                  </Link>
                  <button
                    type="submit"
                    class="px-4 py-2 bg-blue-500 rounded-md text-white hover:bg-blue-600"
                  >
                    {{ isEdit ? 'Update' : 'Create' }}
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { computed } from 'vue';
import { Link, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
  record: {
    type: Object,
    default: () => ({}),
  },
  clients: {
    type: Array,
    required: true,
  },
  errors: {
    type: Object,
    default: () => ({}),
  },
});

const isEdit = computed(() => Object.keys(props.record).length > 0);

const form = useForm({
  client_id: props.record.client_id || '',
  record_number: props.record.record_number || '',
  record_type: props.record.record_type || 'invoice',
  start_date: props.record.start_date || '',
  end_date: props.record.end_date || '',
  purchase_type: props.record.purchase_type || 'goods',
  status: props.record.status || 'pending',
  description: props.record.description || '',
  unit: props.record.unit || '',
  quantity: props.record.quantity || 1,
  unit_price: props.record.unit_price || 0,
  value: props.record.value || 0,
  vat: props.record.vat || 0,
  value_after_vat: props.record.value_after_vat || 0,
  mrc_number: props.record.mrc_number || '',
  cdn_number: props.record.cdn_number || '',
});

const submitForm = () => {
  if (isEdit.value) {
    form.put(route('records.update', props.record.id));
  } else {
    form.post(route('records.store'));
  }
};
</script>
