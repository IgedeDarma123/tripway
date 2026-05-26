@props(['packages', 'addons', 'tourPrice' => 0])

<div 
    x-data="pilihanPaket()" 
    data-packages='{{ json_encode($packages) }}' 
    data-addons='{{ json_encode($addons) }}'
    data-tour-price="{{ $tourPrice }}"
    class="bg-gray-50 rounded-3xl shadow-xl p-8 md:p-12 max-w-4xl mx-auto border border-gray-200"
>
    <!-- Header -->
    <div class="flex justify-between items-start mb-10">
        <div>
from-[#111827] to-slate-800
                Pilihan Paket
            </h2>
            <p class="text-xl text-gray-600">Tentukan tanggal dan paket</p>
        </div>
        <div class="flex gap-3">
            <button @click="cekKetersediaan()" class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-xl font-semibold transition-all flex items-center gap-2">
                <i class="fas fa-calendar-check"></i>
                Cek ketersediaan
            </button>
            <a href="#" onclick="history.back()" class="text-orange-500 hover:text-orange-600 font-semibold">
                <i class="fas fa-arrow-left"></i> Pilih ulang
            </a>
        </div>
    </div>

    <!-- Jenis Paket -->
    <div class="mb-12">
        <label class="block text-xl font-bold text-gray-800 mb-6">Jenis Paket <span class="text-orange-500">*</span></label>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <template x-for="(paket, index) in packages" :key="index">
                <button 
                    @click="pilihPaket(index)"
                    class="p-6 md:p-8 rounded-2xl border-2 transition-all duration-300 relative group hover:shadow-xl hover:-translate-y-1 focus:outline-none focus:ring-4 focus:ring-orange-200"
border-green-500 bg-green-50 shadow-green-200 ring-4 ring-green-100
                >
                    <div x-show="paket.diskon > 0" class="absolute -top-3 left-4 bg-orange-500 text-white text-xs font-bold px-3 py-1 rounded-full">
                        Diskon <span x-text="paket.diskon + '%'"></span>
                    </div>
                    <div class="font-bold text-xl mb-3" x-text="paket.nama"></div>
                    <div class="text-2xl font-black text-orange-500 mb-2" x-text="'Rp ' + formatRupiah(paket.harga)"></div>
                    <div x-show="paket.max_grup" class="text-sm text-gray-600" x-text="'Maks ' + paket.max_grup + ' orang'"></div>
                </button>
            </template>
        </div>
    </div>

    <!-- Pilihan Aktivitas Toggle -->
    <div class="mb-12">
        <label class="block text-xl font-bold text-gray-800 mb-6">Pilihan Aktivitas</label>
        <div class="flex gap-4">
            <button 
                @click="toggleAktivitas('private')"
                class="flex-1 p-5 rounded-2xl border-2 font-semibold transition-all duration-300"
                :class="tipeAktivitas === 'private' ? 'border-orange-500 bg-orange-500 text-white shadow-lg ring-2 ring-orange-200' : 'border-gray-300 hover:border-orange-400 bg-gray-50'"
            >
                <i class="fas fa-ship text-2xl mb-3 block" :class="tipeAktivitas === 'private' ? 'text-white' : 'text-orange-500'"></i>
                Private Snorkeling Boat
            </button>
            <button 
                @click="toggleAktivitas('shared')"
                class="flex-1 p-5 rounded-2xl border-2 font-semibold transition-all duration-300"
                :class="tipeAktivitas === 'shared' ? 'border-orange-500 bg-orange-500 text-white shadow-lg ring-2 ring-orange-200' : 'border-gray-300 hover:border-orange-400 bg-gray-50'"
            >
                <i class="fas fa-users text-2xl mb-3 block" :class="tipeAktivitas === 'shared' ? 'text-white' : 'text-orange-500'"></i>
                Perahu Snorkeling Bersama
            </button>
        </div>
    </div>

    <!-- Jumlah Peserta Counters -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-12">
        <!-- Grup -->
        <div>
            <h3 class="text-lg font-bold text-gray-800 mb-4">Grup Peserta</h3>
            <div class="space-y-3">
                 <div class="flex items-center justify-between p-4 bg-white rounded-xl border shadow-sm hover:shadow-md transition-all" data-max="6">
                     <span>Grup 6 orang</span>
                     <div class="flex items-center gap-3">
                         <button @click="ubahJumlah('grup6', -1)" class="w-10 h-10 bg-gray-200 hover:bg-gray-300 rounded-lg flex items-center justify-center">-</button>
                         <span class="text-xl font-bold min-w-12 text-center" x-text="jumlah['grup6'] || 0"></span>
                         <button @click="ubahJumlah('grup6', 1)" class="w-10 h-10 bg-orange-500 hover:bg-orange-600 text-white rounded-lg flex items-center justify-center">+</button>
                     </div>
                 </div>
                 <!-- Repeat for grup5, grup4, grup3, grup2 -->
                 <div class="flex items-center justify-between p-4 bg-white rounded-xl border shadow-sm hover:shadow-md transition-all" data-max="5">
                     <span>Grup 5 orang</span>
                     <div class="flex items-center gap-3">
                         <button @click="ubahJumlah('grup5', -1)" class="w-10 h-10 bg-gray-200 hover:bg-gray-300 rounded-lg flex items-center justify-center">-</button>
                         <span class="text-xl font-bold min-w-12 text-center" x-text="jumlah['grup5'] || 0"></span>
                         <button @click="ubahJumlah('grup5', 1)" class="w-10 h-10 bg-orange-500 hover:bg-orange-600 text-white rounded-lg flex items-center justify-center">+</button>
                     </div>
                 </div>
                 <div class="flex items-center justify-between p-4 bg-white rounded-xl border shadow-sm hover:shadow-md transition-all" data-max="4">
                     <span>Grup 4 orang</span>
                     <div class="flex items-center gap-3">
                         <button @click="ubahJumlah('grup4', -1)" class="w-10 h-10 bg-gray-200 hover:bg-gray-300 rounded-lg flex items-center justify-center">-</button>
                         <span class="text-xl font-bold min-w-12 text-center" x-text="jumlah['grup4'] || 0"></span>
                         <button @click="ubahJumlah('grup4', 1)" class="w-10 h-10 bg-orange-500 hover:bg-orange-600 text-white rounded-lg flex items-center justify-center">+</button>
                     </div>
                 </div>
                 <div class="flex items-center justify-between p-4 bg-white rounded-xl border shadow-sm hover:shadow-md transition-all" data-max="3">
                     <span>Grup 3 orang</span>
                     <div class="flex items-center gap-3">
                         <button @click="ubahJumlah('grup3', -1)" class="w-10 h-10 bg-gray-200 hover:bg-gray-300 rounded-lg flex items-center justify-center">-</button>
                         <span class="text-xl font-bold min-w-12 text-center" x-text="jumlah['grup3'] || 0"></span>
                         <button @click="ubahJumlah('grup3', 1)" class="w-10 h-10 bg-orange-500 hover:bg-orange-600 text-white rounded-lg flex items-center justify-center">+</button>
                     </div>
                 </div>
                 <div class="flex items-center justify-between p-4 bg-white rounded-xl border shadow-sm hover:shadow-md transition-all" data-max="2">
                     <span>Grup 2 orang</span>
                     <div class="flex items-center gap-3">
                         <button @click="ubahJumlah('grup2', -1)" class="w-10 h-10 bg-gray-200 hover:bg-gray-300 rounded-lg flex items-center justify-center">-</button>
                         <span class="text-xl font-bold min-w-12 text-center" x-text="jumlah['grup2'] || 0"></span>
                         <button @click="ubahJumlah('grup2', 1)" class="w-10 h-10 bg-orange-500 hover:bg-orange-600 text-white rounded-lg flex items-center justify-center">+</button>
                     </div>
                 </div>
            </div>
        </div>
        
        <!-- Add-on -->
        <div>
            <h3 class="text-lg font-bold text-gray-800 mb-4">Add-on</h3>
            <div class="space-y-3">
                <div class="flex items-center justify-between p-4 bg-white rounded-xl border shadow-sm hover:shadow-md transition-all">
                    <span>Sewa Skuter</span>
                    <div class="flex items-center gap-3">
                        <button @click="ubahAddOn('skuter', false)" class="w-10 h-10 bg-gray-200 hover:bg-gray-300 rounded-lg flex items-center justify-center">-</button>
                        <span class="text-xl font-bold min-w-12 text-center" x-text="addons['skuter'] ? '✓' : '0'"></span>
                        <button @click="ubahAddOn('skuter', true)" class="w-10 h-10 bg-orange-500 hover:bg-orange-600 text-white rounded-lg flex items-center justify-center">+</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total & CTA -->
    <div class="border-t pt-8 mt-12">
        <div class="bg-gradient-to-r from-orange-50 to-amber-50 p-8 rounded-2xl">
            <div class="flex justify-between items-center mb-6">
                <span class="text-3xl font-bold text-gray-900" x-text="formatRupiah(totalHarga)"></span>
                <span class="text-xl text-gray-600" x-text="packages[selectedPaket]?.nama || ''"></span>
            </div>
            <div class="flex gap-4">
                <button @click="tambahKeranjang()" :disabled="!isValid()" class="flex-1 bg-yellow-400 hover:bg-yellow-500 text-gray-800 py-4 px-6 rounded-xl font-bold transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                    Tambah ke keranjang
                </button>
                <button @click="pesanSekarang()" :disabled="!isValid()" class="flex-1 bg-orange-500 hover:bg-orange-600 text-white py-4 px-6 rounded-xl font-bold transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                    Pesan sekarang
                </button>
            </div>
        </div>
    </div>
</div>

 <script>
 function pilihanPaket() {
     return {
         init() {
             this.packages = JSON.parse(this.$el.getAttribute('data-packages') || '[]');
             this.addons = JSON.parse(this.$el.getAttribute('data-addons') || '[]');
             this.tourBasePrice = parseInt(this.$el.getAttribute('data-tour-price')) || 0;
         },
         selectedPaket: 0,
         tipeAktivitas: 'private',
         jumlah: {},
         addons: {},
         tourBasePrice: 0,
         pilihPaket(index) {
             this.selectedPaket = index;
             this.hitungTotal();
         },
         toggleAktivitas(tipe) {
             this.tipeAktivitas = tipe;
             this.hitungTotal();
         },
         ubahJumlah(key, delta) {
             if (!this.jumlah[key]) this.jumlah[key] = 0;
             let max = Infinity;
             if (key === 'solo') max = 1;
             else if (key.startsWith('grup')) max = parseInt(key.replace('grup', ''));
             if (delta < 0) {
                 this.jumlah[key] = 0;
             } else {
                 this.jumlah[key] = max;
             }
             this.hitungTotal();
         },
         ubahAddOn(key, tambah) {
             this.addons[key] = tambah;
             this.hitungTotal();
         },
         get totalHarga() {
             const totalPeople = Object.values(this.jumlah).reduce((sum, val) => sum + (parseInt(val) || 0), 0);
             const packagePrice = this.packages[this.selectedPaket]?.harga || 0;
             return this.tourBasePrice + (totalPeople * packagePrice);
         },
         get isValid() {
             const totalPeople = Object.values(this.jumlah).reduce((sum, val) => sum + (parseInt(val) || 0), 0);
             return this.selectedPaket >= 0 && totalPeople > 0;
         },
         hitungTotal() {
             // Trigger update
         },
         formatRupiah(angka) {
             return 'Rp' + parseInt(angka).toLocaleString('id-ID');
         },
         cekKetersediaan() {
             alert('Cek ketersediaan...');
         },
         tambahKeranjang() {
             console.log('Added to cart');
         },
         pesanSekarang() {
             console.log('Booking now');
         }
     }
 }
 </script>

