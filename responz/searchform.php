<form role="search" method="get" id="searchform" action="<?php echo home_url(); ?>/">
	<label for='s' class='screen-reader-text'><?php _e( 'Search', 'themify' ); ?></label> 
	<input type="text" name="s" id="s" value="<?php echo get_search_query(); ?>" />
</form>