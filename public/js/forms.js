window.onload = function () {
    if (!window.jQuery) {
        var script = document.createElement('script');
        script.type = "text/javascript";
        script.src = "https://code.jquery.com/jquery-3.4.1.min.js";
        document.getElementsByTagName('head')[0].appendChild(script)
    }
  }
  
  function getUserIp() {
    var ipXhr = new XMLHttpRequest();
    var ipUrl = 'https://ipapi.co/json';
    var ipfy = {};
  
    ipXhr.onload = function () {
        if (this.readyState == 4 && this.status == 200) {
            Object.assign(ipfy, JSON.parse(this.response));
        }
    };
  
    ipXhr.open('GET', ipUrl, true);
    ipXhr.send();
  
    return ipfy;
  }
  
  
  function getUserAgent() {
    var unknown = '-';
  
    // screen
    var screenSize = '';
    if (screen.width) {
        width = (screen.width) ? screen.width : '';
        height = (screen.height) ? screen.height : '';
        screenSize += '' + width + " x " + height;
    }
  
    // browser
    var nVer = navigator.appVersion;
    var nAgt = navigator.userAgent;
    var browser = navigator.appName;
    var version = '' + parseFloat(navigator.appVersion);
    var majorVersion = parseInt(navigator.appVersion, 10);
    var nameOffset, verOffset, ix;
  
    // Opera
    if ((verOffset = nAgt.indexOf('Opera')) != -1) {
        browser = 'Opera';
        version = nAgt.substring(verOffset + 6);
        if ((verOffset = nAgt.indexOf('Version')) != -1) {
            version = nAgt.substring(verOffset + 8);
        }
    }
    // Opera Next
    if ((verOffset = nAgt.indexOf('OPR')) != -1) {
        browser = 'Opera';
        version = nAgt.substring(verOffset + 4);
    }
    // Edge
    else if ((verOffset = nAgt.indexOf('Edge')) != -1) {
        browser = 'Microsoft Edge';
        version = nAgt.substring(verOffset + 5);
    }
    // MSIE
    else if ((verOffset = nAgt.indexOf('MSIE')) != -1) {
        browser = 'Microsoft Internet Explorer';
        version = nAgt.substring(verOffset + 5);
    }
    // Chrome
    else if ((verOffset = nAgt.indexOf('Chrome')) != -1) {
        browser = 'Chrome';
        version = nAgt.substring(verOffset + 7);
    }
    // Safari
    else if ((verOffset = nAgt.indexOf('Safari')) != -1) {
        browser = 'Safari';
        version = nAgt.substring(verOffset + 7);
        if ((verOffset = nAgt.indexOf('Version')) != -1) {
            version = nAgt.substring(verOffset + 8);
        }
    }
    // Firefox
    else if ((verOffset = nAgt.indexOf('Firefox')) != -1) {
        browser = 'Firefox';
        version = nAgt.substring(verOffset + 8);
    }
    // MSIE 11+
    else if (nAgt.indexOf('Trident/') != -1) {
        browser = 'Microsoft Internet Explorer';
        version = nAgt.substring(nAgt.indexOf('rv:') + 3);
    }
    // Other browsers
    else if ((nameOffset = nAgt.lastIndexOf(' ') + 1) < (verOffset = nAgt.lastIndexOf('/'))) {
        browser = nAgt.substring(nameOffset, verOffset);
        version = nAgt.substring(verOffset + 1);
        if (browser.toLowerCase() == browser.toUpperCase()) {
            browser = navigator.appName;
        }
    }
    // trim the version string
    if ((ix = version.indexOf(';')) != -1) version = version.substring(0, ix);
    if ((ix = version.indexOf(' ')) != -1) version = version.substring(0, ix);
    if ((ix = version.indexOf(')')) != -1) version = version.substring(0, ix);
  
    majorVersion = parseInt('' + version, 10);
    if (isNaN(majorVersion)) {
        version = '' + parseFloat(navigator.appVersion);
        majorVersion = parseInt(navigator.appVersion, 10);
    }
  
    // mobile version
    var mobile = /Mobile|mini|Fennec|Android|iP(ad|od|hone)/.test(nVer);
  
    // cookie
    var cookieEnabled = (navigator.cookieEnabled) ? true : false;
  
    if (typeof navigator.cookieEnabled == 'undefined' && !cookieEnabled) {
        document.cookie = 'testcookie';
        cookieEnabled = (document.cookie.indexOf('testcookie') != -1) ? true : false;
    }
  
    // system
    var os = unknown;
    var clientStrings = [
        { s: 'Windows 10', r: /(Windows 10.0|Windows NT 10.0)/ },
        { s: 'Windows 8.1', r: /(Windows 8.1|Windows NT 6.3)/ },
        { s: 'Windows 8', r: /(Windows 8|Windows NT 6.2)/ },
        { s: 'Windows 7', r: /(Windows 7|Windows NT 6.1)/ },
        { s: 'Windows Vista', r: /Windows NT 6.0/ },
        { s: 'Windows Server 2003', r: /Windows NT 5.2/ },
        { s: 'Windows XP', r: /(Windows NT 5.1|Windows XP)/ },
        { s: 'Windows 2000', r: /(Windows NT 5.0|Windows 2000)/ },
        { s: 'Windows ME', r: /(Win 9x 4.90|Windows ME)/ },
        { s: 'Windows 98', r: /(Windows 98|Win98)/ },
        { s: 'Windows 95', r: /(Windows 95|Win95|Windows_95)/ },
        { s: 'Windows NT 4.0', r: /(Windows NT 4.0|WinNT4.0|WinNT|Windows NT)/ },
        { s: 'Windows CE', r: /Windows CE/ },
        { s: 'Windows 3.11', r: /Win16/ },
        { s: 'Android', r: /Android/ },
        { s: 'Open BSD', r: /OpenBSD/ },
        { s: 'Sun OS', r: /SunOS/ },
        { s: 'Linux', r: /(Linux|X11)/ },
        { s: 'iOS', r: /(iPhone|iPad|iPod)/ },
        { s: 'Mac OS X', r: /Mac OS X/ },
        { s: 'Mac OS', r: /(MacPPC|MacIntel|Mac_PowerPC|Macintosh)/ },
        { s: 'QNX', r: /QNX/ },
        { s: 'UNIX', r: /UNIX/ },
        { s: 'BeOS', r: /BeOS/ },
        { s: 'OS/2', r: /OS\/2/ },
        { s: 'Search Bot', r: /(nuhk|Googlebot|Yammybot|Openbot|Slurp|MSNBot|Ask Jeeves\/Teoma|ia_archiver)/ }
    ];
    for (var id in clientStrings) {
        var cs = clientStrings[id];
        if (cs.r.test(nAgt)) {
            os = cs.s;
            break;
        }
    }
  
    var osVersion = unknown;
  
    if (/Windows/.test(os)) {
        osVersion = /Windows (.*)/.exec(os)[1];
        os = 'Windows';
    }
  
    switch (os) {
        case 'Mac OS X':
            osVersion = /Mac OS X (10[\.\_\d]+)/.exec(nAgt)[1];
            break;
  
        case 'Android':
            osVersion = /Android ([\.\_\d]+)/.exec(nAgt)[1];
            break;
  
        case 'iOS':
            osVersion = /OS (\d+)_(\d+)_?(\d+)?/.exec(nVer);
            osVersion = osVersion[1] + '.' + osVersion[2] + '.' + (osVersion[3] | 0);
            break;
    }
  
  
    return {
        screen: screenSize,
        browser: browser,
        browserVersion: version,
        browserMajorVersion: majorVersion,
        mobile: mobile,
        operating_system: os + ' ' + osVersion,
        cookies: cookieEnabled
    };
  
  }
  
  var gqXhr = new XMLHttpRequest();
  var gqUrl = 'https://cloudcom.businessai.io/api/forms/get';
  var formId = document.body.getElementsByClassName('gq-script')[0].getAttribute('data-id');
  var modalCss = '#popup-close{position:absolute;top:-15px;right:-15px;cursor:pointer;width:25px}#gq-form button{background:#22b9ff;border-color:#22b9ff;padding:10px 20px}#popup-box{position:fixed;left:0;top:0;width:100%;height:100%;background-color:#333;opacity:.8;display:none;z-index:2;}#gq-form input,#gq-form textarea{display:block;width:100%;height:calc(1.5em + 1.3rem + 2px);padding:.65rem 1rem;font-size:1rem;font-weight:400;line-height:1.5;color:#495057;background-color:#fff;background-clip:padding-box;border:1px solid #e2e5ec;border-radius:4px;transition:border-color .15s ease-in-out,box-shadow .15s ease-in-out}#gq-form.popup form{position:fixed;left:50%;top:50%;transform:translate(-50%,-50%);background-color:#f2f3f8;color:#444;width:90%;max-width:600px;padding:30px;border-radius: 2px;display:none;z-index:3;}.form_success{background: #2ecc71;padding: 10px;border-radius: 3px;color: #fff;}.form_error{background: #cc2e2e;padding: 10px;border-radius: 3px;color: #fff;}.gq-modal{display:none;position:fixed;z-index:1;padding-top:100px;left:0;top:0;width:100%;height:100%;overflow:auto;background-color:#000;background-color:rgba(0,0,0,.4)}.gq-modal-content{position:relative;background-color:#fefefe;margin:auto;padding:0;border:1px solid #888;width:35%;box-shadow:0 4px 8px 0 rgba(0,0,0,.2),0 6px 20px 0 rgba(0,0,0,.19);-webkit-animation-name:animatetop;-webkit-animation-duration:.4s;animation-name:animatetop;animation-duration:.4s}@-webkit-keyframes animatetop{from{top:-300px;opacity:0}to{top:0;opacity:1}}@keyframes animatetop{from{top:-300px;opacity:0}to{top:0;opacity:1}}.gq-close{color:#fff;float:right;font-size:28px;font-weight:700}.gq-close:focus,.gq-close:hover{cursor:pointer}.gq-modal-header{padding:10px;background-color:#5cb85c;color:#fff}.gq-modal-body{padding:2px 16px}';
  var modalHtml = '<div id="popup-box"></div><div id="gqFormModal" class="gq-modal"><div class="gq-modal-content"><div class="gq-modal-header"> <span class="gq-close">&times;</span><h2>Success!</h2></div><div class="gq-modal-body"><p>Success text for web form builder capture</p></div></div></div>';
  var close = '<img id="popup-close" src="https://img.icons8.com/material-rounded/24/000000/close-window.png">';

  gqXhr.open('GET', gqUrl + '/' + formId);
  
  gqXhr.onload = function () {
    if (gqXhr.status === 200) {
        var ipInfo = getUserIp();
        var userAgent = getUserAgent();
        var response = JSON.parse(gqXhr.response);
        var formDiv = document.getElementById('gq-form');
        var htmlHead = document.head;
        var html = response.markup;
        var css = response.style;
        var tname = response.title;
        var tdescription = response.description;
        html += modalHtml;
        css += modalCss;
        style = document.createElement('style');
        formDiv.innerHTML = html;
        htmlHead.appendChild(style);
        style.type = 'text/css';
        var gqForm = document.querySelector('#gq-form form');
        var popupbox = document.querySelector('#popup-box');

        Object.keys(response).forEach(function(key) {
            if(response[key] === null) {
                response[key] = '';
            }
        })


        gqForm.insertAdjacentHTML('afterbegin', '<p>' + tname +'</p>');
        gqForm.insertAdjacentHTML('afterbegin', '<h3>' + tdescription +'</h3>');

        if (formDiv.classList.contains('popup')) {
            
            gqForm.insertAdjacentHTML('beforeend', close);

            var delay = 5000; // milliseconds
            var cookie_expire = 0; // days
    
            var cookie = localStorage.getItem("list-builder");
            if(cookie == undefined || cookie == null) {
                cookie = 0;
            }
            if(((new Date()).getTime() - cookie) / (1000 * 60 * 60 * 24) > cookie_expire) {
                
                setTimeout(function () {
                    gqForm.style.display = "block";
                    popupbox.style.display = "block";
                }, delay);

                var closebtn = document.getElementById('popup-close');
                closebtn.addEventListener('click', function(){
                    gqForm.style.display = "none";
                    popupbox.style.display = "none";
                    localStorage.setItem(popupbox, (new Date()).getTime());
                });
            }
        }
  
        var hiddenVal =
          //user tech info fields
            '<input type="hidden" name="location" value="' + ipInfo.city + ', ' + ipInfo.region + ', ' + ipInfo.country_name + '">'
            +'<input type="hidden" name="browser" value="' + userAgent.browser +'">'
            +'<input type="hidden" name="os" value="' + userAgent.operating_system +'">'
            +'<input type="hidden" name="is_mobile" value="' + userAgent.mobile +'">'
            +'<input type="hidden" name="screen_size" value="' + userAgent.screen +'">'
            +'<input type="hidden" name="referrer_url" value="//' + location.host + location.pathname +'">'
  
            //user crm fields
            +'<input type="hidden" name="organization_id" value="' + response.org_id +'">'
            +'<input type="hidden" name="location_id" value="' + response.location_id +'">'
            +'<input type="hidden" name="user_id" value="' + response.owner_id +'">';
  
        if (style.styleSheet) {
            style.styleSheet.cssText = css
        }
  
        else {
            style.appendChild(document.createTextNode(css))
        }
  
        var url_string = window.location.href; 
        var url = new URL(url_string);
        var submitStatus = url.searchParams.get("submit");
        var errMsg = url.searchParams.get("err");
        
  
        gqForm.insertAdjacentHTML('beforeend', hiddenVal);
        gqForm.setAttribute('action', gqUrl);
        gqForm.setAttribute('method', 'post');
  
        if (submitStatus === 'success') {
            var successAlert = '<span class="form_success">Thank you! Your submission has been processed, we will get back to you shortly.</span>';
  
            gqForm.insertAdjacentHTML('beforeend', successAlert);
        }
  
        if (submitStatus === 'error' && errMsg === 'duplicate') {
            var errAlert = '<span class="form_error">The email address you entered is already subscribed.</span>';
  
            gqForm.insertAdjacentHTML('beforeend', errAlert);
        }
  
        gqForm.addEventListener('', function (e) { //ajax submission (disabled)
            e.preventDefault();
            var formArray = $(this).serializeArray();
            var formData = {};
  
            $.each(formArray, function () {
                if (formData[this.name]) {
                    if (!formData[this.name].push) {
                        formData[this.name] = [formData[this.name]]
                    }
  
                    formData[this.name].push(this.value || '')
                }
  
                else {
                    formData[this.name] = this.value || ''
                }
  
                formData['ip'] = ipInfo.ip;
                formData['location'] = ipInfo.city + ', ' + ipInfo.region + ', ' + ipInfo.country_name;
                formData['browser'] = userAgent.browser;
                formData['os'] = userAgent.operating_system;
                formData['is_mobile'] = userAgent.mobile;
                formData['screen_size'] = userAgent.screen;
  
            }
  
            );
            formData.organization_id = response.org_id;
            formData.location_id = response.location_id;
            formData.user_id = response.owner_id;
  
            gqXhr.open('POST', gqUrl);
            gqXhr.setRequestHeader("Access-Control-Allow-Origin", "*");
            gqXhr.setRequestHeader("Access-Control-Allow-Methods", "GET,POST");
            gqXhr.setRequestHeader("Access-Control-Allow-Headers", "Content-Type");
            gqXhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
  
            gqXhr.onload = function () {
                if (gqXhr.status !== 200) {
                    return console.log('Request failed. Returned status of ' + gqXhr.status)
                }
  
                gqForm.reset(); var modal = document.getElementById("gqFormModal"); var span = document.getElementsByClassName("gq-close"); modal.style.display = "block"; span.onclick = function () {
                    modal.style.display = "none"
                }
  
                window.onclick = function (event) {
                    if (event.target == modal) {
                        modal.style.display = "none"
                    }
                }
            };
            gqXhr.send(JSON.stringify(formData))
        }
  
        )
    }
  
    else {
        console.log('Request failed.  Returned status of ' + gqXhr.status)
    }
  };
  gqXhr.send()