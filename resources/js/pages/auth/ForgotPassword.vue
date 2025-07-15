<template>
    <div class="flex min-h-screen items-center justify-center bg-gray-50 p-4">
        <Head title="Forgot password" />

        <div class="w-full max-w-md">
            <div class="rounded-2xl border border-gray-200 bg-white p-8 shadow-xl">
                <div class="mb-8 text-center">
                    <div class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-xl bg-blue-600">
                        <Scissors class="h-6 w-6 text-white" />
                    </div>

                    <h1 class="mb-2 text-2xl font-bold text-gray-900">Forgot password</h1>
                    <p class="text-sm text-gray-600">Enter your email to receive a password reset link</p>
                </div>

                <div v-if="status" class="mb-6 rounded-lg border border-green-200 bg-green-50 p-4 text-center">
                    <p class="text-sm font-medium text-green-700">{{ status }}</p>
                </div>

                <div class="space-y-5">
                    <form @submit.prevent="submit">
                        <div>
                            <label for="email" class="mb-2 block text-sm font-medium text-gray-700"> Email address </label>
                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <Mail class="h-5 w-5 text-gray-400" />
                                </div>
                                <input
                                    id="email"
                                    type="email"
                                    name="email"
                                    autocomplete="off"
                                    v-model="form.email"
                                    autofocus
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

                        <div class="my-6 flex items-center justify-start">
                            <button
                                type="submit"
                                :disabled="form.processing"
                                class="flex w-full items-center justify-center gap-2 rounded-lg bg-blue-600 px-4 py-3 font-medium text-white transition-colors duration-200 hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50"
                            >
                                <LoaderCircle v-if="form.processing" class="h-5 w-5 animate-spin" />
                                <Mail v-else class="h-5 w-5" />
                                Email password reset link
                            </button>
                        </div>
                    </form>

                    <div class="text-center">
                        <TextLink
                            :href="route('login')"
                            class="inline-flex items-center gap-2 font-medium text-black hover:text-blue-600 dark:text-black dark:hover:text-blue-600 !no-underline transition-all duration-200"
                        >
                            <ArrowLeft class="h-4 w-4" />
                            Return to login
                        </TextLink>
                    </div>
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
import { computed, onMounted, onUnmounted } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import Swal from 'sweetalert2';
import TextLink from '@/components/TextLink.vue';
import { AlertCircle, ArrowLeft, Github, LoaderCircle, Mail, Scissors } from 'lucide-vue-next';

defineProps<{ status?: string }>();

const siteKey = import.meta.env.VITE_RECAPTCHA_SITE_KEY;

declare global {
    interface Window {
        grecaptcha: {
            ready: (cb: () => void) => void;
            execute: (siteKey: string, opts: { action: string }) => Promise<string>;
        };
    }
}

const form = useForm({
    email: '',
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

    if (!form.email) {
        Swal.fire({
            icon: 'warning',
            title: 'Email Required',
            text: 'Please enter your email address.',
            confirmButtonColor: '#2F8451',
        });
        return;
    }

    try {
        await loadRecaptcha();

        form['g-recaptcha-response'] = await window.grecaptcha.execute(siteKey, { action: 'forgot' });

        form.post(route('password.email'), {
            onFinish: () => form.reset('g-recaptcha-response'),
            onError: (errors) => {
                if (errors['g-recaptcha-response']) {
                    Swal.fire({
                        icon: 'error',
                        title: 'reCAPTCHA Failed',
                        text: errors['g-recaptcha-response'],
                        confirmButtonColor: '#2F8451',
                    });
                }
            },
        });
    } catch (err) {
        console.error('reCAPTCHA error:', err);
        Swal.fire({
            icon: 'error',
            title: 'reCAPTCHA Error',
            text: typeof err === 'string' ? err : 'Failed to verify reCAPTCHA.',
            confirmButtonColor: '#2F8451',
        });
    }
};

onMounted(loadRecaptcha);
onUnmounted(removeRecaptcha);
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
