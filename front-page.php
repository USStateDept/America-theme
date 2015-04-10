<?php
/**
 * This file adds the Home Page to the America.gov Theme.
 *
 * @author Office of Design, Bureau of International Information Programs
 * @package America.gov
 * @subpackage Customizations
 */

add_action( 'genesis_meta', 'america_home_genesis_meta' );
/**
 * Add widget support for homepage. If no widgets active, display the default loop.
 *
 */
function america_home_genesis_meta() {

	if ( is_active_sidebar( 'home-top' ) || is_active_sidebar( 'home-middle' ) || is_active_sidebar( 'home-cta' ) || is_active_sidebar( 'home-bottom' ) ) {

		remove_action( 'genesis_loop', 'genesis_do_loop' );
		add_action( 'genesis_loop', 'america_home_sections' );
		add_filter( 'body_class', 'america_add_home_body_class' );

	}

}

function america_home_sections() {

	genesis_widget_area( 'home-top', array(
		'before' => '<div class="home-top widget-area">',
		'after'  => '</div>',
	) );

	genesis_widget_area( 'home-middle', array(
		'before' => '<div class="home-middle widget-area">',
		'after'  => '</div>',
	) );

	genesis_widget_area( 'home-cta', array(
		'before' => '<div class="home-cta widget-area">',
		'after'  => '</div>',
	) );

	genesis_widget_area( 'home-bottom', array(
		'before' => '<div class="home-bottom widget-area">',
		'after'  => '</div>',
	) );

}

//* Add body class to home page
function america_add_home_body_class( $classes ) {

	$classes[] = 'america-home';
	return $classes;

}


//* Set default post info to just date
add_filter( 'genesis_post_info', 'america_default_post_info_filter' );
function america_default_post_info_filter($post_meta) {
	$post_meta = '[post_date]';
	return $post_meta;
}

add_filter( 'genesis_post_meta', 'america_default_post_meta' );
function america_default_post_meta($post_meta) {
	$post_meta = '[post_categories sep=", " before=""] [post_tags sep=", " before=""]';
	return $post_meta;
}

genesis();
