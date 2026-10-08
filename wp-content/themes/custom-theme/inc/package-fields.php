<?php
/**
 * Field tambahan untuk kartu Paket Wisata.
 *
 * @package Custom_Theme
 */

add_action( 'add_meta_boxes_paket_wisata', function () {
	add_meta_box(
		'custom-theme-package-details',
		__( 'Detail Kartu Paket Wisata', 'custom-theme' ),
		function ( $post ) {
			wp_nonce_field( 'custom_theme_save_package_details', 'custom_theme_package_nonce' );
			$duration = get_post_meta( $post->ID, '_custom_theme_package_duration', true );
			$location = get_post_meta( $post->ID, '_custom_theme_package_location', true );
			$price    = get_post_meta( $post->ID, '_custom_theme_package_price', true );
			$rating   = get_post_meta( $post->ID, '_custom_theme_package_rating', true );
			$badge = custom_theme_card_badge( $post->ID, 'package' );
			?>
			<p>
				<label for="custom-theme-package-duration"><strong><?php esc_html_e( 'Durasi', 'custom-theme' ); ?></strong></label><br>
				<input id="custom-theme-package-duration" class="widefat" type="text" name="custom_theme_package_duration" value="<?php echo esc_attr( $duration ); ?>" placeholder="<?php echo esc_attr__( 'Contoh: 1 Day', 'custom-theme' ); ?>">
			</p>
			<p>
				<label for="custom-theme-package-rating"><strong><?php esc_html_e( 'Rating (0–5)', 'custom-theme' ); ?></strong></label><br>
				<input id="custom-theme-package-rating" type="number" min="0" max="5" step="0.1" name="custom_theme_package_rating" value="<?php echo esc_attr( $rating ); ?>" placeholder="4.9">
			</p>
			<p>
				<label for="custom-theme-package-location"><strong><?php esc_html_e( 'Lokasi', 'custom-theme' ); ?></strong></label><br>
				<input id="custom-theme-package-location" class="widefat" type="text" name="custom_theme_package_location" value="<?php echo esc_attr( $location ); ?>" placeholder="<?php echo esc_attr__( 'Contoh: Banyuwangi', 'custom-theme' ); ?>">
			</p>
			<p>
				<label for="custom-theme-package-price"><strong><?php esc_html_e( 'Harga mulai dari (Rupiah per orang)', 'custom-theme' ); ?></strong></label><br>
				<input id="custom-theme-package-price" class="widefat" type="number" min="0" step="1" name="custom_theme_package_price" value="<?php echo esc_attr( $price ); ?>" placeholder="499998">
				<small><?php esc_html_e( 'Masukkan angka tanpa titik atau simbol Rp.', 'custom-theme' ); ?></small>
			</p>
			<p>
				<label for="package-badge"><?php esc_html_e( 'Lencana', 'custom-theme' ); ?></label>
				<select id="package-badge" name="custom_theme_package_badge">
					<?php foreach ( custom_theme_badge_options() as $value => $label ) : ?>
						<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $badge, $value ); ?>><?php echo esc_html( $label ); ?></option>
					<?php endforeach; ?>
				</select>
			</p>
			<?php
		},
		'paket_wisata',
		'normal',
		'default'
	);
} );

add_action( 'save_post_paket_wisata', function ( $post_id ) {
	if (
		! isset( $_POST['custom_theme_package_nonce'] ) ||
		! is_string( $_POST['custom_theme_package_nonce'] ) ||
		! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['custom_theme_package_nonce'] ) ), 'custom_theme_save_package_details' ) ||
		( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) ||
		! current_user_can( 'edit_post', $post_id )
	) {
		return;
	}

	foreach ( array( 'duration', 'location' ) as $field ) {
		$input_name = 'custom_theme_package_' . $field;
		$meta_key   = '_custom_theme_package_' . $field;
		$value      = isset( $_POST[ $input_name ] ) && is_string( $_POST[ $input_name ] )
			? sanitize_text_field( wp_unslash( $_POST[ $input_name ] ) )
			: '';

		if ( '' === $value ) {
			delete_post_meta( $post_id, $meta_key );
		} else {
			update_post_meta( $post_id, $meta_key, $value );
		}
	}

	$price = isset( $_POST['custom_theme_package_price'] ) && is_string( $_POST['custom_theme_package_price'] )
		? trim( wp_unslash( $_POST['custom_theme_package_price'] ) )
		: '';
	if ( '' !== $price && ctype_digit( $price ) ) {
		update_post_meta( $post_id, '_custom_theme_package_price', $price );
	} else {
		delete_post_meta( $post_id, '_custom_theme_package_price' );
	}

	$badge = isset( $_POST['custom_theme_package_badge'] ) && is_string( $_POST['custom_theme_package_badge'] ) ? sanitize_key( $_POST['custom_theme_package_badge'] ) : '';
	update_post_meta( $post_id, '_custom_theme_package_badge', array_key_exists( $badge, custom_theme_badge_options() ) ? $badge : '' );

	$rating = isset( $_POST['custom_theme_package_rating'] ) && is_string( $_POST['custom_theme_package_rating'] ) ? sanitize_text_field( wp_unslash( $_POST['custom_theme_package_rating'] ) ) : '';
	if ( '' !== $rating && is_numeric( $rating ) && (float) $rating >= 0 && (float) $rating <= 5 ) {
		update_post_meta( $post_id, '_custom_theme_package_rating', number_format( (float) $rating, 1, '.', '' ) );
	} else {
		delete_post_meta( $post_id, '_custom_theme_package_rating' );
	}
} );
