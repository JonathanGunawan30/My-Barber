<template>
    <div class="flex min-h-screen items-center justify-center bg-gray-50 p-4">
        <Head title="Register" />

        <div class="w-full max-w-md">
            <div class="rounded-2xl border border-gray-200 bg-white p-8 shadow-xl">
                <div class="mb-8 text-center">
                    <div class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-xl bg-blue-600">
                        <Scissors class="h-6 w-6 text-white" />
                    </div>

                    <h1 class="mb-2 text-2xl font-bold text-gray-900">Create an account</h1>
                    <p class="text-sm text-gray-600">Enter your details below to create your account</p>
                </div>

                <p v-if="page.props.flash.status" class="mb-6 rounded-lg bg-green-100 px-4 py-3 text-sm text-green-700">
                    {{ page.props.flash.status }}
                </p>

                <form @submit.prevent="submit" class="space-y-5">
                    <div>
                        <label for="name" class="mb-2 block text-sm font-medium text-gray-700"> Name </label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <User class="h-5 w-5 text-gray-400" />
                            </div>
                            <input
                                id="name"
                                type="text"
                                required
                                autofocus
                                :tabindex="1"
                                autocomplete="name"
                                v-model="form.name"
                                placeholder="Full name"
                                class="w-full rounded-lg border border-gray-300 py-3 pr-4 pl-10 text-gray-900 placeholder-gray-500 transition-colors duration-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500"
                                :class="{ 'border-red-300 focus:border-red-500 focus:ring-red-500': form.errors.name }"
                            />
                        </div>
                        <p v-if="form.errors.name" class="mt-2 flex items-center gap-1 text-sm text-red-600">
                            <AlertCircle class="h-4 w-4" />
                            {{ form.errors.name }}
                        </p>
                    </div>

                    <div>
                        <label for="email" class="mb-2 block text-sm font-medium text-gray-700"> Email address </label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <Mail class="h-5 w-5 text-gray-400" />
                            </div>
                            <input
                                id="email"
                                type="email"
                                required
                                :tabindex="2"
                                autocomplete="email"
                                v-model="form.email"
                                placeholder="email@example.com"
                                class="w-full rounded-lg border border-gray-300 py-3 pr-4 pl-10 text-gray-900 placeholder-gray-500 transition-colors duration-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500"
                                :class="{ 'border-red-300 focus:border-red-500 focus:ring-red-500': form.errors.email }"
                            />
                        </div>
                        <p v-if="form.errors.email" class="mt-2 flex items-center gap-1 text-sm text-red-600">
                            <AlertCircle class="h-4 w-4" />
                            {{ form.errors.email }}
                        </p>
                    </div>

                    <div>
                        <label for="password" class="mb-2 block text-sm font-medium text-gray-700"> Password </label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <Lock class="h-5 w-5 text-gray-400" />
                            </div>
                            <input
                                id="password"
                                :type="showPassword ? 'text' : 'password'"
                                required
                                :tabindex="3"
                                autocomplete="new-password"
                                v-model="form.password"
                                placeholder="Password"
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

                    <div>
                        <label for="password_confirmation" class="mb-2 block text-sm font-medium text-gray-700"> Confirm password </label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <Lock class="h-5 w-5 text-gray-400" />
                            </div>
                            <input
                                id="password_confirmation"
                                :type="showConfirmPassword ? 'text' : 'password'"
                                required
                                :tabindex="4"
                                autocomplete="new-password"
                                v-model="form.password_confirmation"
                                placeholder="Confirm password"
                                class="w-full rounded-lg border border-gray-300 py-3 pr-12 pl-10 text-gray-900 placeholder-gray-500 transition-colors duration-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500"
                                :class="{ 'border-red-300 focus:border-red-500 focus:ring-red-500': form.errors.password_confirmation }"
                            />
                            <button
                                type="button"
                                @click="showConfirmPassword = !showConfirmPassword"
                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 transition-colors duration-200 hover:text-gray-600"
                            >
                                <Eye v-if="!showConfirmPassword" class="h-5 w-5" />
                                <EyeOff v-else class="h-5 w-5" />
                            </button>
                        </div>
                        <p v-if="form.errors.password_confirmation" class="mt-2 flex items-center gap-1 text-sm text-red-600">
                            <AlertCircle class="h-4 w-4" />
                            {{ form.errors.password_confirmation }}
                        </p>
                    </div>

                    <button
                        type="submit"
                        :tabindex="5"
                        :disabled="form.processing"
                        class="flex w-full items-center justify-center gap-2 rounded-lg bg-blue-600 px-4 py-3 font-medium text-white transition-colors duration-200 hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50"
                    >
                        <LoaderCircle v-if="form.processing" class="h-5 w-5 animate-spin" />
                        <UserPlus v-else class="h-5 w-5" />
                        {{ form.processing ? 'Creating account...' : 'Create account' }}
                    </button>
                </form>

                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="bg-white px-2 text-gray-500">Already have an account?</span>
                    </div>
                </div>

                <div class="text-center">
                    <TextLink
                        :href="route('login')"
                        :tabindex="6"
                        class="inline-flex items-center gap-2 font-medium text-blue-600 transition-colors duration-200 hover:text-blue-500"
                    >
                        <LogIn class="h-4 w-4" />
                        Sign In
                    </TextLink>
                </div>
            </div>

            <footer class="mt-8 text-center">
                <p class="flex items-center justify-center text-xs text-gray-600 dark:text-gray-400">
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
            </footer>
        </div>
    </div>
</template>

<script setup lang="ts">
import { computed, onMounted, onUnmounted, ref } from 'vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import TextLink from '@/components/TextLink.vue';
import { AlertCircle, Eye, EyeOff, Github, LoaderCircle, Lock, LogIn, Mail, Scissors, User, UserPlus } from 'lucide-vue-next';
import { route } from 'ziggy-js';
import Swal from 'sweetalert2';

const page = usePage();

const siteKey = import.meta.env.VITE_RECAPTCHA_SITE_KEY;

const showPassword = ref(false);
const showConfirmPassword = ref(false);

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    'g-recaptcha-response': '',
});

const currentYear = computed(() => new Date().getFullYear());

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
    if (form.processing) return;

    try {
        await loadRecaptcha();

        form['g-recaptcha-response'] = await window.grecaptcha.execute(siteKey, { action: 'register' });

        form.post(route('register'), {
            onSuccess: () => {
                form.reset();
            },
            onError: (errors) => {
                form.reset('password', 'password_confirmation');

                if (errors['g-recaptcha-response']) {
                    Swal.fire({
                        icon: 'error',
                        title: 'reCAPTCHA Failed',
                        text: errors['g-recaptcha-response'],
                        confirmButtonColor: '#3B82F6'
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Registration Failed',
                        text: 'Please check your input fields and try again.',
                        confirmButtonColor: '#3B82F6'
                    });
                }
            },
        });
    } catch (err) {
        console.error('reCAPTCHA error:', err);
        Swal.fire({
            icon: 'error',
            title: 'reCAPTCHA Error',
            text: typeof err === 'string' ? err : 'Failed to verify reCAPTCHA. Please try again.',
            confirmButtonColor: '#3B82F6'
        });
    }
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
