<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { ref, computed, onMounted } from 'vue';

const props = defineProps({
  clients: Array,
  categories: Array,
});

const form = useForm({
  client_id: '',
  invoice_number: '',
  invoice_date: new Date().toISOString().substr(0, 10),
  due_date: '',
  subtotal_amount: 0,
  tax_rate: 15.00, // Default 15% VAT for Ethiopia
  tax_amount: 0,
  total_amount: 0,
  amount_in_words: '',
  status: 'pending',
  payment_date: null,
  payment_method: 'cash',
  cheque_number: '',
  approver_name: '',
  cashier_name: '',
  notes: '',
  items: [
    {
      item_number: '01',
      description: '',
      unit: 'Pcs',
      quantity: 1,
      unit_price: 0,
      amount: 0,
    }
  ],
});

const nextItemNumber = computed(() => {
  return (form.items.length + 1).toString().padStart(2, '0');
});

const addItem = () => {
  form.items.push({
    item_number: nextItemNumber.value,
    description: '',
    unit: 'Pcs',
    quantity: 1,
    unit_price: 0,
    amount: 0,
  });
};

const removeItem = (index) => {
  form.items.splice(index, 1);

  // Renumber items
  form.items.forEach((item, i) => {
    item.item_number = (i + 1).toString().padStart(2, '0');
  });

  calculateTotals();
};

const calculateItemAmount = (item) => {
  item.amount = parseFloat((item.quantity * item.unit_price).toFixed(2));
  calculateTotals();
};

const calculateTotals = () => {
  // Calculate subtotal
  form.subtotal_amount = form.items.reduce((total, item) => total + (parseFloat(item.amount) || 0), 0);

  // Calculate VAT (15%)
  form.tax_amount = parseFloat((form.subtotal_amount * form.tax_rate / 100).toFixed(2));

  // Calculate total
  form.total_amount = parseFloat((form.subtotal_amount + form.tax_amount).toFixed(2));

  // Generate amount in words
  generateAmountInWords();
};

const generateAmountInWords = () => {
  // Simple implementation - could be enhanced with a proper library
  const formatter = new Intl.NumberFormat('en-US', {
    style: 'currency',
    currency: 'ETB',
  });

  const formattedAmount = formatter.format(form.total_amount);
  form.amount_in_words = formattedAmount + ' only';
};

const submit = () => {
  form.post(route('invoices.store'), {
    onSuccess: () => {
      // Reset form after successful submission
      form.reset();
      form.items = [
        {
          item_number: '01',
          description: '',
          unit: 'Pcs',
          quantity: 1,
          unit_price: 0,
          amount: 0,
        }
      ];
    },
  });
};
</script>

