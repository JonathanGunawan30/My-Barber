<template>
    <Transition
        enter-active-class="transition-opacity duration-300 ease-out"
        enter-from-class="opacity-0"
        enter-to-class="opacity-100"
        leave-active-class="transition-opacity duration-200 ease-in"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
    >
        <div v-if="isOpen" class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4" @click.self="close">
            <Transition
                enter-active-class="transition-all duration-300 ease-out"
                enter-from-class="opacity-0 scale-90"
                enter-to-class="opacity-100 scale-100"
                leave-active-class="transition-all duration-200 ease-in"
                leave-from-class="opacity-100 scale-100"
                leave-to-class="opacity-0 scale-90"
            >
                <div v-if="isOpen" class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-lg w-full max-h-[90vh] overflow-y-auto">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Booking Details</h2>
                        <button @click="close" class="w-8 h-8 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 flex items-center justify-center">
                            <X class="w-5 h-5 text-gray-500" />
                        </button>
                    </div>

                    <div v-if="booking" class="p-6 space-y-6">
                        <div class="flex items-center gap-4">
                        </div>
                        <hr class="dark:border-gray-700">
                        <div class="space-y-4">
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4 flex items-center justify-between">
                        </div>
                    </div>

                    <div class="p-6 bg-gray-50 dark:bg-gray-900/50 border-t dark:border-gray-700 flex justify-end gap-3">
                        <button @click="close" class="px-6 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg font-medium text-gray-800 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                            Close
                        </button>

                        <button
                            v-if="booking && booking.status === 'done' && !booking.testimonial"
                            @click="triggerWriteReview"
                            class="px-6 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700"
                        >
                            Write Review
                        </button>
                    </div>
                </div>
            </Transition>
        </div>
    </Transition>
</template>

<script setup lang="ts">
import { X } from 'lucide-vue-next';

interface Customer { id: number; name: string; email: string; avatar?: string; }
interface Service { id: number; name: string; price: number | string; duration: number; }
interface Branch { id: number; name: string; address: string; }
interface Barber { id: number; name: string; }
interface Booking {
    id: number;
    date: string; time: string;
    status: 'pending' | 'paid' | 'done' | 'canceled';
    customer: Customer;
    service: Service;
    branch: Branch;
    barber: Barber;
    testimonial?: any | null;
}

const props = defineProps<{
    isOpen: boolean;
    booking: Booking | null;
}>();

const emit = defineEmits(['close', 'write-review']);

const close = () => emit('close');
const triggerWriteReview = () => {
    emit('write-review', props.booking);
}

</script>
