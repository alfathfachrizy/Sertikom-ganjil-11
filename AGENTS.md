## PERAN DAN TUJUAN

Kamu adalah senior product designer sekaligus front-end developer (Laravel Blade + Tailwind CSS + Alpine.js). Proyek "Web App Ticketing The Nice Park Rumpin" sudah berfungsi: backend, route, controller, dan view Blade sudah terisi. Tugasmu **merapikan seluruh tampilan** agar terlihat **bersih, tertata, profesional, dan ceria tanpa terlihat seperti template AI generik ("slop")**.

Ini adalah pekerjaan **refactor visual**, bukan membangun ulang. Hasil akhir harus terasa seperti dirancang oleh satu orang desainer dengan sistem yang jelas.

## REFERENSI BRAND (dari akun Instagram @thenicepark­rumpin Dan website https://tamansafari.com)

Ambil karakter visual dari akun tersebut:

- **Warna dominan:** hijau tua dan hijau cerah (ikon highlight), kuning matahari dan sedikit oranye (poster promo), latar krem/putih hangat.
- **Karakter:** ramah keluarga, ceria, tipografi tebal dan membulat, bentuk membulat, banyak ruang bernapas, satu pesan utama per poster (contoh: "Main Sepuasnya!", "Diskon Rombongan").
- **Informasi nyata yang boleh dipakai:** jam operasional Weekday 09.00 sampai 17.45 dan Weekend 08.00 sampai 17.45; lokasi Kp Cisirung, Kec. Rumpin, Kabupaten Bogor, Jawa Barat 16350; rombongan minimal 20 orang; wahana: Rainbow Slide, Playground, Mini Zoo, Kuliner.
- Jangan mengarang fakta, harga, atau testimoni baru. Jangan memakai logo atau foto dari Instagram.

## BATASAN KERAS (WAJIB)

1. **Jangan ubah logika:** controller, route, model, migration, policy, middleware, dan nama route tidak boleh diubah. Satu-satunya pengecualian: menambah `with()`/`load()` bila view memang membutuhkan relasi, dan catat di laporan.
2. **Jangan ubah nama variabel, atribut `name`, `@csrf`, `@method`, `old()`, `@error`, dan action form.** Form harus tetap berfungsi persis seperti sebelumnya.
3. Jangan hapus fungsi: Alpine (hitung estimasi, drawer, modal tolak), Snap.js Midtrans, tombol cetak e-ticket, filter status, pagination.
4. Jangan menambah fitur baru, halaman baru, atau library UI baru. Pakai Tailwind, Alpine, dan Vite yang sudah ada.
5. Tanpa gambar eksternal, tanpa foto stok, tanpa CDN gambar. Visual hanya dari warna, tipografi, bentuk sederhana, dan ikon SVG inline.
6. Semua teks tampilan tetap **bahasa Indonesia**.
7. Jangan menjalankan query di dalam view.

## DEFINISI "SLOP" (HARUS DIHINDARI)

Periksa dan hilangkan semua ciri berikut dari tampilan saat ini:

- Emoji dipakai sebagai ikon di mana-mana (judul, kartu, tombol, empty state). **Ganti dengan ikon SVG inline bergaya garis (stroke) yang seragam**; emoji hanya boleh di nol atau satu tempat.
- Blob, lingkaran, dan gelombang dekoratif berlebihan, atau lebih dari satu elemen dekoratif per section.
- Gradient ramai, banyak warna dalam satu layar, atau gradient pada tombol dan teks.
- Warna default framework yang bocor: indigo/ungu Breeze, abu-abu biru yang tidak sesuai tema.
- Semua section memakai pola yang sama (judul tengah + 3 kartu identik + tombol). Variasikan ritme layout.
- Kartu dengan border tebal, bayangan berat, atau hover yang berlebihan (melompat, berputar, bergoyang).
- Teks marketing hampa ("Solusi terbaik untuk liburan Anda", "Pengalaman tak terlupakan"). Pakai kalimat pendek, spesifik, dan benar.
- Banyak ukuran dan bobot font acak, huruf kapital semua di mana-mana, teks pusat (center) untuk paragraf panjang.
- Spasi tidak konsisten (margin/padding acak), elemen tidak sejajar, tinggi kartu tidak seragam.
- Tabel padat tanpa hierarki, tombol dengan ukuran berbeda-beda untuk aksi yang setara.
- Badge, chip, dan pill dipakai berlebihan hingga setiap baris penuh label berwarna.

