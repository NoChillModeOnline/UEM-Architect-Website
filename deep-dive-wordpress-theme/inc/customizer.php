<?php
/**
 * The Deep Dive — Customizer support.
 *
 * Registers theme-specific panels, sections, settings, and controls in the
 * WordPress Customizer, then outputs overriding CSS custom properties via
 * wp_head so every component that uses :root variables responds instantly.
 *
 * Pattern borrowed from Astra theme's customize_register + dynamic CSS approach.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


// ── Register Customizer Panels / Sections / Settings / Controls ─────────────

add_action( 'customize_register', 'deep_dive_customize_register' );

function deep_dive_customize_register( WP_Customize_Manager $wp_customize ) {

    // ── Panel ────────────────────────────────────────────────────────────────

    $wp_customize->add_panel( 'deep_dive_panel', [
        'title'       => __( 'Deep Dive', 'deep-dive' ),
        'description' => __( 'Theme color and typography options.', 'deep-dive' ),
        'priority'    => 130,
    ] );


    // ── Colors Section ───────────────────────────────────────────────────────

    $wp_customize->add_section( 'deep_dive_colors', [
        'title'    => __( 'Colors', 'deep-dive' ),
        'panel'    => 'deep_dive_panel',
        'priority' => 10,
    ] );

    // Accent color — maps to --blue
    $wp_customize->add_setting( 'deep_dive_accent_color', [
        'default'           => '#00b4d8',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'deep_dive_accent_color', [
        'label'       => __( 'Accent Color', 'deep-dive' ),
        'description' => __( 'Primary accent — links, buttons, progress bar.', 'deep-dive' ),
        'section'     => 'deep_dive_colors',
        'priority'    => 10,
    ] ) );

    // Secondary / amber color — maps to --amber
    $wp_customize->add_setting( 'deep_dive_amber_color', [
        'default'           => '#f59e0b',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'deep_dive_amber_color', [
        'label'       => __( 'Secondary Color', 'deep-dive' ),
        'description' => __( 'Used for tags, featured labels, and highlights.', 'deep-dive' ),
        'section'     => 'deep_dive_colors',
        'priority'    => 20,
    ] ) );

    // Page background — maps to --surface-0
    $wp_customize->add_setting( 'deep_dive_bg_color', [
        'default'           => '#0d1117',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'deep_dive_bg_color', [
        'label'       => __( 'Page Background', 'deep-dive' ),
        'description' => __( 'Darkest background layer (body, header, footer).', 'deep-dive' ),
        'section'     => 'deep_dive_colors',
        'priority'    => 30,
    ] ) );

    // Body text — maps to --text-primary
    $wp_customize->add_setting( 'deep_dive_text_color', [
        'default'           => '#f1f5f9',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'deep_dive_text_color', [
        'label'       => __( 'Body Text Color', 'deep-dive' ),
        'description' => __( 'Primary text on dark backgrounds.', 'deep-dive' ),
        'section'     => 'deep_dive_colors',
        'priority'    => 40,
    ] ) );


    // ── Typography Section ───────────────────────────────────────────────────

    $wp_customize->add_section( 'deep_dive_typography', [
        'title'    => __( 'Typography', 'deep-dive' ),
        'panel'    => 'deep_dive_panel',
        'priority' => 20,
    ] );

    // Body font weight
    $wp_customize->add_setting( 'deep_dive_body_weight', [
        'default'           => '400',
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


// ── Sanitize font weight select ──────────────────────────────────────────────

function deep_dive_sanitize_font_weight( $value ) {
    $allowed = [ '300', '400', '500' ];
    return in_array( $value, $allowed, true ) ? $value : '400';
}


// ── Output Dynamic CSS to Override :root Variables ───────────────────────────

add_action( 'wp_head', 'deep_dive_customizer_css', 99 );

function deep_dive_customizer_css() {
    $accent = get_theme_mod( 'deep_dive_accent_color', '#00b4d8' );
    $amber  = get_theme_mod( 'deep_dive_amber_color',  '#f59e0b' );
    $bg     = get_theme_mod( 'deep_dive_bg_color',     '#0d1117' );
    $text   = get_theme_mod( 'deep_dive_text_color',   '#f1f5f9' );
    $weight = deep_dive_sanitize_font_weight( get_theme_mod( 'deep_dive_body_weight', '400' ) );
    ?>
    <style id="deep-dive-customizer-css">
    :root {
        --blue:         <?php echo sanitize_hex_color( $accent ); ?>;
        --amber:        <?php echo sanitize_hex_color( $amber );  ?>;
        --surface-0:    <?php echo sanitize_hex_color( $bg );     ?>;
        --text-primary: <?php echo sanitize_hex_color( $text );   ?>;
    }
    body {
        font-weight: <?php echo esc_attr( $weight ); ?>;
    }
    </style>
    <?php
}
