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

//* Remove the post info function
remove_action( 'genesis_entry_header', 'genesis_post_info', 5 );

//* Remove the author box on single posts
remove_action( 'genesis_after_entry', 'genesis_do_author_box_single', 8 );

//* Remove Post Header
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );

//* Remove Post Content
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );

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


/*
 *
 *
 * Rebuilding the page with our custom markup
 *
 */

//* Add the entry header markup and entry title
add_action( 'genesis_before_content', 'america_add_entry_header' );
function america_add_entry_header()
{
  genesis_entry_header_markup_open();
  genesis_do_post_title();
  genesis_entry_header_markup_close();
}

//* Open 1/3 column. We're hijacking genesis_entry_header to do what we want.
add_action( 'genesis_entry_header', 'america_entry_header_markup_open' );
function america_entry_header_markup_open() {
  $html = '<div class="one-third first">';
  echo $html;
}

//* Add file from Publication File meta box to view, if one exists
add_action( 'genesis_entry_header', 'america_publication_file' );
function america_publication_file() {

  $files = rwmb_meta( 'rw_publication_file', 'type=file' );

  if ( $files ) {

    $html = "<div class='downloads'>";
    $html .= "<h3 class='downloads-title'>Download</h3>";

    foreach ( $files as $file ) {
      $file_size = america_format_file_size( america_remote_filesize( $file['url'] ) );
      $html .= "<p><a href='{$file['url']}' title='{$file['title']}' class='downloads-file'>{$file['title']}</a> $file_size</p>";
    }

    $html .= "</div>";

    echo $html;

  }
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
  $html = '<div class="one-third">';
  echo $html;
}


//* Output post content in 1/3 column
add_action( 'genesis_entry_content', 'genesis_do_post_content' );


//* Output post meta in 1/3 column. Add category, tags, and type to the publication post meta data
add_action( 'genesis_after_entry_content', 'genesis_post_meta' );
add_filter( 'genesis_post_meta', 'america_post_meta_filter' );
function america_post_meta_filter($post_meta) {
  $post_meta = '[post_categories before="Subject: "] [post_tags before="Tagged: "]';
  $post_meta .= '[publication_type]';
  return $post_meta;
}


//* Close 1/3 column
add_action( 'genesis_after_entry_content', 'america_after_entry_markup' );
function america_after_entry_markup() {
  $html = '</div>';
  echo $html;
}


genesis();
