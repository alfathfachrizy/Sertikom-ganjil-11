Kamu adalah asisten developer Laravel + Tailwind. Proyek "Web App Ticketing The Nice Park Rumpin" sudah memiliki: migration, model + relasi, middleware role, Policy, route, SEMUA controller terisi, Laravel Breeze (Blade, Tailwind, Vite, Alpine), dan view buatan kita yang masih KOSONG. Tugasmu dalam SATU KALI KERJA:
(A) membuat seeder data contoh, lalu
(B-F) mengisi SEMUA view dengan desain yang cerah, ceria, dan konsisten (tema hijau + kuning khas The Nice Park Rumpin).
Kerjakan berurutan A sampai H tanpa berhenti bertanya. Untuk keputusan kecil, pilih opsi paling sederhana dan catat di laporan akhir.

## BATASAN
- JANGAN mengubah struktur database, nama route, nama model, atau logika bisnis controller. Controller hanya boleh diubah minimal bila view membutuhkan relasi yang belum di-eager-load (tambahkan ke `with()`/`load()`), dan catat perubahannya.
- Sebelum menulis tiap view, BUKA controller-nya dan pakai NAMA VARIABEL yang benar-benar dikirim. Jangan mengarang variabel.
- Dilarang menjalankan query di dalam view (tidak ada `Model::where(...)`, tidak ada akses relasi yang belum di-eager-load di dalam loop). Pakai hanya data dari controller.
- Semua teks tampilan berbahasa Indonesia. Format rupiah: `Rp {{ number_format($v, 0, ',', '.') }}`. Format tanggal: `->translatedFormat('d F Y')` (set `Carbon::setLocale('id')` / `APP_LOCALE=id` bila perlu).
- Tanpa gambar eksternal dan tanpa library UI tambahan. Gunakan gradient CSS, bentuk SVG inline, dan emoji sebagai dekorasi. Pakai Tailwind (sudah ada di Breeze) dan Alpine (sudah ada).
- Semua form POST wajib `@csrf`; method spoofing `@method('PUT')`/`@method('DELETE')` sesuai route. Logout = form POST ke `route('logout')`.
- JANGAN membuat test dan JANGAN membuat fitur baru di luar daftar ini.

## TAHAP A — SEEDER (data contoh)
1. `database/seeders/TicketSeeder.php` (pakai `updateOrCreate` berdasarkan `name` agar bisa dijalankan berulang):
   - "Tiket Masuk Weekday": Rp 35.000, deskripsi: akses bermain sepuasnya (playground, rainbow slide, mini zoo). Berlaku Senin–Jumat, buka 09.00–17.45.
   - "Tiket Masuk Weekend": Rp 40.000, deskripsi sama, berlaku Sabtu, Minggu, dan hari libur, buka 08.00–17.45.
   - "Tiket Anak (Balita)": Rp 20.000, deskripsi: untuk anak usia 2–5 tahun, wajib didampingi orang dewasa.
   Beri komentar `// data contoh, sesuaikan dengan harga resmi`. Semua is_active = true.
2. `database/seeders/SchoolPackageSeeder.php` (juga `updateOrCreate` by name), semua min_participants = 20:
   - "Paket Fun Learning TK/PAUD": Rp 45.000 per peserta.
   - "Paket Field Trip SD": Rp 50.000 per peserta.
   - "Paket Outing SMP/SMA": Rp 55.000 per peserta.
   Deskripsi tiap paket memuat: tiket masuk, akses playground dan mini zoo, serta catatan "minimal 20 peserta, 1 guru pendamping gratis per 10 siswa" (tulis sebagai data contoh).
