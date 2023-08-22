<?php
get_header();
if (is_front_page() && !is_paged()) { 
    get_template_part( 'includes/header-slider'); 
} 
?>
<!-- layout-container -->
<div id="layout" class="tf_clearfix pagewidth">
    <!-- contentwrap -->
    <div id="contentwrap">
	<?php themify_content_before(); //hook  ?>
	<!-- content -->
	<main id="content" class="tf_clearfix">
	    <?php themify_page_output(); ?>
	</main>
	<!--/content -->
	<?php themify_content_after() //hook;  ?>
    </div>
    <!-- /contentwrap -->
    <?php themify_get_sidebar(); ?>
</div>
<!-- layout-container -->
<?php
get_footer();
