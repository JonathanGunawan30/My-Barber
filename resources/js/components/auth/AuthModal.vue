<template>
    <Transition name="modal-fade">
        <div v-if="isOpen" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/60 backdrop-blur-md" @click.self="$emit('close')">
            <div class="bg-white rounded-2xl max-w-md w-full p-8 relative transform scale-95 transition-transform duration-300" :class="{ 'scale-100': isOpen }">
                <button @click="$emit('close')" class="absolute top-4 right-4 p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-600 rounded-lg transition-colors">
                    <X class="w-5 h-5" />
                </button>

                <div class="text-center mb-8">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4 border-4 border-white shadow-md">
                        <User class="w-8 h-8 text-blue-600" />
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ view === 'login' ? 'Welcome Back' : 'Create an Account' }}</h3>
                    <p class="text-gray-500">{{ view === 'login' ? 'Sign in to book your appointment' : 'Get started with us today!' }}</p>
                </div>

                <div v-if="localFlashSuccess" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative mb-6 flex items-center justify-between" role="alert">
                    <div class="flex items-center gap-3">
                        <CheckCircle class="w-5 h-5" />
                        <span class="block sm:inline font-medium">{{ localFlashSuccess }}</span>
                    </div>
                    <button @click="localFlashSuccess = ''" class="p-1 text-green-700 hover:bg-green-200 rounded-full">
                        <X class="w-4 h-4" />
                    </button>
                </div>


                <form v-if="view === 'login'" @submit.prevent="submitLogin" class="space-y-5">
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                            <Mail class="w-5 h-5" />
                        </span>
                        <input type="email" v-model="loginForm.email"
                               class="w-full pl-[3rem] pr-4 py-3.5 bg-gray-100 border-2 border-transparent text-gray-900 placeholder-gray-500 rounded-xl transition-colors duration-300 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500"
                               :class="{'border-red-500': loginForm.errors.email}"
                               placeholder="your@email.com">
                    </div>
                    <p v-if="loginForm.errors.email" class="text-red-600 text-sm -mt-3 ml-2">{{ loginForm.errors.email }}</p>

                    <div class="relative">
                         <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                            <Lock class="w-5 h-5" />
                        </span>
                        <input type="password" v-model="loginForm.password"
                               class="w-full pl-[3rem] pr-4 py-3.5 bg-gray-100 border-2 border-transparent text-gray-900 placeholder-gray-500 rounded-xl transition-colors duration-300 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500"
                               placeholder="Enter your password">
                    </div>

                    <button type="submit" :disabled="loginForm.processing" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3.5 rounded-xl font-semibold transition-all transform hover:scale-105 disabled:opacity-50 flex items-center justify-center gap-2">
                        <span>Sign In</span>
                        <ArrowRight class="w-5 h-5" />
                    </button>
                    <div class="text-center">
                        <p class="text-sm text-gray-600">Don't have an account?
                            <button type="button" @click="view = 'register'; localFlashSuccess = ''" class="text-blue-600 hover:underline font-semibold">Sign up</button>
                        </p>
                    </div>
                </form>

                <form v-else @submit.prevent="submitRegister" class="space-y-5">
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                            <User class="w-5 h-5" />
                        </span>
                        <input type="text" v-model="registerForm.name"
                               class="w-full pl-[3rem] pr-4 py-3.5 bg-gray-100 border-2 border-transparent text-gray-900 placeholder-gray-500 rounded-xl transition-colors duration-300 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500"
                               :class="{'border-red-500': registerForm.errors.name}"
                               placeholder="Your Full Name">
                    </div>
                    <p v-if="registerForm.errors.name" class="text-red-600 text-sm -mt-3 ml-2">{{ registerForm.errors.name }}</p>

                    <div class="relative">
                         <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                            <Mail class="w-5 h-5" />
                        </span>
                        <input type="email" v-model="registerForm.email"
                               class="w-full pl-[3rem] pr-4 py-3.5 bg-gray-100 border-2 border-transparent text-gray-900 placeholder-gray-500 rounded-xl transition-colors duration-300 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500"
                               :class="{'border-red-500': registerForm.errors.email}"
                               placeholder="your@email.com">
                    </div>
                    <p v-if="registerForm.errors.email" class="text-red-600 text-sm -mt-3 ml-2">{{ registerForm.errors.email }}</p>

                    <div class="relative">
                         <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                            <Lock class="w-5 h-5" />
                        </span>
                        <input type="password" v-model="registerForm.password"
                               class="w-full pl-[3rem] pr-4 py-3.5 bg-gray-100 border-2 border-transparent text-gray-900 placeholder-gray-500 rounded-xl transition-colors duration-300 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500"
                               :class="{'border-red-500': registerForm.errors.password}"
                               placeholder="Create a password">
                    </div>
                    <p v-if="registerForm.errors.password" class="text-red-600 text-sm -mt-3 ml-2">{{ registerForm.errors.password }}</p>

                    <div class="relative">
                         <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                            <Lock class="w-5 h-5" />
                        </span>
                        <input type="password" v-model="registerForm.password_confirmation"
                               class="w-full pl-[3rem] pr-4 py-3.5 bg-gray-100 border-2 border-transparent text-gray-900 placeholder-gray-500 rounded-xl transition-colors duration-300 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500"
                               placeholder="Confirm your password">
                    </div>

                    <button type="submit" :disabled="registerForm.processing" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3.5 rounded-xl font-semibold transition-all transform hover:scale-105 disabled:opacity-50 flex items-center justify-center gap-2">
                        <span>Create Account</span>
                        <ArrowRight class="w-5 h-5" />
                    </button>
                    <div class="text-center">
                        <p class="text-sm text-gray-600">Already have an account?
                            <button type="button" @click="view = 'login'; localFlashSuccess = ''" class="text-blue-600 hover:underline font-semibold">Sign in</button>
                        </p>
                    </div>
                </form>

                <div class="flex items-center my-6">
                    <div class="flex-grow border-t border-gray-200"></div>
                    <span class="flex-shrink mx-4 text-gray-400 text-sm font-medium">OR</span>
                    <div class="flex-grow border-t border-gray-200"></div>
                </div>

                <a :href="route('google.redirect')" class="w-full flex items-center justify-center gap-3 py-3 border border-gray-300 rounded-xl hover:bg-gray-50 transition-colors">
                    <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google icon" class="w-6 h-6">
                    <span class="font-semibold text-gray-800">Continue with Google</span>
                </a>
            </div>
        </div>
    </Transition>
