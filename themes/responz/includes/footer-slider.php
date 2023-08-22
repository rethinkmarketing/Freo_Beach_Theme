<?php
/** Check if slider is enabled */
if('on' === themify_get('setting-footer_slider_enabled','on',true)) { ?>

	<?php themify_footer_slider_before(); //hook ?>
	<div id="footer-slider" class="pagewidth slider">
    	<?php themify_footer_slider_start(); //hook ?>
		 <?php
		 $display=themify_get('setting-footer_slider_default_display',false,true);
		 $hasTitle=themify_get('setting-footer_slider_hide_title',false,true);
		 $autoplay = themify_get( 'setting-footer_slider_auto', '0',true );
		 $speed = themify_get( 'setting-footer_slider_speed', 0.5,true )* 1000;
		 $slider_args = apply_filters('themify_theme_footer_slider_args',array(
			 'data-auto'        => $autoplay!=='0'?$autoplay:false,
			 'data-visible'      => themify_get( 'setting-footer_slider_visible', 4,true ),
			 'data-scroll'      => themify_get( 'setting-footer_slider_scroll', 1,true ),
			 'data-wrapvar'      => themify_get( 'setting-footer_slider_wrap', true,true ),
			 'data-speed'       => $speed<1000?$speed/1000:$speed,
			 'data-pager'       => true,
			 'data-slider_nav'  => true,
		 ));
                ?>
		<div data-lazy="1"<?php echo themify_get_element_attributes( $slider_args);?> class="slides tf_clearfix tf_carousel tf_swiper-container tf_rel tf_overflow">
           <div class="tf_swiper-wrapper tf_lazy tf_rel tf_w tf_h">
    		<?php
    		// Get image width and height or set default dimensions
			$img_width = themify_get('setting-footer_slider_width',220,true);
			$img_height = themify_get('setting-footer_slider_height',160,true);

			if(themify_check('setting-footer_slider_posts_category',true)){
				$cat = "&cat=".themify_get('setting-footer_slider_posts_category','',true);
			} else {
				$cat = "";
			}
			if(themify_check('setting-footer_slider_posts_slides',true)){
				$num_posts = "showposts=".themify_get('setting-footer_slider_posts_slides','',true)."&";
			} else {
				$num_posts = "showposts=7&";
			}
			if(themify_get('setting-footer_slider_display',null,true) === 'images'){

				$options = array('one','two','three','four','five','six','seven','eight','nine','ten');
				foreach($options as $option){
					$option = 'setting-footer_slider_images_'.$option;
					if(themify_check($option.'_image',true)){
						echo '<div class="tf_lazy tf_swiper-slide">';
							$title=themify_get($option.'_title','',true);
							$title = function_exists( 'icl_t' )? icl_t('Themify', $option.'_title', $title) : $title;
							$image = themify_get($option.'_image','',true);
							$alt = $title? $title : $image;
							$img=themify_get_image(array('src'=>$image,'w'=>$img_width,'h'=>$img_height,'alt'=>$alt,'class'=>'feature-img','is_slider'=>true));
							if(themify_check($option.'_link',true)){
								$link = themify_get($option.'_link','',true);
								$title_attr = $title? "title='$title'" : "title='$image'";
								echo "<div class='slide-feature-image'><a href='$link' $title_attr>" . $img. '</a></div>';
								echo $title? '<div class="slide-content-wrap"><h3 class="slide-post-title"><a href="'.$link.'" '.$title_attr.'>'.$title.'</a></h3></div>' : '';
							} else {
								echo "<div class='slide-feature-image'>" . $img . '</div>';
								echo $title? '<div class="slide-content-wrap"><h3 class="slide-post-title">'.$title.'</h3></div>' : '';
							}
						echo '</div>';
					}
				}
			} else {
				query_posts($num_posts.$cat);

				if( have_posts() ) {

					while ( have_posts() ) : the_post(); ?>

						<?php $link = themify_permalink_attr(array(),false); 
	$link=$link['href']; ?>

                    	<div class="tf_lazy tf_swiper-slide">
							<div class='slide-feature-image'>
								<a href="<?php echo $link; ?>">
									<?php echo themify_get_image(array('w'=>$img_width,'h'=>$img_height,'class'=>'feature-img','is_slider'=>true)); ?>
								</a>
							</div>
							<!-- /.slide-feature-image -->

						<div class="slide-content-wrap">

							<?php if($hasTitle !== 'yes'): ?>
								<h3 class="slide-post-title"><a href="<?php echo $link; ?>" tabindex="-1"><?php the_title(); ?></a></h3>
							<?php endif; ?>

							<?php if($display === 'content'): ?>
								<div class="slide-excerpt">
								<?php the_content(); ?>
								</div>
							<?php elseif( $display === 'none'): ?>
									<?php //none ?>
							<?php else: ?>
								<div class="slide-excerpt">
								<?php the_excerpt(); ?>
								</div>
							<?php endif; ?>

						</div>
						<!-- /.slide-content-wrap -->

                 		</div>
               			<?php
					endwhile;
				}

				wp_reset_query();

			}
			?>
		</div>
        </div>
      	<?php themify_footer_slider_end(); //hook ?>
	</div>
	<!-- /#slider -->
    <?php themify_footer_slider_after(); //hook ?>

<?php } ?>
