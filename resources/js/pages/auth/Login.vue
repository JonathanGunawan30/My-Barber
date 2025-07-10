<template>
    <div class="flex min-h-screen items-center justify-center bg-gray-50 p-4">
        <Head title="Log in" />

        <!-- Login Card -->
        <div class="w-full max-w-md">
            <div class="rounded-2xl border border-gray-200 bg-white p-8 shadow-xl">
                <!-- Header -->
                <div class="mb-8 text-center">
                    <!-- Logo/Icon -->
                    <div class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-xl bg-blue-600">
                        <Scissors class="h-6 w-6 text-white" />
                    </div>

                    <h1 class="mb-2 text-2xl font-bold text-gray-900">Welcome Back</h1>
                    <p class="text-sm text-gray-600">Sign in to your barbershop admin account</p>
                </div>

                <!-- Status Message -->
                <div v-if="status" class="mb-6 rounded-lg border border-green-200 bg-green-50 p-4 text-center">
                    <p class="text-sm font-medium text-green-700">{{ status }}</p>
                </div>

                <!-- Login Form -->
                <form @submit.prevent="submit" class="space-y-5">
                    <!-- Email Field -->
                    <div>
                        <label for="email" class="mb-2 block text-sm font-medium text-gray-700"> Email Address </label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <Mail class="h-5 w-5 text-gray-400" />
                            </div>
                            <input
                                id="email"
                                type="email"
                                required
                                autofocus
                                :tabindex="1"
                                autocomplete="email"
                                v-model="form.email"
                                placeholder="admin@barbershop.com"
                                class="w-full rounded-lg border border-gray-300 py-3 pr-4 pl-10 text-gray-900 placeholder-gray-500 transition-colors duration-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500"
                                :class="{ 'border-red-300 focus:border-red-500 focus:ring-red-500': form.errors.email }"
                            />
                        </div>
                        <p v-if="form.errors.email" class="mt-2 flex items-center gap-1 text-sm text-red-600">
                            <AlertCircle class="h-4 w-4" />
                            {{ form.errors.email }}
                        </p>
                    </div>

                    <!-- Password Field -->
                    <div>
                        <div class="mb-2 flex items-center justify-between">
                            <label for="password" class="block text-sm font-medium text-gray-700"> Password </label>
                            <TextLink
                                v-if="canResetPassword"
                                :href="route('password.request')"
                                class="text-sm text-blue-600 transition-colors duration-200 hover:text-blue-500"
                                :tabindex="5"
                            >
                                Forgot password?
                            </TextLink>
                        </div>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <Lock class="h-5 w-5 text-gray-400" />
                            </div>
                            <input
                                id="password"
                                :type="showPassword ? 'text' : 'password'"
                                required
                                :tabindex="2"
                                autocomplete="current-password"
                                v-model="form.password"
                                placeholder="Enter your password"
                                class="w-full rounded-lg border border-gray-300 py-3 pr-12 pl-10 text-gray-900 placeholder-gray-500 transition-colors duration-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500"
                                :class="{ 'border-red-300 focus:border-red-500 focus:ring-red-500': form.errors.password }"
                            />
                            <button
                                type="button"
                                @click="showPassword = !showPassword"
                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 transition-colors duration-200 hover:text-gray-600"
                            >
                                <Eye v-if="!showPassword" class="h-5 w-5" />
                                <EyeOff v-else class="h-5 w-5" />
                            </button>
                        </div>
                        <p v-if="form.errors.password" class="mt-2 flex items-center gap-1 text-sm text-red-600">
                            <AlertCircle class="h-4 w-4" />
                            {{ form.errors.password }}
                        </p>
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <input
                            id="remember"
                            type="checkbox"
                            v-model="form.remember"
                            :tabindex="3"
                            class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                        />
                        <label for="remember" class="ml-2 block text-sm text-gray-700"> Remember me </label>
                    </div>

                    <!-- Login Button -->
                    <button
                        type="submit"
                        :tabindex="4"
                        :disabled="form.processing"
                        class="flex w-full items-center justify-center gap-2 rounded-lg bg-blue-600 px-4 py-3 font-medium text-white transition-colors duration-200 hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50"
                    >
                        <LoaderCircle v-if="form.processing" class="h-5 w-5 animate-spin" />
                        <LogIn v-else class="h-5 w-5" />
                        {{ form.processing ? 'Signing in...' : 'Sign In' }}
                    </button>
                </form>

                <!-- Divider -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="bg-white px-2 text-gray-500">New to our platform?</span>
                    </div>
                </div>

                <!-- Register Link -->
                <div class="text-center">
                    <TextLink
                        :href="route('register')"
                        :tabindex="5"
                        class="inline-flex items-center gap-2 font-medium text-blue-600 transition-colors duration-200 hover:text-blue-500"
                    >
                        <UserPlus class="h-4 w-4" />
                        Create an account
                    </TextLink>
                </div>
            </div>

            <!-- Footer -->
            <footer class="shadow-t z-30 border-t border-gray-200 dark:border-gray-700">
                <div class="mx-auto flex h-12 max-w-7xl items-center justify-center px-4 sm:px-6 lg:px-8">
                    <p class="flex items-center text-xs text-gray-600 dark:text-gray-400">
                        &copy; {{ currentYear }} My Barber App. Developed by
                        <a
                            href="https://www.instagram.com/jo.nthn30"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="ml-1 font-medium text-blue-600 transition-colors duration-200 hover:text-blue-700 hover:underline hover:decoration-blue-600 dark:text-blue-400 dark:hover:text-blue-300 dark:hover:decoration-blue-400"
                        >
                            Jonathan Gunawan
                        </a>

                        <span class="mx-1 text-gray-400 dark:text-gray-500">|</span>
                        <a
                            href="https://github.com/jonathangunawan30"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="flex items-center font-medium text-blue-600 transition-colors duration-200 hover:text-blue-700 hover:underline hover:decoration-blue-600 dark:text-blue-400 dark:hover:text-blue-300 dark:hover:decoration-blue-400"
                        >
                            <Github :size="10" class="mr-1" />
                            GitHub
                        </a>
                    </p>
                </div>
            </footer>
        </div>
    </div>
