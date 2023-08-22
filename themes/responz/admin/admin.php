<?php

include THEME_DIR.'/admin/panel/settings.php';

function themify_theme_setup_metaboxes($meta_boxes=array(), $post_type='all') {
    $supportedTypes=array('post', 'page');
    $dir=THEME_DIR . '/admin/pages/';
    if($post_type==='all'){
	foreach($supportedTypes as $s){
	    require_once( $dir . "$s.php" );
	}
	return $meta_boxes;
    }
    if (!in_array($post_type,$supportedTypes , true)) {
	return $meta_boxes;
    }
    require_once( $dir . "$post_type.php" );
    $theme_metaboxes = call_user_func_array( "themify_theme_get_{$post_type}_metaboxes", array( array(), &$meta_boxes ) );

    return array_merge($theme_metaboxes, $meta_boxes);
}

if(isset( $_GET['page'] ) && $_GET['page']==='themify'){
    themify_theme_setup_metaboxes();
}
else{
    add_filter('themify_metabox/fields/themify-meta-boxes', 'themify_theme_setup_metaboxes', 10, 2);
}
