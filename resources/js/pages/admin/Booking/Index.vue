<template>
    <Layout>
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
                <div class="flex-1 max-w-md">
                    <div class="relative group">
                        <Search class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-blue-500 w-5 h-5 transition-colors duration-200" />
                        <input
                            v-model="searchQuery"
                            type="text"
                            placeholder="Search by customer, barber, service..."
                            class="w-full pl-12 pr-4 py-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 transition-all duration-200 shadow-sm hover:shadow-md"
                        />
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="relative">
                        <select
                            v-model="statusFilter"
                            class="appearance-none bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 pr-10 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 shadow-sm hover:shadow-md cursor-pointer"
                        >
                            <option value="">All Status</option>
                            <option value="pending">Pending</option>
                            <option value="paid">Paid (Confirmed)</option>
                            <option value="done">Done</option>
                            <option value="canceled">Canceled</option>
                        </select>
                        <ChevronDown class="absolute right-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" />
                    </div>

                    <Transition enter-active-class="transition-all duration-200 ease-out" enter-from-class="opacity-0 scale-95" enter-to-class="opacity-100 scale-100" leave-active-class="transition-all duration-150 ease-in" leave-from-class="opacity-100 scale-100" leave-to-class="opacity-0 scale-95">
                        <button
                            v-if="searchQuery || statusFilter"
                            @click="clearFilters"
                            class="px-4 py-3 text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200 shadow-sm hover:shadow-md"
                            title="Clear all filters"
                        >
                            <X class="w-4 h-4" />
                        </button>
                    </Transition>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 hover:shadow-lg transition-all duration-200 hover:-translate-y-1">
                <div class="flex items-center">
                    <div class="p-3 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg">
                        <Calendar class="w-6 h-6 text-white" />
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Bookings</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ bookings.length }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 hover:shadow-lg transition-all duration-200 hover:-translate-y-1">
                <div class="flex items-center">
                    <div class="p-3 bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg">
                        <DollarSign class="w-6 h-6 text-white" />
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Revenue</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ formatRupiah(totalRevenue) }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 hover:shadow-lg transition-all duration-200 hover:-translate-y-1">
                <div class="flex items-center">
                    <div class="p-3 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg">
                        <Clock class="w-6 h-6 text-white" />
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Upcoming</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ upcomingBookingsCount }} Bookings</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Booking List</h3>
            </div>

            <div v-if="filteredBookings.length === 0" class="p-12 text-center">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No bookings found</h3>
                <p class="text-gray-600 dark:text-gray-400">Try adjusting your search or filter criteria.</p>
            </div>

            <div v-else class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900/50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Details</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Date & Time</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    <tr v-for="booking in paginatedBookings" :key="booking.id" class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img
                                        v-if="booking.customer.avatar"
                                        :src="booking.customer.avatar"
                                        :alt="booking.customer.name"
                                        class="h-10 w-10 rounded-full object-cover"
                                    >
                                    <div
                                        v-else
                                        class="h-10 w-10 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center"
                                    >
                                        <User class="w-5 h-5 text-gray-500 dark:text-gray-300" />
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ booking.customer.name }}</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ booking.customer.email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 dark:text-white">{{ booking.service.name }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">by {{ booking.barber.name }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 dark:text-white">{{ formatJustDate(booking.date) }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ formatJustTime(booking.time) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">{{ formatRupiah(booking.service.price) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                             <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium" :class="getStatusClass(booking.status)">
                                {{ getStatusText(booking.status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-2">
                                <button
                                    @click="openDetailModal(booking)"
                                    class="p-2 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 bg-blue-50 dark:bg-blue-900/30 hover:bg-blue-100 dark:hover:bg-blue-900/50 rounded-lg transition-all duration-200 hover:scale-105 transform"
                                    title="View Details"
                                >
                                    <Eye class="w-4 h-4" />
                                </button>
                                <button
                                    @click="openStatusModal(booking)"
                                    class="p-2 text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300 bg-green-50 dark:bg-green-900/30 hover:bg-green-100 dark:hover:bg-green-900/50 rounded-lg transition-all duration-200 hover:scale-105 transform"
                                    title="Change Status"
                                >
                                    <Pencil class="w-4 h-4" />
                                </button>
                                <button
                                    @click="confirmDelete(booking)"
                                    class="p-2 text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 bg-red-50 dark:bg-red-900/30 hover:bg-red-100 dark:hover:bg-red-900/50 rounded-lg transition-all duration-200 hover:scale-105 transform"
                                    title="Delete Booking"
                                >
                                    <Trash class="w-4 h-4" />
                                </button>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

        </div>

        <BookingDetailModal :is-open="showDetailModal" :booking="selectedBookingForDetail" @close="closeDetailModal" />
        <BookingStatusModal :is-open="showStatusModal" :booking="selectedBookingForStatus" @close="closeStatusModal" @updated="handleBookingUpdated" />

    </Layout>
</template>

<script setup lang="ts">
import { ref, computed, watch } from 'vue';
import Layout from '@/layouts/AdminLayout.vue';
import { router } from '@inertiajs/vue3';
import { Search, ChevronDown, X, Calendar, DollarSign, Clock, Eye, Pencil, Trash, User } from 'lucide-vue-next';
import Swal from 'sweetalert2';
import BookingDetailModal from '@/components/booking/BookingDetailModal.vue';
import BookingStatusModal from '@/components/booking/BookingStatusModal.vue';

interface Customer { id: number; name: string; email: string; avatar?: string; }
interface Service { id: number; name: string; price: number | string; }
interface Barber { id: number; name: string; }
interface Booking {
    id: number;
    date: string;
    time: string;
    status: 'pending' | 'paid' | 'done' | 'canceled';
    customer: Customer;
    service: Service;
    barber: Barber;
}
const props = defineProps<{
    bookings: Booking[];
}>();

const searchQuery = ref('');
const statusFilter = ref('');
const perPage = ref('10');
const currentPage = ref(1);
const showDetailModal = ref(false);
const selectedBookingForDetail = ref<Booking | null>(null);
const showStatusModal = ref(false);
const selectedBookingForStatus = ref<Booking | null>(null);

const filteredBookings = computed(() => {
    let filtered = props.bookings;

    if (statusFilter.value) {
        filtered = filtered.filter(b => b.status === statusFilter.value);
    }

    if (searchQuery.value) {
        const query = searchQuery.value.toLowerCase();
        filtered = filtered.filter(b =>
            b.customer.name.toLowerCase().includes(query) ||
            b.service.name.toLowerCase().includes(query) ||
            b.barber.name.toLowerCase().includes(query)
        );
    }

    return filtered;
});

const totalPages = computed(() => Math.ceil(filteredBookings.value.length / parseInt(perPage.value)));
const paginatedBookings = computed(() => {
    const start = (currentPage.value - 1) * parseInt(perPage.value);
    const end = start + parseInt(perPage.value);
    return filteredBookings.value.slice(start, end);
});


const totalRevenue = computed(() => {
    return props.bookings
        .filter(b => b.status === 'paid' || b.status === 'done')
        .reduce((sum, b) => sum + Number(b.service.price), 0);
});

const upcomingBookingsCount = computed(() => {
    const today = new Date().toISOString().split('T')[0];
    return props.bookings.filter(b =>
        (b.status === 'paid' || b.status === 'pending') && b.date >= today
    ).length;
});

const formatRupiah = (amount: number | string) => {
    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(Number(amount));
};
const formatJustDate = (date: string) => new Date(date).toLocaleDateString('id-ID', { year: 'numeric', month: 'long', day: 'numeric' });
const formatJustTime = (time: string) => time.slice(0, 5);
const getStatusClass = (status: string) => ({
    'pending': 'bg-yellow-100 text-yellow-800',
    'paid': 'bg-blue-100 text-blue-800',
    'done': 'bg-green-100 text-green-800',
    'canceled': 'bg-red-100 text-red-800',
}[status] || 'bg-gray-100 text-gray-800');
const getStatusText = (status: string) => ({
    'pending': 'Pending',
    'paid': 'Confirmed',
    'done': 'Completed',
    'canceled': 'Cancelled',
}[status] || 'Unknown');

const clearFilters = () => {
    searchQuery.value = '';
    statusFilter.value = '';
};

const openDetailModal = (booking: Booking) => {
    selectedBookingForDetail.value = booking;
    showDetailModal.value = true;
};
const closeDetailModal = () => { showDetailModal.value = false; };

const openStatusModal = (booking: Booking) => {
    selectedBookingForStatus.value = booking;
    showStatusModal.value = true;
};
const closeStatusModal = () => { showStatusModal.value = false; };

const handleBookingUpdated = () => {
    closeStatusModal();
    router.reload({ only: ['bookings'], onSuccess: () => {
            Swal.fire('Success', 'Booking status has been updated.', 'success');
        }});
};

const confirmDelete = async (booking: Booking) => {
    const result = await Swal.fire({
        title: 'Delete Booking?',
        text: `Are you sure to delete booking for ${booking.customer.name} on ${formatJustDate(booking.date)}?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#EF4444',
        cancelButtonColor: '#6B7280',
        confirmButtonText: 'Yes, delete it!',
    });

    if (result.isConfirmed) {
        router.delete(`/admin/bookings/${booking.id}`, {
            preserveScroll: true,
            onSuccess: () => {
                Swal.fire('Deleted!', 'The booking has been deleted.', 'success');
            },
            onError: () => {
                Swal.fire('Error!', 'Something went wrong.', 'error');
            }
        });
    }
};

watch([searchQuery, statusFilter, perPage], () => {
    currentPage.value = 1;
});
</script>
