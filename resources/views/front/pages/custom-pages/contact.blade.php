@extends('front.layouts.base')

{{-- Metas --}}
@section('title', 'Contact - Servease services')

@push('extrastylesheets')
    <style>
        .global-cta{
            background-color: #fff !important;
        }
    </style>
@endpush

@section('content')
    @php
        $platform = getPlatformSettings();
        $platformName = $platform->platform_name ?: 'ServEase';
        $supportEmail = $platform->platform_email ?: 'support@servease.com';
        $phoneNumber = $platform->phone_number ?: '09XXXXXXXXX';
        $officeAddress = $platform->office_address ?: 'Burgos Barangay Hall Rodriguez, Rizal';
        $supportHours = preg_replace('/-{2,}/', '-', preg_replace('/[^\x20-\x7E]/', '-', (string) $platform->support_hours)) ?: 'Mon-Sat, 8:00 AM - 5:00 PM';
    @endphp

    @include('shared.page-loading-bar')

    <main class="main-page page--contact">
        <section class="section--hero">
            <span>CONTACT US</span>
            <h1>Talk to Servease Support</h1>
            <p>Have questions about bookings, provider applications, or your account? Reach Servease for clear support. We help you send requests, track updates, and move through each step with less stress.</p>
        </section>

        <section class="section--mform g-padding global-size global-padding">
            <div class="section--mform__head"> 
                {{-- <p class="section--mform__head--pret">contact us</p> --}}
                <h2>How Can We Help You?</h2>
                <p class="section--mform__head--label">Contact Servease for application updates, booking questions, provider requests, account concerns, or platform suggestions. Send your message and our team will guide your next step.</p>
            </div>
            <br>
            <div class="section--mform__cont">
                <div class="s-mfoorm-c-fields">
                    <form action="{{ route('contact.store') }}" method="POST" data-page-loading-form data-contact-form>
                        @csrf
                        <div class="plm-ff-con">
                            <div class="plm-ff-group">
                                <label for="">Full Name</label>
                                <input type="text" name="fullname" placeholder="e. g. Juan Dela Cruz" value="{{ old('fullname') }}" required maxlength="255" autocomplete="name">
                                @error('fullname') <small>{{ $message }}</small> @enderror
                            </div>
                            <div class="plm-ff-group">
                                <label for="">Email Address</label>
                                <input type="email" name="email" placeholder="e. g. name@gmail.com" value="{{ old('email') }}" required maxlength="255" autocomplete="email" inputmode="email">
                                @error('email') <small>{{ $message }}</small> @enderror
                            </div>
                        </div>
                        <div class="plm-ff-con">
                            <div class="plm-ff-group">
                                <label for="">Phone Number</label>
                                <input
                                    type="text"
                                    name="phone"
                                    placeholder="e. g. 09123456789"
                                    value="{{ old('phone') }}"
                                    maxlength="11"
                                    inputmode="numeric"
                                    autocomplete="tel"
                                    pattern="09[0-9]{9}"
                                    title="Phone number must start with 09 and must be exactly 11 digits"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 11)"
                                >
                                @error('phone') <small>{{ $message }}</small> @enderror
                            </div>
                            <div class="plm-ff-group">
                                <label for="">Subject</label>
                                <input type="text" name="subject" placeholder="" value="{{ old('subject') }}" required maxlength="255" autocomplete="off">
                                @error('subject') <small>{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="plm-ff-group">
                            <label for="">Message</label>
                            <textarea name="message" cols="3" rows="3" maxlength="3000" placeholder="Tell us how we can help you.">{{ old('message') }}</textarea>
                            @error('message') <small>{{ $message }}</small> @enderror
                        </div>
                        <div class="plm-ff-group">
                            <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>

                            @error('g-recaptcha-response')
                                <small>{{ $message }}</small>
                            @enderror
                        </div>

                        <button class="btn btn--tertiary-d" type="submit" data-contact-submit>Send Your Request</button>
                    </form>
                </div>

                <div class="s-mfoorm-c-details">
                    <div class="s-mfoorm-c-details__head">
                        <div class="s-mfoorm-cd-b">
                            <div class="icon-mform">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12.5 7.91309C12.5 9.29384 11.3807 10.4131 10 10.4131C8.61925 10.4131 7.5 9.29384 7.5 7.91309C7.5 6.53238 8.61925 5.41309 10 5.41309C11.3807 5.41309 12.5 6.53238 12.5 7.91309Z" stroke="#FDB932" stroke-width="1.5"/>
                                <path d="M10 1.66309C13.3823 1.66309 16.25 4.51978 16.25 7.9855C16.25 11.5064 13.3357 13.9773 10.6437 15.6574C10.4476 15.7703 10.2257 15.8298 10 15.8298C9.77425 15.8298 9.55242 15.7703 9.35625 15.6574C6.66937 13.9608 3.75 11.5186 3.75 7.9855C3.75 4.51978 6.61767 1.66309 10 1.66309Z" stroke="#FDB932" stroke-width="1.5"/>
                                <path d="M15 16.6631C15 17.5836 12.7614 18.3298 10 18.3298C7.23857 18.3298 5 17.5836 5 16.6631" stroke="#FDB932" stroke-width="1.5"/>
                                </svg>
                            </div>  
                            <h5>our address</h5>
                            <a href="https://maps.app.goo.gl/uhewv1MU5CZ7vtPY6" target="_blank">59 Daang Bakal St, Rodriguez, 1860 Rizal, Philippines </a>
                        </div>
                        <div class="s-mfoorm-cd-b">
                            <div class="icon-mform">
                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.1721 8.70393C1.41368 7.38145 1.04747 6.30163 0.826673 5.20688C0.500094 3.58806 1.24744 2.00664 2.4855 0.997577C3.00885 0.571107 3.60867 0.716814 3.918 1.27192L4.61649 2.52513C5.17027 3.51844 5.44707 4.01511 5.39214 4.54167C5.3372 5.06821 4.96387 5.49701 4.2172 6.35479L2.1721 8.70393ZM2.1721 8.70393C3.70716 11.3805 6.11623 13.791 8.79605 15.3279M8.79605 15.3279C10.1185 16.0863 11.1984 16.4525 12.2931 16.6733C13.912 16.9999 15.4933 16.2525 16.5024 15.0145C16.9289 14.4911 16.7833 13.8913 16.2281 13.582L14.9749 12.8835C13.9815 12.3297 13.4849 12.0529 12.9584 12.1078C12.4318 12.1628 12.003 12.5361 11.1452 13.2828L8.79605 15.3279Z" stroke="#FDB932" stroke-width="1.5"/>
                                </svg>
                            </div>
                            <h5>our Contact Info</h5>
                            <a href="#">+(63) 000 0000 000</a>
                            <a href="#" class="mt-1">+(63) 000 0000 000</a>
                        </div>
                    </div>
                    <div class="s-mfoorm-c-details__foo">
                        <div class="icon-mform">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1.66406 5L7.42491 8.26414C9.54873 9.4675 10.4461 9.4675 12.5699 8.26414L18.3307 5" stroke="#FDB932" stroke-width="1.5" stroke-linejoin="round"/>
                            <path d="M1.6772 11.2329C1.73168 13.7876 1.75892 15.0648 2.70153 16.0111C3.64413 16.9573 4.956 16.9902 7.57975 17.0561C9.19681 17.0968 10.798 17.0968 12.4151 17.0561C15.0388 16.9902 16.3506 16.9573 17.2933 16.0111C18.2359 15.0648 18.2631 13.7876 18.3176 11.2329C18.3351 10.4115 18.3351 9.59501 18.3176 8.77359C18.2631 6.21897 18.2359 4.94166 17.2933 3.99547C16.3506 3.04928 15.0388 3.01632 12.4151 2.9504C10.798 2.90976 9.19681 2.90976 7.57975 2.95039C4.956 3.01631 3.64413 3.04926 2.70152 3.99546C1.75891 4.94166 1.73168 6.21896 1.6772 8.77359C1.65968 9.59501 1.65969 10.4115 1.6772 11.2329Z" stroke="#FDB932" stroke-width="1.5" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <div>
                            <h5>Our Email Address</h5>
                            <a href="#" class="mt-2">info@ridewithalliance.com</a>
                        </div>
                    </div>
                    <div class="s-mfoorm-c-details__body">
                        <h5>Why Choose Servease?</h5>
                        <ul>
                            <li>
                                Servease helps you find trusted providers, send service requests, track booking status, and manage support in one organized platform.
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
        </section>

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

        @include('front.layouts.sections.cta')
    </main>
@endsection
@push('extrascripts')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.querySelector('[data-contact-form]');

            if (!form) {
                return;
            }

            const submitButton = form.querySelector('[data-contact-submit]');

            form.addEventListener('submit', function (event) {
                if (event.defaultPrevented || typeof form.checkValidity === 'function' && !form.checkValidity()) {
                    return;
                }

                if (submitButton) {
                    submitButton.disabled = true;
                    submitButton.textContent = 'Sending...';
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
