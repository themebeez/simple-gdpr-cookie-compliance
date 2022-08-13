//document.addEventListener('DOMContentLoaded', function () {

//    'use stict';

//    let overlayBackgroundEle = document.getElementById('s-gdpr-c-c-bg-overlay');
//    let closeNoticeButtonEle = document.getElementById('close-sgcc');
//    let mainWrapperEle = document.querySelector('.sgcc-main-wrapper');
//    let acceptCookieButtonEle = document.getElementById('sgcc-accept');

//    const setCookie = (name, value, expires) => {

//        let todayDate = new Date();
//        let expireDate = new Date();
//        let cookieDefinition = '';

//        if (expires > 0) {

//            expireDate.setTime(todayDate.getTime() + (expires * 24 * 60 * 60 * 1000));
//            cookieDefinition = name + "=" + value + "; expires=" + expireDate.toUTCString();

//        } else {

//            cookieDefinition = name + "=" + value;
//        }

//        if (simpleGDPRCCJsObj.isMultisite == '1') {

//            if (simpleGDPRCCJsObj.subdomainInstall !== '1') {

//                cookieDefinition += "; path=" + simpleGDPRCCJsObj.path;

//            } else {

//                cookieDefinition += "; path=/";
//            }
//        }

//        document.cookie = cookieDefinition;
//    }

//    const getCookie = (name) => {

//        let cookieName = name + "=";
//        let decodedCookie = decodeURIComponent(document.cookie);

//        let ca = decodedCookie.split(';');

//        for (let i = 0; i < ca.length; i++) {

//            let c = ca[i];

//            while (c.charAt(0) == ' ') {

//                c = c.substring(1);
//            }

//            if (c.indexOf(cookieName) == 0) {

//                return c.substring(cookieName.length, c.length);
//            }
//        }

//        return "";
//    }

//    const closeNotice = () => {

//        closeNoticeButtonEle.addEventListener('click', function () {

//            mainWrapperEle.classList.add('hidden');

//            if (overlayBackgroundEle) {

//                overlayBackgroundEle.style.display = 'none';
//            }
//        });
//    }

//    const acceptCookie = () => {

//        let cookieExpireDays = parseInt(simpleGDPRCCJsObj.cookieExpireTime);

//        acceptCookieButtonEle.addEventListener('click', (e) => {

//            e.preventDefault();
//            setCookie('s_gdpr_c_c_cookie', 'on', cookieExpireDays);
//            mainWrapperEle.classList.add('hidden');

//            if (overlayBackgroundEle) {

//                overlayBackgroundEle.style.display = 'none';
//            }
//        });
//    }

//    const showNotice = () => {

//        if (getCookie('s_gdpr_c_c_cookie') !== 'on') {

//            mainWrapperEle.classList.add('hidden');

//        } else {

//            mainWrapperEle.classList.remove('hidden');
//        }

//    }

//    showNotice();
//    closeNotice();
//    acceptCookie();
//});