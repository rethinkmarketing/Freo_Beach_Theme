<?php
$themify_theme_config = array();

$themify_theme_config['folders'] = array(
	'images' => array(
		'src' => 'uploads/'
	)
);

/* 	Settings Panel
/***************************************************************************/	
$themify_theme_config['panel']['settings']['tab']['theme_settings'] = array(
    'title' => __('Theme Settings', 'themify'),
    'id' => 'theme_settings',
    'custom-module' => array(
        array(
            'title' => __('Responsive Design', 'themify'),
            'function' => 'disable_responsive_design_option'
        ),
        array(
            'title' => __('Page Navigation', 'themify'),
            'function' => 'entries_navigation'
        ),
        array(
            'title' => __('Exclude RSS Link', 'themify'),
            'function' => 'exclude_rss'
        ),
        array(
            'title' => __('Exclude Search Form', 'themify'),
            'function' => 'exclude_search_form'
        ),
        array(
            'title' => __('Header Slider (appears on homepage only)', 'themify'),
            'function' => 'header_slider'
        ),
        array(
            'title' => __('Footer Slider (appears on all pages)', 'themify'),
            'function' => 'footer_slider'
        ),
        array(
            'title' => __('Footer Widgets', 'themify'),
            'function' => 'footer_widgets'
        ),
        array(
            'title' => __( 'Footer Text', 'themify' ),
            'function' => 'footer_text_settings'
        ),
        array(
            'title' => __('WordPress Gallery Lightbox', 'themify'),
            'function' => 'gallery_plugins'
        )
    )
);

$themify_theme_config['panel']['settings']['tab']['default_layouts'] = array(
	'title' => __('Default Layouts', 'themify'),
	'id' => 'default_layouts',
	'custom-module' => array(
		array(
			'title' => __('Default Archive Post Layout', 'themify'),
			'function' => 'default_layout'
		),
		array(
			'title' => __('Default Single Post Layout', 'themify'),
			'function' => 'default_post_layout'
		),
		array(
			'title' => __('Default Page Layout', 'themify'),
			'function' => 'default_page_layout'
		),
		array(
			'title' => __('Custom Post Types', 'themify'),
			'function' => 'custom_post_type_layouts'
		)
	)
);