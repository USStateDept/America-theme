<?php
//* Start the engine
require_once( get_template_directory() . '/lib/init.php' );


//* Setup Theme
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

//* Get shortcodes
include_once( get_stylesheet_directory() . '/lib/shortcodes.php' );


//* Set Localization (do not remove)
load_child_theme_textdomain( 'america', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'america' ) );


//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', __( 'America.gov Theme', 'america' ) );
define( 'CHILD_THEME_URL', 'http://www.america.gov/' );
define( 'CHILD_THEME_VERSION', '1.0.0' );

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );


//* Add Post Formats
add_theme_support( 'post-formats', array( 'gallery', 'image', 'video', 'audio' ) );


//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Enqueue Scripts
add_action( 'wp_enqueue_scripts', 'america_load_scripts' );
function america_load_scripts() {

	wp_enqueue_script( 'america-file-extensions', get_bloginfo( 'stylesheet_directory' ) . '/js/main.min.js', array( 'jquery' ), '1.0.0' );

	wp_enqueue_style( 'dashicons' );

	wp_enqueue_style( 'google-font', '//fonts.googleapis.com/css?family=Source+Sans+Pro:400,700,400italic|Signika', array(), CHILD_THEME_VERSION );

	// IE Specific Script
	wp_enqueue_script( 'lte-ie8', get_bloginfo( 'stylesheet_directory' ) . '/js/lte-ie8.min.js', array(), '1.0.0', false );

	// Event tracking script
	wp_enqueue_script( 'analytics-events', get_bloginfo( 'stylesheet_directory' ) . '/js/analytics-events.min.js', array(), '1.0.0', false );

	add_filter( 'script_loader_tag', function( $tag, $handle ) {
	    if ( $handle === 'lte-ie8' ) {
	        $tag = "<!--[if lte IE 8]>$tag<![endif]-->";
	    }
	    return $tag;
	}, 10, 2 );

}


//* init shortcodes
function america_register_shortcodes(){
	add_shortcode('iframe', 'america_responsive_iframe');
	add_shortcode('takeaway', 'america_takeaway');
	add_shortcode('blockquote', 'america_blockquote');
}
add_action('init', 'america_register_shortcodes');


//* Add new image sizes
add_image_size( 'featured-primary', 700, 475, TRUE );
add_image_size( 'featured-category', 500, 500, TRUE );
add_image_size( 'disinfo-featured', 720, 470, TRUE );
add_image_size( 'disinfo-archive', 340, 200, TRUE );
add_image_size( 'disinfo-sidebar', 100, 100, TRUE );
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



/************************************** Removed for Disinfo; Check publications ************************************** */
//* Relocate the post info
// remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
// add_action( 'genesis_entry_header', 'genesis_post_info', 5 );


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


//* Footer widget area
add_theme_support( 'genesis-footer-widgets', 2 );


//* Remove Footer Credits
remove_action( 'genesis_footer', 'genesis_do_footer' );


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

/**
 * Utility class that returns the sub site part of the url; used to locate correct asset folder (i.e. /climate or /misinfo)
 * Folder names MUST match the path entered in the "path" field of the Edit Sites admin screen
 * 
 * @param  int 		$id current blog_id
 * @return string   url part
 */
function america_get_site_path_part( $id ) {
	$sites = wp_get_sites();

	foreach ( $sites as $site ) {
		foreach ( $site as $key => $value )  {
			if( $key == 'blog_id' ) {
				if( $value == $id ) {
					extract($site);
					$len = strlen($path) - 2;
						return substr( $path , 1, $len );
				}
			}
		}
	}
}

// Loads grandchild theme functons file if file is present and initializes extender
// Currently each grandchild theme requires a functions.php file in order to load css,
// templates, etc.
function load_grandchild_theme() {
	$grandchild_theme_root = 'sites/';
	$grandchild_theme = $grandchild_theme_root . america_get_site_path_part( get_current_blog_id() );
	$grandchild_path = get_stylesheet_directory() . '/' . $grandchild_theme; 
	$functions_file = $grandchild_path. '/functions.php';

	if ( file_exists( $functions_file ) ) {
		include_once( $functions_file );
		initialize_site( $grandchild_theme );
	} 
}

// Load theme extender
load_grandchild_theme();


//* Remove unwanted p tags
//* From: https://wordpress.org/plugins/shortcode-empty-paragraph-fix/
function shortcode_empty_paragraph_fix( $content ) {

    // define your shortcodes to filter, '' filters all shortcodes
    $shortcodes = array( 'iframe', 'takeaway', 'blockquote' );

    foreach ( $shortcodes as $shortcode ) {

        $array = array (
            '<p>[' . $shortcode => '[' .$shortcode,
            '<p>[/' . $shortcode => '[/' .$shortcode,
            $shortcode . ']</p>' => $shortcode . ']',
            $shortcode . ']<br />' => $shortcode . ']'
        );

        $content = strtr( $content, $array );
    }

    return $content;
}

add_filter( 'the_content', 'shortcode_empty_paragraph_fix' );


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
/*function get_publication_template( $template ) {
  if(  is_category() || is_search() || is_tax() ) {
  	$template = get_query_template( 'archive-publication' );
  }
  return $template;
}

add_filter( 'template_include', 'get_publication_template' );*/

/********************************************** END MOVE TO PLUGIN ******************************************* */
