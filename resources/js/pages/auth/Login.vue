<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';

defineProps<{
    status?: string;
    canResetPassword: boolean;
}>();

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <div class="min-h-screen bg-gradient-to-b from-[#f8f9fa] to-white dark:from-[#1a202c] dark:to-[#171923] flex flex-col justify-center relative overflow-hidden">
        <Head title="Log in" />

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
                                Welcome back!
                            </h2>
                            <p class="text-white/80 text-lg max-w-md">
                                Log in to access your dashboard and continue managing vendor invoices efficiently.
                            </p>
                        </div>

                        <!-- Decorative Elements -->
                        <div class="absolute -bottom-16 -right-16 w-64 h-64 rounded-full border border-white/10"></div>
                        <div class="absolute -bottom-8 -right-8 w-48 h-48 rounded-full border border-white/10"></div>

                        <!-- Benefits Points -->
                        <div class="mt-auto">
                            <div class="space-y-4 mt-12">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <span class="text-white/90">Access your vendor management dashboard</span>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <span class="text-white/90">View and manage your invoices securely</span>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <span class="text-white/90">Generate reports for your financial data</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Side - Form -->
                    <div class="lg:w-1/2 bg-white dark:bg-[#1a202c] p-8 lg:p-12">
                        <div class="max-w-md mx-auto">
                            <h2 class="text-3xl font-bold text-[#28536B] dark:text-white mb-2">
                                Log in to your account
                            </h2>
                            <p class="text-[#28536B]/70 dark:text-gray-400 mb-8">
                                Enter your credentials below to access your dashboard
                            </p>

                            <div v-if="status" class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-900/30 rounded-lg text-green-700 dark:text-green-400 text-sm font-medium">
                                {{ status }}
                            </div>

                            <form @submit.prevent="submit" class="space-y-6">
                                <div class="space-y-4">
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
                        autofocus
                        :tabindex="1"
                        autocomplete="email"
                        v-model="form.email"
                                            placeholder="your.email@example.com"
                                            class="bg-[#EDF2F4]/50 border-[#28536B]/20 focus:border-[#19647E] focus:ring-[#19647E]/20 dark:bg-[#28536B]/10 dark:border-[#28536B]/30 dark:focus:ring-[#A9D8B8]/20 dark:focus:border-[#A9D8B8] h-12"
                    />
                    <InputError :message="form.errors.email" />
                </div>

                                    <div class="space-y-2">
                    <div class="flex items-center justify-between">
                                            <Label for="password" class="text-[#28536B] dark:text-white font-medium flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-[#19647E] dark:text-[#A9D8B8]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                                </svg>
                                                Password
                                            </Label>
                                            <TextLink
                                                v-if="canResetPassword"
                                                :href="route('password.request')"
                                                class="text-sm font-medium text-[#19647E] hover:text-[#28536B] dark:text-[#A9D8B8] dark:hover:text-[#BFDBF7] transition-colors"
                                                :tabindex="4"
                                            >
                            Forgot password?
                        </TextLink>
                    </div>
                    <Input
                        id="password"
                        type="password"
                        required
                        :tabindex="2"
                        autocomplete="current-password"
                        v-model="form.password"
                                            placeholder="Enter your password"
                                            class="bg-[#EDF2F4]/50 border-[#28536B]/20 focus:border-[#19647E] focus:ring-[#19647E]/20 dark:bg-[#28536B]/10 dark:border-[#28536B]/30 dark:focus:ring-[#A9D8B8]/20 dark:focus:border-[#A9D8B8] h-12"
                    />
                    <InputError :message="form.errors.password" />
                </div>

                                    <div class="flex items-center" :tabindex="3">
                                        <Label for="remember" class="flex items-center space-x-3 text-[#28536B]/80 dark:text-gray-300 cursor-pointer">
                                            <Checkbox
                                                id="remember"
                                                v-model="form.remember"
                                                class="text-[#19647E] border-[#28536B]/30 focus:ring-[#19647E]/20 dark:border-gray-600 dark:bg-[#28536B]/10"
                                                :tabindex="3"
                                            />
                        <span>Remember me</span>
                    </Label>
                </div>
                                </div>

                                <button
                                    type="submit"
                                    class="w-full py-4 rounded-lg bg-gradient-to-r from-[#19647E] to-[#28536B] text-white font-medium hover:from-[#28536B] hover:to-[#19647E] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#19647E] transition-all duration-300 transform hover:-translate-y-0.5 shadow-lg hover:shadow-xl disabled:opacity-70 disabled:cursor-not-allowed disabled:hover:translate-y-0 flex items-center justify-center space-x-2"
                                    tabindex="4"
                                    :disabled="form.processing"
                                >
                                    <LoaderCircle v-if="form.processing" class="h-5 w-5 animate-spin" />
                                    <span v-else>Sign in to Dashboard</span>
                                    <svg v-if="!form.processing" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>

                                <div class="text-center text-[#28536B]/70 dark:text-gray-400 flex items-center justify-center">
                                    <span class="h-px bg-gray-200 dark:bg-gray-700 w-12"></span>
                                    <span class="px-4">Don't have an account?</span>
                                    <span class="h-px bg-gray-200 dark:bg-gray-700 w-12"></span>
            </div>

                                <a :href="route('register')" class="block w-full py-3 rounded-lg border-2 border-[#19647E] dark:border-[#A9D8B8] text-[#19647E] dark:text-[#A9D8B8] text-center font-medium hover:bg-[#19647E]/5 dark:hover:bg-[#A9D8B8]/5 transition-colors duration-200">
                                    Create an account
                                </a>
                            </form>

                            <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                                <p class="text-xs text-center text-[#28536B]/60 dark:text-gray-500">
                                    By logging in, you agree to our
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
