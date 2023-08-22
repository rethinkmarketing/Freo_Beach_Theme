<?php if(!is_single()) { global $more; $more = 0; } //enable more link ?>
<?php
/** Themify Default Variables
 *  @var object */
global $themify; ?>

<?php themify_post_before(); //hook ?>
<article id="post-<?php the_id(); ?>" <?php post_class("post clearfix " . $themify->get_categories_as_classes(get_the_id())); ?>
	<?php themify_post_start(); // hook ?>

	<?php themify_post_media(); ?>
	<div class="gallery-section">
	<?php if( get_field('gallery_shortcode') ) {
  
   echo do_shortcode(get_field('gallery_shortcode'));
   
} ?>
	</div>

	<div class="post-content">

	<div class="col3-2 first property-desc">
		<div class="property-header">
			<div class="col3-2 first">
				<?php if($themify->hide_title != "yes"): ?>
					<?php themify_before_post_title(); // Hook ?>
					<?php if($themify->unlink_title == "yes"): ?>
						<h1 class="post-title entry-title" <?php themify_schema_markup(array('markup' => 'title'));?>><?php the_title(); ?></h1>
					<?php else: ?>
						<h1 class="post-title entry-title"><a href="<?php echo themify_get_featured_image_link(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
					<?php endif; //unlink post title ?>
					<?php themify_after_post_title(); // Hook ?>
				<?php endif; //post title ?>
			</div>
			<div class="col3-1 last">
				<?php
				if(get_field('number_of_rooms')){
					echo '<span class="rooms">'.get_field('number_of_rooms').'<i class="fa fa-bed"></i></span>';
				}
				?>
				<?php
				if(get_field('number_of_bathrooms')){
					echo '<span class="bathrooms">'.get_field('number_of_bathrooms').'</span>';
				}
				?>
				
			</div>
			<div class="clear"></div>
		</div>
		

		<div class="entry-content col3-2 first" >

		<?php if ( 'excerpt' == $themify->display_content && ! is_attachment() ) : ?>

			<?php the_excerpt(); ?>

			<?php if( themify_check('setting-excerpt_more') ) : ?>
				<p><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute('echo=0'); ?>" class="more-link"><?php echo themify_check('setting-default_more_text')? themify_get('setting-default_more_text') : __('More &rarr;', 'themify') ?></a></p>
			<?php endif; ?>

		<?php elseif ( 'none' == $themify->display_content && ! is_attachment() ) : ?>

		<?php else: ?>

			<?php the_content(themify_check('setting-default_more_text')? themify_get('setting-default_more_text') : __('More &rarr;', 'themify')); ?>

		<?php endif; //display content ?>
		<div class="single-the-area">
		<?php
			if(get_field('area_description')){
				echo '<h2 class="the-area">The Area</h2>';
				echo get_field('area_description');
			}
		?>
		</div>
		</div><!-- /.entry-content -->
		<div class="col3-1 last room-config">
		<?php
			// check if the repeater field has rows of data
			if( have_rows('sleeping_configuration') ):
			    echo '<h3 class="sleep-config">Sleeping Configuration</h3>';
			 	// loop through the rows of data
			    while ( have_rows('sleeping_configuration') ) : the_row();
			
			        // display a sub field value
			        echo '<span>'.get_sub_field('room_description').'</span>';
			
			    endwhile;
			
			else :
			
			    // no rows found
			
			endif;
		?>	<?php
			if(get_field('rates_text')){
				echo '<h3 class="property-rate">Rates</h3>';
				echo get_field('rates_text');
			}
		?></div>
		

		<div class="clear"></div>
		

		<?php edit_post_link(__('Edit', 'themify'), '<span class="edit-button">[', ']</span>'); ?>
	</div>
	<div class="col3-1 last property-book right">
	
	<?php
			if(get_field('vr_calendar_shortcode')){
				echo '<div class="property-calendar">';
					
					echo do_shortcode(get_field('vr_calendar_shortcode'));
					echo '<em class="book-now"><a href="#" class="popmake-property-booking">Make an enquiry</a></em><br>';
					echo '<p class="book-now-desc"><br>book direct for our exclusive rates</p>';
				echo '</div>';
			}
		?>
		<?php
			if(get_field('map_properties')){
				
				echo '<div class="property-map">';
					echo get_field('map_properties');
					echo '<div class="map-overlay"><div class="map-desc"><i class="fa fa-map-marker"></i><br/>map</div></div>';
				echo '</div>';
				
			}
		?>
	</div>
	<div class="clear"></div>
	</div>
	<!-- /.post-content -->
	<?php themify_post_end(); //hook ?>

	<meta >
	<div class="local-attraction">
	<?php
			$ctr = 0;
			// check if the repeater field has rows of data
			if( have_rows('local_attractions') ):
			 	// loop through the rows of data
			    while ( have_rows('local_attractions') ) : the_row(); 
			    	$ctr++;
			    	if($ctr%4==1 || $ctr==0){
			    		$posclass = 'first';
			    	}elseif($ctr%4==0){
			    		$posclass = 'last';
			    	}else{
			    		$posclass = 'middle';
			    	}
			   
				$image = get_sub_field('local_images');
				$name = get_sub_field('local_name');
				$distance = get_sub_field('local_description');
		
			 ?>
			<div class="col4-1 <?php echo $posclass; ?>">
				<div class="image-attraction">
					<div class="image-content">
						<?php if( !empty($image) ): 
							$size = 'attraction-images';
							echo wp_get_attachment_image( $image['id'], $size ); ?>
							
		
						<?php endif; ?>
					</div>
					<div class="image-desc">
						<div class="image-description">
						<?php
							echo '<h3 class="attraction-name">'.$name.'</h3>';
							if( !empty($distance) ): 
								echo '<span class="distance"><i class="fa fa-bus"></i>'.$distance.'</span>';
							endif;
						?>
						
						</div>
					</div>
				</div>
			</div>
			    
			
	<?php		    endwhile;
			
			else :
			
			    // no rows found
			
			endif;
		?>
		</div class="clear"></div>
	</div>
	<div class="property-testimonial guest-reviews">
	<?php
			if(get_field('testimonial_shortcode')){
				echo '<h3 class="module-title">Guest Reviews</h3>';
				echo do_shortcode(get_field('testimonial_shortcode'));
			}
		?>
	
	
	</div>
</article>
<!-- /.post -->
<?php themify_post_after(); //hook ?>