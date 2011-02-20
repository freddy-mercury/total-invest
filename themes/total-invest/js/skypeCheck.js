var activex = ((navigator.userAgent.indexOf('Win')  != -1) && (navigator.userAgent.indexOf('MSIE') != -1) && (parseInt(navigator.appVersion) >= 4 ));
var CantDetect = ((navigator.userAgent.indexOf('Safari')  != -1) || (navigator.userAgent.indexOf('Opera')  != -1));

function oopsPopup() {
    if((navigator.language && navigator.language.indexOf("ja") != -1) || (navigator.systemLanguage && navigator.systemLanguage.indexOf("ja") != -1) || (navigator.userLanguage && navigator.userLanguage.indexOf("ja") != -1)) {
        var URLtoOpen = "http://download.skype.com/share/skypebuttons/oops/oops_ja.html";
    } else {
        var URLtoOpen = "http://download.skype.com/share/skypebuttons/oops/oops.html";
    }
	var windowName = "oops";
	var popW = 540, popH = 305;
	var scrollB = 'no';
	w = screen.availWidth;
	h = screen.availHeight;
	var leftPos = (w-popW)/2, topPos = (h-popH)/2;
	oopswindow = window.open(URLtoOpen, windowName,'width=' + popW + ',height=' + popH + ',scrollbars=' + scrollB + ',screenx=' +leftPos +',screeny=' +topPos +',top=' +topPos +',left=' +leftPos);
	return false;
}

if(typeof(detected) == "undefined" && activex) {
    document.write(
        ['<script language="VBscript">',
        'Function isSkypeInstalled()',
        'on error resume next',
        'Set oSkype = CreateObject("Skype.Detection")',
        'isSkypeInstalled = IsObject(oSkype)',
        'Set oSkype = nothing',
        'End Function',
        '</script>'].join("\n")
    );
}

function skypeCheck() {
    if(CantDetect) {
        return true;
    } else if(!activex) {
        var skypeMime = navigator.mimeTypes["application/x-skype"];
        detected = true;
        if(typeof(skypeMime) == "object") {
            return true;
        } else {
            return oopsPopup();
        }
    } else {
        if(isSkypeInstalled()) {
            detected = true;
            return true;
        }
    }
    
    detected = true;
    return oopsPopup();
}

function loadDetection() {
    if(document.getElementById && document.getElementsByTagName) {
        if (window.addEventListener) window.addEventListener('load', addDetection, false);
        else if (window.attachEvent) window.attachEvent('onload', addDetection);
    }
}

function addDetection() {
    var pageLinks = document.getElementsByTagName("a");
    for (var i=0; i < pageLinks.length; i++) {
        if(pageLinks[i].childNodes[0] && pageLinks[i].childNodes[0].src) {
            if((pageLinks[i].childNodes[0].src.indexOf('download.skype.com\/share\/skypebuttons') != -1 || pageLinks[i].childNodes[0].src.indexOf('mystatus.skype.com') != -1) && (typeof(pageLinks[i].onclick) == "undefined" || pageLinks[i].onclick == null)) {
                pageLinks[i].onclick = function sChk() { return skypeCheck(); }
            }
        }
    }
}

loadDetection();