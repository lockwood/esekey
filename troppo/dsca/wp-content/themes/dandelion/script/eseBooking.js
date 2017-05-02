/**
 * This is the script to open EseBooking in a new window.
 * @author Esekey Limited
 * http://www.esekey.com
 */
function DoPopup(serverName) {

      var targetUrl = 'https://' + serverName + '/troppo/idxs.php?p=13&conditions=Accept';
      var windowName = 'newWindow00003';
      var browserParms = 'width=780,height=598,scrollbars=yes,copyhistory=no,status=no,resizable=yes';
      var newWindow = window.open(targetUrl, windowName, browserParms); 
      newWindow.focus();
}

