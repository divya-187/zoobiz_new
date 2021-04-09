<?php  error_reporting(0);
extract($_REQUEST);
if(isset($company_id)){
$company_master=$d->select("company_master,payment_getway_master"," payment_getway_master.company_id=company_master.company_id and  company_master.company_id= '$company_id' ","");
$company_master_data=mysqli_fetch_array($company_master);
extract($company_master_data);
}
?>
<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
    <div class="row pt-2 pb-2">
      <div class="col-sm-9">
        <?php if(isset($company_id)){?>
        <h4 class="page-title">Edit Company</h4>
        <?php  } else {?>
        <h4 class="page-title">Add Company</h4>
        <?php } ?>
        <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li>
           <li class="breadcrumb-item"><a href="companyList">Company List</a></li>
            <li class="breadcrumb-item active" aria-current="page"> <?php if(isset($company_id)){?>
         Edit Company 
        <?php  } else {?>
        Add Company 
        <?php } ?></li>
         </ol>
      </div>
      
    </div>
    <!-- End Breadcrumb-->
    
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            
            <form id="companyFrm" action="controller/companyController.php" method="post" enctype="multipart/form-data">
              
              <fieldset class="scheduler-border">
                <legend  class="scheduler-border">Company Details</legend>
                <div class="form-group row">
                  
                  <label class="col-lg-2 col-form-label form-control-label">Company Name <span class="required">*</span></label>
                  <div class="col-lg-10">
                    <input  required="" type="text" class="form-control" name="company_name" id="company_name" value="<?php if(isset($company_id)){  echo $company_name;} ?>" placeholder="Company Name" minlength="5" maxlength="80"  >
                    
                  </div>
                  
                </div>
                <div class="form-group row">
                  <label class="col-lg-2 col-form-label form-control-label">Company Email<span class="required">*</span></label>
                  <div class="col-lg-4">
                    <input class="form-control" name="company_email" id="company_email" type="email" minlength="5" maxlength="50" value="<?php if(isset($company_id)){  echo $company_email;} ?>" required="" placeholder="Company Email">
                  </div>
                  <label class="col-lg-2 col-form-label form-control-label">Company Number<span class="required">*</span></label>
                  <div class="col-lg-4">
                    <input required="" class="form-control onlyNumber"  name="company_contact_number" id="company_contact_number"  minlength="6"   maxlength="12"  type="text" value="<?php if(isset($company_id)){  echo $company_contact_number; } ?>" placeholder="Company Contact Number" >
                    
                    
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-lg-2 col-form-label form-control-label">Company Website <span class="required">*</span></label>
                  <div class="col-lg-10">
                    <input required="" type="url" class="form-control" name="company_website" id="company_website" value="<?php if(isset($company_id)){  echo $company_website; } ?>" placeholder="Company Website" minlength="3" maxlength="80"  >
                    
                  </div>
                </div>
                
                <div class="form-group row">
                  
                  
                  <label class="col-lg-2 col-form-label form-control-label">Company Logo</label>
                  <div class="col-lg-4">
                    <input accept="image/*" class="form-control-file border" id="imgInp" name="company_logo" type="file">
                    <?php if(isset($company_id)){ ?>
                    <input class="form-control" name="company_logo_old" type="hidden" value="<?php  echo $company_logo; ?>">
                    <?php } ?>
                  </div>
                  <label for="country_id" class="col-sm-2 col-form-label"> Country <span class="required">*</span></label>
                  <div class="col-sm-4">
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
                  
                  <label for="state_id" class="col-sm-2 col-form-label"> State <span class="required">*</span></label>
                  <div class="col-sm-4">
                    <?php  if(isset($company_id)){ ?>
                    
                    <select type="text" onchange="getCityNew();"  required="" class="form-control single-select" id="state_id" name="state_id">
                      <?php
                      $q31=$d->select("states","country_id='$country_id'","");
                      while ($blockRow11=mysqli_fetch_array($q31)) {
                      ?>
                      <option <?php if( isset($company_id) && $state_id==$blockRow11['state_id']) {echo "selected";} ?> value="<?php echo $blockRow11['state_id'];?>"><?php echo $blockRow11['state_name'];?></option>
                      <?php }  ?>
                    </select>
                    <?php } else { ?>
                    <select type="text" onchange="getCityNew();"  required="" class="form-control single-select" id="state_id" name="state_id">
                      <option value="">-- Select --</option>
                    </select>
                    <?php } ?>
                  </div>
                  <label for="input-101" class="col-sm-2 col-form-label"> City <span class="required">*</span></label>
                  <div class="col-sm-4">
                    <?php  if(isset($company_id)){ ?>
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
                    <?php } else { ?>
                    <select  type="text"   required="" class="form-control single-select" name="city_id" id="city_id">
                      <option value="">-- Select --</option>
                      
                    </select>
                    <?php } ?>
                  </div>
                  
                </div>
                <div class="form-group row">
                  <label for="input-10" class="col-sm-2 col-form-label">Address <span class="required">*</span></label>
                  <div class="col-sm-10">
                    <textarea  required="" class="form-control" id="company_address" name="company_address"><?php if(isset($company_id)){  echo $company_address; }?></textarea>
                    
                  </div>
                  
                </div>
                <div class="form-group row">
                  <label for="comp_gst_number" class="col-sm-2 col-form-label">GST Number <span class="required">*</span></label>
                  <div class="col-sm-10">
                    

                     <input maxlength="15" minlength="15"  required="" type="text" class="form-control text-uppercase" name="comp_gst_number" id="comp_gst_number" value="<?php if(isset($company_id)){  echo $comp_gst_number; } ?>" placeholder="GST Number" minlength="3" maxlength="80"  >

                    
                  </div>
                  
                </div>
                
              </fieldset>
              <fieldset class="scheduler-border">
                <legend  class="scheduler-border">Payment Details</legend>
                <div class="form-group row">
                  <label class="col-lg-2 col-form-label form-control-label">Payment Gateway Name <span class="required">*</span></label>
                  <div class="col-lg-10">
                    <input required=""  type="text" class="form-control" name="payment_getway_name" id="payment_getway_name" value="<?php if(isset($company_id)){  echo $payment_getway_name; } ?>" placeholder="Payment Gateway Name" minlength="3" maxlength="50"  >
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-lg-2 col-form-label form-control-label">Razor  Pay keyId <span class="required">*</span></label>
                  <div class="col-lg-4">
                    <input required=""  type="text" class="form-control" name="merchant_id" id="merchant_id" value="<?php if(isset($company_id)){  echo $merchant_id; } ?>" placeholder="Razor Pay keyId" minlength="3" maxlength="50"  >
                  </div>
                  <label class="col-lg-2 col-form-label form-control-label">Razor Pay Secret key <span class="required">*</span></label>
                  <div class="col-lg-4">
                    <input required=""  type="text" class="form-control" name="merchant_key" id="merchant_key" value="<?php if(isset($company_id)){  echo $merchant_key; } ?>" placeholder="Razor Pay Secret key" minlength="3" maxlength="50"  >
                  </div>
                </div>
                <div class="form-group row">
                  <!-- <label class="col-lg-2 col-form-label form-control-label">Salt Key <span class="required">*</span></label>
                  <div class="col-lg-4">
                    <input required=""  type="text" class="form-control" name="salt_key" id="salt_key" value="<?php if(isset($company_id)){  echo $salt_key; } ?>" placeholder="Salt Key" minlength="3" maxlength="50"  >
                  </div> -->
                  <label class="col-lg-2 col-form-label form-control-label">Payment Gateway Email</label>
                  <div class="col-lg-4">
                    <input type="text" class="form-control" name="payment_getway_email" id="payment_getway_email" value="<?php if(isset($company_id)){  echo $payment_getway_email; } ?>" placeholder="Payment Gateway Email" minlength="3" maxlength="50"  >
                  </div>
                  <label class="col-lg-2 col-form-label form-control-label">Payment Gateway Contact</label>
                  <div class="col-lg-4">
                    <input type="text" class="form-control onlyNumber" name="payment_getway_contact" id="payment_getway_contact" value="<?php if(isset($company_id) && $payment_getway_contact !="0"){  echo $payment_getway_contact; } ?>" placeholder="Payment Gateway Contact" minlength="6" maxlength="12"  >
                  </div>
                  <label class="col-lg-2 col-form-label form-control-label">Payment Gateway Logo</label>
                  <div class="col-lg-4">
                    <input accept="image/*" class="form-control-file border" id="imgInp" name="payment_getway_logo" type="file">
                    <?php if(isset($company_id)){ ?>
                    <input class="form-control" name="payment_getway_logo_old" type="hidden" value="<?php echo $payment_getway_logo; ?>">
                    <?php } ?>
                  </div>

                  <label class="col-lg-2 col-form-label form-control-label">Display Currency <span class="required">*</span></label>
                  <div class="col-lg-4">

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
                <div class="form-group row">
                  
                </div>


                
              </fieldset>




