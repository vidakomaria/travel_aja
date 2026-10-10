<?php
/**
 * Halaman Tentang Kami — layout timeline.
 *
 * Override tema induk (custom-theme/page-tentang-kami.php). Bedanya:
 *  - setiap bagian jadi langkah bernomor pada satu garis waktu vertikal
 *  - tidak ada judul section tengah yang berulang; judul menempel ke tiap langkah
 *  - statistik jadi badge di sepanjang timeline
 *  - kontak (info + formulir WhatsApp + peta) jadi langkah terakhir
 *
 * @package Custom_Theme_V2
 */

$page_id      = get_queried_object_id();
$hero_image   = has_post_thumbnail( $page_id ) ? get_the_post_thumbnail_url( $page_id, 'full' ) : custom_theme_listing_hero_image();
$destinations = new WP_Query( array( 'post_type' => 'destinasi', 'post_status' => 'publish', 'posts_per_page' => 5, 'no_found_rows' => true ) );

$whatsapp = preg_replace( '/\D/', '', get_theme_mod( 'travel_whatsapp', '' ) );
$address  = trim( (string) get_theme_mod( 'travel_office_address', '' ) );
$email    = get_theme_mod( 'travel_email', '' );
$hours    = get_theme_mod( 'travel_hours', 'Setiap Hari (08:00 - 17:00 WIB)' );
$map_url  = get_theme_mod( 'travel_map_url', '' );

$tl_content = trim( (string) get_post_field( 'post_content', $page_id ) );
$tl_no      = 0;