<template>
  <AppLayout title="Create Invoice">
    <Head title="Create Invoice" />

    <div class="py-6">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
          <h1 class="text-2xl font-semibold text-[#28536B] mb-6">Create New Invoice</h1>

          <form @submit.prevent="submit">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
              <!-- Left Column - Client and Invoice Details -->
              <div class="space-y-4">
                <div>
                  <label for="client_id" class="block text-sm font-medium text-gray-700">Client</label>
                  <select
                    id="client_id"
                    v-model="form.client_id"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-[#19647E] focus:ring focus:ring-[#19647E] focus:ring-opacity-50"
                    required
                  >
                    <option value="">Select Client</option>
                    <option v-for="client in clients" :key="client.id" :value="client.id">
                      {{ client.name }}
                    </option>
                  </select>
                  <div v-if="form.errors.client_id" class="text-red-500 text-sm mt-1">{{ form.errors.client_id }}</div>
                </div>

                <div>
                  <label for="invoice_number" class="block text-sm font-medium text-gray-700">Invoice Number</label>
                  <input
                    id="invoice_number"
                    type="text"
                    v-model="form.invoice_number"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-[#19647E] focus:ring focus:ring-[#19647E] focus:ring-opacity-50"
                    required
                  />
                  <div v-if="form.errors.invoice_number" class="text-red-500 text-sm mt-1">{{ form.errors.invoice_number }}</div>
                </div>
              </div>

              <!-- Right Column - Date Details -->
              <div class="space-y-4">
                <div>
                  <label for="invoice_date" class="block text-sm font-medium text-gray-700">Invoice Date</label>
                  <input
                    id="invoice_date"
                    type="date"
                    v-model="form.invoice_date"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-[#19647E] focus:ring focus:ring-[#19647E] focus:ring-opacity-50"
                    required
                  />
                  <div v-if="form.errors.invoice_date" class="text-red-500 text-sm mt-1">{{ form.errors.invoice_date }}</div>
                </div> 
              </div>
            </div>

            <!-- Invoice Items Table -->
            <div class="mb-6">
              <h2 class="text-lg font-medium text-gray-900 mb-2">Invoice Items</h2>
              <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                  <thead class="bg-gray-50">
                    <tr>
                      <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-16">Item No.</th>
                      <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                      <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">Unit</th>
                      <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">Qty</th>
                      <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-32">Unit Price</th>
                      <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-32">Amount</th>
                      <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-16">Actions</th>
                    </tr>
                  </thead>
                  <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="(item, index) in form.items" :key="index">
                      <td class="px-3 py-2 whitespace-nowrap">
                        <input
                          type="text"
                          v-model="item.item_number"
                          class="block w-full border-gray-300 rounded-md shadow-sm focus:border-[#19647E] focus:ring focus:ring-[#19647E] focus:ring-opacity-50 text-sm"
                          readonly
                        />
                      </td>
                      <td class="px-3 py-2">
                        <input
                          type="text"
                          v-model="item.description"
                          class="block w-full border-gray-300 rounded-md shadow-sm focus:border-[#19647E] focus:ring focus:ring-[#19647E] focus:ring-opacity-50 text-sm"
                          required
                        />
                      </td>
                      <td class="px-3 py-2 whitespace-nowrap">
                        <input
                          type="text"
                          v-model="item.unit"
                          class="block w-full border-gray-300 rounded-md shadow-sm focus:border-[#19647E] focus:ring focus:ring-[#19647E] focus:ring-opacity-50 text-sm"
                        />
                      </td>
                      <td class="px-3 py-2 whitespace-nowrap">
                        <input
                          type="number"
                          v-model="item.quantity"
                          @input="calculateItemAmount(item)"
                          min="0"
                          step="0.01"
                          class="block w-full border-gray-300 rounded-md shadow-sm focus:border-[#19647E] focus:ring focus:ring-[#19647E] focus:ring-opacity-50 text-sm"
                          required
                        />
                      </td>
                      <td class="px-3 py-2 whitespace-nowrap">
                        <input
                          type="number"
                          v-model="item.unit_price"
                          @input="calculateItemAmount(item)"
                          min="0"
                          step="0.01"
                          class="block w-full border-gray-300 rounded-md shadow-sm focus:border-[#19647E] focus:ring focus:ring-[#19647E] focus:ring-opacity-50 text-sm"
                          required
                        />
                      </td>
                      <td class="px-3 py-2 whitespace-nowrap">
                        <input
                          type="number"
                          v-model="item.amount"
                          class="block w-full border-gray-300 rounded-md shadow-sm focus:border-[#19647E] focus:ring focus:ring-[#19647E] focus:ring-opacity-50 text-sm"
                          readonly
                        />
                      </td>
                      <td class="px-3 py-2 whitespace-nowrap">
                        <button
                          type="button"
                          @click="removeItem(index)"
                          class="text-red-500 hover:text-red-700"
                          :disabled="form.items.length === 1"
                        >
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                          </svg>
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="mt-2">
                <button
                  type="button"
                  @click="addItem"
                  class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-[#19647E] hover:bg-[#28536B] focus:outline-none focus:border-[#28536B] focus:ring focus:ring-[#19647E] active:bg-[#28536B] transition"
                >
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                  </svg>
                  Add Item
                </button>
              </div>
            </div>

            <!-- Totals and Payment Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
              <!-- Left Column - Payment Details -->
              <div class="space-y-4">
                <div>
                  <label for="amount_in_words" class="block text-sm font-medium text-gray-700">Amount in Words</label>
                  <input
                    id="amount_in_words"
                    type="text"
                    v-model="form.amount_in_words"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-[#19647E] focus:ring focus:ring-[#19647E] focus:ring-opacity-50"
                  />
                </div>

                <div>
                  <label for="payment_method" class="block text-sm font-medium text-gray-700">Payment Method</label>
                  <div class="mt-1 flex items-center space-x-4">
                    <label class="inline-flex items-center">
                      <input type="radio" v-model="form.payment_method" value="cash" class="form-radio text-[#19647E]">
                      <span class="ml-2">Cash</span>
                    </label>
                    <label class="inline-flex items-center">
                      <input type="radio" v-model="form.payment_method" value="cheque" class="form-radio text-[#19647E]">
                      <span class="ml-2">Cheque</span>
                    </label>
                  </div>
                </div>

                <div v-if="form.payment_method === 'cheque'">
                  <label for="cheque_number" class="block text-sm font-medium text-gray-700">Cheque Number</label>
                  <input
                    id="cheque_number"
                    type="text"
                    v-model="form.cheque_number"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-[#19647E] focus:ring focus:ring-[#19647E] focus:ring-opacity-50"
                  />
                </div>

                <div>
                  <label for="approver_name" class="block text-sm font-medium text-gray-700">Approver Name</label>
                  <input
                    id="approver_name"
                    type="text"
                    v-model="form.approver_name"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-[#19647E] focus:ring focus:ring-[#19647E] focus:ring-opacity-50"
                  />
                </div>

                <div>
                  <label for="cashier_name" class="block text-sm font-medium text-gray-700">Cashier Name</label>
                  <input
                    id="cashier_name"
                    type="text"
                    v-model="form.cashier_name"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-[#19647E] focus:ring focus:ring-[#19647E] focus:ring-opacity-50"
                  />
                </div>
              </div>

              <!-- Right Column - Totals -->
              <div class="space-y-4">
                <div class="bg-gray-50 p-4 rounded-lg">
                  <div class="flex justify-between items-center py-2 border-b border-gray-200">
                    <span class="text-gray-600">Subtotal:</span>
                    <span class="font-medium">{{ form.subtotal_amount.toFixed(2) }}</span>
                  </div>
                  <div class="flex justify-between items-center py-2 border-b border-gray-200">
                    <span class="text-gray-600">VAT ({{ form.tax_rate }}%):</span>
                    <span class="font-medium">{{ form.tax_amount.toFixed(2) }}</span>
                  </div>
                  <div class="flex justify-between items-center py-2 font-bold text-lg">
                    <span>Total:</span>
                    <span>{{ form.total_amount.toFixed(2) }}</span>
                  </div>
                </div>

                <div>
                  <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                  <select
                    id="status"
                    v-model="form.status"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-[#19647E] focus:ring focus:ring-[#19647E] focus:ring-opacity-50"
                    required
                  >
                    <option value="pending">Pending</option>
                    <option value="paid">Paid</option>
                    <option value="overdue">Overdue</option>
                    <option value="cancelled">Cancelled</option>
                  </select>
                </div>

                <div v-if="form.status === 'paid'">
                  <label for="payment_date" class="block text-sm font-medium text-gray-700">Payment Date</label>
                  <input
                    id="payment_date"
                    type="date"
                    v-model="form.payment_date"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-[#19647E] focus:ring focus:ring-[#19647E] focus:ring-opacity-50"
                  />
                </div>

                <div>
                  <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                  <textarea
                    id="notes"
                    v-model="form.notes"
                    rows="3"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-[#19647E] focus:ring focus:ring-[#19647E] focus:ring-opacity-50"
                  ></textarea>
                </div>
              </div>
            </div>

            <div class="flex justify-end">
              <button
                type="button"
                @click="$inertia.get(route('invoices.index'))"
                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:border-[#19647E] focus:ring focus:ring-[#19647E] focus:ring-opacity-50 active:bg-gray-100 mr-3"
              >
                Cancel
              </button>

              <button
                type="submit"
                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-medium text-white bg-[#19647E] hover:bg-[#28536B] focus:outline-none focus:border-[#28536B] focus:ring focus:ring-[#19647E] active:bg-[#28536B]"
                :disabled="form.processing"
              >
                <svg v-if="form.processing" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Create Invoice
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
