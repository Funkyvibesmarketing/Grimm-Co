<?php
/**
 * Template Name: Full Width
 * Template Post Type: page, post
 *
 * Header and footer, content stretches across the container with no sidebar.
 *
 * @package Grimm
 */

get_header();
?>

<div class="container content-area">
	<main id="primary" class="site-main">
		<?php
		while ( have_posts() ) :
			the_post();
			get_template_part( 'template-parts/content', is_page() ? 'page' : 'single' );

			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}
		endwhile;
		?>
	</main>
</div>

<?php
get_footer();
