<?php

/**
 * Utility class that returns the sub site part of the url; used to locate correct asset folder (i.e. /climate or /misinfo)
 * Folder names MUST match the path entered in the "path" field of the Edit Sites admin screen
 * 
 * @param  int 		$id current blog_id
 * @return string   url part
 */
function america_get_site_path_part( $id ) {

	$details = get_blog_details( $id );
	$path = get_blog_details( $id )->path;
	america_get_site_domain( 'climate.dev.america.gov' );
	america_get_site_domain( 'facts.edit.america.gov' );
	if( trim($details->path) === '/' ) {
		// on staging/prod servers
		$part = america_get_site_domain( $details->domain );
	} else {
		// on development, local/openshift
		$len = strlen( $path ) - 2;
		$part = substr( $path , 1, $len );
	}

	return $part;
}

function america_get_site_domain( $domain ) {
	$matched = preg_match( '/^[^\.]*/', $domain, $matches );
	if( $matched ) {
		if( $matches[0] === 'facts') {   // stupid workaround
			return 'misinfo';
		} else {
			return $matches[0];
		}
	}
}

// Loads grandchild theme functons file if file is present and initializes extender
// Currently each grandchild theme requires a functions.php file in order to load css,
// templates, etc.
function america_load_grandchild_theme() {
	$grandchild_theme_root = 'sites/';
	$grandchild_theme = $grandchild_theme_root . america_get_site_path_part( get_current_blog_id() );
	$grandchild_path = get_stylesheet_directory() . '/' . $grandchild_theme; 
	$functions_file = $grandchild_path. '/functions.php';

	if ( file_exists( $functions_file ) ) {
		include_once( $functions_file );
		initialize_site( $grandchild_theme );
	} 
}
