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