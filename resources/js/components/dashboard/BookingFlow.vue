<template>
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="bg-gray-50 px-8 py-6 border-b">
            <div class="flex items-center justify-between">
                <div
                    v-for="(step, index) in steps"
                    :key="step.id"
                    class="flex items-center"
                    :class="{ 'flex-1': index < steps.length - 1 }"
                >
                    <div class="flex items-center">
                        <div
                            class="w-10 h-10 rounded-full flex items-center justify-center font-semibold transition-all"
                            :class="currentStep >= step.id
                                ? 'bg-blue-600 text-white'
                                : 'bg-gray-200 text-gray-500'"
                        >
                            <component
                                v-if="currentStep > step.id"
                                :is="Check"
                                class="w-5 h-5"
                            />
                            <span v-else>{{ step.id }}</span>
                        </div>
                        <span
                            class="ml-3 font-medium"
                            :class="currentStep >= step.id ? 'text-blue-600' : 'text-gray-500'"
                        >
                            {{ step.name }}
                        </span>
                    </div>
                    <div
                        v-if="index < steps.length - 1"
                        class="flex-1 h-0.5 mx-4"
                        :class="currentStep > step.id ? 'bg-blue-600' : 'bg-gray-200'"
                    ></div>
                </div>
            </div>
        </div>

        <div class="p-8">
            <div v-if="currentStep === 1" class="space-y-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Select Location</h2>
                    <p class="text-gray-600">Choose your preferred barbershop location</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div
                        v-for="branch in branches"
                        :key="branch.id"
                        @click="selectBranch(branch)"
                        class="border-2 rounded-xl p-6 cursor-pointer transition-all hover:shadow-lg"
                        :class="selectedBranch?.id === branch.id
                            ? 'border-blue-500 bg-blue-50'
                            : 'border-gray-200 hover:border-blue-300'"
                    >
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                                <MapPin class="w-6 h-6 text-blue-600" />
                            </div>
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900 mb-1">{{ branch.name }}</h3>
                                <p class="text-gray-600 text-sm mb-2">{{ branch.address }}</p>
                                <span
                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium"
                                    :class="branch.status === 'active'
                                        ? 'bg-green-100 text-green-800'
                                        : 'bg-red-100 text-red-800'"
                                >
                                    {{ branch.status === 'active' ? 'Open' : 'Closed' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div v-if="currentStep === 2" class="space-y-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Select Service</h2>
                    <p class="text-gray-600">Choose the service you'd like to book</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div
                        v-for="service in services"
                        :key="service.id"
                        @click="selectService(service)"
                        class="border-2 rounded-xl p-6 cursor-pointer transition-all hover:shadow-lg"
                        :class="selectedService?.id === service.id
                            ? 'border-blue-500 bg-blue-50'
                            : 'border-gray-200 hover:border-blue-300'"
                    >
                        <div class="text-center">
                            <div class="w-16 h-16 bg-blue-100 rounded-xl flex items-center justify-center mx-auto mb-4">
                                <Scissors class="w-8 h-8 text-blue-600" />
                            </div>
                            <h3 class="font-semibold text-gray-900 mb-2">{{ service.name }}</h3>
                            <p class="text-gray-600 text-sm mb-3">{{ service.description }}</p>
                            <div class="flex items-center justify-between text-sm">
                                <span class="font-semibold text-blue-600">{{ formatRupiah(service.price) }}</span>
                                <span class="text-gray-500">{{ service.duration }}min</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div v-if="currentStep === 3" class="space-y-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Select Barber</h2>
                    <p class="text-gray-600">Choose your preferred barber</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div
                        v-for="barber in availableBarbers"
                        :key="barber.id"
                        @click="selectBarber(barber)"
                        class="border-2 rounded-xl p-6 cursor-pointer transition-all hover:shadow-lg"
                        :class="selectedBarber?.id === barber.id
                            ? 'border-blue-500 bg-blue-50'
                            : 'border-gray-200 hover:border-blue-300'"
                    >
                        <div class="text-center">
                            <div class="w-16 h-16 rounded-full overflow-hidden mx-auto mb-4">
                                <img
                                    v-if="barber.photo"
                                    :src="`/storage/${barber.photo}`"
                                    :alt="barber.name"
                                    class="w-full h-full object-cover"
                                />
                                <div v-else class="w-full h-full bg-gray-300 flex items-center justify-center">
                                    <User class="w-8 h-8 text-gray-600" />
                                </div>
                            </div>
                            <h3 class="font-semibold text-gray-900 mb-1">{{ barber.name }}</h3>
                            <span
                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium"
                                :class="barber.status === 'active'
                                    ? 'bg-green-100 text-green-800'
                                    : 'bg-red-100 text-red-800'"
                            >
                                {{ barber.status === 'active' ? 'Available' : 'Busy' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div v-if="currentStep === 4" class="space-y-8">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Select Date & Time</h2>
                    <p class="text-gray-600">Choose your preferred appointment time</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">
                    <div class="space-y-4">
                        <h3 class="font-semibold text-gray-900">1. Select a Date</h3>
                        <div class="grid grid-cols-4 sm:grid-cols-7 gap-2">
                            <div
                                v-for="date in availableDates"
                                :key="date.date"
                                @click="selectDate(date)"
                                class="p-3 text-center rounded-xl cursor-pointer transition-all border-2"
                                :class="[
                                    selectedDate?.date === date.date
                                        ? 'bg-blue-600 border-blue-600 text-white shadow-lg'
                                        : date.available
                                            ? 'bg-white hover:bg-blue-50 border-gray-200 text-gray-900'
                                            : 'bg-gray-50 border-gray-200 text-gray-400 cursor-not-allowed'
                                ]"
                            >
                                <div class="text-xs font-medium uppercase">{{ date.dayName }}</div>
                                <div class="text-2xl font-bold mt-1">{{ date.day }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <h3 class="font-semibold text-gray-900">2. Select a Time</h3>
                        <div v-if="selectedDate" class="bg-gray-50 rounded-xl p-4 max-h-60 overflow-y-auto">
                            <div v-if="filteredTimes.length > 0" class="grid grid-cols-3 sm:grid-cols-4 gap-2">
                                <button
                                    v-for="time in filteredTimes"
                                    :key="time"
                                    @click="selectTime(time)"
                                    class="p-3 rounded-lg font-medium transition-all text-center"
                                    :class="selectedTime === time
                                        ? 'bg-blue-600 text-white shadow-md'
                                        : 'bg-white hover:bg-blue-100 text-gray-900 border border-gray-200'"
                                >
                                    {{ time }}
                                </button>
                            </div>
                            <div v-else class="text-center py-8 text-gray-500">
                                <p>No available slots for this date.</p>
                            </div>
                        </div>
                        <div v-else class="text-center py-12 text-gray-500 bg-gray-50 rounded-xl">
                            <p>Please select a date to see available times.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div v-if="currentStep === 5" class="space-y-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Booking Confirmation</h2>
                    <p class="text-gray-600">Please review your booking details</p>
                </div>
                <div class="bg-gray-50 rounded-xl p-6">
                    <div class="space-y-4">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Location:</span>
                            <span class="font-medium text-gray-900 text-right">{{ selectedBranch?.name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Service:</span>
                            <span class="font-medium text-gray-900 text-right">{{ selectedService?.name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Barber:</span>
                            <span class="font-medium text-gray-900 text-right">{{ selectedBarber?.name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Date:</span>
                            <span class="font-medium text-gray-900 text-right">{{ formatSelectedDate() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Time:</span>
                            <span class="font-medium text-gray-900 text-right">{{ selectedTime }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Duration:</span>
                            <span class="font-medium text-gray-900 text-right">{{ selectedService?.duration }} minutes</span>
                        </div>
                        <hr class="my-4">
                        <div class="flex justify-between text-lg font-bold">
                            <span>Total:</span>
                            <span class="text-blue-600">{{ formatRupiah(selectedService?.price || 0) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-gray-50 px-8 py-6 border-t flex justify-between">
            <button
                v-if="currentStep > 1"
                @click="previousStep"
                class="flex items-center gap-2 px-6 py-3 border border-gray-300 rounded-lg font-medium text-gray-700 hover:bg-gray-100 transition-colors"
            >
                <ChevronLeft class="w-4 h-4" />
                Previous
            </button>
            <div v-else></div>
            <button
                @click="nextStep"
                :disabled="!canProceed"
                class="flex items-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
            >
                {{ currentStep === 5 ? 'Confirm Booking' : 'Next' }}
                <ChevronRight v-if="currentStep < 5" class="w-4 h-4" />
                <Check v-else class="w-4 h-4" />
            </button>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import {
    MapPin, Scissors, User, Check, ChevronLeft, ChevronRight
} from 'lucide-vue-next'

interface Branch {
    id: number;
    name: string;
    address: string;
    status: string;
    photo?: string | null;
}

interface Service {
    id: number;
    name: string;
    description: string;
    price: string | number;
    duration: number;
    photo?: string | null;
}

interface Barber {
    id: number;
    name: string;
    branch_id: number;
    photo?: string | null;
    status: string;
}

interface Booking {
    id: number;
    barber_id: number;
    date: string;
    time: string;
    service: {
        duration: number;
    };
}

interface BookingPayload {
    branch: Branch | null;
    service: Service | null;
    barber: Barber | null;
    date?: string;
    time: string | null;
}

const props = defineProps<{
    branches: Branch[];
    services: Service[];
    barbers: Barber[];
    bookings: Booking[];
}>()

const emit = defineEmits<{
    (e: 'booking-complete', payload: BookingPayload): void
}>()

const currentStep = ref<number>(1)
const selectedBranch = ref<Branch | null>(null)
const selectedService = ref<Service | null>(null)
const selectedBarber = ref<Barber | null>(null)
const selectedDate = ref<{ date: string; available: boolean } | null>(null)
const selectedTime = ref<string | null>(null)

const steps = [
    { id: 1, name: 'Location' },
    { id: 2, name: 'Service' },
    { id: 3, name: 'Barber' },
    { id: 4, name: 'Date & Time' },
    { id: 5, name: 'Confirmation' }
]

const availableTimes = computed(() => {
    return [
        '09:00', '10:00', '11:00', '12:00',
        '13:00', '14:00', '15:00', '16:00',
        '17:00', '18:00', '19:00', '20:00'
    ]
})

const availableBarbers = computed(() => {
    if (!selectedBranch.value) return []
    return props.barbers.filter(barber => barber.branch_id === selectedBranch.value!.id)
})

const availableDates = computed(() => {
    const dates = []
    const today = new Date()
    for (let i = 0; i < 14; i++) {
        const date = new Date(today)
        date.setDate(today.getDate() + i + 1)
        dates.push({
            date: date.toISOString().split('T')[0],
            day: date.getDate(),
            dayName: date.toLocaleDateString('en', { weekday: 'short' }),
            available: date.getDay() !== 0
        })
    }
    return dates
})

const filteredTimes = computed(() => {
    if (!selectedDate.value || !selectedBarber.value || !selectedService.value) {
        return []
    }
    const duration = selectedService.value.duration
    const selectedDateStr = selectedDate.value.date
    const closingTime = new Date(`${selectedDateStr}T21:00:00`)
    const bookingsForDate = (props.bookings || []).filter(
        b => b.barber_id === selectedBarber.value!.id && b.date === selectedDateStr
    )
    return availableTimes.value.filter(timeSlot => {
        const newBookingStart = new Date(`${selectedDateStr}T${timeSlot}:00`)
        const newBookingEnd = new Date(newBookingStart.getTime() + duration * 60000)
        if (newBookingEnd > closingTime) {
            return false
        }
        const hasOverlap = bookingsForDate.some(existingBooking => {
            const existingStart = new Date(`${existingBooking.date}T${existingBooking.time}`)
            const existingDuration = existingBooking.service.duration
            const existingEnd = new Date(existingStart.getTime() + existingDuration * 60000)
            return newBookingStart < existingEnd && newBookingEnd > existingStart
        })
        return !hasOverlap
    })
})

const canProceed = computed(() => {
    switch (currentStep.value) {
        case 1: return selectedBranch.value !== null
        case 2: return selectedService.value !== null
        case 3: return selectedBarber.value !== null
        case 4: return selectedDate.value !== null && selectedTime.value !== null
        case 5: return true
        default: return false
    }
})

const selectBranch = (branch: Branch) => {
    selectedBranch.value = branch
    selectedService.value = null
    selectedBarber.value = null
    selectedDate.value = null
    selectedTime.value = null
}

const selectService = (service: Service) => {
    selectedService.value = service
}

const selectBarber = (barber: Barber) => {
    selectedBarber.value = barber
}

const selectDate = (date: { date: string; available: boolean }) => {
    if (date.available) {
        selectedDate.value = date
        selectedTime.value = null
    }
}

const selectTime = (time: string) => {
    selectedTime.value = time
}

const nextStep = () => {
    if (currentStep.value === 5) {
        confirmBooking()
    } else if (canProceed.value) {
        currentStep.value++
    }
}

const previousStep = () => {
    if (currentStep.value > 1) {
        currentStep.value--
    }
}

const confirmBooking = () => {
    const booking: BookingPayload = {
        branch: selectedBranch.value,
        service: selectedService.value,
        barber: selectedBarber.value,
        date: selectedDate.value?.date,
        time: selectedTime.value
    }
    emit('booking-complete', booking)
}

const formatRupiah = (amount: number | string) => {
    const numAmount = typeof amount === 'string' ? parseFloat(amount) : amount
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    }).format(numAmount)
}

const formatSelectedDate = () => {
    if (!selectedDate.value) return ''
    return new Date(selectedDate.value.date + 'T00:00:00Z').toLocaleDateString('id-ID', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    })
}
</script>
