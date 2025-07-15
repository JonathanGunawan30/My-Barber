<template>
    <div class="min-h-screen bg-white overflow-x-hidden">
        <nav ref="navbar" class="fixed top-0 left-0 right-0 z-50 bg-white/90 backdrop-blur-md border-b border-gray-200 transform -translate-y-full">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center gap-3 logo-container">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl flex items-center justify-center logo-icon">
                            <Scissors class="w-5 h-5 text-white" />
                        </div>
                        <div class="logo-text">
                            <h1 class="font-bold text-gray-900 text-lg">BarberShop</h1>
                            <p class="text-xs text-gray-500 -mt-1">Premium Grooming</p>
                        </div>
                    </div>
                    <div class="hidden md:flex items-center space-x-8 nav-links">
                        <a href="#home" @click.prevent="scrollToSection('home')" class="text-gray-700 hover:text-blue-600 font-medium transition-colors nav-link">Home</a>
                        <a href="#services" @click.prevent="scrollToSection('services')" class="text-gray-700 hover:text-blue-600 font-medium transition-colors nav-link">Services</a>
                        <a href="#branches" @click.prevent="scrollToSection('branches')" class="text-gray-700 hover:text-blue-600 font-medium transition-colors nav-link">Locations</a>
                        <a href="#testimonials" @click.prevent="scrollToSection('testimonials')" class="text-gray-700 hover:text-blue-600 font-medium transition-colors nav-link">Reviews</a>
                        <button @click="showAuthModal = true" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-all transform hover:scale-105 book-btn">
                            Book Now
                        </button>
                    </div>
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden p-2 rounded-lg hover:bg-gray-100 mobile-menu-btn">
                        <Menu v-if="!mobileMenuOpen" class="w-6 h-6 text-gray-700" />
                        <X v-else class="w-6 h-6 text-gray-700" />
                    </button>
                </div>
                <div v-if="mobileMenuOpen" class="md:hidden py-4 border-t border-gray-200 mobile-nav">
                    <div class="space-y-3">
                        <a href="#home" @click.prevent="scrollToSection('home'); mobileMenuOpen = false;" class="block text-gray-700 hover:text-blue-600 font-medium py-2 mobile-nav-link">Home</a>
                        <a href="#services" @click.prevent="scrollToSection('services'); mobileMenuOpen = false;" class="block text-gray-700 hover:text-blue-600 font-medium py-2 mobile-nav-link">Services</a>
                        <a href="#branches" @click.prevent="scrollToSection('branches'); mobileMenuOpen = false;" class="block text-gray-700 hover:text-blue-600 font-medium py-2 mobile-nav-link">Locations</a>
                        <a href="#testimonials" @click.prevent="scrollToSection('testimonials'); mobileMenuOpen = false;" class="block text-gray-700 hover:text-blue-600 font-medium py-2 mobile-nav-link">Reviews</a>
                        <button @click="showAuthModal = true" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors mobile-book-btn">
                            Book Now
                        </button>
                    </div>
                </div>
            </div>
        </nav>

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
                    class="services-swiper"
                    @swiper="onSwiperInit" >
                    <swiper-slide v-for="service in services" :key="service.id">
                        <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-500 transform hover:-translate-y-2 overflow-hidden group service-card h-full">
                            <div class="relative h-48 bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center service-card-header">
                                <Scissors class="w-16 h-16 text-white/80 group-hover:scale-110 transition-transform duration-500 service-icon" />
                                <div class="absolute top-4 right-4 bg-white/20 backdrop-blur-sm rounded-full px-3 py-1 service-duration">
                                    <span class="text-white font-semibold text-sm">{{ service.duration }}min</span>
                                </div>
                                <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                            </div>
                            <div class="p-6 service-card-content">
                                <h3 class="text-xl font-bold text-gray-900 mb-2 service-title">{{ service.name }}</h3>
                                <p class="text-gray-600 mb-4 service-description">{{ service.description }}</p>
                                <div class="flex items-center justify-between service-footer">
                                    <span class="text-2xl font-bold text-blue-600 service-price">${{ service.price }}</span>
                                    <button @click="selectService(service)" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-all transform hover:scale-105 service-select-btn">
                                        Select
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
                    <div class="space-y-6 branches-list">
                        <div v-for="(branch, index) in branches" :key="branch.id"
                             @click="selectBranch(branch)"
                             class="bg-gray-50 rounded-2xl p-6 hover:bg-gray-100 transition-all duration-500 cursor-pointer border-2 border-transparent hover:border-blue-200 transform hover:scale-105 branch-card"
                             :data-aos="'fade-right'"
                             :data-aos-delay="index * 100">
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0 branch-icon">
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
                    </div>
                    <div class="bg-gray-200 rounded-2xl h-96 flex items-center justify-center map-container" data-aos="fade-left">
                        <div class="text-center text-gray-500 map-placeholder">
                            <MapPin class="w-12 h-12 mx-auto mb-4 map-icon" />
                            <p class="text-lg font-medium">Interactive Map</p>
                            <p class="text-sm">Google Maps integration will be displayed here</p>
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
                                <div class="w-12 h-12 bg-gray-300 rounded-full flex items-center justify-center author-avatar">
                                    <User class="w-6 h-6 text-gray-600" />
                                </div>
                                <div class="author-info">
                                    <p class="font-semibold text-gray-900 author-name">{{ testimonial.customer_name }}</p>
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
                            <a href="https://facebook.com/barbershop" target="_blank" aria-label="Facebook"
                               class="w-12 h-12 bg-gray-800 rounded-xl flex items-center justify-center hover:bg-blue-600 cursor-pointer transition-all duration-300 transform hover:scale-110 hover:shadow-lg social-icon group">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="text-gray-300 group-hover:text-white w-5 h-5 transition-colors">
                                    <path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.811c-3.211 0-4.189 1.237-4.189 4.004v1.996z"/>
                                </svg>
                            </a>
                            <a href="https://instagram.com/barbershop" target="_blank" aria-label="Instagram"
                               class="w-12 h-12 bg-gray-800 rounded-xl flex items-center justify-center hover:bg-pink-600 cursor-pointer transition-all duration-300 transform hover:scale-110 hover:shadow-lg social-icon group">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="text-gray-300 group-hover:text-white w-5 h-5 transition-colors">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.204-.012 3.584-.069 4.85-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.069-4.85.069-3.204 0-3.584-.012-4.85-.069-3.252-.149-4.771-1.692-4.919-4.919-.058-1.265-.069-1.645-.069-4.849 0-3.204.012-3.584.069-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.85-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.073 4.948.073 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.689-.073-4.949-.073zM12 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.162 6.162 6.162 6.162-2.759 6.162-6.162c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4s1.791-4 4-4 4 1.79 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                </svg>
                            </a>
                            <a href="https://twitter.com/barbershop" target="_blank" aria-label="Twitter"
                               class="w-12 h-12 bg-gray-800 rounded-xl flex items-center justify-center hover:bg-blue-500 cursor-pointer transition-all duration-300 transform hover:scale-110 hover:shadow-lg social-icon group">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="text-gray-300 group-hover:text-white w-5 h-5 transition-colors">
                                    <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.414 0-6.182 2.76-6.182 6.182 0 .485.055.954.126 1.404-5.148-.258-9.717-2.723-12.77-6.463-.538.927-.848 2.005-.848 3.143 0 2.148 1.093 4.022 2.757 5.127-.806-.026-1.566-.247-2.231-.616v.077c0 2.992 2.13 5.485 4.945 6.06-.518.14-1.066.216-1.635.216-.4 0-.79-.038-1.169-.11 4.966 1.956 10.296-.44 12.636-5.467 0-.214.008-.429.008-.642.345-.249.66-.523.957-.834z"/>
                                </svg>
                            </a>
                            <a href="https://linkedin.com/company/barbershop" target="_blank" aria-label="LinkedIn"
                               class="w-12 h-12 bg-gray-800 rounded-xl flex items-center justify-center hover:bg-blue-700 cursor-pointer transition-all duration-300 transform hover:scale-110 hover:shadow-lg social-icon group">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="text-gray-300 group-hover:text-white w-5 h-5 transition-colors">
                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <div class="footer-links" data-aos="fade-up" data-aos-delay="200">
                        <h4 class="font-bold text-lg mb-6 text-white">Quick Links</h4>
                        <div class="space-y-3">
                            <a href="#services" class="block text-gray-300 hover:text-blue-400 transition-colors duration-300 no-underline footer-link">Services</a>

                            <a href="#branches" class="block text-gray-300 hover:text-blue-400 transition-colors duration-300 no-underline footer-link">
                                <span class="border-b border-transparent group-hover:border-blue-400 transition-all duration-300">Locations</span>
                            </a>
                            <a href="#testimonials" class="block text-gray-300 hover:text-blue-400 transition-colors duration-300 no-underline footer-link">
                                <span class="border-b border-transparent group-hover:border-blue-400 transition-all duration-300">Reviews</span>
                            </a>
                            <a href="#" class="block text-gray-300 hover:text-blue-400 transition-colors duration-300 no-underline footer-link">
                                <span class="border-b border-transparent group-hover:border-blue-400 transition-all duration-300">About Us</span>
                            </a>
                            <a href="#" class="block text-gray-300 hover:text-blue-400 transition-colors duration-300 no-underline footer-link">
                                <span class="border-b border-transparent group-hover:border-blue-400 transition-all duration-300">Careers</span>
                            </a>
                            <a href="#" class="block text-gray-300 hover:text-blue-400 transition-colors duration-300 no-underline footer-link">
                                <span class="border-b border-transparent group-hover:border-blue-400 transition-all duration-300">Gift Cards</span>
                            </a>
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
                                    <p class="text-gray-300 group-hover:text-white transition-colors duration-300">(555) 123-4567</p>
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
                                    <p class="text-gray-300 group-hover:text-white transition-colors duration-300">123 Main Street</p>
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
                        <p class="text-gray-400 mb-1">&copy; 2025 BarberShop. All rights reserved.</p>
                        <p class="text-sm text-gray-500">
                            Developed by <a href="https://www.instagram.com/jo.nthn30" target="_blank" class="text-blue-400 hover:text-blue-300 transition-colors duration-300">Jonathan Gunawan</a>
                        </p>
                    </div>
                </div>
            </div>
        </footer>

        <div v-if="showAuthModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 auth-modal-overlay">
            <div class="bg-white rounded-2xl max-w-md w-full p-6 relative auth-modal transform scale-0">
                <button @click="showAuthModal = false" class="absolute top-4 right-4 p-2 hover:bg-gray-100 rounded-lg modal-close">
                    <X class="w-5 h-5 text-gray-500" />
                </button>
                <div class="text-center mb-6 modal-header">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4 modal-icon">
                        <User class="w-8 h-8 text-blue-600" />
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2 modal-title">Welcome Back</h3>
                    <p class="text-gray-600 modal-subtitle">Sign in to book your appointment</p>
                </div>
                <div class="space-y-4 modal-form">
                    <div class="form-group">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" v-model="authForm.email"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 form-input"
                               placeholder="your@email.com">
                    </div>
                    <div class="form-group">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                        <input type="password" v-model="authForm.password"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 form-input"
                               placeholder="Enter your password">
                    </div>
                    <button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-medium transition-all transform hover:scale-105 form-submit">
                        Sign In
                    </button>
                    <div class="text-center form-footer">
                        <p class="text-gray-600">Don't have an account?
                            <button class="text-blue-600 hover:text-blue-500 font-medium">Sign up</button>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted, nextTick, watch, computed } from 'vue'
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
import {
    Menu, X, Scissors, Calendar, ArrowDown, ChevronDown, MapPin, Clock, Phone,
    Star, User, Mail
} from 'lucide-vue-next'


