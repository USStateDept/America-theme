<?php
/**
 * This file adds the category page to the publications site.
 *
 * @author Office of Design, Bureau of International Information Programs
 * @package America.gov
 * @subpackage Publications
 */


//* Remove the entry meta in the entry header
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );
//* Remove the entry image
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
//* Add Image, Post Info, Title, Excerpt & Entry Footer Entry Meta
add_action( 'genesis_entry_header', 'genesis_do_post_image', 2 );
//* Add Header Markup & Post Info 
add_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5);
add_action( 'genesis_entry_header', 'genesis_post_info', 8  );
add_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );

//* Run the Genesis loop
genesis();

