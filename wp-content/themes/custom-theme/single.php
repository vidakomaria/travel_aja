<?php
/** Template detail artikel dan tipe konten khusus. */
get_header();
?>
<main id="main-content" class="single-page">
	<?php while ( have_posts() ) : the_post(); ?>
		<?php $hero_image = has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_ID(), 'full' ) : custom_theme_listing_hero_image(); ?>
		<section class="travel-page-hero single-hero"<?php if ( $hero_image ) : ?> style="--travel-hero-image:url('<?php echo esc_url( $hero_image ); ?>')"<?php endif; ?>>
			<div class="container travel-page-hero__inner">
				<span><?php echo esc_html( get_post_type_object( get_post_type() )->labels->singular_name ); ?></span>
				<h1><?php the_title(); ?></h1>
				<div class="single-meta"><time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time><?php if ( 'post' === get_post_type() ) : ?><span><?php esc_html_e( 'Oleh', 'custom-theme' ); ?> <?php the_author(); ?></span><span><?php echo esc_html( get_comments_number_text( __( 'Belum ada komentar', 'custom-theme' ), __( '1 komentar', 'custom-theme' ), __( '% komentar', 'custom-theme' ) ) ); ?></span><?php endif; ?></div>
			</div>
		</section>
		<div class="single-content-wrap">
			<article <?php post_class( 'single-article' ); ?>>
				<div class="single-article__content"><?php the_content(); ?></div>
				<?php wp_link_pages( array( 'before' => '<nav class="single-page-links">' . esc_html__( 'Halaman: ', 'custom-theme' ), 'after' => '</nav>' ) ); ?>
			</article>
			<?php if ( comments_open() || get_comments_number() ) : comments_template(); endif; ?>
			<nav class="single-post-nav" aria-label="<?php esc_attr_e( 'Artikel lainnya', 'custom-theme' ); ?>"><div><?php previous_post_link( '%link', '← %title' ); ?></div><div><?php next_post_link( '%link', '%title →' ); ?></div></nav>
		</div>
	<?php endwhile; ?>
</main>
<?php get_footer(); ?>