gsap.registerPlugin(ScrollTrigger)

const mySwiper = ref<SwiperClass | null>(null)

const onSwiperInit = (swiperInstance: any) => {
    mySwiper.value = swiperInstance;
};

const mobileMenuOpen = ref(false)
const showAuthModal = ref(false)
const selectedBranch = ref(null)
const navbar = ref(null)
// Removed ref(''); as it was an empty, unused ref.
const authForm = ref({
    email: '',
    password: ''
})

const services = ref([
    {
        id: 1,
        name: 'Classic Haircut',
        description: 'Traditional haircut with styling and finishing touches',
        price: 35,
        duration: 45
    },
    {
        id: 2,
        name: 'Beard Trim & Style',
        description: 'Professional beard trimming and styling service',
        price: 25,
        duration: 30
    },
    {
        id: 3,
        name: 'Premium Package',
        description: 'Haircut, beard trim, hot towel treatment, and styling',
        price: 65,
        duration: 90
    },
    {
        id: 4,
        name: 'Hot Towel Shave',
        description: 'Traditional straight razor shave with hot towel treatment',
        price: 40,
        duration: 60
    },
    {
        id: 5,
        name: 'Hair Wash & Style',
        description: 'Professional hair washing and styling service',
        price: 20,
        duration: 30
    },
    {
        id: 6,
        name: 'Mustache Trim',
        description: 'Precision mustache trimming and styling',
        price: 15,
        duration: 20
    }
])

