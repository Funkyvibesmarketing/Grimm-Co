<?php
/**
 * Post card used in the blog index and archives.
 *
 * @package Grimm
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'card' ); ?>>
	<?php grimm_post_thumbnail(); ?>

	<div class="card__body">
		<header class="entry-header">
			<?php
			if ( is_sticky() && is_home() && ! is_paged() ) {
				echo '<span class="sticky-badge">' . esc_html__( 'Featured', 'grimm' ) . '</span>';
			}
			the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
			grimm_entry_meta();
			?>
		</header>

		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div>

		<a class="read-more" href="<?php the_permalink(); ?>">
			<?php
			printf(
				/* translators: %s: post title. */
				esc_html__( 'Read more %s', 'grimm' ),
				'<span class="screen-reader-text">' . esc_html( get_the_title() ) . '</span>'
			);
			?>
		</a>
	</div>
</article>
