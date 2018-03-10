$(document).ready(function () {

    if (document.getElementById('map') !== null) {

        var $map = L.map('map').setView(mapOptions.latlng, mapOptions.zoom);

        L.tileLayer('//a.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo($map);

        $map.on('click', function ($event) {
            var $map = $event.target;
            var $zoom = $map.getZoom();
            var $center = $map.getCenter();
            setUrl($center, $zoom, $event.latlng);
            mapClick($event.latlng);
        });

        $map.on('moveend', function ($event) {
            var $map = $event.target;
            var $zoom = $map.getZoom();
            var $center = $map.getCenter();
            setUrl($center, $zoom);
            gaSafe('send', 'event', 'map', 'moveend', 'success');
        });

        if (mapOptions.clatlng !== null) {
            mapClick(mapOptions.clatlng);
        }
    }

    function mapClick($latlng) {

        $.ajax({
            url: '/osm/mapquery',
            type: 'GET',
            data: {
                lng: $latlng.lng,
                lat: $latlng.lat
            },
            success: function (html)
            {
                if ($.trim(html)) {
                    L.popup()
                            .setLatLng($latlng)
                            .setContent(html)
                            .openOn($map);
                }
                gaSafe('send', 'event', 'map', 'click', 'success');
            },
            error: function (jqXHR, textStatus) {
                gaSafe('send', 'event', 'map', 'click', textStatus);
            }
        });
    }
});

function setUrl($center, $zoom, $latlng) {
    var $url = '/center/' + $center.lat.toFixed(6) + ',' + $center.lng.toFixed(6) + '/zoom/' + $zoom;

    if ($latlng !== undefined) {
        $url += '/clk/' + $latlng.lat.toFixed(6) + ',' + $latlng.lng.toFixed(6);
    }

    history.pushState(2, "page 2", $url);
}

function gaSafe(eventCategory, eventAction, eventLabel, eventValue) {
    if (typeof ga !== 'undefined') {
        ga(eventCategory, eventAction, eventLabel, eventValue);
    }
}