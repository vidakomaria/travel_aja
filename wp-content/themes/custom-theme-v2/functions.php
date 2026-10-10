<?php
/**
 * Setup Custom Theme 2.
 *
 * Tipe konten disediakan oleh plugin Travel Aja Content Types; field dan query
 * dasarnya berasal dari tema induk.
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

		// Layout "eksplorasi": arsip panduan wisata + halaman tentang kami.
		$explore_path = get_stylesheet_directory() . '/assets/css/v2-explore.css';
		$explore_js   = get_stylesheet_directory() . '/assets/js/v2-explore.js';

		wp_enqueue_style(
			'custom-theme-v2-explore',
			get_stylesheet_directory_uri() . '/assets/css/v2-explore.css',
			array( 'custom-theme-v2' ),
			(string) filemtime( $explore_path )
		);

		wp_enqueue_script(
			'custom-theme-v2-explore',
			get_stylesheet_directory_uri() . '/assets/js/v2-explore.js',
			array(),
			(string) filemtime( $explore_js ),
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
				'default' => 'Paket wisata dan sewa kendaraan di Indonesia',
				'type'    => 'text',
			),
			'travel_v2_hero_title' => array(
				'label'   => __( 'Judul hero', 'custom-theme-v2' ),
				'default' => 'Jelajahi Indonesia dengan lebih mudah',
				'type'    => 'text',
			),
			'travel_v2_hero_description' => array(
				'label'   => __( 'Deskripsi hero', 'custom-theme-v2' ),
				'default' => 'Temukan paket perjalanan pilihan dan kendaraan yang siap menemani rute liburan Anda.',
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
 * Resolve a post to its translation in the active Polylang language.
 * Returns 0 when that translation has not been created yet.
 */
function travel_aja_v2_translated_post_id( $post_id, $language = '' ) {
	$post_id = (int) $post_id;
	if ( ! $post_id || ! function_exists( 'pll_get_post' ) || ! function_exists( 'pll_current_language' ) ) {
		return 0;
	}

	$language = $language ? $language : pll_current_language();
	if ( ! $language ) {
		return 0;
	}

	return (int) pll_get_post( $post_id, $language );
}

/**
 * Find a published page by slug and return its active-language URL.
 */
function travel_aja_v2_page_url( $slug, $fallback = '/' ) {
	$page = get_page_by_path( $slug, OBJECT, 'page' );
	if ( $page instanceof WP_Post && 'publish' === $page->post_status ) {
		$page_id = (int) $page->ID;
		if ( function_exists( 'pll_current_language' ) && function_exists( 'pll_get_post' ) ) {
			$translated_id = travel_aja_v2_translated_post_id( $page_id );
			if ( $translated_id ) {
				$page_id = $translated_id;
			} elseif ( pll_current_language() !== pll_default_language() ) {
				// Never send visitors to a page in another language just because its
				// translation has not been created yet.
				return function_exists( 'pll_home_url' ) ? pll_home_url() : home_url( '/' );
			}
		}
		return get_permalink( $page_id );
	}

	if ( function_exists( 'pll_current_language' ) && function_exists( 'pll_home_url' ) && pll_current_language() !== pll_default_language() ) {
		return pll_home_url();
	}
	return home_url( $fallback );
}

/**
 * Menus can contain links to the default-language page even when an English
 * menu exists. Resolve those page items through Polylang before rendering.
 */
add_filter(
	'wp_nav_menu_objects',
	function ( $items ) {
		if ( ! function_exists( 'pll_current_language' ) || ! function_exists( 'pll_get_post' ) ) {
			return $items;
		}

		$language = pll_current_language();
		if ( ! $language || $language === pll_default_language() ) {
			return $items;
		}

		foreach ( $items as $item ) {
			if ( 'post_type' !== $item->type || 'page' !== $item->object || empty( $item->object_id ) ) {
				continue;
			}

			$translated_id = travel_aja_v2_translated_post_id( $item->object_id, $language );
			if ( $translated_id ) {
				$item->object_id = $translated_id;
				$item->url       = get_permalink( $translated_id );
				continue;
			}

			$source_page = get_post( (int) $item->object_id );
			if ( $source_page instanceof WP_Post ) {
				$listing_types = array(
					'destinasi'    => 'destinasi',
					'paket-wisata' => 'paket_wisata',
					'transportasi' => 'transportasi',
				);
				if ( isset( $listing_types[ $source_page->post_name ] ) && function_exists( 'custom_theme_listing_url' ) ) {
					$item->url = custom_theme_listing_url( $listing_types[ $source_page->post_name ] );
				} else {
					// A missing translation must not silently switch the visitor back
					// to the default-language page.
					$item->url = function_exists( 'pll_home_url' ) ? pll_home_url( $language ) : home_url( '/' );
				}
			}
		}

		return $items;
	},
	20
);

