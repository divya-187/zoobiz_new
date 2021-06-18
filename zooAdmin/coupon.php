<?php  error_reporting(0);
extract($_REQUEST);
if(isset($coupon_id)){
$coupon_master=$d->select("coupon_master","  coupon_id= '$coupon_id' ","");
$coupon_master_data=mysqli_fetch_array($coupon_master);
extract($coupon_master_data);
}
?>
<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
    <div class="row pt-2 pb-2">
      <div class="col-sm-9">
        <?php if(isset($onlyView)){?>
        <h4 class="page-title">View Coupon</h4>
        <?php  } else if(isset($coupon_id)){?>
        <h4 class="page-title">Edit Coupon</h4>
        <?php  }  else {?>
        <h4 class="page-title">Add Coupon</h4>
        <?php } ?>
         <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li>
            <li class="breadcrumb-item"><a href="couponList">Coupon List</a></li>
            <li class="breadcrumb-item active" aria-current="page">  <?php if(isset($onlyView)){?>
         View Coupon 
        <?php  } else if(isset($coupon_id)){?>
         Edit Coupon 
        <?php  }  else {?>
       Add Coupon 
        <?php } ?></li>
         </ol>
      </div>
      
    </div>
    <!-- End Breadcrumb-->
    
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            
            <form id="cpnFrm" action="controller/couponController.php" method="post" enctype="multipart/form-data">
              <?php
              if(isset($coupon_id)){
                ?>
<input type="hidden" name="isedit" id="isedit" value="yes">
                <?php
              } else { ?>
               <input type="hidden" name="isedit" id="isedit" value="no">
             <?php  } ?>
              <fieldset class="scheduler-border">
                <legend  class="scheduler-border">Coupon Details</legend>

 <div class="form-group row">
                 <label class="col-lg-2 col-form-label form-control-label">Membership Plan <span class="required">*</span></label>
                      <div class="col-lg-10">
                         <select id="plan_id" required="" class="form-control single-select" name="plan_id" type="text"  onchange="planDetails();">
                            <option value="">-- Select --</option>
                            <?php $qb=$d->select("package_master","","");

                            $max_amount = 0 ;
                            while ($bData=mysqli_fetch_array($qb)) {?>
                              <option <?php if(isset($coupon_id) &&  $bData['package_id']== $plan_id ){ $max_amount =$bData['package_amount'] ;    echo "selected";} ?>   value="<?php echo $bData['package_id']; ?>"><?php echo $bData['package_name']; ?>-<?php echo $bData['no_of_month']; ?> <?php if($bData['time_slab'] == 1) echo "Days"; else echo "Month"; ?> (₹ <?php echo $bData['package_amount']; ?> ) <?php if($bData['is_cpn_package'] ==1){ echo "- Promotion Only Plan";} ?> </option>
                            <?php } ?> 
                          </select>
                         
                      </div>
