function cpmTableListener() {
	jQuery('#cpm_ColorTable_filter input[type="search"]').on('keypress keyup keydown paste', function() {
	    var NumRows = jQuery( '#cpm_ColorTable tbody tr' ).length;
	    if( ( NumRows != 1 ) ) {
	    	var TotalRecordsOld = localStorage.setItem( "TotalRecordsOld", NumRows );
	    	jQuery( '#cpm_post_result' ).html( '' );
		}
		if( jQuery( '#cpm_ColorTable tbody tr td' ).hasClass( 'dataTables_empty' ) == true ) {
			jQuery( '#cpm_post_result' ).html( '' );
		}
	    if( ( NumRows == 1 ) && ( jQuery( '#cpm_ColorTable tbody tr td' ).hasClass( 'dataTables_empty' ) == false ) ) {
	    	var TotalNewRecords = localStorage.setItem( "TotalNewRecords", NumRows );
	    	if( TotalRecordsOld == TotalNewRecords ) {
		    	// Ajax call to show date if datatable filter shows only one result 
		    	var PostID = jQuery( '#post_id' ).text();
		    	var ajaxurl = jQuery( '#post_id' ).attr( 'ajax_url' );
			    jQuery.ajax({
					data: { action: 'cpm_get_post', pId:PostID },
					type: 'post',
					url: ajaxurl,
					success: function(data) {
						jQuery( '#cpm_post_result' ).html( data );
			        }
			    });
		    }
		}
	});
}