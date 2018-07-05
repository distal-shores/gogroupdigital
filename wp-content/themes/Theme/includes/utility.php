<?php


/**
 * Print the return value of a template function
 *
 * @param string $function Function name
 * @param mixed $parameters Function parameters, optional
 */
function theme_print_function($function, $paramters = array()) {

	if ( is_array($paramters) ) {
		$params = $paramters;
	} else {
		$params = array($paramters);
	}

	$output = call_user_func_array($function, $params);

	if ( $output ) {
		echo $output;
	}

}


/**
 * Return the markup of a widget
 * 
 */
if( !function_exists('theme_get_the_widget') ){

	function theme_get_the_widget( $widget, $instance = '', $args = '' ){
		ob_start();
		the_widget($widget, $instance, $args);
		return ob_get_clean();
	}

}


/**
 * A function to weed out duplicates in an array based on a key
 * 
 */
function unique_multidim_array($array, $key) { 
	$temp_array = array(); 
    $i = 0; 
    $key_array = array(); 

    foreach($array as $val) { 
        if (!in_array($val[$key], $key_array)) { 
            $key_array[$i] = $val[$key]; 
            $temp_array[$i] = $val; 
        } 
        $i++; 
    } 
    return $temp_array; 
} 

function seoUrl($string) {
    //Lower case everything
    $string = strtolower($string);
    //Make alphanumeric (removes all other characters)
    $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
    //Clean up multiple dashes or whitespaces
    $string = preg_replace("/[\s-]+/", " ", $string);
    //Convert whitespaces and underscore to dash
    $string = preg_replace("/[\s_]/", "-", $string);
    return $string;
}