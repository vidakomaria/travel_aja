<?php
/**
 * Plugin Name: Travel Aja Content Types
 * Description: Registers the destination, tour package, and transport post types used by the Travel Aja themes.
 * Version: 1.0.0
 * Requires at least: 6.0
 * Requires PHP: 7.4
 * Text Domain: travel-aja-content
 *
 * @package Travel_Aja_Content
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the post types consumed by both Travel Aja themes.
 *
 * Keep this registration in a plugin so content remains available when the
 * active theme changes.
 *
 * @return void
 */
function travel_aja_content_register_post_types() {
	$post_types = array(
		'destinasi'    => array(
			'singular' => __( 'Destinasi', 'travel-aja-content' ),
			'plural'   => __( 'Destinasi', 'travel-aja-content' ),
			'menu'     => 'dashicons-location-alt',
		),
		'paket_wisata' => array(
			'singular' => __( 'Paket Wisata', 'travel-aja-content' ),
			'plural'   => __( 'Paket Wisata', 'travel-aja-content' ),
			'menu'     => 'dashicons-palmtree',
		),
		'transportasi' => array(
			'singular' => __( 'Transportasi', 'travel-aja-content' ),
			'plural'   => __( 'Transportasi', 'travel-aja-content' ),
			'menu'     => 'dashicons-car',
		),
	);

	foreach ( $post_types as $post_type => $labels ) {
		register_post_type(
			$post_type,
			array(
				'labels'              => array(
					'name'                  => $labels['plural'],
					'singular_name'         => $labels['singular'],
					'add_new_item'          => sprintf(
						/* translators: %s: singular content type label. */
						__( 'Tambah %s', 'travel-aja-content' ),
						$labels['singular']
					),
					'edit_item'             => sprintf(
						/* translators: %s: singular content type label. */
						__( 'Edit %s', 'travel-aja-content' ),
						$labels['singular']
					),
				'new_item'              => sprintf(
						/* translators: %s: singular content type label. */
						__( '%s Baru', 'travel-aja-content' ),
						$labels['singular']
					),
				'view_item'             => sprintf(
						/* translators: %s: singular content type label. */
						__( 'Lihat %s', 'travel-aja-content' ),
						$labels['singular']
					),
				'view_items'            => sprintf(
						/* translators: %s: plural content type label. */
						__( 'Lihat %s', 'travel-aja-content' ),
						$labels['plural']
					),
				'search_items'          => sprintf(
						/* translators: %s: plural content type label. */
						__( 'Cari %s', 'travel-aja-content' ),
						$labels['plural']
					),
				'not_found'             => __( 'Belum ada konten.', 'travel-aja-content' ),
				'not_found_in_trash'    => __( 'Tidak ada konten di tong sampah.', 'travel-aja-content' ),
				'all_items'             => sprintf(
						/* translators: %s: plural content type label. */
						__( 'Semua %s', 'travel-aja-content' ),
						$labels['plural']
					),
				'menu_name'             => $labels['plural'],
				'name_admin_bar'        => $labels['singular'],
				'item_published'        => __( 'Konten berhasil diterbitkan.', 'travel-aja-content' ),
				'item_updated'          => __( 'Konten berhasil diperbarui.', 'travel-aja-content' ),
				'item_reverted_to_draft' => __( 'Konten dikembalikan ke draf.', 'travel-aja-content' ),
				'item_scheduled'        => __( 'Konten berhasil dijadwalkan.', 'travel-aja-content' ),
				'item_trashed'          => __( 'Konten dipindahkan ke tong sampah.', 'travel-aja-content' ),
			),
			'public'              => true,
			'publicly_queryable'  => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_rest'        => true,
		'exclude_from_search' => false,
		'has_archive'         => true,
		'menu_icon'           => $labels['menu'],
		'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', 'comments' ),
		'rewrite'             => array(
			'slug'       => $post_type,
			'with_front' => false,
		),
			)
		);
	}
}
add_action( 'init', 'travel_aja_content_register_post_types', 5 );

/**
 * Refresh rewrite rules after activation so item permalinks work immediately.
 *
 * @return void
 */
function travel_aja_content_activate() {
	travel_aja_content_register_post_types();
	travel_aja_content_register_placeholder_media();
	flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'travel_aja_content_activate' );

