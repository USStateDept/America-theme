;(function ( $, window, document, undefined ) {

  $(document).ready(function() {
      var $files = $('.downloads-file');

      $files.each(function() {
          var $this = $(this),
              $ext = $this.attr('href').split('.').pop();

          $this.addClass($ext);
      });
  });

})( jQuery, window, document );
