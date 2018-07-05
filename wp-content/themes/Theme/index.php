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

		<?php
			if ( have_posts() ) :
				while ( have_posts() ) : the_post(); ?>

				<div class="page-content">
					<div class="l-container">
						<?php the_content(); ?>
						<?php if( get_field('content') ): ?>
							<?php the_field('content'); ?>
						<?php endif; ?>
					</div>
				</div>

				<?php endwhile;
			else :
				get_template_part( 'partials/content', 'none' );
			endif;
		?>

</div>

<?php get_footer(); ?>