## DESIGN SYSTEM

Cek versi Tailwind di `package.json`. Bila token `primary`, `sunny`, `cream` sudah ada, **sesuaikan nilainya, jangan buat token duplikat**. (Tailwind v3: `tailwind.config.js`; v4: blok `@theme` di `resources/css/app.css`.)

### Warna (satu sumber kebenaran)

| Token | Nilai | Pemakaian |
|---|---|---|
| `primary-900` | #0E4B24 | Footer, sidebar admin, teks judul di atas terang |
| `primary-700` | #11722F | Hover tombol utama, tautan |
| `primary-600` | #148F38 | Tombol utama, ikon aktif |
| `primary-100` | #D3F8D8 | Latar badge sukses, border halus |
| `primary-50` | #EDFCEF | Latar section selang-seling |
| `sunny-400` | #FFCC1F | Aksen tunggal: harga, highlight, tombol sekunder |
| `sunny-100` | #FFF4BF | Latar badge menunggu, kotak info |
| `cream` | #FFFDF0 | Latar halaman |
| `ink` | #14301F | Teks utama (jangan hitam murni) |
| `ink-soft` | #4B6355 | Teks sekunder |
| `line` | #E4EBDD | Border dan pembatas |

Aturan pemakaian warna (proporsi 60-30-10):
- 60% krem/putih, 30% hijau, 10% kuning. **Kuning adalah aksen, bukan latar utama.**
- Status memakai pemetaan tetap: Menunggu Persetujuan = kuning, Menunggu Pembayaran = oranye lembut, Lunas/Disetujui = hijau, Ditolak = merah lembut, Dibatalkan/Kedaluwarsa = abu.
- Kontras teks minimal 4.5:1. Jangan menaruh teks kuning di atas putih/krem.

### Tipografi

- Heading: **Baloo 2** (hanya bobot 600 dan 700). Teks: **Nunito** (400, 600, 700). Muat dari fonts.bunny.net dengan `display=swap`.
- Skala ukuran tetap (jangan menambah ukuran lain): `text-sm` (14), `text-base` (16), `text-lg` (18), `text-2xl` (24), `text-4xl` (36), `text-5xl` (48, hanya hero, desktop).
- Tinggi baris: heading `leading-tight`, teks `leading-relaxed`. Lebar baca paragraf maksimal `max-w-prose`. Paragraf rata kiri.
- Sentence case untuk judul dan tombol, bukan huruf kapital semua.

### Spasi, bentuk, bayangan

- Grid spasi kelipatan 4 (4, 8, 12, 16, 24, 32, 48, 64). Jangan memakai nilai acak seperti `mt-7` atau `p-5` bila ada alternatif skala.
- Container: `max-w-6xl mx-auto px-4 sm:px-6 lg:px-8`. Jarak antar section `py-12 md:py-20`.
- Radius hanya tiga level: `rounded-xl` (input, kotak info), `rounded-2xl` (kartu), `rounded-full` (tombol, badge).
- Border `1px` warna `line`. Bayangan hanya satu gaya lembut (`shadow-sm`; `shadow-md` hanya untuk elemen melayang seperti dropdown/modal).
- Hover kartu: perubahan halus saja (border menjadi `primary-100` atau bayangan naik satu level). **Tanpa translate/scale.** Durasi transisi 150 sampai 200 ms.

### Ikon

Buat komponen `components/ui/icon.blade.php` dengan prop `name` yang me-render SVG inline stroke 1.75, ukuran `size-5` atau `size-6`, `currentColor`. Set ikon minimal: ticket, calendar, users, school, map-pin, clock, check-circle, x-circle, hourglass, credit-card, qr-code, printer, arrow-right, plus, pencil, trash, home, menu, close, receipt. Semua ikon sama gaya dan sama ketebalan.

## KOMPONEN (rapikan yang sudah ada di `resources/views/components/ui/`)

Pastikan kesembilan komponen ini konsisten, lalu **pakai ulang di seluruh halaman** (hapus class yang diulang manual):

