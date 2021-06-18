<?php
include_once 'lib.php';

/*ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);*/

if (isset($_POST) && !empty($_POST)) {

	if ($key == $keydb) {

		$response = array();
		extract(array_map("test_input", $_POST));

		if ($_POST['addRecent'] == "addRecent"  && isset($member_id) && isset($user_id)  ) {
			 $user_recent_master_qry = $d->selectRow("id,member_id,user_id,flag","user_recent_master",
				"user_id ='$user_id'", "");
       if(mysqli_num_rows($user_recent_master_qry) > 3){
				$save_member_qry= $d->selectRow("id,member_id,user_id,flag","user_recent_master",
				"user_id ='$user_id'", " order by id desc limit 0,3");

				$save_member_array = array('0');
				 while ($save_member_data = mysqli_fetch_array($save_member_qry)) {
				 	$save_member_array[] = $save_member_data['id'];
				}
				$save_member_array = implode(",", $save_member_array);
				$d->delete("user_recent_master", "user_id='$user_id' AND id not in ($save_member_array) ");

			}
			 
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


				if($d == TRUE){ 
					$response["message"] = "Added Successfully";
					$response["status"] = "200";
					echo json_encode($response);
				} else {
					$response["message"] = "Something Wrong";
					$response["status"] = "201";
					echo json_encode($response);
				}

			 

		} else if ($_POST['getRecent'] == "getRecent"    && isset($user_id)  ) {
			 $user_recent_master_qry = $d->selectRow("user_recent_master.id,user_recent_master.member_id,user_recent_master.user_id,user_recent_master.flag,user_employment_details.company_name,user_employment_details.company_logo, users_master.user_full_name, users_master.user_profile_pic","user_recent_master,users_master,user_employment_details",
				"user_employment_details.user_id=user_recent_master.member_id and  users_master.user_id =user_recent_master.member_id and   user_recent_master.user_id ='$user_id'", " GROUP by user_recent_master.user_id, user_recent_master.member_id, user_recent_master.flag  order by user_recent_master.id desc limit 0,4 ");




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


       if(mysqli_num_rows($user_recent_master_qry) > 0){
				 	$response["recentMember"] = array();

				 
				 while ($user_recent_master_data = mysqli_fetch_array($user_recent_master_qry)) {
				 	$recentMember = array();
				    $recentMember["user_id"] = $user_recent_master_data['member_id'];
				     
				    	$recentMember["user_full_name"] = $user_recent_master_data['user_full_name'];
				    	if($user_recent_master_data['user_profile_pic'] !=''){
				    		$recentMember["user_profile_pic"] = $base_url . "img/users/members_profile/" . $user_recent_master_data['user_profile_pic'];
				    	} else {
				    		$recentMember["user_profile_pic"] ="";
				    	}
  
				    	 
				   
				    	$recentMember["company_name"] = $user_recent_master_data['company_name'];
				    	if($user_recent_master_data['company_logo'] !=''){
				    		$recentMember["company_logo"] = $base_url . "img/users/company_logo/" . $user_recent_master_data['company_logo'];
				    	} else {
				    		$recentMember["company_logo"] ="";
				    	 }
				    	if($user_recent_master_data['flag']==0){
				    		$recentMember["is_user"] = true;
				    	} else {
				    		$recentMember["is_user"] = false;
				    	}

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
				 

				if($d == TRUE){ 
					$response["message"] = "Added Successfully";
					$response["status"] = "200";
					echo json_encode($response);
				} else {
					$response["message"] = "Something Wrong";
					$response["status"] = "201";
					echo json_encode($response);
				}

			} else {
				$response["message"] = "No Recent Member Found";
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