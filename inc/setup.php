<?php
/**
 * Theme setup: supports, menus, image sizes.
 *
 * @package Grimm
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function grimm_setup() {
	load_theme_textdomain( 'grimm', GRIMM_DIR . '/languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/editor.css' );

	add_theme_support(
		'html5',
		array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' )
	);

	add_theme_support(
		'custom-logo',
		array(
			'height'      => 80,
			'width'       => 240,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	add_theme_support(
		'custom-background',
		array( 'default-color' => 'ffffff' )
	);

	add_image_size( 'grimm-card', 768, 480, true );
	add_image_size( 'grimm-hero', 1600, 700, true );

	register_nav_menus(
		array(
			'primary' => esc_html__( 'Primary Menu', 'grimm' ),
			'footer'  => esc_html__( 'Footer Menu', 'grimm' ),
			'social'  => esc_html__( 'Social Links Menu', 'grimm' ),
		)
	);
}
add_action( 'after_setup_theme', 'grimm_setup' );

function grimm_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'grimm_content_width', 780 );
}
add_action( 'after_setup_theme', 'grimm_content_width', 0 );
