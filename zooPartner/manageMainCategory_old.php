<?php $starttime = microtime(true); ?>
<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
    <!-- End Breadcrumb-->
    
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <form id="manageSubCateFrm" action="controller/categoryController.php" method="post" >
              <input type="hidden" name="manageMainSubCategory" value="manageMainSubCategory">
              <input type="hidden" name="business_category_id_val" value="<?php echo $_REQUEST['business_category_id']; ?>">
              <?php
              if(isset($_REQUEST['business_category_id'])) {
              extract(array_map("test_input" , $_REQUEST));
              $q2=$d->select("business_categories","business_category_id ='$business_category_id'");
              $data2=mysqli_fetch_array($q2);
              }
              ?>
              <h4 class="form-header text-uppercase">
              <i class="fa fa-lock"></i>
              Manage Subcategory
              </h4>
              
              <div class="form-group row">
                <label for="input-10" class="col-sm-2 col-form-label">SUB CATEGORY NAME </label>
                <div class="col-sm-4">
                  
                  
                  <input disabled=""  maxlength="30" minlength="1" type="text"   class="form-control"    value="<?php echo $data2['category_name']; ?>">
                  
                </div>
                
              </div>
              
              <?php
              $business_category_id_old = $_REQUEST['business_category_id'];

            


              
              $business_category_id = $data2['business_category_id'];
              $q=$d->select("business_sub_categories, business_categories "," business_categories.business_category_id = business_sub_categories.business_category_id and business_categories.category_status = 0 and  business_sub_categories.sub_category_status = 0  order by business_categories.category_name asc   ");
              //  $data=mysqli_fetch_array($q);
              $business_sub_ctagory_relation_master=$d->select("business_sub_ctagory_relation_master","");
              $data_array = array('0');
              while ($business_sub_ctagory_relation_master_data=mysqli_fetch_array($business_sub_ctagory_relation_master)) {
              $data_array[] = $business_sub_ctagory_relation_master_data['related_sub_category_id'];
              }
 // main_cat_id = '$business_category_id_old'
              ?> 
              <div class="form-group row">
                
                <label for="input-11" class="col-sm-3 col-form-label">Related Categories <span class="required">*</span></label>
                <div class="col-sm-9" >
                  <?php  if (mysqli_num_rows($business_sub_ctagory_relation_master) == 0  || 1) { ?>
                  <input <?php if (mysqli_num_rows($business_sub_ctagory_relation_master) > 0 && 0 ) { echo "checked";} ?> type="checkbox" id="user-checkbox" class="chk_boxes" />
                  <label for="user-checkbox">Check All </label>
                <?php } ?> 
                </div>
              </div>
              <?php
            
              $incounter=1;

              $my_counter =1;
              while ($data=mysqli_fetch_array($q)) {
              // echo "$incounter%3 =>".($incounter%3) ."<br>";
              if( ($incounter%4) ==1 || $incounter==1){ ?>
            <?php if($incounter > 1) { echo '</div>';} ?>
            <div class="form-group row">
              <?php  } ?>
              <div class="col-sm-4" >
                <?php
                $ischecked="";
                if(in_array($data['business_sub_category_id'], $data_array)){
                $ischecked="checked";
                } ?>
               <input type="checkbox" <?php echo $ischecked;?> class="pagePrivilege" value="<?php echo $data['business_sub_category_id']; ?>" name="business_sub_category_id[]"  id="<?php echo $data['business_category_id']; ?>"/>  
                <label for="<?php echo $data['business_sub_category_id']; ?>"><?php echo $my_counter; $my_counter++;?>. <?php echo $data['sub_category_name']; ?> (<?php echo $data['category_name']; ?>)</label>
              </div>
              <?php
              $incounter++;
              if($incounter%4==0 && $incounter > 1){
              if($incounter==4) $incounter = 1;?>
            </div>
            
            <?php  }
            
            } ?>
            
            
            
          </div>
          
          <div class="form-footer text-center">
            <?php if(isset($_REQUEST['business_category_id'])) { ?>
            <button type="submit" name="manageCategoryBtn" class="btn btn-success"><i class="fa fa-check-square-o"></i> UPDATE</button>
            <?php }  ?>
            <button  type="reset" class="btn btn-danger"><i class="fa fa-times"></i> Reset</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  </div><!--End Row-->
</div>
<!-- End container-fluid-->

</div><!--End content-wrapper-->
<!--select icon modal -->
<script src="../zooAdmin/assets/js/jquery.min.js"></script>
<script type="text/javascript">
$(function() {
$('.chk_boxes').click(function() {
$('.pagePrivilege').prop('checked', this.checked);
});
});
</script>
<?php $end = microtime(true);

echo "Time Taken =".($end -$starttime); ?>