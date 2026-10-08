<?php
$vehicles = new WP_Query( array( 'post_type' => 'transportasi', 'post_status' => 'publish', 'posts_per_page' => -1, 'no_found_rows' => true ) );
?>
<section class="section-block bg-white" id="tour-transportation">
 <div class="container">
  <div class="header-row"><div class="title-area"><h2>Transportasi Perjalanan</h2><p>Sewa motor atau gunakan kendaraan dengan driver untuk perjalanan yang lebih praktis.</p></div><a class="view-all-btn" href="<?php echo esc_url( get_post_type_archive_link( 'transportasi' ) ?: home_url( '/?s=&post_type=transportasi' ) ); ?>" aria-label="Lihat semua transportasi">›</a></div>
  <div class="transport-grid">
  <?php while ( $vehicles->have_posts() ) : $vehicles->the_post();
   $data = array(); foreach ( array( 'type', 'capacity', 'transmission', 'model', 'price', 'unit' ) as $field ) { $data[ $field ] = get_post_meta( get_the_ID(), '_custom_theme_transport_' . $field, true ); }
  ?>
   <article class="transport-card">
    <a class="transport-image" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true"><?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'medium_large' ); } ?><?php if ( $data['type'] ) : ?><span class="transport-badge"><?php echo esc_html( $data['type'] ); ?></span><?php endif; ?></a>
    <div class="transport-body"><h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
     <div class="transport-facts"><?php foreach ( array( 'capacity' => '♧', 'transmission' => '⚙', 'model' => '◇' ) as $field => $icon ) : if ( $data[ $field ] ) : ?><span><b aria-hidden="true"><?php echo esc_html( $icon ); ?></b> <?php echo esc_html( $data[ $field ] ); ?></span><?php endif; endforeach; ?></div>
     <p class="transport-description"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 17 ) ); ?></p>
     <div class="transport-footer"><div><small>MULAI DARI</small><strong><?php echo '' !== $data['price'] ? 'Rp ' . esc_html( number_format( (float) $data['price'], 0, ',', '.' ) ) : 'Hubungi Kami'; ?></strong> <span><?php echo esc_html( $data['unit'] ); ?></span></div><a class="btn-base btn-accent" href="<?php the_permalink(); ?>">Lihat Detail</a></div>
    </div>
   </article>
  <?php endwhile; wp_reset_postdata(); ?>
  </div>
  <?php if ( ! $vehicles->post_count ) : ?><p class="transport-empty">Pilihan kendaraan akan segera tersedia. <a href="#itinerary">Sampaikan kebutuhan perjalanan Anda.</a></p><?php endif; ?>
 </div>
</section>
