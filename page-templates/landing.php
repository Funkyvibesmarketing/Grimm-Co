<?php
/**
 * Template Name: Landing Page
 *
 * Keeps the site header and footer, but removes the container, title and sidebar
 * so editor blocks (cover, columns, groups set to full width) run edge to edge.
 *
 * @package Grimm
 */

get_header();
?>

<main id="primary" class="site-main site-main--landing">
	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="entry-content">
				<?php the_content(); ?>
			</div>
		</article>
		<?php
	endwhile;
	?>
</main>

<?php
get_footer();
