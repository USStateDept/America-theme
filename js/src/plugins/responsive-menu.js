;(function ( $, window, document, undefined ) {

    // Create the defaults once
    var pluginName = "responsiveMenu",

        defaults = {
					breakpoint: 800,
					iconClass: "responsive-menu-icon"
				};

    // The actual plugin constructor
    function Plugin ( element, options ) {
        this.element = element;
        this.settings = $.extend( {}, defaults, options );
        this._defaults = defaults;
        this._name = pluginName;
        this.init();
    }

    Plugin.prototype = {
        init: function () {
						this.$window = $(window);
						this.$nav = $(this.element);
						this.$mobileIcon = this.loadMobileIcon();
						this.toggleResponsiveClass();
						this.initSubMenu();
            this.bindUiActions();
        },

        bindUiActions: function () {
            this.click();
						this.resize();
        },

        click: function () {
            var _this = this;

						_this.$mobileIcon.on("click", function () {
								_this.$nav.slideToggle();
						});
        },

				resize: function () {
						var _this = this;

						_this.$window.on("resize", function () {
								_this.toggleResponsiveClass();
						});
				},

				// Build and insert the hamburger menu
				loadMobileIcon: function () {
						var _this = this,
								$icon = $("<div/>").addClass(_this.settings.iconClass);

						_this.$nav.before($icon);
						return $icon;
				},

				// Toggle responsive class and remove styles on main navigation when
				// going from small viewport to large viewport
				toggleResponsiveClass: function () {
						var _this = this;

						if ( window.innerWidth < _this.settings.breakpoint ) {
								_this.$nav.addClass("responsive-menu");
						} else {
								_this.$nav.removeClass("responsive-menu").removeAttr("style");
						}
				},

				initSubMenu: function () {
						$(".menu-item-has-children").click(function(event){
								$(this).find(".sub-menu:first").slideToggle(function() {
										$(this).parent().toggleClass("menu-open");
								});
						});
				}

    };

    // A really lightweight plugin wrapper around the constructor,
    // preventing against multiple instantiations
    $.fn[ pluginName ] = function ( options ) {
        this.each(function() {
            if ( !$.data( this, "plugin_" + pluginName ) ) {
                $.data( this, "plugin_" + pluginName, new Plugin( this, options ) );
            }
        });

        // chain jQuery functions
        return this;
    };

})( jQuery, window, document );
