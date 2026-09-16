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
						<?php if ( trim( (string) get_post_field( 'post_content', get_the_ID() ) ) ) : ?>
							<?php the_content(); ?>
						<?php else : ?>
							<p><?php esc_html_e( 'Pilih paket wisata, destinasi, dan transportasi untuk perjalanan Anda.', 'custom-theme' ); ?></p>
						<?php endif; ?>
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
		array(
			'post_type' => 'transportasi',
			'title'     => __( 'Transportasi Perjalanan', 'custom-theme' ),
			'intro'     => __( 'Pilih kendaraan yang sesuai dengan kebutuhan perjalanan Anda.', 'custom-theme' ),
			'limit'     => 4,
		),
		array(
			'post_type' => 'post',
			'title'     => __( 'Panduan Wisata', 'custom-theme' ),
			'intro'     => __( 'Baca tips dan cerita perjalanan terbaru.', 'custom-theme' ),
			'limit'     => 3,
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
</main>

<?php get_footer(); ?>
