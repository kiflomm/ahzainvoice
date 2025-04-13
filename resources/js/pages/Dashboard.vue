<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, type SharedData } from '@/types';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { ArrowDownToLine, ArrowUpFromLine, Users, FileDown } from 'lucide-vue-next';
import { computed } from 'vue';

const page = usePage<SharedData>();
const authUser = computed(() => page.props.auth.user);
const userRole = computed(() => authUser.value.role || 'user');

// Check if user has admin role
const isAdmin = computed(() => userRole.value === 'admin');

// Check if user has permission to manage records (admin or employee)
const canManageRecords = computed(() => ['admin', 'employee'].includes(userRole.value));

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

interface Props {
    stats: {
        totalRecords: number;
        totalAmount: string;
        pendingRecords: number;
        pendingAmount: string;
        overdueRecords: number;
        overdueAmount: string;
    };
    recentRecords: {
        id: number;
        number: string;
        type: 'invoice' | 'bill';
        client: string;
        date: string;
        amount: string;
        status: 'pending' | 'paid' | 'overdue';
    }[];
}

defineProps<Props>();
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-col gap-6 p-6">
            <!-- Quick Actions -->
            <div class="rounded-lg bg-white p-6 shadow-sm dark:bg-[#1a202c]">
                <h3 class="text-lg font-medium text-[#28536B] dark:text-white">Quick Actions</h3>
                <div class="mt-4 flex flex-wrap gap-3">
                    <!-- Invoice and Bill actions (Admin and Employee only) -->
                    <template v-if="canManageRecords">
                        <Link 
                            :href="route('invoices.create')" 
                            class="inline-flex items-center rounded-md bg-white px-4 py-2 text-sm font-medium text-[#28536B] border border-gray-300 hover:bg-[#EDF2F4] dark:bg-[#1a202c] dark:text-gray-200 dark:border-gray-600 dark:hover:bg-[#28536B]/20"
                        >
                            <ArrowDownToLine class="-ml-1 mr-2 h-5 w-5 text-emerald-600" />
                            Add Invoice
                        </Link>
                        <Link 
                            :href="route('bills.create')" 
                            class="inline-flex items-center rounded-md bg-white px-4 py-2 text-sm font-medium text-[#28536B] border border-gray-300 hover:bg-[#EDF2F4] dark:bg-[#1a202c] dark:text-gray-200 dark:border-gray-600 dark:hover:bg-[#28536B]/20"
                        >
                            <ArrowUpFromLine class="-ml-1 mr-2 h-5 w-5 text-red-600" />
                            Add Bill
                        </Link>
                    </template>
                    
                    <!-- User Management (Admin only) -->
                    <Link 
                        v-if="isAdmin"
                        :href="route('users.index')" 
                        class="inline-flex items-center rounded-md bg-white px-4 py-2 text-sm font-medium text-[#28536B] border border-gray-300 hover:bg-[#EDF2F4] dark:bg-[#1a202c] dark:text-gray-200 dark:border-gray-600 dark:hover:bg-[#28536B]/20"
                    >
                        <Users class="-ml-1 mr-2 h-5 w-5 text-blue-600" />
                        Manage Users
                    </Link>
                    
                    <!-- Export Data (Available to all) -->
                    <button 
                        class="inline-flex items-center rounded-md bg-white px-4 py-2 text-sm font-medium text-[#28536B] border border-gray-300 hover:bg-[#EDF2F4] dark:bg-[#1a202c] dark:text-gray-200 dark:border-gray-600 dark:hover:bg-[#28536B]/20"
                    >
                        <FileDown class="-ml-1 mr-2 h-5 w-5 text-purple-600" />
                        Export Data
                    </button>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                <!-- Total Records -->
                <div class="rounded-lg bg-white p-6 shadow-sm dark:bg-[#1a202c]">
                    <div class="flex items-center">
                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-[#EDF2F4] dark:bg-[#28536B]/30">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#19647E] dark:text-[#A9D8B8]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-[#28536B]/70 dark:text-gray-400">Total Records</h3>
                            <div class="mt-1 flex items-baseline">
                                <p class="text-2xl font-semibold text-[#28536B] dark:text-white">{{ stats.totalRecords }}</p>
                                <p class="ml-2 text-sm text-[#28536B]/80 dark:text-gray-400">records</p>
                            </div>
                            <p class="mt-1 text-sm font-medium text-[#28536B] dark:text-white">{{ stats.totalAmount }}</p>
                        </div>
                    </div>
                </div>

                <!-- Pending Records -->
                <div class="rounded-lg bg-white p-6 shadow-sm dark:bg-[#1a202c]">
                    <div class="flex items-center">
                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-yellow-100 dark:bg-yellow-900/30">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600 dark:text-yellow-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-[#28536B]/70 dark:text-gray-400">Pending Records</h3>
                            <div class="mt-1 flex items-baseline">
                                <p class="text-2xl font-semibold text-[#28536B] dark:text-white">{{ stats.pendingRecords }}</p>
                                <p class="ml-2 text-sm text-[#28536B]/80 dark:text-gray-400">records</p>
                            </div>
                            <p class="mt-1 text-sm font-medium text-[#28536B] dark:text-white">{{ stats.pendingAmount }}</p>
                        </div>
                    </div>
                </div>

                <!-- Overdue Records -->
                <div class="rounded-lg bg-white p-6 shadow-sm dark:bg-[#1a202c]">
                    <div class="flex items-center">
                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-red-100 dark:bg-red-900/30">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600 dark:text-red-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-[#28536B]/70 dark:text-gray-400">Overdue Records</h3>
                            <div class="mt-1 flex items-baseline">
                                <p class="text-2xl font-semibold text-[#28536B] dark:text-white">{{ stats.overdueRecords }}</p>
                                <p class="ml-2 text-sm text-[#28536B]/80 dark:text-gray-400">records</p>
                            </div>
                            <p class="mt-1 text-sm font-medium text-[#28536B] dark:text-white">{{ stats.overdueAmount }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Records -->
            <div class="rounded-lg bg-white shadow-sm dark:bg-[#1a202c]">
                <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-medium text-[#28536B] dark:text-white">Recent Records</h3>
                    <p class="mt-1 text-sm text-[#28536B]/70 dark:text-gray-400">A list of your most recent records.</p>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-[#EDF2F4] dark:bg-[#28536B]/10">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-[#28536B]/70 dark:text-gray-400">
                                    #
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-[#28536B]/70 dark:text-gray-400">
                                    Type
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-[#28536B]/70 dark:text-gray-400">
                                    Client
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-[#28536B]/70 dark:text-gray-400">
                                    Date
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-[#28536B]/70 dark:text-gray-400">
                                    Amount
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-[#28536B]/70 dark:text-gray-400">
                                    Status
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            <tr v-for="record in recentRecords" :key="record.id" class="hover:bg-[#EDF2F4]/50 dark:hover:bg-[#28536B]/10">
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="text-sm font-medium text-[#28536B] dark:text-white">{{ record.number }}</div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="flex items-center">
                                        <ArrowDownToLine v-if="record.type === 'invoice'" class="h-4 w-4 text-emerald-600 mr-2" />
                                        <ArrowUpFromLine v-else class="h-4 w-4 text-red-600 mr-2" />
                                        <span class="text-sm font-medium text-[#28536B] dark:text-white capitalize">{{ record.type }}</span>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="text-sm text-[#28536B]/70 dark:text-gray-400">{{ record.client }}</div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="text-sm text-[#28536B]/70 dark:text-gray-400">{{ record.date }}</div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="text-sm font-medium text-[#28536B] dark:text-white">${{ record.amount }}</div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <span
                                        :class="[
                                            'inline-flex rounded-full px-2 text-xs font-semibold leading-5',
                                            {
                                                'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300': record.status === 'paid',
                                                'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-300': record.status === 'pending',
                                                'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300': record.status === 'overdue'
                                            }
                                        ]"
                                    >
                                        {{ record.status }}
                                    </span>
                                </td>
                            </tr>
                            <tr v-if="recentRecords.length === 0">
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                    No records found
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="flex justify-center px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                    <Link :href="route('records.index')" class="text-sm font-medium text-[#19647E] hover:text-[#28536B] dark:text-[#A9D8B8] dark:hover:text-[#BFDBF7]">
                        View all records
                    </Link>
                </div>
            </div>

            <!-- Record Summary -->
            <div class="rounded-lg bg-white p-6 shadow-sm dark:bg-[#1a202c]">
                <h3 class="text-lg font-medium text-[#28536B] dark:text-white">Record Summary</h3>
                <div class="mt-4 space-y-3">
                    <div class="flex justify-between">
                        <span class="text-sm text-[#28536B]/70 dark:text-gray-400">Paid Records</span>
                        <span class="text-sm font-medium text-[#28536B] dark:text-white">38</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-[#28536B]/70 dark:text-gray-400">Pending Records</span>
                        <span class="text-sm font-medium text-[#28536B] dark:text-white">12</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-[#28536B]/70 dark:text-gray-400">Overdue Records</span>
                        <span class="text-sm font-medium text-[#28536B] dark:text-white">3</span>
                    </div>
                    <div class="pt-3 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-[#28536B] dark:text-white">Total Outstanding</span>
                            <span class="text-sm font-medium text-[#28536B] dark:text-white">$5,440.50</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
