<?php

add_action('init', 'theme_register_menus');

/**
 * Core menu registration.
 *
 * @package theme
 * @subpackage boilerplate-theme_filters+hooks
 * @internal called by init action
 * @link https://codex.wordpress.org/Function_Reference/register_nav_menus
 */
function theme_register_menus() {
	register_nav_menus(array(
		'primary' => __('Primary Nav', 'Admin - ' . get_bloginfo('name')  ),
		'mobile' => __('Mobile Nav', 'Admin - ' . get_bloginfo('name')  ),
		'footer' => __('Footer Nav', 'Admin - ' . get_bloginfo('name')  )
	));
}
