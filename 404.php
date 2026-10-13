<?php
/**
 * 404 (not found) template.
 *
 * @package Grimm
 */

get_header();
?>

<div class="container content-area">
	<main id="primary" class="site-main">
		<section class="error-404 not-found">
			<header class="page-header">
				<p class="error-404__code">404</p>
				<h1 class="page-title"><?php esc_html_e( 'Page not found', 'grimm' ); ?></h1>
			</header>

			<div class="page-content">
				<p><?php esc_html_e( 'The page you are looking for does not exist or has been moved. Try a search instead.', 'grimm' ); ?></p>
				<?php get_search_form(); ?>
				<p><a class="button" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Back to home', 'grimm' ); ?></a></p>
			</div>
		</section>
	</main>
</div>

<?php
get_footer();
