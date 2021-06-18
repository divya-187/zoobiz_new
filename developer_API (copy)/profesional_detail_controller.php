<?php
include_once 'lib.php';

/*ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);*/

if (isset($_POST) && !empty($_POST)) {

	if ($key == $keydb) {

		$response = array();
		extract(array_map("test_input", $_POST));

		if ($_POST['get_professional_info'] == "get_professional_info" && filter_var($user_id, FILTER_VALIDATE_INT) == true) {


			$qA = $d->selectRow("user_employment_details.gst_number,user_employment_details.employment_id,user_employment_details.user_id,users_master.salutation,users_master.user_full_name,users_master.user_mobile,users_master.user_mobile,user_employment_details.business_category_id,user_employment_details.business_sub_category_id,users_master.user_email,user_employment_details.employment_type,business_categories.category_name,business_sub_categories.sub_category_name,user_employment_details.business_categories_other,user_employment_details.professional_other,user_employment_details.business_description,user_employment_details.company_name,user_employment_details.designation,user_employment_details.company_website,user_employment_details.search_keyword,user_employment_details.company_contact_number,user_employment_details.company_email,user_employment_details.products_servicess,user_employment_details.company_logo,user_employment_details.company_broucher,user_employment_details.company_broucher,user_employment_details.company_profile,user_employment_details.company_landline_number",

				"users_master,user_employment_details,business_categories,business_sub_categories",

				 "user_employment_details.user_id=users_master.user_id  AND user_employment_details.user_id='$user_id' AND user_employment_details.business_category_id = business_categories.business_category_id  AND user_employment_details.business_sub_category_id = business_sub_categories.business_sub_category_id", "");


			if (mysqli_num_rows($qA) > 0) {


				$data = mysqli_fetch_array($qA);

				$qAdPrimary = $d->select("business_adress_master,cities,states,countries", "business_adress_master.user_id='$user_id' AND
                business_adress_master.country_id = countries.country_id  AND
                business_adress_master.state_id = states.state_id AND
                business_adress_master.city_id = cities.city_id AND business_adress_master.adress_type=0", "");
				$addData = mysqli_fetch_array($qAdPrimary);

				if($addData['adress2']!=''){
					$busAddress = $addData['adress'] . ', '.$addData['adress2'] . ', ' . $addData['city_name'] . ', ' . $addData['state_name'] . ', ' . $addData['country_name'];
				} else {
					$busAddress = $addData['adress']  . ', ' . $addData['city_name'] . ', ' . $addData['state_name'] . ', ' . $addData['country_name'];
				}
				
				$response["employment_id"] = $data['employment_id'];
				$response["user_id"] = $data['user_id'];
				$response["user_full_name"] = $data["salutation"] . ' ' . $data['user_full_name'];
				if ($data['user_mobile'] != 0) {
					$response["user_phone"] = $data['user_mobile'];
				} else {
					$response["user_phone"] = '';
				}

if($data['gst_number']==""){
	$response['gst_number'] ="";
} else {
	$response["gst_number"] = $data['gst_number'];
}

				$response["business_category_id"] = $data['business_category_id'];
				$response["business_sub_category_id"] = $data['business_sub_category_id'];
				$response["user_email"] = $data['user_email'];
				$response["employment_type"] = html_entity_decode($data['employment_type']);
				$response["category_name"] = html_entity_decode($data['category_name']);
				$response["sub_category_name"] = html_entity_decode($data['sub_category_name']);
				$response["business_categories_other"] = html_entity_decode($data['business_categories_other']);
				$response["professional_other"] = html_entity_decode($data['professional_other']);
				$response["employment_description"] = html_entity_decode($data['business_description']);
				$response["company_name"] = html_entity_decode($data['company_name']);
				$response["designation"] = html_entity_decode($data['designation']);
				$response["company_website"] = html_entity_decode($data['company_website']);
				$response["search_keyword"] = html_entity_decode($data['search_keyword']);
				$response["address"] = html_entity_decode($busAddress);
				if ($data['company_contact_number'] != 0) {
					$response["company_contact_number"] = $data['company_contact_number'];
				} else {
					$response["company_contact_number"] = '';
				}


				 $response["company_landline_number"] = $data['company_landline_number'];
				 

				
				$response["company_email"] = $data['company_email'];

				$response["products_servicess"] = html_entity_decode($data['products_servicess']);
				if($data['company_logo'] !=""){
					$response["company_logo"] = $base_url . "img/users/company_logo/" . $data['company_logo'];
				} else
				$response["company_logo"] ="";
				
				$response["company_logo_name"] = $data['company_logo'];

				if ($data['company_broucher'] != '') {
					$response["company_broucher"] = $base_url . "img/users/company_broucher/" . $data['company_broucher'];
				} else {
					$response["company_broucher"] = "";
				}
				$response["company_broucher_name"] = $data['company_broucher'];

				if ($data['company_profile'] != '') {
					$response["company_profile"] = $base_url . "img/users/comapany_profile/" . $data['company_profile'];
				} else {
					$response["company_profile"] = "";
				}
				$response["compny_profile_name"] = $data['company_profile'];

				$qA2 = $d->selectRow("business_adress_master.adress_id,cities.city_name,states.state_name,countries.country_name,business_adress_master.pincode,business_adress_master.add_latitude,business_adress_master.add_longitude,business_adress_master.adress_type","business_adress_master,cities,states,countries", "business_adress_master.user_id='$user_id' AND
                business_adress_master.country_id = countries.country_id  AND
                business_adress_master.state_id = states.state_id AND
                business_adress_master.city_id = cities.city_id", "");

				if (mysqli_num_rows($qA2) > 0) {

					$response["company_address"] = array();

					while ($data_app = mysqli_fetch_array($qA2)) {

						$company_address = array();
						$company_address["adress_id"] = $data_app["adress_id"];
						$company_address["city_name"] = "" . $data_app["city_name"];
						$company_address["state_name"] = $data_app["state_name"];
						$company_address["country_name"] = $data_app["country_name"];
						$company_address["pincode"] = $data_app["pincode"];
						$company_address["latitude"] = $data_app["add_latitude"];
						$company_address["longitude"] = $data_app["add_longitude"];
						$company_address["adress_type"] = $data_app["adress_type"];

						array_push($response["company_address"], $company_address);

					}

				}
				$response["message"] = "Professional Info";
				$response["status"] = "200";
				echo json_encode($response);
			} else {

				$response["message"] = "No Professional Info found";
				$response["status"] = "201";
				echo json_encode($response);
			}
		} else if ($_POST['add_professional_info'] == "add_professional_info" && filter_var($user_id, FILTER_VALIDATE_INT) == true) {

			$qOld = $d->selectRow("employment_id,company_logo,company_profile,company_broucher","user_employment_details", "employment_id='$employment_id'", "");

			$oldData = mysqli_fetch_array($qOld);
 
			$searchKeyordArray = explode(",", $search_keyword);
			$search_keyword = implode(", ", $searchKeyordArray);
			
			$m->set_data('gst_number', $gst_number);
			$m->set_data('user_id', $user_id);
			$m->set_data('company_email', $company_email);
			$m->set_data('business_category_id', $business_category_id);
			$m->set_data('business_sub_category_id', $business_sub_category_id);
			$m->set_data('business_description', $business_description);
			$m->set_data('company_name', $company_name);
			$m->set_data('designation', $designation);
			$m->set_data('company_contact_number', $company_contact_number);
			$m->set_data('company_website', $company_website);
			$m->set_data('search_keyword', $search_keyword);
			$m->set_data('products_servicess', $products_servicess);
			$m->set_data('company_landline_number', $company_landline_number);

			$file = $_FILES['company_logo']['tmp_name'];
			if ( isset($_FILES['company_logo'])) {

				$temp = explode(".", $_FILES["company_logo"]["name"]);
				$company_logo = $user_id . '_logo_' . round(microtime(true)) . '.' . end($temp);
				move_uploaded_file($_FILES["company_logo"]["tmp_name"], "../img/users/company_logo/" . $company_logo);

				$m->set_data('company_logo', $company_logo);

			} else {

				$m->set_data('company_logo', $oldData['company_logo']);

			}

			$file1 = $_FILES['company_profile']['tmp_name'];
			if ( isset($_FILES['company_profile']) ) {

				$temp = explode(".", $_FILES["company_profile"]["name"]);
				$company_profile = $user_id . '_profile_' . round(microtime(true)) . '.' . end($temp);
				move_uploaded_file($_FILES["company_profile"]["tmp_name"], "../img/users/comapany_profile/" . $company_profile);

				$m->set_data('company_profile', $company_profile);

			} else {

				$m->set_data('company_profile', $oldData['company_profile']);

			}

			$file2 = $_FILES['company_broucher']['tmp_name'];
			if ( isset($_FILES['company_broucher']) ) {

				$temp = explode(".", $_FILES["company_broucher"]["name"]);
				$company_broucher = $user_id . '_broucher_' . round(microtime(true)) . '.' . end($temp);
				move_uploaded_file($_FILES["company_broucher"]["tmp_name"], "../img/users/company_broucher/" . $company_broucher);

				$m->set_data('company_broucher', $company_broucher);

			} else {

				$m->set_data('company_broucher', $oldData['company_broucher']);

			}

			$a = array(
				'user_id' => $m->get_data('user_id'),
				'gst_number' => $m->get_data('gst_number'),
				
				// 'user_full_name' => $m->get_data('user_full_name'),
				// 'user_phone' => $m->get_data('user_phone'),
				'company_email' => $m->get_data('company_email'),
				'business_category_id' => $m->get_data('business_category_id'),
				'business_sub_category_id' => $m->get_data('business_sub_category_id'),
				'business_description' => $m->get_data('business_description'),
				'company_name' => $m->get_data('company_name'),
				'designation' => $m->get_data('designation'),
				'company_contact_number' => $m->get_data('company_contact_number'),
				'company_website' => $m->get_data('company_website'),
				'search_keyword' => $m->get_data('search_keyword'),
				'products_servicess' => $m->get_data('products_servicess'),
				'company_logo' => $m->get_data('company_logo'),
				'company_profile' => $m->get_data('company_profile'),
				'company_broucher' => $m->get_data('company_broucher'),
				'company_landline_number'=> $m->get_data('company_landline_number'),
			);

		 

			if ($employment_id == 0) {
				$d->insert("user_employment_details", $a, "");
				$d->insert_myactivity($user_id,"0","", "Professional Detail Added","activity.png");
				$response["message"] = "Added Successfully";
			} else {
				$response["message"] = "Updated Successfully";
				$d->insert_myactivity($user_id,"0","", "Professional Detail Updated","activity.png");
				$d->update("user_employment_details", $a, "employment_id='$employment_id'");

			}

			if ($d == true) {
				$response["status"] = "200";
				echo json_encode($response);

			} else {
				$response["message"] = "Something Wrong";
				$response["status"] = "201";
				echo json_encode($response);
			}

		} else {

			$response["message"] = "Wrong tag";
			$response["status"] = "201";
			echo json_encode($response);
		}
	} else {
		$response["message"] = "wrong api key.";
		$response["status"] = "201";
		echo json_encode($response);
	}
}
