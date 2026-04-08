<?php
/**
 * 404.php — Not found page
 *
 * Mirrors Ghost's error.hbs.
 */

get_header(); ?>

<div class="error-page">
  <div class="container">
    <div class="error-page__content">
      <p class="error-page__code" aria-hidden="true">404</p>
      <h1 class="error-page__title"><?php esc_html_e( 'Page not found', 'deep-dive' ); ?></h1>
      <p class="error-page__description">
        <?php esc_html_e( 'The page you were looking for doesn\'t exist. It may have been moved, deleted, or never existed.', 'deep-dive' ); ?>
      </p>
      <div class="error-page__actions">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn--primary">
          <?php esc_html_e( 'Go to Homepage', 'deep-dive' ); ?>
        </a>
        <button class="btn btn--outline" type="button" onclick="history.back()">
          <?php esc_html_e( 'Go Back', 'deep-dive' ); ?>
        </button>
      </div>
    </div>
  </div>
</div>

<?php get_footer(); ?>
