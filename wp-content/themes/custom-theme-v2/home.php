<?php
/**
 * Arsip Panduan Wisata — layout "eksplorasi".
 *
 * Override tema induk (custom-theme/home.php). Bedanya:
 *  - tidak ada sidebar kanan; filter kategori jadi rail lengket di KIRI
 *  - artikel ditampilkan sebagai rute bernomor (garis vertikal + nomor besar)
 *  - ada strip gambar destinasi di atas
 *  - post pertama tidak lagi tampil dua kali
 *
 * @package Custom_Theme_V2
 */

$posts_page_id = (int) get_option( 'page_for_posts' );
$hero_image    = $posts_page_id && has_post_thumbnail( $posts_page_id ) ? get_the_post_thumbnail_url( $posts_page_id, 'full' ) : custom_theme_listing_hero_image();
$guide_q       = custom_theme_request_value( 'guide_q' );
$guide_cat     = max( 0, (int) custom_theme_request_value( 'guide_cat', '0' ) );
$paged         = max( 1, (int) get_query_var( 'paged' ) );

$guide_query = new WP_Query(
	array(
		'post_type'      => 'post',
		'post_status'    => 'publish',
		'posts_per_page' => 6,
		'paged'          => $paged,
		's'              => $guide_q,
		'cat'            => $guide_cat,
	)
);

$categories         = get_categories( array( 'hide_empty' => true ) );
$display_categories = custom_theme_guide_display_categories( $categories );
$page_url           = $posts_page_id ? get_permalink( $posts_page_id ) : home_url( '/' );
$guide_title        = $posts_page_id ? get_the_title( $posts_page_id ) : 'Panduan Wisata';

// Jumlah artikel pada bahasa yang sedang aktif (bukan seluruh bahasa).
$xp_count_query = new WP_Query( array( 'post_type' => 'post', 'post_status' => 'publish', 'posts_per_page' => 1, 'fields' => 'ids' ) );
$xp_total       = (int) $xp_count_query->found_posts;

// Strip destinasi: satu gambar per kategori, diambil dari artikel terbarunya.
$xp_tiles = array();
foreach ( array_slice( $display_categories, 0, 6 ) as $xp_category ) {
	$xp_latest = get_posts(
		array(
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'posts_per_page' => 1,
			'cat'            => (int) $xp_category['id'],
			'fields'         => 'ids',
		)
	);
	$xp_post_id     = $xp_latest ? (int) $xp_latest[0] : 0;
	$xp_thumb_id    = $xp_post_id ? (int) get_post_thumbnail_id( $xp_post_id ) : 0;
	$xp_image_title = $xp_thumb_id ? (string) get_post_field( 'post_title', $xp_thumb_id ) : '';
	$xp_label       = custom_theme_guide_category_label( $xp_category['label'] );

	$xp_tiles[] = array(
		'label'         => $xp_label,
		'count'         => (int) $xp_category['count'],
		'thumb'         => $xp_post_id ? (string) get_the_post_thumbnail_url( $xp_post_id, 'medium_large' ) : '',
		'image'         => $xp_post_id ? (string) get_the_post_thumbnail_url( $xp_post_id, 'large' ) : '',
		// Judul gambar: pakai judul lampiran, kalau kosong jatuh ke label kategori.
		'image_title'   => '' !== $xp_image_title ? $xp_image_title : $xp_label,
		'article_title' => $xp_post_id ? custom_theme_guide_public_text( get_the_title( $xp_post_id ) ) : '',
		'article_url'   => $xp_post_id ? (string) get_permalink( $xp_post_id ) : $page_url,
	);
}