</div>

                <div class="form-group row">
                  
                  <label class="col-lg-2 col-form-label form-control-label">Coupon Name <span class="required">*</span></label>
                  <div class="col-lg-10">
                    <input  required="" type="text" class="form-control" name="coupon_name" id="coupon_name" value="<?php if(isset($coupon_id)){  echo $coupon_name;} ?>" placeholder="Coupon Name" minlength="3" maxlength="80"  >
                    
                  </div>
                 
                </div>
                <div class="form-group row">
                   
                  <label class="col-lg-2 col-form-label form-control-label">Coupon Code <span class="required">*</span></label>
                  <div class="col-lg-3" id="coupon_code_div">
                     <?php  
                     $disabled = "";
                     $cpn_valid = 0 ; 
                     $transection_master=$d->select("transection_master","  coupon_id= '$coupon_id' ","");   

                     if (mysqli_num_rows($transection_master) > 0 && isset($coupon_id) ) { 
                      $disabled = "disabled";
                      $cpn_valid = 0 ; 
                     }?> 
                    <input <?php echo $disabled;?>  class="alphanumeric text-uppercase form-control"      name="coupon_code" id="coupon_code" type="text" minlength="3" maxlength="20" value="<?php if(isset($coupon_id)){  echo $coupon_code;}  ?>" required="" placeholder="Coupon Code"  >
                     <?php if(isset($coupon_id)){ ?>
                      <input  id="cpn_valid" type="hidden"   value="1"   >
                     <?php } else { ?> 
                      <input  id="cpn_valid" type="hidden"   value="0"   >
                    <?php } ?> 
                      
                  </div>
                  <div class="col-lg-1" id="loader_cpn"></div>

                   <label for="cpn_expiry" class="col-sm-2 col-form-label"> Coupon Expiry <span class="required">*</span></label>
                  <div class="col-sm-4">
                    <select type="text" required="" id="cpn_expiry" onchange="isLifeTime();" class="form-control single-select" name="cpn_expiry">
                      
                      <option <?php if(isset($coupon_id) && $cpn_expiry==1){ echo 'selected="selected"';} ?> value="1">Yes</option>
                      <option <?php if(isset($coupon_id) && $cpn_expiry==0){ echo 'selected="selected"';} ?> value="0">No</option>
                       
                    </select>
                  </div>


                  
                </div>


                <span  <?php if(isset($coupon_id) && $cpn_expiry==1){ ?>  style="display: block;" <?php  }  else if(isset($coupon_id) && $cpn_expiry==0) {?>  style="display: none;" <?php } ?>  id="cpn_date_div"  >

                   <div   class="form-group row">
              
                  <label class="col-lg-2 col-form-label form-control-label">Start Date <span class="required">*</span></label>
                  <div class="col-lg-4" >
                     
                      <input id="start-date" required="" type="text"  readonly="" class="form-control"   value="<?php if(isset($coupon_id) && ($start_date !="1970-01-01" && $start_date !="0000-00-00")  ){ echo date("d-m-Y", strtotime($start_date)); }?>"  name="start_date"  >

                   
                     
                     
                  </div>

                   


                  <label class="col-lg-2 col-form-label form-control-label">End Date <span class="required">*</span></label>
                  <div class="col-lg-4"  >
                     
                     <input id="end-date" required="" type="text"  readonly="" class="form-control"   value="<?php if(isset($coupon_id) && ($end_date !="1970-01-01" && $start_date !="0000-00-00")   ){ echo date("d-m-Y", strtotime($end_date)); }?>"  name="end_date"  >
                     
                     
                  </div>
                </div>
              </span>

                <div class="form-group row">
                    <label for="is_unlimited" class="col-sm-2 col-form-label"> Is Coupon Uses Unlimited? <span class="required">*</span></label>
                  <div class="col-sm-4">
                    <select type="text" required="" id="is_unlimited" onchange="isUnlimited();" class="form-control single-select" name="is_unlimited">
                      
                      <option <?php if(isset($coupon_id) && $is_unlimited==1){ echo 'selected="selected"';} ?> value="1">Yes</option>
                      <option <?php if(isset($coupon_id) && $is_unlimited==0){ echo 'selected="selected"';} ?> value="0">No</option>
                       
                    </select>
                  </div>

                 
               
                  <label  <?php if(isset($coupon_id) && $is_unlimited==0){  }  else {?>  style="display: none;" <?php } ?>  id="cpn_use_lbl" class="col-lg-2 col-form-label form-control-label">Coupon Uses Number <span class="required">*</span></label>
                  <div class="col-lg-4"   <?php if(isset($coupon_id) && $is_unlimited==0){  }  else {?>  style="display: none;" <?php } ?>  id="cpn_use_div">
                    <input class="form-control onlyNumber"    name="coupon_limit" id="coupon_limit" type="text" min="1" max="25" value="<?php if(isset($coupon_id)){  echo $coupon_limit;} ?>" required="" placeholder="Coupon Uses">
                  </div>
                  
                

                </div>
               <?php  $package_master=$d->select("package_master"," package_id = '$plan_id'","");
               $package_master_data=mysqli_fetch_array($package_master);

                ?>
              <div class="form-group row">
      <label for="client" class="col-lg-2 col-form-label form-control-label">Coupon Amount  </label>
      <div class="col-lg-3">
        <input <?php if($package_master_data['is_cpn_package'] ==1){ echo "readonly";} ?>  maxlength="10" onchange="getNewPriceDiscountFlat();" class="form-control onlyNumber"  id="coupon_amount" type="text" name="coupon_amount" value="<?php echo  number_format( $coupon_amount, 2, '.', ''); ?>" placeholder=""   max="<?php if(isset($coupon_id)){ echo $max_amount; } ?>">
      </div>
      <div class="col-lg-2 text-center">
        <span  class="">OR</span>
      </div>
      <label for="client" class="col-lg-2 col-form-label form-control-label">Coupon Discount in % </label>
      <div class="col-lg-3">
        <input <?php if($package_master_data['is_cpn_package'] ==1){ echo "readonly";
      } ?>   maxlength="6" onchange="getNewPriceDiscountPer();" class="form-control onlyNumber"  id="coupon_per" type="text" name="coupon_per" value="<?php echo number_format($coupon_per,2); ?>" placeholder="" max="100"  >
      </div>

    </div>
              </fieldset>
               
                <?php if(!isset($onlyView)){?>
              <div class="form-footer text-center">
                 <?php if($disabled==""){?>  
                    <button   type="button"  id="generate" class="btn btn-secondary   "><i class="fa fa-cogs"></i>Generate Coupon Code</button>
                  <?php } ?> 
                <?php  if(isset($coupon_id)){ ?>
                <input type="hidden" name="coupon_id" id="coupon_id" value="<?php echo $coupon_id;?>">
                <button type="submit" name="cpnEditBtn" class="btn btn-success"><i class="fa fa-check-square-o"></i> UPDATE</button>
                <?php  } else {?>
                <button type="submit" name="cpnAddBtn" id="cpnAddBtn" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
                <?php }?>
                <button type="reset" class="btn btn-danger"><i class="fa fa-times"></i> RESET</button>
              </div>
            <?php } ?> 
            </form>
          </div>
        </div>
      </div>
      </div><!--End Row-->
    </div>
    <!-- End container-fluid-->
    </div><!--End content-wrapper-->