<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#main-content"><?php esc_html_e( 'Lewati ke konten', 'custom-theme-v2' ); ?></a>

<?php $contact_url = travel_aja_v2_page_url( 'tentang-kami', '/tentang-kami/' ); ?>
<header class="v2-header" data-v2-header>
	<div class="v2-shell v2-header__inner">
		<a class="v2-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
			<?php if ( has_custom_logo() ) : ?>
				<?php echo wp_get_attachment_image( get_theme_mod( 'custom_logo' ), 'full', false, array( 'class' => 'v2-brand__logo', 'alt' => get_bloginfo( 'name' ) ) ); ?>
			<?php else : ?>
				<span class="v2-brand__mark" aria-hidden="true"><i></i><i></i></span>
				<span class="v2-brand__name">TRAVEL AJA</span>
			<?php endif; ?>
		</a>

		<button class="v2-menu-toggle" type="button" aria-expanded="false" aria-controls="v2-primary-navigation">
			<span class="screen-reader-text"><?php esc_html_e( 'Buka navigasi', 'custom-theme-v2' ); ?></span>
			<span></span><span></span><span></span>
		</button>

		<div class="v2-header__navigation" id="v2-primary-navigation" data-v2-navigation>
			<nav class="v2-nav" aria-label="<?php esc_attr_e( 'Navigasi utama', 'custom-theme-v2' ); ?>">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'container'      => false,
						'menu_class'     => 'v2-nav__list',
						'depth'          => 1,
						'fallback_cb'    => 'wp_page_menu',
					)
				);
				?>
			</nav>
			<?php if ( function_exists( 'pll_the_languages' ) ) : ?>
				<?php $v2_languages = pll_the_languages( array( 'raw' => 1, 'hide_if_no_translation' => 0, 'hide_current' => 0, 'show_flags' => 0, 'show_names' => 1 ) ); ?>
				<?php if ( is_array( $v2_languages ) && count( $v2_languages ) > 1 ) : ?>
					<div class="v2-lang" role="group" aria-label="<?php esc_attr_e( 'Pilih bahasa', 'custom-theme-v2' ); ?>">
						<?php foreach ( $v2_languages as $v2_language ) : ?>
							<a class="v2-lang__item<?php echo $v2_language['current_lang'] ? ' is-current' : ''; ?>" href="<?php echo esc_url( $v2_language['url'] ); ?>" hreflang="<?php echo esc_attr( $v2_language['locale'] ); ?>" lang="<?php echo esc_attr( $v2_language['locale'] ); ?>"<?php echo $v2_language['current_lang'] ? ' aria-current="true"' : ''; ?>><?php echo esc_html( strtoupper( $v2_language['slug'] ) ); ?></a>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			<?php endif; ?>
			<a class="v2-button v2-button--small" href="<?php echo esc_url( $contact_url ); ?>"><?php esc_html_e( 'Hubungi Kami', 'custom-theme-v2' ); ?></a>
		</div>
	</div>
</header>

