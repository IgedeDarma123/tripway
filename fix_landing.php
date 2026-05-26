<?php
$file = 'd:/tripway/tripway/resources/views/landing.blade.php';
$lines = file($file);

$output = [];
for ($i = 0; $i < 667; $i++) {
    $output[] = $lines[$i];
}

$append = <<<'HTML'
    <!-- CTA -->
    <section class="cta-section" style="padding: 80px 0; background: url('https://images.unsplash.com/photo-1555400038-63f5ba517a47?w=1920&auto=format&fit=crop') center/cover; position: relative;">
        <div style="position: absolute; inset: 0; background: rgba(0,0,0,0.3);"></div>
        <div class="container" style="position: relative; z-index: 2; text-align: center; color: white;">
            <h2 style="font-size: 36px; font-weight: 800; margin-bottom: 16px;">Siap Memulai Petualanganmu?</h2>
            <p style="font-size: 18px; opacity: 0.95; margin-bottom: 32px; max-width: 500px; margin-left: auto; margin-right: auto;">Bergabung dengan ribuan wisatawan yang telah menjelajahi Bali bersama TripWay.</p>
            <a href="{{ route('tours.index') }}" class="btn btn-lg" style="background: white; color: var(--primary);">Jelajahi Sekarang</a>
        </div>
    </section>

    <!-- Partners Section -->
    <section class="partners-section" style="padding: 40px 0; background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
        <div class="container">
            <p style="text-align:center; font-size:12px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:1px; margin-bottom:24px;">Tersedia juga di platform terpercaya</p>
            <div class="partners-logo-container" style="display: flex; gap: 16px; align-items: center; justify-content: center; flex-wrap: wrap;">
                @php
                    $partners = [
                        ['name' => 'tiket.com', 'url' => asset('images/partners/tiket.webp')],
                        ['name' => 'Traveloka', 'url' => asset('images/partners/traveloka.webp')],
                        ['name' => 'Trip.com', 'url' => asset('images/partners/trip.png')],
                        ['name' => 'Expedia', 'url' => asset('images/partners/expedia.png')],
                        ['name' => 'Klook', 'url' => asset('images/partners/klook.png')],
                        ['name' => 'Viator', 'url' => asset('images/partners/viator.svg')],
                        ['name' => 'Airbnb', 'url' => asset('images/partners/airbnb.webp')],
                        ['name' => 'Booking.com', 'url' => asset('images/partners/booking.webp')],
                        ['name' => 'GetYourGuide', 'url' => asset('images/partners/getyourguide.png')]
                    ];
                @endphp
                
                @foreach($partners as $partner)
                <div style="background: white; border-radius: 12px; padding: 12px 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); display: flex; align-items: center; justify-content: center; min-width: 110px; height: 56px; transition: transform 0.2s; cursor: pointer;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.08)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 1px 3px rgba(0,0,0,0.05)'">
                    <img src="{{ $partner['url'] }}" alt="{{ $partner['name'] }}" style="max-height: 20px; max-width: 90px; object-fit: contain;" onerror="this.outerHTML='<span style=\'font-weight:700; color:#1B3A4B; font-size:14px;\'>{{ $partner['name'] }}</span>'">
                </div>
                @endforeach
                
                <!-- Google 5 Stars -->
                <div style="background: white; border-radius: 12px; padding: 10px 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); display: flex; flex-direction: column; align-items: center; justify-content: center; min-width: 110px; height: 56px; transition: transform 0.2s; cursor: pointer;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.08)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 1px 3px rgba(0,0,0,0.05)'">
                    <img src="{{ asset('images/partners/google.jpg') }}" alt="Google" style="max-height: 16px; margin-bottom: 4px; object-fit: contain;" onerror="this.outerHTML='<span style=\'font-weight:700; color:#1B3A4B; font-size:14px; margin-bottom:4px;\'>Google</span>'">
                    <div style="color: #fbbc04; font-size: 10px; display:flex; gap:2px;"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                </div>
            </div>
        </div>
    </section>
@endsection
HTML;

$output[] = $append;

file_put_contents($file, implode("", $output));
echo "Fixed landing.blade.php\n";
