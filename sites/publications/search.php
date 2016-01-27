<?php

add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_sidebar_content' );
add_filter( 'post_class',                         'publications_archive_post_class' );
add_filter( 'genesis_post_meta',                  'america_post_meta_format_filter' );

remove_action( 'genesis_entry_header',  'genesis_entry_header_markup_open', 5 );
remove_action( 'genesis_entry_header',  'genesis_do_post_title' );
remove_action( 'genesis_entry_header',  'genesis_post_info', 12 );
remove_action( 'genesis_entry_header',  'genesis_entry_header_markup_close', 15 );

remove_action( 'genesis_entry_footer',  'genesis_post_meta' );

remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );

add_action( 'genesis_after_header',   'america_add_search_sidebar' );
add_action( 'genesis_before_content', 'america_add_search_term' );

add_action( 'genesis_entry_content',  'genesis_do_post_image', 10 );
add_action( 'genesis_entry_content',  'genesis_do_post_title', 11 );
add_action( 'genesis_entry_content',  'publication_meta_format', 12 );
add_action( 'genesis_entry_content',  'genesis_do_post_content', 13 );
add_action( 'genesis_entry_content',  'publication_meta_subject', 14 );


function publications_archive_post_class( $classes ) {
  global $wp_query;
  if( ! $wp_query->is_main_query() )
    return $classes;
    
  $classes[] = 'one-half';
  if( 0 == $wp_query->current_post || 0 == $wp_query->current_post % 2 )
    $classes[] = 'first';
  return $classes;
}

function america_post_meta_format_filter( $post_meta ) {
  $post_meta .= '[publication_type before="Format: "]';
  return $post_meta;
}

/**
 * Put secondary sidebar in primary's position
 */
function america_add_search_sidebar() {
  remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );
  remove_action( 'genesis_sidebar_alt', 'genesis_do_sidebar_alt' );
  add_action( 'genesis_sidebar', 'genesis_do_sidebar_alt' );
}

function america_add_search_term() {
  echo '<h3>Search results for <span>' . get_query_var('s') .'</span></h3>';
}

function publication_meta_format () {
  global $post;
  
  $terms = wp_get_post_terms( $post->ID, 'publication-type' );
  echo publications_show_terms( $terms, 'Format');
}

function publication_meta_subject () {
  global $post;
  
  $terms = wp_get_post_terms( $post->ID, 'category' );
  echo publications_show_terms( $terms, 'Subject');
}

function publications_show_terms( $terms, $label ) {
  $html = '';

  if( count($terms) ) {
    $html .=  '<div><span class="aasf-label">' . $label  . ':   </span>';
    foreach ( $terms as $term ) {
      $html .=  "<a href='". get_term_link( $term ) . "'>" . $term->name . "</a>";
      if ( $term !== end($terms) ) {
        $html .= ', ';
      }
    }
    $html .= '</div>';
  }

  return $html;
}


genesis(); 
