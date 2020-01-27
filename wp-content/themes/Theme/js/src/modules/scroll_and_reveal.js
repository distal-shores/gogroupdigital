jQuery(window).on('load', function () {
	'use strict';

	// Scroll and reveal CTA on home
	window.sr = new ScrollReveal();
	sr.reveal('.cta', { duration: 1000, scale: 1, viewFactor: 0.2 });
	sr.reveal('.blog-tile', { duration: 1000, scale: 1, viewFactor: 0.2 });
	sr.reveal('.data-box', { duration: 1000, scale: 1, viewFactor: 0.2 });
	sr.reveal('.location-tile', { duration: 1000, scale: 1, viewFactor: 0.2 });
	sr.reveal('.member-tile', { duration: 1000, scale: 1, viewFactor: 0.2 });
	sr.reveal('.hero__content *', { duration: 1000, scale: 1 });
});