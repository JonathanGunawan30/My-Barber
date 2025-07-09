<template>
    <div class="min-h-screen flex bg-gray-50 dark:bg-gray-900 transition-colors duration-200">

        <div
            :class="[
                'fixed inset-y-0 left-0 z-50 w-64 bg-white dark:bg-gray-800 shadow-lg transform transition-transform duration-300 ease-in-out',
                sidebarOpen ? 'translate-x-0' : '-translate-x-full',
                'lg:translate-x-0 lg:static lg:inset-0'
            ]"
        >
            <div class="flex items-center justify-between h-16 px-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                        <Book class="w-5 h-5 text-white" />
                    </div>
                    <span class="text-xl font-bold text-gray-900 dark:text-white">My Barber</span>
                </div>
                <button
                    @click="toggleSidebar"
                    class="lg:hidden p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700"
                >
                    <X class="w-6 h-6" />
                </button>
            </div>

            <nav class="mt-6 px-3">
                <div class="space-y-6">
                    <div>
                        <h3 class="px-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Main</h3>
                        <div class="mt-2 space-y-1">
                            <Link
                                href="/admin/dashboard"
                                :class="[
                                  'group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200',
                                  page.url.includes('/admin/dashboard')
                                    ? 'bg-blue-100 dark:bg-blue-700 text-blue-800 dark:text-blue-200 shadow-sm'
                                    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700'
                                ]"
                            >
                                <LayoutDashboard class="mr-3 w-5 h-5" />
                                Dashboard
                            </Link>
                        </div>
                    </div>

                    <div>
                        <h3 class="px-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Users & Customers</h3>
                        <div class="mt-2 space-y-1">
                            <Link
                                href="/admin/users"
                                :class="[
                                  'group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200',
                                  page.url.includes('/admin/users')
                                    ? 'bg-blue-100 dark:bg-blue-700 text-blue-800 dark:text-blue-200 shadow-sm'
                                    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700'
                                ]"
                            >
                                <Users class="mr-3 w-5 h-5" />
                                User Management
                            </Link>
                            <Link
                                href="/admin/customers"
                                :class="[
                                  'group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200',
                                  page.url.includes('/admin/customers')
                                    ? 'bg-blue-100 dark:bg-blue-700 text-blue-800 dark:text-blue-200 shadow-sm'
                                    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700'
                                ]"
                            >
                                <User class="mr-3 w-5 h-5" />
                                Customers
                            </Link>
                        </div>
                    </div>

                    <div>
                        <h3 class="px-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Business Management</h3>
                        <div class="mt-2 space-y-1">
                            <Link
                                href="/admin/services"
                                :class="[
                                  'group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200',
                                  page.url.includes('/admin/services')
                                    ? 'bg-blue-100 dark:bg-blue-700 text-blue-800 dark:text-blue-200 shadow-sm'
                                    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700'
                                ]"
                            >
                                <Scissors class="mr-3 w-5 h-5" />
                                Services
                            </Link>
                            <Link
                                href="/admin/branches"
                                :class="[
                                  'group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200',
                                  page.url.includes('/admin/branches')
                                    ? 'bg-blue-100 dark:bg-blue-700 text-blue-800 dark:text-blue-200 shadow-sm'
                                    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700'
                                ]"
                            >
                                <Home class="mr-3 w-5 h-5" />
                                Branches
                            </Link>
                            <Link
                                href="/admin/barbers"
                                :class="[
                                  'group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200',
                                  page.url.includes('/admin/barber')
                                    ? 'bg-blue-100 dark:bg-blue-700 text-blue-800 dark:text-blue-200 shadow-sm'
                                    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700'
                                ]"
                            >
                                <UserCog class="mr-3 w-5 h-5" />
                                Barbers
                            </Link>
                            <Link
                                href="/admin/hairstyles"
                                :class="[
                                  'group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200',
                                  page.url.includes('/admin/hairstyles')
                                    ? 'bg-blue-100 dark:bg-blue-700 text-blue-800 dark:text-blue-200 shadow-sm'
                                    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700'
                                ]"
                            >
                                <Palette class="mr-3 w-5 h-5" /> Hairstyles
                            </Link>
                        </div>
                    </div>

                    <div>
                        <h3 class="px-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Engagement & Bookings</h3>
                        <div class="mt-2 space-y-1">
                            <Link
                                href="/admin/testimonials"
                                :class="[
                                  'group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200',
                                  page.url.includes('/admin/testimonials')
                                    ? 'bg-blue-100 dark:bg-blue-700 text-blue-800 dark:text-blue-200 shadow-sm'
                                    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700'
                                ]"
                            >
                                <MessageSquare class="mr-3 w-5 h-5" />
                                Testimonials
                            </Link>
                            <Link
                                href="/admin/bookings"
                                :class="[
                                  'group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200',
                                  page.url.includes('/admin/bookings')
                                    ? 'bg-blue-100 dark:bg-blue-700 text-blue-800 dark:text-blue-200 shadow-sm'
                                    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700'
                                ]"
                            >
                                <CalendarDays class="mr-3 w-5 h-5" />
                                Bookings
                            </Link>
                        </div>
                    </div>
                </div>
            </nav>
        </div>

        <div class="flex-1 flex flex-col">
            <header class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between h-16 px-6">
                    <div class="flex items-center">
                        <button
                            @click="toggleSidebar"
                            class="lg:hidden p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700"
                        >
                            <Menu class="w-6 h-6" />
                        </button>
                        <h1 class="ml-4 text-2xl font-semibold text-gray-900 dark:text-white">{{ pageTitle }}</h1>
                    </div>

                    <div class="flex items-center space-x-4">
                        <button
                            @click="toggleDarkMode"
                            class="p-2 rounded-lg text-gray-500 hover:text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-gray-200 dark:hover:bg-gray-700 transition-colors duration-200"
                        >
                            <Moon v-if="!isDarkMode" class="w-5 h-5" />
                            <Sun v-else class="w-5 h-5" />
                        </button>

                        <button class="p-2 rounded-lg text-gray-500 hover:text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-gray-200 dark:hover:bg-gray-700 transition-colors duration-200 relative">
                            <BellRing class="w-5 h-5" />
                            <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                        </button>

                        <div class="relative">
                            <button
                                @click="showProfileDropdown = !showProfileDropdown"
                                class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200"
                            >
                                <img class="w-8 h-8 rounded-full" src="/placeholder.svg?height=32&width=32" alt="Profile">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Admin User</span>
                                <ChevronDown class="w-4 h-4 text-gray-400" />
                            </button>

                            <div
                                v-if="showProfileDropdown"
                                @click.stop
                                class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 z-50"
                            >
                                <div class="py-1">
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Profile</a>
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Settings</a>
                                    <hr class="border-gray-200 dark:border-gray-700">
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Sign out</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-grow p-6">
                <slot />
            </main>

            <footer class="bg-white dark:bg-gray-800 shadow-t border-t border-gray-200 dark:border-gray-700 z-30">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-12 flex items-center justify-center">
                    <p class="text-xs text-gray-600 dark:text-gray-400 flex items-center">
                        &copy; {{ currentYear }} My Barber App. Developed by
                        <a
                            href="https://www.instagram.com/jo.nthn30"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="text-blue-600 hover:text-blue-700 hover:underline hover:decoration-blue-600 dark:text-blue-400 dark:hover:text-blue-300 dark:hover:decoration-blue-400 font-medium transition-colors duration-200 ml-1"
                        >
                            Jonathan Gunawan
                        </a>

                        <span class="mx-1 text-gray-400 dark:text-gray-500">|</span>
                        <a
                            href="https://github.com/jonathangunawan30"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="text-blue-600 hover:text-blue-700 hover:underline hover:decoration-blue-600 dark:text-blue-400 dark:hover:text-blue-300 dark:hover:decoration-blue-400 font-medium transition-colors duration-200 flex items-center"
                        >
                            <Github :size="10" class="mr-1" />
                            GitHub
                        </a>
                    </p>
                </div>
            </footer>
        </div>

        <div
            v-if="sidebarOpen"
            @click="toggleSidebar"
            class="fixed inset-0 z-40 bg-gray-600 bg-opacity-75 lg:hidden"
        ></div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { usePage, Link } from '@inertiajs/vue3'