3. Panggil kedua seeder dari `DatabaseSeeder` SETELAH pembuatan akun admin dan customer yang sudah ada (jangan hapus akun itu).
4. `database/seeders/DemoOrderSeeder.php` (TIDAK dipanggil dari DatabaseSeeder; dijalankan manual dengan `php artisan db:seed --class=DemoOrderSeeder`). Tujuannya data untuk demo dan pengukuran N+1:
   - Berhenti (return) jika user `demo1@nicepark.test` sudah ada.
   - Buat 15 customer `demo1..demo15@nicepark.test` (password `password`).
   - Buat sekitar 45 pesanan campuran, dengan item, harga snapshot, dan total yang konsisten dengan harga di database:
     tiket umum Lunas (lengkap dengan Payment `settlement` + ETicket kode unik), tiket umum Menunggu Pembayaran, tiket umum Kedaluwarsa dan Dibatalkan,
     paket sekolah: Menunggu Persetujuan, Disetujui/Menunggu Pembayaran (reviewed_by = admin), Ditolak (isi rejection_reason), Lunas (lengkap dengan Payment dan ETicket).
   - `order_code` unik, `midtrans_order_id` unik (format `DEMO-<order_code>`), `visit_date` bervariasi (beberapa tanggal ke depan).
   - Gunakan Eloquent + `DB::transaction`, tanpa factory.

## TAHAP B — DESIGN SYSTEM (tema ceria hijau + kuning)
Cek versi Tailwind di package.json, lalu daftarkan token yang sama sesuai versinya (v3: `tailwind.config.js` bagian `theme.extend`; v4: blok `@theme` di `resources/css/app.css`).

Warna:
- `primary` (hijau): 50 #EDFCEF, 100 #D3F8D8, 200 #A9F0B5, 300 #74E28A, 400 #3FCB5F, 500 #1FB047, 600 #148F38, 700 #11722F, 800 #115A29, 900 #0E4B24
- `sunny` (kuning): 50 #FFFBE6, 100 #FFF4BF, 200 #FFE980, 300 #FFDB4D, 400 #FFCC1F, 500 #FFB800, 600 #E69500
- `cream`: #FFFDF0 (latar halaman). Aksen oranye: pakai `orange-500` bawaan Tailwind (untuk status menunggu dan sorotan promo).
Font (muat via fonts.bunny.net di layout): heading = "Baloo 2" (600/700/800) sebagai `font-display`; teks = "Nunito" (400/600/700) sebagai `font-sans`.

Gaya: latar `bg-cream`; kartu putih `rounded-3xl`, border `border-2 border-primary-100`, shadow lembut berwarna hijau; tombol utama pill hijau (`bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-full px-6 py-3 shadow-md`), tombol sekunder kuning (`bg-sunny-400 hover:bg-sunny-300 text-primary-900`), tombol bahaya merah lembut; hover kartu `hover:-translate-y-1 transition`; pembatas gelombang SVG antara section; blob/lingkaran dekoratif kuning dan hijau pada hero. Ukuran sentuh minimal 44px. Mobile-first, harus rapi di lebar 375px.

Buat komponen Blade anonim di `resources/views/components/ui/`:
- `button.blade.php` (props: variant primary|secondary|danger|ghost, type; bisa render `<a>` bila ada `href`)
- `card.blade.php`
- `page-header.blade.php` (judul + subjudul + slot aksi)
- `flash.blade.php` (menampilkan `session('success')` hijau dan `session('error')` merah, plus ringkasan `$errors->any()` berupa daftar pesan)
- `field.blade.php` (label + slot input + `@error` per field, teks error merah jelas dalam bahasa Indonesia)
- `status-badge.blade.php` (prop `status`), pemetaan:
  pending_approval/pending = "Menunggu Persetujuan" (kuning), rejected = "Ditolak" (merah), approved = "Disetujui" (hijau muda), awaiting_payment = "Menunggu Pembayaran" (oranye), paid = "Lunas" (hijau), cancelled = "Dibatalkan" (abu), expired = "Kedaluwarsa" (abu)
- `empty-state.blade.php` (ilustrasi emoji + teks + tombol opsional)
Restyle komponen Breeze agar otomatis seragam: `components/primary-button`, `secondary-button`, `danger-button`, `text-input`, `input-label`, `input-error`, `auth-session-status` (ganti warna indigo/gray menjadi tema primary/sunny, bentuk rounded-full untuk tombol, rounded-xl untuk input). Jangan ubah nama prop atau slot-nya.

