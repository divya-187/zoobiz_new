<?php $app_data = $d->selectRow("*","bizlocation", " 
        is_imported_live='0'", "ORDER BY state_id ASC limit 0,1 "); 
 $data=mysqli_fetch_array($app_data);
extract($data);

 
if ($city_id == 0 ) {
 
  $m->set_data('city_name',$City);
  $m->set_data('state_id',$state_id);
  $m->set_data('country_id',$country_id);
   $created_at = date('Y-m-d H:i:s');         
             $a1= array (
                'state_id'=> $m->get_data('state_id'),
                'city_name'=> $m->get_data('city_name'),
                'country_id'=> $m->get_data('country_id'),
                'created_at'=> $created_at,
                'updated_on'=> $created_at,
                'city_flag' =>0
            );

        $q=$d->insert("cities",$a1);

$cities_qry = $d->selectRow("city_id","cities"," 
        state_id='$state_id' and country_id='$country_id' and  city_name='$City'", "");
$cities_data=mysqli_fetch_array($cities_qry);
$city_id = $cities_data['city_id'];
    $m->set_data('city_id',$cities_data['city_id']);
            $a1= array (
                'city_id'=> $m->get_data('city_id'),
            );

    $q=$d->update("bizlocation",$a1,"City='$City'");
}
 
 
 



        ?>
<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
     <div class="row pt-2 pb-2">
        <div class="col-sm-9">
        <h4 class="page-title">Import</h4>
       
     </div>
     
     </div>
    <!-- End Breadcrumb-->
    
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <?php //IS_618  signupForm to serviceProviderFrm ?>
              <form id="addAreaFrmBulk" action="controller/countryController.php" method="post" enctype="multipart/form-data">
                
                  <input type="hidden" name="id" value="<?php echo $id;?>">
                
                   
                      <input  type="hidden" class="form-control" id="lat" name="latitude"  placeholder="Lattitude"  value="23.0242625">
                     <input  type="hidden" class="form-control" id="lng"  name="longitude"  placeholder="Longitude" value="72.5720625">
                   <input  type="hidden" required="" class="form-control" id="adress" name="adress">
                   
                  
                  
                <div class="form-group row">
                  <label for="country_id" class="col-sm-2 col-form-label"> Country <span class="required">*</span></label>
                  <div class="col-sm-4">
                    <select type="text" required="" id="country_id" onchange="getStates();" class="form-control single-select" name="country_id">
                      <option value="">-- Select --</option>
                      <?php 
                        $q3=$d->select("countries","flag=1","");
                         while ($blockRow=mysqli_fetch_array($q3)) {
                       ?>
                        <option <?php if(   $blockRow['country_id'] ==101) {echo "selected";} ?> value="<?php echo $blockRow['country_id'];?>"><?php echo $blockRow['country_name'];?></option>
                        <?php }?>
                      </select>
                  </div>
                   <label for="state_id" class="col-sm-2 col-form-label"> State <span class="required">*</span></label>
                  <div class="col-sm-4">
                    
                      <select type="text" onchange="getCity();"  required="" class="form-control single-select" id="state_id" name="state_id">
                        <?php
                           $q31=$d->select("states","country_id='101' and state_id ='$state_id'","");
                          while ($blockRow11=mysqli_fetch_array($q31)) {
                           ?>
                           <option <?php if( $blockRow11['state_id'] == $state_id) {echo "selected";} ?> value="<?php echo $blockRow11['state_id'];?>"><?php echo $blockRow11['state_name'];?></option>
                          <?php }  ?>
                      </select>
                      
                  </div>
                  
                </div>
                 <div class="form-group row">
                  <label for="input-101" class="col-sm-2 col-form-label"> City <span class="required">*</span></label>
                  <div class="col-sm-4">
                       
                      <select type="text" onchange="getArea();"  required="" class="form-control single-select" id="city_id" name="city_id">
                        <?php
                           $q34=$d->select("cities"," country_id='101' and state_id ='$state_id' and city_id='$city_id' ","");
                          while ($blockRow12=mysqli_fetch_array($q34)) {
                           ?>
                           <option <?php if( $blockRow12['city_id'] == $city_id ) {echo "selected";} ?> value="<?php echo $blockRow12['city_id'];?>"><?php echo $blockRow12['city_name'];?></option>
                          <?php }  ?>
                      </select>
                      
                  </div>
                  <label for="secretary_mobile" class="col-sm-2 col-form-label"> Pincode <span class="required">*</span></label>
                  <div class="col-sm-4">
                    <?php //IS_618 onlyNumber id="service_provider_phone" ?> 
                    <input type="text" id="pincode" maxlength="6" value="<?php  echo $PINCode;  ?>" required="" class="form-control onlyNumber" name="pincode" >
                  </div>
                  
                  
                </div>
                <div class="form-group row">
                  <label for="input-101" class="col-sm-2 col-form-label"> Area <span class="required">*</span></label>
                  <div class="col-sm-10">
                     <input type="text" id="area_name" maxlength="50" value="<?php   echo $AreaName;  ?>" required="" class="form-control" name="area_name" id="area_name">
                  </div>
                 
                </div>

                
                
                <div class="form-group row">
                  <input id="searchInput5" class="form-control" type="text" placeholder="Enter a Google location" value="<?php  echo $PINCode;  ?>" >
                    <div class="map" id="map" style="width: 100%; height: 400px;"></div>
                </div>
                <div class="form-footer text-center">
                    <input type="hidden" name="importBulkArea" value="importBulkArea">
                    <input type="hidden" name="isbug" id="isbug" value="false">
                    <button type="submit" id="socAddBtn" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
                    <button type="reset" class="btn btn-danger"><i class="fa fa-times"></i> RESET</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div><!--End Row-->

    </div>
    <!-- End container-fluid-->
    
    </div><!--End content-wrapper-->


<script src="../zooAdmin/assets/js/jquery.min.js"></script>
  <?php
  //old AIzaSyAUPcYOnCeZLyHFqI-ssbvwg-f12q8B85A
  //new AIzaSyCAqhdXVLwvt1byUEkzGPsLKLhutT70yFY
   ?>
<script src="https://maps.googleapis.com/maps/api/js?sensor=false&libraries=places&key=AIzaSyCAqhdXVLwvt1byUEkzGPsLKLhutT70yFY"></script>
<script src="app-../zooAdmin/assets/vendors/js/core/jquery-3.3.1.min.js"></script>
<script>
  jQuery(document).ready(function($){
//$('#searchInput5').val($('.pac-container').find('.pac-item').eq(0).text());

setTimeout(function(){ var geocoder = new google.maps.Geocoder();
            var address =document.getElementById("searchInput5").value;
            geocoder.geocode({ 'address': address }, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    var latitude = results[0].geometry.location.lat();
                    var longitude = results[0].geometry.location.lng();

                     document.getElementById('lat').value = latitude;
       document.getElementById('lng').value = longitude;
$('#addAreaFrmBulk').submit();

                    //alert("Latitude: " + latitude + "\nLongitude: " + longitude);
                } else {
                    document.getElementById('isbug').value = 'true';
$('#addAreaFrmBulk').submit(); 
                 

                  //alert("Request failed.")
                }
            }); }, 2000);



  
});
    /* script */
    function initialize() {
       // var latlng = new google.maps.LatLng(23.05669,72.50606);
       
 
      var latitute =document.getElementById('lat').value;
      var longitute =document.getElementById('lng').value;
      var latlng = new google.maps.LatLng(latitute,longitute);

        var map = new google.maps.Map(document.getElementById('map'), {
          center: latlng,
          zoom: 13
        });
        var marker = new google.maps.Marker({
          map: map,
          position: latlng,
          draggable: true,
          anchorPoint: new google.maps.Point(0, -29)
          // icon:'img/direction/'+dirction+'.png'
       });
       var parkingRadition = 5;
        var citymap = {
            newyork: {
              center: {lat: latitute, lng: longitute},
              population: parkingRadition
            }
        };
       
        var input = document.getElementById('searchInput5');

        // map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
        var geocoder = new google.maps.Geocoder();
        var autocomplete10 = new google.maps.places.Autocomplete(input);
         
        autocomplete10.bindTo('bounds', map);
        var infowindow = new google.maps.InfoWindow();   
        autocomplete10.addListener('place_changed', function() {
            infowindow.close();
            marker.setVisible(false);
            var place5 = autocomplete10.getPlace();
            if (!place5.geometry) {
                window.alert("Autocomplete's returned place5 contains no geometry");
                return;
            }
      
            // If the place5 has a geometry, then present it on a map.
            if (place5.geometry.viewport) {
                map.fitBounds(place5.geometry.viewport);
            } else {
                map.setCenter(place5.geometry.location);
                map.setZoom(17);
            }
           
            marker.setPosition(place5.geometry.location);
            marker.setVisible(true);          
            
            var pincode="";
            for (var i = 0; i < place5.address_components.length; i++) {
              for (var j = 0; j < place5.address_components[i].types.length; j++) {
                if (place5.address_components[i].types[j] == "postal_code") {
                  pincode = place5.address_components[i].long_name;
                  // alert(pincode);
                }
              }
            }
            bindDataToForm(place5.formatted_address,place5.geometry.location.lat(),place5.geometry.location.lng(),pincode,place5.name);
            infowindow.setContent(place5.formatted_address);
            infowindow.open(map, marker);
           
        });
        // this function will work on marker move event into map 
        google.maps.event.addListener(marker, 'dragend', function() {
            geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
              if (results[0]) { 
               var places = results[0]       ;
               console.log(places);
               var pincode="";
               var serviceable_area_locality= places.address_components[4].long_name;
               // alert(serviceable_area_locality);
            for (var i = 0; i < places.address_components.length; i++) {
              for (var j = 0; j < places.address_components[i].types.length; j++) {
                if (places.address_components[i].types[j] == "postal_code") {
                  pincode = places.address_components[i].long_name;
                  // alert(pincode);
                }
              }
            }
                  bindDataToForm(results[0].formatted_address,marker.getPosition().lat(),marker.getPosition().lng(),pincode,serviceable_area_locality);
                  // infowindow.setContent(results[0].formatted_address);
                  // infowindow.open(map, marker);
              }
            }
            });
        });
    }
    function bindDataToForm(address,lat,lng,pin_code,serviceable_area_locality){
       // document.getElementById('poi_point_address').value = address;
       document.getElementById('lat').value = lat;
       document.getElementById('lng').value = lng;
       document.getElementById('pincode').value = pin_code;
       // document.getElementById('serviceable_area_locality').value = serviceable_area_locality;

        // document.getElementById("POISubmitBtn").removeAttribute("hidden"); 
        // initialize();
    }
    google.maps.event.addDomListener(window, 'load', initialize);
    </script>
    <!-- For Map 6 -->
