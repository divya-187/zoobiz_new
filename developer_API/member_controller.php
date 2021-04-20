<?php
include_once 'lib.php';

/*ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);*/

if (isset($_POST) && !empty($_POST)) {

	if ($key == $keydb) {

		$response = array();
		extract(array_map("test_input", $_POST));
		
		if ($_POST['getCategory'] == "getCategory") {
			
			$app_data = $d->selectRow("business_category_id,category_name,category_images,menu_icon","business_categories", " 
				category_status='0'", "ORDER BY category_name ASC");

			if (mysqli_num_rows($app_data) > 0) {

				$response["category"] = array();

				while ($data = mysqli_fetch_array($app_data)) {

					$category = array();
					$category["business_category_id"] = $data["business_category_id"];
					$category["category_name"] = html_entity_decode($data["category_name"]);

					if ($data["category_images"] != '') {
						$category["category_icon"] = $base_url . "img/category/" . $data["category_images"];
					} else {
						$category["category_icon"] = "";
					}

					if ($data["menu_icon"] != '') {
						$category["menu_icon"] = $base_url . "img/category/icon/" . $data["menu_icon"];
					} else {
						$category["menu_icon"] = "";
					}

					array_push($response["category"], $category);
				}

				$response["message"] = "get Success.";
				$response["status"] = "200";
				echo json_encode($response);
			} else {
				$response["message"] = "No Data Found.";
				$response["status"] = "201";
				echo json_encode($response);
			}

		} else if ($_POST['getCategory'] == "getCategoryMember" && filter_var($user_id, FILTER_VALIDATE_INT) == true ) {

			$app_data = $d->selectRow("business_category_id,category_name,category_images","business_categories", "  
				category_status='0'", "ORDER BY category_name ASC");


			//code optimize

                $dataArray = array();
                $counter = 0 ;
                foreach ($app_data as  $value) {
                    foreach ($value as $key => $valueNew) {
                        $dataArray[$counter][$key] = $valueNew;
                    }
                    $counter++;
                }
                $business_category_id_array = array('0');
                for ($l=0; $l < count($dataArray) ; $l++) {
                    $business_category_id_array[] = $dataArray[$l]['business_category_id'];
                }
                $business_category_id_array = implode(",", $business_category_id_array);
                 

                 $meq_qry = $d->selectRow("users_master.user_id,user_employment_details.business_category_id","users_master,user_employment_details,business_categories,business_sub_categories,business_adress_master", "  business_categories.category_status = 0 and  
						business_adress_master.user_id=users_master.user_id AND business_adress_master.adress_type=0 AND business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id  AND user_employment_details.business_category_id in ($business_category_id_array )  AND users_master.office_member=0 AND users_master.active_status=0  ", "");

                 $CArray = array();
                $Ccounter = 0 ;
                foreach ($meq_qry as  $value) {
                    foreach ($value as $key => $valueNew) {
                        $CArray[$Ccounter][$key] = $valueNew;
                    }
                    $Ccounter++;
                }
                $med_arr = array();
                for ($c=0; $c < count($CArray) ; $c++) {
                    $med_arr[$CArray[$c]['business_category_id']][] = $CArray[$c];
                }

                $qq1_qry = $d->selectRow("category_follow_id,category_id","category_follow_master", "category_id in ($business_category_id_array ) AND user_id='$user_id'");
                  $FArray = array();
                $Fcounter = 0 ;
                foreach ($qq1_qry as  $value) {
                    foreach ($value as $key => $valueNew) {
                        $FArray[$Fcounter][$key] = $valueNew;
                    }
                    $Fcounter++;
                }
                $folow_data_arr = array();
                for ($f=0; $f < count($FArray) ; $f++) {
                    $folow_data_arr[$FArray[$f]['category_id']]  = $FArray[$f];
                }
             // echo "<pre>";print_r($folow_data_arr);exit;

//code optimize

			if (count($dataArray) > 0) {

				$response["category"] = array();
 for ($l=0; $l < count($dataArray) ; $l++) {
 	$data =$dataArray[$l];
				 

					$meq =$med_arr[$data['business_category_id']];

					/* $d->selectRow("users_master.user_id","users_master,user_employment_details,business_categories,business_sub_categories,business_adress_master", "  business_categories.category_status = 0 and  
						business_adress_master.user_id=users_master.user_id AND business_adress_master.adress_type=0 AND business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id  AND user_employment_details.business_category_id='$data[business_category_id]'", "");*/

					$catId = $data["business_category_id"];

					$qq1 = $folow_data_arr[$catId];  //$d->selectRow("category_follow_id","category_follow_master", "category_id = '$catId' AND user_id='$user_id'");

					$dataFollow =$folow_data_arr[$catId];  // mysqli_fetch_array($qq1);

					$category = array();
					$category["business_category_id"] = $data["business_category_id"];
					$category["category_name"] = html_entity_decode($data["category_name"]);

					if (count($qq1) > 0) {
						$category["is_follow"] = true;
						$category["category_follow_id"] = $dataFollow["category_follow_id"];
					} else {
						$category["is_follow"] = false;
						$category["category_follow_id"] = "";
					}

					if ($data["category_images"] != '') {
						$category["category_icon"] = $base_url . "img/category/" . $data["category_images"];
					} else {
						$category["category_icon"] = "";
					}

					if (count($meq) > 0) {
						array_push($response["category"], $category);
					}
				}

				$response["message"] = "get Success.";
				$response["status"] = "200";
				echo json_encode($response);
			} else {
				$response["message"] = "No Data Found.";
				$response["status"] = "201";
				echo json_encode($response);
			}

		} else if ($_POST['getSubCategory'] == "getSubCategory" && filter_var($business_category_id, FILTER_VALIDATE_INT) == true) {

			$response["sub_category"] = array();
			$response["slider"] = array();

			$app_data = $d->selectRow("business_sub_categories.business_sub_category_id,business_sub_categories.business_category_id,business_categories.category_name,business_sub_categories.sub_category_name,business_sub_categories.sub_category_images","business_categories,business_sub_categories", "   business_categories.category_status = 0 and  
				business_sub_categories.business_category_id=business_categories.business_category_id AND business_sub_categories.business_category_id='$business_category_id' AND business_sub_categories.sub_category_status='0'", "ORDER BY business_sub_categories.sub_category_name ASC");

			//code optimize

                $dataArray = array();
                $counter = 0 ;
                foreach ($app_data as  $value) {
                    foreach ($value as $key => $valueNew) {
                        $dataArray[$counter][$key] = $valueNew;
                    }
                    $counter++;
                }
                $business_sub_category_id_array = array('0');
                for ($l=0; $l < count($dataArray) ; $l++) {
                    $business_sub_category_id_array[] = $dataArray[$l]['business_sub_category_id'];
                }
                $business_sub_category_id_array = implode(",", $business_sub_category_id_array);
                
                $meqSub_qry = $d->selectRow("user_employment_details.business_sub_category_id,users_master.user_id","users_master,user_employment_details,business_categories,business_sub_categories,business_adress_master", "  business_categories.category_status = 0 and  
						business_adress_master.user_id=users_master.user_id AND business_adress_master.adress_type=0 AND business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id  AND user_employment_details.business_category_id='$business_category_id' AND user_employment_details.business_sub_category_id in($business_sub_category_id_array) AND users_master.office_member=0 AND users_master.active_status=0   ", "");
                $SArray = array();
                $Scounter = 0 ;
                foreach ($meqSub_qry as  $value) {
                    foreach ($value as $key => $valueNew) {
                        $SArray[$Scounter][$key] = $valueNew;
                    }
                    $Scounter++;
                }
                $sub_arr = array();
                for ($s=0; $s < count($SArray) ; $s++) {
                    $sub_arr[$SArray[$s]['business_sub_category_id']] = $SArray[$s];
                }
              //echo "<pre>";print_r($sub_arr);exit;
//code optimize

			$qnotification = $d->selectRow("slider_id,slider_image,slider_description,slider_url,slider_mobile,slider_video_url,user_id","slider_master", "business_category_id != 0 AND business_category_id = '$business_category_id' and status=0", "order by RAND()");
 

			if (count($dataArray) > 0) {

				$sub_category = array();

				$sub_category["business_sub_category_id"] = "0";
				$sub_category["business_category_id"] = (string)$business_category_id;
				$sub_category["category_name"] = "All";
				$sub_category["sub_category_name"] = "All";
				$sub_category["sub_category_icon"] = $base_url . "img/sub_category/all.png";
                array_push($response["sub_category"], $sub_category);
 
			}

			if (count($dataArray) > 0) {
				for ($l=0; $l < count($dataArray) ; $l++) {
					$data =$dataArray[$l];
		 
					$meqSub =$sub_arr[$data['business_sub_category_id']]; 
					 /*$d->selectRow("users_master.user_id","users_master,user_employment_details,business_categories,business_sub_categories,business_adress_master", "  business_categories.category_status = 0 and  
						business_adress_master.user_id=users_master.user_id AND business_adress_master.adress_type=0 AND business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id  AND user_employment_details.business_category_id='$business_category_id' AND user_employment_details.business_sub_category_id='$data[business_sub_category_id]'", "");*/

					$sub_category = array();
					$sub_category["business_sub_category_id"] = $data["business_sub_category_id"];
					$sub_category["business_category_id"] = $data["business_category_id"];
					$sub_category["category_name"] = html_entity_decode($data["category_name"]);
					$sub_category["sub_category_name"] = html_entity_decode($data["sub_category_name"]);
					if ($data["sub_category_images"] != '') {
						$sub_category["sub_category_icon"] = $base_url . "img/sub_category/" . $data["sub_category_images"];
					} else {
						$sub_category["sub_category_icon"] = "";
					}

					if (count($meqSub) > 0) {
						array_push($response["sub_category"], $sub_category);
					}
				}
				$temp = true;

			}

			if (mysqli_num_rows($qnotification) > 0) {

				while ($data_notification = mysqli_fetch_array($qnotification)) {

			// print_r($data_notification);

					$slider = array();

					$slider["app_slider_id"] = $data_notification['slider_id'];
					$slider["slider_image_name"] = $base_url . "img/sliders/" . $data_notification['slider_image'];
					$slider["slider_description"] = $data_notification['slider_description'];
					$slider["slider_url"] = $data_notification['slider_url'] . '';
					if ($data_notification['slider_mobile'] != 0) {
						$slider["slider_mobile"] = $data_notification['slider_mobile'] . '';
					} else {
						$slider["slider_mobile"] = '';
					}
					$slider["slider_video_url"] = $data_notification['slider_video_url'] . '';
					$slider["user_id"] = $data_notification['user_id'] . '';

					array_push($response["slider"], $slider);
				}

			}

			if ($temp == true || $temp1 == true) {
				$response["message"] = "get Success.";
				$response["status"] = "200";
				echo json_encode($response);
			} else {
				$response["message"] = "No Data Found.";
				$response["status"] = "201";
				echo json_encode($response);
			}

		} else if ($_POST['getSubCategory'] == "getSubCategoryNew" && filter_var($business_category_id, FILTER_VALIDATE_INT) == true) {

			$response["sub_category"] = array();

			$app_data = $d->select("business_categories,business_sub_categories", "  business_categories.category_status = 0 and  
				business_sub_categories.business_category_id=business_categories.business_category_id AND business_sub_categories.business_category_id='$business_category_id' AND business_sub_categories.sub_category_status='0'", "ORDER BY business_sub_categories.sub_category_name ASC");

			if (mysqli_num_rows($app_data) > 0) {

				while ($data = mysqli_fetch_array($app_data)) {

					$sub_category = array();
					$sub_category["business_sub_category_id"] = $data["business_sub_category_id"];
					$sub_category["business_category_id"] = $data["business_category_id"];
					$sub_category["category_name"] = html_entity_decode($data["category_name"]);
					$sub_category["sub_category_name"] = html_entity_decode($data["sub_category_name"]);
					if ($data["sub_category_images"] != '') {
						$sub_category["sub_category_icon"] = $base_url . "img/category/" . $data["sub_category_images"];
					} else {
						$sub_category["sub_category_images"] = "";
					}

					array_push($response["sub_category"], $sub_category);
				}
				$temp = true;

			}

			if ($temp == true || $temp1 == true) {
				$response["message"] = "get Success.";
				$response["status"] = "200";
				echo json_encode($response);
			} else {
				$response["message"] = "No Data Found.";
				$response["status"] = "201";
				echo json_encode($response);
			}

		} 

		/*else if ($_POST['getMembers'] == "getMembers" && filter_var($city_id, FILTER_VALIDATE_INT) == true && filter_var($state_id, FILTER_VALIDATE_INT) == true) {

			

			$app_data = $d->selectRow("city_id,city_name","cities", "city_flag=1", "ORDER BY city_name ASC");
			

			if (mysqli_num_rows($app_data) > 0) {

				$response["city"] = array();

				while ($data = mysqli_fetch_array($app_data)) {

					$city = array();
					$city["city_id"] = $data["city_id"];
					$city["city_name"] = html_entity_decode($data["city_name"]);
					if ($data["city_id"] == $city_id) {
						$city["primary_city"] = true;
					} else {
						$city["category_icon"] = false;
					}

					$city["area"] = array();
					$qs = $d->selectRow("area_id,area_name,pincode,latitude,longitude","area_master", "city_id='$data[city_id]' ", "ORDER BY area_name ASC");

					while ($subData = mysqli_fetch_array($qs)) {
						$area = array();
						$area["area_id"] = $subData["area_id"];
						$area["area_name"] = html_entity_decode($subData["area_name"]);
						if ($subData["pincode"] != 0) {
							$area["area_name_with_pincode"] = html_entity_decode($subData["area_name"]) . ' [' . $subData["pincode"] . ']';
						} else {
							$area["area_name_with_pincode"] = html_entity_decode($subData["area_name"]);

						}
						$area["pincode"] = $subData["pincode"];
						$area["latitude"] = $subData["latitude"];
						$area["longitude"] = $subData["longitude"];

						$area["member"] = array();
						if ($business_sub_category_id == 0) {
							$meq = $d->selectRow("users_master.user_id,business_categories.business_category_id,business_sub_categories.business_sub_category_id,users_master.user_full_name,users_master.zoobiz_id,users_master.public_mobile,users_master.user_mobile,users_master.user_profile_pic,business_categories.category_name,business_sub_categories.sub_category_name,user_employment_details.company_name","users_master,user_employment_details,business_categories,business_sub_categories,business_adress_master", "  business_categories.category_status = 0 and  
								business_adress_master.user_id=users_master.user_id AND business_adress_master.adress_type=0 AND business_adress_master.area_id='$subData[area_id]'  AND business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id  AND user_employment_details.business_category_id='$business_category_id' ", "");
					# code...
						} else {
							$meq = $d->selectRow("users_master.user_id,business_categories.business_category_id,business_sub_categories.business_sub_category_id,users_master.user_full_name,users_master.zoobiz_id,users_master.public_mobile,users_master.user_mobile,users_master.user_profile_pic,business_categories.category_name,business_sub_categories.sub_category_name,user_employment_details.company_name","users_master,user_employment_details,business_categories,business_sub_categories,business_adress_master", "  business_categories.category_status = 0 and  
								business_adress_master.user_id=users_master.user_id AND business_adress_master.adress_type=0 AND business_adress_master.area_id='$subData[area_id]'  AND business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id  AND user_employment_details.business_category_id='$business_category_id' AND user_employment_details.business_sub_category_id='$business_sub_category_id'", "");

						}

						$totalUsers = mysqli_num_rows($meq);

						while ($data_app = mysqli_fetch_array($meq)) {

							$qche = $d->selectRow("follow_id","follow_master", "follow_by='$user_id' AND follow_to='$data_app[user_id]'");
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
							$member["public_mobile"] = $data_app["public_mobile"];
							$member["user_mobile"] = $data_app["user_mobile"];
							$member["user_profile_pic"] = $base_url . "img/users/members_profile/" . $data_app['user_profile_pic'];
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
				$response["message"] = "No Category Found.";
				$response["status"] = "201";
				echo json_encode($response);
			}

		}  */  


		 else if ($_POST['getMembersAll'] == "getMembersAll" && filter_var($user_id, FILTER_VALIDATE_INT) == true) {

			$response["member"] = array();

			$meq = $d->selectRow("users_master.user_id,business_categories.business_category_id,business_sub_categories.business_sub_category_id,users_master.user_full_name,users_master.zoobiz_id,users_master.user_profile_pic,business_categories.category_name,business_sub_categories.sub_category_name,user_employment_details.company_name,user_employment_details.designation,cities.city_name,area_master.area_name,users_master.public_mobile,users_master.user_mobile
				","users_master,user_employment_details,business_categories,business_sub_categories,business_adress_master,cities,area_master", "
				business_categories.category_status = 0 and
				area_master.area_id=business_adress_master.area_id AND cities.city_id=business_adress_master.city_id AND business_adress_master.user_id=users_master.user_id AND business_adress_master.adress_type=0 AND business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id  AND users_master.office_member=0 AND users_master.active_status=0   ", "");


			//code optimize

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
               $qche_qry = $d->selectRow("follow_id,follow_to","follow_master", "follow_by='$user_id' AND follow_to in ($user_id_array)   ");
                 
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
             //   echo "<pre>";print_r($fol_array);exit;
//code optimize


			$totalUsers = count($dataArray);
			if (count($dataArray) > 0) {
				for ($l=0; $l < count($dataArray) ; $l++) {
					$data_app = $dataArray[$l];
				 

					$qche = $fol_array[$data_app[user_id]];// $d->selectRow("follow_id","follow_master", "follow_by='$user_id' AND follow_to='$data_app[user_id]'");
					if (count($qche) > 0) {
						$follow_status = true;
					} else {
						$follow_status = false;
					}

					$member = array();
					$member["user_id"] = $data_app["user_id"];
					$member["zoobiz_id"] = $data_app["zoobiz_id"];
					$member["business_category_id"] = $data_app["business_category_id"];
					$member["business_sub_category_id"] = $data_app["business_sub_category_id"];
					$member["user_full_name"] = $data_app["user_full_name"];
					$member["zoobiz_id"] = $data_app["zoobiz_id"];
					$member["user_profile_pic"] = $base_url . "img/users/members_profile/" . $data_app['user_profile_pic'];

					if($data_app['user_profile_pic'] ==""){
                        $member["user_profile_pic"] ="";
                    } else {
                        $member["user_profile_pic"] = $base_url . "img/users/members_profile/" . $data_app['user_profile_pic'];
                    }


					$member["bussiness_category_name"] = html_entity_decode($data_app["category_name"]);
					$member["sub_category_name"] = html_entity_decode($data_app["sub_category_name"]) . '';
					$member["company_name"] = html_entity_decode($data_app["company_name"]) . '';
					$member["designation"] = html_entity_decode($data_app["designation"]) . '';
					$member["city_name"] = html_entity_decode($data_app["city_name"]) . '';
					$member["area_name"] = html_entity_decode($data_app["area_name"]) . '';
					$member["public_mobile"] = $data_app["public_mobile"];
					$member["user_mobile"] = $data_app["user_mobile"];
					$member["follow_status"] = $follow_status;

					array_push($response["member"], $member);
				}

				$response["message"] = "Member Found.";
				$response["status"] = "200";
				echo json_encode($response);
			} else {
				$response["message"] = "No Member Found.";
				$response["status"] = "201";
				echo json_encode($response);
			}

		} 

 
		       
 




	 
//21dec2020
		else if ($_POST['getAllMembers'] == "getAllMembers" && filter_var($user_id, FILTER_VALIDATE_INT) == true ) {

//recent memmber data start
$user_recent_master_qry = $d->selectRow("users_master.user_id,business_categories.business_category_id,business_sub_categories.business_sub_category_id,users_master.user_full_name,users_master.zoobiz_id,users_master.public_mobile,users_master.user_mobile,users_master.user_profile_pic,business_categories.category_name,business_sub_categories.sub_category_name,user_employment_details.company_name, user_employment_details.company_logo   ,user_recent_master.id,user_recent_master.member_id,user_recent_master.user_id,user_recent_master.flag,user_employment_details.company_name,user_employment_details.company_logo, users_master.user_full_name, users_master.user_profile_pic","user_recent_master,users_master,user_employment_details, business_categories,business_sub_categories",
				"user_employment_details.user_id=user_recent_master.member_id and  business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND users_master.office_member=0 AND users_master.active_status=0  AND  users_master.user_id =user_recent_master.member_id and   user_recent_master.user_id ='$user_id' and   user_recent_master.member_id != $user_id ", " GROUP by user_recent_master.user_id, user_recent_master.member_id, user_recent_master.flag       order by user_recent_master.id desc limit 0,4 ");


 

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

$response["recentMember"] = array();
       if(mysqli_num_rows($user_recent_master_qry) > 0){
				 	

				 
				 while ($user_recent_master_data = mysqli_fetch_array($user_recent_master_qry)) {
				 	$recentMember = array();



				 	$recentMember["user_id"] = $user_recent_master_data["member_id"];
					$recentMember["user_name"] = html_entity_decode($user_recent_master_data["user_full_name"]);
					$recentMember["company_name"] = html_entity_decode($user_recent_master_data["company_name"]);
					$recentMember["category_name"] = html_entity_decode($user_recent_master_data["category_name"]);
					$recentMember["sub_category_name"] = html_entity_decode($user_recent_master_data["sub_category_name"]);
					$recentMember["designation"] = html_entity_decode($user_recent_master_data["designation"]);
					if($user_recent_master_data['user_profile_pic'] !=""){
						$recentMember["user_profile_pic"] = $base_url . "img/users/members_profile/" . $user_recent_master_data['user_profile_pic'];
					} else {
						$recentMember["user_profile_pic"] ="";
					}
					
					if($user_recent_master_data['company_logo'] !=""){
						$recentMember["company_logo"] = $base_url . "img/users/company_logo/" . $user_recent_master_data['company_logo'];
					} else {
						$recentMember["company_logo"] ="";
					}

					 

if($user_recent_master_data['flag']==0){
				    		$recentMember["type"] = "0";
				    	} else {
				    		$recentMember["type"] = "1";
				    	}


					/*if(in_array($user_recent_master_data['member_id'], $user_favorite_master_array_company)){
						$recentMember["is_fevorite"] = "1";
					}else {
						$recentMember["is_fevorite"] = "0";
					}*/


if($user_recent_master_data['flag']==0){
					    	if(in_array($user_recent_master_data['member_id'], $user_favorite_master_array_user)){
								$recentMember["is_fevorite"] = "1";
							}else {
								$recentMember["is_fevorite"] = "0";
							}
						} else {
							if(in_array($user_recent_master_data['member_id'], $user_favorite_master_array_company)){
								$recentMember["is_fevorite"] = "1";
							}else {
								$recentMember["is_fevorite"] = "0";
							}
						}



				   


                    array_push($response["recentMember"], $recentMember);
				}
}
//recent memmber data end
 
			$meq = $d->selectRow("users_master.user_id,business_categories.business_category_id,business_sub_categories.business_sub_category_id,users_master.user_full_name,users_master.user_first_name,users_master.user_last_name,users_master.zoobiz_id,users_master.public_mobile,users_master.user_mobile,users_master.user_profile_pic,business_categories.category_name,business_sub_categories.sub_category_name,user_employment_details.company_name, user_employment_details.company_logo, user_employment_details.search_keyword",
				
				"users_master,user_employment_details,business_categories,business_sub_categories", 
				"     business_categories.category_status = 0 and  
				business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id  and   users_master.user_id != $user_id AND users_master.office_member=0 AND users_master.active_status=0   ", ""); 

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
				
				$response["AllMembers"] = array();
				while ($data = mysqli_fetch_array($meq)) {
					$member  = array();

					$company  = array();
$member["short_name"] =strtoupper(substr($data["user_first_name"], 0, 1).substr($data["user_last_name"], 0, 1) );
$member["search_keyword"] = html_entity_decode($data["search_keyword"]);
					$member["user_id"] = $data["user_id"];
					$member["user_name"] = html_entity_decode($data["user_full_name"]);
					$member["company_name"] = html_entity_decode($data["company_name"]);
					$member["category_name"] = html_entity_decode($data["category_name"]);
					$member["sub_category_name"] = html_entity_decode($data["sub_category_name"]);
					$member["designation"] = html_entity_decode($data["designation"]);
					if($data['user_profile_pic'] !=""){
						$member["user_profile_pic"] = $base_url . "img/users/members_profile/" . $data['user_profile_pic'];
					} else {
						$member["user_profile_pic"] ="";
					}
					
					if($data['company_logo'] !=""){
						$member["company_logo"] = $base_url . "img/users/company_logo/" . $data['company_logo'];
					} else {
						$member["company_logo"] ="";
					}

					$member["type"] = "0";

					if(in_array($data['user_id'], $user_favorite_master_array_user)){
						$member["is_fevorite"] = "1";
					}else {
						$member["is_fevorite"] = "0";
					}

					array_push($response["AllMembers"], $member);

$company["short_name"] =strtoupper(substr($data["user_first_name"], 0, 1).substr($data["user_last_name"], 0, 1) );
$company["search_keyword"] = html_entity_decode($data["search_keyword"]);
					
					$company["user_id"] = $data["user_id"];
					$company["user_name"] = html_entity_decode($data["user_full_name"]);
					$company["company_name"] = html_entity_decode($data["company_name"]);
					$company["category_name"] = html_entity_decode($data["category_name"]);
					$company["sub_category_name"] = html_entity_decode($data["sub_category_name"]);
					$company["designation"] = html_entity_decode($data["designation"]);
					if($data['user_profile_pic'] !=""){
						$company["user_profile_pic"] = $base_url . "img/users/members_profile/" . $data['user_profile_pic'];
					} else {
						$company["user_profile_pic"] ="";
					}
					
					if($data['company_logo'] !=""){
						$company["company_logo"] = $base_url . "img/users/company_logo/" . $data['company_logo'];
					} else {
						$company["company_logo"] ="";
					}

					$company["type"] = "1";

					if(in_array($data['user_id'], $user_favorite_master_array_company)){
						$company["is_fevorite"] = "1";
					}else {
						$company["is_fevorite"] = "0";
					}
					array_push($response["AllMembers"], $company);		
				}
 
		shuffle($response["AllMembers"]);
		
		$response["message"] = "get Success.";
		$response["status"] = "200";
		echo json_encode($response);

	}
	else {
		$response["message"] = "No Data Found.";
		$response["status"] = "201";
		echo json_encode($response);
	}
	
}


//3feb21
else if ($_POST['getAllMembersWithoutCompany'] == "getAllMembersWithoutCompany" && filter_var($user_id, FILTER_VALIDATE_INT) == true ) {

//recent memmber data start
$user_recent_master_qry = $d->selectRow("users_master.user_id,business_categories.business_category_id,business_sub_categories.business_sub_category_id,users_master.user_full_name, users_master.user_first_name,users_master.user_last_name, users_master.zoobiz_id,users_master.public_mobile,users_master.user_mobile,users_master.user_profile_pic,business_categories.category_name,business_sub_categories.sub_category_name,user_employment_details.company_name, user_employment_details.company_logo   ,user_recent_master.id,user_recent_master.member_id,user_recent_master.user_id,user_recent_master.flag,user_employment_details.company_name,user_employment_details.company_logo, users_master.user_full_name, users_master.user_profile_pic","user_recent_master,users_master,user_employment_details, business_categories,business_sub_categories",
				"user_employment_details.user_id=user_recent_master.member_id and  business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND users_master.office_member=0 AND users_master.active_status=0  AND  users_master.user_id =user_recent_master.member_id and   user_recent_master.user_id ='$user_id' and   user_recent_master.member_id != $user_id ", " GROUP by user_recent_master.user_id, user_recent_master.member_id, user_recent_master.flag       order by user_recent_master.id desc limit 0,4 ");


 

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

$response["recentMember"] = array();
       if(mysqli_num_rows($user_recent_master_qry) > 0){
				 	

				 
				 while ($user_recent_master_data = mysqli_fetch_array($user_recent_master_qry)) {
				 	$recentMember = array();
 
 

$recentMember["short_name"] = strtoupper(substr($user_recent_master_data["user_first_name"], 0, 1).substr($user_recent_master_data["user_last_name"], 0, 1));
				 	$recentMember["user_id"] = $user_recent_master_data["member_id"];
					$recentMember["user_name"] = html_entity_decode($user_recent_master_data["user_full_name"]);
					$recentMember["company_name"] = html_entity_decode($user_recent_master_data["company_name"]);
					$recentMember["category_name"] = html_entity_decode($user_recent_master_data["category_name"]);
					$recentMember["sub_category_name"] = html_entity_decode($user_recent_master_data["sub_category_name"]);
					$recentMember["designation"] = html_entity_decode($user_recent_master_data["designation"]);
					if($user_recent_master_data['user_profile_pic'] !=""){
						$recentMember["user_profile_pic"] = $base_url . "img/users/members_profile/" . $user_recent_master_data['user_profile_pic'];
					} else {
						$recentMember["user_profile_pic"] ="";
					}
					
					if($user_recent_master_data['company_logo'] !=""){
						$recentMember["company_logo"] = $base_url . "img/users/company_logo/" . $user_recent_master_data['company_logo'];
					} else {
						$recentMember["company_logo"] ="";
					}

					 

if($user_recent_master_data['flag']==0){
				    		$recentMember["type"] = "0";
				    	} else {
				    		$recentMember["type"] = "1";
				    	}


					/*if(in_array($user_recent_master_data['member_id'], $user_favorite_master_array_company)){
						$recentMember["is_fevorite"] = "1";
					}else {
						$recentMember["is_fevorite"] = "0";
					}*/


if($user_recent_master_data['flag']==0){
					    	if(in_array($user_recent_master_data['member_id'], $user_favorite_master_array_user)){
								$recentMember["is_fevorite"] = "1";
							}else {
								$recentMember["is_fevorite"] = "0";
							}
						} else {
							if(in_array($user_recent_master_data['member_id'], $user_favorite_master_array_company)){
								$recentMember["is_fevorite"] = "1";
							}else {
								$recentMember["is_fevorite"] = "0";
							}
						}



				   


                    array_push($response["recentMember"], $recentMember);
				}
}
//recent memmber data end
	
 $zoobiz_settings_master_qry = $d->select("zoobiz_settings_master","","");
$zoobiz_settings_master_data=mysqli_fetch_array($zoobiz_settings_master_qry);


	$where = "";
	if($zoobiz_settings_master_data['show_member_citywise'] ==1){
			if(isset($city_id) && $city_id != 0 ){
				$where = " and users_master.city_id = '$city_id' ";		
			}
	}		
 

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

             
			$meq = $d->selectRow("users_master.user_id,business_categories.business_category_id,business_sub_categories.business_sub_category_id,users_master.user_full_name ,users_master.user_first_name,users_master.user_last_name ,users_master.zoobiz_id,users_master.public_mobile,users_master.user_mobile,users_master.user_profile_pic,business_categories.category_name,business_sub_categories.sub_category_name,user_employment_details.company_name, user_employment_details.company_logo, user_employment_details.search_keyword",
				
				"users_master,user_employment_details,business_categories,business_sub_categories", 
				"     business_categories.category_status = 0 and  
				business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id  and   users_master.user_id != $user_id AND users_master.office_member=0 AND users_master.active_status=0  $where  ", ""); 
       
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


			$qche_qry = $d->selectRow("follow_id,follow_to","follow_master", "follow_by='$user_id'    ");
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


			
			
			if (mysqli_num_rows($meq) > 0) {
				
				$response["AllMembers"] = array();
				while ($data = mysqli_fetch_array($meq)) {
					$member  = array();

					 	$qche = $fol_array[$data["user_id"]];//  
					if (count($qche) > 0) {
						$follow_status = true;
					} else {
						$follow_status = false;
					}
//$member["qry"] = $where;
					$member["is_follow"] = $follow_status;


					if(in_array($data["user_id"],$blocked_users)){
						$member["is_blocked"] =true;
					} else {
						$member["is_blocked"] =false;
					}
$member["short_name"] =strtoupper(substr($data["user_first_name"], 0, 1).substr($data["user_last_name"], 0, 1) );
					$member["user_id"] = $data["user_id"];
					$member["user_name"] = html_entity_decode($data["user_full_name"]);
					$member["company_name"] = html_entity_decode($data["company_name"]);
					$member["category_name"] = html_entity_decode($data["category_name"]);
					$member["sub_category_name"] = html_entity_decode($data["sub_category_name"]);
					$member["designation"] = html_entity_decode($data["designation"]);
					if($data['user_profile_pic'] !=""){
						$member["user_profile_pic"] = $base_url . "img/users/members_profile/" . $data['user_profile_pic'];
					} else {
						$member["user_profile_pic"] ="";
					}
					
					if($data['company_logo'] !=""){
						$member["company_logo"] = $base_url . "img/users/company_logo/" . $data['company_logo'];
					} else {
						$member["company_logo"] ="";
					}
					$member["search_keyword"] = html_entity_decode($data["search_keyword"]);
					
					$member["type"] = "0";


if($data['public_mobile'] =="0"){
						$member["mobile_privacy"]=true;
					} else {
						$member["mobile_privacy"]=false;
					}

					
					if(in_array($data['user_id'], $user_favorite_master_array_user)){
						$member["is_fevorite"] = "1";
					}else {
						$member["is_fevorite"] = "0";
					}

					array_push($response["AllMembers"], $member);
 
				}
 
		shuffle($response["AllMembers"]);
		
		$response["message"] = "get Success.";
		$response["status"] = "200";
		echo json_encode($response);

	}
	else {
		$response["message"] = "No Data Found.";
		$response["status"] = "201";
		echo json_encode($response);
	}
	
}
//3feb21
 
else if ($_POST['getUserTag'] == "getUserTag" && filter_var($user_id, FILTER_VALIDATE_INT) == true ) {

	$where_cond="";
if ($city_id != 0) {
				$where_cond .= "AND users_master.city_id ='$city_id'";
			}
	$meq = $d->selectRow("users_master.user_id,business_categories.business_category_id,business_sub_categories.business_sub_category_id,business_categories.category_name,business_sub_categories.sub_category_name,user_employment_details.search_keyword, user_employment_details.company_logo,user_employment_details.designation",
		
		"users_master,user_employment_details,business_categories,business_sub_categories", 

		" user_employment_details.search_keyword !='' and  business_categories.category_status = 0 and  
		business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id AND  users_master.user_id  !='$user_id' AND users_master.office_member=0 AND users_master.active_status=0  $where_cond   ", "");

	 
	

	if (mysqli_num_rows($meq) > 0) {
		
		$response["tagWiseUsers"] = array();
		//$response["tagWiseUsers2"] = array();
		$tagWiseUsers = array();
		$tagWiseUsers2 = array();
		$counter= 0;

			 $member  = array();
			 $member["user_id"] = "0";
	         $member["search_keyword"] = "All";
	         $member["category_id"] ="0-0";
	         $member["business_category_id"] ="0";
	         $member["business_sub_category_id"] ="0";
	         $member["category_name"] ="All";
	          $tagWiseUsers[] = $member;
	      //   array_push($response["tagWiseUsers"], $member);
$arr_key= array();

$tag_array = array();
		while ($data = mysqli_fetch_array($meq)) {
			


			$search_key_array = $data["search_keyword"];
			$search_key_array = explode(",", $search_key_array);

			for ($g=0; $g < count($search_key_array) ; $g++) { 

				if($search_key_array[$g]!="" && !in_array(trim(strtolower($search_key_array[$g])), $arr_key)){
					$arr_key[] = trim(strtolower($search_key_array[$g]));
					$member  = array();
					 $member["user_id"] = $data["user_id"];
			         $member["search_keyword"] = trim(html_entity_decode($search_key_array[$g])) ;
			         $member["category_id"] =$data["business_category_id"]."-".$data["business_sub_category_id"];
			         $member["business_category_id"] =$data["business_category_id"];
			         $member["business_sub_category_id"] =$data["business_sub_category_id"];
			         $member["category_name"] =$data["category_name"]."-".$data["sub_category_name"];
			         $counter++;
			        // array_push($response["tagWiseUsers2"], $member);
			         $tagWiseUsers2[] = $member;
				}
				
			}

			 shuffle($tagWiseUsers2);

			
		}
$final_arr =  array_merge($tagWiseUsers,$tagWiseUsers2) ;

 //array_push($response["tagWiseUsers"], $final_arr);
 		$response["tagWiseUsers"] = $final_arr;
 		$response["count"] =$counter;
		$response["message"] = "User With Tag Found.";
		$response["status"] = "200";
		echo json_encode($response);

	}
	else {
		$response["message"] = "No Users With Tag Found.";
		$response["status"] = "201";
		echo json_encode($response);
	}
	
}

 else if ($_POST['blockUser'] == "blockUser" && filter_var($user_id, FILTER_VALIDATE_INT) == true && filter_var($my_id, FILTER_VALIDATE_INT) == true) {

			if ($user_id == $my_id) {
				$response["message"] = "You Can't";
				$response["status"] = "201";
				echo json_encode($response);
				exit();
			}

			$m->set_data('user_id', $user_id);
			$m->set_data('my_id', $my_id);

			$a = array('user_id' => $m->get_data('user_id'),
				'block_by' => $m->get_data('my_id'),
			);


			//23dec2020
			$users_master_q=$d->selectRow("user_full_name","users_master","user_id ='$user_id'");
			 $users_master_data = mysqli_fetch_array($users_master_q);
			//23dec2020
			$qch = $d->selectRow("user_block_id", "user_block_master", "user_id='$user_id' AND block_by='$my_id' ");
			if (mysqli_num_rows($qch) > 0) {
				$q = $d->update("user_block_master", $a, "user_id='$user_id' AND my_id='$my_id' ");
			} else {
				
				$q = $d->insert("user_block_master", $a);
			}

			if ($q == true) {
				$d->insert_myactivity($my_id,"0","", "You blocked ".$users_master_data['user_full_name'],"activity.png");
				$d->insert_myactivity($my_id,"0","", $users_master_data['user_full_name']."Not Following you anymore.","activity.png");
				$d->delete("follow_master", "follow_to='$my_id' AND follow_by='$user_id'");
				$d->delete("user_favorite_master", " member_id='$user_id'");

				$response["message"] = "User Blocked ";
				$response["status"] = "200";
				echo json_encode($response);
			} else {
				$response["message"] = "Something Wrong";
				$response["status"] = "201";
				echo json_encode($response);
			}
		}

  else if ($_POST['blockUnUser'] == "blockUnUser" && filter_var($user_id, FILTER_VALIDATE_INT) == true && filter_var($my_id, FILTER_VALIDATE_INT) == true) {

			$q = $d->delete("user_block_master", "user_id='$user_id' AND block_by='$my_id' ");

			if ($q == true) {

				  




			$users_master_q=$d->selectRow("user_full_name","users_master","user_id ='$user_id'");
			 $users_master_data = mysqli_fetch_array($users_master_q);
			 

				$d->insert_myactivity($my_id,"0","", "You Unblocked ".$users_master_data['user_full_name'],"activity.png");
				$response["message"] = "User Unblocked";
				$response["status"] = "200";
				echo json_encode($response);
			} else {
				$response["message"] = "Something Wrong";
				$response["status"] = "201";
				echo json_encode($response);
			}
		} else if ($_POST['getMyBlockedMember'] == "getMyBlockedMember" && filter_var($user_id, FILTER_VALIDATE_INT) == true) {

			$app_data = $d->selectRow("user_block_master.user_id,users_master.salutation,users_master.user_full_name,users_master.user_profile_pic,business_categories.category_name,business_sub_categories.sub_category_name,user_employment_details.company_name","users_master,user_block_master,user_employment_details,business_categories,business_sub_categories", "business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id AND user_block_master.user_id= users_master.user_id AND user_block_master.block_by='$user_id' AND users_master.office_member=0 AND users_master.active_status=0  ", "ORDER BY user_block_master.user_block_id ASC");


			//code optimize

                $dataArray = array();
                $counter = 0 ;
                foreach ($app_data as  $value) {
                    foreach ($value as $key => $valueNew) {
                        $dataArray[$counter][$key] = $valueNew;
                    }
                    $counter++;
                }
                $blk_user_id_array = array('0');
                for ($l=0; $l < count($dataArray) ; $l++) {
                    $blk_user_id_array[] = $dataArray[$l]['user_id'];
                }
                $blk_user_id_array = implode(",", $blk_user_id_array);
                 
                $tq22_qry = $d->selectRow("follow_master.follow_id,follow_master.follow_to","users_master,follow_master,user_employment_details,business_categories,business_sub_categories", "business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id AND follow_master.follow_by=users_master.user_id AND follow_master.follow_to in ($blk_user_id_array) AND users_master.office_member=0 AND users_master.active_status=0     ", "ORDER BY users_master.user_full_name ASC");

                $FArray = array();
                $Fcounter = 0 ;
                foreach ($tq22_qry as  $value) {
                    foreach ($value as $key => $valueNew) {
                        $FArray[$Fcounter][$key] = $valueNew;
                    }
                    $Fcounter++;
                }
                $f_array = array();
                for ($l=0; $l < count($FArray) ; $l++) {
                    $f_array[$FArray[$l]['follow_to']][] = $FArray[$l];
                }

                $tq33_qry = $d->selectRow("follow_master.follow_id,follow_master.follow_by","users_master,follow_master,user_employment_details,business_categories,business_sub_categories", "business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id AND follow_master.follow_to=users_master.user_id AND follow_master.follow_by in ($blk_user_id_array) AND users_master.office_member=0 AND users_master.active_status=0   ", "ORDER BY users_master.user_full_name ASC");

                $F1Array = array();
                $F1counter = 0 ;
                foreach ($tq33_qry as  $value) {
                    foreach ($value as $key => $valueNew) {
                        $F1Array[$F1counter][$key] = $valueNew;
                    }
                    $F1counter++;
                }
                $f1_array = array();
                for ($l=0; $l < count($F1Array) ; $l++) {
                    $f1_array[$F1Array[$l]['follow_by']][] = $F1Array[$l];
                }

                $qche_qry = $d->selectRow("follow_id,follow_to","follow_master", "follow_by='$user_id' AND follow_to in ($blk_user_id_array)");
                $F2Array = array();
                $F2counter = 0 ;
                foreach ($qche_qry as  $value) {
                    foreach ($value as $key => $valueNew) {
                        $F2Array[$F2counter][$key] = $valueNew;
                    }
                    $F2counter++;
                }
                $f2_array = array();
                for ($l=0; $l < count($F2Array) ; $l++) {
                    $f2_array[$F2Array[$l]['follow_to']][] = $F2Array[$l];
                }
               // echo "<pre>";print_r($f_array);exit;
//code optimize


			if (count($dataArray) > 0) {

				$response["member"] = array();
  for ($l=0; $l < count($dataArray) ; $l++) {
  	$data_app =$dataArray[$l];
				 
					
					$total_post = mysqli_num_rows($tq11);

					$tq22 =$f_array[$data_app[user_id]];  
					$followers = count($tq22);

					$tq33 = $f1_array[$data_app[user_id]]; 
					$following = count($tq33);

					$qche =$f2_array[$data_app[user_id]]; /*$d->select("follow_master", "follow_by='$user_id' AND follow_to='$data_app[user_id]'");*/
					if (count($qche) > 0) {
						$follow_status = true;
					} else {
						$follow_status = false;
					}

					$member = array();
					$member["user_id"] = $data_app["user_id"];
					$member["user_full_name"] = $data_app["salutation"] . ' ' . $data_app["user_full_name"];
					$member["user_profile_pic"] = $base_url . "img/users/members_profile/" . $data_app['user_profile_pic'];

					if($data_app['user_profile_pic'] ==""){
                        $member["user_profile_pic"] ="";
                    } else {
                        $member["user_profile_pic"] =$base_url . "img/users/members_profile/" . $data_app['user_profile_pic'];
                    }

                    
					$member["total_post"] = $total_post . '';
					$member["followers"] = $followers . '';
					$member["following"] = $following . '';
					$member["follow_status"] = $follow_status;
					$member["bussiness_category_name"] = html_entity_decode($data_app["category_name"]);
					$member["sub_category_name"] = html_entity_decode($data_app["sub_category_name"]) . '';
					$member["company_name"] = html_entity_decode($data_app["company_name"]) . '';

					array_push($response["member"], $member);
				}

				$response["message"] = "Block List";
				$response["status"] = "200";
				echo json_encode($response);
			} else {
				$response["message"] = "No Blocked Member Found";
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