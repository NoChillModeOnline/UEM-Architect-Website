<?php
/**
 * author.php — Author archive
 *
 * Mirrors Ghost's author.hbs: avatar/initials, bio, links, post count + grid.
 */

get_header();

$author     = get_queried_object();
$author_id  = $author->ID;
$avatar     = get_avatar_url( $author_id, [ 'size' => 160 ] );
$bio        = get_the_author_meta( 'description', $author_id );
$website    = get_the_author_meta( 'user_url', $author_id );
$twitter    = get_the_author_meta( 'twitter', $author_id );
$post_count = count_user_posts( $author_id );
?>

<header class="archive-header">
  <div class="container">
    <div class="archive-header__content archive-header__content--author">

      <!-- Avatar -->
      <?php if ( $avatar ) : ?>
        <img class="archive-header__author-avatar"
          src="<?php echo esc_url( $avatar ); ?>"
          alt="<?php echo esc_attr( $author->display_name ); ?>"
          width="80" height="80" />
      <?php else : ?>
        <span class="archive-header__author-initials" aria-hidden="true">
          <?php echo esc_html( deep_dive_initials( $author_id ) ); ?>
        </span>
      <?php endif; ?>

      <div>
        <span class="archive-header__label"><?php esc_html_e( 'Author', 'deep-dive' ); ?></span>
        <h1 class="archive-header__title"><?php echo esc_html( $author->display_name ); ?></h1>

        <?php if ( $bio ) : ?>
          <p class="archive-header__description"><?php echo esc_html( $bio ); ?></p>
        <?php endif; ?>

        <span class="archive-header__count">
          <?php printf(
              esc_html( _n( '%d article', '%d articles', $post_count, 'deep-dive' ) ),
              esc_html( $post_count )
          ); ?>
        </span>

        <div class="archive-header__author-links">
          <?php if ( $website ) : ?>
            <a href="<?php echo esc_url( $website ); ?>" target="_blank" rel="noopener noreferrer">
              <?php esc_html_e( 'Website', 'deep-dive' ); ?>
            </a>
          <?php endif; ?>
          <?php if ( $twitter ) : ?>
            <a href="https://twitter.com/<?php echo esc_attr( ltrim( $twitter, '@' ) ); ?>" target="_blank" rel="noopener noreferrer">
              <?php echo esc_html( '@' . ltrim( $twitter, '@' ) ); ?>
            </a>
          <?php endif; ?>
        </div>
      </div>

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
          'prev_text' => '&larr; ' . __( 'Newer', 'deep-dive' ),
          'next_text' => __( 'Older', 'deep-dive' ) . ' &rarr;',
          'class'     => 'pagination',
      ] );
      ?>

    <?php else : ?>
      <p class="no-results"><?php esc_html_e( 'No articles found.', 'deep-dive' ); ?></p>
    <?php endif; ?>

  </div>
</section>

<?php get_footer(); ?>
