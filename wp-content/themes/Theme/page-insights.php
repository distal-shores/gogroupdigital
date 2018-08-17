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

	$user = wp_get_current_user();
?>

<div class="banner" style="background-image: url(<?php echo $banner_background; ?>);">
	<span class="banner__content">
		<?php if($banner_title): ?>
			<p class="banner__content--first"><?php echo $banner_title; ?><span class="go go--white"></span></p>
		<?php endif; ?>
		<?php if($banner_subtitle): ?>
			<p class="banner__content--second"><?php echo $banner_subtitle; ?></p>
		<?php endif; ?>
	</span>
</div>

<div class="blog">
	<div class="l-container">
		<ul class="blog-tiles">
			<?php
				$featured_post = get_field('e_to_e_featured_post', 2);
				$featured_post = $featured_post[0];
				if(!in_array('administrator', $user->roles)) {

					$args = array(
						'post_type' => 'blog_post',
						'posts_per_page' => 6,
						'orderby'=> 'date',
						'order' => 'DESC',
						'post__not_in' => array($featured_post->ID),
						'tax_query' => array(
							'relation' => 'OR',
							array(
								'taxonomy' => 'privilege_level',
								'field'    => 'slug',
								'terms'    => $user->roles,
							),
							array(
            					'taxonomy' => 'privilege_level',
            					'field'    => 'slug',
            					'terms'    => array('managing_partner','strategic_partner','associate_partner'),
            					'operator' => 'NOT IN'
							),
						),
					);
					
				} else {

					$args = array(
						'post_type' => 'blog_post',
						'posts_per_page' => 6,
						'post__not_in' => array($featured_post->ID),
						'orderby'=> 'date',
						'order' => 'DESC',
					);

				}
				$loop = new WP_Query( $args );
				if ( $loop->have_posts() ): 
				$count = -1;
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