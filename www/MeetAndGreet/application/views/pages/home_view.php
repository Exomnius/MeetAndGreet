
<div class="container">
    <div class="col-xs-12">
        <h1 class="pull-left">{title}</h1>
        <a href="{create}" class="btn btn-primary pull-right">Create Event</a>
    </div>
</div>

<div class="container">
    <div id="map">
    </div>
</div>
<form>
    <input id="geocomplete" type="text" placeholder="Type in an address" value="Empire State Bldg" autocomplete="off">
    <input id="find" type="button" value="find">
    <fieldset class="details">
        <h3>Address-Details</h3>

        <label>Latitude</label>
        <input name="lat" type="text" value="">

        <label>Longitude</label>
        <input name="lng" type="text" value="">

        <label>Location</label>
        <input name="location" type="text" value="">

        <label>Location Type</label>
        <input name="location_type" type="text" value="">

        <label>Formatted Address</label>
        <input name="formatted_address" type="text" value="">

        <label>Bounds</label>
        <input name="bounds" type="text" value="">

        <label>Viewport</label>
        <input name="viewport" type="text" value="">

        <label>Route</label>
        <input name="route" type="text" value="">

        <label>Street Number</label>
        <input name="street_number" type="text" value="">

        <label>Postal Code</label>
        <input name="postal_code" type="text" value="">

        <label>Locality</label>
        <input name="locality" type="text" value="">

        <label>Sub Locality</label>
        <input name="sublocality" type="text" value="">

        <label>Country</label>
        <input name="country" type="text" value="">

        <label>Country Code</label>
        <input name="country_short" type="text" value="">

        <label>State</label>
        <input name="administrative_area_level_1" type="text" value="">

        <label>ID</label>
        <input name="id" type="text" value="">

        <label>URL</label>
        <input name="url" type="text" value="">

        <label>Website</label>
        <input name="website" type="text" value="">
    </fieldset>
</form>
<Script>
    $(document).ready(function() {
        var map = null;

        function success(position) {
            var mapcanvas = document.createElement('div');
            mapcanvas.id = 'mapcontainer';
            mapcanvas.style.height = '400px';
            mapcanvas.className = 'text-center';

            document.querySelector('#map').appendChild(mapcanvas);

            var coords = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);

            var options = {
                zoom: 15,
                center: coords,
                mapTypeControl: false,
                navigationControlOptions: {
                    style: google.maps.NavigationControlStyle.SMALL
                },
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };

            map = new google.maps.Map(document.getElementById("mapcontainer"), options);

            // var marker = new google.maps.Marker({
            //     position: coords,
            //     map: map,
            //     title: "You are here!"
            // });

            getMarkers();
        }

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(success);
        } else {
            error('Geo Location is not supported');
        }

        function getMarkers() {
            $.ajax({
                url: "api/getMarkers",
                type: "GET",
                dataType: 'json',
                success: function(data, status) {
                    console.log(data);
                    for (var i = 0; i < data.length; i++) {
                        var marker = new google.maps.Marker({
                            position: new google.maps.LatLng(data[i]['latitude'], data[i]['longitude']),
                            map: map
                        });
                        marker.setMap(map);
                    }
                },
                error: function(jqXHR, status, error) {
                    console.log('Error: ' + error);
                }
            });
        }
    });
    
    $("input").geocomplete({map: ".map"})
    $(function() {
        $("#geocomplete").geocomplete({
            map: ".map",
            details: ".details",
            types: ["geocode", "establishment"]
        });

        $("#find").click(function() {
            $("#geocomplete").trigger("geocode");
        });
    });
</script>
