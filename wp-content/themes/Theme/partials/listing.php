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
			$blog_categories[] = $blog_category->name;
		}
		$blog_categories_list = join( ", ", $blog_categories);
		$blog_category_class = seoUrl($blog_categories[0]);
	endif;

    // Counting
    $position = 'blog-tile--normal';
    if ($count === 0 ) {
    	$position = 'blog-tile--featured';
    }
    if ($count % 7 == 2 ) {
    	$position = 'blog-tile--long';
    }
    if ($count % 7 == 6 ) {
    	$position = 'blog-tile--long';
    }
?>

<li class="blog-tile blog-tile--<?php echo $blog_category_class; ?> <?php echo $position; ?> <?php echo $thumbnail_checker; ?>">
	<?php if ($count === 0 ): ?>
		<a href="<?php the_permalink(); ?>">
			<?php if( $blog_thumbnail ): ?>
			<div class="blog-post__thumbnail" style="background-image: url(<?php echo $blog_thumbnail_featured ?>);">
				<img src="<?php echo $blog_thumbnail_featured; ?>">
			</div>
			<?php endif; ?>
			<div class="blog-tile__content">
				<div class="l-container">
					<p class="blog-tile__content__meta"><?php echo $blog_title; ?><span></span></p>
					<div class="blog-tile__content__details">
						<p class="blog-tile__content__details__title"><?php echo $blog_subtitle; ?></p>
						<p class="blog-tile__content__details__description"><?php echo $blog_content_truncated; ?></p>
					</div>
				</div>
			</div>
		</a>
	<?php elseif ($count % 7 == 2 || $count % 7 == 6 ): ?>
		<a href="<?php the_permalink(); ?>" <?php if( $blog_thumbnail ): ?>style="background-image: url(<?php echo $blog_thumbnail_long ?>);"<?php endif; ?>>
			<span class="blog-tile__content">
				<p class="blog-tile__content__category"><?php echo $blog_categories_list; ?></p>
				<p class="blog-tile__content__subtitle"><?php echo $blog_subtitle; ?></p>
				<p class="blog-tile__content__title"><?php echo $blog_title; ?></p>
			</span>
		</a>
	<?php else: ?>
		<a href="<?php the_permalink(); ?>" <?php if( $blog_thumbnail ): ?>style="background-image: url(<?php echo $blog_thumbnail_small ?>);"<?php endif; ?>>
			<span class="blog-tile__content">
				<p class="blog-tile__content__category"><?php echo $blog_categories_list; ?></p>
				<p class="blog-tile__content__subtitle"><?php echo $blog_subtitle; ?></p>
				<p class="blog-tile__content__title"><?php echo $blog_title; ?></p>
			</span>
		</a>
	<?php endif; ?>
</li>