import {
    LayoutDashboard, Users, User, Scissors, Home, UserCog, MessageSquare, CalendarDays, Palette,
    Moon, Sun, BellRing, ChevronDown, Menu, X, Book, Github
} from 'lucide-vue-next'

const page = usePage()
const sidebarOpen = ref(false)
const showProfileDropdown = ref(false)
const isDarkMode = ref(false)

const currentYear = computed(() => new Date().getFullYear());

const pageTitle = computed(() => {
    const path = page.url
    if (path.includes('/admin/dashboard')) return 'Dashboard'
    if (path.includes('/admin/branches')) return 'Branches'
    if (path.includes('/admin/users')) return 'User Management'
    if (path.includes('/admin/customers')) return 'Customers'
    if (path.includes('/admin/services')) return 'Services'
    if (path.includes('/admin/barber')) return 'Barbers'
    if (path.includes('/admin/hairstyles')) return 'Hairstyles'
    if (path.includes('/admin/testimonials')) return 'Testimonials'
    if (path.includes('/admin/bookings')) return 'Bookings'
    return 'Dashboard'
})

const toggleSidebar = () => {
    sidebarOpen.value = !sidebarOpen.value
}

const toggleDarkMode = () => {
    isDarkMode.value = !isDarkMode.value
    if (isDarkMode.value) {
        document.documentElement.classList.add('dark')
        localStorage.setItem('darkMode', 'true')
    } else {
        document.documentElement.classList.remove('dark')
        localStorage.setItem('darkMode', 'false')
    }
}

const handleClickOutside = (event) => {
    const profileDropdownButton = document.querySelector('.relative > button');
    if (showProfileDropdown.value && !event.target.closest('.relative') && !profileDropdownButton.contains(event.target)) {
        showProfileDropdown.value = false;
    }
}

onMounted(() => {
    const savedDarkMode = localStorage.getItem('darkMode')
    if (savedDarkMode === 'true') {
        isDarkMode.value = true
        document.documentElement.classList.add('dark')
    }
    document.addEventListener('click', handleClickOutside)
})

onUnmounted(() => {
    document.removeEventListener('click', handleClickOutside)
})
</script>

<style scoped>
nav::-webkit-scrollbar {
    width: 4px;
}

nav::-webkit-scrollbar-track {
    background: transparent;
}

nav::-webkit-scrollbar-thumb {
    background: rgba(156, 163, 175, 0.5);
    border-radius: 2px;
}

nav::-webkit-scrollbar-thumb:hover {
    background: rgba(156, 163, 175, 0.7);
}

</style>
