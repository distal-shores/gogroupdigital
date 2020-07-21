<?php get_header('blog'); ?>

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

	// Get Categories
	$terms = get_terms( array(
		'taxonomy' => 'category',
		'hide_empty' => 'false'
	));
	// Exclude categories
	$categories = array();
	$excluded_categories = array();
	foreach ($terms as $term) {
		$slug = $term->slug;
		if ($slug === 'webinars' || $slug === 'roundtable') {
			$excluded_categories[] = $term->term_id;
		} else if ($term->count !== 0) {
			$categories[] = $term->name;
		}
	}
?>

<div class="banner" id="banner--insights" style="background-image: linear-gradient(to bottom, rgba(113, 76, 182, 0.7), rgba(39, 96, 182, 0.7)), url(<?php echo $banner_background; ?>);">
	<span class="banner__content">
		<?php if($banner_title): ?>
			<h1 class="banner__content--first"><?php echo $banner_title; ?></h1>
		<?php endif; ?>
		<?php if($banner_subtitle): ?>
			<hr class="banner__content__hr__short-blue"/>
			<h2 class="banner__content--second">The world’s first publication dedicated to revealing how the power of <strong>experimentation unlocks epic business growth.</strong></h2>
		<?php endif; ?>
	</span>
</div>

<div class="blog">
	<div class="l-container">
		<?php
			$featured_post = get_field('e_to_e_featured_post', 2);
			$featured_post = $featured_post[0];
			$args = array(
				'post_type' => 'blog_post',
			);
			$loop = new WP_Query( $args );
			if ( $loop->have_posts() ): 
			$count = 0;
		?>
		<ul id="featured-post-list" class="blog-tiles">
			<?php 			
				include(locate_template('partials/listing-featured.php', false, false));
				$count++;
				endif;
				wp_reset_postdata();
			?>
		</ul>
		<div class="spacer"></div>
		<h3 class="blog-index-headline">Recent Articles</h3>
		<ul id="recent-articles-list" class="blog-tiles">
			<?php
				$excluded_posts = array($featured_post->ID);
				$args = array(
					'post_type' => 'blog_post',
					'post_status' => 'publish',
					'orderby'=> 'date',
					'order' => 'DESC',
					'posts_per_page' => 3,
					'post__not_in' => $excluded_posts,
					'category__not_in' => $excluded_categories
				);
				$loop = new WP_Query( $args );
				if ( $loop->have_posts() ): 
					while ( $loop->have_posts() ) : $loop->the_post();
						include(locate_template('partials/listing-index.php', false, false));
						array_push($excluded_posts, get_the_id()); 
						$count++;
					endwhile;
				endif;
				wp_reset_postdata(); 
			?>
		</ul>
		<h3 id="more-go-insights" class="blog-index-headline">More GO Insights</h3>
		<div id="blog-categories-select-wrapper">
			<select id="blog-categories-select">
				<option>View All</option>
				<?php foreach($categories as $category) : ?>
				<option><?= $category ?></option>
				<?php endforeach ?>
			</select>
		</div>
		<?php 
			$args = array(
				'post_type' => 'blog_post',
				'post_status' => 'publish',
				'orderby'=> 'date',
				'order' => 'DESC',
				'posts_per_page' => 3,
				'post__not_in' => $excluded_posts,
				'category__not_in' => $excluded_categories
			);
			$loop = new WP_Query( $args );
		?>
		<ul id="more-go-content" class="blog-tiles">
			<?php if ( $loop->have_posts() ): 
				while ( $loop->have_posts() ) : $loop->the_post();
					include(locate_template('partials/listing-index.php', false, false));
				endwhile;
			endif;
			wp_reset_postdata();
		?>
		</ul>
		<a href="" class="blog__view-more">View More Articles</a>
	</div>

	<span class="helix helix--five"><img src="<?php echo get_bloginfo('stylesheet_directory').'/images/background-helix_five.png'; ?>"/></span>
</div>

<?php get_footer(); ?>
