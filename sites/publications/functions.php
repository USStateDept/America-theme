<?php

/**
 * Initialize the America_Theme_Extender class if it is not already loaded
 * sending in both a path to the direcotry on filesystem where assets are
 * located and url to assets. The params are set to reasonable defaults
 * and can be changed if necessary.
 *
 * @param  string $path default path to granchild assets (i.e. sites/publications)
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
	return '/wp-content/themes/america/sites/publications/images/dist/favicon.ico';
}

//* Add image sizes
add_image_size( 'publication', 424, 530, TRUE );
add_image_size( 'pub-small', 200, 250, TRUE );
set_post_thumbnail_size(150, 188, TRUE);


//* Modify the length of post excerpts
add_filter( 'excerpt_length', 'sp_excerpt_length' );
function sp_excerpt_length( $length ) {
	return 30; // pull first 50 words
}

//* Redirect search, category and taxonomy archives to use archive-publication template
/*function get_publication_template( $template ) {
  if(  is_category() || is_search() || is_tax() ) {
  	$template = get_query_template( 'archive-publication' );
  }
  return $template;
}

add_filter( 'template_include', 'get_publication_template' );*/

/********************************************** END MOVE TO PLUGIN ******************************************* */