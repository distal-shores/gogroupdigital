jQuery(window).on('load', function () {
	'use strict';

	const hideContactForm = function () {
		jQuery('.contact-form').removeClass('active');
		jQuery('html, body').removeClass('contact-active');
		// remove #contact from the url
		history.pushState('', document.title, window.location.pathname + window.location.search);
	};

	const showContactForm = function () {
		jQuery('.contact-form').addClass('active');
		jQuery('html, body').addClass('contact-active');
		// If hitting escape key
		jQuery(document).keyup(function (e) {
			if (e.keyCode === 27) {
				hideContactForm();
			}
		});
	};

	// Check if the url has `#contact` and show the contact form if it does
	const currentUrlFragment = window.location.hash;
	if (currentUrlFragment === '#contact') {
		if (window.location.pathname.includes('thank-you')) {
			hideContactForm();
		} else {
			showContactForm();
		}
	}

	jQuery('.contact-button, .primary-nav__item--contact, .footer-nav__item--contact').click(function () {
		showContactForm();
	});

	// If hitting close
	jQuery('.contact-form__form__close').click(function () {
		hideContactForm();
	});
});