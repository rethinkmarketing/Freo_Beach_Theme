<?php if(!post_password_required()):?>
    <?php themify_sidebar_before(); //hook ?>
    <aside id="sidebar" itemscope="itemscope" itemtype="https://schema.org/WPSideBar" role="complementary">
                <?php themify_sidebar_start(); //hook ?>

                <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar-main') ); ?>

                <div class="tf_clearfix">
                        <div class="secondary">
                        <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar-main-2a') ); ?>
                        </div>
                        <div class="secondary last">
                        <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar-main-2b') ); ?>
                        </div>
                </div>
                <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar-main-3') ); ?>

                <?php themify_sidebar_end(); //hook ?>
    </aside>
    <!-- /#sidebar -->
    <?php themify_sidebar_after(); //hook ?>
<?php endif;?>