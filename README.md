# Kaswargi — Aplikasi Pembukuan Keuangan Warga RT

Aplikasi web (PWA) untuk mencatat pembukuan keuangan lingkungan RT/RW: buku kas
masuk–keluar, tagihan & pembayaran iuran warga, data warga, serta halaman
transparansi publik yang bisa dibagikan ke warga lewat satu tautan.

Nama aplikasi: **Kaswargi** — "Buku kas warga kita" (v1.0.0).

---

## 1. Ringkasan Teknis

| Item | Spesifikasi |
|---|---|
| Bahasa | PHP (minimum PHP 5.3.7 per `composer.json`; disarankan PHP 7.4) |
| Framework | **CodeIgniter 3.1.10** (MVC, pola HMVC tidak dipakai) |
| Database | MySQL / MariaDB |
| Web server | Apache + mod_rewrite (dikembangkan di XAMPP) |
| Session | CodeIgniter session driver `files`, kedaluwarsa 7200 detik (2 jam) |
| Autentikasi | Custom (tabel `operator`, hash MD5) |
| Multi-tenant | Ya — pemisahan data lewat kolom `org_code` di hampir semua tabel |
| Front-end utama | Tema **Finapp** (Bootstrap 5) — mobile-first PWA |
| Charting | ApexCharts |
| Ikon | Ionicons 5.5.2 (via CDN unpkg) |
| Manifest PWA | `assets-p/__manifest.json` + `assets-p/__service-worker.js` |
| Lisensi framework | MIT (CodeIgniter), lihat `license.txt` |

### Tema & Aset

Repo berisi tiga set aset. Yang **aktif** untuk modul RT hanya `assets-p`.

| Folder | Tema | Basis | Status |
|---|---|---|---|
| `assets-p/` | **Finapp** (mobile PWA) | Bootstrap 5 | **Aktif** — dipakai `template/template-p.php`, seluruh halaman RT |
| `assets-fi/` | Finapp (varian) | Bootstrap 5, Chart.js 3.3.1, Swiper 6.6.2, daterangepicker, sparklines, progressbar.js | Parsial — hanya jQuery 3.3.1 yang masih dimuat template aktif |
| `assets/` | **AdminLTE 2.4.12** | Bootstrap 3 | Legacy — dipakai template lama (`template/template`) untuk modul POS |

Template view:

- `application/views/template/template-p.php` — layout utama PWA: app header,
  sidebar panel, menu (Beranda, Pembukuan, Warga, E-iuran, Komp. Iuran, Galeri
  Kabar, Ganti Password, Keluar), action sheet "Add to Home Screen" iOS/Android,
  dan tombol salin tautan publik.
- `application/views/template/template-fi.php` — layout varian Finapp.
- Halaman login: `application/views/login-p.php` (aktif), `login-fi.php`,
  `form_login.php` (legacy).

---

## 2. Fitur

### 2.1 Autentikasi & Operator (`Auth`, `Operator`)

- Login username + password (MD5) terhadap tabel `operator`, join ke tabel `akses`.
- Pencatatan `last_login` setiap login berhasil.
- Session menyimpan: `id`, `status_login`, `username`, `akses`, `org_code`, `foto`.
- Routing pasca-login berdasarkan level akses: `id_akses = 1` → `Dashboard`
  (modul legacy), selain itu → `Apps` (beranda RT).
- Penjaga akses: helper `chek_session()` (wajib login) dan `chek_role()`
  (khusus administrator) di `application/helpers/stok_helper.php`.
- CRUD operator + unggah foto profil (`uploads/operator/`, nama file dienkripsi).
- Ganti password mandiri (`Operator/pass_form` → `edit_pass`), otomatis logout
  setelah ganti.
- Logout menghancurkan session.

### 2.2 Beranda / Dashboard RT (`Apps::index` → `apps/k-home.php`)

- Kartu **Saldo Semua Buku (Rp)** — akumulasi seluruh buku kas.
- Ringkasan per buku kas: total masuk, total keluar, saldo berjalan
  (dihitung di sisi klien dari data `kas_buku`).
