<?php
/*
Plugin Name: Color System Visualizer
Plugin URI: 
Description: Enhance your WordPress website with a searchable color palette like RAL, HKS or Pantone.
Author: WSM – Walter Solbach Metallbau GmbH
Author URI: https://www.wsm.eu/
Version: 1.1.3
Text Domain:
Domain Path: /languages
License: GPLv3

	Color System Visualizer
    Copyright (C) 2019 WSM – Walter Solbach Metallbau GmbH

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program. If not, see <http://www.gnu.org/licenses/>.
*/

/* Include CSS and JS files */

include( plugin_dir_path( __FILE__ ) . 'includes/cpm_enqueue_files.php' );

/* Write functions */

include( plugin_dir_path( __FILE__ ) . 'includes/cpm_functions.php' );

/* Register Color paletter post type */

include( plugin_dir_path( __FILE__ ) . 'includes/cpm_post_type.php' );

/* Add Submenu to color post type */

include( plugin_dir_path( __FILE__ ) . 'includes/cpm_menus.php' );

/* Add plugin settings Page */

include( plugin_dir_path( __FILE__ ) . 'includes/cpm_plugin_options.php' );

/* Import/Export functionality */

include( plugin_dir_path( __FILE__ ) . 'includes/cpm_import_export.php' );

/* Add Metabox to Color paletter post type */

include( plugin_dir_path( __FILE__ ) . 'includes/cpm_meta_boxes.php' );

/* Register archive and single page template for color palette */

include( plugin_dir_path( __FILE__ ) . 'includes/cpm_template_register.php' );

/**
 * Load plugin textdomain.
 *
 */
function cpm_plugin_load_textdomain() {
  load_plugin_textdomain( 'color-system-visualizer', false, basename( dirname( __FILE__ ) ) . '/languages' ); 
}
add_action( 'init', 'cpm_plugin_load_textdomain', 0 );
?>