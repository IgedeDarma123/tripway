@props(['packages', 'addons'])

<section class="pilihan-paket-section mb-16">
<div class="container">
        <div class="tour-detail">
            <div>
                <div class="tour-gallery">
                    <img src="{{ $tour->image ?? 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=1200' }}" alt="{{ $tour->title }}">
                </div>
                <div class="tour-gallery">
                    <img src="https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=1200" alt="ATV Ubud" class="w-full h-96 object-cover rounded-3xl shadow-2xl">
                </div>
                <div class="space-y-6">
                    <div class="tour-header">
                        <h1 class="text-4xl md:text-5xl font-bold text-gray-900 leading-tight">ATV Off-Road Ubud Adventure</h1>
                        <p class="text-xl text-gray-600 mt-4 leading-relaxed">Rasakan sensasi ATV melalui sawah hijau, sungai jernih, dan gua misterius di Ubud. Petualangan nyata!</p>
                    </div>
                    <div class="highlights bg-white p-8 rounded-3xl shadow-xl border border-gray-100">
                        <h2 class="text-2xl font-bold mb-6 flex items-center gap-3 text-gray-800">
                            <i class="fas fa-star text-orange-500"></i>
                            Highlights
                        </h2>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div class="flex items-start gap-3 p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl hover:shadow-md transition-all">
                                <i class="fas fa-route text-blue-500 mt-1 text-xl"></i>
                                <div>
                                    <h4 class="font-semibold text-gray-900">Track off-road menantang</h4>
                                    <p class="text-sm text-gray-600">4km lintasan profesional</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3 p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-2xl hover:shadow-md transition-all">
                                <i class="fas fa-mountain text-green-500 mt-1 text-xl"></i>
                                <div>
                                    <h4 class="font-semibold text-gray-900">Sawah, sungai & gua</h4>
                                    <p class="text-sm text-gray-600">Pemandangan alam memukau</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3 p-4 bg-gradient-to-r from-orange-50 to-amber-50 rounded-2xl hover:shadow-md transition-all">
                                <i class="fas fa-motorcycle text-orange-500 mt-1 text-xl"></i>
                                <div>
                                    <h4 class="font-semibold text-gray-900">ATV single atau tandem</h4>
                                    <p class="text-sm text-gray-600">Pilih sesuai kebutuhan</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3 p-4 bg-gradient-to-r from-purple-50 to-violet-50 rounded-2xl hover:shadow-md transition-all">
                                <i class="fas fa-user-tie text-purple-500 mt-1 text-xl"></i>
                                <div>
                                    <h4 class="font-semibold text-gray-900">Guide profesional</h4>
                                    <p class="text-sm text-gray-600">Bahasa Indonesia/Inggris</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Jadwal Perjalanan -->
                    <div class="jadwal bg-white p-8 rounded-3xl shadow-xl border border-gray-100">
                        <h2 class="text-2xl font-bold mb-8 flex items-center gap-3 text-gray-800">
                            <i class="fas fa-clock text-blue-500"></i>
                            Jadwal Perjalanan
                        </h2>
                        <div class="space-y-6">
                            <div class="jadwal-item flex items-start gap-6 p-6 bg-gradient-to-r from-indigo-50 to-blue-50 rounded-2xl border-l-4 border-indigo-400 hover:shadow-lg transition-all">
                                <div class="jadwal-time w-24 font-mono text-xl font-bold text-indigo-600 bg-indigo-100 px-4 py-2 rounded-xl">
                                    09:00
                                </div>
                                <div>
                                    <h4 class="font-semibold text-lg mb-2">Penjemputan dari hotel</h4>
                                    <p class="text-gray-700">Pickup gratis dari Kuta/Seminyak/Ubud area</p>
                                </div>
                            </div>
                            <div class="jadwal-item flex items-start gap-6 p-6 bg-gradient-to-r from-emerald-50 to-green-50 rounded-2xl border-l-4 border-emerald-400 hover:shadow-lg transition-all">
                                <div class="jadwal-time w-24 font-mono text-xl font-bold text-emerald-600 bg-emerald-100 px-4 py-2 rounded-xl">
                                    10:00
                                </div>
                                <div>
                                    <h4 class="font-semibold text-lg mb-2">Briefing & latihan</h4>
                                    <p class="text-gray-700">Safety training dan practice session</p>
                                </div>
                            </div>
                            <div class="jadwal-item flex items-start gap-6 p-6 bg-gradient-to-r from-orange-50 to-amber-50 rounded-2xl border-l-4 border-orange-400 hover:shadow-lg transition-all">
                                <div class="jadwal-time w-24 font-mono text-xl font-bold text-orange-600 bg-orange-100 px-4 py-2 rounded-xl">
                                    10:30
                                </div>
                                <div>
                                    <h4 class="font-semibold text-lg mb-2">Start ATV adventure</h4>
                                    <p class="text-gray-700">Track pertama - sawah & sungai</p>
                                </div>
                            </div>
                            <div class="jadwal-item flex items-start gap-6 p-6 bg-gradient-to-r from-yellow-50 to-amber-50 rounded-2xl border-l-4 border-yellow-400 hover:shadow-lg transition-all">
                                <div class="jadwal-time w-24 font-mono text-xl font-bold text-yellow-600 bg-yellow-100 px-4 py-2 rounded-xl">
                                    12:00
                                </div>
                                <div>
                                    <h4 class="font-semibold text-lg mb-2">Istirahat siang</h4>
                                    <p class="text-gray-700">Lunch break di basecamp</p>
                                </div>
                            </div>
                            <div class="jadwal-item flex items-start gap-6 p-6 bg-gradient-to-r from-purple-50 to-violet-50 rounded-2xl border-l-4 border-purple-400 hover:shadow-lg transition-all">
                                <div class="jadwal-time w-24 font-mono text-xl font-bold text-purple-600 bg-purple-100 px-4 py-2 rounded-xl">
                                    12:30
                                </div>
                                <div>
                                    <h4 class="font-semibold text-lg mb-2">Track kedua - gua misterius</h4>
                                    <p class="text-gray-700">Adventure track paling menantang</p>
                                </div>
                            </div>
                            <div class="jadwal-item flex items-start gap-6 p-6 bg-gradient-to-r from-emerald-50 to-green-50 rounded-2xl border-l-4 border-emerald-400 hover:shadow-lg transition-all">
                                <div class="jadwal-time w-24 font-mono text-xl font-bold text-emerald-600 bg-emerald-100 px-4 py-2 rounded-xl">
                                    14:30
                                </div>
                                <div>
                                    <h4 class="font-semibold text-lg mb-2">Kembali ke basecamp</h4>
                                    <p class="text-gray-700">Photo session & sertifikat</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Sticky Package Selection -->
                <div class="lg:sticky lg:top-8 space-y-6">
                    <div class="pilihan-paket-card bg-white rounded-3xl shadow-2xl border border-orange-100 overflow-hidden sticky top-8 z-10">
                        <div class="p-8 pb-4 border-b border-orange-100 bg-gradient-to-br from-orange-50 to-amber-50">
                            <div class="flex justify-between items-start mb-6">
                                <div>
                                    <h2 class="text-3xl font-black bg-gradient-to-r from-orange-500 to-orange-600 bg-clip-text text-transparent">
                                        Pilihan paket
                                    </h2>
                                    <p class="text-lg text-gray-600 mt-1">Tentukan tanggal dan paket</p>
                                </div>
                                <div class="flex gap-3">
                                    <button class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-2xl font-semibold shadow-lg transition-all flex items-center gap-2">
                                        <i class="fas fa-calendar-check"></i> Cek ketersediaan
                                    </button>
                                    <a href="#" class="text-orange-500 hover:text-orange-600 font-semibold flex items-center gap-1">
                                        <i class="fas fa-arrow-left"></i> Pilih ulang
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="p-8 space-y-8">
                            <!-- Tanggal -->
                            <div class="border-b pb-8">
                                <label class="block text-lg font-semibold text-gray-800 mb-3">
                                    Pilih tanggal partisipasi
                                </label>
                                <div class="flex gap-3">
                                    <input type="date" class="flex-1 p-4 border border-gray-200 rounded-2xl text-lg focus:ring-4 focus:ring-orange-200 focus:border-orange-500 transition-all shadow-sm">
                                    <button class="bg-orange-500 hover:bg-orange-600 text-white px-8 py-4 rounded-2xl font-bold shadow-lg transition-all flex items-center gap-2 whitespace-nowrap">
                                        <i class="fas fa-calendar-check"></i>
                                        Cek ketersediaan
                                    </button>
                                </div>
                            </div>

                            <!-- Diskon Banner -->
                            <div class="bg-gradient-to-r from-orange-100 to-amber-100 p-6 rounded-3xl border border-orange-200 shadow-md">
                                <div class="flex items-center gap-3">
                                    <div class="bg-orange-500 text-white text-sm font-bold px-4 py-2 rounded-full shadow-lg">
                                        Diskon
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-lg text-gray-900">Lihat paket dengan diskon</h4>
                                        <p class="text-sm text-gray-600">Hemat hingga 20% untuk booking sekarang</p>
                                    </div>
                                    <i class="fas fa-arrow-right text-orange-500 text-xl ml-auto"></i>
                                </div>
                            </div>

                            <!-- Jenis Paket -->
                            <div>
                                <label class="block text-lg font-bold text-gray-800 mb-6">Jenis paket <span class="text-orange-500">*</span></label>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <button class="pilihan-paket-btn group relative overflow-hidden rounded-3xl border-2 shadow-lg transition-all duration-300 hover:shadow-2xl hover:-translate-y-1 focus:outline-none focus:ring-4 focus:ring-orange-200 p-6 md:p-8">
                                        <div class="absolute inset-0 bg-gradient-to-r from-orange-500 to-orange-600 opacity-0 group-hover:opacity-10 transition-opacity"></div>
                                        <div class="font-bold text-xl mb-3 relative z-10 text-gray-900 group-hover:text-white transition-colors">Layanan Penjemputan & Pengantaran Hotel di Pulau Utama Bali</div>
                                        <div class="text-3xl font-black text-orange-500 relative z-10 mb-2 group-hover:text-orange-200 transition-colors">Rp 1.200.000</div>
                                        <div class="text-sm text-gray-600 relative z-10">Maks 10 orang</div>
                                    </button>
                                    <button class="pilihan-paket-btn selected border-orange-500 bg-orange-50 shadow-orange-200 ring-4 ring-orange-100/50 relative overflow-hidden rounded-3xl shadow-lg transition-all duration-300 hover:shadow-2xl hover:-translate-y-1 focus:outline-none focus:ring-4 focus:ring-orange-200 p-6 md:p-8">
                                        <div class="absolute inset-0 bg-gradient-to-r from-orange-500 to-orange-600 opacity-20"></div>
                                        <div class="font-bold text-xl mb-3 relative z-10 text-orange-600">Bertemu di Sanur Harbor</div>
                                        <div class="text-3xl font-black text-orange-500 relative z-10 mb-2">Rp 944.000</div>
                                        <div class="text-sm text-orange-600 relative z-10 font-semibold">Maks 8 orang</div>
                                        <div class="absolute top-4 left-4 bg-orange-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg">
                                            Diskon 20%
                                        </div>
                                    </button>
                                    <button class="pilihan-paket-btn group relative overflow-hidden rounded-3xl border-2 shadow-lg transition-all duration-300 hover:shadow-2xl hover:-translate-y-1 focus:outline-none focus:ring-4 focus:ring-orange-200 p-6 md:p-8">
                                        <div class="absolute inset-0 bg-gradient-to-r from-orange-500 to-orange-600 opacity-0 group-hover:opacity-10 transition-opacity"></div>
                                        <div class="font-bold text-xl mb-3 relative z-10 text-gray-900 group-hover:text-white transition-colors">Bertemu di "Manta Fish Snorkeling" Nusa Penida</div>
                                        <div class="text-3xl font-black text-orange-500 relative z-10 mb-2 group-hover:text-orange-200 transition-colors">Rp 1.100.000</div>
                                        <div class="text-sm text-gray-600 relative z-10">Maks 6 orang</div>
                                    </button>
                                    <button class="pilihan-paket-btn group relative overflow-hidden rounded-3xl border-2 shadow-lg transition-all duration-300 hover:shadow-2xl hover:-translate-y-1 focus:outline-none focus:ring-4 focus:ring-orange-200 p-6 md:p-8">
                                        <div class="absolute inset-0 bg-gradient-to-r from-orange-500 to-orange-600 opacity-0 group-hover:opacity-10 transition-opacity"></div>
                                        <div class="font-bold text-xl mb-3 relative z-10 text-gray-900 group-hover:text-white transition-colors">Penjemputan & Pengantaran Hotel di Nusa Penida</div>
                                        <div class="text-3xl font-black text-orange-500 relative z-10 mb-2 group-hover:text-orange-200 transition-colors">Rp 1.350.000</div>
                                        <div class="text-sm text-gray-600 relative z-10">Maks 4 orang</div>
                                    </button>
                                </div>
                            </div>

                            <!-- Pilihan Aktivitas -->
                            <div>
                                <label class="block text-lg font-bold text-gray-800 mb-6">Pilihan</label>
                                <div class="flex gap-4 mb-8">
                                    <button class="flex-1 pilihan-toggle selected p-6 md:p-8 rounded-3xl border-4 border-orange-500 bg-orange-500 text-white shadow-2xl ring-4 ring-orange-100/50 transition-all duration-300 hover:shadow-3xl hover:-translate-y-1">
                                        <i class="fas fa-ship text-3xl mb-4 block"></i>
                                        <div class="font-bold text-xl">Private Snorkeling Boat</div>
                                    </button>
                                    <button class="flex-1 pilihan-toggle p-6 md:p-8 rounded-3xl border-2 border-gray-200 bg-white shadow-lg transition-all duration-300 hover:shadow-xl hover:-translate-y-1 hover:border-orange-400">
                                        <i class="fas fa-users text-3xl mb-4 block text-orange-500"></i>
                                        <div class="font-bold text-xl text-gray-900">Perahu Snorkeling Bersama</div>
                                    </button>
                                </div>
                            </div>

                            <!-- Jumlah Peserta -->
                            <div>
                                <label class="block text-lg font-bold text-gray-800 mb-6">Jumlah</label>
                                <div class="space-y-4">
                                    <div class="jumlah-row flex items-center justify-between p-6 bg-white rounded-2xl border shadow-sm hover:shadow-md transition-all group">
                                        <span class="font-semibold text-lg">Grup Berisi 6 Orang (Harga Per Orang)</span>
                                        <div class="flex items-center gap-4">
                                            <button class="w-12 h-12 bg-gray-200 hover:bg-gray-300 rounded-xl flex items-center justify-center text-xl font-bold transition-all group-hover:bg-orange-100">-</button>
                                            <span class="text-2xl font-black min-w-16 text-center text-gray-900">0</span>
                                            <button class="w-12 h-12 bg-orange-500 hover:bg-orange-600 text-white rounded-xl flex items-center justify-center text-xl font-bold shadow-md transition-all">+</button>
                                        </div>
                                    </div>
                                    <!-- Repeat for 5,4,3,2 orang -->
                                    <div class="jumlah-row flex items-center justify-between p-6 bg-white rounded-2xl border shadow-sm hover:shadow-md transition-all group">
                                        <span class="font-semibold text-lg">Wisatawan Tunggal</span>
                                        <div class="flex items-center gap-4">
                                            <button class="w-12 h-12 bg-gray-200 hover:bg-gray-300 rounded-xl flex items-center justify-center text-xl font-bold transition-all group-hover:bg-orange-100">-</button>
                                            <span class="text-2xl font-black min-w-16 text-center text-gray-900">0</span>
                                            <button class="w-12 h-12 bg-orange-500 hover:bg-orange-600 text-white rounded-xl flex items-center justify-center text-xl font-bold shadow-md transition-all">+</button>
                                        </div>
                                    </div>
                                    <div class="jumlah-row flex items-center justify-between p-6 bg-white rounded-2xl border shadow-sm hover:shadow-md transition-all">
                                        <span class="font-semibold text-lg mb-2">Tambahan: Sewa Skuter Bawah Air 2 Jam</span>
                                        <div class="flex items-center gap-4">
                                            <button class="w-12 h-12 bg-gray-200 hover:bg-gray-300 rounded-xl flex items-center justify-center text-xl font-bold transition-all">-</button>
                                            <span class="text-2xl font-black min-w-16 text-center text-gray-900">0</span>
                                            <button class="w-12 h-12 bg-orange-500 hover:bg-orange-600 text-white rounded-xl flex items-center justify-center text-xl font-bold shadow-md transition-all">+</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sticky Footer -->
                        <div class="p-6 pt-0 bg-gradient-to-r from-orange-50 to-amber-50 border-t-2 border-orange-200">
                            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4 lg:gap-8 p-6 bg-white/80 backdrop-blur-md rounded-3xl shadow-xl border border-gray-200">
                                <div>
                                    <p class="text-sm text-gray-600 uppercase tracking-wide font-medium">Total harga</p>
                                    <div class="text-4xl font-black text-gray-900 mt-1">Rp 944.000</div>
                                </div>
                                <div class="flex flex-col sm:flex-row gap-3">
                                    <button class="flex-1 bg-white border-2 border-orange-400 hover:border-orange-500 text-orange-500 hover:text-orange-600 px-8 py-4 rounded-2xl font-bold shadow-lg hover:shadow-xl transition-all text-sm uppercase tracking-wide">
                                        Tambah ke keranjang
                                    </button>
                                    <button class="flex-1 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-8 py-4 rounded-2xl font-bold shadow-2xl hover:shadow-3xl transition-all text-sm uppercase tracking-wide">
                                        Pesan sekarang
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Sticky Package Selection -->
        <div class="lg:sticky lg:top-8 space-y-6">
            <div class="pilihan-paket-card bg-white rounded-3xl shadow-2xl border border-orange-100 overflow-hidden sticky top-8 z-10">
                <div class="p-8 pb-4 border-b border-orange-100 bg-gradient-to-br from-orange-50 to-amber-50">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h2 class="text-3xl font-black bg-gradient-to-r from-orange-500 to-orange-600 bg-clip-text text-transparent">
                                Pilihan paket
                            </h2>
                            <p class="text-lg text-gray-600 mt-1">Tentukan tanggal dan paket</p>
                        </div>
                        <div class="flex gap-3">
                            <button class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-2xl font-semibold shadow-lg transition-all flex items-center gap-2">
                                <i class="fas fa-calendar-check"></i> Cek ketersediaan
                            </button>
                            <a href="#" class="text-orange-500 hover:text-orange-600 font-semibold flex items-center gap-1">
                                <i class="fas fa-arrow-left"></i> Pilih ulang
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Rest of sticky card content... -->
            </div>
        </div>
    </div>

    <script>
        // Vanilla JS for interactivity
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle buttons
            const toggles = document.querySelectorAll('.pilihan-toggle, .pilihan-paket-btn');
            toggles.forEach(btn => {
                btn.addEventListener('click', function() {
                    this.classList.toggle('selected');
                    this.classList.toggle('border-orange-500');
                    this.classList.toggle('bg-orange-500');
                    this.classList.toggle('text-white');
                });
            });

            // Counter buttons
            const minusBtns = document.querySelectorAll('.jumlah-row button:first-child');
            const plusBtns = document.querySelectorAll('.jumlah-row button:last-child');
            const counters = document.querySelectorAll('.jumlah-row span:nth-child(2)');
            
            minusBtns.forEach((btn, index) => {
                btn.addEventListener('click', () => {
                    let count = parseInt(counters[index].textContent);
                    if (count > 0) counters[index].textContent = count - 1;
                });
            });
            
            plusBtns.forEach((btn, index) => {
                btn.addEventListener('click', () => {
                    let count = parseInt(counters[index].textContent);
                    counters[index].textContent = count + 1;
                    updateTotal();
                });
            });

            function updateTotal() {
                // Realtime total calculation
                let total = 0;
                counters.forEach((counter, index) => {
                    total += parseInt(counter.textContent) * 944000; // Base price
                });
                // Update total display
            }
        });
    </script>

<style>
    /* Custom styles for perfect Klook clone */
    .pilihan-paket-btn {
        position: relative;
        cursor: pointer;
    }
    .pilihan-paket-btn.selected {
        border-color: #F97316 !important;
        background: linear-gradient(135deg, #F97316, #FB923C) !important;
        color: white !important;
        box-shadow: 0 20px 25px -5px rgb(245 158 11 / 0.4), 0 10px 10px -5px rgb(245 158 11 / 0.2) !important;
    }
    .pilihan-toggle.selected {
        border-color: #F97316 !important;
        background: linear-gradient(135deg, #F97316, #FB923C) !important;
        color: white !important;
        box-shadow: 0 20px 25px -5px rgb(245 158 11 / 0.4) !important;
    }
    .jadwal-item:hover {
        transform: translateX(8px);
        box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);
    }
    .jumlah-row:hover {
        transform: translateY(-2px);
    }
    
    /* Responsive */
    @media (max-width: 1024px) {
        .tour-detail {
            grid-template-columns: 1fr;
            gap: 2rem;
        }
    }
    
    /* Smooth scroll */
    html {
        scroll-behavior: smooth;
    }
</style>
