    data-packages='{{ json_encode($packages) }}' data-addons='{{ json_encode($addons) }}'>
    <!-- Header -->
    <div class="mb-8 text-center md:text-left">
        <h2 class="text-3xl md:text-4xl font-black bg-gradient-to-r from-orange-500 to-orange-600 bg-clip-text text-transparent mb-4">
            Pilihan Paket
        </h2>
        <p class="text-xl text-gray-600 font-medium mb-6">Tentukan tanggal dan paket untuk petualangan Anda</p>
        
        <!-- Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center mb-8">
            <button @click="checkAvailability()" class="btn-orange px-8 py-4 text-lg flex items-center gap-3">
                <i class="fas fa-calendar-check"></i>
                Cek Ketersediaan
            </button>
            <button class="btn-secondary px-8 py-4 text-lg flex items-center gap-3" onclick="history.back()">
                <i class="fas fa-arrow-left"></i>
                Pilih Ulang
            </button>
        </div>
    </div>

    <!-- Package Selection -->
    <div class="mb-12">
        <label class="block text-lg font-semibold text-gray-800 mb-6">Jenis Paket <span class="text-orange-500">*</span></label>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <template x-for="(pkg, index) in packages" :key="index">
                <button 
                    @click="selectPackage(index)"
                    :class="[
                        'package-tab border-2 text-left p-6 md:p-8 rounded-2xl shadow-lg transition-all duration-300 hover:shadow-2xl hover:-translate-y-1 focus:outline-none focus:ring-4 focus:ring-orange-200',
                        selectedPackageIndex === index ? 'package-tab-active border-orange-500 ring-4 ring-orange-100' : 'border-gray-200 hover:border-orange-300 hover:bg-orange-50 text-gray-800'
                    ]"
                    x-html="pkg.discount > 0 ? `<div class='absolute -top-3 left-4 px-3 py-1 bg-orange-500 text-white text-xs font-bold rounded-full'>Diskon ${pkg.discount}%</div>` : ''"
                >
                    <div class="relative z-10">
                        <div class="font-bold text-xl mb-2 leading-tight" x-text="pkg.name"></div>
                        <div class="text-2xl font-black text-orange-500 mb-1" x-text="'Rp ' + formatPrice(pkg.price)"></div>
                        <div x-show="pkg.max_group" class="text-sm text-gray-600" x-text="`Maks ${pkg.max_group} orang`"></div>
                    </div>
                </button>
            </template>
        </div>
    </div>

    <!-- Toggle Private/Shared -->
    <div class="mb-12">
        <label class="block text-lg font-semibold text-gray-800 mb-6 flex items-center gap-3">
            <i class="fas fa-users text-orange-500"></i>
            Pilih Tipe Grup
        </label>
        <div class="flex gap-4">
            <button 
                @click="toggleType('private')"
                class="flex-1 p-4 rounded-xl border-2 font-semibold transition-all duration-300 shadow-md"
                :class="groupType === 'private' ? 'bg-orange-500 text-white border-orange-500 shadow-orange-200 ring-2 ring-orange-200' : 'border-gray-200 hover:border-orange-300 hover:bg-orange-50'"
            >
                <i class="fas fa-user-friends text-lg mb-2 block" :class="groupType === 'private' ? 'text-white' : 'text-orange-500'"></i>
                Private (Full)
            </button>
            <button 
                @click="toggleType('shared')"
                class="flex-1 p-4 rounded-xl border-2 font-semibold transition-all duration-300 shadow-md"
                :class="groupType === 'shared' ? 'bg-orange-500 text-white border-orange-500 shadow-orange-200 ring-2 ring-orange-200' : 'border-gray-200 hover:border-orange-300 hover:bg-orange-50'"
            >
                <i class="fas fa-user-group text-lg mb-2 block" :class="groupType === 'shared' ? 'text-white' : 'text-orange-500'"></i>
                Shared
            </button>
        </div>
    </div>

    <!-- Participants Counters -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
        <!-- Group -->
        <div>
            <label class="block text-lg font-semibold text-gray-800 mb-4 flex items-center gap-3">
                <i class="fas fa-users text-orange-500"></i>
                Grup 6-2 orang <span class="text-sm text-gray-500">(min 2 orang)</span>
            </label>
            <div class="flex items-center gap-4 p-6 bg-gray-50 rounded-2xl">
                <button @click="changeGroup(-1)" class="counter-btn" :disabled="groupCount <= 2">-</button>
                <span class="text-2xl font-bold text-gray-800 min-w-[3rem] text-center" x-text="groupCount"></span>
                <button @click="changeGroup(1)" class="counter-btn">+</button>
                <div class="ml-auto text-right">
                    <div class="text-lg font-semibold text-gray-800" x-text="formatPrice(groupSubtotal)"></div>
                    <div class="text-sm text-gray-500">/grup</div>
                </div>
            </div>
        </div>

        <!-- Solo -->
        <div>
            <label class="block text-lg font-semibold text-gray-800 mb-4 flex items-center gap-3">
                <i class="fas fa-user text-orange-500"></i>
                Solo Traveler
            </label>
            <div class="flex items-center gap-4 p-6 bg-gray-50 rounded-2xl">
                <button @click="changeSolo(-1)" class="counter-btn" :disabled="soloCount === 0">-</button>
                <span class="text-2xl font-bold text-gray-800 min-w-[3rem] text-center" x-text="soloCount"></span>
                <button @click="changeSolo(1)" class="counter-btn">+</button>
                <div class="ml-auto text-right">
                    <div class="text-lg font-semibold text-gray-800" x-text="formatPrice(soloSubtotal)"></div>
                    <div class="text-sm text-gray-500">/orang</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add-ons -->
    <div v-if="addons.length > 0" class="mb-12">
        <label class="block text-lg font-semibold text-gray-800 mb-6 flex items-center gap-3">
            <i class="fas fa-plus-circle text-orange-500"></i>
            Add-on Opsional
        </label>
        <div class="space-y-3">
            <template x-for="(addon, index) in addons" :key="index">
                <label class="flex items-center p-4 border border-gray-200 rounded-xl hover:border-orange-300 hover:bg-orange-50 cursor-pointer transition-all group">
                    <input type="checkbox" :value="addon.name" x-model="selectedAddons" class="sr-only">
                    <div class="flex items-center gap-4 flex-1">
                        <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center group-hover:bg-orange-200 transition-colors">
                            <i class="fas fa-tools text-orange-500 text-lg"></i>
                        </div>
                        <div>
                            <div class="font-semibold text-gray-800" x-text="addon.name"></div>
                            <div class="text-sm text-gray-600" x-text="`+ ${formatPrice(addon.price)}`"></div>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="font-bold text-lg text-orange-500" x-text="formatPrice(selectedAddons.includes(addon.name) ? addon.price : 0)"></div>
                    </div>
                </label>
            </template>
        </div>
    </div>

    <!-- Total & CTA -->
    <div class="border-t pt-8">
        <div class="flex flex-col lg:flex-row justify-between items-end gap-6 bg-gradient-to-r from-orange-50 to-amber-50 p-8 rounded-2xl">
            <div>
                <div class="text-4xl font-black text-gray-900 mb-2" x-text="formatPrice(total)"></div>
                <div class="text-xl text-gray-600 font-medium" x-text="packages[selectedPackageIndex]?.name || ''"></div>
            </div>
            <div class="flex flex-col sm:flex-row gap-4 w-full lg:w-auto">
                <button 
                    @click="addToCart()" 
                    :disabled="!isValid"
                    class="btn-secondary py-4 px-8 text-lg flex-1 flex items-center justify-center gap-3"
                    :class="{ 'opacity-50 cursor-not-allowed': !isValid }"
                >
                    <i class="fas fa-cart-plus"></i>
                    Tambah ke Keranjang
                </button>
                <form :action="bookingRoute" method="POST" x-ref="form">
                    @csrf
                    <input type="hidden" name="destination_id" :value="destinationId">
                    <input type="hidden" name="package_index" x-model="selectedPackageIndex">
                    <input type="hidden" name="group_count" x-model="groupCount">
                    <input type="hidden" name="solo_count" x-model="soloCount">
                    <input type="hidden" name="addons" x-model="selectedAddonsJSON">
                    <button 
                        type="submit"
                        :disabled="!isValid"
                        class="btn-orange py-4 px-8 text-lg flex-1 flex items-center justify-center gap-3 font-bold"
                        :class="{ 'opacity-50 cursor-not-allowed': !isValid }"
                    >
                        <i class="fas fa-credit-card"></i>
                        Pesan Sekarang
                    </button>
                </form>
            </div>
        </div>
        <p class="text-xs text-gray-500 mt-4 text-center" x-show="!isValid">* Wajib pilih paket dan minimal 1 peserta</p>
    </div>
