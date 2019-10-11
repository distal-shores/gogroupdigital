<?php

function generate_sidebar_topic( $atts, $content = null ) {
	$a = shortcode_atts( array(
		'title' => '',
	), $atts );

	$content = strip_tags($content, '<ul><li>');

	ob_start();
	?>
		<div class="sidebar-topic">
			<h1><?php echo $a['title']; ?></h1>
			<?php echo $content ?>
		</div>
	<?php
	return ob_get_clean();
}

add_shortcode( 'sidebar_topic', 'generate_sidebar_topic' );

function generate_blockquote( $atts, $content = null ) {
	$a = shortcode_atts( array(), $atts );

	$content = strip_tags($content, '');

	ob_start();
	?>
		<blockquote>
			“<?php echo $content ?>”
		</blockquote>
	<?php
	return ob_get_clean();
}

add_shortcode( 'blockquote', 'generate_blockquote' );

function generate_pullquote( $atts, $content = null ) {
	$a = shortcode_atts( array(), $atts );

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

add_shortcode( 'pullquote', 'generate_pullquote' );

function generate_social_shares( $atts ) {
	$a = shortcode_atts( array(), $atts );
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

add_shortcode( 'social-shares', 'generate_social_shares' );

