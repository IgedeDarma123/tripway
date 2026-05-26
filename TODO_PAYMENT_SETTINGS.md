# Plan: Payment Settings Management

## Task:

Add/edit all payment settings in admin dashboard and make them changeable in payment section

## Files to Create:

1. `resources/views/admin/payments/index.blade.php` - Admin payment settings management page

## Files to Edit:

1. `app/Http/Controllers/AdminController.php` - Add CRUD methods for payment settings
2. `routes/web.php` - Add routes for payment settings
3. `resources/views/layouts/admin.blade.php` - Add navigation link for payment settings
4. `app/Services/MockPaymentService.php` - Use database payment settings
5. `resources/views/payments/show.blade.php` - Use database payment methods

## Steps:

### Step 1: Add CRUD methods to AdminController

- paymentsIndex() - List all payment settings
- paymentsStore() - Create new payment setting
- paymentsUpdate() - Update payment setting
- paymentsDestroy() - Delete payment setting
- paymentsToggle() - Toggle is_active status

### Step 2: Add routes

- GET /admin/payments - List payment settings
- POST /admin/payments - Create
- PUT /admin/payments/{id} - Update
- DELETE /admin/payments/{id} - Delete

### Step 3: Create admin view

- Create admin/payments/index.blade.php with form for add/edit

### Step 4: Update admin layout

- Add link in sidebar navigation

### Step 5: Update MockPaymentService

- Read payment methods from database
- Use account_number from database for VA display

### Step 6: Update payments/show.blade.php

- Load payment methods from database
- Display configured account numbers

## Dependencies:

- PaymentSetting model (already exists)
- payment_settings migration (already exists)
