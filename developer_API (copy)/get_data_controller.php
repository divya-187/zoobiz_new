<?php
include_once 'lib.php';

/*ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);*/

if (isset($_POST) && !empty($_POST)) {

	if ($key == $keydb) {

		$response = array();
		extract(array_map("test_input", $_POST));
		
	   if ($_POST['getZooMembers'] == "getZooMembers") {

			$response["member"] = array();
 
			$meq = $d->selectRow(" users_master.user_first_name,users_master.user_last_name,users_master.user_id,business_categories.business_category_id,business_sub_categories.business_sub_category_id,users_master.user_full_name,users_master.zoobiz_id,users_master.user_profile_pic,business_categories.category_name,business_sub_categories.sub_category_name,user_employment_details.company_name,user_employment_details.designation,cities.city_name,area_master.area_name,users_master.public_mobile,users_master.user_mobile
				","users_master,user_employment_details,business_categories,business_sub_categories,business_adress_master,cities,area_master", "
				business_categories.category_status = 0 and
				area_master.area_id=business_adress_master.area_id AND cities.city_id=business_adress_master.city_id AND business_adress_master.user_id=users_master.user_id AND business_adress_master.adress_type=0 AND business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id  AND users_master.office_member=0 AND users_master.active_status=0   ", "group by users_master.user_id");


			//code optimize

                $dataArray = array();
                $counter = 0 ;
                foreach ($meq as  $value) {
                    foreach ($value as $key => $valueNew) {
                        $dataArray[$counter][$key] = $valueNew;
                    }
                    $counter++;
                }
             


			$totalUsers = count($dataArray);
			if (count($dataArray) > 0) {
				for ($l=0; $l < count($dataArray) ; $l++) {
					$data_app = $dataArray[$l];
				  
					 
					$member = array();
					$member["user_id"] = $data_app["user_id"];
					  
					$member["user_full_name"] = $data_app["user_full_name"];
					 $member["short_name"] =strtoupper(substr($data_app["user_first_name"], 0, 1).substr($data_app["user_last_name"], 0, 1) ); 
					$member["user_profile_pic"] = $base_url . "img/users/members_profile/" . $data_app['user_profile_pic'];

					if($data_app['user_profile_pic'] ==""){
                        $member["user_profile_pic"] ="";
                    } else {
                        $member["user_profile_pic"] =  $base_url . "img/users/members_profile/" . $data_app['user_profile_pic'];
                    }

				 
					$member["company_name"] = html_entity_decode($data_app["company_name"]) . '';
					 
					$member["city_name"] = html_entity_decode($data_app["city_name"]) . '';
					 
				 
				//	$member["user_mobile"] = $data_app["user_mobile"];
					 

					array_push($response["member"], $member);
				}

				$response["message"] = "Member Data.";
				$response["status"] = "200";
				echo json_encode($response);
				exit;
			} else {
				$response["message"] = "No Data Found.";
				$response["status"] = "201";
				echo json_encode($response);
				exit;
			}

		}    else {
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