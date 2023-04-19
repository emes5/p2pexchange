<style>
    #cookieNotice.display-right {
        right: 30px;
        bottom: 30px;
        max-width: 395px;
    }
    #cookieNotice.light {
        background-color: #fff;
        color: #393d4d;
    }
    #cookieNotice {
        box-sizing: border-box;
        position: fixed;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 6px 6px rgb(0 0 0 / 25%);
        font-family: inherit;
        z-index: 999997;
    }
    #cookieNotice #closeIcon {
        width: 20px;
        height: 20px;
        cursor: pointer;
        color: #bfb9b9;
        overflow: hidden;
        opacity: .85;
        z-index: 999999;
        position: absolute;
        top: 0;
        right: 0;
        background: url({{asset('assets/img/cookie-icon.svg')}}) 0 0 / 20px 20px no-repeat;
    }
    #cookieNotice * {
        margin: 0;
        padding: 0;
        text-decoration: none;
        list-style: none;
        box-sizing: border-box;
    }
    #cookieNotice .title-wrap {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
        background: url({{asset('assets/img/cookie-icon.svg')}}) 0 0 / 40px 40px no-repeat;
        padding-left: 45px;
        height: 40px;
    }
    #cookieNotice .title-wrap svg {
        margin-right: 10px;
    }
    #cookieNotice h4 {
        font-family: inherit;
        font-weight: 700;
        font-size: 18px;
    }
    #cookieNotice.light p, #cookieNotice.light ul {
        color: #393d4d;
    }
    #cookieNotice p, #cookieNotice ul {
        font-size: 14px;
        margin-bottom: 20px;
    }
    #cookieNotice .btn-wrap {
        display: flex;
        flex-direction: row;
        font-weight: 700;
        justify-content: center;
        margin: 0 -5px 0 -5px;
        flex-wrap: wrap;
    }
    #cookieNotice .btn-wrap button {
        flex-grow: 1;
        padding: 0 7px;
        margin: 0 5px 10px 5px;
        border-radius: 20px;
        cursor: pointer;
        white-space: nowrap;
        min-width: 130px;
        line-height: 36px;
        border: none;
        font-family: inherit;
        font-size: 16px;
        transition: box-shadow .3s;
    }
    #cookieNotice button {
        outline: 0;
        border: none;
        appearance: none;
        -webkit-appearance: none;
        appearance: none;
    }
    #cookieNotice .btn-wrap button:hover {
        transition: box-shadow .4s cubic-bezier(.25,.8,.25,1),transform .4s cubic-bezier(.25,.8,.25,1);
        box-shadow: 0 2px 5px 0 rgb(0 0 0 / 30%);
        transform: translate3d(0,-1px,0);
    }
    .btn-primary{
        color:#ffffff;
        background:#115cfa;
        border: 1px solid #115cfa;
    }
</style>
<div id="cookieNotice" class="light display-right" style="display: none;">
    <div id="closeIcon" style="display: none;">
    </div>
    <div class="title-wrap">
        <h4>Your privacy</h4>
    </div>
    <div class="content-wrap">
        <div class="msg-wrap">
            <p>{{__('This website uses cookies, to enhance your browsing experience and provide personalized recommendations. By continuing to use our website, accept cookies.')}}</p>
            <div class="btn-wrap">
                <button class="btn-primary" onclick="acceptCookieConsent()" >Accept</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    let cookie_consent = getCookie("user_cookie_consent");
    if(cookie_consent != ""){
        document.getElementById("cookieNotice").style.display = "none";
    }else{
        document.getElementById("cookieNotice").style.display = "block";
    }
    function acceptCookieConsent(){
        deleteCookie('user_cookie_consent');
        setCookie('user_cookie_consent', 1, 30);
        document.getElementById("cookieNotice").style.display = "none";
    }
    // Create cookie
    function setCookie(cname, cvalue, exdays) {
        const d = new Date();
        d.setTime(d.getTime() + (exdays*24*60*60*1000));
        let expires = "expires="+ d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }
    // Read cookie
    function getCookie(cname) {
        let name = cname + "=";
        let decodedCookie = decodeURIComponent(document.cookie);
        let ca = decodedCookie.split(';');
        for(let i = 0; i <ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }
    // Delete cookie
    function deleteCookie(cname) {
        const d = new Date();
        d.setTime(d.getTime() + (24*60*60*1000));
        let expires = "expires="+ d.toUTCString();
        document.cookie = cname + "=;" + expires + ";path=/";
    }
</script>
