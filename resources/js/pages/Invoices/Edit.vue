<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AppShell from '@/components/AppShell.vue';
import InvoiceForm from '@/components/invoices/InvoiceForm.vue';

interface Vendor {
    id: number;
    name: string;
}

interface Invoice {
    id: number;
    vendor_id: number;
    invoice_number: string;
    invoice_date: string;
    ethiopian_invoice_date: string | null;
    calendar_type: 'G' | 'E';
    due_date: string;
    ethiopian_due_date: string | null;
    payment_date: string | null;
    ethiopian_payment_date: string | null;
    total_amount: number;
    tax_amount: number;
    notes: string;
    status: string;
}

defineProps<{
    vendors: Vendor[];
    invoice: Invoice;
}>();
</script>

<template>
    <Head title="Edit Invoice" />

    <AppShell>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-bold">Edit Invoice</h2>
            </div>
        </template>

        <div class="max-w-5xl mx-auto py-6">
            <InvoiceForm :vendors="vendors" :invoice="invoice" />
        </div>
    </AppShell>
</template> 