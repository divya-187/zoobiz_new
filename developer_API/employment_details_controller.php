<?php
include_once 'lib.php';

/*ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);*/

if (isset($_POST) && !empty($_POST)) {

	if ($key == $keydb) {

		$response = array();
		extract(array_map("test_input", $_POST));


		if (isset($edit_profile_and_logo) && $edit_profile_and_logo == 'edit_profile_and_logo' && filter_var($user_id, FILTER_VALIDATE_INT) == true) {



			if(file_exists($_FILES['company_logo']['tmp_name'])) {
				$extensionResume=array("png","jpg","jpeg","PNG","JPG","JPEG");
				$extId = pathinfo($_FILES['company_logo']['name'], PATHINFO_EXTENSION);
				$errors     = array();
				$maxsize    = 10097152;
				if(($_FILES['company_logo']['size'] >= $maxsize) || ($_FILES["company_logo"]["size"] == 0)) {
					$response["message"] = "Company Logo too large. Must be less than 5 MB.";
					$response["status"] = "201";
					echo json_encode($response);
					exit;

				}
				if(!in_array($extId, $extensionResume) && (!empty($_FILES["company_logo"]["type"]))) {
					$response["message"] = "Invalid Company Logo File format, Only  JPG,PDF, PNG are allowed.";
					$response["status"] = "201";
					echo json_encode($response);
					exit;

				}
			}

			if(file_exists($_FILES['user_profile_pic']['tmp_name'])) {
				$extensionResume=array("png","jpg","jpeg","PNG","JPG","JPEG");
				$extId = pathinfo($_FILES['user_profile_pic']['name'], PATHINFO_EXTENSION);
				$errors     = array();
				$maxsize    = 10097152;
				if(($_FILES['user_profile_pic']['size'] >= $maxsize) || ($_FILES["user_profile_pic"]["size"] == 0)) {
					$response["message"] = "Profile Pic too large. Must be less than 5 MB.";
					$response["status"] = "201";
					echo json_encode($response);
					exit;

				}
				if(!in_array($extId, $extensionResume) && (!empty($_FILES["user_profile_pic"]["type"]))) {
					$response["message"] = "Invalid Profile Pic File format, Only  JPG,PDF, PNG are allowed.";
					$response["status"] = "201";
					echo json_encode($response);
					exit;

				}
			}
			$uploaded = 0;
			$user_profile_pic_val="";
			$user_profile_pic = $_FILES['user_profile_pic']['tmp_name'];
			if(file_exists($user_profile_pic)) { 
				$uploadedFile = $_FILES["user_profile_pic"]["tmp_name"];
				$ext = pathinfo($_FILES['user_profile_pic']['name'], PATHINFO_EXTENSION);
				if (file_exists($uploadedFile)) {

					$sourceProperties = getimagesize($uploadedFile);
					$newFileName = rand() . $user_id;
					$dirPath = "../img/users/members_profile/";
					$imageType = $sourceProperties[2];
					$imageHeight = $sourceProperties[1];
					$imageWidth = $sourceProperties[0];


					move_uploaded_file($_FILES["user_profile_pic"]["tmp_name"], "../img/users/members_profile/".$newFileName . "_profile." . $ext); 

					$profile_name = $newFileName . "_profile." . $ext;
					$user_profile_pic_val = $base_url . "../img/users/members_profile/".$newFileName . "_profile." . $ext;
				} else {

					$response["message"] = "Invalid Photo Format for Profile Pic.";
					$response["status"] = "201";
					echo json_encode($response);
					exit();
				}

				$m->set_data('user_profile_pic', $profile_name);

				$a = array('user_profile_pic' => $m->get_data('user_profile_pic'));

				$q = $d->update("users_master", $a, "user_id='$user_id'");
				if($q == true){
					$uploaded = 1;
				}
			}


			$uploaded_logo = 0;
			$file = $_FILES['company_logo']['tmp_name'];
			if(file_exists($file)) {
				$extensionResume=array("png","jpg","jpeg","PNG","JPG","JPEG");
				$extId = pathinfo($_FILES['company_logo']['name'], PATHINFO_EXTENSION);

				$errors     = array();


				$image_Arr = $_FILES['company_logo'];   
				$temp = explode(".", $_FILES["company_logo"]["name"]);


				$users_master = $d->selectRow("user_mobile","users_master", "user_id ='$user_id'");
				$users_master_data = mysqli_fetch_array($users_master);
				$company_logo = $users_master_data['user_mobile'].'_company_logo_'.round(microtime(true)) . '.' . end($temp);

				move_uploaded_file($_FILES["company_logo"]["tmp_name"], "../img/users/company_logo/".$company_logo);

				$company_logo_val = $base_url . "../img/users/company_logo/".$company_logo;
				$m->set_data('company_logo', $company_logo);
				$a = array(
					'company_logo' => $m->get_data('company_logo')
				);
				$q = $d->update("user_employment_details", $a, "user_id='$user_id'");
				if ($q == true) {
                  $uploaded_logo =1;
                }  
			} 

			if($uploaded==1 &&  $uploaded_logo == 1){
				$d->insert_myactivity($user_id,"0","", "Company Logo and Profile Pic Updated","activity.png");
				$response["company_logo"] = $company_logo_val;
				$response["user_profile_pic"] = $user_profile_pic_val;
				$response["message"] = "Company Logo and Profile Pic Updated";
				$response["status"] = "200";
				echo json_encode($response);
				exit();
			} else if($uploaded==1 &&  $uploaded_logo == 0){
				$d->insert_myactivity($user_id,"0","", "Profile Pic Updated","activity.png");

				$response["user_profile_pic"] = $user_profile_pic_val;
				$response["message"] = "Profile Pic Updated";
				$response["status"] = "200";
				echo json_encode($response);
				exit();
			} else if($uploaded==0 &&  $uploaded_logo == 1){
				$d->insert_myactivity($user_id,"0","", "Company Logo  Updated","activity.png");
				$response["company_logo"] = $company_logo_val;

				$response["message"] = "Company Logo Updated";
				$response["status"] = "200";
				echo json_encode($response);
				exit();
			}  else {
				$response["message"] = "Please Provide File";
				$response["status"] = "201";
				echo json_encode($response);
			}



		} else if (isset($edit_company_broucher) && $edit_company_broucher == 'edit_company_broucher' && filter_var($user_id, FILTER_VALIDATE_INT) == true) {
			  


$file11=$_FILES["company_broucher"]["tmp_name"];
            $extId = pathinfo($_FILES['company_broucher']['name'], PATHINFO_EXTENSION);
            $extAllow=array("pdf","doc","docx","png","jpg","jpeg","PNG","JPG","JPEG");

              if(in_array($extId,$extAllow)) {
                 $temp = explode(".", $_FILES["company_broucher"]["name"]);
                  $company_broucher = "company_broucher_".$user_id.round(microtime(true)) . '.' . end($temp);
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
                
                $response["message"]="Invalid Document only JPG,PNG,Doc & PDF are allowed.";
                $response["status"]="201";
                echo json_encode($response);
                exit();
              }

 
			 


		}  else if (isset($edit_company_profile) && $edit_company_profile == 'edit_company_profile' && filter_var($user_id, FILTER_VALIDATE_INT) == true) {
			$file = $_FILES['company_profile']['tmp_name'];
			if(file_exists($file)) {
				$extensionResume=array("pdf","doc","docx","png","jpg","jpeg","PNG","JPG","JPEG");
				$extId = pathinfo($_FILES['company_profile']['name'], PATHINFO_EXTENSION);

				$errors     = array();
				$maxsize    = 10097152;

				/*if(($_FILES['company_profile']['size'] >= $maxsize) || ($_FILES["company_profile"]["size"] == 0)) {


					$response["message"] = "Company profile too large. Must be less than 10 MB.";
					$response["status"] = "201";
					echo json_encode($response);


				}
				if(!in_array($extId, $extensionResume) && (!empty($_FILES["company_profile"]["type"]))) {

					$response["message"] = "Invalid Company Profile File format, Only  JPG,PDF, PNG,Doc are allowed.";
					$response["status"] = "201";
					echo json_encode($response);


				}*/

				$image_Arr = $_FILES['company_profile'];   
				$temp = explode(".", $_FILES["company_profile"]["name"]);
				$users_master = $d->selectRow("user_mobile","users_master", "user_id ='$user_id'");
				$users_master_data = mysqli_fetch_array($users_master);
				$company_profile = $users_master_data['user_mobile'].'_company_profile'.round(microtime(true)) . '.' . end($temp);
				//move_uploaded_file($_FILES["company_profile"]["tmp_name"], "../img/users/comapany_profile/".$company_profile);

				$temp = explode(".", $_FILES["company_profile"]["name"]);
                  $company_broucher = "company_broucher_".$user_id.round(microtime(true)) . '.' . end($temp);
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



		}



		else if ($_POST['add_professional_info'] == "add_professional_info" && filter_var($user_id, FILTER_VALIDATE_INT) == true) {

			$qOld = $d->selectRow("employment_id,company_logo,company_profile,company_broucher","user_employment_details", "employment_id='$employment_id'", "");

			$oldData = mysqli_fetch_array($qOld);

			$searchKeyordArray = explode(",", $search_keyword);
			$search_keyword = implode(", ", $searchKeyordArray);

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


			$a = array(
				'user_id' => $m->get_data('user_id'),
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
