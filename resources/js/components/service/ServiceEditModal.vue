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
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-hidden flex flex-col"
                >
                    <div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-blue-100 dark:bg-blue-900/50 rounded-lg">
                                <Pencil class="w-6 h-6 text-blue-600 dark:text-blue-400" />
                            </div>
                            <div>
                                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Edit Service</h2>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Update service information</p>
                            </div>
                        </div>
                        <button
                            @click="closeModal"
                            class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-gray-200 dark:hover:bg-gray-700 rounded-lg transition-colors duration-200"
                        >
                            <X class="w-5 h-5" />
                        </button>
                    </div>

                    <div class="flex-grow p-6 overflow-y-auto">
                        <form @submit.prevent="submitForm" class="space-y-6">
                            <div>
                                <label for="edit-service-name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Service Name *
                                </label>
                                <div class="relative">
                                    <input
                                        id="edit-service-name"
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
                                <label for="edit-service-description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Description (Optional)
                                </label>
                                <div class="relative">
                                    <textarea
                                        id="edit-service-description"
                                        v-model="form.description"
                                        rows="3"
                                        placeholder="Briefly describe the service..."
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 transition-colors duration-200 resize-y"
                                        :class="{ 'border-red-500 focus:ring-red-500': errors.description }"
                                    ></textarea>
                                    <FileText class="absolute right-3 top-3 w-5 h-5 text-gray-400" />
                                </div>
                                <p v-if="errors.description" class="mt-1 text-sm text-red-600 dark:text-red-400">{{ errors.description }}</p>
                            </div>

                            <div>
                                <label for="edit-price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Price (IDR) *
                                </label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500 dark:text-gray-400">Rp</span>
                                    <input
                                        id="edit-price"
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
                                <label for="edit-duration" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Duration (minutes) *
                                </label>
                                <div class="relative">
                                    <input
                                        id="edit-duration"
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

                            <div>
                                <label for="edit-photo" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Service Photo (Optional)
                                </label>
                                <div class="space-y-4">
                                    <div
                                        @drop="handleDrop"
                                        @dragover.prevent
                                        @dragenter.prevent="isDragging = true"
                                        @dragleave="isDragging = false"
                                        class="relative border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-6 text-center hover:border-blue-500 dark:hover:border-blue-400 transition-colors duration-200"
                                        :class="{ 'border-blue-500 dark:border-blue-400 bg-blue-50 dark:bg-blue-900/20': isDragging }"
                                    >
                                        <input
                                            id="edit-photo"
                                            ref="fileInput"
                                            type="file"
                                            accept="image/*"
                                            class="hidden"
                                            @change="handleFileSelect"
                                        />

                                        <div v-if="photoPreview" class="space-y-3">
                                            <div class="relative inline-block">
                                                <img
                                                    :src="photoPreview"
                                                    alt="New service preview"
                                                    class="w-32 h-32 object-cover rounded-lg border border-gray-200 dark:border-gray-600"
                                                />
                                                <button
                                                    type="button"
                                                    @click="clearNewPhoto"
                                                    class="absolute -top-2 -right-2 p-1 bg-red-500 hover:bg-red-600 text-white rounded-full shadow-lg transition-colors duration-200"
                                                    title="Remove selected photo"
                                                >
                                                    <X class="w-4 h-4" />
                                                </button>
                                                <div class="absolute top-2 left-2 bg-green-500 text-white text-xs px-2 py-1 rounded-full">
                                                    New
                                                </div>
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ form.photo?.name }}</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                                    {{ formatFileSize(form.photo?.size) }}
                                                </p>
                                            </div>
                                            <button
                                                type="button"
                                                @click="$refs.fileInput.click()"
                                                class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 text-sm font-medium"
                                            >
                                                Change Photo
                                            </button>
                                        </div>

                                        <div v-else-if="service?.photo" class="space-y-3">
                                            <div class="relative inline-block">
                                                <img
                                                    :src="`/storage/${service.photo}`"
                                                    :alt="service.name"
                                                    class="w-32 h-32 object-cover rounded-lg border border-gray-200 dark:border-gray-600"
                                                />
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-gray-900 dark:text-white">Current Photo</p>
                                                <button
                                                    type="button"
                                                    @click="$refs.fileInput.click()"
                                                    class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 text-sm font-medium mt-1"
                                                >
                                                    Change Photo
                                                </button>
                                            </div>
                                        </div>

                                        <div v-else class="space-y-2">
                                            <Upload class="w-8 h-8 text-gray-400 mx-auto" />
                                            <div>
                                                <button
                                                    type="button"
                                                    @click="$refs.fileInput.click()"
                                                    class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 font-medium"
                                                >
                                                    Click to upload
                                                </button>
                                                <span class="text-gray-500 dark:text-gray-400"> or drag and drop</span>
                                            </div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG, JPEG up to 2MB</p>
                                        </div>
                                    </div>
                                </div>
                                <p v-if="errors.photo" class="mt-1 text-sm text-red-600 dark:text-red-400">{{ errors.photo }}</p>
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
                                    <Save v-else class="w-4 h-4" />
                                    <span>{{ isSubmitting ? 'Updating...' : 'Update Service' }}</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </Transition>
        </div>
    </Transition>
