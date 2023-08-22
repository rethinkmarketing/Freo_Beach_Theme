

<?php get_template_part( 'includes/footer-slider'); ?>

	<?php themify_layout_after(); //hook ?>
	</div>
	<!-- /body -->
		
	<div id="footerwrap">
    
    	<?php themify_footer_before(); //hook ?>
		<footer id="footer" class="pagewidth tf_clearfix" itemscope="itemscope" itemtype="https://schema.org/WPFooter" role="contentinfo">
        	<?php themify_footer_start(); //hook ?>

			<?php get_template_part( 'includes/footer-widgets'); ?>
	
			<nav class="footer-nav-wrap" aria-label="<?php _e( 'Footer Navigation', 'themify' ); ?>">
				<p class="back-top"><a href="#header">&uarr;</a></p>
			
				<?php themify_menu_nav(array('theme_location' => 'footer-nav' , 'fallback_cb' => '' , 'container'  => '' , 'menu_id' => 'footer-nav' , 'menu_class' => 'footer-nav')); ?>
			</nav>
			<!-- /footer-nav-wrap -->
	
			<div class="footer-text tf_clearfix">
				<?php themify_the_footer_text(); ?>
				<?php themify_the_footer_text('right'); ?>
			</div>
			<!-- /footer-text --> 

			<?php themify_footer_end(); //hook ?>
		</footer>
		<!-- /#footer --> 
        <?php themify_footer_after(); //hook ?>
        
	</div>
	<!-- /#footerwrap -->
	
</div>
<!-- /#pagewrap -->


<?php themify_body_end(); // hook ?>
<!-- wp_footer -->
<?php wp_footer(); ?>

</body>
</html>