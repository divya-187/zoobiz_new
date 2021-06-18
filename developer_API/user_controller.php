<?php
include_once 'lib.php';

if (isset($_POST) && !empty($_POST)) {

	if ($key == $keydb) {


		 
		$response = array();
		extract(array_map("test_input", $_POST));
		$today = date('Y-m-d');
		if (isset($getProfile) && $getProfile == 'getProfile' && filter_var($user_id, FILTER_VALIDATE_INT) == true) {

			$qch11 = $d->selectRow("user_id","user_block_master", "user_id='$my_id' AND block_by='$user_id' ");
			if (mysqli_num_rows($qch11) > 0) {
				$response["message"] = "You Are Blocked";
				$response["status"] = "202";
				echo json_encode($response);
				exit();
			}

			$qq = $d->select("user_employment_details,business_categories,business_sub_categories,users_master", "users_master.user_id='$user_id'  AND business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id  ", "");
			$userData = mysqli_fetch_array($qq);

//get member added details
			if (mysqli_num_rows($qq) > 0) {


				$qche = $d->select("follow_master", "follow_by='$my_id' AND follow_to='$user_id'");
				if (mysqli_num_rows($qche) > 0) {
					$follow_status = true;
				} else {
					$follow_status = false;
				}


				
			$user_mobile_new = $userData['user_mobile'];
			//$q = $d->select("users_master", "user_mobile ='$user_mobile_new' ");
 
			 $memberAdded=$d->count_data_direct("user_mobile"," users_master  "," refere_by_phone_number ='$user_mobile_new'");
			 if($memberAdded > 0 ){ 
			 	 
			 $response["memberAdded"] =  $memberAdded ;
 
			 //details start
			   // $q6=$d->select("company_master,users_master","company_master.company_id =  users_master.company_id  and    users_master.active_status= 0  and users_master.refer_by!= 0 and   users_master.refere_by_phone_number  = '$user_mobile_new'  ","");
	 $q6=$d->select("users_master","refere_by_phone_number  = '$user_mobile_new'  ","");
			    $user_id_array = array('0');
                 while ($data3=mysqli_fetch_array($q6)) {
                  $user_id_array[] = $data3['user_id'];
                 }
                  $user_id_array = implode(",", $user_id_array);
 
                /* $q3= $d->select("company_master,users_master","company_master.company_id =  users_master.company_id  and    users_master.active_status= 0  and users_master.refer_by!= 0  and   users_master.refere_by_phone_number  = '$user_mobile_new'  ","");*/
 
                  $q3= $d->select("users_master","refere_by_phone_number  = '$user_mobile_new'  ","");
$response["member_added_details"] = array();
                 while ($data=mysqli_fetch_array($q3)) {
		                extract($data);
                $member_added_details = array();
			//	$member_added_details["company_name"] = $company_name;
				$member_added_details["user_full_name"] = $salutation.' '.$user_full_name;
				 
				if($refer_by=="1") {
					$member_added_details["refer_by"] = "Social Media";} 
                  else if($refer_by=="2") {$member_added_details["refer_by"]=  "Member / Friend";}
                  else if($refer_by=="3") {$member_added_details["refer_by"] =  "Other";}

                  $member_added_details["refere_by_name"] = $refere_by_name;
                  $member_added_details["refere_by_phone_number"] = $refere_by_phone_number;
                  $member_added_details["remark"] = $remark;
                  $member_added_details["register_date"] = date("d-m-Y h:i:s A",strtotime($register_date));
                  $member_added_details["refere_by_name"] = $refere_by_name;
//echo "<pre>";print_r($member_added_details);exit;
				array_push($response["member_added_details"], $member_added_details);

		            }
		        } else {
		        	$response["member_added_details"] = array();
		        	$response["memberAdded"] ="0";
		        }
		    //get member added details
			

				$qch22 = $d->select("user_block_master", "user_id='$user_id' AND block_by='$my_id' ");
				if (mysqli_num_rows($qch22) > 0) {
					$block_status = true;
				} else {
					$block_status = false;
				}

				

				$response["user_id"] = $userData["user_id"];
				$response["user_full_name"] = $userData["user_full_name"];
				$response["user_first_name"] = $userData['user_first_name'];
				$response["user_last_name"] = $userData['user_last_name'];
				$response["gender"] = $userData['gender'];

				//12nov
				$userData['member_date_of_birth'] = str_replace("/", "-",$userData['member_date_of_birth']);
				//12nov

				
				$response["member_date_of_birth"] = $userData['member_date_of_birth'];
				if ($userData["public_mobile"] == 0) {
					//3nov 2020
					/*$response["user_mobile"] = "" . substr($userData['user_mobile'], 0, 3) . '****' . substr($userData['user_mobile'], -3);*/
					$response["user_mobile"] = "*Private";
				} else {
					if ($userData["user_mobile"] != 0) {
						$response["user_mobile"] = $userData["user_mobile"];
					} else {
						$response["user_mobile"] = "";
					}
				}
				if ($userData["whatsapp_privacy"] == 1 && $userData["whatsapp_number"] != 0) {
					//3nov 2020
					/*$response["whatsapp_number"] = "" . substr($userData['whatsapp_number'], 0, 3) . '****' . substr($userData['whatsapp_number'], -3);*/
					$response["whatsapp_number"] = "*Private";
					$response["whatsapp_number_click"] = "";
				} else {
					if ($userData["whatsapp_number"] != 0) {
						$response["whatsapp_number"] = $userData["whatsapp_number"];
					} else {
						$response["whatsapp_number"] = "Not Available";
					}
					$response["whatsapp_number_click"] = $userData["country_code"] . $userData["whatsapp_number"];
				}
				$response["zoobiz_id"] = $userData["zoobiz_id"];
				$response["plan_renewal_date"] = date("d M Y", strtotime($userData['plan_renewal_date']));

				if ($userData["email_privacy"] == 1) {
					if ($userData["user_email"] != '') {
						$response["user_email"] = 'Email id is private';
					} else {
						$response["user_email"] = 'Not Available';
					}
				} else {
					if ($userData["user_email"] != '') {
						$response["user_email"] = html_entity_decode($userData["user_email"]);
					} else {
						$response["user_email"] = 'Not Available';
					}
				}

				if ($userData["alt_mobile"] != 0 && $userData["public_mobile"] == 0) {
					//3nov 2020
					/*$response["alt_mobile"] = "" . substr($userData['alt_mobile'], 0, 3) . '****' . substr($userData['alt_mobile'], -3);*/
					$response["alt_mobile"] = "*Private";
				} else if ($userData["alt_mobile"] != 0) {
					$response["alt_mobile"] = $userData["alt_mobile"];
				} else {
					$response["alt_mobile"] = "Not Available";
				}
				$response["public_mobile"] = $userData["public_mobile"];
				$response["whatsapp_privacy"] = $userData["whatsapp_privacy"];
				$response["email_privacy"] = $userData["email_privacy"];
				$response["facebook"] = $userData["facebook"];
				$response["instagram"] = $userData["instagram"];
				$response["linkedin"] = $userData["linkedin"];
				$response["twitter"] = $userData["twitter"];
				$response["user_profile_pic"] = $base_url . "img/users/members_profile/" . $userData['user_profile_pic'];
				$response["follow_status"] = $follow_status;
				$response["block_status"] = $block_status;
				$response["business_description"] = html_entity_decode($userData["business_description"]);
				$response["bussiness_category_name"] = html_entity_decode($userData["category_name"]);
				$response["sub_category_name"] = html_entity_decode($userData["sub_category_name"]) . '';
				$response["company_name"] = html_entity_decode($userData["company_name"]) . '';
				$response["designation"] = html_entity_decode($userData["designation"]) . '';
				if ($userData["public_mobile"] == 0) {
					//3nov 2020
					/*$response["company_contact_number"] = "" . substr($userData['company_contact_number'], 0, 3) . '****' . substr($userData['company_contact_number'], -3);*/
					$response["company_contact_number"] = "*Private";
				} else if ($userData["company_contact_number"] != 0) {
					$response["company_contact_number"] = $userData["company_contact_number"];
				} else {
					$response["company_contact_number"] = "Not Available";
				}
				// $response["company_contact_number"]=html_entity_decode($userData["company_contact_number"]).'';

				if ($userData["email_privacy"] == 1) {
					if ($userData["company_email"] != '') {
						$response["company_email"] = 'Email id is private';
					} else {
						$response["company_email"] = 'Not Available';
					}
				} else {
					if ($userData["company_email"] != '') {
						$response["company_email"] = html_entity_decode($userData["company_email"]) . '';
					} else {
						$response["company_email"] = 'Not Available';
					}
				}

				if ($userData['company_logo'] != '') {
					$response["company_logo"] = $base_url . "img/users/company_logo/" . $userData['company_logo'];
				} else {
					$response["company_logo"] = "";
				}
				$response["company_logo_name"] = $userData['company_logo'];
				if ($userData['company_broucher'] != '') {
					$response["company_broucher"] = $base_url . "img/users/company_broucher/" . $userData['company_broucher'];
				} else {
					$response["company_broucher"] = "";
				}
				$response["company_broucher_name"] = $userData['company_broucher'];
				if ($userData['company_profile'] != '') {
					$response["company_profile"] = $base_url . "img/users/comapany_profile/" . $userData['company_profile'];
				} else {
					$response["company_profile"] = "";
				}
				$response["compny_profile_name"] = $userData['company_profile'];
				$response["products_servicess"] = html_entity_decode($userData['products_servicess']);
				$response["billing_address"] = html_entity_decode($userData['billing_address']);
				$response["gst_number"] = html_entity_decode($userData['gst_number']);
				$response["billing_pincode"] = html_entity_decode($userData['billing_pincode']);
				$response["bank_name"] = html_entity_decode($userData['bank_name']);
				$response["ifsc_code"] = html_entity_decode($userData['ifsc_code']);
				$response["billing_contact_person"] = html_entity_decode($userData['billing_contact_person']);
				$response["billing_contact_person_name"] = html_entity_decode($userData['billing_contact_person_name']);

				$qA2 = $d->select("area_master,business_adress_master,cities,states,countries", "business_adress_master.user_id='$user_id'
                AND
                business_adress_master.country_id = countries.country_id
                AND
                business_adress_master.state_id = states.state_id
                AND
                business_adress_master.city_id = cities.city_id
                AND
                business_adress_master.area_id = area_master.area_id", "ORDER BY business_adress_master.adress_type ASC");

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
					$company_address["country_id"] = $data_app["country_id"];
					$company_address["state_id"] = $data_app["state_id"];
					$company_address["city_id"] = $data_app["city_id"];
					$company_address["area_id"] = $data_app["area_id"];
					$company_address["area_name"] = $data_app["area_name"];
					$company_address["adress"] = $data_app["adress"];
					array_push($response["company_address"], $company_address);

				}
//here
				$response["message"] = "Member Details Found";
				$response["status"] = "200";
				echo json_encode($response);

			} else {
				$response["message"] = "No Member Found";
				$response["status"] = "201";
				echo json_encode($response);
			}

		} else if (isset($getProfileIos) && $getProfileIos == 'getProfileIos' && filter_var($user_id, FILTER_VALIDATE_INT) == true) {

			$qq = $d->select("users_master,user_employment_details,business_categories,business_sub_categories,business_adress_master", "business_adress_master.user_id=users_master.user_id AND business_adress_master.adress_type=0 AND users_master.user_id='$user_id'  AND business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id  ", "");
			$user_data = mysqli_fetch_array($qq);

			if (mysqli_num_rows($qq) > 0) {
				$qA2 = $d->select("business_adress_master,cities,states,countries,area_master", "business_adress_master.user_id='$user_data[user_id]'
		                AND
		                business_adress_master.country_id = countries.country_id
		                AND
		                business_adress_master.state_id = states.state_id
		                AND
		                business_adress_master.city_id = cities.city_id
		                AND
		                business_adress_master.area_id = area_master.area_id AND business_adress_master.adress_type=0", "");
				$addData = mysqli_fetch_array($qA2);

				$response["zoobiz_id"] = $user_data['zoobiz_id'];

				$response["user_id"] = $user_id;

				$response["plan_renewal_date"] = date("d M Y", strtotime($user_data['plan_renewal_date']));

				$response["facebook"] = $user_data['facebook'];
				$response["instagram"] = $user_data['instagram'];
				$response["linkedin"] = $user_data['linkedin'];
				$response["twitter"] = $user_data['twitter'];

				$response["salutation"] = $user_data['salutation'];
				$response["user_full_name"] = $user_data['user_full_name'];
				$response["user_first_name"] = $user_data['user_first_name'];
				$response["user_last_name"] = $user_data['user_last_name'];
				$response["gender"] = $user_data['gender'];
				if ($user_data['member_date_of_birth'] == '') {
					$response["member_date_of_birth_new"] = '';
				} else {

					//12nov
				$user_data['member_date_of_birth'] = str_replace("/", "-",$user_data['member_date_of_birth']);
				//12nov

					$response["member_date_of_birth_new"] = date("d/m/Y", strtotime($user_data['member_date_of_birth']));
				}   

				//12nov
				$user_data['member_date_of_birth'] = str_replace("/", "-",$user_data['member_date_of_birth']);
				//12nov

				$response["member_date_of_birth"] = date("d/m/Y", strtotime($user_data['member_date_of_birth']));

				$response["user_mobile"] = $user_data['user_mobile'];
				if ($user_data["user_mobile"] != 0) {
					$response["user_mobile"] = $user_data["user_mobile"];
				} else {
					$response["user_mobile"] = "";
				}

				if ($user_data['alt_mobile'] != 0) {
					$response["alt_mobile"] = $user_data['alt_mobile'];

				} else {
					$response["alt_mobile"] = '';
				}

				if ($user_data["whatsapp_number"] != 0) {
					$response["whatsapp_number"] = $user_data["whatsapp_number"];
				} else {
					$response["whatsapp_number"] = "";
				}
				$response["user_email"] = $user_data['user_email'];

				$response["public_mobile"] = $user_data['public_mobile'];
				$response["whatsapp_privacy"] = $user_data['whatsapp_privacy'];
				$response["email_privacy"] = $user_data['email_privacy'];
				$response["cllassified_mute"] = $user_data['cllassified_mute'];

				$response["user_profile_pic"] = $base_url . "img/users/members_profile/" . $user_data['user_profile_pic'];

				$response["company_name"] = html_entity_decode($user_data['company_name']);
				$response["designation"] = html_entity_decode($user_data['designation']);

				$response["address"] = $addData['adress'] . '';
				$response["country_id"] = $addData['country_id'] . '';
				$response["state_id"] = $addData['state_id'] . '';
				$response["city_id"] = $addData['city_id'] . '';
				$response["area_id"] = $addData['area_id'] . '';
				$response["country_name"] = $addData['country_name'] . '';
				$response["state_name"] = $addData['state_name'] . '';
				$response["city_name"] = $addData['city_name'] . '';
				$response["area_name"] = $addData['area_name'] . '';
				$response["latitude"] = $addData['add_latitude'] . '';
				$response["longitude"] = $addData['add_longitude'] . '';

				$response["message"] = "Member Details Found";
				$response["status"] = "200";
				echo json_encode($response);

			} else {
				$response["message"] = "No Member Found";
				$response["status"] = "201";
				echo json_encode($response);
			}

		} else if (isset($getFollowingDeatils) && $getFollowingDeatils == 'getFollowingDeatils' && filter_var($user_id, FILTER_VALIDATE_INT) == true) {
			$q = $d->select("users_master", "user_id ='$user_id' ");
			$user_data = mysqli_fetch_array($q);

			$tq11 = $d->select("users_master,timeline_master", "users_master.user_id=timeline_master.user_id AND  timeline_master.user_id='$user_id'", "");
			$total_post = mysqli_num_rows($tq11);

			$tq22 = $d->select("users_master,follow_master,user_employment_details,business_categories,business_sub_categories", "business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id AND follow_master.follow_to=users_master.user_id AND follow_master.follow_by='$user_id'", "ORDER BY users_master.user_full_name ASC");

			$tq33 = $d->select("users_master,follow_master,user_employment_details,business_categories,business_sub_categories", "business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id AND follow_master.follow_by=users_master.user_id AND follow_master.follow_to='$user_id'", "ORDER BY users_master.user_full_name ASC");
			$following = mysqli_num_rows($tq22);
			$followers = mysqli_num_rows($tq33);

			$q11 = $d->select("user_employment_details", "user_id ='$user_data[user_id]'");
			$profData = mysqli_fetch_array($q11);

			$qA2 = $d->select("business_adress_master,cities,states,countries,area_master", "business_adress_master.user_id='$user_data[user_id]'
	                AND
	                business_adress_master.country_id = countries.country_id
	                AND
	                business_adress_master.state_id = states.state_id
	                AND
	                business_adress_master.city_id = cities.city_id
	                AND
	                business_adress_master.area_id = area_master.area_id AND business_adress_master.adress_type=0", "");
			$addData = mysqli_fetch_array($qA2);

			$response["user_id"] = $user_data['user_id'];
			$response["zoobiz_id"] = $user_data['zoobiz_id'];

			$response["facebook"] = $user_data['facebook'];
			$response["instagram"] = $user_data['instagram'];
			$response["linkedin"] = $user_data['linkedin'];
			$response["twitter"] = $user_data['twitter'];

			$response["salutation"] = $user_data['salutation'];
			$response["user_full_name"] = $user_data['user_full_name'];
			$response["user_first_name"] = $user_data['user_first_name'];
			$response["user_last_name"] = $user_data['user_last_name'];
			$response["gender"] = $user_data['gender'];
			if ($user_data['member_date_of_birth'] == '') {
				$response["member_date_of_birth_new"] = '';
			} else {
				//9nov
				$user_data['member_date_of_birth'] = str_replace("/", "-",$user_data['member_date_of_birth']);
				//9nov
				$response["member_date_of_birth_new"] = date("d/m/Y", strtotime($user_data['member_date_of_birth']));
			}

			//9nov
				$user_data['member_date_of_birth'] = str_replace("/", "-",$user_data['member_date_of_birth']);
				//9nov

			$response["member_date_of_birth"] = date("d/m/Y", strtotime($user_data['member_date_of_birth']));

			$response["user_mobile"] = $user_data['user_mobile'];
			$response["alt_mobile"] = $user_data['alt_mobile'];
			$response["user_email"] = $user_data['user_email'];
			$response["whatsapp_number"] = $user_data['whatsapp_number'];

			$response["public_mobile"] = $user_data['public_mobile'];
			$response["whatsapp_privacy"] = $user_data['whatsapp_privacy'];
			$response["email_privacy"] = $user_data['email_privacy'];
			$response["cllassified_mute"] = $user_data['cllassified_mute'];

			$response["user_profile_pic"] = $base_url . "img/users/members_profile/" . $user_data['user_profile_pic'];

			$response["company_name"] = html_entity_decode($profData['company_name']);
			$response["designation"] = html_entity_decode($profData['designation']);

			$response["address"] = $addData['adress'] . '';
			$response["country_id"] = $addData['country_id'] . '';
			$response["state_id"] = $addData['state_id'] . '';
			$response["city_id"] = $addData['city_id'] . '';
			$response["area_id"] = $addData['area_id'] . '';
			$response["country_name"] = $addData['country_name'] . '';
			$response["state_name"] = $addData['state_name'] . '';
			$response["city_name"] = $addData['city_name'] . '';
			$response["area_name"] = $addData['area_name'] . '';
			$response["latitude"] = $addData['add_latitude'] . '';
			$response["longitude"] = $addData['add_longitude'] . '';

			$response["plan_renewal_date"] = date("d M Y", strtotime($user_data['plan_renewal_date']));

			if ($user_data['invoice_download'] == 0) {
				$response["invoice_download"] = false;
				$response["invoice_url"] = "";
			} else {
				$response["invoice_download"] = true;
				$response["invoice_url"] = $base_url . "paymentReceipt.php?user_id=" . $user_data['user_id'];
			}

			$response["total_post"] = $total_post . '';
			$response["followers"] = $followers . '';
			$response["following"] = $following . '';
			$response["message"] = "Get Success.";
			$response["status"] = "200";
			echo json_encode($response);

		} else if (isset($setProfilePicture) && $setProfilePicture == 'setProfilePicture' && filter_var($user_id, FILTER_VALIDATE_INT) == true) {

			 $maxsize = 5000000;
             if (($_FILES['user_profile_pic']['size'] >= $maxsize) || ($_FILES["user_profile_pic"]["size"] == 0)) {
                $response["message"] = "Profile Pic is too large. Must be less than or equal to 5 MB.";
				$response["status"] = "201";
				echo json_encode($response);
				exit;
              }

              
			$extension = array("jpeg", "jpg", "png", "gif", "JPG", "JPEG", "PNG");
			$uploadedFile = $_FILES["user_profile_pic"]["tmp_name"];
			$ext = pathinfo($_FILES['user_profile_pic']['name'], PATHINFO_EXTENSION);
			if (file_exists($uploadedFile)) {

				$sourceProperties = getimagesize($uploadedFile);
				$newFileName = rand() . $user_id;
				$dirPath = "../img/users/members_profile/";
				$imageType = $sourceProperties[2];
				$imageHeight = $sourceProperties[1];
				$imageWidth = $sourceProperties[0];
				if ($imageWidth > 1800) {
					$newWidthPercentage = 500 * 100 / $imageWidth; //for maximum 500 widht
					$newImageWidth = $imageWidth * $newWidthPercentage / 100;
					$newImageHeight = $imageHeight * $newWidthPercentage / 100;
				} else {
					$newImageWidth = $imageWidth;
					$newImageHeight = $imageHeight;
				}


				//7jan2021
					 move_uploaded_file($_FILES["user_profile_pic"]["tmp_name"], "../img/users/members_profile/".$newFileName . "_profile." . $ext); 
					//7jan2021


				/*switch ($imageType) {

				case IMAGETYPE_PNG:
					$imageSrc = imagecreatefrompng($uploadedFile);
					$tmp = imageResize($imageSrc, $sourceProperties[0], $sourceProperties[1], $newImageWidth, $newImageHeight);
					imagepng($tmp, $dirPath . $newFileName . "_profile." . $ext);
					break;

				case IMAGETYPE_JPEG:
					$imageSrc = imagecreatefromjpeg($uploadedFile);
					$tmp = imageResize($imageSrc, $sourceProperties[0], $sourceProperties[1], $newImageWidth, $newImageHeight);
					imagejpeg($tmp, $dirPath . $newFileName . "_profile." . $ext);
					break;

				case IMAGETYPE_GIF:
					$imageSrc = imagecreatefromgif($uploadedFile);
					$tmp = imageResize($imageSrc, $sourceProperties[0], $sourceProperties[1], $newImageWidth, $newImageHeight);
					imagegif($tmp, $dirPath . $newFileName . "_profile." . $ext);
					break;

				default:

					break;
				}*/
				$profile_name = $newFileName . "_profile." . $ext;

			} else {

				$response["message"] = "Invalid Photo Format.";
				$response["status"] = "201";
				echo json_encode($response);
				exit();
			}

			$m->set_data('user_profile_pic', $profile_name);

			$a = array('user_profile_pic' => $m->get_data('user_profile_pic'));

			$q = $d->update("users_master", $a, "user_id='$user_id'");

			if ($q == true) {
				$d->insert_myactivity($user_id,"0","", "profile picture updated","activity.png");

				$response["user_profile_pic"] = $base_url . "img/users/members_profile/" . $profile_name;
				$response["message"] = "Photo Updated";
				$response["status"] = "200";
				echo json_encode($response);
			} else {
				$response["message"] = "wrong profile details.";
				$response["status"] = "201";
				echo json_encode($response);
			}
		} else if (isset($changeMobileNumber) && $changeMobileNumber == 'changeMobileNumber' && filter_var($user_mobile, FILTER_VALIDATE_INT) == true && filter_var($user_id, FILTER_VALIDATE_INT) == true) {

			$q = $d->select("users_master", "user_mobile ='$user_mobile' ");
			if (mysqli_num_rows($q) > 0) {
				$response["message"] = "Mobile Number Already Registered";
				$response["status"] = "201";
				echo json_encode($response);
			} else {

				$digits = 4;
				$otp = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
				$m->set_data('otp', $otp);

				$a = array(
					'otp' => $m->get_data('otp'),
				);

				$d->update("users_master", $a, "user_id='$user_id'");

				$d->send_otp($user_mobile, $otp);
				$response["message"] = "OTP Sent Successfully";
				$response["status"] = "200";
				echo json_encode($response);

			}
		} 
		// get member added details start
		else if (isset($getMemberAdded) && $getMemberAdded == 'getMemberAdded' && filter_var($user_mobile, FILTER_VALIDATE_INT) == true && filter_var($user_id, FILTER_VALIDATE_INT) == true) {

			$q = $d->select("users_master", "user_mobile ='$user_mobile' ");

			 $memberAdded=$d->count_data_direct("user_mobile"," users_master  "," refere_by_phone_number ='$user_mobile'");
			 if($memberAdded > 0 ){ 
			 	 
			 $response["memberAdded"] =  $memberAdded ;

			 //details start
			    $q6=$d->select("company_master,users_master","company_master.company_id =  users_master.company_id  and    users_master.active_status= 0  and users_master.refer_by!= 0 and   users_master.refere_by_phone_number  = '$user_mobile'  ","");
			    $user_id_array = array('0');
                 while ($data3=mysqli_fetch_array($q6)) {
                  $user_id_array[] = $data3['user_id'];
                 }
                  $user_id_array = implode(",", $user_id_array);
 
                 $q3= $d->select("company_master,users_master","company_master.company_id =  users_master.company_id  and    users_master.active_status= 0  and users_master.refer_by!= 0  and   users_master.refere_by_phone_number  = '$user_mobile'  ","");
 
                 /* $user_employment_details=$d->select("users_master,user_employment_details ","   user_employment_details.user_id=users_master.user_id and users_master.user_id in ($user_id_array) ","");
 
                $user_employment_details_array = array();
                 while ($user_employment_details_data=mysqli_fetch_array($user_employment_details)) {
                  $user_employment_details_array[$user_employment_details_data['user_id']] = $user_employment_details_data;
                 }*/
$response["member_added_details"] = array();
                 while ($data=mysqli_fetch_array($q3)) {
		                extract($data);
                $member_added_details = array();
				$member_added_details["company_name"] = html_entity_decode($company_name);
				$member_added_details["name"] = $salutation.' '.$user_full_name;
				 
				if($refer_by=="1") {
					$member_added_details["refer_by"] = "Social Media";} 
                  else if($refer_by=="2") {$member_added_details["refer_by"]=  "Member / Friend";}
                  else if($refer_by=="3") {$member_added_details["refer_by"] =  "Other";}

                  $member_added_details["refere_by_name"] = $refere_by_name;
                  $member_added_details["refere_by_phone_number"] = $refere_by_phone_number;
                  $member_added_details["remark"] = $remark;
                  $member_added_details["register_date"] = date("d-m-Y h:i:s A",strtotime($register_date));
                  $member_added_details["refere_by_name"] = $refere_by_name;
//echo "<pre>";print_r($member_added_details);exit;
				array_push($response["member_added_details"], $member_added_details);

		            }
			  //details end
 
				$response["message"] = "Member Added Details";
				$response["status"] = "200";
				echo json_encode($response);
			} else {
				$response["message"] = "No Member Added";
				$response["status"] = "201";
				echo json_encode($response);
			}

		 }
		 
		//get member added details end


		else if (isset($changeMobileNumberVerify) && $changeMobileNumberVerify == 'changeMobileNumberVerify' && filter_var($user_mobile, FILTER_VALIDATE_INT) == true && filter_var($user_id, FILTER_VALIDATE_INT) == true) {

			$user_mobile = mysqli_real_escape_string($con, $user_mobile);
			$otp = mysqli_real_escape_string($con, $otp);

			$q = $d->select("users_master", "user_id ='$user_id' AND otp='$otp'");
			if (mysqli_num_rows($q) > 0) {
				$m->set_data('user_mobile', $user_mobile);
				
				if(isset($country_code)){
					$m->set_data('country_code',$country_code);
				} else {
					$m->set_data('country_code','+91');
				}
				$a = array(
					'country_code' => $m->get_data('country_code'),
					'user_mobile' => $m->get_data('user_mobile'),
					'otp' => "",
				);

				$d->update("users_master", $a, "user_id='$user_id'");

				$d->send_otp($user_mobile, $otp);
				$response["user_mobile"] = $user_mobile;
				$d->insert_myactivity($user_id,"0","", "Primary Number Changed","activity.png");

				$response["message"] = "Mobile Number Changed Successfully";
				$response["status"] = "200";
				echo json_encode($response);

			} else {

				$response["message"] = "Invalid OTP";
				$response["status"] = "201";
				echo json_encode($response);

			}
		}   else {
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