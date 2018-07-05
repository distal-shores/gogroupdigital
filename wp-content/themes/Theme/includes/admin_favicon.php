<?php
function add_favicon() {
  	$favicon_url = get_stylesheet_directory_uri() . '/favicon/favicon.ico';
	echo '<link rel="shortcut icon" href="' . $favicon_url . '" />';
}

add_action('login_head', 'add_favicon');
add_action('admin_head', 'add_favicon');