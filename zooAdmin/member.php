<?php  error_reporting(0); ?>
<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
     <div class="row pt-2 pb-2">
        <div class="col-sm-9">
        <h4 class="page-title">Add Member</h4>
       <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li> 
           <li class="breadcrumb-item"><a href="memberList">Member List</a></li> 
            <li class="breadcrumb-item active" aria-current="page">Add Member</li>
         </ol>
     </div>
     
     </div>
    <!-- End Breadcrumb-->
    
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <?php //IS_618  signupForm to serviceProviderFrm ?>
              <form id="memberFrm" action="controller/userController.php" method="post" enctype="multipart/form-data">
               <fieldset class="scheduler-border">
                <legend  class="scheduler-border">Basic Details</legend>
              
                <div class="form-group row">
                  <?php /* ?> 
                    <label class="col-lg-2 col-form-label form-control-label">Salutation <span class="required">*</span></label>
                      <div class="col-lg-4">
                      <select class="form-control" name="salutation" type="text" required="">
                            <option value="">-- Select --</option>
                            <option value="Mr.">Mr.</option>
                            <option value="Mrs.">Mrs.</option>
                            <option value="Miss">Miss</option>
                            <option value="Ms">Ms</option>
                            <option value="Dr.">Dr.</option>
                            <option value="Prof.">Prof.</option>
                            <option value="Other">Other</option>
                        </select>
                      </div>
                      <?php */ ?> 
                      <label class="col-lg-2 col-form-label form-control-label">First Name <span class="required">*</span></label>
                      <div class="col-lg-4">
                        <input type="hidden" name="addNewMember" value="<?php echo 'addNewMember'; ?>">
                        <input minlength="1" maxlength="50" class="form-control mem-alphanumeric" name="user_first_name" type="text" value="<?php echo $user_first_name ; ?>" required="">
                      </div>

                      <label class="col-lg-2 col-form-label form-control-label">Last Name <span class="required">*</span></label>
                      <div class="col-lg-4">
                        <input minlength="1" maxlength="50"  class="form-control mem-alphanumeric" name="user_last_name" type="text" value="<?php echo $user_last_name; ?>" required="">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-lg-2 col-form-label form-control-label">Country Code<span class="required">*</span></label>
                      <div class="col-lg-4">
                      <select class="form-control single-select" name="country_code" type="text" required="">
                          <?php include '../common/country_code_option_list.php'; ?>
                        </select>
                      </div>

                      <label class="col-lg-2 col-form-label form-control-label">Mobile <span class="required">*</span></label>
                      <div class="col-lg-4">
                        <input required="" class="form-control" onblur="checkMobileUser()"  name="user_mobile"  maxlength="10" minlength="10"   type="text" value="<?php echo $user_mobile; ?>" id="userMobile">
                        <!-- <input required="" class="form-control" name="user_mobile" onblur="checkMobileUserEdit()" maxlength="10"  type="text" value="<?php echo $user_mobile; ?>" id="userMobile"> -->
                        <input class="form-control" name="user_mobile_old" maxlength="10"  type="hidden" value="<?php echo $user_mobile; ?>"  id="userMobileOld">
                      </div>
                    </div>
                     <div class="form-group row">
                     
                      <label class="col-lg-2 col-form-label form-control-label">Date Of Birth </label>
                      <div class="col-lg-4">
                        <input class="form-control" readonly="" id="autoclose-datepicker-dob" name="member_date_of_birth" type="text" value="<?php echo $member_date_of_birth; ?>" >
                      </div>
                      <label class="col-lg-2 col-form-label form-control-label">Gender</label>
                      <div class="col-lg-4">
                        <div class="form-check-inline">
                          <label class="form-check-label">
                            <input type="radio" checked="" class="form-check-input" value="Male" name="gender"> Male
                          </label>
                        </div>
                        <div class="form-check-inline">
                          <label class="form-check-label">
                            <input type="radio"   class="form-check-input" value="Female" name="gender"> Female
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="form-group row">
                       <label class="col-lg-2 col-form-label form-control-label">Whatsapp No. </label>
                      <div class="col-lg-4">
                        <input class="form-control onlyNumber" minlength="10" name="whatsapp_number"  maxlength="10"   type="text" value="<?php if($whatsapp_number!=0) {  echo $whatsapp_number; }?>" id="whatsapp_number">
                        <!-- <input required="" class="form-control" name="user_mobile" onblur="checkMobileUserEdit()" maxlength="10"  type="text" value="<?php echo $user_mobile; ?>" id="userMobile"> -->
                        <input class="form-control" name="user_mobile_old" maxlength="10"  type="hidden" value="<?php echo $user_mobile; ?>"  id="userMobileOld">
                      </div>
                      <label class="col-lg-2 col-form-label form-control-label">Email </label>
                      <div class="col-lg-4">
                        <input  minlength="5" maxlength="80" class="form-control" type="email" name="user_email"  value="<?php echo $user_email; ?>" id="userEmail">
                        
                      </div>
                      
                    </div>
                    <div class="form-group row">
                     
                      <label class="col-lg-2 col-form-label form-control-label">Membership Plan <span class="required">*</span></label>
                      <div class="col-lg-4">
                         <select id="plan_id" required="" class="form-control single-select" name="plan_id" type="text" >
                            <option value="">-- Select --</option>
                            <?php $qb=$d->select("package_master","","");
                            while ($bData=mysqli_fetch_array($qb)) {?>
                              <option  value="<?php echo $bData['package_id']; ?>"><?php echo $bData['package_name']; ?>-<?php echo $bData['no_of_month']; ?> <?php if($bData['time_slab'] == 1) echo "Days"; else echo "Month"; ?> (₹ <?php echo $bData['package_amount']; ?> )</option>
                            <?php } ?> 
                          </select>
                        <!-- <input class="form-control" readonly="" id="default-datepicker" name="plan_renewal_date" type="text" value="<?php echo $plan_renewal_date; ?>" > -->
                      </div>

                       <label class="col-lg-2 col-form-label form-control-label">Email Privacy</label>
                      <div class="col-lg-4">
                        <div class="form-check-inline">
                          <label class="form-check-label">
                            <input type="radio" checked="" class="form-check-input" value="0" name="email_privacy"> No
                          </label>
                        </div>
                        <div class="form-check-inline">
                          <label class="form-check-label">
                            <input type="radio"   class="form-check-input" value="1" name="email_privacy"> Yes
                          </label>
                        </div>
                      </div>
                    </div>


                    <?php //5nov 2020 ?>
                    <div class="form-group row">
                     
                      <label class="col-lg-2 col-form-label form-control-label">Is Paid Member?<span class="required">*</span></label>
                      <div class="col-lg-4">
                         <select onchange="isPaidUser();" id="is_paid" required="" class="form-control single-select" name="is_paid" type="text" >
                            <option value="1">Free</option>
                            <option value="0">Paid</option>  
                          </select>
                       
                      </div>

                       <label id="lbl_paid" style="display: none" class="col-lg-2 col-form-label form-control-label">AMOUNT WITH GST <span class="required">*</span></label>
                      <div id="div_paid" style="display: none" class="col-lg-4">
                         <input   min="0" maxlength="8"  amx="999999"    class="form-control onlyNumber " id="amount_with_gst" name="amount_with_gst" type="text">
                        
                      </div>
                    </div>
                    <?php //5nov 2020 ?>
                       <div class="form-group row">
                       <label class="col-lg-2 col-form-label form-control-label">Profile <span class="required">*</span></label>
                      <div class="col-lg-4">
                        <input accept="image/*" class="form-control-file border" id="imgInp" name="user_profile_pic" type="file">
                        <input class="form-control" name="user_profile_pic_old" type="hidden" value="<?php echo $user_profile_pic; ?>">
                      </div>

                       <label class="col-lg-2 col-form-label form-control-label">Invoice Download</label>
                      <div class="col-lg-4">
                        <div class="form-check-inline">
                          <label class="form-check-label">
                            <input type="radio" checked="" class="form-check-input" value="0" name="invoice_download"> Off
                          </label>
                        </div>
                        <div class="form-check-inline">
                          <label class="form-check-label">
                            <input type="radio"   class="form-check-input" value="1" name="invoice_download"> On
                          </label>
                        </div>
                      </div>
                    </div>
                     <div class="form-group row">
                      <label class="col-lg-2 col-form-label form-control-label">Referred By <span class="required">*</span></label>
                      <div class="col-lg-4">
                        <select id="refer_by" onchange="referBy();" class="form-control single-select" name="refer_by" required=""   >
                            <option value="">-- Select --</option>
                            <option value="1">Social Media</option>
                            <option value="2">Member / Friend</option>
                            <?php /* <option   value="3">Other</option> */ ?>
                           </select>
                      </div>



                      <label class="col-lg-2 col-form-label form-control-label">Office Member?</label>
                      <div class="col-lg-4">
                        <div class="form-check-inline">
                          <label class="form-check-label">
                            <input type="radio"  class="form-check-input" value="1" name="office_member"> Yes
                          </label>
                        </div>
                        <div class="form-check-inline">
                          <label class="form-check-label">
                            <input type="radio" checked=""   class="form-check-input" value="0" name="office_member"> No
                          </label>
                        </div>
                      </div>


                      <!-- <label style="display: none" id="refere_by_name_lbl" class="col-lg-2 col-form-label form-control-label">Refer By Name <span class="required">*</span></label>
                      <div style="display: none" class="col-lg-4" id="refere_by_name_div">
                        <input   class="form-control" name="refere_by_name"  maxlength="60" minlength="3"  type="text" value="" id="refere_by_name">
                      </div> -->



                     </div>

                        <div class="form-group row"  >
                             
                                <label  style="display: none" id="refere_by_user_div" class="col-lg-2 col-form-label form-control-label" for="refere_by_name" >Referred Member <span class="required">*</span></label>
                                 <div   class="col-lg-4" style="display: none" id="refere_by_user_div2" >
                                <input maxlength="50" class="form-control" type="text" id="refer_friend_name" name="refer_friend_name"    placeholder="Type Member Name To Get Selections" autocomplete="off">
                             
                             <select   class="form-control multiple-select" name="refer_friend_id"   required=""    id="refer_friend_id">
                            </select>
                          </div>
                        </div>

                      
                        


                      <div class="form-group row">
                        <label style="display: none" id="refere_by_name_lbl" class="col-lg-2 col-form-label form-control-label">Refer By Name <span class="required">*</span></label>
                      <div style="display: none" class="col-lg-4" id="refere_by_name_div">
                        <input   class="form-control" name="refere_by_name"  maxlength="60" minlength="3"  type="text" value="" id="refere_by_name">
                      </div>
                      <label style="display: none" id="refere_by_phone_number_lbl" class="col-lg-2 col-form-label form-control-label">Refer Perosn Number <span class="required">*</span></label>
                      <div style="display: none" class="col-lg-4" id="refere_by_phone_number_div">
                        <input   class="form-control onlyNumber" name="refere_by_phone_number"  maxlength="10" minlength="3"  type="text" value="" id="refere_by_phone_number">
                      </div>
                       

                       <label style="display: none" id="remark_lbl" class="col-lg-2 col-form-label form-control-label">Remarks</label>
                      <div style="display: none" class="col-lg-10" id="remark_div">
                        <input   class="form-control" name="remark"  maxlength="100" minlength="3"  type="text" value="" >
                      </div>
                      </div>


              </fieldset>
               <fieldset class="scheduler-border">
                <legend  class="scheduler-border">Business Details</legend>
                <div class="form-group row">
                        <label class="col-lg-2 col-form-label form-control-label">Business Category <span class="required">*</span></label>
                        <div class="col-lg-4">
                          <select id="business_categories" onchange="getSubCategory();" class="form-control single-select" name="business_category_id" type="text"  required="">
                            <option value="">-- Select --</option>
                            <?php $qb=$d->select("business_categories"," category_status =0 OR category_status =2","");
                            while ($bData=mysqli_fetch_array($qb)) {?>
                              <option <?php if($proData['business_category_id']== $bData['business_category_id']) { echo 'selected';} ?> value="<?php echo $bData['business_category_id']; ?>"><?php echo $bData['category_name']; ?></option>
                            <?php } ?> 
                          </select>
                        </div>
                     
                        <label class="col-lg-2 col-form-label form-control-label">Business Sub Category <span class="required">*</span></label>
                        <div class="col-lg-4">
                          <select id="business_categories_sub" class="form-control single-select" name="business_sub_category_id" type="text"  required="">
                            <option value="">-- Select --</option>
                            <?php if($proData>0) { 
                              $q3=$d->select("business_sub_categories","business_category_id='$proData[business_category_id]'","");
                              while ($blockRow=mysqli_fetch_array($q3)) {
                                ?>
                                <option <?php if($blockRow['business_sub_category_id']== $proData['business_sub_category_id']) { echo 'selected';} ?> value="<?php echo $blockRow['business_sub_category_id'];?>"><?php echo $blockRow['sub_category_name'];?></option>
                              <?php } } ?>
                            </select>
                          </div>
                        </div>
                       
                        <div class="form-group row">
                          <label class="col-lg-2 col-form-label form-control-label">Business Name <span class="required">*</span></label>
                          <div class="col-lg-4">
                            <input value="<?php echo $proData['company_name']; ?>" class="form-control" name="company_name"  maxlength="60" minlength="3"  type="text" value="<?php echo $company_name; ?>" id="company_name">
                          </div>
                          <label class="col-lg-2 col-form-label form-control-label">Designation <span class="required">*</span></label>
                          <div class="col-lg-4">
                            <input maxlength="80" required="" value="<?php echo $proData['designation']; ?>"  class="form-control" type="text" name="designation"    value="<?php echo $designation; ?>" id="designation">
                          </div>
                        </div>
                        
                      
                        <div class="form-group row">
                          <label class="col-lg-2 col-form-label form-control-label">Website </label>
                          <div class="col-lg-4">
                            <input  class="form-control" id="company_website" name="company_website"  maxlength="250" minlength="5"  value="<?php echo $proData['company_website']; ?>" type="url">
                          </div>
                          <label class="col-lg-2 col-form-label form-control-label">Business Logo </label>
                          <div class="col-lg-4">
                            <input accept="image/*" class="form-control-file border photoOnly" id="company_logo" name="company_logo" type="file">
                            <input class="form-control" name="company_logo_old" type="hidden" value="<?php echo $company_logo; ?>">
                            </div>
                            
                        </div>
              </fieldset>

              <fieldset class="scheduler-border">
                <legend  class="scheduler-border">Address Details</legend>
                
                <div class="form-group row">
                  <label for="input-10" class="col-sm-2 col-form-label">House No./ Floor/ Building <span class="required">*</span></label>
                  <div class="col-sm-10">
                    <?php  if(isset($_POST['editAddress'])) { ?>
                    <input type="hidden" name="adress_id" value="<?php echo $adress_id;?>">
                    <input  type="hidden" class="form-control" id="lat" name="latitude"  placeholder="Lattitude"  value="<?php echo $data['add_latitude']; ?>">
                     <input  type="hidden" class="form-control" id="lng"  name="longitude"  placeholder="sociaty_longitude" value="<?php echo $data['add_longitude']; ?>">
                     <textarea  minlength="1" maxlength="250" value="" required="" class="form-control" id="adress" name="adress"><?php echo $data['adress'];?></textarea>
                   <?php } else { ?>
                      <input  type="hidden" class="form-control" id="lat" name="latitude"  placeholder="Lattitude"  value="23.0242625">
                     <input  type="hidden" class="form-control" id="lng"  name="longitude"  placeholder="Longitude" value="72.5720625">
                   <textarea minlength="1" maxlength="250" value="" required="" class="form-control" id="adress" name="adress"></textarea>
                   
                   <?php } ?>
                  </div>
                  
                </div>

                <div class="form-group row">
                  <label for="input-10" class="col-sm-2 col-form-label">landmark/ Street <span class="required">*</span></label>
                  <div class="col-sm-10">
                    <?php  if(isset($_POST['editAddress'])) { ?>
                    
                     <textarea  minlength="1" maxlength="250" value="" required="" class="form-control" id="adress2" name="adress2"><?php echo $data['adress2'];?></textarea>
                   <?php } else { ?>
                      
                   <textarea minlength="1" maxlength="250" value="" required="" class="form-control" id="adress2" name="adress2"></textarea>
                   
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
                    <input type="text" id="pincode" minlength="6"  maxlength="6" value="<?php if(isset($_POST['editAddress'])) { echo $data['pincode']; } ?>" required="" class="form-control onlyNumber" name="pincode" id="pincode">
                  </div>
                  <label for="secretary_mobile" class="col-sm-2 col-form-label"> Type <span class="required">*</span></label>
                  <div class="col-sm-4">
                    <select required="" class="form-control" name="adress_type">
                      <option value=""> -- Select Type -- </option>
                      <option <?php if($data['adress_type']==0) {echo "selected";} ?>  value="0">Main Office</option>
                      <option  <?php if($data['adress_type']==1) {echo "selected";} ?> value="1">Sub Office</option>
                    </select>
                  </div>
                </div>

                
              
                <div class="form-group">
                  <input id="searchInput5" class="form-control" type="text" placeholder="Serach a Google location" >
                    <div class="map" id="map" style="width: 100%; height: 400px;"></div>
                </div>
              </fieldset> 

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
 //5nov 2020
//old AIzaSyAUPcYOnCeZLyHFqI-ssbvwg-f12q8B85A
  //new AIzaSyCAqhdXVLwvt1byUEkzGPsLKLhutT70yFY ?>
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
