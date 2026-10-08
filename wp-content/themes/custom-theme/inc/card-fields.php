<?php
/** Field kartu destinasi dan pilihan lencana. */

function custom_theme_badge_options() {
	return array( '' => __( 'Tanpa lencana', 'custom-theme' ), 'popular' => __( 'Populer', 'custom-theme' ), 'recommended' => __( 'Rekomendasi', 'custom-theme' ), 'bestseller' => __( 'Terlaris', 'custom-theme' ) );
}

function custom_theme_card_badge( $post_id, $type ) {
	$key = '_custom_theme_' . $type . '_badge';
	$badge = get_post_meta( $post_id, $key, true );
	if ( 'package' === $type && ! metadata_exists( 'post', $post_id, $key ) && '1' === get_post_meta( $post_id, '_custom_theme_package_popular', true ) ) {
		$badge = 'popular';
	}
	return is_string( $badge ) && array_key_exists( $badge, custom_theme_badge_options() ) ? $badge : '';
}

add_action( 'add_meta_boxes_destinasi', function () {
	add_meta_box( 'custom-theme-destination-details', __( 'Detail Kartu Destinasi', 'custom-theme' ), function ( $post ) {
		wp_nonce_field( 'custom_theme_save_destination', 'custom_theme_destination_nonce' );
		$badge = custom_theme_card_badge( $post->ID, 'destination' );
		?>
		<p><label for="destination-location"><?php esc_html_e( 'Lokasi', 'custom-theme' ); ?></label><br>
		<input class="widefat" id="destination-location" name="custom_theme_destination_location" type="text" value="<?php echo esc_attr( get_post_meta( $post->ID, '_custom_theme_destination_location', true ) ); ?>" placeholder="Banyuwangi"></p>
		<p><label for="destination-rating"><?php esc_html_e( 'Rating (0–5)', 'custom-theme' ); ?></label><br>
		<input id="destination-rating" name="custom_theme_destination_rating" type="number" min="0" max="5" step="0.1" value="<?php echo esc_attr( get_post_meta( $post->ID, '_custom_theme_destination_rating', true ) ); ?>">
		<br><small><?php esc_html_e( 'Isi berdasarkan rating yang Anda miliki; kosongkan jika belum ada.', 'custom-theme' ); ?></small></p>
		<p><label for="destination-category"><?php esc_html_e( 'Kategori', 'custom-theme' ); ?></label><br>
		<input class="widefat" id="destination-category" name="custom_theme_destination_category" type="text" value="<?php echo esc_attr( get_post_meta( $post->ID, '_custom_theme_destination_category', true ) ); ?>" placeholder="Gunung & Kawah"></p>
		<p><label for="destination-highlights"><?php esc_html_e( 'Aktivitas unggulan', 'custom-theme' ); ?></label><br>
		<input class="widefat" id="destination-highlights" name="custom_theme_destination_highlights" type="text" value="<?php echo esc_attr( get_post_meta( $post->ID, '_custom_theme_destination_highlights', true ) ); ?>" placeholder="Trekking, Camping, Spot Foto"><br>
		<small><?php esc_html_e( 'Pisahkan setiap aktivitas dengan koma.', 'custom-theme' ); ?></small></p>
		<p><label for="destination-badge"><?php esc_html_e( 'Lencana', 'custom-theme' ); ?></label>
		<select id="destination-badge" name="custom_theme_destination_badge">
		<?php foreach ( custom_theme_badge_options() as $value => $label ) : ?>
			<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $badge, $value ); ?>><?php echo esc_html( $label ); ?></option>
		<?php endforeach; ?>
		</select></p>
		<?php
	}, 'destinasi', 'normal', 'default' );
} );

add_action( 'save_post_destinasi', function ( $post_id ) {
	if ( ! isset( $_POST['custom_theme_destination_nonce'] ) || ! is_string( $_POST['custom_theme_destination_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['custom_theme_destination_nonce'] ) ), 'custom_theme_save_destination' ) || ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	foreach ( array( 'location', 'rating', 'category', 'highlights', 'badge' ) as $field ) {
		$name = 'custom_theme_destination_' . $field;
		$value = isset( $_POST[ $name ] ) && is_string( $_POST[ $name ] ) ? sanitize_text_field( wp_unslash( $_POST[ $name ] ) ) : '';
		if ( 'rating' === $field && '' !== $value ) {
			$value = is_numeric( $value ) && (float) $value >= 0 && (float) $value <= 5 ? number_format( (float) $value, 1, '.', '' ) : '';
		}
		if ( 'badge' === $field && ! array_key_exists( $value, custom_theme_badge_options() ) ) {
			$value = '';
		}
		update_post_meta( $post_id, '_' . $name, $value );
	}
} );