/**
 * Format a price saved as an integer in post meta.
 */
function travel_aja_v2_price( $price, $fallback = 'Hubungi kami' ) {
	if ( '' === trim( (string) $price ) || ! is_numeric( $price ) ) {
		return function_exists( 'travel_aja_v2_ui_text' ) ? travel_aja_v2_ui_text( $fallback ) : $fallback;
	}
	return 'Rp ' . number_format( (float) $price, 0, ',', '.' );
}

/**
 * Terjemahan antarmuka tema ke bahasa Inggris.
 *
 * WordPress sengaja tidak memuat berkas .mo untuk locale en_US, jadi terjemahan
 * gettext biasa tidak akan pernah aktif di sini. Peta ini diterapkan lewat filter
 * `gettext` hanya ketika bahasa aktif Inggris dan hanya di sisi depan.
 *
 * @return array<string,string>
 */
function travel_aja_v2_ui_translations() {
	static $map = null;

	if ( null === $map ) {
		$map = array(
			'% Komentar' => '% comments',
			'% komentar' => '% comments',
			'1 Komentar' => '1 Comment',
			'1 komentar' => '1 comment',
			'Aktivitas unggulan' => 'Featured activities',
			'Alamat email Anda tidak akan dipublikasikan. Kolom bertanda * wajib diisi.' => 'Your email address will not be published. Required fields are marked *.',
			'Artikel & Tips' => 'Articles & Tips',
			'Artikel & Tips Wisata Indonesia' => 'Articles & Tips on Indonesian Travel',
			'Artikel berikutnya' => 'Next article',
			'Artikel lainnya' => 'Other articles',
			'Artikel sebelumnya' => 'Previous article',
			'Baca Panduan →' => 'Read Guide →',
			'Baca Selengkapnya' => 'Read more',
			'Baca artikel' => 'Read article',
			'Baca panduan' => 'Read guide',
			'Bagikan pertanyaan atau pengalaman Anda. Komentar yang masuk mengikuti pengaturan moderasi WordPress.' => 'Share your question or experience. Submitted comments follow the WordPress moderation settings.',
			'Bantuan cepat' => 'Quick help',
			'Bebas menjelajah' => 'Freedom to explore',
			'Belum ada komentar' => 'No comments yet',
			'Belum ada konten' => 'No content yet',
			'Belum ada konten %s. Tambahkan dari wp-admin agar bagian ini terisi.' => 'No %s content yet. Add some from wp-admin to fill this section.',
			'Belum ada panduan' => 'No guides yet',
			'Beranda Custom Theme 2' => 'Custom Theme 2 Homepage',
			'Berikutnya' => 'Next',
			'Buka navigasi' => 'Open navigation',
			'Butuh itinerary khusus?' => 'Need a custom itinerary?',
			'Cari' => 'Search',
			'Cari destinasi, paket wisata, atau artikel' => 'Search destinations, tour packages or articles',
			'Cari panduan perjalanan...' => 'Search travel guides...',
			'Ceritakan kebutuhan perjalanan Anda. Tim kami akan membantu memilih paket dan kendaraan yang paling sesuai.' => 'Tell us what your trip needs. Our team will help you choose the best package and vehicle.',
			'Coba kata kunci lain untuk mencari destinasi, paket wisata, atau artikel.' => 'Try another keyword to search destinations, tour packages or articles.',
			'Contoh: 1 Day' => 'Example: 1 Day',
			'Contoh: Indonesia' => 'Example: Indonesia',
			'Deskripsi hero' => 'Hero description',
			'Destinasi untuk Dijelajahi' => 'Destinations to Explore',
			'Detail Kartu Destinasi' => 'Destination card details',
			'Detail Kartu Paket Wisata' => 'Tour package card details',
			'Detail biaya ditampilkan sejak awal.' => 'All costs are shown upfront.',
			'Diskusi Pengunjung' => 'Visitor Discussion',
			'Durasi' => 'Duration',
			'Filter Kategori' => 'Filter by Category',
			'Filter kategori' => 'Filter by category',
			'Gambar berikutnya' => 'Next image',
			'Gambar sebelumnya' => 'Previous image',
			'Halaman: ' => 'Page: ',
			'Harga mulai dari (Rupiah per orang)' => 'Starting price (Rupiah per person)',
			'Harga transparan' => 'Transparent pricing',
			'Hasil pencarian: %s' => 'Search results: %s',
			'Hubungi Kami' => 'Contact Us',
			'Hubungi Kami ↗' => 'Contact Us ↗',
			'Hubungi kami' => 'Contact us',
			'Inspirasi perjalanan' => 'Travel inspiration',
			'Isi berdasarkan rating yang Anda miliki; kosongkan jika belum ada.' => 'Fill in based on the rating you have; leave blank if there is none yet.',
			'Item lainnya' => 'Other items',
			'Jam layanan' => 'Service hours',
			'Jelajah' => 'Explore',
			'Jelajahi Banyuwangi bersama kami' => 'Explore Banyuwangi with us',
			'Jelajahi tempat menarik untuk perjalanan berikutnya.' => 'Explore great places for your next trip.',
			'Judul hero' => 'Hero title',
			'Kategori' => 'Category',
			'Kategori Panduan' => 'Guide Categories',
			'Kategori panduan' => 'Guide categories',
			'Gunung Bromo' => 'Mount Bromo',
			'Kebijakan Privasi' => 'Privacy Policy',
			'Kembali ke' => 'Back to',
			'Kembali ke daftar' => 'Back to list',
			'Keunggulan layanan' => 'Why choose us',
			'Kirim Komentar' => 'Post Comment',
			'Komentar *' => 'Comment *',
			'Komentar berikutnya →' => 'Next comments →',
			'Komentar untuk konten ini sudah ditutup.' => 'Comments for this content are closed.',
			'Konsultasi Sekarang' => 'Chat with us now',
			'Konsultasi via WhatsApp' => 'Chat on WhatsApp',
			'Konten Beranda' => 'Homepage content',
			'Lencana' => 'Badge',
			'Lewati ke konten' => 'Skip to content',
			'Lihat Detail' => 'View details',
			'Lihat Paket Wisata' => 'Browse tour packages',
			'Lihat kontak' => 'View contact',
			'Lihat paket wisata' => 'See tour packages',
			'Lihat semua artikel' => 'See all articles',
			'Lihat semua kendaraan' => 'See all vehicles',
			'Lihat semua paket' => 'See all packages',
			'Lokasi' => 'Location',
			'MULAI DARI' => 'STARTING FROM',
			'Masukkan angka tanpa titik atau simbol Rp.' => 'Enter numbers only, without dots or the Rp symbol.',
			'Mau menjelajahi ke mana?' => 'Where do you want to go?',
			'Motor dan mobil pilihan untuk perjalanan harian, liburan keluarga, atau rute khusus di destinasi pilihan Anda.' => 'Selected motorbikes and cars for daily trips, family holidays or custom routes in your chosen destination.',
			'Mulai dari' => 'Starting from',
			'Nama' => 'Name',
			'Navigasi Utama' => 'Primary navigation',
			'Navigasi artikel' => 'Article navigation',
			'Navigasi item' => 'Item navigation',
			'Navigasi utama' => 'Primary navigation',
			'Oleh' => 'By',
			'Paket Wisata' => 'Tour packages',
			'Paket Wisata Pilihan' => 'Featured Tour Packages',
			'Paket dan kendaraan dipilih untuk kebutuhan liburan.' => 'Packages and vehicles chosen for your holiday needs.',
			'Paket wisata dan kendaraan pilihan untuk perjalanan yang lebih praktis, nyaman, dan berkesan.' => 'Selected tour packages and vehicles for a more practical, comfortable and memorable trip.',
			'Panduan Populer' => 'Popular Guides',
			'Panduan Terbaru' => 'Latest Guides',
			'Panduan Wisata' => 'Travel Guide',
			'Peta Panduan' => 'Guide Map',
			'Pilih bahasa' => 'Choose language',
			'Pilih paket wisata, destinasi, dan transportasi untuk perjalanan Anda.' => 'Choose tour packages, destinations and transport for your trip.',
			'Pilih pengalaman terbaik dari berbagai destinasi di Indonesia dengan perjalanan yang disusun agar liburan lebih praktis.' => 'Pick the best experiences across destinations in Indonesia, with trips planned to make your holiday easier.',
			'Pilih perjalanan berdasarkan destinasi dan pengalaman yang Anda inginkan.' => 'Pick a trip based on the destination and experience you want.',
			'Pilihan perjalanan' => 'Trip options',
			'Pilihan terkurasi' => 'Curated selection',
			'Pisahkan setiap aktivitas dengan koma.' => 'Separate each activity with a comma.',
			'Populer' => 'Popular',
			'Rating %s dari 5' => 'Rating %s out of 5',
			'Rating (0–5)' => 'Rating (0–5)',
			'Rekomendasi' => 'Recommended',
			'Rencanakan perjalanan Anda' => 'Plan your trip',
			'Sampaikan rencana perjalanan Anda, tim kami bantu susun rutenya.' => 'Tell us your travel plans and our team will help arrange the route.',
			'Sebelumnya' => 'Previous',
			'Seluruh hak cipta dilindungi.' => 'All rights reserved.',
			'Semua' => 'All',
			'Sewa Kendaraan' => 'Vehicle Rental',
			'Siap menjelajahi Indonesia?' => 'Ready to explore Indonesia?',
			'Sudah Siap Merencanakan Perjalanan?' => 'Ready to Plan Your Trip?',
			'Tambahkan Komentar' => 'Leave a Comment',
			'Tambahkan Paket Wisata dari wp-admin agar bagian ini terisi.' => 'Add Tour Packages from wp-admin to fill this section.',
			'Tambahkan Pos dari wp-admin agar bagian artikel terisi.' => 'Add Posts from wp-admin to fill the article section.',
			'Tambahkan Transportasi dari wp-admin agar bagian ini terisi.' => 'Add Transportation from wp-admin to fill this section.',
			'Tambahkan artikel melalui menu Posts di wp-admin.' => 'Add articles from the Posts menu in wp-admin.',
			'Tambahkan konten dari wp-admin untuk melihatnya di sini.' => 'Add content from wp-admin to see it here.',
			'Tanpa lencana' => 'No badge',
			'Tanya via WhatsApp' => 'Ask via WhatsApp',
			'Teks kecil hero' => 'Hero small text',
			'Teks utama yang tampil pada hero beranda.' => 'The main text shown on the homepage hero.',
			'Telusuri rute belajar: tips perjalanan, panduan destinasi, rekomendasi aktivitas, hingga informasi praktis untuk menjelajahi Indonesia.' => 'Follow the route: travel tips, destination guides, activity ideas and practical information for exploring Indonesia.',
			'Temukan inspirasi destinasi dan panduan perjalanan dalam bahasa Indonesia.' => 'Find destination inspiration and travel guides in Indonesian.',
			'Temukan paket wisata yang sesuai atau ceritakan rencana perjalanan Anda kepada kami.' => 'Find a tour package that suits you, or tell us about your travel plans.',
			'Temukan tips perjalanan, panduan destinasi, rekomendasi aktivitas, hingga informasi praktis untuk menjelajahi Indonesia.' => 'Find travel tips, destination guides, activity ideas and practical information for exploring Indonesia.',
			'Tentang Kami' => 'About Us',
			'Terlaris' => 'Best seller',
			'Tidak ada hasil untuk: %s' => 'No results for: %s',
			'Tim lokal siap membantu sebelum dan selama perjalanan.' => 'Our local team is here to help before and during your trip.',
			'Tipe' => 'Type',
			'Kapasitas' => 'Capacity',
			'Transmisi' => 'Transmission',
			'Tulis komentar atau pertanyaan Anda...' => 'Write your comment or question...',
			'Tutup pratinjau' => 'Close preview',
			'Untuk pertanyaan perjalanan, silakan kunjungi halaman Kontak Kami.' => 'For travel questions, please visit our Contact Us page.',
			'mnt baca' => 'min read',
			'← Komentar sebelumnya' => '← Previous comments',
		);
	}

	return $map;
}

