<template>
    <div class="space-y-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div
                v-for="(stat, index) in statsCards"
                :key="stat.title"
                class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2"
            >
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center" :class="stat.iconBg">
                        <component :is="stat.icon" class="w-6 h-6" :class="stat.iconColor" />
                    </div>
                    <span class="text-2xl font-bold text-gray-900">{{ stat.value }}</span>
                </div>
                <h3 class="text-gray-600 font-medium">{{ stat.title }}</h3>
                <p class="text-sm text-gray-500 mt-1">{{ stat.subtitle }}</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-8 shadow-lg">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Quick Actions</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <button
                    @click="$emit('book-appointment')"
                    class="bg-gradient-to-r from-blue-600 to-blue-700 text-white p-6 rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all transform hover:scale-105 shadow-lg hover:shadow-xl"
                >
                    <Calendar class="w-8 h-8 mb-3 mx-auto" />
                    <h3 class="font-semibold text-lg mb-2">Book Appointment</h3>
                    <p class="text-blue-100 text-sm">Schedule your next grooming session</p>
                </button>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-8 shadow-lg">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-900">Upcoming Appointments</h2>
            </div>
            <div v-if="upcomingBookings.length === 0" class="text-center py-12">
                <p class="text-gray-500 mb-6">You have no upcoming appointments.</p>
                <button
                    @click="$emit('book-appointment')"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors"
                >
                    Book Now
                </button>
            </div>
            <div v-else class="space-y-4">
                <div
                    v-for="booking in upcomingBookings"
                    :key="booking.id"
                    class="border border-gray-200 rounded-xl p-6"
                >
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                                <Scissors class="w-6 h-6 text-blue-600" />
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">{{ booking.service.name }}</h3>
                                <p class="text-gray-600">{{ booking.branch.name }}</p>
                                <p class="text-sm text-gray-500">{{ formatDate(booking.date) }} at {{ booking.time.slice(0, 5) }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-semibold text-gray-900">{{ formatRupiah(booking.service.price) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { computed } from 'vue';
import { Calendar, Scissors, Star, Clock } from 'lucide-vue-next';

const props = defineProps<{
    upcomingBookings: any[];
    stats: {
        totalBookings: number;
        totalSpent: number;
        favoriteService: string;
        memberSince: string;
    };
}>();

defineEmits(['book-appointment']);

const statsCards = computed(() => [
    {
        title: 'Total Bookings',
        value: props.stats.totalBookings,
        subtitle: 'All time appointments',
        icon: Calendar,
        iconBg: 'bg-blue-100',
        iconColor: 'text-blue-600'
    },
    {
        title: 'Total Spent',
        value: formatRupiah(props.stats.totalSpent),
        subtitle: 'Lifetime spending',
        icon: Scissors,
        iconBg: 'bg-green-100',
        iconColor: 'text-green-600'
    },
    {
        title: 'Favorite Service',
        value: props.stats.favoriteService,
        subtitle: 'Most booked service',
        icon: Star,
        iconBg: 'bg-yellow-100',
        iconColor: 'text-yellow-600'
    },
    {
        title: 'Member Since',
        value: new Date(props.stats.memberSince).getFullYear(),
        subtitle: 'Years of trust',
        icon: Clock,
        iconBg: 'bg-purple-100',
        iconColor: 'text-purple-600'
    }
]);

const formatRupiah = (amount: number) => new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(amount || 0);
const formatDate = (date: string) => new Date(date).toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
</script>
