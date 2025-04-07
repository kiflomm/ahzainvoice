<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';

const form = useForm({
  name: '',
  contact_person: '',
  email: '',
  phone: '',
  address: '',
  tin_number: '',
  vat_registration: '',
  registration_date: '',
  notes: '',
  is_active: true,
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
    title: 'Create',
  },
];

const submit = () => {
  form.post(route('clients.store'));
};
</script>

<template>
  <AppLayout title="Create Client" :breadcrumbs="breadcrumbs">
    <Head title="Create Client" />

    <div class="py-6">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
          <h1 class="text-2xl font-semibold text-[#28536B] mb-6">Create New Client</h1>

          <form @submit.prevent="submit">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- Basic Information -->
              <div class="space-y-4">
                <div>
                  <label for="name" class="block text-sm font-medium text-gray-700">Name *</label>
                  <input
                    id="name"
                    type="text"
                    v-model="form.name"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-[#19647E] focus:ring focus:ring-[#19647E] focus:ring-opacity-50"
                    required
                  />
                  <div v-if="form.errors.name" class="text-red-500 text-sm mt-1">{{ form.errors.name }}</div>
                </div>

                <div>
                  <label for="contact_person" class="block text-sm font-medium text-gray-700">Contact Person</label>
                  <input
                    id="contact_person"
                    type="text"
                    v-model="form.contact_person"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-[#19647E] focus:ring focus:ring-[#19647E] focus:ring-opacity-50"
                  />
                  <div v-if="form.errors.contact_person" class="text-red-500 text-sm mt-1">{{ form.errors.contact_person }}</div>
                </div>

                <div>
                  <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                  <input
                    id="email"
                    type="email"
                    v-model="form.email"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-[#19647E] focus:ring focus:ring-[#19647E] focus:ring-opacity-50"
                  />
                  <div v-if="form.errors.email" class="text-red-500 text-sm mt-1">{{ form.errors.email }}</div>
                </div>

                <div>
                  <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                  <input
                    id="phone"
                    type="text"
                    v-model="form.phone"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-[#19647E] focus:ring focus:ring-[#19647E] focus:ring-opacity-50"
                  />
                  <div v-if="form.errors.phone" class="text-red-500 text-sm mt-1">{{ form.errors.phone }}</div>
                </div>
              </div>

              <!-- Additional Information -->
              <div class="space-y-4">
                <div>
                  <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                  <textarea
                    id="address"
                    v-model="form.address"
                    rows="3"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-[#19647E] focus:ring focus:ring-[#19647E] focus:ring-opacity-50"
                  ></textarea>
                  <div v-if="form.errors.address" class="text-red-500 text-sm mt-1">{{ form.errors.address }}</div>
                </div>

                <div>
                  <label for="tin_number" class="block text-sm font-medium text-gray-700">TIN Number</label>
                  <input
                    id="tin_number"
                    type="text"
                    v-model="form.tin_number"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-[#19647E] focus:ring focus:ring-[#19647E] focus:ring-opacity-50"
                  />
                  <div v-if="form.errors.tin_number" class="text-red-500 text-sm mt-1">{{ form.errors.tin_number }}</div>
                </div>

                <div>
                  <label for="vat_registration" class="block text-sm font-medium text-gray-700">VAT Registration</label>
                  <input
                    id="vat_registration"
                    type="text"
                    v-model="form.vat_registration"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-[#19647E] focus:ring focus:ring-[#19647E] focus:ring-opacity-50"
                  />
                  <div v-if="form.errors.vat_registration" class="text-red-500 text-sm mt-1">{{ form.errors.vat_registration }}</div>
                </div>

                <div>
                  <label for="is_active" class="flex items-center">
                    <input
                      id="is_active"
                      type="checkbox"
                      v-model="form.is_active"
                      class="rounded border-gray-300 text-[#19647E] shadow-sm focus:border-[#19647E] focus:ring focus:ring-[#19647E] focus:ring-opacity-50"
                    />
                    <span class="ml-2 text-sm text-gray-700">Active</span>
                  </label>
                </div>
              </div>
            </div>

            <!-- Notes -->
            <div class="mt-6">
              <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
              <textarea
                id="notes"
                v-model="form.notes"
                rows="4"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-[#19647E] focus:ring focus:ring-[#19647E] focus:ring-opacity-50"
              ></textarea>
              <div v-if="form.errors.notes" class="text-red-500 text-sm mt-1">{{ form.errors.notes }}</div>
            </div>

            <div class="mt-8 flex justify-end">
              <button
                type="button"
                @click="$inertia.visit(route('clients.index'))"
                class="mr-3 px-4 py-2 text-sm font-medium text-gray-700 border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#19647E]"
              >
                Cancel
              </button>
              <button
                type="submit"
                class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-[#19647E] border border-transparent rounded-md shadow-sm hover:bg-[#28536B] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#19647E]"
                :disabled="form.processing"
              >
                {{ form.processing ? 'Creating...' : 'Create Client' }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
