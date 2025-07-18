<template>
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Booking History</h2>
                <p class="text-gray-600">View all your past and upcoming appointments</p>
            </div>
            <div class="flex items-center gap-4">
                <select
                    v-model="statusFilter"
                    class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-900"
                >
                    <option value="">All Status</option>
                    <option value="confirmed">Confirmed / Pending</option>
                    <option value="completed">Completed</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>
        </div>

        <div v-if="filteredBookings.length === 0" class="text-center py-12 bg-white rounded-2xl shadow-lg">
            <Calendar class="w-16 h-16 text-gray-300 mx-auto mb-4" />
            <h3 class="text-lg font-medium text-gray-900 mb-2">No Bookings Found</h3>
            <p class="text-gray-500">You haven't made any bookings yet</p>
        </div>

        <div v-else class="space-y-4">
            <div
                v-for="booking in filteredBookings"
                :key="booking.id"
                class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-xl transition-all duration-300"
            >
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 rounded-xl overflow-hidden">
                            <img
                                v-if="booking.service.photo"
                                :src="`/storage/${booking.service.photo}`"
                                :alt="booking.service.name"
                                class="w-full h-full object-cover"
                            />
                            <div v-else class="w-full h-full bg-blue-100 flex items-center justify-center">
                                <Scissors class="w-8 h-8 text-blue-600" />
                            </div>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900">{{ booking.service.name }}</h3>
                            <p class="text-gray-600">{{ booking.branch.name }}</p>
                            <p class="text-sm text-gray-500">{{ formatDateTime(booking.date, booking.time) }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-2xl font-bold text-gray-900 mb-2">{{ formatRupiah(booking.service.price) }}</p>
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium"
                            :class="getStatusClass(booking.status)"
                        >
                            {{ getStatusText(booking.status) }}
                        </span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                            <User class="w-5 h-5 text-gray-600" />
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Barber</p>
                            <p class="font-medium text-gray-900">{{ booking.barber.name }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                            <Clock class="w-5 h-5 text-gray-600" />
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Duration</p>
                            <p class="font-medium text-gray-900">{{ booking.service.duration }} minutes</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                            <CreditCard class="w-5 h-5 text-gray-600" />
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Payment</p>
                            <p class="font-medium text-gray-900">{{ 'Cash' }}</p>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                    <button
                        @click="$emit('view-details', booking)"
                        class="text-blue-600 hover:text-blue-800 font-medium flex items-center gap-2"
                    >
                        <Eye class="w-4 h-4" />
                        View Details
                    </button>
                    <div class="flex items-center gap-3">
                        <button
                            v-if="booking.status === 'done' && !booking.testimonial"
                            @click="$emit('write-review', booking)"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors flex items-center gap-2"
                        >
                            <Star class="w-4 h-4" />
                            Write Review
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import {
    Calendar, Scissors, User, Clock, CreditCard, Eye, Star
} from 'lucide-vue-next'

interface Barber {
    id: number;
    name: string;
}
interface Service {
    name: string;
    price: number | string;
    duration: number;
    photo?: string | null;
}
interface Branch {
    name: string;
}
interface Booking {
    id: number;
    status: 'paid' | 'pending' | 'canceled' | 'done';
    date: string;
    time: string;
    service: Service;
    branch: Branch;
    barber: Barber;
    payment?: {
        method: string;
    } | null;
    testimonial?: any | null;
}

const props = defineProps<{
    bookings: Booking[];
    reviewedBarberIds: number[];
}>()

const emit = defineEmits(['write-review', 'view-details'])

const statusFilter = ref('')

const filteredBookings = computed(() => {
    if (!statusFilter.value) {
        return props.bookings;
    }

    switch (statusFilter.value) {
        case 'confirmed':
            return props.bookings.filter(b => b.status === 'paid' || b.status === 'pending');
        case 'completed':
            return props.bookings.filter(b => b.status === 'done');
        case 'cancelled':
            return props.bookings.filter(b => b.status === 'canceled');
        default:
            return props.bookings;
    }
})

const getStatusClass = (status: string): string => {
    switch (status) {
        case 'paid':
        case 'pending':
            return 'bg-blue-100 text-blue-800';
        case 'done':
            return 'bg-green-100 text-green-800';
        case 'canceled':
            return 'bg-red-100 text-red-800';
        default:
            return 'bg-gray-100 text-gray-800';
    }
}

const getStatusText = (status: string): string => {
    switch (status) {
        case 'paid':
            return 'Confirmed';
        case 'pending':
            return 'Pending Payment';
        case 'done':
            return 'Completed';
        case 'canceled':
            return 'Cancelled';
        default:
            return status.charAt(0).toUpperCase() + status.slice(1);
    }
}

const formatRupiah = (amount: number | string): string => {
    const numAmount = typeof amount === 'string' ? parseFloat(amount) : amount;
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    }).format(numAmount);
}

const formatDateTime = (date: string, time: string): string => {
    const timeWithoutSeconds = time.slice(0, 5);
    const bookingDate = new Date(`${date}T00:00:00Z`);

    return `${bookingDate.toLocaleDateString('id-ID', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    })} at ${timeWithoutSeconds}`;
}
</script>
