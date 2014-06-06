$(document).ready(function(){
    $("#success-div").hide();

    $("#submit-button").click(function(){
        /* Get nearest city in database */
        $.ajax({
            type: "POST",
            url: "city",
            data: { "lat": $("#latitude").val(), "lon": $('#longitude').val()}
        })
            .done(function(data){
                if (data !== "NULL")
                {
                    var nearest_city_id = data;
                    $("#city-picker-div").slideUp();
                    $("#success-div").slideDown();

                    /* Set cookie and load front page */
                    $.ajax({
                        type: "PUT",
                        url: "city",
                        data: { "city_id": nearest_city_id }
                    })
                        .done(function(data){
                            if (data === "NULL")
                            {
                                $("#success-text").text("Cookie error! Cannot show weather for desired location.");
                            }

                            setTimeout(function() {
                                window.location.href = "/";
                            }, 2000);
                        });

                }
                else
                {
                    alert("Error!");
                }
            });
    });
});

/* CITY PICKER */
(function($) {

    var GMapsLatLonPicker = (function() {

        var _self = this;

        //Parameters for init
        _self.params = {
            defZoom : 1,
            mapOptions :
            {
                mapTypeControl: false,
                disableDoubleClickZoom: true,
                streetViewControl: false
            }
        };

        _self.vars = {
            ID : null,
            LATLNG : null,
            map : null,
            marker : null,
            geocoder : null
        };

        // Manipulation functions
        var setPosition = function(position) {
            _self.vars.marker.setPosition(position);
            _self.vars.map.panTo(position);

            //Change hidden values
            $(_self.vars.cssID + "#longitude").val( position.lng() );
            $(_self.vars.cssID + "#latitude").val( position.lat() );
        };

        // Public function for google map
        var publicfunc = {

            // Init map on page
            init : function(object) {

                // map initialization (copy-paste)
                _self.vars.ID = $(object).attr("id");
                _self.vars.cssID = "#" + _self.vars.ID + " ";
                _self.params.defLat  = $(_self.vars.cssID + "#latitude").val();
                _self.params.defLng  = $(_self.vars.cssID + "#longitude").val();
                _self.vars.LATLNG = new google.maps.LatLng(_self.params.defLat, _self.params.defLng);
                _self.vars.MAPOPTIONS		 = _self.params.mapOptions;
                _self.vars.MAPOPTIONS.zoom   = _self.params.defZoom;
                _self.vars.MAPOPTIONS.center = _self.vars.LATLNG;
                _self.vars.map = new google.maps.Map($(_self.vars.cssID + "#maps-div").get(0), _self.vars.MAPOPTIONS);

                // Place marker on map
                _self.vars.marker = new google.maps.Marker({
                    position: _self.vars.LATLNG,
                    map: _self.vars.map,
                    draggable: true
                });

                // Set new position on click
                google.maps.event.addListener(_self.vars.map, 'click', function(event) {
                    setPosition(event.latLng);
                });

                // Set new position on drag
                google.maps.event.addListener(_self.vars.marker, 'dragend', function(event) {
                    setPosition(_self.vars.marker.position);
                });
            }
        }

        return publicfunc;
    });

    // Init
    $(document).ready( function() {
        $("#city-picker-div").each(function() {
            (new GMapsLatLonPicker()).init( $(this) );
        });
    });

}(jQuery));
