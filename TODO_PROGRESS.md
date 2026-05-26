# Progress Perbaikan

## Masalah

- Foto destinasi memanjang/memenuhi layar dan tipis (kepotong)
- Bug HTML di tours/index.blade.php (tag penutup salah)

## Plan

1. [ ] Fix `tours/index.blade.php` — ganti `</div>` dengan `</a>`, hapus `</a>` berlebih
2. [ ] Fix `landing.blade.php` — perbaiki CSS `.destination-card` agar tampilan foto tidak memanjang
3. [ ] Fix `tours/show.blade.php` — perbaiki tag penutup form-row (children form-group missing `</div>`)
4. [ ] Update `TODO_DESTINATION_FIX.md` — tandai selesai
5. [ ] Update `TODO_FIX.md` — tandai selesai
6. [ ] Run `php artisan view:clear`
