<?php
include_once 'lib.php';

/*ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);*/

if (isset($_POST) && !empty($_POST)) {

	if ($key == $keydb) {

		$response = array();
		extract(array_map("test_input", $_POST));

		if ($_POST['getGeoMembers'] == "getGeoMembers" && filter_var($user_id, FILTER_VALIDATE_INT) == true) {

			if ($city_name != "") {
				// find city id
				$qc = $d->selectRow("city_id,city_name", "cities", "city_name LIKE '%$city_name%'");
				$cityData = mysqli_fetch_array($qc);
				$city_id = $cityData['city_id'];
				$city_name = $cityData['city_name'];

				

				$meq = $d->selectRow("users_master.user_id,user_employment_details.business_category_id,user_employment_details.business_sub_category_id,users_master.user_full_name,business_adress_master.add_latitude,business_adress_master.add_longitude,business_adress_master.adress,users_master.zoobiz_id,users_master.user_profile_pic,business_categories.menu_icon,business_categories.category_name,business_sub_categories.sub_category_name,user_employment_details.company_name,users_master.public_mobile,users_master.user_mobile,users_master.user_email",

					"users_master,user_employment_details,business_categories,business_sub_categories,business_adress_master", 

					"
					business_categories.category_status = 0 and  
					business_adress_master.user_id=users_master.user_id AND business_adress_master.adress_type=0  AND business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id AND business_adress_master.city_id='$city_id' and users_master.is_developer_account=0  AND business_adress_master.adress_type=0 AND users_master.office_member=0 AND users_master.active_status=0   ", "");
			} else {
				$meq = $d->selectRow("users_master.user_id,user_employment_details.business_category_id,user_employment_details.business_sub_category_id,users_master.user_full_name,business_adress_master.add_latitude,business_adress_master.add_longitude,business_adress_master.adress,users_master.zoobiz_id,users_master.user_profile_pic,business_categories.menu_icon,business_categories.category_name,business_sub_categories.sub_category_name,user_employment_details.company_name,users_master.public_mobile,users_master.user_mobile,users_master.user_email","users_master,user_employment_details,business_categories,business_sub_categories,business_adress_master", "
					business_categories.category_status = 0 and  
					business_adress_master.user_id=users_master.user_id AND business_adress_master.adress_type=0  AND business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id and users_master.is_developer_account=0   AND users_master.office_member=0 AND users_master.active_status=0   ", "");
			}

			if (mysqli_num_rows($meq) > 0) {

				$response["NearByMember"] = array();

				while ($data_app = mysqli_fetch_array($meq)) {

					if (!preg_match('/^(\-?\d+(\.\d+)?),\s*(\-?\d+(\.\d+)?)$/', $data_app['add_latitude'])) {

						$NearByMember = array();
						$NearByMember["user_id"] = $data_app["user_id"];
						$NearByMember["city_name"] = $cityData["city_name"] . '';
						$NearByMember["business_category_id"] = $data_app["business_category_id"];
						$NearByMember["business_sub_category_id"] = $data_app["business_sub_category_id"];
						$NearByMember["user_full_name"] = $data_app["user_full_name"];
						$NearByMember["add_latitude"] = $data_app["add_latitude"];
						$NearByMember["add_longitude"] = $data_app["add_longitude"];
						$NearByMember["adress"] = $data_app["adress"];
						$NearByMember["zoobiz_id"] = $data_app['zoobiz_id'];
						$NearByMember["user_profile_pic"] = $base_url . "img/users/members_profile/" . $data_app['user_profile_pic'];

						 if($data_app['user_profile_pic'] ==""){
                        $NearByMember["user_profile_pic"] ="";
                    } else {
                        $NearByMember["user_profile_pic"] =$base_url . "img/users/members_profile/" . $data_app['user_profile_pic'];


                    }



						//23oct
						if($data_app['menu_icon'] !="" && 0){
							$NearByMember["menu_icon"] = $base_url . "img/category/icon/" . $data_app['menu_icon'];
						} else {
							$NearByMember["menu_icon"] = "";
						}
						//23oct

						
						$NearByMember["bussiness_category_name"] = html_entity_decode($data_app["category_name"]);
						$NearByMember["sub_category_name"] = html_entity_decode($data_app["sub_category_name"]) . '';
						$NearByMember["company_name"] = html_entity_decode($data_app["company_name"]) . '';
						if ($data_app["public_mobile"] == 0) {
							$NearByMember["user_mobile"] = "" . substr($data_app['user_mobile'], 0, 3) . '****' . substr($data_app['user_mobile'], -3);
						} else {
							$NearByMember["user_mobile"] = $data_app["user_mobile"];
						}
						// $NearByMember["user_mobile"]=html_entity_decode($data_app["user_mobile"]).'';
						$NearByMember["user_email"] = html_entity_decode($data_app["user_email"]) . '';

						/**************************** Distance Calculation ******************************/
						$service_provider_latitude = $data_app['add_latitude'];
						$service_provider_logitude = $data_app['add_longitude'];

						$radiusInMeeter = $d->haversineGreatCircleDistance($user_latitude, $user_longitude, $service_provider_latitude, $service_provider_logitude);

						$totalKm = number_format($radiusInMeeter / 1000, 2, '.', '');

						// $distancedetails = file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=$user_latitude,$user_longitude&destinations=$service_provider_latitude,$service_provider_logitude&key=AIzaSyAUPcYOnCeZLyHFqI-ssbvwg-f12q8B85A");
						// $test = json_decode($distancedetails);
						// $destination = explode(',', $test->destination_addresses[0]);
						// $local_service_provider["distance"]=$destination[1].','.$destination[2].' - '.number_format($test->rows[0]->elements[0]->distance->value/1000,2).' km';
						// $totalKm= number_format($test->rows[0]->elements[0]->distance->value/1000,2).' km';
						$NearByMember["distance_in_km"] = $totalKm . ' KM';
						/**************************** Distance Calculation ******************************/

						array_push($response["NearByMember"], $NearByMember);
					}
				}

				$response["message"] = "Get Member Found";
				$response["status"] = "200";
				echo json_encode($response);
			} else {
				$response["message"] = "No Near By Member Found.";
				$response["status"] = "201";
				echo json_encode($response);
			}

		} else if ($_POST['getGeoMembersNew'] == "getGeoMembersNew" && filter_var($user_id, FILTER_VALIDATE_INT) == true) {
			if(isset($user_id)){
				$d->insert__feature_clicked_log('1',$user_id);
			}

$main_user_id = $user_id;
			if ($city_id != "") {
				// find city id

				

				$meq = $d->selectRow("business_adress_master.add_latitude,users_master.user_id,user_employment_details.business_category_id,user_employment_details.business_sub_category_id,users_master.user_full_name,business_adress_master.add_latitude,business_adress_master.add_longitude,users_master.user_id,business_adress_master.adress,users_master.zoobiz_id,users_master.user_profile_pic,business_categories.category_name,business_categories.menu_icon,business_sub_categories.sub_category_name,user_employment_details.company_name,users_master.public_mobile,users_master.user_mobile,users_master.user_email, cities.city_name","users_master,user_employment_details,business_categories,business_sub_categories,business_adress_master, cities", " cities.city_id = business_adress_master.city_id and 
					business_categories.category_status = 0 and  
					business_adress_master.user_id=users_master.user_id AND business_adress_master.adress_type=0  AND business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id AND /*business_adress_master.city_id='$city_id' and*/ users_master.is_developer_account=0 and (business_adress_master.add_latitude!='' and business_adress_master.add_longitude !='')   AND users_master.office_member=0 AND users_master.active_status=0     ", "");
			} else {
				$meq = $d->selectRow("business_adress_master.add_latitude,users_master.user_id,user_employment_details.business_category_id,user_employment_details.business_sub_category_id,users_master.user_full_name,business_adress_master.add_latitude,business_adress_master.add_longitude,users_master.user_id,business_adress_master.adress,users_master.zoobiz_id,users_master.user_profile_pic,business_categories.category_name,business_categories.menu_icon,business_sub_categories.sub_category_name,user_employment_details.company_name,users_master.public_mobile,users_master.user_mobile,users_master.user_email, cities.city_name","users_master,user_employment_details,business_categories,business_sub_categories,business_adress_master, cities", "cities.city_id = business_adress_master.city_id and  
					business_categories.category_status = 0 and  
					business_adress_master.user_id=users_master.user_id AND business_adress_master.adress_type=0  AND business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id  and users_master.is_developer_account=0  and (business_adress_master.add_latitude!='' and business_adress_master.add_longitude !='')   AND users_master.office_member=0 AND users_master.active_status=0   ", "");
			}

			if (mysqli_num_rows($meq) > 0) {
				$dataArray = array();
				$counter = 0 ;
				foreach ($meq as  $value) {
					foreach ($value as $key => $valueNew) {
						$dataArray[$counter][$key] = $valueNew;
					}
					$counter++;
				}


				$user_id_array = array('0');
				for ($l=0; $l < count($dataArray) ; $l++) {
					$user_id_array[] = $dataArray[$l]['user_id'];
				}
				$user_id_array = implode(",", $user_id_array);


				$address = $d->selectRow("business_adress_master.user_id,business_adress_master.adress,area_master.area_name,cities.city_name,business_adress_master.pincode,states.state_name,countries.country_name","business_adress_master,area_master,cities,states,countries", " business_adress_master.country_id =countries.country_id AND business_adress_master.state_id =states.state_id AND business_adress_master.city_id =cities.city_id AND business_adress_master.area_id =area_master.area_id AND 
					business_adress_master.user_id in ($user_id_array) AND business_adress_master.adress_type=0   ", "");
				$dataArray2 = array();
				$counter2 = 0 ;
				foreach ($address as  $value) {
					foreach ($value as $key => $valueNew) {
						$dataArray2[$counter2][$key] = $valueNew;
					}
					$counter2++;
				}
				$user_data_array = array();
				for ($l=0; $l < count($dataArray2) ; $l++) {
					$user_data_array[$dataArray2[$l]['user_id']] = $dataArray2[$l];
				}


//follow end
$qche_qry = $d->selectRow("follow_id,follow_to","follow_master", "follow_by='$main_user_id'    ");
 $FArray = array();
                $Fcounter = 0 ;
                foreach ($qche_qry as  $value) {
                    foreach ($value as $key => $valueNew) {
                        $FArray[$Fcounter][$key] = $valueNew;
                    }
                    $Fcounter++;
                }
 $fol_array = array();
                for ($l=0; $l < count($FArray) ; $l++) {
                    $fol_array[$FArray[$l]['follow_to']] = $FArray[$l];
                }
//follow end

$blocked_users = array('-2'); 
$getBLockUserQry = $d->selectRow("user_id, block_by","user_block_master", " block_by='$user_id' or user_id='$user_id'  ", "");
while($getBLockUserData=mysqli_fetch_array($getBLockUserQry)) {
	 	 if($user_id != $getBLockUserData['user_id']){
	 		$blocked_users[] = $getBLockUserData['user_id'];
	 	}
       if($user_id != $getBLockUserData['block_by']){
	 		$blocked_users[] = $getBLockUserData['block_by'];
	 	}
 }

				$response["NearByMember"] = array();
				for ($l=0; $l < count($dataArray) ; $l++) {
					$data_app =$dataArray[$l];


					if (!preg_match('/^(\-?\d+(\.\d+)?),\s*(\-?\d+(\.\d+)?)$/', $data_app['add_latitude'])) {

						$NearByMember = array();

						//follow start
						$qche = $fol_array[$data_app["user_id"]];//  
						if (count($qche) > 0) {
							$follow_status = true;
						} else {
							$follow_status = false;
						}
                        $NearByMember["is_follow"] = $follow_status;
                        //follow end

                        if(in_array($data_app["user_id"],$blocked_users)){
						$NearByMember["is_blocked"] =true;
						} else {
							$NearByMember["is_blocked"] =false;
						}

						$NearByMember["user_id"] = $data_app["user_id"];
						//$NearByMember["city_name"] = $cityData["city_name"] . '';
						$NearByMember["city_name"] = $data_app["city_name"] . '';
						$NearByMember["business_category_id"] = $data_app["business_category_id"];
						$NearByMember["business_sub_category_id"] = $data_app["business_sub_category_id"];
						$NearByMember["user_full_name"] = $data_app["user_full_name"];
						$NearByMember["add_latitude"] = $data_app["add_latitude"];
						$NearByMember["add_longitude"] = $data_app["add_longitude"];

						//27oct
						$data_user_id = $data_app["user_id"];
						/*$address = $d->select("business_adress_master,area_master,cities,states,countries", " business_adress_master.country_id =countries.country_id AND business_adress_master.state_id =states.state_id AND business_adress_master.city_id =cities.city_id AND business_adress_master.area_id =area_master.area_id AND business_adress_master.user_id = '$data_user_id'    ", "");*/

						$address = $user_data_array[$data_user_id];
						//if (mysqli_num_rows($address) > 0) {
						if ( !empty($address)) {
							//$address_data = mysqli_fetch_array($address);
							$address_data = $address;
							$NearByMember["adress"] = $address_data["adress"]."\n Area: ".$address_data["area_name"]."\n City:  ".$address_data["city_name"]." - ".$address_data["pincode"]."\n State: ".$address_data["state_name"]."\n Country: ".$address_data["country_name"];
						} else {
							$NearByMember["adress"] = $data_app["adress"];
						}

						//27oct
						
						$NearByMember["zoobiz_id"] = $data_app['zoobiz_id'];

						$NearByMember["user_profile_pic"] = $base_url . "img/users/members_profile/" . $data_app['user_profile_pic'];

						 if($data_app['user_profile_pic'] ==""){
                        $NearByMember["user_profile_pic"] ="";
                    } else {
                        $NearByMember["user_profile_pic"] =$base_url . "img/users/members_profile/" . $data_app['user_profile_pic']; 
                    }


						$NearByMember["bussiness_category_name"] = html_entity_decode($data_app["category_name"]);

						//23oct
						if($data_app['menu_icon'] !="" && 0 ){
							$NearByMember["menu_icon"] = $base_url . "img/category/icon/" . $data_app['menu_icon'];
						} else {
							$NearByMember["menu_icon"] = "";
						}
						//23oct
						
						$NearByMember["sub_category_name"] = html_entity_decode($data_app["sub_category_name"]) . '';
						$NearByMember["company_name"] = html_entity_decode($data_app["company_name"]) . '';
						if ($data_app["public_mobile"] == 0) {
							$NearByMember["user_mobile"] = "" . substr($data_app['user_mobile'], 0, 3) . '****' . substr($data_app['user_mobile'], -3);
						} else {
							$NearByMember["user_mobile"] = $data_app["user_mobile"];
						}
						// $NearByMember["user_mobile"]=html_entity_decode($data_app["user_mobile"]).'';
						$NearByMember["user_email"] = html_entity_decode($data_app["user_email"]) . '';

						/**************************** Distance Calculation ******************************/
						$service_provider_latitude = $data_app['add_latitude'];
						$service_provider_logitude = $data_app['add_longitude'];

						$radiusInMeeter = $d->haversineGreatCircleDistance($user_latitude, $user_longitude, $service_provider_latitude, $service_provider_logitude);

						$totalKm = number_format($radiusInMeeter / 1000, 2, '.', '');

						// $distancedetails = file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=$user_latitude,$user_longitude&destinations=$service_provider_latitude,$service_provider_logitude&key=AIzaSyAUPcYOnCeZLyHFqI-ssbvwg-f12q8B85A");
						// $test = json_decode($distancedetails);
						// $destination = explode(',', $test->destination_addresses[0]);
						// $local_service_provider["distance"]=$destination[1].','.$destination[2].' - '.number_format($test->rows[0]->elements[0]->distance->value/1000,2).' km';
						// $totalKm= number_format($test->rows[0]->elements[0]->distance->value/1000,2).' km';
						$NearByMember["distance_in_km"] = $totalKm . ' KM';
						/**************************** Distance Calculation ******************************/

						array_push($response["NearByMember"], $NearByMember);
					}
				}

				$response["message"] = "Get Member Found";
				$response["status"] = "200";
				echo json_encode($response);
			} else {
				$response["message"] = "No Near By Member Found.";
				$response["status"] = "201";
				echo json_encode($response);
			}

		} else if ($_POST['getGeoMembersFilter'] == "getGeoMembersFilter" && filter_var($user_id, FILTER_VALIDATE_INT) == true) {

			$queryAry = array();
			if ($city_id != 0) {
				$cityIdAry = explode(",", $city_id);
				$ids = join("','", $cityIdAry);
				$query = "business_adress_master.city_id IN ('$ids')";
				array_push($queryAry, $query);
			}
			if ($business_category_id == 0) {
				$query = "user_employment_details.business_category_id!='0'";
				array_push($queryAry, $query);
			}
			if ($business_category_id != 0) {
				$atchQuery = "user_employment_details.business_category_id='$business_category_id'";
				array_push($queryAry, $atchQuery);
			}
			if ($business_sub_category_id != 0) {
				$atchQuery1 = "user_employment_details.business_sub_category_id='$business_sub_category_id'";
				array_push($queryAry, $atchQuery1);
			}

			if ($user_full_name != '') {
				$atchQueryName = "users_master.user_full_name LIKE '%$user_full_name%'";
				array_push($queryAry, $atchQueryName);
			}

			if ($zoobiz_id != '') {
				$atchQuery2 = "users_master.zoobiz_id LIKE '%$zoobiz_id%'";
				array_push($queryAry, $atchQuery2);
			}

			if ($user_email != '') {
				$atchQuery3 = "users_master.user_email LIKE '%$user_email%'";
				array_push($queryAry, $atchQuery3);
			}
			if ($user_mobile != '') {
				$atchQuery4 = "users_master.user_mobile LIKE '%$user_mobile%'";
				array_push($queryAry, $atchQuery4);
			}
			if ($search_keyword != '') {
				$atchQuery5 = "user_employment_details.search_keyword LIKE '%$search_keyword%'";
				array_push($queryAry, $atchQuery5);
			}

			if ($distance != '') {

				$business_adress_master_qry = $d->selectRow("add_latitude,add_longitude","business_adress_master", " business_adress_master.user_id= '$user_id' AND business_adress_master.adress_type=0 ", "");
				$business_adress_master_data = mysqli_fetch_array($business_adress_master_qry);


				$business_adress_master_qry2 = $d->selectRow(" ( ( ( acos( sin(( '".$business_adress_master_data['add_latitude']."' * pi() / 180)) * sin(( `add_latitude` * pi() / 180)) + cos(( '".$business_adress_master_data['add_latitude']."' * pi() /180 )) * cos(( `add_latitude` * pi() / 180)) * cos((( '".$business_adress_master_data['add_longitude']."' - `add_longitude`) * pi()/180))) ) * 180/pi() ) * 60 * 1.1515 * 1.609344 ) as distance, user_id ","business_adress_master", "   ( ( ( acos( sin(( '".$business_adress_master_data['add_latitude']."' * pi() / 180)) * sin(( `add_latitude` * pi() / 180)) + cos(( '".$business_adress_master_data['add_latitude']."' * pi() /180 )) * cos(( `add_latitude` * pi() / 180)) * cos((( '".$business_adress_master_data['add_longitude']."' - `add_longitude`) * pi()/180))) ) * 180/pi() ) * 60 * 1.1515 * 1.609344 )  <='$distance'  ", "");


				$user_id_arr = array('0');
				while ($business_adress_master_data2 = mysqli_fetch_array($business_adress_master_qry2)) {
					$user_id_arr[] =$business_adress_master_data2['user_id'];
				}
				$user_id_arr = implode(",", $user_id_arr);

				$atchQuery5 = "users_master.user_id in ($user_id_arr) ";
				array_push($queryAry, $atchQuery5);
			}
			



			$appendQuery = implode(" AND ", $queryAry);



			$meq = $d->selectRow("users_master.user_id,user_employment_details.business_category_id,user_employment_details.business_sub_category_id,users_master.user_full_name,business_adress_master.add_latitude,business_adress_master.add_longitude,users_master.user_id,business_adress_master.adress,users_master.zoobiz_id,users_master.user_profile_pic,business_categories.menu_icon,business_categories.category_name,business_sub_categories.sub_category_name,user_employment_details.company_name,users_master.public_mobile,users_master.user_mobile,users_master.user_mobile,users_master.user_email,business_adress_master.add_latitude,business_adress_master.add_longitude","users_master,user_employment_details,business_categories,business_sub_categories,business_adress_master", "
				business_categories.category_status = 0 and  
				business_adress_master.user_id=users_master.user_id AND business_adress_master.adress_type=0  AND business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id and users_master.is_developer_account=0  AND users_master.office_member=0 AND users_master.active_status=0    AND  $appendQuery  ", "");

			if (mysqli_num_rows($meq) > 0) {

				$dataArray = array();
				$counter = 0 ;
				foreach ($meq as  $value) {
					foreach ($value as $key => $valueNew) {
						$dataArray[$counter][$key] = $valueNew;
					}
					$counter++;
				}


				$user_id_array = array('0');
				for ($l=0; $l < count($dataArray) ; $l++) {
					$user_id_array[] = $dataArray[$l]['user_id'];
				}
				$user_id_array = implode(",", $user_id_array);


				$address = $d->selectRow("business_adress_master.user_id,business_adress_master.adress,area_master.area_name,cities.city_name,business_adress_master.pincode,states.state_name,countries.country_name","business_adress_master,area_master,cities,states,countries", " business_adress_master.country_id =countries.country_id AND business_adress_master.state_id =states.state_id AND business_adress_master.city_id =cities.city_id AND business_adress_master.area_id =area_master.area_id AND 
					business_adress_master.user_id in ($user_id_array) AND business_adress_master.adress_type=0   ", "");
				$dataArray2 = array();
				$counter2 = 0 ;
				foreach ($address as  $value) {
					foreach ($value as $key => $valueNew) {
						$dataArray2[$counter2][$key] = $valueNew;
					}
					$counter2++;
				}
				$user_data_array = array();
				for ($l=0; $l < count($dataArray2) ; $l++) {
					$user_data_array[$dataArray2[$l]['user_id']] = $dataArray2[$l];
				}

				$response["NearByMember"] = array();
				for ($l=0; $l < count($dataArray) ; $l++) {
					$data_app =$dataArray[$l];


					if (!preg_match('/^(\-?\d+(\.\d+)?),\s*(\-?\d+(\.\d+)?)$/', $data_app['add_latitude'])) {

						$NearByMember = array();
						$NearByMember["user_id"] = $data_app["user_id"];
						$NearByMember["city_name"] = $cityData["city_name"] . '';
						$NearByMember["business_category_id"] = $data_app["business_category_id"];
						$NearByMember["business_sub_category_id"] = $data_app["business_sub_category_id"];
						$NearByMember["user_full_name"] = $data_app["user_full_name"];
						$NearByMember["add_latitude"] = $data_app["add_latitude"];
						$NearByMember["add_longitude"] = $data_app["add_longitude"];

						//27oct
						$data_user_id = $data_app["user_id"];
						/*$address = $d->select("business_adress_master,area_master,cities,states,countries", " business_adress_master.country_id =countries.country_id AND business_adress_master.state_id =states.state_id AND business_adress_master.city_id =cities.city_id AND business_adress_master.area_id =area_master.area_id AND business_adress_master.user_id = '$data_user_id'    ", "");*/
						$address = $user_data_array[$data_user_id];


						if ( !empty($address) ) {
							//$address_data = mysqli_fetch_array($address);
							$address_data = $address;
							$NearByMember["adress"] = $address_data["adress"]."\n Area: ".$address_data["area_name"]."\n City:  ".$address_data["city_name"]." - ".$address_data["pincode"]."\n State: ".$address_data["state_name"]."\n Country: ".$address_data["country_name"];
						} else {
							$NearByMember["adress"] = $data_app["adress"];
						}

						//27oct


						$NearByMember["zoobiz_id"] = $data_app['zoobiz_id'];
						$NearByMember["user_profile_pic"] = $base_url . "img/users/members_profile/" . $data_app['user_profile_pic'];

						if($data_app['user_profile_pic'] ==""){
                        $NearByMember["user_profile_pic"] ="";
                    } else {
                        $NearByMember["user_profile_pic"] =$base_url . "img/users/members_profile/" . $data_app['user_profile_pic']; 
                    }


						//23oct
						if($data_app['menu_icon'] !="" && 0){
							$NearByMember["menu_icon"] = $base_url . "img/category/icon/" . $data_app['menu_icon'];
						} else {
							$NearByMember["menu_icon"] = "";
						}
						//23oct
						$NearByMember["bussiness_category_name"] = html_entity_decode($data_app["category_name"]);
						$NearByMember["sub_category_name"] = html_entity_decode($data_app["sub_category_name"]) . '';
						$NearByMember["company_name"] = html_entity_decode($data_app["company_name"]) . '';
						// $NearByMember["user_mobile"]=html_entity_decode($data_app["user_mobile"]).'';
						if ($data_app["public_mobile"] == 0) {
							$NearByMember["user_mobile"] = "" . substr($data_app['user_mobile'], 0, 3) . '****' . substr($data_app['user_mobile'], -3);
						} else {
							$NearByMember["user_mobile"] = $data_app["user_mobile"];
						}
						$NearByMember["user_email"] = html_entity_decode($data_app["user_email"]) . '';

						/**************************** Distance Calculation ******************************/
						$service_provider_latitude = $data_app['add_latitude'];
						$service_provider_logitude = $data_app['add_longitude'];

						$radiusInMeeter = $d->haversineGreatCircleDistance($user_latitude, $user_longitude, $service_provider_latitude, $service_provider_logitude);

						$totalKm = number_format($radiusInMeeter / 1000, 2, '.', '');
						// $distancedetails = file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=$user_latitude,$user_longitude&destinations=$service_provider_latitude,$service_provider_logitude&key=AIzaSyAUPcYOnCeZLyHFqI-ssbvwg-f12q8B85A");
						// $test = json_decode($distancedetails);
						// $destination = explode(',', $test->destination_addresses[0]);
						// $local_service_provider["distance"]=$destination[1].','.$destination[2].' - '.number_format($test->rows[0]->elements[0]->distance->value/1000,2).' km';
						// $totalKm= number_format($test->rows[0]->elements[0]->distance->value/1000,2).' km';
						$NearByMember["distance_in_km"] = $totalKm . ' KM';
						/**************************** Distance Calculation ******************************/
						if($totalKm <= $distance || 1){
							array_push($response["NearByMember"], $NearByMember);
						}
						
					}
				}

				$response["message"] = "Get Member Found";
				$response["status"] = "200";
				echo json_encode($response);
			} else {
				$response["message"] = "No Near By Member Found.";
				$response["status"] = "201";
				echo json_encode($response);
			}

		}

//new code
else if ($_POST['getFilterAllGeoMembers'] == "getFilterAllGeoMembers" && filter_var($user_id, FILTER_VALIDATE_INT) == true ) {
$main_user_id= $user_id;

$queryAry = array();
						if ($business_category_id == 0) {
							$query = "user_employment_details.business_category_id!='0'";
							array_push($queryAry, $query);
						}
						if ($business_category_id != 0) {
							$atchQuery = "user_employment_details.business_category_id='$business_category_id'";
							array_push($queryAry, $atchQuery);
						}
						if ($business_sub_category_id != 0) {
							$atchQuery1 = "user_employment_details.business_sub_category_id='$business_sub_category_id'";
							array_push($queryAry, $atchQuery1);
						}
						if ($city_id != 0) {
							$atchQuery1 = "business_adress_master.city_id='$city_id'";
							array_push($queryAry, $atchQuery1);
						}

						if ($pincode != 0) {
							$atchQuery1 = "business_adress_master.pincode='$pincode'";
							array_push($queryAry, $atchQuery1);
						}

						
						if ($zoobiz_id != '') {
							$atchQuery2 = "users_master.zoobiz_id LIKE '%$zoobiz_id%'";
							array_push($queryAry, $atchQuery2);
						}

						if ($user_full_name != '') {
							$atchQueryName = "users_master.user_full_name LIKE '%$user_full_name%'";
							array_push($queryAry, $atchQueryName);
						}

						if ($company_name != '') {
							$atchQueryName = "user_employment_details.company_name LIKE '%$company_name%'";
							array_push($queryAry, $atchQueryName);
						}

						if ($user_email != '') {
							$atchQueryName = "users_master.user_email LIKE '%$user_email%'";
							array_push($queryAry, $atchQueryName);
						}


						 
						if ($user_mobile != '') {
							$atchQuery4 = "users_master.user_mobile LIKE '%$user_mobile%'";
							array_push($queryAry, $atchQuery4);
						}
						if ($search_keyword != '') {
							$atchQuery5 = "user_employment_details.search_keyword LIKE '%$search_keyword%'";
							array_push($queryAry, $atchQuery5);
						}


						$business_adress_master_qry = $d->selectRow("add_latitude,add_longitude,city_id","business_adress_master", " business_adress_master.user_id= '$user_id' and adress_type=0  ", "");
				$business_adress_master_data = mysqli_fetch_array($business_adress_master_qry);

					//ignore kilometrs condition when other city is being searched

				if(isset($debug)){
			 	// echo $distance ."!= ''  &&". $business_adress_master_data['city_id'] ."==". $city_id;exit;
				 }
		 if ($distance != '' &&  ($city_id == 0 || $business_adress_master_data['city_id'] == $city_id )   /*&& $business_adress_master_data['city_id'] ==*/  ) {


				 
				 


				$business_adress_master_qry2 = $d->selectRow(" ( ( ( acos( sin(( '".$add_latitude_filter."' * pi() / 180)) * sin(( `add_latitude` * pi() / 180)) + cos(( '".$add_latitude_filter."' * pi() /180 )) * cos(( `add_latitude` * pi() / 180)) * cos((( '".$add_longitude_filter."' - `add_longitude`) * pi()/180))) ) * 180/pi() ) * 60 * 1.1515 * 1.609344 ) as distance, user_id ","business_adress_master", "   ( ( ( acos( sin(( '".$add_latitude_filter."' * pi() / 180)) * sin(( `add_latitude` * pi() / 180)) + cos(( '".$add_latitude_filter."' * pi() /180 )) * cos(( `add_latitude` * pi() / 180)) * cos((( '".$add_longitude_filter."' - `add_longitude`) * pi()/180))) ) * 180/pi() ) * 60 * 1.1515 * 1.609344 )  <='$distance'  ", "");


				$user_id_arr = array('0');
				while ($business_adress_master_data2 = mysqli_fetch_array($business_adress_master_qry2)) {
					$user_id_arr[] =$business_adress_master_data2['user_id'];
				}
				$user_id_arr = implode(",", $user_id_arr);

				$atchQuery5 = "users_master.user_id in ($user_id_arr) ";

				 if(isset($debug)){
				 	//echo $atchQuery5;exit;
				 }
				array_push($queryAry, $atchQuery5);
			}


						$appendQuery = implode(" AND ", $queryAry);
 
			$business_adress_master = $d->selectRow("add_latitude,add_longitude", "business_adress_master", 
				"user_id = $user_id and  adress_type=0  ", "");
			$business_adress_master_data = mysqli_fetch_array($business_adress_master);


			if(isset($add_latitude_filter) &&  isset($add_longitude_filter)){
				$user_latitude = $add_latitude_filter;
			    $user_longitude = $add_longitude_filter;
			} else {
				$user_latitude = $business_adress_master_data['add_latitude'];
			    $user_longitude = $business_adress_master_data['add_longitude'];
			}
			

			$meq = $d->selectRow("users_master.user_id,business_categories.business_category_id,business_sub_categories.business_sub_category_id,users_master.user_full_name,users_master.zoobiz_id,users_master.public_mobile,users_master.user_mobile,users_master.user_profile_pic,business_categories.category_name,business_sub_categories.sub_category_name,user_employment_details.company_name, user_employment_details.company_logo  ,business_adress_master.add_latitude,business_adress_master.add_longitude",
				
				"users_master,user_employment_details,business_categories,business_sub_categories ,business_adress_master", 
				"  business_adress_master.user_id= users_master.user_id and    business_categories.category_status = 0 and  
				business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id  and users_master.user_id != $user_id and business_adress_master.add_latitude!='' and business_adress_master.add_longitude!='' AND business_adress_master.adress_type=0 AND  users_master.office_member=0 AND users_master.active_status=0    and   $appendQuery  group by users_master.user_id ", "");
 

 if(isset($debug)){
 	echo "  business_adress_master.user_id= users_master.user_id and    business_categories.category_status = 0 and  
				business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id  and users_master.user_id != $user_id and business_adress_master.add_latitude!='' and business_adress_master.add_longitude!='' AND business_adress_master.adress_type=0  AND users_master.office_member=0 AND users_master.active_status=0    and   $appendQuery  group by users_master.user_id ";exit;
 }
			$user_favorite_master_q = $d->selectRow("member_id,flag","user_favorite_master", "user_id='$user_id'  ", "");
			
			$user_favorite_master_array_user = array('0');
			$user_favorite_master_array_company = array('0');
			while ($user_favorite_master = mysqli_fetch_array($user_favorite_master_q)) {

				if($user_favorite_master['flag'] == 0 ){
					$user_favorite_master_array_user[] = $user_favorite_master['member_id'];
				} else {
					$user_favorite_master_array_company[] = $user_favorite_master['member_id'];
				}
				
			}
			
			

			if (mysqli_num_rows($meq) > 0) {
				$dataArray = array();
				$counter = 0 ;
				foreach ($meq as  $value) {
					foreach ($value as $key => $valueNew) {
						$dataArray[$counter][$key] = $valueNew;
					}
					$counter++;
				}


				$user_id_array = array('0');
				for ($l=0; $l < count($dataArray) ; $l++) {
					$user_id_array[] = $dataArray[$l]['user_id'];
				}
				$user_id_array = implode(",", $user_id_array);


				$address = $d->selectRow("business_adress_master.user_id,business_adress_master.adress,area_master.area_name,cities.city_name,business_adress_master.pincode,states.state_name,countries.country_name","business_adress_master,area_master,cities,states,countries", " business_adress_master.country_id =countries.country_id AND business_adress_master.state_id =states.state_id AND business_adress_master.city_id =cities.city_id AND business_adress_master.area_id =area_master.area_id AND 
					business_adress_master.user_id in ($user_id_array) AND business_adress_master.adress_type=0   ", "");
				$dataArray2 = array();
				$counter2 = 0 ;
				foreach ($address as  $value) {
					foreach ($value as $key => $valueNew) {
						$dataArray2[$counter2][$key] = $valueNew;
					}
					$counter2++;
				}
				$user_data_array = array();
				for ($l=0; $l < count($dataArray2) ; $l++) {
					$user_data_array[$dataArray2[$l]['user_id']] = $dataArray2[$l];
				}

 
$qche_qry = $d->selectRow("follow_id,follow_to","follow_master", "follow_by='$main_user_id'    ");


                $FArray = array();
                $Fcounter = 0 ;
                foreach ($qche_qry as  $value) {
                    foreach ($value as $key => $valueNew) {
                        $FArray[$Fcounter][$key] = $valueNew;
                    }
                    $Fcounter++;
                }

                
                $fol_array = array();
                for ($l=0; $l < count($FArray) ; $l++) {
                    $fol_array[$FArray[$l]['follow_to']] = $FArray[$l];
                }

             $blocked_users = array('-2'); 
             //block_by='$user_id' or
$getBLockUserQry = $d->selectRow("user_id, block_by","user_block_master", "  user_id='$user_id'  ", "");
while($getBLockUserData=mysqli_fetch_array($getBLockUserQry)) {
	 	 if($user_id != $getBLockUserData['user_id']){
	 		$blocked_users[] = $getBLockUserData['user_id'];
	 	}
       if($user_id != $getBLockUserData['block_by']){
	 		$blocked_users[] = $getBLockUserData['block_by'];
	 	}
 }     

$response["NearByMember"] = array();
				for ($l=0; $l < count($dataArray) ; $l++) {
					$data_app =$dataArray[$l];
                     if (!preg_match('/^(\-?\d+(\.\d+)?),\s*(\-?\d+(\.\d+)?)$/', $data_app['add_latitude'])) {
                        $NearByMember = array();


					$qche = $fol_array[$data_app["user_id"]];//  
					if (count($qche) > 0  ) {
						$follow_status = true;
					} else {
						$follow_status = false;
					}

                        $NearByMember["is_follow"] = $follow_status;
 

					if(in_array($data_app["user_id"],$blocked_users)){
						$NearByMember["is_blocked"] =true;
					} else {
						$NearByMember["is_blocked"] =false;
					}

						$NearByMember["user_id"] = $data_app["user_id"];
						$NearByMember["business_category_id"] = $data_app["business_category_id"];
						$NearByMember["business_sub_category_id"] = $data_app["business_sub_category_id"];
						$NearByMember["user_full_name"] = $data_app["user_full_name"];
						$NearByMember["add_latitude"] = $data_app["add_latitude"];
						$NearByMember["add_longitude"] = $data_app["add_longitude"];
                        $data_user_id = $data_app["user_id"];
						$address = $user_data_array[$data_user_id];
						 
						if ( !empty($address)) {
							$address_data = $address;
							$NearByMember["adress"] = $address_data["adress"]."\n Area: ".$address_data["area_name"]."\n City:  ".$address_data["city_name"]." - ".$address_data["pincode"]."\n State: ".$address_data["state_name"]."\n Country: ".$address_data["country_name"];
						} else {
							$NearByMember["adress"] = $data_app["adress"];
						}

						$NearByMember["zoobiz_id"] = $data_app['zoobiz_id'];
                        $NearByMember["user_profile_pic"] = $base_url . "img/users/members_profile/" . $data_app['user_profile_pic'];

                        if($data_app['user_profile_pic'] ==""){
                        $NearByMember["user_profile_pic"] ="";
                    } else {
                        $NearByMember["user_profile_pic"] =$base_url . "img/users/members_profile/" . $data_app['user_profile_pic']; 
                    }

                    
						$NearByMember["bussiness_category_name"] = html_entity_decode($data_app["category_name"]);



						 
						if($data_app['menu_icon'] !="" && 0 ){
							$NearByMember["menu_icon"] = $base_url . "img/category/icon/" . $data_app['menu_icon'];
						} else {
							$NearByMember["menu_icon"] = "";
						}
						 
						
						$NearByMember["sub_category_name"] = html_entity_decode($data_app["sub_category_name"]) . '';
						$NearByMember["company_name"] = html_entity_decode($data_app["company_name"]) . '';
						if ($data_app["public_mobile"] == 0) {
							$NearByMember["user_mobile"] = "" . substr($data_app['user_mobile'], 0, 3) . '****' . substr($data_app['user_mobile'], -3);
						} else {
							$NearByMember["user_mobile"] = $data_app["user_mobile"];
						}
						 
						$NearByMember["user_email"] = html_entity_decode($data_app["user_email"]) . '';

						 
						$service_provider_latitude = $data_app['add_latitude'];
						$service_provider_logitude = $data_app['add_longitude'];

						$radiusInMeeter = $d->haversineGreatCircleDistance($user_latitude, $user_longitude, $service_provider_latitude, $service_provider_logitude);

						 


						$totalKm = number_format($radiusInMeeter / 1000, 2, '.', '');
                        $NearByMember["distance_in_km"] = $totalKm . ' KM';
                         if ( (int) $totalKm > $distance  && $business_adress_master_data['city_id'] == $city_id && 0){
                         	
                         } else {
                         	array_push($response["NearByMember"], $NearByMember);
                         }
						
					}
				}





		
		$response["message"] = "get Success.";
		$response["status"] = "200";
		echo json_encode($response);

	}
 
	else {
		//$response["message"] = "No User Found. business_category_id->".$business_category_id." - business_sub_category_id->".$business_sub_category_id;
		$response["message"] = "No User Found.";
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