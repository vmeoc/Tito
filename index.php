<html>
    <html lang="en">
<head>
  <title>Tito</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
 
    <div class="jumbotron text-center">
  <h1>Tito</h1>
  <img src="bouchons-home7-banner.png"  class="img-rounded" style="display:inline" alt="Bird">
  <p>Time Traffic Optimizer</p>
  <br>By vince :)</br>
</div>
 
    
<form class="form-horizontal" role="form" method="post" action="index.php">
	<div class="form-group">
		<label for="name" class="col-sm-2 control-label">Name</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="name" name="name" placeholder="First & Last Name" value="">
		</div>
	</div>
	<div class="form-group">
		<label for="home" class="col-sm-2 control-label">Home</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="home" name="home" placeholder="Home Address" value="">
		</div>
	</div>
    	<div class="form-group">
		<label for="work" class="col-sm-2 control-label">Work</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="work" name="work" placeholder="Work Address" value="">
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-10 col-sm-offset-2">
			<input id="submit" name="submit" type="submit" value="Send" class="btn btn-primary">
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-10 col-sm-offset-2">
			<! Will be used to display an alert to the user>
		</div>
	</div>
    
     
</form>
<div class="jumbotron text-center">
    <iframe width="600" height="450" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/directions?origin=verri%C3%A8res%20le%20buisson&destination=La%20d%C3%A9fense&key=AIzaSyA5ZDRG9r8hBWrtlGsEuJKU2KBg_cCV_Qk" allowfullscreen></iframe>
     </div>
   <script>
      // This example displays an address form, using the autocomplete feature
      // of the Google Places API to help users fill in the information.

      // This example requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
    //<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA5ZDRG9r8hBWrtlGsEuJKU2KBg_cCV_Qk&libraries=places">

      var placeSearch, autocomplete;
     

      function initAutocomplete() {
        // Create the autocomplete object, restricting the search to geographical
        // location types.
        autocomplete = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */(document.getElementById('home')),
            {types: ['geocode']}); autocomplete = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */(document.getElementById('work')),
            {types: ['geocode']});

        
      }

      // Bias the autocomplete object to the user's geographical location,
      // as supplied by the browser's 'navigator.geolocation' object.
      function geolocate() {
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var geolocation = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
            var circle = new google.maps.Circle({
              center: geolocation,
              radius: position.coords.accuracy
            });
            autocomplete.setBounds(circle.getBounds());
          });
        }
      }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA5ZDRG9r8hBWrtlGsEuJKU2KBg_cCV_Qk&libraries=places&callback=initAutocomplete"
        async defer></script>
  </body>  
</body>
</html>