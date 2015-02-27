<?php
//* Start the engine
require_once( get_template_directory() . '/lib/init.php' );


//* Setup Theme
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );


//* Set Localization (do not remove)
load_child_theme_textdomain( 'america', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'america' ) );


//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', __( 'America.gov Theme', 'america' ) );
define( 'CHILD_THEME_URL', 'http://www.america.gov/' );
define( 'CHILD_THEME_VERSION', '1.0.0' );


//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );


//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );


//* Enqueue Scripts
add_action( 'wp_enqueue_scripts', 'america_load_scripts' );
function america_load_scripts() {

	wp_enqueue_script( 'america-responsive-menu', get_bloginfo( 'stylesheet_directory' ) . '/js/responsive-menu.js', array( 'jquery' ), '1.0.0' );

	wp_enqueue_script( 'america-file-extensions', get_bloginfo( 'stylesheet_directory' ) . '/js/file-ext.js', array( 'jquery' ), '1.0.0' );

	wp_enqueue_style( 'dashicons' );

	wp_enqueue_style( 'google-font', '//fonts.googleapis.com/css?family=Source+Sans+Pro:400,700,400italic|Signika', array(), CHILD_THEME_VERSION );
}


//* Add new image sizes
add_image_size( 'featured-primary', 700, 475, TRUE );
add_image_size( 'featured-category', 500, 500, TRUE );
//add_image_size( 'publication', 424, 530, TRUE );


//* Add support for custom header
add_theme_support( 'custom-header', array(
	'width'           => 260,
	'height'          => 100,
	'header-selector' => '.site-title a',
	'header-text'     => false
) );


//* Add support for additional color style options
add_theme_support( 'genesis-style-selector', array(
	'america'   => __( 'America.gov Theme', 'america' ),
) );


//* Unregister layout settings
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );


//* Unregister secondary sidebar
unregister_sidebar( 'sidebar-alt' );


//* Load Admin Stylesheet
add_action( 'admin_enqueue_scripts', 'america_load_admin_styles' );
function america_load_admin_styles() {

	wp_register_style( 'custom_wp_admin_css', get_stylesheet_directory_uri() . '/lib/admin-style.css', false, '1.0.0' );
	wp_enqueue_style( 'custom_wp_admin_css' );

}


//* Remove the site description
remove_action( 'genesis_site_description', 'genesis_seo_site_description' );


//* Reposition the secondary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_footer', 'genesis_do_subnav', 7 );


//* Reduce the secondary navigation menu to one level depth
add_filter( 'wp_nav_menu_args', 'america_secondary_menu_args' );
function america_secondary_menu_args( $args ){

	if( 'secondary' != $args['theme_location'] )
	return $args;

	$args['depth'] = 1;
	return $args;

}


//* Relocate the post info
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
add_action( 'genesis_entry_header', 'genesis_post_info', 5 );


//* Remove comment form allowed tags
add_filter( 'comment_form_defaults', 'america_remove_comment_form_allowed_tags' );
function america_remove_comment_form_allowed_tags( $defaults ) {

	$defaults['comment_notes_after'] = '';
	return $defaults;

}


//* Add support for after entry widget
add_theme_support( 'genesis-after-entry-widget-area' );

//* Relocate after entry widget
remove_action( 'genesis_after_entry', 'genesis_after_entry_widget_area' );
add_action( 'genesis_after_entry', 'genesis_after_entry_widget_area', 5 );

//* Register widget areas
genesis_register_sidebar( array(
	'id'          => 'home-top',
	'name'        => __( 'Home - Top', 'america' ),
	'description' => __( 'This is the top-most section on the home page.', 'america' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-middle',
	'name'        => __( 'Home - Middle', 'america' ),
	'description' => __( 'This is the middle section of the home page.', 'america' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-cta',
	'name'        => __( 'Home - Call To Action', 'america' ),
	'description' => __( 'This is the call to action section on the home page.', 'america' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-bottom',
	'name'        => __( 'Home - Bottom', 'america' ),
	'description' => __( 'This is the bottom section of the home page (above the footer).', 'america' ),
) );


//* Remove Footer Credits
remove_action( 'genesis_footer', 'genesis_do_footer' );
add_action( 'genesis_footer', 'sp_custom_footer' );
function sp_custom_footer() {
	?>
	<p class="site-footer-legal">This site is managed by the <a href="http://www.state.gov/r/iip" target="_blank">Bureau of International Information Programs</a> within the  <a href="http://www.state.gov" target="_blank">U.S. Department of State</a>. External links to other Internet sites should not be construed as an endorsement of the views or privacy policies contained therein.</p>
	<?php
}

//* Untility function to get file size
function remote_filesize($url) {
	static $regex = '/^Content-Length: *+\K\d++$/im';

	if ( !$fp = @fopen( $url, 'rb' ) ) {
		return false;
	}

	if ( isset( $http_response_header ) && preg_match( $regex, implode( "\n", $http_response_header ), $matches ) ) {
		return (int)$matches[0];
	}

	return strlen(stream_get_contents($fp));
}

//* Utility function to format file size
function format_file_size( $size ) {
	if ( $size >= 1000000000 ) {
		$fileSize = round( $size / 1000000000, 1 ) . 'GB';
	} elseif ( $size >= 1000000 ) {
		$fileSize = round( $size / 1000000, 1) . 'MB';
	} elseif ( $size >= 1000 ){
		$fileSize = round( $size / 1000, 1 ) . 'KB';
	} else {
		$fileSize = $size . ' bytes';
	}
	return $fileSize;
}

/************************************** MOVE TO PLUGIN AND MAKE GENERIC ************************************** */

// When moved to plugin, associated styles need to moved as well.

//* Featured Custom Post Type, Featured Page and Featured Category widgets
include_once( CHILD_DIR . '/lib/featured-cpt-widget.php' );
include_once( CHILD_DIR . '/lib/featured-category-widget.php' );

function custom_replace_featured_post_widget() {
	register_widget( 'America_Featured_Custom_Post' );
}

function custom_replace_featured_category_widget() {
	register_widget( 'America_Featured_Category' );
}

add_action( 'widgets_init', 'custom_replace_featured_post_widget' );
add_action( 'widgets_init', 'custom_replace_featured_category_widget' );


//* Redirect search, category and taxonomy archives to use archive-publication template
function get_publication_template( $template ) {
  if(  is_category() || is_search() || is_tax() ) {
  	$template = get_query_template( 'archive-publication' );
  }
  return $template;
}

add_filter( 'template_include', 'get_publication_template' );

/********************************************** END MOVE TO PLUGIN ******************************************* */
