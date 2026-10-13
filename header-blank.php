<?php
/**
 * Minimal header used by the Blank page template (no site header or navigation).
 *
 * @package Grimm
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>

<body <?php body_class( 'is-blank-template' ); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
