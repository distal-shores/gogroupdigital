(function ($) {
    var globalSelect = '';
    var acceptableInputs = ['digital', 'epic outcomes', 'groupx', 'business development', 'knowledge exchange', 'news', 'operations', 'posits', 'vantages'];
    var queryVars = new Object();
    var taxQuery = false;
    var postsNotIn = [];

    /* A function that will close all select boxes in the document, except the current select box: */
    function closeAllSelect(elmnt) {
        var x, y, i, arrNo = [];
        x = document.getElementsByClassName("select-items");
        y = document.getElementById("select-selected");
        for (i = 0; i < y.length; i++) {
            if (elmnt == y[i]) {
                arrNo.push(i)
            } else {
                y[i].classList.remove("select-arrow-active");
            }
        }
        for (i = 0; i < x.length; i++) {
            if (arrNo.indexOf(i)) {
                x[i].classList.add("select-hide");
            }
        }
    }

    /* update the original select box, and the selected item: */
    function updateSelection(selection) {
        const selectionToLower = selection.toLowerCase();
        const originalSelectElement = document.getElementById('blog-categories-select');
        const selectedItem = document.getElementById('select-selected');

        // iterate through selection options
        for (let i = 0; i < originalSelectElement.length; i++) {
            const option = originalSelectElement.options[i].innerText.toLowerCase();
            // if we found a matching option set that as the selected object
            if (option == selectionToLower) {
                originalSelectElement.selectedIndex = i;
                selectedItem.innerHTML = selection;

                document.querySelectorAll('#blog-categories-select-wrapper .select-items div').forEach(function (el) {
                    const innerText = el.innerText.toLowerCase();
                    if (innerText == selectionToLower) {
                        el.setAttribute('class', 'same-as-selected');
                    } else {
                        el.removeAttribute('class');
                    }
                });

                break;
            }
        }

        closeAllSelect();
    }

    function onOptionItemClick(el) {
        updateSelection(el.target.innerText);
    }

    function setupUi() {
        const selectWrapperElement = document.getElementById("blog-categories-select-wrapper");
        const originalSelectElement = document.getElementById('blog-categories-select');
        /* Create a new DIV that will act as the selected item: */
        const selectedItemElement = document.createElement("DIV");
        selectedItemElement.id = 'select-selected';
        selectedItemElement.innerHTML = originalSelectElement.options[originalSelectElement.selectedIndex].innerHTML;
        selectWrapperElement.appendChild(selectedItemElement);
        /* Create a new DIV that will contain the option list: */
        const optionsListElement = document.createElement("DIV");
        optionsListElement.setAttribute("class", "select-items select-hide");
        for (let i = 0; i < originalSelectElement.length; i++) {
            /* For each option in the original select element, create a new DIV that will act as an option item: */
            const optionElement = document.createElement("DIV");
            optionElement.innerHTML = originalSelectElement.options[i].innerHTML;
            /* When an item is clicked, update the original select box, and the selected item: */
            optionElement.addEventListener('click', onOptionItemClick, true);
            optionsListElement.appendChild(optionElement);
        }
        selectWrapperElement.appendChild(optionsListElement);
        selectedItemElement.addEventListener("click", function (e) {
            /* When the select box is clicked, close any other select boxes, and open/close the current select box: */
            e.stopPropagation();
            closeAllSelect(this);
            this.nextSibling.classList.toggle("select-hide");
            this.classList.toggle("select-arrow-active");
        });

        /* If the user clicks anywhere outside the select box, then close all select boxes: */
        document.addEventListener("click", closeAllSelect);
    }

    $(document).ready(function () {
        setupUi();

        $('#more-go-content .blog-tile').each(function (index) {
            postsNotIn.push($(this).attr('data-post-id'));
        })

        // save the bottom of the recent articles list so we can scroll to it when selecting a new category
        const recentArticlesList = $('#recent-articles-list');
        const scroll = recentArticlesList.offset().top + recentArticlesList.height();

        function onBlogTileCategoryClick(el) {
            const category = el.target.innerText;
            updateSelection(category);
        }

        const attachCategoryClickListeners = function () {
            document.querySelectorAll('.blog .blog-tile__category span').forEach(function (el) {
                el.removeEventListener('click', onBlogTileCategoryClick, false);
                el.addEventListener('click', onBlogTileCategoryClick, false);
            });
        };

        const doSearch = function (loadingMore) {
            if (taxQuery === true) {
                queryVars = {
                    "post_type": "blog_post",
                    "post_status": "publish",
                    "orderby": "date",
                    "order": "DESC",
                    "posts_per_page": 3,
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
                };
            }
            if (loadingMore) {
                queryVars['post__not_in'] = postsNotIn;
            }
            queryVars = JSON.stringify(queryVars);
            $.ajax({
                url: ajaxfetch.ajaxurl,
                type: 'post',
                data: {
                    action: 'ajax_fetch',
                    query_vars: queryVars,
                },
                success: function (html, status) {
                    if (html != '') {
                        if (!loadingMore) {
                            $('#more-go-content').empty();
                        }
                        $('#more-go-content').append(html);
                        $('#more-go-content .blog-tile').each(function (index) {
                            postsNotIn.push($(this).attr('data-post-id'));
                        });
                        attachCategoryClickListeners();
                    } else {
                        $('.blog__view-more').addClass('disabled');
                    }
                },
                error: function (response) {
                    console.error(response);
                }
            });
        }

        const doTheFilter = function (category) {
            $('html, body').animate({ scrollTop: scroll });
            const newCategory = category.toLowerCase();
            if (globalSelect != newCategory) {
                globalSelect = newCategory;
                $('.blog__view-more').removeClass('disabled');
                for (x = 0; x < acceptableInputs.length; x++) {
                    if (globalSelect === acceptableInputs[x]) {
                        taxQuery = true;
                        break;
                    }
                }
                doSearch(false);
            }
        };

        // Use $() inside of this function
        $('#blog-categories-select-wrapper .select-items').on('DOMSubtreeModified', function (e) {
            if (e.target.className === 'same-as-selected') {
                postsNotIn = [];
                taxQuery = false;
                var selectVal = $(this).children(".same-as-selected").text().toLowerCase();
                doTheFilter(selectVal);
            }
        });

        $('.blog__view-more').on('click', function (e) {
            e.preventDefault();
            doSearch(true);
        });

        attachCategoryClickListeners();
    });
})(jQuery);