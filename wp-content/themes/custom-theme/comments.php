<?php
/** Daftar dan formulir komentar WordPress. */
if ( post_password_required() ) {
	return;
}
$commenter = wp_get_current_commenter();
$required  = (bool) get_option( 'require_name_email' );
$aria_req  = $required ? ' aria-required="true" required' : '';
?>
<section id="comments" class="comments-area" aria-labelledby="comments-title">
	<div class="comments-area__heading">
		<span class="comments-area__kicker"><?php esc_html_e( 'Diskusi Pengunjung', 'custom-theme' ); ?></span>
		<h2 id="comments-title"><?php echo esc_html( get_comments_number_text( __( 'Belum ada komentar', 'custom-theme' ), __( '1 Komentar', 'custom-theme' ), __( '% Komentar', 'custom-theme' ) ) ); ?></h2>
		<p><?php esc_html_e( 'Bagikan pertanyaan atau pengalaman Anda. Komentar yang masuk mengikuti pengaturan moderasi WordPress.', 'custom-theme' ); ?></p>
	</div>

	<?php if ( have_comments() ) : ?>
		<ol class="comment-list">
			<?php wp_list_comments( array( 'style' => 'ol', 'avatar_size' => 52, 'short_ping' => true ) ); ?>
		</ol>
		<?php the_comments_pagination( array( 'prev_text' => esc_html__( '← Komentar sebelumnya', 'custom-theme' ), 'next_text' => esc_html__( 'Komentar berikutnya →', 'custom-theme' ) ) ); ?>
	<?php endif; ?>

	<?php if ( comments_open() ) : ?>
		<div class="comment-form-card">
			<?php
			comment_form(
				array(
					'class_form'           => 'comment-form',
					'title_reply'          => esc_html__( 'Tambahkan Komentar', 'custom-theme' ),
					'title_reply_before'   => '<h3 id="reply-title" class="comment-reply-title">',
					'title_reply_after'    => '</h3>',
					'comment_notes_before' => '<p class="comment-notes">' . esc_html__( 'Alamat email Anda tidak akan dipublikasikan. Kolom bertanda * wajib diisi.', 'custom-theme' ) . '</p>',
					'comment_field'        => '<p class="comment-form-comment"><label for="comment">' . esc_html__( 'Komentar *', 'custom-theme' ) . '</label><textarea id="comment" name="comment" cols="45" rows="7" maxlength="65525" required placeholder="' . esc_attr__( 'Tulis komentar atau pertanyaan Anda...', 'custom-theme' ) . '"></textarea></p>',
					'fields'               => array(
						'author' => '<p class="comment-form-author"><label for="author">' . esc_html__( 'Nama', 'custom-theme' ) . ( $required ? ' *' : '' ) . '</label><input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" maxlength="245" autocomplete="name"' . $aria_req . '></p>',
						'email'  => '<p class="comment-form-email"><label for="email">Email' . ( $required ? ' *' : '' ) . '</label><input id="email" name="email" type="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '" maxlength="100" autocomplete="email"' . $aria_req . '></p>',
					),
					'label_submit'         => esc_html__( 'Kirim Komentar', 'custom-theme' ),
					'class_submit'         => 'submit comment-submit',
				)
			);
			?>
		</div>
	<?php elseif ( get_comments_number() ) : ?>
		<p class="comments-closed"><?php esc_html_e( 'Komentar untuk konten ini sudah ditutup.', 'custom-theme' ); ?></p>
	<?php endif; ?>
</section>
