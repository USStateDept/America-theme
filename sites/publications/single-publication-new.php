<?php
/**
  * This file adds the custom publicaton post type single post template to the America.gov Theme.
  *
  * @author Office of Design, Bureau of International Information Programs
  * @package America.gov
  * @subpackage Customizations
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


/*
 * Rebuilding the page with our custom markup
 */

// remove Genesis default loop
remove_action( 'genesis_loop', 'genesis_do_loop' );

<article itemtype="http://schema.org/CreativeWork" itemscope="itemscope" class="post-<?php print $pageid; ?> page type-page status-publish entry">
<div class="entry-content" itemprop=”text”>

<div class="">
<?php if(have_posts()) : while(have_posts()) : the_post();

/* Custom meta boxes */
echo '<div class="intro-tekst"> ' . get_field('intro_tekst') . ' </div>';
echo '<div class="images"> ' . get_field('images') . ' </div>';
echo '<div class="trailer"> ' . get_field('trailer') . ' </div>';
echo '<div class="teknisk-info"> ' . get_field('teknisk_info') . ' </div>';
echo '<div class="synopsis"> ' . get_field('synopsis') . ' </div>';

endwhile; endif;
?>
</div></div></article>



genesis();
