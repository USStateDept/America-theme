jQuery(function($) {
  var $vidThumbs = $(
    '.archive .format-video .entry-image,
     .archive .category-video .entry-image,
     .blog .format-video .entry-image,
     .blog .category-video .entry-image'
  );

  var $playButton = $('<div/>').addClass('play-button');

  $vidThumbs.after($playButton);

});
