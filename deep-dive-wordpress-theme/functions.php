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

// Set excerpt length to 22 words (matches Ghost theme)
function deep_dive_excerpt_length( $length ) {
    return 22;
}
add_filter( 'excerpt_length', 'deep_dive_excerpt_length', 999 );

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
