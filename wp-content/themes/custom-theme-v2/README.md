# Custom Theme 2

Child theme yang mengubah beranda dan tampilan Travel Aja. Tema ini menggunakan tema `custom-theme` yang ada di repository sebagai parent. Konten dan media tetap dikelola melalui wp-admin.

## Sumber konten beranda

- Hero: featured image halaman **Beranda**.
- Paket: menu **Paket Wisata**.
- Kendaraan: menu **Transportasi**.
- Ulasan: tidak ditampilkan di beranda; komentar tidak dianggap sebagai testimoni.
- Artikel: menu **Posts**.
- Kontak: footer memakai detail yang diatur di **Appearance → Customize → Kontak & Footer**. Jika belum ada detail, footer mengarahkan pengunjung ke halaman Kontak Kami.
- Teks hero: **Appearance → Customize → Beranda Custom Theme 2**.

Aktifkan melalui **Appearance → Themes → Custom Theme 2**.

## Dependensi dan setup demo

`Custom Theme` harus terpasang sebagai parent, dan plugin **Travel Aja Content Types** harus aktif untuk mendaftarkan post type `destinasi`, `paket_wisata`, dan `transportasi`. Polylang menyediakan pengalihan bahasa dan pasangan terjemahan; tanpa Polylang, tampilkan satu bahasa. WP Travel Engine tidak digunakan sebagai dependensi oleh template ini.

Untuk data contoh, plugin konten, impor WXR, dan langkah setup halaman bilingual, ikuti [README repository](../../../README.md).
