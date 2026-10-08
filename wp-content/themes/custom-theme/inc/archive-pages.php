<?php
/** Komponen halaman daftar Paket Wisata, Destinasi, dan Transportasi. */

function custom_theme_listing_config( $post_type ) {
	$configs = array(
		'paket_wisata' => array(
			'slug'        => 'paket-wisata',
			'label'       => 'Paket Wisata Indonesia',
			'title'       => 'Temukan Paket Wisata Indonesia',
			'description' => 'Jelajahi berbagai destinasi di Indonesia melalui perjalanan yang dirancang sesuai waktu, minat, dan gaya perjalananmu.',
			'placeholder' => 'Cari paket wisata atau destinasi...',
			'count'       => 'Paket Wisata',
			'cta_title'   => 'Punya rencana sendiri?',
			'cta_text'    => 'Diskusikan kebutuhan perjalananmu bersama Travel Aja dan kami bantu memilih perjalanan yang sesuai.',
		),
		'destinasi' => array(
			'slug'        => 'destinasi',
			'label'       => 'Explore Destinasi',
			'title'       => 'Jelajahi Destinasi Indonesia',
			'description' => 'Temukan beragam destinasi di Indonesia, dari gunung dan kawah hingga pantai, pulau, hutan, budaya, dan berbagai pengalaman petualangan.',
			'placeholder' => 'Cari destinasi wisata...',
			'count'       => 'Destinasi',
			'cta_title'   => 'Sudah menemukan destinasi pilihanmu?',
			'cta_text'    => 'Rencanakan perjalananmu bersama Travel Aja. Kami siap membantu menyesuaikan perjalanan dengan waktu, minat, dan kebutuhanmu.',
		),
		'transportasi' => array(
			'slug'        => 'transportasi',
			'label'       => 'Transportasi Wisata',
			'title'       => 'Sewa Kendaraan untuk Menjelajahi Indonesia',
			'description' => 'Temukan pilihan motor, mobil, dan layanan kendaraan dengan pengemudi untuk membantu perjalanan Anda di berbagai destinasi Indonesia.',
			'placeholder' => 'Cari kendaraan atau tipe transportasi...',
			'count'       => 'Pilihan Transportasi',
			'cta_title'   => 'Butuh transportasi untuk perjalanan Anda?',
			'cta_text'    => 'Diskusikan kebutuhan kendaraan Anda bersama Travel Aja dan pilih opsi transportasi yang paling sesuai.',
		),
	);
	return isset( $configs[ $post_type ] ) ? $configs[ $post_type ] : $configs['paket_wisata'];
}

function custom_theme_listing_url( $post_type ) {
	$config = custom_theme_listing_config( $post_type );
	$page   = get_page_by_path( $config['slug'] );
	if ( $page instanceof WP_Post && 'publish' === $page->post_status ) {
		return get_permalink( $page );
	}
	$archive = get_post_type_archive_link( $post_type );
	return $archive ? $archive : home_url( '/' );
}

/** Present legacy regional article categories under the current site focus. */
function custom_theme_guide_category_label( $label ) {
	if ( stripos( (string) $label, 'Banyuwangi' ) !== false ) {
		return 'Jelajah Indonesia';
	}
	if ( 0 === strcasecmp( trim( (string) $label ), 'culinary' ) ) {
		return 'Kuliner';
	}
	return (string) $label;
}

/** Use broad Indonesian destination wording in guide listings. */
function custom_theme_guide_public_text( $text ) {
	$text = preg_replace( '/Banyuwangi\s+Jawa Timur/i', 'Jawa Timur', (string) $text );
	$text = preg_replace( '/Banyuwangi\s+East Java/i', 'East Java', $text );
	return str_ireplace( 'Banyuwangi', 'Indonesia', $text );
}

