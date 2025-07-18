<template>
    <MainLayout>
        <section class="relative bg-gray-900 text-white h-screen flex items-center justify-center hero-section overflow-hidden">
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-gray-900 via-gray-800 to-black"></div>
                <div class="absolute inset-0 bg-black/40"></div>
                <div class="floating-element-1 absolute top-20 left-10 w-32 h-32 bg-blue-500/20 rounded-full blur-3xl"></div>
                <div class="floating-element-2 absolute bottom-20 right-10 w-48 h-48 bg-blue-600/20 rounded-full blur-3xl"></div>
                <div class="floating-element-3 absolute top-1/2 left-1/4 w-24 h-24 bg-blue-500/15 rounded-full blur-2xl"></div>
            </div>

            <div class="particles-container absolute inset-0">
                <div v-for="i in 40" :key="i" class="particle absolute bg-white/50 rounded-full"></div>
            </div>

            <div class="relative max-w-6xl mx-auto text-center px-4 z-10">
                <div class="mb-8" data-aos="fade-up" data-aos-duration="1000">
                    <div class="inline-flex items-center gap-3 mb-6 px-6 py-3 bg-white/10 backdrop-blur-md rounded-full border border-white/20">
                        <Sparkles class="w-5 h-5 text-blue-400 animate-pulse" />
                        <span class="text-sm font-semibold text-blue-200 tracking-wide uppercase">Premium Collection</span>
                        <Sparkles class="w-5 h-5 text-blue-400 animate-pulse" style="animation-delay: 0.5s;" />
                    </div>

                    <h1 class="text-6xl md:text-7xl lg:text-8xl font-black mb-6 leading-tight hero-title">
                        <span class="hero-word-1">Hairstyle</span>
                        <br>
                        <span class="hero-word-2 bg-gradient-to-r from-blue-400 to-blue-600 bg-clip-text text-transparent">
                          Gallery
                        </span>
                    </h1>
                </div>

                <div class="max-w-3xl mx-auto mb-12" data-aos="fade-up" data-aos-delay="300" data-aos-duration="1000">
                    <p class="text-xl md:text-2xl text-gray-300 leading-relaxed mb-6 font-light">
                        Discover your next look. Browse our collection of
                        <span class="text-blue-400 font-semibold">modern</span> and
                        <span class="text-blue-500 font-semibold">classic</span> hairstyles
                        curated by our expert barbers.
                    </p>

                    <div class="flex flex-wrap justify-center gap-8 text-sm">
                        <div class="flex items-center gap-2 px-4 py-2 bg-white/5 rounded-full backdrop-blur-sm">
                            <div class="w-2 h-2 bg-blue-400 rounded-full animate-pulse"></div>
                            <span class="text-gray-300">50+ Styles</span>
                        </div>
                        <div class="flex items-center gap-2 px-4 py-2 bg-white/5 rounded-full backdrop-blur-sm">
                            <div class="w-2 h-2 bg-blue-500 rounded-full animate-pulse" style="animation-delay: 0.3s;"></div>
                            <span class="text-gray-300">Expert Curated</span>
                        </div>
                        <div class="flex items-center gap-2 px-4 py-2 bg-white/5 rounded-full backdrop-blur-sm">
                            <div class="w-2 h-2 bg-blue-600 rounded-full animate-pulse" style="animation-delay: 0.6s;"></div>
                            <span class="text-gray-300">Trending Now</span>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center" data-aos="fade-up" data-aos-delay="600" data-aos-duration="1000">
                    <button
                        @click="scrollToGallery"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-xl font-semibold text-lg transition-all transform hover:scale-105 flex items-center gap-2 hero-btn-1">
                        <span>Explore Gallery</span>
                        <ArrowDown class="w-5 h-5" />
                    </button>

                    <Link href="/" class="border-2 border-white/30 hover:border-white text-white px-8 py-4 rounded-xl font-semibold text-lg transition-all hover:bg-white/10 flex items-center gap-2 hero-btn-2">
                        <Home class="w-5 h-5" />
                        <span>Back to Home</span>
                    </Link>
                </div>
            </div>

            <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 scroll-indicator" data-aos="fade-up" data-aos-delay="1000">
                <div class="w-6 h-10 border-2 border-white/30 rounded-full flex justify-center">
                    <div class="w-1 h-3 bg-white/60 rounded-full mt-2 scroll-dot animate-bounce"></div>
                </div>
                <ChevronDown class="w-6 h-6 text-white/60 mt-2 mx-auto animate-bounce" />
            </div>
        </section>

        <section id="gallery" class="py-20 bg-gray-50 relative">
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <div class="flex justify-center items-center gap-4 mb-16" data-aos="fade-up" data-aos-delay="200">
                    <button
                        @click="setActiveCategory('all')"
                        :class="['px-8 py-4 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 flex items-center gap-2', activeCategory === 'all' ? 'bg-blue-600 text-white shadow-lg' : 'bg-white text-gray-700 shadow-md border-2 border-gray-200']">
                        All Hairstyles
                    </button>

                    <button
                        v-if="activeCategory === 'trending'"
                        @click="setActiveCategory('trending')"
                        class="px-8 py-4 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 flex items-center gap-2 bg-blue-600 text-white shadow-lg hover:bg-blue-700">
                        <Sparkles class="w-5 h-5" />
                        Trending
                    </button>
                    <button
                        v-else
                        @click="setActiveCategory('trending')"
                        class="animated-gradient-bg transition-all duration-300 transform hover:scale-105 rounded-xl font-semibold flex items-center gap-2 relative px-8 py-4">
                        <span class="flex items-center gap-2">
                            <Sparkles class="w-5 h-5" />
                            Trending
                        </span>
                    </button>
                </div>

                <TransitionGroup name="gallery" tag="div" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                    <div
                        v-for="(hairstyle, index) in filteredHairstyles"
                        :key="hairstyle.id"
                        @click="openDetailModal(hairstyle)"
                        class="group bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-500 transform hover:-translate-y-2 cursor-pointer overflow-hidden border border-gray-100"
                        :data-aos="'fade-up'"
                        :data-aos-delay="(index % 4) * 100">
                        <div class="relative overflow-hidden">
                            <img
                                :src="hairstyle.photo ? `/storage/${hairstyle.photo}` : 'https://via.placeholder.com/400x500'"
                                :alt="hairstyle.name"
                                class="w-full h-72 object-cover transition-transform duration-500 group-hover:scale-110" />
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                            <div v-if="hairstyle.is_featured" class="absolute top-4 right-4 bg-blue-600 text-white px-3 py-1 rounded-full text-xs font-bold flex items-center gap-1 shadow-lg">
                                <Sparkles class="w-4 h-4" />
                                Trending
                            </div>
                            <h3 class="absolute bottom-4 left-4 text-white text-2xl font-bold group-hover:text-blue-300 transition-colors duration-300">
                                {{ hairstyle.name }}
                            </h3>
                        </div>
                    </div>
                </TransitionGroup>
                <div v-if="filteredHairstyles.length === 0" class="text-center py-16 text-gray-500">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <Scissors class="w-12 h-12 text-gray-400" />
                    </div>
                    <p class="text-xl font-semibold mb-2">No hairstyles found in this category.</p>
                    <p class="mb-6">Check back later for new styles!</p>
                    <button @click="setActiveCategory('all')" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                        View All Styles
                    </button>
                </div>
            </div>
        </section>

        <Transition name="modal-fade">
            <div v-if="showDetailModal" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/60 backdrop-blur-md" @click.self="closeDetailModal">
                <div class="bg-white rounded-2xl max-w-2xl w-full relative transform scale-95 transition-transform duration-300 overflow-hidden" :class="{ 'scale-100': showDetailModal }">
                    <button @click="closeDetailModal" class="absolute top-4 right-4 z-10 p-2 bg-white rounded-full shadow-lg hover:bg-gray-200 transition">
                        <X class="w-6 h-6 text-gray-700" />
                    </button>
                    <div v-if="selectedHairstyle" class="flex flex-col md:flex-row">
                        <div class="relative w-full md:w-1/2">
                            <img :src="selectedHairstyle.photo ? `/storage/${selectedHairstyle.photo}` : 'https://via.placeholder.com/400x500'" :alt="selectedHairstyle.name" class="w-full h-64 md:h-full object-cover" />
                            <div v-if="selectedHairstyle.is_featured" class="absolute top-4 right-4 bg-blue-600 text-white px-3 py-1 rounded-full text-xs font-bold flex items-center gap-1">
                                <Sparkles class="w-4 h-4" />
                                Trending
                            </div>
                        </div>
                        <div class="w-full md:w-1/2 p-8 flex flex-col justify-center">
                            <h3 class="text-3xl font-bold text-gray-900 mb-4">{{ selectedHairstyle.name }}</h3>
                            <p class="text-gray-600 leading-relaxed mb-6">
                                {{ selectedHairstyle.description }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </Transition>
    </MainLayout>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue';
import MainLayout from '@/layouts/MainLayout.vue';
import { Link } from '@inertiajs/vue3';
import { Sparkles, X, ArrowDown, ChevronDown, Scissors, Home } from 'lucide-vue-next';
import AOS from 'aos';
import 'aos/dist/aos.css';

interface Hairstyle {
    id: number;
    name: string;
    slug: string;
    description: string;
    photo: string | null;
    is_featured: boolean | number;
}
const props = defineProps<{
    hairstyles: Hairstyle[];
}>();

const activeCategory = ref('all');
const showDetailModal = ref(false);
const selectedHairstyle = ref<Hairstyle | null>(null);

const filteredHairstyles = computed(() => {
    if (!props.hairstyles) return [];
    if (activeCategory.value === 'trending') {
        return props.hairstyles.filter(h => h.is_featured);
    }
    return props.hairstyles;
});

const setActiveCategory = (category: 'all' | 'trending') => {
    activeCategory.value = category;
};

const openDetailModal = (hairstyle: Hairstyle) => {
    selectedHairstyle.value = hairstyle;
    showDetailModal.value = true;
};

const closeDetailModal = () => {
    showDetailModal.value = false;
};

const scrollToGallery = () => {
    const gallery = document.getElementById('gallery');
    if (gallery) {
        const offset = 64;
        const bodyRect = document.body.getBoundingClientRect().top;
        const elementRect = gallery.getBoundingClientRect().top;
        const elementPosition = elementRect - bodyRect;
        const offsetPosition = elementPosition - offset;

        window.scrollTo({
            top: offsetPosition,
            behavior: 'smooth'
        });
    }
};

onMounted(() => {
    AOS.init({
        duration: 1000,
        easing: 'ease-out-cubic',
        once: true,
        offset: 100
    });

    const particles = document.querySelectorAll('.particle');
    particles.forEach((particle: any) => {
        const size = Math.random() * 2 + 1;
        particle.style.width = `${size}px`;
        particle.style.height = `${size}px`;
        particle.style.top = `${Math.random() * 100}%`;
        particle.style.left = `${Math.random() * 100}%`;
        const duration = Math.random() * 5 + 4;
        const delay = Math.random() * 5;
        particle.style.animation = `twinkle ${duration}s ease-in-out infinite ${delay}s`;
    });
});
</script>

<style scoped>
.particles-container {
    pointer-events: none;
}

@keyframes twinkle {
    0%, 100% {
        transform: scale(0.5);
        opacity: 0.2;
    }
    50% {
        transform: scale(1);
        opacity: 0.8;
    }
}

.animated-gradient-bg {
    background: linear-gradient(90deg, #d946ef, #8b5cf6, #ec4899, #d946ef);
    background-size: 200% auto;
    animation: background-pan 3s linear infinite;
    padding: 2px;
    border-radius: 12px;
    box-sizing: border-box;
}

.animated-gradient-bg > span {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    justify-content: center;
    width: 100%;
    height: 100%;
    background-color: white;
    color: #374151;
    padding: 14px 32px;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
}


@keyframes background-pan {
    from {
        background-position: 200% center;
    }
    to {
        background-position: 0% center;
    }
}

.hero-section {
    background: linear-gradient(-45deg, #1f2937, #111827, #0f172a, #1e293b);
    background-size: 400% 400%;
    animation: gradient-shift 15s ease infinite;
}
@keyframes gradient-shift {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}
.hero-title {
    background: linear-gradient(45deg, #ffffff, #3b82f6, #ffffff);
    background-size: 200% 200%;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    animation: gradient-shift 3s ease infinite;
}
.floating-element-1,
.floating-element-2,
.floating-element-3 {
    animation: float 6s ease-in-out infinite;
}
.floating-element-2 { animation-delay: 2s; }
.floating-element-3 { animation-delay: 4s; }
@keyframes float {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    33% { transform: translateY(-10px) rotate(3deg); }
    66% { transform: translateY(-5px) rotate(-3deg); }
}
.scroll-indicator .scroll-dot {
    animation: scroll-bounce 1.5s infinite;
}
@keyframes scroll-bounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(10px); }
}
.gallery-enter-active,
.gallery-leave-active {
    transition: all 0.6s cubic-bezier(0.25, 0.8, 0.25, 1);
}
.gallery-enter-from { opacity: 0; transform: translateY(20px) scale(0.95); }
.gallery-leave-to { opacity: 0; transform: translateY(-20px) scale(0.95); }
.modal-fade-enter-active,
.modal-fade-leave-active {
    transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
}
.modal-fade-enter-from,
.modal-fade-leave-to { opacity: 0; transform: scale(0.9); }
.hero-btn-1,
.hero-btn-2 {
    position: relative;
    overflow: hidden;
}
.hero-btn-1::before,
.hero-btn-2::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
}
.hero-btn-1:hover::before,
.hero-btn-2:hover::before {
    left: 100%;
}
@media (max-width: 768px) {
    .floating-element-1,
    .floating-element-2,
    .floating-element-3 { opacity: 0.3; width: 40px; height: 40px; }
    .hero-title { font-size: 2.5rem; }
}
::-webkit-scrollbar { width: 6px; }
::-webkit-scrollbar-track { background: #f1f5f9; }
::-webkit-scrollbar-thumb { background: linear-gradient(to bottom, #6366f1, #374151); border-radius: 3px; }
::-webkit-scrollbar-thumb:hover { background: linear-gradient(to bottom, #4f46e5, #1f2937); }
</style>