/** Translate a theme string used outside the gettext functions. */
function travel_aja_v2_ui_text( $text ) {
	if ( ! function_exists( 'pll_current_language' ) || 'en' !== pll_current_language() ) {
		return $text;
	}
	$map = travel_aja_v2_ui_translations();
	return isset( $map[ $text ] ) ? $map[ $text ] : $text;
}

add_filter(
	'gettext',
	function ( $translated, $text, $domain ) {
		if ( is_admin() || ! in_array( $domain, array( 'custom-theme', 'custom-theme-v2' ), true ) ) {
			return $translated;
		}
		if ( ! function_exists( 'pll_current_language' ) || 'en' !== pll_current_language() ) {
			return $translated;
		}
		$map = travel_aja_v2_ui_translations();
		return isset( $map[ $text ] ) ? $map[ $text ] : $translated;
	},
	10,
	3
);

/**
 * Teks hero beranda disimpan sebagai satu nilai global di Customizer, bukan string
 * gettext, jadi diterjemahkan per bahasa lewat filter theme_mod. Nilai yang sudah
 * disesuaikan sendiri oleh pengguna dibiarkan apa adanya (tidak ditimpa diam-diam).
 *
 * @return array<string,array<string,string>>
 */
function travel_aja_v2_hero_translations() {
	return array(
		'travel_v2_hero_kicker'      => array(
			'id' => 'Paket wisata dan sewa kendaraan di Indonesia',
			'en' => 'Tour packages and vehicle rental across Indonesia',
		),
		'travel_v2_hero_title'       => array(
			'id' => 'Jelajahi Indonesia dengan lebih mudah',
			'en' => 'Explore Indonesia with ease',
		),
		'travel_v2_hero_description' => array(
			'id' => 'Temukan paket perjalanan pilihan dan kendaraan yang siap menemani rute liburan Anda.',
			'en' => 'Discover curated travel packages and vehicles ready to accompany your holiday route.',
		),
	);
}

