<template>
  <Form @submit="submit" class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <!-- Client Selection -->
      <FormField
        name="client_id"
        :value="form.client_id"
      >
        <FormItem>
          <FormLabel>Client</FormLabel>
          <div class="flex items-center">
            <Select 
              :value="form.client_id"
              @update:value="(value: number) => form.client_id = Number(value)"
              class="flex-1"
            >
              <FormControl>
                <SelectTrigger>
                  <SelectValue placeholder="Select a client">
                    {{ selectedClientName }}
                  </SelectValue>
                </SelectTrigger>
              </FormControl>
              <SelectContent>
                <SelectItem v-for="client in localClients" :key="client.id" :value="client.id">
                  {{ client.name }}
                </SelectItem>
              </SelectContent>
            </Select>
            <ClientCreateModal @created="onClientCreated" />
          </div>
          <FormMessage>{{ form.errors.client_id }}</FormMessage>
        </FormItem>
      </FormField>

      <!-- Record Number -->
      <FormField
        name="record_number"
        :value="form.record_number"
      >
        <FormItem>
          <FormLabel>Invoice Number</FormLabel>
          <FormControl>
            <Input v-model="form.record_number" placeholder="Enter invoice number" />
          </FormControl>
          <FormMessage>{{ form.errors.record_number }}</FormMessage>
        </FormItem>
      </FormField>

      <!-- Start Date -->
      <FormField
        name="start_date"
        :value="form.start_date"
      >
        <FormItem>
          <FormLabel>Start Date</FormLabel>
          <FormControl>
            <Input type="date" v-model="form.start_date" />
          </FormControl>
          <FormMessage>{{ form.errors.start_date }}</FormMessage>
        </FormItem>
      </FormField>

      <!-- End Date -->
      <FormField
        name="end_date"
        :value="form.end_date"
      >
        <FormItem>
          <FormLabel>End Date</FormLabel>
          <FormControl>
            <Input type="date" v-model="form.end_date" />
          </FormControl>
          <FormMessage>{{ form.errors.end_date }}</FormMessage>
        </FormItem>
      </FormField>

      <!-- Purchase Type -->
      <FormField
        name="purchase_type"
        :value="form.purchase_type"
      >
        <FormItem>
          <FormLabel>Purchase Type</FormLabel>
          <Select v-model="form.purchase_type">
            <FormControl>
              <SelectTrigger>
                <SelectValue placeholder="Select type" />
              </SelectTrigger>
            </FormControl>
            <SelectContent>
              <SelectItem value="goods">Goods</SelectItem>
              <SelectItem value="services">Services</SelectItem>
            </SelectContent>
          </Select>
          <FormMessage>{{ form.errors.purchase_type }}</FormMessage>
        </FormItem>
      </FormField>

      <!-- Status -->
      <FormField
        name="status"
        :value="form.status"
      >
        <FormItem>
          <FormLabel>Status</FormLabel>
          <Select v-model="form.status">
            <FormControl>
              <SelectTrigger>
                <SelectValue placeholder="Select status" />
              </SelectTrigger>
            </FormControl>
            <SelectContent>
              <SelectItem value="pending">Pending</SelectItem>
              <SelectItem value="paid">Paid</SelectItem>
              <SelectItem value="overdue">Overdue</SelectItem>
            </SelectContent>
          </Select>
          <FormMessage>{{ form.errors.status }}</FormMessage>
        </FormItem>
      </FormField>

      <!-- Unit -->
      <FormField
        name="unit"
        :value="form.unit"
      >
        <FormItem>
          <FormLabel>Unit</FormLabel>
          <FormControl>
            <Input v-model="form.unit" placeholder="Enter unit" />
          </FormControl>
          <FormMessage>{{ form.errors.unit }}</FormMessage>
        </FormItem>
      </FormField>

      <!-- Quantity -->
      <FormField
        name="quantity"
        :value="form.quantity"
      >
        <FormItem>
          <FormLabel>Quantity</FormLabel>
          <FormControl>
            <Input type="number" v-model="form.quantity" min="1" />
          </FormControl>
          <FormMessage>{{ form.errors.quantity }}</FormMessage>
        </FormItem>
      </FormField>

      <!-- Unit Price -->
      <FormField
        name="unit_price"
        :value="form.unit_price"
      >
        <FormItem>
          <FormLabel>Unit Price</FormLabel>
          <FormControl>
            <Input type="number" v-model="form.unit_price" step="0.01" min="0" />
          </FormControl>
          <FormMessage>{{ form.errors.unit_price }}</FormMessage>
        </FormItem>
      </FormField>

      <!-- VAT -->
      <FormField
        name="vat"
        :value="form.vat"
      >
        <FormItem>
          <FormLabel>VAT (%)</FormLabel>
          <FormControl>
            <Input type="number" v-model="form.vat" step="0.01" min="0" />
          </FormControl>
          <FormMessage>{{ form.errors.vat }}</FormMessage>
        </FormItem>
      </FormField>

      <!-- MRC Number -->
      <FormField
        name="mrc_number"
        :value="form.mrc_number"
      >
        <FormItem>
          <FormLabel>MRC Number</FormLabel>
          <FormControl>
            <Input v-model="form.mrc_number" placeholder="Enter MRC number" />
          </FormControl>
          <FormMessage>{{ form.errors.mrc_number }}</FormMessage>
        </FormItem>
      </FormField>

      <!-- CDN Number -->
      <FormField
        name="cdn_number"
        :value="form.cdn_number"
      >
        <FormItem>
          <FormLabel>CDN Number</FormLabel>
          <FormControl>
            <Input v-model="form.cdn_number" placeholder="Enter CDN number" />
          </FormControl>
          <FormMessage>{{ form.errors.cdn_number }}</FormMessage>
        </FormItem>
      </FormField>
    </div>

    <!-- Description -->
    <FormField
      name="description"
      :value="form.description"
    >
      <FormItem>
        <FormLabel>Description</FormLabel>
        <FormControl>
          <Textarea v-model="form.description" rows="3" placeholder="Enter description" />
        </FormControl>
        <FormMessage>{{ form.errors.description }}</FormMessage>
      </FormItem>
    </FormField>

    <!-- Calculated Values Display -->
    <div class="bg-gray-50 p-4 rounded-md">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
          <span class="text-sm text-gray-500">Subtotal:</span>
          <p class="text-lg font-semibold">{{ formatCurrency(subtotal) }}</p>
        </div>
        <div>
          <span class="text-sm text-gray-500">VAT Amount:</span>
          <p class="text-lg font-semibold">{{ formatCurrency(vatAmount) }}</p>
        </div>
        <div>
          <span class="text-sm text-gray-500">Total:</span>
          <p class="text-lg font-semibold">{{ formatCurrency(total) }}</p>
        </div>
      </div>
    </div>

    <div class="flex justify-end space-x-4">
      <Button
        variant="outline"
        as-child
      >
        <Link :href="route('invoices.index')">
          Cancel
        </Link>
      </Button>
      <Button
        type="submit"
        :disabled="form.processing"
      >
        {{ isEditing ? 'Update Invoice' : 'Create Invoice' }}
      </Button>
    </div>
  </Form>
