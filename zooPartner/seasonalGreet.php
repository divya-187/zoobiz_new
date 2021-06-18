<?php  error_reporting(0);
extract($_REQUEST);
if(isset($seasonal_greet_id)){
$seasonal_greet_master=$d->select("seasonal_greet_master","  seasonal_greet_id = '$seasonal_greet_id' ","");
$seasonal_greet_master_data=mysqli_fetch_array($seasonal_greet_master);
extract($seasonal_greet_master_data);
}
?>
<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
    <div class="row pt-2 pb-2">
      <div class="col-sm-9">
        <?php if(isset($seasonal_greet_id)){?>
        <h4 class="page-title">Edit Seasonal Greetings</h4>
        <?php  } else {?>
        <h4 class="page-title">Add Seasonal Greetings</h4>
        <?php } ?>

         <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li>

           <li class="breadcrumb-item"><a href="seasonalGreetList">Seasonal Greetings List</a></li>
            <li class="breadcrumb-item active" aria-current="page"> <?php if(isset($seasonal_greet_id)){?>
         Edit Seasonal Greetings 
        <?php  } else {?>
        Add Seasonal Greetings 
        <?php } ?></li>
         </ol>
        
      </div>
      
    </div>
    <!-- End Breadcrumb-->
    
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            
            <form id="seasonalGreetFrm" action="controller/seasonalGreetController.php" method="post" enctype="multipart/form-data" >
              <?php if(isset($seasonal_greet_id)){ ?> 
              <input type="hidden" name="promotionEditBtn" value="promotionEditBtn">
            <?php  } else {?>
                <input type="hidden" name="promotionAddBtn" value="promotionAddBtn">
              <?php } ?> 
              
               <?php if(isset($seasonal_greet_id)){ ?> 
              <input type="hidden" id="isEdit" value="yes">
            <?php  } else {?>
                <input type="hidden" id="isEdit" value="no">
              <?php } ?> 
              
              <div class="form-group row">
                
                <label class="col-lg-2 col-form-label form-control-label">Title<span class="required">*</span></label>
                <div class="col-lg-10">
                  <input  required="" type="text" class="form-control  " name="title" id="title" value="<?php if(isset($seasonal_greet_id)){  echo $title;} ?>" placeholder="Title" minlength="3" maxlength="100"  >
                  
                </div>
               </div>

                <div class="form-group row">
                <label for="is_expiry" class="col-sm-2 col-form-label">Is Expiry?</label>
                <div class="col-sm-4">
                  <select id="is_expiry"   class="form-control single-select" name="is_expiry" type="text" onchange="isExpire();"  required=""  >
                     
                      <option  <?php if(isset($seasonal_greet_id) && $is_expiry == "Yes" ){  echo "selected";} ?>   value="Yes">Yes</option>
                      <option   <?php if(isset($seasonal_greet_id) && $is_expiry == "No" ){  echo "selected";} ?> value="No">No</option> 
                     
                  </select>
                </div>
                 
              
                <label for="status" class="col-sm-2 col-form-label">Status</label>
                <div class="col-sm-4">
                  <select id="status"   class="form-control single-select" name="status" type="text"   required=""  >
                     
                      <option  <?php if(isset($seasonal_greet_id) && $status == "Active" ){  echo "selected";} ?>   value="Active">Active</option>
                      <option   <?php if(isset($seasonal_greet_id) && $status == "Inactive" ){  echo "selected";} ?> value="Inactive">InActive</option> 
                     
                  </select>
                </div>
                 
              </div>


              <span id="date_div" <?php if($is_expiry == "No") {?> style="display: none;" <?php } ?> >
               <div   class="form-group row" >
              
                  <label class="col-lg-2 col-form-label form-control-label">Start Date <span class="required">*</span></label>
                  <div class="col-lg-4" >
                     
                      <input id="start-date" required="" type="text"  readonly="" class="form-control"   value="<?php if(isset($seasonal_greet_id) && ($start_date !="1970-01-01" && $start_date !="0000-00-00")  ){ echo date("d-m-Y", strtotime($start_date)); }?>"  name="start_date"  >
                   </div>

                   


                  <label class="col-lg-2 col-form-label form-control-label">End Date <span class="required">*</span></label>
                  <div class="col-lg-4"  >
                     
                     <input id="end-date" required="" type="text"  readonly="" class="form-control"   value="<?php if(isset($seasonal_greet_id) && ($end_date !="1970-01-01" && $end_date !="0000-00-00")   ){ echo date("d-m-Y", strtotime($end_date)); }?>"  name="end_date"  >
                     
                     
                  </div>
                </div>

                <div   class="form-group row" >
                    <label class="col-lg-2 col-form-label form-control-label">Event Date 
                  (for sorting) <span class="required">*</span></label>
                <div class="col-lg-4">
                  <input  required="" readonly="" type="text" class="form-control  " name="order_date" id="autoclose-datepicker-evt" value="<?php if(isset($seasonal_greet_id) && ($order_date !="1970-01-01" && $order_date !="0000-00-00")   ){ echo date("d-m-Y", strtotime($order_date)); }?>"  minlength="5" maxlength="50"  >
                  
                </div>
                </div>

               </span>
 
                
                <div class="form-footer text-center">
                  
                  <?php  if(isset($seasonal_greet_id)){ ?>
                  <input type="hidden" name="seasonal_greet_id" value="<?php echo $seasonal_greet_id;?>">
                  <button type="submit" name="updateSeasonalGreet" class="btn btn-success"><i class="fa fa-check-square-o"></i> UPDATE</button>
                  <?php  } else {?>
                  <button type="submit" name="addSeasonalGreet" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
                  <?php }?>
                  <a href="seasonalGreetList" class="btn btn-danger">Cancel</a>
                  
                </div>
              </form>
            </div>
          </div>
        </div>
        </div><!--End Row-->
      </div>
      <!-- End container-fluid-->
      </div><!--End content-wrapper-->
      