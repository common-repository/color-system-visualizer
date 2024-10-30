<?php
if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/* Filter Color Palette single page */

add_filter( 'single_template', 'cpm_color_palette_single_template' );

function cpm_color_palette_single_template($single) {

    global $post;

    /* Checks for single template by post type */
    if ( $post->post_type == 'color' ) {
        if ( file_exists( get_stylesheet_directory() . '/cpm-single-template.php' ) ) {
            return get_stylesheet_directory() . '/cpm-single-template.php';
        } else if ( file_exists( plugin_dir_path( __FILE__ ) . 'cpm-single-template.php' ) ) {
            return plugin_dir_path( __FILE__ ) . 'cpm-single-template.php';
        }
    }
    return $single;
}

/* Filter Color Palette Archive Page */

add_filter( 'archive_template', 'get_cpm_color_palette_archive_template' ) ;

function get_cpm_color_palette_archive_template( $archive_template ) {
    global $post;

    if ( ( is_archive () ) && ( ( $post->post_type == 'color' ) ) ) {
        if ( file_exists( get_stylesheet_directory() . '/cpm-archive-template.php' ) ) {
            $archive_template = get_stylesheet_directory() . '/cpm-archive-template.php';
        } else if ( file_exists( plugin_dir_path( __FILE__ ) . 'cpm-archive-template.php' ) ) {
            $archive_template = plugin_dir_path( __FILE__ ) . 'cpm-archive-template.php';
        }

        return $archive_template;
    }

    return $archive_template;
}

function cpm_wpsites_query( $query ) {
    global $post;

        if ( $query->is_tax( 'color-palette' ) && $query->is_main_query() ) {
                $query->set( 'posts_per_page', -1 );
            }
}
add_action( 'pre_get_posts', 'cpm_wpsites_query' );
?>