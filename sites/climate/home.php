<?php
/**
  * This file adds the custom publicaton post type single post template to the America.gov Theme.
  *
  * @author Office of Design, Bureau of International Information Programs
  * @package America.gov
  * @subpackage Customizations
  */

//* Remove the post image
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );

//* Remove the post content
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );

//* Remove post meta
remove_action('genesis_entry_footer', 'genesis_post_meta');

add_filter( 'genesis_post_info', 'america_post_info_filter' );
function america_post_info_filter($post_info) {
	if ( !is_page() ) {
		$post_info = '[post_date] [post_categories sep=", " before=""] [post_tags sep=", " before=""] [post_edit]';
		return $post_info;
	}
}


//* Picturefill img output
add_action( 'genesis_entry_content', 'america_responsive_image' );
function america_responsive_image() {
	$id = get_post_thumbnail_id();

	if ( empty( $id ) == false ) {
		echo do_shortcode("[picturefill id='$id' align='alignnone' names='medium,post-feature-big-mobile,archive-mobile' sizes='285,630,365' min_widths='50,25']");
	}
}


//* Add back the post content
add_action( 'genesis_entry_content', 'genesis_do_post_content' );

genesis();
