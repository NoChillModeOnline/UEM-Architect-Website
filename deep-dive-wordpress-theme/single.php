<?php
/**
 * single.php — Individual post view
 *
 * Mirrors Ghost's post.hbs: reading progress, header,
 * feature image, content, tags, author card, newsletter CTA, related posts.
 */

get_header();

if ( have_posts() ) : while ( have_posts() ) : the_post();

    $author_id   = get_the_author_meta( 'ID' );
    $avatar      = get_avatar_url( $author_id, [ 'size' => 88 ] );
    $tags        = get_the_tags();
    $first_tag   = $tags ? $tags[0] : null;
    $author_url  = get_author_posts_url( $author_id );
    $author_bio  = get_the_author_meta( 'description' );
    $author_web  = get_the_author_meta( 'user_url' );
?>

<article <?php post_class( 'post-full' ); ?> id="post-<?php the_ID(); ?>">

  <!-- ── Post Header ── -->
  <header class="post-full-header">
    <div class="container--narrow">

      <?php if ( $first_tag ) : ?>
        <a class="post-full-tag" href="<?php echo esc_url( get_tag_link( $first_tag ) ); ?>">
          <?php echo esc_html( $first_tag->name ); ?>
        </a>
      <?php endif; ?>

      <h1 class="post-full-title"><?php the_title(); ?></h1>

      <?php if ( has_excerpt() ) : ?>
        <p class="post-full-excerpt"><?php the_excerpt(); ?></p>
      <?php endif; ?>

      <div class="post-full-meta">
        <!-- Author -->
        <div class="post-full-author">
          <?php if ( $avatar ) : ?>
            <a href="<?php echo esc_url( $author_url ); ?>">
              <img class="post-full-author__avatar" src="<?php echo esc_url( $avatar ); ?>"
                alt="<?php echo esc_attr( get_the_author() ); ?>" width="44" height="44" />
            </a>
          <?php else : ?>
            <a href="<?php echo esc_url( $author_url ); ?>" class="post-full-author__initials" aria-label="<?php echo esc_attr( get_the_author() ); ?>">
              <?php echo esc_html( deep_dive_initials( $author_id ) ); ?>
            </a>
          <?php endif; ?>

          <div>
            <span class="post-full-author__name">
              <a href="<?php echo esc_url( $author_url ); ?>"><?php the_author(); ?></a>
            </span>
            <div class="post-full-author__details">
              <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
                <?php echo esc_html( get_the_date() ); ?>
              </time>
              <span aria-hidden="true">&middot;</span>
              <span><?php echo esc_html( deep_dive_reading_time() ); ?></span>
            </div>
          </div>
        </div><!-- /.post-full-author -->

        <!-- Share button -->
        <button class="share-btn" id="share-btn" type="button"
          data-url="<?php echo esc_attr( get_permalink() ); ?>"
          data-title="<?php echo esc_attr( get_the_title() ); ?>">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="16" height="16" aria-hidden="true">
            <path d="M13 4.5a2.5 2.5 0 11.702 1.737L6.97 9.604a2.518 2.518 0 010 .792l6.733 3.367a2.5 2.5 0 11-.671 1.341l-6.733-3.367a2.5 2.5 0 110-3.475l6.733-3.366A2.52 2.52 0 0113 4.5z"/>
          </svg>
          <?php esc_html_e( 'Share', 'deep-dive' ); ?>
        </button>

      </div><!-- /.post-full-meta -->
    </div><!-- /.container--narrow -->
  </header><!-- /.post-full-header -->

  <!-- ── Feature Image ── -->
  <?php if ( has_post_thumbnail() ) : ?>
    <figure class="post-full-image">
      <?php the_post_thumbnail( 'deep-dive-hero', [ 'alt' => '' ] ); ?>
      <?php $caption = get_the_post_thumbnail_caption(); if ( $caption ) : ?>
        <figcaption><?php echo esc_html( $caption ); ?></figcaption>
      <?php endif; ?>
    </figure>
  <?php endif; ?>

  <!-- ── Post Content ── -->
  <div class="post-full-content">
    <div class="container--narrow">
      <div class="entry-content">
        <?php the_content(); ?>
      </div>
    </div>
  </div>

  <!-- ── Post Footer ── -->
  <footer class="post-full-footer">
    <div class="container--narrow">

      <?php if ( $tags ) : ?>
        <div class="post-full-tags">
          <span class="post-full-tags__label"><?php esc_html_e( 'Tags:', 'deep-dive' ); ?></span>
          <?php foreach ( $tags as $tag ) : ?>
            <a class="post-full-tags__tag" href="<?php echo esc_url( get_tag_link( $tag ) ); ?>">
              <?php echo esc_html( $tag->name ); ?>
            </a>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

      <div class="post-full-divider"></div>

      <!-- Author card -->
      <div class="author-card">
        <div class="author-card__image-link">
          <?php if ( $avatar ) : ?>
            <a href="<?php echo esc_url( $author_url ); ?>">
              <img class="author-card__image" src="<?php echo esc_url( $avatar ); ?>"
                alt="<?php echo esc_attr( get_the_author() ); ?>" width="64" height="64" />
            </a>
          <?php else : ?>
            <span class="author-card__initials"><?php echo esc_html( deep_dive_initials( $author_id ) ); ?></span>
          <?php endif; ?>
        </div>

        <div class="author-card__body">
          <a class="author-card__name" href="<?php echo esc_url( $author_url ); ?>">
            <?php the_author(); ?>
          </a>
          <?php if ( $author_bio ) : ?>
            <p class="author-card__bio"><?php echo esc_html( $author_bio ); ?></p>
          <?php endif; ?>
          <?php if ( $author_web ) : ?>
            <a class="author-card__link" href="<?php echo esc_url( $author_web ); ?>" target="_blank" rel="noopener noreferrer">
              <?php esc_html_e( 'More articles', 'deep-dive' ); ?>
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="14" height="14" aria-hidden="true">
                <path fill-rule="evenodd" d="M3 10a.75.75 0 01.75-.75h10.638L10.23 5.29a.75.75 0 111.04-1.08l5.5 5.25a.75.75 0 010 1.08l-5.5 5.25a.75.75 0 11-1.04-1.08l4.158-3.96H3.75A.75.75 0 013 10z" clip-rule="evenodd"/>
              </svg>
            </a>
          <?php endif; ?>
        </div>
      </div><!-- /.author-card -->

      <!-- Newsletter CTA -->
      <div class="post-subscribe-cta">
        <div class="post-subscribe-cta__icon" aria-hidden="true">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="24" height="24">
            <path d="M1.5 8.67v8.58a3 3 0 003 3h15a3 3 0 003-3V8.67l-8.928 5.493a3 3 0 01-3.144 0L1.5 8.67z"/>
            <path d="M22.5 6.908V6.75a3 3 0 00-3-3h-15a3 3 0 00-3 3v.158l9.714 5.978a1.5 1.5 0 001.572 0L22.5 6.908z"/>
          </svg>
        </div>
        <h3 class="post-subscribe-cta__heading"><?php esc_html_e( 'Enjoyed this article?', 'deep-dive' ); ?></h3>
        <p class="post-subscribe-cta__text">
          <?php esc_html_e( 'Get endpoint management insights delivered straight to your inbox. Join IT pros who trust The Deep Dive.', 'deep-dive' ); ?>
        </p>
        <?php if ( get_option( 'users_can_register' ) ) : ?>
          <a href="<?php echo esc_url( wp_registration_url() ); ?>" class="btn btn--primary">
            <?php esc_html_e( 'Subscribe for free', 'deep-dive' ); ?>
          </a>
        <?php endif; ?>
      </div>

    </div><!-- /.container--narrow -->
  </footer><!-- /.post-full-footer -->

</article><!-- /.post-full -->

<!-- ── Related Posts ── -->
<?php
$related_args = [
    'posts_per_page'      => 3,
    'post__not_in'        => [ get_the_ID() ],
    'post_status'         => 'publish',
    'ignore_sticky_posts' => 1,
];

// If the post has tags, prefer posts with the same tags
if ( $tags ) {
    $related_args['tag__in'] = array_column( $tags, 'term_id' );
}

$related_query = new WP_Query( $related_args );

if ( $related_query->have_posts() ) : ?>
<section class="related-posts">
  <div class="container">
    <h2 class="related-posts__heading"><?php esc_html_e( 'You might also like', 'deep-dive' ); ?></h2>
    <div class="post-grid post-grid--3">
      <?php while ( $related_query->have_posts() ) : $related_query->the_post(); ?>
        <?php get_template_part( 'template-parts/post-card' ); ?>
      <?php endwhile; ?>
    </div>
  </div>
</section>
<?php
    wp_reset_postdata();
endif;

endwhile; endif;

get_footer();
?>
