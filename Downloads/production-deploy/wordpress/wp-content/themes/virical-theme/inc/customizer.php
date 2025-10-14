<?php
/**
 * Virical Theme Customizer
 *
 * @package Virical
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer
 */
function aura_customize_register( $wp_customize ) {
    $wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
    $wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
    $wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

    if ( isset( $wp_customize->selective_refresh ) ) {
        $wp_customize->selective_refresh->add_partial(
            'blogname',
            array(
                'selector'        => '.site-title a',
                'render_callback' => 'aura_customize_partial_blogname',
            )
        );
        $wp_customize->selective_refresh->add_partial(
            'blogdescription',
            array(
                'selector'        => '.site-description',
                'render_callback' => 'aura_customize_partial_blogdescription',
            )
        );
    }

    /**
     * Theme Options Panel
     */
    $wp_customize->add_panel( 'aura_theme_options', array(
        'title'    => __( 'Theme Options', 'aura-lighting' ),
        'priority' => 130,
    ) );

    /**
     * Colors Section
     */
    $wp_customize->add_section( 'aura_colors', array(
        'title'    => __( 'Colors', 'aura-lighting' ),
        'panel'    => 'aura_theme_options',
        'priority' => 10,
    ) );

    // Primary Color
    $wp_customize->add_setting( 'aura_primary_color', array(
        'default'           => '#d94948',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'aura_primary_color', array(
        'label'    => __( 'Primary Color', 'aura-lighting' ),
        'section'  => 'aura_colors',
        'settings' => 'aura_primary_color',
    ) ) );

    // Secondary Color
    $wp_customize->add_setting( 'aura_secondary_color', array(
        'default'           => '#e93333',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'aura_secondary_color', array(
        'label'    => __( 'Secondary Color', 'aura-lighting' ),
        'section'  => 'aura_colors',
        'settings' => 'aura_secondary_color',
    ) ) );

    /**
     * Header Section
     */
    $wp_customize->add_section( 'aura_header', array(
        'title'    => __( 'Header', 'aura-lighting' ),
        'panel'    => 'aura_theme_options',
        'priority' => 20,
    ) );

    // Transparent Header
    $wp_customize->add_setting( 'aura_transparent_header', array(
        'default'           => true,
        'sanitize_callback' => 'aura_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'aura_transparent_header', array(
        'type'     => 'checkbox',
        'label'    => __( 'Enable Transparent Header on Homepage', 'aura-lighting' ),
        'section'  => 'aura_header',
        'settings' => 'aura_transparent_header',
    ) );

    // Sticky Header
    $wp_customize->add_setting( 'aura_sticky_header', array(
        'default'           => true,
        'sanitize_callback' => 'aura_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'aura_sticky_header', array(
        'type'     => 'checkbox',
        'label'    => __( 'Enable Sticky Header', 'aura-lighting' ),
        'section'  => 'aura_header',
        'settings' => 'aura_sticky_header',
    ) );

    /**
     * Footer Section
     */
    $wp_customize->add_section( 'aura_footer', array(
        'title'    => __( 'Footer', 'aura-lighting' ),
        'panel'    => 'aura_theme_options',
        'priority' => 30,
    ) );

    // Footer Copyright Text
    $wp_customize->add_setting( 'aura_footer_copyright', array(
        'default'           => sprintf( __( '&copy; %1$s %2$s. All rights reserved.', 'aura-lighting' ), date( 'Y' ), get_bloginfo( 'name' ) ),
        'sanitize_callback' => 'wp_kses_post',
        'transport'         => 'postMessage',
    ) );

    $wp_customize->add_control( 'aura_footer_copyright', array(
        'type'     => 'textarea',
        'label'    => __( 'Footer Copyright Text', 'aura-lighting' ),
        'section'  => 'aura_footer',
        'settings' => 'aura_footer_copyright',
    ) );

    // Footer Background Color
    $wp_customize->add_setting( 'aura_footer_bg_color', array(
        'default'           => '#011627',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'aura_footer_bg_color', array(
        'label'    => __( 'Footer Background Color', 'aura-lighting' ),
        'section'  => 'aura_footer',
        'settings' => 'aura_footer_bg_color',
    ) ) );

    /**
     * Typography Section
     */
    $wp_customize->add_section( 'aura_typography', array(
        'title'    => __( 'Typography', 'aura-lighting' ),
        'panel'    => 'aura_theme_options',
        'priority' => 40,
    ) );

    // Body Font Size
    $wp_customize->add_setting( 'aura_body_font_size', array(
        'default'           => '15',
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ) );

    $wp_customize->add_control( 'aura_body_font_size', array(
        'type'        => 'number',
        'label'       => __( 'Body Font Size (px)', 'aura-lighting' ),
        'section'     => 'aura_typography',
        'settings'    => 'aura_body_font_size',
        'input_attrs' => array(
            'min'  => 12,
            'max'  => 24,
            'step' => 1,
        ),
    ) );

    /**
     * Layout Section
     */
    $wp_customize->add_section( 'aura_layout', array(
        'title'    => __( 'Layout', 'aura-lighting' ),
        'panel'    => 'aura_theme_options',
        'priority' => 50,
    ) );

    // Container Width
    $wp_customize->add_setting( 'aura_container_width', array(
        'default'           => '1240',
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ) );

    $wp_customize->add_control( 'aura_container_width', array(
        'type'        => 'number',
        'label'       => __( 'Container Width (px)', 'aura-lighting' ),
        'section'     => 'aura_layout',
        'settings'    => 'aura_container_width',
        'input_attrs' => array(
            'min'  => 960,
            'max'  => 1920,
            'step' => 10,
        ),
    ) );

    /**
     * Social Links Section
     */
    $wp_customize->add_section( 'aura_social_links', array(
        'title'    => __( 'Social Links', 'aura-lighting' ),
        'panel'    => 'aura_theme_options',
        'priority' => 60,
    ) );

    // Social platforms
    $social_platforms = array(
        'facebook'  => __( 'Facebook URL', 'aura-lighting' ),
        'twitter'   => __( 'Twitter URL', 'aura-lighting' ),
        'instagram' => __( 'Instagram URL', 'aura-lighting' ),
        'linkedin'  => __( 'LinkedIn URL', 'aura-lighting' ),
        'youtube'   => __( 'YouTube URL', 'aura-lighting' ),
    );

    foreach ( $social_platforms as $platform => $label ) {
        $wp_customize->add_setting( 'aura_social_' . $platform, array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ) );

        $wp_customize->add_control( 'aura_social_' . $platform, array(
            'type'     => 'url',
            'label'    => $label,
            'section'  => 'aura_social_links',
            'settings' => 'aura_social_' . $platform,
        ) );
    }
}
add_action( 'customize_register', 'aura_customize_register' );