</template>

<script setup lang="ts">
import { ref, computed, watch } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { X, User, Mail, Lock, ArrowRight, CheckCircle } from 'lucide-vue-next';
import { PageProps as InertiaPageProps } from '@inertiajs/core';

interface CustomPageProps extends InertiaPageProps {
    flash?: {
        success?: string;
        error?: string;
    };
}

const page = usePage<CustomPageProps>();
const flashSuccess = computed(() => page.props.flash?.success || '');

const localFlashSuccess = ref('');

watch(flashSuccess, (newValue) => {
    if (newValue) {
        localFlashSuccess.value = newValue;
    }
});

const props = defineProps<{
    isOpen: boolean
}>();

watch(() => props.isOpen, (newValue) => {
    if (!newValue) {
        setTimeout(() => {
            localFlashSuccess.value = '';
        }, 300);
    }
});


const view = ref<'login' | 'register'>('login');

const loginForm = useForm({
    email: '',
    password: '',
});

const registerForm = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submitLogin = () => {
    loginForm.post(route('login.customer'), {
        onFinish: () => loginForm.reset('password'),
    });
};

const submitRegister = () => {
    registerForm.post(route('register.customer'), {
        onSuccess: () => {
            registerForm.reset();
        },
    });
};

</script>

<style scoped>
.modal-fade-enter-active,
.modal-fade-leave-active {
    transition: opacity 0.3s ease;
}
.modal-fade-enter-from,
.modal-fade-leave-to {
    opacity: 0;
}
.modal-fade-enter-active .transform,
.modal-fade-leave-active .transform {
    transition: transform 0.3s ease;
}
</style>
