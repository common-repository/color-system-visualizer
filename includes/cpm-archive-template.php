<?php
if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/* 
** Color paletter archive page
*/
get_header(); ?>

<div class="cpm_content_wrapper">
	<div class="container">
		<div class="row">

			<?php if ( have_posts() ) : ?>
				<div class="cpm_page_title">
					<?php the_archive_title( '<h1 class="page-title">', '</h1>' ); ?>
				</div>
				<div class="cpm_main_content">
					<table id="cpm_ColorTable" class="display">
						<thead>
					      	<tr>
					      		<th style="display: none;"></th>
						      	<th></th>
						        <th><?php echo single_cat_title(); ?></th>
						        <th>Name</th>
						        <th>RGB</th>
						        <th>CMYK</th>
						        <th>HEX</th>
					      	</tr>
					    </thead>
					    <tbody>
							<?php
							// Start the Loop.
							while ( have_posts() ) : the_post();
								$rgb 		= '';
								$cmyk 		= '';
								if( !empty( get_post_meta( get_the_ID(), 'cpm_color_rgb', TRUE ) ) ) {
									$rgb 		=  str_replace(' ', '', get_post_meta( get_the_ID(), 'cpm_color_rgb', TRUE ) );
							    	$rgb 		= explode( ";",$rgb );
							    	$rgb 		= "R".$rgb[0]." G".$rgb[1]." B".$rgb[2];	
								}
								if( !empty(get_post_meta( get_the_ID(), 'cpm_color_cmyk', TRUE ) ) ) {
									$cmyk 		= str_replace(' ', '', get_post_meta( get_the_ID(), 'cpm_color_cmyk', TRUE ) );
				        			$cmyk 		= explode( ';', $cmyk );
				        			$cmyk 		= "C".$cmyk[0]." M".$cmyk[1]." Y".$cmyk[2]." K".$cmyk[3];
								}								        		
							?>
						        <tr>
						        	<td id="post_id" ajax_url="<?php echo admin_url( 'admin-ajax.php' ); ?>" style="display: none;"><?php echo get_the_ID(); ?></td>
						            <td style="background-color: <?php echo "#".get_post_meta( get_the_ID(), 'cpm_color_hex', TRUE ); ?>"></td>
							        <td><?php echo '<a href="'.get_permalink().'">'.get_the_title().'</a>'; ?></td>
							        <td><?php
							        		if( get_locale() == 'de_DE' ) {
							        			echo get_post_meta( get_the_ID(), 'cpm_color_name_de', TRUE );
							        		} else {
							        			_e( get_post_meta( get_the_ID(), 'cpm_color_name_en', TRUE ), 'color-system-visualizer' );
							        		}
							        	?>							        	
							        </td>
							        <td><?php echo $rgb; ?></td>
							        <td><?php echo $cmyk ?></td>
							        <td><?php echo "#".get_post_meta( get_the_ID(), 'cpm_color_hex', TRUE ); ?></td>
						        </tr>
							<?php	
							endwhile;
						// If no content, include the "No posts found" template.
						else :
							echo '<h1>'. __( 'No Content Found!!', 'color-system-visualizer' ).'</h1>';

						endif;
						?>
						</tbody>
					</table>
					<!-- Show content if table filter shows one result -->
					<div id="cpm_post_result"></div>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>