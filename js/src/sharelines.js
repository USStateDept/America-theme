;(function ( $, window, document, undefined ) {

    $(document).ready(function() {
        var $sharelines = $('.shareline li'),
            url = window.location.href;

        function buildTweet ( $listItem ) {
            var text = $listItem.data('tweetContent'),
                url = $listItem.data('tweetUrl'),
                intentQuery = $.param({ 'text': text, 'url': url }),
                intentHref = 'https://twitter.com/intent/tweet?' + intentQuery;

            return $('<a></a>').attr('href', intentHref).text(text);
        }

        function buildIntent ( item ) {
            var $this = $(item);

            $this.attr('data-tweet-content', $this.text());
            $this.attr('data-tweet-url', url);

            var $link = buildTweet( $this );

            $this.html($link);
        }

        $sharelines.each(function() {
            buildIntent(this);
        });

    });

})( jQuery, window, document );
