<?php
if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/* function to show plugin options page */
function cpm_plugin_settings_page() {
	?>
	<div class="wrap">
		<h1> <?php _e( 'Color palette plugin settings', 'color-system-visualizer' ); ?></h1>
		<?php settings_errors(); ?>
		<form method="post" action="options.php">
		    <?php 	settings_fields( 'cpm_plugin_settings' );
					do_settings_sections( 'cpm_plugin_settings' ); 
			?>
		    <table class="form-table">
		        <tr valign="top">
			        <th scope="row"> <?php _e( 'Load bootstrap files', 'color-system-visualizer' ); ?></th>
			        <td>
			        	<input type="radio" name="cpm_load_btstrp" value="yes" <?php echo (esc_attr( get_option( 'cpm_load_btstrp' ) == 'yes')) ? 'checked' : ''; ?>  /><?php  _e( 'Yes' ) ?>
			        	<input type="radio" name="cpm_load_btstrp" value="no" <?php echo ( ( esc_attr(  get_option( 'cpm_load_btstrp' ) == 'no')) || ( esc_attr( get_option( 'cpm_load_btstrp' ) == '' ) )) ? 'checked' : ''; ?>/> <?php _e( 'No' ); ?>
			        </td>
		        </tr>
		    </table>
		    <?php submit_button(); ?>
		</form>
	</div>
<?php
}
?>