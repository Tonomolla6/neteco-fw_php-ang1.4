var map;
var InforObj = [];
var centerCords = {
    lat: 38.820753,
    lng: -0.599474
};
var markersOnMap = [{
        placeName: "Neteco",
        LatLng: [{
            lat: 38.820753,
            lng: -0.599474
        }]
    }
];

window.onload = function () {
    initMap();
    send_mail();
};

function addMarker() {
    for (var i = 0; i < markersOnMap.length; i++) {
        var contentString = '<div class="content_maps"><h1>' + markersOnMap[i].placeName +
            '</h1></div>';

        const marker = new google.maps.Marker({
            position: markersOnMap[i].LatLng[0],
            map: map
        });

        const infowindow = new google.maps.InfoWindow({
            content: contentString,
            maxWidth: 200
        });

        marker.addListener('click', function () {
            closeOtherInfo();
            infowindow.open(marker.get('map'), marker);
            InforObj[0] = infowindow;
        });
    }
}

function closeOtherInfo() {
    if (InforObj.length > 0) {
        /* detach the info-window from the marker ... undocumented in the API docs */
        InforObj[0].set("marker", null);
        /* and close it */
        InforObj[0].close();
        /* blank the array */
        InforObj.length = 0;
    }
}

function initMap() {
    map = new google.maps.Map(document.getElementById('map'), {
        zoom: 4,
        center: centerCords
    });
    addMarker();
}

function send_mail() {
    $("#send").click(function() {
        var array_data = {
            "nombre":$('input[name="nombre"]').val(),
            "apellidos":$('input[name="apellidos"]').val(),
            "correo":$('input[name="correo"]').val(),
            "cliente":$('select[name="cliente"]').val(),
            "sexo":$('input[name="sexo"]').val(),
            "asunto":$('input[name="asunto"]').val(),
            "mensaje":$('textarea[name="mensaje"]').val()
        };
        $.ajax({ 
            type: "POST",
            url: amigable("?module=contact&function=send_mail"),
            data: {"data": array_data},
            }).done(function(result) {
                setTimeout(function() {
                    $('.alert').remove();
                }, 2000);

                $("body").html($("body").html()+result);
            });
      });
}