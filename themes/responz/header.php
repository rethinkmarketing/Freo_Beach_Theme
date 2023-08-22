<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php themify_body_start(); //hook ?>
<div id="pagewrap" class="hfeed site">

	<div id="headerwrap">

		<nav id="nav-bar" aria-label="<?php _e( 'Top Bar Navigation', 'themify' ); ?>">
			<div class="pagewidth tf_clearfix">
				<?php themify_menu_nav(array('theme_location' => 'top-nav' , 'fallback_cb' => '' , 'container'  => '' , 'menu_id' => 'top-nav' , 'menu_class' => 'top-nav'));?>
			</div>
			<span class="screen-reader-text"><?php _e( 'Scroll down to content', 'themify' ); ?></span>
		</nav>
		<!-- /nav-bar -->

		<?php themify_header_before(); //hook ?>
		<header id="header" class="pagewidth" itemscope="itemscope" itemtype="https://schema.org/WPHeader" role="banner">
        	<?php themify_header_start(); //hook ?>

			<?php echo themify_logo_image('site_logo'),themify_site_description();?>

			<aside class="header-widget" role="complementary">
				<?php dynamic_sidebar('header-widget'); ?>
			</aside>
			<!--/header widget -->

			<?php if(!themify_check('setting-exclude_search_form')): ?>
				<div id="searchform-wrap">
					<div id="search-icon" class="mobile-button"></div>
					<?php get_search_form(); ?>
				</div>
				<!-- /searchform-wrap -->
			<?php endif ?>

			<aside class="social-widget" role="complementary">
				<?php 
				    dynamic_sidebar('social-widget');
				    themify_theme_feed();
				?>
			</aside>
			<!-- /.social-widget -->

            <div id="main-nav-wrap">
                <div id="menu-icon" class="mobile-button">
                	<span class="screen-reader-text"><?php _e( 'Menu', 'themify' ); ?></span>
                </div>
                <nav itemscope="itemscope" aria-label="<?php _e( 'Main Navigation', 'themify' ); ?>" itemtype="https://schema.org/SiteNavigationElement">
                    <?php
			themify_menu_nav( array(
				'theme_location' => 'main-nav',
				'fallback_cb'    => 'themify_default_main_nav',
				'container'      => '',
				'menu_id'        => 'main-nav',
				'menu_class'     => 'main-nav'
			));
					
		    ?>
                </nav>
                <span class="screen-reader-text"><?php _e( 'Scroll down to content', 'themify' ); ?></span>
		<!-- /#main-nav -->
	</div>
            <!-- /#main-nav-wrap -->

			<?php themify_header_end(); //hook ?>
		</header>
		<!-- /#header -->
        <?php themify_header_after(); //hook ?>

	</div>
	<!-- /#headerwrap -->

	<div id="body" class="tf_clearfix">
	<?php themify_layout_before(); //hook