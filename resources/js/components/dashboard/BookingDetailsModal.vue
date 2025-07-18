<template>
    <div
        v-if="isOpen"
        class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 p-4"
        @click.self="$emit('close')"
    >
        <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full max-h-[90vh] overflow-y-auto">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-bold text-gray-900">Booking Details</h2>
                    <button
                        @click="$emit('close')"
                        class="w-8 h-8 rounded-full hover:bg-gray-100 flex items-center justify-center transition-colors"
                    >
                        <X class="w-5 h-5 text-gray-500" />
                    </button>
                </div>
            </div>

            <div v-if="booking" class="p-6 space-y-6">
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
                        <p class="text-2xl font-bold text-blue-600 mt-1">{{ formatRupiah(booking.service.price) }}</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                            <MapPin class="w-5 h-5 text-gray-600" />
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Location</p>
                            <p class="font-medium text-gray-900">{{ booking.branch.name }}</p>
                            <p class="text-sm text-gray-600">{{ booking.branch.address }}</p>
                        </div>
                    </div>

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
                            <Calendar class="w-5 h-5 text-gray-600" />
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Date & Time</p>
                            <p class="font-medium text-gray-900">{{ formatDateTime(booking.date, booking.time) }}</p>
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
                            <p class="text-sm text-gray-500">Payment Method</p>
                            <p class="font-medium text-gray-900">{{ 'Cash' }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Status:</span>
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium"
                            :class="getStatusClass(booking.status)"
                        >
                            {{ getStatusText(booking.status) }}
                        </span>
                    </div>
                </div>

                <div class="flex items-center gap-3 pt-4 border-t border-gray-200">
                    <button
                        v-if="booking.status === 'done' && !booking.review"
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-medium transition-colors"
                    >
                        Write Review
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import {
    X, Scissors, MapPin, User, Calendar, Clock, CreditCard
} from 'lucide-vue-next'

interface Booking {
    id: number;
    status: 'paid' | 'pending' | 'canceled' | 'done';
    date: string;
    time: string;
    service: {
        name: string;
        price: number | string;
        duration: number;
        description: string;
        photo?: string | null;
    };
    branch: {
        name: string;
        address: string;
    };
    barber: {
        name: string;
    };
    payment?: {
        method: string;
    } | null;
    review?: any | null;
}

const props = defineProps<{
    isOpen: boolean
    booking: Booking | null
}>()

const emit = defineEmits(['close'])

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
