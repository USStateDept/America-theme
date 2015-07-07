<?php
/**
  * This file adds the custom publicaton post type single post template to the America.gov Theme.
  *
  * @author Office of Design, Bureau of International Information Programs
  * @package America.gov
  * @subpackage Customizations
  */

//* Remove post meta and define below
remove_action('genesis_entry_footer', 'genesis_post_meta');


//* Define output of the post meta
add_filter( 'genesis_post_info', 'america_post_info_filter' );
function america_post_info_filter($post_info) {
if ( !is_page() ) {
	$post_info = '[post_date] [post_categories sep=", " before=""] [post_tags sep=", " before=""] [post_edit]';
	return $post_info;
}}


//* Add feature image if Standard Single Post
if( false == get_post_format() ) {
	add_action( 'genesis_entry_content', 'climate_featured_image', 1 );
	function climate_featured_image() {
		$id = get_post_thumbnail_id();
		if ( !$id == '' ) {
			echo do_shortcode("[picturefill id='$id' names='post-thumbnail,post-feature-laptop,large,post-feature-big-mobile,archive-mobile' sizes='800, 660, 768, 630, 365' min_widths='75, 64, 50, 25']");
		}
	}
}

genesis();
