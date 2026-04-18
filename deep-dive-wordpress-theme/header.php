<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />

  <!-- Favicon -->
  <?php if ( has_site_icon() ) : ?>
    <link rel="icon" href="<?php echo esc_url( get_site_icon_url( 32 ) ); ?>" />
  <?php else : ?>
    <link rel="icon" href="<?php echo esc_url( get_template_directory_uri() . '/assets/images/favicon.svg' ); ?>" type="image/svg+xml" />
  <?php endif; ?>

  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<?php wp_body_open(); ?>

<a href="#site-main" class="skip-link"><?php esc_html_e( 'Skip to content', 'deep-dive' ); ?></a>

<!-- Reading progress bar (shown on single posts) -->
<?php if ( is_singular( 'post' ) ) : ?>
<div class="reading-progress" id="reading-progress" aria-hidden="true">
  <div class="reading-progress__bar" id="reading-progress-bar"></div>
</div>
<?php endif; ?>

<!-- ── Site Header ── -->
<header class="site-header" id="site-header">
  <div class="container">
    <div class="site-header__inner">

      <!-- Logo -->
      <div class="site-header__logo">
        <a href="https://www.uemarchitect.org" rel="home" aria-label="<?php bloginfo( 'name' ); ?> — home">
          <?php if ( has_custom_logo() ) :
            the_custom_logo();
          else : ?>
            <span class="site-header__logo-text"><?php bloginfo( 'name' ); ?></span>
          <?php endif; ?>
        </a>
      </div>

      <!-- Primary navigation -->
      <nav class="site-header__nav" aria-label="<?php esc_attr_e( 'Primary navigation', 'deep-dive' ); ?>">
        <?php
        wp_nav_menu( [
            'theme_location' => 'primary',
            'menu_class'     => 'site-nav',
            'container'      => false,
            'items_wrap'     => '<ul id="%1$s" class="%2$s" role="list">%3$s</ul>',
            'walker'         => new Deep_Dive_Nav_Walker(),
            'fallback_cb'    => '__return_false',
        ] );
        ?>
      </nav>

      <!-- Header actions -->
      <div class="site-header__actions">
        <a href="https://www.uemarchitect.org" class="btn btn--outline btn--sm">
          Main Site
        </a>
        <?php if ( get_option( 'users_can_register' ) ) : ?>
          <?php if ( ! is_user_logged_in() ) : ?>
            <a href="<?php echo esc_url( wp_registration_url() ); ?>" class="btn btn--primary btn--sm">Subscribe</a>
          <?php endif; ?>
        <?php endif; ?>

        <!-- Burger -->
        <button class="site-header__burger" id="site-burger" type="button"
          aria-controls="mobile-nav" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle menu', 'deep-dive' ); ?>">
          <span></span><span></span><span></span>
        </button>
      </div>

    </div><!-- /.site-header__inner -->
  </div><!-- /.container -->

  <!-- Mobile nav drawer -->
  <nav class="mobile-nav" id="mobile-nav" aria-label="<?php esc_attr_e( 'Mobile navigation', 'deep-dive' ); ?>" hidden>
    <div class="container">
      <?php
      wp_nav_menu( [
          'theme_location' => 'primary',
          'menu_class'     => 'mobile-nav__list',
          'container'      => false,
          'fallback_cb'    => '__return_false',
      ] );
      ?>
      <ul class="mobile-nav__list mobile-nav__cta">
        <li><a href="https://www.uemarchitect.org">Main Site &rarr;</a></li>
      </ul>
    </div>
  </nav>

</header><!-- /#site-header -->

<main id="site-main">
<?php
/**
 * Nav Walker — adds .site-nav__item class to <li> elements
 * and .site-nav__item--active when the item is current.
 */
class Deep_Dive_Nav_Walker extends Walker_Nav_Menu {
    public function start_el( &$output, $data_object, $depth = 0, $args = null, $current_object_id = 0 ) {
        $item    = $data_object;
        $classes = empty( $item->classes ) ? [] : (array) $item->classes;
        $classes[] = 'site-nav__item';

        if ( in_array( 'current-menu-item', $classes, true ) ) {
            $classes[] = 'site-nav__item--active';
        }

        $class_names = implode( ' ', array_filter( $classes ) );
        $output .= '<li class="' . esc_attr( $class_names ) . '">';

        $atts = [
            'href'   => ! empty( $item->url ) ? $item->url : '',
            'target' => ! empty( $item->target ) ? $item->target : '',
            'rel'    => ! empty( $item->xfn ) ? $item->xfn : '',
            'title'  => ! empty( $item->attr_title ) ? $item->attr_title : '',
        ];

        $attr_str = '';
        foreach ( $atts as $attr => $value ) {
            if ( ! empty( $value ) ) {
                $attr_str .= ' ' . $attr . '="' . esc_attr( $value ) . '"';
            }
        }

        $output .= '<a' . $attr_str . '>';
        $output .= esc_html( $item->title );
        $output .= '</a>';
    }
}