get_header();
?>
<main id="main-content" class="content-page about-page tl-page">
	<section class="travel-page-hero about-hero"<?php if ( $hero_image ) : ?> style="--travel-hero-image:url('<?php echo esc_url( $hero_image ); ?>')"<?php endif; ?>>
		<div class="container travel-page-hero__inner">
			<span>Inspirasi Perjalanan</span>
			<h1>Jelajahi Indonesia Bersama Travel Aja</h1>
			<p>Temukan paket wisata, transportasi, dan inspirasi perjalanan untuk beragam destinasi di Indonesia.</p>
			<div class="about-actions">
				<a href="<?php echo esc_url( custom_theme_listing_url( 'paket_wisata' ) ); ?>">Lihat Paket Wisata</a>
				<a href="#kontak">Hubungi Travel Aja</a>
			</div>
		</div>
	</section>

	<section class="page-section tl-section">
		<div class="container">
			<ol class="tl">

				<li class="tl__item">
					<?php $tl_no++; ?>
					<span class="tl__dot"><?php echo esc_html( str_pad( (string) $tl_no, 2, '0', STR_PAD_LEFT ) ); ?></span>
					<span class="tl__badge">Indonesia · Destinasi</span>
					<h2>Temukan Cara Baru Menjelajahi Indonesia</h2>
					<?php if ( $hero_image ) : ?>
						<figure class="tl__figure"><img src="<?php echo esc_url( $hero_image ); ?>" alt="Perjalanan menjelajahi Indonesia bersama Travel Aja" loading="lazy"></figure>
					<?php endif; ?>
					<?php if ( $tl_content ) : ?>
						<?php echo wp_kses_post( apply_filters( 'the_content', $tl_content ) ); ?>
					<?php else : ?>
						<p><strong>Travel Aja membantu Anda menemukan paket wisata dan transportasi untuk merencanakan perjalanan di Indonesia.</strong></p>
						<p>Pilih pengalaman yang sesuai dengan waktu, minat, dan kebutuhan perjalanan Anda. Temukan destinasi, lihat informasi paket, lalu siapkan rencana perjalanan dengan lebih mudah.</p>
					<?php endif; ?>
					<ul class="tl__list">
						<li>Inspirasi destinasi di berbagai wilayah Indonesia.</li>
						<li>Pilihan paket wisata sesuai kebutuhan perjalanan.</li>
						<li>Informasi transportasi untuk mendukung perjalanan.</li>
						<li>Bantuan merencanakan perjalanan yang lebih personal.</li>
					</ul>
				</li>

				<li class="tl__item">
					<?php $tl_no++; ?>
					<span class="tl__dot"><?php echo esc_html( str_pad( (string) $tl_no, 2, '0', STR_PAD_LEFT ) ); ?></span>
					<span class="tl__badge">Wisata · Paket Perjalanan</span>
					<h2>Rencanakan Perjalanan dengan Mudah</h2>
					<p>Temukan informasi perjalanan yang membantu Anda menjelajahi Indonesia dengan lebih nyaman.</p>
					<div class="about-grid">
						<?php foreach ( array( 'Inspirasi Destinasi' => 'Jelajahi ide perjalanan dari beragam wilayah dan pengalaman di Indonesia.', 'Pilihan Paket Wisata' => 'Temukan perjalanan yang sesuai dengan waktu, minat, dan kebutuhan Anda.', 'Transportasi' => 'Lihat pilihan kendaraan untuk mendukung perjalanan Anda.', 'Informasi Jelas' => 'Pelajari harga dan layanan sebelum mengonfirmasi perjalanan.', 'Bantuan Personal' => 'Hubungi Travel Aja untuk mendiskusikan rencana perjalanan Anda.' ) as $title => $text ) : ?>
							<article class="about-card"><b><?php echo esc_html( $title ); ?></b><p><?php echo esc_html( $text ); ?></p></article>
						<?php endforeach; ?>
					</div>
				</li>

				<li class="tl__item">
					<?php $tl_no++; ?>
					<span class="tl__dot"><?php echo esc_html( str_pad( (string) $tl_no, 2, '0', STR_PAD_LEFT ) ); ?></span>
					<span class="tl__badge">Transportasi · Pilihan Kendaraan</span>
					<h2>Mulai Menjelajahi Indonesia</h2>
					<p>Pilih destinasi, temukan paket yang sesuai, lalu siapkan perjalanan Anda.</p>
					<div class="about-steps">
						<?php foreach ( array( 'Pilih Destinasi' => 'Jelajahi destinasi yang sesuai dengan minat dan rencana perjalanan Anda.', 'Pilih Paket' => 'Temukan paket wisata yang sesuai dengan waktu dan anggaran Anda.', 'Siapkan Transportasi' => 'Lengkapi perjalanan dengan pilihan transportasi yang tersedia.', 'Nikmati Perjalanan' => 'Setelah detail perjalanan siap, waktunya menikmati pengalaman baru.' ) as $title => $text ) : ?>
							<article class="about-step"><span><?php echo esc_html( $title ); ?></span><p><?php echo esc_html( $text ); ?></p></article>
						<?php endforeach; ?>
					</div>
				</li>

				<li class="tl__item">
					<?php $tl_no++; ?>
					<span class="tl__dot"><?php echo esc_html( str_pad( (string) $tl_no, 2, '0', STR_PAD_LEFT ) ); ?></span>
					<span class="tl__badge">Perjalanan · Pengalaman Baru</span>
					<h2>Perjalanan yang Personal, Jelas, dan Berkesan</h2>
					<p>Perjalanan yang baik dimulai dengan memahami kebutuhan wisatawan dan memberikan informasi yang membantu.</p>
					<div class="about-grid">
						<?php foreach ( array( 'Jelajahi Sesuai Minat' => 'Pilih cara perjalanan dan destinasi yang paling sesuai untuk Anda.', 'Informasi Transparan' => 'Pelajari harga dan layanan dengan jelas sebelum perjalanan dikonfirmasi.', 'Pilihan Beragam' => 'Temukan inspirasi dari beragam destinasi dan pengalaman di Indonesia.', 'Layanan Personal' => 'Kami membantu Anda menyesuaikan rencana dengan kebutuhan perjalanan.' ) as $title => $text ) : ?>
							<article class="about-card"><b><?php echo esc_html( $title ); ?></b><p><?php echo esc_html( $text ); ?></p></article>
						<?php endforeach; ?>
					</div>
				</li>

				<?php if ( $destinations->have_posts() ) : ?>
					<li class="tl__item">
						<?php $tl_no++; ?>
						<span class="tl__dot"><?php echo esc_html( str_pad( (string) $tl_no, 2, '0', STR_PAD_LEFT ) ); ?></span>
						<span class="tl__badge">Inspirasi Perjalanan</span>
						<h2>Jelajahi Indonesia</h2>
						<p>Lihat inspirasi destinasi dan temukan pengalaman baru di berbagai wilayah Indonesia.</p>
						<div class="about-gallery">
							<?php while ( $destinations->have_posts() ) : $destinations->the_post(); ?>
								<?php if ( has_post_thumbnail() ) : the_post_thumbnail( 'large' ); endif; ?>
							<?php endwhile; ?>
						</div>
					</li>
					<?php wp_reset_postdata(); ?>
				<?php endif; ?>

				<li class="tl__item tl__item--contact" id="kontak">
					<?php $tl_no++; ?>
					<span class="tl__dot"><?php echo esc_html( str_pad( (string) $tl_no, 2, '0', STR_PAD_LEFT ) ); ?></span>
					<span class="tl__badge">Kontak</span>
					<h2>Hubungi Travel Aja</h2>
					<p>Punya pertanyaan mengenai destinasi, paket wisata, atau ingin menyusun itinerary khusus? Tim Travel Aja siap membantu merencanakan perjalanan yang sesuai dengan kebutuhan Anda.</p>
					<div class="contact-layout">
						<aside class="contact-panel">
							<div class="contact-info">
								<?php if ( $address ) : ?>
									<div class="contact-item"><small>Alamat Kantor</small><strong><?php echo esc_html( $address ); ?></strong></div>
								<?php else : ?>
									<div class="contact-item"><small>Area Jelajah</small><strong>Berbagai destinasi di Indonesia</strong></div>
								<?php endif; ?>
								<div class="contact-item"><small>WhatsApp Travel Aja</small>
									<?php if ( $whatsapp ) : ?>
										<a href="<?php echo esc_url( 'https://wa.me/' . $whatsapp ); ?>"><?php echo esc_html( $whatsapp ); ?></a>
									<?php else : ?>
										<strong>Kontak demo belum dihubungkan</strong>
									<?php endif; ?>
								</div>
								<div class="contact-item"><small>Email Travel Aja</small>
									<?php if ( $email ) : ?>
										<a href="mailto:<?php echo esc_attr( antispambot( $email ) ); ?>"><?php echo esc_html( antispambot( $email ) ); ?></a>
									<?php else : ?>
										<strong>Belum tersedia di demo ini</strong>
									<?php endif; ?>
								</div>
								<div class="contact-item"><small>Jam Operasional</small><strong><?php echo esc_html( $hours ); ?></strong></div>
							</div>
						</aside>
						<div class="contact-panel">
							<form id="contact-trip-form" class="contact-form contact-form-grid" data-whatsapp="<?php echo esc_attr( $whatsapp ); ?>">
								<label><span>Nama</span><input type="text" name="name" required placeholder="Nama Anda"></label><label><span>Jumlah Orang</span><select name="people" required><option value="">Pilih Jumlah Orang...</option><option>1 Orang</option><option>2 Orang</option><option>3–5 Orang</option><option>6–10 Orang</option><option>Lebih dari 10 Orang</option></select></label>
								<label><span>Estimasi Budget per Orang</span><select name="budget" required><option value="">Pilih Estimasi Budget...</option><option>Di bawah Rp 500.000</option><option>Rp 500.000 – Rp 1.000.000</option><option>Rp 1.000.000 – Rp 2.000.000</option><option>Di atas Rp 2.000.000</option></select></label><label><span>Perkiraan Tanggal Keberangkatan</span><input type="date" name="date" required></label>
								<label class="full"><span>Minat Destinasi & Kategori Wisata</span><input type="text" name="interest" placeholder="Contoh: pantai, alam, budaya, kuliner"></label><label class="full"><span>Catatan Perjalanan</span><textarea name="notes" rows="4" placeholder="Ceritakan kebutuhan atau rencana perjalanan Anda"></textarea></label>
								<button type="submit">◉ Kirim ke WhatsApp</button>
							</form>
							<p id="contact-trip-status" class="contact-status" aria-live="polite"></p>
						</div>
					</div>
					<?php if ( $map_url ) : ?>
						<a class="tl-map" href="<?php echo esc_url( $map_url ); ?>" target="_blank" rel="noopener noreferrer">⌖ Lihat lokasi kantor di Google Maps</a>
					<?php endif; ?>
				</li>

			</ol>
		</div>
	</section>

	<section class="page-section page-section--pale">
		<div class="container">
			<div class="section-heading">
				<h2>Pertanyaan yang Sering Ditanyakan</h2>
				<p>Informasi untuk membantu Anda merencanakan perjalanan di Indonesia.</p>
			</div>
			<div class="about-faq">
				<?php foreach ( array( 'Bagaimana memilih paket wisata yang cocok?' => 'Pilih paket berdasarkan waktu, minat, jumlah peserta, dan anggaran Anda.', 'Bagaimana cara booking paket wisata di Travel Aja?' => 'Pilih paket yang sesuai lalu hubungi tim kami melalui WhatsApp untuk konfirmasi jadwal, jumlah peserta, dan pembayaran.', 'Apakah harga sudah termasuk semua biaya?' => 'Rincian fasilitas dan biaya tersedia pada halaman detail paket atau saat konsultasi.', 'Apakah saya bisa membuat itinerary sendiri?' => 'Sampaikan destinasi dan aktivitas yang Anda inginkan agar tim membantu menyusun rencana.', 'Apakah perjalanan bisa dibuat lebih personal?' => 'Rencana perjalanan dapat disesuaikan dengan kebutuhan rombongan maupun perjalanan pribadi, berdasarkan waktu, minat, dan anggaran Anda.', 'Apakah Travel Aja menyediakan transportasi?' => 'Ya. Pilihan kendaraan dapat dilihat pada halaman Transportasi dan disesuaikan dengan kebutuhan perjalanan.', 'Destinasi mana saja yang tersedia?' => 'Kami membantu merencanakan perjalanan ke berbagai destinasi di Indonesia. Ketersediaan paket dan transportasi mengikuti area layanan pada tiap penawaran.', 'Apa saja layanan yang tersedia di Travel Aja?' => 'Paket wisata, rekomendasi destinasi, transportasi, serta bantuan menyusun itinerary perjalanan.' ) as $question => $answer ) : ?>
					<details><summary><?php echo esc_html( $question ); ?></summary><p><?php echo esc_html( $answer ); ?></p></details>
				<?php endforeach; ?>
			</div>
			<div class="page-bottom-cta">
				<div><h2>Siap Merencanakan Perjalanan?</h2><p>Jelajahi pilihan destinasi dan paket perjalanan Travel Aja.</p></div>
				<div class="page-bottom-cta__actions">
					<?php if ( $whatsapp ) : ?><a href="<?php echo esc_url( 'https://wa.me/' . $whatsapp ); ?>" target="_blank" rel="noopener noreferrer">Konsultasi via WhatsApp</a><?php endif; ?>
					<a href="<?php echo esc_url( custom_theme_listing_url( 'destinasi' ) ); ?>">Jelajahi Destinasi</a>
					<a href="<?php echo esc_url( custom_theme_listing_url( 'paket_wisata' ) ); ?>">Lihat Paket Wisata</a>
				</div>
			</div>
		</div>
	</section>
</main>
<?php get_footer(); ?>
