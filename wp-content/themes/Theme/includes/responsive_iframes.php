<?php

function iframe_embed_html( $html ) {
    return '<div class="videowrapper">' . $html . '</div>';
}
 
add_filter( 'embed_oembed_html', 'iframe_embed_html', 10, 3 );
add_filter( 'video_embed_html', 'iframe_embed_html' ); // Jetpack