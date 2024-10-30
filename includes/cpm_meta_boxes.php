<?php
if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/*
* Add meta box for Color palette post type
*/
function cpm_adding_meta_cpm_color_palette( $post ) {
    add_meta_box( 
        'cpm_color_palette_meta_box',
        __( 'Color Palette Manager Custom Fields', 'color-system-visualizer' ),
        'cpm_show_color_pelette_fields',
        'color',
        'normal',
        'default'
    );
}
add_action( 'add_meta_boxes_color', 'cpm_adding_meta_cpm_color_palette', 10, 2 );

function cpm_show_color_pelette_fields( $object ) {
     wp_nonce_field(basename(__FILE__), "cpm_meta-box-nonce");
    ?>
    	<table class="form-table ">
    		 <tr>
		        <td>
		        	<label for="cpm_color_name_de"><?php _e( 'Color name German', 'color-system-visualizer' ); ?></label>
		        </td>
		        <td>
		        	<input name="cpm_color_name_de" type="text" id="cpm_color_name_de" value="<?php echo get_post_meta( $object->ID, "cpm_color_name_de", true ); ?>" placeholder="<?php _e( 'Anthrazitgrau', 'color-system-visualizer' ); ?>">
		        </td>
	        </tr>
	        <tr>
		        <td>
		        	<label for="cpm_color_name_en"><?php _e( 'Color name English', 'color-system-visualizer' ); ?></label>
		        </td>
		        <td>
		        	<input name="cpm_color_name_en" type="text" id="cpm_color_name_en" value="<?php echo get_post_meta( $object->ID, "cpm_color_name_en", true ); ?>" placeholder="<?php _e( 'Anthracite grey', 'color-system-visualizer' ); ?>">
		        </td>
	        </tr>
            <tr>
                <td>
                    <label for="cpm_color_hex"><?php _e( 'Color Hex', 'color-system-visualizer' ); ?></label>
                </td>
                <td>
                    <input name="cpm_color_hex" type="text" id="colorpicker-full" value="<?php echo get_post_meta( $object->ID, "cpm_color_hex", true ); ?>" placeholder="<?php _e( '#383e42', 'color-system-visualizer' ); ?>">
                </td>
            </tr>
	        <tr>
		        <td>
		        	<label for="cpm_color_rgb"><?php _e( 'Color RGB', 'color-system-visualizer' ); ?></label>
		        </td>
		        <td>
		        	<input name="cpm_color_rgb" type="text" id="cpm_color_rgb" value="<?php echo get_post_meta( $object->ID, "cpm_color_rgb", true ); ?>" placeholder="<?php _e( ' 56; 62; 66', 'color-system-visualizer' ); ?>">
		        </td>
		        </br>
	        </tr>
	        <tr>
		        <td>
		        	<label for="cpm_color_cmyk"><?php _e( 'Color CMYK', 'color-system-visualizer' ); ?></label>
		        </td>
		        <td>
		        	<input name="cpm_color_cmyk" type="text" id="cpm_color_cmyk" value="<?php echo get_post_meta( $object->ID, "cpm_color_cmyk", true ); ?>" placeholder="<?php _e( '60; 30; 20; 80', 'color-system-visualizer' ); ?>">
		        </td>
	        </tr>
	        <tr>
		        <td>
		        	<label for="cpm_color_lab"><?php _e( 'Color Lab', 'color-system-visualizer' ); ?></label>
		        </td>
		        <td>
		        	<input name="cpm_color_lab" type="text" id="cpm_color_lab" value="<?php echo get_post_meta( $object->ID, "cpm_color_lab", true ); ?>" placeholder="<?php _e( '25,93; −1,85; −3,40', 'color-system-visualizer' ); ?>">
		        </td>
	        </tr>	        
	    </table>
    <?php  
}

/* Save Color paletter post type meta box values */

function cpm_save_color_pelette_meta_box_fields($post_id, $post, $update)
{
    if ( !isset( $_POST["cpm_meta-box-nonce"] ) || !wp_verify_nonce( $_POST["cpm_meta-box-nonce"], basename(__FILE__) ))
        return $post_id;

    if( !current_user_can( "edit_post", $post_id ))
        return $post_id;

    if( defined( "DOING_AUTOSAVE" ) && DOING_AUTOSAVE )
        return $post_id;

    $slug = "color";
    if( $slug != $post->post_type )
        return $post_id;

    $cpm_color_name_en_value	= "";
    $cpm_color_name_de_value	= "";
    $cpm_color_rgb_value		= "";
    $cpm_color_cmyk_value		= "";
    $cpm_color_lab_value		= "";
    $cpm_color_hex_value		= "";

    if( isset( $_POST["cpm_color_name_de"] ))
    {
        $cpm_color_name_de_value = sanitize_text_field( $_POST["cpm_color_name_de"] );
    }
    update_post_meta( $post_id, "cpm_color_name_de", $cpm_color_name_de_value );

    if( isset( $_POST["cpm_color_name_en"] ))
    {
        $cpm_color_name_en_value = sanitize_text_field( $_POST["cpm_color_name_en"] );
    }  
    update_post_meta( $post_id, "cpm_color_name_en", $cpm_color_name_en_value );

    if( isset( $_POST["cpm_color_rgb"] ))
    {
        $cpm_color_rgb_value = sanitize_text_field( $_POST["cpm_color_rgb"] );
    }   
    update_post_meta( $post_id, "cpm_color_rgb", $cpm_color_rgb_value );

    if( isset( $_POST["cpm_color_cmyk"] ))
    {
        $cpm_color_cmyk_value = sanitize_text_field( $_POST["cpm_color_cmyk"] );
    }   
    update_post_meta( $post_id, "cpm_color_cmyk", $cpm_color_cmyk_value );

    if( isset( $_POST["cpm_color_lab"] ))
    {
        $cpm_color_lab_value = sanitize_text_field( $_POST["cpm_color_lab"] );
    }   
    update_post_meta( $post_id, "cpm_color_lab", $cpm_color_lab_value );

    if( isset( $_POST["cpm_color_hex"] ))
    {
        $cpm_color_hex_value = sanitize_text_field( $_POST["cpm_color_hex"] );
    }   
    update_post_meta( $post_id, "cpm_color_hex", $cpm_color_hex_value );
}

add_action( "save_post", "cpm_save_color_pelette_meta_box_fields", 10, 3 );
?>