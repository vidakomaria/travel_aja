<?php
/** Pengaturan kontak dan field kartu transportasi. */
add_action( 'customize_register', function ( $customizer ) {
 $customizer->add_section( 'travel_contact', array( 'title' => 'Kontak & Footer', 'priority' => 35 ) );
 $fields = array(
  'travel_whatsapp' => 'WhatsApp (kode negara, contoh 62812...)',
  'travel_office_address' => 'Alamat kantor',
  'travel_email' => 'Email',
  'travel_hours' => 'Jam operasional',
  'travel_map_url' => 'URL Google Maps',
  'travel_footer_description' => 'Deskripsi footer',
  'travel_facebook' => 'URL Facebook',
  'travel_instagram' => 'URL Instagram',
  'travel_tiktok' => 'URL TikTok',
  'travel_youtube' => 'URL YouTube'
 );
 foreach ( $fields as $key => $label ) {
  $is_url = in_array( $key, array( 'travel_map_url', 'travel_facebook', 'travel_instagram', 'travel_tiktok', 'travel_youtube' ), true );
  $customizer->add_setting( $key, array( 'default' => '', 'sanitize_callback' => $is_url ? 'esc_url_raw' : ( 'travel_email' === $key ? 'sanitize_email' : 'sanitize_text_field' ) ) );
  $customizer->add_control( $key, array( 'label' => $label, 'section' => 'travel_contact', 'type' => 'travel_footer_description' === $key ? 'textarea' : 'text' ) );
 }
} );
function custom_theme_transport_fields() {
 return array( 'type' => 'Jenis layanan (Sewa Motor / Mobil + Driver)', 'capacity' => 'Kapasitas penumpang', 'transmission' => 'Transmisi', 'model' => 'Model / kapasitas mesin', 'price' => 'Harga mulai dari (angka Rupiah, kosongkan untuk Hubungi Kami)', 'unit' => 'Satuan harga (contoh: 24 Jam)' );
}
add_action( 'add_meta_boxes_transportasi', function () {
 add_meta_box( 'travel-transport', 'Detail Kartu Transportasi', function ( $post ) {
  wp_nonce_field( 'travel_transport_save', 'travel_transport_nonce' );
  foreach ( custom_theme_transport_fields() as $key => $label ) {
   echo '<p><label for="transport-' . esc_attr( $key ) . '">' . esc_html( $label ) . '</label><input class="widefat" id="transport-' . esc_attr( $key ) . '" name="transport_' . esc_attr( $key ) . '" type="' . ( 'price' === $key ? 'number' : 'text' ) . '" min="0" value="' . esc_attr( get_post_meta( $post->ID, '_custom_theme_transport_' . $key, true ) ) . '"></p>';
  }
 }, 'transportasi', 'normal' );
} );
add_action( 'save_post_transportasi', function ( $id ) {
 if ( ! isset( $_POST['travel_transport_nonce'] ) || ! is_string( $_POST['travel_transport_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['travel_transport_nonce'] ) ), 'travel_transport_save' ) || ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || ! current_user_can( 'edit_post', $id ) ) { return; }
 foreach ( custom_theme_transport_fields() as $key => $label ) {
  $value = isset( $_POST[ 'transport_' . $key ] ) && is_string( $_POST[ 'transport_' . $key ] ) ? sanitize_text_field( wp_unslash( $_POST[ 'transport_' . $key ] ) ) : '';
  if ( 'price' === $key && '' !== $value ) { $value = is_numeric( $value ) && (float) $value >= 0 ? (string) (int) $value : ''; }
  update_post_meta( $id, '_custom_theme_transport_' . $key, $value );
 }
} );
