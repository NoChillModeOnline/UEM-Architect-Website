<?php
/**
 * comments.php — Comments template
 *
 * Styled to match the dark editorial design.
 */

if ( post_password_required() ) {
    return;
}
?>

<div class="comments-area" id="comments">

  <?php if ( have_comments() ) : ?>
    <h2 class="comments-title">
      <?php
      $count = get_comments_number();
      if ( '1' === $count ) {
          printf(
              /* translators: %s: post title */
              esc_html__( 'One response to "%s"', 'deep-dive' ),
              '<em>' . esc_html( get_the_title() ) . '</em>'
          );
      } else {
          printf(
              /* translators: 1: comment count, 2: post title */
              esc_html__( '%1$s responses to "%2$s"', 'deep-dive' ),
              esc_html( number_format_i18n( $count ) ),
              '<em>' . esc_html( get_the_title() ) . '</em>'
          );
      }
      ?>
    </h2>

    <ol class="comment-list">
      <?php
      wp_list_comments( [
          'style'      => 'ol',
          'short_ping' => true,
          'avatar_size' => 44,
          'callback'   => 'deep_dive_comment',
      ] );
      ?>
    </ol>

    <?php the_comments_navigation(); ?>

  <?php endif; ?>

  <?php if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
    <p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'deep-dive' ); ?></p>
  <?php endif; ?>

  <?php
  comment_form( [
      'title_reply_before' => '<h2 id="reply-title" class="comment-reply-title">',
      'title_reply_after'  => '</h2>',
      'title_reply'        => __( 'Leave a Response', 'deep-dive' ),
      'label_submit'       => __( 'Post Comment', 'deep-dive' ),
      'class_submit'       => 'btn btn--primary',
      'comment_field'      => '<p class="comment-form-comment"><label for="comment">' .
                              esc_html__( 'Comment', 'deep-dive' ) .
                              '</label><textarea id="comment" name="comment" cols="45" rows="6" required></textarea></p>',
  ] );
  ?>

</div><!-- /.comments-area -->
