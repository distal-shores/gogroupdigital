(function($) {

    // Use $() inside of this function
    $('.blog-categories-select-wrapper .select-items').on('DOMSubtreeModified', function() {
        var selectVal = $(this).children(".same-as-selected").text().toLowerCase();
        console.log(selectVal);
        var queryVars = {
            "post_type": "blog_post",
            "orderby": "date",
            "order": "DESC",
            "posts_per_page": 3,
            "tax_query": [{
                "taxonomy": "category",
                "field": "slug",
                "terms": selectVal
            }]
        };
        queryVars = JSON.stringify(queryVars);
        $.ajax({
            url: ajaxfetch.ajaxurl,
            type: 'post',
            data: {
                action: 'ajax_fetch',
                query_vars: queryVars,
            },
            success: function( html) {
                $('#more-go-content').empty();
                $('#more-go-content').append(html);
            },
            error: function (response ) {
                console.log(response);
            }
        })
    });
})(jQuery);