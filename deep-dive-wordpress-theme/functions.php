<?php
/**
 * The Deep Dive — functions.php
 * Theme setup, asset enqueuing, and helper functions.
 */

// ── Theme Setup ────────────────────────────────────────────────────────────

function deep_dive_setup() {
    // Let WordPress manage the document title
    add_theme_support( 'title-tag' );

    // Enable featured images on posts/pages
    add_theme_support( 'post-thumbnails' );

    // HTML5 markup for core elements
    add_theme_support( 'html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ] );

    // Custom logo in Customizer
    add_theme_support( 'custom-logo', [
        'height'      => 72,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ] );

    // Gutenberg wide/full alignment support
    add_theme_support( 'align-wide' );

    // Gutenberg block editor styles
    add_theme_support( 'editor-styles' );
    add_editor_style( 'assets/css/screen.css' );

    // Register navigation menus
    register_nav_menus( [
        'primary'  => __( 'Primary Navigation', 'deep-dive' ),
        'footer'   => __( 'Footer Navigation', 'deep-dive' ),
    ] );

    // Automatic feed links
    add_theme_support( 'automatic-feed-links' );
}
add_action( 'after_setup_theme', 'deep_dive_setup' );

// Customizer panels, settings, controls, and dynamic CSS output
require_once get_template_directory() . '/inc/customizer.php';


// ── Enqueue Assets ─────────────────────────────────────────────────────────

function deep_dive_enqueue_assets() {
    $uri = get_template_directory_uri();
    $ver = '1.0.0';

    // Google Fonts
    wp_enqueue_style(
        'deep-dive-fonts',
        'https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=Figtree:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&display=swap',
        [],
        null
    );

    // Main stylesheet
    wp_enqueue_style(
        'deep-dive-screen',
        $uri . '/assets/css/screen.css',
        [ 'deep-dive-fonts' ],
        $ver
    );

    // Main JS
    wp_enqueue_script(
        'deep-dive-main',
        $uri . '/assets/js/main.js',
        [],
        $ver,
        true   // load in footer
    );
}
add_action( 'wp_enqueue_scripts', 'deep_dive_enqueue_assets' );


// ── Excerpt ─────────────────────────────────────────────────────────────────
// Excerpt length is now controlled by the Customizer (deep_dive_excerpt_length).

// Use '…' as the excerpt "more" string
function deep_dive_excerpt_more( $more ) {
    return '&hellip;';
}
add_filter( 'excerpt_more', 'deep_dive_excerpt_more' );


// ── Reading Time ─────────────────────────────────────────────────────────────

/**
 * Calculate reading time for a post.
 *
 * @param int|null $post_id Defaults to current post.
 * @return string e.g. "4 min read"
 */
function deep_dive_reading_time( $post_id = null ) {
    $post_id  = $post_id ?: get_the_ID();
    $content  = get_post_field( 'post_content', $post_id );
    $words    = str_word_count( wp_strip_all_tags( $content ) );
    $minutes  = max( 1, (int) round( $words / 200 ) );
    return $minutes . ' min read';
}


// ── Author Initials ──────────────────────────────────────────────────────────

/**
 * Get 1–2 letter initials for a user.
 *
 * @param int $user_id
 * @return string
 */
function deep_dive_initials( $user_id ) {
    $name  = get_the_author_meta( 'display_name', $user_id );
    $parts = explode( ' ', trim( $name ) );
    $init  = strtoupper( $parts[0][0] ?? 'A' );
    if ( isset( $parts[1] ) ) {
        $init .= strtoupper( $parts[1][0] );
    }
    return $init;
}


// ── Post Classes ─────────────────────────────────────────────────────────────

// Add custom body classes for template identification
function deep_dive_body_classes( $classes ) {
    if ( is_singular() ) {
        $classes[] = 'is-singular';
    }
    return $classes;
}
add_filter( 'body_class', 'deep_dive_body_classes' );


// ── Widget Areas ─────────────────────────────────────────────────────────────

function deep_dive_widgets_init() {
    register_sidebar( [
        'name'          => __( 'Sidebar', 'deep-dive' ),
        'id'            => 'sidebar-1',
        'description'   => __( 'Add widgets here.', 'deep-dive' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ] );
}
add_action( 'widgets_init', 'deep_dive_widgets_init' );


// ── Image Sizes ──────────────────────────────────────────────────────────────

add_image_size( 'deep-dive-hero',    1200, 630,  true ); // Featured hero
add_image_size( 'deep-dive-card',    800,  450,  true ); // Post card (16:9)
add_image_size( 'deep-dive-archive', 1200, 400,  true ); // Archive header banner


// ── Featured Post Meta Box ───────────────────────────────────────────────────

/**
 * Register the "Featured Post" meta box on the post edit screen.
 * Sets the _is_featured meta key queried in home.php.
 */
function deep_dive_register_featured_meta_box() {
    add_meta_box(
        'deep-dive-featured',
        __( 'Featured Post', 'deep-dive' ),
        'deep_dive_featured_meta_box_html',
        'post',
        'side',
        'high'
    );
}
add_action( 'add_meta_boxes', 'deep_dive_register_featured_meta_box' );

function deep_dive_featured_meta_box_html( $post ) {
    wp_nonce_field( 'deep_dive_featured_nonce', '_deep_dive_featured_nonce' );
    $is_featured = get_post_meta( $post->ID, '_is_featured', true );
    ?>
    <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
        <input type="checkbox" name="deep_dive_is_featured" value="1"
            <?php checked( $is_featured, '1' ); ?> />
        <?php esc_html_e( 'Show as featured post on homepage', 'deep-dive' ); ?>
    </label>
    <?php
}

function deep_dive_save_featured_meta( $post_id ) {
    // Verify nonce
    if ( ! isset( $_POST['_deep_dive_featured_nonce'] ) ||
         ! wp_verify_nonce( sanitize_key( $_POST['_deep_dive_featured_nonce'] ), 'deep_dive_featured_nonce' ) ) {
        return;
    }
    // Bail on autosave
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    if ( ! empty( $_POST['deep_dive_is_featured'] ) ) {
        update_post_meta( $post_id, '_is_featured', '1' );
    } else {
        delete_post_meta( $post_id, '_is_featured' );
    }
}
add_action( 'save_post', 'deep_dive_save_featured_meta' );


// ── Nav Menu: Strip target="_blank" from Main Site link ─────────────────────

/**
 * Remove target="_blank" from the "Main Site" nav menu item so it opens
 * in the same tab. WordPress stores this as menu item metadata and adds
 * it via the nav_menu_link_attributes filter.
 */
function deep_dive_remove_main_site_new_tab( $atts, $item ) {
    if ( isset( $atts['href'] ) && strpos( $atts['href'], 'uemarchitect.org' ) !== false ) {
        unset( $atts['target'] );
        unset( $atts['rel'] );
    }
    return $atts;
}
add_filter( 'nav_menu_link_attributes', 'deep_dive_remove_main_site_new_tab', 10, 2 );


// ── Comment Callback ─────────────────────────────────────────────────────────

/**
 * Custom comment template callback — styled for the dark editorial design.
 *
 * @param WP_Comment $comment
 * @param array      $args
 * @param int        $depth
 */
function deep_dive_comment( $comment, $args, $depth ) {
    $avatar      = get_avatar_url( $comment, [ 'size' => 88 ] );
    $author_url  = get_comment_author_url( $comment );
    $author_name = get_comment_author( $comment );
    ?>
    <li id="comment-<?php comment_ID(); ?>" <?php comment_class( 'comment-item' ); ?>>
      <article class="comment-body">
        <div class="comment-author-wrap">
          <?php if ( $avatar ) : ?>
            <img class="comment-avatar" src="<?php echo esc_url( $avatar ); ?>"
              alt="<?php echo esc_attr( $author_name ); ?>" width="44" height="44" />
          <?php endif; ?>
          <div>
            <span class="comment-author-name">
              <?php if ( $author_url ) : ?>
                <a href="<?php echo esc_url( $author_url ); ?>" rel="nofollow"><?php echo esc_html( $author_name ); ?></a>
              <?php else : ?>
                <?php echo esc_html( $author_name ); ?>
              <?php endif; ?>
            </span>
            <time class="comment-date" datetime="<?php comment_date( 'c' ); ?>">
              <?php comment_date( get_option( 'date_format' ) ); ?>
            </time>
          </div>
        </div>

        <?php if ( '0' === $comment->comment_approved ) : ?>
          <p class="comment-awaiting-moderation">
            <?php esc_html_e( 'Your comment is awaiting moderation.', 'deep-dive' ); ?>
          </p>
        <?php endif; ?>

        <div class="comment-content">
          <?php comment_text(); ?>
        </div>

        <div class="comment-reply">
          <?php
          comment_reply_link( array_merge( $args, [
              'add_below' => 'comment',
              'depth'     => $depth,
              'max_depth' => $args['max_depth'],
          ] ) );
          ?>
        </div>
      </article>
    <?php
    // Note: closing </li> is handled by WordPress
}
