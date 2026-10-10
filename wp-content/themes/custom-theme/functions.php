<?php
/**
 * Fitur dasar tema. Travel Aja Content Types mendaftarkan tipe konten di luar tema.
 *
 * @package Custom_Theme
 */

add_action( 'after_setup_theme', function () {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-logo', array( 'height' => 80, 'width' => 260, 'flex-height' => true, 'flex-width' => true ) );
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
		(string) filemtime( get_stylesheet_directory() . '/style.css' )
	);

	wp_enqueue_script(
		'custom-theme-header',
		get_theme_file_uri( 'assets/js/header.js' ),
		array(),
		wp_get_theme()->get( 'Version' ),
		true
	);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
} );

add_action( 'init', function () {
	foreach ( array( 'paket_wisata', 'destinasi', 'transportasi' ) as $post_type ) {
		if ( post_type_exists( $post_type ) ) {
			add_post_type_support( $post_type, 'comments' );
		}
	}
}, 99 );

require_once get_theme_file_path( 'inc/card-fields.php' );
require_once get_theme_file_path( 'inc/package-fields.php' );

require_once get_theme_file_path( 'inc/lower-home.php' );
require_once get_theme_file_path( 'inc/archive-pages.php' );
add_action( 'wp_enqueue_scripts', function () {
 wp_enqueue_style( 'custom-theme-lower', get_theme_file_uri( 'assets/css/lower-home.css' ), array( 'custom-theme' ), (string) filemtime( get_theme_file_path( 'assets/css/lower-home.css' ) ) );
 wp_enqueue_style( 'custom-theme-pages', get_theme_file_uri( 'assets/css/pages.css' ), array( 'custom-theme-lower' ), (string) filemtime( get_theme_file_path( 'assets/css/pages.css' ) ) );
 if ( is_front_page() ) {
  wp_enqueue_script( 'custom-theme-home', get_theme_file_uri( 'assets/js/home.js' ), array(), (string) filemtime( get_theme_file_path( 'assets/js/home.js' ) ), true );
 }
 if ( is_page( array( 'tentang-kami', 'about-us' ) ) ) {
  wp_enqueue_script( 'custom-theme-contact', get_theme_file_uri( 'assets/js/contact.js' ), array(), (string) filemtime( get_theme_file_path( 'assets/js/contact.js' ) ), true );
 }
} );

add_filter( 'body_class', function ( $classes ) {
	if ( is_home() || is_singular( array( 'post', 'paket_wisata', 'destinasi', 'transportasi' ) ) || is_post_type_archive( array( 'paket_wisata', 'destinasi', 'transportasi' ) ) || is_page( array( 'paket-wisata', 'destinasi', 'transportasi', 'panduan-wisata', 'tentang-kami' ) ) ) {
		$classes[] = 'has-overlay-header';
	}
	return $classes;
} );
