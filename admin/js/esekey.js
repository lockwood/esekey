// +----------------------------------------------------------------------+
// | EseKey  - initialisation of Admin Console Javascript functions       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: esekey.js, V1.01 2004/12/06
//

var tenantId = null;
var currentWidth = 0;
var currentHeight = 0;

function SetTopText(strText) {

	if (top.frames.length != 0) {
	    if( typeof( window.innerWidth ) == 'number' ) {
    		//Non-IE
			topbartext = top.Top.document.getElementById('topbartext');
			topbartext.innerHTML = strText;
		} else {
			//IE
			top.Top.window.topbartext.innerHTML = strText;
		}
	}

}

function SetTopMenu(strText) {

	if (top.frames.length != 0) {
	    if( typeof( window.innerWidth ) == 'number' ) {
    		//Non-IE
			topbarmenu = top.Top.document.getElementById('topbarmenu');
			topbarmenu.innerHTML = strText;
		} else {
			//IE
			top.Top.window.topbarmenu.innerHTML = strText;
		}
	}
}

function SetTopHead1(strText) {

	if (top.frames.length != 0) {
	    if( typeof( window.innerWidth ) == 'number' ) {
    		//Non-IE
			topbarhead1 = top.Top.document.getElementById('topbarhead1');
			topbarhead1.innerHTML = strText;
		} else {
			//IE
			top.Top.window.topbarhead1.innerHTML = strText;
		}
	}
}

function SetTopHead2(strText) {

	if (top.frames.length != 0) {
	    if( typeof( window.innerWidth ) == 'number' ) {
    		//Non-IE
			topbarhead2 = top.Top.document.getElementById('topbarhead2');
			topbarhead2.innerHTML = strText;
		} else {
			//IE
			top.Top.window.topbarhead2.innerHTML = strText;
		}
	}
}

function Initialise(strAction, strFormName, blnHasErrors) {
	
	if (top.frames.length != 0) {
		top.Top.SetPageVars(strAction, strFormName, blnHasErrors);
	}

}


function CheckSubmit() {

	if (tenantId != null) {
		var strTitle = document.frmEdit.title_t.value;
		var strFirstName = document.frmEdit.first_name_t.value;
		var strLastName = document.frmEdit.last_name_t.value;
		var strPostAddress = document.frmEdit.post_address_t.value;
		var strPostCode = document.frmEdit.post_code_t.value;
		var strTelephone = document.frmEdit.telephone_t.value;
		var strTelephoneAlt = document.frmEdit.telephone_alt_t.value;
		var strEmail = document.frmEdit.email_t.value;
		if (strTitle == '' && strFirstName == '' && strLastName == '' && strPostAddress == '' && strPostCode == ''
		    && strTelephone == '' && strTelephoneAlt == '' && strEmail == '') { // no data
			if (tenantId == '000000000') { // no tenant either! no problem then.
				// alert('No tenant, no change');
			} else { // request to remove tenant details from booking
				if (!confirm('To remove the tenant details from this booking select OK. Otherwise select Cancel, then select Back to ensure that you keep the existing tenant details')) {
					return false;
				}
			}
		} else { // if we get here, then there is some tenant data
			if (tenantId == '000000000') { // this will be a new tenant - must have at least surname & email address
				if (document.frmEdit.last_name_t.value == '' || document.frmEdit.email_t.value =='') {
					alert('To add a tenant to this booking, you must enter at least the Last Name and Email Address');
					return false; 
				}
			} else {
				if (document.frmEdit.last_name_t.value == '' || document.frmEdit.email_t.value =='') {
					alert('To remove the tenant from this booking, please ensure that all the tenant details are blank.');
					return false; 
				}
			}
		}
	}
	document.frmEdit.submit();
}


function SetTenantId(strTenantId) {

	tenantId = strTenantId;
}


function ChangeMade() {

	top.Top.SetChangedFlag(true);
}

