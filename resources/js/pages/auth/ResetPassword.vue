<template>
    <div class="min-h-screen bg-gray-50 flex items-center justify-center p-4">
        <Head title="Reset password" />

        <div class="w-full max-w-md">
            <div class="bg-white rounded-2xl shadow-xl border border-gray-200 p-8">
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center w-12 h-12 bg-blue-600 rounded-xl mb-4">
                        <Scissors class="w-6 h-6 text-white" />
                    </div>

                    <h1 class="text-2xl font-bold text-gray-900 mb-2">Reset password</h1>
                    <p class="text-gray-600 text-sm">Please enter your new password below</p>
                </div>

                <form @submit.prevent="submit" class="space-y-5">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email address</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <Mail class="h-5 w-5 text-gray-400" />
                            </div>
                            <input
                                id="email"
                                type="email"
                                name="email"
                                autocomplete="email"
                                v-model="form.email"
                                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg bg-gray-100 cursor-not-allowed text-gray-900 placeholder-gray-500"
                                readonly
                            />
                        </div>
                        <p v-if="form.errors.email" class="text-red-600 text-sm mt-2 flex items-center gap-1">
                            <AlertCircle class="w-4 h-4" />
                            {{ form.errors.email }}
                        </p>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <Lock class="h-5 w-5 text-gray-400" />
                            </div>
                            <input
                                id="password"
                                :type="showPassword ? 'text' : 'password'"
                                name="password"
                                autocomplete="new-password"
                                v-model="form.password"
                                autofocus
                                placeholder="New password"
                                class="w-full pl-10 pr-12 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-gray-900 placeholder-gray-500"
                                :class="{ 'border-red-300 focus:ring-red-500 focus:border-red-500': form.errors.password }"
                            />
                            <button
                                type="button"
                                @click="showPassword = !showPassword"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 transition-colors duration-200"
                            >
                                <Eye v-if="!showPassword" class="h-5 w-5" />
                                <EyeOff v-else class="h-5 w-5" />
                            </button>
                        </div>
                        <p v-if="form.errors.password" class="text-red-600 text-sm mt-2 flex items-center gap-1">
                            <AlertCircle class="w-4 h-4" />
                            {{ form.errors.password }}
                        </p>
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <Lock class="h-5 w-5 text-gray-400" />
                            </div>
                            <input
                                id="password_confirmation"
                                :type="showConfirmPassword ? 'text' : 'password'"
                                name="password_confirmation"
                                autocomplete="new-password"
                                v-model="form.password_confirmation"
                                placeholder="Confirm new password"
                                class="w-full pl-10 pr-12 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-gray-900 placeholder-gray-500"
                                :class="{ 'border-red-300 focus:ring-red-500 focus:border-red-500': form.errors.password_confirmation }"
                            />
                            <button
                                type="button"
                                @click="showConfirmPassword = !showConfirmPassword"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 transition-colors duration-200"
                            >
                                <Eye v-if="!showConfirmPassword" class="h-5 w-5" />
                                <EyeOff v-else class="h-5 w-5" />
                            </button>
                        </div>
                        <p v-if="form.errors.password_confirmation" class="text-red-600 text-sm mt-2 flex items-center gap-1">
                            <AlertCircle class="w-4 h-4" />
                            {{ form.errors.password_confirmation }}
                        </p>
                    </div>

                    <button
                        type="submit"
                        class="w-full py-3 px-4 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2 mt-6"
                        :disabled="form.processing"
                    >
                        <LoaderCircle v-if="form.processing" class="h-5 w-5 animate-spin" />
                        <Lock class="h-5 w-5" />
                        {{ form.processing ? 'Resetting password...' : 'Reset password' }}
                    </button>
                </form>
            </div>

            <footer class="mt-8 text-center">
                <p class="text-xs text-gray-600 dark:text-gray-400 flex items-center justify-center">
                    &copy; {{ currentYear }} My Barber App. Developed by
                    <a
                        href="https://www.instagram.com/jo.nthn30"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="text-blue-600 hover:text-blue-700 hover:underline hover:decoration-blue-600 dark:text-blue-400 dark:hover:text-blue-300 dark:hover:decoration-blue-400 font-medium transition-colors duration-200 ml-1"
                    >
                        Jonathan Gunawan
                    </a>

                    <span class="mx-1 text-gray-400 dark:text-gray-500">|</span>
                    <a
                        href="https://github.com/jonathangunawan30"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="text-blue-600 hover:text-blue-700 hover:underline hover:decoration-blue-600 dark:text-blue-400 dark:hover:text-blue-300 dark:hover:decoration-blue-400 font-medium transition-colors duration-200 flex items-center"
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
import { computed, ref } from 'vue';
import { Head, useForm } from '@inertiajs/vue3'
import {
    LoaderCircle,
    Mail,
    Lock,
    Eye,
    EyeOff,
    Scissors,
    AlertCircle,
    Github
} from 'lucide-vue-next';
import { route } from 'ziggy-js'

interface Props {
    token: string;
    email: string;
}

const props = defineProps<Props>();

const showPassword = ref(false);
const showConfirmPassword = ref(false);

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const currentYear = computed(() => new Date().getFullYear());

const submit = () => {
    form.post(route('password.store'), {
        onFinish: () => {
            form.reset('password', 'password_confirmation');
        },
    });
};
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
