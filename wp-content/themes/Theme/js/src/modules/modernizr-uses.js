jQuery(window).on('load', function() {
'use strict';
	// If srcset is not supported
	if (!Modernizr.srcset) {
		jQuery('.lazyload').each(function() { 
			var fallbackSRC = jQuery(this).attr('fallback-src');
			jQuery(this).attr('src', fallbackSRC);
		});
	}
});