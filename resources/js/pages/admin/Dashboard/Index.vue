<template>
    <AdminLayout>
        <Head title="Dashboard" />
        <div class="">
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Dashboard Overview</h1>
            <p class="text-gray-600 dark:text-gray-400">Welcome back! Here's what's happening at your barbershop today.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Today's Bookings</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">24</p>
                        <p class="text-sm text-green-600 flex items-center gap-1">
                            <TrendingUp class="w-4 h-4" />
                            +12% from yesterday
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
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">$1,240</p>
                        <p class="text-sm text-green-600 flex items-center gap-1">
                            <TrendingUp class="w-4 h-4" />
                            +8% from yesterday
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
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">1,429</p>
                        <p class="text-sm text-blue-600 dark:text-blue-400 flex items-center gap-1">
                            <Users class="w-4 h-4" />
                            +23 new this week
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
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">8/12</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">4 on break</p>
                    </div>
                    <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900/50 rounded-lg flex items-center justify-center">
                        <UserCheck class="w-6 h-6 text-orange-600 dark:text-orange-400" />
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Bookings</h3>
                        <button class="text-sm text-blue-600 hover:text-blue-500 font-medium">View all</button>
                    </div>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div v-for="booking in recentBookings" :key="booking.id" class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gray-300 dark:bg-gray-600 rounded-full flex items-center justify-center">
                                    <User class="w-5 h-5 text-gray-600 dark:text-gray-400" />
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white">{{ booking.customer }}</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ booking.service }} • {{ booking.time }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-medium text-gray-900 dark:text-white">${{ booking.amount }}</p>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium"
                                      :class="getStatusClass(booking.status)">
                                        {{ booking.status }}
                                    </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Quick Actions</h3>
                    <div class="space-y-3">
                        <button class="w-full flex items-center gap-3 p-3 text-left bg-blue-50 hover:bg-blue-100 dark:bg-blue-900/30 dark:hover:bg-blue-900/50 rounded-lg transition-colors duration-200">
                            <Plus class="w-5 h-5 text-blue-600 dark:text-blue-400" />
                            <span class="font-medium text-blue-600 dark:text-blue-400">New Booking</span>
                        </button>
                        <button class="w-full flex items-center gap-3 p-3 text-left bg-gray-50 hover:bg-gray-100 dark:bg-gray-700/50 dark:hover:bg-gray-700 rounded-lg transition-colors duration-200">
                            <UserPlus class="w-5 h-5 text-gray-600 dark:text-gray-400" />
                            <span class="font-medium text-gray-700 dark:text-gray-300">Add Customer</span>
                        </button>
                        <button class="w-full flex items-center gap-3 p-3 text-left bg-gray-50 hover:bg-gray-100 dark:bg-gray-700/50 dark:hover:bg-gray-700 rounded-lg transition-colors duration-200">
                            <Settings class="w-5 h-5 text-gray-600 dark:text-gray-400" />
                            <span class="font-medium text-gray-700 dark:text-gray-300">Manage Services</span>
                        </button>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Today's Schedule</h3>
                    <div class="space-y-3">
                        <div v-for="appointment in todaySchedule" :key="appointment.id" class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                            <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ appointment.time }}</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">{{ appointment.customer }} - {{ appointment.barber }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </AdminLayout>
</template>

<script setup>
import { ref } from 'vue'
import { Head } from '@inertiajs/vue3'
import AdminLayout from '@/layouts/AdminLayout.vue'
import {
    Calendar, Users, UserCheck, TrendingUp, DollarSign, Plus,
    UserPlus, Settings, User
} from 'lucide-vue-next'


const recentBookings = ref([
    {
        id: 1,
        customer: 'John Smith',
        service: 'Haircut & Beard Trim',
        time: '10:30 AM',
        amount: 45,
        status: 'Completed'
    },
    {
        id: 2,
        customer: 'Mike Johnson',
        service: 'Premium Haircut',
        time: '11:15 AM',
        amount: 35,
        status: 'In Progress'
    },
    {
        id: 3,
        customer: 'David Wilson',
        service: 'Beard Styling',
        time: '12:00 PM',
        amount: 25,
        status: 'Scheduled'
    },
    {
        id: 4,
        customer: 'Alex Brown',
        service: 'Full Service',
        time: '1:30 PM',
        amount: 65,
        status: 'Scheduled'
    }
])

const todaySchedule = ref([
    { id: 1, time: '2:00 PM', customer: 'Robert Davis', barber: 'Tony' },
    { id: 2, time: '2:30 PM', customer: 'James Miller', barber: 'Mike' },
    { id: 3, time: '3:00 PM', customer: 'Chris Wilson', barber: 'Alex' },
    { id: 4, time: '3:30 PM', customer: 'Mark Taylor', barber: 'Tony' }
])

const getStatusClass = (status) => {
    switch (status) {
        case 'Completed':
            return 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300'
        case 'In Progress':
            return 'bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300'
        case 'Scheduled':
            return 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-300'
        default:
            return 'bg-gray-100 text-gray-800 dark:bg-gray-700/50 dark:text-gray-300'
    }
}
</script>

<style scoped>
/* Custom scrollbar */
::-webkit-scrollbar {
    width: 4px;
}

::-webkit-scrollbar-track {
    background: transparent;
}

::-webkit-scrollbar-thumb {
    background: rgba(156, 163, 175, 0.5);
    border-radius: 2px;
}

::-webkit-scrollbar-thumb:hover {
    background: rgba(156, 163, 175, 0.7);
}
</style>
