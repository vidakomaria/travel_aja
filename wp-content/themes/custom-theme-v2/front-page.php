<?php
/**
 * Homepage Custom Theme 2.
 *
 * @package Custom_Theme_V2
 */

get_header();

$front_id       = (int) get_option( 'page_on_front' );
$hero_image     = $front_id && has_post_thumbnail( $front_id ) ? get_the_post_thumbnail_url( $front_id, 'full' ) : '';
$package_url    = custom_theme_listing_url( 'paket_wisata' );
$transport_url  = custom_theme_listing_url( 'transportasi' );
$guide_url      = travel_aja_v2_page_url( 'panduan-wisata', '/panduan-wisata/' );
$contact_url    = travel_aja_v2_page_url( 'tentang-kami', '/tentang-kami/' );
$hero_kicker    = get_theme_mod( 'travel_v2_hero_kicker', 'Paket wisata dan sewa kendaraan di Indonesia' );
$hero_title     = get_theme_mod( 'travel_v2_hero_title', 'Jelajahi Indonesia dengan lebih mudah' );
$hero_desc      = get_theme_mod( 'travel_v2_hero_description', 'Temukan paket perjalanan pilihan dan kendaraan yang siap menemani rute liburan Anda.' );
?>

<main id="main-content" class="v2-home">
	<section class="v2-hero<?php echo $hero_image ? ' v2-hero--has-image' : ''; ?>"<?php if ( $hero_image ) : ?> style="--v2-hero-image:url('<?php echo esc_url( $hero_image ); ?>')"<?php endif; ?>>
		<div class="v2-shell v2-hero__content">
			<span class="v2-kicker"><?php echo esc_html( $hero_kicker ); ?></span>
			<h1><?php echo esc_html( $hero_title ); ?></h1>
			<p><?php echo esc_html( $hero_desc ); ?></p>
			<div class="v2-actions">
				<a class="v2-button" href="<?php echo esc_url( $package_url ); ?>"><?php esc_html_e( 'Lihat Paket Wisata', 'custom-theme-v2' ); ?></a>
				<a class="v2-button v2-button--outline-light" href="<?php echo esc_url( $transport_url ); ?>"><?php esc_html_e( 'Sewa Kendaraan', 'custom-theme-v2' ); ?></a>
			</div>
		</div>
		<a class="v2-hero__scroll" href="#paket-wisata" aria-label="<?php esc_attr_e( 'Lihat paket wisata', 'custom-theme-v2' ); ?>">↓</a>
	</section>

	<section class="v2-section" id="paket-wisata">
		<div class="v2-shell">
			<header class="v2-section__heading">
				<div><span class="v2-eyebrow"><?php esc_html_e( 'Pilihan perjalanan', 'custom-theme-v2' ); ?></span><h2><?php esc_html_e( 'Paket Wisata Pilihan', 'custom-theme-v2' ); ?></h2><p><?php esc_html_e( 'Pilih pengalaman terbaik dari berbagai destinasi di Indonesia dengan perjalanan yang disusun agar liburan lebih praktis.', 'custom-theme-v2' ); ?></p></div>
				<a href="<?php echo esc_url( $package_url ); ?>"><?php esc_html_e( 'Lihat semua paket', 'custom-theme-v2' ); ?> <span>→</span></a>
			</header>
			<?php
			$packages = new WP_Query(
				array(
					'post_type'           => 'paket_wisata',
					'post_status'         => 'publish',
					'posts_per_page'      => 4,
					'ignore_sticky_posts' => true,
					'no_found_rows'       => true,
				)
			);
			?>
			<?php if ( $packages->have_posts() ) : ?>
				<div class="v2-card-grid v2-card-grid--packages">
					<?php while ( $packages->have_posts() ) : $packages->the_post(); ?>
						<?php
						$duration = trim( (string) get_post_meta( get_the_ID(), '_custom_theme_package_duration', true ) );
						$location = trim( (string) get_post_meta( get_the_ID(), '_custom_theme_package_location', true ) );
						$price    = get_post_meta( get_the_ID(), '_custom_theme_package_price', true );
						$badge    = function_exists( 'custom_theme_card_badge' ) ? custom_theme_card_badge( get_the_ID(), 'package' ) : '';
						$labels   = function_exists( 'custom_theme_badge_options' ) ? custom_theme_badge_options() : array();
						?>
						<article <?php post_class( 'v2-package-card' ); ?>>
							<a class="v2-package-card__media" href="<?php the_permalink(); ?>">
								<?php if ( has_post_thumbnail() ) : the_post_thumbnail( 'large' ); else : ?><span class="v2-placeholder">INDONESIA</span><?php endif; ?>
								<?php if ( $badge ) : ?><span class="v2-badge"><?php echo esc_html( isset( $labels[ $badge ] ) ? $labels[ $badge ] : $badge ); ?></span><?php endif; ?>
							</a>
							<div class="v2-package-card__body">
								<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
								<div class="v2-package-card__facts"><span>◷ <?php echo esc_html( $duration ?: 'Durasi fleksibel' ); ?></span><span>● <?php echo esc_html( $location ?: 'Indonesia' ); ?></span></div>
								<div class="v2-package-card__footer"><span><small><?php esc_html_e( 'Mulai dari', 'custom-theme-v2' ); ?></small><strong><?php echo esc_html( travel_aja_v2_price( $price ) ); ?></strong><?php if ( '' !== (string) $price ) : ?><small>/pax</small><?php endif; ?></span><a href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr( sprintf( 'Lihat %s', get_the_title() ) ); ?>">→</a></div>
							</div>
						</article>
					<?php endwhile; ?>
				</div>
			<?php elseif ( current_user_can( 'edit_posts' ) ) : ?>
				<p class="v2-empty"><?php esc_html_e( 'Tambahkan Paket Wisata dari wp-admin agar bagian ini terisi.', 'custom-theme-v2' ); ?></p>
			<?php endif; wp_reset_postdata(); ?>
		</div>
	</section>

	<section class="v2-section v2-section--soft" id="sewa-kendaraan">
		<div class="v2-shell">
			<header class="v2-section__heading">
				<div><span class="v2-eyebrow"><?php esc_html_e( 'Bebas menjelajah', 'custom-theme-v2' ); ?></span><h2><?php esc_html_e( 'Sewa Kendaraan', 'custom-theme-v2' ); ?></h2><p><?php esc_html_e( 'Motor dan mobil pilihan untuk perjalanan harian, liburan keluarga, atau rute khusus di destinasi pilihan Anda.', 'custom-theme-v2' ); ?></p></div>
				<a href="<?php echo esc_url( $transport_url ); ?>"><?php esc_html_e( 'Lihat semua kendaraan', 'custom-theme-v2' ); ?> <span>→</span></a>
			</header>
			<?php
			$vehicles = new WP_Query(
				array(
					'post_type'           => 'transportasi',
					'post_status'         => 'publish',
					'posts_per_page'      => 4,
					'ignore_sticky_posts' => true,
					'no_found_rows'       => true,
				)
			);
			?>
			<?php if ( $vehicles->have_posts() ) : ?>
				<div class="v2-card-grid v2-card-grid--vehicles">
					<?php while ( $vehicles->have_posts() ) : $vehicles->the_post(); ?>
						<?php
						$type         = trim( (string) get_post_meta( get_the_ID(), '_custom_theme_transport_type', true ) );
						$capacity     = trim( (string) get_post_meta( get_the_ID(), '_custom_theme_transport_capacity', true ) );
						$transmission = trim( (string) get_post_meta( get_the_ID(), '_custom_theme_transport_transmission', true ) );
						$price        = get_post_meta( get_the_ID(), '_custom_theme_transport_price', true );
						$unit         = trim( (string) get_post_meta( get_the_ID(), '_custom_theme_transport_unit', true ) );
						?>
						<article <?php post_class( 'v2-vehicle-card' ); ?>>
							<a class="v2-vehicle-card__media" href="<?php the_permalink(); ?>"><?php if ( has_post_thumbnail() ) : the_post_thumbnail( 'large' ); else : ?><span class="v2-placeholder">RENT</span><?php endif; ?><?php if ( $type ) : ?><span class="v2-badge v2-badge--green"><?php echo esc_html( $type ); ?></span><?php endif; ?></a>
							<div class="v2-vehicle-card__body">
								<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
								<div class="v2-vehicle-card__facts"><?php if ( $capacity ) : ?><span>♟ <?php echo esc_html( $capacity ); ?></span><?php endif; ?><?php if ( $transmission ) : ?><span>⚙ <?php echo esc_html( $transmission ); ?></span><?php endif; ?></div>
								<div class="v2-vehicle-card__footer"><span><small><?php esc_html_e( 'Mulai dari', 'custom-theme-v2' ); ?></small><strong><?php echo esc_html( travel_aja_v2_price( $price ) ); ?></strong><?php if ( $unit && '' !== (string) $price ) : ?><small>/<?php echo esc_html( $unit ); ?></small><?php endif; ?></span><a class="v2-button v2-button--small" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Lihat Detail', 'custom-theme-v2' ); ?></a></div>
							</div>
						</article>
					<?php endwhile; ?>
				</div>
			<?php elseif ( current_user_can( 'edit_posts' ) ) : ?>
				<p class="v2-empty"><?php esc_html_e( 'Tambahkan Transportasi dari wp-admin agar bagian ini terisi.', 'custom-theme-v2' ); ?></p>
			<?php endif; wp_reset_postdata(); ?>
		</div>
	</section>

	<section class="v2-trust" aria-label="<?php esc_attr_e( 'Keunggulan layanan', 'custom-theme-v2' ); ?>">
		<div class="v2-shell v2-trust__grid">
			<div><strong>01</strong><span><b><?php esc_html_e( 'Pilihan terkurasi', 'custom-theme-v2' ); ?></b><?php esc_html_e( 'Paket dan kendaraan dipilih untuk kebutuhan liburan.', 'custom-theme-v2' ); ?></span></div>
			<div><strong>02</strong><span><b><?php esc_html_e( 'Harga transparan', 'custom-theme-v2' ); ?></b><?php esc_html_e( 'Detail biaya ditampilkan sejak awal.', 'custom-theme-v2' ); ?></span></div>
			<div><strong>03</strong><span><b><?php esc_html_e( 'Bantuan cepat', 'custom-theme-v2' ); ?></b><?php esc_html_e( 'Tim lokal siap membantu sebelum dan selama perjalanan.', 'custom-theme-v2' ); ?></span></div>
		</div>
	</section>

	<section class="v2-section v2-section--articles" id="artikel">
		<div class="v2-shell">
			<header class="v2-section__heading">
				<div><span class="v2-eyebrow"><?php esc_html_e( 'Inspirasi perjalanan', 'custom-theme-v2' ); ?></span><h2><?php esc_html_e( 'Artikel & Tips Wisata Indonesia', 'custom-theme-v2' ); ?></h2><p><?php esc_html_e( 'Temukan inspirasi destinasi dan panduan perjalanan dalam bahasa Indonesia.', 'custom-theme-v2' ); ?></p></div>
				<a href="<?php echo esc_url( $guide_url ); ?>"><?php esc_html_e( 'Lihat semua artikel', 'custom-theme-v2' ); ?> <span>→</span></a>
			</header>
			<?php
			// Artikel terbaru; Polylang otomatis membatasi hasil ke bahasa yang sedang aktif.
			$articles = new WP_Query(
				array(
					'post_type'           => 'post',
					'post_status'         => 'publish',
					'posts_per_page'      => 3,
					'ignore_sticky_posts' => true,
					'no_found_rows'       => true,
				)
			);
			?>
			<?php if ( $articles->have_posts() ) : ?><div class="v2-article-grid">
				<?php while ( $articles->have_posts() ) : $articles->the_post(); ?>
					<article <?php post_class( 'v2-article-card' ); ?>><a class="v2-article-card__media" href="<?php the_permalink(); ?>"><?php if ( has_post_thumbnail() ) : the_post_thumbnail( 'large' ); else : ?><span class="v2-placeholder">STORY</span><?php endif; ?></a><div class="v2-article-card__body"><span><?php echo esc_html( get_the_date() ); ?></span><h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3><p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 18 ) ); ?></p><a href="<?php the_permalink(); ?>"><?php esc_html_e( 'Baca artikel', 'custom-theme-v2' ); ?> →</a></div></article>
				<?php endwhile; ?>
			</div><?php elseif ( current_user_can( 'edit_posts' ) ) : ?><p class="v2-empty"><?php esc_html_e( 'Tambahkan Pos dari wp-admin agar bagian artikel terisi.', 'custom-theme-v2' ); ?></p><?php endif; wp_reset_postdata(); ?>
		</div>
	</section>

	<section class="v2-cta">
		<div class="v2-shell v2-cta__inner"><div><span class="v2-eyebrow"><?php esc_html_e( 'Rencanakan perjalanan Anda', 'custom-theme-v2' ); ?></span><h2><?php esc_html_e( 'Siap menjelajahi Indonesia?', 'custom-theme-v2' ); ?></h2><p><?php esc_html_e( 'Ceritakan kebutuhan perjalanan Anda. Tim kami akan membantu memilih paket dan kendaraan yang paling sesuai.', 'custom-theme-v2' ); ?></p></div><a class="v2-button" href="<?php echo esc_url( $contact_url ); ?>"><?php esc_html_e( 'Konsultasi Sekarang', 'custom-theme-v2' ); ?> →</a></div>
	</section>
</main>

<?php get_footer(); ?>
