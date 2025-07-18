<template>
    <div class="space-y-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">My Reviews</h2>
            <p class="text-gray-600">All the reviews you've written</p>
        </div>

        <div v-if="reviews.length === 0" class="text-center py-12 bg-white rounded-2xl shadow-lg">
            <Star class="w-16 h-16 text-gray-300 mx-auto mb-4" />
            <h3 class="text-lg font-medium text-gray-900 mb-2">No Reviews Yet</h3>
            <p class="text-gray-500">Complete a booking to write your first review</p>
        </div>

        <div v-else class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div
                v-for="review in reviews"
                :key="review.id"
                class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-xl transition-all duration-300"
            >
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center gap-1">
                        <Star
                            v-for="star in 5"
                            :key="star"
                            class="w-5 h-5"
                            :class="star <= review.rating ? 'text-yellow-400 fill-current' : 'text-gray-300'"
                        />
                    </div>
                    <button
                        @click="$emit('edit-review', review)"
                        class="text-blue-600 hover:text-blue-800 text-sm font-medium"
                    >
                        Edit
                    </button>
                </div>

                <p class="text-gray-700 mb-4 italic">"{{ review.comment }}"</p>

                <div class="border-t border-gray-200 pt-4">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <Scissors class="w-5 h-5 text-blue-600" />
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-900">{{ review.booking.service.name }}</h4>
                            <p class="text-sm text-gray-500">{{ review.booking.branch.name }}</p>
                        </div>
                    </div>
                    <p class="text-xs text-gray-400">
                        Reviewed on {{ formatDate(review.created_at) }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { Star, Scissors } from 'lucide-vue-next'

const props = defineProps<{
    reviews: Array<any>
}>()

const emit = defineEmits(['edit-review'])

const formatDate = (date: string) => {
    return new Date(date).toLocaleDateString('id-ID', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    })
}
</script>
