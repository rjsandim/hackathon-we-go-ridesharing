<div id = "wrapper">

	<div id = "drawer">

		<div id="drawerWrapper">
			<div><p>Find a Rideshare near you by typing you location and destination</p></div><br>
			<div class="InputLocationForm">

				<div id="locationA">A</div>
				<input id="origin" class="inputLocation" type="text" name="origin" value="" placeholder="Origin"><br>
				<br>
				<div id="locationB">B</div>
				<input id="destination" class="inputLocation" type="text" name="destination" value="" placeholder="Destination"><br>
				<br>
				<button class="sendButton" type="" name="commit" value="SUBMIT">Get a Ride</button>

			</div>
		</div>

	</div>
	<div id = "topBar">
		<div id = "drawDiv">
			<a><i class="fa fa-taxi" aria-hidden="true"></i></a>
		</div>
	</div>
	<div id = "myBody"></div>
</div>

<section id="background"></section>

<script type="text/javascript">

	var gMarkers = [{lat:0,lng:0,infoWindow:{content:null}}];
	var rMarkers = [];

	GMaps.prototype.addMarkersOfType = function (type) {
		var theMap = this.map;
		rMarkers[type]=[];
		$.each(gMarkers[type],function(index, obj){
			//console.log(obj);
			var marker = map.addMarker(obj);
			rMarkers[type].push(marker);
		});
	}

	GMaps.prototype.removeMarkersOfType = function (type) {
		$.each(rMarkers[type],function(index, obj){
			obj.setMap(null);
		});
		rMarkers[type]=[];
	}

	function setNewMarker(type, lat, long){
		console.log("setNewMarker");
		if(gMarkers[type][0].lat==0){
			gMarkers[type] = [{lat:lat, lng:long, infoWindow:{content:type}}];
			console.log(gMarkers[type][0].lng);
			map.addMarkersOfType(type);
		}else{
			removeMarker(type);
			gMarkers[type] = [{lat:lat, lng:long, infoWindow:{content:type}}];
			console.log(gMarkers[type][0].lng);
			map.addMarkersOfType(type);
		}
	}

	function createMatchList(lat_origin, lng_origin, lat_dest, lng_dest){
		$.ajax({
			dataType: "json",
			url: "webservice/match/getPeopleNearby/"+getAddressFromCoord(lat_origin, lng_origin)+"/"+getAddressFromCoord(lat_dest, lng_dest),
			success: function(data){//Testar se cors funciona
				console.log("matchlist");//Falta algoritimo pra injetar lista. Lucas está finalizando
			}
		});
	}

	function changeListener(type){
		GMaps.geocode({
			address: $('#'+type+'').val(),
			callback: function(results, status) {
				if (status == 'OK') {
					var latlng = results[0].geometry.location;
					console.log(latlng);
					map.setCenter(latlng.lat(), latlng.lng());
					setNewMarker(type, latlng.lat(), latlng.lng());
				}
			}
		});
	}

	function removeMarker(type){
		console.log("removeMarker");
		map.removeMarkers();
		if(type=='destination'){//Restores oposite marker
			map.addMarkersOfType('origin');
		}else{
			map.addMarkersOfType('destination');
		}
		gMarkers[type] = [{lat:0,lng:0,infoWindow:{content:null}}];
	}

	function getAddressFromCoord(lat, lng){
		var result;
		$.ajax({
			dataType: "json",
			url: "http://maps.googleapis.com/maps/api/geocode/json?latlng="+lat+","+lng, //WORKING
			async: false,
			success: function(data){
				result = data.results[0].formatted_address
			}
		});
		return result;
	}

	$(document).ready(function(){
		gMarkers['origin'] = [{lat:0,lng:0,infoWindow:{content:null}}];
		gMarkers['destination'] = [{lat:0,lng:0,infoWindow:{content:null}}];
		var origin = document.getElementById("origin");
		var destination = document.getElementById("destination");
		console.log($("#myBody").parent().height());
		var a = 0;
		window.map = new GMaps({//Start new map
			div: '#myBody',
			lat: 0,
			lng: 0
		});

		$("#drawDiv").click(function(){
			console.log(a);
			if(a==0){
				a=1;
				$("#drawer").css("margin-top", "0px");
			}else{
				a=0;
				$("#drawer").css("margin-top", "-400px");
			}
		});

		GMaps.geolocate({//Start maps with your current location
			success: function(position, responses) {
				map.setCenter(position.coords.latitude, position.coords.longitude);
				console.log(position.coords.latitude+" "+position.coords.longitude);
				gMarkers['origin'] = [{lat:0,lng:0,infoWindow:{content:null}}];
				setNewMarker('origin', position.coords.latitude, position.coords.longitude);
				origin.value = getAddressFromCoord(position.coords.latitude, position.coords.longitude);
			},
			error: function(error) {
				console.log('Geolocation failed: '+error.message);
			},
			not_supported: function() {
				console.log("Your browser does not support geolocation");
			},
			always: function() {
				console.log("Done!");
			}
		});//Map finished starting

		$(document).on("keyup",'#origin' ,function(e) {
			console.log(e.which);
			if (e.which == 13) {
				console.log("Enter pressed");
				changeListener('origin');
				return false;
			}
		});

		$(document).on("keyup",'#destination' ,function(e) {
			console.log(e.which);
			if (e.which == 13) {
				console.log("Enter pressed");
				changeListener('destination');
				return false;
			}
		});

		$('.sendButton').click(function(){//Get a ride on click
			var lat_origin = gMarkers['origin'][0].lat;
			var lng_origin = gMarkers['origin'][0].lng;
			var lat_dest = gMarkers['destination'][0].lat;
			var lng_dest = gMarkers['destination'][0].lng;

			console.log("Lat Origin: "+lat_origin);
			console.log("Lng Origin: "+lng_origin);
			console.log("Lat Dest: "+lat_dest);
			console.log("Lng Dest: "+lng_dest);

			map.drawRoute({
				origin: [lat_origin, lng_origin],
				destination: [lat_dest, lng_dest],
				travelMode: 'driving',
				strokeColor: '#131540',
				strokeOpacity: 0.6,
				strokeWeight: 6
			});

			map.drawRoute({
				origin: [lat_origin, lng_origin],
				destination: [lat_dest, lng_dest],
				travelMode: 'driving',
				strokeColor: '#131540',
				strokeOpacity: 0.6,
				strokeWeight: 6,
			});

			map.getRoutes({
				origin: [lat_origin, lng_origin],
				destination: [lat_dest, lng_dest],
				provideRouteAlternatives: true,
				callback: function (e) {
					var time = 0;
					var distance = 0;
					for (var i=0; i<e[0].legs.length; i++) {
						time += e[0].legs[i].duration.value;
						distance += e[0].legs[i].distance.value;
					}
					alert("Distância: " + distance/1000+"km");
				}
			});

			createMatchList(lat_origin, lng_origin, lat_dest, lng_dest);
		});

		$("#locationA").click(function(){
			changeListener('origin');
		});

		$("#locationB").click(function(){
			changeListener('destination');
		});
	});
</script>