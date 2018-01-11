<?php
/**
 * Template modified version of _s theme from Automattic
 * @link https://github.com/Automattic/_s/blob/master/comments.php
 *
 * @since  1.0.0
 */

if ( post_password_required() ) {
  return;
}

?>

<section class="post-comments">

  <?php

    if ( have_comments() ) : ?>
      <h2>
        <?php
        $comment_count = get_comments_number();
        if ( 1 === $comment_count ) {
          printf(
            /* translators: 1: title. */
            esc_html_e( 'A comment on &ldquo;%1$s&rdquo;' ),
            '<span>' . get_the_title() . '</span>'
          );
        } else {
          printf( // WPCS: XSS OK.
            /* translators: 1: comment count number, 2: title. */
            esc_html( _nx( '%1$s comment on &ldquo;%2$s&rdquo;', '%1$s comments on &ldquo;%2$s&rdquo;', $comment_count, 'comments title' ) ),
            number_format_i18n( $comment_count ),
            '<span>' . get_the_title() . '</span>'
          );
        }
        ?>
      </h2>

      <?php the_comments_navigation(); ?>

      <ol class="post-comments__list">
        <?php
          wp_list_comments( array(
            'style'      => 'ol',
            'short_ping' => true,
          ) );
        ?>
      </ol>

      <?php the_comments_navigation();

      // If comments are closed and there are comments, let's leave a little note, shall we?
      if ( ! comments_open() ) : ?>
        <p class="post-comments__none"><?php esc_html_e( 'Comments are closed.' ); ?></p>
      <?php
      endif;

    endif; // Check for have_comments().

    comment_form();

  ?>

</section>