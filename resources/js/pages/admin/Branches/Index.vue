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
                            placeholder="Search branches..."
                            class="w-full pl-12 pr-4 py-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 transition-all duration-200 shadow-sm hover:shadow-md"
                        />
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center gap-3">
                    <!-- Filter Dropdown -->
                    <div class="relative">
                        <select
                            v-model="statusFilter"
                            class="appearance-none bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 pr-10 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 shadow-sm hover:shadow-md cursor-pointer"
                        >
                            <option value="">All Status</option>
                            <option value="active">Active Only</option>
                            <option value="inactive">Inactive Only</option>
                        </select>
                        <ChevronDown class="absolute right-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" />
                    </div>

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
                            v-if="searchQuery || statusFilter"
                            @click="clearFilters"
                            class="px-4 py-3 text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200 shadow-sm hover:shadow-md"
                            title="Clear all filters"
                        >
                            <X class="w-4 h-4" />
                        </button>
                    </Transition>

                    <!-- Add New Branch Button - Enhanced -->
                    <button
                        @click="openCreateModal"
                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5 whitespace-nowrap group"
                    >
                        <Plus class="w-5 h-5 mr-2 group-hover:rotate-90 transition-transform duration-200" />
                        Add Branch
                    </button>
                </div>
            </div>

            <!-- Active Filters Display -->
            <div v-if="searchQuery || statusFilter" class="mt-4 flex items-center gap-2">
                <span class="text-sm text-gray-600 dark:text-gray-400">Active filters:</span>
                <div class="flex gap-2">
          <span v-if="searchQuery" class="inline-flex items-center px-3 py-1 bg-blue-100 dark:bg-blue-900/50 text-blue-800 dark:text-blue-300 text-sm rounded-full">
            Search: "{{ searchQuery }}"
            <button @click="searchQuery = ''" class="ml-2 hover:text-blue-600">
              <X class="w-3 h-3" />
            </button>
          </span>
                    <span v-if="statusFilter" class="inline-flex items-center px-3 py-1 bg-green-100 dark:bg-green-900/50 text-green-800 dark:text-green-300 text-sm rounded-full">
            Status: {{ statusFilter }}
            <button @click="statusFilter = ''" class="ml-2 hover:text-green-600">
              <X class="w-3 h-3" />
            </button>
          </span>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 hover:shadow-lg transition-all duration-200 hover:-translate-y-1">
                <div class="flex items-center">
                    <div class="p-3 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg">
                        <Building class="w-6 h-6 text-white" />
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Branches</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ branches.length }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 hover:shadow-lg transition-all duration-200 hover:-translate-y-1">
                <div class="flex items-center">
                    <div class="p-3 bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg">
                        <CircleCheck class="w-6 h-6 text-white" />
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Active Branches</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ activeBranchesCount }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 hover:shadow-lg transition-all duration-200 hover:-translate-y-1">
                <div class="flex items-center">
                    <div class="p-3 bg-gradient-to-br from-red-500 to-red-600 rounded-xl shadow-lg">
                        <XCircle class="w-6 h-6 text-white" />
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Inactive Branches</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ inactiveBranchesCount }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 hover:shadow-lg transition-all duration-200 hover:-translate-y-1">
                <div class="flex items-center">
                    <div class="p-3 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg">
                        <MapPin class="w-6 h-6 text-white" />
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Cities</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ uniqueCities }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Branches Table -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Branches</h3>
                    <span class="px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 text-xs font-medium rounded-full">
            {{ filteredBranches.length }}
          </span>
                </div>
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    Showing {{ paginatedBranches.length }} of {{ filteredBranches.length }} results
                </div>
            </div>

            <div v-if="filteredBranches.length === 0" class="p-12 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full mb-4">
                    <Building class="w-8 h-8 text-gray-400" />
                </div>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">
                    {{ searchQuery || statusFilter ? 'No branches found' : 'No branches yet' }}
                </h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6 max-w-sm mx-auto">
                    {{ searchQuery || statusFilter ? 'Try adjusting your search criteria or filters.' : 'Get started by creating your first branch location.' }}
                </p>
                <button
                    v-if="!searchQuery && !statusFilter"
                    @click="openCreateModal"
                    class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5"
                >
                    <Plus class="w-5 h-5 mr-2" />
                    Create First Branch
                </button>
            </div>

            <div v-else class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900/50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">#</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Branch Info</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Address</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Photo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    <tr
                        v-for="(branch, index) in paginatedBranches"
                        :key="branch.id"
                        class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200"
                    >
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                            {{ (currentPage - 1) * parseInt(perPage) + index + 1 }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center">
                                        <Building class="h-5 w-5 text-white" />
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ branch.name }}</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">Branch ID: {{ branch.id }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900 dark:text-white">
                                <div class="flex items-start">
                                    <MapPin class="w-4 h-4 text-gray-400 mt-0.5 mr-2 flex-shrink-0" />
                                    <span class="break-words">{{ branch.address }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <button
                                @click="toggleStatus(branch)"
                                :class="[
                                    'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium transition-colors duration-200',
                                    branch.status === 'active'
                                      ? 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300 hover:bg-green-200 dark:hover:bg-green-900/70'
                                      : 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300 hover:bg-red-200 dark:hover:bg-red-900/70'
                                  ]"
                            >
                                <div :class="[
                                    'w-1.5 h-1.5 rounded-full mr-1.5',
                                    branch.status === 'active' ? 'bg-green-500' : 'bg-red-500'
                                  ]"></div>
                                {{ branch.status === 'active' ? 'Active' : 'Inactive' }}
                            </button>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div v-if="branch.photo" class="flex items-center">
                                <img
                                    :src="`/storage/${branch.photo}`"
                                    :alt="branch.name"
                                    class="h-12 w-12 rounded-lg object-cover border border-gray-200 dark:border-gray-600 hover:scale-105 transition-transform duration-200 cursor-pointer"
                                    @click="showImageModal(branch)"
                                />
                                <button
                                    @click="showImageModal(branch)"
                                    class="ml-2 p-1.5 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 bg-blue-50 dark:bg-blue-900/30 hover:bg-blue-100 dark:hover:bg-blue-900/50 rounded-lg transition-all duration-200"
                                >
                                    <Eye class="w-4 h-4" />
                                </button>
                            </div>
                            <div v-else class="flex items-center text-gray-500 dark:text-gray-400">
                                <div class="p-2 bg-gray-100 dark:bg-gray-700 rounded-lg">
                                    <Image class="w-5 h-5" />
                                </div>
                                <span class="text-sm ml-2">No Image</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-2">
                                <button
                                    @click="viewBranch(branch)"
                                    class="p-2 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 bg-blue-50 dark:bg-blue-900/30 hover:bg-blue-100 dark:hover:bg-blue-900/50 rounded-lg transition-all duration-200 hover:scale-105 transform"
                                    title="View Details"
                                >
                                    <Eye class="w-4 h-4" />
                                </button>
                                <button
                                    @click="editBranch(branch)"
                                    class="p-2 text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300 bg-green-50 dark:bg-green-900/30 hover:bg-green-100 dark:hover:bg-green-900/50 rounded-lg transition-all duration-200 hover:scale-105 transform"
                                    title="Edit Branch"
                                >
                                    <Pencil class="w-4 h-4" />
                                </button>
                                <button
                                    @click="confirmDelete(branch)"
                                    class="p-2 text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 bg-red-50 dark:bg-red-900/30 hover:bg-red-100 dark:hover:bg-red-900/50 rounded-lg transition-all duration-200 hover:scale-105 transform"
                                    title="Delete Branch"
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
                        <span class="font-medium">{{ Math.min(currentPage * parseInt(perPage), filteredBranches.length) }}</span> of
                        <span class="font-medium">{{ filteredBranches.length }}</span> results
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

        <!-- Image Modal -->
        <Transition
            enter-active-class="transition-opacity duration-300 ease-out"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition-opacity duration-200 ease-in"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div
                v-if="showModal"
                class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 p-4"
                @click="closeModal"
            >
                <Transition
                    enter-active-class="transition-all duration-300 ease-out"
                    enter-from-class="opacity-0 scale-90"
                    enter-to-class="opacity-100 scale-100"
                    leave-active-class="transition-all duration-200 ease-in"
                    leave-from-class="opacity-100 scale-100"
                    leave-to-class="opacity-0 scale-90"
                >
                    <div v-if="showModal" class="relative max-w-4xl max-h-full">
                        <img
                            :src="`/storage/${selectedBranch.photo}`"
                            :alt="selectedBranch.name"
                            class="max-w-full max-h-full object-contain rounded-lg"
                        />
                        <button
                            @click="closeModal"
                            class="absolute top-4 right-4 text-white hover:text-gray-300 bg-black bg-opacity-50 rounded-full p-2 transition-colors duration-200"
                        >
                            <X class="w-6 h-6" />
                        </button>
                        <div class="absolute bottom-4 left-4 bg-black bg-opacity-75 text-white p-3 rounded-lg">
                            <h3 class="font-medium">{{ selectedBranch.name }}</h3>
                            <p class="text-sm text-gray-300">{{ selectedBranch.address }}</p>
                        </div>
                    </div>
                </Transition>
            </div>
        </Transition>

        <!-- Create Branch Modal -->
        <BranchCreateModal
            :is-open="showCreateModal"
            @close="closeCreateModal"
            @created="handleBranchCreated"
        />

        <!-- Edit Branch Modal -->
        <BranchEditModal
            :is-open="showEditModal"
            :branch="selectedBranchForEdit"
            @close="closeEditModal"
            @updated="handleBranchUpdated"
        />

        <!-- Detail Branch Modal -->
        <BranchDetailModal
            :is-open="showDetailModal"
            :branch="selectedBranchForDetail"
            @close="closeDetailModal"
            @edit="handleEditFromDetail"
        />
    </Layout>
