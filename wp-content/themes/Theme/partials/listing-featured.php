<?php 
	$blog_title = get_the_title();
	$blog_subtitle = get_field('subtitle');
	$blog_thumbnail = get_field('featured_image');
		$blog_thumbnail_featured = $blog_thumbnail['sizes']['blog_large'];
		$blog_thumbnail_long = $blog_thumbnail['sizes']['blog_medium'];
		$blog_thumbnail_small = $blog_thumbnail['sizes']['blog_small'];
		if( $blog_thumbnail ):
			$thumbnail_checker = 'has-thumbnail';
		else:
			$thumbnail_checker = 'no-thumbnail';
		endif;
	// $blog_content = get_field('content');

	// Get Categories
	$blog_categories_array = get_the_terms( get_the_ID(), 'category' );
	$blog_category_class = 'blog-post--no-category';
	if ( $blog_categories_array && ! is_wp_error( $blog_categories_array )): 
		$blog_categories = array();
		foreach ( $blog_categories_array as $blog_category ) {
			$blog_categories[] = $blog_category->name;
		}
		$blog_categories_list = join( ", ", $blog_categories);
		$blog_category_class = seoUrl($blog_categories[0]);
	endif;

	$featured_post_blog_content_truncated = wp_trim_words( get_field('content', $featured_post), $num_words = 25, $more = '...' ); 
	$featured_post_category = get_the_category($featured_post->ID)[0]->slug;

?>

<li class="blog-tile blog-tile--<?php echo $featured_post_category; ?> blog-tile--featured has-thumbnail" style="background-image: url(<?php echo get_field('featured_image', $featured_post)['sizes']['blog_large'] ?>);">
	<div class="blog-tile--featured--overlay"></div>
    <a href="<?php echo get_permalink($featured_post, false); ?>">
        <div class="blog-tile__content">
			<span class="blog-tile__content__featured-flag"></span>
            <h2 class="blog-tile__content__title"><?php echo $featured_post->post_title ?></h2>
        </div>
    </a>
</li>