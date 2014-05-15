
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

<Script>
$(document).ready(function(){
        

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

    function getMarkers(){
        $.ajax({
            url: "api/getMarkers",
            type : "GET",
            dataType:'json',
            success: function(data, status){
                console.log(data);
                for (var i = 0; i < data.length; i++) {
                    var marker = new google.maps.Marker({
                        position: new google.maps.LatLng(data[i]['latitude'], data[i]['longitude']),
                        map: map
                    });
                    marker.setMap(map);
                }
            },
            error: function(jqXHR, status, error){
                console.log('Error: ' + error);
            }
        });
    }
});
</script>
