@extends('front.layouts.base')

{{-- Metas --}}
@section('title', 'About - Servease services')
@push('extrastylesheets')
    <style>

    </style>
@endpush
@section('content')
    <main class="main-page page--about">
        <div style="width: 100%; background-color: #F7F8FA; border-bottom: 1px solid #E6E8EC; !important">
            <section class="section--hero m-padding m-width">
                <div class="section--hero__main">
                    <div class="badge-hero">About Servease</div>
                    <h1>Local Services Made Simple, Safe, and Easy to Book</h1>
                    <p>Servease helps you find and book trusted local service providers online. From home repairs to cleaning, appliance work, and daily service needs, the platform gives you a clear way to request help, track updates, and manage your booking in one place.</p>
                </div>
                <div class="section--hero__boxs">
                    <div class="section--hero__boxs__box">
                        <svg width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="50" height="50" rx="12" fill="#202020"/>
                        <path d="M29.5625 33.8711C26.48 35.5603 23.9375 35.5586 20.5625 34.4336C17.1447 33.294 14.9375 29.3711 14.9375 26.5586C14.9375 25.0151 17.2516 24.0993 18.0476 23.8305C18.1242 23.8048 18.1909 23.7559 18.2383 23.6906C18.2858 23.6253 18.3118 23.5467 18.3125 23.466V19.2461C18.3125 18.9876 18.3634 18.7315 18.4624 18.4927C18.5613 18.2538 18.7063 18.0368 18.8891 17.854C19.0719 17.6712 19.289 17.5261 19.5278 17.4272C19.7667 17.3283 20.0227 17.2773 20.2812 17.2773C20.5398 17.2773 20.7958 17.3283 21.0347 17.4272C21.2735 17.5261 21.4906 17.6712 21.6734 17.854C21.8562 18.0368 22.0012 18.2538 22.1001 18.4927C22.1991 18.7315 22.25 18.9876 22.25 19.2461V17.8398C22.25 17.3177 22.4574 16.8169 22.8266 16.4477C23.1958 16.0785 23.6966 15.8711 24.2188 15.8711C24.7409 15.8711 25.2417 16.0785 25.6109 16.4477C25.9801 16.8169 26.1875 17.3177 26.1875 17.8398V19.2461C26.1875 18.7239 26.3949 18.2232 26.7641 17.854C27.1333 17.4848 27.6341 17.2773 28.1562 17.2773C28.6784 17.2773 29.1792 17.4848 29.5484 17.854C29.9176 18.2232 30.125 18.7239 30.125 19.2461V15.0273C30.125 14.5052 30.3324 14.0044 30.7016 13.6352C31.0708 13.266 31.5716 13.0586 32.0938 13.0586C32.6159 13.0586 33.1167 13.266 33.4859 13.6352C33.8551 14.0044 34.0625 14.5052 34.0625 15.0273V26.6891C34.0625 28.0796 33.7295 29.4611 32.9161 30.5895C32.0893 31.7364 30.8883 33.1443 29.5625 33.8711Z" stroke="white" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>  
                        <div>
                            <h3>Easy Online Booking</h3>
                            <p>Choose a service, send a request, and track your booking without long calls or manual follow-ups.</p>
                        </div>
                    </div>
                    <div class="section--hero__boxs__box">
                        <svg width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="50" height="50" rx="12" fill="#202020"/>
                            <path d="M24.834 22.0586C27.3193 22.0586 29.334 20.0439 29.334 17.5586C29.334 15.0733 27.3193 13.0586 24.834 13.0586C22.3487 13.0586 20.334 15.0733 20.334 17.5586C20.334 20.0439 22.3487 22.0586 24.834 22.0586Z" stroke="white" stroke-width="1.4"/>
                            <path d="M31.584 33.3086C34.0693 33.3086 36.084 31.2939 36.084 28.8086C36.084 26.3233 34.0693 24.3086 31.584 24.3086C29.0987 24.3086 27.084 26.3233 27.084 28.8086C27.084 31.2939 29.0987 33.3086 31.584 33.3086Z" stroke="white" stroke-width="1.4"/>
                            <path d="M30.084 28.8087L31.0211 29.9337L33.0832 27.8086" stroke="white" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M28.209 25.8015C27.1011 25.5541 25.9691 25.4307 24.834 25.4336C19.8637 25.4336 15.834 27.7005 15.834 30.4961C15.834 33.2918 15.834 35.5586 24.834 35.5586C31.2319 35.5586 33.0814 34.4134 33.6169 32.7461" stroke="white" stroke-width="1.4"/>
                        </svg>
                        <div>
                            <h3>Trusted Local Services</h3>
                            <p>Find skilled local providers for repairs, cleaning, appliance work, installations, and daily support.</p>
                        </div>
                    </div>
                    <div class="section--hero__boxs__box">
                        <svg width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="50" height="50" rx="12" fill="#202020"/>
                            <g clip-path="url(#clip0_1959_12230)">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M35.6151 23.7498C35.9088 26.6525 35.0375 29.5529 33.1927 31.813C31.348 34.0732 28.6809 35.508 25.7783 35.8017C22.8757 36.0955 19.9753 35.2241 17.7151 33.3794C15.455 31.5346 14.0202 28.8676 13.7264 25.965C13.6976 25.6929 13.7781 25.4206 13.9501 25.2078C14.1221 24.9951 14.3715 24.8594 14.6436 24.8306C14.9156 24.8018 15.188 24.8822 15.4007 25.0542C15.6134 25.2262 15.7491 25.4757 15.7779 25.7477C15.9368 27.2513 16.4744 28.6901 17.3407 29.9293C18.2069 31.1686 19.3733 32.1678 20.7309 32.8335C22.0884 33.4992 23.5926 33.8097 25.1028 33.7358C26.613 33.6619 28.0797 33.2061 29.3658 32.411C30.6518 31.6159 31.7152 30.5076 32.4563 29.1897C33.1974 27.8718 33.592 26.3874 33.6033 24.8755C33.6145 23.3635 33.242 21.8735 32.5206 20.5447C31.7992 19.2159 30.7525 18.0919 29.4784 17.2777V19.6523C29.4784 19.9258 29.3698 20.1882 29.1764 20.3815C28.983 20.5749 28.7207 20.6836 28.4472 20.6836C28.1737 20.6836 27.9114 20.5749 27.718 20.3815C27.5246 20.1882 27.4159 19.9258 27.4159 19.6523V13.8086H33.2597C33.5332 13.8086 33.7955 13.9172 33.9889 14.1106C34.1823 14.304 34.2909 14.5663 34.2909 14.8398C34.2909 15.1133 34.1823 15.3757 33.9889 15.569C33.7955 15.7624 33.5332 15.8711 33.2597 15.8711H31.0789C32.3529 16.7852 33.4167 17.9611 34.199 19.3199C34.9814 20.6788 35.4642 22.1892 35.6151 23.7498ZM23.2909 16.5586C23.6556 16.5586 24.0054 16.4137 24.2632 16.1559C24.5211 15.898 24.6659 15.5483 24.6659 15.1836C24.6659 14.8189 24.5211 14.4692 24.2632 14.2113C24.0054 13.9535 23.6556 13.8086 23.2909 13.8086C22.9263 13.8086 22.5765 13.9535 22.3187 14.2113C22.0608 14.4692 21.9159 14.8189 21.9159 15.1836C21.9159 15.5483 22.0608 15.898 22.3187 16.1559C22.5765 16.4137 22.9263 16.5586 23.2909 16.5586ZM20.1972 16.9023C20.1972 17.267 20.0523 17.6168 19.7945 17.8746C19.5366 18.1325 19.1869 18.2773 18.8222 18.2773C18.4575 18.2773 18.1078 18.1325 17.8499 17.8746C17.5921 17.6168 17.4472 17.267 17.4472 16.9023C17.4472 16.5377 17.5921 16.1879 17.8499 15.9301C18.1078 15.6722 18.4575 15.5273 18.8222 15.5273C19.1869 15.5273 19.5366 15.6722 19.7945 15.9301C20.0523 16.1879 20.1972 16.5377 20.1972 16.9023ZM15.7284 22.0586C16.0931 22.0586 16.4429 21.9137 16.7007 21.6559C16.9586 21.398 17.1034 21.0483 17.1034 20.6836C17.1034 20.3189 16.9586 19.9692 16.7007 19.7113C16.4429 19.4535 16.0931 19.3086 15.7284 19.3086C15.3638 19.3086 15.014 19.4535 14.7562 19.7113C14.4983 19.9692 14.3534 20.3189 14.3534 20.6836C14.3534 21.0483 14.4983 21.398 14.7562 21.6559C15.014 21.9137 15.3638 22.0586 15.7284 22.0586Z" fill="white"/>
                            </g>
                            <defs>
                            <clipPath id="clip0_1959_12230">
                            <rect width="22" height="22" fill="white" transform="translate(13.666 13.8086)"/>
                            </clipPath>
                            </defs>
                        </svg>
                        <div>
                            <h3>Clear Service Flow</h3>
                            <p>Servease keeps bookings, updates, reviews, and service details organized in one online platform.</p>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <section class="section--what-we-do m-padding m-width">
            <div class="section--what-we-do__image">
                <img src="{{asset('public/images/about-whatwedo.webp')}}" alt="What We Do Banner Image">
            </div>
            <div class="section--what-we-do__content">
                <h2>Helping You Request Local Services With Less Hassle</h2>
                <p class="section--what-we-do__content--p">
                    Servease gives you a simple way to request local services online. You choose the service you need, send a booking request, and track the status from your account.
                    <br><br>
                    The platform helps keep every request clear and organized. You see where your booking stands, what service you requested, and how the process moves from pending to completed.
                    <br><br>
                    Servease focuses on making local service access easier for everyday needs like repairs, cleaning, appliance work, installations, and other home support services.
                </p>
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
                        <img src="{{asset('public/images/testimonials/testimonial-4.png')}}" alt="Joshua Rentillo">
                        <div>
                            <h4>Joshua Rentillo</h4>
                            <p>“Dati, mahirap maghanap ng maaasahang service provider. Sa Servease, mas mabilis na akong nakakapag-book gamit ang phone ko, at mas madali kong nasusundan ang status ng request.”</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section--misvis m-padding m-width">
            <div class="section--misvis__header">
                <h2>Making Local Services Easier for Every Resident</h2>
                <p>
                    Servease lets you book trusted local services online, send requests, and track updates for repairs, cleaning, appliance work, and daily support.
                </p>
            </div>

            <div class="section--misvis__grid">
                <div class="section--misvis__card">
                    <h3>Our Mission</h3>
                    <p>
                        To empower our barangay by making local services accessible, reliable, and fair whether you need a plumber, tutor, hilot, or handyman, Servease helps you find the right kapitbahay for the job.
                        <br><br>
                        We believe strong communities are built on trust and opportunity. Servease gives local talent a place to shine and residents a simpler way to get things done.
                    </p>
                </div>

                <div class="section--misvis__card">
                    <h3>Our Vision</h3>
                    <p>
                        A connected Barangay Burgos where every resident can easily access trusted local services, and every skilled worker has a fair chance to grow their livelihood through Servease.
                        <br><br>
                        We aim to build a community where help is easier to find, service providers are easier to reach, and daily needs are handled with trust and convenience.
                    </p>
                </div>
            </div>
        </section>
        <section class="section__add-on ">
            <div class="section__add-on--main global-size m-padding">
                <div class="section__add-on--main__detail">
                    <span class="glb-pret">COMMUNITY SUPPORT</span>
                    <h2>How Servease Helps the Community</h2>
                    <p class="section__add-on--main__detail--paragraph">Servease gives residents a faster way to request help and gives local providers a better way to receive bookings. It keeps service requests clear, organized, and easier to manage.</p>
                    <div class="line-addon"></div>
                    <ul>
                        <li>
                            <svg width="17" height="10" viewBox="0 0 17 10" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 5.54625L3.95958 9.50583L4.95833 8.5L1.00583 4.5475M15.4629 0L7.96875 7.50125L5.02208 4.5475L4.00917 5.54625L7.96875 9.50583L16.4688 1.00583M12.4596 1.00583L11.4608 0L6.96292 4.49792L7.96875 5.49667L12.4596 1.00583Z" fill="#FDB932"/></svg>
                            <p><strong>Daily Service Needs</strong> Book help for repairs, cleaning, appliance work, errands, and other common home service requests.</p>
                        </li>
                        <li>
                            <svg width="17" height="10" viewBox="0 0 17 10" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 5.54625L3.95958 9.50583L4.95833 8.5L1.00583 4.5475M15.4629 0L7.96875 7.50125L5.02208 4.5475L4.00917 5.54625L7.96875 9.50583L16.4688 1.00583M12.4596 1.00583L11.4608 0L6.96292 4.49792L7.96875 5.49667L12.4596 1.00583Z" fill="#FDB932"/></svg>
                            <p><strong>Trusted Local Providers</strong> Find skilled workers in the community who are ready to accept service requests and help nearby residents.</p>
                        </li>
                        <li>
                            <svg width="17" height="10" viewBox="0 0 17 10" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 5.54625L3.95958 9.50583L4.95833 8.5L1.00583 4.5475M15.4629 0L7.96875 7.50125L5.02208 4.5475L4.00917 5.54625L7.96875 9.50583L16.4688 1.00583M12.4596 1.00583L11.4608 0L6.96292 4.49792L7.96875 5.49667L12.4596 1.00583Z" fill="#FDB932"/></svg>
                            <p><strong>Clear Booking Updates</strong> Track your request status online, from pending review to completed service, without confusion.</p>
                        </li>
                    </ul>
                    <div class="btn-space">
                        <a href="{{url('/provider-signup')}}" class="btn btn--tertiary">Become A Provider</a>
                        <a href="{{url('/services')}}" class="btn btn--transparent" style="background-color: transparent">Book Services</a>
                    </div>
                </div>
                <div class="section__add-on--main__image">
                    <img src="{{ asset('public/images/add-on-img.png') }}" alt="banner-img">
                </div>
            </div>
        </section>
        <section class="section__faqs">
            <div class="section__faqs--main global-size m-padding">
                <div class="section__faqs--main--details">
                    <span class="glb-pret">FAQ</span>
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
                            <img src="{{asset('public/images/testimonials/testimonial-5.png')}}" alt="Dawn Izach J. Cruz">
                            <div>
                                <h4>Dawn Izach J. Cruz</h4>
                                <p>“Mas madali na akong makahanap ng local service sa Servease. Hindi ko na kailangang magtanong-tanong pa. Pili lang ng service, send ng request, at susundan ko na lang ang update online.”</p>
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