/**
 * Render the site title for the selective refresh partial
 */
function aura_customize_partial_blogname() {
    bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial
 */
function aura_customize_partial_blogdescription() {
    bloginfo( 'description' );
}

/**
 * Sanitize checkbox
 */
function aura_sanitize_checkbox( $checked ) {
    return ( ( isset( $checked ) && true == $checked ) ? true : false );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously
 */
function aura_customize_preview_js() {
    wp_enqueue_script( 'aura-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), AURA_THEME_VERSION, true );
}
add_action( 'customize_preview_init', 'aura_customize_preview_js' );

/**
 * Add custom CSS based on customizer settings
 */
function aura_customizer_css() {
    $primary_color    = get_theme_mod( 'aura_primary_color', '#d94948' );
    $secondary_color  = get_theme_mod( 'aura_secondary_color', '#e93333' );
    $footer_bg_color  = get_theme_mod( 'aura_footer_bg_color', '#011627' );
    $body_font_size   = get_theme_mod( 'aura_body_font_size', '15' );
    $container_width  = get_theme_mod( 'aura_container_width', '1240' );
    ?>
    <style type="text/css">
        :root {
            --ast-global-color-0: <?php echo esc_attr( $primary_color ); ?>;
            --ast-global-color-1: <?php echo esc_attr( $secondary_color ); ?>;
        }
        
        body {
            font-size: <?php echo absint( $body_font_size ); ?>px;
        }
        
        .container,
        .ast-container {
            max-width: <?php echo absint( $container_width ); ?>px;
        }
        
        .site-footer {
            background-color: <?php echo esc_attr( $footer_bg_color ); ?>;
        }
    </style>
    <?php
}
add_action( 'wp_head', 'aura_customizer_css' );