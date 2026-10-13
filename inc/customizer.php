<?php
/**
 * Customizer settings (Appearance > Customize > Grimm Options).
 *
 * @package Grimm
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function grimm_option_defaults() {
	return array(
		'grimm_primary_color'        => '#111827',
		'grimm_accent_color'         => '#b45309',
		'grimm_container_width'      => 1200,
		'grimm_sticky_header'        => true,
		'grimm_header_cta_text'      => '',
		'grimm_header_cta_url'       => '',
		'grimm_blog_layout'          => 'right-sidebar',
		'grimm_single_layout'        => 'right-sidebar',
		'grimm_page_layout'          => 'no-sidebar',
		'grimm_excerpt_length'       => 30,
		'grimm_show_post_meta'       => true,
		'grimm_show_featured_single' => true,
		'grimm_show_author_box'      => true,
		'grimm_footer_text'          => '',
	);
}

function grimm_get_option( $key ) {
	$defaults = grimm_option_defaults();
	$default  = isset( $defaults[ $key ] ) ? $defaults[ $key ] : null;

	return get_theme_mod( $key, $default );
}

function grimm_layout_choices() {
	return array(
		'right-sidebar' => esc_html__( 'Right sidebar', 'grimm' ),
		'left-sidebar'  => esc_html__( 'Left sidebar', 'grimm' ),
		'no-sidebar'    => esc_html__( 'No sidebar', 'grimm' ),
	);
}

function grimm_sanitize_checkbox( $value ) {
	return (bool) $value;
}

function grimm_sanitize_layout( $value ) {
	return array_key_exists( $value, grimm_layout_choices() ) ? $value : 'right-sidebar';
}

function grimm_customize_register( $wp_customize ) {
	$defaults = grimm_option_defaults();

	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	$wp_customize->add_panel(
		'grimm_options',
		array(
			'title'    => esc_html__( 'Grimm Options', 'grimm' ),
			'priority' => 30,
		)
	);

	// Colors & width.
	$wp_customize->add_section(
		'grimm_general',
		array(
			'title' => esc_html__( 'General', 'grimm' ),
			'panel' => 'grimm_options',
		)
	);

	foreach ( array(
		'grimm_primary_color' => esc_html__( 'Primary color', 'grimm' ),
		'grimm_accent_color'  => esc_html__( 'Accent color', 'grimm' ),
	) as $id => $label ) {
		$wp_customize->add_setting(
			$id,
			array(
				'default'           => $defaults[ $id ],
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				$id,
				array(
					'label'   => $label,
					'section' => 'grimm_general',
				)
			)
		);
	}

	$wp_customize->add_setting(
		'grimm_container_width',
		array(
			'default'           => $defaults['grimm_container_width'],
			'sanitize_callback' => 'absint',
		)
	);
	$wp_customize->add_control(
		'grimm_container_width',
		array(
			'label'       => esc_html__( 'Container width (px)', 'grimm' ),
			'section'     => 'grimm_general',
			'type'        => 'number',
			'input_attrs' => array(
				'min'  => 960,
				'max'  => 1600,
				'step' => 10,
			),
		)
	);

	// Header.
	$wp_customize->add_section(
		'grimm_header',
		array(
			'title' => esc_html__( 'Header', 'grimm' ),
			'panel' => 'grimm_options',
		)
	);

	$wp_customize->add_setting(
		'grimm_sticky_header',
		array(
			'default'           => $defaults['grimm_sticky_header'],
			'sanitize_callback' => 'grimm_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'grimm_sticky_header',
		array(
			'label'   => esc_html__( 'Sticky header', 'grimm' ),
			'section' => 'grimm_header',
			'type'    => 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'grimm_header_cta_text',
		array(
			'default'           => $defaults['grimm_header_cta_text'],
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'grimm_header_cta_text',
		array(
			'label'       => esc_html__( 'Button text', 'grimm' ),
			'description' => esc_html__( 'Leave empty to hide the header button.', 'grimm' ),
			'section'     => 'grimm_header',
			'type'        => 'text',
		)
	);

	$wp_customize->add_setting(
		'grimm_header_cta_url',
		array(
			'default'           => $defaults['grimm_header_cta_url'],
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		'grimm_header_cta_url',
		array(
			'label'   => esc_html__( 'Button link', 'grimm' ),
			'section' => 'grimm_header',
			'type'    => 'url',
		)
	);

	// Layout.
	$wp_customize->add_section(
		'grimm_layout',
		array(
			'title'       => esc_html__( 'Layout', 'grimm' ),
			'description' => esc_html__( 'Default layouts. Individual posts and pages can override this in the "Grimm Layout" box in the editor.', 'grimm' ),
			'panel'       => 'grimm_options',
		)
	);

	foreach ( array(
		'grimm_blog_layout'   => esc_html__( 'Blog & archives', 'grimm' ),
		'grimm_single_layout' => esc_html__( 'Single posts', 'grimm' ),
		'grimm_page_layout'   => esc_html__( 'Pages', 'grimm' ),
	) as $id => $label ) {
		$wp_customize->add_setting(
			$id,
			array(
				'default'           => $defaults[ $id ],
				'sanitize_callback' => 'grimm_sanitize_layout',
			)
		);
		$wp_customize->add_control(
			$id,
			array(
				'label'   => $label,
				'section' => 'grimm_layout',
				'type'    => 'select',
				'choices' => grimm_layout_choices(),
			)
		);
	}

	// Blog.
	$wp_customize->add_section(
		'grimm_blog',
		array(
			'title' => esc_html__( 'Blog', 'grimm' ),
			'panel' => 'grimm_options',
		)
	);

	$wp_customize->add_setting(
		'grimm_excerpt_length',
		array(
			'default'           => $defaults['grimm_excerpt_length'],
			'sanitize_callback' => 'absint',
		)
	);
	$wp_customize->add_control(
		'grimm_excerpt_length',
		array(
			'label'       => esc_html__( 'Excerpt length (words)', 'grimm' ),
			'section'     => 'grimm_blog',
			'type'        => 'number',
			'input_attrs' => array(
				'min' => 5,
				'max' => 120,
			),
		)
	);

	foreach ( array(
		'grimm_show_post_meta'       => esc_html__( 'Show post date and author', 'grimm' ),
		'grimm_show_featured_single' => esc_html__( 'Show featured image on single posts', 'grimm' ),
		'grimm_show_author_box'      => esc_html__( 'Show author box on single posts', 'grimm' ),
	) as $id => $label ) {
		$wp_customize->add_setting(
			$id,
			array(
				'default'           => $defaults[ $id ],
				'sanitize_callback' => 'grimm_sanitize_checkbox',
			)
		);
		$wp_customize->add_control(
			$id,
			array(
				'label'   => $label,
				'section' => 'grimm_blog',
				'type'    => 'checkbox',
			)
		);
	}

	// Footer.
	$wp_customize->add_section(
		'grimm_footer',
		array(
			'title' => esc_html__( 'Footer', 'grimm' ),
			'panel' => 'grimm_options',
		)
	);

	$wp_customize->add_setting(
		'grimm_footer_text',
		array(
			'default'           => $defaults['grimm_footer_text'],
			'sanitize_callback' => 'wp_kses_post',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'grimm_footer_text',
		array(
			'label'       => esc_html__( 'Copyright text', 'grimm' ),
			'description' => esc_html__( 'Use {year} for the current year. Leave empty for the default.', 'grimm' ),
			'section'     => 'grimm_footer',
			'type'        => 'textarea',
		)
	);

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => static function () {
					bloginfo( 'name' );
				},
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => static function () {
					bloginfo( 'description' );
				},
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'grimm_footer_text',
			array(
				'selector'        => '.site-info__text',
				'render_callback' => 'grimm_footer_text',
			)
		);
	}
}
add_action( 'customize_register', 'grimm_customize_register' );

function grimm_customizer_css() {
	$primary = sanitize_hex_color( grimm_get_option( 'grimm_primary_color' ) );
	$accent  = sanitize_hex_color( grimm_get_option( 'grimm_accent_color' ) );
	$width   = absint( grimm_get_option( 'grimm_container_width' ) );

	$css = ':root{';
	if ( $primary ) {
		$css .= '--grimm-primary:' . $primary . ';';
	}
	if ( $accent ) {
		$css .= '--grimm-accent:' . $accent . ';';
	}
	if ( $width ) {
		$css .= '--grimm-container:' . $width . 'px;';
	}
	$css .= '}';

	return $css;
}
