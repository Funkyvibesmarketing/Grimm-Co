<?php
/**
 * Shown when a query returns no posts.
 *
 * @package Grimm
 */

?>

<section class="no-results not-found">
	<header class="page-header">
		<h1 class="page-title"><?php esc_html_e( 'Nothing found', 'grimm' ); ?></h1>
	</header>

	<div class="page-content">
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>
			<p>
				<?php
				printf(
					wp_kses(
						/* translators: %s: link to new post screen. */
						__( 'Ready to publish your first post? <a href="%s">Get started here</a>.', 'grimm' ),
						array( 'a' => array( 'href' => array() ) )
					),
					esc_url( admin_url( 'post-new.php' ) )
				);
				?>
			</p>
		<?php elseif ( is_search() ) : ?>
			<p><?php esc_html_e( 'Nothing matched your search terms. Please try again with different keywords.', 'grimm' ); ?></p>
		<?php else : ?>
			<p><?php esc_html_e( 'We could not find what you are looking for. Perhaps searching can help.', 'grimm' ); ?></p>
			<?php get_search_form(); ?>
		<?php endif; ?>
	</div>
</section>
