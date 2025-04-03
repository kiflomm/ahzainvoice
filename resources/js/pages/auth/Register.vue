<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthBase from '@/layouts/AuthLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <div class="min-h-screen bg-gradient-to-b from-[#f8f9fa] to-white dark:from-[#1a202c] dark:to-[#171923] flex flex-col justify-center relative overflow-hidden">
        <Head title="Create Account" />

        <!-- Background Pattern -->
        <div class="absolute inset-0 z-0 overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-r from-[#EDF2F4]/30 to-[#BFDBF7]/30 dark:from-[#28536B]/20 dark:to-[#19647E]/20 opacity-50"></div>
            <div class="absolute top-0 right-0 w-1/3 h-full bg-[#19647E]/5 dark:bg-[#19647E]/10 transform -skew-x-12"></div>
            <div class="absolute bottom-0 left-0 w-1/3 h-full bg-[#28536B]/5 dark:bg-[#28536B]/10 transform skew-x-12"></div>
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

        <!-- Decorative Elements -->
        <div class="absolute top-1/4 left-10 w-20 h-20 rounded-full bg-gradient-to-r from-[#19647E]/10 to-[#28536B]/10 backdrop-blur-xl animate-float"></div>
        <div class="absolute bottom-1/4 right-20 w-32 h-32 rounded-full bg-gradient-to-r from-[#28536B]/10 to-[#19647E]/10 backdrop-blur-xl animate-float-delay"></div>

        <div class="container mx-auto px-4 py-8 relative z-10">
            <div class="max-w-6xl mx-auto">
                <div class="flex flex-col lg:flex-row rounded-3xl overflow-hidden shadow-2xl">
                    <!-- Left Side - Image/Brand -->
                    <div class="lg:w-1/2 bg-gradient-to-br from-[#19647E] to-[#28536B] p-8 lg:p-12 relative overflow-hidden flex flex-col justify-between">
                        <div>
                            <div class="flex items-center space-x-3 mb-8">
                                <div class="h-12 w-12 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center shadow-md">
                                    <span class="text-2xl font-bold text-white">A</span>
                                </div>
                                <h1 class="text-2xl font-bold text-white">Ahaz Platforms</h1>
                            </div>

                            <h2 class="text-3xl lg:text-4xl font-bold text-white mt-12 mb-4">
                                Start managing your invoices today
                            </h2>
                            <p class="text-white/80 text-lg max-w-md">
                                Join our platform and streamline your vendor invoice management process with our powerful tools.
                            </p>
                        </div>

                        <!-- Decorative Elements -->
                        <div class="absolute -bottom-16 -right-16 w-64 h-64 rounded-full border border-white/10"></div>
                        <div class="absolute -bottom-8 -right-8 w-48 h-48 rounded-full border border-white/10"></div>

                        <!-- Feature Points -->
                        <div class="mt-auto">
                            <div class="space-y-4 mt-12">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <span class="text-white/90">Organize vendor details and invoices</span>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <span class="text-white/90">Track payment statuses and deadlines</span>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <span class="text-white/90">Export data for financial analysis</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Side - Form -->
                    <div class="lg:w-1/2 bg-white dark:bg-[#1a202c] p-8 lg:p-12">
                        <div class="max-w-md mx-auto">
                            <h2 class="text-3xl font-bold text-[#28536B] dark:text-white mb-2">
                                Create your account
                            </h2>
                            <p class="text-[#28536B]/70 dark:text-gray-400 mb-8">
                                Enter your details below to get started
                            </p>

                            <form @submit.prevent="submit" class="space-y-6">
                                <div class="space-y-4">
                                    <div class="space-y-2">
                                        <Label for="name" class="text-[#28536B] dark:text-white font-medium flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-[#19647E] dark:text-[#A9D8B8]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            Full Name
                                        </Label>
                                        <Input
                                            id="name"
                                            type="text"
                                            required
                                            autofocus
                                            :tabindex="1"
                                            autocomplete="name"
                                            v-model="form.name"
                                            placeholder="Enter your full name"
                                            class="bg-[#EDF2F4]/50 border-[#28536B]/20 focus:border-[#19647E] focus:ring-[#19647E]/20 dark:bg-[#28536B]/10 dark:border-[#28536B]/30 dark:focus:ring-[#A9D8B8]/20 dark:focus:border-[#A9D8B8] h-12"
                                        />
                    <InputError :message="form.errors.name" />
                </div>

                                    <div class="space-y-2">
                                        <Label for="email" class="text-[#28536B] dark:text-white font-medium flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-[#19647E] dark:text-[#A9D8B8]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                            Email address
                                        </Label>
                                        <Input
                                            id="email"
                                            type="email"
                                            required
                                            :tabindex="2"
                                            autocomplete="email"
                                            v-model="form.email"
                                            placeholder="your.email@example.com"
                                            class="bg-[#EDF2F4]/50 border-[#28536B]/20 focus:border-[#19647E] focus:ring-[#19647E]/20 dark:bg-[#28536B]/10 dark:border-[#28536B]/30 dark:focus:ring-[#A9D8B8]/20 dark:focus:border-[#A9D8B8] h-12"
                                        />
                    <InputError :message="form.errors.email" />
                </div>

                                    <div class="space-y-2">
                                        <Label for="password" class="text-[#28536B] dark:text-white font-medium flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-[#19647E] dark:text-[#A9D8B8]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                            </svg>
                                            Password
                                        </Label>
                    <Input
                        id="password"
                        type="password"
                        required
                        :tabindex="3"
                        autocomplete="new-password"
                        v-model="form.password"
                                            placeholder="Create a secure password"
                                            class="bg-[#EDF2F4]/50 border-[#28536B]/20 focus:border-[#19647E] focus:ring-[#19647E]/20 dark:bg-[#28536B]/10 dark:border-[#28536B]/30 dark:focus:ring-[#A9D8B8]/20 dark:focus:border-[#A9D8B8] h-12"
                    />
                    <InputError :message="form.errors.password" />
                </div>

                                    <div class="space-y-2">
                                        <Label for="password_confirmation" class="text-[#28536B] dark:text-white font-medium flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-[#19647E] dark:text-[#A9D8B8]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                            </svg>
                                            Confirm password
                                        </Label>
                    <Input
                        id="password_confirmation"
                        type="password"
                        required
                        :tabindex="4"
                        autocomplete="new-password"
                        v-model="form.password_confirmation"
                                            placeholder="Confirm your password"
                                            class="bg-[#EDF2F4]/50 border-[#28536B]/20 focus:border-[#19647E] focus:ring-[#19647E]/20 dark:bg-[#28536B]/10 dark:border-[#28536B]/30 dark:focus:ring-[#A9D8B8]/20 dark:focus:border-[#A9D8B8] h-12"
                    />
                    <InputError :message="form.errors.password_confirmation" />
                </div>
                                </div>

                                <button
                                    type="submit"
                                    class="w-full py-4 rounded-lg bg-gradient-to-r from-[#19647E] to-[#28536B] text-white font-medium hover:from-[#28536B] hover:to-[#19647E] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#19647E] transition-all duration-300 transform hover:-translate-y-0.5 shadow-lg hover:shadow-xl disabled:opacity-70 disabled:cursor-not-allowed disabled:hover:translate-y-0 flex items-center justify-center space-x-2"
                                    tabindex="5"
                                    :disabled="form.processing"
                                >
                                    <LoaderCircle v-if="form.processing" class="h-5 w-5 animate-spin" />
                                    <span v-else>Create Your Account</span>
                                    <svg v-if="!form.processing" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>

                                <div class="text-center text-[#28536B]/70 dark:text-gray-400 flex items-center justify-center">
                                    <span class="h-px bg-gray-200 dark:bg-gray-700 w-12"></span>
                                    <span class="px-4">Already have an account?</span>
                                    <span class="h-px bg-gray-200 dark:bg-gray-700 w-12"></span>
            </div>

                                <a :href="route('login')" class="block w-full py-3 rounded-lg border-2 border-[#19647E] dark:border-[#A9D8B8] text-[#19647E] dark:text-[#A9D8B8] text-center font-medium hover:bg-[#19647E]/5 dark:hover:bg-[#A9D8B8]/5 transition-colors duration-200">
                                    Sign in to your account
                                </a>
                            </form>

                            <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                                <p class="text-xs text-center text-[#28536B]/60 dark:text-gray-500">
                                    By creating an account, you agree to our
                                    <a href="#" class="text-[#19647E] dark:text-[#A9D8B8] hover:underline">Terms of Service</a>
                                    and
                                    <a href="#" class="text-[#19647E] dark:text-[#A9D8B8] hover:underline">Privacy Policy</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
@keyframes float {
  0% { transform: translateY(0px); }
  50% { transform: translateY(-20px); }
  100% { transform: translateY(0px); }
}

@keyframes float-delay {
  0% { transform: translateY(0px); }
  50% { transform: translateY(-15px); }
  100% { transform: translateY(0px); }
}

.animate-float {
  animation: float 7s ease-in-out infinite;
}

.animate-float-delay {
  animation: float-delay 8s ease-in-out infinite;
}
</style>
