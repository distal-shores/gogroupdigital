<?php

/**
 * CUSTOM POST TYPES: Template.
 *
 * To use, copy and rename file to posttype-TYPENAME.php. Replace all instances of
 * TYPENAME with the slug of your post type. All posttype-*.php files will be
 * automatically included.
 *
 * For full documentation on post types and all arguments and labels available,
 * see http://codex.wordpress.org/Function_Reference/register_post_type.
 */


add_action('init', function(){

	/*
		Labels for your post type.
		Note that many more are available, as detailed in the codex.

		$singular and $plural are the only variables you must set.
	*/

	$plugin_slug = theme_plugin_slug(plugin_dir_path(__DIR__));

	$singular = apply_filters( $plugin_slug . '/post-type/singular', 'Blog Post' );
	$plural = apply_filters( $plugin_slug . '/post-type/plural', 'Blog Posts' );

	$rewrite = array('slug' => str_replace(" ", "-", strtolower($plural)));
	$rewrite = apply_filters ( $plugin_slug . '/post-type/rewrite', $rewrite, $singular );

	$labels = array(
		'name' => _x($plural, 'post type general name'),
		'singular_name' => _x($singular, 'post type singular name'),
		'add_new' => _x('Add New', $singular),
		'add_new_item' => __('Add New ' . $singular),
		'edit_item' => __('Edit ' . $singular),
		'new_item' => __('New ' . $singular),
		'view_item' => __('View ' . $singular),
		'search_items' => __('Search ' . $plural),
		'not_found' =>  __('no ' . strtolower($plural) . ' found'),
		'not_found_in_trash' => __('No ' . strtolower($plural) . ' in Trash'),
		'parent_item_colon' => ''
	);


	// For all available arguments go to http://codex.wordpress.org/Function_Reference/register_post_type
	$args = array(
		'labels' => apply_filters ( $plugin_slug . '/post-type/labels', $labels, $singular ),
		'public' => true,
		'exclude_from_search' => false,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'our-insights' ),
		'show_in_rest' => true,
		'rest_base' => str_replace(" ", "_", strtolower($plural)),
		'capability_type' => 'page',
		'menu_icon' => 'dashicons-admin-generic',
		'taxonomies' => array(''), // Uses the custom taxonomy created in this template
		'has_archive' => true,
		'hierarchical' => false,
		'supports' => array('title', 'editor', 'custom-fields')
	  );

	$slug = str_replace(" ", "_", strtolower($singular));

	$slug = apply_filters( $plugin_slug . '/post-type/slug', $slug, $singular );
	$args = apply_filters( $plugin_slug . '/post-type/args', $args, $singular );

	register_post_type($slug, $args);
	flush_rewrite_rules();

}, 0);
