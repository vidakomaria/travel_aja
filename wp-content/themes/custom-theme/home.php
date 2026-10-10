<?php
/** Halaman arsip Panduan Wisata. */
$posts_page_id = (int) get_option( 'page_for_posts' );
$hero_image    = $posts_page_id && has_post_thumbnail( $posts_page_id ) ? get_the_post_thumbnail_url( $posts_page_id, 'full' ) : custom_theme_listing_hero_image();
$guide_q       = custom_theme_request_value( 'guide_q' );
$guide_cat     = max( 0, (int) custom_theme_request_value( 'guide_cat', '0' ) );
$paged         = max( 1, (int) get_query_var( 'paged' ) );
$guide_query   = new WP_Query(
	array(
		'post_type'      => 'post',
		'post_status'    => 'publish',
		'posts_per_page' => 6,
		'paged'          => $paged,
		's'              => $guide_q,
		'cat'            => $guide_cat,
	)
);
$categories = get_categories( array( 'hide_empty' => true ) );
$display_categories = custom_theme_guide_display_categories( $categories );
$page_url   = $posts_page_id ? get_permalink( $posts_page_id ) : home_url( '/' );
get_header();
?>
<main id="main-content" class="guide-page">
	<section class="travel-page-hero"<?php if ( $hero_image ) : ?> style="--travel-hero-image:url('<?php echo esc_url( $hero_image ); ?>')"<?php endif; ?>>
		<div class="container travel-page-hero__inner">
			<?php $guide_title = $posts_page_id ? get_the_title( $posts_page_id ) : __( 'Panduan Wisata', 'custom-theme' ); ?>
			<h1><?php echo esc_html( $guide_title ); ?></h1>
			<p><?php esc_html_e( 'Temukan tips perjalanan, panduan destinasi, rekomendasi aktivitas, hingga informasi praktis untuk menjelajahi Indonesia.', 'custom-theme' ); ?></p>
			<form class="travel-page-search" method="get" action="<?php echo esc_url( $page_url ); ?>"><input type="search" name="guide_q" value="<?php echo esc_attr( $guide_q ); ?>" placeholder="<?php esc_attr_e( 'Cari panduan perjalanan...', 'custom-theme' ); ?>"><button type="submit"><?php esc_html_e( 'Cari', 'custom-theme' ); ?></button></form>
			<nav class="guide-chips" aria-label="<?php esc_attr_e( 'Kategori panduan', 'custom-theme' ); ?>"><a href="<?php echo esc_url( $page_url ); ?>"><?php esc_html_e( 'Semua', 'custom-theme' ); ?></a><?php foreach ( array_slice( $display_categories, 0, 5 ) as $category ) : ?><a href="<?php echo esc_url( add_query_arg( 'guide_cat', $category['id'], $page_url ) ); ?>"><?php echo esc_html( $category['label'] ); ?></a><?php endforeach; ?></nav>
		</div>
	</section>
	<section class="guide-content"><div class="container guide-layout">
		<div>
			<?php if ( $guide_query->have_posts() ) : $guide_query->the_post(); ?>
				<article class="guide-feature">
					<a class="guide-feature__image" href="<?php the_permalink(); ?>"><?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'large' ); } ?></a>
					<?php $article_categories = get_the_category(); $article_labels = array_map( 'custom_theme_guide_category_label', wp_list_pluck( $article_categories, 'name' ) ); ?>
					<div class="guide-feature__body"><div class="guide-meta"><span><?php echo esc_html( $article_labels ? implode( ', ', $article_labels ) : __( 'Panduan Wisata', 'custom-theme' ) ); ?></span><time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time><span><?php echo esc_html( max( 1, (int) ceil( str_word_count( wp_strip_all_tags( get_the_content() ) ) / 200 ) ) ); ?> <?php esc_html_e( 'mnt baca', 'custom-theme' ); ?></span></div><h2><?php echo esc_html( custom_theme_guide_public_text( get_the_title() ) ); ?></h2><p><?php echo esc_html( wp_trim_words( custom_theme_guide_public_text( get_the_excerpt() ), 28 ) ); ?></p><a class="guide-read" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Baca Panduan →', 'custom-theme' ); ?></a></div>
				</article>
				<?php $guide_query->rewind_posts(); ?>
				<div class="guide-post-grid">
				<?php while ( $guide_query->have_posts() ) : $guide_query->the_post(); $cats = get_the_category(); ?>
					<article <?php post_class( 'guide-post' ); ?>><a class="guide-post__image" href="<?php the_permalink(); ?>"><?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'medium_large' ); } ?><?php if ( $cats ) : ?><span><?php echo esc_html( custom_theme_guide_category_label( $cats[0]->name ) ); ?></span><?php endif; ?></a><div class="guide-post__body"><h2><a href="<?php the_permalink(); ?>"><?php echo esc_html( custom_theme_guide_public_text( get_the_title() ) ); ?></a></h2><p><?php echo esc_html( wp_trim_words( custom_theme_guide_public_text( get_the_excerpt() ), 20 ) ); ?></p><div class="guide-post__footer"><time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time><a href="<?php the_permalink(); ?>"><?php esc_html_e( 'Baca Selengkapnya', 'custom-theme' ); ?></a></div></div></article>
				<?php endwhile; ?>
				</div>
				<?php if ( $guide_query->max_num_pages > 1 ) : ?><nav class="listing-pagination"><?php echo wp_kses_post( paginate_links( array( 'total' => $guide_query->max_num_pages, 'current' => $paged ) ) ); ?></nav><?php endif; ?>
			<?php else : ?><div class="listing-empty"><h2><?php esc_html_e( 'Belum ada panduan', 'custom-theme' ); ?></h2><p><?php esc_html_e( 'Tambahkan artikel melalui menu Posts di wp-admin.', 'custom-theme' ); ?></p></div><?php endif; wp_reset_postdata(); ?>
		</div>
		<aside class="guide-sidebar">
			<section class="guide-widget"><h2><?php esc_html_e( 'Kategori Panduan', 'custom-theme' ); ?></h2><ul><?php foreach ( $display_categories as $category ) : ?><li><a href="<?php echo esc_url( add_query_arg( 'guide_cat', $category['id'], $page_url ) ); ?>"><?php echo esc_html( $category['label'] ); ?></a><span><?php echo esc_html( (string) $category['count'] ); ?></span></li><?php endforeach; ?></ul></section>
			<?php $popular = new WP_Query( array( 'post_type' => 'post', 'posts_per_page' => 3, 'orderby' => 'comment_count', 'no_found_rows' => true ) ); if ( $popular->have_posts() ) : ?><section class="guide-widget"><h2><?php esc_html_e( 'Panduan Populer', 'custom-theme' ); ?></h2><ul><?php while ( $popular->have_posts() ) : $popular->the_post(); ?><li><?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'thumbnail' ); } ?><a href="<?php the_permalink(); ?>"><?php echo esc_html( wp_trim_words( custom_theme_guide_public_text( get_the_title() ), 9 ) ); ?></a></li><?php endwhile; wp_reset_postdata(); ?></ul></section><?php endif; ?>
			<?php $latest = new WP_Query( array( 'post_type' => 'post', 'posts_per_page' => 3, 'no_found_rows' => true ) ); if ( $latest->have_posts() ) : ?><section class="guide-widget"><h2><?php esc_html_e( 'Panduan Terbaru', 'custom-theme' ); ?></h2><ul><?php while ( $latest->have_posts() ) : $latest->the_post(); ?><li><?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'thumbnail' ); } ?><a href="<?php the_permalink(); ?>"><?php echo esc_html( wp_trim_words( custom_theme_guide_public_text( get_the_title() ), 9 ) ); ?></a></li><?php endwhile; wp_reset_postdata(); ?></ul></section><?php endif; ?>
			<section class="guide-widget guide-widget--cta"><h2><?php esc_html_e( 'Sudah Siap Merencanakan Perjalanan?', 'custom-theme' ); ?></h2><p><?php esc_html_e( 'Temukan paket wisata yang sesuai atau ceritakan rencana perjalanan Anda kepada kami.', 'custom-theme' ); ?></p><a href="<?php echo esc_url( home_url( '/tentang-kami/' ) ); ?>"><?php esc_html_e( 'Hubungi Kami ↗', 'custom-theme' ); ?></a></section>
		</aside>
	</div></section>
</main>
<?php get_footer(); ?>
