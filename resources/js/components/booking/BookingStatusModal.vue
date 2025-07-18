<template>
    <Transition name="modal-fade">
        <div v-if="isOpen" class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4" @click.self="close">
            <div v-if="isOpen && booking" class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-md w-full max-h-screen overflow-y-auto" @click.stop>
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Change Booking Status</h2>
                    <p class="text-gray-600 dark:text-gray-400">For booking ID: {{ booking.id }}</p>
                </div>

                <div class="p-6 space-y-4">
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">New Status</label>
                        <select
                            v-model="newStatus"
                            id="status"
                            class="w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500"
                        >
                            <option value="pending">Pending</option>
                            <option value="paid">Paid (Confirmed)</option>
                            <option value="done">Done (Completed)</option>
                            <option value="canceled">Canceled</option>
                        </select>
                    </div>
                </div>

                <div class="p-6 bg-gray-50 dark:bg-gray-900/50 border-t dark:border-gray-700 flex justify-end gap-3">
                    <button @click="close" class="px-5 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg font-medium text-gray-800 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                        Cancel
                    </button>
                    <button
                        @click="updateStatus"
                        :disabled="form.processing || newStatus === booking.status"
                        class="px-5 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        Save Changes
                    </button>
                </div>
            </div>
        </div>
    </Transition>
</template>

<script setup lang="ts">
import { ref, watch } from 'vue';
import { useForm } from '@inertiajs/vue3';

interface Booking {
    id: number;
    status: 'pending' | 'paid' | 'done' | 'canceled';
}

const props = defineProps<{
    isOpen: boolean;
    booking: Booking | null;
}>();

const emit = defineEmits(['close', 'updated']);

const newStatus = ref('');

const form = useForm({
    status: '',
});

watch(() => props.booking, (newBooking) => {
    if (newBooking) {
        newStatus.value = newBooking.status;
    }
});

const close = () => emit('close');

const updateStatus = () => {
    if (!props.booking) return;

    form.status = newStatus.value;

    form.put(`/admin/bookings/${props.booking.id}/status`, {
        preserveScroll: true,
        onSuccess: () => {
            emit('updated');
        },
        onError: (errors) => {
            console.error('Failed to update status:', errors);
        }
    });
};
</script>

<style scoped>
.modal-fade-enter-active, .modal-fade-leave-active {
    transition: opacity 0.3s ease;
}
.modal-fade-enter-from, .modal-fade-leave-to {
    opacity: 0;
}
</style>