- Grafik **Total Pembayaran Iuran** per bulan (ApexCharts) dari agregasi
  `iuran_alter` (`SUM(total_nominal)` per `pada_bulan`/`pada_tahun`).
- Pintasan input transaksi baru.

### 2.3 Pembukuan / Buku Kas (`Buku`)

- **Multi buku kas** per organisasi dan per operator (tabel `kas_nama`),
  misalnya kas RT, kas sampah, kas pembangunan.
- **Kategori transaksi** (tabel `kas_kategori`) dengan jenis **MASUK** / **KELUAR**.
- `Buku::index` — daftar seluruh buku kas beserta rekapnya (`k-buku-kas.php`).
- `Buku::create` — form input transaksi: periode (tanggal), jenis transaksi,
  buku kas tujuan, nominal, uraian. Tanggal dipecah menjadi kolom `tgl`,
  `bulan`, `tahun` untuk mempermudah rekap.
- `Buku::quickCreate` — input cepat via AJAX (tanpa reload halaman).
- `Buku::readByIdKas/{id}` — rincian mutasi satu buku kas
  (`k-rincian-buku.php`), lengkap dengan total masuk, keluar, dan saldo.
- `Buku::editTrans` — ubah nominal & uraian transaksi (AJAX).
- `Buku::deleteKasEntry` — hapus entri transaksi (AJAX).
- Sanitasi uraian: karakter kutip dan baris baru dibersihkan sebelum disimpan.

### 2.4 Data Warga (`Warga`)

- Daftar warga per `org_code`: nama, blok, nominal iuran, status aktif, deposit.
- `Warga::wargaDetail/{id}` — profil warga + **Kartu Iuran** (riwayat seluruh
  periode tagihan warga tersebut).
- `Warga::quickAddWarga` — tambah warga cepat (nama, blok, total iuran).
- `Warga::wargaNama` — ubah nama warga.
- `Warga::editIuran` — ubah nominal iuran bulanan warga.
- `Warga::updateKomponen` — set komponen iuran warga (disimpan sebagai JSON di
  kolom `nama_iuran`) sekaligus memperbarui total.
- `Warga::wargaDepo` — kelola **deposit** (saldo titipan) warga.
- `Warga::toggleStatus` — aktif/nonaktifkan warga; warga nonaktif tidak ikut
  dalam pembuatan tagihan massal.
- `Warga::wargaBayar` — tandai satu periode **LUNAS** langsung dari kartu iuran,
  sekaligus membuat catatan alokasi pembayaran.
- `Warga::hapusBayar` — hapus baris tagihan.

### 2.5 Komponen Iuran (`Komponen`)

- Daftar komponen/kategori iuran per organisasi (tabel `iuran_kategori`),
  misalnya keamanan, kebersihan, kas RT.
- `Komponen::override` — sinkronisasi massal: menyalin komponen iuran terbaru
  dari data warga ke seluruh baris tagihan `iuran_bayar` milik warga tersebut.

### 2.6 E-Iuran / Tagihan & Pembayaran (`Iuran`, `IuranDetail`)

- `Iuran::index` — tiga panel:
  1. **Rekap** seluruh tagihan (`iuran_bayar`).
  2. **Riwayat pembayaran** (`iuran_alter`, termasuk pembayaran rapel
     beberapa periode sekaligus).
  3. **Tunggakan** — agregasi per warga: jumlah periode menunggak dan total
     nominal, diurutkan dari yang terbanyak.
- `Iuran::create` — pembayaran rentang periode: pilih warga, periode **dari**
  dan **sampai** (format `YYYY-MM`), serta bulan pembukuan. Sistem melakukan
  iterasi bulanan (`DatePeriod`), membuat tagihan yang belum ada dan memperbarui
  yang sudah ada, lalu mencatat satu transaksi rapel di `iuran_alter`
  (menyimpan daftar `kode_periode` dan `untuk_periode` sebagai JSON).
