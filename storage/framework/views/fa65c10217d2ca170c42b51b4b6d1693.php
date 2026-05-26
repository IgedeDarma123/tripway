<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo $__env->yieldContent('title', 'TripWay - Temukan Petualangan Terbaik di Bali'); ?></title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Tailwind CSS CDN for component demo -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            orange: {
              400: '#ff8c33',
              500: '#ff6b00',
              600: '#e55a00',
            }
          }
        }
      }
    }
    </script>

    <style>
:root {
--primary: #30525c;
            --primary-dark: #24414a;
            --secondary: #1D4ED8;
            --text-dark: #111827;
            --text-medium: #4B5563;
            --text-light: #6B7280;
            --bg-light: #F1F5F9;
            --border: #D1D5DB;
            --white: #FFFFFF;
            --shadow: 0 2px 8px rgba(0,0,0,0.08);
            --shadow-lg: 0 4px 20px rgba(0,0,0,0.12);
            --radius: 12px;
            --radius-sm: 8px;
            --sidebar-bg: #0F172A;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            color: var(--text-dark);
            background: var(--white);
            line-height: 1.6;
        }

        a { text-decoration: none; color: inherit; }

        /* Navbar */
        .navbar {
            background: var(--white);
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .navbar-inner {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 24px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .logo {
            font-size: 24px;
            font-weight: 800;
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .logo i { font-size: 20px; }
        .nav-links {
            display: flex;
            align-items: center;
            gap: 28px;
        }
        .nav-links a {
            font-size: 14px;
            font-weight: 500;
            color: var(--text-medium);
            transition: color 0.2s;
        }
        .nav-links a:hover { color: var(--primary); }
        .nav-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 20px;
            border-radius: var(--radius-sm);
            font-size: 14px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
            gap: 6px;
        }
        .btn-primary {
            background: var(--primary);
            color: var(--white);
        }
        .btn-primary:hover { background: var(--primary-dark); }
        .btn-outline {
            background: transparent;
            color: var(--text-medium);
            border: 1px solid var(--border);
        }
        .btn-outline:hover {
            border-color: var(--primary);
            color: var(--primary);
        }
        .btn-sm { padding: 8px 16px; font-size: 13px; }
        .btn-lg { padding: 14px 28px; font-size: 16px; }
        .btn-full { width: 100%; }

        /* Footer */
        .footer {
            background: #1a1a1a;
            color: #aaa;
            padding: 60px 0 30px;
            margin-top: 80px;
        }
        .footer-inner {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 24px;
        }
        .footer-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 40px;
            margin-bottom: 40px;
        }
        .footer-brand .logo {
            color: var(--white);
            margin-bottom: 16px;
        }
        .footer-brand p {
            font-size: 14px;
            line-height: 1.7;
            color: #888;
        }
        .footer-col h4 {
            color: var(--white);
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 16px;
        }
        .footer-col ul { list-style: none; }
        .footer-col li { margin-bottom: 10px; }
        .footer-col a {
            font-size: 14px;
            color: #888;
            transition: color 0.2s;
        }
        .footer-col a:hover { color: var(--white); }
        .footer-bottom {
            border-top: 1px solid #333;
            padding-top: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 13px;
            color: #666;
        }
        .footer-social {
            display: flex;
            gap: 16px;
        }
        .footer-social a {
            color: #888;
            font-size: 18px;
            transition: color 0.2s;
        }
        .footer-social a:hover { color: var(--primary); }

        main { min-height: calc(100vh - 64px); padding-top: 32px; }

        /* Responsive */
        @media (max-width: 768px) {
            .footer-grid { grid-template-columns: repeat(2, 1fr); }
            .nav-links { display: none; }
        }
        @media (max-width: 480px) {
            .footer-grid { grid-template-columns: 1fr; }
            .navbar-inner { padding: 0 16px; }
        }

        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 24px;
        }
    </style>

<?php echo $__env->yieldContent('styles'); ?>
<!-- Vite after page styles -->
<?php if(config('app.env') !== 'local'): ?>
<?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
<?php endif; ?>

