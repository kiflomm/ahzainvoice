<template>
  <AppLayout>
    <template #header>
      <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Records
        </h2>
        <Link
          :href="route('records.create')"
          class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
        >
          Create Record
        </Link>
      </div>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <div class="mb-4">
              <input
                type="text"
                v-model="search"
                placeholder="Search..."
                class="w-full px-3 py-2 border rounded-md"
              />
            </div>

            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Record Number
                  </th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Type
                  </th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Client
                  </th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Date
                  </th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Amount
                  </th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Status
                  </th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Actions
                  </th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="record in filteredRecords" :key="record.id">
                  <td class="px-6 py-4 whitespace-nowrap">
                    {{ record.record_number }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap capitalize">
                    {{ record.record_type }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    {{ record.client_name }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    {{ record.start_date }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    {{ formatCurrency(record.value_after_vat) }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
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
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <Link
                      :href="route('records.show', record.id)"
                      class="text-blue-600 hover:text-blue-900 mr-3"
                    >
                      View
                    </Link>
                    <Link
                      :href="route('records.edit', record.id)"
                      class="text-indigo-600 hover:text-indigo-900 mr-3"
                    >
                      Edit
                    </Link>
                    <button
                      @click="deleteRecord(record.id)"
                      class="text-red-600 hover:text-red-900"
                    >
                      Delete
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { formatCurrency } from '@/composables/useCurrency';

interface Record {
  id: number;
  record_number: string;
  record_type: string;
  client_name: string;
  start_date: string;
  status: 'pending' | 'paid' | 'overdue';
  value_after_vat: string | number;
}

const props = defineProps<{
  records: Record[];
}>();

const search = ref('');

const filteredRecords = computed(() => {
  if (!search.value) return props.records;

  const searchTerm = search.value.toLowerCase();
  return props.records.filter(record =>
    record.record_number.toLowerCase().includes(searchTerm) ||
    record.client_name.toLowerCase().includes(searchTerm) ||
    record.status.toLowerCase().includes(searchTerm) ||
    record.record_type.toLowerCase().includes(searchTerm)
  );
});

const deleteRecord = (id: number) => {
  if (confirm('Are you sure you want to delete this record?')) {
    router.delete(route('records.destroy', id));
  }
};
</script>
