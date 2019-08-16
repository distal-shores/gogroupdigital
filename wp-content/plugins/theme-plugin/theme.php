<?php
/**
Plugin Name: Theme
Description: Unique modules added and stored within this plugin
Version: 1.0
Author: Alan Chao
Text Domain: theme
*/

define( 'THEME__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'THEME_URL', plugin_dir_url( __FILE__ )) ;

require_once( THEME__PLUGIN_DIR . 'includes/acf.php');
// require_once ( THEME__PLUGIN_DIR . 'includes/options.php' );

foreach (glob(THEME__PLUGIN_DIR . 'posttypes/posttype-*.php') as $filename) {
	require_once($filename);
}
foreach (glob(THEME__PLUGIN_DIR . 'taxonomies/taxonomy-*.php') as $filename) {
	require_once($filename);
}
foreach (glob(THEME__PLUGIN_DIR . 'template-tags-*.php') as $filename) {
	require_once($filename);
}

/**
 * Return a plugin slug
 */
function theme_plugin_slug($path = '') {
	$parts = array_filter(explode('/', $path));
	return end($parts);
}