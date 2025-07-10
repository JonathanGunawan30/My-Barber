<template>
    <Layout>
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg">
                    <Settings class="w-8 h-8 text-white" />
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Account Settings</h1>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                        Manage your account information and security preferences
                    </p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Account Overview Card -->
            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <!-- Account Header -->
                    <div class="text-center mb-6">
                        <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                          <span class="text-2xl font-bold text-white">
                            {{ getInitials($page.props.auth.user.name) }}
                          </span>
                        </div>

                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">
                            {{ $page.props.auth.user.name }}
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                            {{ $page.props.auth.user.email }}
                        </p>

                        <!-- Status Badge -->
                        <span class="inline-flex items-center px-3 py-1 bg-green-100 dark:bg-green-900/50 text-green-800 dark:text-green-300 text-sm font-medium rounded-full">
                          <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                          Active Account
                        </span>
                    </div>

                    <!-- Account Info -->
                    <div class="space-y-4">
                        <div class="flex items-center justify-between py-3 border-b border-gray-200 dark:border-gray-700">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-blue-100 dark:bg-blue-900/50 rounded-lg">
                                    <Crown class="w-4 h-4 text-blue-600 dark:text-blue-400" />
                                </div>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Role</span>
                            </div>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">Administrator</span>
                        </div>

                        <div class="flex items-center justify-between py-3 border-b border-gray-200 dark:border-gray-700">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-green-100 dark:bg-green-900/50 rounded-lg">
                                    <Calendar class="w-4 h-4 text-green-600 dark:text-green-400" />
                                </div>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Member Since</span>
                            </div>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ formatDate($page.props.auth.user.created_at) }}
                              </span>
                        </div>

                        <div class="flex items-center justify-between py-3">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-purple-100 dark:bg-purple-900/50 rounded-lg">
                                    <Clock class="w-4 h-4 text-purple-600 dark:text-purple-400" />
                                </div>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Last Login</span>
                            </div>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ lastLoginTime }}
                              </span>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions Card -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mt-6">
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Quick Actions</h4>
                    <div class="space-y-3">
                        <button
                            @click="exportAccountData"
                            :disabled="exportLoading"
                            class="w-full flex items-center gap-3 p-3 text-left bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 rounded-lg transition-colors duration-200 disabled:opacity-50"
                        >
                            <div class="p-2 bg-blue-100 dark:bg-blue-900/50 rounded-lg">
                                <Download v-if="!exportLoading" class="w-4 h-4 text-blue-600 dark:text-blue-400" />
                                <Loader2 v-else class="w-4 h-4 text-blue-600 dark:text-blue-400 animate-spin" />
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ exportLoading ? 'Generating PDF...' : 'Export Account Data' }}
                                </p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">Download your account information as PDF</p>
                            </div>
                        </button>

                        <button
                            @click="showLoginHistory = !showLoginHistory"
                            class="w-full flex items-center gap-3 p-3 text-left bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 rounded-lg transition-colors duration-200"
                        >
                            <div class="p-2 bg-orange-100 dark:bg-orange-900/50 rounded-lg">
                                <History class="w-4 h-4 text-orange-600 dark:text-orange-400" />
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">Login History</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">
                                    {{ showLoginHistory ? 'Hide login history' : 'View recent logins' }}
                                </p>
                            </div>
                        </button>
                    </div>
                </div>

                <!-- Login History Card -->
                <div v-if="showLoginHistory" class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mt-6">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Login History</h4>
                        <button
                            @click="clearLoginHistory"
                            class="p-2 text-gray-400 hover:text-red-600 dark:hover:text-red-400 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200"
                            title="Clear History"
                        >
                            <Trash2 class="w-4 h-4" />
                        </button>
                    </div>

                    <div class="space-y-3 max-h-64 overflow-y-auto">
                        <div v-for="(login, index) in loginHistory" :key="index" class="flex items-start gap-3 p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="p-2 bg-green-100 dark:bg-green-900/50 rounded-lg flex-shrink-0">
                                <LogIn class="w-4 h-4 text-green-600 dark:text-green-400" />
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">Login Successful</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">{{ login.userAgent }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">{{ formatDateTime(login.timestamp) }}</p>
                            </div>
                        </div>

                        <div v-if="loginHistory.length === 0" class="text-center py-8">
                            <History class="w-12 h-12 text-gray-400 mx-auto mb-3" />
                            <p class="text-sm text-gray-600 dark:text-gray-400">No login history available</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Settings Forms -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Profile Information Form -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/30">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-blue-100 dark:bg-blue-900/50 rounded-lg">
                                <UserCircle class="w-5 h-5 text-blue-600 dark:text-blue-400" />
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Profile Information</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Update your account's profile information and email address.</p>
                            </div>
                        </div>
                    </div>

                    <form @submit.prevent="updateProfile" class="p-6">
                        <div class="space-y-6">
                            <!-- Name Field -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Full Name
                                </label>
                                <div class="relative">
                                    <input
                                        id="name"
                                        v-model="profileForm.name"
                                        type="text"
                                        required
                                        class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-white transition-all duration-200 shadow-sm hover:shadow-md"
                                        :class="{ 'border-red-500 focus:ring-red-500': profileErrors.name }"
                                    />
                                    <User class="absolute right-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" />
                                </div>
                                <p v-if="profileErrors.name" class="mt-2 text-sm text-red-600 dark:text-red-400">
                                    {{ profileErrors.name }}
                                </p>
                            </div>

                            <!-- Email Field -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Email Address
                                </label>
                                <div class="relative">
                                    <input
                                        id="email"
                                        v-model="profileForm.email"
                                        type="email"
                                        required
                                        class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-white transition-all duration-200 shadow-sm hover:shadow-md"
                                        :class="{ 'border-red-500 focus:ring-red-500': profileErrors.email }"
                                    />
                                    <Mail class="absolute right-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" />
                                </div>
                                <p v-if="profileErrors.email" class="mt-2 text-sm text-red-600 dark:text-red-400">
                                    {{ profileErrors.email }}
                                </p>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex items-center justify-between pt-6 mt-6 border-t border-gray-200 dark:border-gray-700">
                            <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                                <Shield class="w-4 h-4" />
                                Your information is secure and encrypted
                            </div>
                            <div class="flex gap-3">
                                <button
                                    type="button"
                                    @click="resetProfileForm"
                                    class="px-4 py-2 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-200"
                                >
                                    Reset
                                </button>
                                <button
                                    type="submit"
                                    :disabled="profileProcessing"
                                    class="inline-flex items-center px-6 py-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none"
                                >
                                    <template v-if="profileProcessing">
                                        <Loader2 class="w-4 h-4 mr-2 animate-spin" />
                                        Updating...
                                    </template>
                                    <template v-else>
                                        <Save class="w-4 h-4 mr-2" />
                                        Update Profile
                                    </template>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Password Change Form -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/30">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-orange-100 dark:bg-orange-900/50 rounded-lg">
                                <Lock class="w-5 h-5 text-orange-600 dark:text-orange-400" />
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Change Password</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Ensure your account is using a long, random password to stay secure.</p>
                            </div>
                        </div>
                    </div>

                    <form @submit.prevent="updatePassword" class="p-6">
                        <div class="space-y-6">
                            <!-- Current Password Field -->
                            <div>
                                <label for="current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Current Password
                                </label>
                                <div class="relative">
                                    <input
                                        id="current_password"
                                        v-model="passwordForm.current_password"
                                        :type="showCurrentPassword ? 'text' : 'password'"
                                        required
                                        class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-white transition-all duration-200 shadow-sm hover:shadow-md pr-20"
                                        :class="{ 'border-red-500 focus:ring-red-500': passwordErrors.current_password }"
                                    />
                                    <div class="absolute right-3 top-1/2 transform -translate-y-1/2 flex items-center gap-2">
                                        <button
                                            type="button"
                                            @click="showCurrentPassword = !showCurrentPassword"
                                            class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                                        >
                                            <Eye v-if="!showCurrentPassword" class="w-5 h-5" />
                                            <EyeOff v-else class="w-5 h-5" />
                                        </button>
                                        <Lock class="w-5 h-5 text-gray-400" />
                                    </div>
                                </div>
                                <p v-if="passwordErrors.current_password" class="mt-2 text-sm text-red-600 dark:text-red-400">
                                    {{ passwordErrors.current_password }}
                                </p>
                            </div>

                            <!-- New Password Field -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    New Password
                                </label>
                                <div class="relative">
                                    <input
                                        id="password"
                                        v-model="passwordForm.password"
                                        :type="showNewPassword ? 'text' : 'password'"
                                        required
                                        class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-white transition-all duration-200 shadow-sm hover:shadow-md pr-20"
                                        :class="{ 'border-red-500 focus:ring-red-500': passwordErrors.password }"
                                    />
                                    <div class="absolute right-3 top-1/2 transform -translate-y-1/2 flex items-center gap-2">
                                        <button
                                            type="button"
                                            @click="showNewPassword = !showNewPassword"
                                            class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                                        >
                                            <Eye v-if="!showNewPassword" class="w-5 h-5" />
                                            <EyeOff v-else class="w-5 h-5" />
                                        </button>
                                        <KeyRound class="w-5 h-5 text-gray-400" />
                                    </div>
                                </div>
                                <p v-if="passwordErrors.password" class="mt-2 text-sm text-red-600 dark:text-red-400">
                                    {{ passwordErrors.password }}
                                </p>

                                <!-- Password Strength Indicator -->
                                <div v-if="passwordForm.password" class="mt-3">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">Password strength:</span>
                                        <span :class="passwordStrengthClass" class="text-sm font-medium">
                                          {{ passwordStrengthText }}
                                        </span>
                                    </div>
                                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                        <div
                                            :class="passwordStrengthBarClass"
                                            class="h-2 rounded-full transition-all duration-300"
                                            :style="{ width: passwordStrengthPercentage + '%' }"
                                        ></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Confirm Password Field -->
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Confirm New Password
                                </label>
                                <div class="relative">
                                    <input
                                        id="password_confirmation"
                                        v-model="passwordForm.password_confirmation"
                                        :type="showConfirmPassword ? 'text' : 'password'"
                                        required
                                        class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-white transition-all duration-200 shadow-sm hover:shadow-md pr-20"
                                        :class="{ 'border-red-500 focus:ring-red-500': passwordErrors.password_confirmation }"
                                    />
                                    <div class="absolute right-3 top-1/2 transform -translate-y-1/2 flex items-center gap-2">
                                        <button
                                            type="button"
                                            @click="showConfirmPassword = !showConfirmPassword"
                                            class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                                        >
                                            <Eye v-if="!showConfirmPassword" class="w-5 h-5" />
                                            <EyeOff v-else class="w-5 h-5" />
                                        </button>
                                        <ShieldCheck class="w-5 h-5 text-gray-400" />
                                    </div>
                                </div>
                                <p v-if="passwordErrors.password_confirmation" class="mt-2 text-sm text-red-600 dark:text-red-400">
                                    {{ passwordErrors.password_confirmation }}
                                </p>

                                <!-- Password Match Indicator -->
                                <div v-if="passwordForm.password && passwordForm.password_confirmation" class="mt-2">
                                    <div class="flex items-center gap-2">
                                        <CheckCircle v-if="passwordsMatch" class="w-4 h-4 text-green-500" />
                                        <XCircle v-else class="w-4 h-4 text-red-500" />
                                        <span :class="passwordsMatch ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'" class="text-sm">
                                          {{ passwordsMatch ? 'Passwords match' : 'Passwords do not match' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex items-center justify-between pt-6 mt-6 border-t border-gray-200 dark:border-gray-700">
                            <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                                <AlertTriangle class="w-4 h-4" />
                                Use a strong password with at least 8 characters
                            </div>
                            <div class="flex gap-3">
                                <button
                                    type="button"
                                    @click="resetPasswordForm"
                                    class="px-4 py-2 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-200"
                                >
                                    Reset
                                </button>
                                <button
                                    type="submit"
                                    :disabled="passwordProcessing || !passwordsMatch"
                                    class="inline-flex items-center px-6 py-2 bg-gradient-to-r from-orange-600 to-orange-700 hover:from-orange-700 hover:to-orange-800 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none"
                                >
                                    <template v-if="passwordProcessing">
                                        <Loader2 class="w-4 h-4 mr-2 animate-spin" />
                                        Updating...
                                    </template>
                                    <template v-else>
                                        <Shield class="w-4 h-4 mr-2" />
                                        Update Password
                                    </template>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Security Tips -->
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-xl border border-blue-200 dark:border-blue-800 p-6">
                    <div class="flex items-start gap-4">
                        <div class="p-2 bg-blue-100 dark:bg-blue-900/50 rounded-lg flex-shrink-0">
                            <Info class="w-5 h-5 text-blue-600 dark:text-blue-400" />
                        </div>
                        <div>
                            <h4 class="text-lg font-semibold text-blue-900 dark:text-blue-100 mb-2">Security Best Practices</h4>
                            <ul class="space-y-2 text-sm text-blue-800 dark:text-blue-200">
                                <li class="flex items-center gap-2">
                                    <CheckCircle class="w-4 h-4 text-blue-600 dark:text-blue-400 flex-shrink-0" />
                                    Use a unique password that you don't use elsewhere
                                </li>
                                <li class="flex items-center gap-2">
                                    <CheckCircle class="w-4 h-4 text-blue-600 dark:text-blue-400 flex-shrink-0" />
                                    Make it at least 12 characters long
                                </li>
                                <li class="flex items-center gap-2">
                                    <CheckCircle class="w-4 h-4 text-blue-600 dark:text-blue-400 flex-shrink-0" />
                                    Include numbers, symbols, and mixed-case letters
                                </li>
                                <li class="flex items-center gap-2">
                                    <CheckCircle class="w-4 h-4 text-blue-600 dark:text-blue-400 flex-shrink-0" />
                                    Avoid personal information like names or birthdays
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { router, usePage } from '@inertiajs/vue3'
import Layout from '@/layouts/AdminLayout.vue'
import {
    Settings, User, UserCircle, Mail, Lock, KeyRound, Shield, ShieldCheck, Save,
    Eye, EyeOff, CheckCircle, XCircle, AlertTriangle, Info, Loader2, Crown,
    Calendar, Clock, Download, History, LogIn, Trash2
} from 'lucide-vue-next'
import Swal from 'sweetalert2'
import jsPDF from 'jspdf'

const profileForm = ref({
    name: '',
    email: ''
})

const passwordForm = ref({
    current_password: '',
    password: '',
    password_confirmation: ''
})

const profileProcessing = ref(false)
const passwordProcessing = ref(false)
const profileErrors = ref({})
const passwordErrors = ref({})
const exportLoading = ref(false)
const showLoginHistory = ref(false)

const showCurrentPassword = ref(false)
const showNewPassword = ref(false)
const showConfirmPassword = ref(false)

const loginHistory = ref([])
const lastLoginTime = ref('Just now')

const getInitials = (name) => {
    if (!name) return 'U'
    return name
        .split(' ')
        .map(word => word.charAt(0).toUpperCase())
        .slice(0, 2)
        .join('')
}

const getBrowserInfo = () => {
    const userAgent = navigator.userAgent
    let browser = 'Unknown Browser'

    if (userAgent.includes('Chrome')) browser = 'Chrome'
    else if (userAgent.includes('Firefox')) browser = 'Firefox'
    else if (userAgent.includes('Safari')) browser = 'Safari'
    else if (userAgent.includes('Edge')) browser = 'Edge'

    return browser
}

const loadLoginHistory = () => {
    const stored = localStorage.getItem('barbershop_login_history')
    if (stored) {
        loginHistory.value = JSON.parse(stored).map(login => ({
            ...login,
            timestamp: new Date(login.timestamp)
        }))
    }

    const lastLogin = localStorage.getItem('barbershop_last_login')
    if (lastLogin) {
        lastLoginTime.value = formatDateTime(new Date(lastLogin))
    }
}

const saveLoginHistory = () => {
    localStorage.setItem('barbershop_login_history', JSON.stringify(loginHistory.value))
}

const getPublicIP = async () => {
    try {
        const response = await fetch('https://api.ipify.org?format=json')
        const data = await response.json()
        return data.ip
    } catch (error) {
        console.error('Failed to get IP:', error)
        return 'Unknown IP'
    }
}

const addLoginEntry = async () => {
    const now = new Date()
    const ip = await getPublicIP()

    const newLogin = {
        timestamp: now,
        userAgent: `${getBrowserInfo()} on ${navigator.platform}`,
        ip: ip
    }

    loginHistory.value.unshift(newLogin)
    if (loginHistory.value.length > 10) {
        loginHistory.value = loginHistory.value.slice(0, 10)
    }

    lastLoginTime.value = 'Just now'
    localStorage.setItem('barbershop_last_login', now.toISOString())

    saveLoginHistory()
}


const clearLoginHistory = () => {
    Swal.fire({
        title: 'Clear Login History?',
        text: 'This will permanently delete all login history records.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#EF4444',
        cancelButtonColor: '#6B7280',
        confirmButtonText: 'Yes, clear it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            loginHistory.value = []
            localStorage.removeItem('barbershop_login_history')
            Swal.fire({
                icon: 'success',
                title: 'History Cleared!',
                text: 'Login history has been cleared successfully.',
                confirmButtonColor: '#3B82F6',
                timer: 2000,
                timerProgressBar: true
            })
        }
    })
}

const exportAccountData = async () => {
    exportLoading.value = true

    try {
        await new Promise(resolve => setTimeout(resolve, 1500))

        const user = usePage().props.auth.user
        const doc = new jsPDF()

        doc.setFontSize(20)
        doc.setTextColor(59, 130, 246)
        doc.text('Account Information Report', 20, 30)

        doc.setFontSize(10)
        doc.setTextColor(100, 100, 100)
        doc.text(`Generated on: ${new Date().toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        })}`, 20, 40)

        doc.setFontSize(16)
        doc.setTextColor(0, 0, 0)
        doc.text('Personal Information', 20, 60)

        doc.setFontSize(12)
        doc.text(`Full Name: ${user.name}`, 20, 75)
        doc.text(`Email Address: ${user.email}`, 20, 85)
        doc.text(`Account Role: Administrator`, 20, 95)
        doc.text(`Member Since: ${formatDate(user.created_at)}`, 20, 105)
        doc.text(`Last Login: ${lastLoginTime.value}`, 20, 115)

        if (loginHistory.value.length > 0) {
            doc.setFontSize(16)
            doc.text('Recent Login History', 20, 140)

            doc.setFontSize(10)
            let yPosition = 155

            loginHistory.value.slice(0, 8).forEach((login, index) => {
                if (yPosition > 270) {
                    doc.addPage()
                    yPosition = 30
                }

                doc.setTextColor(0, 0, 0)
                doc.text(`${index + 1}. Login Session`, 20, yPosition)
                doc.setTextColor(100, 100, 100)
                doc.text(`   Device: ${login.userAgent}`, 20, yPosition + 8)
                doc.text(`   Time: ${formatDateTime(login.timestamp)}`, 20, yPosition + 16)
                yPosition += 25
            })
        }

        doc.setFontSize(8)
        doc.setTextColor(150, 150, 150)
        doc.text('This document contains confidential information. Please handle with care.', 20, 280)
        doc.text('Generated by Barbershop Admin Dashboard', 20, 285)

        doc.save(`account-data-${user.name.replace(/\s+/g, '-').toLowerCase()}-${new Date().toISOString().split('T')[0]}.pdf`)

        Swal.fire({
            icon: 'success',
            title: 'Export Successful!',
            text: 'Your account data has been exported to PDF.',
            confirmButtonColor: '#3B82F6',
            timer: 2000,
            timerProgressBar: true
        })

    } catch (error) {
        console.error('Export error:', error)
        Swal.fire({
            icon: 'error',
            title: 'Export Failed',
            text: 'There was an error exporting your data. Please try again.',
            confirmButtonColor: '#3B82F6'
        })
    } finally {
        exportLoading.value = false
    }
}

const passwordStrength = computed(() => {
    const password = passwordForm.value.password
    if (!password) return 0

    let score = 0

    if (password.length >= 8) score += 1
    if (password.length >= 12) score += 1

    if (/[a-z]/.test(password)) score += 1
    if (/[A-Z]/.test(password)) score += 1
    if (/[0-9]/.test(password)) score += 1
    if (/[^A-Za-z0-9]/.test(password)) score += 1

    return score
})

const passwordStrengthText = computed(() => {
    const strength = passwordStrength.value
    if (strength <= 2) return 'Weak'
    if (strength <= 4) return 'Medium'
    return 'Strong'
})

const passwordStrengthClass = computed(() => {
    const strength = passwordStrength.value
    if (strength <= 2) return 'text-red-600 dark:text-red-400'
    if (strength <= 4) return 'text-yellow-600 dark:text-yellow-400'
    return 'text-green-600 dark:text-green-400'
})

const passwordStrengthBarClass = computed(() => {
    const strength = passwordStrength.value
    if (strength <= 2) return 'bg-red-500'
    if (strength <= 4) return 'bg-yellow-500'
    return 'bg-green-500'
})

const passwordStrengthPercentage = computed(() => {
    return (passwordStrength.value / 6) * 100
})

const passwordsMatch = computed(() => {
    return passwordForm.value.password === passwordForm.value.password_confirmation
})

const updateProfile = () => {
    profileProcessing.value = true
    profileErrors.value = {}

    router.put('/admin/profile', profileForm.value, {
        onSuccess: () => {
            profileProcessing.value = false
            Swal.fire({
                icon: 'success',
                title: 'Profile Updated!',
                text: 'Your profile information has been updated successfully.',
                confirmButtonColor: '#3B82F6',
                timer: 2000,
                timerProgressBar: true
            })
        },
        onError: (errors) => {
            profileProcessing.value = false
            profileErrors.value = errors
            Swal.fire({
                icon: 'error',
                title: 'Update Failed',
                text: 'Please check the form for errors and try again.',
                confirmButtonColor: '#3B82F6'
            })
        }
    })
}

const updatePassword = () => {
    passwordProcessing.value = true
    passwordErrors.value = {}

    router.put('/admin/profile/password', passwordForm.value, {
        onSuccess: () => {
            passwordProcessing.value = false
            resetPasswordForm()
            Swal.fire({
                icon: 'success',
                title: 'Password Updated!',
                text: 'Your password has been changed successfully.',
                confirmButtonColor: '#3B82F6',
                timer: 2000,
                timerProgressBar: true
            })
        },
        onError: (errors) => {
            passwordProcessing.value = false
            passwordErrors.value = errors
            Swal.fire({
                icon: 'error',
                title: 'Password Update Failed',
                text: 'Please check the form for errors and try again.',
                confirmButtonColor: '#3B82F6'
            })
        }
    })
}

const resetProfileForm = () => {
    initializeData()
    profileErrors.value = {}
}

const resetPasswordForm = () => {
    passwordForm.value = {
        current_password: '',
        password: '',
        password_confirmation: ''
    }
    passwordErrors.value = {}
    showCurrentPassword.value = false
    showNewPassword.value = false
    showConfirmPassword.value = false
}

const formatDate = (dateString) => {
    if (!dateString) return 'N/A'
    const date = new Date(dateString)
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    })
}

