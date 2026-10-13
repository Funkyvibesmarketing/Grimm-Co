<?php
/**
 * Hooks and helpers that change how templates behave.
 *
 * @package Grimm
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Resolve the layout for the current request.
 *
 * Priority: page template > per-post "Grimm Layout" meta box > Customizer default.
 */
function grimm_get_layout() {
	if ( is_404() || is_page_template( array( 'page-templates/full-width.php', 'page-templates/blank.php', 'page-templates/landing.php' ) ) ) {
		$layout = 'no-sidebar';
	} elseif ( is_page_template( 'page-templates/left-sidebar.php' ) ) {
		$layout = 'left-sidebar';
	} elseif ( is_page_template( 'page-templates/right-sidebar.php' ) ) {
		$layout = 'right-sidebar';
	} elseif ( is_singular() ) {
		$override = get_post_meta( get_queried_object_id(), '_grimm_layout', true );
		if ( $override && array_key_exists( $override, grimm_layout_choices() ) ) {
			$layout = $override;
		} else {
			$layout = is_page() ? grimm_get_option( 'grimm_page_layout' ) : grimm_get_option( 'grimm_single_layout' );
		}
	} else {
		$layout = grimm_get_option( 'grimm_blog_layout' );
	}

	if ( 'no-sidebar' !== $layout && ! is_active_sidebar( 'sidebar-1' ) ) {
		$layout = 'no-sidebar';
	}

	return apply_filters( 'grimm_layout', $layout );
}

function grimm_has_sidebar() {
	return 'no-sidebar' !== grimm_get_layout();
}

function grimm_hide_title() {
	return is_singular() && (bool) get_post_meta( get_queried_object_id(), '_grimm_hide_title', true );
}

function grimm_body_classes( $classes ) {
	$classes[] = 'layout-' . grimm_get_layout();

	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}
	if ( grimm_get_option( 'grimm_sticky_header' ) ) {
		$classes[] = 'has-sticky-header';
	}

	return $classes;
}
add_filter( 'body_class', 'grimm_body_classes' );

function grimm_excerpt_length( $length ) {
	if ( is_admin() ) {
		return $length;
	}
	$custom = absint( grimm_get_option( 'grimm_excerpt_length' ) );

	return $custom ? $custom : $length;
}
add_filter( 'excerpt_length', 'grimm_excerpt_length', 999 );

function grimm_excerpt_more( $more ) {
	return is_admin() ? $more : '&hellip;';
}
add_filter( 'excerpt_more', 'grimm_excerpt_more' );

function grimm_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'grimm_pingback_header' );

/**
 * Per-post layout meta box shown on posts and pages.
 */
function grimm_add_layout_meta_box() {
	add_meta_box(
		'grimm_layout',
		esc_html__( 'Grimm Layout', 'grimm' ),
		'grimm_render_layout_meta_box',
		array( 'post', 'page' ),
		'side',
		'default'
	);
}
add_action( 'add_meta_boxes', 'grimm_add_layout_meta_box' );

function grimm_render_layout_meta_box( $post ) {
	wp_nonce_field( 'grimm_layout_meta', 'grimm_layout_nonce' );

	$layout     = get_post_meta( $post->ID, '_grimm_layout', true );
	$hide_title = get_post_meta( $post->ID, '_grimm_hide_title', true );
	?>
	<p>
		<label for="grimm_layout_field"><?php esc_html_e( 'Sidebar', 'grimm' ); ?></label><br>
		<select name="grimm_layout_field" id="grimm_layout_field" class="widefat">
			<option value=""><?php esc_html_e( 'Default (Customizer)', 'grimm' ); ?></option>
			<?php foreach ( grimm_layout_choices() as $value => $label ) : ?>
				<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $layout, $value ); ?>><?php echo esc_html( $label ); ?></option>
			<?php endforeach; ?>
		</select>
	</p>
	<p>
		<label>
			<input type="checkbox" name="grimm_hide_title_field" value="1" <?php checked( $hide_title, '1' ); ?>>
			<?php esc_html_e( 'Hide title', 'grimm' ); ?>
		</label>
	</p>
	<p class="description"><?php esc_html_e( 'Page templates (Full Width, Blank, Landing, etc.) take priority over the sidebar setting.', 'grimm' ); ?></p>
	<?php
}

function grimm_save_layout_meta_box( $post_id ) {
	if ( ! isset( $_POST['grimm_layout_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['grimm_layout_nonce'] ) ), 'grimm_layout_meta' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$layout = isset( $_POST['grimm_layout_field'] ) ? sanitize_key( wp_unslash( $_POST['grimm_layout_field'] ) ) : '';
	if ( $layout && array_key_exists( $layout, grimm_layout_choices() ) ) {
		update_post_meta( $post_id, '_grimm_layout', $layout );
	} else {
		delete_post_meta( $post_id, '_grimm_layout' );
	}

	if ( ! empty( $_POST['grimm_hide_title_field'] ) ) {
		update_post_meta( $post_id, '_grimm_hide_title', '1' );
	} else {
		delete_post_meta( $post_id, '_grimm_hide_title' );
	}
}
add_action( 'save_post', 'grimm_save_layout_meta_box' );
