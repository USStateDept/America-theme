<?php

add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_sidebar_content' );
add_filter( 'post_class', 'publications_archive_post_class' );
add_filter( 'genesis_post_meta', 'america_post_meta_all_filter' );

remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );

add_action( 'genesis_sidebar', 'america_add_sidebar_filter' );
add_action( 'genesis_before_content', 'america_add_search_term' );
add_action( 'genesis_entry_content', 'genesis_do_post_image', 10 );
add_action( 'genesis_entry_content', 'genesis_do_post_title', 11 );
add_action( 'genesis_entry_content', 'genesis_post_meta', 12 );
add_action( 'genesis_entry_content', 'genesis_do_post_content', 13 );
//add_action( 'genesis_entry_content', 'genesis_post_meta', 14 );


function publications_archive_post_class( $classes ) {
  global $wp_query;
  if( ! $wp_query->is_main_query() )
    return $classes;
    
  $classes[] = 'one-half';
  $classes[] = 'pubs-search-post';
  if( 0 == $wp_query->current_post || 0 == $wp_query->current_post % 2 )
    $classes[] = 'first';
  return $classes;
}

function america_post_meta_all_filter( $post_meta ) {
  $post_meta = '[post_categories before="Subject: "]';
  $post_meta .= '[post_tags before="Tagged: "]';
  $post_meta .= '[publication_type before="Format: "]';
  return $post_meta;
}

// function america_meta_format() {
//   echo 'format';
// }

// function america_meta_subject() {
//   var_dump($wp_query); die();
//   echo 'subject';
// }

function america_add_sidebar_filter () {
	echo do_shortcode('[aasf filter_by="publication-type, category" layout="checkbox" show_taxonomy_name="true"]');
}

function america_add_search_term() {
	echo '<h3>Search results for <span>' . get_query_var('s') .'</span></h3>';
}

genesis(); 