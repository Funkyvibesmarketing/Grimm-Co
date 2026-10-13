<?php
/**
 * Grimm theme functions and definitions.
 *
 * @package Grimm
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'GRIMM_VERSION', wp_get_theme( get_template() )->get( 'Version' ) );
define( 'GRIMM_DIR', get_template_directory() );
define( 'GRIMM_URI', get_template_directory_uri() );

require GRIMM_DIR . '/inc/setup.php';
require GRIMM_DIR . '/inc/enqueue.php';
require GRIMM_DIR . '/inc/widgets.php';
require GRIMM_DIR . '/inc/customizer.php';
require GRIMM_DIR . '/inc/template-tags.php';
require GRIMM_DIR . '/inc/template-functions.php';
