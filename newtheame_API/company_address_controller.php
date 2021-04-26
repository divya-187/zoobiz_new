<?php
include_once 'lib.php';

/*ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);*/

if (isset($_POST) && !empty($_POST)) {

	if ($key == $keydb) {

		$response = array();
		extract(array_map("test_input", $_POST));

		if ($_POST['get_company_address'] == "get_company_address" && filter_var($user_id, FILTER_VALIDATE_INT) == true) {

			$qA2 = $d->selectRow("business_adress_master.adress_id,cities.city_name,states.state_name,countries.country_name,business_adress_master.pincode,business_adress_master.add_latitude,business_adress_master.add_longitude,business_adress_master.adress_type,business_adress_master.country_id,business_adress_master.state_id,business_adress_master.city_id,business_adress_master.area_id,area_master.area_name,business_adress_master.adress,business_adress_master.adress2 ","area_master,business_adress_master,cities,states,countries", "business_adress_master.user_id='$user_id'
                AND
                business_adress_master.country_id = countries.country_id
                AND
                business_adress_master.state_id = states.state_id
                AND
                business_adress_master.city_id = cities.city_id
                AND
                business_adress_master.area_id = area_master.area_id", "ORDER BY business_adress_master.adress_type ASC");

			if (mysqli_num_rows($qA2) > 0) {

				$response["company_address"] = array();

				while ($data_app = mysqli_fetch_array($qA2)) {
					$company_address = array();


					$userDQuery = $d->select("cities,states,countries,users_master", " users_master.city_id = cities.city_id and users_master.user_id='$user_id' AND cities.country_id = countries.country_id  AND cities.state_id = states.state_id  AND cities.city_id = cities.city_id ", "");
					    $userDData = mysqli_fetch_array($userDQuery);


						$response["selected_country_name"] = $userDData['country_name'] . '';
						$response["selected_country_id"] = $userDData['country_id'];
						$response["selected_state_name"] = $userDData['state_name'] . '';
						$response["selected_state_id"] = $userDData['state_id'];
						$response["selected_city_name"] = $userDData['city_name'] . '';
						$response["selected_city_id"] = $userDData['city_id'];


					$company_address["adress_id"] = $data_app["adress_id"];
					$company_address["city_name"] = "" . $data_app["city_name"];
					$company_address["state_name"] = $data_app["state_name"];
					$company_address["country_name"] = $data_app["country_name"];
					$company_address["pincode"] = $data_app["pincode"];
					$company_address["latitude"] = $data_app["add_latitude"];
					$company_address["longitude"] = $data_app["add_longitude"];
					$company_address["adress_type"] = $data_app["adress_type"];
					if($company_address["adress_type"] == 0){
						$company_address["adress_type_name"] ="Main Office";
					} else {
						$company_address["adress_type_name"] ="Sub Office";
					}
					$company_address["country_id"] = $data_app["country_id"];
					$company_address["state_id"] = $data_app["state_id"];
					$company_address["city_id"] = $data_app["city_id"];
					$company_address["area_id"] = $data_app["area_id"];
					$company_address["area_name"] = $data_app["area_name"] . " [" . $data_app["pincode"] . "]";

					if($data_app["adress2"]!=''){
						$company_address["full_address"] = html_entity_decode($data_app["adress"].', '.$data_app["adress2"]);
					} else {
						$company_address["full_address"] = html_entity_decode($data_app["adress"]);
					}
					
					$company_address["adress"] =html_entity_decode($data_app["adress"]);
					
					$company_address["adress2"] = html_entity_decode($data_app["adress2"]);
					
					array_push($response["company_address"], $company_address);

				}

				$response["message"] = "Company Address Data";
				$response["status"] = "200";
				echo json_encode($response);
			} else {

				$response["message"] = "No Company Address found";
				$response["status"] = "201";
				echo json_encode($response);
			}
		} else if ($_POST['get_countries'] == "get_countries") {

			$qA2 = $d->selectRow("country_id,country_name","countries", "flag=1", "");

			if (mysqli_num_rows($qA2) > 0) {

				$response["countries"] = array();

				while ($data_app = mysqli_fetch_array($qA2)) {

					$countries = array();
					$countries["country_id"] = $data_app["country_id"];
					$countries["country_name"] = "" . $data_app["country_name"];
					array_push($response["countries"], $countries);

				}

				$response["message"] = "Country Data";
				$response["status"] = "200";
				echo json_encode($response);
			} else {

				$response["message"] = "No Country Found";
				$response["status"] = "201";
				echo json_encode($response);
			}
		} else if ($_POST['get_states'] == "get_states" && filter_var($country_id, FILTER_VALIDATE_INT) == true) {

			$qA2 = $d->selectRow("state_id,state_name","states", "country_id='$country_id' AND state_flag=1", "");

			if (mysqli_num_rows($qA2) > 0) {

				$response["states"] = array();

				while ($data_app = mysqli_fetch_array($qA2)) {

					$states = array();
					$states["state_id"] = $data_app["state_id"];
					$states["state_name"] = "" . $data_app["state_name"];
					array_push($response["states"], $states);

				}

				$response["message"] = "State Data";
				$response["status"] = "200";
				echo json_encode($response);
			} else {

				$response["message"] = "No State Found";
				$response["status"] = "201";
				echo json_encode($response);
			}
		} else if ($_POST['get_cities'] == "get_cities" && filter_var($country_id, FILTER_VALIDATE_INT) == true
			&& filter_var($state_id, FILTER_VALIDATE_INT) == true) {

			$qA2 = $d->selectRow("city_id,city_name","cities", "country_id='$country_id' AND state_id='$state_id' AND city_flag=1", "");

			//CLASSIFIED SETTINGS START
			 $zoobiz_settings_master = $d->select("zoobiz_settings_master","","");
             $zoobiz_settings_masterData = mysqli_fetch_array($zoobiz_settings_master);

             if($zoobiz_settings_masterData['classifieds_sel_multiple_cities'] == "1"){
             	$response["classifieds_sel_multiple_cities"] =true;
             } else {
             	$response["classifieds_sel_multiple_cities"] =false;
             }

             if($zoobiz_settings_masterData['classifieds_sel_multiple_categories'] == "1"){
             	$response["classifieds_sel_multiple_categories"] =true;
             } else {
             	$response["classifieds_sel_multiple_categories"] =false;
             }
             
             $response["classified_max_image_select"] = (int)$zoobiz_settings_masterData["classified_max_image_select"];
			 $response["classified_max_audio_duration"] =(int) $zoobiz_settings_masterData["classified_max_audio_duration"];
			 $response["classified_max_document_select"] =(int) $zoobiz_settings_masterData["classified_max_document_select"];
			//CLASSIFIED SETTINGS END	 

				 

			if (mysqli_num_rows($qA2) > 0) {

				$response["cities"] = array();

				while ($data_app2 = mysqli_fetch_array($qA2)) {

					$cities = array();
					$cities["city_id"] = $data_app2["city_id"];
					$cities["city_name"] = $data_app2["city_name"];
					array_push($response["cities"], $cities);

				}



				$response["message"] = "City Data";
				$response["status"] = "200";
				echo json_encode($response);
			} else {

				$response["message"] = "No Cities";
				$response["status"] = "201";
				echo json_encode($response);
			}
		}  else if ($_POST['get_user_cities'] == "get_user_cities" && filter_var($country_id, FILTER_VALIDATE_INT) == true
			&& filter_var($state_id, FILTER_VALIDATE_INT) == true && filter_var($user_id, FILTER_VALIDATE_INT) == true ) {

			$qA2 = $d->selectRow("cities.city_id,cities.city_name","cities,users_master", "users_master.city_id = cities.city_id and  users_master.user_id='$user_id' and cities.country_id='$country_id' AND cities.state_id='$state_id' AND cities.city_flag=1", " group by cities.city_id");

			if (mysqli_num_rows($qA2) > 0) {

				$response["cities"] = array();

				while ($data_app2 = mysqli_fetch_array($qA2)) {

					$cities = array();
					$cities["city_id"] = $data_app2["city_id"];
					$cities["city_name"] = $data_app2["city_name"];
					array_push($response["cities"], $cities);

				}

				$response["message"] = "City Data";
				$response["status"] = "200";
				echo json_encode($response);
			} else {

				$response["message"] = "No Cities";
				$response["status"] = "201";
				echo json_encode($response);
			}
		} else if ($_POST['get_area'] == "get_area" && filter_var($country_id, FILTER_VALIDATE_INT) == true
			&& filter_var($state_id, FILTER_VALIDATE_INT) == true
			&& filter_var($city_id, FILTER_VALIDATE_INT) == true) {
			$qA2 = $d->selectRow("area_id,area_name,pincode","area_master", "country_id='$country_id' AND state_id='$state_id' AND
            city_id='$city_id'", "");
			if (mysqli_num_rows($qA2) > 0) {
				$response["area"] = array();
				while ($data_app2 = mysqli_fetch_array($qA2)) {
					$area = array();
					$area["area_id"] = $data_app2["area_id"];
					$area["area_name"] = $data_app2["area_name"];
					$area["pincode"] = $data_app2["pincode"];
					array_push($response["area"], $area);
				}
				$response["message"] = "Area Data";
				$response["status"] = "200";
				echo json_encode($response);
			} else {
				$response["message"] = "No Area Found";
				$response["status"] = "201";
				echo json_encode($response);
			}
		} else if ($_POST['add_edit_company_address'] == "add_edit_company_address" && filter_var($user_id, FILTER_VALIDATE_INT) == true) {

			$m->set_data('user_id', $user_id);
			$m->set_data('adress', $adress);
			$m->set_data('area_id', $area_id);
			$m->set_data('city_id', $city_id);
			$m->set_data('state_id', $state_id);
			$m->set_data('country_id', $country_id);
			$m->set_data('pincode', $pincode);
			$m->set_data('latitude', $latitude);
			$m->set_data('longitude', $longitude);
			$m->set_data('adress_type', $adress_type);

			$a = array(
				'user_id' => $m->get_data('user_id'),
				'adress' => $m->get_data('adress'),
				'area_id' => $m->get_data('area_id'),
				'city_id' => $m->get_data('city_id'),
				'state_id' => $m->get_data('state_id'),
				'country_id' => $m->get_data('country_id'),
				'pincode' => $m->get_data('pincode'),
				'add_latitude' => $m->get_data('latitude'),
				'add_longitude' => $m->get_data('longitude'),
				'adress_type' => $m->get_data('adress_type'),
			);

			if ($adress_id == 0) {
				if ($adress_type == 0) {
					$type="primary";
					$a11 = array(
						'adress_type' => 1,
					);
					$d->update("business_adress_master", $a11, "user_id='$user_id'");
					$d->insert_myactivity($user_id,"0","", "Company $type address updated","activity.png");

				} else if ($adress_type == 1) {
					$type="other";
					$totalAddress = $d->count_data_direct("adress_id", "business_adress_master", "user_id='$user_id' AND adress_type=0 ");
					if ($totalAddress < 1) {
						$response["message"] = "Primary Address Needed";
						$response["status"] = "201";
						echo json_encode($response);
						exit();
					}

				}

				$d->insert("business_adress_master", $a, "");
				$response["message"] = "Added Successfully";
				$d->insert_myactivity($user_id,"0","","Company $type address added.","activity.png");
			} else {
				if ($adress_type == 0) {
					$type="primary";

					$a11 = array(
						'adress_type' => 1,
					);
					$d->update("business_adress_master", $a11, "user_id='$user_id' AND adress_id!='$adress_id'");
					$d->insert_myactivity($user_id,"0","", "Company $type address updated","activity.png");
				} else if ($adress_type == 1) {
					$type="other";
					$totalAddress = $d->count_data_direct("adress_id", "business_adress_master", "user_id='$user_id' AND adress_type=0 AND adress_id!='$adress_id'");
					if ($totalAddress < 1) {
						$response["message"] = "Primary Address Needed";
						$response["status"] = "201";
						echo json_encode($response);
						exit();
					}

				}

				$d->update("business_adress_master", $a, "adress_id='$adress_id'");
				$d->insert_myactivity($user_id,"0","","Company $type address added.","activity.png");
				$response["message"] = "Updated Successfully";
			}

			if ($d == true) {
 
				echo json_encode($response);

			} else {
				$response["message"] = "Something Wrong";
				$response["status"] = "201";
				echo json_encode($response);
			}

		} else if ($_POST['add_company_address'] == "add_company_address" && filter_var($user_id, FILTER_VALIDATE_INT) == true) {

			$m->set_data('user_id', $user_id);
			$m->set_data('adress', $adress);
			if(isset($adress2)){
             
			$m->set_data('adress2', $adress2);
			} else {

			$m->set_data('adress2', '');
			}
			$m->set_data('area_id', $area_id);
			$m->set_data('city_id', $city_id);
			$m->set_data('state_id', $state_id);
			$m->set_data('country_id', $country_id);
			$m->set_data('pincode', $pincode);
			$m->set_data('latitude', $latitude);
			$m->set_data('longitude', $longitude);
			$m->set_data('adress_type', $adress_type);

			$a = array(
				'user_id' => $m->get_data('user_id'),
				'adress' => $m->get_data('adress'),
				'adress2' => $m->get_data('adress2'),
				'area_id' => $m->get_data('area_id'),
				'city_id' => $m->get_data('city_id'),
				'state_id' => $m->get_data('state_id'),
				'country_id' => $m->get_data('country_id'),
				'pincode' => $m->get_data('pincode'),
				'add_latitude' => $m->get_data('latitude'),
				'add_longitude' => $m->get_data('longitude'),
				'adress_type' => $m->get_data('adress_type'),
			);

			if ($adress_id == 0) {
				if ($adress_type == 0) {
					$type="primary";
					$a11 = array(
						'adress_type' => 1,
					);
					$d->update("business_adress_master", $a11, "user_id='$user_id'");
					$d->insert_myactivity($user_id,"0","","Company $type address updated.","activity.png");
				} else if ($adress_type == 1) {
					$type="other";
					$totalAddress = $d->count_data_direct("adress_id", "business_adress_master", "user_id='$user_id' AND adress_type=0 ");
					if ($totalAddress < 1) {
						$response["message"] = "Primary Address Needed";
						$response["status"] = "201";
						echo json_encode($response);
						exit();
					}

				}

				$d->insert("business_adress_master", $a, "");
				$response["message"] = "Added Successfully";
				$d->insert_myactivity($user_id,"0","","Company $type address added.","activity.png");
			} else {
				if ($adress_type == 0) {
					$type="primary";
					$a11 = array(
						'adress_type' => 1,
					);
					$d->update("business_adress_master", $a11, "user_id='$user_id' AND adress_id!='$adress_id'");
					$d->insert_myactivity($user_id,"0","","Company $type address updated.","activity.png");
				} else if ($adress_type == 1) {
					$type="other";
					$totalAddress = $d->count_data_direct("adress_id", "business_adress_master", "user_id='$user_id' AND adress_type=0 AND adress_id!='$adress_id'");
					if ($totalAddress < 1) {
						$response["message"] = "Primary Address Needed";
						$response["status"] = "201";
						echo json_encode($response);
						exit();
					}

				}

				$d->update("business_adress_master", $a, "adress_id='$adress_id'");
				$d->insert_myactivity($user_id,"0","","Company $type address added.","activity.png");
				 
				$response["message"] = "Updated Successfully";
			}

			if ($d == true) {

				$response["status"] = "200";
				echo json_encode($response);

			} else {
				$response["message"] = "Something Wrong";
				$response["status"] = "201";
				echo json_encode($response);
			}

		} else if ($_POST['delete_address'] == "delete_address" && filter_var($user_id, FILTER_VALIDATE_INT) == true && filter_var($adress_id, FILTER_VALIDATE_INT) == true) {
			$totalAddress = $d->count_data_direct("adress_id", "business_adress_master", "user_id='$user_id' AND adress_type=0 AND adress_id!='$adress_id'");
			if ($totalAddress < 1) {
				$response["message"] = "Primary Address Needed";
				$response["status"] = "201";
				echo json_encode($response);
				exit();
			}

			$q = $d->delete("business_adress_master", "adress_id='$adress_id' AND user_id='$user_id'");

			if ($q == true) {
				$d->insert_myactivity($user_id,"0","", "company address removed","activity.png");
				$response["message"] = "Address Deleted";
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
