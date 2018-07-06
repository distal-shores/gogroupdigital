<?php get_header(); ?>

<div class="l-body blog-post">

	<?php
	if ( have_posts() ) :
	while ( have_posts() ) : the_post(); ?>

	<?php 
		$featured_image = get_field('featured_image'); 
		$subtitle = get_field('subtitle'); 
		$content = get_field('content'); 
	?>


		<?php if($featured_image): ?>
			<div class="blog-post__image">
				<img src="<?php echo $featured_image['sizes']['blog_large']; ?>" />
			</div>
		<?php endif; ?>
		
		<div class="blog-post__header">
			<h1 class="blog-post__header__title"><?php the_title(); ?></h1>
			<p class="blog-post__header__categories">
				<?php foreach((get_the_category()) as $category) { 
					echo $category->cat_name . ' '; 
				}  ?>
			</p>
			<p class="blog-post__header__date">
				<?php $post_date = get_the_date( 'F j, Y' ); echo $post_date; ?>
			</p>
		</div>

		<div class="page-content">
			<div class="l-container blog-content">
				<?php if($subtitle): ?>
					<h2 class="blog-post__subtitle">
						<?php echo $subtitle; ?>
					</h2>
				<?php endif; ?>

				<?php the_content(); ?>

				<?php if( get_field('content') ): ?>
					<?php echo filter_ptags_on_images_acf($content); ?>
				<?php endif; ?>
			</div>
		</div>

		<div class="blog-post__footer">
			<p class="blog-post__footer__date">Posted on <?php $post_date = get_the_date( 'F j, Y' ); echo $post_date; ?></p>
			<p class="blog-post__footer__categories"> Posted under <?php foreach((get_the_category()) as $category) { echo $category->cat_name . ' '; }  ?></p>
			<div class="blog-post__footer__share">
				<?php echo do_shortcode('[DISPLAY_ULTIMATE_SOCIAL_ICONS]'); ?>
			</div>
		</div>

		<div class="l-container post-nav">
			<?php
			$prev_post = get_previous_post();
			setup_postdata($prev_post);
				if($prev_post) {
				   $prev_title = strip_tags(str_replace('"', '', $prev_post->post_title));
				   echo '<a rel="prev" href="' . get_permalink($prev_post->ID) . '" title="' . $prev_title. '" class="post-nav__prev"><span class="post-nav__wrapper"><p>Previous Article</p></span></a>';
				}
			wp_reset_postdata();

			$next_post = get_next_post();
			setup_postdata($next_post);
				if($next_post) {
				   $next_title = strip_tags(str_replace('"', '', $next_post->post_title));
				   echo '<a rel="next" href="' . get_permalink($next_post->ID) . '" title="' . $next_title. '" class="post-nav__next"><span class="post-nav__wrapper"><p>Next Article</p></span></a>';
				}
			wp_reset_postdata();
			?>
		</div>

	<?php endwhile;
	endif;
	?>

</div>

<?php get_footer(); ?>
