@extends('front.layouts.base')

@section('title', 'Terms and Conditions - Servease')

@section('content')
    @php
        $platform = getPlatformSettings();
        $platformName = $platform->platform_name ?: 'ServEase';
        $serviceArea = $platform->service_area ?: 'Burgos Barangay Hall Rodriguez, Rizal';
        $supportEmail = $platform->platform_email ?: 'support@servease.com';
    @endphp

    <main class="main-page legal-page">
        <section class="legal-page__hero m-padding">
            <div class="m-width-legal">
                <p>{{ $platformName }}</p>
                <h1>Terms and Conditions</h1>
                <span>
                    These terms apply when customers book local services and providers offer services through {{ $platformName }} in {{ $serviceArea }}.
                </span>
            </div>
        </section>

        <section class="legal-page__content m-padding">
            <div class="m-width legal-page__content-inner">

                <div class="legal-page__intro">
                    <span>Last updated: {{ now()->format('F d, Y') }}</span>
                    <p>
                        {{ $platformName }} connects customers with local service providers. By using the platform, you agree to follow these terms and use the service honestly and responsibly.
                    </p>
                </div>

                <div class="legal-page__list">

                    <article class="legal-page__item">
                        <div class="legal-page__number">1</div>
                        <div class="legal-page__body">
                            <h2>Use of the platform</h2>
                            <p>
                                You agree to provide accurate account, contact, booking, and service information when using {{ $platformName }}.
                            </p>

                            <ul>
                                <li>Do not use the platform for fraud, spam, harassment, fake bookings, or misleading service offers.</li>
                                <li>Do not create false accounts or submit false provider information.</li>
                                <li>Do not use the platform in a way that may harm customers, providers, administrators, or the system.</li>
                            </ul>
                        </div>
                    </article>

                    <article class="legal-page__item">
                        <div class="legal-page__number">2</div>
                        <div class="legal-page__body">
                            <h2>Customer bookings</h2>
                            <p>
                                Customers are responsible for submitting clear and correct service request details.
                            </p>

                            <ul>
                                <li>Provide the correct service location, preferred schedule, contact details, and request notes.</li>
                                <li>Review service details before sending a booking request.</li>
                                <li>A booking is not final until it is accepted by a provider or confirmed through the platform workflow.</li>
                            </ul>
                        </div>
                    </article>

                    <article class="legal-page__item">
                        <div class="legal-page__number">3</div>
                        <div class="legal-page__body">
                            <h2>Provider responsibilities</h2>
                            <p>
                                Providers must submit truthful registration details and keep their service information updated.
                            </p>

                            <ul>
                                <li>Provide accurate service descriptions, prices, availability, and service areas.</li>
                                <li>Respond to customer bookings professionally.</li>
                                <li>Perform accepted services with reasonable care, skill, and respect.</li>
                                <li>Do not list services that are false, unsafe, illegal, or outside your ability to perform.</li>
                            </ul>
                        </div>
                    </article>

                    <article class="legal-page__item">
                        <div class="legal-page__number">4</div>
                        <div class="legal-page__body">
                            <h2>Provider application review</h2>
                            <p>
                                Provider accounts may require admin review before full access is granted.
                            </p>

                            <ul>
                                <li>Admins may review submitted provider details and uploaded documents.</li>
                                <li>Approval may be accepted or declined based on platform review.</li>
                                <li>Provider access may be restricted, suspended, or removed for false information, safety issues, or misuse.</li>
                            </ul>
                        </div>
                    </article>

                    <article class="legal-page__item">
                        <div class="legal-page__number">5</div>
                        <div class="legal-page__body">
                            <h2>Service information and pricing</h2>
                            <p>
                                Service titles, descriptions, categories, prices, and availability may be provided by providers or administrators.
                            </p>

                            <ul>
                                <li>Customers should review all service details before booking.</li>
                                <li>Providers are responsible for keeping pricing and service details accurate.</li>
                                <li>{{ $platformName }} may update, hide, or remove service listings that are inaccurate, misleading, or harmful.</li>
                            </ul>
                        </div>
                    </article>

                    <article class="legal-page__item">
                        <div class="legal-page__number">6</div>
                        <div class="legal-page__body">
                            <h2>Cancellations and completion</h2>
                            <p>
                                Customers and providers should cancel only when necessary and should update booking status honestly.
                            </p>

                            <ul>
                                <li>Customers should give clear notice when they need to cancel a request.</li>
                                <li>Providers should only accept bookings they can complete.</li>
                                <li>Completed bookings may be used for records, ratings, reviews, and platform quality checks.</li>
                            </ul>
                        </div>
                    </article>

                    <article class="legal-page__item">
                        <div class="legal-page__number">7</div>
                        <div class="legal-page__body">
                            <h2>Ratings and comments</h2>
                            <p>
                                Reviews must be based on actual service experience.
                            </p>

                            <ul>
                                <li>Do not post abusive, false, misleading, unrelated, or harmful reviews.</li>
                                <li>{{ $platformName }} may review, hide, or remove ratings and comments that affect platform trust or safety.</li>
                                <li>Reviews may appear on service pages, provider profiles, or other platform areas.</li>
                            </ul>
                        </div>
                    </article>

                    <article class="legal-page__item">
                        <div class="legal-page__number">8</div>
                        <div class="legal-page__body">
                            <h2>Account restrictions</h2>
                            <p>
                                We may restrict, suspend, or remove accounts when needed to protect users and the platform.
                            </p>

                            <ul>
                                <li>This may apply to fraud, fake bookings, false provider documents, abusive behavior, or repeated policy violations.</li>
                                <li>Restricted users may lose access to bookings, service listings, or provider dashboard features.</li>
                            </ul>
                        </div>
                    </article>

                    <article class="legal-page__item">
                        <div class="legal-page__number">9</div>
                        <div class="legal-page__body">
                            <h2>Platform availability</h2>
                            <p>
                                We aim to keep {{ $platformName }} available and working properly, but we do not guarantee that the platform will always be uninterrupted, error-free, or available at all times.
                            </p>
                        </div>
                    </article>

                    <article class="legal-page__item">
                        <div class="legal-page__number">10</div>
                        <div class="legal-page__body">
                            <h2>Changes to these terms</h2>
                            <p>
                                We may update these terms when platform features, policies, operations, or legal requirements change. Continued use of {{ $platformName }} means you accept the latest version posted on this page.
                            </p>
                        </div>
                    </article>

                    <article class="legal-page__item legal-page__item--contact">
                        <div class="legal-page__number">11</div>
                        <div class="legal-page__body">
                            <h2>Contact us</h2>
                            <p>
                                For questions about these terms, contact us at
                                <a href="mailto:{{ $supportEmail }}">{{ $supportEmail }}</a>.
                            </p>
                        </div>
                    </article>

                </div>
            </div>
        </section>
    </main>
@endsection