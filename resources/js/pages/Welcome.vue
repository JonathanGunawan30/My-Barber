<template>
    <MainLayout>
        <section id="home" class="relative min-h-screen flex items-center justify-center overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-gray-900 via-gray-800 to-black hero-bg">
                <div class="absolute inset-0 bg-black/40"></div>
                <div class="floating-element-1 absolute top-20 left-10 w-32 h-32 bg-blue-500/20 rounded-full blur-3xl"></div>
                <div class="floating-element-2 absolute bottom-20 right-10 w-48 h-48 bg-blue-600/20 rounded-full blur-3xl"></div>
                <div class="floating-element-3 absolute top-1/2 left-1/4 w-24 h-24 bg-purple-500/15 rounded-full blur-2xl"></div>
                <div class="particles-container absolute inset-0">
                    <div v-for="i in 20" :key="i" :class="`particle particle-${i}`" class="absolute w-2 h-2 bg-white/10 rounded-full"></div>
                </div>
            </div>
            <div class="relative z-10 text-center text-white px-4 max-w-4xl mx-auto hero-content">
                <div class="hero-title-container">
                    <h1 class="text-5xl md:text-7xl font-bold mb-6 leading-tight hero-title">
                        <span class="hero-word-1">Premium</span>
                        <br>
                        <span class="hero-word-2 bg-gradient-to-r from-blue-400 to-blue-600 bg-clip-text text-transparent">
                          Grooming
                        </span>
                        <br>
                        <span class="hero-word-3">Experience</span>
                    </h1>
                </div>
                <p class="text-xl md:text-2xl text-gray-300 mb-8 max-w-2xl mx-auto leading-relaxed hero-subtitle">
                    Transform your look with our expert barbers and premium services. Book your appointment today.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center hero-buttons">
                    <button @click="showAuthModal = true" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-xl font-semibold text-lg transition-all transform hover:scale-105 flex items-center justify-center gap-2 hero-btn-1">
                        <Calendar class="w-5 h-5" />
                        Book Appointment
                    </button>
                    <button @click="scrollToServices" class="border-2 border-white/30 hover:border-white text-white px-8 py-4 rounded-xl font-semibold text-lg transition-all hover:bg-white/10 flex items-center justify-center gap-2 hero-btn-2">
                        <ArrowDown class="w-5 h-5" />
                        Explore Services
                    </button>
                </div>
            </div>
            <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 scroll-indicator">
                <div class="w-6 h-10 border-2 border-white/30 rounded-full flex justify-center">
                    <div class="w-1 h-3 bg-white/60 rounded-full mt-2 scroll-dot"></div>
                </div>
                <ChevronDown class="w-6 h-6 text-white/60 mt-2 mx-auto animate-bounce" />
            </div>
        </section>

        <section id="services" class="py-20 bg-gray-50 services-section">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16 services-header">
                    <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4" data-aos="fade-up">Our Services</h2>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto" data-aos="fade-up" data-aos-delay="200">Professional grooming services tailored to your style and preferences</p>
                </div>
                <swiper
                    :modules="[Navigation, Pagination, Autoplay, EffectCoverflow]"
                    :slides-per-view="1"
                    :space-between="30"
                    :loop="true"
                    :autoplay="{ delay: 3000, disableOnInteraction: false }"
                    :effect="'coverflow'"
                    :coverflow-effect="{ rotate: 50, stretch: 0, depth: 100, modifier: 1, slideShadows: true }"
                    :navigation="{ nextEl: '.services-next', prevEl: '.services-prev' }"
                    :pagination="{ clickable: true, dynamicBullets: true }"
                    :breakpoints="{
                        640: {
                            slidesPerView: 2,
                            effect: 'slide',
                            spaceBetween: 20
                        },
                        1024: {
                            slidesPerView: 3,
                            effect: 'slide',
                            spaceBetween: 30
                        }
                    }"
                    class="services-swiper pb-12"
                    @swiper="onSwiperInit" >
                    <swiper-slide v-for="service in props.services" :key="service.id">
                        <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-500 transform hover:-translate-y-2 overflow-hidden group service-card h-full flex flex-col">
                            <div class="relative h-48 w-full service-card-media flex items-center justify-center">
                                <img v-if="service.photo" :src="`/storage/${service.photo}`" :alt="service.name" class="absolute inset-0 w-full h-full object-cover service-image" />
                                <div v-else class="absolute inset-0 bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center">
                                    <Scissors class="w-16 h-16 text-white/80 group-hover:scale-110 transition-transform duration-500 service-icon" />
                                </div>
                                <div class="absolute top-4 right-4 bg-white/20 backdrop-blur-sm rounded-full px-3 py-1 service-duration">
                                    <span class="text-white font-semibold text-sm">{{ service.duration }}min</span>
                                </div>
                                <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                            </div>
                            <div class="p-6 service-card-content flex-grow flex flex-col justify-between">
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900 mb-2 service-title">{{ service.name }}</h3>
                                    <p class="text-gray-600 mb-4 service-description">{{ service.description }}</p>
                                </div>
                                <div class="flex items-center justify-between service-footer">
                                    <span class="text-2xl font-bold text-blue-600 service-price">{{ formatRupiah(service.price) }}</span>
                                    <button @click="showServiceDetails(service)" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-all transform hover:scale-105 service-detail-btn">
                                        Detail
                                    </button>
                                </div>
                            </div>
                        </div>
                    </swiper-slide>
                    <div class="swiper-button-next services-next"></div>
                    <div class="swiper-button-prev services-prev"></div>
                    <div class="swiper-pagination services-pagination"></div>
                </swiper>
            </div>
        </section>

        <section id="branches" class="py-20 bg-white branches-section">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16 branches-header">
                    <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4" data-aos="fade-up">Our Locations</h2>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto" data-aos="fade-up" data-aos-delay="200">Find the nearest barbershop location to you</p>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
                    <div>
                        <TransitionGroup name="branch-list" tag="div" class="space-y-6 branches-list">
                            <div v-for="(branch, index) in displayedBranches" :key="branch.id"
                                 @click="selectBranch(branch)"
                                 class="bg-gray-50 rounded-2xl p-6 hover:bg-gray-100 transition-all duration-300 cursor-pointer border-2"
                                 :class="selectedBranch?.id === branch.id ? 'border-blue-500 scale-105 shadow-lg' : 'border-transparent hover:border-blue-200 transform hover:scale-[1.02]'"
                                 :data-aos="'fade-right'"
                                 :data-aos-delay="index * 100">
                                <div class="flex items-start gap-4">
                                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0 branch-icon transition-transform duration-300"
                                         :class="{ 'rotate-6 scale-110': selectedBranch?.id === branch.id }">
                                        <MapPin class="w-6 h-6 text-blue-600" />
                                    </div>
                                    <div class="flex-1 branch-info">
                                        <h3 class="text-xl font-bold text-gray-900 mb-2 branch-name">{{ branch.name }}</h3>
                                        <p class="text-gray-600 mb-3 branch-address">{{ branch.address }}</p>
                                        <div class="flex items-center gap-4 text-sm text-gray-500 branch-details">
                                            <span class="flex items-center gap-1">
                                              <Clock class="w-4 h-4" />
                                              Open 9AM - 9PM
                                            </span>
                                            <span class="flex items-center gap-1">
                                              <Phone class="w-4 h-4" />
                                              (555) 123-4567
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0 branch-status">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium"
                                              :class="branch.status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'">
                                            {{ branch.status === 'active' ? 'Open' : 'Closed' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </TransitionGroup>

                        <div v-if="props.branches && props.branches.length > 3" class="mt-6 text-center">
                            <button @click="toggleBranches"
                                    class="inline-flex items-center gap-2 text-blue-600 font-semibold hover:text-blue-800 transition-colors duration-300 group">
                                <span>{{ isBranchesExpanded ? 'Show Less' : 'Show All Locations' }}</span>
                                <ChevronsUpDown class="w-4 h-4 transition-transform duration-300" :class="{ 'rotate-180': isBranchesExpanded }" />
                            </button>
                        </div>
                    </div>

                    <div class="bg-gray-200 rounded-2xl h-96 lg:h-full sticky top-24 map-container" data-aos="fade-left">
                        <iframe
                            v-if="mapSrc"
                            :key="selectedBranch?.id"
                            :src="mapSrc"
                            width="100%"
                            height="100%"
                            style="border:0;"
                            allow="fullscreen"
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            class="rounded-2xl transition-opacity duration-500 opacity-0"
                            @load="onIframeLoad">
                        </iframe>
                        <div v-else class="text-center text-gray-500 flex items-center justify-center h-full">
                            <div>
                                <MapPin class="w-12 h-12 mx-auto mb-4 map-icon" />
                                <p class="text-lg font-medium">Loading Map...</p>
                                <p class="text-sm">Please ensure API Key is set.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="testimonials" class="py-20 bg-gray-50 testimonials-section">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16 testimonials-header">
                    <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4" data-aos="fade-up">What Our Clients Say</h2>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto" data-aos="fade-up" data-aos-delay="200">Real reviews from satisfied customers</p>
                </div>

                <div class="marquee-container relative overflow-hidden py-4 h-auto">
                    <div class="marquee-content marquee-single-row">
                        <div v-for="testimonial in duplicatedTestimonials" :key="testimonial.uniqueId"
                             class="testimonial-card flex-shrink-0 w-[380px] min-h-[200px] bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-500 transform hover:-translate-y-2 h-full border-2 border-transparent">
                            <div class="flex items-center gap-1 mb-4 testimonial-rating">
                                <Star v-for="i in 5" :key="i"
                                      class="w-5 h-5 star-icon"
                                      :class="i <= testimonial.rating ? 'text-yellow-400 fill-current' : 'text-gray-300'" />
                            </div>
                            <p class="text-gray-700 mb-6 italic testimonial-comment">"{{ testimonial.comment }}"</p>
                            <div class="flex items-center gap-3 testimonial-author">
                                <div class="w-12 h-12 rounded-full flex-shrink-0 author-avatar overflow-hidden">
                                    <img v-if="testimonial.customer?.avatar" :src="`/storage/${testimonial.customer.avatar}`" :alt="testimonial.customer.name" class="w-full h-full object-cover" />
                                    <div v-else class="w-full h-full bg-gray-300 flex items-center justify-center">
                                        <User class="w-6 h-6 text-gray-600" />
                                    </div>
                                </div>
                                <div class="author-info">
                                    <p class="font-semibold text-gray-900 author-name">{{ testimonial.customer?.name }}</p>
                                    <p class="text-sm text-gray-500 author-label">Verified Customer</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pointer-events-none absolute inset-y-0 left-0 w-1/4 bg-gradient-to-r from-gray-50 z-10"></div>
                    <div class="pointer-events-none absolute inset-y-0 right-0 w-1/4 bg-gradient-to-l from-gray-50 z-10"></div>
                </div>
            </div>
        </section>

        <section class="py-20 bg-gradient-to-r from-blue-600 to-blue-700 cta-section">
            <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8 cta-content">
                <h2 class="text-4xl md:text-5xl font-bold text-white mb-6 cta-title" data-aos="zoom-in">Ready for Your New Look?</h2>
                <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto cta-subtitle" data-aos="zoom-in" data-aos-delay="200">
                    Book your appointment today and experience the difference of premium grooming services.
                </p>
                <button @click="showAuthModal = true"
                        class="bg-white hover:bg-gray-100 text-blue-600 px-8 py-4 rounded-xl font-semibold text-lg transition-all transform hover:scale-105 inline-flex items-center gap-2 cta-button"
                        data-aos="zoom-in" data-aos-delay="400">
                    <Calendar class="w-5 h-5" />
                    Book Your Appointment
                </button>
            </div>
        </section>

        <ServiceDetailModalClient
            :is-open="showServiceDetailModal"
            :service="selectedServiceForDisplay"
            @close="showServiceDetailModal = false"
        />
    </MainLayout>
</template>

<script setup lang="ts">
import { ref, onMounted, nextTick, computed } from 'vue'
import { gsap } from 'gsap'
import { ScrollTrigger } from 'gsap/ScrollTrigger'
import AOS from 'aos'
import { Swiper, SwiperSlide } from 'swiper/vue';
import type { Swiper as SwiperClass } from 'swiper'
import { Navigation, Pagination, Autoplay, EffectCoverflow } from 'swiper/modules';
import 'swiper/css'
import 'swiper/css/navigation'
import 'swiper/css/pagination'
import 'swiper/css/effect-coverflow'
import 'aos/dist/aos.css'

import MainLayout from '@/layouts/MainLayout.vue'

import ServiceDetailModalClient from '@/components/service/client/ServiceDetailModal.vue';
import {
    Scissors, Calendar, ArrowDown, ChevronDown, MapPin, Clock, Phone,
    Star, User, ChevronsUpDown,
} from 'lucide-vue-next'

gsap.registerPlugin(ScrollTrigger)

const props = defineProps<{
    services?: Array<{
        id: number;
        name: string;
        description: string;
        price: number;
        duration: number;
        photo: string | null;
    }>;
    branches?: Array<{
        id: number;
        name: string;
        address: string;
        status: string;
        photo: string | null;
    }>;
    testimonials?: Array<{
        id: number;
        customer: {
            name: string;
            avatar: string;
        };
        username: string;
        comment: string;
        rating: number;
    }>;
}>();

const mySwiper = ref<SwiperClass | null>(null)
const onSwiperInit = (swiperInstance: any) => {
    mySwiper.value = swiperInstance;
};

const selectedBranch = ref<NonNullable<typeof props.branches>[number] | null>(null);
const isBranchesExpanded = ref(false);

const displayedBranches = computed(() => {
    if (!props.branches) return [];
    if (isBranchesExpanded.value || props.branches.length <= 3) {
        return props.branches;
    }
    return props.branches.slice(0, 3);
});

const mapApiKey = import.meta.env.VITE_GOOGLE_MAPS_API_KEY;

const mapSrc = computed(() => {
    if (!mapApiKey) {
        console.error("GOOGLE MAPS API KEY NOT FOUND");
        return '';
    }
    const baseUrl = 'https://www.google.com/maps/embed/v1/place';
    let query = 'Tangerang, Banten, Indonesia';

    if (selectedBranch.value) {
        query = `${selectedBranch.value.address}`;
    }

    return `${baseUrl}?key=${mapApiKey}&q=${encodeURIComponent(query)}`;
});

const selectBranch = (branch: NonNullable<typeof props.branches>[number]) => {
    selectedBranch.value = branch;
};

const toggleBranches = () => {
    isBranchesExpanded.value = !isBranchesExpanded.value;
};

const onIframeLoad = (event: Event) => {
    const iframe = event.target as HTMLIFrameElement;
    if (iframe) {
        iframe.style.opacity = '1';
    }
};

const showServiceDetailModal = ref(false);
const selectedServiceForDisplay = ref<NonNullable<typeof props.services>[number] | null>(null);

const duplicatedTestimonials = computed(() => {
    if (!props.testimonials || props.testimonials.length === 0) {
        return [];
    }
    const duplicated: (typeof props.testimonials[number] & { uniqueId: string })[] = [];
    for (let i = 0; i < 5; i++) {
        props.testimonials.forEach((testimonial) => {
            duplicated.push({
                ...testimonial,
                uniqueId: `${testimonial.id}-${i}-${Math.random().toString(36).substring(7)}`
            });
        });
    }
    return duplicated;
});

const scrollToServices = () => {
    document.getElementById('services')?.scrollIntoView({ behavior: 'smooth' })
}
const showServiceDetails = (service: NonNullable<typeof props.services>[number]) => {
    selectedServiceForDisplay.value = service;
    showServiceDetailModal.value = true;
};

const formatRupiah = (amount: number) => {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    }).format(amount)
}

