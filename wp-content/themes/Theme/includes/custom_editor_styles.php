<?php
// Add a stylesheet to apply styles to the wordpress editor
function add_editor_styles() {
    add_editor_style( 'stylesheets/css/custom-editor-style.css' );
}
add_action( 'admin_init', 'add_editor_styles' );

// Add a button to wordpress editor
function wpb_mce_buttons_2($buttons) {
	array_unshift($buttons, 'styleselect');
	return $buttons;
}
add_filter('mce_buttons_2', 'wpb_mce_buttons_2');

// Calling the added button to wordpress editor
function my_mce_before_init_insert_formats( $init_array ) {  
	$style_formats = array(  
		array(  
			'title' => 'Pullquote',  
			'block' => 'div',  
			'classes' => 'pullquote',
			'wrapper' => true,
		),
	);  
	// Insert the array, JSON ENCODED, into 'style_formats'
	$init_array['style_formats'] = json_encode( $style_formats );  
	
	return $init_array;  
  
} 
add_filter( 'tiny_mce_before_init', 'my_mce_before_init_insert_formats' ); 

// Showing only specific headings from list
function custom_headings($arr){
    $arr['block_formats'] = 'Body Text=p;Page Title=h1;Heading=h2;Heading 2=h3;Introductory Text=h4;Small Info Heading=h5;Preformatted=pre;';
    return $arr;
  }
add_filter('tiny_mce_before_init', 'custom_headings');

// Add buttons to wysiwyg that's hidden by default
function mcebuttons($buttons) {
	$buttons[] = 'superscript';
	$buttons[] = 'subscript';
	return $buttons;
}
add_filter('mce_buttons_2', 'mcebuttons');

// Enable font size and font family selects in the editor
if ( ! function_exists( 'am_add_mce_font_buttons' ) ) {
    function am_add_mce_font_buttons( $buttons ) {
        array_unshift( $buttons, 'fontsizeselect' ); 
        return $buttons;
    }
}
add_filter( 'mce_buttons_2', 'am_add_mce_font_buttons' );

// Customize Tiny mce editor font sizes for WordPress
if ( ! function_exists( 'am_tiny_mce_font_size' ) ) {
    function am_tiny_mce_font_size( $initArray ){
        $initArray['fontsize_formats'] = "9px 10px 12px 13px 14px 16px 18px 21px 24px 28px 32px 36px";
        return $initArray;
    }
}
add_filter( 'tiny_mce_before_init', 'am_tiny_mce_font_size' );