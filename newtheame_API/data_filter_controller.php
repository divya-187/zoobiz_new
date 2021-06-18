<?php
include_once 'lib.php';

if (isset($_POST) && !empty($_POST)) {

	if ($key == $keydb) {

		$response = array();
		extract(array_map("test_input", $_POST));

		if ($_POST['getSubCategoryFilter'] == "getSubCategoryFilter") {

			$response["sub_category"] = array();

			$app_data = $d->selectRow("business_sub_categories.business_sub_category_id,business_categories.business_category_id,business_sub_categories.sub_category_name,business_categories.category_name", "business_categories,business_sub_categories", "
				business_categories.category_status = 0 and
				business_sub_categories.business_category_id=business_categories.business_category_id AND business_sub_categories.sub_category_status='0'", "ORDER BY business_sub_categories.sub_category_name ASC");

			if (mysqli_num_rows($app_data) > 0) {

				$sub_category = array();
				$sub_category["business_sub_category_id"] = "0";
				$sub_category["business_category_id"] = "0";
				$sub_category["category_name"] = html_entity_decode("All");
				array_push($response["sub_category"], $sub_category);

				while ($data = mysqli_fetch_array($app_data)) {

					$sub_category = array();
					$sub_category["business_sub_category_id"] = $data["business_sub_category_id"];
					$sub_category["business_category_id"] = $data["business_category_id"];
					$sub_category["category_name"] = html_entity_decode($data["sub_category_name"] . ' - ' . $data["category_name"]);
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

		} else if ($_POST['getCombineCityState'] == "getCombineCityState") {

			$response["city_state"] = array();

			/*$app_data = $d->selectRow("cities.city_name,cities.city_id,states.state_id,states.state_name","cities,states", "states.state_id = cities.state_id and  cities.city_flag =1 and states.state_flag=1 ", "ORDER BY cities.city_name ASC"); */

			$app_data = $d->selectRow("cities.city_name,cities.city_id,states.state_id,states.state_name", "cities,states,users_master", "states.state_id = cities.state_id and  cities.city_flag =1 and states.state_flag=1 AND cities.city_id = users_master.city_id AND users_master.is_profile_completed = 1", "GROUP BY cities.city_id ORDER BY cities.city_name ASC");
			if (mysqli_num_rows($app_data) > 0) {
				/*$city_state = array();

					$city_state["city_id"] = "0";
					$city_state["state_id"] = "0";
					$city_state["city_name"] = html_entity_decode("All");
					array_push($response["city_state"], $city_state);*/

				while ($data = mysqli_fetch_array($app_data)) {

					$city_state = array();

					$city_state["city_id"] = $data["city_id"];
					$city_state["state_id"] = $data["state_id"];

					if ($data["city_name"] == "Others") {
						$city_state["city_name"] = html_entity_decode($data["city_name"]);
					} else {
						$city_state["city_name"] = html_entity_decode($data["city_name"] . ' - ' . $data["state_name"]);
					}

					array_push($response["city_state"], $city_state);

				}
				$response["message"] = "City Data.";
				$response["status"] = "200";
				echo json_encode($response);

			} else {
				$response["message"] = "No Data Found.";
				$response["status"] = "201";
				echo json_encode($response);
			}

		} else if ($_POST['getMembersFilter'] == "getMembersFilter" && filter_var($user_id, FILTER_VALIDATE_INT) == true) {

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
			if ($zoobiz_id != '') {
				$atchQuery2 = "users_master.zoobiz_id LIKE '%$zoobiz_id%'";
				array_push($queryAry, $atchQuery2);
			}

			if ($user_full_name != '') {
				$atchQueryName = "users_master.user_full_name LIKE '%$user_full_name%'";
				array_push($queryAry, $atchQueryName);
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

			$appendQuery = implode(" AND ", $queryAry);

			if ($city_id == 0 || $city_id == '') {
				$app_data = $d->selectRow("city_id,city_name", "cities", "state_id='$state_id' AND city_flag=1", "ORDER BY city_name ASC");
			} else {
				$cityIdAry = explode(",", $city_id);
				$ids = join("','", $cityIdAry);
				$app_data = $d->selectRow("city_id,city_name", "cities", "state_id='$state_id' AND city_flag=1 AND city_id IN ('$ids')", "ORDER BY city_name ASC");
			}

			if (mysqli_num_rows($app_data) > 0) {

				$response["city"] = array();

				$dataArray = array();
				$counter = 0;
				foreach ($app_data as $value) {
					foreach ($value as $key => $valueNew) {
						$dataArray[$counter][$key] = $valueNew;
					}
					$counter++;
				}
				$city_id_array = array('0');
				for ($l = 0; $l < count($dataArray); $l++) {
					$city_id_array[] = $dataArray[$l]['city_id'];
				}

				$city_id_array = implode(",", $city_id_array);
				$qs_q = $d->selectRow("area_id,pincode,area_name,pincode,latitude,longitude,city_id", "area_master", "city_id in ($city_id_array)   ", "ORDER BY area_name ASC");

				$dataArray2 = array();
				$counter2 = 0;
				foreach ($qs_q as $value) {
					foreach ($value as $key => $valueNew) {
						$dataArray2[$counter2][$key] = $valueNew;
					}
					$counter2++;
				}
				$area_data = array();
				$area_id_array = array('0');
				for ($l2 = 0; $l2 < count($dataArray2); $l2++) {
					$area_data[$dataArray2[$l2]['city_id']][] = $dataArray2[$l2];
					$area_id_array[] = $dataArray2[$l2]['area_id'];
				}

				$area_id_array = implode(",", $area_id_array);
				$meq = $d->selectRow("business_adress_master.area_id,users_master.user_id,business_categories.business_category_id,business_sub_categories.business_sub_category_id,users_master.user_full_name,users_master.zoobiz_id,users_master.user_mobile,users_master.public_mobile,users_master.user_profile_pic,business_categories.category_name,business_sub_categories.sub_category_name,user_employment_details.company_name", "users_master,user_employment_details,business_categories,business_sub_categories,business_adress_master", "
							business_categories.category_status = 0 and
							business_adress_master.user_id=users_master.user_id AND business_adress_master.adress_type=0 AND business_adress_master.area_id in ($area_id_array)    AND business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id  AND users_master.office_member=0 AND users_master.active_status=0    AND  $appendQuery", "");

				$dataArray3 = array();
				$counter3 = 0;
				foreach ($meq as $value) {
					foreach ($value as $key => $valueNew) {
						$dataArray3[$counter3][$key] = $valueNew;
					}
					$counter3++;
				}

				$main_data = array();
				for ($l6 = 0; $l6 < count($dataArray3); $l6++) {
					$main_data[$dataArray3[$l6]['area_id']][] = $dataArray3[$l6];

				}
//echo "<pre>";print_r($main_data);exit;

//print_r($area_data['15499']);exit;

				//while ($data = mysqli_fetch_array($app_data)) {
				for ($l = 0; $l < count($dataArray); $l++) {
					$data = $dataArray[$l];
					$city = array();
					$city["city_id"] = $data["city_id"];
					$city["ids"] = $ids;
					$city["city_name"] = html_entity_decode($data["city_name"]);
					if ($data["city_id"] == $city_id) {
						$city["primary_city"] = true;
					} else {
						$city["category_icon"] = false;
					}

					$city["area"] = array();
					$qs = $area_data[$data[city_id]]; // $d->selectRow("area_id,pincode,area_name,pincode,latitude,longitude","area_master", "city_id='$data[city_id]' ", "ORDER BY area_name ASC");

					//while ($subData = mysqli_fetch_array($qs)) {
					for ($l3 = 0; $l3 < count($qs); $l3++) {
						$subData = $qs[$l3];
						$area = array();
						$area["area_id"] = $subData["area_id"];

						if ($subData["pincode"] != 0) {
							$area["area_name_with_pincode"] = html_entity_decode($subData["area_name"]) . ' [' . $subData["pincode"] . ']';
						} else {
							$area["area_name_with_pincode"] = html_entity_decode($subData["area_name"]);

						}

						$area["pincode"] = $subData["pincode"];
						$area["latitude"] = $subData["latitude"];
						$area["longitude"] = $subData["longitude"];

						$area["member"] = array();

						$meq = $main_data[$subData['area_id']];

						//$totalUsers = mysqli_num_rows($meq);

						$totalUsers = count($meq);

						for ($l8 = 0; $l8 < count($meq); $l8++) {
							//while ($data_app = mysqli_fetch_array($meq)) {
							$data_app = $meq[$l8];
							$qche = $d->selectRow("follow_id", "follow_master", "follow_by='$user_id' AND follow_to='$data_app[user_id]'");
							if (mysqli_num_rows($qche) > 0) {
								$follow_status = true;
							} else {
								$follow_status = false;
							}

							$member = array();
							$member["user_id"] = $data_app["user_id"];
							$member["business_category_id"] = $data_app["business_category_id"];
							$member["business_sub_category_id"] = $data_app["business_sub_category_id"];
							$member["user_full_name"] = $data_app["user_full_name"];
							$member["zoobiz_id"] = $data_app["zoobiz_id"];
							$member["user_mobile"] = $data_app["user_mobile"];
							$member["public_mobile"] = $data_app["public_mobile"];
							$member["user_profile_pic"] = $base_url . "img/users/members_profile/" . $data_app['user_profile_pic'];

							if ($data_app['user_profile_pic'] == "") {
								$member["user_profile_pic"] = "";
							} else {
								$member["user_profile_pic"] = $base_url . "img/users/members_profile/" . $data_app['user_profile_pic'];
							}

							$member["bussiness_category_name"] = html_entity_decode($data_app["category_name"]);
							$member["sub_category_name"] = html_entity_decode($data_app["sub_category_name"]) . '';
							$member["company_name"] = html_entity_decode($data_app["company_name"]) . '';
							$member["follow_status"] = $follow_status;

							array_push($area["member"], $member);
						}
						if ($totalUsers > 0) {
							array_push($city["area"], $area);
						}
					}

					array_push($response["city"], $city);
				}

				$response["message"] = "get Success.";
				$response["status"] = "200";
				echo json_encode($response);
			} else {
				$response["message"] = "No Data Found.";
				$response["status"] = "201";
				echo json_encode($response);
			}

		} else if ($_POST['getFilterAllMembersnew'] == "getFilterAllMembersnew" && filter_var($user_id, FILTER_VALIDATE_INT) == true) {

//recent memmber data start
			$user_recent_master_qry = $d->selectRow("users_master.user_id,business_categories.business_category_id,business_sub_categories.business_sub_category_id,users_master.user_full_name,users_master.zoobiz_id,users_master.public_mobile,users_master.user_mobile,users_master.user_profile_pic,business_categories.category_name,business_sub_categories.sub_category_name,user_employment_details.company_name, user_employment_details.company_logo   ,user_recent_master.id,user_recent_master.member_id,user_recent_master.user_id,user_recent_master.flag,user_employment_details.company_name,user_employment_details.company_logo, users_master.user_full_name, users_master.user_profile_pic", "user_recent_master,users_master,user_employment_details, business_categories,business_sub_categories",
				"user_employment_details.user_id=user_recent_master.member_id and  business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND users_master.office_member=0 AND users_master.active_status=0  AND  users_master.user_id =user_recent_master.member_id and   user_recent_master.user_id ='$user_id' and   user_recent_master.member_id != $user_id ", " GROUP by user_recent_master.user_id, user_recent_master.member_id, user_recent_master.flag       order by user_recent_master.id desc limit 0,4 ");

			$user_favorite_master_q = $d->selectRow("member_id,flag", "user_favorite_master", "user_id='$user_id'  ", "");

			$user_favorite_master_array_user = array('0');
			$user_favorite_master_array_company = array('0');
			while ($user_favorite_master = mysqli_fetch_array($user_favorite_master_q)) {

				if ($user_favorite_master['flag'] == 0) {
					$user_favorite_master_array_user[] = $user_favorite_master['member_id'];
				} else {
					$user_favorite_master_array_company[] = $user_favorite_master['member_id'];
				}

			}

			$response["recentMember"] = array();
			if (mysqli_num_rows($user_recent_master_qry) > 0) {

				while ($user_recent_master_data = mysqli_fetch_array($user_recent_master_qry)) {
					$recentMember = array();

					$recentMember["user_id"] = $user_recent_master_data["member_id"];
					$recentMember["user_name"] = html_entity_decode($user_recent_master_data["user_full_name"]);
					$recentMember["company_name"] = html_entity_decode($user_recent_master_data["company_name"]);
					$recentMember["category_name"] = html_entity_decode($user_recent_master_data["category_name"]);
					$recentMember["sub_category_name"] = html_entity_decode($user_recent_master_data["sub_category_name"]);
					$recentMember["designation"] = html_entity_decode($user_recent_master_data["designation"]);
					if ($user_recent_master_data['user_profile_pic'] != "") {
						$recentMember["user_profile_pic"] = $base_url . "img/users/members_profile/" . $user_recent_master_data['user_profile_pic'];
					} else {
						$recentMember["user_profile_pic"] = "";
					}

					if ($user_recent_master_data['company_logo'] != "") {
						$recentMember["company_logo"] = $base_url . "img/users/company_logo/" . $user_recent_master_data['company_logo'];
					} else {
						$recentMember["company_logo"] = "";
					}

					if ($user_recent_master_data['flag'] == 0) {
						$recentMember["type"] = "0";
					} else {
						$recentMember["type"] = "1";
					}

					/*if(in_array($user_recent_master_data['member_id'], $user_favorite_master_array_company)){
							$recentMember["is_fevorite"] = "1";
						}else {
							$recentMember["is_fevorite"] = "0";
					*/

					if ($user_recent_master_data['flag'] == 0) {
						if (in_array($user_recent_master_data['member_id'], $user_favorite_master_array_user)) {
							$recentMember["is_fevorite"] = "1";
						} else {
							$recentMember["is_fevorite"] = "0";
						}
					} else {
						if (in_array($user_recent_master_data['member_id'], $user_favorite_master_array_company)) {
							$recentMember["is_fevorite"] = "1";
						} else {
							$recentMember["is_fevorite"] = "0";
						}
					}

					array_push($response["recentMember"], $recentMember);
				}
			}
//recent memmber data end

			$qche_qry = $d->selectRow("follow_id,follow_to", "follow_master", "follow_by='$user_id'    ");

			$FArray = array();
			$Fcounter = 0;
			foreach ($qche_qry as $value) {
				foreach ($value as $key => $valueNew) {
					$FArray[$Fcounter][$key] = $valueNew;
				}
				$Fcounter++;
			}

			$fol_array = array();
			for ($l = 0; $l < count($FArray); $l++) {
				$fol_array[$FArray[$l]['follow_to']] = $FArray[$l];
			}

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

			$appendQuery = implode(" AND ", $queryAry);

			$meq = $d->selectRow("users_master.user_first_name,users_master.user_last_name,users_master.user_id,business_categories.business_category_id,business_sub_categories.business_sub_category_id,users_master.user_full_name,users_master.zoobiz_id,users_master.public_mobile,users_master.user_mobile,users_master.user_profile_pic,business_categories.category_name,business_sub_categories.sub_category_name,user_employment_details.company_name, user_employment_details.company_logo, user_employment_details.search_keyword",

				"users_master,user_employment_details,business_categories,business_sub_categories,business_adress_master",
				"  business_adress_master.user_id = users_master.user_id and    business_categories.category_status = 0 and
				business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id and users_master.user_id != $user_id  AND users_master.office_member=0 AND users_master.active_status=0   and   $appendQuery  group by users_master.user_id   ", "");

			$user_favorite_master_q = $d->selectRow("member_id,flag", "user_favorite_master", "user_id='$user_id'  ", "");

			$user_favorite_master_array_user = array('0');
			$user_favorite_master_array_company = array('0');
			while ($user_favorite_master = mysqli_fetch_array($user_favorite_master_q)) {

				if ($user_favorite_master['flag'] == 0) {
					$user_favorite_master_array_user[] = $user_favorite_master['member_id'];
				} else {
					$user_favorite_master_array_company[] = $user_favorite_master['member_id'];
				}

			}
			$blocked_users = array('-2');
			$getBLockUserQry = $d->selectRow("user_id, block_by", "user_block_master", " block_by='$user_id' or user_id='$user_id'  ", "");
			while ($getBLockUserData = mysqli_fetch_array($getBLockUserQry)) {
				if ($user_id != $getBLockUserData['user_id']) {
					$blocked_users[] = $getBLockUserData['user_id'];
				}
				if ($user_id != $getBLockUserData['block_by']) {
					$blocked_users[] = $getBLockUserData['block_by'];
				}
			}

			if (mysqli_num_rows($meq) > 0) {

				$response["AllMembers"] = array();
				while ($data = mysqli_fetch_array($meq)) {
					$member = array();

					$company = array();

					$qche = $fol_array[$data["user_id"]]; //
					if (count($qche) > 0) {
						$follow_status = true;
					} else {
						$follow_status = false;
					}

					if (in_array($data["user_id"], $blocked_users)) {
						$member["is_blocked"] = true;
					} else {
						$member["is_blocked"] = false;
					}

					$member["is_follow"] = $follow_status;
					if ($data['public_mobile'] == "0") {
						$member["mobile_privacy"] = true;
					} else {
						$member["mobile_privacy"] = false;
					}
					$member["user_mobile"] = $data["user_mobile"];
					$member["short_name"] = strtoupper(substr($data["user_first_name"], 0, 1) . substr($data["user_last_name"], 0, 1));
					$member["search_keyword"] = html_entity_decode($data["search_keyword"]);
					$member["user_id"] = $data["user_id"];
					$member["user_name"] = html_entity_decode($data["user_full_name"]);
					$member["company_name"] = html_entity_decode($data["company_name"]);
					$member["category_name"] = html_entity_decode($data["category_name"]);
					$member["sub_category_name"] = html_entity_decode($data["sub_category_name"]);
					$member["designation"] = html_entity_decode($data["designation"]);
					if ($data['user_profile_pic'] != "") {
						$member["user_profile_pic"] = $base_url . "img/users/members_profile/" . $data['user_profile_pic'];
					} else {
						$member["user_profile_pic"] = "";
					}

					if ($data['company_logo'] != "") {
						$member["company_logo"] = $base_url . "img/users/company_logo/" . $data['company_logo'];
					} else {
						$member["company_logo"] = "";
					}

					$member["type"] = "0";

					if (in_array($data['user_id'], $user_favorite_master_array_user)) {
						$member["is_fevorite"] = "1";
					} else {
						$member["is_fevorite"] = "0";
					}

					array_push($response["AllMembers"], $member);

				}

				shuffle($response["AllMembers"]);

				$response["message"] = "get Success.";
				$response["status"] = "200";
				echo json_encode($response);

			} else {
				$response["message"] = "No User Found.";
				$response["status"] = "201";
				echo json_encode($response);
			}

		} else if ($_POST['getFilterAllMembers'] == "getFilterAllMembers" && filter_var($user_id, FILTER_VALIDATE_INT) == true) {

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

			$appendQuery = implode(" AND ", $queryAry);

			$meq = $d->selectRow("users_master.user_first_name,users_master.user_last_name,users_master.user_id,business_categories.business_category_id,business_sub_categories.business_sub_category_id,users_master.user_full_name,users_master.zoobiz_id,users_master.public_mobile,users_master.user_mobile,users_master.user_profile_pic,business_categories.category_name,business_sub_categories.sub_category_name,user_employment_details.company_name, user_employment_details.company_logo, user_employment_details.search_keyword",

				"users_master,user_employment_details,business_categories,business_sub_categories,business_adress_master",
				"  business_adress_master.user_id = users_master.user_id and    business_categories.category_status = 0 and
				business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id and users_master.user_id != $user_id  AND users_master.office_member=0 AND users_master.active_status=0   and   $appendQuery  group by users_master.user_id   ", "");

			$user_favorite_master_q = $d->selectRow("member_id,flag", "user_favorite_master", "user_id='$user_id'  ", "");

			$user_favorite_master_array_user = array('0');
			$user_favorite_master_array_company = array('0');
			while ($user_favorite_master = mysqli_fetch_array($user_favorite_master_q)) {

				if ($user_favorite_master['flag'] == 0) {
					$user_favorite_master_array_user[] = $user_favorite_master['member_id'];
				} else {
					$user_favorite_master_array_company[] = $user_favorite_master['member_id'];
				}

			}

			if (mysqli_num_rows($meq) > 0) {

				$response["AllMembers"] = array();
				while ($data = mysqli_fetch_array($meq)) {
					$member = array();

					$company = array();

					$member["short_name"] = strtoupper(substr($data["user_first_name"], 0, 1) . substr($data["user_last_name"], 0, 1));
					$member["search_keyword"] = html_entity_decode($data["search_keyword"]);
					$member["user_id"] = $data["user_id"];
					$member["user_name"] = html_entity_decode($data["user_full_name"]);
					$member["company_name"] = html_entity_decode($data["company_name"]);
					$member["category_name"] = html_entity_decode($data["category_name"]);
					$member["sub_category_name"] = html_entity_decode($data["sub_category_name"]);
					$member["designation"] = html_entity_decode($data["designation"]);
					if ($data['user_profile_pic'] != "") {
						$member["user_profile_pic"] = $base_url . "img/users/members_profile/" . $data['user_profile_pic'];
					} else {
						$member["user_profile_pic"] = "";
					}

					if ($data['company_logo'] != "") {
						$member["company_logo"] = $base_url . "img/users/company_logo/" . $data['company_logo'];
					} else {
						$member["company_logo"] = "";
					}

					$member["type"] = "0";

					if (in_array($data['user_id'], $user_favorite_master_array_user)) {
						$member["is_fevorite"] = "1";
					} else {
						$member["is_fevorite"] = "0";
					}

					array_push($response["AllMembers"], $member);

					$company["user_id"] = $data["user_id"];
					$company["user_name"] = html_entity_decode($data["user_full_name"]);
					$company["company_name"] = html_entity_decode($data["company_name"]);
					$company["category_name"] = html_entity_decode($data["category_name"]);
					$company["sub_category_name"] = html_entity_decode($data["sub_category_name"]);
					$company["designation"] = html_entity_decode($data["designation"]);
					if ($data['user_profile_pic'] != "") {
						$company["user_profile_pic"] = $base_url . "img/users/members_profile/" . $data['user_profile_pic'];
					} else {
						$company["user_profile_pic"] = "";
					}

					if ($data['company_logo'] != "") {
						$company["company_logo"] = $base_url . "img/users/company_logo/" . $data['company_logo'];
					} else {
						$company["company_logo"] = "";
					}

					$company["type"] = "1";

					if (in_array($data['user_id'], $user_favorite_master_array_company)) {
						$company["is_fevorite"] = "1";
					} else {
						$company["is_fevorite"] = "0";
					}
					array_push($response["AllMembers"], $company);
				}

				shuffle($response["AllMembers"]);

				$response["message"] = "get Success.";
				$response["status"] = "200";
				echo json_encode($response);

			} else {
				$response["message"] = "No User Found.";
				$response["status"] = "201";
				echo json_encode($response);
			}

		} else if ($_POST['getSubCatMembersFilter'] == "getSubCatMembersFilter" && filter_var($user_id, FILTER_VALIDATE_INT) == true && isset($business_sub_category_id)) {

			//	$business_sub_category_id = implode(",", $business_sub_category_id);

			$meq = $d->selectRow("users_master.user_id,business_categories.business_category_id,business_sub_categories.business_sub_category_id,users_master.user_full_name,users_master.zoobiz_id,users_master.public_mobile,users_master.user_mobile,users_master.user_profile_pic,business_categories.category_name,business_sub_categories.sub_category_name,user_employment_details.company_name, user_employment_details.company_logo,user_employment_details.search_keyword",

				"users_master,user_employment_details,business_categories,business_sub_categories",
				"     business_categories.category_status = 0 and
				business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id  group by users_master.user_id and users_master.user_id != $user_id and user_employment_details.business_sub_category_id in ($business_sub_category_id )  AND users_master.office_member=0 AND users_master.active_status=0   ", "");

			$user_favorite_master_q = $d->selectRow("member_id,flag", "user_favorite_master", "user_id='$user_id'  ", "");

			$user_favorite_master_array_user = array('0');
			$user_favorite_master_array_company = array('0');
			while ($user_favorite_master = mysqli_fetch_array($user_favorite_master_q)) {

				if ($user_favorite_master['flag'] == 0) {
					$user_favorite_master_array_user[] = $user_favorite_master['member_id'];
				} else {
					$user_favorite_master_array_company[] = $user_favorite_master['member_id'];
				}

			}

			if (mysqli_num_rows($meq) > 0) {

				$response["FilteredSubCatMember"] = array();
				while ($data = mysqli_fetch_array($meq)) {
					$member = array();

					$company = array();

					$member["user_id"] = $data["user_id"];
					$member["user_name"] = html_entity_decode($data["user_full_name"]);
					$member["company_name"] = html_entity_decode($data["company_name"]);
					$member["category_name"] = html_entity_decode($data["category_name"]);
					$member["sub_category_name"] = html_entity_decode($data["sub_category_name"]);
					$member["designation"] = html_entity_decode($data["designation"]);
					if ($data['user_profile_pic'] != "") {
						$member["user_profile_pic"] = $base_url . "img/users/members_profile/" . $data['user_profile_pic'];
					} else {
						$member["user_profile_pic"] = "";
					}
					$response["search_keyword"] = html_entity_decode($data_app["search_keyword"]);
					if ($data['company_logo'] != "") {
						$member["company_logo"] = $base_url . "img/users/company_logo/" . $data['company_logo'];
					} else {
						$member["company_logo"] = "";
					}

					$member["type"] = "0";

					if (in_array($data['user_id'], $user_favorite_master_array_user)) {
						$member["is_fevorite"] = "1";
					} else {
						$member["is_fevorite"] = "0";
					}

					array_push($response["FilteredSubCatMember"], $member);

				}

				//shuffle($response["FilteredSubCatMember"]);

				$response["total_records"] = mysqli_num_rows($meq);
				$response["message"] = "get Success.";
				$response["status"] = "200";
				echo json_encode($response);

			} else {
				$response["message"] = "No Data Found.";
				$response["status"] = "201";
				echo json_encode($response);
			}

		} else if ($_POST['get_active_cities'] == "get_active_cities" && filter_var($user_id, FILTER_VALIDATE_INT) == true) {

			$response["cities"] = array();
			$cities = array();
			$cities["city_id"] = "0";
			$cities["city_name"] = "All";
			array_push($response["cities"], $cities);

			$cities = $d->selectRow("cities.city_id,cities.city_name", "cities,business_adress_master", "business_adress_master.city_id=cities.city_id and business_adress_master.user_id='$user_id' and   city_flag=1", "");
			$user_city = 0;
			if (mysqli_num_rows($cities) > 0) {
				$cities_data = mysqli_fetch_array($cities);
				$cities = array();
				$user_city = $cities_data['city_id'];
				$cities["city_id"] = $cities_data['city_id'];
				$cities["city_name"] = $cities_data['city_name'];
				array_push($response["cities"], $cities);
			}

			$qA2 = $d->selectRow("city_id,city_name", "cities", "city_flag=1 and city_id!='$user_city'", "");

			if (mysqli_num_rows($qA2) > 0) {

				while ($data_app2 = mysqli_fetch_array($qA2)) {

					$cities = array();
					$cities["city_id"] = $data_app2["city_id"];
					$cities["city_name"] = $data_app2["city_name"];
					array_push($response["cities"], $cities);

				}
				//	$response["count"] = mysqli_num_rows($qA2);
				$response["message"] = "Cities List.";
				$response["status"] = "200";
				echo json_encode($response);
			} else {

				$response["message"] = "No Cities";
				$response["status"] = "201";
				echo json_encode($response);
			}

		} else if ($_POST['getMembersTagFilter'] == "getMembersTagFilter" && filter_var($user_id, FILTER_VALIDATE_INT) == true) {

			$where_cond = "";
			$queryAry = array();
			/*if ($business_sub_category_id != 0) {
				$where_cond .= " AND user_employment_details.business_category_id ='$business_sub_category_id'";
			}*/

			if ($city_id != 0) {
				$where_cond .= "AND business_adress_master.city_id ='$city_id'";
			}

			if ($search_keyword != '' && strtolower($search_keyword) != 'all') {
				$where_cond .= "AND (";
				$where_cond .= "   user_employment_details.search_keyword  LIKE '%" . $search_keyword . "%' ";

				/*if($business_sub_category_id !=0 && $business_sub_category_id!=""){
					 	$where_cond .= " OR user_employment_details.business_sub_category_id ='$business_sub_category_id'  ";
				*/

				$where_cond .= ")";
			} else if ($business_sub_category_id != 0) {
				$where_cond .= " AND user_employment_details.business_sub_category_id ='$business_sub_category_id'  ";
			}

			//$appendQuery = implode(" AND ", $queryAry);

			$meq = $d->selectRow("users_master.user_id,business_categories.business_category_id,business_sub_categories.business_sub_category_id,users_master.user_full_name,users_master.zoobiz_id,users_master.public_mobile,users_master.user_mobile,users_master.user_profile_pic,business_categories.category_name,business_sub_categories.sub_category_name,user_employment_details.company_name, user_employment_details.company_logo,user_employment_details.search_keyword,users_master.user_first_name,users_master.user_last_name",

				"business_adress_master, users_master,user_employment_details,business_categories,business_sub_categories",
				"  business_adress_master.user_id = users_master.user_id    and business_categories.category_status = 0 and
				business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id   AND users_master.office_member=0 AND users_master.active_status=0  and users_master.user_id != $user_id   $where_cond  group by users_master.user_id  order by  user_employment_details.search_keyword   ", "");

			if (isset($debug)) {
				echo "business_adress_master.user_id = users_master.user_id    and business_categories.category_status = 0 and
				business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id   AND users_master.office_member=0 AND users_master.active_status=0  and users_master.user_id != $user_id   $where_cond  group by users_master.user_id  order by  user_employment_details.search_keyword";exit;
			}
			$user_favorite_master_q = $d->selectRow("member_id,flag", "user_favorite_master", "user_id='$user_id'  ", "");

			$user_favorite_master_array_user = array('0');
			$user_favorite_master_array_company = array('0');
			while ($user_favorite_master = mysqli_fetch_array($user_favorite_master_q)) {

				if ($user_favorite_master['flag'] == 0) {
					$user_favorite_master_array_user[] = $user_favorite_master['member_id'];
				} else {
					$user_favorite_master_array_company[] = $user_favorite_master['member_id'];
				}

			}

			if (mysqli_num_rows($meq) > 0) {

				$response["AllMembers"] = array();
				while ($data = mysqli_fetch_array($meq)) {
					$member = array();

					$company = array();
					$member["short_name"] = strtoupper(substr($data["user_first_name"], 0, 1) . substr($data["user_last_name"], 0, 1));

					if ($data['public_mobile'] == "0") {
						$member["mobile_privacy"] = true;
					} else {
						$member["mobile_privacy"] = false;
					}

					$company["user_mobile"] = $data["user_mobile"];
					$member["user_id"] = $data["user_id"];
					$member["search_keyword"] = html_entity_decode($data["search_keyword"]);
					$member["user_name"] = html_entity_decode($data["user_full_name"]);
					$member["company_name"] = html_entity_decode($data["company_name"]);
					$member["category_name"] = html_entity_decode($data["category_name"]);
					$member["sub_category_name"] = html_entity_decode($data["sub_category_name"]);
					$member["designation"] = html_entity_decode($data["designation"]);
					if ($data['user_profile_pic'] != "") {
						$member["user_profile_pic"] = $base_url . "img/users/members_profile/" . $data['user_profile_pic'];
					} else {
						$member["user_profile_pic"] = "";
					}

					if ($data['company_logo'] != "") {
						$member["company_logo"] = $base_url . "img/users/company_logo/" . $data['company_logo'];
					} else {
						$member["company_logo"] = "";
					}

					$member["type"] = "0";

					if (in_array($data['user_id'], $user_favorite_master_array_user)) {
						$member["is_fevorite"] = "1";
					} else {
						$member["is_fevorite"] = "0";
					}

					array_push($response["AllMembers"], $member);

					$company["user_id"] = $data["user_id"];

					if ($data['public_mobile'] == "0") {
						$company["mobile_privacy"] = true;
					} else {
						$company["mobile_privacy"] = false;
					}

					$company["user_mobile"] = $data["user_mobile"];
					$company["search_keyword"] = html_entity_decode($data["search_keyword"]);
					$company["user_name"] = html_entity_decode($data["user_full_name"]);
					$company["company_name"] = html_entity_decode($data["company_name"]);
					$company["category_name"] = html_entity_decode($data["category_name"]);
					$company["sub_category_name"] = html_entity_decode($data["sub_category_name"]);
					$company["designation"] = html_entity_decode($data["designation"]);
					if ($data['user_profile_pic'] != "") {
						$company["user_profile_pic"] = $base_url . "img/users/members_profile/" . $data['user_profile_pic'];
					} else {
						$company["user_profile_pic"] = "";
					}

					if ($data['company_logo'] != "") {
						$company["company_logo"] = $base_url . "img/users/company_logo/" . $data['company_logo'];
					} else {
						$company["company_logo"] = "";
					}

					$company["type"] = "1";

					if (in_array($data['user_id'], $user_favorite_master_array_company)) {
						$company["is_fevorite"] = "1";
					} else {
						$company["is_fevorite"] = "0";
					}
					array_push($response["AllMembers"], $company);
				}

				shuffle($response["AllMembers"]);

				$response["message"] = "get Success.";
				$response["status"] = "200";
				echo json_encode($response);

			} else {
				$response["message"] = "No User Found.";
				$response["status"] = "201";
				echo json_encode($response);
			}

		} else {
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