(function($) {

    'use strict';


    // Document ready function

    $(document).ready(function() {

        var expireTime = Number( noticeObj.cookie_expire_time );
        
    	// on click set cookie

        $('.close-sgcc').on('click', function() {

            $('.sgcc-main-wrapper').hide();
            
            $.cookie('sgcc_cookie', true, { expires: expireTime });

        });

        // check if cookie is alive

        if( $.cookie('sgcc_cookie') ) {

        	$(".sgcc-main-wrapper").hide();
        };

    });


})(jQuery);