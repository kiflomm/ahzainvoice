<template>
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ isEdit ? 'Edit' : 'Create' }} Client
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <form @submit.prevent="submitForm">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div class="col-span-2">
                  <label class="block text-sm font-medium text-gray-700">Name</label>
                  <input
                    type="text"
                    v-model="form.name"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    :class="{ 'border-red-500': errors.name }"
                  />
                  <p v-if="errors.name" class="mt-1 text-sm text-red-600">
                    {{ errors.name }}
                  </p>
                </div>

                <!-- Address -->
                <div class="col-span-2">
                  <label class="block text-sm font-medium text-gray-700">Address</label>
                  <input
                    type="text"
                    v-model="form.address"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    :class="{ 'border-red-500': errors.address }"
                  />
                  <p v-if="errors.address" class="mt-1 text-sm text-red-600">
                    {{ errors.address }}
                  </p>
                </div>

                <!-- Phone -->
                <div>
                  <label class="block text-sm font-medium text-gray-700">Phone</label>
                  <input
                    type="text"
                    v-model="form.phone"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    :class="{ 'border-red-500': errors.phone }"
                  />
                  <p v-if="errors.phone" class="mt-1 text-sm text-red-600">
                    {{ errors.phone }}
                  </p>
                </div>

                <!-- TIN Number -->
                <div>
                  <label class="block text-sm font-medium text-gray-700">TIN Number</label>
                  <input
                    type="text"
                    v-model="form.tin_number"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    :class="{ 'border-red-500': errors.tin_number }"
                  />
                  <p v-if="errors.tin_number" class="mt-1 text-sm text-red-600">
                    {{ errors.tin_number }}
                  </p>
                </div>

                <!-- VAT Registration -->
                <div>
                  <label class="block text-sm font-medium text-gray-700">VAT Registration</label>
                  <input
                    type="text"
                    v-model="form.vat_registration"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    :class="{ 'border-red-500': errors.vat_registration }"
                  />
                  <p v-if="errors.vat_registration" class="mt-1 text-sm text-red-600">
                    {{ errors.vat_registration }}
                  </p>
                </div>

                <!-- Registration Date -->
                <div>
                  <label class="block text-sm font-medium text-gray-700">Registration Date</label>
                  <input
                    type="date"
                    v-model="form.registration_date"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    :class="{ 'border-red-500': errors.registration_date }"
                  />
                  <p v-if="errors.registration_date" class="mt-1 text-sm text-red-600">
                    {{ errors.registration_date }}
                  </p>
                </div>
              </div>

              <div class="mt-6 flex justify-end">
                <Link
                  :href="route('clients.index')"
                  class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2"
                >
                  Cancel
                </Link>
                <button
                  type="submit"
                  class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                  :disabled="processing"
                >
                  {{ isEdit ? 'Update' : 'Create' }}
                </button>
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
  client: {
    type: Object,
    default: () => ({}),
  },
  errors: {
    type: Object,
    default: () => ({}),
  },
});

const isEdit = computed(() => Object.keys(props.client).length > 0);

const form = useForm({
  name: props.client.name || '',
  address: props.client.address || '',
  phone: props.client.phone || '',
  tin_number: props.client.tin_number || '',
  vat_registration: props.client.vat_registration || '',
  registration_date: props.client.registration_date || '',
});

const submitForm = () => {
  if (isEdit.value) {
    form.put(route('clients.update', props.client.id));
  } else {
    form.post(route('clients.store'));
  }
};
</script>
