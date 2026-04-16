<?php
/**
 * The Deep Dive — Customizer support.
 *
 * Registers panels, sections, settings, and controls in the WordPress
 * Customizer, then outputs overriding CSS custom properties via wp_head.
 *
 * Panel structure mirrors Astra's layout for a familiar editing experience:
 *   Global  → Container, Colors, Typography, Buttons
 *   Header  → Primary Header, Primary Menu
 *   Post Types → Blog / Archive, Single Post
 *   General → Sidebar, Scroll To Top
 *   Footer  → Footer Bar
 *   (Deep Dive panel removed — settings folded into Global)
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// ── Defaults ─────────────────────────────────────────────────────────────────

define( 'DEEP_DIVE_COLOR_ACCENT',     '#0369A1' );
define( 'DEEP_DIVE_COLOR_ACCENT_ALT', '#38BDF8' );
define( 'DEEP_DIVE_COLOR_AMBER',      '#f59e0b'  );
define( 'DEEP_DIVE_COLOR_BG',         '#0d1117'  );
define( 'DEEP_DIVE_COLOR_TEXT',       '#f1f5f9'  );
define( 'DEEP_DIVE_COLOR_LINK',       '#38BDF8'  );
define( 'DEEP_DIVE_COLOR_HDR_BG',     '#0d1117'  );
define( 'DEEP_DIVE_COLOR_HDR_TEXT',   '#f1f5f9'  );
define( 'DEEP_DIVE_COLOR_FTR_BG',     '#0d1117'  );
define( 'DEEP_DIVE_COLOR_FTR_TEXT',   '#94a3b8'  );
define( 'DEEP_DIVE_FONT_SIZE_BASE',   '16'       );
define( 'DEEP_DIVE_FONT_WEIGHT',      '400'      );
define( 'DEEP_DIVE_CONTAINER_WIDTH',  '1200'     );


// ── Customizer Registration ───────────────────────────────────────────────────

add_action( 'customize_register', 'deep_dive_customize_register' );

function deep_dive_customize_register( WP_Customize_Manager $wp_customize ) {

    // ── PANEL: Global ────────────────────────────────────────────────────────

    $wp_customize->add_panel( 'deep_dive_global', [
        'title'    => __( 'Global', 'deep-dive' ),
        'priority' => 10,
    ] );

    // Section: Container
    $wp_customize->add_section( 'deep_dive_container', [
        'title'    => __( 'Container', 'deep-dive' ),
        'panel'    => 'deep_dive_global',
        'priority' => 10,
    ] );

    $wp_customize->add_setting( 'deep_dive_container_width', [
        'default'           => DEEP_DIVE_CONTAINER_WIDTH,
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'deep_dive_container_width', [
        'type'        => 'number',
        'label'       => __( 'Content Max Width (px)', 'deep-dive' ),
        'description' => __( 'Maximum width of the main content area.', 'deep-dive' ),
        'section'     => 'deep_dive_container',
        'priority'    => 10,
        'input_attrs' => [
            'min'  => 800,
            'max'  => 1800,
            'step' => 10,
        ],
    ] );

    $wp_customize->add_setting( 'deep_dive_color_scheme', [
        'default'           => 'dark',
        'sanitize_callback' => 'deep_dive_sanitize_color_scheme',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'deep_dive_color_scheme', [
        'type'        => 'select',
        'label'       => __( 'Color Scheme', 'deep-dive' ),
        'description' => __( 'Choose between the dark editorial look or a light reading mode.', 'deep-dive' ),
        'section'     => 'deep_dive_container',
        'priority'    => 20,
        'choices'     => [
            'dark'  => __( 'Dark (default)', 'deep-dive' ),
            'light' => __( 'Light', 'deep-dive' ),
        ],
    ] );

    // Section: Colors
    $wp_customize->add_section( 'deep_dive_colors', [
        'title'    => __( 'Colors', 'deep-dive' ),
        'panel'    => 'deep_dive_global',
        'priority' => 20,
    ] );

    $wp_customize->add_setting( 'deep_dive_accent_color', [
        'default'           => DEEP_DIVE_COLOR_ACCENT,
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'deep_dive_accent_color', [
        'label'       => __( 'Accent Color', 'deep-dive' ),
        'description' => __( 'Primary accent — buttons, progress bar, active states.', 'deep-dive' ),
        'section'     => 'deep_dive_colors',
        'priority'    => 10,
    ] ) );

    $wp_customize->add_setting( 'deep_dive_accent_alt_color', [
        'default'           => DEEP_DIVE_COLOR_ACCENT_ALT,
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'deep_dive_accent_alt_color', [
        'label'       => __( 'Accent Alt Color', 'deep-dive' ),
        'description' => __( 'Lighter accent used in gradients and hover states.', 'deep-dive' ),
        'section'     => 'deep_dive_colors',
        'priority'    => 20,
    ] ) );

    $wp_customize->add_setting( 'deep_dive_amber_color', [
        'default'           => DEEP_DIVE_COLOR_AMBER,
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'deep_dive_amber_color', [
        'label'       => __( 'Secondary / Highlight Color', 'deep-dive' ),
        'description' => __( 'Used for tags, featured labels, and callouts.', 'deep-dive' ),
        'section'     => 'deep_dive_colors',
        'priority'    => 30,
    ] ) );

    $wp_customize->add_setting( 'deep_dive_bg_color', [
        'default'           => DEEP_DIVE_COLOR_BG,
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'deep_dive_bg_color', [
        'label'       => __( 'Page Background', 'deep-dive' ),
        'description' => __( 'Base background color (dark surface-0).', 'deep-dive' ),
        'section'     => 'deep_dive_colors',
        'priority'    => 40,
    ] ) );

    $wp_customize->add_setting( 'deep_dive_text_color', [
        'default'           => DEEP_DIVE_COLOR_TEXT,
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'deep_dive_text_color', [
        'label'       => __( 'Body Text Color', 'deep-dive' ),
        'description' => __( 'Primary text color on dark backgrounds.', 'deep-dive' ),
        'section'     => 'deep_dive_colors',
        'priority'    => 50,
    ] ) );

    $wp_customize->add_setting( 'deep_dive_link_color', [
        'default'           => DEEP_DIVE_COLOR_LINK,
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'deep_dive_link_color', [
        'label'   => __( 'Link Color', 'deep-dive' ),
        'section' => 'deep_dive_colors',
        'priority' => 60,
    ] ) );

    // Section: Typography
    $wp_customize->add_section( 'deep_dive_typography', [
        'title'    => __( 'Typography', 'deep-dive' ),
        'panel'    => 'deep_dive_global',
        'priority' => 30,
    ] );

    $wp_customize->add_setting( 'deep_dive_base_font_size', [
        'default'           => DEEP_DIVE_FONT_SIZE_BASE,
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'deep_dive_base_font_size', [
        'type'        => 'number',
        'label'       => __( 'Base Font Size (px)', 'deep-dive' ),
        'description' => __( 'Sets the root font size — all rem values scale from this.', 'deep-dive' ),
        'section'     => 'deep_dive_typography',
        'priority'    => 10,
        'input_attrs' => [
            'min'  => 12,
            'max'  => 24,
            'step' => 1,
        ],
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
        'priority'    => 20,
        'choices'     => [
            '300' => __( 'Light (300)', 'deep-dive' ),
            '400' => __( 'Regular (400)', 'deep-dive' ),
            '500' => __( 'Medium (500)', 'deep-dive' ),
        ],
    ] );

    $wp_customize->add_setting( 'deep_dive_body_line_height', [
        'default'           => '1.7',
        'sanitize_callback' => 'deep_dive_sanitize_line_height',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'deep_dive_body_line_height', [
        'type'        => 'select',
        'label'       => __( 'Body Line Height', 'deep-dive' ),
        'section'     => 'deep_dive_typography',
        'priority'    => 30,
        'choices'     => [
            '1.4' => '1.4 — Compact',
            '1.6' => '1.6 — Normal',
            '1.7' => '1.7 — Comfortable (default)',
            '1.9' => '1.9 — Spacious',
        ],
    ] );

    // Section: Buttons
    $wp_customize->add_section( 'deep_dive_buttons', [
        'title'    => __( 'Buttons', 'deep-dive' ),
        'panel'    => 'deep_dive_global',
        'priority' => 40,
    ] );

    $wp_customize->add_setting( 'deep_dive_btn_bg_color', [
        'default'           => DEEP_DIVE_COLOR_ACCENT,
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'deep_dive_btn_bg_color', [
        'label'   => __( 'Button Background Color', 'deep-dive' ),
        'section' => 'deep_dive_buttons',
        'priority' => 10,
    ] ) );

    $wp_customize->add_setting( 'deep_dive_btn_text_color', [
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'deep_dive_btn_text_color', [
        'label'   => __( 'Button Text Color', 'deep-dive' ),
        'section' => 'deep_dive_buttons',
        'priority' => 20,
    ] ) );

    $wp_customize->add_setting( 'deep_dive_btn_radius', [
        'default'           => '8',
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'deep_dive_btn_radius', [
        'type'        => 'number',
        'label'       => __( 'Button Border Radius (px)', 'deep-dive' ),
        'section'     => 'deep_dive_buttons',
        'priority'    => 30,
        'input_attrs' => [ 'min' => 0, 'max' => 50, 'step' => 1 ],
    ] );


    // ── PANEL: Header ────────────────────────────────────────────────────────

    $wp_customize->add_panel( 'deep_dive_header_panel', [
        'title'    => __( 'Header', 'deep-dive' ),
        'priority' => 20,
    ] );

    // Move Site Identity into our Header panel
    $wp_customize->get_section( 'title_tagline' )->panel    = 'deep_dive_header_panel';
    $wp_customize->get_section( 'title_tagline' )->priority = 5;

    // Section: Primary Header
    $wp_customize->add_section( 'deep_dive_header_primary', [
        'title'    => __( 'Primary Header', 'deep-dive' ),
        'panel'    => 'deep_dive_header_panel',
        'priority' => 15,
    ] );

    $wp_customize->add_setting( 'deep_dive_header_bg_color', [
        'default'           => DEEP_DIVE_COLOR_HDR_BG,
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'deep_dive_header_bg_color', [
        'label'   => __( 'Header Background Color', 'deep-dive' ),
        'section' => 'deep_dive_header_primary',
        'priority' => 10,
    ] ) );

    $wp_customize->add_setting( 'deep_dive_header_text_color', [
        'default'           => DEEP_DIVE_COLOR_HDR_TEXT,
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'deep_dive_header_text_color', [
        'label'   => __( 'Header Text / Nav Color', 'deep-dive' ),
        'section' => 'deep_dive_header_primary',
        'priority' => 20,
    ] ) );

    $wp_customize->add_setting( 'deep_dive_header_sticky', [
        'default'           => '1',
        'sanitize_callback' => 'deep_dive_sanitize_checkbox',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'deep_dive_header_sticky', [
        'type'    => 'checkbox',
        'label'   => __( 'Sticky Header', 'deep-dive' ),
        'section' => 'deep_dive_header_primary',
        'priority' => 30,
    ] );

    $wp_customize->add_setting( 'deep_dive_header_border_width', [
        'default'           => '0',
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'deep_dive_header_border_width', [
        'type'        => 'number',
        'label'       => __( 'Bottom Border Size (px)', 'deep-dive' ),
        'section'     => 'deep_dive_header_primary',
        'priority'    => 40,
        'input_attrs' => [ 'min' => 0, 'max' => 10, 'step' => 1 ],
    ] );

    $wp_customize->add_setting( 'deep_dive_header_border_color', [
        'default'           => 'rgba(255,255,255,0.08)',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'deep_dive_header_border_color', [
        'label'   => __( 'Bottom Border Color', 'deep-dive' ),
        'section' => 'deep_dive_header_primary',
        'priority' => 50,
    ] ) );

    // Section: Primary Menu
    $wp_customize->add_section( 'deep_dive_primary_menu', [
        'title'    => __( 'Primary Menu', 'deep-dive' ),
        'panel'    => 'deep_dive_header_panel',
        'priority' => 20,
    ] );

    $wp_customize->add_setting( 'deep_dive_menu_item_spacing', [
        'default'           => '24',
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'deep_dive_menu_item_spacing', [
        'type'        => 'number',
        'label'       => __( 'Menu Item Spacing (px)', 'deep-dive' ),
        'description' => __( 'Horizontal padding on each nav link.', 'deep-dive' ),
        'section'     => 'deep_dive_primary_menu',
        'priority'    => 10,
        'input_attrs' => [ 'min' => 8, 'max' => 60, 'step' => 2 ],
    ] );

    $wp_customize->add_setting( 'deep_dive_show_search_icon', [
        'default'           => '1',
        'sanitize_callback' => 'deep_dive_sanitize_checkbox',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'deep_dive_show_search_icon', [
        'type'    => 'checkbox',
        'label'   => __( 'Show Search Icon in Header', 'deep-dive' ),
        'section' => 'deep_dive_primary_menu',
        'priority' => 20,
    ] );


    // ── SECTION GROUP: Post Types ─────────────────────────────────────────────
    // WordPress core doesn't support true nested sections; we use a top-level
    // section that acts as a visual group header, then sub-sections beside it.

    $wp_customize->add_section( 'deep_dive_post_types_group', [
        'title'    => __( 'Post Types', 'deep-dive' ),
        'priority' => 30,
    ] );

    // Sub-section: Blog / Archive
    $wp_customize->add_section( 'deep_dive_blog_archive', [
        'title'    => __( 'Blog / Archive', 'deep-dive' ),
        'priority' => 31,
    ] );

    $wp_customize->add_setting( 'deep_dive_posts_per_page', [
        'default'           => get_option( 'posts_per_page', 10 ),
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'deep_dive_posts_per_page', [
        'type'        => 'number',
        'label'       => __( 'Posts Per Page', 'deep-dive' ),
        'section'     => 'deep_dive_blog_archive',
        'priority'    => 10,
        'input_attrs' => [ 'min' => 1, 'max' => 50, 'step' => 1 ],
    ] );

    $wp_customize->add_setting( 'deep_dive_excerpt_length', [
        'default'           => '22',
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'deep_dive_excerpt_length', [
        'type'        => 'number',
        'label'       => __( 'Excerpt Length (words)', 'deep-dive' ),
        'section'     => 'deep_dive_blog_archive',
        'priority'    => 20,
        'input_attrs' => [ 'min' => 5, 'max' => 100, 'step' => 1 ],
    ] );

    $wp_customize->add_setting( 'deep_dive_archive_show_author', [
        'default'           => '1',
        'sanitize_callback' => 'deep_dive_sanitize_checkbox',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'deep_dive_archive_show_author', [
        'type'    => 'checkbox',
        'label'   => __( 'Show Author on Cards', 'deep-dive' ),
        'section' => 'deep_dive_blog_archive',
        'priority' => 30,
    ] );

    $wp_customize->add_setting( 'deep_dive_archive_show_date', [
        'default'           => '1',
        'sanitize_callback' => 'deep_dive_sanitize_checkbox',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'deep_dive_archive_show_date', [
        'type'    => 'checkbox',
        'label'   => __( 'Show Date on Cards', 'deep-dive' ),
        'section' => 'deep_dive_blog_archive',
        'priority' => 40,
    ] );

    $wp_customize->add_setting( 'deep_dive_archive_show_reading_time', [
        'default'           => '1',
        'sanitize_callback' => 'deep_dive_sanitize_checkbox',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'deep_dive_archive_show_reading_time', [
        'type'    => 'checkbox',
        'label'   => __( 'Show Reading Time on Cards', 'deep-dive' ),
        'section' => 'deep_dive_blog_archive',
        'priority' => 50,
    ] );

    // Sub-section: Single Post
    $wp_customize->add_section( 'deep_dive_single_post', [
        'title'    => __( 'Single Post', 'deep-dive' ),
        'priority' => 32,
    ] );

    $wp_customize->add_setting( 'deep_dive_single_show_featured', [
        'default'           => '1',
        'sanitize_callback' => 'deep_dive_sanitize_checkbox',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'deep_dive_single_show_featured', [
        'type'    => 'checkbox',
        'label'   => __( 'Show Featured Image', 'deep-dive' ),
        'section' => 'deep_dive_single_post',
        'priority' => 10,
    ] );

    $wp_customize->add_setting( 'deep_dive_single_show_author_bio', [
        'default'           => '1',
        'sanitize_callback' => 'deep_dive_sanitize_checkbox',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'deep_dive_single_show_author_bio', [
        'type'    => 'checkbox',
        'label'   => __( 'Show Author Bio Box', 'deep-dive' ),
        'section' => 'deep_dive_single_post',
        'priority' => 20,
    ] );

    $wp_customize->add_setting( 'deep_dive_single_show_comments', [
        'default'           => '1',
        'sanitize_callback' => 'deep_dive_sanitize_checkbox',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'deep_dive_single_show_comments', [
        'type'    => 'checkbox',
        'label'   => __( 'Show Comments Section', 'deep-dive' ),
        'section' => 'deep_dive_single_post',
        'priority' => 30,
    ] );

    $wp_customize->add_setting( 'deep_dive_single_show_reading_time', [
        'default'           => '1',
        'sanitize_callback' => 'deep_dive_sanitize_checkbox',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'deep_dive_single_show_reading_time', [
        'type'    => 'checkbox',
        'label'   => __( 'Show Reading Time', 'deep-dive' ),
        'section' => 'deep_dive_single_post',
        'priority' => 40,
    ] );

    $wp_customize->add_setting( 'deep_dive_single_show_related', [
        'default'           => '1',
        'sanitize_callback' => 'deep_dive_sanitize_checkbox',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'deep_dive_single_show_related', [
        'type'    => 'checkbox',
        'label'   => __( 'Show Related Posts', 'deep-dive' ),
        'section' => 'deep_dive_single_post',
        'priority' => 50,
    ] );


    // ── SECTION GROUP: General ────────────────────────────────────────────────

    $wp_customize->add_section( 'deep_dive_general_group', [
        'title'    => __( 'General', 'deep-dive' ),
        'priority' => 35,
    ] );

    // Sub-section: Sidebar
    $wp_customize->add_section( 'deep_dive_sidebar', [
        'title'    => __( 'Sidebar', 'deep-dive' ),
        'priority' => 36,
    ] );

    $wp_customize->add_setting( 'deep_dive_sidebar_layout', [
        'default'           => 'no-sidebar',
        'sanitize_callback' => 'deep_dive_sanitize_sidebar_layout',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'deep_dive_sidebar_layout', [
        'type'    => 'select',
        'label'   => __( 'Default Layout', 'deep-dive' ),
        'section' => 'deep_dive_sidebar',
        'priority' => 10,
        'choices' => [
            'no-sidebar'    => __( 'No Sidebar', 'deep-dive' ),
            'right-sidebar' => __( 'Right Sidebar', 'deep-dive' ),
            'left-sidebar'  => __( 'Left Sidebar', 'deep-dive' ),
        ],
    ] );

    // Sub-section: Scroll To Top
    $wp_customize->add_section( 'deep_dive_scroll_top', [
        'title'    => __( 'Scroll To Top', 'deep-dive' ),
        'priority' => 37,
    ] );

    $wp_customize->add_setting( 'deep_dive_scroll_top_enable', [
        'default'           => '1',
        'sanitize_callback' => 'deep_dive_sanitize_checkbox',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'deep_dive_scroll_top_enable', [
        'type'    => 'checkbox',
        'label'   => __( 'Enable Scroll To Top Button', 'deep-dive' ),
        'section' => 'deep_dive_scroll_top',
        'priority' => 10,
    ] );

    $wp_customize->add_setting( 'deep_dive_scroll_top_color', [
        'default'           => DEEP_DIVE_COLOR_ACCENT,
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'deep_dive_scroll_top_color', [
        'label'   => __( 'Button Color', 'deep-dive' ),
        'section' => 'deep_dive_scroll_top',
        'priority' => 20,
    ] ) );


    // ── SECTION: Footer ───────────────────────────────────────────────────────

    $wp_customize->add_section( 'deep_dive_footer', [
        'title'    => __( 'Footer', 'deep-dive' ),
        'priority' => 50,
    ] );

    $wp_customize->add_setting( 'deep_dive_footer_bg_color', [
        'default'           => DEEP_DIVE_COLOR_FTR_BG,
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'deep_dive_footer_bg_color', [
        'label'   => __( 'Footer Background Color', 'deep-dive' ),
        'section' => 'deep_dive_footer',
        'priority' => 10,
    ] ) );

    $wp_customize->add_setting( 'deep_dive_footer_text_color', [
        'default'           => DEEP_DIVE_COLOR_FTR_TEXT,
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'deep_dive_footer_text_color', [
        'label'   => __( 'Footer Text Color', 'deep-dive' ),
        'section' => 'deep_dive_footer',
        'priority' => 20,
    ] ) );

    $wp_customize->add_setting( 'deep_dive_footer_copyright', [
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'deep_dive_footer_copyright', [
        'type'        => 'textarea',
        'label'       => __( 'Footer Copyright Text', 'deep-dive' ),
        'description' => __( 'Leave blank to use the default copyright line. HTML allowed.', 'deep-dive' ),
        'section'     => 'deep_dive_footer',
        'priority'    => 30,
    ] );

    $wp_customize->add_setting( 'deep_dive_footer_show_nav', [
        'default'           => '1',
        'sanitize_callback' => 'deep_dive_sanitize_checkbox',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'deep_dive_footer_show_nav', [
        'type'    => 'checkbox',
        'label'   => __( 'Show Footer Navigation', 'deep-dive' ),
        'section' => 'deep_dive_footer',
        'priority' => 40,
    ] );
}


// ── Sanitization Helpers ──────────────────────────────────────────────────────

function deep_dive_sanitize_font_weight( $value ) {
    $allowed = [ '300', '400', '500' ];
    return in_array( $value, $allowed, true ) ? $value : DEEP_DIVE_FONT_WEIGHT;
}

function deep_dive_sanitize_line_height( $value ) {
    $allowed = [ '1.4', '1.6', '1.7', '1.9' ];
    return in_array( $value, $allowed, true ) ? $value : '1.7';
}

function deep_dive_sanitize_checkbox( $value ) {
    return ( '1' === $value || true === $value ) ? '1' : '0';
}

function deep_dive_sanitize_color_scheme( $value ) {
    return in_array( $value, [ 'dark', 'light' ], true ) ? $value : 'dark';
}

function deep_dive_sanitize_sidebar_layout( $value ) {
    $allowed = [ 'no-sidebar', 'right-sidebar', 'left-sidebar' ];
    return in_array( $value, $allowed, true ) ? $value : 'no-sidebar';
}


// ── Dynamic CSS Output ────────────────────────────────────────────────────────

add_action( 'wp_head', 'deep_dive_customizer_css', 99 );

function deep_dive_customizer_css() {
    if ( is_admin() ) {
        return;
    }

    // Global
    $accent      = get_theme_mod( 'deep_dive_accent_color',     DEEP_DIVE_COLOR_ACCENT     );
    $accent_alt  = get_theme_mod( 'deep_dive_accent_alt_color', DEEP_DIVE_COLOR_ACCENT_ALT );
    $amber       = get_theme_mod( 'deep_dive_amber_color',      DEEP_DIVE_COLOR_AMBER      );
    $bg          = get_theme_mod( 'deep_dive_bg_color',         DEEP_DIVE_COLOR_BG         );
    $text        = get_theme_mod( 'deep_dive_text_color',       DEEP_DIVE_COLOR_TEXT       );
    $link        = get_theme_mod( 'deep_dive_link_color',       DEEP_DIVE_COLOR_LINK       );
    $container   = absint( get_theme_mod( 'deep_dive_container_width', DEEP_DIVE_CONTAINER_WIDTH ) );
    $font_size   = absint( get_theme_mod( 'deep_dive_base_font_size',  DEEP_DIVE_FONT_SIZE_BASE  ) );
    $weight      = get_theme_mod( 'deep_dive_body_weight',       DEEP_DIVE_FONT_WEIGHT      );
    $line_height = get_theme_mod( 'deep_dive_body_line_height',  '1.7'                      );
    $scheme      = get_theme_mod( 'deep_dive_color_scheme',      'dark'                     );

    // Buttons
    $btn_bg     = get_theme_mod( 'deep_dive_btn_bg_color',   DEEP_DIVE_COLOR_ACCENT );
    $btn_text   = get_theme_mod( 'deep_dive_btn_text_color', '#ffffff'              );
    $btn_radius = absint( get_theme_mod( 'deep_dive_btn_radius', '8' ) );

    // Header
    $hdr_bg           = get_theme_mod( 'deep_dive_header_bg_color',     DEEP_DIVE_COLOR_HDR_BG   );
    $hdr_text         = get_theme_mod( 'deep_dive_header_text_color',   DEEP_DIVE_COLOR_HDR_TEXT );
    $hdr_border_w     = absint( get_theme_mod( 'deep_dive_header_border_width', '0' ) );
    $hdr_border_color = get_theme_mod( 'deep_dive_header_border_color', 'rgba(255,255,255,0.08)' );
    $menu_spacing     = absint( get_theme_mod( 'deep_dive_menu_item_spacing', '24' ) );

    // Footer
    $ftr_bg   = get_theme_mod( 'deep_dive_footer_bg_color',   DEEP_DIVE_COLOR_FTR_BG   );
    $ftr_text = get_theme_mod( 'deep_dive_footer_text_color', DEEP_DIVE_COLOR_FTR_TEXT );

    // Scroll to top
    $scroll_color = get_theme_mod( 'deep_dive_scroll_top_color', DEEP_DIVE_COLOR_ACCENT );

    // Apply light scheme class to body if selected
    $body_class = ( 'light' === $scheme ) ? 'body { /* light scheme applied via .theme-light class */ }' : '';
    ?>
    <style id="deep-dive-customizer-css">
    :root {
        --blue:         <?php echo esc_attr( $accent );     ?>;
        --light-blue:   <?php echo esc_attr( $accent_alt ); ?>;
        --amber:        <?php echo esc_attr( $amber );      ?>;
        --surface-0:    <?php echo esc_attr( $bg );         ?>;
        --text-primary: <?php echo esc_attr( $text );       ?>;
        --container:    <?php echo esc_attr( $container );  ?>px;
    }
    html {
        font-size: <?php echo esc_attr( $font_size ); ?>px;
    }
    body {
        font-weight: <?php echo esc_attr( $weight );      ?>;
        line-height: <?php echo esc_attr( $line_height ); ?>;
    }
    a { color: <?php echo esc_attr( $link ); ?>; }
    a:hover { color: <?php echo esc_attr( $accent_alt ); ?>; }

    /* Buttons */
    .btn, .wp-block-button__link, button[type="submit"] {
        background-color: <?php echo esc_attr( $btn_bg );     ?>;
        color:            <?php echo esc_attr( $btn_text );   ?>;
        border-radius:    <?php echo esc_attr( $btn_radius ); ?>px;
    }

    /* Header */
    .site-header, header.site-header {
        background-color: <?php echo esc_attr( $hdr_bg );          ?>;
        color:            <?php echo esc_attr( $hdr_text );         ?>;
        border-bottom:    <?php echo esc_attr( $hdr_border_w ); ?>px solid <?php echo esc_attr( $hdr_border_color ); ?>;
    }
    .site-header .nav-link, .site-header a {
        color: <?php echo esc_attr( $hdr_text ); ?>;
    }
    .site-header .nav-link { padding-inline: <?php echo esc_attr( $menu_spacing ); ?>px; }

    /* Footer */
    .site-footer, footer.site-footer {
        background-color: <?php echo esc_attr( $ftr_bg );   ?>;
        color:            <?php echo esc_attr( $ftr_text ); ?>;
    }
    .site-footer a { color: <?php echo esc_attr( $ftr_text ); ?>; }

    /* Scroll to Top */
    .scroll-top { background-color: <?php echo esc_attr( $scroll_color ); ?>; }
    </style>
    <?php

    // Inject light-scheme body class via JS if needed (avoids PHP-side body_class filter complexity)
    if ( 'light' === $scheme ) {
        echo '<script>document.body.classList.add("theme-light");</script>' . "\n";
    }
}


// ── Apply Theme Mods to WordPress Options ─────────────────────────────────────

// Sync posts_per_page WordPress option from customizer setting on save
add_action( 'customize_save_after', 'deep_dive_sync_posts_per_page' );
function deep_dive_sync_posts_per_page() {
    $val = get_theme_mod( 'deep_dive_posts_per_page' );
    if ( $val ) {
        update_option( 'posts_per_page', absint( $val ) );
    }
}

// Sync excerpt length filter from customizer setting
add_filter( 'excerpt_length', 'deep_dive_customizer_excerpt_length', 998 );
function deep_dive_customizer_excerpt_length() {
    return absint( get_theme_mod( 'deep_dive_excerpt_length', 22 ) );
}