function ShowPic(elem) {

  for(i=0; i<elem.options.length; i++)
  {
    if(elem.options[i].value==elem.value)
    {
      if (elem.value=='')
      {
        document.getElementById('noimg').style.display='';
      } else
      {
        document.getElementById(elem.options[i].value).style.display='';
      }      
    } else
    {
      if (elem.options[i].value=='')
      {
        document.getElementById('noimg').style.display='none';
      } else
      {
        document.getElementById(elem.options[i].value).style.display='none';
      }      
    }
  }
}

function GoHome() {

	window.location = 'intro.html';

}


function GoBack() {

	history.back();

}


function doConfirmSubmit(msgString) {

	var strMessage = msgString;
	if (confirm(strMessage)) {
	    document.forms[0].submit();
	}

}

function GoDisable() {

	var strMessage = 'This option will disable the current record and make it unavailable for queries throughout the system.\n\nAre you sure you wish to continue?';
	confirm(strMessage);
	
}

function doHover(elem) {

	 elem.style.backgroundColor='gold';
	 elem.style.cursor='pointer';
	 elem.title='Click here';
	 return window.status='EseBooking\u2122 > Selected Property > Add Invoice Reminder'; 
}

function noHover(elem) {

	 if (elem.className == 'awC') {
	 	elem.style.backgroundColor='#FFCCCC';
	 } else if (elem.className == 'C') {
	 	elem.style.backgroundColor='red';
	 } else if (elem.className == 'awP' || elem.className == 'P') {
	 	elem.style.backgroundColor='#FFFF88';
	 } else {
	 	elem.style.backgroundColor='#BBFF88';
	 }
	 return window.status=''; 
}

function invSet(strDate) {

	alert(strDate);
}

function ScaleTable() {
  if (!(document.getElementById("scrollmaster"))) {
  	return;
  }
  var myWidth = 0, myHeight = 0;
  if( typeof( window.innerWidth ) == 'number' ) {
    //Non-IE
    myWidth = window.innerWidth;
    myHeight = window.innerHeight;
  } else if( document.documentElement && ( document.documentElement.clientWidth || document.documentElement.clientHeight ) ) {
    //IE 6+ in 'standards compliant mode'
    myWidth = document.documentElement.clientWidth;
    myHeight = document.documentElement.clientHeight;
  } else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) {
    //IE 4 compatible
    myWidth = document.body.clientWidth;
    myHeight = document.body.clientHeight;
  }
  if (myWidth > 500) {
	var tableWidth = myWidth - 270;
	var hdrWidth = myWidth - 287;
	document.getElementById("scrollmaster").style.width = tableWidth + 'px';
	document.getElementById("static_top").style.width = hdrWidth + 'px';
  }
  if (myHeight > 300) {
	var tableHeight = myHeight - 170;
	var hdrHeight = myHeight - 187;
	document.getElementById("scrollmaster").style.height = tableHeight + 'px';
	document.getElementById("static_left").style.height = hdrHeight + 'px';
  }
}

function NoRightClick() {
	return;
	var strTagName = event.srcElement.tagName;
	if ((event.button == 3||event.button==2) && (strTagName != 'INPUT') && (strTagName != 'TEXTAREA')) {
		alert('This feature has been disabled.');
		return false;
	}
}

function KeyHandler() {
      if (event.ctrlKey && ( event.keyCode == 78 || event.keyCode == 110) ) {
          event.returnValue = false;
      }
      
      if (event.shiftKey && event.keyCode == 51) {
    	  alert('Please do not use the pound sign!')
    	  return false;
      }
	
	var strTagName = event.srcElement.tagName;
	
	if ((window.event) && (window.event.keyCode == 8) && (strTagName != 'INPUT') && (strTagName != 'TEXTAREA')) {
          alert('This feature has been disabled.');
          return false;
      }
}

