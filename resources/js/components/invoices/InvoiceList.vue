<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';

interface Invoice {
    id: number;
    invoice_number: string;
    vendor: {
        name: string;
    };
    invoice_date: string;
    ethiopian_invoice_date: string | null;
    calendar_type: 'G' | 'E';
    total_amount: number;
    status: string;
}

defineProps<{
    invoices: Invoice[];
}>();

const formatDate = (date: string, ethiopianDate: string | null, calendarType: 'G' | 'E') => {
    if (calendarType === 'E' && ethiopianDate) {
        return ethiopianDate;
    }
    return new Date(date).toLocaleDateString();
};

const formatAmount = (amount: number) => {
    return new Intl.NumberFormat('en-ET', {
        style: 'currency',
        currency: 'ETB'
    }).format(amount);
};
</script>

<template>
    <div class="flex flex-col gap-6">
        <!-- Header with Add Button -->
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold">Invoices</h2>
                <p class="text-sm text-muted-foreground">A list of your invoices.</p>
            </div>
            <Button @click="router.visit(route('invoices.create'))">Add New Invoice</Button>
        </div>

        <!-- Table Card -->
        <div class="rounded-lg bg-[#1a202c] overflow-hidden">
            <Table>
                <TableHeader class="bg-[#1a202c] border-b border-gray-700">
                    <TableRow class="hover:bg-[#2d3748]">
                        <TableHead class="text-gray-400 font-medium uppercase">Invoice #</TableHead>
                        <TableHead class="text-gray-400 font-medium uppercase">Vendor</TableHead>
                        <TableHead class="text-gray-400 font-medium uppercase">Date</TableHead>
                        <TableHead class="text-gray-400 font-medium uppercase">Amount</TableHead>
                        <TableHead class="text-gray-400 font-medium uppercase">Status</TableHead>
                        <TableHead class="text-gray-400 font-medium uppercase">Actions</TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <TableRow 
                        v-for="invoice in invoices" 
                        :key="invoice.id"
                        class="border-b border-gray-700 hover:bg-[#2d3748]"
                    >
                        <TableCell class="text-white">{{ invoice.invoice_number }}</TableCell>
                        <TableCell class="text-gray-300">{{ invoice.vendor.name }}</TableCell>
                        <TableCell class="text-gray-300">
                            {{ formatDate(invoice.invoice_date, invoice.ethiopian_invoice_date, invoice.calendar_type) }}
                        </TableCell>
                        <TableCell class="text-white">{{ formatAmount(invoice.total_amount) }}</TableCell>
                        <TableCell>
                            <span 
                                class="px-2 py-1 rounded-full text-xs font-medium"
                                :class="{
                                    'bg-green-900/50 text-green-300': invoice.status === 'paid',
                                    'bg-yellow-900/50 text-yellow-300': invoice.status === 'pending',
                                    'bg-red-900/50 text-red-300': invoice.status === 'overdue',
                                    'bg-gray-900/50 text-gray-300': invoice.status === 'cancelled'
                                }"
                            >
                                {{ invoice.status }}
                            </span>
                        </TableCell>
                        <TableCell>
                            <div class="flex space-x-2">
                                <Button 
                                    variant="ghost" 
                                    size="sm"
                                    class="text-gray-300 hover:text-white hover:bg-[#2d3748]"
                                    @click="router.visit(route('invoices.show', invoice.id))"
                                >
                                    View
                                </Button>
                                <Button 
                                    variant="ghost" 
                                    size="sm"
                                    class="text-gray-300 hover:text-white hover:bg-[#2d3748]"
                                    @click="router.visit(route('invoices.edit', invoice.id))"
                                >
                                    Edit
                                </Button>
                            </div>
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </div>
    </div>
</template> 