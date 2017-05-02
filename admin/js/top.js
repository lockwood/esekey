// +----------------------------------------------------------------------+
// | TOP  - initialisation of Admin Console Navigation functions          |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 Esekey Limited                               |
// +----------------------------------------------------------------------+
// | Author:  Dave Lockwood <dave@esekey.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: esesite.js, V1.02 2004/12/06
//


var g_blnChangedFlag = false;
var g_strPageName    = '';
var g_strPageAction  = '';
var g_listString  = '';
var g_URL1 = '';
var g_URL2 = '';
var g_URL3 = '';
var g_currPos = '0';
var g_sidString = '';


function GoToURL(strHeading, strLinkTitle, strLinkURL) {

	sidParam = 'sid=' + g_sidString;

    topString = '<a href="#" onClick="top.Top.GoToURL(&quot;'
                + strHeading + '&quot;, &quot;'
                + strLinkTitle + '&quot;, &quot;'
                + strLinkURL + '&quot;)">' + strLinkTitle + '</a>';   

    if (top.Top.GetChangedFlag() == true) {
        strMessage = 'Unsaved changes may have been made in ' + top.Top.window.topbarhead1.innerText + top.Top.window.topbarhead2.innerText + top.Top.window.topbartext.innerText + '.\n\nPress OK to proceed to ' + strLinkTitle + ' or Cancel to stay on the current page.';
        if (confirm(strMessage)) {
            if (strHeading == '2') {
                top.Top.SetTopText('&nbsp;&gt;&nbsp;' + topString);
                g_URL3 = strLinkURL + sidParam;
                g_currPos = '2';
            } else {
                if (strHeading == '1') {
                    top.Top.SetTopHead2('&nbsp;&gt;&nbsp;' + topString);
                    top.Top.SetTopText('');
                    g_URL2 = strLinkURL + sidParam;
                    g_currPos = '1';
                } else {
                    top.Top.SetTopMenu(strHeading + '&trade;&nbsp;&gt;&nbsp;');
                    top.Top.SetTopHead1(topString);
                    top.Top.SetTopHead2('');
                    top.Top.SetTopText('');
                    g_URL1 = strLinkURL + sidParam;
                    g_currPos = '0';
                }
            }
            top.Top.SetChangedFlag(false);
            top.Workarea.location = strLinkURL + sidParam;
            g_listString = strLinkTitle; 
        }
    } else {
        if (strHeading == '2') {
            top.Top.SetTopText('&nbsp;&gt;&nbsp;' + topString);
            g_URL3 = strLinkURL + sidParam;
            g_currPos = '2';
        } else {
            if (strHeading == '1') {
                top.Top.SetTopHead2('&nbsp;&gt;&nbsp;' + topString);
                top.Top.SetTopText('');
                g_URL2 = strLinkURL + sidParam;
                g_currPos = '1';
            } else {
                top.Top.SetTopMenu(strHeading + '&trade;&nbsp;&gt;&nbsp;');
                top.Top.SetTopHead1(topString);
                top.Top.SetTopHead2('');
                top.Top.SetTopText('');
                g_URL1 = strLinkURL + sidParam;
                g_currPos = '0';
            }
        }
        top.Workarea.location = strLinkURL + sidParam;
        g_listString = strLinkTitle; 
    }
}

function BackToURL(strLinkURL) {

	if (g_currPos == '1') {
		backURL = g_URL1;
            returnString = top.Top.window.topbarhead1.innerText;
      } else {
		if (g_currPos == '2') {
			backURL = g_URL2;
	            returnString = top.Top.window.topbarhead1.innerText + top.Top.window.topbarhead2.innerText;
		} else {
                  backURL = strLinkURL;
      	      returnString = top.Top.window.topbarhead1.innerText;
		}
      }
	if (top.Top.GetChangedFlag() == true) {
		strMessage = 'Unsaved changes may have been made in ' + top.Top.window.topbarhead1.innerText + top.Top.window.topbarhead2.innerText + top.Top.window.topbartext.innerText + '.\n\nPress OK to return to ' + returnString + ' or Cancel to stay on the current page.';
		if (confirm(strMessage)) {
			top.Top.SetChangedFlag(false);
			top.Workarea.location = backURL;
                  top.Top.SetTopText('');
			if (g_currPos == '2') {
				g_currPos = '1';
			} else {
				if (g_currPos == '1') {
					g_currPos = 0;
					top.Top.SetTopHead2('');
				}
			}
		}
	} else {
		top.Workarea.location = backURL;
            top.Top.SetTopText('');
		if (g_currPos == '2') {
			g_currPos = '1';
		} else {
			if (g_currPos == '1') {
				g_currPos = 0;
				top.Top.SetTopHead2('');
			}
		}
	}
}

function SendEmail(strLinkURL) {

	strMessage = 'Do you want to send this email now?\n\nPress OK to send or Cancel to abort the request.';
	if (confirm(strMessage)) {
		top.Workarea.location = strLinkURL;
	}
}

function Logout() {

	var strMessage = 'Are you sure you wish to logout now?';
	if (confirm(strMessage)) {
            top.window.opener=self;
		top.window.close();
	}

}


function SetPageVars(strAction) {

	g_strPageAction = strAction;

      top.Top.window.topbartext.innerText = ' > ' + strAction;
	if (g_strPageAction.substring(0,4) == 'Edit') {
          top.Workarea.frmEdit.btnUpdate.disabled = true;
      }
	if (g_strPageAction == 'Add New') {
          top.Workarea.frmAdd.btnAdd.disabled = true;	
      }
	SetChangedFlag(false);

}


function SetChangedFlag(blnFlag) {

	g_blnChangedFlag = blnFlag;
	
	if (g_blnChangedFlag == true) {

		if (top.Workarea.frmEdit) {
			top.Workarea.frmEdit.btnUpdate.disabled = false;
                  if (top.Workarea.frmEdit.btnSend) {
			    top.Workarea.frmEdit.btnSend.disabled = true;
                  }
		} else if (top.Workarea.frmAdd) {
			top.Workarea.frmAdd.btnAdd.disabled = false;		
		}	
	/*	
	} else {
     
		if (top.Workarea.frmEdit) {
			top.Workarea.frmEdit.btnUpdate.disabled = true;
                  if (top.Workarea.frmEdit.btnSend) {
			    top.Workarea.frmEdit.btnSend.disabled = false;
                  }
		} else if (top.Workarea.frmAdd) {
			top.Workarea.frmAdd.btnAdd.disabled = true;		
		}	
    // */
    }
}


function GetChangedFlag() {

	return g_blnChangedFlag;

}

function GetPageName() {

	return g_strPageName;

}

function GetPageAction() {

	return g_strPageAction;

}

function SetSID(strSID) {

	g_sidString = strSID;

}
function GetSID() {

	return g_sidString;

}
