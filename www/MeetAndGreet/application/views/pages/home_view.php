<div class="progress_bar_container">
    <div class="container">  
      {bar_progress}
    </div>
</div>

<div class="container">
    <div class="col-xs-12 homeActionBar">
        {createEvent}
    </div>
</div>

<div class="container">
    <div id="map">
    </div>
</div>

<div id="createModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title">Create an Event!</h3>
            </div>
            <div class="modal-body">
                {form_open}
                <div class="form-group">
                    <label for="eventName" class="control-label col-lg-3">Event Name:</label>
                    <div class="col-lg-6">
                        <input type="text" name="eventName" class="form-control"/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="eventTime" class="control-label col-lg-3">Start:</label>
                    <div class="col-lg-6">
                        <div class='input-group date' id="dtpStart">
                            <input type='text' name="eventTime" class="form-control" readonly value="{start}" />
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                            </span> 
                        </div>
                    </div>
                </div> 
                <div class="form-group">
                    <label for="eventCategory" class="control-label col-lg-3">Event Category:</label>
                    <div class="col-lg-6">
                        <select name="eventCategory" class="form-control">
                            {categories}
                            <option value="{id}">{name}</option>
                            {/categories}
                        </select>
                    </div>
                </div> 
                <div class="form-group">
                    <label for="eventDescription" class="control-label col-lg-3">Description:</label>
                    <div class="col-lg-6">
                        <textarea name="eventDescription" class="form-control" style="width: 100%;"></textarea>
                    </div>
                </div> 
                <div class="form-group">
                    <label for="eventLocation" class="control-label col-lg-3">Location:</label>
                    <div class="col-lg-6">
                        <input type="text" id="geocomplete" class="form-control" name="eventLocation"/>
                    </div>
                </div> 
                <!-- <div class="eventMap"></div> -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>

                <div id="coords">
                    <input type="hidden" name="lat" value="" />
                    <input type="hidden" name="lng" value="" />
                </div>
                {form_close}
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->



<script>
    $(document).ready(function() {

        $('#dtpStart').datetimepicker({
            language: 'en',
            format: 'YYYY-M-d hh:mm:ss A'
        });

        var map = null;
        var currentInfoWindow = null;
        var messagesCount = -1;

        function success(position) {
            var mapcanvas = document.createElement('div');
            mapcanvas.id = 'mapcontainer';
            mapcanvas.style.height = '600px';
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
            getMarkers();
            getFriendMarkers();
        }

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(success);
            navigator.geolocation.getCurrentPosition(updateLastLogin);
        } else {
            error('Geo Location is not supported');
        }

        function getFriendMarkers() {
            $.ajax({
                url: "api/getFriends",
                type: "GET",
                dataType: 'json',
                success: function(data, status) {

                    for (var i = 0; i < data.length; i++) {

                        var marker = new google.maps.Marker({
                            position: new google.maps.LatLng(data[i]['user']['latitude'], data[i]['user']['longitude']),
                            icon: '/assets/images/pin-friend.png',
                            map: map
                        });

                        marker.setMap(map);

                        var infowindow = new google.maps.InfoWindow();

                        bindInfoWindow(marker, map, infowindow, data[i]['infoWindow']);
                    }
                },
                error: function(jqXHR, status, error) {
                    console.log('Error: ' + error);
                }
            });
        }

        function getMarkers() {
            $.ajax({
                url: "api/getMarkers",
                type: "GET",
                dataType: 'json',
                success: function(data, status) {

                    var iconBase = '/assets/images/';

                    for (var i = 0; i < data.length; i++) {

                        var marker = new google.maps.Marker({
                            position: new google.maps.LatLng(data[i]['event']['latitude'], data[i]['event']['longitude']),
                            icon: '/assets/images/' + data[i]['cat']['iconURL'] + '.png',
                            // icon: '/assets/images/pin-drinks.png',
                            map: map
                        });

                        marker.setMap(map);

                        var infowindow = new google.maps.InfoWindow();

                        bindInfoWindow(marker, map, infowindow, data[i]['infoWindow']);
                    }
                },
                error: function(jqXHR, status, error) {
                    console.log('Error: ' + error);
                }
            });
        }



        $("#geocomplete").geocomplete({
            details: 'form'
        });

        
        
        setInterval(getMessages(), 10000);

    });

    function getMessages(){
        $.ajax({
            url: "api/getMessages",
            type: "GET",
            dataType: 'json',
            success: function(data, status) {
               if(data){
                    var htmlString = "<ul id='messagesList'>";
                    for (var i = 0; i < data.length; i++) {
                        htmlString += "<li><a onclick='alert("+ data[i]['message']['message'] +")' href='#'>"+getPreviewText(data[i]['message']['message'])+"</a> from "+data[i]['user']['username']+"</li>";
                    };
                    htmlString += "</ul>";
                    // return htmlString;

                    var popoveroptions = {
                        title: 'Your messages',
                        html: true,
                        placement: 'bottom',
                        content: htmlString };

                        $('#messages').popover(popoveroptions);
                    }
                },
            error: function(jqXHR, status, error) {
                console.log('Error: ' + error);
            }
        });
    }

    function sendMessage(userId, message){
        $.ajax({
            url: "api/sendMessage",
            type: "POST",
            data: { message: message, userId: userId },
            dataType: 'text',
            success: function(data, status) {
               console.log(data);
            },
            error: function(jqXHR, status, error) {
                console.log('Error: ' + error);
            }
        });
    }

    function updateLastLogin(position){
        var latitude = position.coords.latitude;
        var longitude = position.coords.longitude;

        $.ajax({
                url: "api/updateLastLogin/"+latitude+"/"+longitude,
                type: "GET",
                dataType: 'json',
                success: function(data, status) {
                    console.log(data);
                },
                error: function(jqXHR, status, error) {
                    console.log('Error: ' + error);
                }
            });
    }

    function joinEvent(id, userId) {

        $.ajax({
            url: "api/joinEvent/" + id,
            type: "GET",
            dataType: 'json',
            success: function(data, status) {
                if ($('#joinResult').length != 0) {
                    $('#joinResult').remove();
                }

                if (data == -1) {
                    $("<div id='joinResult' class='alert alert-warning'>You already joined this event!</div>").insertBefore(".homeActionBar");
                } else if (data == 0) {
                    $("<div id='joinResult' class='alert alert-warning'>You could not join this event.</div>").insertBefore(".homeActionBar");
                } else if (data == 1) {
                    $("<div id='joinResult' class='alert alert-success'>You joined this event!</div>").insertBefore(".homeActionBar");
                    sendMessage(userId, 'Hi! I joined your event!');
                }
            },
            error: function(jqXHR, status, error) {
                console.log('Error: ' + error);
            }
        });
    }

    function closeInfoWindow() {
        currentInfoWindow.close();
    }

    function bindInfoWindow(marker, map, infowindow, html) {
        google.maps.event.addListener(marker, 'click', function() {
            infowindow.setContent(html);
            infowindow.open(map, marker);
            currentInfoWindow = infowindow;
        });
    }

    function getPreviewText(tekst){
        if(tekst.length > 25){
            return tekst.substring(0, 25) + "...";
        } else {
            return tekst;
        }
    }

</script>