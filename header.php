<?php
/**
 * Site header.
 *
 * @package Grimm
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'grimm' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="container site-header__inner">
			<?php grimm_site_branding(); ?>

			<?php if ( has_nav_menu( 'primary' ) ) : ?>
				<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
					<span class="menu-toggle__bar" aria-hidden="true"></span>
					<span class="screen-reader-text"><?php esc_html_e( 'Menu', 'grimm' ); ?></span>
				</button>
				<nav id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e( 'Primary', 'grimm' ); ?>">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'primary',
							'menu_id'        => 'primary-menu',
							'container'      => false,
							'depth'          => 3,
						)
					);
					?>
				</nav>
			<?php endif; ?>

			<?php grimm_header_cta(); ?>
		</div>
	</header>

	<div id="content" class="site-content">
