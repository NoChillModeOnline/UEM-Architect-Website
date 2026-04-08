<?php
/**
 * home.php — Blog index / homepage
 *
 * Mirrors Ghost's index.hbs: featured hero post + tag filter + post grid.
 */

get_header();

// ── Featured Post ──────────────────────────────────────────────────────────
$featured_query = new WP_Query( [
    'posts_per_page' => 1,
    'meta_key'       => '_is_featured',
    'meta_value'     => '1',
    'post_status'    => 'publish',
] );

// Fall back to most recent post if no featured post is set
if ( ! $featured_query->have_posts() ) {
    $featured_query = new WP_Query( [
        'posts_per_page' => 1,
        'post_status'    => 'publish',
    ] );
}

if ( $featured_query->have_posts() ) :
    $featured_query->the_post();
    $featured_author_id  = get_the_author_meta( 'ID' );
    $featured_avatar     = get_avatar_url( $featured_author_id, [ 'size' => 80 ] );
    $featured_tags       = get_the_tags();
    $featured_first_tag  = $featured_tags ? $featured_tags[0] : null;
?>

<section class="featured-hero" aria-label="<?php esc_attr_e( 'Featured article', 'deep-dive' ); ?>">
  <div class="container">
    <div class="featured-hero__inner">

      <!-- Text side -->
      <div class="featured-hero__text">
        <div class="featured-hero__eyebrow">
          <?php if ( $featured_first_tag ) : ?>
            <a class="featured-hero__tag" href="<?php echo esc_url( get_tag_link( $featured_first_tag ) ); ?>">
              <?php echo esc_html( $featured_first_tag->name ); ?>
            </a>
          <?php endif; ?>
          <span class="featured-hero__label"><?php esc_html_e( 'Featured', 'deep-dive' ); ?></span>
        </div>

        <h2 class="featured-hero__title">
          <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h2>

        <p class="featured-hero__excerpt"><?php echo wp_trim_words( get_the_excerpt(), 30 ); ?></p>

        <div class="featured-hero__meta">
          <!-- Author avatar -->
          <?php if ( $featured_avatar ) : ?>
            <img class="featured-hero__author-avatar" src="<?php echo esc_url( $featured_avatar ); ?>"
              alt="<?php echo esc_attr( get_the_author() ); ?>" width="40" height="40" />
          <?php else : ?>
            <span class="featured-hero__author-initials" aria-hidden="true">
              <?php echo esc_html( deep_dive_initials( $featured_author_id ) ); ?>
            </span>
          <?php endif; ?>

          <div>
            <span class="featured-hero__author-name"><?php the_author(); ?></span>
            <div class="featured-hero__details">
              <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
                <?php echo esc_html( get_the_date() ); ?>
              </time>
              <span aria-hidden="true">&middot;</span>
              <span><?php echo esc_html( deep_dive_reading_time() ); ?></span>
            </div>
          </div>
        </div>

        <a href="<?php the_permalink(); ?>" class="btn btn--primary">
          <?php esc_html_e( 'Read Article', 'deep-dive' ); ?>
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="16" height="16" aria-hidden="true">
            <path fill-rule="evenodd" d="M3 10a.75.75 0 01.75-.75h10.638L10.23 5.29a.75.75 0 111.04-1.08l5.5 5.25a.75.75 0 010 1.08l-5.5 5.25a.75.75 0 11-1.04-1.08l4.158-3.96H3.75A.75.75 0 013 10z" clip-rule="evenodd"/>
          </svg>
        </a>
      </div>

      <!-- Image side -->
      <?php if ( has_post_thumbnail() ) : ?>
        <a href="<?php the_permalink(); ?>" class="featured-hero__image-link" tabindex="-1" aria-hidden="true">
          <?php the_post_thumbnail( 'deep-dive-hero', [
              'class' => 'featured-hero__image',
              'alt'   => '',
          ] ); ?>
        </a>
      <?php endif; ?>

    </div><!-- /.featured-hero__inner -->
  </div><!-- /.container -->
</section><!-- /.featured-hero -->

<?php
    wp_reset_postdata();
endif; // end featured post
?>

<!-- ── Post Grid ── -->
<section class="home-content">
  <div class="container">

    <!-- Tag filter pills -->
    <?php
    $tags = get_tags( [ 'orderby' => 'count', 'order' => 'DESC', 'number' => 8 ] );
    if ( $tags ) :
        $current_tag = get_query_var( 'tag' );
    ?>
    <nav class="tag-filter" aria-label="<?php esc_attr_e( 'Filter by topic', 'deep-dive' ); ?>">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>"
        class="tag-filter__item<?php echo ! $current_tag ? ' tag-filter__item--active' : ''; ?>">
        <?php esc_html_e( 'All', 'deep-dive' ); ?>
      </a>
      <?php foreach ( $tags as $tag ) : ?>
        <a href="<?php echo esc_url( get_tag_link( $tag ) ); ?>"
          class="tag-filter__item<?php echo ( $current_tag === $tag->slug ) ? ' tag-filter__item--active' : ''; ?>">
          <?php echo esc_html( $tag->name ); ?>
        </a>
      <?php endforeach; ?>
    </nav>
    <?php endif; ?>

    <!-- Header row -->
    <div class="home-posts__header">
      <h2 class="home-posts__heading"><?php esc_html_e( 'Latest Articles', 'deep-dive' ); ?></h2>
    </div>

    <?php if ( have_posts() ) : ?>
      <div class="post-grid post-grid--3">
        <?php while ( have_posts() ) : the_post(); ?>
          <?php get_template_part( 'template-parts/post-card' ); ?>
        <?php endwhile; ?>
      </div>

      <!-- Pagination -->
      <?php
      the_posts_pagination( [
          'mid_size'  => 2,
          'prev_text' => '&larr; ' . __( 'Newer', 'deep-dive' ),
          'next_text' => __( 'Older', 'deep-dive' ) . ' &rarr;',
          'class'     => 'pagination',
      ] );
      ?>

    <?php else : ?>
      <p class="no-results"><?php esc_html_e( 'No articles found.', 'deep-dive' ); ?></p>
    <?php endif; ?>

  </div><!-- /.container -->
</section><!-- /.home-content -->

<?php get_footer(); ?>
