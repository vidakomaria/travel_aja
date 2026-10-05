# Custom Theme

Tema klasik WordPress untuk belajar dan mengembangkan tampilan di lokal.

## Peta file

- `style.css`: metadata agar WordPress mengenali tema, serta CSS tampilan dasar.
- `functions.php`: dukungan fitur WordPress, lokasi menu, dan pemuatan CSS.
- `header.php` / `footer.php`: kerangka halaman; `wp_head()` dan `wp_footer()` wajib dipertahankan.
- `index.php`: template cadangan untuk halaman, daftar konten, dan hasil pencarian.
- `front-page.php`: halaman Beranda, dengan teks dan gambar dari Pages → Beranda serta bagian konten dinamis dari wp-admin.
- `archive-*.php` dan `page-*.php`: halaman daftar Paket Wisata, Destinasi, Transportasi, Panduan Wisata, Tentang Kami, dan Kontak Kami.
- `inc/archive-pages.php`: query, filter, kartu, hero, pagination, dan CTA untuk halaman daftar.
- `inc/package-fields.php`, `inc/card-fields.php`, dan `inc/lower-home.php`: field kartu serta pengaturan kontak/footer.
- `assets/css/pages.css`: tampilan semua halaman menu dan responsif.

## Uji pertama

1. Buka **Appearance → Themes** di wp-admin lokal.
2. Pastikan **Custom Theme** terlihat. Gunakan **Live Preview** untuk melihat hasil sebelum mengaktifkan.
3. Setelah siap, aktifkan tema dan buka beranda serta satu artikel.
4. Untuk kembali, aktifkan lagi **Travel Agency**; data konten tidak dihapus.

Untuk mengisi Beranda, edit isi halaman **Beranda**; isinya tampil tepat setelah hero. Atur **Featured Image** sebagai latar hero. Tambah item lewat menu **Paket Wisata**, **Destinasi**, **Transportasi**, dan **Posts** agar kartu di beranda muncul otomatis. Bagian dengan tipe konten yang masih kosong hanya menampilkan pesan bantuan kepada admin.

Untuk kartu Paket Wisata, buka item paket di wp-admin, atur **Featured Image**, lalu isi kotak **Detail Kartu Paket Wisata**: Durasi, Lokasi, Harga, Rating, dan Lencana. Masukkan harga sebagai angka Rupiah tanpa pemisah ribuan.

Untuk Destinasi, isi Lokasi, Rating, Kategori, Aktivitas Unggulan, dan Lencana pada kotak **Detail Kartu Destinasi**. Aktivitas dipisahkan dengan koma.

Untuk Transportasi, isi Featured Image lalu kotak **Detail Kartu Transportasi**: Jenis layanan, Kapasitas, Transmisi, Model, Harga, dan Satuan harga.

Isi nomor WhatsApp, alamat kantor, email, jam operasional, Google Maps, deskripsi footer, media sosial, dan logo melalui **Appearance → Customize**. Nomor WhatsApp harus memakai kode negara, misalnya `62812...`.

Kolom pencarian di Beranda memakai parameter `s` bawaan WordPress. Hasilnya ditampilkan melalui `index.php`; tipe konten khusus akan ikut dicari jika pengaturan CPT UI tidak mengecualikannya dari pencarian.

Halaman daftar membaca data langsung dari wp-admin. Pencarian, filter, urutan, dan pagination berjalan melalui parameter URL sehingga hasilnya dapat dibagikan atau dibuka kembali.
