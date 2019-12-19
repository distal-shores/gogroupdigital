<?php

add_action('after_setup_theme', 'theme_theme_setup');
add_filter('stylesheet_uri', 'theme_stylesheet_uri', 10, 2);

/**
 * Basic theme setup stuff like theme support
 *
 * @package theme
 * @subpackage boilerplate-theme_filters+hooks
 * @internal only called as `after_setup_theme` action
 * @link https://codex.wordpress.org/Function_Reference/add_theme_support
 *
 */
function theme_theme_setup() {

	global $content_width;

	// Set the $content_width for things such as video embeds.
	// http://codex.wordpress.org/Content_Width
	if ( !isset( $content_width ) )
		$content_width = 1000;

	// Let WordPress manage document title
	add_theme_support( 'title-tag' );

	add_theme_support('html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption')); 	// http://codex.wordpress.org/Function_Reference/add_theme_support#HTML5
}

/**
 * Change the stylesheet url to our compiled stylesheet from Sassyplayte
 *
 * @package theme
 * @subpackage boilerplate-theme_filters+hooks
 * @internal only called as `stylesheet_uri` filter
 *
 */
function theme_stylesheet_uri($stylesheet_uri, $stylesheet_dir_uri)
{
	return $stylesheet_dir_uri . '/stylesheets/css/style.css';
}

/**
 * Use wp_enqueue to add theme stylesheet to wp_head()
 *
 * @package theme
 * @subpackage boilerplate-theme\filters+hooks
 * @uses theme_stylesheet_uri()
 * @link http://codex.wordpress.org/Function_Reference/wp_enqueue_style
 * @internal the '15' in the add_action forces the file to load after the other styles in wp_head().
 *
 */
function theme_enqueue_styles()
{
    wp_enqueue_style('theme-stylesheet',  get_bloginfo( 'stylesheet_url' ), array(), filemtime( theme_stylesheet_uri(null, get_stylesheet_directory()) ));
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles', 15 );

// Remove wp-embed script from footer
function my_deregister_scripts(){
  wp_deregister_script( 'wp-embed' );
}
add_action( 'wp_footer', 'my_deregister_scripts' );

// Clean up <head> and improve security.
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'feed_links', 2 );
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');


if( function_exists('acf_add_options_page') ) {
	acf_add_options_page();
}
