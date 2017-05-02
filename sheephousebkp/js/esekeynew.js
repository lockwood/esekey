<!-- hide from old browsers

var days = new Array();
days[0] = "Sunday";
days[1] = "Monday";
days[2] = "Tuesday";
days[3] = "Wednesday";
days[4] = "Thursday";
days[5] = "Friday";
days[6] = "Saturday";

var months = new Array();
months[0] = "January";
months[1] = "February";
months[2] = "March";
months[3] = "April";
months[4] = "May";
months[5] = "June";
months[6] = "July";
months[7] = "August";
months[8] = "September";
months[9] = "October";
months[10] = "November";
months[11] = "December";

$(document).ready(function() {
	
	$('body').supersleight();

 
	function megaHoverOver(){
		$(this).find(".sub").stop().fadeTo('fast', 1).show();
	}
	
	function megaHoverOut(){ 
	  $(this).find(".sub").stop().fadeTo('fast', 0, function() {
		  $(this).hide(); 
	  });
	}
 
	var config = {    
		 sensitivity: 2, // number = sensitivity threshold (must be 1 or higher)    
		 interval: 100, // number = milliseconds for onMouseOver polling interval    
		 over: megaHoverOver, // function = onMouseOver callback (REQUIRED)    
		 timeout: 500, // number = milliseconds delay before onMouseOut    
		 out: megaHoverOut // function = onMouseOut callback (REQUIRED)    
	};
 
	$("ul#menu li .sub").css({'opacity':'0'});
	$("ul#menu li").hoverIntent(config);
 
 
  	$("a[rel=gallery]").fancybox({
  		'transitionIn'		: 'elastic',
  		'transitionOut'		: 'elastic',
  		'titlePosition' 	: 'over',
  		'titleFormat'		: function(title, currentArray, currentIndex, currentOpts) {
  			return '<span id="fancybox-title-over">Gallery Image ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
  		}
	});
  
  
   	$('.flexslider').flexslider();
 
});
// end script hiding -->