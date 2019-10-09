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
	$featured_post_blog_content_truncated = wp_trim_words( get_field('content', $featured_post), $num_words = 25, $more = '...' ); 

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

    // Counting
    $position = 'blog-tile--normal';
    if ($count === 0 || $count % 7 == 2  || $count % 7 == 4 ) {
    	$position = 'blog-tile--long';
    }

	$featured_post_blog_content_truncated = wp_trim_words( get_field('content', $featured_post), $num_words = 25, $more = '...' ); 
	$featured_post_category = get_the_category($featured_post->ID)[0]->slug;

?>


<?php if($count === 0 && $featured_post != NULL) : ?>
	<li class="blog-tile blog-tile--<?php echo $featured_post_category; ?> blog-tile--featured has-thumbnail">
		<a href="<?php echo get_permalink($featured_post, false); ?>">
			<div class="blog-post__thumbnail" style="background-image: url(<?php echo get_field('featured_image', $featured_post)['sizes']['blog_large'] ?>);">
				<img src="<?php echo get_field('featured_image', $featured_post)['sizes']['blog_large'] ?>">
			</div>
			<div class="overlay"></div>
			<div class="blog-tile__content">
				<span class="blog-tile__content__featured-flag"></span>
				<div class="l-container">
					<p class="blog-tile__content__meta"><?php echo $featured_post->post_title ?><span></span></p>
					<div class="blog-tile__content__details">
						<p class="blog-tile__content__details__title"><?php echo get_field('subtitle', $featured_post); ?></p>
						<p class="blog-tile__content__details__description"><?php echo $featured_post_blog_content_truncated; ?></p>
					</div>
				</div>
			</div>
		</a>

	</li>
<?php endif; ?>


<li class="blog-tile blog-tile--<?php echo $blog_category_class; ?> <?php echo $position; ?> <?php echo $thumbnail_checker; ?>">
	<div class="overlay"></div>
	<?php if ($count === 0 || $count % 7 == 2 || $count % 7 == 4 ): ?>
		<a href="<?php the_permalink(); ?>" <?php if( $blog_thumbnail ): ?>style="background-image: url(<?php echo $blog_thumbnail_long ?>);"<?php endif; ?>>
			<span class="blog-tile__content">
				<p class="blog-tile__content__category"><?php echo $blog_categories_list; ?></p>
				<p class="blog-tile__content__title"><?php echo $blog_title; ?></p>
				<p class="blog-tile__content__subtitle"><?php echo $blog_subtitle; ?></p>
			</span>
		</a>
	<?php else: ?>
		<a href="<?php the_permalink(); ?>" <?php if( $blog_thumbnail ): ?>style="background-image: url(<?php echo $blog_thumbnail_small ?>);"<?php endif; ?>>
			<span class="blog-tile__content">
				<p class="blog-tile__content__category"><?php echo $blog_categories_list; ?></p>
				<p class="blog-tile__content__title"><?php echo $blog_title; ?></p>
				<p class="blog-tile__content__subtitle"><?php echo $blog_subtitle; ?></p>
			</span>
		</a>
	<?php endif; ?>
</li>