get_header();
?>
<main id="main-content" class="xp-page">
	<section class="travel-page-hero xp-hero"<?php if ( $hero_image ) : ?> style="--travel-hero-image:url('<?php echo esc_url( $hero_image ); ?>')"<?php endif; ?>>
		<div class="container travel-page-hero__inner">
			<span><?php esc_html_e( 'Peta Panduan', 'custom-theme-v2' ); ?></span>
			<h1><?php echo esc_html( $guide_title ); ?></h1>
			<p><?php esc_html_e( 'Telusuri rute belajar: tips perjalanan, panduan destinasi, rekomendasi aktivitas, hingga informasi praktis untuk menjelajahi Indonesia.', 'custom-theme-v2' ); ?></p>
			<form class="travel-page-search" method="get" action="<?php echo esc_url( $page_url ); ?>">
				<input type="search" name="guide_q" value="<?php echo esc_attr( $guide_q ); ?>" placeholder="<?php esc_attr_e( 'Cari panduan perjalanan...', 'custom-theme-v2' ); ?>">
				<button type="submit"><?php esc_html_e( 'Cari', 'custom-theme-v2' ); ?></button>
			</form>
		</div>
	</section>

	<?php if ( $xp_tiles ) : ?>
		<section class="xp-strip-wrap">
			<div class="container">
				<div class="xp-strip">
					<?php foreach ( $xp_tiles as $xp_tile ) : ?>
						<a class="xp-tile" href="<?php echo esc_url( $xp_tile['article_url'] ); ?>"
							data-xp-tile
							data-xp-image="<?php echo esc_url( $xp_tile['image'] ); ?>"
							data-xp-caption="<?php echo esc_attr( $xp_tile['image_title'] ); ?>"
							data-xp-label="<?php echo esc_attr( $xp_tile['label'] ); ?>"
							data-xp-article="<?php echo esc_attr( $xp_tile['article_title'] ); ?>"
							data-xp-url="<?php echo esc_url( $xp_tile['article_url'] ); ?>">
							<?php if ( $xp_tile['thumb'] ) : ?>
								<img src="<?php echo esc_url( $xp_tile['thumb'] ); ?>" alt="<?php echo esc_attr( $xp_tile['label'] ); ?>" loading="lazy">
							<?php else : ?>
								<span class="xp-tile__blank" aria-hidden="true"></span>
							<?php endif; ?>
							<span class="xp-tile__count"><?php echo esc_html( (string) $xp_tile['count'] ); ?></span>
							<span class="xp-tile__label"><?php echo esc_html( $xp_tile['label'] ); ?></span>
						</a>
					<?php endforeach; ?>
				</div>
			</div>
		</section>

		<dialog class="xp-modal" id="xp-modal" aria-labelledby="xp-modal-title">
			<button type="button" class="xp-modal__close" data-xp-close aria-label="<?php esc_attr_e( 'Tutup pratinjau', 'custom-theme-v2' ); ?>">×</button>
			<div class="xp-modal__stage">
				<img class="xp-modal__img" src="" alt="">
				<button type="button" class="xp-modal__nav xp-modal__nav--prev" data-xp-prev aria-label="<?php esc_attr_e( 'Gambar sebelumnya', 'custom-theme-v2' ); ?>">‹</button>
				<button type="button" class="xp-modal__nav xp-modal__nav--next" data-xp-next aria-label="<?php esc_attr_e( 'Gambar berikutnya', 'custom-theme-v2' ); ?>">›</button>
				<span class="xp-modal__counter"></span>
			</div>
			<div class="xp-modal__body">
				<span class="xp-modal__eyebrow"></span>
				<p class="xp-modal__caption"></p>
				<h2 class="xp-modal__title" id="xp-modal-title"><a class="xp-modal__link" href=""></a></h2>
			</div>
		</dialog>
	<?php endif; ?>

	<section class="page-section xp-section">
		<div class="container xp-layout">
			<aside class="xp-rail" aria-label="<?php esc_attr_e( 'Filter kategori', 'custom-theme-v2' ); ?>">
				<div class="xp-rail__box">
					<h2 class="xp-rail__title"><?php esc_html_e( 'Filter Kategori', 'custom-theme-v2' ); ?></h2>
					<ul class="xp-rail__list">
						<li>
							<a class="<?php echo $guide_cat ? '' : 'is-active'; ?>" href="<?php echo esc_url( $page_url ); ?>">
								<?php esc_html_e( 'Semua', 'custom-theme-v2' ); ?><span><?php echo esc_html( (string) $xp_total ); ?></span>
							</a>
						</li>
						<?php foreach ( $display_categories as $xp_category ) : ?>
							<li>
								<a class="<?php echo $guide_cat === (int) $xp_category['id'] ? 'is-active' : ''; ?>" href="<?php echo esc_url( add_query_arg( 'guide_cat', (int) $xp_category['id'], $page_url ) ); ?>">
									<?php echo esc_html( custom_theme_guide_category_label( $xp_category['label'] ) ); ?><span><?php echo esc_html( (string) $xp_category['count'] ); ?></span>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
				<div class="xp-rail__note">
					<strong><?php esc_html_e( 'Butuh itinerary khusus?', 'custom-theme-v2' ); ?></strong>
					<p><?php esc_html_e( 'Sampaikan rencana perjalanan Anda, tim kami bantu susun rutenya.', 'custom-theme-v2' ); ?></p>
					<a href="<?php echo esc_url( travel_aja_v2_page_url( 'tentang-kami', '/tentang-kami/' ) ); ?>"><?php esc_html_e( 'Hubungi kami', 'custom-theme-v2' ); ?> →</a>
				</div>
			</aside>

			<div class="xp-content">
				<?php if ( $guide_query->have_posts() ) : ?>
					<ol class="xp-route">
						<?php
						$xp_index = ( $paged - 1 ) * 6;
						while ( $guide_query->have_posts() ) :
							$guide_query->the_post();
							$xp_index++;
							$xp_cats = get_the_category();
							?>
							<li class="xp-stop">
								<span class="xp-stop__num"><?php echo esc_html( str_pad( (string) $xp_index, 2, '0', STR_PAD_LEFT ) ); ?></span>
								<article <?php post_class( 'xp-card' ); ?>>
									<a class="xp-card__media" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
										<?php if ( has_post_thumbnail() ) : ?>
											<?php the_post_thumbnail( 'medium_large' ); ?>
										<?php else : ?>
											<span class="xp-card__blank" aria-hidden="true"></span>
										<?php endif; ?>
									</a>
									<div class="xp-card__body">
										<?php if ( $xp_cats ) : ?>
											<span class="xp-card__tag"><?php echo esc_html( custom_theme_guide_category_label( $xp_cats[0]->name ) ); ?></span>
										<?php endif; ?>
										<h2><a href="<?php the_permalink(); ?>"><?php echo esc_html( custom_theme_guide_public_text( get_the_title() ) ); ?></a></h2>
										<p><?php echo esc_html( wp_trim_words( custom_theme_guide_public_text( get_the_excerpt() ), 24 ) ); ?></p>
										<div class="xp-card__meta">
											<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
											<span><?php echo esc_html( (string) max( 1, (int) ceil( str_word_count( wp_strip_all_tags( get_the_content() ) ) / 200 ) ) ); ?> <?php esc_html_e( 'mnt baca', 'custom-theme-v2' ); ?></span>
											<a class="xp-card__read" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Baca panduan', 'custom-theme-v2' ); ?> →</a>
										</div>
									</div>
								</article>
							</li>
						<?php endwhile; ?>
					</ol>

					<?php if ( $guide_query->max_num_pages > 1 ) : ?>
						<nav class="listing-pagination"><?php echo wp_kses_post( paginate_links( array( 'total' => $guide_query->max_num_pages, 'current' => $paged ) ) ); ?></nav>
					<?php endif; ?>
				<?php else : ?>
					<div class="listing-empty">
						<h2><?php esc_html_e( 'Belum ada panduan', 'custom-theme-v2' ); ?></h2>
						<p><?php esc_html_e( 'Tambahkan artikel melalui menu Posts di wp-admin.', 'custom-theme-v2' ); ?></p>
					</div>
				<?php endif; ?>
				<?php wp_reset_postdata(); ?>
			</div>
		</div>
	</section>
</main>
<?php get_footer(); ?>
