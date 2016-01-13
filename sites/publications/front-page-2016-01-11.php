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
		echo '<div class="home-category-header clearfix">
				<h3 class="category-header clearfix">About America</h3>
				<span class="category-header-more clearfix"><a href="/about-america">See all ></></span>
			  </div>';

		// loop through posts
		while( $loop->have_posts() ): $loop->the_post();
		echo '<div class="one-third-home clearfix">';
			echo '<div class="home-post-thumb clearfix">' . get_the_post_thumbnail() . '</div>';
			echo '<div class="home-post-data">';
				echo '<h6><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h6>';
				echo '<div class="blurb">' . the_field('blurb') . '</div>';
				echo '<div>' . get_the_terms('publication_type') . '</div>';
			echo '</div>';
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
		echo '<div class="home-category-header clearfix">
				<h3 class="category-header clearfix">Human Rights</h3>
				<span class="category-header-more clearfix"><a href="/human-rights">See all ></></span>
			  </div>';
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

// Add our custom loop
add_action( 'genesis_loop', 'publications_home_democracy_loop' );
function publications_home_democracy_loop() {
	$args = array(
		'post_type' => 'publications', 
		'category_name' => 'democracy',
		'orderby'       => 'post_date',
		'order'         => 'DESC',
		'posts_per_page'=> '3', // overrides posts per page in theme settings
	);
	$loop = new WP_Query( $args );
	if( $loop->have_posts() ) {
		echo '<div class="home-category-header clearfix">
				<h3 class="category-header clearfix">Democracy</h3>
				<span class="category-header-more clearfix"><a href="/democracy">See all ></></span>
			  </div>';
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