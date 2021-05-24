<?php 
error_reporting(0);
include_once '../zooAdmin/lib/dao.php';
include '../zooAdmin/lib/model.php';
$d = new dao();
$m = new model();
extract(array_map("test_input" , $_POST));
if (isset($refer_friend_name) && strlen($refer_friend_name) > 2) { ?>
	 
	
	<?php
	$meq = $d->selectRow("users_master.user_id,business_categories.business_category_id,business_sub_categories.business_sub_category_id,users_master.user_full_name,users_master.zoobiz_id,users_master.user_profile_pic,business_categories.category_name,business_sub_categories.sub_category_name,user_employment_details.company_name,user_employment_details.designation,cities.city_name,area_master.area_name,users_master.public_mobile,users_master.user_mobile
		","users_master,user_employment_details,business_categories,business_sub_categories,business_adress_master,cities,area_master", " (  users_master.user_full_name like '%$refer_friend_name%' OR users_master.user_first_name like '%$refer_friend_name%' OR users_master.user_last_name like '%$refer_friend_name%' )  and users_master.user_mobile !='$userMobile' and 
		business_categories.category_status = 0 and
		area_master.area_id=business_adress_master.area_id AND cities.city_id=business_adress_master.city_id AND business_adress_master.user_id=users_master.user_id AND business_adress_master.adress_type=0 AND business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id  AND users_master.office_member=0 AND users_master.active_status=0  order by  users_master.user_first_name asc    ", "");
	if (mysqli_num_rows($meq) > 0) {
		while ($blockRow=mysqli_fetch_array($meq)) {
			?>
			<option value="<?php echo $blockRow['user_id'];?>"><?php echo $blockRow['user_full_name'];?>(<?php echo $blockRow['city_name'];?>)</option>

		<?php } 
	}

	else {
		?>
		<option value="">--Select--</option>

		<?php
	}

} else {
	?>
	<option value="">--Select--</option>

	<?php
}  ?>