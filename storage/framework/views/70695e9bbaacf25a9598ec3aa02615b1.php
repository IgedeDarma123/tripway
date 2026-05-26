

<?php $__env->startSection('scripts'); ?>
<script>
window.addEventListener('DOMContentLoaded', function() {
    // Hero Carousel
    let currentSlide = 0;
    const totalSlides = 3;
    const slides = document.querySelectorAll('.hero-slide');
    const prevBtn = document.querySelector('.hero-arrow.prev');
    const nextBtn = document.querySelector('.hero-arrow.next');

    function showSlide(index) {
        slides.forEach((slide, i) => {
            slide.classList.toggle('active', i === index);
        });
    }
    function nextSlide() { currentSlide = (currentSlide + 1) % totalSlides; showSlide(currentSlide); }
    function prevSlide() { currentSlide = (currentSlide - 1 + totalSlides) % totalSlides; showSlide(currentSlide); }
    prevBtn.addEventListener('click', prevSlide);
    nextBtn.addEventListener('click', nextSlide);
    setInterval(nextSlide, 5000);

    // Search Dropdown
    const input = document.getElementById('hero-search');
    const dropdown = document.getElementById('search-dropdown');
    const searchFooter = document.getElementById('search-footer');
    const searchKeyword = document.getElementById('search-keyword');
    const allItems = dropdown.querySelectorAll('a');

    function showDropdown() { dropdown.style.display = 'block'; }
    function hideDropdown() { setTimeout(() => { dropdown.style.display = 'none'; }, 150); }

    input.addEventListener('focus', showDropdown);
    input.addEventListener('click', showDropdown);
    input.addEventListener('blur', hideDropdown);

    input.addEventListener('input', function () {
        const keyword = this.value.toLowerCase().trim();
        searchKeyword.textContent = this.value;
        searchFooter.style.display = keyword ? 'block' : 'none';

        // Filter items berdasarkan keyword
        allItems.forEach(item => {
            const text = item.querySelector('span').textContent.toLowerCase();
            item.style.display = (!keyword || text.includes(keyword)) ? 'flex' : 'none';
        });

        showDropdown();
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('title', 'TripWay - Temukan Petualangan Terbaik di Bali'); ?>

<?php $__env->startSection('styles'); ?>
<style>
/* Hero Carousel */
.hero-carousel { 

    position: relative; 
    height: 70vh; 
    min-height: 520px; 
    overflow: hidden; 
}
.hero-slides { 
    position: absolute; 
    inset: 0; 
    width: 300%; /* 3 slides */ 
}
.hero-slide { 
    position: absolute; 
    width: 33.333%; 
    height: 100%; 
    background-size: cover; 
    background-position: center; 
    opacity: 0; 
    transition: opacity 0.8s ease-in-out; 
}
.hero-slide.active { 
    opacity: 1; 
}
.hero-arrow { 
    position: absolute; 
    top: 50%; 
    transform: translateY(-50%); 
    background: rgba(48,82,92,0.9); 
    border: none; 
    width: 50px; 
    height: 50px; 
    border-radius: 50%; 
    display: flex; 
    align-items: center; 
    justify-content: center; 
    font-size: 20px; 
    color: white; 
    cursor: pointer; 
    z-index: 20; 
    transition: all 0.2s; 
    box-shadow: 0 4px 12px rgba(0,0,0,0.3); 
}
.hero-arrow:hover { 
    background: #30525c; 
    transform: translateY(-50%) scale(1.1); 
}
.hero-arrow.prev { left: 30px; } 
.hero-arrow.next { right: 30px; } 
.hero-overlay { 
    position: absolute; 
    inset: 0; 
    background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.2)); 
    z-index: 5; 
}
.hero-content { 
    position: absolute; 
    top: 50%; 
    left: 50%; 
    transform: translate(-50%, -50%); 
    width: 90%; 
    max-width: 780px; 
    color: white; 
    text-align: center; 
    z-index: 10; 
}
.hero h1 { 
    font-size: clamp(42px, 6vw, 68px); 
    font-weight: 800; 
    margin-bottom: 20px; 
    line-height: 1.15; 
    letter-spacing: -1px;
    text-shadow: 0 2px 20px rgba(0,0,0,0.3);
}
.hero p { 
    font-size: clamp(17px, 2.2vw, 22px); 
    opacity: 0.92; 
    margin-bottom: 36px; 
    max-width: 580px; 
    margin-left: auto; 
    margin-right: auto;
    font-weight: 400;
    line-height: 1.7;
    letter-spacing: 0.1px;
    text-shadow: 0 1px 8px rgba(0,0,0,0.2);
}
.search-bar { 
    display: flex; 
    background: rgba(255,255,255,0.95); 
    border-radius: var(--radius); 
    padding: 8px; 
    max-width: 700px; 
    box-shadow: var(--shadow-lg); 
    gap: 8px; 
    margin: 0 auto; 
    backdrop-filter: blur(10px); 
}
.search-bar input { 
    flex: 1; 
    border: none; 
    padding: 12px 16px; 
    font-size: 15px; 
    outline: none; 
    border-radius: var(--radius-sm); 
    background: var(--bg-light); 
}
.search-bar button { 
    background: var(--primary); 
    color: white; 
    border: none; 
    padding: 12px 28px; 
    border-radius: var(--radius-sm); 
    font-weight: 600; 
    font-size: 15px; 
    cursor: pointer; 
    transition: background 0.2s; 
}
.search-bar button:hover { 
    background: var(--primary-dark); 
}

/* Rest of styles unchanged */
.section { padding: 60px 0; }
.section-title { 
    font-size: 28px; 
    font-weight: 700; 
    margin-bottom: 8px; 
    color: var(--text-dark); 
}
.section-subtitle { 
    font-size: 16px; 
    color: var(--text-light); 
    margin-bottom: 32px; 
}
.categories-grid { 
    display: grid; 
    grid-template-columns: repeat(6, 1fr); 
    gap: 16px; 
}
.category-card { 
    background: white; 
    border: 1px solid var(--border); 
    border-radius: var(--radius); 
    padding: 24px 16px; 
    text-align: center; 
    transition: all 0.2s; 
    cursor: pointer; 
}
.category-card:hover { 
    border-color: var(--primary); 
    box-shadow: var(--shadow); 
    transform: translateY(-2px); 
}
.category-icon { 
    width: 48px; 
    height: 48px; 
    background: var(--bg-light); 
    border-radius: 50%; 
    display: flex; 
    align-items: center; 
    justify-content: center; 
    margin: 0 auto 12px; 
    font-size: 20px; 
    color: var(--primary); 
}
.category-card h3 { 
    font-size: 14px; 
    font-weight: 600; 
    color: var(--text-dark); 
}

.destinations-grid { 
    display: grid; 
    grid-template-columns: repeat(4, 1fr); 
    gap: 20px; 
}
.destination-card { 
    position: relative; 
    border-radius: var(--radius); 
    overflow: hidden; 
    cursor: pointer; 
    width: 100%; 
    min-width: 0; 
    aspect-ratio: 1 / 1; 
}
.destination-card::before { 
    content: ''; 
    display: block; 
    padding-top: 100%; 
}
.destination-card img { 
    position: absolute; 
    inset: 0; 
    width: 100%; 
    height: 100%; 
    object-fit: cover; 
    transition: transform 0.3s; 
}
.destination-card:hover img { transform: scale(1.05); } 
.destination-overlay { 
    position: absolute; 
    inset: 0; 
    background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, transparent 60%); 
    display: flex; 
    flex-direction: column; 
    justify-content: flex-end; 
    padding: 20px; 
    color: white; 
}
.destination-overlay h3 { 
    font-size: 18px; 
    font-weight: 700; 
}
.destination-overlay span { 
    font-size: 13px; 
    opacity: 0.9; 
}

.tours-grid { 
    display: grid; 
    grid-template-columns: repeat(4, 1fr); 
    gap: 20px; 
}
.tour-card { 
    background: white; 
    border: 1px solid var(--border); 
    border-radius: var(--radius); 
    overflow: hidden; 
    transition: all 0.2s; 
    cursor: pointer; 
}
.tour-card:hover { 
    box-shadow: var(--shadow-lg); 
    transform: translateY(-4px); 
}
.tour-image { 
    position: relative; 
    height: 180px; 
    overflow: hidden; 
}
.tour-image img { 
    width: 100%; 
    height: 100%; 
    object-fit: cover; 
}
.tour-badge { 
    position: absolute; 
    top: 12px; 
    left: 12px; 
    background: var(--primary); 
    color: white; 
    font-size: 11px; 
    font-weight: 600; 
    padding: 4px 10px; 
    border-radius: 4px; 
}
.tour-wishlist { 
    position: absolute; 
    top: 12px; 
    right: 12px; 
    width: 32px; 
    height: 32px; 
    background: rgba(255,255,255,0.9); 
    border-radius: 50%; 
    display: flex; 
    align-items: center; 
    justify-content: center; 
    border: none; 
    cursor: pointer; 
    color: var(--text-light); 
}
.tour-body { padding: 16px; } 
.tour-category { 
    font-size: 12px; 
    color: var(--primary); 
    font-weight: 600; 
    text-transform: uppercase; 
    margin-bottom: 6px; 
}
.tour-title { 
    font-size: 15px; 
    font-weight: 600; 
    color: var(--text-dark); 
    margin-bottom: 8px; 
    line-height: 1.4; 
    display: -webkit-box; 
    -webkit-line-clamp: 2; 
    -webkit-box-orient: vertical; 
    overflow: hidden; 
}
.tour-meta { 
    display: flex; 
    align-items: center; 
    gap: 12px; 
    margin-bottom: 12px; 
    font-size: 13px; 
    color: var(--text-light); 
}
.tour-rating { 
    display: flex; 
    align-items: center; 
    gap: 4px; 
}
.tour-rating i { color: #ffc107; font-size: 12px; } 
.tour-rating span { color: var(--text-dark); font-weight: 600; } 
.tour-footer { 
    display: flex; 
    align-items: flex-end; 
    justify-content: space-between; 
    border-top: 1px solid var(--border); 
    padding-top: 12px; 
}
.tour-price-label { 
    font-size: 12px; 
    color: var(--text-light); 
}
.tour-price { 
    font-size: 18px; 
    font-weight: 700; 
    color: var(--text-dark); 
}
.tour-price span { 
    font-size: 13px; 
    color: var(--text-light); 
    font-weight: 400; 
}
.trust-section { 
    background: var(--bg-light); 
    padding: 48px 0; 
}
.trust-grid { 
    display: grid; 
    grid-template-columns: repeat(4, 1fr); 
    gap: 32px; 
    text-align: center; 
}
.trust-item i { 
    font-size: 32px; 
    color: var(--primary); 
    margin-bottom: 12px; 
}
.trust-item h4 { 
    font-size: 15px; 
    font-weight: 600; 
    margin-bottom: 6px; 
    color: var(--text-dark); 
}
.trust-item p { 
    font-size: 13px; 
    color: var(--text-light); 
}
.section-header { 
    display: flex; 
    justify-content: space-between; 
    align-items: flex-end; 
    margin-bottom: 24px; 
}
.see-all { 
    font-size: 14px; 
    font-weight: 600; 
    color: var(--primary); 
    display: flex; 
    align-items: center; 
    gap: 4px; 
}
.see-all:hover { text-decoration: underline; }

@media (max-width: 1024px) { 
    .categories-grid { grid-template-columns: repeat(3, 1fr); } 
    .tours-grid { grid-template-columns: repeat(3, 1fr); } 
    .destinations-grid { grid-template-columns: repeat(2, 1fr); } 
    .trust-grid { grid-template-columns: repeat(2, 1fr); } 
}
@media (max-width: 768px) { 
    .hero h1 { font-size: 32px; } 
    .categories-grid { grid-template-columns: repeat(2, 1fr); } 
    .tours-grid { grid-template-columns: repeat(2, 1fr); } 
    .search-bar { flex-direction: column; } 
}
@media (max-width: 480px) { 
    .tours-grid { grid-template-columns: 1fr; } 
    .categories-grid { grid-template-columns: repeat(2, 1fr); } 
    .destinations-grid { grid-template-columns: 1fr; } 
}
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <!-- Hero Carousel -->
    <section class="hero-carousel">
        <div class="hero-slides">
            <div class="hero-slide active" style="background-image: url('https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=1920&auto=format&fit=crop')"></div>
            <div class="hero-slide" style="background-image: url('https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=1920&auto=format&fit=crop')"></div>
            <div class="hero-slide" style="background-image: url('https://images.unsplash.com/photo-1519046904884-53103b34b206?w=1920&auto=format&fit=crop')"></div>
        </div>
        <button class="hero-arrow prev" onclick="changeSlide(-1)"><i class="fas fa-chevron-left"></i></button>
        <button class="hero-arrow next" onclick="changeSlide(1)"><i class="fas fa-chevron-right"></i></button>
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1 style="font-size: clamp(36px, 5vw, 56px); font-weight: 800; line-height: 1.15; letter-spacing: -1px; text-shadow: 0 2px 24px rgba(0,0,0,0.35); margin-bottom: 16px;">Temukan Petualangan Terbaik di Bali</h1>
            <p style="font-size: clamp(16px, 2vw, 20px); font-weight: 400; line-height: 1.7; opacity: 0.93; text-shadow: 0 1px 8px rgba(0,0,0,0.25); max-width: 580px; margin: 0 auto 32px;">Pesan aktivitas seru, tur eksklusif, dan pengalaman tak terlupakan di Pulau Dewata bersama TripWay.</p>
            <form class="search-bar" action="<?php echo e(route('tours.index')); ?>" method="GET">
                <div style="position:relative; flex:1;">
                    <input type="text" name="search" id="hero-search" placeholder="Cari aktivitas, tur, atau destinasi..."
                        autocomplete="off"
                        style="width:100%; border:none; padding:12px 16px; font-size:15px; outline:none; border-radius:var(--radius-sm); background:var(--bg-light);">
                    <!-- Dropdown Suggestions -->
                    <div id="search-dropdown" style="display:none; position:absolute; top:calc(100% + 8px); left:0; width:600px; background:white; border-radius:16px; box-shadow:0 16px 48px rgba(0,0,0,0.18); z-index:999; overflow:hidden; border:1px solid #e5e7eb;">
                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:0;">
                            <!-- Kolom Destinasi -->
                            <div style="padding:16px; border-right:1px solid #f3f4f6;">
                                <div style="font-size:11px; font-weight:700; color:#9ca3af; text-transform:uppercase; letter-spacing:0.8px; margin-bottom:10px;"><i class="fas fa-map-marker-alt" style="margin-right:5px;"></i>Destinasi</div>
                                <?php $__currentLoopData = $destinations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dest): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a href="<?php echo e(route('tours.index', ['destination' => $dest->slug])); ?>"
                                    style="display:flex; align-items:center; justify-content:space-between; padding:8px 10px; border-radius:8px; font-size:13px; color:#374151; transition:all 0.15s; text-decoration:none;"
                                    onmouseover="this.style.background='#f1f5f9'; this.style.color='#1B3A4B';" onmouseout="this.style.background='transparent'; this.style.color='#374151';">
                                    <span><?php echo e($dest->name); ?></span>
                                    <span style="font-size:11px; color:#9ca3af; background:#f3f4f6; padding:2px 7px; border-radius:20px;"><?php echo e($dest->tours_count); ?></span>
                                </a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <!-- Kolom Kategori -->
                            <div style="padding:16px;">
                                <div style="font-size:11px; font-weight:700; color:#9ca3af; text-transform:uppercase; letter-spacing:0.8px; margin-bottom:10px;"><i class="fas fa-compass" style="margin-right:5px;"></i>Kategori</div>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a href="<?php echo e(route('tours.index', ['category' => $cat->slug])); ?>"
                                    style="display:flex; align-items:center; gap:8px; padding:8px 10px; border-radius:8px; font-size:13px; color:#374151; transition:all 0.15s; text-decoration:none;"
                                    onmouseover="this.style.background='#f1f5f9'; this.style.color='#1B3A4B';" onmouseout="this.style.background='transparent'; this.style.color='#374151';">
                                    <i class="fas <?php echo e($cat->icon ?? 'fa-compass'); ?>" style="color:#1B3A4B; width:14px; font-size:12px;"></i>
                                    <span><?php echo e($cat->name); ?></span>
                                </a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                        <!-- Footer cari keyword -->
                        <div id="search-footer" style="display:none; padding:12px 16px; border-top:1px solid #f3f4f6; background:#f8fafc;">
                            <button type="submit" style="width:100%; padding:10px; background:#1B3A4B; color:white; border:none; border-radius:8px; font-size:13px; font-weight:600; cursor:pointer;">
                                <i class="fas fa-search"></i> Cari "<span id="search-keyword"></span>"
                            </button>
                        </div>
                    </div>
                </div>
                <button type="submit" style="background:#1B3A4B; color:white; border:none; padding:12px 28px; border-radius:var(--radius-sm); font-weight:600; font-size:15px; cursor:pointer; transition:background 0.2s;">
                    <i class="fas fa-search"></i> Cari
                </button>
            </form>
        </div>
    </section>

    <!-- Categories -->
    <section class="section">
        <div class="container">
            <h2 class="section-title">Jelajahi Berdasarkan Kategori</h2>
            <p class="section-subtitle">Pilih jenis pengalaman yang kamu inginkan</p>
            <div class="categories-grid">
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('tours.index', ['category' => $category->slug])); ?>" class="category-card">
                    <div class="category-icon"><i class="fas <?php echo e($category->icon ?? 'fa-compass'); ?>"></i></div>
                    <h3><?php echo e($category->name); ?></h3>
                </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>

    <!-- Popular Destinations -->
    <section class="section" style="background: var(--bg-light);">
        <div class="container">
            <div class="section-header">
                <div>
                    <h2 class="section-title">Destinasi Populer</h2>
                    <p class="section-subtitle" style="margin-bottom:0;">Jelajahi keindahan Bali dari berbagai sudut</p>
                </div>
                <a href="<?php echo e(route('tours.index')); ?>" class="see-all">Lihat Semua <i class="fas fa-chevron-right" style="font-size:10px;"></i></a>
            </div>
            <div class="destinations-grid">
                <?php $__currentLoopData = $destinations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $destination): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('tours.index', ['destination' => $destination->slug])); ?>" class="destination-card">
                    <img src="<?php echo e($destination->image ?? 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=600'); ?>" alt="<?php echo e($destination->name); ?>">
                    <div class="destination-overlay">
                        <h3><?php echo e($destination->name); ?></h3>
                        <span><?php echo e($destination->tours_count); ?> aktivitas</span>
                    </div>
                </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>

    <!-- Popular Tours -->
    <section class="section">
        <div class="container">
            <div class="section-header">
                <div>
                    <h2 class="section-title">Tour Paling Populer</h2>
                    <p class="section-subtitle" style="margin-bottom:0;">Pilihan wisatawan terbaik minggu ini</p>
                </div>
                <a href="<?php echo e(route('tours.index')); ?>" class="see-all">Lihat Semua <i class="fas fa-chevron-right" style="font-size:10px;"></i></a>
            </div>
            <div class="tours-grid">
                <?php $__currentLoopData = $popularTours; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tour): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('tours.show', $tour->slug)); ?>" class="tour-card">
                    <div class="tour-image">
                        <img src="<?php echo e($tour->image ?? 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=400'); ?>" alt="<?php echo e($tour->title); ?>">
                        <?php if($tour->discountPercentage() > 0): ?>
                            <span class="tour-badge">Hemat <?php echo e($tour->discountPercentage()); ?>%</span>
                        <?php endif; ?>
                        <button class="tour-wishlist"><i class="far fa-heart"></i></button>
                    </div>
                    <div class="tour-body">
                        <div class="tour-category"><?php echo e($tour->category->name); ?></div>
                        <h3 class="tour-title"><?php echo e($tour->title); ?></h3>
                        <div class="tour-meta">
                            <span><i class="far fa-clock"></i> <?php echo e($tour->duration); ?> <?php echo e($tour->duration_type == 'hours' ? 'jam' : 'hari'); ?></span>
                            <?php if($tour->rating > 0): ?>
                            <div class="tour-rating">
                                <i class="fas fa-star"></i>
                                <span><?php echo e($tour->rating); ?></span>
                                <span style="color:var(--text-light);font-weight:400;">(<?php echo e($tour->review_count); ?>)</span>
                            </div>
                            <?php endif; ?>
                        </div>
                        <div class="tour-footer">
                            <div>
                                <div class="tour-price-label">Mulai dari</div>
                                <div class="tour-price">Rp <?php echo e(number_format($tour->lowestPrice(), 0, ',', '.')); ?> <span>/ orang</span></div>
                            </div>
                        </div>
                    </div>
                </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>

    <!-- Trust Badges -->
    <section class="trust-section">
        <div class="container">
            <div class="trust-grid">
                <div class="trust-item">
                    <i class="fas fa-shield-alt"></i>
                    <h4>Pembayaran Aman</h4>
                    <p>Transaksi terenkripsi dengan sistem pembayaran terpercaya</p>
                </div>
                <div class="trust-item">
                    <i class="fas fa-tags"></i>
                    <h4>Harga Terbaik</h4>
                    <p>Jaminan harga kompetitif untuk setiap aktivitas</p>
                </div>
                <div class="trust-item">
                    <i class="fas fa-headset"></i>
                    <h4>Bantuan 24/7</h4>
                    <p>Tim support siap membantu kapan saja Anda butuhkan</p>
                </div>
                <div class="trust-item">
                    <i class="fas fa-check-circle"></i>
                    <h4>Reservasi Instan</h4>
                    <p>Konfirmasi booking langsung tanpa menunggu lama</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Tours -->
    <?php if($featuredTours->count() > 0): ?>
    <section class="section">
        <div class="container">
            <div class="section-header">
                <div>
                    <h2 class="section-title">Rekomendasi Spesial</h2>
                    <p class="section-subtitle" style="margin-bottom:0;">Pengalaman premium pilihan kami</p>
                </div>
                <a href="<?php echo e(route('tours.index')); ?>" class="see-all">Lihat Semua <i class="fas fa-chevron-right" style="font-size:10px;"></i></a>
            </div>
            <div class="tours-grid">
                <?php $__currentLoopData = $featuredTours; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tour): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('tours.show', $tour->slug)); ?>" class="tour-card">
                    <div class="tour-image">
                        <img src="<?php echo e($tour->image ?? 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=400'); ?>" alt="<?php echo e($tour->title); ?>">
                        <span class="tour-badge">Unggulan</span>
                        <button class="tour-wishlist"><i class="far fa-heart"></i></button>
                    </div>
                    <div class="tour-body">
                        <div class="tour-category"><?php echo e($tour->category->name); ?></div>
                        <h3 class="tour-title"><?php echo e($tour->title); ?></h3>
                        <div class="tour-meta">
                            <span><i class="far fa-clock"></i> <?php echo e($tour->duration); ?> <?php echo e($tour->duration_type == 'hours' ? 'jam' : 'hari'); ?></span>
                            <?php if($tour->rating > 0): ?>
                            <div class="tour-rating">
                                <i class="fas fa-star"></i>
                                <span><?php echo e($tour->rating); ?></span>
                            </div>
                            <?php endif; ?>
                        </div>
                        <div class="tour-footer">
                            <div>
                                <div class="tour-price-label">Mulai dari</div>
                                <div class="tour-price">Rp <?php echo e(number_format($tour->lowestPrice(), 0, ',', '.')); ?> <span>/ orang</span></div>
                            </div>
                        </div>
                    </div>
                </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- CTA -->
    <section class="cta-section" style="padding: 80px 0; background: url('https://images.unsplash.com/photo-1555400038-63f5ba517a47?w=1920&auto=format&fit=crop') center/cover; position: relative;">
        <div style="position: absolute; inset: 0; background: rgba(0,0,0,0.3);"></div>
        <div class="container" style="position: relative; z-index: 2; text-align: center; color: white;">
            <h2 style="font-size: 36px; font-weight: 800; margin-bottom: 16px;">Siap Memulai Petualanganmu?</h2>
            <p style="font-size: 18px; opacity: 0.95; margin-bottom: 32px; max-width: 500px; margin-left: auto; margin-right: auto;">Bergabung dengan ribuan wisatawan yang telah menjelajahi Bali bersama TripWay.</p>
            <a href="<?php echo e(route('tours.index')); ?>" class="btn btn-lg" style="background: white; color: var(--primary);">Jelajahi Sekarang</a>
        </div>
    </section>

    <!-- Partners Section -->
    <section class="partners-section" style="padding: 40px 0; background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
        <div class="container">
            <p style="text-align:center; font-size:12px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:1px; margin-bottom:24px;">Our Collaboration Partners</p>
            <div class="partners-logo-container" style="display: flex; gap: 16px; align-items: center; justify-content: center; flex-wrap: wrap;">
                <?php
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
                ?>
                
                <?php $__currentLoopData = $partners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $partner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div style="background: white; border-radius: 12px; padding: 12px 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); display: flex; align-items: center; justify-content: center; min-width: 110px; height: 56px; transition: transform 0.2s; cursor: pointer;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.08)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 1px 3px rgba(0,0,0,0.05)'">
                    <img src="<?php echo e($partner['url']); ?>" alt="<?php echo e($partner['name']); ?>" style="max-height: 20px; max-width: 90px; object-fit: contain;" onerror="this.outerHTML='<span style=\'font-weight:700; color:#1B3A4B; font-size:14px;\'><?php echo e($partner['name']); ?></span>'">
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                
                <!-- Google 5 Stars -->
                <div style="background: white; border-radius: 12px; padding: 10px 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); display: flex; flex-direction: column; align-items: center; justify-content: center; min-width: 110px; height: 56px; transition: transform 0.2s; cursor: pointer;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.08)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 1px 3px rgba(0,0,0,0.05)'">
                    <img src="<?php echo e(asset('images/partners/google.jpg')); ?>" alt="Google" style="max-height: 16px; margin-bottom: 4px; object-fit: contain;" onerror="this.outerHTML='<span style=\'font-weight:700; color:#1B3A4B; font-size:14px; margin-bottom:4px;\'>Google</span>'">
                    <div style="color: #fbbc04; font-size: 10px; display:flex; gap:2px;"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.tripway', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\tripway\tripway\resources\views/landing.blade.php ENDPATH**/ ?>