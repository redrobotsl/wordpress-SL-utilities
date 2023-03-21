if (typeof(sl) === 'undefined') {
    var sl = {};
}
sl.teleport = {
  init: function() {
    sl.teleport.data.uaString = navigator.userAgent.toLowerCase();
    if ( (sl.teleport.data.uaString.indexOf('safari') !== -1) && (sl.teleport.data.uaString.indexOf('chrome') == -1) ) { return; }
    // Check for direct SLurl in hidden element.
    sl.teleport.data.teleportLinks = document.getElementsByTagName('a');
    for(var i=0;i<sl.teleport.data.teleportLinks.length;i++){
     
        sl.teleport.data.originalLink = sl.teleport.data.teleportLinks[i].href;
        sl.teleport.data.teleportLinks[i].addEventListener("click", function(event){
            event.preventDefault();
            if (sl.teleport.data.uaString.indexOf('msie') !== -1 ||
                sl.teleport.data.uaString.indexOf('trident') !== -1 ||
                sl.teleport.data.uaString.indexOf('edge') !== -1) {
                 if (navigator.appVersion.indexOf('6.1') !== -1) {
                    // Handle Windows 7
                    sl.teleport.helper.launchMozilla( this.getAttribute('href') );
                 } else {
                    //Handle Windows > 7
                    sl.teleport.helper.launchIE( this.getAttribute('href') );
                 }
                } else if (sl.teleport.data.uaString.indexOf('chrome') !== -1) {
                   sl.teleport.helper.launchChrome( this.getAttribute('href') );
                } else if ( (sl.teleport.data.uaString.indexOf('mozilla') !== -1)){
                   sl.teleport.helper.launchMozilla( this.getAttribute('href') );
                } else {
                  location.href = sl.teleport.data.teleportLinks[i].href; }
            }, false);
     }
  },

  data: {
    slUrl: "",
    joinLink: "https://join.secondlife.com/",
    originalLink: "",
    protocol: "",
    teleportLinks: [],
    urlSplit: [],
    urls: [],
    urlArray: [],
    uaString: "",
    isSupported: false
  },

  helper: {
    setUrls: function( targetUrl ) {
      sl.teleport.data.urlSplit = targetUrl.split("/");
      sl.teleport.data.protocol = sl.teleport.data.urlSplit[0];
      if (sl.teleport.data.protocol == "http:") {
          if (sl.teleport.data.urlSplit[2].indexOf('maps.secondlife.com') == -1) {
            window.location = targetUrl;
            return;
          }
          sl.teleport.data.slUrl = sl.teleport.helper.getSlUrl( targetUrl );
      } else if (sl.teleport.data.protocol == "https:") {
        if (sl.teleport.data.urlSplit[2].indexOf('maps.secondlife.com') == -1) {
          window.location = targetUrl;
          return;
        }
        sl.teleport.data.slUrl = sl.teleport.helper.getSlUrl( targetUrl );
    } 
      
      else if ( sl.teleport.data.protocol == "secondlife:"){
          sl.teleport.data.slUrl = targetUrl;
      } else {
          location.href = targetUrl;
      }
        sl.teleport.data.urls = [sl.teleport.data.slUrl,sl.teleport.data.joinLink];
        return sl.teleport.data.urls;
    },

    getSlUrl: function(targetUrl){
      sl.teleport.data.urlArray = targetUrl.split("/");
      sl.teleport.data.slUrl = 'secondlife://' + sl.teleport.data.urlArray[4] +  '/' + sl.teleport.data.urlArray[5] + '/' + sl.teleport.data.urlArray[6] + '/' + sl.teleport.data.urlArray[7];
      return sl.teleport.data.slUrl;
    },

    //Handle IE
    launchIE: function(targetUrl){
      if(targetUrl.search(/secondlife/) == -1){
        return;

      }
      sl.teleport.data.urls = sl.teleport.helper.setUrls( targetUrl );
      sl.teleport.data.slUrl = sl.teleport.data.urls[0];
      sl.teleport.data.joinLink = sl.teleport.data.urls[1];

      var url = sl.teleport.data.slUrl;

      navigator.msLaunchUri(url,
        function()
        {
          window.location = sl.teleport.data.slUrl;
        },
        function()
        {
          window.location = sl.teleport.data.joinLink;
        }
      );
    },

    //Handle Firefox
    launchMozilla: function(targetUrl){
      sl.teleport.data.urls = sl.teleport.helper.setUrls( targetUrl );
      sl.teleport.data.slUrl = sl.teleport.data.urls[0];
      sl.teleport.data.joinLink = sl.teleport.data.urls[1];
      var iFrame = document.getElementById("hiddenIframe");
      sl.teleport.data.isSupported = false;
      try{
          iFrame.contentWindow.location.href = sl.teleport.data.slUrl;
          sl.teleport.data.isSupported = true;
      }catch(e){
          if (e.name == "NS_ERROR_UNKNOWN_PROTOCOL"){
            sl.teleport.data.isSupported = false;
            window.location = sl.teleport.data.joinLink;
          }
        }
    },

    //Handle Chrome
    launchChrome: function (targetUrl){

      if(targetUrl.search(/secondlife/) == -1){
      return       window.location = targetUrl;


      }
      sl.teleport.data.urls = sl.teleport.helper.setUrls( targetUrl );
      sl.teleport.data.slUrl = sl.teleport.data.urls[0];
      sl.teleport.data.joinLink = sl.teleport.data.urls[1];
      //protocoLelement = $('#protocol')[0];
      var protocolElement = document.getElementById("protocol");
      sl.teleport.data.isSupported = false;

      protocolElement.focus();
      protocolElement.onblur = function(){
          sl.teleport.data.isSupported = true;
      };

      //will trigger onblur
      location.href = sl.teleport.data.slUrl;

      //Note: timeout could vary as per the browser version, have a higher value
      setTimeout(function(){
          protocolElement.onblur = null;
            if (sl.teleport.data.isSupported) {
             //location.href = targetUrl;
            } else {
                location.href = sl.teleport.data.joinLink;
            }
        }, 500);
    }
  }
}

document.addEventListener("DOMContentLoaded", function(event) {
  // These hidden elements are used to test for protocol support and must be added to the DOM
  var hiddenFields = document.createElement("div");
  hiddenFields.style.width = 0;
  hiddenFields.style.height = 0;
  hiddenFields.style.overflow = "hidden";

  var input = document.createElement("input");
  input.id = "protocol";
  input.value="";
  input.placeholder="custom protocol"
  hiddenFields.appendChild(input);

  var hiddenIframe = document.createElement("iframe");
  hiddenIframe.setAttribute("id", "hiddenIframe");
  hiddenIframe.src = "about:blank";
  hiddenFields.appendChild(hiddenIframe);

  var hiddenAnchor = document.createElement("a");
  hiddenAnchor.href = "#";
  hiddenAnchor.id = "hiddenLink";
  hiddenAnchor.innerHTML = "custom protocol";
  hiddenFields.appendChild(hiddenAnchor);

  document.body.appendChild(hiddenFields);

  sl.teleport.init();
});