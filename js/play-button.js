jQuery(function($) {
  var $vidThumbs = $(
    '.archive .content .format-video .entry-image,
     .archive .content .category-video .entry-image,
     .blog .content .format-video .entry-image,
     .blog .content .category-video .entry-image'
  );

  var $playButton = $('<div/>').addClass('play-button');

  $vidThumbs.after($playButton);

});
