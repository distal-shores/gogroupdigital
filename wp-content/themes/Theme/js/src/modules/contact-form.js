jQuery(window).on('load', function () {
  'use strict';

  var hideContactForm = function () {
    jQuery('.contact-form').removeClass('active');
    jQuery('html, body').removeClass('contact-active');
    // remove #contact from the url
    history.pushState('', document.title, window.location.pathname + window.location.search);
  };

  var showContactForm = function () {
    jQuery('.contact-form').addClass('active');
    jQuery('html, body').addClass('contact-active');
    // If hitting escape key
    jQuery(document).keyup(function (e) {
      if (e.keyCode === 27) {
        hideContactForm();
      }
    });
  };

  var hashMatchesContact = function () {
    return window.location.hash === '#contact';
  };

  window.addEventListener('hashchange', function () {
    if (hashMatchesContact()) {
      showContactForm();
    }
  }, false);

  // If hitting close
  jQuery('.contact-form__form__close').click(function () {
    hideContactForm();
  });

  // Check if the url has `#contact` and show the contact form if it does
  if (hashMatchesContact()) {
    if (window.location.pathname.includes('thank-you')) {
      hideContactForm();
    } else {
      showContactForm();
    }
  }

});