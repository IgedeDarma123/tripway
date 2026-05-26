# TripWay - Admin Dashboard & Fake Review Implementation

## Progress

- [x] Add is_admin field to users table (migration)
- [x] Create reviews table (migration)
- [x] Create Review model
- [x] Update User model (is_admin)
- [x] Update Tour model (reviews relation, recalculateRating)
- [x] Create AdminMiddleware
- [x] Register admin middleware alias
- [x] Create AdminController
- [x] Create admin layout (layouts/admin.blade.php)
- [x] Create admin dashboard view
- [x] Create admin tours views (index, create, edit)
- [x] Create admin categories view
- [x] Create admin destinations view
- [x] Create admin bookings view
- [x] Create admin reviews view (with fake review generator)
- [x] Update web.php routes
- [x] Update DatabaseSeeder (add admin user)
- [x] Create AdminUserSeeder
- [x] Update tripway layout (add admin link)
- [x] Run migrations
- [x] Run admin seeder
- [x] Clear view cache

## Admin Access

- URL: `/admin`
- Email: `admin@tripway.com`
- Password: `password`

## Features

### Admin Dashboard

- Dashboard statistik (total tours, bookings, users, reviews)
- Akses cepat ke semua menu

### Tour Management (CRUD)

- List semua tour dengan search & filter
- Tambah tour baru
- Edit tour
- Hapus tour
- Toggle featured & active

### Category Management (CRUD)

- List kategori
- Tambah kategori
- Edit kategori inline
- Hapus kategori

### Destination Management (CRUD)

- List destinasi
- Tambah destinasi
- Edit destinasi inline
- Hapus destinasi

### Booking Management

- List semua booking
- Update status booking (pending, confirmed, cancelled, completed)
- Hapus booking

### Review & Fake Review

- Tambah review manual untuk tour apapun
- Generate fake review otomatis (1-50 review per klik, rating 4-5 bintang)
- Hapus review
- Badge "Fake" / "Real" pada daftar review
