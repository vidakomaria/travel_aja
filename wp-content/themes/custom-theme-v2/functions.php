<?php
/**
 * Setup Custom Theme 2.
 *
 * Semua tipe konten dan field tetap disediakan oleh tema induk agar data yang
 * sudah dimasukkan melalui wp-admin dapat langsung digunakan.
 *
 * @package Custom_Theme_V2
 */

add_action(
	'wp_enqueue_scripts',
	function () {
		$css_path = get_stylesheet_directory() . '/assets/css/v2.css';
		$js_path  = get_stylesheet_directory() . '/assets/js/v2.js';

		wp_enqueue_style(
			'custom-theme-v2',
			get_stylesheet_directory_uri() . '/assets/css/v2.css',
			array( 'custom-theme-pages' ),
			(string) filemtime( $css_path )
		);

		wp_enqueue_script(
			'custom-theme-v2',
			get_stylesheet_directory_uri() . '/assets/js/v2.js',
			array(),
			(string) filemtime( $js_path ),
			true
		);
	},
	30
);

add_filter(
	'body_class',
	function ( $classes ) {
		$classes[] = 'travel-aja-v2';
		return $classes;
	}
);

add_action(
	'customize_register',
	function ( $customizer ) {
		$customizer->add_section(
			'travel_v2_home',
			array(
				'title'       => __( 'Beranda Custom Theme 2', 'custom-theme-v2' ),
				'description' => __( 'Teks utama yang tampil pada hero beranda.', 'custom-theme-v2' ),
				'priority'    => 34,
			)
		);

		$fields = array(
			'travel_v2_hero_kicker' => array(
				'label'   => __( 'Teks kecil hero', 'custom-theme-v2' ),
				'default' => 'Paket wisata dan sewa kendaraan di Bali',
				'type'    => 'text',
			),
			'travel_v2_hero_title' => array(
				'label'   => __( 'Judul hero', 'custom-theme-v2' ),
				'default' => 'Liburan Bali jadi lebih mudah',
				'type'    => 'text',
			),
			'travel_v2_hero_description' => array(
				'label'   => __( 'Deskripsi hero', 'custom-theme-v2' ),
				'default' => 'Temukan paket perjalanan pilihan dan kendaraan yang siap menemani setiap rute liburan Anda di Bali.',
				'type'    => 'textarea',
			),
		);

		foreach ( $fields as $key => $field ) {
			$customizer->add_setting(
				$key,
				array(
					'default'           => $field['default'],
					'sanitize_callback' => 'sanitize_text_field',
				)
			);
			$customizer->add_control(
				$key,
				array(
					'label'   => $field['label'],
					'section' => 'travel_v2_home',
					'type'    => $field['type'],
				)
			);
		}
	}
);

/**
 * Find a published page by slug and return a safe fallback URL.
 */
function travel_aja_v2_page_url( $slug, $fallback = '/' ) {
	$page = get_page_by_path( $slug );
	if ( $page instanceof WP_Post && 'publish' === $page->post_status ) {
		return get_permalink( $page );
	}
	return home_url( $fallback );
}

/**
 * Format a price saved as an integer in post meta.
 */
function travel_aja_v2_price( $price, $fallback = 'Hubungi kami' ) {
	if ( '' === trim( (string) $price ) || ! is_numeric( $price ) ) {
		return $fallback;
	}
	return 'Rp ' . number_format( (float) $price, 0, ',', '.' );
}