- `button` (varian primary, secondary, ghost, danger; ukuran md dan sm; tinggi sentuh minimal 44px; state hover, focus-visible ring `ring-2 ring-primary-600 ring-offset-2`, disabled)
- `card`, `page-header`, `flash`, `field`, `status-badge`, `empty-state`, `icon`
- Tambah `section-heading` (judul section + deskripsi satu kalimat, rata kiri) dan `info-box` (kotak info kuning lembut/hijau lembut dengan ikon SVG).
- Restyle komponen Breeze (`primary-button`, `secondary-button`, `danger-button`, `text-input`, `input-label`, `input-error`) agar identik dengan komponen di atas. Jangan ubah nama prop dan slot.

## ARAHAN PER HALAMAN

**Layout publik**
- Navbar putih, tinggi seragam, border bawah `line`, tanpa bayangan berat. Logo berupa teks "The Nice Park" (heading hijau tua). Maksimal 3 tautan menu + aksi akun. Item aktif ditandai garis bawah hijau tipis. Mobile: menu hamburger Alpine yang rapi.
- Footer `primary-900`, tiga kolom sederhana (tentang, jam operasional, lokasi), teks krem, tanpa gelombang dekoratif.

**Beranda / katalog**
- Hero: dua kolom di desktop (teks kiri, panel visual kanan). Panel visual dibuat dari bentuk geometris sederhana (misalnya kartu "Tiket mulai Rp 35.000" + jam operasional) di atas latar `primary-50`; **tanpa blob dan tanpa emoji**. Satu judul, satu paragraf maksimal dua kalimat, dua tombol (utama dan sekunder).
- Strip info 3 kolom tipis (jam operasional, lokasi, rombongan min. 20 orang) dengan ikon SVG.
- Tiket dan paket sekolah: grid kartu yang **tinggi dan susunan isinya seragam** (nama, deskripsi dua baris, harga menonjol dengan satuan kecil, tombol di dasar kartu lewat `mt-auto`). Bedakan paket sekolah dari tiket umum lewat label kecil, bukan warna latar yang berbeda total.
- "Cara memesan": dua baris langkah bernomor (tiket umum dan paket sekolah) berupa daftar vertikal sederhana atau stepper horizontal ringan, bukan kartu besar.
- Hindari section "Kenapa memilih kami" generik. Bila perlu, ganti dengan daftar wahana (Rainbow Slide, Playground, Mini Zoo, Kuliner) berupa baris teks + ikon.

**Detail tiket / paket**
- Dua kolom: kiri deskripsi dan ketentuan kunjungan (daftar bersih), kanan kartu ringkasan lengket (`lg:sticky lg:top-24`) berisi harga dan tombol pesan.

**Form pesan tiket / ajukan paket sekolah**
- Satu kolom form di kiri, ringkasan sticky di kanan. Label di atas input, teks bantu `text-sm ink-soft`, pesan error merah lembut tepat di bawah field dengan ikon kecil. Tinggi input 44px. Stepper jumlah (− / +) rapi, ukuran tombol sama.
- Kelompokkan field sekolah (data sekolah, penanggung jawab, kunjungan) dengan sub-judul kecil, bukan kartu bersarang.

**Pembayaran**
- Ringkasan pesanan di kiri, panel aksi di kanan dengan satu tombol "Bayar sekarang" dan catatan kecil Sandbox. Tanpa dekorasi.

**Riwayat dan detail pesanan**
- Daftar baris bersih: kode pesanan (tebal), jenis, tanggal kunjungan, total, badge status, aksi. Desktop: tabel dengan header `ink-soft` kecil dan pemisah baris tipis; mobile: tiap baris menjadi kartu ringkas. Detail pesanan: ringkasan di atas, tabel item, riwayat pembayaran sebagai daftar vertikal bergaris waktu sederhana.

**Pengajuan sekolah (sisi pelanggan)**
- Stepper empat langkah horizontal yang tegas dan konsisten (selesai = hijau, saat ini = kuning, belum = abu). Alasan penolakan di `info-box` merah lembut.

**E-ticket**
- Tiket horizontal bersih: panel kiri `primary-900` (nama tempat, kode e-ticket besar monospaced), panel kanan putih (pemesan, tanggal kunjungan, item, QR). Garis sobekan putus-putus. Seluruh elemen dekoratif dibatasi pada garis sobekan. Pertahankan CSS cetak (sembunyikan navbar, footer, tombol).

**Auth (login, register, lupa/reset password, profil)**
- Satu kartu putih di tengah di atas latar `primary-50`/krem, judul jelas, satu kalimat sambutan, tautan silang Masuk/Daftar. Tanpa dekorasi tambahan.

