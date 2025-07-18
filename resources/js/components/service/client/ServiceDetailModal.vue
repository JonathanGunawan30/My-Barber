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
            class="fixed inset-0 z-50 flex items-center justify-center p-4 backdrop-blur-md bg-white/30"
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
                    v-if="isOpen && service"
                    @click.stop
                    class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-hidden flex flex-col"
                >
                    <div class="p-6 border-b border-gray-200 flex justify-between items-center flex-shrink-0">
                        <h2 class="text-2xl font-bold text-gray-900">{{ service.name }}</h2>
                        <button
                            @click="closeModal"
                            class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors duration-200"
                        >
                            <X class="w-6 h-6" />
                        </button>
                    </div>

                    <div class="flex-grow overflow-y-auto">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-0">
                            <div class="relative h-72 md:h-auto overflow-hidden bg-gray-200 service-image-container">
                                <img v-if="service.photo" :src="`/storage/${service.photo}`" :alt="service.name"
                                     class="w-full h-full object-cover" />
                                <div v-else class="w-full h-full flex items-center justify-center bg-gradient-to-br from-blue-500 to-blue-700">
                                    <Scissors class="w-24 h-24 text-white/50" />
                                </div>
                                <div class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity duration-300 cursor-pointer" @click="showFullImage">
                                    <ZoomIn class="w-10 h-10 text-white" />
                                </div>
                            </div>

                            <div class="p-6 bg-white flex flex-col justify-between">
                                <div class="space-y-6">
                                    <div>
                                        <h3 class="text-xl font-semibold text-gray-900 mb-2 flex items-center">
                                            <Info class="w-5 h-5 mr-2 text-blue-600" />
                                            Service Overview
                                        </h3>
                                        <p class="text-gray-700 leading-relaxed text-sm">
                                            {{ service.description || 'No detailed description available for this service.' }}
                                        </p>
                                    </div>

                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <p class="text-sm font-medium text-gray-600">Price</p>
                                            <p class="text-lg font-bold text-gray-900">{{ formatRupiah(service.price) }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-600">Duration</p>
                                            <p class="text-lg font-bold text-gray-900">{{ service.duration }} minutes</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-8">
                                    <button
                                        @click="closeModal"
                                        class="w-full inline-flex items-center justify-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5"
                                    >
                                        <CheckCircle class="w-5 h-5 mr-2" />
                                        Got it! Close
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </Transition>
        </div>
    </Transition>

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
                <div v-if="showImageModal && service?.photo" class="relative max-w-6xl max-h-full">
                    <img
                        :src="`/storage/${service.photo}`"
                        :alt="service.name"
                        class="max-w-full max-h-full object-contain rounded-lg"
                    />
                    <button
                        @click="closeImageModal"
                        class="absolute top-4 right-4 text-white hover:text-gray-300 bg-black bg-opacity-50 rounded-full p-3 transition-colors duration-200"
                    >
                        <X class="w-6 h-6" />
                    </button>
                    <div class="absolute bottom-4 left-4 bg-black bg-opacity-75 text-white p-4 rounded-lg max-w-md">
                        <h3 class="font-semibold text-lg">{{ service.name }}</h3>
                        <p class="text-gray-300 mt-1">{{ formatRupiah(service.price) }} • {{ service.duration }} mins</p>
                    </div>
                </div>
            </Transition>
        </div>
    </Transition>
</template>

<script setup lang="ts">
import { ref, watch } from 'vue'
import { X, Scissors, ZoomIn, Info, CheckCircle } from 'lucide-vue-next'

const props = defineProps<{
    isOpen: boolean;
    service: {
        id: number;
        name: string;
        description: string;
        price: number;
        duration: number;
        photo: string | null;
        created_at?: string;
        updated_at?: string;
    } | null;
}>();

const emit = defineEmits(['close']);

const showImageModal = ref(false);

watch(() => props.isOpen, (newValue) => {
    if (newValue) {
        document.body.style.overflow = 'hidden';
    } else {
        document.body.style.overflow = 'auto';
        showImageModal.value = false;
    }
});

const closeModal = () => {
    emit('close');
};

const showFullImage = () => {
    showImageModal.value = true;
};

const closeImageModal = () => {
    showImageModal.value = false;
};

const formatRupiah = (amount: number) => {
    if (amount === null || amount === undefined) return 'N/A';
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    }).format(amount);
};
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

.service-image-container {
    background-color: #e2e8f0;
}

.service-image-container > div:last-child {
    opacity: 0;
    transition: opacity 0.3s ease;
}
.service-image-container:hover > div:last-child {
    opacity: 1;
}
</style>
