<template>
  <AppLayout>
    <template #header>
      <div class="flex justify-between items-center">
        <div>
          <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Bills
          </h2>
          <p class="mt-1 text-sm text-gray-600">Manage your bills and track payments</p>
        </div>
        <div class="flex items-center space-x-4">
          <Button variant="outline" @click="refreshData">
            <RefreshCcw class="h-4 w-4 mr-2" />
            Refresh
          </Button>
          <Button asChild>
            <Link :href="route('bills.create')">
              <Plus class="h-4 w-4 mr-2" />
              Create Bill
            </Link>
          </Button>
        </div>
      </div>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <div class="flex flex-col md:flex-row justify-between items-center mb-6 space-y-4 md:space-y-0">
              <div class="w-full md:w-1/3">
                <Input
                  type="text"
                  v-model="search"
                  placeholder="Search bills..."
                  class="w-full"
                >
                  <template #prefix>
                    <Search class="h-4 w-4 text-gray-400" />
                  </template>
                </Input>
              </div>
              <div class="flex items-center space-x-4">
                <Select v-model="statusFilter" class="w-[150px]">
                  <SelectTrigger>
                    <SelectValue placeholder="Filter by status" />
                  </SelectTrigger>
                  <SelectContent>
                    <SelectItem value="">All Statuses</SelectItem>
                    <SelectItem value="pending">Pending</SelectItem>
                    <SelectItem value="paid">Paid</SelectItem>
                    <SelectItem value="overdue">Overdue</SelectItem>
                  </SelectContent>
                </Select>
                <Select v-model="sortBy" class="w-[200px]">
                  <SelectTrigger>
                    <SelectValue placeholder="Sort by" />
                  </SelectTrigger>
                  <SelectContent>
                    <SelectItem value="date_desc">Date (Newest)</SelectItem>
                    <SelectItem value="date_asc">Date (Oldest)</SelectItem>
                    <SelectItem value="amount_desc">Amount (High to Low)</SelectItem>
                    <SelectItem value="amount_asc">Amount (Low to High)</SelectItem>
                  </SelectContent>
                </Select>
              </div>
            </div>

            <div class="relative overflow-x-auto">
              <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                  <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Bill Number
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Client
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Date Range
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Amount
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Status
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Actions
                    </th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  <tr v-for="bill in filteredBills" :key="bill.id" class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                      {{ bill.record_number }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      {{ bill.client_name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      {{ formatDate(bill.start_date) }} - {{ formatDate(bill.end_date) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap font-medium">
                      {{ bill.value_after_vat }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <Badge
                        :variant="getStatusVariant(bill.status)"
                      >
                        {{ bill.status }}
                      </Badge>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                      <DropdownMenu>
                        <DropdownMenuTrigger asChild>
                          <Button variant="ghost" size="sm">
                            <MoreHorizontal class="h-4 w-4" />
                            <span class="sr-only">Open menu</span>
                          </Button>
                        </DropdownMenuTrigger>
                        <DropdownMenuContent align="end" class="w-[160px]">
                          <DropdownMenuItem asChild>
                            <Link :href="route('bills.show', bill.id)">
                              <Eye class="h-4 w-4 mr-2" />
                              View
                            </Link>
                          </DropdownMenuItem>
                          <DropdownMenuItem asChild>
                            <Link :href="route('bills.edit', bill.id)">
                              <PenSquare class="h-4 w-4 mr-2" />
                              Edit
                            </Link>
                          </DropdownMenuItem>
                          <DropdownMenuSeparator />
                          <DropdownMenuItem @click="confirmDelete(bill.id)" class="text-red-600">
                            <Trash class="h-4 w-4 mr-2" />
                            Delete
                          </DropdownMenuItem>
                        </DropdownMenuContent>
                      </DropdownMenu>
                    </td>
                  </tr>
                  <tr v-if="filteredBills.length === 0">
                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                      No bills found
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    <Dialog :open="!!billToDelete" @update:open="billToDelete = null">
      <DialogContent>
        <DialogHeader>
          <DialogTitle>Delete Bill</DialogTitle>
          <DialogDescription>
            Are you sure you want to delete this bill? This action cannot be undone.
          </DialogDescription>
        </DialogHeader>
        <DialogFooter>
          <Button variant="outline" @click="billToDelete = null">Cancel</Button>
          <Button variant="destructive" @click="deleteBill" :disabled="isDeleting">
            <Loader2 v-if="isDeleting" class="h-4 w-4 mr-2 animate-spin" />
            Delete
          </Button>
        </DialogFooter>
      </DialogContent>
    </Dialog>
  </AppLayout>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import AppLayout from '@/layouts/app/AppSidebarLayout.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import Badge from '@/components/ui/badge/Badge.vue';
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from '@/components/ui/select';
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import {
  Dialog,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
} from '@/components/ui/dialog';
import { Eye, PenSquare, Plus, MoreHorizontal, RefreshCcw, Search, Trash, Loader2 } from 'lucide-vue-next';

interface Bill {
  id: number;
  record_number: string;
  client_name: string;
  start_date: string;
  end_date: string;
  purchase_type: string;
  status: 'pending' | 'paid' | 'overdue';
  value_after_vat: string;
}

const props = defineProps<{
  bills: Bill[];
}>();

const search = ref('');
const statusFilter = ref('');
const sortBy = ref('date_desc');
const billToDelete = ref<number | null>(null);
const isDeleting = ref(false);

const filteredBills = computed(() => {
  let result = [...props.bills];

  // Apply search filter
  if (search.value) {
    const searchTerm = search.value.toLowerCase();
    result = result.filter((bill) =>
      bill.record_number.toLowerCase().includes(searchTerm) ||
      bill.client_name.toLowerCase().includes(searchTerm) ||
      bill.status.toLowerCase().includes(searchTerm)
    );
  }

  // Apply status filter
  if (statusFilter.value) {
    result = result.filter((bill) => bill.status === statusFilter.value);
  }

  // Apply sorting
  result.sort((a, b) => {
    switch (sortBy.value) {
      case 'date_asc':
        return new Date(a.start_date).getTime() - new Date(b.start_date).getTime();
      case 'date_desc':
        return new Date(b.start_date).getTime() - new Date(a.start_date).getTime();
      case 'amount_asc':
        return parseFloat(a.value_after_vat) - parseFloat(b.value_after_vat);
      case 'amount_desc':
        return parseFloat(b.value_after_vat) - parseFloat(a.value_after_vat);
      default:
        return 0;
    }
  });

  return result;
});

const formatDate = (date: string) => {
  return new Date(date).toLocaleDateString();
};

const getStatusVariant = (status: string) => {
  switch (status) {
    case 'paid':
      return 'success';
    case 'pending':
      return 'warning';
    case 'overdue':
      return 'destructive';
    default:
      return 'secondary';
  }
};

const refreshData = () => {
  router.reload();
};

const confirmDelete = (id: number) => {
  billToDelete.value = id;
};

const deleteBill = async () => {
  if (!billToDelete.value) return;

  isDeleting.value = true;
  router.delete(route('bills.destroy', billToDelete.value), {
    onSuccess: () => {
      billToDelete.value = null;
      isDeleting.value = false;
    },
    onError: () => {
      isDeleting.value = false;
    },
  });
};
</script> 