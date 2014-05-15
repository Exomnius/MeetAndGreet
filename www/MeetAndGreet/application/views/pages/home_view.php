
<div class="container">
    <div class="col-xs-12 homeActionBar">
        <h1 class="pull-left">{title}</h1>

        <a href="{create}" class="btn btn-primary pull-right">Create Event</a>
    </div>
</div>

<div class="container">
    <div id="map">
    </div>
</div>

<script>
var map = null;
var currentInfoWindow = null;

$(document).ready(function(){


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
                        position: new google.maps.LatLng(data[i]['event']['latitude'], data[i]['event']['longitude']),
                        map: map
                    });
                    marker.setMap(map);
                    
                    var infowindow = new google.maps.InfoWindow();

                    bindInfoWindow(marker, map, infowindow, data[i]['infoWindow']); 

                    // google.maps.event.addListener(marker, 'click', function() {
                    //     infowindow.open(map, this);
                    //     currentInfoWindow = infowindow;
                    // });
                }
            },
            error: function(jqXHR, status, error){
                console.log('Error: ' + error);
            }
        });
    }


});

function joinEvent(id){

    $.ajax({
        url: "api/joinEvent/"+id,
        type : "GET",
        dataType:'json',
        success: function(data, status){
            if($('#joinResult').length != 0){
                $('#joinResult').remove();
            }

            if(data == -1){
                $( "<div id='joinResult' class='alert alert-warning'>You already joined this event!</div>").insertBefore( ".homeActionBar" );
            } else if(data == 0) {
                $( "<div id='joinResult' class='alert alert-success'>You could not join this event.</div>").insertBefore( ".homeActionBar" );
            } else if(data == 1){
                $( "<div id='joinResult' class='alert alert-success'>You joined this event!</div>").insertBefore( ".homeActionBar" );
            }
        },
        error: function(jqXHR, status, error){
            console.log('Error: ' + error);
        }
    });
}

function closeInfoWindow(){
    currentInfoWindow.close();
}

function bindInfoWindow(marker, map, infowindow, html) {
    google.maps.event.addListener(marker, 'click', function() {
        infowindow.setContent(html);
        infowindow.open(map, marker);
        currentInfoWindow = infowindow;
    });
    
} 
</script>