foreach ( travel_aja_v2_hero_translations() as $travel_aja_v2_key => $travel_aja_v2_text ) {
	add_filter(
		'theme_mod_' . $travel_aja_v2_key,
		static function ( $value ) use ( $travel_aja_v2_text ) {
			if ( is_admin() ) {
				return $value;
			}
			if ( ! function_exists( 'pll_current_language' ) || 'en' !== pll_current_language() ) {
				return $value;
			}
			$current = is_string( $value ) ? trim( $value ) : '';
			if ( '' !== $current && $current !== $travel_aja_v2_text['id'] ) {
				return $value; // teks kustom milik pengguna
			}
			return $travel_aja_v2_text['en'];
		}
	);
}

/**
 * Halaman "Kontak Kami" digabung ke "Tentang Kami".
 * URL lama dialihkan permanen (301) supaya tautan lama tidak mati.
 */
add_action(
	'template_redirect',
	function () {
		if ( ! is_page( 'kontak-kami' ) ) {
			return;
		}

		$target = get_page_by_path( 'tentang-kami' );
		if ( $target instanceof WP_Post && 'publish' === $target->post_status ) {
			wp_safe_redirect( get_permalink( $target ), 301 );
			exit;
		}
	},
	1
);

/**
 * Tujuan navigasi "kembali" dari halaman detail.
 *
 * Untuk artikel biasa: halaman daftar Panduan Wisata (mengikuti bahasa aktif).
 * Untuk tipe konten khusus: halaman listing-nya masing-masing.
 *
 * @return array{url:string,label:string}
 */
