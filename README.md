# Travel Aja

Situs pemesanan wisata berbasis WordPress untuk demo portofolio. Repository ini menyimpan dua tema yang dikembangkan atau disesuaikan untuk proyek ini:

- `wp-content/themes/custom-theme/` — tema dasar khusus Travel Aja.
- `wp-content/themes/custom-theme-v2/` — child theme dengan beranda dan tampilan yang disesuaikan; menggunakan `custom-theme` sebagai parent.

WordPress core, tema standar, plugin pihak ketiga, unggahan media, dan konfigurasi lingkungan tidak disertakan dalam repository. Situs memerlukan instalasi WordPress terpisah. Tipe konten wisata dan fitur tambahan yang berasal dari plugin WordPress harus dipasang serta dikonfigurasi di lingkungan tersebut.

## Menyiapkan lokal

1. Siapkan instalasi WordPress lokal dan database sendiri.
2. Salin kedua folder tema dari `wp-content/themes/` ke instalasi WordPress.
3. Aktifkan **Custom Theme** lalu **Custom Theme 2** melalui Appearance → Themes.
4. Buat halaman Beranda, Paket Wisata, Transportasi, Panduan Wisata, dan Kontak Kami; pilih Beranda sebagai homepage statis.
5. Tambahkan data demo dan media melalui wp-admin. Data dan unggahan WordPress tidak berada di repository ini.

## Catatan portofolio

Tampilan beranda, komponen kartu, navigasi, dan penyesuaian tema berada di dua folder tema di atas. Situs tetap memakai WordPress dan dapat bergantung pada plugin pihak ketiga untuk tipe konten atau fitur tertentu. Konten paket, artikel, gambar, kontak, dan ulasan merupakan data situs, bukan kode tema. Ulasan tidak ditampilkan di beranda agar komentar pengunjung tidak disajikan sebagai testimoni.

## Konfigurasi

Jangan commit `wp-config.php`, kredensial database, secret key, atau file lokal lain. Buat konfigurasi WordPress di instalasi lokal dan isi nilai rahasia hanya di lingkungan pribadi.
