(function($) {
    var globalSelect = '';
    var acceptableInputs = ['digital', 'epic outcomes', 'groupx', 'business development', 'knowledge exchange', 'news', 'operations', 'posits', 'vantages'];
    var queryVars = new Object();
    var taxQuery = false;
    var postsNotIn = [];
    $('#more-go-content .blog-tile').each(function( index ) {
        postsNotIn.push($( this ).attr('data-post-id'));
    })

    // Use $() inside of this function
    $('.blog-categories-select-wrapper .select-items').on('DOMSubtreeModified', function(e) {
        if(e.target.className === 'same-as-selected') {
            postsNotIn = [];
            taxQuery = false;
            var selectVal = $(this).children(".same-as-selected").text().toLowerCase();
            globalSelect = selectVal;
            $('.blog__view-more').removeClass('disabled');
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
                    $('#more-go-content .blog-tile').each(function( index ) {
                        postsNotIn.push($( this ).attr('data-post-id'));
                    });
                },
                error: function (response ) {
                    console.log(response);
                }
            });     
        }
    });

    $('.blog__view-more').on('click', function(e) {
        e.preventDefault();
        if(taxQuery === true) {
            queryVars = {
                "post_type": "blog_post",
                "post_status": "publish",
                "orderby": "date",
                "order": "DESC",
                "posts_per_page": 3,
                "post__not_in": postsNotIn,
                "tax_query": [{
                    "taxonomy": "category",
                    "field": "slug",
                    "terms": globalSelect
                }]
            };
        } else {
            queryVars = {
                "post_type": "blog_post",
                "post_status": "publish",
                "orderby": "date",
                "order": "DESC",
                "posts_per_page": 3,
                "post__not_in": postsNotIn
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
            success: function( html, status) {
                if(html != '') {
                    $('#more-go-content').append(html);
                    $('#more-go-content .blog-tile').each(function( index ) {
                        postsNotIn.push($( this ).attr('data-post-id'));
                    });
                } else {
                    $('.blog__view-more').addClass('disabled');
                }
            },
            error: function (response ) {
                console.log(response);
            }
        });  
    });

})(jQuery);