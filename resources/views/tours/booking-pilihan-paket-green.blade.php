<div style="width:100%; background:#f1f5f9; border-radius:16px; box-shadow:0 4px 20px rgba(0,0,0,0.1); overflow:hidden; box-sizing:border-box;">
    <div class="rounded-2xl shadow-xl border border-slate-200 overflow-hidden" style="background:#f1f5f9;">

        <!-- Header -->
        <div class="p-4 md:p-6 pb-3 md:pb-4 border-b border-slate-200 bg-gradient-to-br from-slate-50/80 to-slate-100/80">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                <div>
                    <h2 class="text-xl md:text-2xl font-black bg-gradient-to-r from-[#1B3A4B] to-[#14505F] bg-clip-text text-transparent">
                        Pilihan paket
                    </h2>
                    <p class="text-xs md:text-sm text-gray-500 mt-0.5">{{ $tour->destination->name }} &middot; {{ $tour->duration }} {{ $tour->duration_type == 'hours' ? 'jam' : 'hari' }}</p>
                </div>
                <div class="flex items-center gap-2 w-full sm:w-auto justify-end">
                    <button id="btn-cek-ketersediaan" class="bg-[#1B3A4B] hover:bg-[#14505F] text-white px-3 md:px-4 py-1.5 md:py-2 rounded-xl font-semibold shadow-lg transition-all flex items-center gap-1 md:gap-2 text-xs whitespace-nowrap">
                        <i class="fas fa-calendar-check text-xs"></i> <span class="hidden sm:inline">Cek ketersediaan</span><span class="sm:hidden">Cek</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Form Booking -->
        <form id="booking-form" action="{{ route('bookings.store') }}" method="POST">
            @csrf
            <input type="hidden" name="tour_id" value="{{ $tour->id }}">
            <input type="hidden" name="package_id" id="selected_package_id" value="">
            <input type="hidden" name="travel_type" id="selected_travel_type" value="">
            <input type="hidden" name="group_option_id" id="selected_group_option_id" value="">
            <input type="hidden" name="num_persons" id="selected_num_persons" value="1">

            {{-- Pesan error validasi --}}
            @if($errors->any())
            <div style="margin:12px 16px 0; padding:12px 16px; background:#fef2f2; border:1px solid #fecaca; border-radius:10px;">
                <p style="font-size:12px; font-weight:700; color:#dc2626; margin-bottom:6px;"><i class="fas fa-exclamation-circle"></i> Periksa data berikut:</p>
                <ul style="margin:0; padding-left:16px;">
                    @foreach($errors->all() as $error)
                    <li style="font-size:12px; color:#dc2626;">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- 1-column layout -->
            <div class="p-3 md:p-4 flex flex-col gap-4">

                <!-- Tanggal -->
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-800 uppercase tracking-wide">Tanggal partisipasi <span class="text-[#1B3A4B]">*</span></label>
                    <input type="date" name="travel_date" id="travel_date"
                        class="w-full p-2.5 border border-gray-200 rounded-xl text-sm focus:ring-4 focus:ring-slate-200 focus:border-[#1B3A4B] transition-all shadow-sm"
                        min="{{ date('Y-m-d') }}" required>
                    <button type="button" id="btn-cek" class="w-full bg-[#1B3A4B] hover:bg-[#14505F] text-white px-4 py-2 rounded-xl font-bold shadow-lg transition-all flex items-center justify-center gap-2 text-sm mt-1">
                        <i class="fas fa-search text-xs"></i> Cek ketersediaan
                    </button>
                </div>

                    @if($tour->activePackages->count() > 0)

                    <!-- Diskon Banner -->
                    @php $hasDiscount = $tour->activePackages->filter(fn($p) => $p->discountPercentage() > 0)->count() > 0; @endphp
                    @if($hasDiscount)
                    <div class="bg-gradient-to-r from-slate-50 to-slate-100 p-3 rounded-xl border border-slate-200 shadow-sm">
                        <div class="flex items-center gap-2">
                            <div class="bg-[#1B3A4B] text-white text-xs font-bold px-2 py-0.5 rounded-full">Diskon</div>
                            <div class="flex-1 min-w-0">
                                <p class="font-bold text-xs text-gray-900">Hemat hingga {{ $tour->activePackages->max(fn($p) => $p->discountPercentage()) }}%</p>
                                <p class="text-xs text-gray-500">booking sekarang</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Jenis Paket -->
                    <div>
                        <label class="block text-xs font-bold text-gray-800 uppercase tracking-wide mb-2">Jenis paket <span class="text-[#1B3A4B]">*</span></label>
                        <div class="space-y-1.5" id="paket-list">
                            @foreach($tour->activePackages as $index => $package)
                            <button type="button"
                                class="pilihan-paket-btn w-full p-2.5 md:p-3 rounded-xl border-2 border-gray-200 hover:border-[#1B3A4B] hover:shadow-sm transition-all text-left paket-item {{ $index > 0 ? 'paket-hidden' : '' }}"
                                data-package-id="{{ $package->id }}"
                                data-price="{{ $package->price }}"
                                data-sharing-price="{{ $package->sharing_price > 0 ? $package->sharing_price : $package->price }}"
                                data-name="{{ $package->name }}"
                                data-travel-type="{{ $package->travel_type }}"
                                data-groups="{{ json_encode($package->activeGroups->map(fn($g) => ['id'=>$g->id,'label'=>$g->label,'group_size'=>$g->group_size,'price'=>$g->price])) }}"
                                data-addons="{{ json_encode($package->activeAddons->map(fn($a) => ['id'=>$a->id,'name'=>$a->name,'description'=>$a->description])) }}">
                                <div class="font-bold text-sm">{{ $package->name }}</div>
                            </button>
                            @endforeach
                            @if($tour->activePackages->count() > 1)
                            <button type="button" id="btn-toggle-paket" onclick="toggleMorePaket()" style="width:100%; padding:6px; background:#e2e8f0; border:none; border-radius:8px; color:#475569; font-size:11px; font-weight:600; cursor:pointer; transition:all 0.2s;" onmouseover="this.style.background='#cbd5e1'" onmouseout="this.style.background='#e2e8f0'">
                                <span id="toggle-paket-text">Lihat semua ({{ $tour->activePackages->count() }})</span> <i class="fas fa-chevron-down" id="toggle-paket-icon" style="font-size:10px;"></i>
                            </button>
                            @endif
                        </div>
                    </div>

                    @else
                    <div class="p-4 bg-amber-50 border border-amber-200 rounded-xl text-xs text-amber-700 text-center">
                        <i class="fas fa-info-circle mb-1"></i><br>
                        Belum ada paket tersedia.<br>Hubungi admin untuk info lebih lanjut.
                    </div>
                    @endif

                <!-- Toggle Private / Sharing -->
                    <div>
                        <label class="block text-xs font-bold text-gray-800 uppercase tracking-wide mb-2">Pilihan</label>
                        <div class="flex gap-2">
                            <button type="button" id="btn-private"
                                class="flex-1 pilihan-toggle p-2.5 rounded-xl border-2 border-gray-200 bg-white font-bold hover:border-[#1B3A4B] transition-all shadow-sm text-sm"
                                data-type="private">Private</button>
                            <button type="button" id="btn-sharing"
                                class="flex-1 pilihan-toggle p-2.5 rounded-xl border-2 border-gray-200 bg-white font-bold hover:border-[#1B3A4B] transition-all shadow-sm text-sm"
                                data-type="sharing">Sharing</button>
                        </div>
                    </div>

                    <!-- Pilihan Grup (Private) -->
                    <div id="section-private" style="display:none;">
                        <label class="block text-xs font-bold text-gray-800 uppercase tracking-wide mb-2">Pilih Grup</label>
                        <div class="space-y-1.5" id="group-list"></div>
                    </div>

                    <!-- Jumlah Orang + Add-on (Sharing) -->
                    <div id="section-sharing" style="display:none;">
                        <label class="block text-xs font-bold text-gray-800 uppercase tracking-wide mb-2">Jumlah Peserta</label>
                        <div class="flex items-center justify-between p-2.5 bg-white rounded-xl border shadow-sm">
                            <span class="font-semibold text-xs">Peserta</span>
                            <div class="flex items-center gap-2">
                                <span id="sharing-price-label" class="text-xs text-green-600 font-bold"></span>
                                <button type="button" id="sharing-minus" class="w-7 h-7 bg-gray-200 hover:bg-gray-300 rounded-lg flex items-center justify-center font-bold transition-all text-gray-600 text-sm">-</button>
                                <span id="sharing-count" class="text-sm font-bold w-6 text-center text-gray-900">1</span>
                                <button type="button" id="sharing-plus" class="w-7 h-7 bg-[#1B3A4B] hover:bg-[#14505F] text-white rounded-lg flex items-center justify-center font-bold shadow-sm transition-all text-sm">+</button>
                            </div>
                        </div>
                        <div id="section-addons" style="display:none; margin-top:8px;">
                            <label class="block text-xs font-bold text-gray-800 uppercase tracking-wide mb-1.5">Add-on</label>
                            <div class="space-y-1.5" id="addon-list"></div>
                        </div>
                    </div>

                    <!-- Kontak -->
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-gray-800 uppercase tracking-wide">Kontak</label>
                        <input type="text" name="contact_name" placeholder="Nama lengkap" required
                            class="w-full p-2.5 border border-gray-200 rounded-xl text-xs focus:ring-2 focus:ring-slate-200 focus:border-[#1B3A4B] transition-all">
                        <input type="email" name="contact_email" placeholder="Email"
                            value="{{ auth()->user()->email ?? '' }}" required
                            class="w-full p-2.5 border border-gray-200 rounded-xl text-xs focus:ring-2 focus:ring-slate-200 focus:border-[#1B3A4B] transition-all">
                        <input type="tel" name="contact_phone" placeholder="No. HP / WhatsApp" required
                            class="w-full p-2.5 border border-gray-200 rounded-xl text-xs focus:ring-2 focus:ring-slate-200 focus:border-[#1B3A4B] transition-all">
                    </div>

                    <!-- Total + CTA -->
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-3 md:p-4 mt-auto">
                        <p id="paket-selected-name" class="text-xs text-gray-400 mb-2">Pilih paket terlebih dahulu</p>
                        <div id="price-breakdown" class="text-xs text-gray-500 space-y-0.5 mb-2 text-[11px]"></div>
                        <div class="flex justify-between items-center border-t border-gray-100 pt-2 mb-3">
                            <span class="text-xs font-bold text-gray-800 uppercase">Total</span>
                            <div id="total-display" class="text-lg md:text-xl font-black text-gray-900">Rp0</div>
                        </div>
                        <div class="space-y-2">
                            @auth
                            <button type="submit" id="btn-pesan"
                                class="w-full bg-gradient-to-r from-[#1B3A4B] to-[#14505F] hover:from-[#14505F] hover:to-[#1E5F74] text-white py-2 md:py-2.5 px-3 md:px-4 rounded-xl font-bold shadow-lg transition-all text-xs uppercase tracking-wide">
                                Pesan sekarang</button>
                            @else
                            <a href="{{ route('login') }}"
                                class="block w-full bg-gradient-to-r from-[#1B3A4B] to-[#14505F] text-white py-2 md:py-2.5 px-3 md:px-4 rounded-xl font-bold shadow-lg transition-all text-xs uppercase tracking-wide text-center">
                                Login untuk memesan
                            </a>
                            @endauth
                        </div>
                    </div>
            </div>
        </form>
    </div>
</div>

<script>
(function () {
    let selectedPackage = null;
    let selectedTravelType = null;
    let selectedGroupId = null;
    let groupQuantities = {};
    let sharingCount = 1;
    let selectedAddonIds = [];
    let paketExpanded = false;

    const hiddenPackageId  = document.getElementById('selected_package_id');
    const hiddenTravelType = document.getElementById('selected_travel_type');
    const hiddenGroupId    = document.getElementById('selected_group_option_id');
    const hiddenNumPersons = document.getElementById('selected_num_persons');
    const totalDisplay     = document.getElementById('total-display');
    const paketName        = document.getElementById('paket-selected-name');
    const btnPesan         = document.getElementById('btn-pesan');

    function fmt(n) { return 'Rp' + parseInt(n).toLocaleString('id-ID'); }

    window.toggleMorePaket = function() {
        paketExpanded = !paketExpanded;
        const items = document.querySelectorAll('.paket-item');
        items.forEach((item, i) => {
            if (i === 0) return;
            item.classList.toggle('paket-hidden', !paketExpanded);
        });
        const text = document.getElementById('toggle-paket-text');
        const icon = document.getElementById('toggle-paket-icon');
        const total = items.length;
        if (paketExpanded) {
            text.textContent = 'Tutup';
            icon.className = 'fas fa-chevron-up';
        } else {
            text.textContent = 'Lihat semua (' + total + ')';
            icon.className = 'fas fa-chevron-down';
        }
    };

    function recalc() {
        if (!selectedPackage || !selectedTravelType) {
            totalDisplay.textContent = 'Rp0';
            document.getElementById('price-breakdown').innerHTML = '';
            updateBtn();
            return;
        }

        let total = 0;
        let breakdown = [];

        if (selectedTravelType === 'private') {
            const activeGroups = Object.entries(groupQuantities).filter(([, q]) => q > 0);
            if (activeGroups.length === 0) {
                totalDisplay.textContent = 'Rp0';
                document.getElementById('price-breakdown').innerHTML = '';
                updateBtn();
                return;
            }
            activeGroups.forEach(([gid]) => {
                const group = selectedPackage.groups.find(g => g.id == gid);
                if (group) {
                    const price = parseFloat(group.price) || 0;
                    const qty = groupQuantities[gid] || 0;
                    const subtotal = price * qty;
                    total += subtotal;
                    breakdown.push(`<div class="flex justify-between"><span>${group.label} &middot; ${fmt(price)}/orang</span><span class="font-semibold">${fmt(subtotal)}</span></div>`);
                }
            });
        } else {
            const pricePerPerson = selectedPackage.sharingPrice;
            total = pricePerPerson * sharingCount;
            breakdown.push(`<div class="flex justify-between"><span>${fmt(pricePerPerson)}/orang &times; ${sharingCount}</span><span class="font-semibold">${fmt(total)}</span></div>`);
            selectedAddonIds.forEach(id => {
                const addon = selectedPackage.addons.find(a => a.id == id);
                if (addon) {
                    breakdown.push(`<div class="flex justify-between"><span>${addon.name}</span><span class="font-semibold"></span></div>`);
                }
            });
        }

        document.getElementById('price-breakdown').innerHTML = breakdown.join('');
        totalDisplay.textContent = fmt(total);
        updateBtn();
    }

    function updateBtn() {
        if (!btnPesan) return;
        btnPesan.disabled = false;
    }

    document.querySelectorAll('.pilihan-paket-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.pilihan-paket-btn').forEach(b => b.classList.remove('selected'));
            this.classList.add('selected');

            selectedPackage = {
                id: this.dataset.packageId,
                price: parseFloat(this.dataset.price),
                sharingPrice: parseFloat(this.dataset.sharingPrice) || parseFloat(this.dataset.price),
                name: this.dataset.name,
                travelType: this.dataset.travelType,
                groups: JSON.parse(this.dataset.groups || '[]'),
                addons: JSON.parse(this.dataset.addons || '[]'),
            };

            hiddenPackageId.value = selectedPackage.id;
            paketName.textContent = selectedPackage.name;

            const sharingLabel = document.getElementById('sharing-price-label');
            if (sharingLabel) sharingLabel.textContent = fmt(selectedPackage.sharingPrice) + '/orang';

            selectedTravelType = null;
            selectedGroupId = null;
            groupQuantities = {};
            sharingCount = 1;
            document.getElementById('sharing-count').textContent = 1;
            hiddenTravelType.value = '';
            hiddenGroupId.value = '';
            hiddenNumPersons.value = 1;

            document.getElementById('section-private').style.display = 'none';
            document.getElementById('section-sharing').style.display = 'none';
            document.querySelectorAll('.pilihan-toggle').forEach(b => b.classList.remove('selected'));

            const btnPrivate = document.getElementById('btn-private');
            const btnSharing = document.getElementById('btn-sharing');
            const tt = selectedPackage.travelType;
            btnPrivate.style.display = (tt === 'sharing') ? 'none' : '';
            btnSharing.style.display = (tt === 'private') ? 'none' : '';

            if (tt === 'private') selectTravelType('private');
            else if (tt === 'sharing') selectTravelType('sharing');

            recalc();
        });
    });

    document.querySelectorAll('.pilihan-toggle').forEach(btn => {
        btn.addEventListener('click', function () { selectTravelType(this.dataset.type); });
    });

    function selectTravelType(type) {
        selectedTravelType = type;
        hiddenTravelType.value = type;
        selectedGroupId = null;
        hiddenGroupId.value = '';

        document.querySelectorAll('.pilihan-toggle').forEach(b => {
            b.classList.toggle('selected', b.dataset.type === type);
        });

        if (type === 'private') {
            document.getElementById('section-private').style.display = 'block';
            document.getElementById('section-sharing').style.display = 'none';
            renderGroups();
        } else {
            document.getElementById('section-private').style.display = 'none';
            document.getElementById('section-sharing').style.display = 'block';
            renderAddons();
        }
        recalc();
    }

    function renderGroups() {
        const list = document.getElementById('group-list');
        list.innerHTML = '';
        if (!selectedPackage || !selectedPackage.groups.length) {
            list.innerHTML = '<p class="text-xs text-gray-400 p-2 text-center">Belum ada pilihan grup.</p>';
            return;
        }
        selectedPackage.groups.forEach(g => {
            groupQuantities[g.id] = groupQuantities[g.id] || 0;
            const row = document.createElement('div');
            row.className = 'group-counter-row flex items-center justify-between p-2.5 rounded-xl border shadow-sm';
            row.dataset.groupId = g.id;
            row.innerHTML = `
                <div class="min-w-0">
                    <div class="font-bold text-xs">Grup ${g.group_size} orang (Harga per orang)</div>
                    <div class="text-xs text-gray-400">Kamu wajib memesan minimum ${g.group_size} unit</div>
                </div>
                <div class="flex items-center gap-2 shrink-0">
                    <span class="group-price font-bold text-xs text-[#1B3A4B]" data-group-id="${g.id}"></span>
                    <button type="button" class="group-minus w-7 h-7 bg-gray-200 hover:bg-gray-300 rounded-lg flex items-center justify-center font-bold transition-all text-gray-600 text-sm" data-group-id="${g.id}">-</button>
                    <span class="group-qty text-sm font-bold w-6 text-center text-gray-900" data-group-id="${g.id}">${groupQuantities[g.id]}</span>
                    <button type="button" class="group-plus w-7 h-7 bg-[#1B3A4B] hover:bg-[#14505F] text-white rounded-lg flex items-center justify-center font-bold shadow-sm transition-all text-sm" data-group-id="${g.id}">+</button>
                </div>`;
            row.querySelector('.group-minus').addEventListener('click', function () {
                const gid = this.dataset.groupId;
                groupQuantities[gid] = 0;
                updateGroupCounters();
                syncGroupSelection();
                recalc();
            });
            row.querySelector('.group-plus').addEventListener('click', function () {
                const gid = this.dataset.groupId;
                const grp = selectedPackage.groups.find(x => x.id == gid);
                groupQuantities[gid] = grp ? grp.group_size : 1;
                updateGroupCounters();
                syncGroupSelection();
                recalc();
            });
            list.appendChild(row);
        });
        updateGroupCounters();
    }

    function updateGroupCounters() {
        document.querySelectorAll('.group-counter-row').forEach(row => {
            const gid = row.dataset.groupId;
            const qty = groupQuantities[gid] || 0;
            row.querySelector('.group-qty').textContent = qty;
            const priceEl = row.querySelector('.group-price');
            const grp = selectedPackage ? selectedPackage.groups.find(x => x.id == gid) : null;
            const unit = grp ? (parseFloat(grp.price) || 0) : 0;
            if (priceEl) {
                if (qty > 0) {
                    priceEl.textContent = fmt(unit);
                    priceEl.style.display = '';
                } else {
                    priceEl.textContent = '';
                    priceEl.style.display = 'none';
                }
            }
            const minusBtn = row.querySelector('.group-minus');
            minusBtn.disabled = qty <= 0;
            minusBtn.classList.toggle('opacity-40', qty <= 0);
            minusBtn.classList.toggle('cursor-not-allowed', qty <= 0);
            row.classList.toggle('group-row-active', qty > 0);
        });
    }

    function syncGroupSelection() {
        const activeGroups = Object.entries(groupQuantities).filter(([, q]) => q > 0);
        if (activeGroups.length > 0) {
            selectedGroupId = activeGroups[0][0];
            hiddenGroupId.value = selectedGroupId;
            const totalQty = activeGroups.reduce((sum, [gid]) => {
                const grp = selectedPackage.groups.find(x => x.id == gid);
                return sum + (grp ? grp.group_size : 0);
            }, 0);
            hiddenNumPersons.value = totalQty;
        } else {
            selectedGroupId = null;
            hiddenGroupId.value = '';
            hiddenNumPersons.value = 1;
        }
    }

    function renderAddons() {
        const section = document.getElementById('section-addons');
        const list    = document.getElementById('addon-list');
        list.innerHTML = '';
        selectedAddonIds = [];

        if (!selectedPackage || !selectedPackage.addons.length) {
            section.style.display = 'none';
            return;
        }
        section.style.display = 'block';
        selectedPackage.addons.forEach(a => {
            const label = document.createElement('label');
            label.className = 'flex items-center justify-between p-2.5 bg-white rounded-xl border shadow-sm cursor-pointer hover:border-[#1B3A4B] transition-all';
            label.innerHTML = `
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="addon_ids[]" value="${a.id}" class="addon-check w-4 h-4 accent-[#1B3A4B]">
                    <div>
                        <div class="font-semibold text-xs">${a.name}</div>
                        ${a.description ? `<div class="text-xs text-gray-400">${a.description}</div>` : ''}
                    </div>
                </div>`;
            label.querySelector('.addon-check').addEventListener('change', function () {
                selectedAddonIds = this.checked
                    ? [...selectedAddonIds, a.id]
                    : selectedAddonIds.filter(x => x != a.id);
                recalc();
            });
            list.appendChild(label);
        });
    }

    document.getElementById('sharing-minus').addEventListener('click', () => {
        if (sharingCount > 1) {
            sharingCount--;
            document.getElementById('sharing-count').textContent = sharingCount;
            hiddenNumPersons.value = sharingCount;
            recalc();
        }
    });
    document.getElementById('sharing-plus').addEventListener('click', () => {
        sharingCount++;
        document.getElementById('sharing-count').textContent = sharingCount;
        hiddenNumPersons.value = sharingCount;
        recalc();
    });

    document.getElementById('travel_date').addEventListener('change', updateBtn);

    ['btn-cek', 'btn-cek-ketersediaan'].forEach(id => {
        const el = document.getElementById(id);
        if (el) el.addEventListener('click', () => document.getElementById('paket-list')?.scrollIntoView({ behavior: 'smooth', block: 'center' }));
    });

    document.getElementById('booking-form').addEventListener('submit', function (e) {
        const errors = [];
        if (!document.getElementById('travel_date').value) errors.push('Tanggal partisipasi wajib diisi.');
        if (!selectedPackage) errors.push('Pilih jenis paket terlebih dahulu.');
        if (!selectedTravelType) errors.push('Pilih tipe perjalanan (Private/Sharing).');
        if (selectedTravelType === 'private' && Object.values(groupQuantities).every(q => q <= 0)) errors.push('Pilih pilihan grup terlebih dahulu.');
        if (!document.querySelector('[name=contact_name]').value) errors.push('Nama lengkap wajib diisi.');
        if (!document.querySelector('[name=contact_email]').value) errors.push('Email wajib diisi.');
        if (!document.querySelector('[name=contact_phone]').value) errors.push('Nomor HP wajib diisi.');
        else if (!/^[0-9+\-\s()]{7,20}$/.test(document.querySelector('[name=contact_phone]').value)) errors.push('Nomor HP hanya boleh berisi angka.');

        if (errors.length > 0) {
            e.preventDefault();
            let box = document.getElementById('js-error-box');
            if (!box) {
                box = document.createElement('div');
                box.id = 'js-error-box';
                box.style.cssText = 'margin:12px 16px 0; padding:12px 16px; background:#fef2f2; border:1px solid #fecaca; border-radius:10px;';
                document.getElementById('booking-form').prepend(box);
            }
            box.innerHTML = '<p style="font-size:12px; font-weight:700; color:#dc2626; margin-bottom:6px;"><i class="fas fa-exclamation-circle"></i> Periksa data berikut:</p><ul style="margin:0; padding-left:16px;">' +
                errors.map(e => `<li style="font-size:12px; color:#dc2626;">${e}</li>`).join('') + '</ul>';
            box.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });
})();
</script>

<style>
.paket-hidden {
    display: none !important;
}
.pilihan-paket-btn.selected {
    border-color: #30525c !important;
    background: rgba(48, 82, 92, 0.12) !important;
    color: #30525c !important;
}
.pilihan-paket-btn.selected .text-\[\#1B3A4B\],
.pilihan-paket-btn.selected .text-green-600 { color: #30525c !important; }
.pilihan-paket-btn.selected .text-gray-500,
.pilihan-paket-btn.selected .text-gray-400 { color: #4b5563 !important; }
.pilihan-toggle.selected {
    border-color: #1B3A4B !important;
    background: linear-gradient(135deg, #1B3A4B 0%, #14505F 100%) !important;
    color: white !important;
}
.group-counter-row {
    border-color: #e5e7eb !important;
    background: white !important;
}
.group-counter-row.group-row-active {
    border-color: #1B3A4B !important;
    background: #f0f9ff !important;
}
.group-counter-row.group-row-active .font-bold.text-xs {
    color: #1B3A4B !important;
}
</style>
