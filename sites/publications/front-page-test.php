<?php
/**
 * This file adds the Home Page to the publications site.
 *
 * @author Office of Design, Bureau of International Information Programs
 * @package America.gov
 * @subpackage Publications
 *Template Name: Publication homepage
 */

// Add our custom loop
add_action( 'genesis_loop', 'cd_goh_loop' );
function cd_goh_loop() {
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
		echo '<div class="two-thirds">';
			echo '<h4>' . get_the_title() . '</h4>';
			echo '<p>' . get_the_thumbnail() . '</p>';
			echo '<p><a href="' . get_the_permalink() . '"</a></p>';
		echo '</div>';
		endwhile;
	}
	wp_reset_postdata();
}
genesis();