/** Collapse legacy regional categories that share the same public label. */
function custom_theme_guide_display_categories( $categories ) {
	$display_categories = array();
	$labels             = array();

	foreach ( $categories as $category ) {
		$label = custom_theme_guide_category_label( $category->name );
		if ( isset( $labels[ $label ] ) ) {
			$display_categories[ $labels[ $label ] ]['count'] += (int) $category->count;
			continue;
		}

		$labels[ $label ] = count( $display_categories );
		$display_categories[] = array(
			'id'    => (int) $category->term_id,
			'label' => $label,
			'count' => (int) $category->count,
		);
	}

	return $display_categories;
}

function custom_theme_listing_hero_image() {
	$front_id = (int) get_option( 'page_on_front' );
	return $front_id && has_post_thumbnail( $front_id ) ? get_the_post_thumbnail_url( $front_id, 'full' ) : '';
}

function custom_theme_request_value( $key, $default = '' ) {
	if ( ! isset( $_GET[ $key ] ) || ! is_string( $_GET[ $key ] ) ) {
		return $default;
	}
	return sanitize_text_field( wp_unslash( $_GET[ $key ] ) );
}

function custom_theme_listing_query( $post_type ) {
	$paged = max( 1, (int) get_query_var( 'paged' ), (int) get_query_var( 'page' ) );
	$args  = array(
		'post_type'      => $post_type,
		'post_status'    => 'publish',
		'posts_per_page' => 9,
		'paged'          => $paged,
		's'              => custom_theme_request_value( 'travel_q' ),
	);
	$sort = custom_theme_request_value( 'travel_sort', 'latest' );
	if ( 'title' === $sort ) {
		$args['orderby'] = 'title';
		$args['order']   = 'ASC';
	} elseif ( in_array( $sort, array( 'price_low', 'price_high' ), true ) && in_array( $post_type, array( 'paket_wisata', 'transportasi' ), true ) ) {
		$args['meta_key'] = 'paket_wisata' === $post_type ? '_custom_theme_package_price' : '_custom_theme_transport_price';
		$args['orderby']  = 'meta_value_num';
		$args['order']    = 'price_high' === $sort ? 'DESC' : 'ASC';
	} else {
		$args['orderby'] = 'date';
		$args['order']   = 'DESC';
	}

	$meta_query = array();
	$type       = custom_theme_request_value( 'travel_type' );
	if ( $type ) {
		$key = 'paket_wisata' === $post_type ? '_custom_theme_package_duration' : ( 'destinasi' === $post_type ? '_custom_theme_destination_category' : '_custom_theme_transport_type' );
		$meta_query[] = array( 'key' => $key, 'value' => $type, 'compare' => 'LIKE' );
	}
	$budget = custom_theme_request_value( 'travel_budget' );
	if ( $budget && in_array( $post_type, array( 'paket_wisata', 'transportasi' ), true ) ) {
		$bands = array(
			'under-250' => array( 0, 250000 ),
			'250-500'   => array( 250000, 500000 ),
			'500-1000'  => array( 500000, 1000000 ),
			'above-1000'=> array( 1000000, 999999999 ),
		);
		if ( isset( $bands[ $budget ] ) ) {
			$meta_query[] = array(
				'key'     => 'paket_wisata' === $post_type ? '_custom_theme_package_price' : '_custom_theme_transport_price',
				'value'   => $bands[ $budget ],
				'type'    => 'NUMERIC',
				'compare' => 'BETWEEN',
			);
		}
	}
	if ( $meta_query ) {
		$args['meta_query'] = $meta_query;
	}
	return new WP_Query( $args );
}

function custom_theme_listing_badge( $post_id, $post_type ) {
	if ( 'paket_wisata' === $post_type ) {
		return custom_theme_card_badge( $post_id, 'package' );
	}
	if ( 'destinasi' === $post_type ) {
		return custom_theme_card_badge( $post_id, 'destination' );
	}
	return get_post_meta( $post_id, '_custom_theme_transport_type', true ) ? 'recommended' : '';
}

