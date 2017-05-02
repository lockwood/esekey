(function() {

	window.onload = function(){	

	

		var latlng = new google.maps.LatLng(51.5398, -0.7058);

		var options = {

			  zoom: 13,

			  center: latlng,

			  mapTypeId: google.maps.MapTypeId.ROADMAP

		}; 

		var map = new google.maps.Map(document.getElementById('map'), options);

			

		var marker = new google.maps.Marker({

		      position: latlng,

		      map: map

		 });

	    var html = 'Sheephouse Manor';

	    var infowindow = new google.maps.InfoWindow({

			content: html,

			maxWidth: 500

		});

	    google.maps.event.addListener(marker, 'click', function() {

			infowindow.open(map,marker);

	    });

	}

})();