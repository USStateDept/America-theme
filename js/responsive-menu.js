jQuery(function( $ ){

	var breakPoint = 800;

	if (window.innerWidth < breakPoint) {
		$(".genesis-nav-menu").addClass("responsive-menu");
	} else {
		$(".genesis-nav-menu").removeClass("responsive-menu");
	}

	$(".nav-primary .genesis-nav-menu, .nav-secondary .genesis-nav-menu, .header-widget-area").before('<div class="responsive-menu-icon"></div>');

	// Add class "menu-item-has-children" to wpml language switcher
	$(".menu-item-language").addClass("menu-item-has-children");

	$(".responsive-menu-icon").click(function(){
		$(".genesis-nav-menu").slideToggle();
	});

	$(window).resize(function() {
		if (window.innerWidth < breakPoint) {
			$(".genesis-nav-menu").addClass("responsive-menu");
			$(".genesis-nav-menu, .sub-menu").removeAttr("style");
			$(".responsive-menu > .menu-item").removeClass("menu-open");
		} else {
			$(".genesis-nav-menu").removeClass("responsive-menu");
		}
	});

	$(".menu-item-has-children").click(function(event){
		$(this).find(".sub-menu:first").slideToggle(function() {
			$(this).parent().toggleClass("menu-open");
		});
	});

});
