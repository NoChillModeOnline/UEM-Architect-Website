<?php
/**
 * template-parts/post-card.php
 *
 * Reusable post card. Mirrors Ghost's post-card.hbs.
 * Expects standard WP loop context (have_posts / the_post already called).
 */

$author_id = get_the_author_meta( 'ID' );
$avatar    = get_avatar_url( $author_id, [ 'size' => 56 ] );
$tags      = get_the_tags();
$first_tag = $tags ? $tags[0] : null;

$show_author       = get_theme_mod( 'deep_dive_archive_show_author',       '1' );
$show_date         = get_theme_mod( 'deep_dive_archive_show_date',         '1' );
$show_reading_time = get_theme_mod( 'deep_dive_archive_show_reading_time', '1' );
?>

<article <?php post_class( 'post-card reveal' ); ?> id="post-<?php the_ID(); ?>">

  <?php if ( has_post_thumbnail() ) : ?>
    <a href="<?php the_permalink(); ?>" class="post-card__image-link" tabindex="-1" aria-hidden="true">
      <?php the_post_thumbnail( 'deep-dive-card', [
          'class' => 'post-card__image',
          'alt'   => '',
      ] ); ?>
    </a>
  <?php endif; ?>

  <div class="post-card__content">

    <?php if ( $first_tag ) : ?>
      <a class="post-card__tag" href="<?php echo esc_url( get_tag_link( $first_tag ) ); ?>">
        <?php echo esc_html( $first_tag->name ); ?>
      </a>
    <?php endif; ?>

    <h3 class="post-card__title">
      <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
    </h3>

    <p class="post-card__excerpt"><?php echo wp_trim_words( get_the_excerpt(), 22 ); ?></p>

    <div class="post-card__meta">

      <?php if ( $show_author ) : ?>
      <div class="post-card__author">
        <?php if ( $avatar ) : ?>
          <img class="post-card__author-avatar" src="<?php echo esc_url( $avatar ); ?>"
            alt="<?php echo esc_attr( get_the_author() ); ?>" width="28" height="28" />
        <?php else : ?>
          <span class="post-card__author-initials" aria-hidden="true">
            <?php echo esc_html( deep_dive_initials( $author_id ) ); ?>
          </span>
        <?php endif; ?>
        <span class="post-card__author-name"><?php the_author(); ?></span>
      </div>
      <?php endif; // show_author ?>

      <?php if ( $show_date || $show_reading_time ) : ?>
      <div class="post-card__details">
        <?php if ( $show_date ) : ?>
          <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
            <?php echo esc_html( get_the_date( 'M j, Y' ) ); ?>
          </time>
        <?php endif; ?>
        <?php if ( $show_date && $show_reading_time ) : ?>
          <span aria-hidden="true">&middot;</span>
        <?php endif; ?>
        <?php if ( $show_reading_time ) : ?>
          <span><?php echo esc_html( deep_dive_reading_time() ); ?></span>
        <?php endif; ?>
      </div>
      <?php endif; // show_date || show_reading_time ?>

    </div><!-- /.post-card__meta -->

  </div><!-- /.post-card__content -->

</article>
