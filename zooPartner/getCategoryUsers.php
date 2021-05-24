<?php 
error_reporting(0);
include_once 'lib/dao.php';
include 'lib/model.php';
$d = new dao();
$m = new model();
extract(array_map("test_input",$_POST));
if(isset($business_category_id) && $business_category_id !="") { 
	?>  <option> -- Select --</option>
                    <  <?php 
                $i=1;
                  $q=$d->select("users_master,user_employment_details,business_categories,business_sub_categories"," business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id  AND user_employment_details.business_category_id='$business_category_id'  ","ORDER BY users_master.user_id DESC");
               while ($data=mysqli_fetch_array($q)) {  ?>
                  <option value="<?php echo $data['user_id'] ; ?>"><?php echo $data['user_full_name'] ; ?>-<?php echo $data['company_name'] ; ?></option>

                    <?php } ?>

<?php } else if(isset($send_to) && $send_to =="") { ?>
	  <option> -- Select --</option>
                    <  <?php 
                $i=1;
                  $q=$d->select("users_master,user_employment_details,business_categories,business_sub_categories"," business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id     ","ORDER BY users_master.user_id DESC");
               while ($data=mysqli_fetch_array($q)) {  ?>
                  <option value="<?php echo $data['user_id'] ; ?>"><?php echo $data['user_full_name'] ; ?>-<?php echo $data['company_name'] ; ?></option>

                    <?php } ?>
                    <?php
}  ?>