# TODO: Add Photo Upload Feature for Students

## Steps:
- [x] 1. Create migration `database/migrations/2024_10_28_100000_add_foto_to_input_aspirasis_table.php`
- [x] 2. Update `app/Models/InputAspirasi.php` ($fillable)
- [x] 3. Update `app/Http/Controllers/StudentController.php` (storeAspirasi: validation + upload)
- [x] 4. Update `resources/views/siswa/create_aspirasi.blade.php` (add file input)
- [x] 5. Update `resources/views/siswa/dashboard.blade.php` (display photo)
- [x] 6. Run `php artisan migrate`
- [x] 7. Run `php artisan storage:link`
- [ ] 8. Test feature (login as siswa, create aspirasi with photo, verify upload/display in dashboard)

**Bug fixed (NIS max:10). Feature ready. Test now.**
