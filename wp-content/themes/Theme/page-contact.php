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
				<h1 class="banner__content--first"><?php echo $banner_title; ?></h1>
			<?php endif; ?>
			<?php if($banner_subtitle): ?>
				<h2 class="banner__content--second"><?php echo $banner_subtitle; ?></h2>
			<?php endif; ?>
		</span>
	</div>

  <div class="contact-page">
    <div class="l-container">
      <div class="_contact-form">
        <div class="_contact-form__form">
          <p class="_contact-form__form__title">Ready to go evolutionary to epic?</p>
          <?php echo do_shortcode('[vfb id=1]'); ?>
        </div>
      </div>
    </div>
  </div>

</div>

<?php get_footer(); ?>