
(function($) {

    'use strict';

    var s_GDPR_C_C_Cookie = {

    	setCookie : function( name, value, days ) {

    		var todayDate 	= new Date(); 
    		var expireDate 	= new Date();
    		var cookie_dfn	= '';
		
			if( days > 0 ) {

				expireDate.setTime( todayDate.getTime() + ( days * 24 * 60 * 60 * 1000 ) );

				cookie_dfn = name + "=" + value +"; expires=" + expireDate.toUTCString() + "; path=/";
			} else {

				cookie_dfn = name + "=" + value + "; path=/";
			}

			document.cookie = cookie_dfn;
    	},

    	getCookie : function( name ) {

    		var cookieName = name + "=";
			var decodedCookie = decodeURIComponent( document.cookie );
			var ca = decodedCookie.split(';');

			for( var i = 0; i <ca.length; i++ ) {

				var c = ca[i];

				while( c.charAt(0) == ' ' ) {

					c = c.substring(1);
				}

				if( c.indexOf( cookieName ) == 0 ) {

					return c.substring( cookieName.length, c.length );
				}
			}

			return "";
    	}
    }

    // Document ready function

    $(document).ready(function() {

    	var no_Days 		= noticeObj.cookie_expire_time;

        var bgOverlayEle = $('#s-gdpr-c-c-bg-overlay');

    	if( s_GDPR_C_C_Cookie.getCookie( 's_gdpr_c_c_cookie' ) == 'on' ) {

    		$('.sgcc-main-wrapper').addClass('hidden');
    	} else {

            $( '.sgcc-main-wrapper' ).removeClass('hidden');
        }

    	$( 'body' ).on( 'click', '#close-sgcc', function() { 

            $('.sgcc-main-wrapper').addClass('hidden');

            if ( bgOverlayEle ) {
                bgOverlayEle.hide();
            }
        } );

        $( 'body' ).on( 'click', '#sgcc-accept', function(e) {

        	e.preventDefault(); 

        	s_GDPR_C_C_Cookie.setCookie( 's_gdpr_c_c_cookie', 'on', no_Days );

            $('.sgcc-main-wrapper').addClass('hidden');

            if ( bgOverlayEle ) {
                bgOverlayEle.hide();
            }
        } );
    } );

})(jQuery);