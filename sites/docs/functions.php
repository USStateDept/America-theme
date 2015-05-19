<?php

/**
 * Initialize the America_Theme_Extender class if it is not already loaded
 * sending in both a path to the direcotry on filesystem where assets are
 * located and url to assets. The params are set to reasonable defaults
 * and can be changed if necessary.
 *
 * @param  string $path default path to granchild assets (i.e. sites/climate)
 */
function initialize_site( $path ) {
	$dir = get_stylesheet_directory() . '/' . $path;
	$uri = get_stylesheet_directory_uri() . '/' . $path;

	if( class_exists ('America_Theme_Extender') ) {
		$america_theme_extender = new America_Theme_Extender( $dir, $uri );
	}
}

//* Display a custom favicon
add_filter( 'genesis_pre_load_favicon', 'sp_favicon_filter' );
function sp_favicon_filter( $favicon_url ) {
	return '/wp-content/themes/america/sites/docs/images/dist/favicon.ico';
}
