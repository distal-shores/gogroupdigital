<?php get_header('blog'); ?>

<?php
if ( have_posts() ) :
while ( have_posts() ) : the_post();
?>

<?php
	$marketing_page = get_field('marketing_page') == true ? true : false;
	$featured_image = get_field('featured_image'); 
	$subtitle = get_field('subtitle'); 
	$content = get_the_content();
	$contributing_authors = get_field('contributing_authors');
	$byline_authors = get_field('byline_authors');
	$go_content = get_field('go_content_switch');
	$user = wp_get_current_user();
	$privilege_level = wp_get_post_terms(get_the_ID(), 'privilege_level');
	$privilege_levels = array();
	$excluded_posts = array(get_the_ID());
	foreach($privilege_level as $level) {
		$privilege_levels[] = $level->slug;
	}
	$categories = array();
	foreach((get_the_category()) as $category) { 
		array_push($categories, $category->category_nicename);
	}

	$show_form = get_field('show_gravity_form') == true ? true : false;
	$form_id = $show_form ? get_field('gravity_form') : null;
?>

<div class="l-body blog-post  <?= $show_form ? 'has-form' : '' ?>">

	<?php if($show_form): ?>
	<div class="landing-background" style="background-image:url(<?php echo $featured_image['sizes']['blog_large']; ?>)"></div>
	<div class="landing-background scrim"></div>
	<?php endif; ?>

	<?php if($featured_image): ?>
		<?php if($show_form): ?>
		<div class="blog-post__image">
		<?php else: ?>
		<div class="blog-post__image" style="background-image:url(<?php echo $featured_image['sizes']['blog_large']; ?>)">
		<?php endif; ?>
			<div class="overlay"></div>
			<div class="blog-post__header">
				<?php if(!$show_form): ?>
				<p class="blog-post__header__date">
					<?php $post_date = get_the_date( 'F j, Y' ); echo $post_date; ?>
				</p>
				<?php endif; ?>
				<h1 class="blog-post__header__title"><?php the_title(); ?></h1>
				<?php if(!$marketing_page): ?>
					<hr class="blog-post__header__hr__short-blue" />
					<p class="blog-post__header__byline">
						<?php if($byline_authors != NULL): ?>
							<span class="blog-post__header__byline__by">By</span> <?php foreach( $byline_authors as $a ): ?>
								<span class="blog-post__header__byline__name"><?= get_the_title($a->ID) ?></span>
							<?php endforeach; ?>
						<?php else : ?>
							<span class="blog-post__header__byline__by">By</span> GO Group Digital
						<?php endif; ?>
					</p>
				<?php endif; ?>
			</div> 
		</div>
	<?php endif; ?><!-- featured-image -->
	
	<div class="page-content">

		<div class="l-container blog-content">

			<?php if(!$marketing_page): ?>
				<div class="blog-post__blog-content__categories">
					<?php foreach((get_the_category()) as $category) { 
						echo "<span>{$category->cat_name}</span>";
					} ?>
				</div>
			<?php endif; ?>

			<?php if($subtitle): ?>
				<h2 class="blog-post__subtitle">
					<?php echo $subtitle; ?>
				</h2>
			<?php endif; ?>

			<?php
				if ( in_array_any($privilege_levels, (array) $user->roles) || empty($privilege_levels) || in_array('administrator', $user->roles)) {
					the_content();
				} else {
					$mailtoSubject = str_replace(' ', '%20', the_title('', ' Access', false));
					?>
						<p style="text-align:left">
							This content is reserved for Go Partners. As a GO Partner, please <a href="<?= wp_login_url(); ?>">log in</a> to gain access.<br>
							Not a partner? Please <a href="#contact">contact us</a> to learn about exclusive access to the GO Group Digital Platform.
						</p>
					<?php
				}
			?>

			<?php echo (!$marketing_page && !$show_form) ? do_shortcode('[social-shares]') : '' ?>

			<?php if(!$marketing_page && ($contributing_authors || $byline_authors)): ?>
				<h4 class="blog-post__authors__header">Contributing Author(s)</h4>
				<?php
					$authors = array();
					if ($byline_authors) {
						$authors = array_merge($authors, $byline_authors);
					}
					if ($contributing_authors) {
						$authors = array_merge($authors, $contributing_authors);
					}
				?>
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

		</div><!-- .blog-content -->

		<?php if($show_form): ?>
			<div class="form-overlay-wrapper">
				<div class="form-overlay">
					<?php gravity_form($form_id, true, false) ?>
				</div>
				<?php echo do_shortcode('[social-shares]') ?>
			</div>
		<?php endif; ?>

		<div class="blog-post__contact <?= $marketing_page == true ? 'blog-post__contact__no-border' : '' ?>">
			<h4>Got Questions?</h4>
			<a href="#contact" class="contact-button">Reach Out to Us</a>
		</div>

		<?php if(!$marketing_page): ?>
			<?php if(get_field('blog_post_about_go', 2) != NULL) : ?>
				<div class="blog-post__about">
					<?php echo get_field('blog_post_about_go', 2); ?>
				</div>
			<?php endif; ?>
		<?php endif; ?>

		<div class="blog-post__footnotes"></div>

	</div><!-- .page-content -->

	<?php endwhile; endif; ?>

	<?php 
		$args = array(
			'post_type' => 'blog_post',
			'post_status' => 'publish',
			'orderby'=> 'date',
			'order' => 'DESC',
			'posts_per_page' => 3,
			'post__not_in' => $excluded_posts,
			'tax_query' => array(
				array(
					'taxonomy' => 'category',
					'field' => 'slug',
					'terms' => $categories,
				)
			),
		);
		$loop = new WP_Query( $args );
	?>
	<?php if ( $loop->have_posts() ): ?>
		<div class="related-articles">
			<div class="related-articles__wrapper">
				<h2>Related Articles</h2>
				<ul id="recent-articles-list" class="blog-tiles">
					<?php
					while ( $loop->have_posts() ) : $loop->the_post();
						include(locate_template('partials/listing-index.php', false, false));
					endwhile;
					?>
				</ul>
			</div>
		</div>
	<?php endif; wp_reset_postdata(); ?>
</div>

<?php get_footer(); ?>
