<?php
/**
 * Template Name: Blank Canvas
 *
 * No site header, footer, title or sidebar. Only the page content is rendered.
 *
 * @package Grimm
 */

get_header( 'blank' );
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
get_footer( 'blank' );
