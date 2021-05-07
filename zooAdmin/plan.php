<?php
$package_name="";
$packaage_description="";
$package_amount="";
$no_of_month="";
extract(array_map("test_input" , $_POST));
if(isset($package_id))
{
  $q=$d->select("package_master","package_id='$package_id'");
  $row=mysqli_fetch_array($q);
  extract($row);
}
?>
<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
    <div class="row pt-2 pb-2">
      <div class="col-sm-9">
        <h4 class="page-title"> <?php if(isset($package_id))
{ echo 'Edit Package'; } else { echo 'Add Package';} ?> </h4>
        <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li>
           <li class="breadcrumb-item"><a href="plans">Member Plans</a></li>
            <li class="breadcrumb-item active" aria-current="page"> <?php if(isset($package_id))
{ echo 'Edit Package'; } else { echo 'Add Package';} ?></li>
         </ol>
      
      </div>
    </div>
    <!-- End Breadcrumb-->

    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <?php if(isset($package_id))
              { ?>
            <form id="planFrm" action="controller/packageController.php" method="POST">
              <h4 class="form-header text-uppercase">
                <i class="fa fa-inr"></i>
                Package Information
              </h4>

              <div class="form-group row">
                <label for="input-10" class="col-sm-2 col-form-label">Apple IAP Purchase <span class="required">*</span></label>
                <div class="col-sm-10">
                  <input disabled=""  type="text" required="" class="form-control" id="input-12" name="inapp_ios_purchase_id" value="<?php echo $inapp_ios_purchase_id; ?>" maxlength="255" minlength="3"  >
                </div>

              </div>

              <div class="form-group row">
                <label for="input-10" class="col-sm-2 col-form-label">Package Name <span class="required">*</span></label>
                <div class="col-sm-10">
                  <input type="text" required="" class="form-control" id="input-12" name="package_name" value="<?php echo $package_name; ?>" maxlength="80" minlength="3" >
                </div>

              </div>

              <div class="form-group row">
                <label for="gst_slab_id" class="col-sm-2 col-form-label">IS Only coupon package? <span class="required">*</span></label>
                <div class="col-sm-10">

                  
                 <select   name="is_cpn_package" id="is_cpn_package"  onchange="is_cpn_package_func();"   class="form-control single-select" name="gst_slab_id" type="text" >
                            <option <?php if($is_cpn_package == 0){ echo "selected";} ?> value="0">No</option>
                            <option <?php if($is_cpn_package == 1){ echo "selected";} ?>  value="1">Yes</option>
                              
                          </select>

                         
                </div>

              </div>

              <div class="form-group row">
                <label for="input-10" class="col-sm-2 col-form-label">Package Description <span class="required">*</span></label>
                <div class="col-sm-10">
                  <textarea maxlength="250" minlength="3" required="" class="form-control" id="input-123" name="packaage_description"><?php echo $packaage_description; ?></textarea>
                </div>

              </div>

              <div class="form-group row">
                <label for="input-12" class="col-sm-2 col-form-label"> Amount Without GST <span class="required">*</span></label>
                <div class="col-sm-10">

                  <?php //24nov2020 
                  $transection_master=$d->select("transection_master","  package_id= '$package_id' and (payment_status='success' OR payment_status='SUCCESS') ","");
                      if (mysqli_num_rows($transection_master) > 0  ) { ?>

                  <input disabled=""  type="text" min="1" size="20" required="" class="form-control allow_decimal" id="trlDays" maxlength="9"  value="<?php echo $package_amount; ?>">


                   <input type="hidden"  <?php if($is_cpn_package == 1){ echo "disabled";} ?>   name="package_amount" id="package_amount" value="<?php echo $package_amount; ?>">

                 <?php } else {?>
                   <input   type="text" min="1" size="20" required="" class="form-control allow_decimal" <?php if($is_cpn_package == 1){ echo "disabled";} ?>   id="package_amount" name="package_amount" value="<?php echo $package_amount; ?>"   maxlength="9"  >
                  <?php } //24nov2020 ?> 

                </div>

              </div>


              <div class="form-group row">
                <label for="gst_slab_id" class="col-sm-2 col-form-label">GST Slab <span class="required">*</span></label>
                <div class="col-sm-10">

                  <?php //24nov2020
                   $dis ="";
                  if (mysqli_num_rows($transection_master) > 0  ) {
                     $dis ="disabled";
                  }
                  ?>
                 <select <?php if($is_cpn_package == 1){ echo "disabled";} ?>   <?php echo $dis;?> id="gst_slab_id" required="" class="form-control single-select" name="gst_slab_id" type="text" >
                            <option value="">-- Select --</option>
                             <option <?php if($gst_slab_id == 0){ echo "selected";} ?>  value="0">None</option>
                            <?php $qb=$d->select("gst_master","status=0","");
                            while ($bData=mysqli_fetch_array($qb)) {?>
                              <option <?php if( isset($gst_slab_id) && $gst_slab_id == $bData['slab_id'] ){ echo "selected";} ?>   value="<?php echo $bData['slab_id']; ?>"><?php echo $bData['slab_percentage']; ?> %</option>
                            <?php } ?> 
                          </select>

                          <?php //24nov2020
                     if (mysqli_num_rows($transection_master) > 0  ) { ?>
                      <input type="hidden"  name="gst_slab_id" value="<?php echo $gst_slab_id; ?>">
                  <?php } ?>
                </div>

              </div>
              <div class="form-group row">
              <label class="col-lg-2 col-form-label form-control-label">Package Duration</label>
                      <div class="col-lg-4">
                        <div class="form-check-inline">
                          <label class="form-check-label">
                            <input <?php echo $dis;?>  <?php if($time_slab == 0) echo "checked";  ?> type="radio" checked="" class="form-check-input" value="0" name="time_slab"> Months
                          </label>
                        </div>
                        <div class="form-check-inline">
                          <label  class="form-check-label">
                            <input <?php echo $dis;?> type="radio"  <?php if($time_slab == 1) echo "checked";  ?>  class="form-check-input" value="1" name="time_slab"> Days
                          </label>
                        </div>
                      </div>

                       <?php //24nov2020
                     if (mysqli_num_rows($transection_master) > 0  ) { ?>
                      <input type="hidden"  name="time_slab" value="<?php echo $time_slab; ?>">
                  <?php } ?>

                    </div>
              <div class="form-group row">

                <label for="input-13" class="col-sm-2 col-form-label"> Duration <span id="time_slab_lbl"> <?php if($time_slab == 1) echo "Days"; else echo "Month"; ?> </span><span class="required">*</span></label>
                <div class="col-sm-10">
                  <input <?php echo $dis;?> type="text"  min="1" size="3"  required="" class="form-control" id="emp_sallary"  maxlength="3"  name="no_of_month" value="<?php echo $no_of_month; ?>">

                   <?php //24nov2020
                     if (mysqli_num_rows($transection_master) > 0  ) { ?>
                      <input type="hidden"  name="no_of_month" value="<?php echo $no_of_month; ?>">
                  <?php } ?>

                  
                </div>
              </div>

           
                <div class="form-footer text-center">
              <?php if(isset($updatepackage))
              {
                ?>
                <input type="hidden" name="package_id" value="<?php echo ($package_id) ?>">
                <input type="submit" name="updatepackage" value="update package" class="btn btn-success">  
              <?php } else  { ?>   



                  <button type="submit" name="addpackage" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
                </div>
              <?php } ?>
            </form>
          <?php } else { 

  $package_master_qry=$d->selectRow("max(package_id) as maxId","package_master","");
  $package_master_data=mysqli_fetch_array($package_master_qry);
            ?>
             <form id="planFrm" action="controller/packageController.php" method="POST">
                <h4 class="form-header text-uppercase">
                  <i class="fa fa-inr"></i>
                  Package Information
                </h4>

              <div class="form-group row">
                <label for="input-10" class="col-sm-2 col-form-label">Apple IAP Purchase <span class="required">*</span></label>
                <div class="col-sm-10">
                  <input disabled=""  type="text" required="" class="form-control"     value="com.zoobiz.<?php echo $package_master_data['maxId']; ?>" maxlength="255" minlength="3"  >

                  <input    type="hidden" required="" class="form-control" name="inapp_ios_purchase_id"     value="com.zoobiz.<?php echo $package_master_data['maxId']; ?>" maxlength="255" minlength="3"  >
                </div>

              </div>


                <div class="form-group row">
                  <label for="input-10" class="col-sm-2 col-form-label">Package Name <span class="required">*</span></label>
                  <div class="col-sm-10">
                    <input type="text" required="" maxlength="80" minlength="3" class="form-control"  name="package_name" value="<?php echo $package_name; ?>">
                  </div>

                </div>

                  <div class="form-group row">
                <label for="gst_slab_id" class="col-sm-2 col-form-label">IS Only coupon package? <span class="required">*</span></label>
                <div class="col-sm-10">

                  
                 <select onchange="is_cpn_package_func();"   name="is_cpn_package"  id="is_cpn_package"    class="form-control single-select"   type="text" >
                            <option  value="0">No</option>
                            <option   value="1">Yes</option>
                              
                          </select>

                         
                </div>

              </div>

                <div class="form-group row">
                  <label for="input-10" class="col-sm-2 col-form-label">Package Description <span class="required">*</span></label>
                  <div class="col-sm-10">
                    <textarea required="" maxlength="250" minlength="3" class="form-control"  name="packaage_description"><?php echo $packaage_description; ?></textarea>
                  </div>

                </div>

                <div class="form-group row">
                  <label for="input-12" class="col-sm-2 col-form-label"> Amount Without GST  <span class="required">*</span></label>
                  <div class="col-sm-10">
                    <input type="text" min="1"  maxlength="9" required="" class="form-control allow_decimal" id="package_amount" name="package_amount" value="<?php echo $package_amount; ?>">
                  </div>

                </div>


                <div class="form-group row">
                <label for="gst_slab_id" class="col-sm-2 col-form-label">GST Slab <span class="required">*</span></label>
                <div class="col-sm-10">
                 <select id="gst_slab_id" required="" class="form-control single-select" name="gst_slab_id" type="text" >
                            <option value="">-- Select --</option>
                            <option <?php if( isset($gst_slab_id) && $gst_slab_id == 0){ echo "selected";} ?>  value="0">None</option>
                            <?php $qb=$d->select("gst_master","status=0","");
                            while ($bData=mysqli_fetch_array($qb)) {?>
                              <option <?php if( isset($gst_slab_id) && $gst_slab_id == $bData['slab_id'] ){ echo "selected";} ?>   value="<?php echo $bData['slab_id']; ?>"><?php echo $bData['slab_percentage']; ?> %</option>
                            <?php } ?> 
                          </select>
                </div>

              </div>

              <div class="form-group row">
              <label class="col-lg-2 col-form-label form-control-label">Package Duration</label>
                      <div class="col-lg-4">
                        <div class="form-check-inline">
                          <label class="form-check-label">
                            <input type="radio" checked="" class="form-check-input" value="0" name="time_slab"> Months
                          </label>
                        </div>
                        <div class="form-check-inline">
                          <label class="form-check-label">
                            <input type="radio"   class="form-check-input" value="1" name="time_slab"> Days
                          </label>
                        </div>
                      </div>
                    </div>
                <div class="form-group row">

                  <label for="input-13" class="col-sm-2 col-form-label"> Duration <span id="time_slab_lbl"> Month</span> <span class="required">*</span></label>
                  <div class="col-sm-10">
                    <input min="1" maxlength="3" type="text" required="" class="form-control" id="emp_sallary" name="no_of_month" value="<?php echo $no_of_month; ?>">
                  </div>
                </div>

             
                  <div class="form-footer text-center">
                <?php if(isset($updatepackage))
                {
                  ?>
                  <input type="hidden" name="package_id" value="<?php echo ($package_id) ?>">
                  <input type="submit" name="updatepackage" value="update package" class="btn btn-success">  
                <?php } else  { ?>   
                    <button type="submit" name="addpackage" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
                  </div>
                <?php } ?>
            </form>
          <?php } ?>

          </div>
        </div>
      </div>
    </div><!--End Row-->

  </div>
  <!-- End container-fluid-->

    </div><!--End content-wrapper-->
<script src="assets/js/jquery.min.js"></script>
<script type="text/javascript">

  $(function() {

    $('.chk_boxes').click(function() {

        $('.menu_id').prop('checked', this.checked);

    });

});

</script>