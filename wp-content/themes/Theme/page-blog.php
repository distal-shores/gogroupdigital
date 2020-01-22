<?php get_header(); ?>

<?php 
	// Banner Content
	$banner_title = get_field('featured_hero_title');
	$banner_subtitle = get_field('featured_hero_subtitle');
	if(!$banner_title):
		$banner_title = get_the_title();
	endif;

	// Banner Background
	$banner_background = get_field('featured_hero'); 
	if($banner_background):
		$banner_background = $banner_background['sizes']['banner'];
	else:
		$banner_background = get_bloginfo('stylesheet_directory').'/images/banner-services.jpg';
	endif;
?>

<div class="banner" style="background-image: url(<?php echo $banner_background; ?>);">
	<span class="banner__content">
		<?php if($banner_title): ?>
			<h1 class="banner__content--first"><?php echo $banner_title; ?><span class="go go--white"></span></h1>
		<?php endif; ?>
		<?php if($banner_subtitle): ?>
			<h2 class="banner__content--second"><?php echo $banner_subtitle; ?></h2>
		<?php endif; ?>
	</span>
</div>

<div class="blog">
	<div class="l-container">
		<ul class="blog-tiles">
			<?php
				$args = array(
					'post_type' => 'blog_post',
					'posts_per_page' => -1,
					'orderby'=> 'date',
					'order' => 'DESC',
				);
				$loop = new WP_Query( $args );
				if ( $loop->have_posts() ): 
				$count = 0;
				while ( $loop->have_posts() ) : $loop->the_post();
					include(locate_template('partials/listing.php', false, false));
					$count++;
				endwhile;
				endif;
				wp_reset_postdata();
			?>
		</ul>
	</div>
	<span class="helix helix--five"><img src="<?php echo get_bloginfo('stylesheet_directory').'/images/background-helix_five.png'; ?>"/></span>
</div>

<?php get_footer(); ?>