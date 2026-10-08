<?php $articles = new WP_Query( array( 'post_type' => 'post', 'posts_per_page' => 3, 'post_status' => 'publish', 'ignore_sticky_posts' => true, 'no_found_rows' => true ) ); ?>
<section class="section-block bg-white" id="panduan-riset"><div class="container">
 <div class="header-row"><div class="title-area"><h2>Panduan Wisata</h2><p>Temukan tips, destinasi, budaya, dan informasi praktis sebelum memulai perjalanan.</p></div><a class="view-all-btn" href="<?php echo esc_url( get_permalink( (int) get_option( 'page_for_posts' ) ) ?: home_url( '/?s=&post_type=post' ) ); ?>" aria-label="Lihat semua panduan wisata">›</a></div>
 <div class="article-grid">
 <?php while ( $articles->have_posts() ) : $articles->the_post(); $categories = get_the_category(); ?>
 <article class="guide-card"><a class="guide-image" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true"><?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'medium_large' ); } ?><?php if ( $categories ) : ?><span><?php echo esc_html( $categories[0]->name ); ?></span><?php endif; ?></a><div class="guide-body"><time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">▢ <?php echo esc_html( get_the_date( 'F Y' ) ); ?></time><h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3><p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 22 ) ); ?></p><div class="guide-date">▦ <?php echo esc_html( get_the_date( 'd M Y' ) ); ?></div></div></article>
 <?php endwhile; wp_reset_postdata(); ?>
 </div>
</div></section>