function ShowHideTenant() {
	if (document.all.now_or_later.value == 'Add Now...') {
		document.all.now_or_later.value = 'Add Later...';
		document.all.add_tenant.value = 'yes';
		document.all.tenant0.style.display = "";
		document.all.tenant1.style.display = "";
		document.all.tenant2.style.display = "";
		document.all.tenant3.style.display = "";
		document.all.tenant4.style.display = "";
		document.all.tenant5.style.display = "";
		document.all.tenant6.style.display = "";
	} else {
		document.all.now_or_later.value = 'Add Now...';
		document.all.add_tenant.value = 'no';
		document.all.tenant0.style.display = "none";
		document.all.tenant1.style.display = "none";
		document.all.tenant2.style.display = "none";
		document.all.tenant3.style.display = "none";
		document.all.tenant4.style.display = "none";
		document.all.tenant5.style.display = "none";
		document.all.tenant6.style.display = "none";
	};
}

function Swap_BB_SC() {
	if (document.all.bb_or_sc.value == 'Switch to Self Catering...') {
		document.all.bk_label.innerHTML = 'New Self Catering Booking';
		document.all.bb_or_sc.value = 'Switch to B&B...';
		document.all.book_bb.value = 'no';
		document.all.sc_div.style.display = "";
		document.all.bb_div.style.display = "none";
		document.all.status.style.display = "none";
	} else {
		document.all.bk_label.innerHTML = 'New Bed & Breakfast Booking';
		document.all.bb_or_sc.value = 'Switch to Self Catering...';
		document.all.book_bb.value = 'yes';
		document.all.sc_div.style.display = "none";
		document.all.bb_div.style.display = "";
		document.all.status.style.display = "none";
	};
}

// This is a function that returns a function that is used
// in the event listener
function getOnScrollFunction(oElement) {
	if (oElement.attachEvent)
	{
		// MSIE
		return function () {
			if (oElement._scrollSyncDirection == "horizontal" || oElement._scrollSyncDirection == "both")
				oElement.scrollLeft = event.srcElement.scrollLeft;
			if (oElement._scrollSyncDirection == "vertical" || oElement._scrollSyncDirection == "both")
				oElement.scrollTop = event.srcElement.scrollTop;
		};
	} else
	{
		// Firefox
		return function () {
			if (oElement._scrollSyncDirection == "horizontal" || oElement._scrollSyncDirection == "both")
				oElement.scrollLeft = event.target.scrollLeft;
			if (oElement._scrollSyncDirection == "vertical" || oElement._scrollSyncDirection == "both")
				oElement.scrollTop = event.target.scrollTop;
		};
	}

}
// This function adds scroll syncronization for the fromElement to the toElement
// this means that the fromElement will be updated when the toElement is scrolled
function addScrollSynchronization(fromElement, toElement, direction) {
	removeScrollSynchronization(fromElement);
	
	fromElement._syncScroll = getOnScrollFunction(fromElement);
	fromElement._scrollSyncDirection = direction;
	fromElement._syncTo = toElement;
	if (toElement.attachEvent)
	{
		toElement.attachEvent("onscroll", fromElement._syncScroll);
	} else 
	{
		toElement.addEventListener("scroll", fromElement._syncScroll, false);
	}
}

// removes the scroll synchronization for an element
function removeScrollSynchronization(fromElement) {
	if (fromElement._syncTo != null)
	{
		if (fromElement._syncTo.detachEvent)
		{
			fromElement._syncTo.detachEvent("onscroll", fromElement._syncScroll);
		} else
		{
			fromElement._syncTo.removeEventListener("scroll", fromElement._syncScroll);
		}
	}

	fromElement._syncTo = null;;
	fromElement._syncScroll = null;
	fromElement._scrollSyncDirection = null;
}

function setScrollSync() {
	addScrollSynchronization(document.getElementById("static_left"), 
	document.getElementById("scrollmaster"), "vertical");
	addScrollSynchronization(document.getElementById("static_top"), 
	document.getElementById("scrollmaster"), "horizontal");
}
