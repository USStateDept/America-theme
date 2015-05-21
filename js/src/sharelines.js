;(function ( $, window, document, undefined ) {

    var $sharelines = $('.shareline li'),
        url = window.location.href;

    function buildTweet ( $listItem ) {
        var text = $listItem.text(),
            intentQuery = $.param({ 'text': text, 'url': url }),
            intentHref = 'https://twitter.com/intent/tweet?' + intentQuery;

        return $('<a></a>').attr('href', intentHref).text(text);
    }

    function buildIntent ( item ) {
        var $this = $(item),
            $link = buildTweet( $this );

        $this.html($link);
    }

    $sharelines.each(function() {
        buildIntent(this);
    });

})( jQuery, window, document );
