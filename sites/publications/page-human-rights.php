<?php
/**
 * This file adds the Home Page to the publications site.
 *
 * @author Office of Design, Bureau of International Information Programs
 * @package America.gov
 * @subpackage Publications
 */
/*
Template Name: About America publications landing
*/

// set full width layout
add_filter ( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

// remove Genesis default loop
remove_action( 'genesis_loop', 'genesis_do_loop' );

// Add our custom loop
add_action( 'genesis_loop', 'publications_cat_loop' );
function publications_cat_loop() {
	$args = array(
		'post_type' => 'publications', 
		'category_name' => 'human-rights',
		'orderby'       => 'post_date',
		'order'         => 'DESC',
		'posts_per_page'=> '20', // overrides posts per page in theme settings
	);
	$loop = new WP_Query( $args );
	if( $loop->have_posts() ) {
		echo '<div class="home-category-header clearfix"><h3 class="category-header clearfix">Human Rights</h3></div>';
		// loop through posts
		while( $loop->have_posts() ): $loop->the_post();
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