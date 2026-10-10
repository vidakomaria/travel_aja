<?php
/**
 * Layout detail untuk destinasi, paket wisata, dan transportasi.
 *
 * Dipakai oleh single-destinasi.php, single-paket_wisata.php, dan
 * single-transportasi.php. Menampilkan: hero tanpa gambar latar, gambar utama
 * sebagai gambar biasa, panel spesifikasi + harga + CTA WhatsApp, lalu navigasi
 * antar-item.
 *
 * @package Custom_Theme_V2
 */

while ( have_posts() ) :
	the_post();

	$dt_type  = get_post_type();
	$dt_id    = get_the_ID();
	$dt_back  = travel_aja_v2_single_back();
	$dt_price = '';
	$dt_unit  = '';
	$dt_facts = array();
	$dt_specs = array();

	if ( 'destinasi' === $dt_type ) {
		$dt_specs = array(
			'Lokasi'             => get_post_meta( $dt_id, '_custom_theme_destination_location', true ),
			'Kategori'           => get_post_meta( $dt_id, '_custom_theme_destination_category', true ),
			'Aktivitas unggulan' => get_post_meta( $dt_id, '_custom_theme_destination_highlights', true ),
		);

		$dt_rating = trim( (string) get_post_meta( $dt_id, '_custom_theme_destination_rating', true ) );
		$dt_facts  = array(
			$dt_specs['Lokasi'],
			$dt_rating ? '★ ' . $dt_rating : '',
		);
	} elseif ( 'paket_wisata' === $dt_type ) {
		$dt_specs = array(
			'Durasi' => get_post_meta( $dt_id, '_custom_theme_package_duration', true ),
			'Lokasi' => get_post_meta( $dt_id, '_custom_theme_package_location', true ),
		);

		$dt_price = (string) get_post_meta( $dt_id, '_custom_theme_package_price', true );
		$dt_facts = array( $dt_specs['Durasi'], $dt_specs['Lokasi'] );
	} elseif ( 'transportasi' === $dt_type ) {
		$dt_specs = array(
			'Tipe'      => get_post_meta( $dt_id, '_custom_theme_transport_type', true ),
			'Model'     => get_post_meta( $dt_id, '_custom_theme_transport_model', true ),
			'Kapasitas' => get_post_meta( $dt_id, '_custom_theme_transport_capacity', true ),
			'Transmisi' => get_post_meta( $dt_id, '_custom_theme_transport_transmission', true ),
		);

		$dt_price = (string) get_post_meta( $dt_id, '_custom_theme_transport_price', true );
		$dt_unit  = trim( (string) get_post_meta( $dt_id, '_custom_theme_transport_unit', true ) );
		$dt_facts = array( $dt_specs['Tipe'], $dt_specs['Kapasitas'], $dt_specs['Transmisi'] );
	}

	$dt_specs = array_filter( $dt_specs, static function ( $value ) {
		return '' !== trim( (string) $value );
	} );
	$dt_facts = array_filter( array_map( 'travel_aja_v2_ui_text', array_map( 'strval', $dt_facts ) ) );

	$dt_wa       = preg_replace( '/\D/', '', (string) get_theme_mod( 'travel_whatsapp', '' ) );
	$dt_wa_message = 'en' === ( function_exists( 'pll_current_language' ) ? pll_current_language() : 'id' )
		? sprintf( 'Hello, I would like to ask about %s.', get_the_title() )
		: sprintf( 'Halo, saya ingin bertanya tentang %s.', get_the_title() );
	$dt_wa_text  = rawurlencode( $dt_wa_message );
	$dt_wa_href  = $dt_wa ? 'https://wa.me/' . $dt_wa . '?text=' . $dt_wa_text : '';

	$dt_prev = get_previous_post();
	$dt_next = get_next_post();
	?>
	<main id="main-content" class="single-page dt-page">
		<section class="travel-page-hero single-hero dt-hero">
			<div class="container travel-page-hero__inner">
				<nav class="single-breadcrumb" aria-label="<?php esc_attr_e( 'Navigasi item', 'custom-theme-v2' ); ?>">
					<a href="<?php echo esc_url( $dt_back['url'] ); ?>"><?php echo esc_html( $dt_back['label'] ); ?></a>
				</nav>
				<h1><?php the_title(); ?></h1>
				<?php if ( $dt_facts ) : ?>
					<ul class="dt-facts">
						<?php foreach ( $dt_facts as $dt_fact ) : ?>
							<li><?php echo esc_html( $dt_fact ); ?></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
				<a class="single-back" href="<?php echo esc_url( $dt_back['url'] ); ?>">← <?php esc_html_e( 'Kembali ke', 'custom-theme-v2' ); ?> <?php echo esc_html( $dt_back['label'] ); ?></a>
			</div>
		</section>

		<div class="single-content-wrap dt-wrap">
			<div class="dt-layout">
				<div class="dt-main">
					<?php if ( has_post_thumbnail() ) : ?>
						<figure class="dt-figure"><?php the_post_thumbnail( 'large' ); ?></figure>
					<?php endif; ?>

					<?php if ( '' !== trim( (string) get_the_content() ) ) : ?>
						<article <?php post_class( 'single-article dt-article' ); ?>>
							<div class="single-article__content"><?php the_content(); ?></div>
						</article>
					<?php endif; ?>
				</div>

				<aside class="dt-aside">
					<div class="dt-card">
						<?php if ( '' !== trim( $dt_price ) ) : ?>
							<div class="dt-price">
								<small><?php esc_html_e( 'Mulai dari', 'custom-theme-v2' ); ?></small>
								<strong><?php echo esc_html( travel_aja_v2_price( $dt_price ) ); ?></strong>
								<?php if ( '' !== $dt_unit ) : ?><span>/<?php echo esc_html( $dt_unit ); ?></span><?php endif; ?>
							</div>
						<?php endif; ?>

						<?php if ( $dt_specs ) : ?>
							<dl class="dt-specs">
								<?php foreach ( $dt_specs as $dt_key => $dt_value ) : ?>
									<div>
										<dt><?php echo esc_html( travel_aja_v2_ui_text( $dt_key ) ); ?></dt>
									<dd><?php echo esc_html( travel_aja_v2_ui_text( $dt_value ) ); ?></dd>
									</div>
								<?php endforeach; ?>
							</dl>
						<?php endif; ?>

						<?php if ( $dt_wa_href ) : ?>
							<a class="dt-cta" href="<?php echo esc_url( $dt_wa_href ); ?>" target="_blank" rel="noopener noreferrer">◉ <?php esc_html_e( 'Tanya via WhatsApp', 'custom-theme-v2' ); ?></a>
						<?php endif; ?>
						<a class="dt-cta dt-cta--ghost" href="<?php echo esc_url( $dt_back['url'] ); ?>"><?php echo esc_html( $dt_back['label'] ); ?> →</a>
					</div>
				</aside>
			</div>

			<nav class="single-post-nav" aria-label="<?php esc_attr_e( 'Item lainnya', 'custom-theme-v2' ); ?>">
				<div class="single-post-nav__cell<?php echo $dt_prev ? '' : ' is-empty'; ?>">
					<?php if ( $dt_prev ) : ?>
						<span class="single-post-nav__eyebrow">← <?php esc_html_e( 'Sebelumnya', 'custom-theme-v2' ); ?></span>
						<a href="<?php echo esc_url( (string) get_permalink( $dt_prev ) ); ?>"><?php echo esc_html( get_the_title( $dt_prev ) ); ?></a>
					<?php endif; ?>
				</div>
				<div class="single-post-nav__cell single-post-nav__cell--all">
					<span class="single-post-nav__eyebrow"><?php esc_html_e( 'Kembali ke daftar', 'custom-theme-v2' ); ?></span>
					<a href="<?php echo esc_url( $dt_back['url'] ); ?>"><?php echo esc_html( $dt_back['label'] ); ?> →</a>
				</div>
				<div class="single-post-nav__cell<?php echo $dt_next ? '' : ' is-empty'; ?>">
					<?php if ( $dt_next ) : ?>
						<span class="single-post-nav__eyebrow"><?php esc_html_e( 'Berikutnya', 'custom-theme-v2' ); ?> →</span>
						<a href="<?php echo esc_url( (string) get_permalink( $dt_next ) ); ?>"><?php echo esc_html( get_the_title( $dt_next ) ); ?></a>
					<?php endif; ?>
				</div>
			</nav>
		</div>
	</main>
	<?php
endwhile;
