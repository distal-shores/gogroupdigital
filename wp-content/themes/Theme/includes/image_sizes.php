<?php

	/**
	 * Image sizes
	 *
	 * @link https://codex.wordpress.org/Function_Reference/add_image_size
	 *
	 */

	// Add post thumbnail theme support
    add_theme_support( 'post-thumbnails' );

	// Add Image Sizes
    add_image_size( 'hero', 1600, 1200, array('center, center') );
    add_image_size( 'banner', 1600, 742, array('center, center') );
    add_image_size( 'office', 560, 370, array('center, center') );
    add_image_size( 'office-map', 700, 390, array('center, center') );
    add_image_size( 'client_logo', 160, 60 );
    add_image_size( 'blog_small', 370, 300, array('center, center') );
    add_image_size( 'blog_medium', 770, 300, array('center, center') );
    add_image_size( 'blog_large', 1140, 575, array('center, center') );


    // Set default values for the upload media box
	function default_image_size() {
	    update_option('image_default_align', 'center' );
	    update_option('image_default_size', 'full' );

	}
	add_action('after_setup_theme', 'default_image_size');
