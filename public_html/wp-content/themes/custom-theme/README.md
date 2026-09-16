# Custom Theme

Tema klasik WordPress untuk belajar dan mengembangkan tampilan di lokal.

## Peta file

- `style.css`: metadata agar WordPress mengenali tema, serta CSS tampilan dasar.
- `functions.php`: dukungan fitur WordPress, lokasi menu, dan pemuatan CSS.
- `header.php` / `footer.php`: kerangka halaman; `wp_head()` dan `wp_footer()` wajib dipertahankan.
- `index.php`: template cadangan untuk halaman, daftar konten, dan hasil pencarian.
- `front-page.php`: halaman Beranda, dengan teks dan gambar dari Pages → Beranda, formulir pencarian WordPress, serta kartu otomatis dari Paket Wisata, Destinasi, Transportasi, dan Posts.

## Uji pertama

1. Buka **Appearance → Themes** di wp-admin lokal.
2. Pastikan **Custom Theme** terlihat. Gunakan **Live Preview** untuk melihat hasil sebelum mengaktifkan.
3. Setelah siap, aktifkan tema dan buka beranda serta satu artikel.
4. Untuk kembali, aktifkan lagi **Travel Agency**; data konten tidak dihapus.

Untuk mengisi Beranda, edit isi halaman **Beranda** dan atur **Featured Image** sebagai gambar pembuka. Tambah item lewat menu **Paket Wisata**, **Destinasi**, **Transportasi**, dan **Posts** agar kartu di beranda muncul otomatis. Bagian dengan tipe konten yang masih kosong hanya menampilkan pesan bantuan kepada admin.

Kolom pencarian di Beranda memakai parameter `s` bawaan WordPress. Hasilnya ditampilkan melalui `index.php`; tipe konten khusus akan ikut dicari jika pengaturan CPT UI tidak mengecualikannya dari pencarian.

Langkah pengembangan berikutnya: buat `archive-paket_wisata.php` dan `single-paket_wisata.php` setelah struktur data paket dipetakan.
