jQuery(window).on('load', function() {
	'use strict';

	jQuery('.contact-button, .primary-nav__item--contact, .footer-nav__item--contact').click(function() {
		jQuery('.contact-form').addClass('active');
		jQuery('html, body').addClass('contact-active');
		// If hitting escape key
		jQuery(document).keyup(function(e) {
			if (e.keyCode === 27) { 
				jQuery('.contact-form').removeClass('active');
				jQuery('html, body').removeClass('contact-active');
			}
		});
	});

	// If hitting close
	jQuery('.contact-form__form__close').click(function() {
		jQuery('.contact-form').removeClass('active');
		jQuery('html, body').removeClass('contact-active');
	});
});