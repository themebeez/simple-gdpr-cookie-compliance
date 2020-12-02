(function( $ ) {

	'use strict';

	$( document ).ready( function() {

		var linkType = $( ".sgdpr_link_type" );

		var linkContentWrapper = $( ".s_gdpr_c_n_field_link_content_wrapper" );

		var customUrlContentWrapper = $( ".s_gdpr_c_n_field_custom_link_wrapper" );

		var pageContentWrapper = $( ".s_gdpr_c_n_field_page_selection_wrapper" );

		var noticeStyleField = $( ".sgdpr_notice_type" );

		var enableBGOverlayField = $('.s_gdpr_c_n_bg_overlay_field');

		var customPositionField = $('.sgdpr_customwidth_position');

		var offsetFieldsWrapper = $('#s_gdpr_c_n_offset_group_wrapper');

		var topOffsetWrapperField = $('#s_gdpr_c_n_top_offset_group_field');

		var rightOffsetWrapperField = $('#s_gdpr_c_n_right_offset_group_field');

		var bottomOffsetWrapperField = $('#s_gdpr_c_n_bottom_offset_group_field');

		var leftOffsetWrapperField = $('#s_gdpr_c_n_left_offset_group_field');

		var bgOverlayFieldWrapper = $( "#s_gdpr_c_n_bg_overlay" );

		// Initialize color picker
		$( '.s_gdpr_c_n_color' ).wpColorPicker();

		customPositionOffset();

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

		$('body').on('change', noticeStyleField, function() {

			var noticeStyleVal = noticeStyleField.val();

			var overlayFieldWrapper = $('#s_gdpr_c_n_enable_bg_overlay');

			var fullWidthPositionFieldWrapper = $('#s_gdpr_c_n_fullwidth_position');

			var customWidthFieldWrapper = $('#s_gdpr_c_n_width');

			var customWidthPositionFieldWrapper = $('#s_gdpr_c_n_customwidth_position');

			var bgOverlayField = $( "#s_gdpr_c_n_bg_overlay" );

			if ( noticeStyleVal == 'pop_up' ) {
				overlayFieldWrapper.removeClass('sgdpr_hidden');
				customWidthFieldWrapper.removeClass('sgdpr_hidden');
				fullWidthPositionFieldWrapper.addClass('sgdpr_hidden');
				customWidthPositionFieldWrapper.addClass('sgdpr_hidden');
				offsetFieldsWrapper.addClass('sgdpr_hidden');
			}

			if ( noticeStyleVal == 'custom_width' ) {
				overlayFieldWrapper.addClass('sgdpr_hidden');
				customWidthFieldWrapper.removeClass('sgdpr_hidden');
				fullWidthPositionFieldWrapper.addClass('sgdpr_hidden');
				customWidthPositionFieldWrapper.removeClass('sgdpr_hidden');
				offsetFieldsWrapper.removeClass('sgdpr_hidden');
			}

			if ( noticeStyleVal == 'full_width' ) {
				overlayFieldWrapper.addClass('sgdpr_hidden');
				customWidthFieldWrapper.addClass('sgdpr_hidden');
				customWidthPositionFieldWrapper.addClass('sgdpr_hidden');
				offsetFieldsWrapper.addClass('sgdpr_hidden');
				fullWidthPositionFieldWrapper.removeClass('sgdpr_hidden');
			}
		});

		$('body').on('click', enableBGOverlayField, function() {
			noticeBGOverlay();	
		} );

		$('body').on('change', customPositionField, function() {
			var noticeStyleVal = noticeStyleField.val();
			if ( noticeStyleVal == 'custom_width' ) {
				offsetFieldsWrapper.removeClass('sgdpr_hidden');
				customPositionOffset();
			}			
		} );

		function noticeBGOverlay() {
			var noticeStyleVal = noticeStyleField.val();
			if ( noticeStyleVal == 'pop_up' && enableBGOverlayField.is(":checked") ) {
				bgOverlayFieldWrapper.removeClass('sgdpr_hidden');	
			} else {
				bgOverlayFieldWrapper.addClass('sgdpr_hidden');
			}
		}

		function customPositionOffset() {
			var customPosition = customPositionField.val();
			switch (customPosition) {
				case 'top_left' :
					topOffsetWrapperField.removeClass('sgdpr_hidden');
					leftOffsetWrapperField.removeClass('sgdpr_hidden');
					rightOffsetWrapperField.addClass('sgdpr_hidden');
					bottomOffsetWrapperField.addClass('sgdpr_hidden');
					break;
				case 'top_center' :
					topOffsetWrapperField.removeClass('sgdpr_hidden');
					leftOffsetWrapperField.addClass('sgdpr_hidden');
					rightOffsetWrapperField.addClass('sgdpr_hidden');
					bottomOffsetWrapperField.addClass('sgdpr_hidden');
					break;
				case 'top_right' :
					topOffsetWrapperField.removeClass('sgdpr_hidden');
					leftOffsetWrapperField.addClass('sgdpr_hidden');
					rightOffsetWrapperField.removeClass('sgdpr_hidden');
					bottomOffsetWrapperField.addClass('sgdpr_hidden');
					break;
				case 'bottom_left' :
					topOffsetWrapperField.addClass('sgdpr_hidden');
					leftOffsetWrapperField.removeClass('sgdpr_hidden');
					rightOffsetWrapperField.addClass('sgdpr_hidden');
					bottomOffsetWrapperField.removeClass('sgdpr_hidden');
					break;
				case 'bottom_center' :
					topOffsetWrapperField.addClass('sgdpr_hidden');
					leftOffsetWrapperField.addClass('sgdpr_hidden');
					rightOffsetWrapperField.addClass('sgdpr_hidden');
					bottomOffsetWrapperField.removeClass('sgdpr_hidden');
					break;
				case 'bottom_right' :
					topOffsetWrapperField.addClass('sgdpr_hidden');
					leftOffsetWrapperField.addClass('sgdpr_hidden');
					rightOffsetWrapperField.removeClass('sgdpr_hidden');
					bottomOffsetWrapperField.removeClass('sgdpr_hidden');
					break;
				default :
					topOffsetWrapperField.addClass('sgdpr_hidden');
					leftOffsetWrapperField.addClass('sgdpr_hidden');
					rightOffsetWrapperField.addClass('sgdpr_hidden');
					bottomOffsetWrapperField.addClass('sgdpr_hidden');
			}
		}

	} );	


})( jQuery );
