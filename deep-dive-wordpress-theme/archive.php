<?php
/**
 * archive.php — Category, tag, date, and custom taxonomy archives.
 *
 * Mirrors Ghost's tag.hbs: archive header with image + name + description + count,
 * followed by 3-column post grid with pagination.
 */

get_header();

$term = get_queried_object();
?>

<header class="archive-header">
  <div class="container">

    <?php
    // Tag/category cover image (custom field — set via ACF or similar)
    $cover = ( $term && isset( $term->term_id ) )
        ? get_term_meta( $term->term_id, 'cover_image', true )
        : '';
    if ( $cover ) : ?>
      <img class="archive-header__image"
        src="<?php echo esc_url( $cover ); ?>"
        alt="<?php echo esc_attr( single_term_title( '', false ) ); ?>" />
    <?php endif; ?>

    <div class="archive-header__content">
      <span class="archive-header__label">
        <?php
        if ( is_tag() )      esc_html_e( 'Topic', 'deep-dive' );
        elseif ( is_category() ) esc_html_e( 'Category', 'deep-dive' );
        elseif ( is_author() )   esc_html_e( 'Author', 'deep-dive' );
        elseif ( is_date() )     esc_html_e( 'Archive', 'deep-dive' );
        else                     esc_html_e( 'Archive', 'deep-dive' );
        ?>
      </span>

      <h1 class="archive-header__title">
        <?php the_archive_title(); ?>
      </h1>

      <?php the_archive_description( '<p class="archive-header__description">', '</p>' ); ?>

      <?php if ( $term && isset( $term->count ) ) : ?>
        <span class="archive-header__count">
          <?php printf(
              /* translators: %d: number of articles */
              esc_html( _n( '%d article', '%d articles', $term->count, 'deep-dive' ) ),
              esc_html( $term->count )
          ); ?>
        </span>
      <?php endif; ?>
    </div>

  </div><!-- /.container -->
</header><!-- /.archive-header -->

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
          'prev_text' => '&larr; ' . __( 'Newer', 'deep-dive' ),
          'next_text' => __( 'Older', 'deep-dive' ) . ' &rarr;',
          'class'     => 'pagination',
      ] );
      ?>

    <?php else : ?>
      <p class="no-results"><?php esc_html_e( 'No articles found.', 'deep-dive' ); ?></p>
    <?php endif; ?>

  </div><!-- /.container -->
</section>

<?php get_footer(); ?>
