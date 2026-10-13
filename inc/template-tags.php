<?php
/**
 * Reusable template output helpers.
 *
 * @package Grimm
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function grimm_site_branding() {
	?>
	<div class="site-branding">
		<?php
		if ( has_custom_logo() ) {
			the_custom_logo();
		}
		?>
		<div class="site-branding__text<?php echo has_custom_logo() ? ' screen-reader-text' : ''; ?>">
			<?php if ( is_front_page() && is_home() ) : ?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<?php else : ?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
			<?php endif; ?>
			<?php
			$description = get_bloginfo( 'description', 'display' );
			if ( $description || is_customize_preview() ) :
				?>
				<p class="site-description"><?php echo $description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
			<?php endif; ?>
		</div>
	</div>
	<?php
}

function grimm_header_cta() {
	$text = grimm_get_option( 'grimm_header_cta_text' );
	$url  = grimm_get_option( 'grimm_header_cta_url' );

	if ( ! $text || ! $url ) {
		return;
	}

	printf(
		'<a class="button header-cta" href="%1$s">%2$s</a>',
		esc_url( $url ),
		esc_html( $text )
	);
}

function grimm_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf(
		$time_string,
		esc_attr( get_the_date( DATE_W3C ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( DATE_W3C ) ),
		esc_html( get_the_modified_date() )
	);

	printf(
		'<span class="posted-on"><a href="%1$s" rel="bookmark">%2$s</a></span>',
		esc_url( get_permalink() ),
		$time_string // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	);
}

function grimm_posted_by() {
	printf(
		'<span class="byline">%1$s <span class="author vcard"><a class="url fn n" href="%2$s">%3$s</a></span></span>',
		esc_html_x( 'by', 'post author', 'grimm' ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_html( get_the_author() )
	);
}

function grimm_entry_meta() {
	if ( 'post' !== get_post_type() || ! grimm_get_option( 'grimm_show_post_meta' ) ) {
		return;
	}

	echo '<div class="entry-meta">';
	grimm_posted_on();
	grimm_posted_by();

	$categories = get_the_category_list( esc_html__( ', ', 'grimm' ) );
	if ( $categories ) {
		echo '<span class="cat-links">' . $categories . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
	echo '</div>';
}

function grimm_entry_footer() {
	if ( 'post' === get_post_type() ) {
		$tags = get_the_tag_list( '', esc_html_x( ', ', 'tag separator', 'grimm' ) );
		if ( $tags ) {
			printf(
				'<span class="tags-links">%1$s %2$s</span>',
				esc_html__( 'Tagged:', 'grimm' ),
				$tags // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			);
		}
	}

	edit_post_link(
		sprintf(
			/* translators: %s: post title. */
			esc_html__( 'Edit %s', 'grimm' ),
			'<span class="screen-reader-text">' . get_the_title() . '</span>'
		),
		'<span class="edit-link">',
		'</span>'
	);
}

function grimm_post_thumbnail( $size = 'grimm-card' ) {
	if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
		return;
	}

	if ( is_singular() ) {
		echo '<figure class="post-thumbnail">';
		the_post_thumbnail( $size );
		echo '</figure>';
		return;
	}

	printf( '<a class="post-thumbnail" href="%s" aria-hidden="true" tabindex="-1">', esc_url( get_permalink() ) );
	the_post_thumbnail(
		$size,
		array( 'alt' => the_title_attribute( array( 'echo' => false ) ) )
	);
	echo '</a>';
}

function grimm_author_box() {
	if ( ! is_single() || 'post' !== get_post_type() || ! grimm_get_option( 'grimm_show_author_box' ) ) {
		return;
	}
	$description = get_the_author_meta( 'description' );
	if ( ! $description ) {
		return;
	}
	?>
	<aside class="author-box">
		<?php echo get_avatar( get_the_author_meta( 'ID' ), 72 ); ?>
		<div class="author-box__body">
			<h2 class="author-box__name"><?php echo esc_html( get_the_author() ); ?></h2>
			<p><?php echo wp_kses_post( $description ); ?></p>
			<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php esc_html_e( 'View all posts', 'grimm' ); ?></a>
		</div>
	</aside>
	<?php
}

function grimm_pagination() {
	the_posts_pagination(
		array(
			'mid_size'  => 2,
			'prev_text' => esc_html__( '&larr; Previous', 'grimm' ),
			'next_text' => esc_html__( 'Next &rarr;', 'grimm' ),
		)
	);
}

function grimm_footer_text() {
	$text = grimm_get_option( 'grimm_footer_text' );

	if ( ! $text ) {
		$text = sprintf(
			/* translators: 1: year, 2: site name. */
			esc_html__( '&copy; %1$s %2$s. All rights reserved.', 'grimm' ),
			'{year}',
			get_bloginfo( 'name' )
		);
	}

	echo wp_kses_post( str_replace( '{year}', wp_date( 'Y' ), $text ) );
}
