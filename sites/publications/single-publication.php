<?php
/**
  * This file adds the custom publicaton post type single post template to the America.gov Theme.
  *
  * @author Office of Design, Bureau of International Information Programs
  * @package America.gov
  * @subpackage Customizations
  */

//* Force full width content layout
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

//* Remove the breadcrumb navigation
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );

remove_action( 'genesis_before_content_sidebar_wrap', 'genesis_before_content_sidebar_wrap' );

//* Remove the post info function
remove_action( 'genesis_entry_header', 'genesis_post_info', 5 );

//* Remove the author box on single posts
remove_action( 'genesis_after_entry', 'genesis_do_author_box_single', 8 );

//* Remove Post Header
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );
remove_action( 'genesis_entry_header', 'genesis_post_meta' );

//* Remove Post Content
//* Remove the post info function
remove_action( 'genesis_entry_content', 'genesis_post_info' );
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );

//* Remove Post Meta
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );
remove_action( 'genesis_entry_content', 'genesis_post_meta' );
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
remove_action( 'genesis_entry_content', 'genesis_entry_meta' );


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

/* Rebuilding the page with our custom markup */

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



//* Output post title 
add_action( 'genesis_entry_header', 'genesis_do_post_title' );

//* Open 1/3 column. We're hijacking genesis_entry_header to do what we want.
add_action( 'genesis_entry_header', 'america_entry_header_markup_open' );
function america_entry_header_markup_open() {
  $html = '<div class="one-fourth first">';
  echo $html;
}


//* Add featured image to single-publication page.
add_action( 'genesis_entry_header', 'america_publication_featured_image' );
function america_publication_featured_image() {
  if ( $image = genesis_get_image( 'format=url' ) ) {
    printf( '<div class="publication-featured-image"><img src="%s" alt="%s" /></div>', $image, the_title_attribute( 'echo=0' ) );
  }
}


//* Close 1/3 column
add_action( 'genesis_entry_header', 'america_entry_header_markup_close' );
function america_entry_header_markup_close() {
  $html = '</div>';
  echo $html;
}


//* Open 1/3 column
add_action( 'genesis_before_entry_content', 'america_before_entry_markup', 1 );
function america_before_entry_markup() {
  $html = '<div class="one-half">';
  echo $html;
}

//* Output pub file
add_action( 'genesis_entry_content', 'pub_file_loop' );//add in the repeater loop below
function pub_file_loop () {
// check if the repeater field has rows of data
if( have_rows('attach_files') ):
  // loop through the rows of data
    while ( have_rows('attach_files') ) : the_row();
        // display a sub field value
    echo '<div class="file-download">
       <a href=' . get_sub_field('file') .' class="downloads-file">Download</a>
       </div>';
    endwhile;
else :
    // no rows found
endif;
}

//* Output post content in 1/3 column
add_action( 'genesis_entry_content', 'genesis_do_post_content' );


//* Close 1/3 column
add_action( 'genesis_after_entry_content', 'america_after_entry_markup' );
function america_after_entry_markup() {
  $html = '</div>';
  echo $html;
}

//* Add related pubs
add_action( 'genesis_entry_footer', 'publications_related' );
function publications_related() {
  $html = '<div class="one-fourth pubs-related">';
  echo $html;
  $html = '<h4>Suggested for you</h4>';
  echo $html;
  $html = '</div>';
  echo $html;
}


genesis();
