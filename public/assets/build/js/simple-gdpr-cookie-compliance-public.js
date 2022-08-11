
(function($) {

    'use strict';

	

    var simpleGDPRCCCookie = {

    	setCookie : function( name, value, expires ) {

    		var todayDate 	= new Date(); 
    		var expireDate 	= new Date();
    		var cookieDefinition	= '';
		
			if( expires > 0 ) {
				expireDate.setTime( todayDate.getTime() + ( expires * 24 * 60 * 60 * 1000 ) );
				cookieDefinition = name + "=" + value +"; expires=" + expireDate.toUTCString();
			} else {
				cookieDefinition = name + "=" + value;
			}

			if ( simpleGDPRCCJsObj.isMultisite === '1' ) {
				if ( simpleGDPRCCJsObj.subdomainInstall !== '1' ) {
					cookieDefinition += "; path=" + simpleGDPRCCJsObj.path;
				} else {
					cookieDefinition += "; path=/";
				}
			}

			console.log( cookieDefinition); 

			document.cookie = cookieDefinition;

			console.log( document.cookie); 
    	},

    	getCookie : function( name ) {

    		var cookieName = name + "=";
			var decodedCookie = decodeURIComponent( document.cookie );

			var ca = decodedCookie.split(';');

			for( var i = 0; i < ca.length; i++ ) {

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

		// console.log( document.cookie );

    	var cookieExpireDays = parseInt(simpleGDPRCCJsObj.cookieExpireTime);

        var bgOverlayEle = $('#s-gdpr-c-c-bg-overlay');

    	if( simpleGDPRCCCookie.getCookie( 's_gdpr_c_c_cookie' ) == 'on' ) {

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

        	simpleGDPRCCCookie.setCookie( 's_gdpr_c_c_cookie', 'on', cookieExpireDays );

            $('.sgcc-main-wrapper').addClass('hidden');

            if ( bgOverlayEle ) {
                bgOverlayEle.hide();
            }
        } );
    } );

})(jQuery);