const initPageAnimations = () => {
    const heroTl = gsap.timeline();
    heroTl.from('.hero-word-1', { x: -100, opacity: 0, duration: 1, ease: "power3.out" })
        .from('.hero-word-2', { scale: 0, opacity: 0, duration: 1, ease: "back.out(1.7)" }, "-=0.5")
        .from('.hero-word-3', { x: 100, opacity: 0, duration: 1, ease: "power3.out" }, "-=0.5")
        .from('.hero-subtitle', { y: 30, opacity: 0, duration: 0.8, ease: "power2.out" }, "-=0.3")
        .from('.hero-btn-1', { scale: 0, rotation: 180, duration: 0.8, ease: "back.out(1.7)" }, "-=0.2")
        .from('.hero-btn-2', { scale: 0, rotation: -180, duration: 0.8, ease: "back.out(1.7)" }, "-=0.6");

    gsap.to('.floating-element-1', { y: -20, x: 20, rotation: 10, duration: 4, repeat: -1, yoyo: true, ease: "power1.inOut" });
    gsap.to('.floating-element-2', { y: 20, x: -20, rotation: -10, duration: 5, repeat: -1, yoyo: true, ease: "power1.inOut" });
    gsap.to('.floating-element-3', { y: -15, x: 15, rotation: 15, duration: 3, repeat: -1, yoyo: true, ease: "power1.inOut" });
    gsap.set('.particle', { x: () => Math.random() * window.innerWidth, y: () => Math.random() * window.innerHeight, opacity: () => Math.random() * 0.5 + 0.1 });
    gsap.to('.particle', { y: '-=100', duration: () => Math.random() * 3 + 2, repeat: -1, ease: "none", stagger: { each: 0.2, repeat: -1 } });
    gsap.to('.scroll-dot', { y: 20, duration: 1.5, repeat: -1, yoyo: true, ease: "power2.inOut" });
}

