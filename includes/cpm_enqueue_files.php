<?php
if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/* Enqueue Scripts for frontend */
function cpm_color_palette_scripts() {

    // Check for current template file name and only enqueue styles + scripts if on a cpm page:
    global $template;
    if ( basename($template) == 'cpm-archive-template.php' || basename($template) == 'cpm-single-template.php' ) :

    	/* Enqueue CSS */
        // check if need to
        if( ( !empty( esc_attr( get_option( 'cpm_load_btstrp' ) ) ) ) && ( esc_attr( get_option( 'cpm_load_btstrp' ) ) == 'yes' ) ) {
            wp_register_style( 'cpm_bootstrap', plugins_url( 'css/bootstrap.min.css',__FILE__ ), false, '3.4.0' );
            wp_enqueue_style( 'cpm_bootstrap' );
        }
        wp_register_style( 'cpm_jquery_dataTables', plugins_url( 'css/jquery.dataTables.min.css',__FILE__ ), true, '1.10.19' );
        wp_enqueue_style( 'cpm_jquery_dataTables' );
        wp_register_style( 'cpm_deafault_css', plugins_url( 'css/cpm_deafault.css',__FILE__ ), true, '1.0.0' );
        wp_enqueue_style( 'cpm_deafault_css' );

        /* Enqueue JS */
        wp_enqueue_script( 'cpm_jquery_dataTables', plugins_url( 'js/jquery.dataTables.min.js',__FILE__ ), array('jquery'), '1.10.19', true );

        // get current language in order to decide which json file for dataTable to load
        switch (get_locale()) {
            case 'de_DE':
            case 'de_DE_formal':
            case 'de_AT':
            case 'de_CH':
                $locale_file = plugins_url( '../languages/dataTables.de_DE.lang', __FILE__ );
                $locale_file = explode(site_url(), $locale_file)[1];
                break;
            
            default:
                $locale_file = plugins_url( '../languages/dataTables.en_GB.lang', __FILE__ );
                $locale_file = explode(site_url(), $locale_file)[1];
                break;
        }
        wp_add_inline_script( 'cpm_jquery_dataTables', 'jQuery(document).ready(function($){jQuery("#cpm_ColorTable").DataTable({"initComplete":function(settings,json){cpmTableListener()},"lengthMenu":[[10, 25, 50, -1],[10, 25, 50, "∞"]],"language":{"url":"' . $locale_file . '",},});});' );
        wp_enqueue_script( 'cpm_default_js', plugins_url( 'js/default.js',__FILE__ ), array('jquery'), '1.0.0', true );

    endif;
}
add_action( 'wp_enqueue_scripts', 'cpm_color_palette_scripts' );

/* Enqueue Scripts for admin */
function cpm_color_palette_admin_scripts() {

	/* Enqueue CSS */
    wp_register_style( 'cpm_jquery.colorpicker_css', plugins_url( 'css/jquery.colorpicker.css',__FILE__ ), false, '1.1.1' );
    wp_enqueue_style( 'cpm_jquery.colorpicker_css' );
	wp_register_style( 'cpm_jquery-ui.min', plugins_url( 'css/jquery-ui.min.css',__FILE__ ), false, '1.12.1' );
    wp_enqueue_style( 'cpm_jquery-ui.min' );

    /* Enqueue JS */
    wp_enqueue_script( 'jquery-ui-core' );
    wp_enqueue_script( 'jquery-ui-draggable' );
    wp_enqueue_script( 'jquery-ui-button' );
    wp_enqueue_script( 'cpm_jquery.colorpicker_js', plugins_url( 'js/jquery.colorpicker.js',__FILE__ ), array('jquery'), '1.1.1', true );
    wp_enqueue_script( 'cpm_admin_default_js', plugins_url( 'js/admin_default.js',__FILE__ ), array('jquery'), '1.0.0', true );
}
add_action( 'admin_enqueue_scripts', 'cpm_color_palette_admin_scripts' );
?>