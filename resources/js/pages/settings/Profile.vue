<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Profile settings" />

        <SettingsLayout>
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden p-6">
                <div class="px-0 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center mb-6">
                    <HeadingSmall title="Profile information" description="Update your name and email address" />
                </div>

                <form @submit.prevent="submit" class="space-y-6">
                    <div class="grid gap-2">
                        <Label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Name</Label>
                        <div class="relative">
                            <Input
                                id="name"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 transition-colors duration-200"
                                v-model="form.name"
                                required
                                autocomplete="name"
                                placeholder="Full name"
                                :class="{ 'border-red-500 focus:ring-red-500': form.errors.name }"
                            />
                            <UserIcon class="absolute right-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" />
                        </div>
                        <InputError class="mt-2 text-sm text-red-600 dark:text-red-400" :message="form.errors.name" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email address</Label>
                        <div class="relative">
                            <Input
                                id="email"
                                type="email"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 transition-colors duration-200"
                                v-model="form.email"
                                required
                                autocomplete="username"
                                placeholder="Email address"
                                :class="{ 'border-red-500 focus:ring-red-500': form.errors.email }"
                            />
                            <Mail class="absolute right-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" />
                        </div>
                        <InputError class="mt-2 text-sm text-red-600 dark:text-red-400" :message="form.errors.email" />
                    </div>

                    <div v-if="mustVerifyEmail && !user.email_verified_at" class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-700 text-yellow-800 dark:text-yellow-300 p-4 rounded-lg">
                        <p class="text-sm">
                            Your email address is unverified.
                            <Link
                                :href="route('verification.send')"
                                method="post"
                                as="button"
                                class="inline-flex items-center text-yellow-900 dark:text-yellow-200 font-medium underline decoration-yellow-400 underline-offset-4 transition-colors duration-300 ease-out hover:decoration-yellow-600"
                            >
                                Click here to resend the verification email.
                            </Link>
                        </p>

                        <div v-if="status === 'verification-link-sent'" class="mt-2 text-sm font-medium text-green-600 dark:text-green-400">
                            A new verification link has been sent to your email address.
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <Button :disabled="form.processing" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 disabled:bg-blue-400 text-white font-semibold rounded-lg shadow-md transition-all duration-200">
                            <Loader2 v-if="form.processing" class="w-4 h-4 mr-2 animate-spin" />
                            <span>Save</span>
                        </Button>

                        <Transition
                            enter-active-class="transition ease-in-out"
                            enter-from-class="opacity-0"
                            leave-active-class="transition ease-in-out"
                            leave-to-class="opacity-0"
                        >
                            <p v-show="form.recentlySuccessful" class="text-sm text-neutral-600 dark:text-neutral-400">Saved.</p>
                        </Transition>
                    </div>
                </form>
            </div>

            <DeleteUser />
        </SettingsLayout>
    </AppLayout>
</template>
<script setup lang="ts">
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import Swal from 'sweetalert2';

import DeleteUser from '@/components/DeleteUser.vue';
import HeadingSmall from '@/components/HeadingSmall.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AdminLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import { type BreadcrumbItem, type User } from '@/types';
import { Loader2, User as UserIcon, Mail } from 'lucide-vue-next';

interface Props {
    mustVerifyEmail: boolean;
    status?: string;
}

defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Profile settings',
        href: '/settings/profile',
    },
];

const page = usePage();
const user = page.props.auth.user as User;

const form = useForm({
    name: user.name,
    email: user.email,
});

const submit = () => {
    form.patch(route('profile.update'), {
        preserveScroll: true,
        onSuccess: () => {
            Swal.fire({
                icon: 'success',
                title: 'Profile Updated!',
                text: 'Your profile information has been successfully updated.',
                confirmButtonColor: '#3B82F6',
                timer: 2000,
                timerProgressBar: true
            });
        },
        onError: () => {
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                text: 'Please check the form and try again.',
                confirmButtonColor: '#3B82F6'
            });
        }
    });
};
</script>
