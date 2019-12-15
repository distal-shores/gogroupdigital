(function ($) {
	$(document).ready(function () {
		if ($('.easy-footnotes-wrapper').length > 0) {
			$('.blog-post__footnotes').append('<h3>Sources</h3>');
			$('.easy-footnotes-wrapper').clone().appendTo('.blog-post__footnotes');
			$('.easy-footnotes-wrapper')[0].remove();
		}
	});
})(jQuery);