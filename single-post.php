<?php
/**
  * This file adds the custom publicaton post type single post template to the America.gov Theme.
  *
  * @author Office of Design, Bureau of International Information Programs
  * @package America.gov
  * @subpackage Customizations
  */

$details = get_blog_details();
echo 'INFO<br>';
foreach ( $details as $key => $value )  {
	echo $key . ' = ' . $value . '<br>';
}


add_filter( 'genesis_post_info', 'america_post_info_filter' );
function america_post_info_filter($post_info) {
if ( !is_page() ) {
	$post_info = '[post_date] [post_categories sep=", " before=""] [post_tags sep=", " before=""] [post_edit]';
	return $post_info;
}}

remove_action('genesis_entry_footer', 'genesis_post_meta');

genesis();