- `Iuran::createBulk` — **buat tagihan untuk semua warga aktif** sekaligus untuk
  satu bulan; aman diulang karena memeriksa duplikasi `kode_periode`.
- `Iuran::cancelPayment` — batalkan pembayaran: seluruh periode terkait
  dikembalikan ke status `BELUM` dan catatan alokasi dihapus.
- `IuranDetail::alokasi/{org}/{bulan}/{tahun}` — rincian alokasi pembayaran
  iuran yang diterima pada bulan tertentu, dipetakan ke buku kas dan kategori.
- `IuranDetail::getTotalAlter` — endpoint JSON untuk total alokasi per periode.
- Kunci periode: `kode_periode = id_warga + bulan + tahun` (mencegah tagihan ganda).
- Status tagihan: `LUNAS` / `BELUM`, dengan `tgl_bayar` dan `nama_operator`
  sebagai jejak audit.

### 2.7 Galeri Kabar / Pengumuman (`News`)

- CRUD pengumuman warga: judul, deskripsi, gambar.
- Unggah gambar ke `uploads/` — tipe `jpg|jpeg|png`, maksimum 2 MB.
- Penggantian gambar saat update otomatis menghapus file lama.
- Flag `show` untuk menampilkan/menyembunyikan kabar di halaman publik.

### 2.8 Halaman Transparansi Publik (`Review`) — tanpa login

Diakses lewat tautan `Review/only/{org_code}` yang bisa disalin dari tombol
salin di header aplikasi lalu dibagikan ke grup warga.

- `Review::only/{org}` — dashboard publik: ringkasan buku kas, grafik total
  pembayaran iuran per bulan, dan galeri kabar.
- `Review::recap/{org}` — rekap iuran dan daftar tunggakan.
- `Review::allResident/{org}` — daftar warga aktif.
- `Review::resident/{org}/{id}` — kartu iuran satu warga.
- `Review::readByIdKas/{org}/{id}` — rincian mutasi satu buku kas.
- `Review::printByIdKas/{org}/{id}` — versi siap cetak laporan buku kas.


Untuk pemakaian sebagai catatan keuangan resmi RT, angka dari aplikasi ini tetap
harus diverifikasi manual oleh bendahara terhadap bukti fisik/mutasi rekening
sebelum dipakai dalam laporan pertanggungjawaban.

## 3. Struktur Direktori
```
public_html/
├── application/
│   ├── config/          # config.php, database.php (di-gitignore), routes.php, autoload.php
│   ├── controllers/     # Auth, Apps, Buku, Warga, Iuran, IuranDetail, Komponen, News, Review, Operator, + legacy
│   ├── models/          # model legacy POS (modul RT memakai query langsung)
│   ├── helpers/         # stok_helper.php → chek_session(), chek_role()
│   ├── libraries/       # template.php, Fungsi.php (rupiah, tanggalindo), CropImage.php
│   └── views/
│       ├── apps/        # k-*.php (halaman pengurus), r-*.php (halaman publik/Review)
│       ├── template/    # template-p.php (aktif), template-fi.php
│       └── login-p.php
├── assets-p/            # tema Finapp aktif + manifest & service worker PWA
├── assets-fi/           # varian Finapp (jQuery, Bootstrap 5, Chart.js, dll.)
├── assets/              # AdminLTE 2.4.12 (legacy)
├── database/project.sql # dump skema legacy POS (belum mencakup tabel RT)
├── system/              # core CodeIgniter 3.1.10
├── uploads/             # gambar kabar & foto operator
├── index.php            # front controller
└── .htaccess            # rewrite ke index.php
```

Konvensi penamaan view: prefiks `k-` = halaman pengurus (perlu login),
prefiks `r-` = halaman publik (Review).


## 4. Screenshot



## 5. Lisensi

Framework CodeIgniter berlisensi MIT (lihat `license.txt`). AdminLTE berlisensi
MIT. Tema Finapp mengikuti lisensi pembeliannya masing-masing.
