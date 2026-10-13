<?php
/**
 * Widget areas.
 *
 * @package Grimm
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function grimm_widgets_init() {
	$defaults = array(
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	);

	register_sidebar(
		array_merge(
			$defaults,
			array(
				'name'        => esc_html__( 'Sidebar', 'grimm' ),
				'id'          => 'sidebar-1',
				'description' => esc_html__( 'Shown beside posts, archives and pages that use a sidebar layout.', 'grimm' ),
			)
		)
	);

	for ( $i = 1; $i <= 3; $i++ ) {
		register_sidebar(
			array_merge(
				$defaults,
				array(
					/* translators: %d: footer column number. */
					'name'        => sprintf( esc_html__( 'Footer Column %d', 'grimm' ), $i ),
					'id'          => 'footer-' . $i,
					'description' => esc_html__( 'Footer widget column.', 'grimm' ),
				)
			)
		);
	}
}
add_action( 'widgets_init', 'grimm_widgets_init' );
