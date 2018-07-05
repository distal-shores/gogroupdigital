jQuery(window).on('load', function() {
	'use strict';

	// On load, scroll to section if hash exists in URL
	if(window.location.hash) {
      	var anchor = window.location.hash.substr(1);
      	if(jQuery('#' + anchor).length) {
	        jQuery('html,body').animate({
	        	scrollTop: jQuery('#'+anchor).offset().top - 71
	        }, 1250, function(){
	          jQuery('html,body').off('scroll mousedown wheel DOMMouseScroll mousewheel keyup touchmove');
	        });
    	}
    }

    // Scroll to section on hashtag links
	jQuery('a[href*="#"]')
	.not('[href="#"]')
	.not('[href="#0"]')
	.click(function(event) {
    	if ( location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') && location.hostname === this.hostname) {
			var target = jQuery(this.hash);
			target = target.length ? target : jQuery('[name=' + this.hash.slice(1) + ']');
			if (target.length) {
				event.preventDefault();
				jQuery('html, body').animate({
					scrollTop: target.offset().top - 71
				}, 1200, function() {
					jQuery('html, body').on('scroll mousedown wheel DOMMouseScroll mousewheel keyup touchmove', function(){
						jQuery('html, body').stop();
					});
				});
			}
		}
	});

	// Add class to nav if scrolling to section
	function onScroll(event){
	    var scrollPos = jQuery(document).scrollTop();
	    jQuery('.page-nav__anchor').each(function () {
	        var currLink = jQuery(this);
	        var refElement = jQuery(currLink.attr('href'));
	        if (refElement.position().top <= scrollPos + 150 && refElement.position().top + refElement.height() > scrollPos - 71) {
	            jQuery('.page-nav__anchor').removeClass('active');
	            currLink.addClass('active');
	        }
	        else {
	            currLink.removeClass('active');
	        }
	    });
	}
	jQuery(document).on('scroll', onScroll);
});