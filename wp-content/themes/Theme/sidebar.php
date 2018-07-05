<?php

	/**
	 * Sub menu using wp_nav_menu with sub_menu added
	 * @link http://nathansh.github.io/penguinpress-theme/docs/function-pp_wp_nav_menu_objects_sub_menu.html
	 * @link https://codex.wordpress.org/Function_Reference/wp_nav_menu
	 */
	wp_nav_menu( array(
		'theme_location' => 'primary',
		'container' => 'nav',
		'container_class' => 'menu subnav',
		'items_wrap' => '<ul class="subnav__items">%3$s</ul>',
		'depth' => 2,
		'sub_menu' => true,
		)
	);
	wp_nav_menu( array(
		'theme_location' => 'footer',
		'container' => 'nav',
		'container_class' => 'menu subnav',
		'items_wrap' => '<ul class="subnav__items">%3$s</ul>',
		'depth' => 2,
		'sub_menu' => true,
		)
	);

?>