**Panel admin**
- Sidebar `primary-900` dengan ikon SVG + teks, item aktif memakai latar `primary-700`. Topbar tipis. Konten di atas `cream`.
- Dashboard: empat kartu statistik seragam (angka besar, label kecil, ikon kecil), lalu dua daftar ringkas (pengajuan menunggu dan pesanan terbaru) bila datanya tersedia dari controller. Jangan menambah query baru.
- Tabel admin: header lengket tipis, baris zebra sangat halus atau pemisah garis, kolom angka rata kanan, aksi berupa ikon-tombol dengan `aria-label`. Filter status berupa tab/segmented control sederhana.
- Form CRUD: lebar maksimal `max-w-2xl`, tombol Simpan dan Batal sejajar di bawah.
- Halaman tinjau pengajuan: dua kolom (data pengajuan di kiri, panel keputusan di kanan). Tombol Setujui hijau dan Tolak merah-ghost; modal tolak Alpine dengan textarea dan error yang jelas.

## KONDISI YANG HARUS TERLIHAT RAPI

Setiap halaman wajib memiliki tampilan yang layak untuk: **kosong** (empty state tanpa emoji, dengan ikon SVG + satu aksi), **error validasi** (ringkasan di atas + pesan per field), **flash sukses/gagal**, **tombol disabled**, **focus keyboard**, dan **teks panjang** (nama sekolah panjang tidak merusak layout; gunakan `truncate` atau `break-words`).

## ALUR KERJA

1. **Audit dulu.** Telusuri seluruh `resources/views` dan `resources/css/app.css`. Buat daftar singkat masalah slop yang ditemukan (sebutkan file dan jenis masalah). Tampilkan sebagai artifact rencana sebelum mengubah.
2. Perbarui token (warna, font) dan komponen UI.
3. Refactor halaman dalam urutan: layout publik, beranda, detail, form, pembayaran, riwayat, e-ticket, auth, layout admin, halaman admin.
4. Hapus class Tailwind yang mati atau duplikat, dan inline style yang tidak perlu.
5. Jalankan `npm run build` dan `php artisan view:clear && php artisan view:cache` (lalu `view:clear`). Perbaiki semua error.
6. **Verifikasi visual dengan browser.** Jalankan `php artisan serve`, buka halaman-halaman utama dan ambil screenshot pada lebar **375px, 768px, dan 1280px**. Periksa: tidak ada scroll horizontal, tidak ada teks terpotong, tidak ada elemen bertumpuk, spasi konsisten, kontras terbaca, semua tombol berukuran sentuh memadai. Perbaiki lalu ulangi sampai bersih.
7. Uji fungsi ulang secara manual: login, pesan tiket, ajukan paket sekolah, setujui/tolak di admin, halaman bayar (tombol Snap tampil), e-ticket, filter dan pagination. Tidak boleh ada yang rusak.

## KRITERIA SELESAI (CHECKLIST)

- [ ] Hanya satu palet (hijau, kuning, krem, ink); tidak ada indigo/ungu/abu-biru sisa Breeze.
- [ ] Tidak ada emoji sebagai ikon; semua ikon SVG seragam.
- [ ] Hanya dua font, skala ukuran tetap, judul sentence case.
- [ ] Hanya tiga level radius, satu gaya bayangan, tanpa efek hover melompat.
- [ ] Spasi mengikuti grid 4px; kartu sejajar dan tinggi seragam.
- [ ] Setiap halaman punya hierarki jelas: satu judul, satu aksi utama.
- [ ] Semua halaman rapi di 375px, 768px, 1280px.
- [ ] Kontras teks minimal 4.5:1; focus ring terlihat; target sentuh minimal 44px.
- [ ] Seluruh fungsi (form, Snap, filter, modal, cetak) tetap bekerja.
- [ ] `npm run build` dan `view:cache` bersih tanpa error.

## LAPORAN AKHIR

Tampilkan: ringkasan masalah slop yang ditemukan dan diperbaiki, daftar file yang diubah, perubahan kecil di controller (bila ada), screenshot sebelum dan sesudah untuk beranda, form pesan, riwayat pesanan, e-ticket, dan dashboard admin, serta hal yang sengaja tidak diubah. Jangan menambahkan fitur di luar yang diminta.
