

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
   <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC27M5hfywTEJa5_l-g0KHWe8m8lxu-rSI&libraries=places&callback=initMap"
    async defer></script>
    
   
    <script>
var flightPath = null;
var flightPlanCoordinatesdata = [];
      function initialize() {
       // var myLatLng = new google.maps.LatLng(14.081750, -87.185720);
        var myLatLng = {lat: 14.072275, lng: -87.192139};
        var mapOptions = {
          zoom: 13,
          center: myLatLng,
          mapTypeId: google.maps.MapTypeId.terrain
        };
     
        var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
         arePointsNear();
          $.getJSON("<?php echo SITE_URL;?>/admin/servicearea/ddd", function (result) {
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
  //  alert('testdss');
    var flightPlanCoordinates = [{lat:14.072275, lng:-87.192139},
			     {lat:14.072275, lng:-87.192139}
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
   var path = flightPath.getPath();
   var len = path.getLength();
   var coordStr = "";
   for (var i=0; i<len; i++) {
     coordStr += path.getAt(i).toUrlValue(6)+"+";
   }
$.ajax({
          type: "POST",
          url: '<?php echo SITE_URL;?>/admin/servicearea/add',
          cache: false,
          data: {latlong: coordStr},
          success: function(html) {
        
          } 
        });
   
   
}
 function arePointsNear(point1, point2) {
     var point1 = {lat: 14.078768, lng: -87.190221};
      //var point2 = {lat: 14.078768, lng: -87.190221};
   var sw = new google.maps.LatLng(14.064615 - 0.005, -87.197975 - 0.005);
    var ne = new google.maps.LatLng(14.072212 + 0.005, -87.167591 + 0.005);
    var bounds = new google.maps.LatLngBounds(sw,ne);
    if (bounds.contains (point1))
    {
        alert('test');
        //return true;
    }else{
        alert('best');
        // return false;
    }
}
    </script>
    
<!--  user location-->
<!--14.29891424-->
<!---87.37978324-->

<!--bound-->
<!--14.0787682-->
<!---87.19022125-->
    
    <input onclick="removeLine();" type=button value="Remove line">
    <div id="map-canvas" style="height:500px; width:500px;"></div>