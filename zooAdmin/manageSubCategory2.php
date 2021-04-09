<?php $starttime = microtime(true); ?>
<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
     <div class="row pt-2 pb-2">
        <div class="col-sm-9">
          <h4 class="page-title">Bind Main Categories</h4>
          <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li>
           <li class="breadcrumb-item"><a href="subCategories">Sub Categories</a></li>
            <li class="breadcrumb-item active" aria-current="page">Bind Main Categories</li>
         </ol>
         
       </div>
       
   </div>
    <!-- End Breadcrumb-->
     
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <form id="manageSubCateFrm" action="controller/categoryController.php" method="post" >
              <input type="hidden" name="manageCategory2" value="manageCategory2">
              <input type="hidden" name="business_sub_category_id_val" value="<?php echo $_REQUEST['business_sub_category_id']; ?>">
              <?php
              if(isset($_REQUEST['business_sub_category_id'])) {
              extract(array_map("test_input" , $_REQUEST));
              $q2=$d->select("business_sub_categories","business_sub_category_id ='$business_sub_category_id'");
              $data2=mysqli_fetch_array($q2);
              }
              ?>
              <h4 class="form-header text-uppercase">
              <i class="fa fa-lock"></i>
              Bind Main categories
              </h4>
              
              <div class="form-group row">
                <label for="input-10" class="col-sm-2 col-form-label">SUB CATEGORY NAME </label>
                <div class="col-sm-4">
                  
                  
                  <input disabled=""  maxlength="30" minlength="1" type="text"   class="form-control"    value="<?php echo $data2['sub_category_name']; ?>">
                  
                </div>
                
              </div>
              
              <?php
              /*and    business_sub_categories.business_category_id = '$business_category_id' and business_sub_categories.business_sub_category_id !='$business_sub_category_id_old'*/
              $business_sub_category_id_old = $_REQUEST['business_sub_category_id'];
              $business_category_id = $data2['business_category_id'];
                $q=$d->select(" business_categories,business_sub_categories "," business_sub_categories.business_category_id = business_categories.business_category_id and    business_categories.category_status = 0  group by business_categories.business_category_id  order by business_categories.category_name asc   ");
              //  $data=mysqli_fetch_array($q);
              $business_sub_ctagory_relation_master=$d->select("business_sub_ctagory_relation_master"," business_sub_category_id = '$business_sub_category_id_old' ");
              $data_array = array('0');
              while ($business_sub_ctagory_relation_master_data=mysqli_fetch_array($business_sub_ctagory_relation_master)) {
              $data_array[] = $business_sub_ctagory_relation_master_data['whole_main_category_id'];

                if($business_sub_category_id_old == $business_sub_ctagory_relation_master_data['business_sub_category_id'])
               $data_array[] = $business_sub_ctagory_relation_master_data['whole_main_sub_cat_id'];
              }

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
               $my_counter = 1;
              while ($data=mysqli_fetch_array($q)) {
              // echo "$incounter%3 =>".($incounter%3) ."<br>";
              if( ($incounter%4) ==1 || $incounter==1){ ?>
            <?php if($incounter > 1) { echo '</div>';} ?>
            <div class="form-group row">
              <?php  } ?>
              <div class="col-sm-4" >
                <?php
                $ischecked="";
                if(in_array($data['business_category_id'], $data_array)){
                $ischecked="checked";
                } ?>
               <input type="checkbox" <?php echo $ischecked;?> class="pagePrivilege" value="<?php echo $data['business_category_id']; ?>" name="business_category_id[]"  id="<?php echo $data['business_category_id']; ?>"/>  
                <label for="<?php echo $data['business_category_id']; ?>"><?php echo $my_counter;$my_counter++;?>. <?php echo $data['category_name']; ?></label>
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
            <?php if(isset($_REQUEST['business_sub_category_id'])) { ?>
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
<script src="assets/js/jquery.min.js"></script>
<script type="text/javascript">
$(function() {
$('.chk_boxes').click(function() {
$('.pagePrivilege').prop('checked', this.checked);
});
});
</script>
<?php $end = microtime(true);

echo "Time Taken =".($end -$starttime); ?>