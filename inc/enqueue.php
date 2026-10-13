<?php
/**
 * Scripts and styles.
 *
 * @package Grimm
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function grimm_scripts() {
	wp_enqueue_style( 'grimm-style', get_stylesheet_uri(), array(), GRIMM_VERSION );
	wp_enqueue_style( 'grimm-main', GRIMM_URI . '/assets/css/main.css', array( 'grimm-style' ), GRIMM_VERSION );
	wp_add_inline_style( 'grimm-main', grimm_customizer_css() );

	wp_enqueue_script(
		'grimm-navigation',
		GRIMM_URI . '/assets/js/navigation.js',
		array(),
		GRIMM_VERSION,
		array(
			'strategy'  => 'defer',
			'in_footer' => true,
		)
	);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'grimm_scripts' );
