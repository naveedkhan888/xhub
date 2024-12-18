<!-- #site-header-open -->
<header id="site-header" class="site-header <?php xhub_header_class(); ?>">

    <!-- #header-desktop-open -->
    <?php xhub_header_builder(); ?>
    <!-- #header-desktop-close -->

    <!-- #header-mobile-open -->
    <?php xhub_mobile_builder(); ?>
    <!-- #header-mobile-close -->

</header>
<!-- #site-header-close -->
<!-- #side-panel-open -->
<?php if ( !empty( xhub_get_option('is_sidepanel') ) && xhub_get_option('sidepanel_layout') != '' ) { ?>
    <div id="side-panel" class="side-panel <?php if( xhub_get_option('panel_left') ) echo 'on-left'; ?>">
        <a href="#" class="side-panel-close"><i class="xp-webicon-cancel"></i></a>
        <div class="side-panel-block">
            <?php if ( did_action( 'elementor/loaded' ) ) xhub_sidepanel_builder(); ?>	
        </div>
    </div>
<?php } ?>
<!-- #side-panel-close -->