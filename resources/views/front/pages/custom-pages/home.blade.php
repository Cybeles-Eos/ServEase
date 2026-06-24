@extends('front.layouts.base')

{{-- Metas --}}
@section('title', 'Home - Servease')


@section('content')
    <main class="main-page page--home">
        <section class="section--hero m-padding">
            <h1>Find reliable local experts fast with our smart service hub</h1>
            <p>A smart platform that connects people who need help with locals who can get the job done anytime.</p>

            <div class="section--hero__inp">
                <input type="text" id="serviceSearch" autocomplete="off" placeholder="What service are you looking for?" >
                <button id="view">Search</button>
                <div class="sh-inp-lists">
                    <ul id="serviceList">
                        <p class="serv-not-found">Service not found</p>
                        {{-- Services List --}}
                    </ul>
                </div>
            </div>

        </section>
        <section class="section--about m-width m-padding">  
            <div class="section--about__img">
                <img src="{{asset('images/abt-2.webp')}}" alt="about-img">
            </div>
            <div class="section--about__detail">
                <p class="section--about__detail--pret">Why Choose Brgy BATAsan for local services</p>
                <h2>Trusted Local Services for Any Problem You Face</h2>
                <p>
                    We’re a trusted local services platform connecting customers with skilled and verified providers through a seamless, secure, and dependable booking experience designed for everyday convenience.
                    <br><br>
                    Servease bridges customers and providers using smart technology, ensuring efficient service, clear communication, full transparency, and peace of mind from booking to job completion.
                </p>
                <a href="{{url('/services')}}" class="btn btn--tertiary">Explore Services</a>
            </div>
        </section>
        <section class="section--req">
            <div class="section--req--main m-width m-padding">
                <div class="sec-rm-left">   
                    <h2>Grow and Scale Your Service Business by Joining Servease Today</h2>
                    <p class="sec-rm-left__p">Join a trusted local services platform designed to help providers attract more clients, manage bookings efficiently, and grow their income. With our seamless system and expanding customer base, you can focus on delivering quality service while we handle the rest.</p>
                    <div class="btn-space">
                        <a href="{{url('/provider-signup')}}" class="btn btn--tertiary">Become A Provider</a>
                        <a href="{{url('/services')}}" class="btn btn--transparent">Book Services</a>
                    </div>
                    <div class="glb-testimonial">
                        <svg width="27" height="20" viewBox="0 0 30 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M21.2947 23H25.7718C28.1068 23 30 21.0686 30 18.6864V14.1189C30 11.7367 28.1068 9.80532 25.7718 9.80532H25.3288C24.9575 9.80532 24.6096 9.61833 24.399 9.30546C24.1893 8.99259 24.1432 8.59423 24.2774 8.24077L26.8027 1.56455C26.9369 1.21067 26.8908 0.812313 26.6811 0.499917C26.4705 0.187044 26.1226 6.00634e-05 25.7512 6.00634e-05H22.7783C22.359 6.00634e-05 21.9738 0.238035 21.7798 0.616843L18.1905 7.61257C17.4517 9.0526 17.0657 10.6541 17.0657 12.2795V18.6864C17.0655 21.0686 18.9596 23 21.2947 23Z" fill="#FFBE42"/>
                            <path d="M4.22812 23H8.70527C11.0404 23 12.9334 21.0686 12.9334 18.6864V14.1189C12.9334 11.7367 11.0403 9.80532 8.70527 9.80532H8.2633C7.89193 9.80532 7.54312 9.61833 7.33342 9.30546C7.12271 8.99259 7.07766 8.59423 7.2109 8.24077L9.73705 1.56449C9.87129 1.21061 9.82523 0.812253 9.61459 0.499857C9.40488 0.186983 9.05701 -1.49012e-07 8.68465 -1.49012e-07H5.71266C5.2933 -1.49012e-07 4.90816 0.237976 4.71316 0.616784L1.12488 7.61251C0.386073 9.0526 -9.23872e-07 10.654 -9.23872e-07 12.2795V18.6864C-9.23872e-07 21.0686 1.8931 23 4.22812 23Z" fill="#FFBE42"/>
                        </svg>
                        <div class="glb-testimonial__d">
                            <img src="{{asset('public/images/user-1.png')}}" alt="testimonial_profile">
                            <div>
                                <h4>Dr. Bella Barcelon</h4>
                                <p>“Since joining Servease, I’ve gained consistent bookings and expanded my client base. The platform makes managing jobs simple and efficient.”</p>
                            </div>
                        </div>
                    </div>
                </div>  
                <div class="sec-rm-right">
                    <img src="{{asset('images/reg-lap.webp')}}" alt="laptop">
                </div>
            </div>
        </section>
        <section class="section--services m-padding">
            <h2>Find Trusted Local Services for Any Home or Business Need</h2>
            <p class="section--services__p">Get quick, reliable help from verified Filipino professionals anytime you need repairs, cleaning, installations, or daily support.</p>
            <div class="section--services__box">
                <div class="section-ser-bb">
                    <div>
                        <img src="{{asset('images/sys-vec.svg')}}" alt="icon">
                        <h3>Home Repairs</h3>
                        <p>Fix leaks, wiring issues, broken fixtures, and other home concerns with skilled professionals you can trust. Our reliable workers provide fast and efficient repair services anytime you need help.</p>
                    </div>
                    <br>
                    <a href="{{url('/services')}}">Explore Service</a>
                </div>
                <div class="section-ser-bb">
                    <div>
                        <img src="{{asset('images/sys-vec.svg')}}" alt="icon">
                        <h3>Cleaning Services</h3>
                        <p>Keep your home or office spotless with trained cleaners who deliver deep cleaning, general upkeep, and routine maintenance. Enjoy a fresh and hygienic space with service you can rely on.</p>
                    </div>
                    <br>
                    <a href="{{url('/services')}}">Explore Service</a>
                </div>
                <div class="section-ser-bb">
                    <div>
                        <img src="{{asset('images/sys-vec.svg')}}" alt="icon">
                        <h3>Appliance Services</h3>
                        <p>From aircon inspections to full appliance repairs, our experts ensure everything functions safely and smoothly. Get dependable installation and repair services for all your household devices.</p>
                    </div>
                    <br>
                    <a href="{{url('/services')}}">Explore Service</a>
                </div>
                <div class="section-ser-bb">
                    <div>
                        <img src="{{asset('images/sys-vec.svg')}}" alt="icon">
                        <h3>Personal Help</h3>
                        <p>For daily tasks, simple errands, or small jobs at home, find dependable helpers ready to assist. Enjoy quick, convenient, and stress-free support from trusted local service providers.</p>
                    </div>
                    <br>
                    <a href="{{url('/services')}}">Explore Service</a>
                </div>
            </div>
        </section>
        <section class="section--guide m-padding">
            <div class="section--guide__head">
                <h2>Fast Guide to Booking Services in Community</h2>
                <p> Makes it simple to find trusted local professionals for plumbing, aircon repair, electrical work, and more. Just browse services, book a provider, and pay face to face when they arrive fast, reliable, and hassle free.</p>
            </div>
            <div class="section--guide__guide">

                <div class="section--guide__guide--box">
                    <img src="{{asset('images/guide-icon-1.svg')}}" alt="icon-guide">
                    <div>
                        <h3>Create Your Account</h3>
                        <p>Sign up using your email or mobile number. Complete your profile to make booking services easier and faster.</p>
                    </div>
                </div>
                <div class="section--guide__guide--box">
                    <img src="{{asset('images/guide-icon-1.svg')}}" alt="icon-guide">
                    <div>
                        <h3>Book a Service</h3>
                        <p>Select the service you need, choose a professional, and schedule a time that works for you. Your service is confirmed once booked.</p>
                    </div>
                </div>
                <div class="section--guide__guide--box">
                    <img src="{{asset('images/guide-icon-1.svg')}}" alt="icon-guide">
                    <div>
                        <h3>Browse Local Services</h3>
                        <p>Explore a wide range of trusted local services like plumbing, aircon repair, electrical work, and more—all available in your area.</p>
                    </div>
                </div>
                <div class="section--guide__guide--box">
                    <img src="{{asset('images/guide-icon-1.svg')}}" alt="icon-guide">
                    <div>
                        <h3>Rate and Review</h3>
                        <p>After the service is completed, leave a rating and review to help others choose trusted local professionals.</p>
                    </div>
                </div>

            </div>
        </section>
        <div style="width: 100%; background-color: #F7F8FA !important">
        <section class="section--closing m-width m-padding">
            <div class="section--closing__img">
                <img src="{{asset('images/closing-1.webp')}}" alt="closing-img">
            </div>
            <div class="section--closing__detail">
                <h2>Your Trusted Partner for Local Services</h2>
                <p>
                    Find reliable Filipino professionals for any task—big or small. From plumbing and electrical work to cleaning and maintenance, we make it easy to book the right expert. 
                    <br><br>
                    We verify every service provider to ensure quality, safety, and a smooth experience. Convenience is just one click away.
                </p>
                <div class="btn-space">
                    <a href="{{url('/provider-signup')}}" class="btn btn--tertiary">Become A Provider</a>
                    <a href="{{url('/services')}}" class="btn btn--transparent">Book Services</a>
                </div>
            </div>
        </section>
        </div>

        <section class="section__faqs">
            <div class="section__faqs--main global-size m-padding">
                <div class="section__faqs--main--details">
                    <span class="section--label">FAQ</span>
                    <h2>Frequently Asked Questions About Servease</h2>
                    <p class="section__faqs--main--details--paragraph">Find quick answers about bookings, provider applications, service requests, account support, reviews, and how Servease helps you connect with trusted local service providers.</p>
                    <div class="global-btns-con">
                        <a href="{{url('services')}}" class="btn btn--tertiary-d" style="max-width: fit-content">View Our Services</a>
                    </div>
                    <div class="glb-testimonial">
                        <svg width="27" height="20" viewBox="0 0 30 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M21.2947 23H25.7718C28.1068 23 30 21.0686 30 18.6864V14.1189C30 11.7367 28.1068 9.80532 25.7718 9.80532H25.3288C24.9575 9.80532 24.6096 9.61833 24.399 9.30546C24.1893 8.99259 24.1432 8.59423 24.2774 8.24077L26.8027 1.56455C26.9369 1.21067 26.8908 0.812313 26.6811 0.499917C26.4705 0.187044 26.1226 6.00634e-05 25.7512 6.00634e-05H22.7783C22.359 6.00634e-05 21.9738 0.238035 21.7798 0.616843L18.1905 7.61257C17.4517 9.0526 17.0657 10.6541 17.0657 12.2795V18.6864C17.0655 21.0686 18.9596 23 21.2947 23Z" fill="#FFBE42"/>
                            <path d="M4.22812 23H8.70527C11.0404 23 12.9334 21.0686 12.9334 18.6864V14.1189C12.9334 11.7367 11.0403 9.80532 8.70527 9.80532H8.2633C7.89193 9.80532 7.54312 9.61833 7.33342 9.30546C7.12271 8.99259 7.07766 8.59423 7.2109 8.24077L9.73705 1.56449C9.87129 1.21061 9.82523 0.812253 9.61459 0.499857C9.40488 0.186983 9.05701 -1.49012e-07 8.68465 -1.49012e-07H5.71266C5.2933 -1.49012e-07 4.90816 0.237976 4.71316 0.616784L1.12488 7.61251C0.386073 9.0526 -9.23872e-07 10.654 -9.23872e-07 12.2795V18.6864C-9.23872e-07 21.0686 1.8931 23 4.22812 23Z" fill="#FFBE42"/>
                        </svg>
                        <div class="glb-testimonial__d">
                            <img src="{{asset('public/images/user-1.png')}}" alt="testimonial_profile">
                            <div>
                                <h4>Dr. Bella Barcelon</h4>
                                <p>“Since joining Servease, I’ve gained consistent bookings and expanded my client base. The platform makes managing jobs simple and efficient.”</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="section__faqs--main--faq">
                    <div class="servease-faq" id="serveaseFaq">
                        {{-- JS FAQ items will render here --}}
                    </div>
                </div>
            </div>
        </section>
        {{-- <section style="width: 100%; height: 100vh"></section> --}}
        @include('front.layouts.sections.cta')
    </main>
