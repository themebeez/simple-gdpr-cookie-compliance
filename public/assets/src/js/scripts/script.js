(function ($) {

    'use strict';

    let bgOverlayEle = $('#s-gdpr-c-c-bg-overlay');

    const setCookie = (name, value, expires) => {

        let todayDate = new Date();
        let expireDate = new Date();
        let cookieDefinition = '';

        if (expires > 0) {

            expireDate.setTime(todayDate.getTime() + (expires * 24 * 60 * 60 * 1000));
            cookieDefinition = name + "=" + value + "; expires=" + expireDate.toUTCString();

        } else {

            cookieDefinition = name + "=" + value;
        }

        if (simpleGDPRCCJsObj.isMultisite == '1') {

            if (simpleGDPRCCJsObj.subdomainInstall !== '1') {

                cookieDefinition += "; path=" + simpleGDPRCCJsObj.path;

            } else {

                cookieDefinition += "; path=/";
            }
        }

        document.cookie = cookieDefinition;
    }

    const getCookie = (name) => {

        let cookieName = name + "=";
        let decodedCookie = decodeURIComponent(document.cookie);

        let ca = decodedCookie.split(';');

        for (let i = 0; i < ca.length; i++) {

            let c = ca[i];

            while (c.charAt(0) == ' ') {

                c = c.substring(1);
            }

            if (c.indexOf(cookieName) == 0) {

                return c.substring(cookieName.length, c.length);
            }
        }

        return "";
    }

    const closeNotice = () => {

        $(document).on('click', '#close-sgcc', function () {

            $('.sgcc-main-wrapper').addClass('hidden');

            if (bgOverlayEle) {

                bgOverlayEle.hide();
            }
        });
    }

    const acceptCookie = () => {

        let cookieExpireDays = parseInt(simpleGDPRCCJsObj.cookieExpireTime);

        $(document).on('click', '#sgcc-accept', function (e) {

            e.preventDefault();

            setCookie('s_gdpr_c_c_cookie', 'on', cookieExpireDays);

            $('.sgcc-main-wrapper').addClass('hidden');

            if (bgOverlayEle) {
                bgOverlayEle.hide();
            }
        });
    }

    const showNotice = () => {

        if (getCookie('s_gdpr_c_c_cookie') == 'on') {

            $('.sgcc-main-wrapper').addClass('hidden');

        } else {

            $('.sgcc-main-wrapper').removeClass('hidden');
        }
    }

    $(document).ready(function () {

        setCookie();
        getCookie();
        closeNotice();
        acceptCookie();
        showNotice();
    });

})(jQuery);