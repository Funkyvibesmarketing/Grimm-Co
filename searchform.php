<?php
/**
 * Search form.
 *
 * @package Grimm
 */

$grimm_search_id = wp_unique_id( 'search-form-' );
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="screen-reader-text" for="<?php echo esc_attr( $grimm_search_id ); ?>"><?php esc_html_e( 'Search for:', 'grimm' ); ?></label>
	<input type="search" id="<?php echo esc_attr( $grimm_search_id ); ?>" class="search-field" placeholder="<?php esc_attr_e( 'Search&hellip;', 'grimm' ); ?>" value="<?php echo get_search_query(); ?>" name="s">
	<button type="submit" class="search-submit button"><?php esc_html_e( 'Search', 'grimm' ); ?></button>
</form>
