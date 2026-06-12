<footer class="static-footer m-padding">
    @php
        $platform = getPlatformSettings();
        $cleanSupportHours = function ($value) {
            $value = preg_replace('/[^\x20-\x7E]/', '-', (string) $value);
            return trim(preg_replace('/-{2,}/', '-', $value));
        };
        $platformName = $platform->platform_name ?: 'ServEase';
        $tagline = $platform->platform_tagline ?: 'Service help with ease and convenience.';
        $serviceArea = $platform->service_area ?: 'Barangay Batasan Hills, Quezon City';
        $supportHours = $cleanSupportHours($platform->support_hours) ?: 'Mon-Sat, 8:00 AM - 5:00 PM';
        $privacyUrl = $platform->privacy_policy_url ?: route('privacy.policy');
        $termsUrl = $platform->terms_url ?: route('terms.conditions');
        $popularServices = \App\Models\Service::query()
            ->where('is_active', true)
            ->whereHas('ratings', fn ($query) => $query->where('is_visible', true))
            ->withAvg(['ratings as average_rating' => fn ($query) => $query->where('is_visible', true)], 'rating')
            ->withCount(['ratings as visible_ratings_count' => fn ($query) => $query->where('is_visible', true)])
            ->orderByDesc('visible_ratings_count')
            ->orderByDesc('average_rating')
            ->limit(5)
            ->get();
        $fallbackServices = [
            'Smart Water System Setup',
            'Sprinkler & Garden Plumbing',
            'Deep Drain & Clog Clearing',
            'Home Wiring and Panel Upgrade',
            'Faucet & Sink Installation',
        ];
    @endphp

    <div class="static-footer__main m-width">
        <div class="sfoomain-info">
            <a href="{{ url('/') }}" class="img-cta-foo">
                <img src="{{ asset('public/images/new-logo-l.png') }}" alt="{{ $platformName }}">
            </a>
            <p>{{ $tagline }} Serving {{ $serviceArea }}. Support Hours: {{ $supportHours }}.</p>
            <div class="footer-socials">
                <a href="{{ $platform->facebook_page ?: url('/') }}" aria-label="Facebook" @if($platform->facebook_page) target="_blank" rel="noopener noreferrer" @endif>
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="{{ url('/') }}" aria-label="Instagram">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="{{ url('/') }}" aria-label="LinkedIn">
                    <i class="fab fa-linkedin-in"></i>
                </a>
            </div>
        </div>
        <div class="sfoomain-links">
            <ul>
                <h4>General Links</h4>
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><a href="{{ url('/about-us') }}">About</a></li>
                <li><a href="{{ route('services.index') }}">Services</a></li>
                <li><a href="{{ route('contact') }}">Get in touch</a></li>
                <li><a href="{{ route('privacy.policy') }}">Privacy Policy</a></li>
            </ul>
            <ul>
                <h4>Popular Services</h4>
                @forelse ($popularServices as $service)
                    <li>
                        <a href="{{ $service->slug ? route('services.show', $service->slug) : route('services.index') }}" title="{{ $service->title }}">
                            {{ \Illuminate\Support\Str::limit($service->title, 31, '...') }}
                        </a>
                    </li>
                @empty
                    @foreach ($fallbackServices as $serviceName)
                        <li><a href="{{ route('services.index') }}">{{ $serviceName }}</a></li>
                    @endforeach
                @endforelse
            </ul>
        </div>
    </div>
    <div class="static-footer__bot m-width">
        <div>
            <a href="{{ $privacyUrl }}">Privacy Policy</a>
            <a href="{{ $termsUrl }}">Terms and conditions</a>
        </div>
        <p>Non Copyrighted &copy; {{ date('Y') }} {{ $platformName }}</p>
    </div>
</footer>
