<?php
/**
 * Template Name: Publications  Archives
 */

remove_action ('genesis_loop', 'genesis_do_loop'); // Remove the standard loop
add_action( 'genesis_loop', 'custom_do_grid_loop' ); // Add custom loop
function custom_do_grid_loop() {  
  	
	$args = array(
		'post_type' => 'publications', // enter your custom post type
		'posts_per_page'=> '12',  // overrides posts per page in theme settings
	);
	$loop = new WP_Query( $args );
	if( $loop->have_posts() ):
				
		while( $loop->have_posts() ): $loop->the_post(); global $post;
		echo '<div id="testimonials">';
			echo '<div class="one-fourth first">';
			echo '<div class="quote-obtuse"><div class="pic">'. get_the_post_thumbnail( $id, array(150,150) ).'</div></div>';
			echo '<div style="margin-top:20px;line-height:20px;text-align:right;"><cite>'.genesis_get_custom_field( '_cd_client_name' ).'</cite><br />'.genesis_get_custom_field( '_cd_client_title' ).'</div>';
			echo '</div>';	
			echo '<div class="three-fourths" style="border-bottom:1px solid #DDD;">';
			echo '<h3>' . get_the_title() . '</h3>';
			echo '<blockquote><p>' . get_the_content() . '</p></blockquote>';	
			echo '</div>';
		echo '</div>';
		
		endwhile;
		
	endif;
	
}
	
/** Remove Post Info */
remove_action('genesis_before_post_content','genesis_post_info');
remove_action('genesis_after_post_content','genesis_post_meta');
 
genesis();