<?php

/**
 * Initialize the America_Theme_Extender class if it is not already loaded
 * sending in both a path to the direcotry on filesystem where assets are
 * located and url to assets. The params are set to reasonable defaults
 * and can be changed if necessary.
 *
 * @param  string $path default path to granchild assets (i.e. sites/misinfo)
 */
function initialize_site( $path) {

	$dir = get_stylesheet_directory() . '/' . $path;
	$uri = get_stylesheet_directory_uri() . '/' . $path;

	if( class_exists ('America_Theme_Extender') ) {
		$america_theme_extender = new America_Theme_Extender( $dir, $uri );
	}
}


//* Display a custom favicon
add_filter( 'genesis_pre_load_favicon', 'sp_favicon_filter' );
function sp_favicon_filter( $favicon_url ) {
	return '/wp-content/themes/america/sites/misinfo/images/dist/favicon.ico';
}


//* WPML Date Format
add_filter('option_date_format', 'translate_date_format');
function translate_date_format($format) {
	if (function_exists('icl_translate'))
	  $format = icl_translate('Formats', $format, $format);
	return $format;
}


//* Remove WPML Widget
add_action('wp_dashboard_setup', 'wpml_remove_dashboard_widget' );
function wpml_remove_dashboard_widget() {
	remove_meta_box( 'icl_dashboard_widget', 'dashboard', 'side' );
}


add_image_size( 'disinfo-featured', 720, 470, TRUE );
add_image_size( 'disinfo-archive', 340, 200, TRUE );
add_image_size( 'disinfo-sidebar', 100, 100, TRUE );