## TAHAP C — LAYOUT
1. `resources/views/layouts/public.blade.php` (dipakai dengan `@extends('layouts.public')`, `@section('title')`, `@section('content')`, `@stack('scripts')`): memuat `@vite(['resources/css/app.css','resources/js/app.js'])`, font, `<x-ui.flash />`.
   - Navbar sticky putih/transparan dengan teks logo "The Nice Park" (font-display, hijau, aksen kuning) tanpa gambar. Menu: Beranda (`catalog.index`), Tiket (`catalog.index#tiket`), Paket Sekolah (`catalog.index#paket-sekolah`). Guest: tombol Masuk (`login`) dan Daftar (`register`). Customer: Pesanan Saya (`orders.index`), Profil (`profile.edit`), Keluar (form POST logout). Admin: tombol "Panel Admin" (`admin.dashboard`) dan Keluar. Menu mobile pakai Alpine (hamburger).
   - Footer hijau tua dengan gelombang di atasnya: nama tempat, alamat "Kp Cisirung, RT.003/RW.001, Kec. Rumpin, Kabupaten Bogor, Jawa Barat 16350", jam operasional (Weekday 09.00–17.45, Weekend 08.00–17.45), Instagram @thenicepark lalu langsung "rumpin" tanpa spasi (tulis sebagai teks), dan catatan "Rombongan minimal 20 orang".
2. `resources/views/layouts/admin.blade.php` (dipakai dengan `@extends('layouts.admin')`): sidebar hijau tua (`bg-primary-900`) dengan menu Dashboard, Tiket, Paket Sekolah, Pengajuan Sekolah, Pesanan (tandai menu aktif lewat `request()->routeIs('admin.tickets.*')`, dst.), tautan "Lihat Website" (`catalog.index`), dan Keluar (form POST). Area konten latar `bg-cream`, topbar dengan nama admin. Responsif: sidebar menjadi drawer Alpine di mobile. Tampilkan `<x-ui.flash />`.
3. Ubah `layouts/guest.blade.php` (Breeze): latar gradient hijau–krem, kartu putih rounded-3xl di tengah, teks logo "The Nice Park" di atas kartu, dekorasi lingkaran kuning. Pertahankan `{{ $slot }}`.

