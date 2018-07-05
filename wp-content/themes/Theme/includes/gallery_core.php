<?php

// Edit the Wordpress core gallery to make images open in new tabs
add_action( 'after_setup_theme', 'wpse50911_replace_img_shortcodes' );
function wpse50911_replace_img_shortcodes() {
    remove_shortcode( 'gallery', 'gallery_shortcode' );
    add_shortcode( 'gallery', 'wpse50911_gallery_shortcode' );

    remove_shortcode( 'caption', 'img_caption_shortcode' );
    add_shortcode( 'caption', 'wpse50911_caption_shortcode' );

    remove_shortcode( 'wp_caption', 'img_caption_shortcode' );
    add_shortcode( 'wp_caption', 'wpse50911_caption_shortcode' );
}
function wpse50911_gallery_shortcode( $attr ) {
    return links_add_target( gallery_shortcode( $attr ) );
}
function wpse50911_caption_shortcode( $attr, $content = null) {
    return img_caption_shortcode( $attr, links_add_target( $content ) );
}