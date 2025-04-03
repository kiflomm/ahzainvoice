<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';

defineProps<{
    status?: string;
}>();

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <div class="min-h-screen bg-gradient-to-b from-[#f8f9fa] to-white dark:from-[#1a202c] dark:to-[#171923] flex flex-col justify-center relative overflow-hidden">
        <Head title="Reset Password" />

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
                                Forgot your password?
                            </h2>
                            <p class="text-white/80 text-lg max-w-md">
                                No worries. We'll send you a secure link to reset your password and get you back to managing invoices.
                            </p>
                        </div>

                        <!-- Decorative Elements -->
                        <div class="absolute -bottom-16 -right-16 w-64 h-64 rounded-full border border-white/10"></div>
                        <div class="absolute -bottom-8 -right-8 w-48 h-48 rounded-full border border-white/10"></div>

                        <!-- Key Icon -->
                        <div class="mt-auto flex justify-center lg:justify-start">
                            <div class="w-32 h-32 relative">
                                <div class="absolute inset-0 flex items-center justify-center opacity-70">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Side - Form -->
                    <div class="lg:w-1/2 bg-white dark:bg-[#1a202c] p-8 lg:p-12">
                        <div class="max-w-md mx-auto">
                            <h2 class="text-3xl font-bold text-[#28536B] dark:text-white mb-2">
                                Reset your password
                            </h2>
                            <p class="text-[#28536B]/70 dark:text-gray-400 mb-8">
                                Enter your email address below and we'll send you a link to reset your password
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
                                            name="email"
                                            required
                                            autofocus
                                            autocomplete="email"
                                            v-model="form.email"
                                            placeholder="your.email@example.com"
                                            class="bg-[#EDF2F4]/50 border-[#28536B]/20 focus:border-[#19647E] focus:ring-[#19647E]/20 dark:bg-[#28536B]/10 dark:border-[#28536B]/30 dark:focus:ring-[#A9D8B8]/20 dark:focus:border-[#A9D8B8] h-12"
                                        />
                                        <InputError :message="form.errors.email" />
                                    </div>
                                </div>

                                <button
                                    type="submit"
                                    class="w-full py-4 rounded-lg bg-gradient-to-r from-[#19647E] to-[#28536B] text-white font-medium hover:from-[#28536B] hover:to-[#19647E] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#19647E] transition-all duration-300 transform hover:-translate-y-0.5 shadow-lg hover:shadow-xl disabled:opacity-70 disabled:cursor-not-allowed disabled:hover:translate-y-0 flex items-center justify-center space-x-2"
                                    :disabled="form.processing"
                                >
                                    <LoaderCircle v-if="form.processing" class="h-5 w-5 animate-spin" />
                                    <span v-else>Send Reset Link</span>
                                    <svg v-if="!form.processing" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11h2a1 1 0 00.894-.553l7-14A1 1 0 0017.894 1.1l-5 1.429A1 1 0 0012 3.571V8h-2a1 1 0 00-.894.553z" />
                                    </svg>
                                </button>

                                <div class="text-center text-[#28536B]/70 dark:text-gray-400 flex items-center justify-center">
                                    <span class="h-px bg-gray-200 dark:bg-gray-700 w-12"></span>
                                    <span class="px-4">Or</span>
                                    <span class="h-px bg-gray-200 dark:bg-gray-700 w-12"></span>
                                </div>

                                <a :href="route('login')" class="block w-full py-3 rounded-lg border-2 border-[#19647E] dark:border-[#A9D8B8] text-[#19647E] dark:text-[#A9D8B8] text-center font-medium hover:bg-[#19647E]/5 dark:hover:bg-[#A9D8B8]/5 transition-colors duration-200">
                                    Back to Login
                                </a>
                            </form>

                            <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                                <p class="text-xs text-center text-[#28536B]/60 dark:text-gray-500">
                                    Need help? Contact our
                                    <a href="#" class="text-[#19647E] dark:text-[#A9D8B8] hover:underline">support team</a>
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
