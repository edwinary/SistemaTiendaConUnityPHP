var saveclass = null;

function saveTheme(cookieValue)
{
    var sel = document.getElementById('ThemeSelect');

    saveclass = saveclass ? saveclass : document.body.className;
    document.body.className = saveclass + ' ' + sel.value;

    setCookie('theme', cookieValue, 365);
}

function setCookie(cookieName, cookieValue, nDays) {
    var today = new Date();
    var expire = new Date();

    if (nDays==null || nDays==0)
        nDays=1;

    expire.setTime(today.getTime() + 3600000*24*nDays);
    document.cookie = cookieName+"="+escape(cookieValue) + ";expires="+expire.toGMTString();
}