const branches = ref([
    {
        id: 1,
        name: 'Downtown Branch',
        address: '123 Main Street, Downtown City, NY 10001',
        status: 'active',
        photo: null
    },
    {
        id: 2,
        name: 'Uptown Location',
        address: '456 Oak Avenue, Uptown District, NY 10002',
        status: 'active',
        photo: null
    },
    {
        id: 3,
        name: 'Mall Branch',
        address: '789 Shopping Center, West Mall, NY 10003',
        status: 'active',
        photo: null
    }
])

const testimonials = ref([
    {
        id: 1,
        customer_name: 'John Smith',
        username: '@john.smith',
        comment: 'Amazing service! The barbers are skilled and the atmosphere is great. Highly recommend!',
        rating: 5,
        img: 'https://avatar.vercel.sh/john',
    },
    {
        id: 2,
        customer_name: 'Mike Johnson',
        username: '@mikej',
        comment: 'Best haircut I\'ve had in years. Professional staff and clean environment.',
        rating: 5,
        img: 'https://avatar.vercel.sh/mike',
    },
    {
        id: 3,
        customer_name: 'David Wilson',
        username: '@davidw',
        comment: 'Great experience from start to finish. Will definitely be coming back!',
        rating: 4,
        img: 'https://avatar.vercel.sh/david',
    },
    {
        id: 4,
        customer_name: 'Alex Brown',
        username: '@alexb',
        comment: 'Top-notch service and attention to detail. Worth every penny!',
        rating: 5,
        img: 'https://avatar.vercel.sh/alex',
    },
    {
        id: 5,
        customer_name: 'Chris Davis',
        username: '@chrisd',
        comment: 'Professional barbers who really know their craft. Excellent results!',
        rating: 5,
        img: 'https://avatar.vercel.sh/chris',
    },
    {
        id: 6,
        customer_name: 'Robert Miller',
        username: '@robertm',
        comment: 'Clean, modern shop with friendly staff. Great value for money.',
        rating: 4,
        img: 'https://avatar.vercel.sh/robert',
    }
])

