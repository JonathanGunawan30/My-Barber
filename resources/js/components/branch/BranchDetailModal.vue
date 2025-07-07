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
                    v-if="isOpen && branch"
                    @click.stop
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl max-w-5xl w-full max-h-[90vh] overflow-hidden flex flex-col"
                >
                    <!-- Modal Header -->
                    <div class="relative bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 p-6 flex-shrink-0">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="p-3 bg-blue-100 dark:bg-blue-900/50 rounded-lg">
                                    <Eye class="w-8 h-8 text-blue-600 dark:text-blue-400" />
                                </div>
                                <div>
                                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ branch.name }}</h2>
                                    <p class="text-gray-600 dark:text-gray-400 mt-1">Branch Details & Information</p>
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
                            branch.status === 'active'
                              ? 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300'
                              : 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300'
                          ]">
                            <div :class="[
                              'w-2 h-2 rounded-full mr-2',
                              branch.status === 'active' ? 'bg-green-500' : 'bg-red-500'
                            ]"></div>
                            {{ branch.status === 'active' ? 'Active' : 'Inactive' }}
                          </span>
                        </div>
                    </div>

                    <!-- Modal Body -->
                    <div class="flex flex-col lg:flex-row flex-grow overflow-y-auto">
                        <!-- Left Section - Branch Info -->
                        <div class="flex-1 p-6">
                            <div class="space-y-6">
                                <!-- Basic Information -->
                                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                                        <Building class="w-5 h-5 mr-2 text-blue-600 dark:text-blue-400" />
                                        Basic Information
                                    </h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">
                                                Branch ID
                                            </label>
                                            <p class="text-gray-900 dark:text-white font-mono bg-white dark:bg-gray-800 px-3 py-2 rounded border">
                                                #{{ branch.id }}
                                            </p>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">
                                                Branch Name
                                            </label>
                                            <p class="text-gray-900 dark:text-white bg-white dark:bg-gray-800 px-3 py-2 rounded border">
                                                {{ branch.name }}
                                            </p>
                                        </div>
                                        <div class="md:col-span-2">
                                            <label class="block text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">
                                                Status
                                            </label>
                                            <div class="flex items-center space-x-2">
                                            <span :class="[
                                              'inline-flex items-center px-3 py-1 rounded-full text-sm font-medium',
                                              branch.status === 'active'
                                                ? 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300'
                                                : 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300'
                                            ]">
                                              <div :class="[
                                                'w-2 h-2 rounded-full mr-2',
                                                branch.status === 'active' ? 'bg-green-500' : 'bg-red-500'
                                              ]"></div>
                                              {{ branch.status === 'active' ? 'Active' : 'Inactive' }}
                                            </span>
                                                <span class="text-sm text-gray-500 dark:text-gray-400">
                                              {{ branch.status === 'active' ? 'Branch is currently operational' : 'Branch is temporarily closed' }}
                                            </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Address Information -->
                                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                                        <MapPin class="w-5 h-5 mr-2 text-purple-600 dark:text-purple-400" />
                                        Location Details
                                    </h3>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">
                                            Full Address
                                        </label>
                                        <div class="bg-white dark:bg-gray-800 border rounded-lg p-3">
                                            <p class="text-gray-900 dark:text-white leading-relaxed">
                                                {{ branch.address }}
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Quick Actions -->
                                    <div class="mt-4 flex flex-wrap gap-2">
                                        <a
                                            :href="`https://www.google.com/maps/search/?api=1&query=${encodeURIComponent(branch.address)}`"
                                            target="_blank"
                                            class="inline-flex items-center px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200"
                                        >
                                            <MapPin class="w-4 h-4 mr-2" />
                                            Open in Google Maps
                                        </a>
                                        <button
                                            @click="copyAddress"
                                            class="inline-flex items-center px-3 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-lg transition-colors duration-200"
                                        >
                                            <Copy class="w-4 h-4 mr-2" />
                                            Copy Address
                                        </button>
                                    </div>
                                </div>

                                <!-- Branch Photo -->
                                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                                        <Camera class="w-5 h-5 mr-2 text-green-600 dark:text-green-400" />
                                        Branch Photo
                                    </h3>
                                    <div v-if="branch.photo" class="space-y-3">
                                        <div class="relative group cursor-pointer" @click="showFullImage">
                                            <img
                                                :src="`/storage/${branch.photo}`"
                                                :alt="branch.name"
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
                                        <p class="text-sm text-gray-400 dark:text-gray-500 mt-1">Upload a photo to showcase this branch</p>
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
                                                {{ formatDate(branch.created_at) }}
                                            </p>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">
                                                Last Updated
                                            </label>
                                            <p class="text-gray-900 dark:text-white bg-white dark:bg-gray-800 px-3 py-2 rounded border">
                                                {{ formatDate(branch.updated_at) }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Section - Map -->
                        <div class="lg:w-96 border-t lg:border-t-0 lg:border-l border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/30 flex-shrink-0">
                            <div class="p-6 h-full flex flex-col">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                                    <Map class="w-5 h-5 mr-2 text-blue-600 dark:text-blue-400" />
                                    Location Map
                                </h3>

                                <!-- Map Container -->
                                <div class="bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-sm border border-gray-200 dark:border-gray-600 flex-grow">
                                    <iframe
                                        width="100%"
                                        height="100%"
                                        frameborder="0"
                                        style="border:0"
                                        referrerpolicy="no-referrer-when-downgrade"
                                        :src="mapUrl"
                                        allowfullscreen
                                        loading="lazy"
                                    ></iframe>
                                </div>

                                <!-- Map Actions -->
                                <div class="mt-4 space-y-2 flex-shrink-0">
                                    <a
                                        :href="`https://www.google.com/maps/dir/?api=1&destination=${encodeURIComponent(branch.address)}`"
                                        target="_blank"
                                        class="w-full inline-flex items-center justify-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors duration-200"
                                    >
                                        <Navigation class="w-4 h-4 mr-2" />
                                        Get Directions
                                    </a>
                                    <button
                                        @click="shareLocation"
                                        class="w-full inline-flex items-center justify-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition-colors duration-200"
                                    >
                                        <Share class="w-4 h-4 mr-2" />
                                        Share Location
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="border-t border-gray-200 dark:border-gray-700 px-6 py-4 bg-gray-50 dark:bg-gray-700/30 flex-shrink-0">
                        <div class="flex justify-between items-center">
                            <div class="text-sm text-gray-600 dark:text-gray-400">
                                Branch ID: {{ branch.id }} • Last updated {{ formatRelativeTime(branch.updated_at) }}
                            </div>
                            <div class="flex space-x-3">
                                <button
                                    @click="editBranch"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200"
                                >
                                    <Pencil class="w-4 h-4 mr-2" />
                                    Edit Branch
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
                <div v-if="showImageModal && branch?.photo" class="relative max-w-6xl max-h-full">
                    <img
                        :src="`/storage/${branch.photo}`"
                        :alt="branch.name"
                        class="max-w-full max-h-full object-contain rounded-lg"
                    />
                    <button
                        @click="closeImageModal"
                        class="absolute top-4 right-4 text-white hover:text-gray-300 bg-black bg-opacity-50 rounded-full p-3 transition-colors duration-200"
                    >
                        <X class="w-6 h-6" />
                    </button>
                    <div class="absolute bottom-4 left-4 bg-black bg-opacity-75 text-white p-4 rounded-lg max-w-md">
                        <h3 class="font-semibold text-lg">{{ branch.name }}</h3>
                        <p class="text-gray-300 mt-1">{{ branch.address }}</p>
                    </div>
                </div>
            </Transition>
        </div>
    </Transition>
</template>

<script setup>
import { ref, computed, watch } from 'vue'
import {
    Eye, X, Building, MapPin, Camera, Clock, Map, Navigation, Share, Copy,
    ZoomIn, Pencil
} from 'lucide-vue-next'
import Swal from 'sweetalert2'

const props = defineProps({
    isOpen: {
        type: Boolean,
        default: false
    },
    branch: {
        type: Object,
        default: null
    }
})

const emit = defineEmits(['close', 'edit'])

const showImageModal = ref(false)

const googleMapsKey = import.meta.env.VITE_GOOGLE_MAPS_API_KEY

const mapUrl = computed(() => {
    if (!props.branch?.address) return ''
    return `https://www.google.com/maps/embed/v1/place?q=${encodeURIComponent(props.branch.address)}&key=${googleMapsKey}`
})

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

const editBranch = () => {
    emit('edit', props.branch)
    closeModal()
}

const showFullImage = () => {
    showImageModal.value = true
}

const closeImageModal = () => {
    showImageModal.value = false
}

const copyAddress = async () => {
    try {
        await navigator.clipboard.writeText(props.branch.address)
        Swal.fire({
            icon: 'success',
            title: 'Copied!',
            text: 'Address copied to clipboard',
            confirmButtonColor: '#3B82F6',
            timer: 1500,
            timerProgressBar: true
        })
    } catch (err) {
        console.error('Failed to copy address:', err)
        Swal.fire({
            icon: 'error',
            title: 'Copy Failed',
            text: 'Unable to copy address to clipboard',
            confirmButtonColor: '#3B82F6'
        })
    }
}

const shareLocation = async () => {
    const shareData = {
        title: props.branch.name,
        text: `Check out ${props.branch.name} location`,
        url: `https://www.google.com/maps/search/?api=1&query=${encodeURIComponent(props.branch.address)}`
    }

    try {
        if (navigator.share) {
            await navigator.share(shareData)
        } else {
            await navigator.clipboard.writeText(shareData.url)
            Swal.fire({
                icon: 'success',
                title: 'Link Copied!',
                text: 'Location link copied to clipboard',
                confirmButtonColor: '#3B82F6',
                timer: 2000,
                timerProgressBar: true
            })
        }
    } catch (err) {
        console.error('Error sharing location:', err)
    }
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
    if (diffInSeconds < 86400) return `${Math.floor(diffInSeconds / 3600)} hours ago`
    if (diffInSeconds < 2592000) return `${Math.floor(diffInSeconds / 86400)} days ago`
    if (diffInSeconds < 31536000) return `${Math.floor(diffInSeconds / 2592000)} months ago`
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
