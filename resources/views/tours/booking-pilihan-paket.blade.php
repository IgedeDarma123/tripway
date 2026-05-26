<div class="max-w-4xl mx-auto bg-white border border-green-100 rounded-16 shadow-lg p-4 md:p-5 overflow-hidden">
        <!-- Header -->
bg-gradient-to-br from-green-50/80 to-emerald-50/80
            <!-- Header -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
                <div class="text-center md:text-left">
                    <h2 class="text-2xl md:text-3xl font-black bg-gradient-to-r from-orange-500 to-orange-600 bg-clip-text text-transparent drop-shadow-lg">
                        Pilihan paket
                    </h2>
                    <p class="text-base md:text-lg text-gray-600 mt-1 font-medium">Tentukan tanggal dan paket</p>
                </div>
                <div class="flex gap-2 w-full md:w-auto justify-center md:justify-start">
                    <button class="bg-orange-500 hover:bg-orange-600 text-white px-4 md:px-6 py-2 md:py-3 rounded-2xl font-semibold shadow-lg transition-all flex items-center gap-2 text-xs md:text-sm whitespace-nowrap">
                        <i class="fas fa-calendar-check text-xs md:text-sm"></i> Cek ketersediaan
                    </button>
                    <a href="#" class="text-orange-500 hover:text-orange-600 font-semibold flex items-center gap-1 text-xs md:text-sm whitespace-nowrap">
                        <i class="fas fa-arrow-left"></i> Pilih ulang
                    </a>
                </div>
            </div>
        </div>

        <!-- Content -->
    <div class="p-3 space-y-2 grid grid-cols-1 gap-1 h-[60vh] overflow-y-auto pb-20">
            <!-- Tanggal -->
            <div class="space-y-3">
                <label class="block text-sm font-bold text-gray-800 uppercase tracking-wide">Tanggal partisipasi <span class="text-orange-500">*</span></label>
                <div class="flex gap-3">
                    <input type="date" class="flex-1 p-3 border border-gray-200 rounded-xl text-base focus:ring-4 focus:ring-orange-200 focus:border-orange-500 transition-all shadow-sm placeholder-gray-400" min="{{ date('Y-m-d') }}" placeholder="Pilih tanggal">
                    <button class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-xl font-bold shadow-lg transition-all flex items-center gap-2 whitespace-nowrap text-sm">
                        <i class="fas fa-search"></i>
                        Cek
                    </button>
                </div>
            </div>

            <!-- Diskon Banner -->
            <div class="bg-gradient-to-r from-orange-50 to-amber-50 p-4 rounded-2xl border border-orange-200 shadow-md">
                <div class="flex items-center gap-3">
                    <div class="bg-orange-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg">
                        Diskon
                    </div>
                    <div class="flex-1">
                        <h4 class="font-bold text-sm text-gray-900">Lihat paket dengan diskon</h4>
                        <p class="text-xs text-gray-600 mt-1">Hemat hingga 20% untuk booking sekarang</p>
                    </div>
                    <i class="fas fa-arrow-right text-orange-500 text-lg"></i>
                </div>
            </div>

            <!-- Jenis Paket -->
            <div>
                <label class="block text-sm font-bold text-gray-800 uppercase tracking-wide mb-4">Jenis paket <span class="text-orange-500">*</span></label>
                <div class="grid grid-cols-1 gap-2 md:gap-2.5">
                    <button class="pilihan-paket-btn p-4 rounded-2xl border-2 border-gray-200 hover:border-orange-400 hover:shadow-md transition-all group">
                        <div class="flex justify-between items-center">
                            <div>
                                <div class="font-bold text-sm mb-1">Layanan Penjemputan Hotel Bali</div>
                                <div class="text-lg md:text-xl font-black text-orange-500 mb-1">Rp1.200.000</div>
                                <div class="text-xs text-gray-600">Maks 10 orang</div>
                            </div>
                            <i class="fas fa-chevron-right text-gray-400 group-hover:text-orange-500 transition-all"></i>
                        </div>
                    </button>
                    <button class="pilihan-paket-btn selected p-4 rounded-2xl border-2 border-orange-500 bg-orange-50 shadow-md ring-2 ring-orange-100/50">
                        <div class="flex justify-between items-center">
                            <div>
                                <div class="font-bold text-sm mb-1">Sanur Harbor</div>
                                <div class="text-lg md:text-xl font-black text-orange-500 mb-1">Rp944.000</div>
                                <div class="text-xs text-orange-600 font-semibold">Maks 8 orang</div>
                            </div>
                            <div class="bg-orange-500 text-white text-xs font-bold px-2 py-1 rounded-full shadow-lg">
                                Diskon 20%
                            </div>
                        </div>
                    </button>
                    <button class="pilihan-paket-btn p-4 rounded-2xl border-2 border-gray-200 hover:border-orange-400 hover:shadow-md transition-all group">
                        <div class="flex justify-between items-center">
                            <div>
                                <div class="font-bold text-sm mb-1">Nusa Penida Manta</div>
                                <div class="text-lg md:text-xl font-black text-orange-500 mb-1">Rp1.100.000</div>
                                <div class="text-xs text-gray-600">Maks 6 orang</div>
                            </div>
                            <i class="fas fa-chevron-right text-gray-400 group-hover:text-orange-500 transition-all"></i>
                        </div>
                    </button>
                    <button class="pilihan-paket-btn p-4 rounded-2xl border-2 border-gray-200 hover:border-orange-400 hover:shadow-md transition-all group">
                        <div class="flex justify-between items-center">
                            <div>
                                <div class="font-bold text-sm mb-1">Hotel Nusa Penida</div>
                                <div class="text-lg md:text-xl font-black text-orange-500 mb-1">Rp1.350.000</div>
                                <div class="text-xs text-gray-600">Maks 4 orang</div>
                            </div>
                            <i class="fas fa-chevron-right text-gray-400 group-hover:text-orange-500 transition-all"></i>
                        </div>
                    </button>
                </div>
            </div>

            <!-- Toggle Pilihan -->
            <div>
                <label class="block text-sm font-bold text-gray-800 uppercase tracking-wide mb-4">Pilihan</label>
                <div class="flex gap-3">
                    <button class="flex-1 pilihan-toggle selected p-3 rounded-xl border-2 border-orange-500 bg-orange-500 text-white font-bold shadow-md transition-all">
                        Private
                    </button>
                    <button class="flex-1 pilihan-toggle p-3 rounded-xl border-2 border-gray-200 bg-white font-bold hover:border-orange-400 transition-all shadow-sm">
                        Shared
                    </button>
                </div>
            </div>

            <!-- Jumlah Compact -->
            <div>
                <label class="block text-sm font-bold text-gray-800 uppercase tracking-wide mb-3 md:mb-4">Jumlah</label>
                <div class="space-y-2 max-h-48 overflow-y-auto -mx-2 px-2">
                    @for($i = 6; $i >= 2; $i--)
                        <div class="flex items-center justify-between p-3 md:p-4 bg-white/70 backdrop-blur-sm rounded-xl border shadow-sm hover:shadow-md transition-all">
                            <span class="font-semibold text-sm">Grup {{ $i }} Orang</span>
                            <div class="flex items-center gap-2">
                                <button class="w-9 h-9 bg-gray-200 hover:bg-gray-300 rounded-lg flex items-center justify-center text-lg font-bold transition-all text-gray-600">-</button>
                                <span class="text-lg font-bold w-10 text-center text-gray-900 min-w-[2.5rem]">0</span>
                                <button class="w-9 h-9 bg-orange-500 hover:bg-orange-600 text-white rounded-lg flex items-center justify-center text-lg font-bold shadow-sm transition-all">+</button>
                            </div>
                        </div>
                    @endfor
                    <div class="flex items-center justify-between p-3 md:p-4 bg-white/70 backdrop-blur-sm rounded-xl border shadow-sm hover:shadow-md transition-all">
                        <span class="font-semibold text-sm">Solo Traveler</span>
                        <div class="flex items-center gap-2">
                            <button class="w-9 h-9 bg-gray-200 hover:bg-gray-300 rounded-lg flex items-center justify-center text-lg font-bold transition-all text-gray-600">-</button>
                            <span class="text-lg font-bold w-10 text-center text-gray-900 min-w-[2.5rem]">0</span>
                            <button class="w-9 h-9 bg-orange-500 hover:bg-orange-600 text-white rounded-lg flex items-center justify-center text-lg font-bold shadow-sm transition-all">+</button>
                        </div>
                    </div>
                    <div class="flex items-center justify-between p-3 md:p-4 bg-white/70 backdrop-blur-sm rounded-xl border shadow-sm hover:shadow-md transition-all">
                        <span class="font-semibold text-xs">Skuter Bawah Air 2 Jam</span>
                        <div class="flex items-center gap-2">
                            <button class="w-9 h-9 bg-gray-200 hover:bg-gray-300 rounded-lg flex items-center justify-center text-lg font-bold transition-all text-gray-600">-</button>
                            <span class="text-lg font-bold w-10 text-center text-gray-900 min-w-[2.5rem]">0</span>
                            <button class="w-9 h-9 bg-orange-500 hover:bg-orange-600 text-white rounded-lg flex items-center justify-center text-lg font-bold shadow-sm transition-all">+</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Footer -->
            <div class="p-4 md:p-6 pt-0 bg-gradient-to-r from-orange-50 to-amber-50 border-t border-orange-200">
                <div class="p-4 md:p-6 bg-white/80 backdrop-blur-md rounded-2xl shadow-xl border border-gray-200">
                <div class="flex justify-between items-end mb-4">
                    <span class="text-base font-bold text-gray-800 tracking-wide uppercase">Total</span>
                    <div class="text-2xl md:text-3xl font-black text-gray-900">Rp 944.000</div>
                </div>
                <div class="space-y-3">
                    <button class="w-full bg-white border-2 border-orange-400 hover:border-orange-500 text-orange-500 hover:text-orange-600 py-2.5 md:py-3 px-4 md:px-6 rounded-xl font-bold shadow-lg hover:shadow-xl transition-all text-xs md:text-sm uppercase tracking-wide">
                        Tambah ke keranjang
                    </button>
                    <button class="w-full bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white py-2.5 md:py-3 px-4 md:px-6 rounded-xl font-bold shadow-2xl hover:shadow-3xl transition-all text-xs md:text-sm uppercase tracking-wide">
                        Pesan sekarang
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.pilihan-paket-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.pilihan-paket-btn').forEach(b => b.classList.remove('selected'));
            this.classList.add('selected');
        });
    });
    
    document.querySelectorAll('.pilihan-toggle').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.pilihan-toggle').forEach(b => b.classList.remove('selected'));
            this.classList.add('selected');
        });
    });
    
    document.querySelectorAll('.jumlah-row').forEach(row => {
        const minus = row.querySelector('button:first-child');
        const plus = row.querySelector('button:last-child');
        const countEl = row.querySelector('span:nth-child(3)');
        
        minus.addEventListener('click', () => {
            let val = parseInt(countEl.textContent);
            if (val > 0) countEl.textContent = val - 1;
        });
        
        plus.addEventListener('click', () => {
            let val = parseInt(countEl.textContent);
            countEl.textContent = val + 1;
        });
    });
});
</script>

<style>
.pilihan-paket-btn {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
.pilihan-paket-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}
.pilihan-paket-btn.selected {
    border-color: #F97316 !important;
    background: linear-gradient(135deg, #F97316 0%, #FB923C 100%) !important;
    color: white !important;
    transform: translateY(-2px);
}
.pilihan-toggle.selected {
    border-color: #F97316 !important;
    background: linear-gradient(135deg, #F97316 0%, #FB923C 100%) !important;
    color: white !important;
}
</style>
