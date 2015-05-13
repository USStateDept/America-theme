jQuery(function($) {
  var $vidThumbs = $(
    '.archive .content .format-video .entry-image,
     .archive .content .category-video .entry-image,
     .blog .content .format-video .entry-image,
     .blog .content .category-video .entry-image'
  );

  var $videoWatermark = $('<div/>').addClass('video-watermark');

  $vidThumbs.after($videoWatermark);

});
