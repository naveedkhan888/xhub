<?php

/* admin style */
if ( ! function_exists( 'restobar_custom_wp_admin_style' ) ) :
    function restobar_custom_wp_admin_style() {
        wp_register_style( 'restobar_custom_wp_admin_css', get_template_directory_uri() . '/inc/backend/css/admin-style.css', false, '1.0.0' );
        wp_enqueue_style( 'restobar_custom_wp_admin_css' );
        
        wp_enqueue_script( 'restobar_custom_wp_admin_js', get_template_directory_uri()."/inc/backend/js/admin-script.js", array( 'jquery' ), '1.0.0', true );
        wp_enqueue_script( 'restobar_custom_wp_admin_js' );
    }
    add_action( 'admin_enqueue_scripts', 'restobar_custom_wp_admin_style' );
endif;

/* upload SVG file */

//add_filter('upload_mimes', 'restobar_mime_types', 10, 1);

/**
 * add group fonts
 */
add_filter( 'elementor/fonts/groups', function( $font_groups ) {
  $font_groups['restobar_fonts'] = __( 'Restobar Fonts', 'restobar' );
  return $font_groups;
} );

/* Filters the fonts used by Elementor to add additional fonts. */
add_filter( 'elementor/fonts/additional_fonts', function ( $additional_fonts ) {
  $additional_fonts['DM Sans'] = 'restobar_fonts';
  return $additional_fonts;
} );