const formatDateTime = (date) => {
    if (!date) return 'N/A'
    return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    })
}

const initializeData = () => {
    const user = usePage().props.auth.user
    profileForm.value = {
        name: user.name || '',
        email: user.email || ''
    }
}

onMounted(() => {
    initializeData()
    loadLoginHistory()

    const lastLogin = localStorage.getItem('barbershop_last_login')
    const now = new Date()

    if (!lastLogin || (now - new Date(lastLogin)) > 5 * 60 * 1000) {
        addLoginEntry()
    }
})
</script>

<style scoped>
input:focus {
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.transition-all {
    transition-property: all;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
}

.hover\:shadow-lg:hover {
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}

.dark .hover\:shadow-lg:hover {
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3), 0 4px 6px -2px rgba(0, 0, 0, 0.2);
}

.transform:hover {
    transform: translateY(-1px);
}

.disabled\:transform-none:disabled {
    transform: none;
}

.overflow-y-auto::-webkit-scrollbar {
    width: 4px;
}

.overflow-y-auto::-webkit-scrollbar-track {
    background: transparent;
}

.overflow-y-auto::-webkit-scrollbar-thumb {
    background: rgba(156, 163, 175, 0.5);
    border-radius: 2px;
}

.overflow-y-auto::-webkit-scrollbar-thumb:hover {
    background: rgba(156, 163, 175, 0.7);
}
</style>
