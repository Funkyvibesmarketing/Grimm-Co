<?php
/**
 * Single post content.
 *
 * @package Grimm
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ( ! grimm_hide_title() ) : ?>
		<header class="entry-header">
			<?php
			the_title( '<h1 class="entry-title">', '</h1>' );
			grimm_entry_meta();
			?>
		</header>
	<?php endif; ?>

	<?php
	if ( grimm_get_option( 'grimm_show_featured_single' ) ) {
		grimm_post_thumbnail( 'grimm-hero' );
	}
	?>

	<div class="entry-content">
		<?php
		the_content();

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'grimm' ),
				'after'  => '</div>',
			)
		);
		?>
	</div>

	<footer class="entry-footer">
		<?php grimm_entry_footer(); ?>
	</footer>
</article>