</div>

<script>
function destinationPackages() {
    return {
        init() {
            this.packages = JSON.parse(this.$el.getAttribute('data-packages') || '[]');
            this.addons = JSON.parse(this.$el.dataset.addons || '[]');
        },
        selectedPackageIndex: 0,
        groupType: 'private',
        groupCount: 2,
        soloCount: 0,
        selectedAddons: [],

        selectPackage(index) {
            this.selectedPackageIndex = index;
            this.updateTotal();
        },

        toggleType(type) {
            this.groupType = type;
            if (type === 'solo') {
                this.groupCount = 0;
                this.soloCount = 1;
            } else {
                this.soloCount = 0;
            }
            this.updateTotal();
        },

        changeGroup(delta) {
            if (this.groupCount + delta < 2) return;
            if (this.groupCount + delta > (this.packages[this.selectedPackageIndex]?.max_group || 6)) return;
            this.groupCount += delta;
            this.updateTotal();
        },

        changeSolo(delta) {
            if (this.soloCount + delta < 0) return;
            this.soloCount += delta;
            this.updateTotal();
        },

        get groupSubtotal() {
            const pkg = this.packages[this.selectedPackageIndex];
            return this.groupCount * (pkg?.price || 0);
        },

        get soloSubtotal() {
            const pkg = this.packages[this.selectedPackageIndex];
            return this.soloCount * (pkg?.price * 0.8 || 0); // 20% solo discount
        },

        get addonsSubtotal() {
            return this.selectedAddons.reduce((sum, name) => {
                const addon = this.addons.find(a => a.name === name);
                return sum + (addon?.price || 0);
            }, 0);
        },

        get total() {
            return this.groupSubtotal + this.soloSubtotal + this.addonsSubtotal;
        },

        get isValid() {
            return this.selectedPackageIndex >= 0 && (this.groupCount > 0 || this.soloCount > 0);
        },

        updateTotal() {
            // Trigger reactivity
        },

        formatPrice(price) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(price);
        },

        checkAvailability() {
            alert('Checking availability for ' + this.packages[this.selectedPackageIndex].name);
        },

        addToCart() {
            if (!this.isValid) return;
            // Add to cart logic
            console.log('Added to cart:', this.getCartData());
        },

        get selectedAddonsJSON() {
            return JSON.stringify(this.selectedAddons);
        },

        getCartData() {
            return {
                package: this.packages[this.selectedPackageIndex],
                groupCount: this.groupCount,
                soloCount: this.soloCount,
                addons: this.selectedAddons,
                total: this.total
            };
        }
    }
}
</script>

