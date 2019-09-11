<?php get_header('blog'); 

?>

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
				<?php if($authors != NULL): ?>
					<p class="blog-post__header__byline">
						By <?php foreach( $authors as $a ): ?>
							<span class="blog-post__header__byline__name"><?= get_the_title($a->ID) ?></span>
						<?php endforeach; ?>
					</p>
				<?php endif; ?>
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
			<?php if(get_field('blog_post_about_go', 2) != NULL) : ?>
				<div class="blog-post__about">
					<?php echo get_field('blog_post_about_go', 2); ?>
				</div>
			<?php endif; ?>
			<div class="blog-post__footnotes">
				<h3>Sources</h3>
			</div>
		</div>
	</div>

	<?php endwhile;
	endif;
	?>

</div>

<?php get_footer(); ?>
