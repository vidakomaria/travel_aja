<?php
/**
 * Beranda: konten pembuka dari halaman Beranda dan daftar konten dari WordPress.
 *
 * @package Custom_Theme
 */

get_header();
?>

<main id="main-content">
	<?php while ( have_posts() ) : the_post(); ?>
		<?php $hero_image_url = get_the_post_thumbnail_url( get_the_ID(), 'full' ); ?>
		<section class="home-hero<?php echo $hero_image_url ? ' home-hero--has-image' : ''; ?>" aria-labelledby="home-hero-title"<?php if ( $hero_image_url ) : ?> style="--home-hero-image: url('<?php echo esc_url( $hero_image_url ); ?>');"<?php endif; ?>>
			<div class="container home-hero__inner">
				<div class="home-hero__copy">
					<h1 id="home-hero-title"><?php esc_html_e( 'Jelajahi Banyuwangi bersama kami', 'custom-theme' ); ?></h1>
					<div class="home-hero__description">
						<p><?php esc_html_e( 'Pilih paket wisata, destinasi, dan transportasi untuk perjalanan Anda.', 'custom-theme' ); ?></p>
					</div>
					<form class="home-search" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
						<label class="home-search__label" for="home-search-input"><?php esc_html_e( 'Cari destinasi, paket wisata, atau artikel', 'custom-theme' ); ?></label>
						<svg class="home-search__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true" focusable="false">
							<circle cx="11" cy="11" r="7"></circle>
							<path d="m16 16 5 5"></path>
						</svg>
						<input id="home-search-input" type="search" name="s" placeholder="<?php echo esc_attr__( 'Mau menjelajahi ke mana?', 'custom-theme' ); ?>" required>
						<button type="submit"><?php esc_html_e( 'Cari', 'custom-theme' ); ?></button>
					</form>
				</div>
			</div>
		</section>
		<?php if ( trim( (string) get_post_field( 'post_content', get_the_ID() ) ) ) : ?>
			<section class="home-page-content" aria-label="<?php echo esc_attr__( 'Konten Beranda', 'custom-theme' ); ?>">
				<div class="container">
					<?php the_content(); ?>
				</div>
			</section>
		<?php endif; ?>
	<?php endwhile; ?>

	<?php
	// Setiap bagian mengambil konten terbaru dari tipe konten yang dikelola di wp-admin.
	$home_sections = array(
		array(
			'post_type' => 'paket_wisata',
			'title'     => __( 'Paket Wisata', 'custom-theme' ),
			'intro'     => __( 'Pilih perjalanan berdasarkan destinasi dan pengalaman yang Anda inginkan.', 'custom-theme' ),
			'limit'     => 4,
		),
		array(
			'post_type' => 'destinasi',
			'title'     => __( 'Destinasi untuk Dijelajahi', 'custom-theme' ),
			'intro'     => __( 'Jelajahi tempat menarik untuk perjalanan berikutnya.', 'custom-theme' ),
			'limit'     => 4,
		),

	);
	?>

	<?php foreach ( $home_sections as $section ) : ?>
		<?php
		$items = new WP_Query(
			array(
				'post_type'           => $section['post_type'],
				'post_status'         => 'publish',
				'posts_per_page'      => $section['limit'],
				'ignore_sticky_posts' => true,
				'no_found_rows'       => true,
			)
		);

		if ( ! $items->have_posts() && ! current_user_can( 'edit_posts' ) ) {
			wp_reset_postdata();
			continue;
		}
		?>
		<section class="home-section" aria-labelledby="home-<?php echo esc_attr( $section['post_type'] ); ?>-title">
			<div class="container">
				<div class="home-section__heading">
					<h2 id="home-<?php echo esc_attr( $section['post_type'] ); ?>-title"><?php echo esc_html( $section['title'] ); ?></h2>
					<p><?php echo esc_html( $section['intro'] ); ?></p>
				</div>

				<?php if ( $items->have_posts() ) : ?>
					<div class="home-cards">
						<?php while ( $items->have_posts() ) : $items->the_post(); ?>
							<?php if ( 'paket_wisata' === $section['post_type'] ) : ?>
								<?php
								$duration = trim( (string) get_post_meta( get_the_ID(), '_custom_theme_package_duration', true ) );
								$location = trim( (string) get_post_meta( get_the_ID(), '_custom_theme_package_location', true ) );
								$price    = get_post_meta( get_the_ID(), '_custom_theme_package_price', true );
								$badge = custom_theme_card_badge( get_the_ID(), 'package' );
								?>
								<article <?php post_class( 'home-card home-card--package' ); ?>>
									<div class="package-card__media">
										<?php if ( has_post_thumbnail() ) : ?>
											<a href="<?php echo esc_url( get_permalink() ); ?>" aria-hidden="true" tabindex="-1">
												<?php the_post_thumbnail( 'medium_large', array( 'class' => 'package-card__image' ) ); ?>
											</a>
										<?php endif; ?>
										<?php if ( $badge ) : ?>
											<span class="package-card__badge card-badge--<?php echo esc_attr( $badge ); ?>"><?php echo esc_html( custom_theme_badge_options()[ $badge ] ); ?></span>
										<?php endif; ?>
									</div>
									<div class="package-card__body">
										<h3><a href="<?php echo esc_url( get_permalink() ); ?>"><?php echo esc_html( get_the_title() ); ?></a></h3>
										<?php if ( $duration || $location ) : ?>
											<div class="package-card__facts">
												<?php if ( $duration ) : ?>
													<span><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9"></circle><path d="M12 7v5l3 2"></path></svg><?php echo esc_html( $duration ); ?></span>
												<?php endif; ?>
												<?php if ( $location ) : ?>
													<span><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 10c0 5-8 12-8 12S4 15 4 10a8 8 0 1 1 16 0Z"></path><circle cx="12" cy="10" r="2.5"></circle></svg><?php echo esc_html( $location ); ?></span>
												<?php endif; ?>
											</div>
										<?php endif; ?>
										<div class="package-card__footer">
											<?php if ( '' !== (string) $price ) : ?>
												<div class="package-card__price">
													<span><?php esc_html_e( 'MULAI DARI', 'custom-theme' ); ?></span>
													<strong>Rp <?php echo esc_html( number_format( (int) $price, 0, ',', '.' ) ); ?></strong><small>/PAX</small>
												</div>
											<?php endif; ?>
											<a class="package-card__button" href="<?php echo esc_url( get_permalink() ); ?>"><?php esc_html_e( 'Lihat Detail', 'custom-theme' ); ?></a>
										</div>
									</div>
								</article>
							<?php elseif ( 'destinasi' === $section['post_type'] ) : ?>
								<?php
								$location = get_post_meta( get_the_ID(), '_custom_theme_destination_location', true );
								$rating = get_post_meta( get_the_ID(), '_custom_theme_destination_rating', true );
								$badge = custom_theme_card_badge( get_the_ID(), 'destination' );
								?>
								<article <?php post_class( 'destination-card' ); ?>>
									<a class="destination-card__link" href="<?php echo esc_url( get_permalink() ); ?>">
										<?php if ( has_post_thumbnail() ) : ?>
											<?php the_post_thumbnail( 'large', array( 'class' => 'destination-card__image', 'alt' => '' ) ); ?>
										<?php endif; ?>
										<?php if ( $badge ) : ?>
											<span class="package-card__badge card-badge--<?php echo esc_attr( $badge ); ?>"><?php echo esc_html( custom_theme_badge_options()[ $badge ] ); ?></span>
										<?php endif; ?>
										<div class="destination-card__content">
											<h3><?php the_title(); ?></h3>
											<?php if ( $location || '' !== (string) $rating ) : ?>
												<div class="destination-card__facts">
													<?php if ( $location ) : ?><span><svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2a8 8 0 0 0-8 8c0 6 8 12 8 12s8-6 8-12a8 8 0 0 0-8-8Zm0 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6Z"/></svg><?php echo esc_html( $location ); ?></span><?php endif; ?>
													<?php if ( '' !== (string) $rating ) : ?><span aria-label="<?php echo esc_attr( sprintf( __( 'Rating %s dari 5', 'custom-theme' ), $rating ) ); ?>"><span class="destination-card__star" aria-hidden="true">★</span><?php echo esc_html( number_format( (float) $rating, 1 ) ); ?></span><?php endif; ?>
												</div>
											<?php endif; ?>
										</div>
									</a>
								</article>
							<?php else : ?>
								<article <?php post_class( 'home-card' ); ?>>
									<?php if ( has_post_thumbnail() ) : ?>
										<a class="home-card__media" href="<?php echo esc_url( get_permalink() ); ?>" aria-hidden="true" tabindex="-1">
											<?php the_post_thumbnail( 'medium_large', array( 'class' => 'home-card__image' ) ); ?>
										</a>
									<?php endif; ?>
									<div class="home-card__body">
										<h3><a href="<?php echo esc_url( get_permalink() ); ?>"><?php echo esc_html( get_the_title() ); ?></a></h3>
										<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 22 ) ); ?></p>
									</div>
								</article>
							<?php endif; ?>
						<?php endwhile; ?>
					</div>
				<?php else : ?>
					<p class="home-section__empty">
						<?php echo esc_html( sprintf( __( 'Belum ada konten %s. Tambahkan dari wp-admin agar bagian ini terisi.', 'custom-theme' ), $section['title'] ) ); ?>
					</p>
				<?php endif; ?>
			</div>
		</section>
		<?php wp_reset_postdata(); ?>
	<?php endforeach; ?>
<div class="lower-home">
	<?php get_template_part( 'template-parts/home-transport' ); ?>
	<?php get_template_part( 'template-parts/home-extras' ); ?>
</div>
</main>

<?php get_footer(); ?>
