<script setup lang="ts">
import { ref } from 'vue';
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogContent,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { useForm } from '@inertiajs/vue3';

interface Vendor {
    id: number;
    name: string;
    tin?: string;
    address?: string;
    phone?: string;
    email?: string;
}

const props = defineProps<{
    vendors: Vendor[];
    modelValue?: number | null;
    required?: boolean;
}>();

const emit = defineEmits<{
    (e: 'update:modelValue', value: number): void;
    (e: 'vendor-created', vendor: Vendor): void;
}>();

const showNewVendorDialog = ref(false);

const form = useForm({
    name: '',
    tin: '',
    address: '',
    phone: '',
    email: '',
});

const createVendor = () => {
    form.post(route('vendors.store'), {
        preserveScroll: true,
        onSuccess: () => {
            showNewVendorDialog.value = false;
            form.reset();
        },
    });
};
</script>

<template>
    <div class="space-y-2">
        <div class="flex items-end gap-2">
            <div class="flex-1">
                <Label for="vendor_id">Vendor</Label>
                <Select 
                    id="vendor_id"
                    name="vendor_id"
                    :value="modelValue"
                    :required="required"
                    @update:value="emit('update:modelValue', $event)"
                >
                    <SelectTrigger>
                        <SelectValue placeholder="Select a vendor" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectItem v-for="vendor in vendors" :key="vendor.id" :value="vendor.id">
                            {{ vendor.name }}
                        </SelectItem>
                    </SelectContent>
                </Select>
            </div>
            <Dialog v-model:open="showNewVendorDialog">
                <DialogTrigger asChild>
                    <Button type="button" variant="outline">Add New Vendor</Button>
                </DialogTrigger>
                <DialogContent>
                    <DialogHeader>
                        <DialogTitle>Add New Vendor</DialogTitle>
                    </DialogHeader>
                    <form @submit.prevent="createVendor" class="space-y-4">
                        <div class="space-y-2">
                            <Label for="name">Name</Label>
                            <Input id="name" v-model="form.name" required />
                        </div>
                        <div class="space-y-2">
                            <Label for="tin">TIN</Label>
                            <Input id="tin" v-model="form.tin" />
                        </div>
                        <div class="space-y-2">
                            <Label for="address">Address</Label>
                            <Input id="address" v-model="form.address" />
                        </div>
                        <div class="space-y-2">
                            <Label for="phone">Phone</Label>
                            <Input id="phone" v-model="form.phone" type="tel" />
                        </div>
                        <div class="space-y-2">
                            <Label for="email">Email</Label>
                            <Input id="email" v-model="form.email" type="email" />
                        </div>
                        <div class="flex justify-end gap-2">
                            <Button 
                                type="button" 
                                variant="outline" 
                                @click="showNewVendorDialog = false"
                            >
                                Cancel
                            </Button>
                            <Button type="submit" :disabled="form.processing">
                                Create Vendor
                            </Button>
                        </div>
                    </form>
                </DialogContent>
            </Dialog>
        </div>
    </div>
</template> 