function custom_theme_render_listing_card( $post_type ) {
	$post_id = get_the_ID();
	$badge   = custom_theme_listing_badge( $post_id, $post_type );
	$labels  = custom_theme_badge_options();
	?>
	<article <?php post_class( 'listing-card listing-card--' . $post_type ); ?>>
		<a class="listing-card__image" href="<?php the_permalink(); ?>">
			<?php if ( has_post_thumbnail() ) : the_post_thumbnail( 'medium_large' ); else : ?><span class="listing-card__placeholder" aria-hidden="true">✦</span><?php endif; ?>
			<?php if ( $badge ) : ?><span class="listing-card__badge card-badge--<?php echo esc_attr( $badge ); ?>"><?php echo esc_html( isset( $labels[ $badge ] ) ? $labels[ $badge ] : $badge ); ?></span><?php endif; ?>
		</a>
		<div class="listing-card__body">
			<?php if ( 'paket_wisata' === $post_type ) :
				$location = get_post_meta( $post_id, '_custom_theme_package_location', true );
				$rating   = get_post_meta( $post_id, '_custom_theme_package_rating', true );
				$duration = get_post_meta( $post_id, '_custom_theme_package_duration', true );
				$price    = get_post_meta( $post_id, '_custom_theme_package_price', true ); ?>
				<?php if ( $location ) : ?><span class="listing-card__eyebrow">● <?php echo esc_html( $location ); ?></span><?php endif; ?>
				<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				<?php if ( $rating ) : ?><div class="listing-card__rating">★ <?php echo esc_html( number_format( (float) $rating, 1 ) ); ?></div><?php endif; ?>
				<div class="listing-card__facts"><span>◷ <?php echo esc_html( $duration ?: 'Durasi fleksibel' ); ?></span><span>● <?php echo esc_html( $location ?: 'Indonesia' ); ?></span></div>
				<div class="listing-card__footer"><span><small>Mulai dari</small><strong><?php echo $price ? esc_html( 'Rp ' . number_format_i18n( (float) $price ) ) : 'Hubungi Kami'; ?></strong><?php if ( $price ) : ?><small>/pax</small><?php endif; ?></span><a href="<?php the_permalink(); ?>">Lihat Detail</a></div>
			<?php elseif ( 'destinasi' === $post_type ) :
				$location   = get_post_meta( $post_id, '_custom_theme_destination_location', true );
				$rating     = get_post_meta( $post_id, '_custom_theme_destination_rating', true );
				$category   = get_post_meta( $post_id, '_custom_theme_destination_category', true );
				$highlights = array_filter( array_map( 'trim', explode( ',', (string) get_post_meta( $post_id, '_custom_theme_destination_highlights', true ) ) ) ); ?>
				<div class="listing-card__meta"><span class="listing-card__eyebrow">● <?php echo esc_html( $location ?: 'Indonesia' ); ?></span><?php if ( $category ) : ?><span><?php echo esc_html( $category ); ?></span><?php endif; ?></div>
				<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				<?php if ( $rating ) : ?><div class="listing-card__rating">★ <?php echo esc_html( number_format( (float) $rating, 1 ) ); ?></div><?php endif; ?>
				<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 16 ) ); ?></p>
				<?php if ( $highlights ) : ?><div class="listing-card__highlights"><?php foreach ( array_slice( $highlights, 0, 3 ) as $item ) : ?><span>✦ <?php echo esc_html( $item ); ?></span><?php endforeach; ?></div><?php endif; ?>
				<a class="listing-card__wide-button" href="<?php the_permalink(); ?>">Lihat Destinasi</a>
			<?php else :
				$type         = get_post_meta( $post_id, '_custom_theme_transport_type', true );
				$capacity     = get_post_meta( $post_id, '_custom_theme_transport_capacity', true );
				$transmission = get_post_meta( $post_id, '_custom_theme_transport_transmission', true );
				$model        = get_post_meta( $post_id, '_custom_theme_transport_model', true );
				$price        = get_post_meta( $post_id, '_custom_theme_transport_price', true );
				$unit         = get_post_meta( $post_id, '_custom_theme_transport_unit', true ); ?>
				<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				<div class="listing-card__facts"><span>♟ <?php echo esc_html( $capacity ?: 'Kapasitas fleksibel' ); ?></span><span>⚙ <?php echo esc_html( $transmission ?: 'Sesuai pilihan' ); ?></span><?php if ( $model ) : ?><span>▰ <?php echo esc_html( $model ); ?></span><?php endif; ?></div>
				<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 13 ) ); ?></p>
				<div class="listing-card__footer"><span><small>Harga Sewa</small><strong><?php echo $price ? esc_html( 'Rp ' . number_format_i18n( (float) $price ) ) : 'Hubungi Kami'; ?></strong><?php if ( $price && $unit ) : ?><small>/<?php echo esc_html( $unit ); ?></small><?php endif; ?></span><a href="<?php the_permalink(); ?>">Lihat Detail</a></div>
			<?php endif; ?>
		</div>
	</article>
	<?php
}

