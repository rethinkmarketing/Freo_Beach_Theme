<?php
/*
To add custom PHP functions to the theme, create a child theme (https://themify.me/docs/child-theme) and add it to the child theme functions.php file. 
They will be added to the theme automatically.
*/

function themify_theme_google_fonts( $fonts ) {
	$fonts['arapey'] = 'Arapey:400i,400';
	return $fonts;
}
function themify_theme_avatar_size(){
    return 36;
}
add_filter('themify_comment_avatar_size','themify_theme_avatar_size');
add_filter( 'themify_google_fonts', 'themify_theme_google_fonts' );
add_filter('themify_register_sidebars','themify_theme_register_sidebars');
	
	
// Register Custom Menu Function
function themify_register_custom_nav() {
    /* prevent update checks from wp.org repository */
    add_theme_support( 'themify-exclude-theme-from-wp-update' );
    add_theme_support( 'post-thumbnails' );
    Themify_Enqueue_Assets::remove_theme_support_css('rtl');
    register_nav_menus( array(
	    'top-nav' => __( 'Top Navigation', 'themify' ),
	    'main-nav' => __( 'Main Navigation', 'themify' ),
	    'footer-nav' => __( 'Footer Navigation', 'themify' ),
    ) );
}

// Register Custom Menu Function - Action
add_action('after_setup_theme', 'themify_register_custom_nav');
	
/* 
 * Register sidebars
 * @since 1.0.0
 */
function themify_theme_register_sidebars($sidebars) {
    $sidebars[0]['name']= __('Sidebar Wide', 'themify');
    $sidebars[]=array(
	    'name' => __('Sidebar Narrow', 'themify'),
	    'id' => 'sidebar-alt',
	    'before_widget' => '<div class="widgetwrap"><div id="%1$s" class="widget %2$s">',
	    'after_widget' => '</div></div>',
	    'before_title' => '<h4 class="widgettitle">',
	    'after_title' => '</h4>'
    );
    $sidebars[]=array(
	    'name' => __('Sidebar Wide 2A', 'themify'),
	    'id' => 'sidebar-main-2a',
	    'before_widget' => '<div id="%1$s" class="widget %2$s">',
	    'after_widget' => '</div>',
	    'before_title' => '<h4 class="widgettitle">',
	    'after_title' => '</h4>'
    );
    $sidebars[]=array(
	    'name' => __('Sidebar Wide 2B', 'themify'),
	    'id' => 'sidebar-main-2b',
	    'before_widget' => '<div id="%1$s" class="widget %2$s">',
	    'after_widget' => '</div>',
	    'before_title' => '<h4 class="widgettitle">',
	    'after_title' => '</h4>',
    );
    $sidebars[]=array(
	    'name' => __('Sidebar Wide 3', 'themify'),
	    'id' => 'sidebar-main-3',
	    'before_widget' => '<div id="%1$s" class="widget %2$s">',
	    'after_widget' => '</div>',
	    'before_title' => '<h4 class="widgettitle">',
	    'after_title' => '</h4>'
    );
    $sidebars[]=array(
	    'name' => __('Header Widget', 'themify'),
	    'id' => 'header-widget',
	    'before_widget' => '<div id="%1$s" class="widget %2$s">',
	    'after_widget' => '</div>',
	    'before_title' => '<strong class="widgettitle">',
	    'after_title' => '</strong>'
    );
    return $sidebars;
     
}
if( ! function_exists('themify_theme_add_sidebar_alt') ) {
	/**
	 * Includes narrow left sidebar
	 * @since 1.2.0
	 */
	function themify_theme_add_sidebar_alt() {
		global $themify;
		if( 'sidebar2' === $themify->layout || 'sidebar2 content-left' === $themify->layout || 'sidebar2 content-right' === $themify->layout ): ?>
			<!-- sidebar-narrow -->
			<?php get_template_part( 'includes/sidebar-alt'); ?>
			<!-- /sidebar-narrow -->
		<?php endif;
	}
}
add_action( 'themify_content_after', 'themify_theme_add_sidebar_alt' );


// CPT Sidebars
add_filter( 'themify_post_type_theme_sidebars', 'themify_CPT_sidebar_option', 10, 2 );

if( ! function_exists('themify_CPT_sidebar_option') ) {
	/**
	 * Includes second sidebar
	 */
	function themify_CPT_sidebar_option($option, $default = true) {

		$option = array();

		if ($default) {
			$option[] = array('value' => 'default', 'img' => 'themify/img/default.svg', 'selected' => true, 'title' => __('Default', 'themify'));
		}

		array_push($option,
					array('value' => 'sidebar1', 'img' => 'images/layout-icons/sidebar1.png', 'selected' => true, 'title' => __('Sidebar Right', 'themify')),
					array('value' => 'sidebar1 sidebar-left', 'img' => 'images/layout-icons/sidebar1-left.png', 'title' => __('Sidebar Left', 'themify')),
					array('value' => 'sidebar2', 'img' => 'images/layout-icons/sidebar2.png', 'title' => __('Left and Right', 'themify')),
					array('value' => 'sidebar2 content-left', 	'img' => 'images/layout-icons/sidebar2-content-left.png', 'title' => __('2 Right Sidebars', 'themify')),
					array('value' => 'sidebar2 content-right', 	'img' => 'images/layout-icons/sidebar2-content-right.png', 'title' => __('2 Left Sidebars', 'themify')),
					array('value' => 'sidebar-none', 'img' => 'images/layout-icons/sidebar-none.png', 'title' => __('No Sidebar', 'themify'))
				);

		return $option;
	}
}
