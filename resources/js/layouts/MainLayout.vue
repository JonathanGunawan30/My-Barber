<template>
    <div class="min-h-screen bg-white overflow-x-hidden">
        <nav ref="navbar" class="fixed top-0 left-0 right-0 z-50 bg-white/90 backdrop-blur-md border-b border-gray-200 transform -translate-y-full">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center gap-3 logo-container">
                        <Link href="/" class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl flex items-center justify-center logo-icon">
                                <Scissors class="w-5 h-5 text-white" />
                            </div>
                            <div class="logo-text">
                                <h1 class="font-bold text-gray-900 text-lg">BarberShop</h1>
                                <p class="text-xs text-gray-500 -mt-1">Premium Grooming</p>
                            </div>
                        </Link>
                    </div>

                    <div class="hidden md:flex items-center space-x-8 nav-links">
                        <a href="/#home" @click.prevent="handleNavClick('home')" class="text-gray-700 hover:text-blue-600 font-medium transition-colors nav-link">Home</a>
                        <a href="/#services" @click.prevent="handleNavClick('services')" class="text-gray-700 hover:text-blue-600 font-medium transition-colors nav-link">Services</a>
                        <a href="/#branches" @click.prevent="handleNavClick('branches')" class="text-gray-700 hover:text-blue-600 font-medium transition-colors nav-link">Locations</a>
                        <a href="/#testimonials" @click.prevent="handleNavClick('testimonials')" class="text-gray-700 hover:text-blue-600 font-medium transition-colors nav-link">Reviews</a>
                        <Link href="/hairstyles" class="text-gray-700 hover:text-blue-600 font-medium transition-colors nav-link">Hairstyles</Link>

                        <div v-if="$page.props.auth.customer" class="flex items-center gap-4">
                            <Link href="/dashboard" class="flex items-center gap-2 text-gray-700 font-medium transition-colors group">
                                <div class="w-8 h-8 rounded-full border-2 border-transparent group-hover:border-blue-500 overflow-hidden flex items-center justify-center bg-gray-200">
                                    <img
                                        v-if="$page.props.auth.customer.avatar"
                                        :src="$page.props.auth.customer.avatar"
                                        class="w-full h-full object-cover"
                                        alt="Avatar"
                                    >
                                    <User v-else class="w-5 h-5 text-gray-500" />
                                </div>
                                <span class="group-hover:text-blue-600">
                                    {{ $page.props.auth.customer.name.split(' ')[0] }}
                                </span>
                            </Link>

                            <Link :href="route('logout.customer')" method="post" as="button" class="bg-gray-200 hover:bg-red-500 hover:text-white text-gray-700 px-4 py-2 rounded-lg font-medium transition-colors text-sm">
                                Logout
                            </Link>
                        </div>


                        <div v-else>
                            <button @click="showAuthModal = true" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-all transform hover:scale-105 book-btn">
                                Book Now
                            </button>
                        </div>
                    </div>

                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden p-2 rounded-lg hover:bg-gray-100 mobile-menu-btn">
                        <Menu v-if="!mobileMenuOpen" class="w-6 h-6 text-gray-700" />
                        <X v-else class="w-6 h-6 text-gray-700" />
                    </button>
                </div>

                <div v-if="mobileMenuOpen" class="md:hidden py-4 border-t border-gray-200 mobile-nav">
                    <div class="space-y-3">
                        <a href="/#home" @click.prevent="handleNavClick('home'); mobileMenuOpen = false;" class="block text-gray-700 hover:text-blue-600 font-medium py-2 mobile-nav-link">Home</a>
                        <a href="/#services" @click.prevent="handleNavClick('services'); mobileMenuOpen = false;" class="block text-gray-700 hover:text-blue-600 font-medium py-2 mobile-nav-link">Services</a>
                        <a href="/#branches" @click.prevent="handleNavClick('branches'); mobileMenuOpen = false;" class="block text-gray-700 hover:text-blue-600 font-medium py-2 mobile-nav-link">Locations</a>
                        <a href="/#testimonials" @click.prevent="handleNavClick('testimonials'); mobileMenuOpen = false;" class="block text-gray-700 hover:text-blue-600 font-medium py-2 mobile-nav-link">Reviews</a>
                        <Link href="/hairstyles" @click="mobileMenuOpen = false;" class="block text-gray-700 hover:text-blue-600 font-medium py-2 mobile-nav-link">Hairstyles</Link>

                        <div v-if="$page.props.auth.customer" class="pt-4 border-t">
                            <Link href="/dashboard" @click="mobileMenuOpen = false" class="flex items-center gap-3 text-gray-700 font-medium py-2">
                                <img :src="$page.props.auth.customer.avatar" class="w-8 h-8 rounded-full" alt="Avatar">
                                <span>Dashboard</span>
                            </Link>
                            <Link :href="route('logout.customer')" method="post" as="button" class="w-full text-left bg-gray-200 hover:bg-red-500 hover:text-white text-gray-700 px-4 py-3 mt-2 rounded-lg font-medium transition-colors">
                                Logout
                            </Link>
                        </div>

                        <button v-else @click="showAuthModal = true; mobileMenuOpen = false" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors mobile-book-btn">
                            Book Now
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <main>
            <slot />
        </main>

        <footer class="bg-gray-900 text-white footer-section">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12">
                    <div class="lg:col-span-2 footer-company" data-aos="fade-up">
                        <div class="flex items-center gap-3 mb-6 footer-logo">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                                <Scissors class="w-6 h-6 text-white" />
                            </div>
                            <div>
                                <h3 class="font-bold text-xl text-white">BarberShop</h3>
                                <p class="text-sm text-blue-200">Premium Grooming Experience</p>
                            </div>
                        </div>
                        <p class="text-gray-300 mb-6 max-w-md leading-relaxed footer-description">
                            Your premier destination for professional grooming services. We combine traditional barbering techniques with modern style to deliver an exceptional experience that leaves you looking and feeling your best.
                        </p>
                        <div class="flex gap-4 footer-social">
                            <a href="https://facebook.com/#" target="_blank" aria-label="Facebook"
                               class="w-12 h-12 bg-gray-800 rounded-xl flex items-center justify-center hover:bg-blue-600 cursor-pointer transition-all duration-300 transform hover:scale-110 hover:shadow-lg social-icon group">
                                <i class="fab fa-facebook text-2xl"></i>
                            </a>
                            <a href="https://instagram.com/#" target="_blank" aria-label="Instagram"
                               class="w-12 h-12 bg-gray-800 rounded-xl flex items-center justify-center hover:bg-pink-600 cursor-pointer transition-all duration-300 transform hover:scale-110 hover:shadow-lg social-icon group">
                                <i class="fab fa-instagram text-2xl"></i>
                            </a>
                            <a href="https://x.com/#" target="_blank" aria-label="X"
                               class="w-12 h-12 bg-gray-800 rounded-xl flex items-center justify-center hover:bg-gray-950 cursor-pointer transition-all duration-300 transform hover:scale-110 hover:shadow-lg social-icon group">
                                <i class="fab fa-x-twitter text-2xl"></i>
                            </a>
                            <a href="https://linkedin.com/#" target="_blank" aria-label="LinkedIn"
                               class="w-12 h-12 bg-gray-800 rounded-xl flex items-center justify-center hover:bg-blue-700 cursor-pointer transition-all duration-300 transform hover:scale-110 hover:shadow-lg social-icon group">
                                <i class="fab fa-linkedin text-2xl"></i>
                            </a>
                            <a href="https://threads.com/#" target="_blank" aria-label="Threads"
                               class="w-12 h-12 bg-gray-800 rounded-xl flex items-center justify-center hover:bg-white hover:text-black cursor-pointer transition-all duration-300 transform hover:scale-110 hover:shadow-lg social-icon group">
                                <i class="fab fa-threads text-2xl"></i>
                            </a>
                        </div>
                    </div>

                    <div class="footer-links" data-aos="fade-up" data-aos-delay="200">
                        <h4 class="font-bold text-lg mb-6 text-white">Quick Links</h4>
                        <div class="space-y-3">
                            <a href="#services" @click.prevent="handleNavClick('services')" class="block text-gray-300 hover:text-blue-400 transition-colors duration-300 no-underline footer-link">Services</a>
                            <a href="#branches" @click.prevent="handleNavClick('branches')" class="block text-gray-300 hover:text-blue-400 transition-colors duration-300 no-underline footer-link">Locations</a>
                            <a href="#testimonials" @click.prevent="handleNavClick('testimonials')" class="block text-gray-300 hover:text-blue-400 transition-colors duration-300 no-underline footer-link">Reviews</a>
                            <a href="#" class="block text-gray-300 hover:text-blue-400 transition-colors duration-300 no-underline footer-link">About Us</a>
                            <a href="#" class="block text-gray-300 hover:text-blue-400 transition-colors duration-300 no-underline footer-link">Careers</a>
                            <a href="#" class="block text-gray-300 hover:text-blue-400 transition-colors duration-300 no-underline footer-link">Gift Cards</a>
                        </div>
                    </div>

                    <div class="footer-contact" data-aos="fade-up" data-aos-delay="400">
                        <h4 class="font-bold text-lg mb-6 text-white">Get In Touch</h4>
                        <div class="space-y-4">
                            <div class="flex items-start gap-3 contact-item group">
                                <div class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:bg-blue-600 transition-colors duration-300">
                                    <Phone class="w-4 h-4 text-gray-300 group-hover:text-white" />
                                </div>
                                <div>
                                    <p class="text-gray-300 group-hover:text-white transition-colors duration-300">(021) 1234 1234</p>
                                    <p class="text-sm text-gray-400">Mon - Sat: 9AM - 9PM</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3 contact-item group">
                                <div class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:bg-blue-600 transition-colors duration-300">
                                    <Mail class="w-4 h-4 text-gray-300 group-hover:text-white" />
                                </div>
                                <div>
                                    <p class="text-gray-300 group-hover:text-white transition-colors duration-300">info@barbershop.com</p>
                                    <p class="text-sm text-gray-400">We'll respond within 24hrs</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3 contact-item group">
                                <div class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:bg-blue-600 transition-colors duration-300">
                                    <MapPin class="w-4 h-4 text-gray-300 group-hover:text-white" />
                                </div>
                                <div>
                                    <p class="text-gray-300 group-hover:text-white transition-colors duration-300">Jalan Belum Ada</p>
                                    <p class="text-sm text-gray-400">Tangerang, Banten, Indonesia</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-800">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                    <div class="flex flex-col items-center justify-center text-center">
                        <p class="text-gray-400 mb-1">© 2025 BarberShop. All rights reserved.</p>
                        <p class="text-sm text-gray-500">
                            Developed by <a href="https://www.instagram.com/jo.nthn30" target="_blank" class="text-blue-400 hover:text-blue-300 transition-colors duration-300">Jonathan Gunawan</a>
                        </p>
                    </div>
                </div>
            </div>
        </footer>

        <AuthModal :is-open="showAuthModal" @close="showAuthModal = false" />

    </div>
