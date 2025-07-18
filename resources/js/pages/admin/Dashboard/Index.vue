<template>
    <AdminLayout>
        <Head title="Dashboard" />
        <div>
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Dashboard Overview</h1>
                <p class="text-gray-600 dark:text-gray-400">Welcome back! Here's what's happening today, {{ new Date().toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'}) }}.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Today's Bookings</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ stats.todaysBookings.count }}</p>
                            <p v-if="stats.todaysBookings.percentageChange !== 0" class="text-sm flex items-center gap-1" :class="stats.todaysBookings.percentageChange > 0 ? 'text-green-600' : 'text-red-600'">
                                <TrendingUp v-if="stats.todaysBookings.percentageChange > 0" class="w-4 h-4" />
                                <TrendingDown v-else class="w-4 h-4" />
                                {{ stats.todaysBookings.percentageChange > 0 ? '+' : '' }}{{ stats.todaysBookings.percentageChange }}% from yesterday
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/50 rounded-lg flex items-center justify-center">
                            <Calendar class="w-6 h-6 text-blue-600 dark:text-blue-400" />
                        </div>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Today's Revenue</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ formatRupiah(stats.todaysRevenue.total) }}</p>
                            <p v-if="stats.todaysRevenue.percentageChange !== 0" class="text-sm flex items-center gap-1" :class="stats.todaysRevenue.percentageChange > 0 ? 'text-green-600' : 'text-red-600'">
                                <TrendingUp v-if="stats.todaysRevenue.percentageChange > 0" class="w-4 h-4" />
                                <TrendingDown v-else class="w-4 h-4" />
                                {{ stats.todaysRevenue.percentageChange > 0 ? '+' : '' }}{{ stats.todaysRevenue.percentageChange }}% from yesterday
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 dark:bg-green-900/50 rounded-lg flex items-center justify-center">
                            <DollarSign class="w-6 h-6 text-green-600 dark:text-green-400" />
                        </div>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Active Customers</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ stats.activeCustomers.total }}</p>
                            <p class="text-sm text-blue-600 dark:text-blue-400 flex items-center gap-1">
                                <Users class="w-4 h-4" />
                                +{{ stats.activeCustomers.newThisWeek }} new this week
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/50 rounded-lg flex items-center justify-center">
                            <Users class="w-6 h-6 text-purple-600 dark:text-purple-400" />
                        </div>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Available Barbers</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ stats.availableBarbers.active }}/{{ stats.availableBarbers.total }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ stats.availableBarbers.total - stats.availableBarbers.active }} on break</p>
                        </div>
                        <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900/50 rounded-lg flex items-center justify-center">
                            <UserCheck class="w-6 h-6 text-orange-600 dark:text-orange-400" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Bookings</h3>
                        <a :href="route('admin.bookings.index')" class="text-sm text-blue-600 hover:text-blue-500 font-medium">View all</a>
                    </div>
                    <div class="p-6">
                        <div v-if="recentBookings.length > 0" class="space-y-4">
                            <div v-for="booking in recentBookings" :key="booking.id" class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-gray-200 dark:bg-gray-600 rounded-full flex items-center justify-center">
                                        <User class="w-5 h-5 text-gray-600 dark:text-gray-400" />
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-white">{{ booking.customer.name }}</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ booking.service.name }} • {{ formatJustTime(booking.time) }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-medium text-gray-900 dark:text-white">{{ formatRupiah(booking.service.price) }}</p>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium" :class="getStatusClass(booking.status)">
                                        {{ getStatusText(booking.status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div v-else class="text-center py-8">
                            <p class="text-gray-500">No recent bookings found.</p>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    </div>
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Today's Schedule</h3>
                        <div v-if="todaySchedule.length > 0" class="space-y-3">
                            <div v-for="appointment in todaySchedule" :key="appointment.id" class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                <div class="w-2 h-2 rounded-full" :class="getScheduleStatusClass(appointment.status)"></div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ formatJustTime(appointment.time) }}</p>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">{{ appointment.customer.name }} - {{ appointment.barber.name }}</p>
                                </div>
                            </div>
                        </div>
                        <div v-else class="text-center py-4">
                            <p class="text-sm text-gray-500">No appointments scheduled for today.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { Calendar, Users, UserCheck, TrendingUp, TrendingDown, DollarSign, User } from 'lucide-vue-next';

interface Stats {
    todaysBookings: { count: number; percentageChange: number; };
    todaysRevenue: { total: number; percentageChange: number; };
    activeCustomers: { total: number; newThisWeek: number; };
    availableBarbers: { active: number; total: number; };
}
interface Booking {
    id: number;
    time: string;
    status: string;
    customer: { name: string };
    service: { name: string; price: number | string };
    barber: { name: string };
}

const props = defineProps<{
    stats: Stats;
    recentBookings: Booking[];
    todaySchedule: Booking[];
}>();

const formatRupiah = (amount: number | string) => new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(Number(amount));
const formatJustTime = (time: string) => time.slice(0, 5);

const getStatusClass = (status: string) => ({
    'pending': 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-300',
    'paid': 'bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300',
    'done': 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300',
    'canceled': 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300',
}[status] || 'bg-gray-100 text-gray-800');

const getStatusText = (status: string) => ({
    'pending': 'Pending',
    'paid': 'Confirmed',
    'done': 'Completed',
    'canceled': 'Cancelled',
}[status] || 'Unknown');

const getScheduleStatusClass = (status: string) => ({
    'pending': 'bg-yellow-500',
    'paid': 'bg-blue-500',
}[status] || 'bg-gray-400');
</script>

<style scoped>
</style>
