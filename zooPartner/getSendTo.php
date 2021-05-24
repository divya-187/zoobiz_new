<?php 
error_reporting(0);
include_once 'lib/dao.php';
include 'lib/model.php';
$d = new dao();
$m = new model();
extract(array_map("test_input",$_POST));
if(isset($send_to) && $send_to =="1") { 
	?> 
	
                    	<?php
	 $users_master_qry=$d->select("users_master, user_employment_details"," user_employment_details.user_id =users_master.user_id and   users_master.active_status=0  AND users_master.office_member=0     ","");
	 if (mysqli_num_rows($users_master_qry) > 0) {
	 	?>
	 	  <option value="0">All</option>
	 	  <?php
	 while ($users_master_data=mysqli_fetch_array($users_master_qry)) {
 ?>
    <option value="<?php echo $users_master_data['user_id'];?>"><?php echo $users_master_data['salutation'].' '.$users_master_data['user_full_name'] .' ('.$users_master_data['company_name'].')';?></option>
<?php }
} ?>

<?php

} else if(isset($send_to) && $send_to =="2") { 
	?> 
	 
                    	<?php
	 $cities_qry=$d->select("cities","city_flag=1","");
	 if (mysqli_num_rows($cities_qry) > 0) {
	 	?>
	 	  <option value="0">All</option>
	 	  <?php
	 while ($cities_data=mysqli_fetch_array($cities_qry)) {
 ?>
    <option value="<?php echo $cities_data['city_id'];?>"><?php echo $cities_data['city_name'];?></option>
<?php }
} ?>
 
<?php

} else if(isset($send_to) && $send_to =="3") { 
	?> 
	 
                    	<?php
	 $business_categories_qry=$d->select("business_categories","category_status=0","");
	 if (mysqli_num_rows($business_categories_qry) > 0) {
	 	?>
	 	  <option value="0">All</option>
	 	  <?php
	 while ($business_categories_data=mysqli_fetch_array($business_categories_qry)) {
 ?>
    <option value="<?php echo $business_categories_data['business_category_id'];?>"><?php echo $business_categories_data['category_name'];?></option>
<?php }
} ?>
 
<?php

} else if(isset($send_to) && $send_to =="4") { 
/*	?> 
	<div class="form-group row">
                    <label for="input-10" class="col-sm-4 col-form-label">Category </label>
                    <div class="col-sm-8">
                    	 

                    		<select id="business_categories_deals" onchange="getSubCategoryDeals();" class="form-control single-select" name="business_category_id" type="text"  required="">
                            <option value="">-- Select --</option>
                            <?php $qb=$d->select("business_categories"," category_status=0 ","");
                            while ($bData=mysqli_fetch_array($qb)) {?>
                              <option   value="<?php echo $bData['business_category_id']; ?>"><?php echo $bData['category_name']; ?></option>
                            <?php } ?> 
                          </select>
</div>
                </div>

    
    	 
                <span id="business_categories_sub"></span>
               
<?php

} else if(isset($business_categories)) { */ ?>

	 
                    	<?php
	$q3=$d->select("business_sub_categories,business_categories","  business_categories.business_category_id =business_sub_categories.business_category_id and business_sub_categories.sub_category_status = 0 and business_categories.category_status = 0 ","");
	 if (mysqli_num_rows($q3) > 0) {
	 	?>
	 	  <option value="0"  >All</option>
	 	  <?php
	 while ($business_sub_categories=mysqli_fetch_array($q3)) {
 ?>
    <option value="<?php echo $business_sub_categories['business_sub_category_id'];?>"><?php echo $business_sub_categories['sub_category_name'];?> - <?php echo $business_sub_categories['category_name'];?></option>
<?php }
} ?>
 
 
<?php   } else if(isset($send_to) && $send_to =="7") {   
 ?>
   
    <input type="text" name="pincode" value="" required="" class="form-control" maxlength="6" minlength="6" placeholder="PIN Code">
 
<?php   }  else {

   ?>
 <option value="0" >All</option>
 <?php 
  $q3=$d->select("business_sub_categories","business_category_id='$business_categories'","");
while ($blockRow=mysqli_fetch_array($q3)) {
 ?>
 <option value="<?php echo $blockRow['business_sub_category_id'];?>"><?php echo $blockRow['sub_category_name'];?></option>
<?php } }  ?>