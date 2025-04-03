<script setup lang="ts">
import { computed } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import VendorSelector from './VendorSelector.vue';
import AppLayout from '@/layouts/AppLayout.vue';

interface Vendor {
    id: number;
    name: string;
}

interface Invoice {
    id?: number;
    vendor_id: number | null;
    invoice_number: string;
    invoice_date: string;
    ethiopian_invoice_date: string | null;
    calendar_type: 'G' | 'E';
    due_date: string;
    ethiopian_due_date: string | null;
    payment_date: string | null;
    ethiopian_payment_date: string | null;
    total_amount: number;
    subtotal_amount: number;
    tax_amount: number;
    notes: string;
    status: 'draft' | 'pending' | 'paid' | 'overdue' | 'cancelled';
    items: any[];
}

const props = defineProps<{
    vendors: Vendor[];
    invoice?: Invoice;
}>();

const form = useForm<Invoice>({
    vendor_id: props.invoice?.vendor_id ?? null,
    invoice_number: props.invoice?.invoice_number ?? '',
    invoice_date: props.invoice?.invoice_date ?? new Date().toISOString().split('T')[0],
    ethiopian_invoice_date: props.invoice?.ethiopian_invoice_date ?? null,
    calendar_type: props.invoice?.calendar_type ?? 'G',
    due_date: props.invoice?.due_date ?? '',
    ethiopian_due_date: props.invoice?.ethiopian_due_date ?? null,
    payment_date: props.invoice?.payment_date ?? null,
    ethiopian_payment_date: props.invoice?.ethiopian_payment_date ?? null,
    total_amount: props.invoice?.total_amount ?? 0,
    subtotal_amount: props.invoice?.subtotal_amount ?? 0,
    tax_amount: props.invoice?.tax_amount ?? 0,
    notes: props.invoice?.notes ?? '',
    status: props.invoice?.status ?? 'draft',
    items: props.invoice?.items ?? [],
});

const isEditing = computed(() => !!props.invoice);

const handleVendorSelect = (value: number) => {
    console.log('Vendor selected:', value);
    form.vendor_id = value;
};

const submit = () => {
    // Calculate subtotal_amount based on total_amount and tax_amount
    form.subtotal_amount = Number(form.total_amount) - Number(form.tax_amount);
    
    console.log('Submitting form with vendor_id:', form.vendor_id);
    
    if (isEditing.value) {
        form.put(route('invoices.update', props.invoice?.id), {
            preserveScroll: true,
            onError: (errors) => {
                console.log('Form errors:', errors);
            }
        });
    } else {
        form.post(route('invoices.store'), {
            preserveScroll: true,
            onError: (errors) => {
                console.log('Form errors:', errors);
            }
        });
    }
};
</script>

<template>
    <AppLayout :title="isEditing ? 'Edit Invoice' : 'Create Invoice'">
        <div class="flex flex-col gap-6 p-6">
            <!-- Form Card -->
            <div class="rounded-lg bg-white p-6 shadow-sm dark:bg-[#1a202c]">
                <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-medium text-[#28536B] dark:text-white">Invoice Details</h3>
                    <p class="mt-1 text-sm text-[#28536B]/70 dark:text-gray-400">Fill in the information below to {{ isEditing ? 'update' : 'create' }} your invoice.</p>
                </div>

                <div class="p-6">
                    <form @submit.prevent="submit" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <VendorSelector
                                    :vendors="vendors"
                                    :model-value="form.vendor_id"
                                    :required="true"
                                    @update:model-value="handleVendorSelect"
                                />
                                <div v-if="form.errors.vendor_id" class="text-sm text-red-500">
                                    {{ form.errors.vendor_id }}
                                </div>
                            </div>

                            <div class="space-y-2">
                                <Label for="invoice_number">Invoice Number</Label>
                                <Input
                                    id="invoice_number"
                                    v-model="form.invoice_number"
                                    required
                                />
                                <div v-if="form.errors.invoice_number" class="text-sm text-red-500">
                                    {{ form.errors.invoice_number }}
                                </div>
                            </div>

                            <div class="space-y-2">
                                <Label for="invoice_date">Invoice Date</Label>
                                <Input
                                    id="invoice_date"
                                    type="date"
                                    v-model="form.invoice_date"
                                    required
                                />
                                <div v-if="form.errors.invoice_date" class="text-sm text-red-500">
                                    {{ form.errors.invoice_date }}
                                </div>
                            </div>

                            <div class="space-y-2">
                                <Label for="due_date">Due Date</Label>
                                <Input
                                    id="due_date"
                                    type="date"
                                    v-model="form.due_date"
                                    required
                                />
                                <div v-if="form.errors.due_date" class="text-sm text-red-500">
                                    {{ form.errors.due_date }}
                                </div>
                            </div>

                            <div class="space-y-2">
                                <Label for="total_amount">Total Amount</Label>
                                <Input
                                    id="total_amount"
                                    type="number"
                                    step="0.01"
                                    v-model="form.total_amount"
                                    required
                                />
                                <div v-if="form.errors.total_amount" class="text-sm text-red-500">
                                    {{ form.errors.total_amount }}
                                </div>
                            </div>

                            <div class="space-y-2">
                                <Label for="tax_amount">Tax Amount</Label>
                                <Input
                                    id="tax_amount"
                                    type="number"
                                    step="0.01"
                                    v-model="form.tax_amount"
                                    required
                                />
                                <div v-if="form.errors.tax_amount" class="text-sm text-red-500">
                                    {{ form.errors.tax_amount }}
                                </div>
                            </div>

                            <div class="space-y-2 md:col-span-2">
                                <Label for="notes">Notes</Label>
                                <Textarea
                                    id="notes"
                                    v-model="form.notes"
                                    rows="4"
                                />
                                <div v-if="form.errors.notes" class="text-sm text-red-500">
                                    {{ form.errors.notes }}
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end gap-2 pt-4 border-t border-gray-200 dark:border-gray-700">
                            <Button
                                type="button"
                                variant="outline"
                                :href="route('invoices.index')"
                            >
                                Cancel
                            </Button>
                            <Button type="submit" :disabled="form.processing">
                                {{ isEditing ? 'Update' : 'Create' }} Invoice
                            </Button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template> 