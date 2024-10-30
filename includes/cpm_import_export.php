<?php
if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 * Display callback for the submenu page for import export functionality.
 */
function cpm_import_export_func() {
    ?>
    <div id="cpm_update" class="notice notice-success" style="display: none;"></div>
    <div id="cpm_notice" class="notice notice-warning" style="display: none;"></div>
    <div id="cpm_insert" class="notice notice-success" style="display: none;"></div>
    <div class="wrap">
       <table>
            <tr>
                <td>
                    <div class="cpm_import">
                        <h2><?php _e( 'Import color palettes', 'color-system-visualizer' ); ?></h2>
                        <form action="" id="cpm_import_form" method="POST" enctype="multipart/form-data">
                            <?php wp_nonce_field('ajax_file_nonce', 'cpm_csv_security'); ?>
                            <input type="file" name="cpm_import_color" id="cpm_import_color" required="required" accept=".csv">
                            <input type="hidden" name="ajaxurl" id="ajaxurl" value="<?php echo admin_url( 'admin-ajax.php' ); ?>">
                            <input type="submit" name="cpm_submit" id="cpm_submit" value="<?php _e( 'Import color palettes', 'color-system-visualizer' ); ?>">
                        </form>
                        <hr>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="cpm_export">
                        <h2><?php _e( 'Export color palettes sample', 'color-system-visualizer' ); ?></h2>
                        <p><a class="cpm_sample_export" href="<?php echo plugin_dir_url( __FILE__ ); ?>demo_csv/demo.csv"><?php _e( 'Export Color Palette Sample CSV', 'color-system-visualizer' ); ?></a></p>
                        <hr>
                        <p><em><strong><?php _e( 'Tip:', 'color-system-visualizer' );?></strong><br>
                            <?php _e( 'If you want to create a database for RAL Classic, a good starting point is the "RAL Standard Color Table (CSV)" which can be downloaded for free at GitHub:', 'color-system-visualizer' );?><br>
                            <a href="https://gist.github.com/lunohodov/1995178">https://gist.github.com/lunohodov/1995178</a></em></p>
                    </div>
                </td>
            </tr>
       </table>
        <div id="cpm_loader" style="position: fixed;left: 0px;top: 0px;width: 100%;height: 100%;z-index: 9999;background: url('<?php echo plugin_dir_url( __FILE__ ); ?>images/loading.gif') 50% 50% no-repeat rgb(249,249,249);opacity: .8; display: none;"></div>
    </div>
    <?php
}
?>