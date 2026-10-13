<?php
/**
 * Primary sidebar.
 *
 * @package Grimm
 */

if ( ! grimm_has_sidebar() ) {
	return;
}
?>

<aside id="secondary" class="widget-area" aria-label="<?php esc_attr_e( 'Sidebar', 'grimm' ); ?>">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside>
