// Sends social media event tracking to Google Analytics

( function( window, d, s, id ) {

	//* Titter events *//

	// expose twitter object
	window.twttr = ( function( d, s, id ) {
		var t, js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); 
		js.id = id;
		js.src = "https://platform.twitter.com/widgets.js";
		fjs.parentNode.insertBefore(js, fjs);

		return window.twttr || (t = { 
			_e: [], 
			ready: function(f) { 
				t._e.push(f) 
			}
		});
	} (d, s, id ) );

	// Define our custom event handlers
	function clickEventToAnalytics (intentEvent) {
	  	if (!intentEvent) return;
	  	ga('send', 'event', 'Social', 'Click', 'Twitter Follow');
	}

	// Wait for the asynchronous resources to load
	twttr.ready( function ( twttr ) {
	  // bind events
	  twttr.events.bind( 'click', clickEventToAnalytics );
	});

} )( window, document, "script", "twitter-wjs" );