</template>

<script setup>
import { ref, computed, watch } from 'vue'
import Layout from '@/layouts/AdminLayout.vue'
import BranchCreateModal from '@/components/branch/BranchCreateModal.vue'
import BranchEditModal from '@/components/branch/BranchEditModal.vue'
import BranchDetailModal from '@/components/branch/BranchDetailModal.vue'
import { router } from '@inertiajs/vue3'
import {
    Plus, Search, Building, CircleCheck, MapPin, Eye, Pencil, Trash, Image, X, XCircle,
    ChevronLeft, ChevronRight, ChevronDown
} from 'lucide-vue-next'
import Swal from 'sweetalert2'

const props = defineProps({
    branches: {
        type: Array,
        default: () => []
    }
})

const searchQuery = ref('')
const statusFilter = ref('')
const showModal = ref(false)
const selectedBranch = ref(null)
const showCreateModal = ref(false)
const showEditModal = ref(false)
const selectedBranchForEdit = ref(null)
const showDetailModal = ref(false)
const selectedBranchForDetail = ref(null)
const currentPage = ref(1)
const perPage = ref('10')

const filteredBranches = computed(() => {
    let filtered = props.branches

    if (searchQuery.value) {
        filtered = filtered.filter(branch =>
            branch.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
            branch.address.toLowerCase().includes(searchQuery.value.toLowerCase())
        )
    }

    if (statusFilter.value) {
        filtered = filtered.filter(branch => branch.status === statusFilter.value)
    }

    return filtered
})

