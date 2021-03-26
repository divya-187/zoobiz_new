<?php
include_once 'lib.php';

 

if (isset($_POST) && !empty($_POST)) {

	if ($key == $keydb) {
 
		$response = array();
		extract(array_map("test_input", $_POST));

		if ($_POST['memberFavorite'] == "memberFavorite" && isset($flag) && isset($member_id) && isset($user_id)  ) {
			
			if(isset($is_delete) && $is_delete=='true'){
				$d->delete("user_favorite_master", "user_id='$user_id' AND member_id='$member_id' and flag='$flag' ");
				if($d == TRUE){ 
					

					$quc=$d->selectRow("user_full_name,user_token,device,user_id","users_master","user_id='$member_id'   AND office_member=0 AND active_status=0  ");
                    $userData=mysqli_fetch_array($quc);


$response["message"] =  $userData['user_full_name']."'s Profile Unliked";
$qucn=$d->selectRow("user_full_name,user_token,device,user_id,user_profile_pic","users_master","user_id='$user_id'   AND office_member=0 AND active_status=0  ");
                    $userDataN=mysqli_fetch_array($qucn);

                    
 $sos_user_token=$userData['user_token'];
                $device=$userData['device'];
                $feed_user_id=$userData['user_id'];
                $title= $userDataN['user_full_name'] ;
                $msg= "UnLiked Your Profile";

                /* $notiAry = array(
                  'user_id'=>$member_id,
                  'notification_title'=>$userDataN['user_full_name'] ,
                  'notification_desc'=>$msg,    
                  'notification_date'=>date('Y-m-d H:i'),
                  'notification_action'=>'viewMemeber',
                  'notification_logo'=>'profile.png',
                  'notification_type'=>'9',
                  'other_user_id'=>$user_id,
                  'timeline_id'=>'',
                  );
                  $d->insert("user_notification",$notiAry);
                  if($userDataN['user_full_name']!=""){
                  	$img = $base_url . "img/users/members_profile/" . $userDataN['user_profile_pic'];
                  } else {
                  	$img ="";
                  }*/
                  
               /* if (strtolower($device) =='android') {
                   $nResident->noti("viewMemeber",$img,0,$sos_user_token,$title,$msg,$member_id);
                }  else if(strtolower($device) =='ios') {
                  $nResident->noti_ios("viewMemeber",$img,0,$sos_user_token,$title,$msg,$member_id);
                }*/


					$d->insert_myactivity($user_id,"0","",$userData['user_full_name']." Removed from Member Like.","activity.png");
 
					$response["status"] = "200";
					echo json_encode($response);
				} else {
					$response["message"] = "Something Wrong";
					$response["status"] = "201";
					echo json_encode($response);
				}
			} else {

 $user_favorite_master = $d->selectRow("user_id","user_favorite_master",
				"member_id ='$member_id' and user_id='$user_id' and flag='$flag'  ", "");
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
				$d->insert("user_favorite_master", $a1);
} else {
	$response["message"] = "Already Liked";
					$response["status"] = "201";
					echo json_encode($response);
}

				if($d == TRUE){ 

$quc=$d->selectRow("user_full_name,user_token,device,user_id","users_master","user_id='$member_id'   AND office_member=0 AND active_status=0 ");
                $userData=mysqli_fetch_array($quc);

                
					$qucn=$d->selectRow("user_full_name,user_token,device,user_id,user_profile_pic","users_master","user_id='$user_id'   AND office_member=0 AND active_status=0  ");
                    $userDataN=mysqli_fetch_array($qucn);
 $user_token=$userData['user_token'];
  
                $device=$userData['device'];
                $feed_user_id=$userData['user_id'];
                $title= "Like" ;
                $msg= $userDataN['user_full_name'] ." Liked Your Profile";

                 $notiAry = array(
                  'user_id'=>$member_id,
                  'notification_title'=>$userDataN['user_full_name'],
                  'notification_desc'=>$msg,    
                  'notification_date'=>date('Y-m-d H:i'),
                  'notification_action'=>'viewMemeber',
                  'notification_logo'=>'profile.png',
                  'notification_type'=>'9',
                  'other_user_id'=>$user_id,
                  'timeline_id'=>'',
                  );
                  $d->insert("user_notification",$notiAry);

$users_master_by = $d->select("users_master", "user_id='$user_id'   AND active_status=0  ");
$users_master_by_data = mysqli_fetch_array($users_master_by);
if($users_master_by_data['user_profile_pic']!=""){

    $profile_u = $base_url . "img/users/members_profile/" . $users_master_by_data['user_profile_pic'];
  } else {
    $profile_u ="https://zoobiz.in/zooAdmin/img/user.png";
  }
                if (strtolower($device) =='android') {
                   $nResident->noti("viewMemeber",$img,0,$user_token,$title,$msg,$user_id,1,$profile_u);
                }  else if(strtolower($device) =='ios') {
                  $nResident->noti_ios("viewMemeber",$img,0,$user_token,$title,$msg,$user_id,1,$profile_u);
                }


					

					$d->insert_myactivity($user_id,"0","",$userData['user_full_name']." Member Liked.","activity.png");
					$response["message"] = "Liked ".$userData['user_full_name']. "'s Profile";

					$response["status"] = "200";
					echo json_encode($response);
				} else {
					$response["message"] = "Something Wrong";
					$response["status"] = "201";
					echo json_encode($response);
				}

			}

		} else if ($_POST['getFavoriteMembers'] == "getFavoriteMembers" && filter_var($user_id, FILTER_VALIDATE_INT) == true ) {
			

	
	$meq = $d->selectRow(" users_master.user_first_name,users_master.user_last_name, users_master.user_id,business_categories.business_category_id,business_sub_categories.business_sub_category_id,users_master.user_full_name,users_master.zoobiz_id,users_master.public_mobile,users_master.user_mobile,users_master.user_profile_pic,business_categories.category_name,business_sub_categories.sub_category_name,user_employment_details.company_name, user_employment_details.company_logo,user_employment_details.designation",
		
		"user_employment_details,business_categories,business_sub_categories,user_favorite_master,users_master", 

		"user_favorite_master.user_id = users_master.user_id and   user_favorite_master.member_id = '$user_id' and 
		user_favorite_master.user_id != '$user_id' and     
		user_favorite_master.flag = 0 and     business_categories.category_status = 0 and  
		business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id   AND users_master.office_member=0 AND users_master.active_status=0    ", "");

	$user_favorite_master_q = $d->selectRow("member_id,flag","user_favorite_master", "member_id='$user_id'  ", "");
	
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
		
		$response["favoriteMember"] = array();
		while ($data = mysqli_fetch_array($meq)) {
			$member  = array();
			$member["user_id"] = $data["user_id"];
			$member["short_name"] =strtoupper(substr($data["user_first_name"], 0, 1).substr($data["user_last_name"], 0, 1) );
			$member["user_name"] = $data["user_full_name"];
			$member["company_name"] = html_entity_decode($data["company_name"]);
			$member["designation"] = html_entity_decode($data["designation"]);
			$member["category_name"] = $data["category_name"];
			$member["sub_category_name"] = $data["sub_category_name"];

			if($data['user_profile_pic'] !=""){
				$member["user_profile_pic"] = $base_url . "img/users/members_profile/" . $data['user_profile_pic'];
			} else {
				$member["user_profile_pic"] ="";
			}
			
			$member["type"] = "0";

			if(in_array($data['user_id'], $user_favorite_master_array_user)){
				$member["is_fevorite"] = "1";
			}else {
				$member["is_fevorite"] = "0";
			}

			array_push($response["favoriteMember"], $member);
		}

		/*$meq2 = $d->selectRow("users_master.user_id,business_categories.business_category_id,business_sub_categories.business_sub_category_id,users_master.user_full_name,users_master.zoobiz_id,users_master.public_mobile,users_master.user_mobile,users_master.user_profile_pic,business_categories.category_name,business_sub_categories.sub_category_name,user_employment_details.company_name, user_employment_details.company_logo, user_employment_details.designation",
			
			"users_master,user_employment_details,business_categories,business_sub_categories,user_favorite_master", 

			"user_favorite_master.member_id = users_master.user_id and   user_favorite_master.member_id = '$user_id' and 
		user_favorite_master.user_id != '$user_id' and     
			user_favorite_master.flag = 1 and  business_categories.category_status = 0 and  
			business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id   ", "");

		while ($data = mysqli_fetch_array($meq2)) {
			$member  = array();
			$member["user_id"] = $data["user_id"];
			 
			$member["user_name"] = html_entity_decode($data["company_name"]);
			$member["company_name"] = html_entity_decode($data["company_name"]);
			$member["designation"] = html_entity_decode($data["designation"]);
			$member["category_name"] = $data["category_name"];
			$member["sub_category_name"] = $data["sub_category_name"];

			if($data['company_logo'] !=""){
				$member["user_profile_pic"] = $base_url . "img/users/company_logo/" . $data['company_logo'];
			} else {
				$member["user_profile_pic"] ="";
			}
			
			$member["type"] = "1";

			if(in_array($data['user_id'], $user_favorite_master_array_company)){
				$member["is_fevorite"] = "1";
			}else {
				$member["is_fevorite"] = "0";
			}
			
			array_push($response["favoriteMember"], $member);
		}*/


		
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