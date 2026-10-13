<?php
/**
 * Site footer.
 *
 * @package Grimm
 */

?>
	</div><!-- #content -->

	<footer id="colophon" class="site-footer">
		<?php if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) ) : ?>
			<div class="container footer-widgets">
				<?php for ( $i = 1; $i <= 3; $i++ ) : ?>
					<div class="footer-widgets__column">
						<?php
						if ( is_active_sidebar( 'footer-' . $i ) ) {
							dynamic_sidebar( 'footer-' . $i );
						}
						?>
					</div>
				<?php endfor; ?>
			</div>
		<?php endif; ?>

		<div class="site-info">
			<div class="container site-info__inner">
				<p class="site-info__text"><?php grimm_footer_text(); ?></p>

				<?php if ( has_nav_menu( 'footer' ) ) : ?>
					<nav class="footer-navigation" aria-label="<?php esc_attr_e( 'Footer', 'grimm' ); ?>">
						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'footer',
								'container'      => false,
								'depth'          => 1,
							)
						);
						?>
					</nav>
				<?php endif; ?>

				<?php if ( has_nav_menu( 'social' ) ) : ?>
					<nav class="social-navigation" aria-label="<?php esc_attr_e( 'Social links', 'grimm' ); ?>">
						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'social',
								'container'      => false,
								'depth'          => 1,
							)
						);
						?>
					</nav>
				<?php endif; ?>
			</div>
		</div>
	</footer>
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
