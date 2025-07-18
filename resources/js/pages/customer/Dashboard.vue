<template>
    <div class="min-h-screen bg-gray-50">
        <section class="bg-white border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="flex items-center justify-between">
                    <div data-aos="fade-right">
                        <h1 class="text-3xl font-bold text-gray-900">Welcome back, {{ customer?.name }}!</h1>
                        <p class="text-lg text-gray-600 mt-1">Manage your appointments and grooming experience</p>
                    </div>
                    <div class="hidden md:block" data-aos="fade-left">
                        <div class="w-20 h-20 rounded-full overflow-hidden border-4 border-white shadow-lg">
                            <img
                                v-if="customer?.avatar"
                                :src="customer.avatar"
                                :alt="customer.name"
                                class="w-full h-full object-cover"
                            />
                            <div v-else class="w-full h-full bg-gray-200 flex items-center justify-center">
                                <User class="w-10 h-10 text-gray-500" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-white/80 backdrop-blur-lg shadow-sm sticky top-0 z-40 border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <nav class="flex space-x-6 overflow-x-auto py-3">
                    <button
                        v-for="tab in tabs"
                        :key="tab.id"
                        @click="activeTab = tab.id"
                        class="flex items-center gap-2 px-4 py-2.5 rounded-lg font-semibold transition-all whitespace-nowrap text-sm"
                        :class="activeTab === tab.id
                            ? 'bg-blue-600 text-white shadow-md'
                            : 'text-gray-600 hover:text-blue-600 hover:bg-blue-50'"
                    >
                        <component :is="tab.icon" class="w-5 h-5" />
                        {{ tab.name }}
                    </button>
                </nav>
            </div>
        </section>

        <main class="py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div v-if="activeTab === 'overview'" class="space-y-8">
                    <DashboardOverview
                        :upcoming-bookings="customerBookings.filter(b => new Date(b.date) >= new Date()) || []"
                        :stats="customerStats || {}"
                        @book-appointment="activeTab = 'booking'"
                    />
                </div>

                <div v-if="activeTab === 'booking'" class="space-y-8">
                    <BookingFlow
                        :branches="branches || []"
                        :services="services || []"
                        :barbers="barbers || []"
                        :bookings="allFutureBookings || []"
                        @booking-complete="handleBookingComplete"
                    />
                </div>

                <div v-if="activeTab === 'history'" class="space-y-8">
                    <BookingHistory
                        :bookings="customerBookings || []"
                        @write-review="handleWriteReview"
                        @view-details="handleViewDetails"
                    />
                </div>
            </div>
        </main>
    </div>

    <BookingDetailsModal
        :is-open="showBookingDetails"
        :booking="selectedBooking"
        @close="showBookingDetails = false"
        @write-review="handleReviewFromDetails"
    />
    <ReviewModal
        :is-open="showReviewModal"
        :booking="selectedBookingForReview"
        @close="showReviewModal = false"
        @review-submitted="handleReviewSubmitted"
    />
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { router } from '@inertiajs/vue3';
import AOS from 'aos';
import 'aos/dist/aos.css';
import DashboardOverview from '@/components/dashboard/DashboardOverview.vue';
import BookingFlow from '@/components/dashboard/BookingFlow.vue';
import BookingHistory from '@/components/dashboard/BookingHistory.vue';
import BookingDetailsModal from '@/components/dashboard/BookingDetailsModal.vue';
import ReviewModal from '@/components/dashboard/ReviewModal.vue';
import { LayoutDashboard, Calendar, History, User } from 'lucide-vue-next';
import Swal from 'sweetalert2';
import dayjs from 'dayjs';

interface Customer { id: number; name: string; email: string; avatar?: string; phone: string; }
interface Booking { id: number; date: string; }
interface BookingPayload {
    branch: { id: number };
    service: { id: number };
    barber: { id: number };
    date: string;
    time: string;
    notes?: string;
}

const props = defineProps<{
    customer: Customer;
    branches: any[];
    services: any[];
    barbers: any[];
    customerStats: object;
    allFutureBookings: Booking[];
    customerBookings: Booking[];
}>();

const activeTab = ref('overview');
const showReviewModal = ref(false);
const showBookingDetails = ref(false);
const selectedBookingForReview = ref<Booking | null>(null);
const selectedBooking = ref<Booking | null>(null);

const tabs = [
    { id: 'overview', name: 'Overview', icon: LayoutDashboard },
    { id: 'booking', name: 'Book Appointment', icon: Calendar },
    { id: 'history', name: 'History', icon: History },
];

const handleBookingComplete = async (booking: BookingPayload) => {
    try {
        const response = await fetch('/booking', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
            },
            body: JSON.stringify({
                service_id: booking.service.id,
                barber_id: booking.barber.id,
                branch_id: booking.branch.id,
                time: dayjs(`${booking.date} ${booking.time}`).format('YYYY-MM-DD HH:mm:ss'),
                note: booking.notes || '',
                date: dayjs(booking.date).format('YYYY-MM-DD'),
            }),
        });

        const data = await response.json();

        if (data.snap_token) {
            const updateStatus = async (result: any) => {
                try {
                    await fetch('/booking/update-status', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                        },
                        body: JSON.stringify({
                            order_id: result.order_id,
                            transaction_status: result.transaction_status,
                        }),
                    });
                } catch (err) {
                    console.error('Failed to update booking status:', err);
                }
            };

            window.snap.pay(data.snap_token, {
                onSuccess: async function (result) {
                    await updateStatus(result);
                    await Swal.fire({
                        title: 'Success!',
                        text: 'Payment completed successfully. The page will now refresh.',
                        icon: 'success',
                        timer: 2000,
                        timerProgressBar: true,
                        showConfirmButton: false,
                    });

                    router.visit(window.location.href, {
                        preserveScroll: true,
                        onSuccess: () => {
                            activeTab.value = 'history';
                        }
                    });
                },
                onPending: async function (result) {
                    await updateStatus(result);
                    await Swal.fire('Pending', 'Waiting for your payment to complete...', 'info');
                    activeTab.value = 'history';
                },
                onError: function () {
                    Swal.fire('Error', 'Payment failed. Please try again.', 'error');
                },
                onClose: function () {
                },
            });
        } else {
            Swal.fire('Error', 'Failed to retrieve Snap token.', 'error');
        }
    } catch (error) {
        Swal.fire('Error', 'Booking failed. Please try again.', 'error');
    }
};

const handleWriteReview = (booking: Booking) => {
    selectedBookingForReview.value = booking;
    showReviewModal.value = true;
};

const handleViewDetails = (booking: Booking) => {
    selectedBooking.value = booking;
    showBookingDetails.value = true;
};

const handleReviewFromDetails = (booking: Booking) => {
    showBookingDetails.value = false;
    handleWriteReview(booking);
};

const handleReviewSubmitted = () => {
    showReviewModal.value = false;
    Swal.fire('Thank You!', 'Your review has been submitted.', 'success');
    router.reload({ only: ['customerBookings', 'reviewedBarberIds'] });
};

onMounted(() => {
    AOS.init({ duration: 800, easing: 'ease-out-cubic', once: true, offset: 50 });
});
</script>
