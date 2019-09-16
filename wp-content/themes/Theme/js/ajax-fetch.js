(function($) {

    // Use $() inside of this function
    $('.blog-categories-select-wrapper .select-items').on('DOMSubtreeModified', function(e) {
        if(e.target.className === 'same-as-selected') {
            var selectVal = $(this).children(".same-as-selected").text().toLowerCase();
            var acceptableInputs = ['digital', 'epic outcomes', 'groupx', 'knowledge exchange', 'news', 'operations', 'posits', 'vantages'];
            var taxQuery = false;
            var queryVars = new Object();
            for(x = 0; x < acceptableInputs.length; x++) {
                if(selectVal === acceptableInputs[x]) {
                    taxQuery = true;
                    break;
                }
            }
            if(taxQuery === true) {
                queryVars = {
                    "post_type": "blog_post",
                    "post_status": "publish",
                    "orderby": "date",
                    "order": "DESC",
                    "posts_per_page": 3,
                    "tax_query": [{
                        "taxonomy": "category",
                        "field": "slug",
                        "terms": selectVal
                    }]
                };
            } else {
                queryVars = {
                    "post_type": "blog_post",
                    "post_status": "publish",
                    "orderby": "date",
                    "order": "DESC",
                    "posts_per_page": 3,
                };
            }
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
        }
    });

})(jQuery);