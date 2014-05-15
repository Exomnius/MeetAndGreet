<div class="container">
    <div class="col-xs-12">
        <h1 class="pull-left">{title}</h1>
        <a href="{create}" class="btn btn-primary pull-right">Create Event</a>
    </div>
    <section>
        <article></article>
    </section>
</div>
<Script>
    function success(position) {
        var mapcanvas = document.createElement('div');
        mapcanvas.id = 'mapcontainer';
        mapcanvas.style.height = '400px';
        mapcanvas.className = 'text-center';

        document.querySelector('article').appendChild(mapcanvas);

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
        var map = new google.maps.Map(document.getElementById("mapcontainer"), options);

        /*var marker = new google.maps.Marker({
         position: coords,
         map: map,
         title: "You are here!"
         });*/
    }

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(success);
    } else {
        error('Geo Location is not supported');
    }

    function getMarkers() {

    }
</script>
