<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#main-content"><?php esc_html_e( 'Lewati ke konten', 'custom-theme' ); ?></a>

<header class="site-header">
	<div class="container site-header__inner">
		<a class="site-title" href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<?php if ( has_custom_logo() ) : $logo_id = get_theme_mod( 'custom_logo' ); echo wp_get_attachment_image( $logo_id, 'full', false, array( 'class' => 'site-logo', 'alt' => get_bloginfo( 'name' ) ) ); else : echo esc_html( get_bloginfo( 'name' ) ); endif; ?>
		</a>
		<nav class="site-nav" aria-label="<?php esc_attr_e( 'Navigasi utama', 'custom-theme' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'site-nav__list',
					'depth'          => 1,
					'fallback_cb'    => 'wp_page_menu',
				)
			);
			?>
		</nav>
	</div>
</header>
