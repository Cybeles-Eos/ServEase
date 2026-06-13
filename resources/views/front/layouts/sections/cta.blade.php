<section class="global-cta">
    @php
        $platform = getPlatformSettings();
        $serviceArea = $platform->service_area ?: 'Burgos Barangay Hall Rodriguez, Rizal';
    @endphp

    <div class="global-cta__main">
        <div class="global-cta__main--txt">
            <h2>Get Local Help Fast Anytime, Anywhere</h2>
            <p>Find trusted professionals in {{ $serviceArea }} for plumbing, aircon repair, and more. Quick, reliable, and affordable services are just a click away.</p>
            <a href="{{url('services')}}" class="btn btn--tertiary-n">Book Service Now</a>
        </div>  
        <div class="global-cta__main--img">
            <img src="{{asset('images/cta-vec.svg')}}" class="global-cta__main--img__vec" alt="vector">
            <img src="{{asset('images/cta-img.png')}}" class="global-cta__main--img__img" alt="image">
        </div>
    </div>
</section>