<?php //17feb21 ?>
<fieldset class="scheduler-border">
                <legend  class="scheduler-border">UPI Details</legend>
                <div class="form-group row">
                  <label class="col-lg-2 col-form-label form-control-label">Name</label>
                  <div class="col-lg-4">
                    <input    type="text" class="form-control" name="upi_name" id="upi_name" value="<?php if(isset($company_id)){  echo $upi_name; } ?>" placeholder="Name" minlength="3" maxlength="50"  >
                  </div>
                
                  <label class="col-lg-2 col-form-label form-control-label">UPI ID</label>
                  <div class="col-lg-4">
                    <input    type="text" class="form-control" name="upi_id" id="upi_id" value="<?php if(isset($company_id)){  echo $upi_id; } ?>" placeholder="UPI ID" minlength="3" maxlength="50"  >
                  </div>
                  
                </div>
                 

                
             
              </fieldset>
 
<fieldset class="scheduler-border">
                <legend  class="scheduler-border">CCAvenue Details</legend>
                <div class="form-group row">
                  <label class="col-lg-2 col-form-label form-control-label">merchant id </label>
                  <div class="col-lg-4">
                    <input    type="text" class="form-control" name="ccav_merchant_id" id="ccav_merchant_id" value="<?php if(isset($company_id)){  echo $ccav_merchant_id ; } ?>" placeholder="Merchant Id" minlength="3" maxlength="50"  >
                  </div>
                
                  <label class="col-lg-2 col-form-label form-control-label">access code</label>
                  <div class="col-lg-4">
                    <input    type="text" class="form-control" name="ccav_access_code" id="ccav_access_code" value="<?php if(isset($company_id)){  echo $ccav_access_code; } ?>" placeholder="Access Code" minlength="3" maxlength="50"  >
                  </div>
                  
                </div>
                 

                  <div class="form-group row">
                  <label class="col-lg-2 col-form-label form-control-label">working key </label>
                  <div class="col-lg-4">
                    <input    type="text" class="form-control" name="ccav_working_key" id="ccav_working_key" value="<?php if(isset($ccav_working_key)){  echo $ccav_working_key ; } ?>" placeholder="Working Key" minlength="3" maxlength="50"  >
                  </div>
                
                  <label class="col-lg-2 col-form-label form-control-label">Live Mode  </label>
                  <div class="col-lg-4">

                    <select      required="" class="form-control single-select" id="ccav_live_mode" name="ccav_live_mode">
                       <option value="Yes"  <?php if( isset($company_id) && $ccav_live_mode=='Yes') {echo "selected";} ?> >Yes</option>
                        <option value="No" <?php if( isset($company_id) && $ccav_live_mode=='No') {echo "selected";} ?> >No</option>
                      
                    </select>


                  
                  </div>
                  
                </div>

                
                

             
              </fieldset>
 
 <fieldset class="scheduler-border">
                <legend  class="scheduler-border">Paytm Details</legend>
                <div class="form-group row">
                  <label class="col-lg-2 col-form-label form-control-label">Name </label>
                  <div class="col-lg-4">
                    <input    type="text" class="form-control" name="paytm_name" id="paytm_name" value="<?php if(isset($company_id)){  echo $paytm_name ; } ?>" placeholder="Name" minlength="3" maxlength="50"  >
                  </div>
                
                  <label class="col-lg-2 col-form-label form-control-label">Merchant Id</label>
                  <div class="col-lg-4">
                    <input    type="text" class="form-control" name="paytm_merchant_id" id="paytm_merchant_id" value="<?php if(isset($company_id)){  echo $paytm_merchant_id; } ?>" placeholder="Merchant Id" minlength="3" maxlength="50"  >
                  </div>
                  
                </div>
                 

                  <div class="form-group row">
                  <label class="col-lg-2 col-form-label form-control-label">Merchant key </label>
                  <div class="col-lg-4">
                    <input    type="text" class="form-control" name="paytm_merrchant_key" id="paytm_merrchant_key" value="<?php if(isset($company_id)){  echo $paytm_merrchant_key ; } ?>" placeholder="Merchant Key" minlength="3" maxlength="50"  >
                  </div>
                
                  <label class="col-lg-2 col-form-label form-control-label">Live Mode  </label>
                  <div class="col-lg-4">

                    <select      required="" class="form-control single-select" id="paytm_is_live_mode" name="paytm_is_live_mode">
                       <option value="Yes"  <?php if( isset($company_id) && $paytm_is_live_mode=='Yes') {echo "selected";} ?> >Yes</option>
                        <option value="No" <?php if( isset($company_id) && $paytm_is_live_mode=='No') {echo "selected";} ?> >No</option>
                      
                    </select>


                  
                  </div>
                  
                </div>


                <div class="form-group row">
                  <label class="col-lg-2 col-form-label form-control-label">Test Mode MERCHANT ID </label>
                  <div class="col-lg-4">
                   <input    type="text" class="form-control" name="test_paytm_merchant_id" id="test_paytm_merchant_id" value="<?php if(isset($company_id)){  echo $test_paytm_merchant_id; } ?>" placeholder="Test Merchant Id" minlength="3" maxlength="50"  >
                  </div>
                
                   <label class="col-lg-2 col-form-label form-control-label">Test Mode MERCHANT KEY </label>
                  <div class="col-lg-4">
                    <input    type="text" class="form-control" name="test_paytm_merrchant_key" id="test_paytm_merrchant_key" value="<?php if(isset($company_id)){  echo $test_paytm_merrchant_key ; } ?>" placeholder="Test Merchant Key" minlength="3" maxlength="50"  >
                  </div>
                  
                </div>

                
             
              </fieldset>


              <div class="form-footer text-center">
                
                <?php  if(isset($company_id)){ ?>
                <input type="hidden" name="company_id" value="<?php echo $company_id;?>">
                 <input type="hidden" name="compnayEdit" value="compnayEdit">
                <button type="submit" name="compnayEditBtn" class="btn btn-success"><i class="fa fa-check-square-o"></i> UPDATE</button>
                <?php  } else {?>
                  <input type="hidden" name="compnayAdd" value="compnayAdd">
                <button type="submit" name="compnayAddBtn" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
                <?php }?>
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