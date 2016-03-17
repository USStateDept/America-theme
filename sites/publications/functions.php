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
add_filter( 'genesis_pre_load_favicon', 'amgov_pubs_favicon_filter' );
function amgov_pubs_favicon_filter( $favicon_url ) {
	return '/wp-content/themes/america/sites/publications/images/dist/favicon.ico';
}

//* Add image sizes
add_image_size( 'publication', 450, 564 ); // 400 x 600
add_image_size( 'publication-small', 200, 250, true ); 
set_post_thumbnail_size( 150, 190, true );   // 150 x 190


//* Modify the length of post excerpts
add_filter( 'excerpt_length', 'amgov_pubs_excerpt_length' );
function amgov_pubs_excerpt_length( $length ) {
  echo 'length';
	return 30; // pull first 50 words
}

//* Remove archive pages from search results 
add_action('pre_get_posts','amgov_pubs_search_filter');
function amgov_pubs_search_filter($query) {
  if ( !is_admin() && $query->is_main_query() ) {
    if ($query->is_search) {
      $query->set( 'post_type', array('post', 'publication') );
     // $query->set( 'posts_per_page', 12 );
    }
  }
}

//* Remove Footer Credits
remove_action( 'genesis_footer', 'genesis_do_footer' );
add_action( 'genesis_footer', 'amgov_pubs_custom_footer' );
function amgov_pubs_custom_footer() {
  ?>

  <p class="site-footer footer-contact">Want a publication on a specific topic, but it doesn't exist? <a href="/contact-us/">Contact Us</a></div>

  <p class="site-footer-legal">This site is managed by the <a href="http://www.state.gov/r/iip" target="_blank">Bureau of International Information Programs</a> within the  <a href="http://www.state.gov" target="_blank">U.S. Department of State</a>. External links to other Internet sites should not be construed as an endorsement of the views or privacy policies contained therein.</p>
  <?php
}