function custom_theme_render_listing_sidebar( $post_type ) {
	$type_options = array(
		'paket_wisata' => array( '1 Day', '2D1N', '3D2N', '4D3N' ),
		'destinasi'    => array( 'Air Terjun', 'Budaya', 'Gunung & Kawah', 'Hutan & Alam', 'Pantai', 'Petualangan', 'Pulau', 'Sejarah' ),
		'transportasi' => array( 'Sewa Motor', 'Sewa Mobil', 'Mobil + Driver' ),
	);
	$active_type   = custom_theme_request_value( 'travel_type' );
	$active_budget = custom_theme_request_value( 'travel_budget' );
	?>
	<form class="listing-filter" method="get" action="<?php echo esc_url( custom_theme_listing_url( $post_type ) ); ?>">
		<?php if ( custom_theme_request_value( 'travel_q' ) ) : ?><input type="hidden" name="travel_q" value="<?php echo esc_attr( custom_theme_request_value( 'travel_q' ) ); ?>"><?php endif; ?>
		<fieldset><legend><?php echo 'paket_wisata' === $post_type ? 'Durasi Perjalanan' : ( 'destinasi' === $post_type ? 'Kategori' : 'Jenis Transportasi' ); ?></legend>
			<?php foreach ( $type_options[ $post_type ] as $option ) : ?><label><input type="radio" name="travel_type" value="<?php echo esc_attr( $option ); ?>" <?php checked( $active_type, $option ); ?>> <?php echo esc_html( $option ); ?></label><?php endforeach; ?>
		</fieldset>
		<?php if ( 'destinasi' !== $post_type ) : ?><fieldset><legend>Rentang Harga</legend>
			<?php foreach ( array( 'under-250' => 'Di bawah Rp 250rb', '250-500' => 'Rp 250rb – Rp 500rb', '500-1000' => 'Rp 500rb – Rp 1 Juta', 'above-1000' => 'Di atas Rp 1 Juta' ) as $value => $label ) : ?><label><input type="radio" name="travel_budget" value="<?php echo esc_attr( $value ); ?>" <?php checked( $active_budget, $value ); ?>> <?php echo esc_html( $label ); ?></label><?php endforeach; ?>
		</fieldset><?php endif; ?>
		<button type="submit">Terapkan Filter</button>
		<a href="<?php echo esc_url( custom_theme_listing_url( $post_type ) ); ?>">Reset Filter</a>
	</form>
	<?php
}

