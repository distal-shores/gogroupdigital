<?php get_header(); ?>

<div class="l-body">

	<h2 class="u-screen-reader">Main content</h2>

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
				<p class="banner__content--first"><?php echo $banner_title; ?></p>
			<?php endif; ?>
			<?php if($banner_subtitle): ?>
				<p class="banner__content--second"><?php echo $banner_subtitle; ?></p>
			<?php endif; ?>
		</span>
	</div>

<!-- About Intro -->
	<div class="about-intro">
		<div class='l-container'>
			<?php if( have_rows('about_intro') ): 
			while( have_rows('about_intro') ): the_row(); 
			$about_intro_title = get_sub_field('about_intro_title');
			$about_intro_subtitle = get_sub_field('about_intro_subtitle'); ?>
				<h1 class="about-intro__title"><?php echo $about_intro_title; ?></h1>
				<h2 class="about-intro__subtitle"><?php echo $about_intro_subtitle; ?></h2>
			<?php endwhile;
			endif; ?>
		</div>
	</div>

<!-- Featured members -->
	<div class="featured-members">
		<div class="l-container">
		<?php $posts = get_field('featured_members');
		if( $posts ): ?>
			<div class="member-tiles">
				<?php foreach($posts as $post): setup_postdata($post); 
					$profile_name = get_the_title();
					$profile_description = get_field('profile_description');
					$profile_description = htmlentities($profile_description, null, 'utf-8');
					$profile_description = str_replace("&nbsp;", " ", $profile_description);
					$profile_description = html_entity_decode($profile_description);
					$profile_industry = get_field('industry');
					$profile_image = get_field('profile_image');
					if($profile_image):
						$profile_image = $profile_image['sizes']['thumbnail'];
					else:
						$profile_image = get_bloginfo('stylesheet_directory').'/images/placeholder-member.jpg';
					endif;
				?>
		        <div class="member-tile">
		        	<img src="<?php echo $profile_image; ?>" class="member-tile__image">
		            <div class="member-tile__bio">
		            	<p class="member-tile__bio__industry"><?php echo $profile_industry; ?></p>
		            	<span class="member-tile__bio__description"><?php echo $profile_description; ?></span>
		            </div>
		        </div>
				<?php endforeach; wp_reset_postdata(); ?>
			</div>
		<?php endif; ?>
		</div>
	</div>

<!-- Partner -->
	<div class="about-location">
		<div class='l-container'>
		<?php if( have_rows('location_intro') ): 
			while( have_rows('location_intro') ): the_row(); 
			$location_title = get_sub_field('location_title');
			$location_content = get_sub_field('location_content'); ?>
				<p class="about-location__title"><?php echo $location_title; ?></p>
				<p class="about-location__content"><?php echo $location_content; ?></p>
			<?php endwhile;
			endif; ?>
			<ul class="locations">
				<?php
					$args = array(
						'post_type' => 'office',
						'posts_per_page' => -1,
						'orderby'=> 'date',
						'order' => 'DESC',
					);
					$loop = new WP_Query( $args );
					if ( $loop->have_posts() ): 
					while ( $loop->have_posts() ) : $loop->the_post();
						include(locate_template('partials/listing-office.php', false, false));
					endwhile;
					endif;
					wp_reset_postdata();
				?>
			</ul>
		</div>
	</div>

<!-- Go Membership -->
<?php if( have_rows('about_content_section') ): 
	while( have_rows('about_content_section') ): the_row(); 
	$title = get_sub_field('title');
	$content = get_sub_field('content'); 
	$leading_image = get_sub_field('leading_image'); ?>
		<div class="about-membership">
			<div class='l-container'>
				<img src="<?php echo $leading_image['url']; ?>" class="about-membership__leading-image">
				<p class="about-membership__title"><?php echo $title; ?></p>
				<p class="about-membership__content"><?php echo $content; ?></p>
				<a href="#contact" class="about-membership__contact contact-button">Get In Touch</a>
			</div>
			<span class="helix helix--four"><img src="<?php echo get_bloginfo('stylesheet_directory').'/images/background-helix_four.png'; ?>"/></span>
		</div>
	<?php endwhile;
	endif; ?>

</div>
<?php get_footer(); ?>
