<?php

// Wordpress sometimes adds a bunch of random <p>'s with no content. This will remove them.
if (!function_exists('jdm_fix_shortcodes')) {
	function jdm_fix_shortcodes($content)
	{
		$array = array(
			'<p>[' => '[',
			']</p>' => ']',
			']<br />' => ']',
			'<p></p>' => ''
		);
		$content = strtr($content, $array);
		return $content;
	}
	add_filter('the_content', 'jdm_fix_shortcodes');
}

function generate_sidebar_topic($atts, $content = null)
{
	$a = shortcode_atts(array(
		'title' => '',
		'heading' => 'Sidebar Topic'
	), $atts);

	$content = strip_tags($content, '<ul><ol><li><p><img><br><span><b><strong><caption><figure>');
	// Place images in <p>, so they're styled correctly
	$content = preg_replace("/(<img[^>]*>)/i", '<p>$1</p>', $content);
	// Handle nested shortcodes
	$content = do_shortcode($content);
	$content = force_balance_tags($content);

	ob_start();
?>
	<div class="sidebar-topic">
		<div class="sidebar-topic__divider"></div>
		<h2 class="sidebar-topic__title" data-heading="<?php echo $a['heading']; ?>"><?php echo $a['title']; ?></h2>
		<?php echo $content; ?>
		<div class="sidebar-topic__divider"></div>
	</div>
<?php
	return ob_get_clean();
}
add_shortcode('sidebar_topic', 'generate_sidebar_topic');

function generate_blockquote($atts, $content = null)
{
	$a = shortcode_atts(array(
		'attribution' => null,
	), $atts);

	$attribution = $a['attribution'];

	$content = trim(strip_tags($content, '<strong><b><br>'));

	ob_start();
?>
	<div class="blockquote-wrapper">
		<blockquote><p><?= $content ?><p></blockquote>
		<?php if ($attribution) : ?>
			<span class="attribution">- <?= $attribution ?></span>
		<?php endif; ?>
	</div>
<?php
	return ob_get_clean();
}
add_shortcode('blockquote', 'generate_blockquote');

function generate_pullquote($atts, $content = null)
{
	$a = shortcode_atts(array(), $atts);

	$content = strip_tags($content, '');

	ob_start();
?>
	<div class="pullquote">
		<h3><?php echo $content ?></h3>
		<span class="border-bottom"></span>
	</div>
<?php
	return ob_get_clean();
}
add_shortcode('pullquote', 'generate_pullquote');

function generate_social_shares($atts)
{
	$a = shortcode_atts(array(), $atts);
	global $post;
	ob_start();
?>
	<div class="social-shares">
		<span class="social-shares__heading">Share Article:</span>
		<ul class="social-shares__icons">
			<li class="linkedin"><a target="_blank" href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode(get_permalink($post->ID)); ?>"><i class="fa fa-linkedin"></i></a></li>
			<li class="facebook" data-href="<?php echo get_permalink($post->ID); ?>" data-layout="button_count"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink($post->ID)); ?>"><i class="fa fa-facebook"></i></a></li>
			<li class="twitter"><a target="_blank" href="https://twitter.com/intent/tweet?text=<?php echo get_the_title($post->ID); ?>&amp;url=<?php echo urlencode(get_permalink($post->ID)); ?>"><i class="fa fa-twitter"></i></a></li>
			<!-- Your share button code -->
		</ul>
	</div>
	<?php
	return ob_get_clean();
}
add_shortcode('social-shares', 'generate_social_shares');

function generate_go_presenter($attrs, $content = null)
{
	$a = shortcode_atts(array('id' => ''), $attrs);

	if (!isset($a['id']) || !($a['id'] !== '')) {
		return '<h1 style="background-color: black; color: red;">[go_presenter id=""] Missing id</h1>';
	}

	$content = strip_tags($content, '<a>');

	$args = array(
		'post_type' => 'member',
		'name' => $a['id']
	);
	$query = new WP_Query($args);

	ob_start();
	if ($query->have_posts()) {
		while ($query->have_posts()) {
			$query->the_post();

			$name = get_the_title();
			$profileImage = get_field('profile_image');
			$title = get_field('title');
			$description = get_field('profile_description');
			$logoImage = null;
			$locations = get_field('location');
			if ($locations && count($locations) > 0) {
				$logoImage = get_field('logo', $locations[0]->ID)['url'];
			}
	?>
			<section class="presenter">
				<?php if ($profileImage) : ?>
					<div class="presenter__image-container">
						<img class="presenter__profile-image" src="<?= $profileImage['url'] ?>">
						<?php if ($logoImage) : ?>
							<div class="presenter__logo-container">
								<img class="presenter__logo-image" src="<?= $logoImage ?>">
							</div>
						<?php endif; ?>
					</div>
				<?php endif; ?>
				<div class="presenter__title-description">
					<strong class="presenter__title"><?= $name ?>, <?= $title ?></strong>
					<p><?= $content ?></p>
				</div>
			</section>
	<?php
		}
	} else {
		echo '<h1 style="background-color: black; color: red;">[go_presenter id="' . $a['id'] . '"] Could not find member</h1>';
	}
	wp_reset_postdata();
	return ob_get_clean();
}
add_shortcode('go_presenter', 'generate_go_presenter');

function generate_go_feature($attrs, $content = null)
{
	$a = shortcode_atts(array(
		'title' => '',
		'author' => '',
		'url' => null,
	), $attrs);

	$content = strip_tags($content, '<img>');

	ob_start();
	?>
	<?php if ($a['url']) : ?>
		<a href="<?= $a['url'] ?>" target="_blank" class="go-feature-link">
		<?php endif; ?>
		<div class="go-feature">
			<?= $content ?>
			<div class="go-feature__content">
				<span class="go-feature__author"><?= $a['author'] ?></span>
				<span class="go-feature__title"><?= $a['title'] ?></span>
			</div>
		</div>
		<?php if ($a['url']) : ?>
		</a>
	<?php endif; ?>
<?php
	return ob_get_clean();
}
add_shortcode('go_feature', 'generate_go_feature');

function generate_go_button($attrs, $content)
{
	$a = shortcode_atts(array('url' => null), $attrs);
	$content = strip_tags($content);
	ob_start();
?>
	<a class="go-button" href="<?= $a['url'] ?>" target="_blank"><?= $content ?></a>
<?php
	return ob_get_clean();
}
add_shortcode('go_button', 'generate_go_button');