onMounted(() => {
    AOS.init({ duration: 1000, easing: 'ease-out-cubic', once: true, offset: 100 });

    nextTick(() => {
        initPageAnimations();
    });

    if (props.branches && props.branches.length > 0) {
        selectBranch(props.branches[0]);
    }

    const handleResize = () => {
        if (mySwiper.value) {
            mySwiper.value?.update();
        }
    };
    window.addEventListener('resize', handleResize);
});
</script>

<style scoped>
.service-card {
    height: 100%;
    display: flex;
    flex-direction: column;
}

.service-card-media {
    height: 12rem;
    flex-shrink: 0;
}

.service-card-content {
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.swiper-button-next,
.swiper-button-prev {
    color: #3B82F6;
    background: white;
    width: 44px;
    height: 44px;
    border-radius: 50%;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.swiper-button-next:hover,
.swiper-button-prev:hover {
    background: #3B82F6;
    color: white;
    transform: scale(1.1);
}

.swiper-button-next::after,
.swiper-button-prev::after {
    font-size: 16px;
    font-weight: bold;
}

.marquee-container {
    mask-image: linear-gradient(to right, transparent, black 8%, black 92%, transparent);
    overflow: hidden;
    height: auto;
    display: flex;
    flex-direction: column;
    padding-bottom: 2rem;
}

.marquee-content {
    display: flex;
    white-space: nowrap;
    animation: marquee-horizontal linear infinite;
    gap: 2rem;
    padding-left: 2rem;
    padding-right: 2rem;
}

.marquee-single-row {
    animation-duration: 25s;
    animation-direction: normal;
}

.marquee-content:hover {
    animation-play-state: paused;
}

.testimonial-card {
    flex-shrink: 0;
    width: 380px;
    min-width: 380px;
    min-height: 200px;
    height: auto;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    border: 2px solid transparent;
    transition: all 0.3s ease;
    box-sizing: border-box;
}

.testimonial-comment {
    max-height: 100px;
    text-overflow: ellipsis;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 4;
    -webkit-box-orient: vertical;
    white-space: normal;
}

.testimonial-card:hover {
    border-color: #3B82F6;
}

@keyframes marquee-horizontal {
    0% { transform: translateX(0); }
    100% { transform: translateX(calc(-100% - 2rem)); }
}

@keyframes float {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-20px) rotate(5deg); }
}

