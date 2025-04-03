<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AppShell from '@/components/AppShell.vue';
import InvoiceForm from '@/components/invoices/InvoiceForm.vue';

interface Vendor {
    id: number;
    name: string;
}

defineProps<{
    vendors: Vendor[];
}>();
</script>

<template>
    <Head title="Create Invoice" />

    <AppShell>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-bold">Create Invoice</h2>
            </div>
        </template>

        <div class="max-w-5xl mx-auto py-6">
            <InvoiceForm :vendors="vendors" />
        </div>
    </AppShell>
</template>
