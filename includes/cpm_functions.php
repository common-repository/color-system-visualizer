<?php 
if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 * Write functions here
 */

/* Add action for ajax use to get post*/
add_action( 'wp_ajax_cpm_get_post', 'cpm_get_post' );
add_action( 'wp_ajax_nopriv_cpm_get_post', 'cpm_get_post' );

/* function to get post by id */
function cpm_get_post() {
	global $wpdb;
	if( ( $_POST['action'] == 'cpm_get_post' ) && ( !empty( $_POST['pId'] ) ) ) {

		/* Post content by post id*/
		$my_postid 					= $_POST['pId'];
		$content_post 				= get_post($my_postid);
		$pcontent 					= $content_post ->post_content; // Post Content
		$ptitle 					= $content_post ->post_title; // Post Title
		$pfeatured_image    		= '';

		/* Get featured image */
		if ( has_post_thumbnail( $my_postid ) ): 
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $my_postid ), 'single-post-thumbnail' ); 
		  		$pfeatured_image 	=  $image[0];
		   endif;

	   echo'<div class="cpm_post_details">
				<div class="col-md-3 col-md-3 col-xs-12">
					<div class="cpm_featured_color" style="background-color:#'.get_post_meta( $my_postid, "cpm_color_hex", TRUE ).'">
						<img src="'.$pfeatured_image .'"/>
					</div>
				</div>
				<div class="col-md-9 col-sm-9 col-xs-12">
					<div class="cpm_title"><h3><a href="'.get_permalink( $my_postid ).'">'.$ptitle .'</a></h3></div>							
					<div class="cpm_content">'.$pcontent .'</div>
				</div>
			</div>';
	}
	wp_die();
}

add_action( 'wp_ajax_cpm_import_csv_function', 'cpm_import_csv_function' );
/*add_action('wp_ajax_nopriv_cpm_import_csv_function', 'cpm_import_csv_function');*/

