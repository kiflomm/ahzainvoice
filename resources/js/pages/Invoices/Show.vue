<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';

defineProps({
  invoice: Object,
});
</script>

<template>
  <AppLayout title="Invoice Details">
    <Head title="Invoice Details" />

    <div class="py-6">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <!-- Invoice Header with Actions -->
          <div class="p-6 border-b border-gray-200 flex justify-between items-center">
            <h1 class="text-2xl font-semibold text-[#28536B]">
              Invoice #{{ invoice.invoice_number }}
            </h1>
            <div class="flex space-x-3">
              <Link
                :href="route('invoices.edit', invoice.id)"
                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-medium text-white bg-[#19647E] hover:bg-[#28536B] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#19647E]"
              >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                  <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                </svg>
                Edit
              </Link>
              <Link
                :href="route('invoices.index')"
                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#19647E]"
              >
                Back to List
              </Link>
            </div>
          </div>

          <!-- Invoice Document -->
          <div class="p-6">
            <!-- VAT Invoice Header -->
            <div class="border-b-2 border-gray-300 pb-4 text-center">
              <h2 class="text-xl font-bold">VALUE ADDED TAX INVOICE</h2>
            </div>

            <!-- Company and Customer Info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6 mb-8">
              <!-- Client Info (From) -->
              <div class="border rounded-lg p-4 bg-gray-50">
                <h3 class="font-semibold text-[#28536B] mb-3">Client Information:</h3>
                <table class="w-full text-sm">
                  <tr>
                    <td class="font-medium py-1 w-1/3">Name:</td>
                    <td>{{ invoice.client.name }}</td>
                  </tr>
                  <tr>
                    <td class="font-medium py-1">Address:</td>
                    <td>{{ invoice.client.address || 'N/A' }}</td>
                  </tr>
                  <tr>
                    <td class="font-medium py-1">Phone:</td>
                    <td>{{ invoice.client.phone || 'N/A' }}</td>
                  </tr>
                  <tr>
                    <td class="font-medium py-1">TIN No:</td>
                    <td>{{ invoice.client.tin_number || 'N/A' }}</td>
                  </tr>
                  <tr>
                    <td class="font-medium py-1">VAT Reg. No:</td>
                    <td>{{ invoice.client.vat_registration || 'N/A' }}</td>
                  </tr>
                </table>
              </div>

              <!-- Invoice Details -->
              <div class="border rounded-lg p-4">
                <h3 class="font-semibold text-[#28536B] mb-3">Invoice Details:</h3>
                <table class="w-full text-sm">
                  <tr>
                    <td class="font-medium py-1 w-1/3">Invoice Number:</td>
                    <td>{{ invoice.invoice_number }}</td>
                  </tr>
                  <tr>
                    <td class="font-medium py-1">Invoice Date:</td>
                    <td>{{ invoice.invoice_date }}</td>
                  </tr>
                  <tr>
                    <td class="font-medium py-1">Due Date:</td>
                    <td>{{ invoice.due_date || 'N/A' }}</td>
                  </tr>
                  <tr>
                    <td class="font-medium py-1">Status:</td>
                    <td>
                      <span
                        :class="{
                          'bg-yellow-100 text-yellow-800': invoice.status === 'pending',
                          'bg-green-100 text-green-800': invoice.status === 'paid',
                          'bg-red-100 text-red-800': invoice.status === 'overdue',
                          'bg-gray-100 text-gray-800': invoice.status === 'cancelled'
                        }"
                        class="px-2 py-1 rounded-full text-xs font-semibold"
                      >
                        {{ invoice.status.charAt(0).toUpperCase() + invoice.status.slice(1) }}
                      </span>
                    </td>
                  </tr>
                  <tr v-if="invoice.status === 'paid'">
                    <td class="font-medium py-1">Payment Date:</td>
                    <td>{{ invoice.payment_date }}</td>
                  </tr>
                </table>
              </div>
            </div>

            <!-- Invoice Items Table -->
            <div class="border rounded-lg overflow-hidden mb-6">
              <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-[#28536B]">
                  <tr>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-white uppercase w-16">Item No.</th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-white uppercase">Description</th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-white uppercase w-24">Unit</th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-white uppercase w-24">Qty</th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-white uppercase w-32">Unit Price</th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-white uppercase w-32">Amount</th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  <tr v-for="(item, index) in invoice.items" :key="index" class="hover:bg-gray-50">
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ item.item_number || (index + 1).toString().padStart(2, '0') }}</td>
                    <td class="px-4 py-3 text-sm text-gray-900">{{ item.description }}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ item.unit || 'Pcs' }}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ item.quantity }}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ Number(item.unit_price).toFixed(2) }}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ Number(item.amount).toFixed(2) }}</td>
                  </tr>
                </tbody>
              </table>
            </div>

            <!-- Totals and Payment Info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
              <!-- Payment Details -->
              <div class="border rounded-lg p-4">
                <h3 class="font-semibold text-[#28536B] mb-3">Payment Details:</h3>
                <div class="space-y-3 text-sm">
                  <div>
                    <span class="font-medium">Amount in words:</span>
                    <p class="italic mt-1">{{ invoice.amount_in_words || 'Not specified' }}</p>
                  </div>

                  <div v-if="invoice.payment_method">
                    <span class="font-medium">Payment Method:</span>
                    <p class="mt-1">{{ invoice.payment_method === 'cash' ? 'Cash' : 'Cheque' }}</p>
                  </div>

                  <div v-if="invoice.payment_method === 'cheque' && invoice.cheque_number">
                    <span class="font-medium">Cheque Number:</span>
                    <p class="mt-1">{{ invoice.cheque_number }}</p>
                  </div>

                  <div v-if="invoice.approver_name">
                    <span class="font-medium">Approved by:</span>
                    <p class="mt-1">{{ invoice.approver_name }}</p>
                  </div>

                  <div v-if="invoice.cashier_name">
                    <span class="font-medium">Cashier:</span>
                    <p class="mt-1">{{ invoice.cashier_name }}</p>
                  </div>
                </div>
              </div>

              <!-- Totals -->
              <div class="border rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                  <tbody>
                    <tr class="bg-gray-50">
                      <td class="px-4 py-3 text-sm font-medium text-gray-700 text-right">Subtotal:</td>
                      <td class="px-4 py-3 text-sm text-gray-900 text-right w-32">{{ Number(invoice.subtotal_amount).toFixed(2) }}</td>
                    </tr>
                    <tr>
                      <td class="px-4 py-3 text-sm font-medium text-gray-700 text-right">VAT ({{ invoice.tax_rate || 15 }}%):</td>
                      <td class="px-4 py-3 text-sm text-gray-900 text-right">{{ Number(invoice.tax_amount).toFixed(2) }}</td>
                    </tr>
                    <tr class="bg-[#28536B]/10">
                      <td class="px-4 py-3 text-base font-bold text-gray-700 text-right">Total:</td>
                      <td class="px-4 py-3 text-base font-bold text-gray-900 text-right">{{ Number(invoice.total_amount).toFixed(2) }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>

            <!-- Notes and Additional Info -->
            <div v-if="invoice.notes" class="border rounded-lg p-4 mb-6">
              <h3 class="font-semibold text-[#28536B] mb-2">Notes:</h3>
              <p class="text-sm text-gray-700 whitespace-pre-line">{{ invoice.notes }}</p>
            </div>

            <!-- Signatures and Stamps Section -->
            <div class="border-t-2 border-gray-300 pt-6 mt-8">
              <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center">
                  <p class="font-medium text-sm mb-10">Approved by:</p>
                  <div class="border-t border-gray-400 pt-1">
                    <p class="text-sm">{{ invoice.approver_name || 'Not specified' }}</p>
                  </div>
                </div>

                <div class="text-center">
                  <p class="font-medium text-sm mb-10">Received by:</p>
                  <div class="border-t border-gray-400 pt-1">
                    <p class="text-sm">Customer Signature</p>
                  </div>
                </div>

                <div class="text-center">
                  <p class="font-medium text-sm mb-10">Cashier:</p>
                  <div class="border-t border-gray-400 pt-1">
                    <p class="text-sm">{{ invoice.cashier_name || 'Not specified' }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