</template>

<script setup lang="ts">
import { computed, onMounted, onUnmounted, ref } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import { route } from 'ziggy-js';

import { AlertCircle, Eye, EyeOff, Github, LoaderCircle, Lock, LogIn, Mail, Scissors, UserPlus } from 'lucide-vue-next';
import TextLink from '@/components/TextLink.vue';

const siteKey = import.meta.env.VITE_RECAPTCHA_SITE_KEY;

declare global {
    interface Window {
        grecaptcha: {
            ready: (callback: () => void) => void;
            execute: (siteKey: string, options: { action: string }) => Promise<string>;
        };
    }
}

const form = useForm({
    email: '',
    password: '',
    remember: false,
    'g-recaptcha-response': '',
});

const showPassword = ref(false);
const currentYear = computed(() => new Date().getFullYear());

defineProps<{
    status?: string;
    canResetPassword: boolean;
}>();
const loadRecaptcha = () => {
    return new Promise<void>((resolve) => {
        if (document.getElementById('recaptcha-script')) return resolve();

        const script = document.createElement('script');
        script.id = 'recaptcha-script';
        script.src = `https://www.google.com/recaptcha/api.js?render=${siteKey}`;
        script.async = true;
        script.onload = () => resolve();
        document.head.appendChild(script);
    });
};

const removeRecaptcha = () => {
    const script = document.getElementById('recaptcha-script');
    if (script) script.remove();

    const badge = document.querySelector('.grecaptcha-badge');
    if (badge) badge.remove();
};

const submit = async () => {
    await loadRecaptcha();

    form['g-recaptcha-response'] = await window.grecaptcha.execute(siteKey, { action: 'login' });

    form.post(route('login'), {
        onFinish: () => {
            form.reset('password');
        },
    });
};

onMounted(() => {
    loadRecaptcha();
});

onUnmounted(() => {
    removeRecaptcha();
});
</script>

<style scoped>
input:focus {
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

@keyframes spin {
    from {
        transform: rotate(0deg);
    }
    to {
        transform: rotate(360deg);
    }
}

.animate-spin {
    animation: spin 1s linear infinite;
}
</style>