</template>

<script setup lang="ts">
import { computed, ref } from 'vue';
import { Link, useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import {
  Form,
  FormControl,
  FormField,
  FormItem,
  FormLabel,
  FormMessage,
} from '@/components/ui/form';
import { Input } from '@/components/ui/input';
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from '@/components/ui/select';
import { Textarea } from '@/components/ui/textarea';
import ClientCreateModal from '@/components/ClientCreateModal.vue';
import { toast } from '@/components/ui/toast/use-toast';

interface Client {
  id: number;
  name: string;
}

interface Props {
  clients: Client[];
  record?: {
    id?: number;
    client_id: number;
    record_number: string;
    start_date: string;
    end_date: string;
    purchase_type: string;
    status: string;
    description?: string;
    unit: string;
    quantity: number;
    unit_price: number;
    vat: number;
    mrc_number?: string;
    cdn_number?: string;
  };
}

const props = withDefaults(defineProps<Props>(), {
  record: () => ({
    client_id: 0,
    record_number: '',
    start_date: '',
    end_date: '',
    purchase_type: '',
    status: '',
    description: '',
    unit: '',
    quantity: 1,
    unit_price: 0,
    vat: 0,
    mrc_number: '',
    cdn_number: '',
  }),
});

const isEditing = computed(() => !!props.record?.id);
const localClients = ref([...props.clients]);

const form = useForm({
  client_id: Number(props.record.client_id) || 0,
  record_number: props.record.record_number || '',
  start_date: props.record.start_date || '',
  end_date: props.record.end_date || '',
  purchase_type: props.record.purchase_type || '',
  status: props.record.status || '',
  description: props.record.description || '',
  unit: props.record.unit || '',
  quantity: Number(props.record.quantity) || 1,
  unit_price: Number(props.record.unit_price) || 0,
  vat: Number(props.record.vat) || 0,
  mrc_number: props.record.mrc_number || '',
  cdn_number: props.record.cdn_number || '',
});

const selectedClientName = computed(() => {
  const client = localClients.value.find(c => c.id === form.client_id);
  return client?.name || '';
});

// Convert string inputs to numbers for numeric fields
form.quantity = Number(form.quantity);
form.unit_price = Number(form.unit_price);
form.vat = Number(form.vat);

const subtotal = computed(() => {
  const qty = Number(form.quantity) || 0;
  const price = Number(form.unit_price) || 0;
  return qty * price;
});

const vatAmount = computed(() => {
  const vat = Number(form.vat) || 0;
  return subtotal.value * (vat / 100);
});

const total = computed(() => {
  return subtotal.value + vatAmount.value;
});

const formatCurrency = (value: number) => {
  return new Intl.NumberFormat('en-US', {
    style: 'currency',
    currency: 'USD',
  }).format(value);
};

const submit = () => {
  // Ensure numeric fields are properly typed
  form.quantity = Number(form.quantity);
  form.unit_price = Number(form.unit_price);
  form.vat = Number(form.vat);

  if (isEditing.value) {
    form.put(route('invoices.update', props.record.id), {
      onSuccess: () => {
        toast({
          title: 'Success',
          description: 'Invoice updated successfully'
        });
      },
      onError: () => {
        toast({
          title: 'Error',
          description: 'Failed to update invoice',
          variant: 'destructive'
        });
      },
    });
  } else {
    form.post(route('invoices.store'), {
      onSuccess: () => {
        toast({
          title: 'Success',
          description: 'Invoice created successfully'
        });
      },
      onError: () => {
        toast({
          title: 'Error',
          description: 'Failed to create invoice',
          variant: 'destructive'
        });
      },
    });
  }
};

const onClientCreated = (payload: { id: string; name: string }) => {
  // Update the local clients list and select the new client
  const newClient = {
    id: Number(payload.id),
    name: payload.name
  };
  localClients.value.push(newClient);
  form.client_id = newClient.id;
  toast({
    title: 'Success',
    description: 'Client added successfully'
  });
};
</script> 