/**
 * Clear registered rewrite rules after deactivation.
 *
 * @return void
 */
function travel_aja_content_deactivate() {
	flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'travel_aja_content_deactivate' );

/**
 * Install local illustration assets as media items for content without photos.
 *
 * @return void
 */
function travel_aja_content_register_placeholder_media() {
	// WordPress only loads the image helpers automatically in some admin flows.
	// Playground activates plugins through PHP, so load the API before creating
	// attachment metadata to avoid a fatal error during activation.
	if ( ! function_exists( 'wp_generate_attachment_metadata' ) ) {
		require_once ABSPATH . 'wp-admin/includes/image.php';
	}

	$assets = array(
		'destination' => 'destination.png',
		'package'     => 'package.png',
		'transport'   => 'transport.png',
		'story'       => 'story.png',
	);
	$labels = array(
		'destination' => __( 'Destinasi', 'travel-aja-content' ),
		'package'     => __( 'Paket Wisata', 'travel-aja-content' ),
		'transport'   => __( 'Transportasi', 'travel-aja-content' ),
		'story'       => __( 'Panduan', 'travel-aja-content' ),
	);
	$ids    = get_option( 'travel_aja_content_placeholder_ids', array() );
	$upload = wp_upload_dir();

	if ( ! empty( $upload['error'] ) ) {
		return;
	}

	$directory = trailingslashit( $upload['basedir'] ) . 'travel-aja-placeholders';
	wp_mkdir_p( $directory );

	foreach ( $assets as $key => $filename ) {
		if ( ! empty( $ids[ $key ] ) && get_post( (int) $ids[ $key ] ) ) {
			continue;
		}

		$source = trailingslashit( plugin_dir_path( __FILE__ ) ) . 'assets/placeholders/' . $filename;
		$target = trailingslashit( $directory ) . $filename;

		if ( ! file_exists( $source ) || ( ! file_exists( $target ) && ! copy( $source, $target ) ) ) {
			continue;
		}

		$attachment_id = wp_insert_attachment(
			array(
				'post_mime_type' => 'image/png',
				'post_title'     => sprintf(
					/* translators: %s: placeholder category. */
					__( 'Travel Aja demo image: %s', 'travel-aja-content' ),
					$labels[ $key ] ?? $key
				),
				'post_status'    => 'inherit',
			),
			$target
		);

		if ( ! is_wp_error( $attachment_id ) ) {
			$ids[ $key ] = (int) $attachment_id;
			update_post_meta( $attachment_id, '_travel_aja_content_placeholder', sanitize_key( $key ) );
			update_attached_file( $attachment_id, $target );
			$metadata = wp_generate_attachment_metadata( $attachment_id, $target );
			if ( is_array( $metadata ) ) {
				wp_update_attachment_metadata( $attachment_id, $metadata );
			}
		}
	}

	update_option( 'travel_aja_content_placeholder_ids', $ids, false );
}

/**
 * Return a local illustration when demo content has no featured image.
 *
 * @param int          $thumbnail_id Existing featured image ID.
 * @param int|\WP_Post $post          Post ID or object being queried.
 * @return int
 */
function travel_aja_content_placeholder_thumbnail( $thumbnail_id, $post ) {
	if ( $thumbnail_id || is_admin() ) {
		return (int) $thumbnail_id;
	}

	$post = get_post( $post );
	if ( ! $post ) {
		return (int) $thumbnail_id;
	}

	$type_to_placeholder = array(
		'destinasi'    => 'destination',
		'paket_wisata' => 'package',
		'transportasi' => 'transport',
		'post'         => 'story',
	);
	$key                = isset( $type_to_placeholder[ $post->post_type ] ) ? $type_to_placeholder[ $post->post_type ] : '';

	if ( 'page' === $post->post_type && (int) get_option( 'page_on_front' ) === (int) $post->ID ) {
		$key = 'destination';
	}

	if ( ! $key ) {
		return (int) $thumbnail_id;
	}

	$ids = get_option( 'travel_aja_content_placeholder_ids', array() );
	return isset( $ids[ $key ] ) ? (int) $ids[ $key ] : (int) $thumbnail_id;
}
add_filter( 'post_thumbnail_id', 'travel_aja_content_placeholder_thumbnail', 10, 2 );
