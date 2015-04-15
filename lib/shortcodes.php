<?php

function america_responsive_iframe( $atts, $content = null ) {
  extract(shortcode_atts(array(
      'allowfullscreen' => 1,
      'chat' => 0,
      'class' => '',
      'frameborder' => 0,
      'height' => 315,
      'width' => 560,
   ), $atts));

   if ( $chat == 1 ) {
     $markup = '<div class="iframe-wrapper chat">';
   } else {
     $markup = '<div class="iframe-wrapper">';
   }

   $markup .= '<iframe class="' . $class . '" src="' . $content . '" width="' . $width . '" height="' . $height . '" frameborder="' . $frameborder . '" allowfullscreen="' . $allowfullscreen . '" ></iframe>';

   $markup .= '</div>';

   return $markup;
}
