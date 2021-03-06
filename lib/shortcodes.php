<?php

function america_responsive_iframe( $atts, $content = null ) {
  extract( shortcode_atts( array(
      'allowfullscreen' => 1,
      'chat' => 0,
      'iframe_class' => '',
      'ratio' => '16-9',
      'responsive' => 1,
      'frameborder' => 0,
      'height' => 315,
      'width' => 560,
  ), $atts ));

   $container_classes = '';

   if ( $chat == 1 ) {
     $container_classes .= ' chat';
   } else {
     $container_classes .= '';
   }

   if ( $ratio == '4-3' ) {
     $container_classes .= ' ratio-4-3';
   } else {
     $container_classes .= ' ratio-16-9';
   }

   if ( $responsive == '0' ) {
     $container_classes .= ' no-responsive';
   } else {
     $container_classes .= ' responsive';
   }

   $markup = '<div class="media-container' . $container_classes . '">' ;

   $markup .= '<iframe class="' . $iframe_class . '" src="' . $content . '" width="' . $width . '" height="' . $height . '" frameborder="' . $frameborder . '" allowfullscreen="' . $allowfullscreen . '" ></iframe>';

   $markup .= '</div>';

   return $markup;
}


function america_breakout( $atts, $content = null ) {
  extract( shortcode_atts( array(
    'align' => 'alignleft',
    'title' => 'Key Takeways',
    'type' => 'takeway',
    'width' => ''
  ), $atts ));

  $markup = '<div class="breakout '. $type . ' ' . $align . ' ' . $width .'">';
    $markup .= '<h3 class="breakout-title">'.$title.'</h3>';
    $markup .= '<ul>'.$content.'</ul></div>';
  return $markup;
}


function america_blockquote( $atts, $content = null ) {
  extract( shortcode_atts( array(
    'type' => 'default',
    'align' => 'aligncenter',
  ), $atts ));

  $markup = '<blockquote class="' . $type . ' ' . $align . '">';

  $markup .= $content . '</blockquote>';

  return $markup;
}


function america_picturefill( $atts ) {
  extract( shortcode_atts( array(
    'id' => '',
    'names' => '',
    'sizes' => '',
    'min_widths' => '',
    'align' => 'alignnone',
    'class' => '',
  ), $atts ));

  $names = preg_split( "/(, |,)/", $names );
  $sizes = preg_split( "/(, |,)/", $sizes );
  $min_widths = preg_split( "/(, |,)/", $min_widths );
  $alt = isset( get_post_meta( $id, '_wp_attachment_image_alt', false)[0] ) ? esc_attr__( get_post_meta( $id, '_wp_attachment_image_alt', false )[0] ) : esc_attr( '' );
  $caption = trim( strip_tags( get_post( $id ) -> post_excerpt ) );
  $class = trim( 'wp-caption ' . $align . ' ' . $class );

  $markup = '<figure id="attachment_'. esc_attr( $id ) . '" class="' . esc_attr( $class ) . '">';
		$markup .= '<img ';
      $markup .= america_generate_srcset( $id, $names, $sizes );
      $markup .= america_generate_sizes( $min_widths, $sizes );
      $markup .= 'alt="'. $alt .'"';
    $markup .= '>';
    $markup .= '<figcaption class="wp-caption-text">';
			$markup .= $caption;
		$markup .= '</figcaption>';
	$markup .= '</figure>';

	return $markup;
}