## TAHAP D — HALAMAN PELANGGAN (isi file view yang kosong)
- `catalog/index`: 
  - Hero: gradient hijau cerah dengan lingkaran kuning, judul "Main Sepuasnya di The Nice Park Rumpin!", subjudul singkat, dua tombol ("Lihat Tiket" ke #tiket, "Pesan Paket Sekolah" ke #paket-sekolah), chip jam operasional dan "Diskon HTM Rp 35.000".
  - Section "Kenapa Main di The Nice?" 4 kartu: Rainbow Slide, Mini Zoo, Playground, Kuliner (emoji + 1 kalimat).
  - Section `#tiket`: grid kartu tiket (nama, deskripsi singkat `Str::limit`, harga besar berwarna, tombol "Lihat Detail"). Section `#paket-sekolah`: grid kartu paket (harga per peserta, badge "Min. N peserta", tombol detail). Pakai `<x-ui.empty-state>` bila kosong.
  - Section "Cara Memesan" 3 langkah bernomor (Pilih → Bayar → E-ticket; untuk sekolah: Ajukan → Disetujui admin → Bayar → E-ticket).
- `catalog/ticket-show`: breadcrumb, judul, harga besar, deskripsi, kotak "Ketentuan Kunjungan" (jam operasional weekday/weekend, tiket berlaku sesuai tanggal kunjungan yang dipilih, e-ticket terbit setelah pembayaran terverifikasi), tombol "Pesan Tiket" ke `ticket-orders.create`. Guest tetap melihat tombol (akan diarahkan login oleh middleware). Jika `auth()->user()?->isAdmin()`, ganti tombol dengan catatan "Admin tidak dapat memesan tiket".
- `catalog/package-show`: seperti di atas, tambah daftar fasilitas, "Minimal N peserta", penjelasan alur persetujuan admin, tombol "Ajukan Paket" ke `school-submissions.create`.
- `ticket-orders/create`: form POST `ticket-orders.store`; hidden `ticket_id`; input jumlah dengan tombol − / + (Alpine, min 1, max 50); input tanggal kunjungan (`min` = hari ini); kartu ringkasan di samping dengan estimasi total real-time (Alpine; beri catatan kecil "Total akhir dihitung ulang oleh server"). Tampilkan error per field memakai `<x-ui.field>` dan `old()`.
- `school-submissions/create`: form POST `school-submissions.store`; hidden `school_package_id`; field: nama sekolah, nama penanggung jawab, no. HP penanggung jawab, jumlah peserta (hint minimum), tanggal kunjungan; ringkasan estimasi total (Alpine) dan kotak info alur "Pengajuan ditinjau admin dulu, pembayaran dibuka setelah disetujui".
- `school-submissions/show`: stepper 4 langkah (Diajukan → Ditinjau Admin → Pembayaran → E-ticket) yang menandai tahap saat ini berdasarkan status; data pengajuan; badge status; bila ditolak tampilkan alasan penolakan di kotak merah lembut; bila `$submission->order->status === 'awaiting_payment'` tampilkan tombol "Bayar Sekarang" (`payments.pay`).
- `orders/index`: daftar kartu atau tabel responsif: kode pesanan, jenis (Tiket Umum / Paket Sekolah), tanggal kunjungan, total, `<x-ui.status-badge>`, tombol "Detail"; `{{ $orders->links() }}`; empty state.
- `orders/show`: ringkasan pesanan, tabel item (nama, jumlah, harga satuan, subtotal, total), riwayat pembayaran (status, metode, waktu), tombol kontekstual: "Bayar Sekarang" bila awaiting_payment, "Lihat E-ticket" bila paid dan punya e-ticket, tautan ke pengajuan bila pesanan sekolah.
- `payments/pay`: ringkasan pesanan + tombol besar "Bayar Sekarang". Muat Snap.js lewat `@push('scripts')`: URL `https://app.sandbox.midtrans.com/snap/snap.js` (pakai `https://app.midtrans.com/snap/snap.js` bila `config('midtrans.is_production')`), atribut `data-client-key="{{ config('midtrans.client_key') }}"`. Klik tombol memanggil `window.snap.pay('{{ $payment->snap_token }}', { onSuccess, onPending, onError, onClose })`; onSuccess dan onPending mengarahkan ke `route('payments.finish', $order)`; onError menampilkan pesan error; onClose menampilkan pesan "Pembayaran belum diselesaikan". Tambahkan catatan "Mode uji coba (Sandbox), tidak ada uang sungguhan".
- `etickets/show`: desain tiket: kartu dengan sisi kiri hijau dan sisi kanan putih, garis putus-putus dengan lubang setengah lingkaran, memuat nama tempat, kode e-ticket besar, nama pemesan, tanggal kunjungan, rincian item/jumlah, kode pesanan, dan QR code. Untuk QR: jalankan `composer require simplesoftwareio/simple-qrcode` dan render dengan `{!! \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->size(140)->generate($order->eTicket->ticket_code) !!}`; JIKA instalasi gagal, lewati QR dan tampilkan kode dalam kotak putus-putus. Tambahkan tombol "Cetak E-ticket" (`window.print()`) dan CSS `@media print` yang menyembunyikan navbar, footer, dan tombol.

## TAHAP E — HALAMAN AUTH BREEZE (restyle saja)
Restyle `auth/login`, `auth/register`, `auth/forgot-password`, `auth/reset-password`: tambahkan judul ceria dan satu kalimat sambutan, serta tautan silang Masuk/Daftar. PERTAHANKAN semua field, atribut `name`, `@csrf`, dan logika bawaan Breeze (termasuk input `phone` di register). Ubah `profile/edit.blade.php` agar memakai `@extends('layouts.public')` (pindahkan isinya ke `@section('content')`, partial profil tetap dipakai). `dashboard.blade.php` biarkan.

## TAHAP F — PANEL ADMIN (semua memakai `@extends('layouts.admin')`)
- `admin/dashboard`: 4 kartu statistik berwarna (Total Pesanan, Pesanan Lunas, Pengajuan Menunggu, Total Pendapatan dalam rupiah) dengan emoji besar, plus tautan cepat ke Pengajuan Sekolah dan Pesanan. Pakai nama variabel dari `Admin\DashboardController`.
- `admin/tickets/index|create|edit` dan `admin/school-packages/index|create|edit`: tabel responsif (nama, harga, status aktif sebagai badge, tombol Edit dan Hapus; Hapus = form DELETE dengan konfirmasi `onsubmit="return confirm('Hapus data ini?')"`), tombol "Tambah", pagination. Buat partial form bersama `admin/tickets/_form.blade.php` dan `admin/school-packages/_form.blade.php` (field sesuai validasi controller, `old()` + nilai model saat edit, checkbox `is_active` dengan hidden input 0 + checkbox 1 atau pola yang cocok dengan `$request->boolean`).
- `admin/school-submissions/index`: tab filter status (Semua, Menunggu, Disetujui, Ditolak) memakai query `?status=`, tabel (sekolah, penanggung jawab, paket, jumlah peserta, tanggal kunjungan, status, tombol "Tinjau"), pagination.
- `admin/school-submissions/show`: detail lengkap pengajuan dan pesanan. Bila status pending: tombol hijau "Setujui" (form POST `admin.school-submissions.approve`) dan tombol merah "Tolak" yang membuka kotak Alpine berisi textarea `rejection_reason` (form POST `admin.school-submissions.reject`, tampilkan error). Bila sudah diproses: tampilkan hasil, alasan penolakan, nama peninjau, dan waktu tinjau.
- `admin/orders/index`: filter status (query `?status=`), tabel (kode, pelanggan, jenis, tanggal kunjungan, total, status pesanan, status pembayaran terakhir), pagination. `admin/orders/show`: detail pesanan, item, pelanggan, pengajuan sekolah (bila ada), riwayat pembayaran, dan e-ticket (bila ada).
Pastikan setiap relasi yang dipakai di tabel sudah di-eager-load oleh controller; bila belum, tambahkan `with()` di controller.

## TAHAP G — VERIFIKASI (jalankan, perbaiki sampai bersih)
1. `npm install` lalu `npm run build` tanpa error.
2. `php artisan migrate:fresh --seed` tanpa error, lalu `php artisan db:seed --class=DemoOrderSeeder` tanpa error. Setelah itu jalankan lagi `php artisan migrate:fresh --seed` agar database kembali bersih (tanpa data demo) dan beri tahu cara memuat data demo.
3. `php artisan view:clear && php artisan view:cache` tanpa error (ini mengompilasi semua Blade dan menangkap kesalahan sintaks), lalu `php artisan view:clear`.
4. `php artisan route:list` tanpa error; setiap `route('...')` di view harus ada di daftar route.
5. `find app routes config database -name '*.php' -exec php -l {} \;` tanpa syntax error.
6. Telusuri semua view buatan kita: tidak ada variabel yang tidak dikirim controller, tidak ada query di view, semua form ber-`@csrf`.

## TAHAP H — LAPORAN AKHIR
Tampilkan: daftar file yang dibuat dan diubah, perubahan kecil pada controller (jika ada), keputusan yang kamu ambil sendiri, hasil perintah verifikasi, dan daftar halaman yang harus saya uji manual. Jangan menambahkan fitur di luar daftar ini.