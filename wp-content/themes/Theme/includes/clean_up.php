<?php 

function callback($buffer) {
    $buffer = preg_replace('/<!--(.|s)*?-->/', '', $buffer);
    return $buffer;
}

function buffer_start() {
    ob_start("callback");
}

function buffer_end() {
    ob_end_flush();
}

add_action('get_header', 'buffer_start');
add_action('wp_footer', 'buffer_end');