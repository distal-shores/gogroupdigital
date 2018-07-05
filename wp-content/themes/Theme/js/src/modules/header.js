jQuery(window).on('load', function() {
	'use strict';

	jQuery(document).scroll(function() {
		if (jQuery(document).scrollTop() >= 592) {
			jQuery('.header').addClass('active');
			jQuery('.page-nav').addClass('active');
		} else {
			jQuery('.header').removeClass('active');
			jQuery('.page-nav').removeClass('active');
		}
	});

});