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

		$excludePosts = array(); // posts to exclude from the 'More UnitX Members' area
	?>
	<div class="banner" style="background-image: url(<?php echo $banner_background; ?>);">
		<span class="banner__content">
			<?php if($banner_title): ?>
				<h1 class="banner__content--first"><?php echo $banner_title; ?></h1>
			<?php endif; ?>
			<?php if($banner_subtitle): ?>
				<h2 class="banner__content--second"><?php echo $banner_subtitle; ?></h2>
			<?php endif; ?>
		</span>
	</div>

<!-- Page Anchor Navigation -->
	<div class="page-nav">
		<div class="l-container">
			<a href="#overview" class="page-nav__anchor">Overview</a>
			<a href="#unitx" class="page-nav__anchor">UnitX</a>
			<a href="#partner" class="page-nav__anchor">Partner</a>
		</div>
	</div>

<!-- Service Intro -->
	<div class="service-intro" id="overview">
		<div class='l-container'>
			<?php if( have_rows('service_intro') ): 
			while( have_rows('service_intro') ): the_row(); 
			$service_intro_title = get_sub_field('service_intro_title');
			$service_intro_subtitle = get_sub_field('service_intro_subtitle'); ?>
				<h1 class="service-intro__title"><?php echo $service_intro_title; ?></h1>
				<h2 class="service-intro__subtitle"><?php echo $service_intro_subtitle; ?></h2>
			<?php endwhile;
			endif; ?>
			<?php if( have_rows('service_intro_data_boxes') ): 
			while( have_rows('service_intro_data_boxes') ): the_row(); 
			$data_box_title = get_sub_field('data_box_title');
			$data_box_subtitle = get_sub_field('data_box_subtitle'); 
			$data_box_content = get_sub_field('data_box_content'); ?>
				<div class="data-box">
					<div class="data-box__data">
						<p class="data-box__subtitle"><?php echo $data_box_subtitle; ?></p>
						<p class="data-box__title"><?php echo $data_box_title; ?></p>
						<span class="data-box__content">
							<?php echo $data_box_content; ?>
						</span>
					</div>
				</div>
			<?php endwhile;
			endif; ?>
		</div>
		<span class="helix helix--six"><img src="<?php echo get_bloginfo('stylesheet_directory').'/images/background-helix_six.png'; ?>"/></span>
	</div>

<!-- Go UnitX -->
<?php if( have_rows('service_content_section') ): 
	while( have_rows('service_content_section') ): the_row(); 
	$title = get_sub_field('title');
	$content = get_sub_field('content'); 
	$leading_image = get_sub_field('leading_image'); ?>
		<div class="service-unitx" id="unitx">
			<div class='l-container'>
				<img src="<?php echo $leading_image['url']; ?>" class="service-unitx__leading-image">
				<p class="service-unitx__title"><?php echo $title; ?></p>
				<p class="service-unitx__content"><?php echo $content; ?></p>
			</div>
		</div>
	<?php endwhile;
	endif; ?>

<!-- Featured members -->
	<div class="featured-members">
		<div class="l-container">
		<?php $posts = get_field('featured_unitx_members');
		if( $posts ): ?>
			<p class="featured-members__title">Assemble a UnitX based on your <u>industry.</u></p>
			<div class="member-tiles">
				<?php foreach($posts as $post): setup_postdata($post); 
					$profile_name = get_the_title();
					$profile_description = get_field('profile_description');
					$profile_description = htmlentities($profile_description, null, 'utf-8');
					$profile_description = str_replace("&nbsp;", " ", $profile_description);
					$profile_description = html_entity_decode($profile_description);
					$profile_industry = get_field('industry');
					$profile_image = get_field('profile_image');
					$excludePosts[] = $post->ID;
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
				<?php 
			endforeach; wp_reset_postdata(); 
			?>
			</div>
		<?php endif; ?>

		<?php $posts = get_field('featured_unitx_members_2');
		if( $posts ): ?>
			<p class="featured-members__title">Create a UnitX team based on <u>expertise.</u></p>
			<div class="member-tiles">
				<?php foreach($posts as $post): setup_postdata($post); 
					$profile_name = get_the_title();
					$profile_description = get_field('profile_description');
					$profile_description = htmlentities($profile_description, null, 'utf-8');
					$profile_description = str_replace("&nbsp;", " ", $profile_description);
					$profile_description = html_entity_decode($profile_description);
					$profile_industry = get_field('industry');
					$profile_image = get_field('profile_image');
					$excludePosts[] = $post->ID;
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

			<p class="featured-members__title">More UnitX experts.</p>
			<div class="member-tiles">
				<?php
					$args = array(
						'post_type' => 'member',
						'posts_per_page' => 3,
						'post__not_in' => $excludePosts,
						'orderby'   => 'rand',
						'tax_query' => array(
							array(
								'taxonomy' => 'member_specialization',
								'field'    => 'slug',
								'terms'    => 'unitx',
							),
						),
					);
					$loop = new WP_Query( $args );

				while ( $loop->have_posts() ) : $loop->the_post();
				
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
				<?php endwhile; wp_reset_postdata(); ?>
			</div>
		</div>
	</div>

<!-- Partner -->
	<div class="service-location" id="partner">
		<div class='l-container'>
		<?php if( have_rows('location_intro') ): 
			while( have_rows('location_intro') ): the_row(); 
			$location_title = get_sub_field('location_title');
			$location_content = get_sub_field('location_content'); ?>
				<p class="service-location__title"><?php echo $location_title; ?></p>
				<p class="service-location__content"><?php echo $location_content; ?></p>
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

		<p class="service-location__outro">More GO partner-offices in key markets worldwide.</p>
	</div>

</div>
<?php get_footer(); ?>
