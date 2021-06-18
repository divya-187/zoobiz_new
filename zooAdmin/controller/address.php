<?php  extract($_REQUEST); ?>
<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
     <div class="row pt-2 pb-2">
        <div class="col-sm-9">
        <h4 class="page-title">Add /Update Address</h4>
       
     </div>
     
     </div>
    <!-- End Breadcrumb-->
    
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <?php //IS_618  signupForm to serviceProviderFrm ?>
              <form id="addAddress" action="controller/userController.php" method="post" enctype="multipart/form-data">
               <?php 
                if(isset($_POST['editAddress'])) {
                   extract(array_map("test_input" , $_POST));
                   $q=$d->select("business_adress_master","adress_id='$adress_id'");
                  $data=mysqli_fetch_array($q);
                } 
                 ?>
                <div class="form-group row">
                  <label for="input-10" class="col-sm-2 col-form-label">Member   <span class="required">*</span></label>
                  <div class="col-sm-10">
                    <select name="user_id" id="user_id" class="form-control" required="">
                      <?php 
                      extract($_REQUEST);
                      $qss=$d->select("users_master","user_id='$user_id'");
                      while ($sData=mysqli_fetch_array($qss)) {
                       ?>
                       <option value="<?php echo $sData['user_id']; ?>"><?php echo $sData['user_full_name']; ?></option>
                       <?php } ?>
                    </select>
                  </div>
                  
                </div>
                <div class="form-group row">
                  <label for="input-10" class="col-sm-2 col-form-label">Address <span class="required">*</span></label>
                  <div class="col-sm-10">
                    <?php  if(isset($_POST['editAddress'])) { ?>
                    <input type="hidden" name="adress_id" value="<?php echo $adress_id;?>">
                    <input  type="hidden" class="form-control" id="lat" name="latitude"  placeholder="Lattitude"  value="<?php echo $data['add_latitude']; ?>">
                     <input  type="hidden" class="form-control" id="lng"  name="longitude"  placeholder="sociaty_longitude" value="<?php echo $data['add_longitude']; ?>">
                     <textarea value="" required="" class="form-control" id="adress" name="adress"><?php echo $data['adress'];?></textarea>
                   <?php } else { ?>
                      <input  type="hidden" class="form-control" id="lat" name="latitude"  placeholder="Lattitude"  value="23.0242625">
                     <input  type="hidden" class="form-control" id="lng"  name="longitude"  placeholder="Longitude" value="72.5720625">
                   <textarea value="" required="" class="form-control" id="adress" name="adress"></textarea>
                   
                   <?php } ?>
                  </div>
                  
                </div>
                <div class="form-group row">
                  <label for="country_id" class="col-sm-2 col-form-label"> Country <span class="required">*</span></label>
                  <div class="col-sm-4">
                    <select type="text" required="" id="country_id" onchange="getStates();" class="form-control single-select" name="country_id">
                      <option value="">-- Select --</option>
                      <?php 
                        $q3=$d->select("countries","flag=1","");
                         while ($blockRow=mysqli_fetch_array($q3)) {
                       ?>
                        <option <?php if(  isset($data['country_id']) && $data['country_id']==$blockRow['country_id']) {echo "selected";} ?> value="<?php echo $blockRow['country_id'];?>"><?php echo $blockRow['country_name'];?></option>
                        <?php }?>
                      </select>
                  </div>
                   <label for="state_id" class="col-sm-2 col-form-label"> State <span class="required">*</span></label>
                  <div class="col-sm-4">
                       <?php  if(isset($_POST['editAddress'])) { ?>
                      <select type="text" onchange="getCity();"  required="" class="form-control single-select" id="state_id" name="state_id">
                        <?php
                           $q31=$d->select("states","country_id='$data[country_id]'","");
                          while ($blockRow11=mysqli_fetch_array($q31)) {
                           ?>
                           <option <?php if( isset($data['state_id']) && $data['state_id']==$blockRow11['state_id']) {echo "selected";} ?> value="<?php echo $blockRow11['state_id'];?>"><?php echo $blockRow11['state_name'];?></option>
                          <?php }  ?>
                      </select>
                      <?php } else { ?>
                      <select type="text" onchange="getCity();"  required="" class="form-control single-select" id="state_id" name="state_id">
                      <option value="">-- Select --</option>
                      </select>
                      <?php } ?>
                  </div>
                  
                </div>
                 <div class="form-group row">
                  <label for="input-101" class="col-sm-2 col-form-label"> City <span class="required">*</span></label>
                  <div class="col-sm-4">
                      <?php  if(isset($_POST['editAddress'])) { ?>
                      <select type="text" onchange="getArea();"  required="" class="form-control single-select" id="city_id" name="city_id">
                        <?php
                           $q34=$d->select("cities","state_id='$data[state_id]'","");
                          while ($blockRow12=mysqli_fetch_array($q34)) {
                           ?>
                           <option <?php if( isset($data['city_id']) && $data['city_id']==$blockRow12['city_id']) {echo "selected";} ?> value="<?php echo $blockRow12['city_id'];?>"><?php echo $blockRow12['city_name'];?></option>
                          <?php }  ?>
                      </select>
                      <?php } else { ?>
                      <select  type="text" onchange="getArea();" required="" class="form-control single-select" name="city_id" id="city_id">
                      <option value="">-- Select --</option>
                      
                      </select>
                      <?php } ?>
                  </div>
                  <label for="input-101" class="col-sm-2 col-form-label"> Area <span class="required">*</span></label>
                  <div class="col-sm-4">
                     <?php  if(isset($_POST['editAddress'])) { ?>
                      <select type="text"  onchange="getLatLong();" required="" class="form-control single-select" id="area_id" name="area_id">
                        <?php
                           $q34=$d->select("area_master","city_id='$data[city_id]'","");
                          while ($blockRow12=mysqli_fetch_array($q34)) {
                           ?>
                           <option <?php if( isset($data['area_id']) && $data['area_id']==$blockRow12['area_id']) {echo "selected";} ?> value="<?php echo $blockRow12['area_id'];?>"><?php echo $blockRow12['area_name'];?></option>
                          <?php }  ?>
                      </select>
                      <?php } else { ?>
                      <select  type="text" onchange="getLatLong();" required="" class="form-control single-select" name="area_id" id="area_id">
                      <option value="">-- Select --</option>
                      
                      </select>
                      <?php } ?>
                  </div>
                  
                </div>
                <div class="form-group row">
                  <label for="secretary_mobile" class="col-sm-2 col-form-label"> Pincode <span class="required">*</span></label>
                  <div class="col-sm-4">
                    <?php //IS_618 onlyNumber id="service_provider_phone" ?> 
                    <input type="text" id="pincode" maxlength="6" value="<?php if(isset($_POST['editAddress'])) { echo $data['pincode']; } ?>" required="" class="form-control onlyNumber" name="pincode" id="pincode">
                  </div>
                  <label for="secretary_mobile" class="col-sm-2 col-form-label"> Type <span class="required">*</span></label>
                  <div class="col-sm-4">
                    <select required="" class="form-control" name="adress_type">
                      <option value=""> -- Select Type -- </option>
                      <option <?php if($data['adress_type']==0) {echo "selected";} ?>  value="0">Primary</option>
                      <option  <?php if($data['adress_type']==1) {echo "selected";} ?> value="1">Other</option>
                    </select>
                  </div>
                </div>

                
                
                <div class="form-group row">
                  <input id="searchInput5" class="form-control" type="text" placeholder="Enter a Google location" >
                    <div class="map" id="map" style="width: 100%; height: 400px;"></div>
                </div>
                <div class="form-footer text-center">
                    <input type="hidden" name="addAddress" value="addAddress">
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


<script src="assets/js/jquery.min.js"></script>
  <?php
  //old AIzaSyAUPcYOnCeZLyHFqI-ssbvwg-f12q8B85A
  //new AIzaSyCAqhdXVLwvt1byUEkzGPsLKLhutT70yFY
   ?>
<script src="https://maps.googleapis.com/maps/api/js?sensor=false&libraries=places&key=AIzaSyCAqhdXVLwvt1byUEkzGPsLKLhutT70yFY"></script>
<script src="app-assets/vendors/js/core/jquery-3.3.1.min.js"></script>
<script>

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
