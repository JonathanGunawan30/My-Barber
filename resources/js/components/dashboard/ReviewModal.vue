<template>
    <Transition name="modal-fade">
        <div v-if="isOpen" class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4" @click.self="close">
            <Transition
                enter-active-class="transition-all duration-300 ease-out"
                enter-from-class="opacity-0 scale-90"
                enter-to-class="opacity-100 scale-100"
                leave-active-class="transition-all duration-200 ease-in"
                leave-from-class="opacity-100 scale-100"
                leave-to-class="opacity-0 scale-90"
            >
                <div v-if="isOpen && booking" class="bg-white rounded-2xl shadow-2xl max-w-lg w-full overflow-y-auto" @click.stop>
                    <form @submit.prevent="submitReview">
                        <div class="p-6 border-b border-gray-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h2 class="text-2xl font-bold text-gray-900">Write a Review</h2>
                                    <p class="text-gray-600">For service: <span class="font-medium text-blue-600">{{ booking.service.name }}</span></p>
                                </div>
                                <button @click="close" type="button" class="w-8 h-8 rounded-full hover:bg-gray-100 flex items-center justify-center">
                                    <X class="w-5 h-5 text-gray-500" />
                                </button>
                            </div>
                        </div>

                        <div class="p-6 space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Your Rating</label>
                                <div class="flex items-center gap-2">
                                    <button
                                        v-for="star in 5"
                                        :key="star"
                                        type="button"
                                        @click="form.rating = star"
                                        class="text-gray-300 hover:text-yellow-400 transition-colors duration-200"
                                        :class="{ 'text-yellow-400': form.rating >= star }"
                                    >
                                        <Star class="w-8 h-8 fill-current" />
                                    </button>
                                </div>
                                <div v-if="form.errors.rating" class="text-sm text-red-500 mt-2">{{ form.errors.rating }}</div>
                            </div>
                            <div>
                                <label for="comment" class="block text-sm font-medium text-gray-700 mb-1">Your Comment (Optional)</label>
                                <textarea
                                    id="comment"
                                    v-model="form.comment"
                                    rows="4"
                                    placeholder="Tell us about your experience with the service and barber..."
                                    class="w-full bg-white border border-gray-300 rounded-lg px-4 py-2 text-gray-900 focus:ring-2 focus:ring-blue-500"
                                ></textarea>
                                <div v-if="form.errors.comment" class="text-sm text-red-500 mt-1">{{ form.errors.comment }}</div>
                            </div>
                        </div>

                        <div class="p-6 bg-gray-50 border-t border-gray-200 flex justify-end gap-3">
                            <button type="button" @click="close" class="px-5 py-2 bg-white border border-gray-300 rounded-lg font-medium text-gray-800 hover:bg-gray-50">
                                Cancel
                            </button>
                            <button
                                type="submit"
                                :disabled="form.processing"
                                class="px-5 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed flex items-center"
                            >
                                <span v-if="form.processing" class="flex items-center gap-2">
                                    <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Submitting...
                                </span>
                                <span v-else>Submit Review</span>
                            </button>
                        </div>
                    </form>
                </div>
            </Transition>
        </div>
    </Transition>
</template>

<script setup lang="ts">
import { watch } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { Star, X } from 'lucide-vue-next';

interface Booking {
    id: number;
    service: {
        name: string;
    };
}

const props = defineProps<{
    isOpen: boolean;
    booking: Booking | null;
}>();

const emit = defineEmits(['close', 'review-submitted']);

const form = useForm({
    rating: 0,
    comment: '',
});

watch(() => props.isOpen, (newVal) => {
    if (!newVal) {
        form.reset();
        form.clearErrors();
    }
});

const close = () => emit('close');

const submitReview = () => {
    if (!props.booking) return;

    form.post(`/bookings/${props.booking.id}/testimonials`, {
        preserveScroll: true,
        onSuccess: () => {
            emit('review-submitted');
        },
        onError: () => {
        }
    });
};
</script>

<style scoped>
.modal-fade-enter-active,
.modal-fade-leave-active {
    transition: opacity 0.3s ease;
}
.modal-fade-enter-from,
.modal-fade-leave-to {
    opacity: 0;
}
</style>
