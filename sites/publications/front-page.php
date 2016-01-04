<?php
/**
 * This file adds the Home Page to the publications site.
 *
 * @author Office of Design, Bureau of International Information Programs
 * @package America.gov
 * @subpackage Publications
 *Template Name: Publication homepage
 */

// set full width layout
add_filter ( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

// remove Genesis default loop
remove_action( 'genesis_loop', 'genesis_do_loop' );

// Add our custom loop
add_action( 'genesis_loop', 'publications_home_about_loop' );
function publications_home_about_loop() {
	$args = array(
		'post_type' => 'publications', 
		'category_name' => 'about-america',
		'orderby'       => 'post_date',
		'order'         => 'DESC',
		'posts_per_page'=> '3', // overrides posts per page in theme settings
	);
	$loop = new WP_Query( $args );
	if( $loop->have_posts() ) {
		// loop through posts
		while( $loop->have_posts() ): $loop->the_post();
		echo '<div class="one-third-home">';
			echo '<div class="home-post-thumb clearfix">' . get_the_post_thumbnail() . '</div>';
			echo '<h6>' . get_the_title() . '</h6>';
			echo '<p><a href="' . get_the_permalink() . '"</a></p>';
		echo '</div>';
		endwhile;
	}
	wp_reset_postdata();
}

// Add our custom loop
add_action( 'genesis_loop', 'publications_home_human_rights_loop' );
function publications_home_human_rights_loop() {
	$args = array(
		'post_type' => 'publications', 
		'category_name' => 'human-rights',
		'orderby'       => 'post_date',
		'order'         => 'DESC',
		'posts_per_page'=> '3', // overrides posts per page in theme settings
	);
	$loop = new WP_Query( $args );
	if( $loop->have_posts() ) {
		// loop through posts
		while( $loop->have_posts() ): $loop->the_post();
		echo '<div class="one-third-home">';
			echo '<div class="home-post-thumb clearfix">' . get_the_post_thumbnail() . '</div>';
			echo '<h6>' . get_the_title() . '</h6>';
			echo '<p><a href="' . get_the_permalink() . '"</a></p>';
		echo '</div>';
		endwhile;
	}
	wp_reset_postdata();
}




genesis();