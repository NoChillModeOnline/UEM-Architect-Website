<?php
/**
 * index.php — WordPress fallback template.
 *
 * WordPress requires this file. In practice, home.php,
 * single.php, archive.php, etc. will take precedence.
 * This handles any case not covered by the template hierarchy.
 */

get_header(); ?>

<section class="home-content">
  <div class="container">

    <div class="home-posts__header">
      <h1 class="home-posts__heading">
        <?php
        if ( is_search() ) {
            printf(
                /* translators: %s: search query */
                esc_html__( 'Search Results for: %s', 'deep-dive' ),
                '<em>' . esc_html( get_search_query() ) . '</em>'
            );
        } else {
            bloginfo( 'name' );
        }
        ?>
      </h1>
    </div>

    <?php if ( have_posts() ) : ?>
      <div class="post-grid post-grid--3">
        <?php while ( have_posts() ) : the_post(); ?>
          <?php get_template_part( 'template-parts/post-card' ); ?>
        <?php endwhile; ?>
      </div>

      <?php
      the_posts_pagination( [
          'mid_size'  => 2,
          'prev_text' => '&larr; ' . __( 'Newer', 'deep-dive' ),
          'next_text' => __( 'Older', 'deep-dive' ) . ' &rarr;',
          'class'     => 'pagination',
      ] );
      ?>

    <?php else : ?>
      <p class="no-results">
        <?php
        if ( is_search() ) {
            esc_html_e( 'No results found. Try a different search term.', 'deep-dive' );
        } else {
            esc_html_e( 'No articles found.', 'deep-dive' );
        }
        ?>
      </p>
    <?php endif; ?>

  </div>
</section>

<?php get_footer(); ?>