</template>

<script setup lang="ts">
import { ref, watch } from 'vue'
import { router } from '@inertiajs/vue3'
import { Scissors, Tag, Clock, X, Loader2, Pencil, Save, Upload, FileText } from 'lucide-vue-next'
import Swal from 'sweetalert2'

const props = defineProps({
    isOpen: {
        type: Boolean,
        default: false
    },
    service: {
        type: Object,
        default: null
    }
})

const emit = defineEmits(['close', 'updated'])

const form = ref({
    name: '',
    description: '',
    price: null,
    duration: null,
    photo: null,
    _method: 'patch',
})

const errors = ref({})
const isSubmitting = ref(false)
const isDragging = ref(false)
const photoPreview = ref(null)
const fileInput = ref(null)

watch(() => props.service, (newService) => {
    if (newService) {
        form.value = {
            name: newService.name || '',
            description: newService.description || '',
            price: newService.price || null,
            duration: newService.duration || null,
            photo: null,
            _method: 'patch',
        }
        photoPreview.value = null;
        errors.value = {};
        if (fileInput.value) {
            fileInput.value.value = '';
        }
    }
}, { immediate: true })

watch(() => props.isOpen, (newValue) => {
    if (newValue) {
        document.body.style.overflow = 'hidden'
    } else {
        document.body.style.overflow = 'auto'
    }
})

const handleFileSelect = (event) => {
    const file = event.target.files[0]
    if (file) {
        validateAndSetFile(file)
    }
}

const handleDrop = (event) => {
    event.preventDefault()
    isDragging.value = false

    const files = event.dataTransfer.files
    if (files.length > 0) {
        validateAndSetFile(files[0])
    }
}

const validateAndSetFile = (file) => {
    if (!file.type.startsWith('image/')) {
        Swal.fire({
            icon: 'error',
            title: 'Invalid File Type',
            text: 'Please select an image file (PNG, JPG, JPEG)',
            confirmButtonColor: '#3B82F6'
        })
        return
    }

    if (file.size > 2 * 1024 * 1024) {
        Swal.fire({
            icon: 'error',
            title: 'File Too Large',
            text: 'Please select an image smaller than 2MB',
            confirmButtonColor: '#3B82F6'
        })
        return
    }

    form.value.photo = file;

    const reader = new FileReader()
    reader.onload = (e) => {
        photoPreview.value = e.target.result
    }
    reader.readAsDataURL(file)

    if (errors.value.photo) {
        delete errors.value.photo
    }
}

const clearNewPhoto = () => {
    form.value.photo = null;
    photoPreview.value = null;
    if (fileInput.value) {
        fileInput.value.value = '';
    }
}

const formatFileSize = (bytes) => {
    if (!bytes) return '0 Bytes'
    const k = 1024
    const sizes = ['Bytes', 'KB', 'MB', 'GB']
    const i = Math.floor(Math.log(bytes) / Math.log(k))
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i]
}

const submitForm = async () => {
    if (isSubmitting.value || !props.service) return

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
        const formData = new FormData()
        formData.append('name', form.value.name.trim())
        formData.append('description', form.value.description || '')
        formData.append('price', form.value.price)
        formData.append('duration', form.value.duration)
        formData.append('_method', 'PATCH')

        if (form.value.photo instanceof File) {
            formData.append('photo', form.value.photo);
        }

        router.post(`/admin/services/${props.service.id}`, formData, {
            forceFormData: true,
            onSuccess: () => {
                emit('updated')
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
        console.error('Error updating service:', error)

        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Something went wrong. Please try again.',
            confirmButtonColor: '#3B82F6'
        })

        isSubmitting.value = false
    }
}

const closeModal = () => {
    if (isSubmitting.value) return

    form.value = {
        name: props.service?.name || '',
        description: props.service?.description || '',
        price: props.service?.price || null,
        duration: props.service?.duration || null,
        photo: null,
        _method: 'patch',
    }
    errors.value = {}
    photoPreview.value = null
    if (fileInput.value) {
        fileInput.value.value = '';
    }

    emit('close')
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

@keyframes dragPulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.02); }
}

.border-blue-500.bg-blue-50 {
    animation: dragPulse 1s ease-in-out infinite;
}
</style>