const totalPages = computed(() => {
    return Math.ceil(filteredBranches.value.length / parseInt(perPage.value))
})

const paginatedBranches = computed(() => {
    const start = (currentPage.value - 1) * parseInt(perPage.value)
    const end = start + parseInt(perPage.value)
    return filteredBranches.value.slice(start, end)
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

const activeBranchesCount = computed(() => {
    return props.branches.filter(branch => branch.status === 'active').length
})

const inactiveBranchesCount = computed(() => {
    return props.branches.filter(branch => branch.status === 'inactive').length
})

const uniqueCities = computed(() => {
    const normalized = new Set();
    props.branches.forEach(branch => {
        const address = branch.address?.toLowerCase() ?? '';
        const cityMap = {
            'tangerang': ['kabupaten tangerang', 'kota tangerang', 'tangerang selatan', 'tangerang'],
            'jakarta': ['jakarta barat', 'jakarta timur', 'jakarta pusat', 'jakarta selatan', 'jakarta utara', 'jakarta'],
            'bandung': ['kota bandung', 'kabupaten bandung', 'kab. bandung', 'bandung barat', 'kabupaten bandung barat', 'bandung'],
            'bekasi': ['kota bekasi', 'kabupaten bekasi', 'kab. bekasi', 'bekasi'],
            'depok': ['kota depok', 'depok'],
            'cimahi': ['kota cimahi', 'cimahi'],
            'semarang': ['kota semarang', 'kabupaten semarang', 'kab. semarang', 'semarang'],
            'surabaya': ['kota surabaya', 'surabaya'],
            'sidoarjo': ['kabupaten sidoarjo', 'kab. sidoarjo', 'sidoarjo'],
            'gresik': ['kabupaten gresik', 'kab. gresik', 'gresik'],
            'malang': ['kota malang', 'kabupaten malang', 'kab. malang', 'malang'],
            'solo': ['kota surakarta', 'surakarta', 'solo'],
            'yogyakarta': ['kota yogyakarta', 'kabupaten sleman', 'kabupaten bantul', 'kab. sleman', 'kab. bantul', 'yogyakarta'],
            'medan': ['kota medan', 'medan'],
            'palembang': ['kota palembang', 'palembang'],
            'makassar': ['kota makassar', 'makassar'],
            'manado': ['kota manado', 'manado'],
            'denpasar': ['kota denpasar', 'denpasar'],
            'pontianak': ['kota pontianak', 'pontianak'],
            'balikpapan': ['kota balikpapan', 'balikpapan'],
            'banjarmasin': ['kota banjarmasin', 'banjarmasin'],
            'pekanbaru': ['kota pekanbaru', 'pekanbaru'],
            'padang': ['kota padang', 'padang'],
            'batam': ['kota batam', 'batam'],
            'bogor': ['kota bogor', 'kabupaten bogor', 'bogor'],
            'cilegon': ['kota cilegon', 'cilegon'],
            'serang': ['kota serang', 'kabupaten serang', 'serang'],
            'karawang': ['kabupaten karawang', 'karawang'],
            'cikarang': ['cikarang'],
            'tasikmalaya': ['kota tasikmalaya', 'kabupaten tasikmalaya', 'tasikmalaya'],
            'purwokerto': ['purwokerto'],
            'tegal': ['kota tegal', 'kabupaten tegal', 'tegal'],
            'cirebon': ['kota cirebon', 'kabupaten cirebon', 'cirebon']
        };

        let found = false;
        for (const [normalizedName, variants] of Object.entries(cityMap)) {
            if (variants.some(keyword => address.includes(keyword))) {
                normalized.add(normalizedName.charAt(0).toUpperCase() + normalizedName.slice(1));
                found = true;
                break;
            }
        }

        if (!found) {
            const parts = address.split(',').map(p => p.trim());
            if (parts.length >= 2) {
                let fallbackCity = parts[parts.length - 2]
                    .replace(/^(kota|kabupaten)\s+/i, '')
                    .trim()
                    .toLowerCase();
                fallbackCity = fallbackCity.charAt(0).toUpperCase() + fallbackCity.slice(1);
                normalized.add(fallbackCity);
            }
        }
    });
    return normalized.size;
});

const clearFilters = () => {
    searchQuery.value = ''
    statusFilter.value = ''
    currentPage.value = 1
}

const goToPage = (page) => {
    if (typeof page === 'number' && page >= 1 && page <= totalPages.value) {
        currentPage.value = page
    }
}

const showImageModal = (branch) => {
    selectedBranch.value = branch
    showModal.value = true
}

const closeModal = () => {
    showModal.value = false
    selectedBranch.value = null
}

const openCreateModal = () => {
    showCreateModal.value = true
}

const closeCreateModal = () => {
    showCreateModal.value = false
}

const handleBranchCreated = () => {
    router.reload({
        only: ['branches'],
        onSuccess: () => {
            closeCreateModal()
            Swal.fire({
                icon: 'success',
                title: 'Branch Created!',
                text: 'New branch has been added successfully.',
                confirmButtonColor: '#3B82F6',
                timer: 2000,
                timerProgressBar: true
            });
        },
        onError: (errors) => {
            console.error('Error reloading data after branch creation:', errors);
        }
    })
}

const viewBranch = (branch) => {
    selectedBranchForDetail.value = branch
    showDetailModal.value = true
}

const closeDetailModal = () => {
    showDetailModal.value = false
    selectedBranchForDetail.value = null
}

const handleEditFromDetail = (branch) => {
    closeDetailModal()
    selectedBranchForEdit.value = branch
    showEditModal.value = true
}

const editBranch = (branch) => {
    selectedBranchForEdit.value = branch
    showEditModal.value = true
}

const closeEditModal = () => {
    showEditModal.value = false
    selectedBranchForEdit.value = null
}

const handleBranchUpdated = () => {
    router.reload({
        only: ['branches'],
        onSuccess: () => {
            closeEditModal()
            Swal.fire({
                icon: 'success',
                title: 'Branch Updated!',
                text: 'Branch information has been updated successfully.',
                confirmButtonColor: '#3B82F6',
                timer: 2000,
                timerProgressBar: true
            });
        },
        onError: (errors) => {
            console.error('Error reloading data after branch update:', errors);
        }
    })
}

const toggleStatus = async (branch) => {
    const newStatus = branch.status === 'active' ? 'inactive' : 'active'
    const action = newStatus === 'active' ? 'activate' : 'deactivate'

    const result = await Swal.fire({
        title: `${action.charAt(0).toUpperCase() + action.slice(1)} Branch?`,
        text: `Are you sure you want to ${action} "${branch.name}"?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: newStatus === 'active' ? '#10B981' : '#EF4444',
        cancelButtonColor: '#6B7280',
        confirmButtonText: `Yes, ${action} it!`,
        cancelButtonText: 'Cancel'
    })

    if (result.isConfirmed) {
        router.patch(`/admin/branches/${branch.id}/status`, {
            status: newStatus
        }, {
            onSuccess: () => {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: `Branch has been ${action}d successfully.`,
                    confirmButtonColor: '#3B82F6',
                    timer: 2000,
                    timerProgressBar: true
                })
            },
            onError: () => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: `Something went wrong while ${action}ing the branch.`,
                    confirmButtonColor: '#3B82F6'
                })
            }
        })
    }
}

const confirmDelete = async (branch) => {
    const result = await Swal.fire({
        title: 'Delete Branch?',
        text: `Are you sure you want to delete "${branch.name}"? This action cannot be undone.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#EF4444',
        cancelButtonColor: '#6B7280',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel',
        reverseButtons: true
    })

    if (result.isConfirmed) {
        router.delete(`/admin/branches/${branch.id}`, {
            onSuccess: () => {
                Swal.fire({
                    icon: 'success',
                    title: 'Deleted!',
                    text: 'Branch has been deleted successfully.',
                    confirmButtonColor: '#3B82F6',
                    timer: 2000,
                    timerProgressBar: true
                })
            },
            onError: () => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Something went wrong while deleting the branch.',
                    confirmButtonColor: '#3B82F6'
                })
            }
        })
    }
}
watch([searchQuery, statusFilter, perPage], () => {
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
