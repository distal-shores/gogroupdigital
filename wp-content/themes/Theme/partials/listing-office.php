<?php 
	$office_title = get_the_title();
	$office_image = get_field('featured_hero');
	if($office_image):
		$office_thumbnail = $office_image['sizes']['office'];
		$office_thumbnail_hero = $office_image['sizes']['banner'];
	else:
		$office_thumbnail = get_bloginfo('stylesheet_directory').'/images/placeholder-office.jpg';
		$office_thumbnail_hero = get_bloginfo('stylesheet_directory').'/images/banner-about_na.jpg';
	endif;
?>

<li class="location-tile">
	<a href="<?php the_permalink(); ?>" style="background-image: url(<?php echo $office_thumbnail ?>);">
		<p class="location-tile__title"><?php echo $office_title; ?></p>
	</a>
</li>