function custom_theme_render_listing_page( $post_type ) {
	$config     = custom_theme_listing_config( $post_type );
	$query      = custom_theme_listing_query( $post_type );
	$hero_image = custom_theme_listing_hero_image();
	$whatsapp   = preg_replace( '/\D/', '', get_theme_mod( 'travel_whatsapp', '' ) );
	get_header();
	?>
	<main id="main-content" class="listing-page">
		<section class="travel-page-hero"<?php if ( $hero_image ) : ?> style="--travel-hero-image:url('<?php echo esc_url( $hero_image ); ?>')"<?php endif; ?>>
			<div class="container travel-page-hero__inner"><span><?php echo esc_html( $config['label'] ); ?></span><h1><?php echo esc_html( $config['title'] ); ?></h1><p><?php echo esc_html( $config['description'] ); ?></p>
				<form class="travel-page-search" method="get" action="<?php echo esc_url( custom_theme_listing_url( $post_type ) ); ?>"><input type="search" name="travel_q" value="<?php echo esc_attr( custom_theme_request_value( 'travel_q' ) ); ?>" placeholder="<?php echo esc_attr( $config['placeholder'] ); ?>"><button type="submit">Cari</button></form>
			</div>
		</section>
		<section class="listing-results"><div class="container listing-layout">
			<aside><?php custom_theme_render_listing_sidebar( $post_type ); ?></aside>
			<div class="listing-main">
				<div class="listing-toolbar"><p>Menampilkan <strong><?php echo esc_html( (string) $query->found_posts ); ?> <?php echo esc_html( $config['count'] ); ?></strong></p><form method="get" action="<?php echo esc_url( custom_theme_listing_url( $post_type ) ); ?>"><?php foreach ( array( 'travel_q', 'travel_type', 'travel_budget' ) as $key ) : if ( custom_theme_request_value( $key ) ) : ?><input type="hidden" name="<?php echo esc_attr( $key ); ?>" value="<?php echo esc_attr( custom_theme_request_value( $key ) ); ?>"><?php endif; endforeach; ?><label>Urutkan: <select name="travel_sort" onchange="this.form.submit()"><option value="latest" <?php selected( custom_theme_request_value( 'travel_sort', 'latest' ), 'latest' ); ?>>Terbaru</option><option value="title" <?php selected( custom_theme_request_value( 'travel_sort' ), 'title' ); ?>>Nama A–Z</option><?php if ( 'destinasi' !== $post_type ) : ?><option value="price_low" <?php selected( custom_theme_request_value( 'travel_sort' ), 'price_low' ); ?>>Harga Terendah</option><option value="price_high" <?php selected( custom_theme_request_value( 'travel_sort' ), 'price_high' ); ?>>Harga Tertinggi</option><?php endif; ?></select></label></form></div>
				<?php if ( $query->have_posts() ) : ?><div class="listing-grid"><?php while ( $query->have_posts() ) : $query->the_post(); custom_theme_render_listing_card( $post_type ); endwhile; ?></div><?php else : ?><div class="listing-empty"><h2>Konten belum ditemukan</h2><p>Coba kata kunci atau filter lain. Konten baru dapat ditambahkan dari wp-admin.</p></div><?php endif; ?>
				<?php if ( $query->max_num_pages > 1 ) : ?><nav class="listing-pagination" aria-label="Navigasi halaman"><?php echo wp_kses_post( paginate_links( array( 'total' => $query->max_num_pages, 'current' => max( 1, (int) get_query_var( 'paged' ), (int) get_query_var( 'page' ) ) ) ) ); ?></nav><?php endif; wp_reset_postdata(); ?>
				<div class="listing-cta"><div><h2><?php echo esc_html( $config['cta_title'] ); ?></h2><p><?php echo esc_html( $config['cta_text'] ); ?></p></div><?php if ( $whatsapp ) : ?><a href="<?php echo esc_url( 'https://wa.me/' . $whatsapp ); ?>" target="_blank" rel="noopener noreferrer">◉ Hubungi via WhatsApp</a><?php else : ?><a href="<?php echo esc_url( home_url( '/kontak-kami/' ) ); ?>">Hubungi Kami</a><?php endif; ?></div>
			</div>
		</div></section>
	</main>
	<?php get_footer();
}
