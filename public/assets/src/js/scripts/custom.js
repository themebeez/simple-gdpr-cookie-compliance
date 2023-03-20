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
* Set cookie with name, value and expiration time in days.
* 
* @param {string} name
* @param {string} value
* @param {number} days
* @since: 1.1.4
*/

const setCookie = (name, value, days) => {

    const date = new Date();
    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
    const expires = `expires=${date.toUTCString()}`;
    const path = '; path=/';
    document.cookie = `${name}=${value}; ${expires}${path}`;
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

    const acceptBtn = document.querySelector('#sgcc-accept');

    if (acceptBtn) {

        acceptBtn.addEventListener('click', (e) => {

            e.preventDefault();
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

    const isCookieSet = getCookie(cookieName) === 'on';

    if ((isCookieSet === undefined) || (isCookieSet === null) || (isCookieSet === '')) {

        // We have a problem here. The cookie is not set, but the notice is hidden.
        console.log('Simple GDPR Cookie Consent: Cookie is not set!!!');

    } else {

        const mainWrapper = document.querySelector('.sgcc-main-wrapper');

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