</template>

<script setup lang="ts">
import { ref, onMounted, nextTick } from 'vue'
import { gsap } from 'gsap'
import { Link, router } from '@inertiajs/vue3'
import AuthModal from '@/Components/auth/AuthModal.vue';
import { Menu, X, Scissors, Phone, Mail, MapPin, User } from 'lucide-vue-next'
import '@fortawesome/fontawesome-free/css/all.min.css'

const mobileMenuOpen = ref(false)
const showAuthModal = ref(false)
const navbar = ref<HTMLElement | null>(null)
const scrollToSection = (id: string, cleanUrl: boolean = false) => {
    const element = document.getElementById(id);
    if (element) {
        const offset = 64;
        const bodyRect = document.body.getBoundingClientRect().top;
        const elementRect = element.getBoundingClientRect().top;
        const elementPosition = elementRect - bodyRect;
        const offsetPosition = elementPosition - offset;

        window.scrollTo({
            top: offsetPosition,
            behavior: 'smooth'
        });

        if (cleanUrl) {
            setTimeout(() => {
                history.replaceState(null, '', window.location.pathname + window.location.search);
            }, 500);
        }
    }
}

const handleNavClick = (sectionId: string) => {
    const targetElement = document.getElementById(sectionId);

    if (targetElement) {
        scrollToSection(sectionId, true);
    } else {
        router.visit(`/#${sectionId}`);
    }
}
onMounted(() => {
    gsap.to(navbar.value, { y: 0, duration: 1, ease: "power3.out", delay: 0.5 });
    gsap.from('.logo-icon', { rotation: 360, scale: 0, duration: 1, ease: "back.out(1.7)", delay: 1 });
    gsap.from('.nav-link', { y: -20, opacity: 0, duration: 0.6, stagger: 0.1, ease: "power2.out", delay: 1.2 });

    nextTick(() => {
        const hash = window.location.hash;
        if (hash) {
            const id = hash.substring(1);
            setTimeout(() => {
                scrollToSection(id, true);
            }, 100);
        }
    });
})
</script>

<style scoped>
html {
    scroll-behavior: smooth;
}

::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f5f9;
}

::-webkit-scrollbar-thumb {
    background: linear-gradient(to bottom, #3B82F6, #1D4ED8);
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(to bottom, #2563EB, #1E40AF);
}

button:focus,
a:focus,
input:focus {
    outline: 2px solid #3B82F6;
    outline-offset: 2px;
}

.auth-modal-overlay {
    backdrop-filter: blur(10px);
}

.footer-section {
    background: linear-gradient(135deg, #111827 0%, #1f2937 100%);
}

.social-icon {
    backdrop-filter: blur(10px);
}

.contact-item {
    transition: all 0.3s ease;
}

.contact-item:hover {
    transform: translateX(5px);
}

.footer-link {
    position: relative;
}

.footer-link::after {
    content: '';
    position: absolute;
    width: 0;
    height: 2px;
    bottom: -2px;
    left: 0;
    background: linear-gradient(90deg, #3B82F6, #60A5FA);
    transition: width 0.3s ease;
}

.footer-link:hover::after {
    width: 100%;
}
</style>