</head>
<body>
    <nav class="navbar">
        <div class="navbar-inner">
            <a href="<?php echo e(url('/')); ?>" class="logo">
                <i class="fas fa-paper-plane"></i>
                TripWay
            </a>

            <div class="nav-links">
                <a href="<?php echo e(route('tours.index')); ?>">Tour & Aktivitas</a>
                <a href="<?php echo e(route('tours.index', ['destination' => 'ubud'])); ?>">Destinasi</a>
                <a href="#">Tentang Kami</a>
            </div>

            <div class="nav-actions">
                <?php if(auth()->guard()->guest()): ?>
                    <a href="<?php echo e(route('login')); ?>" class="btn btn-outline btn-sm">Masuk</a>
                    <a href="<?php echo e(route('register')); ?>" class="btn btn-primary btn-sm">Daftar</a>
                <?php else: ?>
                    <?php if(Auth::user()->is_admin): ?>
                        <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-primary btn-sm">
                            <i class="fas fa-cog"></i> Admin
                        </a>
                    <?php endif; ?>
                    <a href="<?php echo e(route('home')); ?>" class="btn btn-outline btn-sm">
                        <i class="fas fa-user"></i>
                        <?php echo e(Auth::user()->name); ?>

                    </a>
                    <a href="<?php echo e(route('logout')); ?>" class="btn btn-outline btn-sm"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Keluar
                    </a>
                    <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                        <?php echo csrf_field(); ?>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <main>
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <footer class="footer">
        <div class="footer-inner">
            <div class="footer-grid">
                <div class="footer-brand">
                    <div class="logo">
                        <i class="fas fa-paper-plane"></i>
                        TripWay
                    </div>
                    <p>Platform pemesanan aktivitas dan tur terbaik di Bali. Temukan pengalaman tak terlupakan bersama kami.</p>
                </div>
                <div class="footer-col">
                    <h4>Perusahaan</h4>
                    <ul>
                        <li><a href="#">Tentang Kami</a></li>
                        <li><a href="#">Karir</a></li>
                        <li><a href="#">Blog</a></li>
                        <li><a href="#">Pers</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Need Help?</h4>
                    <div style="margin-bottom: 20px;">
                        <p style="margin-bottom: 4px; font-size: 13px; color: #888; text-transform: uppercase; font-weight: 600; letter-spacing: 1px;">Call us</p>
                        <a href="tel:+628983317309" style="display: block; font-weight: 500; font-size: 15px; color: #ccc; margin-bottom: 4px; transition: color 0.2s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='#ccc'">+62 898-3317-309</a>
                        <a href="tel:+628983317309" style="display: block; font-weight: 500; font-size: 15px; color: #ccc; transition: color 0.2s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='#ccc'">+62 898-3317-309</a>
                    </div>
                    
                    <div style="margin-bottom: 20px;">
                        <p style="margin-bottom: 4px; font-size: 13px; color: #888; text-transform: uppercase; font-weight: 600; letter-spacing: 1px;">Email us</p>
                        <a href="mailto:tripway@gmail.com" style="display: block; font-weight: 500; font-size: 15px; color: #ccc; transition: color 0.2s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='#ccc'">tripway@gmail.com</a>
                    </div>
                    
                    <div>
                        <p style="margin-bottom: 4px; font-size: 13px; color: #888; text-transform: uppercase; font-weight: 600; letter-spacing: 1px;">Location</p>
                        <p style="font-size: 14px; line-height: 1.6; color: #ccc;">Jalan Tukad Banyuning II Number 5, Panjer, South Denpasar, Denpasar, Bali</p>
                    </div>
                </div>
                <div class="footer-col">
                    <h4>Destinasi Populer</h4>
                    <ul>
                        <li><a href="<?php echo e(route('tours.index', ['destination' => 'ubud'])); ?>">Ubud</a></li>
                        <li><a href="<?php echo e(route('tours.index', ['destination' => 'seminyak'])); ?>">Seminyak</a></li>
                        <li><a href="<?php echo e(route('tours.index', ['destination' => 'uluwatu'])); ?>">Uluwatu</a></li>
                        <li><a href="<?php echo e(route('tours.index', ['destination' => 'nusa-penida'])); ?>">Nusa Penida</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <span>&copy; <?php echo e(date('Y')); ?> TripWay. All rights reserved.</span>
                <div class="footer-social">
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Alpine CDN -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <?php echo $__env->yieldContent('scripts'); ?>
</body>
</html>
<?php /**PATH D:\tripway\tripway\resources\views/layouts/tripway.blade.php ENDPATH**/ ?>