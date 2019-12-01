(function( $ ) {

	'use strict';

	$( document ).ready( function() {

		// Initialize color picker
		$( '.s_gdpr_c_n_color' ).wpColorPicker();


		var linkType = $( ".sgdpr_link_type" );

		var linkContentWrapper = $( ".s_gdpr_c_n_field_link_content_wrapper" );

		var customUrlContentWrapper = $( ".s_gdpr_c_n_field_custom_link_wrapper" );

		var pageContentWrapper = $( ".s_gdpr_c_n_field_page_selection_wrapper" );

		$('body').on( 'change', linkType, function() {

			if( linkType.val() == 'custom_url' ) {

				linkContentWrapper.removeClass( 'sgdpr_hidden' );
				customUrlContentWrapper.removeClass( 'sgdpr_hidden' );
				pageContentWrapper.addClass( 'sgdpr_hidden' );
			} else if( linkType.val() == 'page' ) {

				linkContentWrapper.removeClass( 'sgdpr_hidden' );
				pageContentWrapper.removeClass( 'sgdpr_hidden' );
				customUrlContentWrapper.addClass( 'sgdpr_hidden' );
			} else {

				linkContentWrapper.addClass( 'sgdpr_hidden' );
				pageContentWrapper.addClass( 'sgdpr_hidden' );
				customUrlContentWrapper.addClass( 'sgdpr_hidden' );
			}
		} );

	} );	


})( jQuery );
