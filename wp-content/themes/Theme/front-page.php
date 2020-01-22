<?php get_header(); ?>

<!-- Hero -->
	<?php if( have_rows('hero') ): 
		while( have_rows('hero') ): the_row(); 
		$hero_title = get_sub_field('hero_title');
		$hero_subtitle = get_sub_field('hero_subtitle');
		$hero_background = get_sub_field('hero_background'); ?>
		<div class="hero hero-home" style="background-image: url(<?php echo $hero_background['sizes']['hero']; ?>);">
			<span class="hero__content">
				<h1><?php echo $hero_title; ?></h1>
				<h2><?php echo $hero_subtitle; ?></h2>
			</span>
			<a href="#begin" class="hero__arrow"></a>
		</div>

		<div class="hero__ghost"></div>
	<?php endwhile;
	endif; ?>

<!-- Banner -->
	<?php if( have_rows('first_banner') ): 
		while( have_rows('first_banner') ): the_row(); 
		$banner_title = get_sub_field('banner_title');
		$banner_subtitle = get_sub_field('banner_subtitle');
		$banner_background = get_sub_field('banner_background'); ?>
		<div class="banner banner--first banner--home" id="begin" style="background-image: url(<?php echo $banner_background['sizes']['banner']; ?>);">
			<span class="banner__content">
				<h1 class="banner__content--first"><?php echo $banner_title; ?></h1>
				<h2 class="banner__content--second"><?php echo $banner_subtitle; ?></h2>
			</span>
		</div>
	<?php endwhile;
	endif; ?>

<!-- Client Section -->
	<?php if( have_rows('client_section') ): 
		while( have_rows('client_section') ): the_row(); 
		$client_intro = get_sub_field('client_intro');
		$client_content = get_sub_field('client_content');
		$client_logos = get_sub_field('client_logos'); ?>	
		<div class="client-home">
			<div class="l-container">
				<span class="client-home__content">
					<p class="client-home__content__intro"><?php echo $client_intro; ?></p>
					<p class="client-home__content__subnote"><?php echo $client_content; ?></p>
				</span>
				<ul class="client-home__logo-farm">
					<?php if( $client_logos ):
	        		foreach( $client_logos as $client_logo ): ?>
						<li class="client-home__logo-farm__logo">
							<img src="<?php echo $client_logo['sizes']['client_logo']; ?>" alt="<?php echo $client_logo['alt']; ?>" />
						</li>
		        	<?php endforeach;
		        	endif; ?>
				</ul>
			</div>
			<span class="helix helix--one"></span>
		</div>
	<?php endwhile;
	endif; ?>

<!-- Banner -->
	<?php if( have_rows('second_banner') ): 
		while( have_rows('second_banner') ): the_row(); 
		$banner_title = get_sub_field('banner_title');
		$banner_content = get_sub_field('banner_content');
		$banner_background = get_sub_field('banner_background'); ?>
		<div class="banner banner--second banner--home" style="background-image: url(<?php echo $banner_background['sizes']['banner']; ?>);">
			<div class="l-container">
				<span class="banner__content">
					<h1 class="banner__content--first"><?php echo $banner_title; ?></h1>
					<h2 class="banner__content--second"><?php echo $banner_content; ?></h2>
				</span>
				<span class="banner__cta">
					<?php  
						$cta_title_1 = get_field('cta_title_1');
						$cta_content_1 = get_field('cta_content_1');
						$cta_text_link_1 = get_field('cta_text_link_1');
						$cta_link_1 = get_field('cta_link_1');
						$cta_title_2 = get_field('cta_title_2');
						$cta_content_2 = get_field('cta_content_2');
						$cta_text_link_2 = get_field('cta_text_link_2');
						$cta_link_2 = get_field('cta_link_2');
					?>
					<div class="cta cta--first">
						<p class="cta__title"><?php echo $cta_title_1; ?></p>
						<p class="cta__content"><?php echo $cta_content_1; ?></p>
						<a class="cta__button" href="<?php echo $cta_link_1; ?>"><?php echo $cta_text_link_1; ?></a>
					</div>
					<div class="cta cta--second">
						<p class="cta__title"><?php echo $cta_title_2; ?></p>
						<p class="cta__content"><?php echo $cta_content_2; ?></p>
						<a class="cta__button" href="<?php echo $cta_link_2; ?>"><?php echo $cta_text_link_2; ?></a>
					</div>
				</span>
			</div>
		</div>
	<?php endwhile;
	endif; ?>

<!-- Statistics -->
	<?php if( have_rows('stat_section') ): 
		while( have_rows('stat_section') ): the_row(); 
		$stat_title = get_sub_field('stat_title');
		$stat_data = get_sub_field('stat_data'); ?>
		<div class="stats-home">
			<div class="l-container">
				<p class="stats-home__title"><?php echo $stat_title; ?></p>
				<div class="stats-home__data">
					<?php echo $stat_data; ?>
				</div>
			</div>
			<span class="helix helix--two"></span>
		</div>
	<?php endwhile;
	endif; ?>

<!-- Blog Posts -->
	<div class="blog blog-home">
		<div class="l-container">
			<p class="blog__title">Evolutionary to Epic by <span class="go go--blue">GO</span></p>
			<p class="blog__description"><?php the_field('evolutionary_to_epic_blurb'); ?></p>
			<ul class="blog-tiles">
				<?php
					$featured_post = get_field('e_to_e_featured_post', 2);
					$featured_post = $featured_post[0];
					$args = array(
						'post_type' => 'blog_post',
					);
					$loop = new WP_Query( $args );
					if ( $loop->have_posts() ): 
					$count = 0;
					include(locate_template('partials/listing-featured.php', false, false));
					$count++;
					endif;
					wp_reset_postdata();
				?>
				<?php
					$user = wp_get_current_user();
					if(!in_array('administrator', $user->roles)) {

						$args = array(
							'post_type' => 'blog_post',
							'posts_per_page' => 3,
							'orderby'=> 'date',
							'order' => 'DESC',
							'post__not_in' => array($featured_post->ID),
							// 'tax_query' => array(
							// 	'relation' => 'OR',
							// 	array(
							// 		'taxonomy' => 'privilege_level',
							// 		'field'    => 'slug',
							// 		'terms'    => $user->roles,
							// 	),
							// 	array(
	            			// 		'taxonomy' => 'privilege_level',
	            			// 		'field'    => 'slug',
	            			// 		'terms'    => array('managing_partner','strategic_partner','associate_partner'),
	            			// 		'operator' => 'NOT IN'
							// 	),
							// ),
						);
						
					} else {

						$args = array(
							'post_type' => 'blog_post',
							'posts_per_page' => 3,
							'orderby'=> 'date',
							'order' => 'DESC',
							'post__not_in' => array($featured_post->ID),
						);

					}

					$loop = new WP_Query( $args );
					if ( $loop->have_posts() ): 
					$count = 0;
					while ( $loop->have_posts() ) : $loop->the_post();
						include(locate_template('partials/listing-index.php', false, false));
						$count++;
					endwhile;
					endif;
					wp_reset_postdata();
				?>
			</ul>
			<a href="<?php // bloginfo('url'); ?>/insights/" class="blog__button">See More</a>
		</div>
		<span class="helix helix--three"></span>
	</div>

<?php get_footer(); ?>