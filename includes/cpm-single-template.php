<?php
if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 * The template for displaying all single posts and attachments
 */
get_header(); ?>
<div class="cpm_content_wrapper">
	<div class="container">
		<div class="row">
			<div class="cpm_backto_archive">
				<?php
				$post_type_data 	= get_post_type_object( 'color' );
			    $post_type_slug 	= $post_type_data->rewrite['slug'];

			    $pID 				= get_the_ID();
				$catSlug 			= get_the_terms( $pID, 'color-palette')[0]->slug ;
				$catName 			= get_the_terms( $pID, 'color-palette')[0]->name ;
				$archiveURL 		= get_site_url()."/color/".$catSlug ;

				/* Fetch all post by post title in asc order */
				$cpm_single_args = array( 'post_type'=>'color', 'numberposts' => -1, 'orderby'=> 'title', 'order' => 'ASC' );
				$cpm_color_posts = get_posts( $cpm_single_args );

				$singlePostID = array();
		         if ( !empty( $cpm_color_posts ) ) {
		              foreach( $cpm_color_posts as $post ) : setup_postdata( $post );
		              $singlePostID[] = get_the_ID();
		              endforeach;
		         }

		         //Count total results
		         $totalPost 		= count( $singlePostID );
		         $totalPostCheck 	= $totalPost - 1;
		         $prevID 			= '';
		         $nextID 			= '';

		        //check if current id exists in array
    			if ( in_array( $pID, $singlePostID ) ) {
    				$key = array_search( $pID ,$singlePostID );
    				if($key != 0) {
    					$prevIDKey 	= $key-1;
    					$prevID 	= $singlePostID[$prevIDKey];
    				}
    				if( $key != $totalPostCheck ){
    					$nextIDKey 	= $key+1;
    					$nextID 	= $singlePostID[$nextIDKey];
    				}
    			}
				?>

					<a class="btn btn-default" href="<?php echo $archiveURL; ?>"><?php printf( __( 'Go back to %s', 'color-system-visualizer'), $catName ) ?> </a>
				
			</div>
				<?php
					// Start the loop.
				 while ( have_posts() ) : the_post();
				 ?>
					<article id="post-<?php the_ID(); ?>">
						<div class="cpm_page_title">
							<h1 class="page-title"><?php the_title(); ?></h1>
						</div>
						<div class="cpm_color_details">
							<div class="col-sm-12">
								<?php 
									$rgb 		= '';
									$cmyk 		= '';
									if( !empty( get_post_meta( get_the_ID(), 'cpm_color_rgb', TRUE ) ) ) {
										$rgb 		=  str_replace(' ', '', get_post_meta( get_the_ID(), 'cpm_color_rgb', TRUE ) );
								    	$rgb 		= explode( ";",$rgb );
								    	$rgb 		= "R".$rgb[0]." G".$rgb[1]." B".$rgb[2];	
									}									
									if( !empty( get_post_meta( get_the_ID(), 'cpm_color_cmyk', TRUE )) ) {
										$cmyk 		= str_replace( ' ', '', get_post_meta( get_the_ID(), 'cpm_color_cmyk', TRUE ) );
					        			$cmyk 		= explode( ';', $cmyk );
					        			$cmyk 		= "C".$cmyk[0]." M".$cmyk[1]." Y".$cmyk[2]." K".$cmyk[3];	
									}
								?>

								<table class="table table-bordered">
								    <thead>
								      <tr>
								      	<th></th>
								        <th><?php echo $catName; ?></th>
								        <th><?php _e( 'Name', 'color-system-visualizer' ); ?></th>
								        <th>RGB</th>
								        <th>CMYK</th>
								        <th>HEX</th>
								      </tr>
								    </thead>
								    <tbody>
								      <tr>
								      	<td style="background-color: <?php echo "#".get_post_meta( get_the_ID(), 'cpm_color_hex', TRUE ); ?>"></td>
								        <td><?php echo the_title(); ?></td>
								        <td><?php  
							        		if( get_locale() == 'de_DE' ) {
							        			echo get_post_meta( get_the_ID(), 'cpm_color_name_de', TRUE );
							        		} else {
							        			_e( get_post_meta( get_the_ID(), 'cpm_color_name_en', TRUE ), 'color-system-visualizer');
							        		}
								         	?>								         	
								        </td>
								        <td><?php echo $rgb; ?></td>
								        <td><?php echo $cmyk ?></td>
								        <td><?php echo "#".get_post_meta( get_the_ID(), 'cpm_color_hex', TRUE ); ?></td>
								      </tr>
								    </tbody>
								</table>
							</div>
						</div>
						<div class="cpm_main_content">
							<div class="col-md-3 col-sm-3 col-xs-12">
								<?php if ( has_post_thumbnail() ) : ?>
										<img src="<?php the_post_thumbnail_url( 'full' ); ?>"/>
								<?php endif; ?>
							</div>
							<div class="col-md-9 col-sm-9 col-xs-12">								
								<div class="cpm_content">
									<?php the_content(); ?>
								</div>
							</div>
						</div>
					</article><!-- #post-## -->
				<?php
					// End of the loop.
					wp_reset_postdata();
					wp_reset_query();
				endwhile;
				?>
				<div class="cpm_post_nav">
					<?php 

						$prev_color_string 	= __( 'Previous color', 'color-system-visualizer' );
						$next_color_string 	= __( 'Next color', 'color-system-visualizer' );
					?>
					<div class="col-md-6 col-sm-3 col-xs-12">
						<div class="cpm_post_prev">
							<?php 
							if( !empty( $prevID ) ) {
								$cpm_prev_title 	= get_the_title( $prevID );
								$cpm_prev_url 		= get_permalink( $prevID );
							   echo '<a rel="prev" href="' . get_permalink( $prevID ) . '" title="' . $cpm_prev_title. '" class=" ">&laquo; '.$prev_color_string.'<br /><strong>&quot;'. $cpm_prev_title . '&quot;</strong></a>';
							}
							?>
						</div>
					</div>
					<div class="col-md-6 col-sm-3 col-xs-12">
						<div class="cpm_post_next">
							<?php
							if( !empty( $nextID ) ) {
								$cpm_next_title 	= get_the_title( $nextID );
								$cpm_next_url 		= get_permalink( $nextID );
							   echo '<a rel="next" href="' . get_permalink($nextID) . '" title="' . $cpm_next_title. '" class=" ">'.$next_color_string.' &raquo;<br /><strong>&quot;'. $cpm_next_title . '&quot;</strong></a>';
							}
							?>
						</div>
					</div>
				</div> <!-- end navigation -->
		</div>
	</div>
</div><!-- .content-area -->

<?php get_footer(); ?>