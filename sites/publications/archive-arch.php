<?php
/**
 * Custom Category Template
 * @author Office of Design, Bureau of International Information Programs
 * @package America.gov
 * @subpackage Publications
 */

//* Force full width content layout
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

//* Remove the breadcrumb navigation
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

//* Remove the post info function
remove_action( 'genesis_entry_header', 'genesis_post_info', 5 );

//* Remove the author box on single posts
remove_action( 'genesis_after_entry', 'genesis_do_author_box_single', 8 );

//* Remove Post Meta
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

//* Add custom body class for publication type
add_filter( 'body_class', 'america_add_publication_body_class' );
function america_add_publication_body_class( $classes ) {
  if ( has_term( 'pamphlet', 'publication-type' ) ) {
    $classes[] = 'term-pamphlet';
  } else if ( has_term( 'book', 'publication-type' ) ) {
    $classes[] = 'term-book';
  }
  return $classes;
}

//* Adding breadcrumb back in
add_action( 'genesis_after_header', 'genesis_do_breadcrumbs' );
//* Modify breadcrumb arguments.
add_filter( 'genesis_breadcrumb_args', 'sp_breadcrumb_args' );
function sp_breadcrumb_args( $args ) {
  $args['home'] = 'Home';
  $args['sep'] = ' / ';
  $args['list_sep'] = ', '; // Genesis 1.5 and later
  $args['prefix'] = '<div class="breadcrumb">';
  $args['suffix'] = '</div>';
  $args['heirarchial_attachments'] = true; // Genesis 1.5 and later
  $args['heirarchial_categories'] = true; // Genesis 1.5 and later
  $args['display'] = true;
  $args['labels']['prefix'] = '';
  $args['labels']['author'] = 'Archives for ';
  $args['labels']['category'] = 'Archives for '; // Genesis 1.6 and later
  $args['labels']['tag'] = 'Archives for ';
  $args['labels']['date'] = 'Archives for ';
  $args['labels']['search'] = 'Search for ';
  $args['labels']['tax'] = 'Archives for ';
  $args['labels']['post_type'] = 'Archives for ';
  $args['labels']['404'] = 'Not found: '; // Genesis 1.5 and later
return $args;
}




genesis();