=== Color System Visualizer ===
Contributors: wsmeu, cleuenberg
Tags: color, colour, color palette, colour palette, color manager, colour manager, color system, colour system, ral, hks, pantone
Requires at least: 
Tested up to: 5.2.2
Stable tag: 1.1.3
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Enhance your WordPress website with a searchable color palette like RAL, HKS or Pantone.

== Description ==

Display all colors of a certain color system (palette) like RAL, HKS or Pantone which can be imported via CSV file. Search for a specific color by it's name or color number. Get detailed information like RGB, CMYK, Lab and Hex values besides optional description and photo.

Features:

*   Custom post type and taxonomy to manage color systems and single colors
*   Color overview with ajax enhanced search
*   Single pages for each color
*   Colors can be imported via CSV file
*   Optional loading of the Bootstrap framework

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/color-system-visualizer` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Go to newly created custom post type "Color Palette".
4. Add new color palette and colors manually or by uploading a CSV file.
5. To edit the templates, simply copy `includes/cpm-archive-template.php` and `includes/cpm-single-template.php` into your theme's main folder, e.g. `your-theme/cpm-archive-template.php`.

== Screenshots ==

== Changelog ==

= 1.1.3 =
* Only enqueue styles and scripts on plugin related pages

= 1.1.2 =
* Bugfixed displaying single color on ajax search
* Changed naming of custom post type and taxonomy
* Added some more german translations

= 1.1.1 =
* Added german language files for jquery.dataTables library

= 1.1 =
* Added custom templating functionality
* Added german language files

= 1.0 =
* Initial release for WordPress plugin directory.