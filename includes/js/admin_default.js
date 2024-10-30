/* Admin color picker for color post type metabox */
jQuery(function($) {
    jQuery('#colorpicker-full').colorpicker({
        parts:          'full',
        alpha:          true,
        showOn:         'both',
        buttonColorize: true,
        showNoneButton: true,        
        /* Callback function to append RGB, CMYK and LAB color format */
        select: function (formats, color) {
		        	var rgb = color.rgb;
		        	var cmyk = color.cmyk;
		        	var lab = color.lab;
					jQuery('#cpm_color_rgb').val(Math.round(rgb.r * 255)+"; "+Math.round(rgb.g * 255)+"; "+Math.round(rgb.b * 255)+";");
					jQuery('#cpm_color_cmyk').val(Math.round(cmyk.c * 100)+"; "+Math.round(cmyk.m * 100)+"; "+Math.round(cmyk.y * 100)+"; "+Math.round(cmyk.k * 100)+";");
					jQuery('#cpm_color_lab').val(Math.round(lab.l * 100)+"; "+Math.round((lab.a * 255) - 128)+"; "+Math.round((lab.b * 255) - 128)+";");
					jQuery('#button_color').css('background-color',color.css);
    			}
    });
    var bgColor         = jQuery("input[name=cpm_color_hex]").val();
    jQuery('#button_color').css('background-color',"#"+bgColor);

/* Ajax call to import color palette using CSV */
    jQuery('#cpm_import_form').submit(function(e){
        e.preventDefault();
        jQuery('#cpm_loader').show();
        var ajaxurl             = jQuery( "#ajaxurl" ).val();
        var cpm_csv_security    = jQuery( "#cpm_csv_security" ).val();
        var file_data           = jQuery('#cpm_import_color').prop('files')[0];
        var form_data           = new FormData();
        form_data.append( 'cpm_import_color', file_data );
        form_data.append( 'action', 'cpm_import_csv_function' );
        form_data.append( 'cpm_csv_security', cpm_csv_security );
        jQuery.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    contentType: false,
                    processData: false,
                    data: form_data,
                    success: function ( results ) {
                            var results = jQuery.parseJSON( results ); 
                            if( results.UpdatedMessage !== undefined ) {
                                jQuery( '#cpm_update' ).show();
                                jQuery( '#cpm_update' ).html( '<p><strong>'+results.UpdatedMessage+'</strong></p>' );
                            }

                            if( results.InsertedMessage !== undefined ) {
                                jQuery( '#cpm_insert' ).show();
                                jQuery( '#cpm_insert' ).html( '<p><strong>'+results.InsertedMessage+'</strong></p>' );
                            }

                             if( results.NoticeMessage !== undefined ) {
                                jQuery( '#cpm_notice' ).show();
                                jQuery( '#cpm_notice' ).html( '<p><strong>'+results.NoticeMessage+'</strong></p>' );
                            }
                        jQuery( '#cpm_import_form' ).find( 'input:file' ).val('');
                        jQuery( '#cpm_loader' ).hide();
                    },
                    error: function( results ) {
                        jQuery( '#cpm_error' ).show();
                        jQuery( '#cpm_error' ).html( '<p><strong>Something went wrong, please try again..!!</strong></p>' );
                        jQuery( '#cpm_loader' ).hide();
                    }
                });
        return false;
    });
});