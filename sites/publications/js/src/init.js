;(function ( $, window, document, undefined ) {

    $(document).ready(function() {
        // init responsive navigation
        $('.genesis-nav-menu').responsiveMenu();

        // add dropdown arrow to wpml language switcher
        $(".menu-item-language").addClass("menu-item-has-children");
    });
    
})( jQuery, window, document );
