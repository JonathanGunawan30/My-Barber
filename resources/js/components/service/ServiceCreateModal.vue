<template>
    <Transition
        enter-active-class="transition-opacity duration-300 ease-out"
        enter-from-class="opacity-0"
        enter-to-class="opacity-100"
        leave-active-class="transition-opacity duration-200 ease-in"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
    >
        <div
            v-if="isOpen"
            class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4"
            @click="closeModal"
        >
            <Transition
                enter-active-class="transition-all duration-300 ease-out"
                enter-from-class="opacity-0 scale-95 translate-y-4"
                enter-to-class="opacity-100 scale-100 translate-y-0"
                leave-active-class="transition-all duration-200 ease-in"
                leave-from-class="opacity-100 scale-100 translate-y-0"
                leave-to-class="opacity-0 scale-95 translate-y-4"
            >
                <div
                    v-if="isOpen"
                    @click.stop
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-hidden"
                >
                    <div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-blue-100 dark:bg-blue-900/50 rounded-lg">
                                <Scissors class="w-6 h-6 text-blue-600 dark:text-blue-400" />
                            </div>
                            <div>
                                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Add New Service</h2>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Define a new barbershop service</p>
                            </div>
                        </div>
                        <button
                            @click="closeModal"
                            class="p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors duration-200"
                        >
                            <X class="w-5 h-5 text-gray-500 dark:text-gray-400" />
                        </button>
                    </div>

                    <div class="p-6 overflow-y-auto">
                        <form @submit.prevent="submitForm" class="space-y-6">
                            <div>
                                <label for="service-name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Service Name *
                                </label>
                                <div class="relative">
                                    <input
                                        id="service-name"
                                        v-model="form.name"
                                        type="text"
                                        required
                                        placeholder="Enter service name (e.g., Haircut, Shave)"
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 transition-colors duration-200"
                                        :class="{ 'border-red-500 focus:ring-red-500': errors.name }"
                                    />
                                    <Scissors class="absolute right-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" />
                                </div>
                                <p v-if="errors.name" class="mt-1 text-sm text-red-600 dark:text-red-400">{{ errors.name }}</p>
                            </div>

                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Price (IDR) *
                                </label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500 dark:text-gray-400">Rp</span>
                                    <input
                                        id="price"
                                        v-model="form.price"
                                        type="number"
                                        min="0"
                                        required
                                        placeholder="Enter service price (e.g., 50000)"
                                        class="w-full pl-10 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 transition-colors duration-200"
                                        :class="{ 'border-red-500 focus:ring-red-500': errors.price }"
                                    />
                                    <Tag class="absolute right-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" />
                                </div>
                                <p v-if="errors.price" class="mt-1 text-sm text-red-600 dark:text-red-400">{{ errors.price }}</p>
                            </div>

                            <div>
                                <label for="duration" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Duration (minutes) *
                                </label>
                                <div class="relative">
                                    <input
                                        id="duration"
                                        v-model="form.duration"
                                        type="number"
                                        min="1"
                                        required
                                        placeholder="Enter duration in minutes (e.g., 30)"
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 transition-colors duration-200"
                                        :class="{ 'border-red-500 focus:ring-red-500': errors.duration }"
                                    />
                                    <Clock class="absolute right-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" />
                                    <span class="absolute right-10 top-1/2 transform -translate-y-1/2 text-gray-500 dark:text-gray-400 text-sm">min</span>
                                </div>
                                <p v-if="errors.duration" class="mt-1 text-sm text-red-600 dark:text-red-400">{{ errors.duration }}</p>
                            </div>

                            <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                                <button
                                    type="button"
                                    @click="closeModal"
                                    class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-200"
                                >
                                    Cancel
                                </button>
                                <button
                                    type="submit"
                                    :disabled="isSubmitting"
                                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 disabled:bg-blue-400 rounded-lg transition-colors duration-200 flex items-center space-x-2"
                                >
                                    <Loader2 v-if="isSubmitting" class="w-4 h-4 animate-spin" />
                                    <Scissors v-else class="w-4 h-4" />
                                    <span>{{ isSubmitting ? 'Creating...' : 'Create Service' }}</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </Transition>
        </div>
    </Transition>
</template>

<script setup>
import { ref, watch } from 'vue'
import { router } from '@inertiajs/vue3'
import { Scissors, Tag, Clock, X, Loader2 } from 'lucide-vue-next'
import Swal from 'sweetalert2'

const props = defineProps({
    isOpen: {
        type: Boolean,
        default: false
    }
})

const emit = defineEmits(['close', 'created'])

const form = ref({
    name: '',
    price: null,
    duration: null
})

const errors = ref({})
const isSubmitting = ref(false)

const submitForm = async () => {
    if (isSubmitting.value) return

    errors.value = {}

    if (!form.value.name.trim()) {
        errors.value.name = 'Service name is required'
        return
    }

    if (form.value.price === null || form.value.price < 0) {
        errors.value.price = 'Price is required and must be a non-negative number'
        return
    }

    if (form.value.duration === null || form.value.duration < 1) {
        errors.value.duration = 'Duration is required and must be at least 1 minute'
        return
    }

    isSubmitting.value = true

    try {
        router.post('/admin/services', form.value, {
            onSuccess: () => {
                resetForm()
                emit('created')
                closeModal()
            },
            onError: (serverErrors) => {
                errors.value = serverErrors

                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: 'Please check the form and try again',
                    confirmButtonColor: '#3B82F6'
                })
            },
            onFinish: () => {
                isSubmitting.value = false
            }
        })
    } catch (error) {
        console.error('Error creating service:', error)

        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Something went wrong. Please try again.',
            confirmButtonColor: '#3B82F6'
        })

        isSubmitting.value = false
    }
}

const resetForm = () => {
    form.value = {
        name: '',
        price: null,
        duration: null
    }
    errors.value = {}
}

const closeModal = () => {
    if (isSubmitting.value) return

    resetForm()
    emit('close')
}

watch(() => props.isOpen, (newValue) => {
    if (newValue) {
        document.body.style.overflow = 'hidden'
    } else {
        document.body.style.overflow = 'auto'
    }
})
</script>

<style scoped>
.overflow-y-auto::-webkit-scrollbar {
    width: 6px;
}

.overflow-y-auto::-webkit-scrollbar-track {
    background: transparent;
}

.overflow-y-auto::-webkit-scrollbar-thumb {
    background: rgba(156, 163, 175, 0.5);
    border-radius: 3px;
}

.overflow-y-auto::-webkit-scrollbar-thumb:hover {
    background: rgba(156, 163, 175, 0.7);
}
</style>
