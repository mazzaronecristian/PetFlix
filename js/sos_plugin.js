(function($){
	$.fn.sos = function(){
		return this.each(function(i,obj){
			let $this = $(this);
			let sos_btn = document.getElementById("sos-btn");
			let overlay = document.getElementsByClassName("overlay");
		 	let $closeButton = $('.close-button', $this);
			let $overlay = $(overlay);
			let $sos_btn = $(sos_btn);

			$sos_btn.on('click', function() {
				$this.addClass('active');
				$overlay.addClass('active');
			});

			$overlay.on('click', function() {
				$this.removeClass('active');
				$overlay.removeClass('active');
			});

			$closeButton.on('click', function() {
				$this.removeClass('active');
				$overlay.removeClass('active');
			});
		});
	}
})(jQuery);

function myMap(){
	var mapProp= {
			center:new google.maps.LatLng(51.508742,-0.120850),
			zoom:1,
			disableDefaultUI: true
	};	
	var map = new google.maps.Map(document.getElementById("googleMap"), mapProp);

	const placeService = new google.maps.places.PlacesService(map)

	var request = {
		query : 'veterinario vicino a me',
		fields :['name', 'geometry']
	};

	placeService.findPlaceFromQuery(request, (results, status) => {
	  if (status == google.maps.places.PlacesServiceStatus.OK) {
	    results.forEach((item) => {
	      console.log(item)
	      // place_id, name, formatted_address, geometry.location, icon
	    });
	  }
	});
}