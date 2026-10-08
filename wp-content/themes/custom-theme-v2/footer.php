<?php
$whatsapp = preg_replace( '/\D/', '', get_theme_mod( 'travel_whatsapp', '' ) );
$email    = sanitize_email( get_theme_mod( 'travel_email', '' ) );
$address  = trim( (string) get_theme_mod( 'travel_office_address', '' ) );
$hours    = trim( (string) get_theme_mod( 'travel_hours', '' ) );
?>
<footer class="v2-footer" id="contact">
	<div class="v2-shell v2-footer__grid">
		<div class="v2-footer__about">
			<a class="v2-footer__brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">TRAVEL AJA</a>
			<p><?php echo esc_html( get_theme_mod( 'travel_footer_description', '' ) ?: 'Paket wisata Bali dan kendaraan pilihan untuk perjalanan yang lebih praktis, nyaman, dan berkesan.' ); ?></p>
			<div class="v2-footer__socials">
				<?php foreach ( array( 'facebook' => 'f', 'instagram' => '◎', 'tiktok' => '♪', 'youtube' => '▶' ) as $social => $symbol ) : ?>
					<?php $url = get_theme_mod( 'travel_' . $social, '' ); ?>
					<?php if ( $url ) : ?><a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( ucfirst( $social ) ); ?>"><?php echo esc_html( $symbol ); ?></a><?php endif; ?>
				<?php endforeach; ?>
			</div>
		</div>

		<nav class="v2-footer__links" aria-label="<?php esc_attr_e( 'Jelajah', 'custom-theme-v2' ); ?>">
			<h2><?php esc_html_e( 'Jelajah', 'custom-theme-v2' ); ?></h2>
			<a href="<?php echo esc_url( custom_theme_listing_url( 'paket_wisata' ) ); ?>"><?php esc_html_e( 'Paket Wisata', 'custom-theme-v2' ); ?></a>
			<a href="<?php echo esc_url( custom_theme_listing_url( 'transportasi' ) ); ?>"><?php esc_html_e( 'Sewa Kendaraan', 'custom-theme-v2' ); ?></a>
			<a href="<?php echo esc_url( travel_aja_v2_page_url( 'panduan-wisata', '/panduan-wisata/' ) ); ?>"><?php esc_html_e( 'Artikel & Tips', 'custom-theme-v2' ); ?></a>
			<a href="<?php echo esc_url( travel_aja_v2_page_url( 'tentang-kami', '/tentang-kami/' ) ); ?>"><?php esc_html_e( 'Tentang Kami', 'custom-theme-v2' ); ?></a>
		</nav>

		<div class="v2-footer__contact">
			<h2><?php esc_html_e( 'Hubungi Kami', 'custom-theme-v2' ); ?></h2>
			<?php if ( $whatsapp ) : ?><a href="<?php echo esc_url( 'https://wa.me/' . $whatsapp ); ?>" target="_blank" rel="noopener noreferrer"><span>WhatsApp</span>+<?php echo esc_html( $whatsapp ); ?></a><?php endif; ?>
			<?php if ( $email ) : ?><a href="mailto:<?php echo esc_attr( antispambot( $email ) ); ?>"><span>Email</span><?php echo esc_html( antispambot( $email ) ); ?></a><?php endif; ?>
			<?php if ( $address ) : ?><p><span><?php esc_html_e( 'Lokasi', 'custom-theme-v2' ); ?></span><?php echo esc_html( $address ); ?></p><?php endif; ?>
			<?php if ( $hours ) : ?><p><span><?php esc_html_e( 'Jam layanan', 'custom-theme-v2' ); ?></span><?php echo esc_html( $hours ); ?></p><?php endif; ?>
			<?php if ( ! $whatsapp && ! $email && ! $address ) : ?><p><?php esc_html_e( 'Lengkapi kontak melalui Tampilan → Sesuaikan → Kontak & Footer.', 'custom-theme-v2' ); ?></p><?php endif; ?>
		</div>
	</div>
	<div class="v2-shell v2-footer__bottom">
		<span>© <?php echo esc_html( wp_date( 'Y' ) ); ?> Travel Aja. <?php esc_html_e( 'Seluruh hak cipta dilindungi.', 'custom-theme-v2' ); ?></span>
		<a href="<?php echo esc_url( travel_aja_v2_page_url( 'privacy-policy', '/privacy-policy/' ) ); ?>"><?php esc_html_e( 'Kebijakan Privasi', 'custom-theme-v2' ); ?></a>
	</div>
</footer>
<?php if ( $whatsapp ) : ?><a class="v2-whatsapp" href="<?php echo esc_url( 'https://wa.me/' . $whatsapp ); ?>" target="_blank" rel="noopener noreferrer">✆ <?php esc_html_e( 'Konsultasi via WhatsApp', 'custom-theme-v2' ); ?></a><?php endif; ?>
<?php wp_footer(); ?>
</body>
</html>

