<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

// Mock data for development - will be replaced with actual API calls
const stats = {
    totalRecords: 53,
    totalAmount: '$15,240.65',
    pendingRecords: 12,
    pendingAmount: '$4,320.00',
    overdueRecords: 3,
    overdueAmount: '$1,120.50'
};

const recentRecords = [
    { id: 1, number: 'REC-001', type: 'invoice', client: 'TechSupplies Inc.', date: '2025-04-01', amount: '$540.25', status: 'paid' },
    { id: 2, number: 'REC-002', type: 'bill', client: 'Office Solutions', date: '2025-04-02', amount: '$890.00', status: 'pending' },
    { id: 3, number: 'REC-003', type: 'invoice', client: 'Hardware Depot', date: '2025-03-28', amount: '$1,250.75', status: 'overdue' },
    { id: 4, number: 'REC-004', type: 'bill', client: 'Paper Plus', date: '2025-04-03', amount: '$320.50', status: 'pending' },
    { id: 5, number: 'REC-005', type: 'invoice', client: 'Tech Services Inc.', date: '2025-04-01', amount: '$750.00', status: 'paid' },
];
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-col gap-6 p-6">
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
                                    Record
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
                                    <div class="text-sm font-medium text-[#28536B] dark:text-white capitalize">{{ record.type }}</div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="text-sm text-[#28536B]/70 dark:text-gray-400">{{ record.client }}</div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="text-sm text-[#28536B]/70 dark:text-gray-400">{{ record.date }}</div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="text-sm font-medium text-[#28536B] dark:text-white">{{ record.amount }}</div>
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
                        </tbody>
                    </table>
                </div>
                <div class="flex justify-center px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                    <Link :href="route('records.index')" class="text-sm font-medium text-[#19647E] hover:text-[#28536B] dark:text-[#A9D8B8] dark:hover:text-[#BFDBF7]">
                        View all records
                    </Link>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div class="rounded-lg bg-white p-6 shadow-sm dark:bg-[#1a202c]">
                    <h3 class="text-lg font-medium text-[#28536B] dark:text-white">Quick Actions</h3>
                    <div class="mt-4 flex flex-wrap gap-3">
                        <Link :href="route('records.create')" class="inline-flex items-center rounded-md bg-[#19647E] px-4 py-2 text-sm font-medium text-white hover:bg-[#28536B]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            New Record
                        </Link>
                        <Link :href="route('clients.index')" class="inline-flex items-center rounded-md bg-white px-4 py-2 text-sm font-medium text-[#28536B] border border-gray-300 hover:bg-[#EDF2F4] dark:bg-[#1a202c] dark:text-gray-200 dark:border-gray-600 dark:hover:bg-[#28536B]/20">
                            <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                            </svg>
                            Manage Clients
                        </Link>
                        <a href="#" class="inline-flex items-center rounded-md bg-white px-4 py-2 text-sm font-medium text-[#28536B] border border-gray-300 hover:bg-[#EDF2F4] dark:bg-[#1a202c] dark:text-gray-200 dark:border-gray-600 dark:hover:bg-[#28536B]/20">
                            <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                            </svg>
                            Export Data
                        </a>
                    </div>
                </div>

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
        </div>
    </AppLayout>
</template>