/* Import function */
function cpm_import_csv_function() {
    
    check_ajax_referer('ajax_file_nonce', 'cpm_csv_security');
    global $wpdb;
    //  the post creation _only_ happens when you want it to.
    if ( ( !isset( $_GET["post_type"] ) ) && ( (!empty( $_GET['post_type'] )) && ( $_GET['post_type'] != 'color') ) && ( !isset( $_GET["page"] ) ) && ( $_GET['page'] != 'cpm_import_export' ) ) {
        	return;
    	}
    
    if( ( !empty($_FILES["cpm_import_color"]["name"] ) ) ){
        
    $filename =$_FILES["cpm_import_color"]["tmp_name"]; 
    if( $_FILES["cpm_import_color"]["size"] > 0 )
    {
        $allowedColNum   = 10;
        $row             = 1;
        $insertedId      = array();
        $UpdatedId       = array();
        $file            = fopen( $filename, "r" );        
        
        while ( ( $getData = fgetcsv( $file, 100000, "," ) ) !== FALSE )
        {
            if( $row == 1 ){ $row++; continue; }
            $row++;
            
            // Get category id by category name
            $categories         = get_term_by('name', $getData[9], 'color-palette');
            // Check if category exists and insert category if not exists
            $cpm_term_exists    = term_exists( $getData[9], 'color-palette');
            if ( 0 == $cpm_term_exists && null == $cpm_term_exists ) {
                wp_insert_term( $getData[9] ,'color-palette' );
            } 

            $postTitle          = $getData[0];
            $content            = $getData[1];
            $type               = 'color';
            $status             = 'publish';
            /*$post_category      = array( 7,8 );*/
            $cpm_color_name_de  = $getData[2];
            $cpm_color_name_en  = $getData[3];
            $cpm_color_hex      = $getData[4];
            $cpm_color_rgb      = $getData[5];
            $cpm_color_cmyk     = $getData[6];
            $cpm_color_lab      = $getData[7];
            $cpm_meta_arr       =  array( 'cpm_color_name_de' => $cpm_color_name_de, 'cpm_color_name_en' => $cpm_color_name_en, 'cpm_color_hex' => $cpm_color_hex, 'cpm_color_rgb' => $cpm_color_rgb, 'cpm_color_cmyk' => $cpm_color_cmyk, 'cpm_color_lab' => $cpm_color_lab );
            $cpm_thumb_img_url  = $getData[8];
            //Query to create color palettes posts
            $cpm_new_post = array(
                'post_title'        => $postTitle,
                'post_content'      => $content,
                'post_type'         => $type,
                'post_status'       => $status,
                'post_author'       => get_current_user_id(),
                /*'post_category'     => $post_category,*/
                'meta_input'        => $cpm_meta_arr
            );
            
            //Query to check if post already exists
            $query = $wpdb->prepare(
                'SELECT ID FROM ' . $wpdb->posts . '
                WHERE post_title = %s
                AND post_type = \'color\'',
                $postTitle
            );
            $wpdb->query( $query );

            //Update records if post already exists
            if ( $wpdb->num_rows ) {
                $post_id            = $wpdb->get_var( $query );
                $IDarr              = array( 'ID' => $post_id );
                $cpm_new_post       =  array_merge( $IDarr, $cpm_new_post );
                $post_id            = wp_update_post( $cpm_new_post );
                if( !empty( $categories ) ){
                    wp_set_post_terms( $post_id, array( $categories->term_id ) , 'color-palette' );
                }                     
                $UpdatedId[]        = $post_id;
                $cpm_notice_class   = 'notice notice-warning';
                $cpm_notice_message = __('Already exists color Palettes will be Updated !!', 'color-system-visualizer' );
            } else {
            //Insert Post new posts
                $post_id = wp_insert_post( $cpm_new_post );

                 $cat               = get_term_by( 'name', $getData[9], 'color-palette' );
                if( !empty( $cat ) ) {
                    wp_set_post_terms( $post_id, array( $cat->term_id ) , 'color-palette' );    
                }
                $insertedId[]       = $post_id;
                $cpm_notice_class   = 'notice notice-success';
                $cpm_notice_message = __( 'New Color Palettes imported !!', 'color-system-visualizer' );
            }
            //Set featured image for posts
            cpm_Generate_Featured_Image( $cpm_thumb_img_url, $post_id, '' );
        }
        //Count updated posts
        if(!empty($UpdatedId)){
            $TotalId 			= count($UpdatedId);
            $UpdatedClass   	=  'notice notice-success';
            $UpdatedMessage 	= sprintf( __( '%s Color palettes Updated !!', 'color-system-visualizer' ),$TotalId );
            /*new AdminNotice( $UpdatedClass , $UpdatedMessage );*/
            $results['UpdatedMessage'] = $UpdatedMessage;
        }


        //Count inserted posts
        if(!empty( $insertedId )){
            $TotalId            = count($insertedId);
            $InsertedClass      =  'notice notice-success';
            $InsertedMessage    = sprintf( __( '%s Color palettes Inserted !!', 'color-system-visualizer' ),$TotalId );
            /*new AdminNotice( $InsertedClass , $InsertedMessage );*/
            $results['InsertedMessage'] = $InsertedMessage;
        }
        //Generate admin notices
        $results['NoticeMessage'] = $cpm_notice_message;

        /*new AdminNotice( $cpm_notice_class , $cpm_notice_message ); */ 

        $upload                 = wp_upload_dir();
        $upload_dir             = $upload['basedir'];
        $upload_dir             = $upload_dir . '/cpm_csv';

        //Create folder if not exists
        if ( !is_dir( $upload_dir ) ) { mkdir( $upload_dir, 0755 ); }

        //Move file to uploads/cpm_csv directory.
        $source                 = $_FILES['cpm_import_color']['tmp_name'];
        $fileName               = pathinfo($_FILES["cpm_import_color"]["name"]);
        $fileName               = $fileName['filename'].'_'.time().'.'.$fileName['extension'];
        $destination            = trailingslashit( $upload_dir ) . $fileName;
        move_uploaded_file( $source, $destination );
        // Close file
        fclose( $file );
        echo json_encode( $results );
        wp_die();
    }
  }
}

/* Generate Freatured Image */
function cpm_Generate_Featured_Image( $file, $post_id, $desc= '' ){
    // Set variables for storage, fix file filename for query strings.
    preg_match( '/[^\?]+\.(jpe?g|jpe|gif|png)\b/i', $file, $matches );
    if ( ! $matches ) {
         return new WP_Error( 'image_sideload_failed', __( 'Invalid image URL' ) );
    }

    $file_array             = array();
    $file_array['name']     = basename( $matches[0] );

    // Download file to temp location.
    $file_array['tmp_name'] = download_url( $file );

    // If error storing temporarily, return the error.
    if ( is_wp_error( $file_array['tmp_name'] ) ) {
        return $file_array['tmp_name'];
    }

    // Do the validation and storage stuff.
    $id = media_handle_sideload( $file_array, $post_id, $desc );

    // If error storing permanently, unlink.
    if ( is_wp_error( $id ) ) {
        @unlink( $file_array['tmp_name'] );
        return $id;
    }
    return set_post_thumbnail( $post_id, $id );
}
 ?>