<?php

add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_sidebar_content' );
add_filter( 'post_class',                         'amgov_pubs_archive_post_class' );
add_filter( 'genesis_post_meta',                  'america_post_meta_format_filter' );

remove_action( 'genesis_entry_header',   'genesis_entry_header_markup_open', 5 );
remove_action( 'genesis_entry_header',   'genesis_do_post_title' );
remove_action( 'genesis_entry_header',   'genesis_post_info', 12 );
remove_action( 'genesis_entry_header',   'genesis_entry_header_markup_close', 15 );
remove_action( 'genesis_entry_content',  'genesis_do_post_image', 8 );
remove_action( 'genesis_entry_content',  'genesis_do_post_content' );
remove_action( 'genesis_entry_footer',   'genesis_entry_footer_markup_open', 5 );
remove_action( 'genesis_entry_footer',   'genesis_entry_footer_markup_close', 15 );
remove_action( 'genesis_entry_footer',   'genesis_post_meta' );
remove_action( 'genesis_after_endwhile', 'genesis_posts_nav' );  // remove default pagination as we need to add query vars to track checkboxes selected (see america-ajax-search-filter plugin)


add_action( 'genesis_after_header',   'amgov_pubs_swap_sidebars' );
add_action( 'genesis_before_content', 'america_add_search_term' );
add_action( 'genesis_entry_content',  'amgov_pubs_do_post_content' );

function amgov_pubs_archive_post_class( $classes ) {
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
function amgov_pubs_swap_sidebars() {
  remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );
  remove_action( 'genesis_sidebar_alt', 'genesis_do_sidebar_alt' );
  add_action( 'genesis_sidebar', 'genesis_do_sidebar_alt' );
}

function america_add_search_term() {
  global $wp_query;
  echo $wp_query->found_posts;
  echo '<h3>Search results for <span>' . get_query_var('s') .'</span></h3>';
}

function amgov_pubs_do_post_content() {
  global $post;
  
  amgov_pubs_do_post_image(); 
  echo '<div class="publication-content">';
  genesis_do_post_title();
  amgov_pubs_meta_format();
  genesis_do_post_content();
  amgov_pubs_meta_subject();
  echo '</div>';
}

function amgov_pubs_do_post_image() {
  $image = genesis_get_image( 'format=url&size=post-thumbnail' );
  if( !$image ) {
    $image = 'http://dummyimage.com/150x188/ddd/aaa.png&text=placeholder';
  }
  printf( '<div class="publication-featured-image"><a href="%s" rel="bookmark"><img src="%s" alt="%s" width="150" height="188"/></a></div>', get_permalink(), $image, the_title_attribute( 'echo=0' ) );
}


function amgov_pubs_meta_format () {
  global $post;
  
  $terms = wp_get_post_terms( $post->ID, 'publication_type' );
  echo amgov_pubs_show_terms( $terms, 'Format');
}

function amgov_pubs_meta_subject () {
  global $post;
  
  $terms = wp_get_post_terms( $post->ID, 'category' );
  echo amgov_pubs_show_terms( $terms, 'Subject');
}

function amgov_pubs_show_terms( $terms, $label ) {
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
