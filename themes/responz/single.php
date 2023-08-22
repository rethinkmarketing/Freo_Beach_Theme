<?php get_header(); ?>
<!-- layout-container -->
<div id="layout" class="tf_clearfix pagewidth">
    <?php
    if (have_posts()) {
	the_post();
    ?>
        <!-- contentwrap -->
        <div id="contentwrap">
	    <?php themify_content_before(); //hook  ?>
	    <!-- content -->
	    <main id="content" class="tf_clearfix">
		<?php
		themify_content_start(); //hook 

		get_template_part('includes/loop');

		wp_link_pages(array('before' => '<p class="post-pagination"><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number'));

		get_template_part('includes/author-box', 'single');

		get_template_part('includes/post-nav');

		themify_comments_template();

		themify_content_end(); //hook 	
		?>
	    </main>
	    <!--/content -->
	    <?php themify_content_after() //hook;   ?>
        </div>
        <!-- /contentwrap -->
    <?php
    }
    themify_get_sidebar();
    ?>
</div>
<!-- layout-container -->
<?php
get_footer();