@keyframes pulse-glow {
    0%, 100% { box-shadow: 0 0 20px rgba(59, 130, 246, 0.3); }
    50% { box-shadow: 0 0 40px rgba(59, 130, 246, 0.6); }
}

@keyframes gradient-shift {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

.hero-bg {
    background: linear-gradient(-45deg, #1f2937, #111827, #0f172a, #1e293b);
    background-size: 400% 400%;
    animation: gradient-shift 15s ease infinite;
}

.service-card:hover .service-icon {
    animation: float 2s ease-in-out infinite;
}

.service-card:hover {
    animation: pulse-glow 2s ease-in-out infinite;
}

.branch-card:hover .branch-icon {
    transform: scale(1.2) rotate(10deg);
    transition: all 0.3s ease;
}

.star-icon {
    transition: all 0.3s ease;
}

.testimonial-card:hover .star-icon {
    transform: scale(1.1);
}

.particles-container {
    pointer-events: none;
}

.service-card-media::before,
.branch-icon::before,
.author-avatar::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
}

.service-card:hover .service-card-media::before,
.branch-card:hover .branch-icon::before,
.testimonial-card:hover .author-avatar::before {
    left: 100%;
}

.hero-btn-1,
.hero-btn-2,
.service-detail-btn,
.cta-button {
    position: relative;
    overflow: hidden;
}

.hero-btn-1::before,
.hero-btn-2::before,
.service-detail-btn::before,
.cta-button::before {
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
.hero-btn-2:hover::before,
.service-detail-btn:hover::before,
.cta-button:hover::before {
    left: 100%;
}

.hero-title,
.services-header h2,
.branches-header h2,
.testimonials-header h2,
.cta-title {
    background: linear-gradient(45deg, #ffffff, #0b5adc, #ffffff);
    background-size: 200% 200%;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    animation: gradient-shift 3s ease infinite;
}

@media (max-width: 768px) {
    .floating-element-1,
    .floating-element-2,
    .floating-element-3 {
        opacity: 0.3;
    }
}
</style>
