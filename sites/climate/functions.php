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
	return '/wp-content/themes/america/sites/climate/images/dist/favicon.ico';
}


//* Add image sizes
add_image_size( 'medium', 285, 190, TRUE ); //homepage thumb, archive thumb, post-inline-float
add_image_size( 'archive-mobile', 365, 243, TRUE ); //mobile archive thumb
add_image_size( 'post-feature-laptop', 660, 371, TRUE ); // laptop feature image
add_image_size( 'large', 768, 396, TRUE); //tablet feature image
add_image_size( 'post-feature-big-mobile', 630, 354, TRUE); //big mobile feature image, big mobile archive


//* Set Feature Image Size
set_post_thumbnail_size( 800, 450, TRUE );


//* Make custom image sizes selectable from WordPress admin
add_filter( 'image_size_names_choose', 'climate_custom_sizes' );
function climate_custom_sizes( $sizes ) {
    return array_merge( $sizes, array(
				'post-thumbnail' => __( 'Post Feature Image Default' ),
    ) );
}