@endsection

@php
    $servicesJson = services()->map(function ($service) {
        $categoryIsVisible = $service->serviceCategory && $service->serviceCategory->is_active;

        return [
            'title' => $service->title,
            'slug' => $service->slug,
            'category' => $categoryIsVisible ? $service->serviceCategory->name : null,
        ];
    })->values()->toJson();
@endphp

@push('extrascripts')
<script>
    $(document).ready(function () {
        const services = {!! $servicesJson !!};

        let selectedService = null;

        const $input = $('#serviceSearch');
        const $listBox = $('.sh-inp-lists');
        const $list = $('#serviceList');
        const $notFound = $('.serv-not-found');
        const $btn = $('#view');

        function renderServices(items) {
            $list.find('li').remove();

            if (!items.length) {
                $notFound.show();
                $listBox.show();
                return;
            }

            $notFound.hide();

            items.forEach(service => {
                const serviceLabel = `${service.category ? service.category + ' - ' : ''}${service.title}`;

                $list.append(`
                    <li>
                        <a href="/services/${service.slug}"
                        data-title="${service.title}"
                        data-slug="${service.slug}"
                        data-category="${service.category ?? ''}">
                            ${serviceLabel}
                        </a>
                    </li>
                `);
            });

            $listBox.show();
        }

        // Show all services when input is focused or clicked
        $input.on('focus click', function () {
            const keyword = $(this).val().toLowerCase().trim();

            if (!keyword) {
                renderServices(services);
                return;
            }

            const matches = services.filter(service =>
                `${service.category} - ${service.title}`.toLowerCase().includes(keyword) ||
                service.title.toLowerCase().includes(keyword) ||
                service.category.toLowerCase().includes(keyword)
            );

            renderServices(matches);
        });

        // Filter services while typing
        $input.on('keyup', function () {
            const keyword = $(this).val().toLowerCase().trim();

            selectedService = null;
            $btn.text('Search');

            if (!keyword) {
                renderServices(services);
                return;
            }

            const matches = services.filter(service =>
                `${service.category} - ${service.title}`.toLowerCase().includes(keyword) ||
                service.title.toLowerCase().includes(keyword) ||
                service.category.toLowerCase().includes(keyword)
            );

            renderServices(matches);
        });

        // Select service from dropdown
        $(document).on('click', '.sh-inp-lists a', function (e) {
            e.preventDefault();

            selectedService = {
                title: $(this).data('title'),
                slug: $(this).data('slug'),
                category: $(this).data('category')
            };

            $input.val(`${selectedService.category} - ${selectedService.title}`);
            $listBox.hide();
            $btn.text('Get Started');
        });

        // Search button action
        $btn.on('click', function () {
            const inputValue = $input.val().trim();

            if (!inputValue) return;

            if (selectedService) {
                window.location.href = `/services/${selectedService.slug}`;
                return;
            }

            const normalizedInput = inputValue.toLowerCase();

            const matchedService = services.find(service =>
                `${service.category} - ${service.title}`.toLowerCase() === normalizedInput ||
                service.title.toLowerCase() === normalizedInput
            );

            if (matchedService) {
                window.location.href = `/services/${matchedService.slug}`;
            } else {
                window.location.href = `/contact`;
            }
        });

        // Hide dropdown when clicking outside
        $(document).on('click', function (e) {
            if (!$(e.target).closest('.section--hero__inp').length) {
                $listBox.hide();
            }
        });
    });
