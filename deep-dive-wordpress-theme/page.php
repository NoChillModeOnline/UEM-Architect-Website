<?php
/**
 * page.php — Static page template
 *
 * Simplified post-full layout without author card or related posts.
 */

get_header();

if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<article <?php post_class( 'post-full' ); ?> id="post-<?php the_ID(); ?>">

  <header class="post-full-header">
    <div class="container--narrow">
      <h1 class="post-full-title"><?php the_title(); ?></h1>
      <?php if ( has_excerpt() ) : ?>
        <p class="post-full-excerpt"><?php the_excerpt(); ?></p>
      <?php endif; ?>
    </div>
  </header>

  <?php if ( has_post_thumbnail() ) : ?>
    <figure class="post-full-image">
      <?php the_post_thumbnail( 'deep-dive-hero', [ 'alt' => '' ] ); ?>
      <?php $caption = get_the_post_thumbnail_caption(); if ( $caption ) : ?>
        <figcaption><?php echo esc_html( $caption ); ?></figcaption>
      <?php endif; ?>
    </figure>
  <?php endif; ?>

  <div class="post-full-content">
    <div class="container--narrow">
      <div class="entry-content">
        <?php the_content(); ?>
      </div>
    </div>
  </div>

</article>

<?php endwhile; endif; get_footer(); ?>
