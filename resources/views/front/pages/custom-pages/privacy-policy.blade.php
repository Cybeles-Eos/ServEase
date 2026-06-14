
@extends('front.layouts.base')

@section('title', 'Privacy Policy - Servease')

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
                <h1>Privacy Policy</h1>
                <span>
                    This Privacy Policy explains how {{ $platformName }} collects, uses, stores, and protects information from customers, service providers, and visitors who use our platform in {{ $serviceArea }}.
                </span>
            </div>
        </section>

        <section class="legal-page__content m-padding">
            <div class="m-width legal-page__content-inner">

                <div class="legal-page__intro">
                    <span>Last updated: {{ now()->format('F d, Y') }}</span>
                    <p>
                        {{ $platformName }} connects customers with local service providers. Customers can book services, while providers can list and manage their services after account review and approval.
                    </p>
                </div>

                <div class="legal-page__list">

                    <article class="legal-page__item">
                        <div class="legal-page__number">1</div>
                        <div class="legal-page__body">
                            <h2>Information we collect</h2>
                            <p>
                                We collect information needed to operate {{ $platformName }}, process bookings, review provider applications, and support platform safety.
                            </p>

                            <ul>
                                <li>
                                    <strong>Account information:</strong>
                                    Name, email address, phone number, password, address, role, and profile details.
                                </li>
                                <li>
                                    <strong>Customer information:</strong>
                                    Booking details, selected services, preferred schedule, service location, notes, reviews, ratings, and support messages.
                                </li>
                                <li>
                                    <strong>Provider information:</strong>
                                    Business or service profile, categories, pricing, availability, service area, contact details, application status, and approval records.
                                </li>
                                <li>
                                    <strong>Verification documents:</strong>
                                    Documents uploaded by providers for admin review and account verification.
                                </li>
                                <li>
                                    <strong>Technical information:</strong>
                                    Device type, browser type, IP address, pages visited, access times, login activity, and actions inside the platform.
                                </li>
                            </ul>
                        </div>
                    </article>

                    <article class="legal-page__item">
                        <div class="legal-page__number">2</div>
                        <div class="legal-page__body">
                            <h2>How we use your information</h2>
                            <p>
                                We use your information to manage accounts, handle bookings, verify providers, and improve the platform.
                            </p>

                            <ul>
                                <li>Create and manage customer and provider accounts.</li>
                                <li>Review, verify, approve, or decline provider applications.</li>
                                <li>Allow providers to create, update, and manage service listings.</li>
                                <li>Allow customers to browse services and submit booking requests.</li>
                                <li>Send booking updates, account notices, and service-related messages.</li>
                                <li>Respond to support requests, reports, disputes, and platform concerns.</li>
                                <li>Monitor activity to help prevent fraud, abuse, and unsafe platform use.</li>
                            </ul>
                        </div>
                    </article>

                    <article class="legal-page__item">
                        <div class="legal-page__number">3</div>
                        <div class="legal-page__body">
                            <h2>How information is shared</h2>
                            <p>
                                We share information only when needed to complete services, operate the platform, support users, or meet legal requirements.
                            </p>

                            <ul>
                                <li>
                                    <strong>With customers:</strong>
                                    Provider profiles, service listings, pricing, availability, ratings, and reviews may be visible.
                                </li>
                                <li>
                                    <strong>With providers:</strong>
                                    Customer name, contact details, schedule, service location, and request details may be shared for confirmed or requested bookings.
                                </li>
                                <li>
                                    <strong>With administrators:</strong>
                                    Authorized admins may access account, booking, document, and support information for platform management.
                                </li>
                                <li>
                                    <strong>With system providers:</strong>
                                    We may use trusted services for hosting, email delivery, file storage, notifications, analytics, and security.
                                </li>
                            </ul>

                            <p>
                                We do not sell your personal information.
                            </p>
                        </div>
                    </article>

                    <article class="legal-page__item">
                        <div class="legal-page__number">4</div>
                        <div class="legal-page__body">
                            <h2>Provider documents and application review</h2>
                            <p>
                                Providers may need to submit documents before getting full provider access. These documents help admins review if the provider can offer services on {{ $platformName }}.
                            </p>

                            <ul>
                                <li>Uploaded documents are used for provider verification and account review.</li>
                                <li>Only authorized administrators can access provider documents.</li>
                                <li>Provider approval may be declined, restricted, suspended, or removed for false information, safety concerns, or platform misuse.</li>
                            </ul>
                        </div>
                    </article>

                    <article class="legal-page__item">
                        <div class="legal-page__number">5</div>
                        <div class="legal-page__body">
                            <h2>Reviews, ratings, and public content</h2>
                            <p>
                                Some content submitted on the platform may be visible to other users.
                            </p>

                            <ul>
                                <li>Provider names, service profiles, prices, descriptions, and availability may appear on public service pages.</li>
                                <li>Customer ratings and reviews may appear on provider or service pages.</li>
                                <li>Users should avoid posting private or sensitive information in reviews, comments, or booking notes unless needed for the service.</li>
                            </ul>
                        </div>
                    </article>

                    <article class="legal-page__item">
                        <div class="legal-page__number">6</div>
                        <div class="legal-page__body">
                            <h2>Cookies and platform usage</h2>
                            <p>
                                {{ $platformName }} may use cookies, local storage, and similar technologies to support account login, user preferences, platform performance, and security.
                            </p>

                            <ul>
                                <li>Cookies help keep users logged in.</li>
                                <li>Cookies help remember platform preferences.</li>
                                <li>Cookies help improve performance and protect accounts.</li>
                            </ul>

                            <p>
                                Some features may not work properly if cookies are disabled in your browser.
                            </p>
                        </div>
                    </article>

                    <article class="legal-page__item">
                        <div class="legal-page__number">7</div>
                        <div class="legal-page__body">
                            <h2>Data security and retention</h2>
                            <p>
                                We use reasonable safeguards to protect stored information from unauthorized access, loss, misuse, or alteration.
                            </p>

                            <ul>
                                <li>We keep data while it is needed for accounts, bookings, provider review, support, safety, records, and legal purposes.</li>
                                <li>Some records may be kept after account closure for dispute handling, fraud prevention, audit records, or legal compliance.</li>
                                <li>Users are responsible for keeping their login details private.</li>
                            </ul>
                        </div>
                    </article>

                    <article class="legal-page__item">
                        <div class="legal-page__number">8</div>
                        <div class="legal-page__body">
                            <h2>Your choices and data concerns</h2>
                            <p>
                                You may contact us for help with account information, corrections, account access concerns, or privacy-related questions.
                            </p>

                            <ul>
                                <li>You may request help updating incorrect account details.</li>
                                <li>You may contact us about provider document concerns.</li>
                                <li>Some data may not be removed immediately if needed for active bookings, legal records, security checks, or dispute resolution.</li>
                            </ul>
                        </div>
                    </article>

                    <article class="legal-page__item">
                        <div class="legal-page__number">9</div>
                        <div class="legal-page__body">
                            <h2>Children’s privacy</h2>
                            <p>
                                {{ $platformName }} is intended for users who are legally allowed to create accounts, book services, or provide services. We do not knowingly collect personal information from children without proper consent or legal basis.
                            </p>
                        </div>
                    </article>

                    <article class="legal-page__item">
                        <div class="legal-page__number">10</div>
                        <div class="legal-page__body">
                            <h2>Policy updates</h2>
                            <p>
                                We may update this Privacy Policy when our platform, services, legal requirements, or data practices change. Updates will be posted on this page.
                            </p>
                        </div>
                    </article>

                    <article class="legal-page__item legal-page__item--contact">
                        <div class="legal-page__number">11</div>
                        <div class="legal-page__body">
                            <h2>Contact us</h2>
                            <p>
                                For privacy questions, account data concerns, provider document concerns, or requests related to your information, contact us at
                                <a href="mailto:{{ $supportEmail }}">{{ $supportEmail }}</a>.
                            </p>
                        </div>
                    </article>

                </div>
            </div>
        </section>
    </main>
@endsection

