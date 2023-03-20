'use strict';

/**
*
* Define global variables.
* 
* @since: 1.1.4
*/

const bgOverlayEle = document.getElementById('s-gdpr-c-c-bg-overlay');
const cookieName = 's_gdpr_c_c_cookie';


/**
*
* Check if the browser supports cookies.
* If browser doesn't support cookies, we don't need to display the notice.
*/


/**
*
* Set cookie with name, value and expiration time in days.
* 
* @param {string} name
* @param {string} value
* @param {number} days
* @since: 1.1.4
*/

const setCookie = (name, value, expires = 0) => {

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

    // Set the cookie.
    document.cookie = cookieDefinition;

};


/**
*
* Get cookie with name.
* 
* @param {name} string
* @return {string}
* @since: 1.1.4
*/


const getCookie = (name) => {

    const cookies = decodeURIComponent(document.cookie).split(';');

    for (let i = 0; i < cookies.length; i++) {

        let cookie = cookies[i];

        while (cookie.charAt(0) === ' ') {

            cookie = cookie.substring(1);
        }

        if (cookie.indexOf(`${name}=`) === 0) {

            return cookie.substring(name.length + 1, cookie.length);
        }
    }

    return '';
};


/**
*
* Close notice on button click.
* 
* @since: 1.1.4
*/

const closeNotice = () => {

    const closeBtn = document.getElementById('close-sgcc');

    if (closeBtn) {

        closeBtn.addEventListener('click', (e) => {

            e.preventDefault();

            const mainWrapper = document.querySelector('.sgcc-main-wrapper');
            mainWrapper.classList.add('hidden');

            if (bgOverlayEle) {

                bgOverlayEle.style.display = 'none';
            }
        });
    }
};


/**
*
* Hide cookie if user accept it.
* 
* @since: 1.1.4
*/

const acceptCookie = () => {

    const cookieExpireDays = parseInt(simpleGDPRCCJsObj.cookieExpireTime);

    const acceptBtn = document.getElementById('sgcc-accept');

    if (acceptBtn) {

        acceptBtn.addEventListener('click', (e) => {

            e.preventDefault();

            console.log('=> Invoking funciton setCookie()...');
            setCookie(cookieName, 'on', cookieExpireDays);

            const mainWrapper = document.querySelector('.sgcc-main-wrapper');

            if (mainWrapper) {

                mainWrapper.classList.add('hidden');
            }

            if (bgOverlayEle) {

                bgOverlayEle.style.display = 'none';
            }
        });

    }
};


/**
*
* Display cookie notice if user didn't accept it.
* 
* @since: 1.1.4
*/

const showNotice = () => {

    const mainWrapper = document.querySelector('.sgcc-main-wrapper');
    const isCookieSet = getCookie(cookieName) === 'on';

    // If the browser doesn't support cookies, do not display the notice.
    if (navigator.cookieEnabled === false) {

        if (mainWrapper) {

            mainWrapper.classList.add('hidden');
        }

        if (bgOverlayEle) {

            bgOverlayEle.style.display = 'none';
        }

        return;
    }

    if ((isCookieSet === undefined) || (isCookieSet === null) || (isCookieSet === '')) {

        // We have a problem here. The cookie is not set, but the notice is hidden.
        console.log('Simple GDPR Cookie Consent: Cookie is not set!!!');

    } else {

        mainWrapper.classList.toggle('hidden', isCookieSet);
    }
};


/**
*
* Fire all functions on DOMContentLoaded.
* 
* @since: 1.1.4
*/

document.addEventListener('DOMContentLoaded', () => {

    closeNotice();
    acceptCookie();
    showNotice();
});
