<div class="content-wrapper">
  <section class="content-header"> 
   <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBb3j8Aiv60CadZ_wJS_5wg2KBO6081a_k&libraries=places&callback=initMap"
    async defer></script>    
   <style>
     .gmnoprint{
      display: none;
     }
   </style>
    <script>
var flightPath = null;
var flightPlanCoordinatesdata = [];
      function initialize() {
      //  var myLatLng = new google.maps.LatLng(14.081750, -87.185720);
        var myLatLng = {lat: <?php echo $latitude; ?>, lng: <?php echo $longitude; ?>};
        var mapOptions = {
          zoom: 9,
          center: myLatLng,
          mapTypeId: google.maps.MapTypeId.terrain
        };
     
        var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
          $.getJSON("<?php echo SITE_URL;?>/admin/servicearea/locatemape/<?php echo $id; ?>", function (result) {
           // alert('adddd');
              if(result){
              for (var i = 0; i < result.length; i++) {
         //  alert(html[i].lat);
          point = new google.maps.LatLng(
              parseFloat(result[i].lat),
              parseFloat(result[i].lng));
            flightPlanCoordinatesdata[i]=point;
              }
          }
          //alert(flightPlanCoordinatesdata);
if(flightPlanCoordinatesdata!=''){
 //   alert('testdd');
   var flightPlanCoordinates = flightPlanCoordinatesdata;
}else{
   // alert('testdss');
    var flightPlanCoordinates = [{lat:<?php echo $latitude; ?>, lng:<?php echo $longitude; ?>},
                 {lat:<?php echo $latitude; ?>, lng:<?php echo $longitude; ?>}
                    ];
}
          flightPath = new google.maps.Polyline({
          path: flightPlanCoordinates,
          strokeColor: '#FF0000',
          strokeOpacity: 1.0,
          strokeWeight: 2,
          editable: true,
          draggable: true
        });
        google.maps.event.addListener(flightPath, "dragend", getPath);
        google.maps.event.addListener(flightPath.getPath(), "insert_at", getPath);
        google.maps.event.addListener(flightPath.getPath(), "remove_at", getPath);
        google.maps.event.addListener(flightPath.getPath(), "set_at", getPath);
        flightPath.setMap(map); 
        });
      }
        function removeLine() {
            alert('remove');
            flightPath.setMap(null);
        $.ajax({
          type: "POST",
          url: '<?php echo SITE_URL;?>/admin/servicearea/remove',
          cache: false,
          //data: {latlong: coordStr},
          success: function(html) {
                location.reload();
            } 
     });
      }
        function getPath() {
   // alert('hello');
         var path = flightPath.getPath();
        var len = path.getLength();
        var coordStr = "";
        for (var i=0; i<len; i++) {
        coordStr += path.getAt(i).toUrlValue(6)+"+";
    }

        $.ajax({
            headers: {
                'X-CSRF-Token': csrfToken
            },
          type: "POST",
          url: '<?php echo SITE_URL;?>admin/servicearea/addservicearea/<?php echo $id; ?>',
          cache: false,
          data: {latlong: coordStr},
          success: function(html) {
                
          } 
        });
    }
    </script>   

    <!-- <input onclick="removeLine();" type=button value="Remove line"> -->
    <div id="map-canvas" style="height:600px; width:1500px;"></div>


    </section>
</div> 