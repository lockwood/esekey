var ta=ta||{};ta.cds=ta.cds||{};ta.cds.handleTALink=function(d,b){if(typeof(Cookie)!=="undefined"&&typeof(Cookie.writeSession)!=="undefined"&&typeof(cookieDomain)!=="undefined"&&Cookie&&Cookie.writeSession&&cookieDomain&&window.location.hostname.match(cookieDomain)){if(Cookie.writeSession("MC",d)){return true}}if(typeof(b)==="undefined"){return false}var a=null;if(typeof(b.pathname)==="string"){a=b.pathname}else{if(typeof(b.action)==="string"){var e=document.createElement("a");e.href=b.action;a=e.pathname}else{return false}}var c=a.split(".");c[0]=c[0]+"-m"+d;a=c.join(".");if(typeof(b.pathname)==="string"){b.pathname=a}else{if(typeof(b.action)==="string"){e.pathname=a;b.action=e.href}}return true};ta.cds.widgetErrors={noReviews:"TA_noReviews",widgetError:"TA_widgetError"};ta.cds.msgPartner=function(a){window.parent.postMessage(a,"*")};ta.cds.sendWidgetInfo=function(b,d){var e=window.document;var a=Math.max(e.body.scrollHeight,e.documentElement.scrollHeight,e.body.offsetHeight,e.documentElement.offsetHeight,e.body.clientHeight,e.documentElement.clientHeight);var c=Math.max(e.body.scrollWidth,e.documentElement.scrollWidth,e.body.offsetWidth,e.documentElement.offsetWidth,e.body.clientWidth,e.documentElement.clientWidth);var g={frameName:window.name,widgetData:{width:c,height:a}};if(d){for(var f in d){g.widgetData[f]=d[f]}}if(b){g.error=b}ta.cds.msgPartner(g);ta.cds.msgPartner(JSON.stringify(g))};ta.cds.informPartnerOfError=function(){ta.cds.msgPartner(ta.cds.widgetErrors.widgetError);ta.cds.sendWidgetInfo(ta.cds.widgetErrors.widgetError)};ta.cds.addOnload=function(a,c){c=c||window;var b=c.onload;if(typeof c.onload!="function"){c.onload=a}else{c.onload=function(){b&&b();a&&a()}}};