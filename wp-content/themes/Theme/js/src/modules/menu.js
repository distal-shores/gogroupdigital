jQuery(window).on('load', function() {
	'use strict';

	jQuery('.header__nav-button').click(function() {
		jQuery('.header__menu').addClass('active');
		// If hitting escape key
		jQuery(document).keyup(function(e) {
			if (e.keyCode === 27) { 
				jQuery('.header__menu').removeClass('active');
			}
		});
	});

	// If hitting close
	jQuery('.header__menu__close').click(function() {
		jQuery('.header__menu').removeClass('active');
	});
});