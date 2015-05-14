;(function ( $, window, document, undefined ) {

    $(document).ready(function() {
        var $vidThumbs = $(
          '.archive .content .format-video .entry-image,
           .archive .content .category-video .entry-image,
           .blog .content .format-video .entry-image,
           .blog .content .category-video .entry-image'
        );

        var $videoWatermark = $('<div/>').addClass('video-watermark');

        $vidThumbs.after($videoWatermark);
    });

})( jQuery, window, document );
