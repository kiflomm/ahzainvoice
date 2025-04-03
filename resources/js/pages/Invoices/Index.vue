<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import InvoiceList from '@/components/invoices/InvoiceList.vue';

interface Invoice {
    id: number;
    invoice_number: string;
    vendor: {
        id: number;
        name: string;
    };
    invoice_date: string;
    ethiopian_invoice_date: string | null;
    calendar_type: 'G' | 'E';
    due_date: string;
    ethiopian_due_date: string | null;
    total_amount: number;
    status: string;
}

defineProps<{
    invoices: Invoice[];
}>();
</script>

<template>
    <AppLayout title="Invoices">
        <div class="p-6">
            <InvoiceList :invoices="invoices" />
        </div>
    </AppLayout>
</template> 