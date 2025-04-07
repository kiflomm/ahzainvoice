<script setup lang="ts">
import { Head, Link, usePage } from '@inertiajs/vue3';

interface PageProps {
  auth: {
    user: any;
  };
  [key: string]: any;
}

const page = usePage<PageProps>();
</script>

<template>
  <Head title="Ahaz platforms" />

  <div class="min-h-screen bg-gradient-to-b from-[#f8f9fa] to-white dark:from-[#1a202c] dark:to-[#171923]">
    <!-- Header -->
    <header class="bg-white/80 backdrop-blur-sm shadow-sm dark:bg-[#1a202c]/80 sticky top-0 z-50">
      <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8 flex justify-between items-center">
        <div class="flex items-center space-x-2">
          <div class="h-10 w-10 rounded-lg bg-[#19647E] flex items-center justify-center">
            <span class="text-xl font-bold text-white">A</span>
          </div>
          <h1 class="text-2xl font-bold tracking-tight text-[#28536B] dark:text-white">Ahaz Platforms</h1>
        </div>

        <nav class="flex gap-3">
                <Link
            v-if="page.props.auth.user"
                    :href="route('dashboard')"
            class="rounded-md bg-[#19647E] px-4 py-2 text-sm font-medium text-white hover:bg-[#28536B] transition-colors duration-200 shadow-sm hover:shadow"
                >
                    Dashboard
                </Link>
                <template v-else>
                    <Link
                        :href="route('login')"
              class="rounded-md bg-white px-4 py-2 text-sm font-medium text-[#28536B] hover:text-[#19647E] dark:bg-[#1a202c] dark:text-gray-300 dark:hover:text-white border border-gray-200 dark:border-gray-700 transition-all duration-200 hover:shadow"
                    >
              Login as Admin
                    </Link>
                    <Link
                        :href="route('register')"
              class="rounded-md bg-[#19647E] px-4 py-2 text-sm font-medium text-white hover:bg-[#28536B] transition-colors duration-200 shadow-sm hover:shadow"
                    >
              Create Admin Account
                    </Link>
                </template>
            </nav>
      </div>
        </header>

    <!-- Main Content -->
    <main>
      <!-- Hero Section -->
      <div class="relative overflow-hidden pt-16 pb-24">
        <div class="absolute inset-0 z-0">
          <div class="absolute inset-0 bg-gradient-to-r from-[#EDF2F4]/30 to-[#BFDBF7]/30 dark:from-[#28536B]/20 dark:to-[#19647E]/20 opacity-50"></div>
          <div class="absolute bottom-0 left-0 right-0 h-32 bg-gradient-to-t from-white dark:from-[#1a202c]"></div>
          <div class="absolute inset-0 opacity-30">
            <svg class="h-full w-full" viewBox="0 0 100 100" preserveAspectRatio="none">
              <defs>
                <pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse">
                  <path d="M 10 0 L 0 0 0 10" fill="none" stroke="rgba(40, 83, 107, 0.2)" stroke-width="0.5"></path>
                </pattern>
              </defs>
              <rect width="100" height="100" fill="url(#grid)"></rect>
            </svg>
          </div>
        </div>

        <div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div class="text-center">
            <h2 class="text-5xl font-bold tracking-tight text-[#28536B] dark:text-white mb-6">
              <span class="bg-clip-text text-transparent bg-gradient-to-r from-[#19647E] to-[#28536B] dark:from-[#BFDBF7] dark:to-[#A9D8B8]">Invoice Management System</span>
            </h2>
            <p class="mx-auto mt-6 max-w-2xl text-xl text-[#28536B]/80 dark:text-gray-300 leading-relaxed">
              A streamlined system to record, track, and analyze invoices for our clients.
            </p>

            <div class="mt-12">
              <Link
                :href="page.props.auth.user ? route('dashboard') : route('register')"
                class="inline-flex items-center justify-center rounded-md bg-[#19647E] px-6 py-3 text-base font-medium text-white shadow-lg hover:bg-[#28536B] transition-all duration-200 transform hover:-translate-y-1"
              >
                {{ page.props.auth.user ? 'Go to Dashboard' : 'Get Started' }}
                <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
              </Link>
            </div>
          </div>
        </div>
      </div>

      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 -mt-16 relative z-20">
        <!-- Features -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-24">
          <div class="bg-white rounded-xl shadow-md dark:bg-[#1a202c] p-8 transform transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
            <div class="h-14 w-14 rounded-xl bg-gradient-to-br from-[#19647E] to-[#28536B] flex items-center justify-center mb-6 shadow-md">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
              </svg>
            </div>
            <h3 class="text-xl font-semibold text-[#28536B] dark:text-white mb-3">Client Management</h3>
            <p class="text-[#28536B]/80 dark:text-gray-300 leading-relaxed">
              Organize client details and track their invoice history in one centralized system.
            </p>
          </div>

          <div class="bg-white rounded-xl shadow-md dark:bg-[#1a202c] p-8 transform transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
            <div class="h-14 w-14 rounded-xl bg-gradient-to-br from-[#19647E] to-[#28536B] flex items-center justify-center mb-6 shadow-md">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
            </div>
            <h3 class="text-xl font-semibold text-[#28536B] dark:text-white mb-3">Payment Tracking</h3>
            <p class="text-[#28536B]/80 dark:text-gray-300 leading-relaxed">
              Keep track of payment status, due dates, and never miss a payment deadline again.
            </p>
          </div>

          <div class="bg-white rounded-xl shadow-md dark:bg-[#1a202c] p-8 transform transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
            <div class="h-14 w-14 rounded-xl bg-gradient-to-br from-[#19647E] to-[#28536B] flex items-center justify-center mb-6 shadow-md">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
              </svg>
            </div>
            <h3 class="text-xl font-semibold text-[#28536B] dark:text-white mb-3">Data Export</h3>
            <p class="text-[#28536B]/80 dark:text-gray-300 leading-relaxed">
              Generate CSV reports for accounting, auditing, and financial analysis purposes.
            </p>
          </div>
        </div>

        <!-- Why Choose Us Section -->
        <div class="mb-24">

          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="p-6 text-center">
              <div class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-[#EDF2F4] text-[#19647E] dark:bg-[#28536B]/30 dark:text-[#A9D8B8] mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
              </div>
              <h3 class="text-lg font-medium text-[#28536B] dark:text-white mb-2">Easy to Use</h3>
              <p class="text-[#28536B]/80 dark:text-gray-400">Intuitive interface designed with users in mind</p>
            </div>

            <div class="p-6 text-center">
              <div class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-[#EDF2F4] text-[#19647E] dark:bg-[#28536B]/30 dark:text-[#A9D8B8] mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
              </div>
              <h3 class="text-lg font-medium text-[#28536B] dark:text-white mb-2">Secure</h3>
              <p class="text-[#28536B]/80 dark:text-gray-400">Our financial data is protected with enterprise-grade security</p>
            </div>

            <div class="p-6 text-center">
              <div class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-[#EDF2F4] text-[#19647E] dark:bg-[#28536B]/30 dark:text-[#A9D8B8] mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
              </div>
              <h3 class="text-lg font-medium text-[#28536B] dark:text-white mb-2">Fast</h3>
              <p class="text-[#28536B]/80 dark:text-gray-400">Optimized performance for quick data processing</p>
            </div>

            <div class="p-6 text-center">
              <div class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-[#EDF2F4] text-[#19647E] dark:bg-[#28536B]/30 dark:text-[#A9D8B8] mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
              </div>
              <h3 class="text-lg font-medium text-[#28536B] dark:text-white mb-2">Automated</h3>
              <p class="text-[#28536B]/80 dark:text-gray-400">Reduces manual work with smart automation features</p>
            </div>
          </div>
        </div>
      </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white shadow-inner dark:bg-[#1a202c] pt-16 pb-8">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 w-full items-start">
          <!-- Company Info -->
          <div class="space-y-8">
            <div class="flex items-center space-x-3">
              <div class="h-10 w-10 rounded-lg bg-[#19647E] flex items-center justify-center shadow-md transform transition-transform duration-300 hover:scale-110">
                <span class="text-xl font-bold text-white">A</span>
              </div>
              <h3 class="text-2xl font-bold text-[#19647E] dark:text-[#A9D8B8]">Ahaz Platforms</h3>
            </div>
            <p class="text-[#28536B]/80 dark:text-gray-400 max-w-md leading-relaxed">
              Streamlining client invoice management for modern businesses.
            </p>
            <div class="flex space-x-6">
              <a href="#" class="text-[#28536B]/60 hover:text-[#19647E] dark:text-gray-400 dark:hover:text-[#A9D8B8] transition-all duration-200 transform hover:scale-110">
                <span class="sr-only">Twitter</span>
                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"/>
                </svg>
              </a>
              <a href="#" class="text-[#28536B]/60 hover:text-[#19647E] dark:text-gray-400 dark:hover:text-[#A9D8B8] transition-all duration-200 transform hover:scale-110">
                <span class="sr-only">LinkedIn</span>
                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-.88-.06-1.601-1-1.601-1 0-1.15.781-1.15 1.601v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                </svg>
              </a>
              <a href="#" class="text-[#28536B]/60 hover:text-[#19647E] dark:text-gray-400 dark:hover:text-[#A9D8B8] transition-all duration-200 transform hover:scale-110">
                <span class="sr-only">GitHub</span>
                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                  <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" />
                                    </svg>
                                </a>
              <a href="#" class="text-[#28536B]/60 hover:text-[#19647E] dark:text-gray-400 dark:hover:text-[#A9D8B8] transition-all duration-200 transform hover:scale-110">
                <span class="sr-only">Instagram</span>
                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                  <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" />
                                    </svg>
                                </a>
            </div>
          </div>

          <!-- Quick Links -->
          <div class="grid grid-cols-1 gap-8">
            <div class="space-y-6 md:ml-auto md:w-56">
              <h3 class="text-lg font-semibold text-[#28536B] dark:text-white relative after:absolute after:w-12 after:h-0.5 after:bg-[#19647E] after:bottom-0 after:left-0 after:rounded-full pb-2">Navigation</h3>
              <ul class="space-y-4">
                <li>
                  <Link :href="route('dashboard')" class="text-[#28536B]/80 hover:text-[#19647E] dark:text-gray-400 dark:hover:text-[#A9D8B8] transition-colors duration-200 flex items-center group">
                    <span class="w-0 h-0.5 bg-[#19647E] dark:bg-[#A9D8B8] transition-all duration-300 mr-0 group-hover:w-3 group-hover:mr-2"></span>
                    Dashboard
                  </Link>
                </li>
                <li>
                  <Link :href="route('clients.index')" class="text-[#28536B]/80 hover:text-[#19647E] dark:text-gray-400 dark:hover:text-[#A9D8B8] transition-colors duration-200 flex items-center group">
                    <span class="w-0 h-0.5 bg-[#19647E] dark:bg-[#A9D8B8] transition-all duration-300 mr-0 group-hover:w-3 group-hover:mr-2"></span>
                    Clients
                  </Link>
                        </li>
                <li>
                  <Link :href="route('invoices.index')" class="text-[#28536B]/80 hover:text-[#19647E] dark:text-gray-400 dark:hover:text-[#A9D8B8] transition-colors duration-200 flex items-center group">
                    <span class="w-0 h-0.5 bg-[#19647E] dark:bg-[#A9D8B8] transition-all duration-300 mr-0 group-hover:w-3 group-hover:mr-2"></span>
                    Invoices
                  </Link>
                        </li>
                    </ul>
                </div>
          </div>
        </div>

        <!-- Copyright -->
        <div class="mt-16 pt-8 border-t border-gray-200 dark:border-gray-700 relative">
          <div class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white dark:bg-[#1a202c] px-8 py-1">
            <div class="flex space-x-3 items-center">
              <div class="h-2 w-2 rounded-full bg-[#19647E]/30 dark:bg-[#A9D8B8]/30"></div>
              <div class="h-2 w-2 rounded-full bg-[#19647E]/60 dark:bg-[#A9D8B8]/60"></div>
              <div class="h-2 w-2 rounded-full bg-[#19647E] dark:bg-[#A9D8B8]"></div>
            </div>
                </div>
          <p class="text-sm text-[#28536B]/60 dark:text-gray-400 text-center">
            &copy; {{ new Date().getFullYear() }} Ahaz Platforms. All rights reserved.
          </p>
        </div>
      </div>
    </footer>
    </div>
</template>

