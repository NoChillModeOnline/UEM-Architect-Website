<?php
/**
 * search.php — Search results template
 */

get_header(); ?>

<header class="archive-header">
  <div class="container">
    <div class="archive-header__content">
      <span class="archive-header__label"><?php esc_html_e( 'Search Results', 'deep-dive' ); ?></span>
      <h1 class="archive-header__title">
        <?php printf(
            /* translators: %s: search query */
            esc_html__( 'Results for: %s', 'deep-dive' ),
            '<em>' . esc_html( get_search_query() ) . '</em>'
        ); ?>
      </h1>
      <?php if ( have_posts() ) : ?>
        <span class="archive-header__count">
          <?php printf(
              /* translators: %d: result count */
              esc_html( _n( '%d result', '%d results', $wp_query->found_posts, 'deep-dive' ) ),
              esc_html( number_format_i18n( $wp_query->found_posts ) )
          ); ?>
        </span>
      <?php endif; ?>
    </div>
  </div>
</header>

<section class="home-content">
  <div class="container">

    <?php if ( have_posts() ) : ?>
      <div class="post-grid post-grid--3">
        <?php while ( have_posts() ) : the_post(); ?>
          <?php get_template_part( 'template-parts/post-card' ); ?>
        <?php endwhile; ?>
      </div>

      <?php
      the_posts_pagination( [
          'mid_size'  => 2,
          'prev_text' => '&larr; ' . __( 'Previous', 'deep-dive' ),
          'next_text' => __( 'Next', 'deep-dive' ) . ' &rarr;',
          'class'     => 'pagination',
      ] );
      ?>

    <?php else : ?>
      <div style="text-align:center; padding: 4rem 0;">
        <p class="no-results">
          <?php printf(
              /* translators: %s: search query */
              esc_html__( 'No results found for "%s". Try a different search term.', 'deep-dive' ),
              esc_html( get_search_query() )
          ); ?>
        </p>
        <?php get_search_form(); ?>
      </div>
    <?php endif; ?>

  </div>
</section>

<?php get_footer(); ?>
