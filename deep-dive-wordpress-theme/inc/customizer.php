<?php
/**
 * The Deep Dive — Customizer support.
 *
 * Registers theme-specific panels, sections, settings, and controls in the
 * WordPress Customizer, then outputs overriding CSS custom properties via
 * wp_head so every component that uses :root variables responds instantly.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Single source of truth for defaults — used by both add_setting() and get_theme_mod().
define( 'DEEP_DIVE_COLOR_ACCENT',  '#00b4d8' );
define( 'DEEP_DIVE_COLOR_AMBER',   '#f59e0b' );
define( 'DEEP_DIVE_COLOR_BG',      '#0d1117' );
define( 'DEEP_DIVE_COLOR_TEXT',    '#f1f5f9' );
define( 'DEEP_DIVE_FONT_WEIGHT',   '400'     );


// ── Customizer Registration ──────────────────────────────────────────────────

add_action( 'customize_register', 'deep_dive_customize_register' );

function deep_dive_customize_register( WP_Customize_Manager $wp_customize ) {

    $wp_customize->add_panel( 'deep_dive_panel', [
        'title'       => __( 'Deep Dive', 'deep-dive' ),
        'description' => __( 'Theme color and typography options.', 'deep-dive' ),
        'priority'    => 130,
    ] );

    $wp_customize->add_section( 'deep_dive_colors', [
        'title'    => __( 'Colors', 'deep-dive' ),
        'panel'    => 'deep_dive_panel',
        'priority' => 10,
    ] );

    $wp_customize->add_setting( 'deep_dive_accent_color', [
        'default'           => DEEP_DIVE_COLOR_ACCENT,
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'deep_dive_accent_color', [
        'label'       => __( 'Accent Color', 'deep-dive' ),
        'description' => __( 'Primary accent — links, buttons, progress bar.', 'deep-dive' ),
        'section'     => 'deep_dive_colors',
        'priority'    => 10,
    ] ) );

    $wp_customize->add_setting( 'deep_dive_amber_color', [
        'default'           => DEEP_DIVE_COLOR_AMBER,
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'deep_dive_amber_color', [
        'label'       => __( 'Secondary Color', 'deep-dive' ),
        'description' => __( 'Used for tags, featured labels, and highlights.', 'deep-dive' ),
        'section'     => 'deep_dive_colors',
        'priority'    => 20,
    ] ) );

    $wp_customize->add_setting( 'deep_dive_bg_color', [
        'default'           => DEEP_DIVE_COLOR_BG,
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'deep_dive_bg_color', [
        'label'       => __( 'Page Background', 'deep-dive' ),
        'description' => __( 'Darkest background layer (body, header, footer).', 'deep-dive' ),
        'section'     => 'deep_dive_colors',
        'priority'    => 30,
    ] ) );

    $wp_customize->add_setting( 'deep_dive_text_color', [
        'default'           => DEEP_DIVE_COLOR_TEXT,
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'deep_dive_text_color', [
        'label'       => __( 'Body Text Color', 'deep-dive' ),
        'description' => __( 'Primary text on dark backgrounds.', 'deep-dive' ),
        'section'     => 'deep_dive_colors',
        'priority'    => 40,
    ] ) );

    $wp_customize->add_section( 'deep_dive_typography', [
        'title'    => __( 'Typography', 'deep-dive' ),
        'panel'    => 'deep_dive_panel',
        'priority' => 20,
    ] );

    $wp_customize->add_setting( 'deep_dive_body_weight', [
        'default'           => DEEP_DIVE_FONT_WEIGHT,
        'sanitize_callback' => 'deep_dive_sanitize_font_weight',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'deep_dive_body_weight', [
        'type'        => 'select',
        'label'       => __( 'Body Font Weight', 'deep-dive' ),
        'description' => __( 'Weight of the Figtree body font.', 'deep-dive' ),
        'section'     => 'deep_dive_typography',
        'priority'    => 10,
        'choices'     => [
            '300' => __( 'Light (300)', 'deep-dive' ),
            '400' => __( 'Regular (400)', 'deep-dive' ),
            '500' => __( 'Medium (500)', 'deep-dive' ),
        ],
    ] );
}


// ── Helpers ──────────────────────────────────────────────────────────────────

function deep_dive_sanitize_font_weight( $value ) {
    $allowed = [ '300', '400', '500' ];
    return in_array( $value, $allowed, true ) ? $value : DEEP_DIVE_FONT_WEIGHT;
}


// ── Dynamic CSS Output ───────────────────────────────────────────────────────

add_action( 'wp_head', 'deep_dive_customizer_css', 99 );

function deep_dive_customizer_css() {
    if ( is_admin() ) {
        return;
    }

    $accent = get_theme_mod( 'deep_dive_accent_color', DEEP_DIVE_COLOR_ACCENT );
    $amber  = get_theme_mod( 'deep_dive_amber_color',  DEEP_DIVE_COLOR_AMBER  );
    $bg     = get_theme_mod( 'deep_dive_bg_color',     DEEP_DIVE_COLOR_BG     );
    $text   = get_theme_mod( 'deep_dive_text_color',   DEEP_DIVE_COLOR_TEXT   );
    $weight = get_theme_mod( 'deep_dive_body_weight',  DEEP_DIVE_FONT_WEIGHT  );
    ?>
    <style id="deep-dive-customizer-css">
    :root {
        --blue:         <?php echo esc_attr( $accent ); ?>;
        --amber:        <?php echo esc_attr( $amber );  ?>;
        --surface-0:    <?php echo esc_attr( $bg );     ?>;
        --text-primary: <?php echo esc_attr( $text );   ?>;
    }
    body {
        font-weight: <?php echo esc_attr( $weight ); ?>;
    }
    </style>
    <?php
}
