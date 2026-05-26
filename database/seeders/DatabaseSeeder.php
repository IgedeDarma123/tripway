<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Destination;
use App\Models\Tour;
use App\Models\User;
use Database\Seeders\PaymentSettingsSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            PaymentSettingsSeeder::class,
        ]);
        // Categories
        $categories = [
            ['name' => 'Petualangan', 'slug' => 'petualangan', 'icon' => 'fa-hiking', 'sort_order' => 1],
            ['name' => 'Budaya & Sejarah', 'slug' => 'budaya-sejarah', 'icon' => 'fa-landmark', 'sort_order' => 2],
            ['name' => 'Kuliner', 'slug' => 'kuliner', 'icon' => 'fa-utensils', 'sort_order' => 3],
            ['name' => 'Wellness & Spa', 'slug' => 'wellness-spa', 'icon' => 'fa-spa', 'sort_order' => 4],
            ['name' => 'Alam & Wildlife', 'slug' => 'alam-wildlife', 'icon' => 'fa-leaf', 'sort_order' => 5],
            ['name' => 'Watersport', 'slug' => 'watersport', 'icon' => 'fa-water', 'sort_order' => 6],
        ];
        foreach ($categories as $cat) Category::create($cat);

        // Destinations
        $destinations = [
            ['name' => 'Ubud', 'slug' => 'ubud', 'image' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=600', 'description' => 'Pusat seni dan budaya Bali'],
            ['name' => 'Seminyak', 'slug' => 'seminyak', 'image' => 'https://images.unsplash.com/photo-1555400038-63f5ba517a47?w=600', 'description' => 'Pantai eksklusif dan vida malam'],
            ['name' => 'Uluwatu', 'slug' => 'uluwatu', 'image' => 'https://images.unsplash.com/photo-1539367628448-4bc5c9d171c8?w=600', 'description' => 'Pura di tebing dan pantai indah'],
            ['name' => 'Nusa Penida', 'slug' => 'nusa-penida', 'image' => 'https://images.unsplash.com/photo-1537956965359-7573183d1f57?w=600', 'description' => 'Surga tersembunyi dengan pemandangan spektakuler'],
            ['name' => 'Kuta', 'slug' => 'kuta', 'image' => 'https://images.unsplash.com/photo-1518548419970-58e3b4079ab2?w=600', 'description' => 'Pantai ikonik dan pusat perbelanjaan'],
            ['name' => 'Canggu', 'slug' => 'canggu', 'image' => 'https://images.unsplash.com/photo-1558005137-d9619a5c539f?w=600', 'description' => 'Surga berselancar dengan vibe santai'],
        ];
        foreach ($destinations as $dest) Destination::create($dest);

        // Tours
        $tours = [
            [
                'title' => 'Rafting Sungai Ayung Ubud',
                'slug' => 'rafting-sungai-ayung-ubud',
                'description' => 'Nikmati pengalaman rafting seru di Sungai Ayung, Ubud. Melintasi jeram dengan pemandangan hutan tropis dan tebing tinggi yang memukau. Aktivitas ini cocok untuk pemula maupun yang berpengalaman.',
                'highlights' => "Rafting di sungai sepanjang 12 km\nPemandangan hutan tropis dan tebing\nGuide berpengalaman & bersertifikat\nMakan siang tradisional Bali",
                'itinerary' => "08:00: Penjemputan di hotel\n09:30: Briefing keselamatan & persiapan\n10:00: Start rafting Sungai Ayung\n12:30: Finish rafting & makan siang\n14:00: Transfer kembali ke hotel",
                'inclusions' => "Penjemputan dari hotel\nPeralatan rafting lengkap\nGuide profesional\nMakan siang\nAsuransi",
                'exclusions' => "Pengeluaran pribadi\nTips untuk guide",
                'duration' => '5', 'duration_type' => 'hours', 'price' => 450000, 'original_price' => 600000,
                'image' => 'https://images.unsplash.com/photo-1537956965359-7573183d1f57?w=800',
                'rating' => 4.8, 'review_count' => 324, 'category_id' => 1, 'destination_id' => 1,
                'max_people' => 20, 'is_featured' => true, 'is_active' => true,
            ],
            [
                'title' => 'Sunrise Trekking Gunung Batur',
                'slug' => 'sunrise-trekking-gunung-batur',
                'description' => 'Saksikan matahari terbit spektakuler dari puncak Gunung Batur. Trekking di malam hari dengan guide lokal yang berpengalaman, diikuti dengan sarapan telur rebus di kawah vulkanik.',
                'highlights' => "Sunrise dari ketinggian 1.717 mdpl\nSarapan di kawah Gunung Batur\nGuide lokal berpengalaman\nPemandangan Danau Batur",
                'itinerary' => "01:30: Penjemputan di hotel\n03:00: Start trekking dari basecamp\n05:30: Sampai puncak & menikmati sunrise\n06:30: Sarapan di kawah\n08:00: Turun kembali\n09:30: Kembali ke hotel",
                'inclusions' => "Penjemputan\nGuide profesional\nSarapan sederhana\nAir mineral\nFlashlight",
                'exclusions' => "Jaket tebal (bisa disewa)\nTips",
                'duration' => '8', 'duration_type' => 'hours', 'price' => 550000, 'original_price' => 750000,
                'image' => 'https://images.unsplash.com/photo-1518548419970-58e3b4079ab2?w=800',
                'rating' => 4.9, 'review_count' => 512, 'category_id' => 1, 'destination_id' => 1,
                'max_people' => 15, 'is_featured' => true, 'is_active' => true,
            ],
            [
                'title' => 'Snorkeling Nusa Penida',
                'slug' => 'snorkeling-nusa-penida',
                'description' => 'Jelajahi keindahan bawah laut Nusa Penida dengan snorkeling di spot terbaik. Lihat Manta Ray, karang warna-warni, dan ikan tropis yang berlimpah.',
                'highlights' => "Snorkeling 4 spot terbaik\nBerkemungkinan lihat Manta Ray\nPerahu tradisional\nMakan siang di pantai",
                'itinerary' => "07:00: Penjemputan & transfer ke pelabuhan\n08:30: Berangkat ke Nusa Penida\n10:00: Snorkeling spot pertama\n12:00: Makan siang di pantai\n13:30: Snorkeling spot kedua\n15:00: Kembali ke Bali\n16:30: Sampai di hotel",
                'inclusions' => "Penjemputan\nTiket boat PP\nPeralatan snorkeling\nGuide\nMakan siang",
                'exclusions' => "Foto underwater\nTips",
                'duration' => '10', 'duration_type' => 'hours', 'price' => 850000, 'original_price' => 1100000,
                'image' => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=800',
                'rating' => 4.7, 'review_count' => 289, 'category_id' => 6, 'destination_id' => 4,
                'max_people' => 12, 'is_featured' => true, 'is_active' => true,
            ],
            [
                'title' => 'Kelas Memasak Bali Tradisional',
                'slug' => 'kelas-memasak-bali-tradisional',
                'description' => 'Pelajari seni memasak khas Bali dari chef lokal. Kunjungi pasar tradisional untuk memilih bahan segar, lalu masak 8 hidangan autentik Bali di setting pedesaan Ubud.',
                'highlights' => "Kunjungan pasar tradisional\nMasak 8 hidangan Bali\nResep untuk dibawa pulang\nMakan hasil masakan sendiri",
                'itinerary' => "08:00: Penjemputan\n08:30: Tour pasar tradisional\n09:30: Persiapan bahan\n10:00: Kelas memasak dimulai\n13:00: Makan siang bersama\n14:00: Selesai & kembali ke hotel",
                'inclusions' => "Penjemputan\nBahan masakan\nInstruktur chef\nResep\nMakan siang",
                'exclusions' => "Minuman beralkohol\nTips",
                'duration' => '6', 'duration_type' => 'hours', 'price' => 650000, 'original_price' => 800000,
                'image' => 'https://images.unsplash.com/photo-1507048331197-7d4ac70811cf?w=800',
                'rating' => 4.9, 'review_count' => 178, 'category_id' => 3, 'destination_id' => 1,
                'max_people' => 8, 'is_featured' => false, 'is_active' => true,
            ],
            [
                'title' => 'Surfing Lesson di Canggu',
                'slug' => 'surfing-lesson-canggu',
                'description' => 'Belajar berselancar di pantai Canggu yang terkenal dengan ombaknya yang ramah untuk pemula. Instruktur bersertifikat akan membimbing Anda dari dasar hingga berdiri di papan.',
                'highlights' => "Instruktur bersertifikat ISA\nPapan selancar & wetsuit\nFoto selancar gratis\nOmbak ramah pemula",
                'itinerary' => "09:00: Bertemu di pantai\n09:15: Teori dasar di pantai\n09:45: Praktik di air\n11:30: Istirahat\n12:00: Sesi kedua\n13:30: Selesai",
                'inclusions' => "Papan selancar\nWetsuit\nInstruktur\nAir mineral\nFoto",
                'exclusions' => "Sunscreen\nTips",
                'duration' => '4', 'duration_type' => 'hours', 'price' => 400000, 'original_price' => 500000,
                'image' => 'https://images.unsplash.com/photo-1502680390469-be75c86b636f?w=800',
                'rating' => 4.6, 'review_count' => 245, 'category_id' => 6, 'destination_id' => 6,
                'max_people' => 6, 'is_featured' => false, 'is_active' => true,
            ],
            [
                'title' => 'Tour Pura Uluwatu & Kecak Dance',
                'slug' => 'tour-pura-uluwatu-kecak-dance',
                'description' => 'Kunjungi Pura Uluwatu yang megah di atas tebing, saksikan sunset memukau, dan nikmati pertunjukan tari Kecak yang mempesona saat matahari terbenam.',
                'highlights' => "Pura Uluwatu di tebing 70 meter\nSunset spektakuler\nTari Kecak api tradisional\nGuide berpengetahuan luas",
                'itinerary' => "15:00: Penjemputan\n16:00: Sampai di Pura Uluwatu\n16:30: Tour pura & melihat kera\n17:30: Menunggu sunset\n18:00: Pertunjukan Kecak dimulai\n19:00: Kembali ke hotel",
                'inclusions' => "Penjemputan\nTiket masuk pura\nTiket pertunjukan Kecak\nGuide",
                'exclusions' => "Makan malam\nTips",
                'duration' => '4', 'duration_type' => 'hours', 'price' => 350000, 'original_price' => 450000,
                'image' => 'https://images.unsplash.com/photo-1539367628448-4bc5c9d171c8?w=800',
                'rating' => 4.8, 'review_count' => 567, 'category_id' => 2, 'destination_id' => 3,
                'max_people' => 25, 'is_featured' => true, 'is_active' => true,
            ],
            [
                'title' => 'Spa Bali Tradisional 2 Jam',
                'slug' => 'spa-bali-tradisional-2-jam',
                'description' => 'Relaksasi total dengan perawatan spa tradisional Bali. Pijat tubuh penuh dengan minyak esensial, lulur rempah Bali, dan mandi bunga untuk menyegarkan tubuh dan pikiran.',
                'highlights' => "Pijat tradisional Bali 90 menit\nLulur rempah Bali\nMandi bunga\nRuangan private",
                'itinerary' => "Sesuai jadwal: Kedatangan\nWelcome drink\nKonsultasi\nPijat tubuh\nLulur & mandi bunga\nSelesai",
                'inclusions' => "Pijat 90 menit\nLulur & mandi bunga\nWelcome drink\nTowel & amenities",
                'exclusions' => "Transportasi\nTips",
                'duration' => '2', 'duration_type' => 'hours', 'price' => 380000, 'original_price' => 500000,
                'image' => 'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?w=800',
                'rating' => 4.7, 'review_count' => 198, 'category_id' => 4, 'destination_id' => 2,
                'max_people' => 2, 'is_featured' => false, 'is_active' => true,
            ],
            [
                'title' => 'ATV Ride di Ubud',
                'slug' => 'atv-ride-ubud',
                'description' => 'Jelajahi pedesaan Ubud dengan ATV! Lewati sawah hijau, hutan, sungai, dan gua dalam petualangan off-road yang seru dan penuh tantangan.',
                'highlights' => "Track off-road menantang\nLewati sawah, sungai & gua\nATV single atau tandem\nGuide mendampingi",
                'itinerary' => "09:00: Penjemputan\n10:00: Briefing & latihan\n10:30: Start ATV ride\n12:00: Istirahat\n12:30: Lanjut track kedua\n13:30: Selesai & makan siang\n14:30: Kembali ke hotel",
                'inclusions' => "Penjemputan\nATV & helm\nGuide\nMakan siang\nAsuransi",
                'exclusions' => "Sepatu (bisa disewa)\nTips",
                'duration' => '5', 'duration_type' => 'hours', 'price' => 700000, 'original_price' => 900000,
                'image' => 'https://images.unsplash.com/photo-1558618666-fcd25c85f82e?w=800',
                'rating' => 4.5, 'review_count' => 156, 'category_id' => 1, 'destination_id' => 1,
                'max_people' => 10, 'is_featured' => false, 'is_active' => true,
            ],
            [
                'title' => 'Tour Taman Nasional Bali Barat',
                'slug' => 'taman-nasional-bali-barat',
                'description' => 'Jelajahi keindahan alam Taman Nasional Bali Barat. Trekking melalui hutan mangrove, spot burung Jalak Bali yang langka, dan snorkeling di terumbu karang yang masih alami.',
                'highlights' => "Trekking hutan mangrove\nSpotting Jalak Bali\nSnorkeling di terumbu karang\nPemandangan laut lepas",
                'itinerary' => "06:00: Penjemputan\n08:00: Trekking hutan\n10:00: Bird watching\n11:30: Snorkeling\n13:00: Makan siang\n14:30: Kembali ke hotel",
                'inclusions' => "Penjemputan\nGuide\nPeralatan snorkeling\nMakan siang\nTiket masuk",
                'exclusions' => "Pengeluaran pribadi\nTips",
                'duration' => '9', 'duration_type' => 'hours', 'price' => 950000, 'original_price' => 1200000,
                'image' => 'https://images.unsplash.com/photo-1447752875215-b2761acb3c5d?w=800',
                'rating' => 4.6, 'review_count' => 87, 'category_id' => 5, 'destination_id' => 1,
                'max_people' => 12, 'is_featured' => false, 'is_active' => true,
            ],
            [
                'title' => 'Sunset Dinner Cruise',
                'slug' => 'sunset-dinner-cruise',
                'description' => 'Nikmati makan malam romantis di atas kapal pesiar sambil menyaksikan sunset indah di Teluk Benoa. Hiburan live music, tari tradisional, dan makanan internasional.',
                'highlights' => "Sunset dari atas kapal\nMakan malam buffet internasional\nLive music & hiburan\nPemandangan pantai dari laut",
                'itinerary' => "16:30: Penjemputan\n17:00: Boarding kapal\n17:30: Kapal berlayar\n18:00: Sunset viewing\n18:30: Makan malam\n20:00: Hiburan\n21:00: Kembali ke dermaga",
                'inclusions' => "Penjemputan\nWelcome drink\nDinner buffet\nHiburan live\nAsuransi",
                'exclusions' => "Minuman beralkohol\nTips",
                'duration' => '4', 'duration_type' => 'hours', 'price' => 750000, 'original_price' => 950000,
                'image' => 'https://images.unsplash.com/photo-1544148103-0773bf10d330?w=800',
                'rating' => 4.4, 'review_count' => 134, 'category_id' => 3, 'destination_id' => 5,
                'max_people' => 50, 'is_featured' => false, 'is_active' => true,
            ],
            [
                'title' => 'Yoga Retreat di Ubud',
                'slug' => 'yoga-retreat-ubud',
                'description' => 'Mulai hari dengan sesi yoga di tengah sawah hijau Ubud. Kelas yang dipandu instruktur bersertifikat dengan pemandangan alam yang menenangkan jiwa.',
                'highlights' => "Yoga di tengah sawah\nInstruktur bersertifikat\nMeditasi & breathing\nHealthy breakfast",
                'itinerary' => "07:00: Kedatangan\n07:15: Sesi meditasi\n07:30: Yoga flow\n08:45: Breathing exercise\n09:00: Healthy breakfast\n09:30: Selesai",
                'inclusions' => "Kelas yoga\nMat yoga\nHealthy breakfast\nTeh herbal",
                'exclusions' => "Transportasi\nTips",
                'duration' => '2.5', 'duration_type' => 'hours', 'price' => 280000, 'original_price' => 350000,
                'image' => 'https://images.unsplash.com/photo-1506126613408-eca07ce68773?w=800',
                'rating' => 4.8, 'review_count' => 203, 'category_id' => 4, 'destination_id' => 1,
                'max_people' => 15, 'is_featured' => false, 'is_active' => true,
            ],
            [
                'title' => 'Tour Desa Tradisional Tenganan',
                'slug' => 'tour-desa-tradisional-tenganan',
                'description' => 'Kunjungi Desa Tenganan, salah satu desa adat Bali Aga yang masih mempertahankan tradisi kuno. Lihat tenun gringsing yang langka dan arsitektur tradisional unik.',
                'highlights' => "Desa adat Bali Aga asli\nTenun gringsing langka\nArsitektur tradisional\nInteraksi dengan warga lokal",
                'itinerary' => "08:00: Penjemputan\n09:30: Sampai di Tenganan\n09:45: Tour desa dengan guide lokal\n11:00: Demo tenun gringsing\n12:00: Makan siang tradisional\n13:30: Kembali ke hotel",
                'inclusions' => "Penjemputan\nGuide lokal\nMakan siang\nDonasi desa",
                'exclusions' => "Oleh-oleh\nTips",
                'duration' => '5', 'duration_type' => 'hours', 'price' => 550000, 'original_price' => 700000,
                'image' => 'https://images.unsplash.com/photo-1528360983277-13d401cdc186?w=800',
                'rating' => 4.7, 'review_count' => 112, 'category_id' => 2, 'destination_id' => 1,
                'max_people' => 10, 'is_featured' => false, 'is_active' => true,
            ],
        ];

        foreach ($tours as $tour) {
            Tour::create($tour);
        }

        // Update tour counts
        foreach (Destination::all() as $dest) {
            $dest->update(['tour_count' => $dest->tours()->count()]);
        }

        // Admin user
        User::create([
            'name' => 'Admin TripWay',
            'email' => 'admin@tripway.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);
    }
}