</script>


    {{-- For FAQs --}}
    <script>
        const serveaseFaqData = [
            {
                question: "Who can use Servease?",
                answer: "Servease is for customers who need local services, providers who want to offer their work, and admins who manage bookings, applications, reports, and platform activity."
            },
            {
                question: "How do I book a service on Servease?",
                answer: "Create an account, browse available services, choose a provider, send your booking request, and track the request status from your account dashboard."
            },
            {
                question: "How do I contact a provider after booking?",
                answer: "After you send a booking request, Servease helps you manage updates through the platform. You can check your booking status and follow the next steps shown in your account."
            },
            {
                question: "Why was my provider application not approved?",
                answer: "Provider applications may not be approved if required details, documents, or service information need more review. Contact Servease support so the team can check your application status."
            },
            {
                question: "How do I check my booking status?",
                answer: "Log in to your Servease account and open your booking records. You can view if your request is pending, accepted, completed, cancelled, or still under review."
            },
            {
                question: "Can I send suggestions or report an account concern?",
                answer: "Yes. You can contact Servease for platform suggestions, account concerns, booking issues, provider questions, or updates about your application."
            }
        ];

        const serveaseFaq = document.getElementById("serveaseFaq");

        if (serveaseFaq) {
            serveaseFaq.innerHTML = serveaseFaqData.map((item, index) => {
                return `
                    <div class="servease-faq__item ${index === 1 ? "is-active" : ""}">
                        <button class="servease-faq__button" type="button" aria-expanded="${index === 1 ? "true" : "false"}">
                            <span class="servease-faq__question">${item.question}</span>
                            <span class="servease-faq__icon">+</span>
                        </button>

                        <div class="servease-faq__content">
                            <div class="servease-faq__body">
                                <p class="servease-faq__answer">${item.answer}</p>
                            </div>
                        </div>
                    </div>
                `;
            }).join("");

            const faqItems = serveaseFaq.querySelectorAll(".servease-faq__item");

            faqItems.forEach((item) => {
                const button = item.querySelector(".servease-faq__button");
                const content = item.querySelector(".servease-faq__content");

                if (item.classList.contains("is-active")) {
                    content.style.maxHeight = content.scrollHeight + "px";
                }

                button.addEventListener("click", () => {
                    const isOpen = item.classList.contains("is-active");

                    faqItems.forEach((otherItem) => {
                        const otherButton = otherItem.querySelector(".servease-faq__button");
                        const otherContent = otherItem.querySelector(".servease-faq__content");

                        otherItem.classList.remove("is-active");
                        otherButton.setAttribute("aria-expanded", "false");
                        otherContent.style.maxHeight = null;
                    });

                    if (!isOpen) {
                        item.classList.add("is-active");
                        button.setAttribute("aria-expanded", "true");
                        content.style.maxHeight = content.scrollHeight + "px";
                    }
                });
            });
        }
    </script>
@endpush