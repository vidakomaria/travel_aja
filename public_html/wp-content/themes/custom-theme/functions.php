<?php
/**
 * Fitur dasar tema. Data dan tipe konten tetap dikelola oleh WordPress/plugin.
 *
 * @package Custom_Theme
 */

add_action( 'after_setup_theme', function () {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );

	register_nav_menus(
		array(
			'primary' => __( 'Navigasi Utama', 'custom-theme' ),
		)
	);
} );

add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style(
		'custom-theme',
		get_stylesheet_uri(),
		array(),
		wp_get_theme()->get( 'Version' )
	);

	wp_enqueue_script(
		'custom-theme-header',
		get_theme_file_uri( 'assets/js/header.js' ),
		array(),
		wp_get_theme()->get( 'Version' ),
		true
	);
} );
