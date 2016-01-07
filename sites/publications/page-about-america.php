<?php
/**
 * This file adds the bout America publications landing page to the publications site.
 *
 * @author Office of Design, Bureau of International Information Programs
 * @package America.gov
 * @subpackage Publications
 */
/*
Template Name: About America publications landing
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

// remove Genesis default loop
remove_action( 'genesis_loop', 'genesis_do_loop' );

// Add our custom loop
add_action( 'genesis_loop', 'publications_cat_loop' );
function publications_cat_loop() {
	$args = array(
		'post_type' => 'publications', 
		'category_name' => 'about-america',
		'orderby'       => 'post_date',
		'order'         => 'DESC',
		'posts_per_page'=> '20', // overrides posts per page in theme settings
	);
	$loop = new WP_Query( $args );
	if( $loop->have_posts() ) {
		// loop through posts
		while( $loop->have_posts() ): $loop->the_post();
		echo '<div class="one-third-home clearfix">';
			echo '<div class="home-post-thumb clearfix">' . get_the_post_thumbnail() . '</div>';
			echo '<div class="home-post-data">';
				echo '<h6><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h6>';
				echo '<div class="blurb">' . the_field('blurb') . '</div>';
			echo '</div>';
		echo '</div>';
		endwhile;
	}
	wp_reset_postdata();
}


genesis(); ?>