<template>
    <Layout>
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
                <!-- Search Section -->
                <div class="flex-1 max-w-md">
                    <div class="relative group">
                        <Search class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-blue-500 w-5 h-5 transition-colors duration-200" />
                        <input
                            v-model="searchQuery"
                            type="text"
                            placeholder="Search customers..."
                            class="w-full pl-12 pr-4 py-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 transition-all duration-200 shadow-sm hover:shadow-md"
                        />
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center gap-3">
                    <!-- Per Page Selector -->
                    <div class="relative">
                        <select
                            v-model="perPage"
                            class="appearance-none bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 pr-10 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 shadow-sm hover:shadow-md cursor-pointer"
                        >
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        <ChevronDown class="absolute right-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" />
                    </div>

                    <!-- Clear Filters Button -->
                    <Transition
                        enter-active-class="transition-all duration-200 ease-out"
                        enter-from-class="opacity-0 scale-95"
                        enter-to-class="opacity-100 scale-100"
                        leave-active-class="transition-all duration-150 ease-in"
                        leave-from-class="opacity-100 scale-100"
                        leave-to-class="opacity-0 scale-95"
                    >
                        <button
                            v-if="searchQuery"
                            @click="clearFilters"
                            class="px-4 py-3 text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200 shadow-sm hover:shadow-md"
                            title="Clear all filters"
                        >
                            <X class="w-4 h-4" />
                        </button>
                    </Transition>

                    <!-- Add New Customer Button -->
                    <button
                        @click="openCreateModal"
                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5 whitespace-nowrap group"
                    >
                        <Plus class="w-5 h-5 mr-2 group-hover:rotate-90 transition-transform duration-200" />
                        Add Customer
                    </button>
                </div>
            </div>

            <!-- Active Filters Display -->
            <div v-if="searchQuery" class="mt-4 flex items-center gap-2">
                <span class="text-sm text-gray-600 dark:text-gray-400">Active filters:</span>
                <div class="flex gap-2">
                    <span v-if="searchQuery" class="inline-flex items-center px-3 py-1 bg-blue-100 dark:bg-blue-900/50 text-blue-800 dark:text-blue-300 text-sm rounded-full">
                        Search: "{{ searchQuery }}"
                        <button @click="searchQuery = ''" class="ml-2 hover:text-blue-600">
                            <X class="w-3 h-3" />
                        </button>
                    </span>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-1 gap-6 mb-8">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 hover:shadow-lg transition-all duration-200 hover:-translate-y-1">
                <div class="flex items-center">
                    <div class="p-3 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg">
                        <Users class="w-6 h-6 text-white" />
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Customers</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ customers.length }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customers Table -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Customers</h3>
                    <span class="px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 text-xs font-medium rounded-full">
                        {{ filteredCustomers.length }}
                    </span>
                </div>
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    Showing {{ paginatedCustomers.length }} of {{ filteredCustomers.length }} results
                </div>
            </div>

            <div v-if="filteredCustomers.length === 0" class="p-12 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full mb-4">
                    <Users class="w-8 h-8 text-gray-400" />
                </div>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">
                    {{ searchQuery ? 'No customers found' : 'No customers yet' }}
                </h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6 max-w-sm mx-auto">
                    {{ searchQuery ? 'Try adjusting your search criteria.' : 'Start by creating your first customer profile.' }}
                </p>
                <button
                    v-if="!searchQuery"
                    @click="openCreateModal"
                    class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5"
                >
                    <Plus class="w-5 h-5 mr-2" />
                    Create First Customer
                </button>
            </div>

            <div v-else class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900/50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">#</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Customer Info</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Phone</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    <tr
                        v-for="(customer, index) in paginatedCustomers"
                        :key="customer.id"
                        class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200"
                    >
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                            {{ (currentPage - 1) * parseInt(perPage) + index + 1 }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center">
                                        <User class="h-5 w-5 text-white" />
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ customer.name }}</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ customer.email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                            {{ customer.phone || 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-2">
                                <button
                                    @click="viewCustomer(customer)"
                                    class="p-2 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 bg-blue-50 dark:bg-blue-900/30 hover:bg-blue-100 dark:hover:bg-blue-900/50 rounded-lg transition-all duration-200 hover:scale-105 transform"
                                    title="View Details"
                                >
                                    <Eye class="w-4 h-4" />
                                </button>
                                <button
                                    @click="editCustomer(customer)"
                                    class="p-2 text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300 bg-green-50 dark:bg-green-900/30 hover:bg-green-100 dark:hover:bg-green-900/50 rounded-lg transition-all duration-200 hover:scale-105 transform"
                                    title="Edit Customer"
                                >
                                    <Pencil class="w-4 h-4" />
                                </button>
                                <button
                                    @click="confirmDelete(customer)"
                                    class="p-2 text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 bg-red-50 dark:bg-red-900/30 hover:bg-red-100 dark:hover:bg-red-900/50 rounded-lg transition-all duration-200 hover:scale-105 transform"
                                    title="Delete Customer"
                                >
                                    <Trash class="w-4 h-4" />
                                </button>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div v-if="totalPages > 1" class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/30">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="text-sm text-gray-700 dark:text-gray-300">
                        Showing <span class="font-medium">{{ (currentPage - 1) * parseInt(perPage) + 1 }}</span> to
                        <span class="font-medium">{{ Math.min(currentPage * parseInt(perPage), filteredCustomers.length) }}</span> of
                        <span class="font-medium">{{ filteredCustomers.length }}</span> results
                    </div>
                    <div class="flex items-center gap-2">
                        <button
                            @click="goToPage(currentPage - 1)"
                            :disabled="currentPage === 1"
                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-gray-700 dark:hover:text-gray-300 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200"
                        >
                            <ChevronLeft class="w-4 h-4 mr-1" />
                            Previous
                        </button>

                        <div class="flex gap-1">
                            <button
                                v-for="page in visiblePages"
                                :key="page"
                                @click="goToPage(page)"
                                :disabled="page === '...'"
                                :class="[
                                  'px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200',
                                  page === currentPage
                                    ? 'bg-blue-600 text-white shadow-lg'
                                    : page === '...'
                                    ? 'text-gray-400 cursor-default'
                                    : 'text-gray-500 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-gray-700 dark:hover:text-gray-300'
                                ]"
                            >
                                {{ page }}
                            </button>
                        </div>

                        <button
                            @click="goToPage(currentPage + 1)"
                            :disabled="currentPage === totalPages"
                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-gray-700 dark:hover:text-gray-300 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200"
                        >
                            Next
                            <ChevronRight class="w-4 h-4 ml-1" />
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Create Customer Modal -->
        <CustomerCreateModal
            :is-open="showCreateModal"
            @close="closeCreateModal"
            @created="handleCustomerCreated"
        />

        <!-- Edit Customer Modal -->
        <CustomerEditModal
            :is-open="showEditModal"
            :customer="selectedCustomerForEdit"
            @close="closeEditModal"
            @updated="handleCustomerUpdated"
        />

        <!-- Detail Customer Modal -->
        <CustomerDetailModal
            :is-open="showDetailModal"
            :customer="selectedCustomerForDetail"
            @close="closeDetailModal"
            @edit="handleEditFromDetail"
        />
    </Layout>
</template>

<script setup>
import { ref, computed, watch } from 'vue'
import Layout from '@/layouts/AdminLayout.vue'
import CustomerCreateModal from '@/components/customer/CustomerCreateModal.vue'
import CustomerEditModal from '@/components/customer/CustomerEditModal.vue'
import CustomerDetailModal from '@/components/customer/CustomerDetailModal.vue'
import { router } from '@inertiajs/vue3'
import {
    Plus, Search, User, Users, Eye, Pencil, Trash, X,
    ChevronLeft, ChevronRight, ChevronDown
} from 'lucide-vue-next'
import Swal from 'sweetalert2'

const props = defineProps({
    customers: {
        type: Array,
        default: () => []
    }
})

const searchQuery = ref('')
const showCreateModal = ref(false)
const showEditModal = ref(false)
const selectedCustomerForEdit = ref(null)
const showDetailModal = ref(false)
const selectedCustomerForDetail = ref(null)
const currentPage = ref(1)
const perPage = ref('10')

const filteredCustomers = computed(() => {
    let filtered = props.customers

    if (searchQuery.value) {
        filtered = filtered.filter(customer =>
            customer.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
            customer.email.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
            (customer.phone && customer.phone.toLowerCase().includes(searchQuery.value.toLowerCase()))
        )
    }

    return filtered
})

const totalPages = computed(() => {
    return Math.ceil(filteredCustomers.value.length / parseInt(perPage.value))
})

const paginatedCustomers = computed(() => {
    const start = (currentPage.value - 1) * parseInt(perPage.value)
    const end = start + parseInt(perPage.value)
    return filteredCustomers.value.slice(start, end)
})

const visiblePages = computed(() => {
    const pages = []
    const total = totalPages.value
    const current = currentPage.value

    if (total <= 7) {
        for (let i = 1; i <= total; i++) {
            pages.push(i)
        }
    } else {
        if (current <= 4) {
            for (let i = 1; i <= 5; i++) {
                pages.push(i)
            }
            pages.push('...')
            pages.push(total)
        } else if (current >= total - 3) {
            pages.push(1)
            pages.push('...')
            for (let i = total - 4; i <= total; i++) {
                pages.push(i)
            }
        } else {
            pages.push(1)
            pages.push('...')
            for (let i = current - 1; i <= current + 1; i++) {
                pages.push(i)
            }
            pages.push('...')
            pages.push(total)
        }
    }

    return pages
})

const clearFilters = () => {
    searchQuery.value = ''
    currentPage.value = 1
}

const goToPage = (page) => {
    if (typeof page === 'number' && page >= 1 && page <= totalPages.value) {
        currentPage.value = page
    }
}

const openCreateModal = () => {
    showCreateModal.value = true
}

const closeCreateModal = () => {
    showCreateModal.value = false
}

const handleCustomerCreated = () => {
    router.reload({
        only: ['customers'],
        onSuccess: () => {
            closeCreateModal()
            Swal.fire({
                icon: 'success',
                title: 'Customer Created!',
                text: 'The new customer has been successfully added.',
                confirmButtonColor: '#3B82F6',
                timer: 2000,
                timerProgressBar: true
            });
        },
        onError: (errors) => {
            console.error('Error reloading data after customer creation:', errors);
        }
    })
}

const viewCustomer = (customer) => {
    selectedCustomerForDetail.value = customer
    showDetailModal.value = true
}

const closeDetailModal = () => {
    showDetailModal.value = false
    selectedCustomerForDetail.value = null
}

const handleEditFromDetail = (customer) => {
    closeDetailModal()
    selectedCustomerForEdit.value = customer
    showEditModal.value = true
}

const editCustomer = (customer) => {
    selectedCustomerForEdit.value = customer
    showEditModal.value = true
}

const closeEditModal = () => {
    showEditModal.value = false
    selectedCustomerForEdit.value = null
}

const handleCustomerUpdated = () => {
    router.reload({
        only: ['customers'],
        onSuccess: () => {
            closeEditModal()
            Swal.fire({
                icon: 'success',
                title: 'Customer Updated!',
                text: 'Customer information has been successfully updated.',
                confirmButtonColor: '#3B82F6',
                timer: 2000,
                timerProgressBar: true
            });
        },
        onError: (errors) => {
            console.error('Error reloading data after customer update:', errors);
        }
    })
}

const confirmDelete = async (customer) => {
    const result = await Swal.fire({
        title: 'Delete Customer?',
        text: `Are you sure you want to delete "${customer.name}"? This action cannot be undone.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#EF4444',
        cancelButtonColor: '#6B7280',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel',
        reverseButtons: true
    })

    if (result.isConfirmed) {
        router.delete(`/admin/customers/${customer.id}`, {
            onSuccess: (page) => {
                if (page.props.flash?.error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: page.props.flash.error,
                        confirmButtonColor: '#3B82F6'
                    })
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: page.props.flash.success || 'Customer deleted successfully.',
                        confirmButtonColor: '#3B82F6',
                        timer: 2000,
                        timerProgressBar: true
                    })
                }
            },
            onError: () => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while deleting the customer.',
                    confirmButtonColor: '#3B82F6'
                })
            }
        })
    }
}
watch([searchQuery, perPage], () => {
    currentPage.value = 1
})
</script>

<style scoped>
.overflow-x-auto::-webkit-scrollbar {
    height: 8px;
}

.overflow-x-auto::-webkit-scrollbar-track {
    background: #f1f5f9;
}

.overflow-x-auto::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 4px;
}

.overflow-x-auto::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

.dark .overflow-x-auto::-webkit-scrollbar-track {
    background: #374151;
}

.dark .overflow-x-auto::-webkit-scrollbar-thumb {
    background: #6b7280;
}

.dark .overflow-x-auto::-webkit-scrollbar-thumb:hover {
    background: #9ca3af;
}

select {
    background-image: none;
}

.group:focus-within .group-focus-within\:text-blue-500 {
    color: #3b82f6;
}
</style>
