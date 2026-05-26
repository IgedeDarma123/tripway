# Fix Plan: Missing HTML Closing Tags

## Root Cause

Many Blade view files have missing closing tags (`</div>`, `</section>`), causing the browser to auto-correct the DOM incorrectly and produce a messy/broken layout.

## Files to Fix

### 1. resources/views/landing.blade.php

- [ ] Categories section: close `.categories-grid`, `.container`, and `</section>`
- [ ] Destinations section: close `.destinations-grid`, `.container`, and `</section>`
- [ ] Popular Tours section: close `.tour-footer`, inner div, `.tours-grid`, `.container`, and `</section>`
- [ ] Trust Badges section: close `.trust-grid`, `.container`, and `</section>`
- [ ] Featured Tours section: close `.tours-grid`, `.tour-footer`, inner div, `.container`, and `</section>`

### 2. resources/views/tours/index.blade.php

- [ ] Close `.tours-hero` div
- [ ] Close `.filter-bar` div
- [ ] Close `.sidebar` aside tag
- [ ] Close `.tours-grid-page` div
- [ ] Close right column div
- [ ] Close `.tours-layout` div
- [ ] Close final `.container` div

### 3. resources/views/tours/show.blade.php

- [ ] Close `.tour-header` div
- [ ] Close `.tour-rating-big` div
- [ ] Close `.itinerary-item` div inside loop
- [ ] Close `.form-row` div
- [ ] Close `.booking-summary` div
- [ ] Close `.booking-card` div
- [ ] Close `.tour-detail` div
- [ ] Close related tour card footer divs

### 4. resources/views/bookings/index.blade.php

- [ ] Close `.booking-info` div
- [ ] Close `.booking-status` div
- [ ] Close `.booking-card` div

### 5. resources/views/home.blade.php

- [ ] Close all 3 `.stat-card` divs
- [ ] Close `.stats-grid` div
- [ ] Close `.booking-row` div inside loop

## Follow-up

- [ ] Run `php artisan view:clear`
- [ ] Test pages in browser
