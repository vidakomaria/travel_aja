<?php
/**
 * Halaman detail artikel / tipe konten — versi child theme.
 *
 * Bedanya dari tema induk:
 *  - kicker "Pos" diganti breadcrumb yang bisa diklik (daftar → kategori)
 *  - ada tombol "Kembali ke …" di hero, jadi ada jalan pulang tanpa scroll
 *  - navigasi bawah jadi 3 kolom: artikel sebelumnya · daftar · artikel berikutnya
 *
 * @package Custom_Theme_V2
 */

get_header();
?>
<main id="main-content" class="single-page">
	<?php while ( have_posts() ) : the_post(); ?>
		<?php
		$back        = travel_aja_v2_single_back();
		$is_article  = ( 'post' === get_post_type() );
		$article_cat = $is_article ? get_the_category() : array();
		$primary_cat = $article_cat ? $article_cat[0] : null;
		$prev_post   = get_previous_post();
		$next_post   = get_next_post();
		$label_prev  = $is_article ? __( 'Artikel sebelumnya', 'custom-theme-v2' ) : __( 'Sebelumnya', 'custom-theme-v2' );
		$label_next  = $is_article ? __( 'Artikel berikutnya', 'custom-theme-v2' ) : __( 'Berikutnya', 'custom-theme-v2' );
		?>
		<section class="travel-page-hero single-hero">
			<div class="container travel-page-hero__inner">
				<nav class="single-breadcrumb" aria-label="<?php esc_attr_e( 'Navigasi artikel', 'custom-theme-v2' ); ?>">
					<a href="<?php echo esc_url( $back['url'] ); ?>"><?php echo esc_html( $back['label'] ); ?></a>
					<?php if ( $primary_cat ) : ?>
						<span aria-hidden="true">/</span>
						<a href="<?php echo esc_url( add_query_arg( 'guide_cat', (int) $primary_cat->term_id, $back['url'] ) ); ?>"><?php echo esc_html( custom_theme_guide_category_label( $primary_cat->name ) ); ?></a>
					<?php endif; ?>
				</nav>
				<h1><?php the_title(); ?></h1>
				<div class="single-meta">
					<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
					<?php if ( $is_article ) : ?>
						<span><?php esc_html_e( 'Oleh', 'custom-theme' ); ?> <?php the_author(); ?></span>
						<span><?php echo esc_html( get_comments_number_text( __( 'Belum ada komentar', 'custom-theme' ), __( '1 komentar', 'custom-theme' ), __( '% komentar', 'custom-theme' ) ) ); ?></span>
					<?php endif; ?>
				</div>
				<a class="single-back" href="<?php echo esc_url( $back['url'] ); ?>">← <?php esc_html_e( 'Kembali ke', 'custom-theme-v2' ); ?> <?php echo esc_html( $back['label'] ); ?></a>
			</div>
		</section>

		<div class="single-content-wrap">
			<article <?php post_class( 'single-article' ); ?>>
				<div class="single-article__content"><?php the_content(); ?></div>
				<?php wp_link_pages( array( 'before' => '<nav class="single-page-links">' . esc_html__( 'Halaman: ', 'custom-theme' ), 'after' => '</nav>' ) ); ?>
			</article>

			<?php if ( comments_open() || get_comments_number() ) : comments_template(); endif; ?>

			<nav class="single-post-nav" aria-label="<?php esc_attr_e( 'Artikel lainnya', 'custom-theme' ); ?>">
				<div class="single-post-nav__cell<?php echo $prev_post ? '' : ' is-empty'; ?>">
					<?php if ( $prev_post ) : ?>
						<span class="single-post-nav__eyebrow">← <?php echo esc_html( $label_prev ); ?></span>
						<a href="<?php echo esc_url( (string) get_permalink( $prev_post ) ); ?>"><?php echo esc_html( get_the_title( $prev_post ) ); ?></a>
					<?php endif; ?>
				</div>
				<div class="single-post-nav__cell single-post-nav__cell--all">
					<span class="single-post-nav__eyebrow"><?php esc_html_e( 'Kembali ke daftar', 'custom-theme-v2' ); ?></span>
					<a href="<?php echo esc_url( $back['url'] ); ?>"><?php echo esc_html( $back['label'] ); ?> →</a>
				</div>
				<div class="single-post-nav__cell<?php echo $next_post ? '' : ' is-empty'; ?>">
					<?php if ( $next_post ) : ?>
						<span class="single-post-nav__eyebrow"><?php echo esc_html( $label_next ); ?> →</span>
						<a href="<?php echo esc_url( (string) get_permalink( $next_post ) ); ?>"><?php echo esc_html( get_the_title( $next_post ) ); ?></a>
					<?php endif; ?>
				</div>
			</nav>
		</div>
	<?php endwhile; ?>
</main>
<?php get_footer(); ?>
