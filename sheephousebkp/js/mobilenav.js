
	var state = 'none';
	
	function showhide(layer_ref) {
	
	if (state == 'block') {
	state = 'none';
	$(".menuToggle").html("Show Navigation");
	}
	else {
	state = 'block';
	// Make the content div fade in
	$("#menu").hide();
	$('#menu').fadeIn(200);
	$('#menu').slideDown(200);
	
	$(".menuToggle").html("Close");
	}
	
	if (document.all) { //IS IE 4 or 5 (or 6 beta)
	eval( "document.all." + layer_ref + ".style.display = state");
	}
	if (document.layers) { //IS NETSCAPE 4 or below
	document.layers[layer_ref].display = state;
	}
	if (document.getElementById &&!document.all) {
	hza = document.getElementById(layer_ref);
	hza.style.display = state;
	}
	}