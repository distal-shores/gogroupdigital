<?php get_header('blog'); ?>

<div class="l-body blog-post">

	<?php
	if ( have_posts() ) :
	while ( have_posts() ) : the_post(); ?>

	<?php 
		$featured_image = get_field('featured_image'); 
		$subtitle = get_field('subtitle'); 
		$content = get_the_content();
		$authors = get_field('authors');
		$go_content = get_field('go_content_switch');
		$user = wp_get_current_user();
		$privilege_level = wp_get_post_terms(get_the_ID(), 'privilege_level');
		$privilege_levels = array();
		foreach($privilege_level as $level) {
			$privilege_levels[] = $level->slug;
		}
	?>

	<?php if($featured_image): ?>
		<div class="blog-post__image" style="background-image:url(<?php echo $featured_image['sizes']['blog_large']; ?>)">
			<div class="overlay"></div>
			<div class="blog-post__header">
				<p class="blog-post__header__date">
					<?php $post_date = get_the_date( 'F j, Y' ); echo $post_date; ?>
				</p>
				<h1 class="blog-post__header__title"><?php the_title(); ?></h1>
				<hr class="blog-post__header__hr__short-blue" />
				<p class="blog-post__header__byline">
					By <?php foreach( $authors as $a ): ?>
						<span class="blog-post__header__byline__name"><?= get_the_title($a->ID) ?></span>
					<?php endforeach; ?>
				</p>
			</div> 
		</div>
	<?php endif; ?>
	

	<div class="page-content">
		<div class="l-container blog-content">
			<ul class="blog-post__blog-content__categories">
				<li><?php foreach((get_the_category()) as $category) { 
					echo $category->cat_name . ' '; 
				}  ?></li>
			</ul>
			<?php if($subtitle): ?>
				<h3 class="blog-post__subtitle">
					<?php echo $subtitle; ?>
				</h3>
			<?php endif; ?>

			<?php
				if ( in_array_any($privilege_levels, (array) $user->roles) || empty($privilege_levels) || in_array('administrator', $user->roles)) {
					the_content();
				} else {
					echo '<p style="text-align:left">This content is reserved for GO Partners. Please contact <a href="mailto:info@gogroupdigital.com">info@gogroupdigital.com</a> to learn about exclusive access.
					</p>'; 
				}
			?>
			<?php if($authors): ?>
				<h3 class="blog-post__authors__header">Contributing Author(s)</h3>
				<ul class="blog-post__authors">
					<?php foreach( $authors as $a ): ?>
						<li>
							<img class="blog-post__authors__headshot" src="<?= get_field('profile_image', $a->ID)["url"]; ?>">
							<div class="blog-post__authors__details">
								<span class="blog-post__authors__details__name"><?= get_the_title($a->ID) ?></span>
								<span class="blog-post__authors__details__title"><?= get_field('title', $a->ID); ?></span>
							</div>
						</li>
					<?php endforeach; ?>
				</ul> <!-- /.blog-post__author -->
			<?php endif ?>
			<div class="blog-post__contact">
				<h3>Got Questions?</h3>
				<a href="">Reach Out to Us</a>
			</div>
			<div class="blog-post__about">
				<?php echo get_field('blog_post_about_go', 2); ?>
			</div>
			<div class="blog-post__footnotes">
				<h3>Sources</h3>
			</div>
		</div>
	</div>

		<!-- <div class="l-container post-nav"> -->
			<?php
			// $prev_post = get_previous_post();
			// setup_postdata($prev_post);
			// 	if($prev_post) {
			// 	   $prev_title = strip_tags(str_replace('"', '', $prev_post->post_title));
			// 	   echo '<a rel="prev" href="' . get_permalink($prev_post->ID) . '" title="' . $prev_title. '" class="post-nav__prev"><span class="post-nav__wrapper"><p>Previous Article</p></span></a>';
			// 	}
			// wp_reset_postdata();

			// $next_post = get_next_post();
			// setup_postdata($next_post);
			// 	if($next_post) {
			// 	   $next_title = strip_tags(str_replace('"', '', $next_post->post_title));
			// 	   echo '<a rel="next" href="' . get_permalink($next_post->ID) . '" title="' . $next_title. '" class="post-nav__next"><span class="post-nav__wrapper"><p>Next Article</p></span></a>';
			// 	}
			// wp_reset_postdata();
			?>
		<!-- </div> -->

		<!-- Blog Posts -->
		<!-- <div class="l-container">
			<h2 class="other-posts">Other Posts from Evolutionary to Epic</h2>
			<ul class="blog-tiles"> -->
				<?php
					// $user = wp_get_current_user();
					// $id = get_the_ID();
					// if(!in_array('administrator', $user->roles)) {

					// 	$args = array(
					// 		'post_type' => 'blog_post',
					// 		'posts_per_page' => 6,
					// 		'orderby'=> 'date',
					// 		'post__not_in' => array($featured_post->ID, $id),
					// 		'order' => 'DESC',
					// 		// 'tax_query' => array(
					// 		// 	'relation' => 'OR',
					// 		// 	array(
					// 		// 		'taxonomy' => 'privilege_level',
					// 		// 		'field'    => 'slug',
					// 		// 		'terms'    => $user->roles,
					// 		// 	),
					// 		// 	array(
	            	// 		// 		'taxonomy' => 'privilege_level',
	            	// 		// 		'field'    => 'slug',
	            	// 		// 		'terms'    => array('managing_partner','strategic_partner','associate_partner'),
	            	// 		// 		'operator' => 'NOT IN'
					// 		// 	),
					// 		// ),
					// 	);
						
					// } else {

					// 	$args = array(
					// 		'post_type' => 'blog_post',
					// 		'posts_per_page' => 6,
					// 		'orderby'=> 'date',
					// 		'order' => 'DESC',
					// 		'post__not_in' => array($featured_post->ID, $id),
					// 	);

					// }

					// $loop = new WP_Query( $args );
					// if ( $loop->have_posts() ): 
					// $count = 0;
					// while ( $loop->have_posts() ) : $loop->the_post();
					// 	include(locate_template('partials/listing.php', false, false));
					// 	$count++;
					// endwhile;
					// endif;
					// wp_reset_postdata();
				?>
			</ul>
			<!-- <a href="<?php bloginfo('url'); ?>/insights" class="blog__button">See More</a> -->
		</div>
		</div>


	<?php endwhile;
	endif;
	?>

</div>

<?php get_footer(); ?>
