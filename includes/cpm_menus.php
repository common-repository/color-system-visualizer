<?php
if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 * Adds a submenu page under a custom post type parent.
 */
function cpm_color_add_submenu_page() {
    add_submenu_page(
        'edit.php?post_type=color',
        __( 'Import/Export Color Palettes', 'color-system-visualizer' ),
        __( 'Import/Export Color Palettes', 'color-system-visualizer' ),
        'manage_options',
        'cpm_import_export',
        'cpm_import_export_func'
    );
    add_submenu_page(
        'edit.php?post_type=color',
        __( 'Plugin setting', 'color-system-visualizer' ),
        __( 'Plugin setting', 'color-system-visualizer' ),
        'manage_options',
        'cpm_plugin_settings',
        'cpm_plugin_settings_page'
    );
}
add_action('admin_menu', 'cpm_color_add_submenu_page');

/* Register plugin settings page fields */

function register_cpm_plugin_settings() {
	//register our settings
	register_setting( 'cpm_plugin_settings', 'cpm_load_btstrp' );
}

add_action( 'admin_init', 'register_cpm_plugin_settings' );
?>