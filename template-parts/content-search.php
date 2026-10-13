<?php
/**
 * Search result item.
 *
 * @package Grimm
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'card card--search' ); ?>>
	<div class="card__body">
		<header class="entry-header">
			<span class="post-type-label"><?php echo esc_html( get_post_type_object( get_post_type() )->labels->singular_name ); ?></span>
			<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
			<?php grimm_entry_meta(); ?>
		</header>

		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div>
	</div>
</article>