const duplicatedTestimonials = computed(() => {
    const duplicated: (typeof testimonials.value[number] & { uniqueId: string })[] = [];

    for (let i = 0; i < 5; i++) {
        testimonials.value.forEach((testimonial) => {
            duplicated.push({
                ...testimonial,
                uniqueId: `${testimonial.id}-${i}-${Math.random().toString(36).substring(7)}`
            });
        });
    }

    return duplicated;
});

const scrollToSection = (id: string) => {
    const element = document.getElementById(id);
    if (element) {
        element.scrollIntoView({ behavior: 'smooth' });
    }
}

const scrollToServices = () => {
    document.getElementById('services')?.scrollIntoView({ behavior: 'smooth' })
}

const selectService = (service: any) => {
    console.log('Selected service:', service)
    showAuthModal.value = true
}

const selectBranch = (branch: any) => {
    selectedBranch.value = branch
    console.log('Selected branch:', branch)
}
const initGSAPAnimations = () => {
    gsap.to(navbar.value, {
        y: 0,
        duration: 1,
        ease: "power3.out",
        delay: 0.5
    })

    gsap.from('.logo-icon', {
        rotation: 360,
        scale: 0,
        duration: 1,
        ease: "back.out(1.7)",
        delay: 1
    })

    gsap.from('.nav-link', {
        y: -20,
        opacity: 0,
        duration: 0.6,
        stagger: 0.1,
        ease: "power2.out",
        delay: 1.2
    })

    const heroTl = gsap.timeline()
    heroTl.from('.hero-word-1', {
        x: -100,
        opacity: 0,
        duration: 1,
        ease: "power3.out"
    })
        .from('.hero-word-2', {
            scale: 0,
            opacity: 0,
            duration: 1,
            ease: "back.out(1.7)"
        }, "-=0.5")
        .from('.hero-word-3', {
            x: 100,
            opacity: 0,
            duration: 1,
            ease: "power3.out"
        }, "-=0.5")
        .from('.hero-subtitle', {
            y: 30,
            opacity: 0,
            duration: 0.8,
            ease: "power2.out"
        }, "-=0.3")
        .from('.hero-btn-1', {
            scale: 0,
            rotation: 180,
            duration: 0.8,
            ease: "back.out(1.7)"
        }, "-=0.2")
        .from('.hero-btn-2', {
            scale: 0,
            rotation: -180,
            duration: 0.8,
            ease: "back.out(1.7)"
        }, "-=0.6")

    gsap.to('.floating-element-1', {
        y: -20,
        x: 20,
        rotation: 10,
        duration: 4,
        repeat: -1,
        yoyo: true,
        ease: "power1.inOut"
    })

    gsap.to('.floating-element-2', {
        y: 20,
        x: -20,
        rotation: -10,
        duration: 5,
        repeat: -1,
        yoyo: true,
        ease: "power1.inOut"
    })

    gsap.to('.floating-element-3', {
        y: -15,
        x: 15,
        rotation: 15,
        duration: 3,
        repeat: -1,
        yoyo: true,
        ease: "power1.inOut"
    })

    gsap.set('.particle', {
        x: () => Math.random() * window.innerWidth,
        y: () => Math.random() * window.innerHeight,
        opacity: () => Math.random() * 0.5 + 0.1
    })

    gsap.to('.particle', {
        y: '-=100',
        duration: () => Math.random() * 3 + 2,
        repeat: -1,
        ease: "none",
        stagger: {
            each: 0.2,
            repeat: -1
        }
    })

    gsap.to('.scroll-dot', {
        y: 20,
        duration: 1.5,
        repeat: -1,
        yoyo: true,
        ease: "power2.inOut"
    })
}

