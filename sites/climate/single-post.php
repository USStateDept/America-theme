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


//* Wrap the post thumbnail (feature image) in figure tag and add figcaption
function america_post_thumbnail_html() {
	$id = get_post_thumbnail_id();
	$caption = get_post( $id ) -> post_excerpt;

	$html = '<figure id="attachment_' . $id . '" class="wp-caption alignnone">';
		$html .= get_the_post_thumbnail();
		$html .= '<figcaption class="wp-caption-text">';
			$html .= $caption;
		$html .= '</figcaption>';
	$html .= '</figure>';

	echo $html;
}


//* Add feature image if Single Post
add_action( 'genesis_entry_content', 'climate_featured_image', 1 );
function climate_featured_image() {
	if ( is_singular( 'post' ) ) {
		america_post_thumbnail_html();
	}
}

genesis();
