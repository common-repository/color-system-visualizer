<?php
if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/*
* Add Color palette post type and register texonomy
*/
function cpm_register_color_paletter_post_type() {
	$labels = array(
		'name'                => __( 'Color System Visualizer', 'color-system-visualizer' ),
		'singular_name'       => __( 'Color System', 'color-system-visualizer' ),
		'menu_name'           => __( 'Color Systems', 'color-system-visualizer' ),
		'parent_item_colon'   => __( 'Parent Color System', 'color-system-visualizer' ),
		'all_items'           => __( 'All Colors', 'color-system-visualizer' ),
		'view_item'           => __( 'View Color', 'color-system-visualizer' ),
		'add_new_item'        => __( 'Add New Color', 'color-system-visualizer' ),
		'add_new'             => __( 'Add New', 'color-system-visualizer' ),
		'edit_item'           => __( 'Edit Color', 'color-system-visualizer' ),
		'update_item'         => __( 'Update Color', 'color-system-visualizer' ),
		'search_items'        => __( 'Search Colors', 'color-system-visualizer' ),
		'not_found'           => __( 'Not found', 'color-system-visualizer' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'color-system-visualizer' )
	);

	$args = array(
		'label'               => __( 'color', 'color-system-visualizer' ),
		'description'         => __( 'Color Systems', 'color-system-visualizer' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'revisions' ),
		'public'              => true,
		'hierarchical'        => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'has_archive'         => 'color',
		'can__xport'          => true,
		'exclude_from_search' => false,
		'query_var'			  => false,
	    'yarpp_support'       => true,
		'taxonomies' 	      => array( 'post_tag' ),
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
		'rewrite' => array( 'slug' => 'color/%color-palette%', 'with_front' => false ),
	);

	register_post_type( 'color', $args );
}

add_action( 'init', 'cpm_register_color_paletter_post_type', 2 );

/*Register texonomy to Color Palette Post type*/

function cpm_register_color_paletter_taxonomy() {
 
	$labels = array(
		'name' => __( 'Color Palettes', 'color-system-visualizer' ),
		'singular_name' => __( 'Color Palettes', 'color-system-visualizer' ),
		'search_items' =>  __( 'Search Color palettes', 'color-system-visualizer' ),
		'all_items' => __( 'All Color Palettes', 'color-system-visualizer' ),
		'parent_item' => __( 'Parent Color System', 'color-system-visualizer' ),
		'parent_item_colon' => __( 'Parent Color System:' ),
		'edit_item' => __( 'Edit Color System', 'color-system-visualizer' ), 
		'update_item' => __( 'Update Color System', 'color-system-visualizer' ),
		'add_new_item' => __( 'Add New Color System', 'color-system-visualizer' ),
		'new_item_name' => __( 'New Color System Name', 'color-system-visualizer' ),
		'menu_name' => __( 'Color System', 'color-system-visualizer' ),
	); 	

	register_taxonomy( 'color-palette', array( 'color' ), array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => true,
		'show_admin_column' => true,
		'query_var' => false,
		'rewrite' => array( 'slug' => 'color-palette', 'with_front' => false ),
		) );
	}

add_action( 'init', 'cpm_register_color_paletter_taxonomy', 2 );


/** filter Color palette URL link for post type url **/
add_filter( 'post_type_link', 'cpm_color_palette_permalink_structure', 1, 2 );
function cpm_color_palette_permalink_structure( $post_link, $post ) {
    if ( is_object( $post ) && $post->post_type == 'color' ) {
        $cpm_terms = wp_get_object_terms( $post->ID, 'color-palette' );
        if( $cpm_terms ) {
            return str_replace( '%color-palette%' , $cpm_terms[0]->slug , $post_link );
        }
    }
    return $post_link;
}

/* On plugin active register color palette post type and texonomy */
register_activation_hook( __FILE__, 'cpm_register_color_paletter_post_type' );
register_activation_hook( __FILE__, 'cpm_register_color_paletter_taxonomy' );