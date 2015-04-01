<?php
/**
  * This file adds the custom publicaton post type single post template to the America.gov Theme.
  *
  * @author Office of Design, Bureau of International Information Programs
  * @package America.gov
  * @subpackage Customizations
  */


add_filter( 'genesis_post_info', 'america_post_info_filter' );
function america_post_info_filter($post_info) {
if ( !is_page() ) {
	$post_info = '[post_date] [post_categories sep=", " before=""]  [post_edit]';
	return $post_info;
}}


//* Remove "Filed under" from post_meta
add_filter( 'genesis_post_meta', 'america_post_meta_filter' );
function america_post_meta_filter($post_meta) {
  if ( !is_page() ) {
  	$post_meta = '[post_tags sep=", " before=""]';
  	return $post_meta;
  }
}


genesis();
