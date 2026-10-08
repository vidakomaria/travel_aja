<?php
/**
 * Template cadangan untuk halaman dan daftar konten.
 *
 * @package Custom_Theme
 */

get_header();
?>

<main id="main-content" class="container site-main">
	<?php if ( have_posts() ) : ?>
		<?php if ( is_search() ) : ?>
			<h1><?php echo esc_html( sprintf( __( 'Hasil pencarian: %s', 'custom-theme' ), get_search_query() ) ); ?></h1>
		<?php elseif ( is_archive() ) : ?>
			<h1><?php echo esc_html( get_the_archive_title() ); ?></h1>
		<?php endif; ?>

		<?php while ( have_posts() ) : the_post(); ?>
			<article <?php post_class( 'entry' ); ?>>
				<?php if ( is_singular() ) : ?>
					<h1 class="entry__title"><?php echo esc_html( get_the_title() ); ?></h1>
				<?php else : ?>
					<h2 class="entry__title"><a href="<?php echo esc_url( get_permalink() ); ?>"><?php echo esc_html( get_the_title() ); ?></a></h2>
				<?php endif; ?>

				<?php if ( has_post_thumbnail() ) : ?>
					<?php the_post_thumbnail( 'large', array( 'class' => 'entry__image' ) ); ?>
				<?php endif; ?>

				<div class="entry__body">
					<?php
					if ( is_singular() ) {
						the_content();
					} else {
						the_excerpt();
					}
					?>
				</div>
			</article>
		<?php endwhile; ?>

		<?php if ( is_singular() && ( comments_open() || get_comments_number() ) ) : comments_template(); endif; ?>

		<?php the_posts_pagination(); ?>
	<?php else : ?>
		<?php if ( is_search() ) : ?>
			<h1><?php echo esc_html( sprintf( __( 'Tidak ada hasil untuk: %s', 'custom-theme' ), get_search_query( false ) ) ); ?></h1>
			<p><?php esc_html_e( 'Coba kata kunci lain untuk mencari destinasi, paket wisata, atau artikel.', 'custom-theme' ); ?></p>
		<?php else : ?>
			<h1><?php esc_html_e( 'Belum ada konten', 'custom-theme' ); ?></h1>
			<p><?php esc_html_e( 'Tambahkan konten dari wp-admin untuk melihatnya di sini.', 'custom-theme' ); ?></p>
		<?php endif; ?>
	<?php endif; ?>
</main>

<?php get_footer(); ?>
