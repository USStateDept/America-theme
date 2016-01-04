<?php
/**
 * This file adds the Home Page to the publications site.
 *
 * @author Office of Design, Bureau of International Information Programs
 * @package America.gov
 * @subpackage Publications
 *Template Name: Publication homepage
 */

// Removing page heading
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );

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
		echo '<div class="one-third">';
			echo '<h6>' . get_the_title() . '</h6>';
			echo '<p>' . get_the_post_thumbnail() . '</p>';
			echo '<p><a href="' . get_the_permalink() . '"</a></p>';
		echo '</div>';
		endwhile;
	}
	wp_reset_postdata();
}
genesis();