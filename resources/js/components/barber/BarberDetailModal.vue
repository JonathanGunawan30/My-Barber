<template>
    <!-- Modal Overlay -->
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
            <!-- Modal Content -->
            <Transition
                enter-active-class="transition-all duration-300 ease-out"
                enter-from-class="opacity-0 scale-95 translate-y-4"
                enter-to-class="opacity-100 scale-100 translate-y-0"
                leave-active-class="transition-all duration-200 ease-in"
                leave-from-class="opacity-100 scale-100 translate-y-0"
                leave-to-class="opacity-0 scale-95 translate-y-4"
            >
                <div
                    v-if="isOpen && barber"
                    @click.stop
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl max-w-3xl w-full max-h-[90vh] overflow-hidden flex flex-col"
                >
                    <!-- Modal Header -->
                    <div class="relative bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 p-6 flex-shrink-0">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="p-3 bg-blue-100 dark:bg-blue-900/50 rounded-lg">
                                    <Eye class="w-8 h-8 text-blue-600 dark:text-blue-400" />
                                </div>
                                <div>
                                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ barber.name }}</h2>
                                    <p class="text-gray-600 dark:text-gray-400 mt-1">Barber Details & Information</p>
                                </div>
                            </div>
                            <button
                                @click="closeModal"
                                class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-gray-200 dark:hover:bg-gray-700 rounded-lg transition-colors duration-200"
                            >
                                <X class="w-6 h-6" />
                            </button>
                        </div>

                        <!-- Status Badge -->
                        <div class="absolute top-6 right-16">
                          <span :class="[
                            'inline-flex items-center px-3 py-1 rounded-full text-sm font-medium',
                            barber.status === 'active'
                              ? 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300'
                              : 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300'
                          ]">
                            <div :class="[
                              'w-2 h-2 rounded-full mr-2',
                              barber.status === 'active' ? 'bg-green-500' : 'bg-red-500'
                            ]"></div>
                            {{ barber.status === 'active' ? 'Active' : 'Inactive' }}
                          </span>
                        </div>
                    </div>

                    <!-- Modal Body -->
                    <div class="flex-grow p-6 overflow-y-auto">
                        <div class="space-y-6">
                            <!-- Basic Information -->
                            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                                    <User class="w-5 h-5 mr-2 text-blue-600 dark:text-blue-400" />
                                    Basic Information
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">
                                            Barber ID
                                        </label>
                                        <p class="text-gray-900 dark:text-white font-mono bg-white dark:bg-gray-800 px-3 py-2 rounded border">
                                            #{{ barber.id }}
                                        </p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">
                                            Barber Name
                                        </label>
                                        <p class="text-gray-900 dark:text-white bg-white dark:bg-gray-800 px-3 py-2 rounded border">
                                            {{ barber.name }}
                                        </p>
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">
                                            Assigned Branch
                                        </label>
                                        <div class="bg-white dark:bg-gray-800 border rounded-lg p-3">
                                            <p v-if="barber.branch" class="text-gray-900 dark:text-white leading-relaxed">
                                                <Building class="w-4 h-4 inline-block mr-2 text-gray-500" />
                                                {{ barber.branch.name }} (ID: {{ barber.branch.id }})
                                            </p>
                                            <p v-else class="text-gray-500 dark:text-gray-400 italic">
                                                <Info class="w-4 h-4 inline-block mr-2 text-yellow-500" />
                                                Not assigned to any branch
                                            </p>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">
                                            Status
                                        </label>
                                        <div class="flex items-center space-x-2">
                                            <span :class="[
                                              'inline-flex items-center px-3 py-1 rounded-full text-sm font-medium',
                                              barber.status === 'active'
                                                ? 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300'
                                                : 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300'
                                            ]">
                                              <div :class="[
                                                'w-2 h-2 rounded-full mr-2',
                                                barber.status === 'active' ? 'bg-green-500' : 'bg-red-500'
                                              ]"></div>
                                              {{ barber.status === 'active' ? 'Active' : 'Inactive' }}
                                            </span>
                                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                              {{ barber.status === 'active' ? 'Barber is currently available' : 'Barber is currently unavailable' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Barber Photo -->
                            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                                    <Camera class="w-5 h-5 mr-2 text-green-600 dark:text-green-400" />
                                    Barber Photo
                                </h3>
                                <div v-if="barber.photo" class="space-y-3">
                                    <div class="relative group cursor-pointer" @click="showFullImage">
                                        <img
                                            :src="`/storage/${barber.photo}`"
                                            :alt="barber.name"
                                            class="w-full h-64 object-cover rounded-lg border border-gray-200 dark:border-gray-600 transition-transform duration-200 group-hover:scale-[1.02]"
                                        />
                                        <div class="absolute inset-0 bg-gray-900/0 opacity-0 group-hover:opacity-100 group-hover:bg-gray-900/20 transition-all duration-200 rounded-lg flex items-center justify-center">
                                            <div class="transition-opacity duration-200">
                                                <div class="bg-white dark:bg-gray-800 rounded-full p-3 shadow-lg">
                                                    <ZoomIn class="w-6 h-6 text-gray-700 dark:text-gray-300" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 text-center">
                                        Click image to view in full size
                                    </p>
                                </div>
                                <div v-else class="text-center py-8">
                                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-200 dark:bg-gray-700 rounded-full mb-3">
                                        <Camera class="w-8 h-8 text-gray-400" />
                                    </div>
                                    <p class="text-gray-500 dark:text-gray-400">No photo available</p>
                                    <p class="text-sm text-gray-400 dark:text-gray-500 mt-1">Upload a photo for this barber</p>
                                </div>
                            </div>

                            <!-- Timestamps -->
                            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                                    <Clock class="w-5 h-5 mr-2 text-orange-600 dark:text-orange-400" />
                                    Timeline
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">
                                            Created Date
                                        </label>
                                        <p class="text-gray-900 dark:text-white bg-white dark:bg-gray-800 px-3 py-2 rounded border">
                                            {{ formatDate(barber.created_at) }}
                                        </p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">
                                            Last Updated
                                        </label>
                                        <p class="text-gray-900 dark:text-white bg-white dark:bg-gray-800 px-3 py-2 rounded border">
                                            {{ formatDate(barber.updated_at) }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="border-t border-gray-200 dark:border-gray-700 px-6 py-4 bg-gray-50 dark:bg-gray-700/30 flex-shrink-0">
                        <div class="flex justify-between items-center">
                            <div class="text-sm text-gray-600 dark:text-gray-400">
                                Barber ID: {{ barber.id }} • Last updated {{ formatRelativeTime(barber.updated_at) }}
                            </div>
                            <div class="flex space-x-3">
                                <button
                                    @click="editBarber"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200"
                                >
                                    <Pencil class="w-4 h-4 mr-2" />
                                    Edit Barber
                                </button>
                                <button
                                    @click="closeModal"
                                    class="px-4 py-2 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-200"
                                >
                                    Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </Transition>
        </div>
    </Transition>

    <!-- Full Image Modal -->
    <Transition
        enter-active-class="transition-opacity duration-300 ease-out"
        enter-from-class="opacity-0"
        enter-to-class="opacity-100"
        leave-active-class="transition-opacity duration-200 ease-in"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
    >
        <div
            v-if="showImageModal"
            class="fixed inset-0 bg-black bg-opacity-90 flex items-center justify-center z-[60] p-4"
            @click="closeImageModal"
        >
            <Transition
                enter-active-class="transition-all duration-300 ease-out"
                enter-from-class="opacity-0 scale-90"
                enter-to-class="opacity-100 scale-100"
                leave-active-class="transition-all duration-200 ease-in"
                leave-from-class="opacity-100 scale-100"
                leave-to-class="opacity-0 scale-90"
            >
                <div v-if="showImageModal && barber?.photo" class="relative max-w-6xl max-h-full">
                    <img
                        :src="`/storage/${barber.photo}`"
                        :alt="barber.name"
                        class="max-w-full max-h-full object-contain rounded-lg"
                    />
                    <button
                        @click="closeImageModal"
                        class="absolute top-4 right-4 text-white hover:text-gray-300 bg-black bg-opacity-50 rounded-full p-3 transition-colors duration-200"
                    >
                        <X class="w-6 h-6" />
                    </button>
                    <div class="absolute bottom-4 left-4 bg-black bg-opacity-75 text-white p-4 rounded-lg max-w-md">
                        <h3 class="font-semibold text-lg">{{ barber.name }}</h3>
                        <p v-if="barber.branch" class="text-gray-300 mt-1">Branch: {{ barber.branch.name }}</p>
                        <p v-else class="text-gray-300 mt-1">Unassigned</p>
                    </div>
                </div>
            </Transition>
        </div>
    </Transition>
</template>

<script setup>
import { ref, watch } from 'vue'
import {
    Eye, X, User, Building, Camera, Clock, ZoomIn, Pencil, Info
} from 'lucide-vue-next'

const props = defineProps({
    isOpen: {
        type: Boolean,
        default: false
    },
    barber: {
        type: Object,
        default: null
    }
})

const emit = defineEmits(['close', 'edit'])

const showImageModal = ref(false)

watch(() => props.isOpen, (newValue) => {
    if (newValue) {
        document.body.style.overflow = 'hidden'
    } else {
        document.body.style.overflow = 'auto'
        showImageModal.value = false
    }
})
const closeModal = () => {
    emit('close')
}

const editBarber = () => {
    emit('edit', props.barber)
    closeModal()
}

const showFullImage = () => {
    showImageModal.value = true
}

const closeImageModal = () => {
    showImageModal.value = false
}

const formatDate = (dateString) => {
    if (!dateString) return 'N/A'
    const date = new Date(dateString)
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    })
}

const formatRelativeTime = (dateString) => {
    if (!dateString) return 'N/A'
    const date = new Date(dateString)
    const now = new Date()
    const diffInSeconds = Math.floor((now - date) / 1000)

    if (diffInSeconds < 60) return 'just now'
    if (diffInSeconds < 3600) return `${Math.floor(diffInSeconds / 60)} minutes ago`
    if (diffInSeconds < 86400) return `${Math.floor(diffInSeconds / 86400)} days ago`
    if (diffInSeconds < 2592000) return `${Math.floor(diffInSeconds / 2592000)} months ago`
    if (diffInSeconds < 31536000) return `${Math.floor(diffInSeconds / 31536000)} years ago`
    return `${Math.floor(diffInSeconds / 31536000)} years ago`
}
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

.transition-all {
    transition-property: all;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
}

.bg-gradient-to-r {
    background-size: 200% 200%;
    animation: gradientShift 6s ease infinite;
}

@keyframes gradientShift {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}
</style>
