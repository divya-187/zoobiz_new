<?php
extract($_REQUEST);
if(filter_var($company_id, FILTER_VALIDATE_INT) != true){
  $_SESSION['msg1']='Invalid Company';
  echo ("<script LANGUAGE='JavaScript'>
    window.location.href='companyList';
    </script>");
}
$company_master=$d->select("company_master,payment_getway_master"," payment_getway_master.company_id=company_master.company_id and  company_master.company_id= '$company_id' ","");

$compData=mysqli_fetch_array($company_master);
extract($compData);
?>
<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
    <?php if(mysqli_num_rows($company_master)>0) { ?>
      <div class="row pt-2 pb-2">
        <div class="col-sm-4">
          <h4 class="page-title"><?php echo $company_name; ?></h4>
        </div>
        
        <div class="col-sm-3">
          
        </div>
      </div>
      <!-- End Breadcrumb-->
      <div class="row">
        <div class="col-lg-4">
          <div class="card profile-card-2">
            <div class="card-img-block">
              <img class="img-fluid" src="img/Free-hd-building-wallpaper.jpg" alt="Card image cap">
            </div>
            <div class="card-body pt-5">
              <img id="blah"  onerror="this.src='img/user.png'" src="../img/company/<?php echo $company_logo; ?>"  width="75" height="75"   src="#" alt="your image" class='profile' />
              <h5 class="card-title">  <?php echo $company_name; ?></h5>
              
              
            </div>
            <div class="card-body border-top">
              <div class="media align-items-center">
                <div>
                  <i class="fa fa-mobile"></i>
                </div>
                <div class="media-body text-left">
                  <div class="progress-wrapper">
                    <?php echo $company_contact_number; ?>
                  </div>
                </div>
              </div>
              <hr>
              
              
              <div class="media align-items-center">
                <div>
                  <i class="fa fa-envelope"></i>
                </div>
                <div class="media-body text-left">
                  <div class="progress-wrapper">
                    <?php echo $company_email; ?>
                  </div>
                </div>
              </div>
              
              
              <hr>
              <div class="media align-items-center">
                <div>
                  <i class="fa fa-money"></i>
                </div>
                <div class="media-body text-left">
                  <div class="progress-wrapper">
                    <?php echo $comp_gst_number; ?>
                  </div>
                </div>
              </div>
              
              
              <hr>
              
              
              
              
              
              
              
              
              <?php
              $q=$d->select("transection_master","  company_id='$company_id'  ","");
              if (mysqli_num_rows($q) <= 0 ) {
                ?> <hr>
                <div class="row">
                  <div class="col-xs-6 col-12">
                    <form action="controller/companyController.php" method="post">
                      <input type="hidden" name="delete_company_id" value="<?php echo $company_id; ?>">
                      <input type="hidden" name="user_fcm" value="<?php echo $user_token; ?>">
                      
                      <button type="submit" class="btn form-btn btn-danger" >Delete Company</button>
                    </form>
                  </div>
                  
                </div>
              <?php } ?>
              
            </div>
          </div>
          
        </div>
        <div class="col-lg-8">
          <div class="card">
            <div class="card-body">
              <ul class="nav nav-tabs nav-tabs-primary top-icon nav-justified">
                <li class="nav-item">
                  <a href="javascript:void();" data-target="#edit" data-toggle="pill" class="nav-link active"><i class="icon-note"></i> <span class="hidden-xs">Company Details </span></a>
                </li>
                
                <li class="nav-item">
                  <a href="javascript:void();" data-target="#emergency" data-toggle="pill" class="nav-link "><i class="fa fa-credit-card"></i> <span class="hidden-xs">Payment Details </span></a>
                </li>
                
              </ul>
              <div class="tab-content p-3">
                
                <div class="tab-pane" id="emergency">
                  
                  <form id="companyPayFrm" action="controller/companyController.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="company_id" value="<?php echo $company_id;?>">
                    <div class="form-group row">
                      <label class="col-lg-4 col-form-label form-control-label">Payment Gateway Name <span class="required">*</span></label>
                      <div class="col-lg-8">
                        <input required=""  type="text" class="form-control" name="payment_getway_name" id="payment_getway_name" value="<?php if(isset($company_id)){  echo $payment_getway_name; } ?>" placeholder="Payment Gateway Name" minlength="3" maxlength="50"  >
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-lg-4 col-form-label form-control-label">Razor Pay keyId <span class="required">*</span></label>
                      <div class="col-lg-8">
                        <input required=""  type="text" class="form-control" name="merchant_id" id="merchant_id" value="<?php if(isset($company_id)){  echo $merchant_id; } ?>" placeholder="Razor Pay keyId" minlength="3" maxlength="50"  >
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-lg-4 col-form-label form-control-label">Razor Pay Secret key <span class="required">*</span></label>
                      <div class="col-lg-8">
                        <input required=""  type="text" class="form-control" name="merchant_key" id="merchant_key" value="<?php if(isset($company_id)){  echo $merchant_key; } ?>" placeholder="Razor Pay Secret key" minlength="3" maxlength="50"  >
                      </div>
                    </div>
                    <!-- <div class="form-group row">
                      <label class="col-lg-4 col-form-label form-control-label">Salt Key <span class="required">*</span></label>
                      <div class="col-lg-8">
                        <input required=""  type="text" class="form-control" name="salt_key" id="salt_key" value="<?php if(isset($company_id)){  echo $salt_key; } ?>" placeholder="Salt Key" minlength="3" maxlength="50"  >
                      </div>
                    </div> -->
                    <div class="form-group row">
                      <label class="col-lg-4 col-form-label form-control-label">Payment Gateway Email</label>
                      <div class="col-lg-8">
                        <input type="text" class="form-control" name="payment_getway_email" id="payment_getway_email" value="<?php if(isset($company_id)){  echo $payment_getway_email; } ?>" placeholder="Payment Gateway Email" minlength="3" maxlength="50"  >
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-lg-4 col-form-label form-control-label">Payment Gateway Contact</label>
                      <div class="col-lg-8">
                        <input type="text" class="form-control onlyNumber" name="payment_getway_contact" id="payment_getway_contact" value="<?php if(isset($company_id) && $payment_getway_contact != 0 ){  echo $payment_getway_contact; } ?>" placeholder="Payment Gateway Contact" minlength="6" maxlength="12"  >
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-lg-4 col-form-label form-control-label">Payment Gateway Logo</label>
                      <div class="col-lg-8">
                        <input accept="image/*" class="form-control-file border" id="imgInp" name="payment_getway_logo" type="file">
                        <?php if(isset($company_id)){ ?>
                          <input class="form-control" name="payment_getway_logo_old" type="hidden" value="<?php echo $payment_getway_logo; ?>">
                        <?php } ?>
                      </div>
                    </div>
                    
                    <div class="form-group row">
                      <label class="col-lg-4 col-form-label form-control-label">Display Currency</label>
                      <div class="col-lg-8">
                        <select      required="" class="form-control single-select" id="currency_id" name="currency_id">
                         <option value="">-- Select --</option>
                         <?php
                         $currency_master=$d->select("currency_master","status=0","");
                         while ($currency_master_data=mysqli_fetch_array($currency_master)) {
                          ?>
                          <option <?php if( isset($company_id) && $currency_id==$currency_master_data['currency_id']) {echo "selected";} ?> value="<?php echo $currency_master_data['currency_id'];?>"><?php echo $currency_master_data['currency_code'].'( '.$currency_master_data['currency_symbol'].' )';?></option>
                        <?php }  ?>
                      </select>
                    </div>
                  </div>

                  <?php //17feb21 ?>
                  
                  <legend  class="scheduler-border">UPI Details</legend>
                  <div class="form-group row">
                    <label class="col-lg-4 col-form-label form-control-label">Name</label>
                    <div class="col-lg-8">
                      <input    type="text" class="form-control" name="upi_name" id="upi_name" value="<?php if(isset($company_id)){  echo $upi_name; } ?>" placeholder="Name" minlength="3" maxlength="50"  >
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-lg-4 col-form-label form-control-label">UPI ID</label>
                    <div class="col-lg-8">
                      <input   type="text" class="form-control" name="upi_id" id="upi_id" value="<?php if(isset($company_id)){  echo $upi_id; } ?>" placeholder="UPI ID" minlength="3" maxlength="50"  >
                    </div>
                    
                  </div>
                  

                   <legend  class="scheduler-border">CCAvenue Details</legend>
                  <div class="form-group row">
                    <label class="col-lg-4 col-form-label form-control-label">merchant id</label>
                    <div class="col-lg-8">
                      <input    type="text" class="form-control" name="ccav_merchant_id" id="ccav_merchant_id" value="<?php if(isset($company_id)){  echo $ccav_merchant_id; } ?>" placeholder="Merchant Id" minlength="3" maxlength="50"  >
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-lg-4 col-form-label form-control-label">access code</label>
                    <div class="col-lg-8">
                      <input   type="text" class="form-control" name="ccav_access_code" id="ccav_access_code" value="<?php if(isset($company_id)){  echo $ccav_access_code; } ?>" placeholder="Access Code" minlength="3" maxlength="50"  >
                    </div>
                    
                  </div>
                  
                  <div class="form-group row">
                    <label class="col-lg-4 col-form-label form-control-label">access code</label>
                    <div class="col-lg-8">
                     <input   type="text" class="form-control" name="ccav_working_key" id="ccav_working_key" value="<?php if(isset($company_id)){  echo $ccav_working_key; } ?>" placeholder="Working Key" minlength="3" maxlength="50"  >
                    </div>
                    
                  </div>
                  <div class="form-group row">
                    <label class="col-lg-4 col-form-label form-control-label">Live Mode </label>
                    <div class="col-lg-8">
                      <select      required="" class="form-control single-select" id="ccav_live_mode" name="ccav_live_mode">
                       <option value="Yes"  <?php if( isset($company_id) && $ccav_live_mode=='Yes') {echo "selected";} ?> >Yes</option>
                        <option value="No" <?php if( isset($company_id) && $ccav_live_mode=='No') {echo "selected";} ?> >No</option>
                      
                    </select>
                    </div>
                    
                  </div>
                  
                     <legend  class="scheduler-border">Paytm Details</legend>
                  <div class="form-group row">
                    <label class="col-lg-4 col-form-label form-control-label">Name</label>
                    <div class="col-lg-8">
                      <input    type="text" class="form-control" name="paytm_name" id="paytm_name" value="<?php if(isset($company_id)){  echo $paytm_name; } ?>" placeholder="Name" minlength="3" maxlength="50"  >
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-lg-4 col-form-label form-control-label">Merchant Id</label>
                    <div class="col-lg-8">
                       <input    type="text" class="form-control" name="paytm_merchant_id" id="paytm_merchant_id" value="<?php if(isset($company_id)){  echo $paytm_merchant_id; } ?>" placeholder="Merchant Id" minlength="3" maxlength="50"  >
                    </div>
                    
                  </div>
                  
                  <div class="form-group row">
                    <label class="col-lg-4 col-form-label form-control-label">Merchant key</label>
                    <div class="col-lg-8">
                    <input    type="text" class="form-control" name="paytm_merrchant_key" id="paytm_merrchant_key" value="<?php if(isset($company_id)){  echo $paytm_merrchant_key ; } ?>" placeholder="Merchant Key" minlength="3" maxlength="50"  >
                    </div>
                    
                  </div>
                  <div class="form-group row">
                    <label class="col-lg-4 col-form-label form-control-label">Live Mode </label>
                    <div class="col-lg-8">
                      <select      required="" class="form-control single-select" id="paytm_is_live_mode" name="paytm_is_live_mode">
                       <option value="Yes"  <?php if( isset($company_id) && $paytm_is_live_mode=='Yes') {echo "selected";} ?> >Yes</option>
                        <option value="No" <?php if( isset($company_id) && $paytm_is_live_mode=='No') {echo "selected";} ?> >No</option>
                      
                    </select>
                    </div>
                    
                  </div>

                  <div class="form-group row">
                  <label class="col-lg-4 col-form-label form-control-label">Test Mode MERCHANT ID </label>
                  <div class="col-lg-8">
                   <input    type="text" class="form-control" name="test_paytm_merchant_id" id="test_paytm_merchant_id" value="<?php if(isset($company_id)){  echo $test_paytm_merchant_id; } ?>" placeholder="Test Merchant Id" minlength="3" maxlength="50"  >
                  </div>
                </div>
                <div class="form-group row">
                   <label class="col-lg-4 col-form-label form-control-label">Test Mode MERCHANT KEY </label>
                  <div class="col-lg-8">
                    <input    type="text" class="form-control" name="test_paytm_merrchant_key" id="test_paytm_merrchant_key" value="<?php if(isset($company_id)){  echo $test_paytm_merrchant_key ; } ?>" placeholder="Test Merchant Key" minlength="3" maxlength="50"  >
                  </div>
                  
                </div>
                  <div class="form-group row">
                    <div class="col-lg-12 text-center">
                      <input type="submit"   class="btn btn-primary" name="updatePaymentDetails"  value="Update">
                    </div>
                  </div>
                </form>
              </div>
              <div class="tab-pane active" id="edit">
                <form id="companyDetailFrm" action="controller/companyController.php" method="post" enctype="multipart/form-data">
                  <input type="hidden" name="company_id" value="<?php echo $company_id;?>">
                  <div class="form-group row">
                    <label class="col-lg-4 col-form-label form-control-label">Company Name <span class="required">*</span></label>
                    <div class="col-lg-8">
                      <input  required="" type="text" class="form-control" name="company_name" id="company_name" value="<?php if(isset($company_id)){  echo $company_name;} ?>" placeholder="Company Name" minlength="5" maxlength="50"  >
                      
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-lg-4 col-form-label form-control-label">Company Email<span class="required">*</span></label>
                    <div class="col-lg-8">
                      <input class="form-control" name="company_email" id="company_email" type="email" minlength="5" maxlength="50" value="<?php if(isset($company_id)){  echo $company_email;} ?>" required="" placeholder="Company Email">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-lg-4 col-form-label form-control-label">Company Number<span class="required">*</span></label>
                    <div class="col-lg-8">
                      <input required="" class="form-control onlyNumber"  name="company_contact_number" id="company_contact_number"  minlength="6"   maxlength="12"  type="text" value="<?php if(isset($company_id)){  echo $company_contact_number; } ?>" placeholder="Company Contact Number" >
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-lg-4 col-form-label form-control-label">Company Website <span class="required">*</span></label>
                    <div class="col-lg-8">
                      <input required="" type="url" class="form-control" name="company_website" id="company_website" value="<?php if(isset($company_id)){  echo $company_website; } ?>" placeholder="Company Website" minlength="3" maxlength="50"  >
                      
                    </div>
                  </div>
                  <div class="form-group row">
                    
                    
                    <label class="col-lg-4 col-form-label form-control-label">Company Logo</label>
                    <div class="col-lg-8">
                      <input accept="image/*" class="form-control-file border" id="imgInp" name="company_logo" type="file">
                      <?php if(isset($company_id)){ ?>
                        <input class="form-control" name="company_logo_old" type="hidden" value="<?php  echo $company_logo; ?>">
                      <?php } ?>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="country_id" class="col-lg-4 col-form-label"> Country <span class="required">*</span></label>
                    <div class="col-lg-8">
                      <select type="text" required="" id="country_id" onchange="getStates();" class="form-control single-select" name="country_id">
                        <option value="">-- Select --</option>
                        <?php
                        $q3=$d->select("countries","flag=1","");
                        while ($blockRow=mysqli_fetch_array($q3)) {
                          ?>
                          <option <?php if(  isset($company_id) &&   $country_id==$blockRow['country_id']) {echo "selected";} ?> value="<?php echo $blockRow['country_id'];?>"><?php echo $blockRow['country_name'];?></option>
                        <?php }?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="state_id" class="col-lg-4 col-form-label"> State <span class="required">*</span></label>
                    <div class="col-lg-8">
                      
                      <select type="text" onchange="getCityNew();"  required="" class="form-control single-select" id="state_id" name="state_id">
                        <?php
                        $q31=$d->select("states","country_id='$country_id'","");
                        while ($blockRow11=mysqli_fetch_array($q31)) {
                          ?>
                          <option <?php if( isset($company_id) && $state_id==$blockRow11['state_id']) {echo "selected";} ?> value="<?php echo $blockRow11['state_id'];?>"><?php echo $blockRow11['state_name'];?></option>
                        <?php }  ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="input-101" class="col-lg-4 col-form-label"> City <span class="required">*</span></label>
                    <div class="col-lg-8">
                      
                      <select type="text"    required="" class="form-control single-select" id="city_id" name="city_id">
                        <?php

                        $company_master_qry=$d->select("company_master","status = 0  and is_master= 0 and company_id !='$company_id'  ","");
                        $company_cities = array('0');
                        while ($company_master_data=mysqli_fetch_array($company_master_qry)) {
                          $company_cities[] = $company_master_data['city_id'];
                        }

                        $company_cities = implode(",", $company_cities); 


                        $q34=$d->select("cities","state_id='$state_id' and city_id not in (". $company_cities.") ","");
                        while ($blockRow12=mysqli_fetch_array($q34)) {
                          ?>
                          <option <?php if( isset($company_id) && $city_id==$blockRow12['city_id']) {echo "selected";} ?> value="<?php echo $blockRow12['city_id'];?>"><?php echo $blockRow12['city_name'];?></option>
                        <?php }  ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="input-10" class="col-lg-4 col-form-label">Address <span class="required">*</span></label>
                    <div class="col-lg-8">
                      <textarea  required="" class="form-control" id="company_address" name="company_address"><?php if(isset($company_id)){  echo $company_address; }?></textarea>
                      
                    </div>
                  </div>
                  
                  <div class="form-group row">
                   <label for="comp_gst_number" class="col-sm-4 col-form-label">GST Number <span class="required">*</span></label>
                   <div class="col-sm-8">
                    

                     <input maxlength="15" minlength="15"  required="" type="text" class="form-control text-uppercase" name="comp_gst_number" id="comp_gst_number" value="<?php if(isset($company_id)){  echo $comp_gst_number; } ?>" placeholder="GST Number" minlength="3" maxlength="80"  >

                     
                   </div>
                 </div>
                 
                 
                 
                 <div class="form-group row">
                  <div class="col-lg-12 text-center">
                    <input type="submit"   class="btn btn-primary" name="updateCompDetails"  value="Update">
                  </div>
                </div>
              </form>
            </div>
            
          </div>
        </div>
      </div>
    </div>
  </div>
  
<?php  } else {
  echo "<img width='250' src='img/no_data_found3.png'>";
} ?>
</div>
</div>
<script src="assets/js/jquery.min.js"></script>
<script type="text/javascript">
  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        $('#blah').attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
    }
  }
  $("#imgInp").change(function() {
    readURL(this);
  });

</script>