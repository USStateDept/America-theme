<?php
/**
* This file adds the publication type taxonomy archive template to the America.gov Theme.
*
* @author Office of Design, Bureau of International Information Programs
* @package America.gov
* @subpackage Customizations
*/

//* Force full width content layout
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

//* Remove the breadcrumb navigation
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

//* Remove the post info function
remove_action( 'genesis_entry_header', 'genesis_post_info', 5 );

//* Remove the post content
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );

//* Remove the post image
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );

//* Add publication body class to the head
add_filter( 'body_class', 'america_add_publication_body_class' );
function america_add_publication_body_class( $classes ) {

  $classes[] = 'america-publication';
  return $classes;

}

//* Add the featured image after post title
add_action( 'genesis_entry_header', 'america_publication_grid', 5 );
function america_publication_grid() {

  if ( $image = genesis_get_image( 'format=url&size=publication' ) ) {
    printf( '<div class="publication-featured-image"><a href="%s" rel="bookmark"><img src="%s" alt="%s" /></a></div>', get_permalink(), $image, the_title_attribute( 'echo=0' ) );
  }
}

add_action( 'genesis_entry_header', 'america_publication_meta', 10);
function america_publication_meta() {

  // taxonomy pages (i.e. Books, Pamphlets, etc.) - display image, title and subjects
  if ( is_tax() ) {
    add_filter( 'genesis_post_meta', 'america_post_meta_category_tags_filter' );
  }

  // category pages (i.e. Democracy, Health, etc.) -  display image, title and publication type
  if (is_category() ) {
    add_filter( 'genesis_post_meta', 'america_post_meta_tags_type_filter' );
  }

  // search results page
  if( is_search() ) {
    add_filter( 'genesis_post_meta', 'america_post_meta_all_filter' );
  }

}

function america_post_meta_all_filter($post_meta) {
  $post_meta = '[post_categories before="Subject: "]';
  $post_meta .= '[post_tags before="Tagged: "]';
  $post_meta .= '[publication_type]';
  return $post_meta;
}

function america_post_meta_category_tags_filter($post_meta) {
  $post_meta = '[post_categories before="Subject: "]';
  $post_meta .= '[post_tags before="Tagged: "]';
  return $post_meta;
}

function america_post_meta_tags_type_filter($post_meta) {
  $post_meta = '[post_tags before="Tagged: "]';
  $post_meta .= '[publication_type]';
  return $post_meta;
}

  genesis();