function travel_aja_v2_single_back() {
	$type = get_post_type();

	if ( 'post' === $type ) {
		$page_id = (int) get_option( 'page_for_posts' );

		// Polylang tidak menerjemahkan opsi page_for_posts di sisi depan,
		// jadi terjemahannya dicari manual supaya halaman EN tetap benar.
		if ( $page_id && function_exists( 'pll_get_post' ) ) {
			$translated = pll_get_post( $page_id );
			if ( $translated ) {
				$page_id = (int) $translated;
			}
		}

		if ( $page_id ) {
			return array(
				'url'   => (string) get_permalink( $page_id ),
				'label' => (string) get_the_title( $page_id ),
			);
		}

		return array( 'url' => home_url( '/' ), 'label' => (string) get_bloginfo( 'name' ) );
	}

	if ( function_exists( 'custom_theme_listing_url' ) ) {
		$config = function_exists( 'custom_theme_listing_config' ) ? custom_theme_listing_config( $type ) : array();
		$label  = '';
		foreach ( array( 'label', 'title' ) as $key ) {
			if ( ! empty( $config[ $key ] ) ) {
				$label = (string) $config[ $key ];
				break;
			}
		}
		if ( '' === $label ) {
			$object = get_post_type_object( $type );
			$label  = $object ? (string) $object->labels->name : (string) get_bloginfo( 'name' );
		}

		return array( 'url' => (string) custom_theme_listing_url( $type ), 'label' => $label );
	}

	return array( 'url' => home_url( '/' ), 'label' => (string) get_bloginfo( 'name' ) );
}
