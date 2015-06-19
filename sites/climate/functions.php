<?php

/**
 * Initialize the America_Theme_Extender class if it is not already loaded
 * sending in both a path to the direcotry on filesystem where assets are
 * located and url to assets. The params are set to reasonable defaults
 * and can be changed if necessary.
 *
 * @param  string $path default path to granchild assets (i.e. sites/climate)
 */
function initialize_site( $path ) {
	$dir = get_stylesheet_directory() . '/' . $path;
	$uri = get_stylesheet_directory_uri() . '/' . $path;

	if( class_exists ('America_Theme_Extender') ) {
		$america_theme_extender = new America_Theme_Extender( $dir, $uri );
	}
}

//* Display a custom favicon
add_filter( 'genesis_pre_load_favicon', 'sp_favicon_filter' );
function sp_favicon_filter( $favicon_url ) {
	return '/wp-content/themes/america/sites/climate/images/dist/favicon.ico';
}


//* Add image sizes
add_image_size( 'medium', 285, 190, TRUE );
add_image_size( 'large', 768, 396, TRUE);


//* Set Feature Image Size
set_post_thumbnail_size( 800, 450, TRUE );


//* Make custom image sizes selectable from WordPress admin
add_filter( 'image_size_names_choose', 'climate_custom_sizes' );
function climate_custom_sizes( $sizes ) {
    return array_merge( $sizes, array(
				'post-thumbnail' => __( 'Post Feature Image Default' ),
    ) );
}


/*add_filter( 'img_caption_shortcode', 'fix_img_caption_shortcode_inline_style', 10, 3 );
function fix_img_caption_shortcode_inline_style( $empty, $attr, $content ) {

	$atts = shortcode_atts( array(
		'id'	  => '',
		'align'	  => 'alignnone',
		'width'	  => '',
		'caption' => '',
		'class'   => '',
	), $attr, 'caption' );

	$atts['width'] = (int) $atts['width'];
	if ( $atts['width'] < 1 || empty( $atts['caption'] ) )
		return $content;

	if ( ! empty( $atts['id'] ) )
		$atts['id'] = 'id="' . esc_attr( $atts['id'] ) . '" ';

	$class = trim( 'wp-caption ' . $atts['align'] . ' ' . $atts['class'] );

	if ( current_theme_supports( 'html5', 'caption' ) ) {
		return '<figure ' . $atts['id'] . 'class="' . esc_attr( $class ) . '">'
		. do_shortcode( $content ) . '<figcaption style="width: ' . (int) $atts['width'] . 'px;"' . 'class="wp-caption-text">' . $atts['caption'] . '</figcaption></figure>';
	}
}*/
