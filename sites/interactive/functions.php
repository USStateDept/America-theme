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
add_filter( 'genesis_pre_load_favicon', 'iip_favicon_filter' );
function iip_favicon_filter( $favicon_url ) {
	return '/wp-content/themes/america/sites/docs/images/dist/favicon.ico';
}

//* remove site title
remove_action( 'genesis_site_title', 'genesis_seo_site_title' );

//* remove page title
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );

//* relocate page title to header
remove_action('genesis_post_title', 'genesis_do_post_title');
add_action('genesis_site_title', 'genesis_do_post_title');


add_filter( 'body_class', 'interactive_body_class' );
function interactive_body_class( $classes ) {
	$classes[] = 'interactive';
	return $classes;
}

add_filter('protected_title_format', 'interactive_remove_protected');
function interactive_remove_protected( $text ){
  $text = '%s';
  return $text;
}