watch(showAuthModal, (newVal) => {
    if (newVal) {
        nextTick(() => {
            gsap.to('.auth-modal', {
                scale: 1,
                duration: 0.5,
                ease: "back.out(1.7)"
            })
        })
    }
})

onMounted(() => {
    AOS.init({
        duration: 1000,
        easing: 'ease-out-cubic',
        once: true,
        offset: 100,
    })

    nextTick(() => {
        initGSAPAnimations()
    })

    const handleResize = () => {
        if (mySwiper.value) {
            mySwiper.value?.update();
        }
    };
    window.addEventListener('resize', handleResize);
});
</script>

<style scoped>
.swiper {
    padding: 20px 0 60px 0;
}

.swiper-wrapper {
    min-height: 250px;
    align-items: stretch;
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

.swiper-pagination-bullet {
    background: #3B82F6;
    opacity: 0.3;
    transition: all 0.3s ease;
}

.swiper-pagination-bullet-active {
    opacity: 1;
    transform: scale(1.2);
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

.auth-modal-overlay {
    backdrop-filter: blur(10px);
}

.particles-container {
    pointer-events: none;
}

.particle {
    will-change: transform;
}

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

.service-card-header,
.branch-icon,
.author-avatar {
    position: relative;
    overflow: hidden;
}

.service-card-header::before,
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

.service-card:hover .service-card-header::before,
.branch-card:hover .branch-icon::before,
.testimonial-card:hover .author-avatar::before {
    left: 100%;
}

.hero-btn-1,
.hero-btn-2,
.service-select-btn,
.cta-button {
    position: relative;
    overflow: hidden;
}

.hero-btn-1::before,
.hero-btn-2::before,
.service-select-btn::before,
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
.service-select-btn:hover::before,
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
    .particle {
        display: none;
    }

    .floating-element-1,
    .floating-element-2,
    .floating-element-3 {
        opacity: 0.3;
    }
}

.service-card,
.branch-card,
.testimonial-card {
    will-change: transform;
    backface-visibility: hidden;
}

button:focus,
a:focus,
input:focus {
    outline: 2px solid #3B82F6;
    outline-offset: 2px;
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
