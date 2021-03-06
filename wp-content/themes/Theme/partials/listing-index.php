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
	$blog_content = get_field('content');
	$blog_content_truncated = wp_trim_words( $blog_content, $num_words = 25, $more = '...' ); 

	// Get Categories
	$blog_categories_array = get_the_terms( get_the_ID(), 'category' );
	$blog_category_class = 'blog-post--no-category';
	if ( $blog_categories_array && ! is_wp_error( $blog_categories_array )): 
		$blog_categories = array();
		foreach ( $blog_categories_array as $blog_category ) {
			$blog_categories[] = '<span>' . $blog_category->name . '</span>';
		}
		$blog_categories_list = join( ", ", $blog_categories);
		$blog_category_class = seoUrl($blog_categories[0]);
	endif;

?>

<li data-post-id="<?php echo the_ID(); ?>" class="blog-tile blog-tile--index blog-tile--<?php echo $blog_category_class; ?>">
	<div class="blog-tile__thumbnail" style="background-image: url(<?php echo $blog_thumbnail['sizes']['blog_small'];?>);">
		<a href="<?php the_permalink(); ?>"></a>
	</div>
		<div class="blog-tile__content-container">
			<div class="blog-tile__category"><?php echo $blog_categories_list; ?></div>
			<a href="<?php the_permalink(); ?>"><h2 class="blog-tile__content__title"><?php echo $blog_title; ?></h2></a>
			<a class="blog-tile__content__read-more" href="<?php the_permalink(); ?>">Read More</a>
		</div>

</li>