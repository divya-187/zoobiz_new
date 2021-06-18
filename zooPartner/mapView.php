<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
    <div class="row pt-2 pb-2">
      <div class="col-sm-6">
        <h4 class="page-title">Map View</h4>
          <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li> 
            <li class="breadcrumb-item active" aria-current="page">Map View</li>
         </ol>
      </div>
      <div class="col-sm-6">

      </div>
       
    </div>
    <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
 
      <form action=""   method="get" accept-charset="utf-8">
        <?php 
        
        if ( isset($_GET['map_view_filter_city_id'])){
          $map_view_filter_city_id = $_GET['map_view_filter_city_id'];
          $qry=$d->select("area_master ,cities"," cities.city_id =area_master.city_id and    cities.city_id='$map_view_filter_city_id'","");
          $area=mysqli_fetch_array($qry);
        //  echo "<pre>";print_r($area);
          $lat = $area['latitude'];
          $lng=$area['longitude'];
         
        } else {
          $lat = "23.0343151";
          $lng="72.5367077";
        }?>
        <input type="hidden" name="lattitude_txt" id="lattitude_txt" value="<?php echo $lat;?>">
        <input type="hidden" name="logitude_txt" id="logitude_txt" value="<?php echo $lng;?>">


        <select name="map_view_filter_city_id" onchange="this.form.submit();" class="form-control single-select">
          <option value="">-- Select City --</option>
          <?php 
          $q3=$d->select("cities","city_flag=1","");
           while ($blockRow=mysqli_fetch_array($q3)) {
         ?>
          <option <?php if ( isset($_GET['map_view_filter_city_id']) &&  $blockRow['city_id']==$_GET['map_view_filter_city_id'] ) { echo 'selected';} ?> value="<?php echo $blockRow['city_id'];?>"><?php echo $blockRow['city_name'];?></option>
          <?php }?>
        </select>
      </form>
       <br>

    <?php

     include("userLocationXML.php");
    
    ?>
    <!-- End Breadcrumb-->





    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <!-- <div class="card-header"><i class="fa fa-table"></i> Data Exporting</div> -->
          <div class="card-body">
           <div id="map" style="height: 600px;"></div>
           <div id="directions-panel"></div>
         </div>
       </div>
     </div>
   </div><!-- End Row-->

</div>
</div>
</div>
</div>

 </div>
 <!-- End container-fluid-->

</div><!--End content-wrapper-->
  
<style type="text/css">
  .media-name{
  color: #1a4089 !important;
}
</style>
<script>
  var customLabel = {
    restaurant: {
      label: 'R'
    },
    bar: {
      label: 'B'
    },
    hoarding: {
      label: 'H'
    }
  };


  function initMap() {
    var directionsService = new google.maps.DirectionsService;
    var directionsDisplay = new google.maps.DirectionsRenderer;

   /* var lattitude = $('#lattitude_txt').val();
    var logitude = $('#logitude_txt').val();
    alert(lattitude);*/

     var latitute =document.getElementById('lattitude_txt').value;
      var longitute =document.getElementById('logitude_txt').value;
      var latlng = new google.maps.LatLng(latitute,longitute);


    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 11,
      center: latlng
    });
    directionsDisplay.setMap(map);


       



        var infoWindow = new google.maps.InfoWindow;
 
          // Change this depending on the name of your PHP or XML file
          downloadUrl('userLocationXML.xml', function(data) {
            var xml = data.responseXML;
            var markers = xml.documentElement.getElementsByTagName('marker');
            Array.prototype.forEach.call(markers, function(markerElem) {
              var id = markerElem.getAttribute('id');
              var name = markerElem.getAttribute('username');
              var address = markerElem.getAttribute('adress');
               var address2 = markerElem.getAttribute('adress2');
              var profile = markerElem.getAttribute('user_profile_pic'); 
              var type = markerElem.getAttribute('type');
               var user_email = markerElem.getAttribute('user_email');
                var user_mobile = markerElem.getAttribute('user_mobile');
                 var gender = markerElem.getAttribute('gender');
             var company = markerElem.getAttribute('company');
              var id = markerElem.getAttribute('id');
              var point = new google.maps.LatLng(
                parseFloat(markerElem.getAttribute('lat')),
                parseFloat(markerElem.getAttribute('lng')));

              
              var onclick ='';// "askToDownload('"+hoarding_photo+"');";

               
                  var contentString = '<div >'+

              '<div> <a href="memberView?id='+ id+'" target="_blank" > <img id="blah"    src="'+profile+'"  width="75" height="75"   src="#" alt="your image" class="profile" style="border-radius: 50%;" />  <span style="display: inline-block;" class="media-name"> <b><h4>'+name+'</h4></b></span></a>  <div> <br>'+
              '<div>Mobile: </b>'+ user_mobile+' </b> </div> <br>'+
              '<div><b>Email: </b>'+ user_email+' </b>  </div> <br>'+
              '<div>  <b>Gender: </b>'+ gender+' </div> <br>'+
              '<div><b>House No./ Floor/ Building: </b>'+ address+'   </div> <br>'+
              '<div><b>Landmark/ Street: </b>'+ address2+'   </div> <br>'+
              '<div>  <b>Business Name: </b>'+ company+' </div> <br>'+
                '</div>';
                
              

 

              var icon = customLabel[type] || {};

               
                var marker = new google.maps.Marker({
                  map: map,
                  position: point,
                  icon:'img/map-gren.png'
                // label: icon.label
              });
               
              marker.addListener('click', function() {
              
               infoWindow.setContent(contentString);
               infoWindow.setOptions({width:350}); 
               infoWindow.setOptions({height:450}); 
               infoWindow.setOptions({maxWidth:400}); 
               infoWindow.setOptions({maxHeight:500}); 
               infoWindow.open(map, marker);
             });
            });
          });


        }

        function downloadUrl(url, callback) {
          var request = window.ActiveXObject ?
          new ActiveXObject('Microsoft.XMLHTTP') :
          new XMLHttpRequest;

          request.onreadystatechange = function() {
            if (request.readyState == 4) {
              request.onreadystatechange = doNothing;
              callback(request, request.status);
            }
          };

          request.open('GET', url, true);
          request.send(null);
        }
        function doNothing (){}
         
 </script>
 <?php //AIzaSyCAqhdXVLwvt1byUEkzGPsLKLhutT70yFY?> 
 <script async defer
 src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCAqhdXVLwvt1byUEkzGPsLKLhutT70yFY&callback=initMap">
        
</script>