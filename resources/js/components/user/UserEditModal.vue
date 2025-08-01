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
                                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Edit User</h2>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Update user information and settings</p>
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
                                <label for="edit-user-name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    User Name *
                                </label>
                                <div class="relative">
                                    <input
                                        id="edit-user-name"
                                        v-model="form.name"
                                        type="text"
                                        required
                                        placeholder="Enter full user name"
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 transition-colors duration-200"
                                        :class="{ 'border-red-500 focus:ring-red-500': errors.name }"
                                    />
                                    <User class="absolute right-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" />
                                </div>
                                <p v-if="errors.name" class="mt-1 text-sm text-red-600 dark:text-red-400">{{ errors.name }}</p>
                            </div>

                            <div>
                                <label for="edit-user-email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Email *
                                </label>
                                <div class="relative">
                                    <input
                                        id="edit-user-email"
                                        v-model="form.email"
                                        type="email"
                                        required
                                        placeholder="Enter user email address"
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 transition-colors duration-200"
                                        :class="{ 'border-red-500 focus:ring-red-500': errors.email }"
                                    />
                                    <Mail class="absolute right-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" />
                                </div>
                                <p v-if="errors.email" class="mt-1 text-sm text-red-600 dark:text-red-400">{{ errors.email }}</p>
                            </div>

                            <div>
                                <label for="edit-status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Status *
                                </label>
                                <div class="relative">
                                    <select
                                        id="edit-status"
                                        v-model="form.status"
                                        required
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-colors duration-200"
                                        :class="{ 'border-red-500 focus:ring-red-500': errors.status }"
                                    >
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                    <div class="absolute right-3 top-1/2 transform -translate-y-1/2">
                                        <div :class="[
                                            'w-3 h-3 rounded-full',
                                            form.status === 'active' ? 'bg-green-500' : 'bg-red-500'
                                          ]"></div>
                                    </div>
                                </div>
                                <p v-if="errors.status" class="mt-1 text-sm text-red-600 dark:text-red-400">{{ errors.status }}</p>
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
                                    <span>{{ isSubmitting ? 'Updating...' : 'Update User' }}</span>
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
import { User, Mail, Pencil, Save, X, Loader2 } from 'lucide-vue-next'
import Swal from 'sweetalert2'

const props = defineProps({
    isOpen: {
        type: Boolean,
        default: false
    },
    user: {
        type: Object,
        default: null
    }
})

const emit = defineEmits(['close', 'updated'])

const form = ref({
    name: '',
    email: '',
    status: 'active'
})

const errors = ref({})
const isSubmitting = ref(false)

watch(() => props.user, (newUser) => {
    if (newUser) {
        form.value = {
            name: newUser.name || '',
            email: newUser.email || '',
            status: newUser.status || 'active'
        }
        errors.value = {}
    }
}, { immediate: true })

watch(() => props.isOpen, (newValue) => {
    if (newValue) {
        document.body.style.overflow = 'hidden'
    } else {
        document.body.style.overflow = 'auto'
    }
})

const submitForm = async () => {
    if (isSubmitting.value || !props.user) return

    errors.value = {}

    if (!form.value.name.trim()) {
        errors.value.name = 'User name is required.'
        return
    }

    if (!form.value.email.trim()) {
        errors.value.email = 'Email is required.'
        return
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(form.value.email)) {
        errors.value.email = 'Invalid email format.'
        return
    }

    if (!form.value.status) {
        errors.value.status = 'Status is required.'
        return
    }

    isSubmitting.value = true

    try {
        router.patch(`/admin/users/${props.user.id}`, form.value, {
            onSuccess: () => {
                emit('updated')
                closeModal()
            },
            onError: (serverErrors) => {
                errors.value = serverErrors

                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: 'Please check the form and try again.',
                    confirmButtonColor: '#3B82F6'
                })
            },
            onFinish: () => {
                isSubmitting.value = false
            }
        })
    } catch (error) {
        console.error('Error updating user:', error)

        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'An error occurred. Please try again.',
            confirmButtonColor: '#3B82F6'
        })

        isSubmitting.value = false
    }
}

const closeModal = () => {
    if (isSubmitting.value) return

    form.value = {
        name: '',
        email: '',
        status: 'active'
    }
    errors.value = {}

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
</style>
