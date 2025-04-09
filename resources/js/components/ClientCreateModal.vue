<template>
  <Dialog :open="isOpen" @update:open="closeModal">
    <DialogTrigger asChild>
      <Button variant="outline" class="ml-2" @click="openModal">
        <Plus class="h-4 w-4 mr-1" />
        Add Client
      </Button>
    </DialogTrigger>
    <DialogContent class="sm:max-w-[600px]">
      <DialogHeader>
        <DialogTitle>Create New Client</DialogTitle>
        <DialogDescription>
          Add a new client to your system. Fill in the client's details below.
        </DialogDescription>
      </DialogHeader>
      <Form @submit="submit" class="space-y-6">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <!-- Name -->
          <FormField
            name="name"
            :value="form.name"
            class="col-span-2"
          >
            <FormItem>
              <FormLabel>Name *</FormLabel>
              <FormControl>
                <Input v-model="form.name" placeholder="Enter client name" />
              </FormControl>
              <FormMessage>{{ form.errors.name }}</FormMessage>
            </FormItem>
          </FormField>

          <!-- Phone -->
          <FormField
            name="phone"
            :value="form.phone"
          >
            <FormItem>
              <FormLabel>Phone</FormLabel>
              <FormControl>
                <Input v-model="form.phone" placeholder="Enter phone number" />
              </FormControl>
              <FormMessage>{{ form.errors.phone }}</FormMessage>
            </FormItem>
          </FormField>

          <!-- Email -->
          <FormField
            name="email"
            :value="form.email"
          >
            <FormItem>
              <FormLabel>Email</FormLabel>
              <FormControl>
                <Input v-model="form.email" type="email" placeholder="Enter email address" />
              </FormControl>
              <FormMessage>{{ form.errors.email }}</FormMessage>
            </FormItem>
          </FormField>

          <!-- TIN Number -->
          <FormField
            name="tin_number"
            :value="form.tin_number"
          >
            <FormItem>
              <FormLabel>TIN Number</FormLabel>
              <FormControl>
                <Input v-model="form.tin_number" placeholder="Enter TIN number" />
              </FormControl>
              <FormMessage>{{ form.errors.tin_number }}</FormMessage>
            </FormItem>
          </FormField>

          <!-- VAT Registration -->
          <FormField
            name="vat_registration"
            :value="form.vat_registration"
          >
            <FormItem>
              <FormLabel>VAT Registration</FormLabel>
              <FormControl>
                <Input v-model="form.vat_registration" placeholder="Enter VAT registration" />
              </FormControl>
              <FormMessage>{{ form.errors.vat_registration }}</FormMessage>
            </FormItem>
          </FormField>

          <!-- Address -->
          <FormField
            name="address"
            :value="form.address"
            class="col-span-2"
          >
            <FormItem>
              <FormLabel>Address</FormLabel>
              <FormControl>
                <Textarea v-model="form.address" placeholder="Enter address" />
              </FormControl>
              <FormMessage>{{ form.errors.address }}</FormMessage>
            </FormItem>
          </FormField>
        </div>

        <DialogFooter>
          <Button type="button" variant="secondary" @click="closeModal">
            Cancel
          </Button>
          <Button type="submit" :disabled="form.processing">
            <Loader2 v-if="form.processing" class="h-4 w-4 mr-2 animate-spin" />
            Create Client
          </Button>
        </DialogFooter>
      </Form>
    </DialogContent>
  </Dialog>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { Plus, Loader2 } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import {
  Dialog,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
  DialogTrigger,
} from '@/components/ui/dialog';
import {
  Form,
  FormControl,
  FormField,
  FormItem,
  FormLabel,
  FormMessage,
} from '@/components/ui/form';
import { Input } from '@/components/ui/input';
import { Textarea } from '@/components/ui/textarea';
import { useToast } from '@/composables/useToast';

interface EmitProps {
  (event: 'created', payload: { id: string; name: string }): void
  (event: 'close'): void
}

const emit = defineEmits<EmitProps>()

const isOpen = ref(false);
const toast = useToast();

const form = useForm({
  name: '',
  email: '',
  phone: '',
  address: '',
  tin_number: '',
  vat_registration: '',
});

const openModal = () => {
  isOpen.value = true;
};

const closeModal = () => {
  isOpen.value = false;
  form.reset();
  form.clearErrors();
};

const submit = async () => {
  form.clearErrors()
  const processing = ref(true)

  try {
    await form.post(route('clients.store'), {
      preserveScroll: true,
      onSuccess: () => {
        emit('created', { 
          id: form.tin_number, // Access form data directly
          name: form.name 
        })
        toast({
          title: 'Success',
          description: 'Client created successfully',
          variant: 'default',
        })
        form.reset()
        closeModal()
      },
    })
  } catch (error) {
    console.error('Error creating client:', error)
    toast({
      title: 'Error',
      description: 'Failed to create client',
      variant: 'destructive',
    })
  } finally {
    processing.value = false
  }
}
</script> 