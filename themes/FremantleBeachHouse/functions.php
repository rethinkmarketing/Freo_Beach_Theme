<?php


//Page Slug Body Class
function add_slug_body_class( $classes ) {
global $post;
if ( isset( $post ) ) {
$classes[] = $post->post_type . '-' . $post->post_name;
}
return $classes;
}
add_filter( 'body_class', 'add_slug_body_class' );
add_theme_support( 'attraction-images' );
add_image_size( 'attraction-images', 400, 400, true ); // Hard Crop Mode