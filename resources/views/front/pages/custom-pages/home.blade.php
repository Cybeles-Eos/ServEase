@extends('front.layouts.base')

@section('content')
    <main class="main-page page--home">
        <section class="section--hero m-padding">
            {{-- <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">logoout</button>
            </form> --}}
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
        <section style="width: 100%; height: 100vh">

        </section>
    </main>
@endsection
@push('extrascripts')
    <script>
        $(document).ready(function () {

            const services = [
                'Plumber - Residential Pipe Repair Services',
                'Plumber - Emergency Leak and Drain Repair',
                'Electrician - Home Wiring and Panel Upgrade',
                'Electrician - Lighting Installation and Repair',
                'Painter - Interior and Exterior Wall Finishing',
                'Painter - Residential Repainting Services',
                'Carpenter - Custom Furniture and Wood Repair',
                'Carpenter - Door Cabinet and Shelf Installation',
                'Aircon - Installation Maintenance and Repair',
                'Aircon - Residential Cooling System Services',
                'Cleaner - Deep House Cleaning and Sanitizing',
                'Cleaner - Move In and Move Out Cleaning',
                'Technician - Appliance Diagnostics and Repair',
                'Technician - Home Device Maintenance Services',
                'Gardener - Lawn Care and Landscape Maintenance',
                'Gardener - Outdoor Planting and Trimming',
                'Mechanic - Vehicle Repair and Maintenance',
                'Mechanic - Engine Check and Tune Up',
                'Pest Control - Termite and Insect Treatment',
                'Pest Control - Home Protection Services'
            ];

            let selectedService = '';

            const $input = $('#serviceSearch');
            const $listBox = $('.sh-inp-lists');
            const $list = $('#serviceList');
            const $notFound = $('.serv-not-found');
            const $btn = $('#view');

            // Filter services on typing
            $input.on('keyup', function () {
                const keyword = $(this).val().toLowerCase().trim();
                if ($(this).val().trim().length === 0) {
                    $btn.text('Search');
                }
                
                selectedService = ''; // reset selection
                //$btn.prop('disabled', true);
                $list.find('li').remove();

                if (!keyword) {
                    $listBox.hide();
                    return;
                }   

                const matches = services.filter(service =>
                    service.toLowerCase().includes(keyword)
                );

                if (matches.length) {
                    $notFound.hide();

                    matches.forEach(service => {
                        $list.append(`
                            <li>
                                <a href="#" data-service="${service}">
                                    ${service}
                                </a>
                            </li>
                        `);
                    });

                } else {
                    $notFound.show();
                }

                $listBox.show();
            });

            // Click service → fill input
            $(document).on('click', '.sh-inp-lists a', function (e) {
                e.preventDefault();

                selectedService = $(this).data('service');
                $input.val(selectedService);
                $listBox.hide();

                $btn.prop('disabled', false);
                $btn.text('Get Started');
            });

            // Search button → redirect
            $('#view').on('click', function () {
                const inputValue = $input.val().trim();

                if (!inputValue) return;

                // normalize input for comparison
                const normalizedInput = inputValue.toLowerCase();

                // check if input exists in services
                const matchedService = services.find(service =>
                    service.toLowerCase() === normalizedInput
                );

                if (matchedService) {
                    // service exists → service detail
                    const slug = matchedService
                        .toLowerCase()
                        .replace(/[^a-z0-9]+/g, '-')
                        .replace(/(^-|-$)/g, '');

                    // window.location.href = `/services/${slug}`;
                    window.location.href = `/services/${slug}`;

                } else {
                    // service does NOT exist → contact page
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
@endpush