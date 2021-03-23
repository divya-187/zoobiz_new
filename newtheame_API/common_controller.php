<?php
include_once 'lib.php';



if (isset($_POST) && !empty($_POST)) {

	if ($key == $keydb) {

		$response = array();
		extract(array_map("test_input", $_POST));

		if ($_POST['shareSeasonalGreet'] == "shareSeasonalGreet" && filter_var($user_id, FILTER_VALIDATE_INT) == true && filter_var($promotion_id, FILTER_VALIDATE_INT) == true) {


			$m->set_data('promotion_id', $promotion_id);
			$m->set_data('user_id', $user_id);
			$m->set_data('created_at', date('Y-m-d H:i:s')); 
			$a = array(
				'promotion_id' => $m->get_data('promotion_id'), 
				'user_id' => $m->get_data('user_id'), 
				'created_at' => $m->get_data('created_at') 
			);

			/*$seasonal_greeting_share_master = $d->selectRow("promotion_id","seasonal_greeting_share_master",
				"promotion_id ='$promotion_id' and user_id='$user_id'   ", "");
			if(mysqli_num_rows($seasonal_greeting_share_master) > 0){
				$q = $d->update("seasonal_greeting_share_master",$a," promotion_id ='$promotion_id' and user_id='$user_id' ");
			} else {
				$q = $d->insert("seasonal_greeting_share_master",$a);
			}*/
$q = $d->insert("seasonal_greeting_share_master",$a);

			if ($q == true) {
				$promotion_master = $d->select("promotion_master", "promotion_id='$promotion_id'");
				$promotion_master_data = mysqli_fetch_array($promotion_master);

				$d->insert_myactivity($user_id,"0","", "You Share Seasonal Greting ".$promotion_master_data['event_name'],"activity.png");
				$response["message"] = "Done";
				$response["status"] = "200";
				echo json_encode($response);
				exit();
			} else {
				$response["message"] = "Fail";
				$response["status"] = "201";
				echo json_encode($response);
			}


		} else if (isset($edit_social_links) && $edit_social_links == 'edit_social_links' && filter_var($user_id, FILTER_VALIDATE_INT) == true) {

			$m->set_data('facebook', $facebook);
			$m->set_data('instagram', $instagram);
			$m->set_data('linkedin', $linkedin);
			$m->set_data('twitter', $twitter);
			$a = array(
				'facebook' => $m->get_data('facebook'),
				'instagram' => $m->get_data('instagram'),
				'linkedin' => $m->get_data('linkedin'),
				'twitter' => $m->get_data('twitter')
			);
			$q = $d->update("users_master", $a, "user_id='$user_id'");
			if ($q == true) {
				$d->insert_myactivity($user_id,"0","", "Social Links Updated","activity.png");

				$response["message"] = "Updated Successfully";
				$response["status"] = "200";
				echo json_encode($response);
				exit();

			} else {
				$response["message"] = "Something Wrong";
				$response["status"] = "201";
				echo json_encode($response);
			}



		}else if (isset($edit_basic_info) && $edit_basic_info == 'edit_basic_info' && filter_var($user_id, FILTER_VALIDATE_INT) == true) {


			$q = $d->selectRow("user_mobile,user_id,user_email,whatsapp_number","users_master", "user_id ='$user_id' ");

			if (mysqli_num_rows($q) > 0) {
				$users_master_data = mysqli_fetch_array($q);
				$user_mobile_old = $users_master_data['user_mobile'];

				 $m->set_data('user_first_name', ucfirst($user_first_name));
				$m->set_data('user_last_name', ucfirst($user_last_name));
	            $m->set_data('user_full_name', ucfirst($user_first_name) .' '.ucfirst($user_last_name) );
	            $user_full_name = ucfirst($user_first_name) .' '.ucfirst($user_last_name);


				$m->set_data('gender', $gender);

				if ($member_date_of_birth != "") {

					 $d->insert_log("","0","$user_id","$user_id",'Birthdate Changed '.$member_date_of_birth);


					$member_date_of_birth = str_replace("/", "-",$member_date_of_birth);
					$member_date_of_birth = date("Y-m-d", strtotime($member_date_of_birth));
					$m->set_data('member_date_of_birth',  $member_date_of_birth);

				} else {
					$m->set_data('member_date_of_birth', "");
				}

				$m->set_data('user_email', $user_email);

				$m->set_data('alt_mobile', $alt_mobile);
				$m->set_data('whatsapp_number', $whatsapp_number);

				$a = array(

					'user_first_name' => $m->get_data('user_first_name'),
					'user_last_name' => $m->get_data('user_last_name'),
					'user_full_name' => $m->get_data('user_full_name'),
					'gender' => $m->get_data('gender'),
					'member_date_of_birth' => $m->get_data('member_date_of_birth'),
					'user_email' => $m->get_data('user_email'), 
					'alt_mobile' => $m->get_data('alt_mobile'),
					'whatsapp_number' => $m->get_data('whatsapp_number') 
				);
					 
				$q = $d->update("users_master", $a, "user_id='$user_id'");


				
				
				if($users_master_data['user_mobile'] != $user_mobile  ){

					$q11 = $d->select("users_master", "user_mobile='$user_mobile' and user_id !='$user_id' ");
					$data = mysqli_fetch_array($q11);
					if ($data > 0) {
						$response["message"] = "Mobile Number Is Already Registered";
						$response["status"] = "201";
						echo json_encode($response);
						exit();
					}


					$digits = 4;
					$otp = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
					$m->set_data('otp', $otp);
					$m->set_data('temp_mobile_number', $user_mobile);
					
					$a = array(
						'otp' => $m->get_data('otp'),
						'temp_mobile_number' => $m->get_data('temp_mobile_number'),
					);

					$d->update("users_master", $a, "user_id='$user_id'");

					$d->send_otp($user_mobile, $otp);
					
					$response["message"] = "OTP Sent to New Mobile Number";
					$response["status"] = "200";
					$response["otp_dialog"] = true;
					echo json_encode($response);
					exit;

				}else {


					if ($q == true) {
						$d->insert_myactivity($user_id,"0","", "Profile Data Updated","activity.png");
						$response["message"] = "Updated Successfully";
						$response["status"] = "200";
						$response["otp_dialog"] = false;
						echo json_encode($response);
						exit();

					} else {
						$response["otp_dialog"] = false;
						$response["message"] = "Something Wrong";
						$response["status"] = "201";
						echo json_encode($response);
					}

					

				}






			} else {
				$response["message"] = "No User Found";
				$response["status"] = "201";
				echo json_encode($response);
			}


		} else if (isset($edit_company_broucher) && $edit_company_broucher == 'edit_company_broucher' && filter_var($user_id, FILTER_VALIDATE_INT) == true) {
    $file = $_FILES['company_broucher']['tmp_name'];
        if(file_exists($file)) {
          $extensionResume=array("pdf","doc","docx","png","jpg","jpeg","PNG","JPG","JPEG");
          $extId = pathinfo($_FILES['company_broucher']['name'], PATHINFO_EXTENSION);

           $errors     = array();
            $maxsize    = 10097152;
            
            if(($_FILES['company_broucher']['size'] >= $maxsize) || ($_FILES["company_broucher"]["size"] == 0)) {
                 

                $response["message"] = "Company Broucher too large. Must be less than 10 MB.";
				$response["status"] = "201";
				echo json_encode($response);

                
            }
            if(!in_array($extId, $extensionResume) && (!empty($_FILES["company_broucher"]["type"]))) {

            	$response["message"] = "Invalid Company Broucher File format, Only  JPG,PDF, PNG,Doc are allowed.";
				$response["status"] = "201";
				echo json_encode($response);

                 
            }
            
            $image_Arr = $_FILES['company_broucher'];   
            $temp = explode(".", $_FILES["company_broucher"]["name"]);
           

            $users_master = $d->selectRow("user_mobile","users_master", "user_id ='$user_id'");
 $users_master_data = mysqli_fetch_array($users_master);
 $company_broucher = $users_master_data['user_mobile'].'_company_broucher_'.round(microtime(true)) . '.' . end($temp);

            move_uploaded_file($_FILES["company_broucher"]["tmp_name"], "../img/users/company_broucher/".$company_broucher);
             $m->set_data('company_broucher', $company_broucher);
             $a = array(
                'company_broucher' => $m->get_data('company_broucher')
				);
			 $q = $d->update("user_employment_details", $a, "user_id='$user_id'");
			 if ($q == true) {
						$d->insert_myactivity($user_id,"0","", "Company Broucher Updated","activity.png");
						$response["message"] = "Company Broucher Updated";
						$response["status"] = "200";
						 echo json_encode($response);
						exit();

					} else {
						 
						$response["message"] = "Something Wrong";
						$response["status"] = "201";
						echo json_encode($response);
					}
        } else {
        	$response["message"] = "Please Provide File";
				$response["status"] = "201";
				echo json_encode($response);
        }
 


		}  else if (isset($edit_company_profile) && $edit_company_profile == 'edit_company_profile' && filter_var($user_id, FILTER_VALIDATE_INT) == true) {
    $file = $_FILES['company_profile']['tmp_name'];
        if(file_exists($file)) {
          $extensionResume=array("pdf","doc","docx","png","jpg","jpeg","PNG","JPG","JPEG");
          $extId = pathinfo($_FILES['company_profile']['name'], PATHINFO_EXTENSION);

           $errors     = array();
            $maxsize    = 10097152;
            
            if(($_FILES['company_profile']['size'] >= $maxsize) || ($_FILES["company_profile"]["size"] == 0)) {
                 

                $response["message"] = "Company profile too large. Must be less than 10 MB.";
				$response["status"] = "201";
				echo json_encode($response);

                
            }
            if(!in_array($extId, $extensionResume) && (!empty($_FILES["company_profile"]["type"]))) {

            	$response["message"] = "Invalid Company Profile File format, Only  JPG,PDF, PNG,Doc are allowed.";
				$response["status"] = "201";
				echo json_encode($response);

                 
            }
            
            $image_Arr = $_FILES['company_profile'];   
            $temp = explode(".", $_FILES["company_profile"]["name"]);
            $users_master = $d->selectRow("user_mobile","users_master", "user_id ='$user_id'");
 $users_master_data = mysqli_fetch_array($users_master);
            $company_profile = $users_master_data['user_mobile'].'_company_profile'.round(microtime(true)) . '.' . end($temp);
            move_uploaded_file($_FILES["company_profile"]["tmp_name"], "../img/users/comapany_profile/".$company_profile);
             $m->set_data('company_profile', $company_profile);
             $a = array(
                'company_profile' => $m->get_data('company_profile')
				);
			 $q = $d->update("user_employment_details", $a, "user_id='$user_id'");
			 if ($q == true) {
						$d->insert_myactivity($user_id,"0","", "Company Profile Updated","activity.png");
						$response["message"] = "Company Profile Updated";
						$response["status"] = "200";
						 echo json_encode($response);
						exit();

					} else {
						 
						$response["message"] = "Something Wrong";
						$response["status"] = "201";
						echo json_encode($response);
					}
        } else {
        	$response["message"] = "Please Provide File";
				$response["status"] = "201";
				echo json_encode($response);
        }
 


		}  else   if (isset($get_profile_data) && $get_profile_data == 'get_profile_data' && filter_var($user_id, FILTER_VALIDATE_INT) == true) {

			//interest start
  $selected=$d->select("interest_relation_master","member_id='$user_id'");
  $valid_int = mysqli_num_rows($selected);
	
$approval_pending=$d->select("interest_master","added_by_member_id='$user_id' and int_status ='User Added'");
 $approval_pending_cnt = mysqli_num_rows($approval_pending);  
 if( ($valid_int+$approval_pending_cnt) >=5 ){
 	$response["add_interest_flag"] = false;
 } else {
 	$response["add_interest_flag"] = true;
 }
//interest end

 
			$full_data_query = $d->selectRow("users_master.chat_alerts,users_master.timeline_alert,user_employment_details.company_contact_number_privacy,   users_master.user_first_name, users_master.user_last_name, users_master.user_first_name,users_master.user_last_name, users_master.office_member,users_master.user_mobile,users_master.alt_mobile,
				users_master.invoice_download,users_master.plan_renewal_date,users_master.facebook,users_master.instagram,users_master.linkedin,users_master.twitter,users_master.whatsapp_privacy,users_master.email_privacy,

				users_master.member_date_of_birth,users_master.gender, users_master.whatsapp_number, users_master.user_email,users_master.cllassified_mute,users_master.user_id,business_categories.business_category_id,business_sub_categories.business_sub_category_id,users_master.user_full_name,users_master.zoobiz_id,users_master.public_mobile,users_master.user_mobile,users_master.user_profile_pic,business_categories.category_name,business_sub_categories.sub_category_name,user_employment_details.company_email ,user_employment_details.company_name ,user_employment_details.designation,user_employment_details.company_contact_number,user_employment_details.company_website,user_employment_details.company_logo,user_employment_details.company_broucher,user_employment_details.company_profile,user_employment_details.gst_number","users_master,user_employment_details,business_categories,business_sub_categories ",

				"  (business_categories.category_status = 0 OR business_categories.category_status = 2 ) and     users_master.user_id='$user_id'  AND business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id  ", "");

			if (mysqli_num_rows($full_data_query) > 0) {
				$data_app=mysqli_fetch_array($full_data_query);

  

				$tq22=$d->selectRow(" users_master.user_first_name, users_master.user_last_name, users_master.user_id,users_master.user_full_name,users_master.user_profile_pic,business_categories.category_name,business_sub_categories.sub_category_name,user_employment_details.company_name,user_employment_details.designation","users_master,follow_master,user_employment_details,business_categories,business_sub_categories","
  business_categories.category_status = 0 and  
business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id AND follow_master.follow_to=users_master.user_id AND follow_master.follow_by='$user_id' AND users_master.office_member=0 AND users_master.active_status=0  ","");

$tq33=$d->selectRow("users_master.user_id,users_master.user_full_name,users_master.user_profile_pic,business_categories.category_name,business_sub_categories.sub_category_name,user_employment_details.company_name,user_employment_details.designation","users_master,follow_master,user_employment_details,business_categories,business_sub_categories","
  business_categories.category_status = 0 and  
business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id AND follow_master.follow_by=users_master.user_id AND follow_master.follow_to='$user_id' AND users_master.office_member=0 AND users_master.active_status=0  ","");

				 
				$following = mysqli_num_rows($tq22);
				$followers = mysqli_num_rows($tq33);
				$response["followers"] = $followers . '';
				$response["following"] = $following . '';


				$user_favorite_master = $d->selectRow("users_master.user_id,business_categories.business_category_id,business_sub_categories.business_sub_category_id,users_master.user_full_name,users_master.zoobiz_id,users_master.public_mobile,users_master.chat_alerts, users_master.user_mobile,users_master.user_profile_pic,business_categories.category_name,business_sub_categories.sub_category_name,user_employment_details.company_name, user_employment_details.company_logo,user_employment_details.designation",
		
		"users_master,user_employment_details,business_categories,business_sub_categories,user_favorite_master", 

		"/*user_favorite_master.member_id = users_master.user_id and   */

		user_employment_details.user_id = users_master.user_id and
		user_favorite_master.user_id = user_employment_details.user_id and
		user_favorite_master.member_id = '$user_id' and     
		user_favorite_master.flag = 0 and     business_categories.category_status = 0 and  
		business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id AND users_master.office_member=0 AND users_master.active_status=0    ", "");
				$favorite = mysqli_num_rows($user_favorite_master);
//$response["favorite"] = $favorite . '';



				$qA2 = $d->selectRow("cities.city_name,cities.city_id, states.state_name,states.state_id , countries.country_name,countries.phonecode, countries.country_id,business_adress_master.adress,business_adress_master.adress2 ,business_adress_master.add_latitude,business_adress_master.add_longitude,business_adress_master.pincode, area_master.area_name , area_master.area_id","business_adress_master,cities,states,countries,area_master", "business_adress_master.user_id='$user_id'
					AND
					business_adress_master.country_id = countries.country_id
					AND
					business_adress_master.state_id = states.state_id
					AND
					business_adress_master.city_id = cities.city_id
					AND
					business_adress_master.area_id = area_master.area_id  ", "");
				$addData = mysqli_fetch_array($qA2);

				$tq11 = $d->selectRow("user_id","timeline_master", "  user_id='$user_id'", "");
				$total_post = mysqli_num_rows($tq11);
				$response["total_post"] = $total_post . '';

				/*$tq11 = $d->selectRow("user_id","user_favorite_master", "  user_id='$user_id'", "");
				$total_fav = mysqli_num_rows($tq11);*/
				$response["total_fav"] = $favorite . '';

				$response["area_id"] = $addData["area_id"];
				$response["area_name"] = $addData["area_name"];
				if($addData["pincode"]==0){
					$response["pincode"] = "";
				} else {
					$response["pincode"] = $addData["pincode"];
				}
				
				$response["add_longitude"] = $addData["add_longitude"];
				$response["add_latitude"] = $addData["add_latitude"];
				$response["full_address"] =html_entity_decode(  $addData["adress"].', '.$addData["adress2"]);
				$response["adress2"] = html_entity_decode( $addData["adress2"]);
				$response["adress"] =html_entity_decode(  $addData["adress"]);
				$response["country_id"] = $addData["country_id"];
				$response["country_name"] = $addData["country_name"];
				$response["state_id"] = $addData["state_id"];
				$response["state_name"] = $addData["state_name"];
				$response["city_id"] = $addData["city_id"];
				$response["city_name"] = $addData["city_name"];

				if($data_app["alt_mobile"]==0){
					$response["alt_mobile"] ="";
				}else{
					$response["alt_mobile"] = $data_app["alt_mobile"];
				}

				if($data_app["whatsapp_number"]==0){
					$response["whatsapp_number"] ="";
				}else{
					$response["whatsapp_number"] = $data_app["whatsapp_number"];
				}
 
				$response["company_email"] = $data_app["company_email"];
				$response["designation"] = html_entity_decode($data_app["designation"]);
				if($data_app["company_contact_number"]!=0){
					$response["company_contact_number"] = $data_app["company_contact_number"];
				} else {
					$response["company_contact_number"] = "";
				}
				$response["user_email"] = $data_app["user_email"];
$response["short_name"] =strtoupper(substr($data_app["user_first_name"], 0, 1).substr($data_app["user_last_name"], 0, 1) );
				$response["user_mobile"] = $data_app["user_mobile"];
				$response["company_website"] = $data_app["company_website"];

				 if($data_app["company_website"] == ""){
				 	$response["company_website"] = "Not Available"; 
				 }
				 
				if($data_app['company_logo']!=""){
					$response["company_logo"] = $base_url . "img/users/company_logo/" . $data_app['company_logo'];  
				} else {
					$response["company_logo"] ="";
				}

				if($data_app['company_broucher']!=""){
					$response["company_broucher"] = $base_url . "img/users/company_broucher/" . $data_app['company_broucher'];  
				} else {
					$response["company_broucher"] ="";
				}

				if($data_app['company_profile']!=""){
					$response["company_profile"] = $base_url . "img/users/comapany_profile/" . $data_app['company_profile'];  
				} else {
					$response["company_profile"] ="";
				}
				if($data_app["gst_number"]!=""){
					$response["gst_number"] = $data_app["gst_number"];
				} else {
					$response["gst_number"] = "";
				}


				$response["user_id"] = $data_app["user_id"];
				$response["facebook"] = $data_app["facebook"];
				$response["instagram"] = $data_app["instagram"];
				$response["linkedin"] = $data_app["linkedin"];
				$response["twitter"] = $data_app["twitter"];

				if($data_app["cllassified_mute"]=="0"){
					$response["cllassified_mute"]=true;
				} else {
					$response["cllassified_mute"]=false;
				}

				if($data_app["whatsapp_privacy"]=="1"){
					$response["whatsapp_privacy"]=true;
				} else {
					$response["whatsapp_privacy"]=false;
				} 

				if($data_app["email_privacy"]=="1"){
					$response["email_privacy"]=true;
				} else {
					$response["email_privacy"]=false;
				}

				$response["user_email"] = $data_app["user_email"];
				if($data_app["member_date_of_birth"]!=""){

					$response["member_date_of_birth"] = date("d/m/Y", strtotime($data_app["member_date_of_birth"]));

					

				} else {
					$response["member_date_of_birth"] ="";
				}
				if($data_app["plan_renewal_date"]!=""){
					$response["plan_renewal_date"] = date("d/m/Y", strtotime($data_app["plan_renewal_date"]));
				} else {
					$response["plan_renewal_date"] ="";
				}

				$response["gender"] = $data_app["gender"];

				if($data_app["whatsapp_number"]==0){
					$response["whatsapp_number"] ="";
				}else{
					$response["whatsapp_number"] = $data_app["whatsapp_number"];
				}


$transection_master_qry_new=$d->select("transection_master","user_id='$user_id'" ,"");
    $transection_master_data_new=mysqli_fetch_array($transection_master_qry_new);
    if($transection_master_data_new['is_paid'] == 0){

    	if($data_app["invoice_download"]=="1"    ){
					$response["invoice_download_url"]=$base_url."paymentReceipt.php?user_id=".$data_app["user_id"]."&download=true";
				} else {
					$response["invoice_download_url"]="";
				}

				if($data_app["invoice_download"]=="1"  ){
					$response["invoice_download"]=true;
				} else {
					$response["invoice_download"]=false;
				}

    } else {
    	$response["invoice_download"]=false;
    	$response["invoice_download_url"]="";
    }
				 
				//$response["invoice_download"] = $data_app["invoice_download"];
				


				$response["business_category_id"] = $data_app["business_category_id"];
				$response["business_sub_category_id"] = $data_app["business_sub_category_id"];
				$response["user_full_name"] = $data_app["user_full_name"];
				$response["user_first_name"] = $data_app["user_first_name"];
				$response["user_last_name"] = $data_app["user_last_name"]; 


				$response["zoobiz_id"] = $data_app["zoobiz_id"];

				if($data_app["public_mobile"]=="0"){
					$response["public_mobile"]=true;
				} else {
					$response["public_mobile"]=false;
				}
				$response["chat_alerts"]=filter_var($data_app["chat_alerts"], FILTER_VALIDATE_BOOLEAN); 

				$response["user_mobile"] = $data_app["user_mobile"];

				if($data_app['user_profile_pic'] !=""){
					$response["user_profile_pic"] = $base_url . "img/users/members_profile/" . $data_app['user_profile_pic'];
				} else {
					$response["user_profile_pic"] = "";
				}
				
				$response["bussiness_category_name"] = html_entity_decode($data_app["category_name"]);
				$response["sub_category_name"] = html_entity_decode($data_app["sub_category_name"]) . '';
				$response["company_name"] = html_entity_decode($data_app["company_name"]) . '';


				$interest_master = $d->selectRow("* ", "interest_master,interest_relation_master", "interest_relation_master.interest_id = interest_master.interest_id and   interest_relation_master.member_id = '$user_id' ", "");

				  $dataArrayA = array();
                $counterA = 0 ;
                foreach ($interest_master as  $value) {
                    foreach ($value as $key => $valueNew) {
                        $dataArrayA[$counterA][$key] = $valueNew;
                    }
                    $counterA++;
                }
                $response["selected_interest_array"] = array();
                for ($l=0; $l < count($dataArrayA) ; $l++) { 
                	$selected_interest_array = array();
				    $selected_interest_array["interest_id"] = $dataArrayA[$l]["interest_id"];
					$selected_interest_array["interest_name"] = $dataArrayA[$l]["interest_name"]; 
					$selected_interest_array["is_approve"] = true;
				    array_push($response["selected_interest_array"], $selected_interest_array);
                }


                  //interest start
  $selected=$d->select("interest_relation_master","member_id='$user_id'");
  $valid_int = mysqli_num_rows($selected);
	
$approval_pending=$d->select("interest_master","added_by_member_id='$user_id' and int_status ='User Added'");
 $approval_pending_cnt = mysqli_num_rows($approval_pending);  
 if( ($valid_int+$approval_pending_cnt) >=5 ){
 	$response["add_interest_flag"] = false;
 } else {
 	$response["add_interest_flag"] = true;
 }

 while ($approval_pending_data=mysqli_fetch_array($approval_pending)) {
 	$selected_interest_array = array();
    $selected_interest_array["interest_id"] = $approval_pending_data["interest_id"];
	$selected_interest_array["interest_name"] = $approval_pending_data["interest_name"]; 
	$selected_interest_array["is_approve"] = false;
    array_push($response["selected_interest_array"], $selected_interest_array);
 }
//interest end

if ($data_app["company_contact_number_privacy"] == 1) {
						 $response["office_number_privacy"] = true;
					  } else {
					  	$response["office_number_privacy"] = false;
				    }

				    if ($data_app["timeline_alert"] == 1) {
						 $response["timeline_privacy"] = false;
					  } else {
					  	$response["timeline_privacy"] = true;
				    }

				$response["message"] = "Profile Details";
				$response["status"] = "200";
				echo json_encode($response);
			} else {

				$response["message"] = "Something Wrong";
				$response["status"] = "201";
				echo json_encode($response);
			}


		}  else   if (isset($get_other_member_details) && $get_other_member_details == 'get_other_member_details' && filter_var($user_id, FILTER_VALIDATE_INT) == true && filter_var($member_id, FILTER_VALIDATE_INT) == true) {


			$user_block_master = $d->count_data_direct("user_id","user_block_master", "  block_by='$member_id' and user_id='$user_id'", "");
				if($user_block_master >0 ){
					$response["message"] = "Blocked";
				$response["status"] = "202";
				echo json_encode($response);
				exit();
				} 


			if ($user_id==$member_id) {
				$response["message"] = "Not allowed, Please select other member or company.";
				$response["status"] = "201";
				echo json_encode($response);
				exit();
			}


			$user_follow_master_q = $d->selectRow("follow_id,follow_to","follow_master", "follow_to='$member_id' and follow_by='$user_id'  ", "");
			
			$user_follow_master_array_user = array('0');

			while ($user_follow_master = mysqli_fetch_array($user_follow_master_q)) {
				$user_follow_master_array_user[] = $user_follow_master['follow_to'];
			}



			$user_recent_master_qry = $d->selectRow("id,member_id,user_id,flag","user_recent_master",
				"user_id ='$user_id'", "");

			$user_recent_master_q2 = $d->selectRow("id,member_id,user_id,flag","user_recent_master",
				"user_id ='$user_id' and member_id='$member_id' and flag='$flag'  ", "");


			if(mysqli_num_rows($user_recent_master_qry) > 3 &&  mysqli_num_rows($user_recent_master_q2)== 0 ){
				$save_member_qry= $d->selectRow("id,member_id,user_id,flag","user_recent_master",
					"user_id ='$user_id'", " order by id desc limit 0,3");

				$save_member_array = array('0');
				while ($save_member_data = mysqli_fetch_array($save_member_qry)) {
					$save_member_array[] = $save_member_data['id'];
				}
				$save_member_array = implode(",", $save_member_array);
				$d->delete("user_recent_master", "user_id='$user_id' AND id not in ($save_member_array) ");

			}
			
			if(mysqli_num_rows($user_recent_master_q2) == 0){
				$modify_date = date("Y-m-d H:i:s");
				$m->set_data('member_id', $member_id);
				$m->set_data('user_id', $user_id);
				$m->set_data('flag', $flag);
				$m->set_data('created_at', $modify_date);
				
				$a1 = array(
					'member_id' => $m->get_data('member_id'),
					'user_id' => $m->get_data('user_id'),
					'flag' => $m->get_data('flag'),
					'created_at' => $m->get_data('created_at')
				);
				$d->insert("user_recent_master", $a1);

			}

			$full_data_query = $d->selectRow("users_master.timeline_alert,user_employment_details.gst_number, users_master.user_first_name, users_master.user_last_name,user_employment_details.company_website, users_master.country_code,user_employment_details.company_landline_number,user_employment_details.search_keyword,users_master.alt_mobile, users_master.user_mobile,
				users_master.invoice_download,users_master.plan_renewal_date,users_master.facebook,users_master.instagram,users_master.linkedin,users_master.twitter,users_master.whatsapp_privacy,users_master.email_privacy,user_employment_details.business_description,business_adress_master.adress, business_adress_master.adress2 ,business_adress_master.country_id, business_adress_master.add_latitude, business_adress_master.add_longitude,
user_employment_details.products_servicess,
				users_master.member_date_of_birth,users_master.gender, users_master.whatsapp_number, users_master.user_email,users_master.cllassified_mute,users_master.user_id,business_categories.business_category_id,business_sub_categories.business_sub_category_id,users_master.user_full_name,users_master.zoobiz_id,users_master.public_mobile,users_master.email_privacy,users_master.whatsapp_privacy,users_master.cllassified_mute,users_master.user_mobile,users_master.user_profile_pic,business_categories.category_name,business_sub_categories.sub_category_name,user_employment_details.company_email ,user_employment_details.company_name ,user_employment_details.designation,user_employment_details.company_contact_number,user_employment_details.company_website,user_employment_details.company_logo,user_employment_details.company_broucher,user_employment_details.company_profile,user_employment_details.gst_number , users_master.refer_by ,  users_master.refere_by_name ,  users_master.refere_by_phone_number, users_master.referred_by_user_id , users_master.remark , user_employment_details.company_contact_number_privacy ","users_master,user_employment_details,business_categories,business_sub_categories,business_adress_master",

				"business_adress_master.user_id =users_master.user_id and  business_categories.category_status = 0 and     users_master.user_id='$member_id'  AND business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id  AND users_master.office_member=0 AND users_master.active_status=0  AND user_employment_details.user_id=users_master.user_id  ", "group by users_master.user_id");

if(isset($debug)){
	//echo "business_adress_master.user_id =users_master.user_id and  business_categories.category_status = 0 and     users_master.user_id='$member_id'  AND business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id  AND users_master.office_member=0 AND users_master.active_status=0  AND user_employment_details.user_id=users_master.user_id  ";exit;
}

			if (mysqli_num_rows($full_data_query) > 0) {
				 $users_masterq = $d->selectRow("user_mobile", "users_master", "user_id='$member_id'  AND office_member=0 AND active_status=0 ", " ");
                $users_masterD = mysqli_fetch_array($users_masterq);

$other_user_mobile = $users_masterD["user_mobile"];
 $memberAdded=$d->count_data_direct("user_mobile"," users_master  "," refere_by_phone_number ='$other_user_mobile'");
             if($memberAdded > 0 ){ 
                 
             $response["memberAdded"] =  $memberAdded ;
  
             $q3= $d->selectRow("users_master.user_first_name,users_master.user_last_name, users_master.user_profile_pic,users_master.user_id as uid,users_master.user_full_name,users_master.refer_by,users_master.refere_by_name,users_master.refere_by_phone_number,users_master.remark,users_master.register_date,user_employment_details.company_name,user_employment_details.designation ","users_master,user_employment_details"," user_employment_details.user_id = users_master.user_id and  users_master.refere_by_phone_number  = '$other_user_mobile'  AND users_master.office_member=0 AND users_master.active_status=0   ","");
$response["member_added_details"] = array();
                 while ($data=mysqli_fetch_array($q3)) {
                        extract($data);
                $member_added_details = array(); 

                if($user_profile_pic != ""){

                 $member_added_details["user_profile_pic"] = $base_url . "img/users/members_profile/" . $user_profile_pic;
                } else {
                    $member_added_details["user_profile_pic"]= "";
                }


                $member_added_details["user_id"] = $uid;
                $member_added_details["user_full_name"] = $user_full_name;
                 $member_added_details["short_name"] =strtoupper(substr($data["user_first_name"], 0, 1).substr($data["user_last_name"], 0, 1) );
                $member_added_details["company_name"] = html_entity_decode( $company_name);
                $member_added_details["designation"] = html_entity_decode( $designation);
                  

                 
                 


                if($refer_by=="1") {
                    $member_added_details["refer_by"] = "Social Media";} 
                  else if($refer_by=="2") {$member_added_details["refer_by"]=  "Member / Friend";}
                  else if($refer_by=="3") {$member_added_details["refer_by"] =  "Other";}

                  $member_added_details["refere_by_name"] = $refere_by_name;
                  $member_added_details["refere_by_phone_number"] = $refere_by_phone_number;
                  $member_added_details["remark"] = $remark;
                  $member_added_details["register_date"] = date("d-m-Y h:i:s A",strtotime($register_date));
                  $member_added_details["refere_by_name"] = $refere_by_name;
 
                array_push($response["member_added_details"], $member_added_details);

                    }
                } else {
                    $response["member_added_details"] = array();
                    $response["memberAdded"] ="0";
                }



				$data_app=mysqli_fetch_array($full_data_query);

				  $ref_by_value = $data_app['refer_by'];
				  $refere_by_phone_number = $data_app['refere_by_phone_number'];
				   $ref_user_id = $data_app['referred_by_user_id'];
				 $response["refer_by"] = "Not Available";

				 $response["ref_user_id"] = "0";
				 if($ref_by_value == 1){
				 	$response["refer_by"] = "Social Media";
				 	$response["ref_user_id"] = "0";
				 }
				 if($ref_by_value == 3){
				 	$response["refer_by"] = "Other ";
				 	if($data_app['remark']!=""){
				 		$response["refer_by"] .= '- '.$data_app['remark'];
				 	}
				 	$response["ref_user_id"] = "0";
				 }
/* if(isset($debug)){
	echo  " user_mobile ='$refere_by_phone_number'    "."here";exit;
}*/

				  if($ref_by_value == 2 && $refere_by_phone_number!=''){
				 	$refere_by_phone_number = $data_app['refere_by_phone_number'];
				 	 $users_master_ref=$d->select("users_master","    user_id ='$ref_user_id' ");

				 	 if (mysqli_num_rows($users_master_ref) > 0) {
 
				 	 	$users_master_ref_data = mysqli_fetch_array($users_master_ref);

				 	 	  

					 	$response["refer_by"] = $users_master_ref_data['user_full_name'];
					 	$response["ref_user_id"] = $users_master_ref_data['user_id'];
					 } else {

					 	   
					 	$response["refer_by"] = $data_app['refere_by_name'];
					 	$response["ref_user_id"] = "0";
					 }
				 	 
				 } 
/* if(isset($debug)){
	echo "test";exit;
}*/
				 $response["short_name"] =strtoupper(substr($data_app["user_first_name"], 0, 1).substr($data_app["user_last_name"], 0, 1) );

$tq22=$d->selectRow("users_master.user_id,users_master.user_full_name,users_master.user_profile_pic,business_categories.category_name,business_sub_categories.sub_category_name,user_employment_details.company_name,user_employment_details.designation","users_master,follow_master,user_employment_details,business_categories,business_sub_categories","
  business_categories.category_status = 0 and  
business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id AND follow_master.follow_to=users_master.user_id AND follow_master.follow_by='$member_id'    AND users_master.office_member=0 AND users_master.active_status=0 ","");


 $tq33=$d->selectRow("users_master.user_id,users_master.user_full_name,users_master.user_profile_pic,business_categories.category_name,business_sub_categories.sub_category_name,user_employment_details.company_name,user_employment_details.designation","users_master,follow_master,user_employment_details,business_categories,business_sub_categories","
  business_categories.category_status = 0 and  
business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id AND follow_master.follow_by=users_master.user_id AND follow_master.follow_to='$member_id'  AND users_master.office_member=0 AND users_master.active_status=0 ","");
 
				$following = mysqli_num_rows($tq22);
				$followers = mysqli_num_rows($tq33);
				$response["followers"] = $followers . '';
				$response["following"] = $following . '';



$user_favorite_master = $d->selectRow("users_master.user_id,business_categories.business_category_id,business_sub_categories.business_sub_category_id,users_master.user_full_name,users_master.zoobiz_id,users_master.public_mobile,users_master.user_mobile,users_master.user_profile_pic,business_categories.category_name,business_sub_categories.sub_category_name,user_employment_details.company_name, user_employment_details.company_logo,user_employment_details.designation",
		
		"users_master,user_employment_details,business_categories,business_sub_categories,user_favorite_master", 

		" 

		user_employment_details.user_id = users_master.user_id and
		user_favorite_master.user_id = user_employment_details.user_id and


		user_favorite_master.member_id = '$member_id' and     
		user_favorite_master.flag = 0 and     business_categories.category_status = 0 and  
		business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id  AND users_master.office_member=0 AND users_master.active_status=0  ", "");


			//	$user_favorite_master =  $d->selectRow("member_id","user_favorite_master","user_id='$member_id'", "");
				$favorite = mysqli_num_rows($user_favorite_master);
				$response["favorite"] = $favorite . '';


				$tq11 = $d->selectRow("user_id","timeline_master", "  user_id='$member_id'", "");
				$total_post = mysqli_num_rows($tq11);
				$response["total_post"] = $total_post . '';

				$user_favorite_master = $d->selectRow("user_id","user_favorite_master", "  member_id='$member_id' and user_id='$user_id'", "");
				if(mysqli_num_rows($user_favorite_master) >0 ){
					$response["is_fevorite"] = true;
				} else {
					$response["is_fevorite"] = false;
				}

				$user_block_master = $d->selectRow("user_id","user_block_master", "  user_id='$member_id' and block_by='$user_id'", "");
				if(mysqli_num_rows($user_block_master) >0 ){
					$response["is_blocked"] = true;
				} else {
					$response["is_blocked"] = false;
				}
				
				  $business_adress_master = $d->selectRow("* ", "business_adress_master,cities,states,countries,area_master", "business_adress_master.user_id='$member_id'
					  AND
					business_adress_master.country_id = countries.country_id
					AND
					business_adress_master.state_id = states.state_id
					AND
					business_adress_master.city_id = cities.city_id
					AND
					business_adress_master.area_id = area_master.area_id  order by business_adress_master.adress_type asc  ", " ");

				  $dataArrayA = array();
                $counterA = 0 ;
                foreach ($business_adress_master as  $value) {
                    foreach ($value as $key => $valueNew) {
                        $dataArrayA[$counterA][$key] = $valueNew;
                    }
                    $counterA++;
                }
                $response["address_array"] = array();
                for ($l=0; $l < count($dataArrayA) ; $l++) { 
                	$address_array = array();
				    

				    if($dataArrayA[$l]["adress2"] !=''){
						$address_array["full_address"] = html_entity_decode( $dataArrayA[$l]["adress"] .', '. $dataArrayA[$l]["adress2"] .', '. $dataArrayA[$l]["area_name"].', '. $dataArrayA[$l]["city_name"].', '. $dataArrayA[$l]["state_name"].', '. $dataArrayA[$l]["country_name"]) ;
					} else {
						$address_array["full_address"] = html_entity_decode( $dataArrayA[$l]["adress"] .', '. $dataArrayA[$l]["area_name"].', '. $dataArrayA[$l]["city_name"].', '. $dataArrayA[$l]["state_name"].', '. $dataArrayA[$l]["country_name"] );
					}

					$address_array["latitude"] = $dataArrayA[$l]["add_latitude"];
					$address_array["longitude"] = $dataArrayA[$l]["add_longitude"];
					if($dataArrayA[$l]["adress_type"] == 0){
						$address_array["adress_type_name"] ="Main Office";
					} else {
						$address_array["adress_type_name"] ="Sub Office";
					}
					$address_array["pincode"] = $dataArrayA[$l]["pincode"];

				    array_push($response["address_array"], $address_array);
                }
				  /*$business_adress_master_data = mysqli_fetch_array($business_adress_master);*/

//new
				 /* $qA2 = $d->selectRow("cities.city_name,cities.city_id, states.state_name,states.state_id , countries.country_name,countries.country_id,business_adress_master.adress,business_adress_master.add_latitude,business_adress_master.add_longitude,business_adress_master.pincode, area_master.area_name , area_master.area_id","business_adress_master,cities,states,countries,area_master", "business_adress_master.user_id='$member_id'
					AND adress_type.user_id=0 AND
					business_adress_master.country_id = countries.country_id
					AND
					business_adress_master.state_id = states.state_id
					AND
					business_adress_master.city_id = cities.city_id
					AND
					business_adress_master.area_id = area_master.area_id  ", "");*/
 
					if($dataArrayA[0]["adress2"] !=''){
						$response["primary_address"] =html_entity_decode(  $dataArrayA[0]["adress"] .', '. $dataArrayA[0]["adress2"] .', '. $dataArrayA[0]["area_name"].', '. $dataArrayA[0]["city_name"].', '. $dataArrayA[0]["state_name"].', '. $dataArrayA[0]["country_name"]) ;
					} else {
						$response["primary_address"] = html_entity_decode( $dataArrayA[0]["adress"] .', '. $dataArrayA[0]["area_name"].', '. $dataArrayA[0]["city_name"].', '. $dataArrayA[0]["state_name"].', '. $dataArrayA[0]["country_name"]) ;
					}
				 
//new


				 // $response["primary_address"] = $business_adress_master_data["adress"] .''. $business_adress_master_data["adress2"] ;
				 $response["company_website"] = $data_app["company_website"];
 if($data_app["company_website"] == ""){
				 	$response["company_website"] = "Not Available"; 
				 }

				if($data_app["whatsapp_number"]==0){
					$response["whatsapp_number"] ="";
				}else{

					$country_id = $data_app['country_id'];
				$countries = $d->selectRow("phonecode","countries","country_id='$country_id'", "");
				$countries_data = mysqli_fetch_array($countries);

					$response["whatsapp_number"] = $countries_data['phonecode'].$data_app['whatsapp_number'];
				}



				if($data_app['cllassified_mute']=="1"){
						$response["cllassified_mute"]=true;
					} else {
						$response["cllassified_mute"]=false;
					}
				if($data_app['whatsapp_privacy']=="1"){
						$response["whatsapp_privacy"]=true;
					} else {
						$response["whatsapp_privacy"]=false;
					}
				if($data_app['email_privacy']=="1"){
						$response["email_privacy"]=true;
					} else {
						$response["email_privacy"]=false;
					}
				if($data_app['public_mobile'] =="0"){
						$response["mobile_privacy"]=true;
					} else {
						$response["mobile_privacy"]=false;
					}


				if(in_array($member_id, $user_follow_master_array_user)){
					$response["is_follow"] = true;
				}else {
					$response["is_follow"] = false;
				}

 
$response["add_latitude"] = $data_app["add_latitude"];
$response["add_longitude"] = $data_app["add_longitude"];
 
if($data_app["products_servicess"]!=""){
					$response["product_service"] =  html_entity_decode($data_app["products_servicess"]);
				} else {
					$response["product_service"] = "Not Available";
				}
if($data_app["gst_number"]!=""){
					$response["gst_number"] =  $data_app["gst_number"];
				} else {
					$response["gst_number"] = "Not Available";
				}

if($data_app['company_broucher']!=""){
					$response["company_broucher"] = $base_url . "img/users/company_broucher/" . $data_app['company_broucher'];  
				} else {
					$response["company_broucher"] ="";
				}

if($data_app['company_profile']!=""){
	$response["company_profile"] = $base_url . "img/users/comapany_profile/" . $data_app['company_profile'];  
} else {
	$response["company_profile"] ="";
}

				 if($data_app["adress2"] !=''){
				 	$response["adress"] =html_entity_decode(  $data_app["adress"].', '. $data_app["adress2"]);
				 } else {
				 	$response["adress"] =html_entity_decode(  $data_app["adress"]);
				 }
				
				$response["company_email"] = $data_app["company_email"];

				 if($data_app["company_email"] == ""){
				 	$response["company_email"] = "Not Available"; 
				 }

				$response["designation"] = html_entity_decode($data_app["designation"]);
				if($data_app["company_contact_number"]!=0){
					$response["company_contact_number"] = $data_app["company_contact_number"];
				} else {
					$response["company_contact_number"] = "Not Available";
				}

				if($data_app["company_landline_number"]!=""){
					$response["company_landline_number"] = $data_app["company_landline_number"];
				} else {
					$response["company_landline_number"] = "Not Available";
				}


			if($data_app['company_contact_number_privacy'] =="1"){
					$response["company_contact_number_privacy"]=true;
				} else {
					$response["company_contact_number_privacy"]=false;
				}


if($data_app["company_contact_number"]!=0){
					$data_app['company_contact_number'] = $data_app["company_contact_number"];
				} else {
					$data_app['company_contact_number'] = "Not Available";
				}

				
				if ($data_app["company_contact_number_privacy"] == 1) {
							//$response["company_contact_number"] = "" . substr($data_app['company_contact_number'], 0, 3) . '****' . substr($data_app['company_contact_number'], -3);
					if($response["company_contact_number"] != 0 ){
						$response["company_contact_number"] = "" . substr($data_app['company_contact_number'], 0, 2) . '********';
					} else {
						$response["company_contact_number"] = "Not Available";
					}
					
						} else {
							$response["company_contact_number"] = $data_app["company_contact_number"];

							


						}


					if ($data_app["company_contact_number_privacy"] == 1) {
						 $response["office_number_privacy"] = true;
					  } else {
					  	$response["office_number_privacy"] = false;
				    }

				    if ($data_app["timeline_alert"] == 1) {
						 $response["timeline_privacy"] = false;
					  } else {
					  	$response["timeline_privacy"] = true;
				    }
				
				$response["user_email_old"] = $data_app["user_email"];


				if($data_app['email_privacy']=="1"){
						$response["email_privacy"]=true;
						//$response["user_email"] = "" . substr($data_app['user_email'], 0, 3) . '****' . substr($data_app['user_email'], -3);
						$response["user_email"] = "Private";
					} else {

						if($data_app['user_email']!=''){
							$response["user_email"]=$data_app['user_email'];
						} else {
							$response["user_email"]="Not Available";
						}
						
					}


				if ($data_app["public_mobile"] == 0) {
							//$response["user_mobile"] = "" . substr($data_app['user_mobile'], 0, 3) . '****' . substr($data_app['user_mobile'], -3);
					$response["user_mobile"] = "" . substr($data_app['user_mobile'], 0, 2) . '********';
						} else {
							$response["user_mobile"] = $data_app["user_mobile"];
						}

						
				
				//$response["search_keyword"] = html_entity_decode($data_app["search_keyword"]);

				$response["search_keyword"] = array();
				if($data_app["search_keyword"]!=""){
					$search_keyword = explode(",", $data_app["search_keyword"]);
					$tag=array();
					for ($p=0; $p < count($search_keyword) ; $p++) { 
						if(trim($search_keyword[$p]) !=""){
							$tag['tag'] = html_entity_decode($search_keyword[$p]);
						    array_push($response["search_keyword"], $tag);
						}
						
					}
					
				}


				$response["company_website"] = $data_app["company_website"];
 if($data_app["company_website"] == ""){
				 	$response["company_website"] = "Not Available"; 
				 }
				$response["user_id"] = $data_app["user_id"];
				$response["zoobiz_id"] = $data_app["zoobiz_id"];
				$response["facebook"] = $data_app["facebook"];
				$response["instagram"] = $data_app["instagram"];
				$response["linkedin"] = $data_app["linkedin"];
				$response["twitter"] = $data_app["twitter"];

				$response["gender"] = $data_app["gender"];

				$response["business_category_id"] = $data_app["business_category_id"];
				$response["business_sub_category_id"] = $data_app["business_sub_category_id"];
				$response["user_full_name"] = $data_app["user_full_name"];
				$response["zoobiz_id"] = $data_app["zoobiz_id"];

				if($data_app['user_profile_pic']!=""){
					$response["user_profile_pic"] = $base_url . "img/users/members_profile/" . $data_app['user_profile_pic'];
				} else {
					$response["user_profile_pic"] ="";
				}

				if($data_app['company_logo']!=""){
					$response["company_logo"] = $base_url . "img/users/company_logo/" . $data_app['company_logo'];
				} else {
					$response["company_logo"] ="";
				}

				$response["bussiness_category_name"] = html_entity_decode($data_app["category_name"]);
				$response["sub_category_name"] = html_entity_decode($data_app["sub_category_name"]) . '';
				$response["company_name"] = html_entity_decode($data_app["company_name"]) . '';
				 

				if($data_app["business_description"]!=""){
					$response["business_description"] = html_entity_decode($data_app["business_description"]);
				} else {
					$response["business_description"] = "Not Available";
				}



				$response["message"] = "Other Member Profile Details";
				$response["status"] = "200";
				echo json_encode($response);
			} else {

				$response["message"] = "Something Wrong";
				$response["status"] = "201";
				echo json_encode($response);
			}


		} else   if (isset($get_interested_member_details) && $get_interested_member_details == 'get_interested_member_details' && filter_var($user_id, FILTER_VALIDATE_INT) == true && filter_var($member_id, FILTER_VALIDATE_INT) == true) {


			$full_data_query = $d->selectRow(" user_employment_details.search_keyword,users_master.alt_mobile, users_master.user_mobile,
				users_master.invoice_download,users_master.plan_renewal_date,users_master.facebook,users_master.instagram,users_master.linkedin,users_master.twitter,users_master.whatsapp_privacy,users_master.email_privacy,user_employment_details.business_description,

				users_master.member_date_of_birth,users_master.gender, users_master.whatsapp_number, users_master.user_email,users_master.cllassified_mute,users_master.user_id,business_categories.business_category_id,business_sub_categories.business_sub_category_id,users_master.user_full_name,users_master.zoobiz_id,users_master.public_mobile,users_master.user_mobile,users_master.user_profile_pic,business_categories.category_name,business_sub_categories.sub_category_name,user_employment_details.company_email ,user_employment_details.company_name ,user_employment_details.designation,user_employment_details.company_contact_number,user_employment_details.company_website,user_employment_details.company_logo,user_employment_details.company_broucher,user_employment_details.company_profile,user_employment_details.gst_number","users_master,user_employment_details,business_categories,business_sub_categories ",

				"  business_categories.category_status = 0 and     users_master.user_id='$member_id'  AND business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id  AND users_master.office_member=0 AND users_master.active_status=0  ", "");

			if (mysqli_num_rows($full_data_query) > 0) {
				$data_app=mysqli_fetch_array($full_data_query);


				$qA2 = $d->selectRow("cities.city_name,cities.city_id, states.state_name,states.state_id , countries.country_name,countries.country_id,business_adress_master.adress,business_adress_master.adress2 ,business_adress_master.add_latitude,business_adress_master.add_longitude,business_adress_master.pincode, area_master.area_name , area_master.area_id","business_adress_master,cities,states,countries,area_master", "business_adress_master.user_id='$member_id'
					AND
					business_adress_master.country_id = countries.country_id
					AND
					business_adress_master.state_id = states.state_id
					AND
					business_adress_master.city_id = cities.city_id
					AND
					business_adress_master.area_id = area_master.area_id  ", "");
				$addData = mysqli_fetch_array($qA2);
				$response["area_id"] = $addData["area_id"];
				$response["area_name"] = $addData["area_name"];
				 
if($addData["pincode"]==0){
					$response["pincode"] = "";
				} else {
					$response["pincode"] = $addData["pincode"];
				}
				$response["adress"] = html_entity_decode( $addData["adress"]);
				$response["adress2"] =html_entity_decode(  $addData["adress2"]);

				$response["state_id"] = $addData["state_id"];
				$response["state_name"] = $addData["state_name"];
				$response["city_id"] = $addData["city_id"];
				$response["city_name"] = $addData["city_name"];


				$user_favorite_master = $d->selectRow("user_id","user_favorite_master", "  member_id='$member_id' and user_id='$user_id'", "");
				if(mysqli_num_rows($user_favorite_master) >0 ){
					$response["is_fevorite"] = true;
				} else {
					$response["is_fevorite"] = false;
				}

				
				$response["designation"] = html_entity_decode($data_app["designation"]);
				
				$response["user_email"] = $data_app["user_email"];

				$response["user_mobile"] = $data_app["user_mobile"];
				$response["search_keyword"] = html_entity_decode($data_app["search_keyword"]);
				

				$response["user_id"] = $data_app["user_id"];
				$response["zoobiz_id"] = $data_app["zoobiz_id"];
				


				$response["business_category_id"] = $data_app["business_category_id"];
				$response["business_sub_category_id"] = $data_app["business_sub_category_id"];
				$response["user_full_name"] = $data_app["user_full_name"];
				$response["zoobiz_id"] = $data_app["zoobiz_id"];


if($data_app['user_profile_pic']==""){
$response["user_profile_pic"] = "";
} else {
	$response["user_profile_pic"] = $base_url . "img/users/members_profile/" . $data_app['user_profile_pic'];
}
				
				$response["bussiness_category_name"] = html_entity_decode($data_app["category_name"]);
				$response["sub_category_name"] = html_entity_decode($data_app["sub_category_name"]) . '';
				$response["company_name"] = html_entity_decode($data_app["company_name"]) . '';
				$response["business_description"] = html_entity_decode($data_app["business_description"]) . '';

				$response["message"] = "Interested Member Profile Details";
				$response["status"] = "200";
				echo json_encode($response);
			} else {

				$response["message"] = "Something Wrong";
				$response["status"] = "201";
				echo json_encode($response);
			}


		}  else if (isset($setUsage) && $setUsage == 'setUsage' && filter_var($user_id, FILTER_VALIDATE_INT) == true) {
			if ($user_id != '') {

				$aUsage = array(
					'user_id' => $user_id,
					'usage_date_time' => $todayTime,
				);

				$d->insert("app_usage_master", $aUsage);
				$response["message"] = "Log Done";
				$response["status"] = "200";
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