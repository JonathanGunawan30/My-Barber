<script setup lang="ts">
import { Head } from '@inertiajs/vue3';

import AppearanceTabs from '@/components/AppearanceTabs.vue';
import HeadingSmall from '@/components/HeadingSmall.vue';
import { type BreadcrumbItem } from '@/types';

import AppLayout from '@/layouts/AdminLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Appearance settings',
        href: '/settings/appearance',
    },
];
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="Appearance settings" />

        <SettingsLayout>
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden p-6">
                <div class="px-0 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center mb-6">
                    <HeadingSmall title="Appearance settings" description="Update your account's appearance settings" />
                </div>

                <div class="space-y-6">
                    <AppearanceTabs />
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-4">
                        Choose your preferred theme and other visual settings.
                    </p>
                </div>
            </div>
        </SettingsLayout>
    </AppLayout>
</template>
