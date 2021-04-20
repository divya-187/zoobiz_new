<?php
include_once 'lib.php';

 
 
if (isset($_POST) && !empty($_POST)) {

	if ($key == $keydb) {

		$response = array();
		extract(array_map("test_input", $_POST));

		if ($_POST['getPackage'] == "getPackage") {

			$response["package"] = array();

			$app_data = $d->selectRow("inapp_ios_purchase_id, package_amount,package_id,gst_slab_id,package_name,package_amount,packaage_description,package_amount,package_amount,no_of_month,time_slab","package_master", "package_status=0", "");

			if (mysqli_num_rows($app_data) > 0) {

				while ($data = mysqli_fetch_array($app_data)) {

			// find gst_amount
					$gst_amount = $data["package_amount"] * 18 / 100;

					$package = array();
					$package["package_id"] = $data["package_id"];

					if($data['gst_slab_id'] !="0"){
						$gst_slab_id = $data['gst_slab_id'];
						$gst_master=$d->selectRow("slab_percentage,slab_id","gst_master","slab_id = '$gst_slab_id'","");
						$gst_master_data=mysqli_fetch_array($gst_master);
						$slab_percentage=  str_replace(".00","",$gst_master_data['slab_percentage']) .'% GST' ;

                   //4nov 2020
						$gst_amount= (($data["package_amount"]*$gst_master_data['slab_percentage']) /100);
                   //4nov 2020
					} else {
						$slab_percentage= "" ;
                    //4nov 2020
						$gst_amount= 0 ;
					}

					




					$package["package_name"] = $data["package_name"] . ' (₹ ' . $data["package_amount"] . ' + '.$slab_percentage.') (₹ '.number_format($data["package_amount"] + $gst_amount, 2, '.', '').')';
					$package["package_description"] = $data["packaage_description"];
					$package["package_amount"] = $data["package_amount"];
					$package["package_with_amount"] = number_format($data["package_amount"] + $gst_amount, 2, '.', '');
					$package["gst_amount"] = number_format($gst_amount, 2, '.', '');
					$package["no_of_month"] = $data["no_of_month"];
					$package["time_slab"] = $data["time_slab"];
					$package["Apple_IAP_ProductID"] = $data["inapp_ios_purchase_id"];
					array_push($response["package"], $package);
				}
				$response["message"] = "Get Success.";

				if (strtolower($device) == 'android' ) {
                         $response["Is_IAP_Payment"] = false;
                }
                if (strtolower($device) == 'ios') {
                	$response["Is_IAP_Payment"] = true;
                }

                 $zoobiz_settings_master = $d->select("zoobiz_settings_master","","");
                if( mysqli_num_rows($zoobiz_settings_master) > 0){ 
                	 $zoobiz_settings_masterData = mysqli_fetch_array($zoobiz_settings_master);
                	  $response["Is_IAP_Payment"] =filter_var($zoobiz_settings_masterData['Is_IAP_Payment'], FILTER_VALIDATE_BOOLEAN);   
                	 // $response["IsSignUpBypass"] =  $zoobiz_settings_masterData['Is_IAP_Payment'];
                } else {
                	$response["Is_IAP_Payment"] = filter_var($zoobiz_settings_masterData['Is_IAP_Payment'], FILTER_VALIDATE_BOOLEAN); 
                	//$response["IsSignUpBypass"] = false;
                }
				 
				$response["status"] = "200";
				echo json_encode($response);

			} else {
				$response["message"] = "No Package Found.";
				$response["status"] = "201";
				echo json_encode($response);
			}
 
		} else if ($_POST['getSubCategoryRegister'] == "getSubCategoryRegister") {

			$response["sub_category"] = array();
$category_use_arr = array('0');
if(isset($city_id)){ 
	$sub_cat_use_qry = $d->selectRow(" count(*) as totalSubCAtUsers, bs.business_sub_category_id ","users_master u, user_employment_details um, business_sub_categories bs, 	business_categories b ", "u.user_id = um.user_id and bs.business_sub_category_id = um.business_sub_category_id and bs.business_category_id = b.business_category_id and u.active_status = 0 and u.active_status = 0 and b.category_status = 0 and bs.sub_category_status=0 and u.city_id = '$city_id' group by  um.business_sub_category_id ");
	 
	while ($sub_cat_use_data = mysqli_fetch_array($sub_cat_use_qry)) {
		 $category_use_arr[$sub_cat_use_data['business_sub_category_id']] = $sub_cat_use_data['totalSubCAtUsers'];
	}
 
}

 $zoobiz_settings_master_qry = $d->select("zoobiz_settings_master","","");
	$zoobiz_settings_master_data=mysqli_fetch_array($zoobiz_settings_master_qry);
	$max_member_per_subcategory = $zoobiz_settings_master_data['max_member_per_subcategory'];



			$app_data = $d->selectRow("business_sub_categories.business_sub_category_id,business_categories.business_category_id,business_sub_categories.sub_category_name,business_categories.category_name","business_categories,business_sub_categories", "
				business_categories.category_status = 0 and
				business_sub_categories.business_category_id=business_categories.business_category_id AND business_sub_categories.sub_category_status='0'", "ORDER BY business_sub_categories.sub_category_name ASC");

			if (mysqli_num_rows($app_data) > 0) {

					 

				while ($data = mysqli_fetch_array($app_data)) {

					$sub_category = array();
					$sub_category["business_sub_category_id"] = $data["business_sub_category_id"];
					$sub_category["business_category_id"] = $data["business_category_id"];
					$sub_category["category_name"] = html_entity_decode($data["sub_category_name"] . ' - ' . $data["category_name"]);

					if(isset($city_id) && $zoobiz_settings_master_data['enable_max_member_facility'] ==1 ){ 

						$full_data =  $category_use_arr[$data["business_sub_category_id"]];
						// $sub_category["con"] = $full_data .'>='. $max_member_per_subcategory;
						if( $full_data >= $max_member_per_subcategory){
							$sub_category["is_full"] =true;
							//$sub_category["full_data"] =$full_data;
							$sub_category["is_full_message"] ="Category Applied Is Full";
							
						} else {
							$sub_category["is_full"] =false;
							$sub_category["is_full_message"] ="";
						}
						
					} else {
						$sub_category["is_full"] =false;
						$sub_category["is_full_message"] ="";
					}
					array_push($response["sub_category"], $sub_category);
				}
				$response["message"] = "get Success.";
				$response["status"] = "200";
				echo json_encode($response);

			} else {
				$response["message"] = "No Data Found.";
				$response["status"] = "201";
				echo json_encode($response);
			}

		}

else {
	$response["message"] = "wrong tag.";
	$response["status"] = "201";
	echo json_encode($response);
}
} else {

	$response["message"] = "wrong api key.";
	$response["status"] = "201";
	echo json_encode($response);
}
}
?>