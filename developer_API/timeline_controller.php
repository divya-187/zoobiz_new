<?php
include_once 'lib.php';
if (isset($_POST) && !empty($_POST)) {
// ini_set('display_errors', '1');
	// ini_set('display_startup_errors', '1');
	// error_reporting(E_ALL);
// //C:\xampp\htdocs\zoobiz\mobileApi\timeline_controller.php
	if ($key == $keydb) {
		$response = array();
		extract(array_map("test_input", $_POST));


				$active_usr_qry=$d->select("users_master","active_status=0");
$active_user_arr = array();
 while($active_usr_data=mysqli_fetch_array($active_usr_qry)) { 
 	$active_user_arr[] = $active_usr_data['user_id'];
 }


		if ($_POST['getFeed'] == "getFeed" && filter_var($user_id, FILTER_VALIDATE_INT) == true) {


	



			$totalFeed = $d->count_data_direct("timeline_id", "timeline_master", "active_status = 0 ");



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
$blocked_users = implode(",", $blocked_users); 

//unset($blocked_users[$user_id]);

/*$blocked_users_new = remove_element($blocked_users,$user_id);
echo "<pre>";print_r($blocked_users_new);exit;*/

 

			if(isset($timeline_id) && $timeline_id !=0  &&  filter_var($timeline_id, FILTER_VALIDATE_INT) == true ){
				$qnotification = $d->selectRow("meetup_user_id2,meetup_user_id1, user_id,timeline_id,timeline_text,feed_type,created_date,feed_type","timeline_master", "active_status = 0 and timeline_id='$timeline_id' and user_id not in ($blocked_users) ", "ORDER BY timeline_id DESC LIMIT $limit_feed,10");
			} else {
				$qnotification = $d->selectRow("meetup_user_id2,meetup_user_id1, user_id,timeline_id,timeline_text,feed_type,created_date,feed_type","timeline_master", "active_status = 0 and user_id not in ($blocked_users) ", "ORDER BY timeline_id DESC LIMIT $limit_feed,10");
			}
			 
			$totalSocietyFeedLimit = $d->count_data_direct("timeline_id", "timeline_master", "active_status = 0 and user_id not in ($blocked_users) ");
			

			$city = $d->selectRow("cities.city_name,cities.city_id","cities,users_master", "cities.city_id=users_master.city_id and users_master.user_id='$user_id'  ", "");
			$city_data = mysqli_fetch_array($city);

			$timeline_user_save_master = $d->selectRow("timeline_id","timeline_user_save_master", "user_id='$user_id'  ", "");
			//$timeline_user_save_master_data = mysqli_fetch_array($timeline_user_save_master);
			$saved_timeline_array = array('0');
			while ($timeline_user_save_master_data = mysqli_fetch_array($timeline_user_save_master)) {
				$saved_timeline_array[] = $timeline_user_save_master_data['timeline_id'];
			}
			//print_r($saved_timeline_array);exit;


//code opt start
			$dataArray = array();
                $counter = 0 ;
                foreach ($qnotification as  $value) {
                    foreach ($value as $key => $valueNew) {
                        $dataArray[$counter][$key] = $valueNew;
                    }
                    $counter++;
                }
                $user_id_array = array('0');
                $timeline_id_array = array('0');
                for ($l=0; $l < count($dataArray) ; $l++) {
                    $user_id_array[] = $dataArray[$l]['user_id'];
                    $timeline_id_array[] = $dataArray[$l]['timeline_id'];
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





               $qch22 = $d->selectRow("user_block_id,block_by","user_block_master", "user_id='$user_id' AND block_by in ($user_id_array) ");


                $blocked_arr = array();
                while($qch22_data=mysqli_fetch_array($qch22)) {
                    $blocked_arr[$qch22_data['block_by']][] = $qch22_data['user_block_id'];
                }

                $user_found_qry =   $d->selectRow(" count(*) as cnt,users_master.user_id","user_employment_details,users_master", " users_master.user_id=user_employment_details.user_id and  users_master.user_id in ($user_id_array)  group by users_master.user_id  ");
                
                 $user_found_arr = array();
                while($user_found_data=mysqli_fetch_array($user_found_qry)) {
                    $user_found_arr[$user_found_data['user_id']] = $user_found_data['cnt'];
                }

                $data_qry = $d->selectRow("users_master.user_id,users_master.user_profile_pic,users_master.user_full_name,user_employment_details.company_name,user_employment_details.company_logo,users_master.user_first_name,users_master.user_last_name,users_master.user_profile_pic, users_master.user_mobile, users_master.public_mobile ","users_master,user_employment_details", "users_master.user_id=user_employment_details.user_id AND users_master.user_id in ($user_id_array) ");
 				

 				 $DArray = array();
                $Dcounter = 0 ;
                foreach ($data_qry as  $value) {
                    foreach ($value as $key => $valueNew) {
                        $DArray[$Dcounter][$key] = $valueNew;
                    }
                    $Dcounter++;
                }
                 $data_arr = array('0');
                for ($da=0; $da < count($DArray) ; $da++) {
                    $data_arr[$DArray[$da]['user_id']] = $DArray[$da];
                }


                $timeline_id_array = implode(",", $timeline_id_array);
                $video_main_qry = $d->selectRow("photo_name,feed_img_height,feed_img_width,video_name,timeline_id,user_id,feed_img_height,feed_img_width","timeline_photos_master", "timeline_id in($timeline_id_array)   AND user_id in ($user_id_array) ");

                $VArray = array();
                $Vcounter = 0 ;
                foreach ($video_main_qry as  $value) {
                    foreach ($value as $key => $valueNew) {
                        $VArray[$Vcounter][$key] = $valueNew;
                    }
                    $Vcounter++;
                }
                 $video_data_arr = array();
                 $video_data_arr2 = array();
                for ($dv=0; $dv < count($VArray) ; $dv++) {
                    $video_data_arr[$VArray[$dv]['timeline_id']."__".$VArray[$dv]['user_id']] = $VArray[$dv];
                    $video_data_arr2[$VArray[$dv]['timeline_id']."__".$VArray[$dv]['user_id']][] = $VArray[$dv];
                }

                $qlike_qry = $d->selectRow("users_master.user_first_name,users_master.user_last_name,timeline_like_master.like_id,timeline_like_master.timeline_id,timeline_like_master.user_id,users_master.user_full_name,users_master.user_profile_pic,timeline_like_master.modify_date,user_employment_details.company_logo,users_master.user_profile_pic","timeline_like_master,users_master,user_employment_details", "user_employment_details.user_id = users_master.user_id and  timeline_like_master.timeline_id in($timeline_id_array) AND timeline_like_master.user_id=users_master.user_id AND timeline_like_master.active_status=0 group by timeline_like_master.timeline_id, timeline_like_master.user_id");
 
                 $LArray = array();
                $Lcounter = 0 ;
                foreach ($qlike_qry as  $value) {
                    foreach ($value as $key => $valueNew) {
                        $LArray[$Lcounter][$key] = $valueNew;
                    }
                    $Lcounter++;
                }
                 
                 $qlike_array = array();
                for ($dl=0; $dl < count($LArray) ; $dl++) {
                    $qlike_array[$LArray[$dl]['timeline_id']][] = $LArray[$dl];
                 }
 				

 				$qcomment = $d->selectRow("users_master.user_first_name,users_master.user_last_name,timeline_comments.comments_id, timeline_comments.timeline_id,timeline_comments.msg,users_master.user_full_name,users_master.user_id,users_master.user_profile_pic,timeline_comments.modify_date,timeline_comments.comments_id ,user_employment_details.company_logo, user_employment_details.company_name,users_master.user_profile_pic","timeline_comments,users_master,user_employment_details", "user_employment_details.user_id = users_master.user_id and  timeline_comments.timeline_id in ($timeline_id_array) AND timeline_comments.user_id=users_master.user_id AND timeline_comments.parent_comments_id=0", " group by timeline_comments.comments_id  ORDER BY timeline_comments.comments_id DESC");
 				$CArray = array();
                $Ccounter = 0 ;
                foreach ($qcomment as  $value) {
                    foreach ($value as $key => $valueNew) {
                        $CArray[$Ccounter][$key] = $valueNew;
                    }
                    $Ccounter++;
                }
                 
                 $cmt_array = array();
                 $parent_comments_id_array = array('0');
                for ($dc=0; $dc < count($CArray) ; $dc++) {
                    $cmt_array[$CArray[$dc]['timeline_id']][] = $CArray[$dc];
                    $parent_comments_id_array[] = $CArray[$dc]['comments_id'];
                 }

                 $parent_comments_id_array = implode(",", $parent_comments_id_array);

                 $sub_cmt_qry = $d->selectRow("users_master.user_first_name,users_master.user_last_name,timeline_comments.parent_comments_id,timeline_comments.comments_id,timeline_comments.timeline_id,timeline_comments.msg,users_master.user_full_name,users_master.user_id,users_master.user_profile_pic,timeline_comments.modify_date,user_employment_details.company_logo, user_employment_details.company_name,users_master.user_profile_pic","timeline_comments,users_master,user_employment_details", "user_employment_details.user_id = users_master.user_id and   timeline_comments.timeline_id in ($timeline_id_array) AND timeline_comments.user_id=users_master.user_id AND timeline_comments.parent_comments_id in ($parent_comments_id_array)  ", "ORDER BY timeline_comments.comments_id DESC");
                 $SCArray = array();
                $SCcounter = 0 ;
                foreach ($sub_cmt_qry as  $value) {
                    foreach ($value as $key => $valueNew) {
                        $SCArray[$SCcounter][$key] = $valueNew;
                    }
                    $SCcounter++;
                }
                 
                 $sub_cmt_array = array();
                 
                for ($dsc=0; $dsc < count($SCArray) ; $dsc++) {
                    $sub_cmt_array[$SCArray[$dsc]['timeline_id']."__".$SCArray[$dsc]['parent_comments_id']][] = $SCArray[$dsc];
                 }
              //echo "<pre>";print_r($sub_cmt_array);exit;
//code opt end



			if (count($dataArray) > 0) {
				$response["feed"] = array();
				for ($tf=0; $tf < count($dataArray) ; $tf++) {
$data_notification = $dataArray[$tf];

 
 if( ($data_notification['meetup_user_id2'] != 0 &&  !in_array($data_notification['meetup_user_id2'], $active_user_arr) ) || (   $data_notification['meetup_user_id1'] != 0 &&  !in_array($data_notification['meetup_user_id1'], $active_user_arr) )  && 0  ){
 	continue;
}

					


					


				 
					$qch22 = $blocked_arr[$data_notification[user_id]];// $d->selectRow("user_block_id","user_block_master", "user_id='$user_id' AND block_by='$data_notification[user_id]' ");
					//new
					$user_found =1;
					if ($data_notification['user_id'] != 0) {
						$time_line_user = $data_notification['user_id'];
						$user_found = $user_counter = $user_found_arr[$time_line_user]; // $d->count_data_direct("user_id","user_employment_details,users_master", " users_master.user_id=user_employment_details.user_id and  users_master.user_id='$time_line_user'  ");
					}
					if($user_found){

						$feed = array();

					//new
						if ($data_notification['user_id'] != 0) {
							//$qu =$data_arr[$data_notification[user_id]]; // $d->selectRow("users_master.user_profile_pic,users_master.user_full_name,user_employment_details.company_name,user_employment_details.company_logo","users_master,user_employment_details", "users_master.user_id=user_employment_details.user_id AND users_master.user_id='$data_notification[user_id]' ");
							$userData = $data_arr[$data_notification[user_id]] ;// mysqli_fetch_array($qu);
							if($userData['user_profile_pic']!=""){
								//$userProfile = $base_url . "img/users/company_logo/" . $userData['company_logo'];
								$userProfile = $base_url . "img/users/members_profile/" . $userData['user_profile_pic'];
							} else {
								$userProfile ="";
							}

							$user_full_name = $userData['user_full_name'];
							//11march
							$feed["user_mobile"] =  $userData["user_mobile"];
							if($userData['public_mobile'] =="0"){
								$feed["mobile_privacy"]=true;
							} else {
								$feed["mobile_privacy"]=false;
							}
							//11march

							$company_name = html_entity_decode($userData['company_name']);
							$feed["short_name"] =strtoupper(substr($userData["user_first_name"], 0, 1).substr($userData["user_last_name"], 0, 1) );

						} else {
							$userProfile = $base_url . "img/fav.png";
							$user_full_name = "ZooBiz";
							$company_name = "Admin";
							$feed["short_name"] ="ZB";
							//11march
							$feed["user_mobile"] =  "";
							$feed["mobile_privacy"]=false;
							//11march
							 
						}
						

						$qche = $fol_array[$data_notification[user_id]];//  
					if (count($qche) > 0) {
						$follow_status = true;
					} else {
						$follow_status = false;
					}

					$feed["is_follow"] = $follow_status;
					if($data_notification[user_id]==$user_id || $data_notification[user_id]==0 ){
						 $feed["show_follow_icon"] = false;
					} else {
						$feed["show_follow_icon"] = true;
					}
					
						$feed["timeline_id"] = $data_notification['timeline_id'];
						$feed["timeline_text"] = htmlspecialchars_decode (stripslashes(  html_entity_decode($data_notification['timeline_text']. ' ' . $block_status )) );   
						$feed["timeline_text"] = html_entity_decode($data_notification["timeline_text"] , ENT_QUOTES);
 
						 $feed["timeline_text"] = htmlspecialchars_decode($feed["timeline_text"], ENT_QUOTES);
						$feed["timeline_text"] =html_entity_decode ($feed["timeline_text"]);


						$feed["user_name"] = $user_full_name;
						$feed["city_id"] = $city_data['city_id'];
						$feed["city_name"] = $city_data['city_name'];

						if(in_array($data_notification['timeline_id'], $saved_timeline_array)){
							$feed["is_saved"] = true;
						}else {
							$feed["is_saved"] = false;
						}
						

						$feed["company_name"] = $company_name;
						$feed["feed_type"] = $data_notification['feed_type'];
						$feed["meetup_user_id2"] = $data_notification['meetup_user_id2'];
						if($data_notification['meetup_user_id2'] != 0 ){
							$meetup_user_id2 = $data_notification['meetup_user_id2'];

							$meetup_user_id2_qry = $d->selectRow("*","users_master", "  user_id='$meetup_user_id2' and active_status = 0  ", "");

							if (mysqli_num_rows($meetup_user_id2_qry)>0) {
								$meetup_user_id2_data = mysqli_fetch_array($meetup_user_id2_qry);
								$feed["meetup_user_name2"] =$meetup_user_id2_data['user_full_name'];
								$feed["user_short_name2"] =strtoupper(substr($meetup_user_id2_data["user_first_name"], 0, 1).substr($meetup_user_id2_data["user_last_name"], 0, 1) );
							 	if($meetup_user_id2_data['user_profile_pic']!=""){
						        $feed["meetup_user_profile_pic2"] = $base_url . "img/users/members_profile/" . $meetup_user_id2_data['user_profile_pic'];
						      } else {
						        $feed["meetup_user_profile_pic2"] ="";
						      }
							} else {
								$feed["user_short_name2"] ="";
								$feed["meetup_user_name2"] ="";
								$feed["meetup_user_profile_pic2"] ="";
								$feed["meetup_user_id2"] = "0" ; 
							}
							

						} else {
							$feed["user_short_name2"] ="";
							$feed["meetup_user_name2"] ="";
							$feed["meetup_user_profile_pic2"] ="";
						}
						$feed["meetup_user_id1"] = $data_notification['meetup_user_id1'];

						if($data_notification['meetup_user_id1'] != 0 ){
							$meetup_user_id1 = $data_notification['meetup_user_id1'];
							$meetup_user_id1_qry = $d->selectRow("*","users_master", "  user_id='$meetup_user_id1' and active_status = 0 ", "");

							if (mysqli_num_rows($meetup_user_id1_qry)>0) {
								$meetup_user_id1_data = mysqli_fetch_array($meetup_user_id1_qry);
							$feed["meetup_user_name1"] =$meetup_user_id1_data['user_full_name'];
							$feed["user_short_name1"] =strtoupper(substr($meetup_user_id1_data["user_first_name"], 0, 1).substr($meetup_user_id1_data["user_last_name"], 0, 1) );
							 if($meetup_user_id1_data['user_profile_pic']!=""){
						        $feed["meetup_user_profile_pic1"] = $base_url . "img/users/members_profile/" . $meetup_user_id1_data['user_profile_pic'];
						      } else {
						        $feed["meetup_user_profile_pic1"] ="";
						      }
						  } else {
						  	$feed["user_short_name1"] ="";
							$feed["meetup_user_name1"] ="";
							$feed["meetup_user_profile_pic1"] ="";
							$feed["meetup_user_id1"] = "0" ; 
						  }
							

						} else {
							$feed["user_short_name1"] ="";
							$feed["meetup_user_name1"] ="";
							$feed["meetup_user_profile_pic1"] ="";
						}
						


						$feed["user_id"] = $data_notification['user_id'];
						$feed["user_profile_pic"] = $userProfile;
						$timeline_id = $data_notification['timeline_id'];
						if($data_notification['feed_type'] == "2"){

							//$video_qry = $d->selectRow("photo_name,feed_img_height,feed_img_width,video_name","timeline_photos_master", "timeline_id='$timeline_id' AND user_id='$data_notification[user_id]'");
							$video_data = $video_data_arr[$timeline_id."__".$data_notification[user_id]]; // mysqli_fetch_array($video_qry);
							$feed["video_thumb"] = $base_url . "img/timeline/" . $video_data['photo_name'];
							$feed["feed_video"] = $base_url . "img/timeline/" . $video_data['video_name'];
						}else {
							$feed["video_thumb"] ="";
							$feed["feed_video"] ="";
						}

						/*$fi = $d->selectRow("photo_name,feed_img_height,feed_img_width,video_name","timeline_photos_master", "timeline_id='$timeline_id' AND user_id='$data_notification[user_id]'");*/

						$timeline_photos_master_data =$video_data_arr2[$timeline_id."__".$data_notification[user_id]]; 
						 
						$feed["timeline_photos"] = array();

						for ($tp=0; $tp < count($timeline_photos_master_data) ; $tp++) {  

							$feeData =$timeline_photos_master_data[$tp];
							$timeline_photos = array();

							
							
							
							$timeline_photos["photo_name"] = $base_url . "img/timeline/" . $feeData['photo_name'];

							$timeline_photos["feed_height"] = $feeData['feed_img_height'];
							$timeline_photos["feed_width"] = $feeData['feed_img_width'];
							array_push($feed["timeline_photos"], $timeline_photos);
						}
						$feed["feed_type"] = $data_notification['feed_type'];
						/*	$feed["modify_date"] = time_elapsed_string($data_notification['created_date']);*/
						if(strtotime($data_notification['created_date']) < strtotime('-30 days')) {
							$feed["modify_date"] = date("j M Y", strtotime($data_notification['created_date']));
						} else {
							$feed["modify_date"] = time_elapsed_string($data_notification['created_date']);
						}
						/*$qlike = $d->selectRow("timeline_like_master.like_id,timeline_like_master.timeline_id,timeline_like_master.user_id,users_master.user_full_name,users_master.user_profile_pic,timeline_like_master.modify_date,user_employment_details.company_logo","timeline_like_master,users_master,user_employment_details", "user_employment_details.user_id = users_master.user_id and  timeline_like_master.timeline_id='$timeline_id' AND timeline_like_master.user_id=users_master.user_id AND timeline_like_master.active_status=0 group by timeline_like_master.timeline_id, timeline_like_master.user_id");*/
						$totalLikes = count($qlike_array[$timeline_id]);
						$feed["totalLikes"] = "$totalLikes";
						if (count($qlike_array[$timeline_id]) > 0) {
							$feed["like"] = array();
							$feed["like_status"] = "0";

							$like_d = $qlike_array[$timeline_id];
							for ($la=0; $la < count($like_d) ; $la++) { 
								$data_like =$like_d[$la];
							 	//echo "<pre>";print_r($data_like);exit;
								$like = array();
								$like["like_id"] = $data_like['like_id'];
								$like["timeline_id"] = $data_like['timeline_id'];
								$like["user_id"] = $data_like['user_id'];
								if ($user_id == $data_like['user_id']) {
									$feed["like_status"] = "1";
								} else {
									if ($feed["like_status"] == "1") {
									} else {
										$feed["like_status"] = "0";
									}
								}
								$like["user_name"] = $data_like['user_full_name'];

								if($data_like['user_profile_pic'] !=""){
									$like["user_profile_pic"] = $base_url . "img/users/members_profile/" . $data_like['user_profile_pic'];
								} else {
									$like["user_profile_pic"] ="";
								}

								$like["short_name"] =strtoupper(substr($data_like["user_first_name"], 0, 1).substr($data_like["user_last_name"], 0, 1) );
								




								$like["modify_date"] = "";// $data_like['modify_date'];
								array_push($feed["like"], $like);
							}
						} else {
							$feed["like_status"] = "0";
						}
						/*$qcomment = $d->selectRow("timeline_comments.timeline_id,timeline_comments.msg,users_master.user_full_name,users_master.user_id,users_master.user_profile_pic,timeline_comments.modify_date,timeline_comments.comments_id ,user_employment_details.company_logo","timeline_comments,users_master,user_employment_details", "user_employment_details.user_id = users_master.user_id and  timeline_comments.timeline_id='$timeline_id' AND timeline_comments.user_id=users_master.user_id AND timeline_comments.parent_comments_id=0", "ORDER BY timeline_comments.comments_id DESC");*/
						$comment_status = "0" ;
						$comment_data = $cmt_array[$timeline_id];
						if (count($comment_data) > 0) {
							$feed["comment"] = array();

							for ($tc=0; $tc < count($comment_data) ; $tc++) { 
								$data_comment =$comment_data[$tc];
							 
								$comment = array();
								$comment["comments_id"] = $data_comment['comments_id'];
								$comment["timeline_id"] = $data_comment['timeline_id'];
								$comment["msg"] = html_entity_decode($data_comment['msg']);
								$comment["company_name"] = html_entity_decode($data_comment['company_name']);
								$comment["user_name"] = $data_comment['user_full_name'];
								$comment["user_id"] = $data_comment['user_id'];

								if($data_comment['user_profile_pic'] !=""){
									$comment["user_profile_pic"] = $base_url . "img/users/members_profile/" . $data_comment['user_profile_pic'];
								} else {
									$comment["user_profile_pic"] ="";
								}

								$comment["short_name"] =strtoupper(substr($data_comment["user_first_name"], 0, 1).substr($data_comment["user_last_name"], 0, 1) );



								if ($user_id == $data_comment['user_id']) {
									$comment["comment_status"] = "1";
								} else {
									$comment["comment_status"] = "0";
								}

								if($comment_status=="0"){
									if (  $user_id == $data_comment['user_id'] ) {
									    $feed["comment_status"] = "1";
									    $comment_status = "1";
									} else {
										$feed["comment_status"] = "0";
									}
								}
								
							//$comment["modify_date"] = time_elapsed_string($data_comment['modify_date']);
								if(strtotime($data_comment['modify_date']) < strtotime('-30 days')) {
									$comment["modify_date"] = date("j M Y", strtotime($data_notification['created_date']));
								} else {
									$comment["modify_date"] = time_elapsed_string($data_comment['modify_date']);
								}
								$comment["sub_comment"] = array();
								/*$q4 = $d->selectRow("timeline_comments.comments_id,timeline_comments.timeline_id,timeline_comments.msg,users_master.user_full_name,users_master.user_id,users_master.user_profile_pic,timeline_comments.modify_date,user_employment_details.company_logo","timeline_comments,users_master,user_employment_details", "user_employment_details.user_id = users_master.user_id and   timeline_comments.timeline_id='$timeline_id' AND timeline_comments.user_id=users_master.user_id AND timeline_comments.parent_comments_id='$data_comment[comments_id]'", "ORDER BY timeline_comments.comments_id DESC");*/

								$sub_cmt_data_arr = $sub_cmt_array[$timeline_id."__".$data_comment['comments_id']];
								for ($scd=0; $scd < count($sub_cmt_data_arr) ; $scd++) { 
									$subCommentData = $sub_cmt_data_arr[$scd];
								 
									$sub_comment = array();
									$sub_comment["comments_id"] = $subCommentData['comments_id'];
									$sub_comment["timeline_id"] = $subCommentData['timeline_id'];
									$sub_comment["msg"] = html_entity_decode($subCommentData['msg']);
									$sub_comment["company_name"] = html_entity_decode($subCommentData['company_name']);

									

									$sub_comment["user_name"] = $subCommentData['user_full_name'];
									$sub_comment["user_id"] = $subCommentData['user_id'];

									if($comment_status=="0"){
									   if (  $user_id == $subCommentData['user_id'] ) {
									    $feed["comment_status"] = "1";
									    $comment_status = "1";
										} else {
											$feed["comment_status"] = "0";
										}
								   }



									if($subCommentData['user_profile_pic'] !=""){
										$sub_comment["user_profile_pic"] = $base_url . "img/users/members_profile/" . $subCommentData['user_profile_pic'];
									} else {
										$sub_comment["user_profile_pic"] ="";
									}

									$sub_comment["short_name"] =strtoupper(substr($subCommentData["user_first_name"], 0, 1).substr($subCommentData["user_last_name"], 0, 1) );


								//$sub_comment["modify_date"] = time_elapsed_string($subCommentData['modify_date']);
									if(strtotime($subCommentData['modify_date']) < strtotime('-30 days')) {
										$sub_comment["modify_date"] = date("j M Y", strtotime($subCommentData['modify_date']));
									} else {
										$sub_comment["modify_date"]= time_elapsed_string($subCommentData['modify_date']);
									}
									array_push($comment["sub_comment"], $sub_comment);
								}
								array_push($feed["comment"], $comment);
							}
						} else {
							$feed["comment_status"] = "0";
						}
						if (mysqli_num_rows($qch22) == 0) {
							array_push($response["feed"], $feed);
						}
					}
				}
				// print_r($response["feed"]);
				$q2222 = $d->selectRow("user_notification_id","user_notification", "user_id='$user_id' AND  notification_type=1 AND read_status=0   and status='Active' ");
				$response["unread_notification"] = mysqli_num_rows($q2222);
				$response["pos1"] = $pos1 + 0;
				$response["totalSocietyFeedLimit"] = '' . $totalSocietyFeedLimit + count($mainFeed);
				$response["message"] = "Get Feeds success.";
				$response["totalFeed"] =(string) $totalFeed;
				$response["status"] = "200";
				echo json_encode($response);
			} else {
				$response["message"] = "Post Removed";
				$response["status"] = "201";
				echo json_encode($response);
			}
		} else if ($_POST['getSavedFeed'] == "getSavedFeed" && filter_var($user_id, FILTER_VALIDATE_INT) == true) {
			$totalFeed = $d->count_data_direct("timeline_id", "timeline_master", "active_status = 0 ");



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
$blocked_users = implode(",", $blocked_users);



			$qnotification = $d->selectRow("*","timeline_user_save_master,timeline_master", "timeline_master.active_status = 0 and timeline_master.timeline_id  = timeline_user_save_master.timeline_id  and timeline_user_save_master.user_id='$user_id' and timeline_master.user_id not in ($blocked_users) ", "ORDER BY timeline_user_save_master.id DESC LIMIT $limit_feed,10");
if(isset($debug)){
	echo "timeline_master.active_status = 0 and timeline_master.timeline_id  = timeline_user_save_master.timeline_id  and timeline_user_save_master.user_id='$user_id' and timeline_master.user_id not in ($blocked_users) ", "ORDER BY timeline_user_save_master.id DESC LIMIT $limit_feed,10";
}
			
			$totalSocietyFeedLimit = $d->count_data_direct("timeline_id", "timeline_master", "active_status = 0  and user_id not in ($blocked_users) ");
			

			$city = $d->selectRow("cities.city_name,cities.city_id","cities,users_master", "cities.city_id=users_master.city_id and users_master.user_id='$user_id'  ", "");
			$city_data = mysqli_fetch_array($city);

			$timeline_user_save_master = $d->selectRow("timeline_id","timeline_user_save_master", "user_id='$user_id'  ", "");
			//$timeline_user_save_master_data = mysqli_fetch_array($timeline_user_save_master);
			$saved_timeline_array = array('0');
			while ($timeline_user_save_master_data = mysqli_fetch_array($timeline_user_save_master)) {
				$saved_timeline_array[] = $timeline_user_save_master_data['timeline_id'];
			}
			//print_r($saved_timeline_array);exit;


//code opt start
			$dataArray = array();
                $counter = 0 ;
                foreach ($qnotification as  $value) {
                    foreach ($value as $key => $valueNew) {
                        $dataArray[$counter][$key] = $valueNew;
                    }
                    $counter++;
                }
                $user_id_array = array('0');
                $timeline_id_array = array('0');
                for ($l=0; $l < count($dataArray) ; $l++) {
                    $user_id_array[] = $dataArray[$l]['user_id'];
                    $timeline_id_array[] = $dataArray[$l]['timeline_id'];
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


               $qch22 = $d->selectRow("user_block_id,block_by","user_block_master", "user_id='$user_id' AND block_by in ($user_id_array) ");


                $blocked_arr = array();
                while($qch22_data=mysqli_fetch_array($qch22)) {
                    $blocked_arr[$qch22_data['block_by']][] = $qch22_data['user_block_id'];
                }

                $user_found_qry =   $d->selectRow(" count(*) as cnt,users_master.user_id","user_employment_details,users_master", " users_master.user_id=user_employment_details.user_id and  users_master.user_id in ($user_id_array)  group by users_master.user_id  ");
                
                 $user_found_arr = array();
                while($user_found_data=mysqli_fetch_array($user_found_qry)) {
                    $user_found_arr[$user_found_data['user_id']] = $user_found_data['cnt'];
                }

                $data_qry = $d->selectRow("users_master.user_first_name,users_master.user_last_name, users_master.user_id,users_master.user_profile_pic,users_master.user_full_name,user_employment_details.company_name,user_employment_details.company_logo,users_master.user_profile_pic,users_master.user_mobile, users_master.public_mobile","users_master,user_employment_details", "users_master.user_id=user_employment_details.user_id AND users_master.user_id in ($user_id_array) ");
 				

 				 $DArray = array();
                $Dcounter = 0 ;
                foreach ($data_qry as  $value) {
                    foreach ($value as $key => $valueNew) {
                        $DArray[$Dcounter][$key] = $valueNew;
                    }
                    $Dcounter++;
                }
                 $data_arr = array();
                for ($da=0; $da < count($DArray) ; $da++) {
                    $data_arr[$DArray[$da]['user_id']] = $DArray[$da];
                }


                $timeline_id_array = implode(",", $timeline_id_array);
                $video_main_qry = $d->selectRow("photo_name,feed_img_height,feed_img_width,video_name,timeline_id,user_id,feed_img_height,feed_img_width","timeline_photos_master", "timeline_id in($timeline_id_array)   AND user_id in ($user_id_array) ");

                $VArray = array();
                $Vcounter = 0 ;
                foreach ($video_main_qry as  $value) {
                    foreach ($value as $key => $valueNew) {
                        $VArray[$Vcounter][$key] = $valueNew;
                    }
                    $Vcounter++;
                }
                 $video_data_arr = array();
                 $video_data_arr2 = array();
                for ($dv=0; $dv < count($VArray) ; $dv++) {
                    $video_data_arr[$VArray[$dv]['timeline_id']."__".$VArray[$dv]['user_id']] = $VArray[$dv];
                    $video_data_arr2[$VArray[$dv]['timeline_id']."__".$VArray[$dv]['user_id']][] = $VArray[$dv];
                }

                $qlike_qry = $d->selectRow("users_master.user_first_name,users_master.user_last_name, timeline_like_master.like_id,timeline_like_master.timeline_id,timeline_like_master.user_id,users_master.user_full_name,users_master.user_profile_pic,timeline_like_master.modify_date,user_employment_details.company_logo,users_master.user_profile_pic","timeline_like_master,users_master,user_employment_details", "user_employment_details.user_id = users_master.user_id and  timeline_like_master.timeline_id in($timeline_id_array) AND timeline_like_master.user_id=users_master.user_id AND timeline_like_master.active_status=0 group by timeline_like_master.timeline_id, timeline_like_master.user_id");
 
                 $LArray = array();
                $Lcounter = 0 ;
                foreach ($qlike_qry as  $value) {
                    foreach ($value as $key => $valueNew) {
                        $LArray[$Lcounter][$key] = $valueNew;
                    }
                    $Lcounter++;
                }
                 
                 $qlike_array = array();
                for ($dl=0; $dl < count($LArray) ; $dl++) {
                    $qlike_array[$LArray[$dl]['timeline_id']][] = $LArray[$dl];
                 }
 				

 				$qcomment = $d->selectRow("users_master.user_first_name,users_master.user_last_name, timeline_comments.comments_id, timeline_comments.timeline_id,timeline_comments.msg,users_master.user_full_name,users_master.user_id,users_master.user_profile_pic,timeline_comments.modify_date,timeline_comments.comments_id  ,user_employment_details.company_logo, user_employment_details.company_name,users_master.user_profile_pic","timeline_comments,users_master,user_employment_details", "user_employment_details.user_id = users_master.user_id and  timeline_comments.timeline_id in ($timeline_id_array) AND timeline_comments.user_id=users_master.user_id AND timeline_comments.parent_comments_id=0", "ORDER BY timeline_comments.comments_id DESC");
 				$CArray = array();
                $Ccounter = 0 ;
                foreach ($qcomment as  $value) {
                    foreach ($value as $key => $valueNew) {
                        $CArray[$Ccounter][$key] = $valueNew;
                    }
                    $Ccounter++;
                }
                 
                 $cmt_array = array();
                 $parent_comments_id_array = array('0');
                for ($dc=0; $dc < count($CArray) ; $dc++) {
                    $cmt_array[$CArray[$dc]['timeline_id']][] = $CArray[$dc];
                    $parent_comments_id_array[] = $CArray[$dc]['comments_id'];
                 }

                 $parent_comments_id_array = implode(",", $parent_comments_id_array);

                 $sub_cmt_qry = $d->selectRow("users_master.user_first_name,users_master.user_last_name, timeline_comments.parent_comments_id,timeline_comments.comments_id,timeline_comments.timeline_id,timeline_comments.msg,users_master.user_full_name,users_master.user_id,users_master.user_profile_pic,timeline_comments.modify_date,user_employment_details.company_logo, user_employment_details.company_name,users_master.user_profile_pic","timeline_comments,users_master,user_employment_details", "user_employment_details.user_id = users_master.user_id and   timeline_comments.timeline_id in ($timeline_id_array) AND timeline_comments.user_id=users_master.user_id AND timeline_comments.parent_comments_id in ($parent_comments_id_array)  ", "ORDER BY timeline_comments.comments_id DESC");
                 $SCArray = array();
                $SCcounter = 0 ;
                foreach ($sub_cmt_qry as  $value) {
                    foreach ($value as $key => $valueNew) {
                        $SCArray[$SCcounter][$key] = $valueNew;
                    }
                    $SCcounter++;
                }
                 
                 $sub_cmt_array = array();
                 
                for ($dsc=0; $dsc < count($SCArray) ; $dsc++) {
                    $sub_cmt_array[$SCArray[$dsc]['timeline_id']."__".$SCArray[$dsc]['parent_comments_id']][] = $SCArray[$dsc];
                 }
              //echo "<pre>";print_r($sub_cmt_array);exit;
//code opt end

/*if(isset($debug)){
	print_r($dataArray);exit;
}*/

			if (count($dataArray) > 0) {
				$response["feed"] = array();
				for ($tf=0; $tf < count($dataArray) ; $tf++) {
$feed = array();
	$data_notification = $dataArray[$tf];

 if( ($data_notification['meetup_user_id2'] != 0 &&  !in_array($data_notification['meetup_user_id2'], $active_user_arr) ) || (   $data_notification['meetup_user_id1'] != 0 &&  !in_array($data_notification['meetup_user_id1'], $active_user_arr) )  && 0  ){
 	continue;
}


				
				 
					$qch22 = $blocked_arr[$data_notification[user_id]];// $d->selectRow("user_block_id","user_block_master", "user_id='$user_id' AND block_by='$data_notification[user_id]' ");
					//new
					$user_found =1;
					if ($data_notification['user_id'] != 0) {
						$time_line_user = $data_notification['user_id'];
						$user_found = $user_counter = $user_found_arr[$time_line_user]; // $d->count_data_direct("user_id","user_employment_details,users_master", " users_master.user_id=user_employment_details.user_id and  users_master.user_id='$time_line_user'  ");
					}
					if($user_found){
					//new
						if ($data_notification['user_id'] != 0) {
							//$qu =$data_arr[$data_notification[user_id]]; // $d->selectRow("users_master.user_profile_pic,users_master.user_full_name,user_employment_details.company_name,user_employment_details.company_logo","users_master,user_employment_details", "users_master.user_id=user_employment_details.user_id AND users_master.user_id='$data_notification[user_id]' ");
							$feed["post_u_id"] =$data_notification[user_id];
							$userData = $data_arr[$data_notification[user_id]] ;// mysqli_fetch_array($qu);
							if($userData['user_profile_pic']!=""){
								$userProfile = $base_url . "img/users/members_profile/" . $userData['user_profile_pic'];
							} else {
								$userProfile ="";
							}

							


							$user_full_name = $userData['user_full_name'];

							//11march
							$feed["user_mobile"] =  $userData["user_mobile"];
							if($userData['public_mobile'] =="0"){
								$feed["mobile_privacy"]=true;
							} else {
								$feed["mobile_privacy"]=false;
							}
							//11march
							$company_name = html_entity_decode($userData['company_name']);
							$feed["short_name"] =strtoupper(substr($userData["user_first_name"], 0, 1).substr($userData["user_last_name"], 0, 1) );
$feed["user_name"] = $user_full_name;
						} else {
							$userProfile = $base_url . "img/fav.png";
							$user_full_name = "ZooBiz";
							$company_name = "Admin";
							$feed["short_name"] ="ZB";
$feed["user_name"] = $user_full_name;

$feed["user_mobile"] =  "";
$feed["mobile_privacy"]=false;
							 
						}
						
						$feed["timeline_id"] = $data_notification['timeline_id'];


						$qche = $fol_array[$data_notification[user_id]];//  
					if (count($qche) > 0) {
						$follow_status = true;
					} else {
						$follow_status = false;
					}

					$feed["is_follow"] = $follow_status;
					 

					if($my_id==$user_id || $data_notification[user_id]==0 ){
						 $feed["show_follow_icon"] = false;
					} else {
						$feed["show_follow_icon"] = true;
					}




						$feed["meetup_user_id2"] = $data_notification['meetup_user_id2'];
						if($data_notification['meetup_user_id2'] != 0 ){
							$meetup_user_id2 = $data_notification['meetup_user_id2'];
							$meetup_user_id2_qry = $d->selectRow("*","users_master", "  user_id='$meetup_user_id2' and active_status = 0  ", "");

							if (mysqli_num_rows($meetup_user_id2_qry)>0) {
								$meetup_user_id2_data = mysqli_fetch_array($meetup_user_id2_qry);
							$feed["meetup_user_name2"] =$meetup_user_id2_data['user_full_name'];
							$feed["user_short_name2"] =strtoupper(substr($meetup_user_id2_data["user_first_name"], 0, 1).substr($meetup_user_id2_data["user_last_name"], 0, 1) );
							 if($meetup_user_id2_data['user_profile_pic']!=""){
						        $feed["meetup_user_profile_pic2"] = $base_url . "img/users/members_profile/" . $meetup_user_id2_data['user_profile_pic'];
						      } else {
						        $feed["meetup_user_profile_pic2"] ="";
						      }
							} else {
								$feed["user_short_name2"] ="";
								$feed["meetup_user_name2"] ="";
								$feed["meetup_user_profile_pic2"] ="";
								$feed["meetup_user_id2"] =0;
							}
							

						} else {
							$feed["user_short_name2"] ="";
							$feed["meetup_user_name2"] ="";
							$feed["meetup_user_profile_pic2"] ="";
						}
						$feed["meetup_user_id1"] = $data_notification['meetup_user_id1'];

						if($data_notification['meetup_user_id1'] != 0 ){
							$meetup_user_id1 = $data_notification['meetup_user_id1'];
							$meetup_user_id1_qry = $d->selectRow("*","users_master", "  user_id='$meetup_user_id1' and active_status = 0  ", "");

							if (mysqli_num_rows($meetup_user_id1_qry)>0) {

								$meetup_user_id1_data = mysqli_fetch_array($meetup_user_id1_qry);
							$feed["meetup_user_name1"] =$meetup_user_id1_data['user_full_name'];
							$feed["user_short_name1"] =strtoupper(substr($meetup_user_id1_data["user_first_name"], 0, 1).substr($meetup_user_id1_data["user_last_name"], 0, 1) );
							 if($meetup_user_id1_data['user_profile_pic']!=""){
						        $feed["meetup_user_profile_pic1"] = $base_url . "img/users/members_profile/" . $meetup_user_id1_data['user_profile_pic'];
						      } else {
						        $feed["meetup_user_profile_pic1"] ="";
						      }
							} else {
								$feed["user_short_name1"] ="";
							$feed["meetup_user_name1"] ="";
							$feed["meetup_user_profile_pic1"] ="";
							$feed["meetup_user_id1"] =0;
							}
							

						} else {
							$feed["user_short_name1"] ="";
							$feed["meetup_user_name1"] ="";
							$feed["meetup_user_profile_pic1"] ="";
						}





						$feed["timeline_text"] =  htmlspecialchars_decode (stripslashes(  html_entity_decode($data_notification['timeline_text']. ' ' . $block_status )) );    

						$feed["timeline_text"] = html_entity_decode($feed["timeline_text"] , ENT_QUOTES);
 $feed["timeline_text"] = htmlspecialchars_decode($feed["timeline_text"], ENT_QUOTES);
						$feed["timeline_text"] =html_entity_decode ($feed["timeline_text"]);
 

						
						$feed["city_id"] = $city_data['city_id'];
						$feed["city_name"] = $city_data['city_name'];

						if(in_array($data_notification['timeline_id'], $saved_timeline_array)){
							$feed["is_saved"] = true;
						}else {
							$feed["is_saved"] = false;
						}
						

						$feed["company_name"] = $company_name;
						$feed["feed_type"] = $data_notification['feed_type'];
						$feed["user_id"] = $data_notification['user_id'];
						$feed["user_profile_pic"] = $userProfile;
						$timeline_id = $data_notification['timeline_id'];
						if($data_notification['feed_type'] == "2"){

							//$video_qry = $d->selectRow("photo_name,feed_img_height,feed_img_width,video_name","timeline_photos_master", "timeline_id='$timeline_id' AND user_id='$data_notification[user_id]'");
							$video_data = $video_data_arr[$timeline_id."__".$data_notification[user_id]]; // mysqli_fetch_array($video_qry);
							$feed["video_thumb"] = $base_url . "img/timeline/" . $video_data['photo_name'];
							$feed["feed_video"] = $base_url . "img/timeline/" . $video_data['video_name'];
						}else {
							$feed["video_thumb"] ="";
							$feed["feed_video"] ="";
						}

						/*$fi = $d->selectRow("photo_name,feed_img_height,feed_img_width,video_name","timeline_photos_master", "timeline_id='$timeline_id' AND user_id='$data_notification[user_id]'");*/

						$timeline_photos_master_data =$video_data_arr2[$timeline_id."__".$data_notification[user_id]]; 
						 
						$feed["timeline_photos"] = array();

						for ($tp=0; $tp < count($timeline_photos_master_data) ; $tp++) {  

							$feeData =$timeline_photos_master_data[$tp];
							$timeline_photos = array();

							
							
							
							$timeline_photos["photo_name"] = $base_url . "img/timeline/" . $feeData['photo_name'];

							$timeline_photos["feed_height"] = $feeData['feed_img_height'];
							$timeline_photos["feed_width"] = $feeData['feed_img_width'];
							array_push($feed["timeline_photos"], $timeline_photos);
						}
						$feed["feed_type"] = $data_notification['feed_type'];
						/*	$feed["modify_date"] = time_elapsed_string($data_notification['created_date']);*/
						if(strtotime($data_notification['created_date']) < strtotime('-30 days')) {
							$feed["modify_date"] = date("j M Y", strtotime($data_notification['created_date']));
						} else {
							$feed["modify_date"] = time_elapsed_string($data_notification['created_date']);
						}
						/*$qlike = $d->selectRow("timeline_like_master.like_id,timeline_like_master.timeline_id,timeline_like_master.user_id,users_master.user_full_name,users_master.user_profile_pic,timeline_like_master.modify_date,user_employment_details.company_logo","timeline_like_master,users_master,user_employment_details", "user_employment_details.user_id = users_master.user_id and  timeline_like_master.timeline_id='$timeline_id' AND timeline_like_master.user_id=users_master.user_id AND timeline_like_master.active_status=0 group by timeline_like_master.timeline_id, timeline_like_master.user_id");*/
						$totalLikes = count($qlike_array[$timeline_id]);
						$feed["totalLikes"] = "$totalLikes";
						if (count($qlike_array[$timeline_id]) > 0) {
							$feed["like"] = array();
							$feed["like_status"] = "0";

							$like_d = $qlike_array[$timeline_id];
							for ($la=0; $la < count($like_d) ; $la++) { 
								$data_like =$like_d[$la];
							 	//echo "<pre>";print_r($data_like);exit;
								$like = array();
								$like["like_id"] = $data_like['like_id'];
								$like["timeline_id"] = $data_like['timeline_id'];
								$like["user_id"] = $data_like['user_id'];
								if ($user_id == $data_like['user_id']) {
									$feed["like_status"] = "1";
								} else {
									if ($feed["like_status"] == "1") {
									} else {
										$feed["like_status"] = "0";
									}
								}
								$like["user_name"] = $data_like['user_full_name'];

								if($data_like['user_profile_pic'] !=""){
									$like["user_profile_pic"] = $base_url . "img/users/members_profile/" . $data_like['user_profile_pic'];
								} else {
									$like["user_profile_pic"] ="";
								}

								$like["short_name"] =strtoupper(substr($data_like["user_first_name"], 0, 1).substr($data_like["user_last_name"], 0, 1) );

								$like["modify_date"] ="";// $data_like['modify_date'];
								array_push($feed["like"], $like);
							}
						} else {
							$feed["like_status"] = "0";
						}
						/*$qcomment = $d->selectRow("timeline_comments.timeline_id,timeline_comments.msg,users_master.user_full_name,users_master.user_id,users_master.user_profile_pic,timeline_comments.modify_date,timeline_comments.comments_id ,user_employment_details.company_logo","timeline_comments,users_master,user_employment_details", "user_employment_details.user_id = users_master.user_id and  timeline_comments.timeline_id='$timeline_id' AND timeline_comments.user_id=users_master.user_id AND timeline_comments.parent_comments_id=0", "ORDER BY timeline_comments.comments_id DESC");*/

						$comment_data = $cmt_array[$timeline_id];
						if (count($comment_data) > 0) {
							$feed["comment"] = array();

							for ($tc=0; $tc < count($comment_data) ; $tc++) { 
								$data_comment =$comment_data[$tc];
							 
								$comment = array();
								$comment["comments_id"] = $data_comment['comments_id'];
								$comment["timeline_id"] = $data_comment['timeline_id'];
								$comment["msg"] = html_entity_decode($data_comment['msg']);

								$comment["company_name"] = html_entity_decode($data_comment['company_name']);

								
								$comment["user_name"] = $data_comment['user_full_name'];
								$comment["user_id"] = $data_comment['user_id'];

								if($data_comment['user_profile_pic'] !=""){
									$comment["user_profile_pic"] = $base_url . "img/users/members_profile/" . $data_comment['user_profile_pic'];
								} else {
									$comment["user_profile_pic"] ="";
								}

								$comment["short_name"] =strtoupper(substr($data_comment["user_first_name"], 0, 1).substr($data_comment["user_last_name"], 0, 1) );


								if ($user_id == $data_comment['user_id']) {
									$feed["comment_status"] = "1";
								} else {
									$feed["comment_status"] = "0";
								}
							//$comment["modify_date"] = time_elapsed_string($data_comment['modify_date']);
								if(strtotime($data_comment['modify_date']) < strtotime('-30 days')) {
									$comment["modify_date"] = date("j M Y", strtotime($data_notification['created_date']));
								} else {
									$comment["modify_date"] = time_elapsed_string($data_comment['modify_date']);
								}
								$comment["sub_comment"] = array();
								/*$q4 = $d->selectRow("timeline_comments.comments_id,timeline_comments.timeline_id,timeline_comments.msg,users_master.user_full_name,users_master.user_id,users_master.user_profile_pic,timeline_comments.modify_date,user_employment_details.company_logo","timeline_comments,users_master,user_employment_details", "user_employment_details.user_id = users_master.user_id and   timeline_comments.timeline_id='$timeline_id' AND timeline_comments.user_id=users_master.user_id AND timeline_comments.parent_comments_id='$data_comment[comments_id]'", "ORDER BY timeline_comments.comments_id DESC");*/

								$sub_cmt_data_arr = $sub_cmt_array[$timeline_id."__".$data_comment['comments_id']];
								for ($scd=0; $scd < count($sub_cmt_data_arr) ; $scd++) { 
									$subCommentData = $sub_cmt_data_arr[$scd];
								 
									$sub_comment = array();
									$sub_comment["comments_id"] = $subCommentData['comments_id'];
									$sub_comment["timeline_id"] = $subCommentData['timeline_id'];
									$sub_comment["msg"] = html_entity_decode($subCommentData['msg']);
									$sub_comment["company_name"] = html_entity_decode($subCommentData['company_name']);

									$sub_comment["user_name"] = $subCommentData['user_full_name'];
									$sub_comment["user_id"] = $subCommentData['user_id'];

									if($subCommentData['user_profile_pic'] !=""){
										$sub_comment["user_profile_pic"] = $base_url . "img/users/members_profile/" . $subCommentData['user_profile_pic'];
									} else {
										$sub_comment["user_profile_pic"] ="";
									}

									$sub_comment["short_name"] =strtoupper(substr($subCommentData["user_first_name"], 0, 1).substr($subCommentData["user_last_name"], 0, 1) );

								//$sub_comment["modify_date"] = time_elapsed_string($subCommentData['modify_date']);
									if(strtotime($subCommentData['modify_date']) < strtotime('-30 days')) {
										$sub_comment["modify_date"] = date("j M Y", strtotime($subCommentData['modify_date']));
									} else {
										$sub_comment["modify_date"]= time_elapsed_string($subCommentData['modify_date']);
									}
									array_push($comment["sub_comment"], $sub_comment);
								}
								array_push($feed["comment"], $comment);
							}
						} else {
							$feed["comment_status"] = "0";
						}
						if (mysqli_num_rows($qch22) == 0) {
							array_push($response["feed"], $feed);
						}
					}
				}

					if(empty($response["feed"])){
						$response["message"] = "No Data Found";
					$response["status"] = "201";
					echo json_encode($response);
						} else { 
							// print_r($response["feed"]);
							$q2222 = $d->selectRow("user_notification_id","user_notification", "user_id='$user_id' AND  notification_type=1 AND read_status=0  and status='Active' ");
							$response["unread_notification"] = mysqli_num_rows($q2222);
							$response["pos1"] = $pos1 + 0;
							$response["totalSocietyFeedLimit"] = '' . $totalSocietyFeedLimit + count($mainFeed);
							$response["message"] = "Saved Feeds";
							$response["totalFeed"] =(string) $totalFeed;
							$response["status"] = "200";
							echo json_encode($response);
						}
			} else {
				$response["message"] = "No Data Found";
				$response["status"] = "201";
				echo json_encode($response);
			}

		} 
		else if ($_POST['addFeed'] == "addFeed" && filter_var($user_id, FILTER_VALIDATE_INT) == true) {
 
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
$blocked_users = implode(",", $blocked_users); 
 $timeline_text = stripslashes($timeline_text);
$timeline_text = htmlentities($timeline_text,ENT_QUOTES);
/*if(isset($debug)){

	echo $timeline_text;
	//echo $m->get_data('timeline_text');
	exit;
}*/



$m->set_data('timeline_text',htmlspecialchars($timeline_text));

/*if(isset($debug)){

	echo $timeline_text;
	//echo $m->get_data('timeline_text');
	exit;
}*/

				// $timeline_text = htmlspecialchars($timeline_text, ENT_QUOTES) ;
				 
 /*if(isset($debug)){
					echo  $timeline_text;exit;
				} */


			$user_id_add= $user_id;
			//$timeline_text = addslashes($timeline_text);
			if ($feed_type == "2" || $feed_type == "1") {
				$gb_devider = 1073741824;
				$timeline_photos_master_det = $d->selectRow("round(sum(size)/".$gb_devider.",1) as used_space","timeline_photos_master", "user_id='$user_id' group by `user_id`  ", "");
				$timeline_photos_master_d = mysqli_fetch_array($timeline_photos_master_det);

				$zoobiz_settings_master_q = $d->selectRow("user_timeline_upload_limit_in_gb","zoobiz_settings_master", "", "");
				$zoobiz_settings_master_d = mysqli_fetch_array($zoobiz_settings_master_q);

				if($timeline_photos_master_d['used_space'] > $zoobiz_settings_master_d['user_timeline_upload_limit_in_gb']   ){
					$response["message"] = "Timeline Storage Limit ".$zoobiz_settings_master_d['user_timeline_upload_limit_in_gb']." GB Exceeded, Please remove Older Videos and Photos to Upload New.";
					$response["status"] = "201";
					echo json_encode($response);
					exit;
				}
			}

			$temDate2 = date("Y_m_dhis");
			$modify_date = date("Y-m-d H:i:s");
			//8march21
			/*$last_auto_id = $d->last_auto_id("timeline_master");
			$res = mysqli_fetch_array($last_auto_id);
			$timeline_id = $res['Auto_increment'];*/


			//20jan21
			$users_master2=$d->selectRow("user_full_name,user_profile_pic"," users_master","user_id= '$user_id_add'");
            $data_q2=mysqli_fetch_array($users_master2);
            if($data_q2['user_profile_pic']!=""){
                    $profile_u = $base_url . "img/users/members_profile/" . $data_q2['user_profile_pic'];
                  } else {
                    $profile_u ="https://zoobiz.in/img/user.png";
                  }

                   
             //20jan21


			if ($feed_type == "1") {
				$total = count($_FILES['photo']['tmp_name']);
				$m->set_data('feed_type', 1);
				
			//	$m->set_data('timeline_text', stripslashes(  html_entity_decode(($timeline_text))));


				$m->set_data('user_id', $user_id);
				$m->set_data('user_name', $user_name);
				$m->set_data('created_date', $modify_date);
				$a1 = array(
					'feed_type' => $m->get_data('feed_type'),
					'timeline_text' => $m->get_data('timeline_text'),
					'user_id' => $m->get_data('user_id'),
					// 'user_name'=>$m->get_data('user_name'),
					'created_date' => $m->get_data('created_date'),
				);
				$d->insert("timeline_master", $a1);
				//8march21
				$timeline_id  = $con->insert_id; 

				if ($d == TRUE) {
					for ($i = 0; $i < $total; $i++) {
						$uploadedFile = $_FILES['photo']['tmp_name'][$i];
						if ($uploadedFile != "") {
							$sourceProperties = getimagesize($uploadedFile);
							$newFileName = rand() . $user_id;
							$dirPath = "../img/timeline/";
							$ext = pathinfo($_FILES['photo']['name'][$i], PATHINFO_EXTENSION);
							$imageType = $sourceProperties[2];
							$imageHeight = $sourceProperties[1];
							$imageWidth = $sourceProperties[0];
							if ($imageWidth > 1800) {
								$newWidthPercentage = 1800 * 100 / $imageWidth; //for maximum 1200 widht
								$newImageWidth = $imageWidth * $newWidthPercentage / 100;
								$newImageHeight = $imageHeight * $newWidthPercentage / 100;
							} else {
								$newImageWidth = $imageWidth;
								$newImageHeight = $imageHeight;
							}
							switch ($imageType) {
								case IMAGETYPE_PNG:
								$imageSrc = imagecreatefrompng($uploadedFile);
								if($ext==''){
									$ext ='png';
								}
								$tmp = imageResize($imageSrc, $sourceProperties[0], $sourceProperties[1], $newImageWidth, $newImageHeight);
								imagepng($tmp, $dirPath . $newFileName . "_feed." . $ext);
								break;
								case IMAGETYPE_JPEG:
								$imageSrc = imagecreatefromjpeg($uploadedFile);
								if($ext==''){
									$ext ='jpeg';
								}
								$tmp = imageResize($imageSrc, $sourceProperties[0], $sourceProperties[1], $newImageWidth, $newImageHeight);
								imagejpeg($tmp, $dirPath . $newFileName . "_feed." . $ext);
								break;
								case IMAGETYPE_GIF:
								$imageSrc = imagecreatefromgif($uploadedFile);
								/*if($ext==''){
									$ext ='gif';
								}*/
								$tmp = imageResize($imageSrc, $sourceProperties[0], $sourceProperties[1], $newImageWidth, $newImageHeight);
								imagegif($tmp, $dirPath . $newFileName . "_feed." . $ext);
								break;
								default:
								$response["message"] = "Invalid Image type.";
								$response["status"] = "201";
								echo json_encode($response);
								exit;
								break;
							}
							if($ext==''){
									$ext ='jpeg';
							}
							$myfilesize= filesize($dirPath . $newFileName . "_feed." . $ext); 
							$feed_img = $newFileName . "_feed." . $ext;

							if($i == 0){
								$timeleine_photo=$base_url.'../img/timeline/'.$feed_img.'.'. $ext;

							}
							$a1 = array(
								'timeline_id' => $timeline_id,
								'user_id' => $user_id,
								'photo_name' => $feed_img,
								'feed_img_height' => $newImageHeight,
								'feed_img_width' => $newImageWidth,
								'size' =>$myfilesize
							);
							$d->insert("timeline_photos_master", $a1);
						} else {
							$response["message"] = "faild.";
							$response["status"] = "201";
							echo json_encode($response);
							exit();
						}
					}
					$title = "$user_name Added A New Post";
					if ($timeline_text == '') {
						//23nov $user_name added
						$description = "$user_name Post A Photo";
					} else {
						$description = stripslashes(  html_entity_decode($timeline_text));
					}

					
					$d->insertFollowNotification($title, $description, $timeline_id, $user_id, 1, "timeline");
					$fcmArray = $d->get_android_fcm("users_master,follow_master", "users_master.user_id=follow_master.follow_by AND follow_master.follow_to='$user_id' AND users_master.user_token!='' AND  lower(users_master.device) ='android' and timeline_alert=0  and users_master.user_id not in ($blocked_users) ");
					$fcmArrayIos = $d->get_android_fcm("users_master,follow_master", "users_master.user_id=follow_master.follow_by AND follow_master.follow_to='$user_id' AND users_master.user_token!='' AND  lower(users_master.device) ='ios' and timeline_alert=0  and users_master.user_id not in ($blocked_users)  ");
					$getCatId = $d->selectRow("business_category_id","user_employment_details", "user_id = '$user_id'");
					$getCatData = mysqli_fetch_array($getCatId);
					$fcmArrayAndroidFollow = $d->get_android_fcm("users_master,category_follow_master", " users_master.user_id=category_follow_master.user_id AND category_follow_master.category_id='$getCatData[business_category_id]' AND users_master.user_token!='' AND  lower(users_master.device) ='android' and users_master.user_id != '$user_id' and timeline_alert=0  and users_master.user_id not in ($blocked_users)  ");
					$fcmArrayIosFollow = $d->get_android_fcm("users_master,category_follow_master", "users_master.user_id=category_follow_master.user_id AND category_follow_master.category_id='$getCatData[business_category_id]' AND users_master.user_token!='' AND  lower(users_master.device) ='ios'  and users_master.user_id != '$user_id' and timeline_alert=0  and users_master.user_id not in ($blocked_users)  ");
					$fcmArray = array_merge($fcmArrayAndroidFollow, $fcmArray);
					$fcmArrayIos = array_merge($fcmArrayIosFollow, $fcmArrayIos);
					//23oct2020

					//8march21
					/*$last_auto_id=$d->last_auto_id("timeline_master");
					$res=mysqli_fetch_array($last_auto_id);
					$new_feed_id=$res['Auto_increment'];
					$new_feed_id =  ($new_feed_id-1);*/
					$new_feed_id =$timeline_id;  
//23oct2020


					


					$nResident->noti("timeline",$timeleine_photo, 0, $fcmArray, $title, $description, $new_feed_id,0,$profile_u);
					$nResident->noti_ios("timeline", $timeleine_photo, 0, $fcmArrayIos, $title, $description, $new_feed_id,0,$profile_u);
					$d->insert_myactivity($user_id,"0","", $timeline_text." Post Added","activity.png");
					$response["message"] = "Posted Successfully";
					$response["status"] = "200";
					echo json_encode($response);
					exit();
				} else {
					$response["message"] = "Something Wrong";
					$response["status"] = "201";
					echo json_encode($response);
				}
			} 

			//17dec2020
			else if ($feed_type == "2") {
				$m->set_data('feed_type', 2);
			//	$m->set_data('timeline_text', stripslashes(  html_entity_decode(($timeline_text))));
				$m->set_data('user_id', $user_id);
				$m->set_data('user_name', $user_name);
				$m->set_data('created_date', $modify_date);
				$a1 = array(
					'feed_type' => $m->get_data('feed_type'),
					'timeline_text' => $m->get_data('timeline_text'),
					'user_id' => $m->get_data('user_id'),
					// 'user_name'=>$m->get_data('user_name'),
					'created_date' => $m->get_data('created_date'),
				);
				$d->insert("timeline_master", $a1);
				$timeline_id  = $con->insert_id;  

				$allowedExts = array( "mp4");
				$extension = pathinfo($_FILES['feed_video']['name'], PATHINFO_EXTENSION);
 //if ((($_FILES["file"]["type"] == "video/mp4")){}


				$total = count($_FILES['feed_video']['tmp_name']);
				 
             //20jan21
				$timeleine_photo="";

				if ($d == TRUE) {
					for ($i = 0; $i < $total; $i++) {
						$uploadedFile = $_FILES['feed_video']['tmp_name'][$i];
						if ($uploadedFile != "") {
							$sourceProperties = getimagesize($uploadedFile);
							$newFileName = rand() . $user_id;
							$dirPath = "../img/timeline/";
							$ext = pathinfo($_FILES['feed_video']['name'][$i], PATHINFO_EXTENSION);
//echo $dirPath . $_FILES["feed_video"]["name"][$i]. $ext;exit;
							move_uploaded_file($_FILES["feed_video"]["tmp_name"][$i],$dirPath . $newFileName."_feed_video." . $ext);
							$myfilesize_video= filesize($dirPath . $newFileName . "_feed_video." . $ext);
							

							$sourceProperties = getimagesize($_FILES['photo']['tmp_name'][$i]);
							$imageType = $sourceProperties[2];
							$imageHeight = $sourceProperties[1];
							$imageWidth = $sourceProperties[0];
							if ($imageWidth > 1800) {
								$newWidthPercentage = 1800 * 100 / $imageWidth; //for maximum 1200 widht
								$newImageWidth = $imageWidth * $newWidthPercentage / 100;
								$newImageHeight = $imageHeight * $newWidthPercentage / 100;
							} else {
								$newImageWidth = $imageWidth;
								$newImageHeight = $imageHeight;
							}
							$ext2 = pathinfo($_FILES['photo']['name'][$i], PATHINFO_EXTENSION);
							 
							if($ext2==''){
								$ext2='jpeg';
							}
							move_uploaded_file($_FILES["photo"]["tmp_name"][$i],$dirPath . $newFileName."_feed." . $ext2);


							$myfilesize_photo= filesize($dirPath . $newFileName."_feed." . $ext2);

//"../../img/users/company_logo/".$newFileName. "_logo.". $ext


							$feed_img = $newFileName . "_feed." . $ext2;

							if($i == 0){
								  

								 $timeleine_photo=$base_url.'../img/timeline/'.$feed_img;
							}

							$feed_video = $newFileName . "_feed_video." . $ext;
							$a1 = array(
								'timeline_id' => $timeline_id,
								'user_id' => $user_id,
								
								'photo_name' => $feed_img,
								'video_name' => $feed_video,
								'feed_img_height' => $newImageHeight,
								'feed_img_width' => $newImageWidth,
								'size' =>($myfilesize_photo+$myfilesize_video)
							);
							$d->insert("timeline_photos_master", $a1);
						} else {
							$response["message"] = "faild.";
							$response["status"] = "201";
							echo json_encode($response);
							exit();
						}
					}

		 

					$title = "$user_name Added A New Post";
					if ($timeline_text == '') {
						//23nov $user_name added
						$description = "$user_name Post A Video";
					} else {
						$description = stripslashes(  html_entity_decode($timeline_text));
					}
					$d->insertFollowNotification($title, $description, $timeline_id, $user_id, 1, "timeline");
					$fcmArray = $d->get_android_fcm("users_master,follow_master", "users_master.user_id=follow_master.follow_by AND follow_master.follow_to='$user_id' AND users_master.user_token!='' AND  lower(users_master.device) ='android'  and timeline_alert=0  and users_master.user_id not in ($blocked_users) ");
					$fcmArrayIos = $d->get_android_fcm("users_master,follow_master", "users_master.user_id=follow_master.follow_by AND follow_master.follow_to='$user_id' AND users_master.user_token!='' AND  lower(users_master.device) ='ios' and timeline_alert=0  and users_master.user_id not in ($blocked_users)  ");
					$getCatId = $d->selectRow("business_category_id","user_employment_details", "user_id = '$user_id'");
					$getCatData = mysqli_fetch_array($getCatId);
					$fcmArrayAndroidFollow = $d->get_android_fcm("users_master,category_follow_master", " users_master.user_id=category_follow_master.user_id AND category_follow_master.category_id='$getCatData[business_category_id]' AND users_master.user_token!='' AND  lower(users_master.device)='android' and users_master.user_id != '$user_id' and timeline_alert=0  and users_master.user_id not in ($blocked_users) ");
					$fcmArrayIosFollow = $d->get_android_fcm("users_master,category_follow_master", "users_master.user_id=category_follow_master.user_id AND category_follow_master.category_id='$getCatData[business_category_id]' AND users_master.user_token!='' AND  lower(users_master.device)='ios'  and users_master.user_id != '$user_id' and timeline_alert=0  and users_master.user_id not in ($blocked_users) ");
					$fcmArray = array_merge($fcmArrayAndroidFollow, $fcmArray);
					$fcmArrayIos = array_merge($fcmArrayIosFollow, $fcmArrayIos);
					//23oct2020

					//8march21
					/*$last_auto_id=$d->last_auto_id("timeline_master");
					$res=mysqli_fetch_array($last_auto_id);
					$new_feed_id=$res['Auto_increment'];
					$new_feed_id = ($new_feed_id-1);*/
					$new_feed_id = $timeline_id;
//23oct2020
					$nResident->noti("timeline", $timeleine_photo, 0, $fcmArray, $title, $description, $new_feed_id,0, $profile_u);
					$nResident->noti_ios("timeline", $timeleine_photo, 0, $fcmArrayIos, $title, $description, $new_feed_id,0, $profile_u);
					$d->insert_myactivity($user_id,"0","",$timeline_text. " Post Added","activity.png");
					$response["message"] = "Posted successfully";
					$response["status"] = "200";
					echo json_encode($response);
					exit();
				} else {
					$response["message"] = "Something Wrong";
					$response["status"] = "201";
					echo json_encode($response);
				}
			} else {
				if ($timeline_text == '') {
					$response["message"] = "Please write something";
					$response["status"] = "201";
					echo json_encode($response);
					exit();
				}

				if(isset($debug)){
					//echo $m->get_data('timeline_text');exit;
				}
				$m->set_data('feed_type', 0);
				//$m->set_data('timeline_text', addslashes($timeline_text));

				
				$m->set_data('user_id', $user_id);
				$m->set_data('user_name', $user_name);
				$m->set_data('created_date', $modify_date);
				$a1 = array(
					'feed_type' => $m->get_data('feed_type'),
					'timeline_text' => $m->get_data('timeline_text'),
					'user_id' => $m->get_data('user_id'),
					'created_date' => $m->get_data('created_date'),
				);
				$d->insert("timeline_master", $a1);
				$timeline_id  = $con->insert_id;  
				if ($d == TRUE) {
					$title = "$user_name Added New Post In Timeline";
					$description = stripslashes(  html_entity_decode($timeline_text));
					$d->insertFollowNotification($title, $description, $timeline_id, $user_id, 1, "timeline");
					$fcmArray = $d->get_android_fcm("users_master,follow_master", "users_master.user_id=follow_master.follow_by AND follow_master.follow_to='$user_id' AND users_master.user_token!='' AND  lower(users_master.device)='android' and users_master.user_id != '$user_id' and timeline_alert=0  and users_master.user_id not in ($blocked_users) ");

					/*if(isset($debug)){
						echo "users_master.user_id=follow_master.follow_by AND follow_master.follow_to='$user_id' AND users_master.user_token!='' AND  lower(users_master.device)='android' and users_master.user_id != '$user_id' and timeline_alert=0  and users_master.user_id not in ($blocked_users) ";exit;
					}*/
					$fcmArrayIos = $d->get_android_fcm("users_master,follow_master", "users_master.user_id=follow_master.follow_by AND follow_master.follow_to='$user_id' AND users_master.user_token!='' AND  lower(users_master.device)='ios' and users_master.user_id != '$user_id' and timeline_alert=0  and users_master.user_id not in ($blocked_users)  ");
					$getCatId = $d->selectRow("business_category_id","user_employment_details", "user_id = '$user_id'");
					$getCatData = mysqli_fetch_array($getCatId);
					$fcmArrayAndroidFollow = $d->get_android_fcm("users_master,category_follow_master", "users_master.user_id=category_follow_master.user_id AND category_follow_master.category_id='$getCatData[business_category_id]' AND users_master.user_token!='' AND  lower(users_master.device)='android' and users_master.user_id != '$user_id' and timeline_alert=0  and users_master.user_id not in ($blocked_users) ");
					$fcmArrayIosFollow = $d->get_android_fcm("users_master,category_follow_master", "users_master.user_id=category_follow_master.user_id AND category_follow_master.category_id='$getCatData[business_category_id]' AND users_master.user_token!='' AND  lower(users_master.device)='ios' and users_master.user_id != '$user_id' and timeline_alert=0  and users_master.user_id not in ($blocked_users) ");
					$fcmArray = array_merge($fcmArrayAndroidFollow, $fcmArray);
					$fcmArrayIos = array_merge($fcmArrayIosFollow, $fcmArrayIos);
					//23oct2020

					//8march21
					/*$last_auto_id=$d->last_auto_id("timeline_master");
					$res=mysqli_fetch_array($last_auto_id);
					$new_feed_id=$res['Auto_increment'];
					$new_feed_id = ($new_feed_id-1);*/
					$new_feed_id = $timeline_id;
//23oct2020
					$nResident->noti("timeline", "", 0, $fcmArray, $title, $description, $new_feed_id,1, $profile_u );
					$nResident->noti_ios("timeline", "", 0, $fcmArrayIos, $title, $description, $new_feed_id ,1, $profile_u);
					$d->insert_myactivity($user_id,"0","", $timeline_text." Post Added","activity.png");
					
					$response["message"] = "Posted successfully";
					$response["status"] = "200";
					echo json_encode($response);
				} else {
					$response["message"] = "Something Wrong";
					$response["status"] = "201";
					echo json_encode($response);
				}
			}
		} else if ($_POST['likeFeed'] == "likeFeed" && filter_var($user_id, FILTER_VALIDATE_INT) == true) {
			$m->set_data('timeline_id', $timeline_id);
			$m->set_data('user_id', $user_id);
			$m->set_data('user_name', $user_name);
			$m->set_data('block_name', $block_name);
			$m->set_data('modify_date', date("Y-m-d H:i:s"));
			$a1 = array(
				'timeline_id' => $m->get_data('timeline_id'),
				'user_id' => $m->get_data('user_id'),
				'modify_date' => $m->get_data('modify_date'),
			);



			//20jan21
			$users_master2=$d->selectRow("user_full_name,user_profile_pic"," users_master","user_id= '$user_id'");
            $data_q2=mysqli_fetch_array($users_master2);
            if($data_q2['user_profile_pic']!=""){
                    $profile_u = $base_url . "img/users/members_profile/" . $data_q2['user_profile_pic'];
                  } else {
                    $profile_u ="https://zoobiz.in/img/user.png";
                  }

                  if(isset($debug)){
                  	//echo $profile_u;exit;
                  }

                  $timeline_photos_master=$d->selectRow("photo_name","timeline_photos_master","  timeline_id= '$timeline_id' order by timeline_photo_id asc");
                  $timeleine_photo="";
                  $is_profile = '1';
                  if (mysqli_num_rows($timeline_photos_master) > 0) {
                  	$timeline_photos_master_data=mysqli_fetch_array($timeline_photos_master);
                  
                    if($timeline_photos_master_data['photo_name']!=""){
                    	$is_profile = '0';
                        $timeleine_photo = $base_url . "img/timeline/" . $timeline_photos_master_data['photo_name'];
                     }  

                  	
                  }
            
 			//20jan21

			if ($like_status == 0) {
				$qcheck = $d->selectRow("like_id ","timeline_like_master", "user_id='$user_id' AND timeline_id='$timeline_id'");
				if (mysqli_num_rows($qcheck) > 0) {
					$a1 = array(
						'active_status' => 0,
					);

					$d->update("timeline_like_master", $a1, "user_id='$user_id' AND timeline_id='$timeline_id'");
				} else {
					$d->delete("timeline_like_master", "user_id='$user_id' AND timeline_id='$timeline_id'");
					$d->insert("timeline_like_master", $a1);
					$quc = $d->selectRow("users_master.user_token,users_master.device,users_master.user_id","users_master,timeline_master", "timeline_master.user_id=users_master.user_id AND timeline_master.timeline_id='$timeline_id' AND users_master.user_id!='$user_id' and timeline_alert=0 ");
					$userData = mysqli_fetch_array($quc);
					$sos_user_token = $userData['user_token'];
					$device = $userData['device'];
					$feed_user_id = $userData['user_id'];
					if ($feed_user_id != $user_id && $feed_user_id != '0' AND $feed_user_id != '') {
						# code...
						$title = "$user_name ";
						$msg = "Liked your post";
						$notiAry = array(
							'user_id' => $feed_user_id,
							'notification_title' => 'timeline',
							'notification_desc' => "$user_name liked your post",
							'notification_date' => date('Y-m-d H:i'),
							'notification_action' => 'timeline',
							'notification_logo' => 'timeline.png',
							'notification_type' => '1',
							'other_user_id' => $user_id,
							'timeline_id' => $timeline_id,
						);
						$d->insert("user_notification", $notiAry);
						if (strtolower($device) == 'android') {
							$nResident->noti("timeline",$timeleine_photo, $society_id, $sos_user_token, $title, $msg, $timeline_id,$is_profile,$profile_u);
						} else if (strtolower($device) == 'ios') {
							$nResident->noti_ios("timeline", $timeleine_photo, $society_id, $sos_user_token, $title, $msg, $timeline_id,$is_profile, $profile_u);
						}
					}
				}

				$like="Liked";
			} else {
				$a1 = array(
					'active_status' => 1,
				);
				$d->update("timeline_like_master", $a1, "user_id='$user_id' AND timeline_id='$timeline_id'");
				// $d->delete("timeline_like_master","user_id='$user_id' AND timeline_id='$timeline_id'");
				$like="Unliked";
			}
			if ($d == TRUE) {

				 $users_master=$d->selectRow("user_full_name,user_profile_pic","timeline_master,users_master"," users_master.user_id=timeline_master.user_id and timeline_master.timeline_id= '$timeline_id'");
            $data_q=mysqli_fetch_array($users_master);


        if($data_q['user_full_name']==""){
 					$data_q['user_full_name']="Admin";
 				}

				$d->insert_myactivity($user_id,"0","", "You $like ".$data_q['user_full_name']."'s Post","activity.png");
				$response["message"] = "Liked";
				$response["status"] = "200";
				echo json_encode($response);
			} else {
				$response["message"] = "Somehitng wrong";
				$response["status"] = "201";
				echo json_encode($response);
			}
		} else if ($_POST['commentFeed'] == "commentFeed" && filter_var($user_id, FILTER_VALIDATE_INT) == true) {
			if ($msg == '') {
				$response["message"] = "Comment Needed";
				$response["status"] = "201";
				echo json_encode($response);
				exit();
			}
			$m->set_data('parent_comments_id', $parent_comments_id);
			$m->set_data('timeline_id', $timeline_id);
			$m->set_data('msg', $msg);
			$m->set_data('user_id', $user_id);
			$m->set_data('user_name', $user_name);
			$a1 = array(
				'parent_comments_id' => $m->get_data('parent_comments_id'),
				'timeline_id' => $m->get_data('timeline_id'),
				'msg' => $m->get_data('msg'),
				'user_id' => $m->get_data('user_id'),
				'user_name' => $m->get_data('user_name'),
				'modify_date' => date("Y-m-d H:i:s"),
			);
			$d->insert("timeline_comments", $a1);
			if ($d == TRUE) {

				//20jan21
			$users_master2=$d->selectRow("user_full_name,user_profile_pic"," users_master","user_id= '$user_id'");
            $data_q2=mysqli_fetch_array($users_master2);
            if($data_q2['user_profile_pic']!=""){
                    $profile_u = $base_url . "img/users/members_profile/" . $data_q2['user_profile_pic'];
                  } else {
                    $profile_u ="https://zoobiz.in/img/user.png";
                  }

                  

                   $timeline_photos_master=$d->selectRow("photo_name","timeline_photos_master","  timeline_id= '$timeline_id' order by timeline_photo_id asc");
                  $timeleine_photo="";
                  $is_profile = '1';
                  if (mysqli_num_rows($timeline_photos_master) > 0) {
                  	$timeline_photos_master_data=mysqli_fetch_array($timeline_photos_master);
                  
                    if($timeline_photos_master_data['photo_name']!=""){
                    	$is_profile = '0';
                        $timeleine_photo = $base_url . "img/timeline/" . $timeline_photos_master_data['photo_name'];
                     }  

                  	
                  }
             //20jan21


				if ($parent_comments_id != 0) {
					$quc = $d->selectRow("users_master.user_token,users_master.device,users_master.user_id","users_master,timeline_comments", "timeline_comments.user_id=users_master.user_id AND timeline_comments.timeline_id='$timeline_id' AND timeline_comments.user_id!='$user_id' and timeline_alert=0 and timeline_comments.parent_comments_id = '$parent_comments_id' ");
				} else {
					$quc = $d->selectRow("users_master.user_token,users_master.device,users_master.user_id","users_master,timeline_master", "timeline_master.user_id=users_master.user_id AND timeline_master.timeline_id='$timeline_id' AND users_master.user_id!='$user_id' and timeline_alert=0 ");
				}
				$userData = mysqli_fetch_array($quc);
				$sos_user_token = $userData['user_token'];
				$device = $userData['device'];
				$feed_user_id = $userData['user_id'];
				if ($parent_comments_id != '0' && $parent_comments_id != '') {
					$title = "$user_name replied on your comment";
				} else {
					$title = "$user_name Commented";
				}
				if ($feed_user_id != '' && $feed_user_id != 0 && $feed_user_id != $user_id) {
					if (strtolower($device) == 'android') {
						$nResident->noti("timeline", $timeleine_photo, $society_id, $sos_user_token, $title.' "'.$msg.'"', $msg, $timeline_id,$is_profile,$profile_u );
					} else if (strtolower($device) == 'ios') {
						$nResident->noti_ios("timeline", $timeleine_photo, $society_id, $sos_user_token, $title.' "'.$msg.'"', $msg, $timeline_id,$is_profile,$profile_u);
					}
					$notiAry = array(
						'user_id' => $feed_user_id,
						'notification_title' => 'timeline',
						'notification_desc' => "$title ".'"'.$msg.'"',
						'notification_date' => date('Y-m-d H:i'),
						'notification_action' => 'timeline',
						'notification_logo' => 'timeline.png',
						'notification_type' => '1',
						'other_user_id' => $user_id,
						'timeline_id' => $timeline_id,
					);
					$d->insert("user_notification", $notiAry);
				}
				$qcomment = $d->selectRow("users_master.user_first_name,users_master.user_last_name,timeline_comments.comments_id,timeline_comments.timeline_id,timeline_comments.msg,timeline_comments.user_name,timeline_comments.user_id,timeline_comments.modify_date,user_employment_details.company_logo,timeline_comments.comments_id, user_employment_details.company_name,users_master.user_profile_pic","timeline_comments,users_master,user_employment_details",  "user_employment_details.user_id = users_master.user_id and  timeline_comments.timeline_id='$timeline_id' AND timeline_comments.user_id=users_master.user_id AND timeline_comments.parent_comments_id=0", " group by timeline_comments.comments_id  ORDER BY timeline_comments.comments_id DESC");

				//code opt start
				 $CArray = array();
                $Ccounter = 0 ;
                foreach ($qcomment as  $value) {
                    foreach ($value as $key => $valueNew) {
                        $CArray[$Ccounter][$key] = $valueNew;
                    }
                    $Ccounter++;
                }
                $timeline_id_array = array('0');
                $comments_id_array = array('0');
                for ($l=0; $l < count($CArray) ; $l++) {
                    $timeline_id_array[] = $CArray[$l]['timeline_id'];
                    $comments_id_array[] = $CArray[$l]['comments_id'];
                }
                $timeline_id_array = implode(",", $timeline_id_array);
                $comments_id_array = implode(",", $comments_id_array);
                

                $sub_cmt_qry = $d->selectRow("users_master.user_first_name,users_master.user_last_name,timeline_comments.parent_comments_id,timeline_comments.comments_id,timeline_comments.timeline_id,timeline_comments.msg,timeline_comments.user_name,users_master.user_id,user_employment_details.company_logo,timeline_comments.modify_date,  user_employment_details.company_name,users_master.user_profile_pic","timeline_comments,users_master,user_employment_details", " user_employment_details.user_id = users_master.user_id and  timeline_comments.timeline_id in ($timeline_id_array) AND timeline_comments.user_id=users_master.user_id AND timeline_comments.parent_comments_id in ($comments_id_array)  ", " group by timeline_comments.comments_id ORDER BY timeline_comments.comments_id DESC");
                 $SCArray = array();
                $SCcounter = 0 ;
                foreach ($sub_cmt_qry as  $value) {
                    foreach ($value as $key => $valueNew) {
                        $SCArray[$SCcounter][$key] = $valueNew;
                    }
                    $SCcounter++;
                }
                 
                $sub_cm_array = array();
                for ($sc=0; $sc < count($SCArray) ; $sc++) {
                    $sub_cm_array[$SCArray[$sc]['timeline_id']."__".$SCArray[$sc]['parent_comments_id'] ][] = $SCArray[$sc];
                     
                }
                //echo "<pre>";print_r($sub_cm_array);exit;
               // echo "<pre>";print_r($sub_cm_array);exit;
                 
				//code opt end
				if (count($CArray) > 0) {
					$response["comment"] = array();
					for ($c=0; $c < count($CArray) ; $c++) { 
						$data_comment =$CArray[$c];
					 
						$comment = array();
						$comment["comments_id"] = $data_comment['comments_id'];
						$comment["timeline_id"] = $data_comment['timeline_id'];
						$comment["msg"] = html_entity_decode($data_comment['msg']);
						$comment["company_name"] = html_entity_decode($data_comment['company_name']);
						
						$comment["user_name"] = $data_comment['user_name'];
						$comment["user_id"] = $data_comment['user_id'];
						//$comment["modify_date"] = time_elapsed_string($data_comment['modify_date']);
						if(strtotime($data_comment['modify_date']) < strtotime('-30 days')) {
							$comment["modify_date"] = date("j M Y", strtotime($data_comment['modify_date']));
						} else {
							$comment["modify_date"]= time_elapsed_string($data_comment['modify_date']);
						}
						if($data_comment['user_profile_pic'] !=""){
							$comment["user_profile_pic"] = $base_url . "img/users/members_profile/" . $data_comment['user_profile_pic'];
						} else {
							$comment["user_profile_pic"] ="";
						}
						
						$comment["short_name"] =strtoupper(substr($data_comment["user_first_name"], 0, 1).substr($data_comment["user_last_name"], 0, 1) );

						$comment["sub_comment"] = array();
						/*$q4 = $d->selectRow("timeline_comments.comments_id,timeline_comments.timeline_id,timeline_comments.msg,timeline_comments.user_name,users_master.user_id,user_employment_details.company_logo,timeline_comments.modify_date","timeline_comments,users_master,user_employment_details", " user_employment_details.user_id = users_master.user_id and  timeline_comments.timeline_id='$timeline_id' AND timeline_comments.user_id=users_master.user_id AND timeline_comments.parent_comments_id='$data_comment[comments_id]'", "ORDER BY timeline_comments.comments_id DESC");*/
						$s_data = $sub_cm_array[$timeline_id."__".$data_comment['comments_id']];

						for ($scde=0; $scde < count($s_data) ; $scde++) { 
							$subCommentData =$s_data[$scde];
						 
							$sub_comment = array();
							$sub_comment["comments_id"] = $subCommentData['comments_id'];
							$sub_comment["timeline_id"] = $subCommentData['timeline_id'];
							$sub_comment["msg"] = html_entity_decode($subCommentData['msg']);
							$sub_comment["company_name"] = html_entity_decode($subCommentData['company_name']);
							$sub_comment["user_name"] = $subCommentData['user_name'];
							$sub_comment["user_id"] = $subCommentData['user_id'];
							if($subCommentData['user_profile_pic'] !=""){
								$sub_comment["user_profile_pic"] = $base_url . "img/users/members_profile/" . $subCommentData['user_profile_pic'];
							} else {
								$sub_comment["user_profile_pic"] ="";
							}
							$sub_comment["short_name"] =strtoupper(substr($subCommentData["user_first_name"], 0, 1).substr($subCommentData["user_last_name"], 0, 1) );
							//$sub_comment["modify_date"] = time_elapsed_string($subCommentData['modify_date']);
							if(strtotime($subCommentData['modify_date']) < strtotime('-30 days')) {
								$sub_comment["modify_date"] = date("j M Y", strtotime($subCommentData['modify_date']));
							} else {
								$sub_comment["modify_date"]= time_elapsed_string($subCommentData['modify_date']);
							}
							array_push($comment["sub_comment"], $sub_comment);
						}
						array_push($response["comment"], $comment);
					}
				}

				 $users_master=$d->selectRow("user_full_name","timeline_master,users_master"," users_master.user_id=timeline_master.user_id and timeline_master.timeline_id= '$timeline_id'");
                $data_q=mysqli_fetch_array($users_master); 
 				if($data_q['user_full_name']==""){
 					$data_q['user_full_name']="Admin";
 				}
				 $d->insert_myactivity($user_id,"0","", "You Commented on " .$data_q['user_full_name']."'s Post"  ,"activity.png");
 				 
				 
				$response["message"] = "Comment Added ".'"'.$title.'"'  ;
				$response["status"] = "200";
				echo json_encode($response);
			} else {
				$response["message"] = "faild.";
				$response["status"] = "201";
				echo json_encode($response);
			}
		} else if ($_POST['getComments'] == "getComments" && filter_var($timeline_id, FILTER_VALIDATE_INT) == true) {
			$qcomment = $d->selectRow("users_master.user_first_name,users_master.user_last_name, timeline_comments.comments_id,timeline_comments.timeline_id,timeline_comments.msg,users_master.user_full_name,timeline_comments.user_id,timeline_comments.modify_date,user_employment_details.company_logo,timeline_comments.comments_id 
							, user_employment_details.company_name,users_master.user_profile_pic ","timeline_comments,users_master,user_employment_details", " user_employment_details.user_id = users_master.user_id and timeline_comments.timeline_id='$timeline_id' AND timeline_comments.user_id=users_master.user_id AND timeline_comments.parent_comments_id=0", " group by timeline_comments.comments_id  ORDER BY timeline_comments.comments_id DESC");


			//code opt start
			$CArray = array();
                $Ccounter = 0 ;
                foreach ($qcomment as  $value) {
                    foreach ($value as $key => $valueNew) {
                        $CArray[$Ccounter][$key] = $valueNew;
                    }
                    $Ccounter++;
                }
                $timeline_id_array = array('0');
                $comments_id_array = array('0');
                for ($l=0; $l < count($CArray) ; $l++) {
                    $timeline_id_array[] = $CArray[$l]['timeline_id'];
                    $comments_id_array[] = $CArray[$l]['comments_id'];
                }
                $timeline_id_array = implode(",", $timeline_id_array);
                $comments_id_array = implode(",", $comments_id_array);

                $sub_q = $d->selectRow("users_master.user_first_name,users_master.user_last_name, timeline_comments.parent_comments_id,timeline_comments.comments_id,timeline_comments.timeline_id,timeline_comments.msg,timeline_comments.user_name,user_employment_details.company_logo,timeline_comments.modify_date,timeline_comments.user_id  , user_employment_details.company_name, users_master.user_profile_pic","timeline_comments,users_master, user_employment_details ", " user_employment_details.user_id = users_master.user_id and timeline_comments.timeline_id in ($timeline_id_array) AND timeline_comments.user_id=users_master.user_id AND timeline_comments.parent_comments_id in ($comments_id_array) ", " group by timeline_comments.comments_id ORDER BY timeline_comments.comments_id DESC");


                $SCArray = array();
                $SCcounter = 0 ;
                foreach ($sub_q as  $value) {
                    foreach ($value as $key => $valueNew) {
                        $SCArray[$SCcounter][$key] = $valueNew;
                    }
                    $SCcounter++;
                }

                $sub_cmt_array = array();
                for ($l=0; $l < count($SCArray) ; $l++) {
                    $sub_cmt_array[$SCArray[$l]['timeline_id']."__".$SCArray[$l]['parent_comments_id']][] = $SCArray[$l];
                }

           //   echo "<pre>";print_r($sub_cmt_array);exit;
			//code opt end 

			if (count($CArray) > 0) {
				$response["comment"] = array();

				for ($mc=0; $mc < count($CArray) ; $mc++) { 
					$data_comment =$CArray[$mc];
				 
					$comment = array();
					$comment["comments_id"] = $data_comment['comments_id'];
					$comment["timeline_id"] = $data_comment['timeline_id'];
					$comment["msg"] = html_entity_decode($data_comment['msg']);
					$comment["company_name"] =html_entity_decode($data_comment['company_name']);
					

					$comment["user_name"] = $data_comment['user_full_name'];
					$comment["user_id"] = $data_comment['user_id'];
					//$comment["modify_date"] = time_elapsed_string($data_comment['modify_date']);
					if(strtotime($data_comment['modify_date']) < strtotime('-30 days')) {
						$comment["modify_date"] = date("j M Y", strtotime($data_comment['modify_date']));
					} else {
						$comment["modify_date"]= time_elapsed_string($data_comment['modify_date']);
					}

					if($data_comment['user_profile_pic'] !=""){
						$comment["user_profile_pic"] = $base_url . "img/users/members_profile/" . $data_comment['user_profile_pic'];
					} else {
						$comment["user_profile_pic"] ="";
					}
					$comment["short_name"] =strtoupper(substr($data_comment["user_first_name"], 0, 1).substr($data_comment["user_last_name"], 0, 1) );
					$comment["sub_comment"] = array();
					/*$q4 = $d->selectRow("timeline_comments.comments_id,timeline_comments.timeline_id,timeline_comments.msg,timeline_comments.user_name,user_employment_details.company_logo,timeline_comments.modify_date","timeline_comments,users_master, user_employment_details ", " user_employment_details.user_id = users_master.user_id and timeline_comments.timeline_id='$timeline_id' AND timeline_comments.user_id=users_master.user_id AND timeline_comments.parent_comments_id='$data_comment[comments_id]'", "ORDER BY timeline_comments.comments_id DESC");*/
					$sub_data = $sub_cmt_array[$timeline_id."__".$data_comment['comments_id']];
					/*echo $timeline_id."__".$data_comment['comments_id'];
					echo print_r($sub_data);exit;*/
					for ($sd=0; $sd < count($sub_data) ; $sd++) { 
						$subCommentData =$sub_data[$sd];
					 
						$sub_comment = array();
						$sub_comment["comments_id"] = $subCommentData['comments_id'];
						$sub_comment["timeline_id"] = $subCommentData['timeline_id'];
						$sub_comment["msg"] = html_entity_decode($subCommentData['msg']);
						$sub_comment["company_name"] = html_entity_decode($subCommentData['company_name']);

						
						$sub_comment["user_name"] = $subCommentData['user_name'];
						$sub_comment["user_id"] = $subCommentData['user_id'];
						if($subCommentData['user_profile_pic'] !=""){
							$sub_comment["user_profile_pic"] = $base_url . "img/users/members_profile/" . $subCommentData['user_profile_pic'];
						} else {
							$sub_comment["user_profile_pic"] ="";
						}
						$sub_comment["short_name"] =strtoupper(substr($subCommentData["user_first_name"], 0, 1).substr($subCommentData["user_last_name"], 0, 1) );
						//$sub_comment["modify_date"] = time_elapsed_string($subCommentData['modify_date']);
						if(strtotime($subCommentData['modify_date']) < strtotime('-30 days')) {
							$sub_comment["modify_date"] = date("j M Y", strtotime($subCommentData['modify_date']));
						} else {
							$sub_comment["modify_date"]= time_elapsed_string($subCommentData['modify_date']);
						}
						array_push($comment["sub_comment"], $sub_comment);
					}
					array_push($response["comment"], $comment);
				}
				$response["message"] = "success.";
				$response["status"] = "200";
				echo json_encode($response);
			} else {
				$response["message"] = "faild.";
				$response["status"] = "201";
				echo json_encode($response);
			}
		} else if ($_POST['deleteFeed'] == "deleteFeed" && filter_var($timeline_id, FILTER_VALIDATE_INT) == true && filter_var($user_id, FILTER_VALIDATE_INT) == true) {

			$gu=$d->select("timeline_master","timeline_id='$timeline_id' AND timeline_id!=0 AND user_id='$user_id'");
$NewData=mysqli_fetch_array($gu);


			$q = $d->delete("timeline_master", "timeline_id='$timeline_id' AND timeline_id!=0 AND user_id='$user_id'");
			if ($q == true) {

				 $qqq=$d->select("timeline_photos_master","timeline_id='$timeline_id' ");
  
   while($iData=mysqli_fetch_array($qqq)) { 
     $abspath=$_SERVER['DOCUMENT_ROOT'];
    $path = $abspath."/img/timeline/".$iData['photo_name'];
    unlink($path);
   }


				$q = $d->delete("timeline_comments", "timeline_id='$timeline_id'");
				$q = $d->delete("timeline_like_master", "timeline_id='$timeline_id'");
				$q = $d->delete("user_notification", "timeline_id='$timeline_id'");
				$q = $d->delete("timeline_photos_master", "timeline_id='$timeline_id'");
				$d->insert_myactivity($user_id,"0","",$NewData['timeline_text']. " Post Deleted","activity.png");
				$response["message"] = "Deleted Successfully";
				$response["status"] = "200";
				echo json_encode($response);
			} else {
				$response["message"] = "Sumething Wrong";
				$response["status"] = "201";
				echo json_encode($response);
			}
		} else if ($_POST['deleteComment'] == "deleteComment" && filter_var($comments_id, FILTER_VALIDATE_INT) == true && filter_var($user_id, FILTER_VALIDATE_INT) == true) {

			$users_master=$d->selectRow("user_full_name","timeline_master,users_master,timeline_comments"," timeline_comments.timeline_id =  timeline_master.timeline_id and  users_master.user_id=timeline_master.user_id and timeline_comments.comments_id= '$comments_id'");
                $data_q=mysqli_fetch_array($users_master);

                
			$q = $d->delete("timeline_comments", "comments_id='$comments_id' AND user_id='$user_id'");
			if ($q == true) {
				$q = $d->delete("timeline_comments", "parent_comments_id='$comments_id' AND user_id='$user_id'");

				/*$users_master=$d->selectRow("user_full_name","timeline_master,users_master,timeline_comments"," timeline_comments.timeline_id =  timeline_master.timeline_id and  users_master.user_id=timeline_master.user_id and timeline_comments.comments_id= '$comments_id' and timeline_comments.user_id= '$user_id' ");
                $data_q=mysqli_fetch_array($users_master);
                if($data_q['user_full_name']==""){
 					$data_q['user_full_name']="Admin";
 				}
*/
				$d->insert_myactivity($user_id,"0","", "You Deleted Comment on ".$data_q['user_full_name']."'s Post","activity.png");

				
  				if($data_q['user_full_name']==""){
 					$data_q['user_full_name']="Admin";
 				}
				$response["message"] = "You Deleted Comment on ".$data_q['user_full_name']."'s Post";
				$response["status"] = "200";
				echo json_encode($response);
			} else {
				$response["message"] = "Something Wrong";
				$response["status"] = "201";
				echo json_encode($response);
			}
		} else if ($_POST['getMyFeed'] == "getMyFeed") {



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
$blocked_users = implode(",", $blocked_users); 
 

			if(isset($limit_feed)){

				$qnotification = $d->selectRow("users_master.user_first_name,users_master.user_last_name,timeline_master.meetup_user_id2,timeline_master.meetup_user_id1, timeline_master.timeline_id,timeline_master.timeline_text,users_master.user_full_name,user_employment_details.company_name,timeline_master.user_id,company_logo,timeline_master.feed_type,timeline_master.created_date,users_master.user_profile_pic,users_master.user_mobile, users_master.public_mobile","timeline_master,users_master,user_employment_details", "user_employment_details.user_id=users_master.user_id AND timeline_master.active_status = 0 AND timeline_master.user_id='$user_id' AND users_master.user_id='$user_id'
and timeline_master.user_id not in ($blocked_users) ", "ORDER BY timeline_id DESC LIMIT $limit_feed, 10");
				
			} else {
				$qnotification = $d->selectRow("users_master.user_first_name,users_master.user_last_name, timeline_master.meetup_user_id2,timeline_master.meetup_user_id1,timeline_master.timeline_id,timeline_master.timeline_text,users_master.user_full_name,user_employment_details.company_name,timeline_master.user_id,company_logo,timeline_master.feed_type,timeline_master.created_date,users_master.user_profile_pic,users_master.user_mobile, users_master.public_mobile","timeline_master,users_master,user_employment_details", "user_employment_details.user_id=users_master.user_id AND timeline_master.active_status = 0 AND timeline_master.user_id='$user_id' AND users_master.user_id='$user_id' 
and timeline_master.user_id not in ($blocked_users) ", "ORDER BY timeline_id DESC LIMIT 500");
			}
			


			 




			//code optimize

                $dataArray = array();
                $counter = 0 ;
                foreach ($qnotification as  $value) {
                    foreach ($value as $key => $valueNew) {
                        $dataArray[$counter][$key] = $valueNew;
                    }
                    $counter++;
                }
                $user_id_array = array('0');
                $timeline_id_array = array('0');
                for ($l=0; $l < count($dataArray) ; $l++) {
                    $user_id_array[] = $dataArray[$l]['user_id'];
                    $timeline_id_array[] = $dataArray[$l]['timeline_id'];
                }
                $user_id_array = implode(",", $user_id_array);

                $qche_qry = $d->selectRow("follow_id,follow_to","follow_master", "follow_by='$my_id' AND follow_to='$user_id'   ");
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


                $timeline_id_array = implode(",", $timeline_id_array);
                 

                  $video_main_qry = $d->selectRow("photo_name,feed_img_height,feed_img_width,video_name,timeline_id,user_id,feed_img_height,feed_img_width","timeline_photos_master", "timeline_id in($timeline_id_array)   AND user_id in ($user_id_array) ");

                $VArray = array();
                $Vcounter = 0 ;
                foreach ($video_main_qry as  $value) {
                    foreach ($value as $key => $valueNew) {
                        $VArray[$Vcounter][$key] = $valueNew;
                    }
                    $Vcounter++;
                }
                 $video_data_arr = array();
                 $video_data_arr2 = array();
                for ($dv=0; $dv < count($VArray) ; $dv++) {
                    $video_data_arr[$VArray[$dv]['timeline_id']."__".$VArray[$dv]['user_id']] = $VArray[$dv];
                    $video_data_arr2[$VArray[$dv]['timeline_id']."__".$VArray[$dv]['user_id']][] = $VArray[$dv];
                }


                $timeline_user_save_master = $d->selectRow("timeline_id","timeline_user_save_master", "user_id='$my_id'  ", "");
			 
			$saved_timeline_array = array('0');
			while ($timeline_user_save_master_data = mysqli_fetch_array($timeline_user_save_master)) {
				$saved_timeline_array[] = $timeline_user_save_master_data['timeline_id'];
			}


                $photo_qry = $d->selectRow("photo_name,feed_img_height,feed_img_width,timeline_id,user_id","timeline_photos_master", "timeline_id in ($timeline_id_array)   AND user_id in ($user_id_array) ");
                 $PArray = array();
                $Pcounter = 0 ;
                foreach ($photo_qry as  $value) {
                    foreach ($value as $key => $valueNew) {
                        $PArray[$Pcounter][$key] = $valueNew;
                    }
                    $Pcounter++;
                }
                $photo_array = array();
                for ($pd=0; $pd < count($PArray) ; $pd++) {
                    $photo_array[$PArray[$pd]['timeline_id']."__".$PArray[$pd]['user_id']][] = $PArray[$pd]; 
                }

                $qlike_qry = $d->selectRow("users_master.user_first_name,users_master.user_last_name,timeline_like_master.like_id,timeline_like_master.timeline_id,users_master.user_id,users_master.user_full_name,timeline_like_master.modify_date,user_employment_details.company_logo,users_master.user_profile_pic","timeline_like_master,users_master,user_employment_details", "user_employment_details.user_id = users_master.user_id and  timeline_like_master.timeline_id in ($timeline_id_array)  AND timeline_like_master.user_id=users_master.user_id AND timeline_like_master.active_status=0");
                $LArray = array();
                $Lcounter = 0 ;
                foreach ($qlike_qry as  $value) {
                    foreach ($value as $key => $valueNew) {
                        $LArray[$Lcounter][$key] = $valueNew;
                    }
                    $Lcounter++;
                }
                $qlike_data = array();
                for ($pd=0; $pd < count($LArray) ; $pd++) {
                    $qlike_data[$LArray[$pd]['timeline_id']][] = $LArray[$pd]; 
                }

                $qcomment_qry = $d->selectRow("users_master.user_first_name,users_master.user_last_name,timeline_comments.comments_id,timeline_comments.timeline_id,timeline_comments.msg,users_master.user_full_name,users_master.user_id,timeline_comments.modify_date,user_employment_details.company_logo , user_employment_details.company_name,users_master.user_profile_pic ","timeline_comments,users_master,user_employment_details", " user_employment_details.user_id=users_master.user_id and  timeline_comments.timeline_id in ($timeline_id_array)  AND timeline_comments.user_id=users_master.user_id AND timeline_comments.parent_comments_id=0", "group by timeline_comments.comments_id ORDER BY timeline_comments.comments_id DESC");
                $QArray = array();
                $Qcounter = 0 ;
                foreach ($qcomment_qry as  $value) {
                    foreach ($value as $key => $valueNew) {
                        $QArray[$Qcounter][$key] = $valueNew;
                    }
                    $Qcounter++;
                }

                //echo "<pre>";print_r($QArray);exit;
                $comment_data = array();
                $comments_id_array = array('0');
                for ($pq=0; $pq < count($QArray) ; $pq++) {
                    $comment_data[$QArray[$pq]['timeline_id']][] = $QArray[$pq]; 
                    $comments_id_array[] = $QArray[$pq]['comments_id'];
                }


                $clike_q = $d->selectRow("count(*) as cnt, like_id,timeline_id", "timeline_like_master", "timeline_id  in ($timeline_id_array) AND user_id = '$my_id' AND active_status=0 group by timeline_id");
                $clike_array = array();
                while($clike_data = mysqli_fetch_array($clike_q)){
                	$clike_array[$clike_data['timeline_id']] = $clike_data['cnt'];
                }



                $comments_id_array = implode(",", $comments_id_array);
                $sub_data_qry = $d->selectRow("users_master.user_first_name,users_master.user_last_name,timeline_comments.parent_comments_id,timeline_comments.comments_id,timeline_comments.timeline_id,timeline_comments.msg,users_master.user_full_name,users_master.user_id,user_employment_details.company_logo,timeline_comments.modify_date, user_employment_details.company_name,users_master.user_profile_pic","timeline_comments,users_master,user_employment_details", " user_employment_details.user_id = users_master.user_id and timeline_comments.timeline_id in ($timeline_id_array) AND timeline_comments.user_id=users_master.user_id AND timeline_comments.parent_comments_id in ($comments_id_array)  ", " group by timeline_comments.comments_id ORDER BY timeline_comments.comments_id DESC");

                $SDQArray = array();
                $SDQcounter = 0 ;
                foreach ($sub_data_qry as  $value) {
                    foreach ($value as $key => $valueNew) {
                        $SDQArray[$SDQcounter][$key] = $valueNew;
                    }
                    $SDQcounter++;
                }
                $comment_sub_data = array(); 
                for ($ps=0; $ps < count($SDQArray) ; $ps++) {
                    $comment_sub_data[$SDQArray[$ps]['timeline_id']."__".$SDQArray[$ps]['parent_comments_id']][] = $SDQArray[$ps];  
                }
               // echo "<pre>";print_r($comment_sub_data);exit;


//code optimize


			$tq11 = $d->selectRow("timeline_id", "timeline_master", "user_id='$user_id' 
and timeline_master.user_id not in ($blocked_users) ");
			$total_post = mysqli_num_rows($tq11);
			$tq22 = $d->selectRow("follow_master.follow_id","users_master,follow_master,user_employment_details,business_categories,business_sub_categories", "business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id AND follow_master.follow_by=users_master.user_id AND follow_master.follow_to='$user_id'", "ORDER BY users_master.user_full_name ASC");
			// $tq22=$d->selectRow("follow_id","follow_master","follow_by!='$data_app[user_id]'");
			$followers = mysqli_num_rows($tq22);
			$tq33 = $d->selectRow("follow_master.follow_id","users_master,follow_master,user_employment_details,business_categories,business_sub_categories", "business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id AND follow_master.follow_to=users_master.user_id AND follow_master.follow_by='$user_id'", "ORDER BY users_master.user_full_name ASC");
			// $tq33=$d->selectRow("follow_id","follow_master","follow_by='$data_app[user_id]'");
			$following = mysqli_num_rows($tq33);
			$qche = $d->selectRow("follow_id","follow_master", "follow_by='$my_id' AND follow_to='$user_id'");
			if (mysqli_num_rows($qche) > 0) {
				$follow_status = true;
			} else {
				$follow_status = false;
			}
			if (count($dataArray) > 0) {
				$response["feed"] = array();

				for ($l=0; $l < count($dataArray) ; $l++) {
					$data_notification =$dataArray[$l];
				 
					$feed = array();


					//11march
							$feed["user_mobile"] =  $data_notification["user_mobile"];
							if($data_notification['public_mobile'] =="0"){
								$feed["mobile_privacy"]=true;
							} else {
								$feed["mobile_privacy"]=false;
							}
							//11march


					$qche = $fol_array[$data_notification[user_id]];//  
					if (count($qche) > 0) {
						$follow_status = true;
					} else {
						$follow_status = false;
					}

					$feed["is_follow"] = $follow_status;
					 
if(in_array($data_notification['timeline_id'], $saved_timeline_array)){
							$feed["is_saved"] = true;
						}else {
							$feed["is_saved"] = false;
						}


					if($my_id==$user_id || $data_notification[user_id]==0 ){
						 $feed["show_follow_icon"] = false;
					} else {
						$feed["show_follow_icon"] = true;
					}



					$feed["timeline_id"] = $data_notification['timeline_id'];
					$feed["timeline_text"] =  htmlspecialchars_decode (stripslashes(  html_entity_decode($data_notification['timeline_text'] )) );    

					$feed["timeline_text"] = html_entity_decode($feed["timeline_text"] , ENT_QUOTES);

					 $feed["timeline_text"] = htmlspecialchars_decode($feed["timeline_text"], ENT_QUOTES);
						$feed["timeline_text"] =html_entity_decode ($feed["timeline_text"]);


$feed["short_name"] =strtoupper(substr($data_notification["user_first_name"], 0, 1).substr($data_notification["user_last_name"], 0, 1) );
					$feed["user_name"] = $data_notification['user_full_name'];
					$feed["company_name"] = html_entity_decode($data_notification['company_name']);
					$feed["user_id"] = $data_notification['user_id'];
					if($data_notification['user_profile_pic'] !=""){
						$feed["user_profile_pic"] = $base_url . "img/users/members_profile/" . $data_notification['user_profile_pic'];
					} else {
						$feed["user_profile_pic"] ="";
					}
					
					$timeline_id = $data_notification['timeline_id'];
					$feed["feed_type"] = $data_notification['feed_type'];
					$feed["meetup_user_id2"] = $data_notification['meetup_user_id2'];
					$feed["meetup_user_id1"] = $data_notification['meetup_user_id1'];
					if($data_notification['feed_type'] == "2"){

							//$video_qry = $d->selectRow("photo_name,feed_img_height,feed_img_width,video_name","timeline_photos_master", "timeline_id='$timeline_id' AND user_id='$data_notification[user_id]'");
							$video_data = $video_data_arr[$timeline_id."__".$data_notification[user_id]]; // mysqli_fetch_array($video_qry);
							$feed["video_thumb"] = $base_url . "img/timeline/" . $video_data['photo_name'];
							$feed["feed_video"] = $base_url . "img/timeline/" . $video_data['video_name'];
						}else {
							$feed["video_thumb"] ="";
							$feed["feed_video"] ="";
						}


					//$feed["modify_date"] = time_elapsed_string($data_notification['created_date']);
					if(strtotime($data_notification['created_date']) < strtotime('-30 days')) {
						$feed["modify_date"] = date("j M Y", strtotime($data_notification['created_date']));
					} else {
						$feed["modify_date"]= time_elapsed_string($data_notification['created_date']);
					}
					// $fi = $d->selectRow("photo_name,feed_img_height,feed_img_width","timeline_photos_master", "timeline_id='$timeline_id' AND user_id='$data_notification[user_id]'");
					$p_data_arr = $photo_array[$timeline_id."__".$data_notification['user_id']];
					$feed["timeline_photos"] = array();
					for ($pda=0; $pda < count($p_data_arr) ; $pda++) { 
						$feeData = $p_data_arr[$pda];
					 
						$timeline_photos = array();
						if($feeData['photo_name']!=""){
							$timeline_photos["photo_name"] = $base_url . "img/timeline/" . $feeData['photo_name'];
						} else {
							$timeline_photos["photo_name"] ="";
						}
						
						$timeline_photos["feed_height"] = $feeData['feed_img_height'];
						$timeline_photos["feed_width"] = $feeData['feed_img_width'];
						array_push($feed["timeline_photos"], $timeline_photos);
					}
					/*$qlike = $d->selectRow("timeline_like_master.like_id,timeline_like_master.timeline_id,users_master.user_id,users_master.user_full_name,timeline_like_master.modify_date,user_employment_details.company_logo","timeline_like_master,users_master,user_employment_details", "user_employment_details.user_id = users_master.user_id and  timeline_like_master.timeline_id='$timeline_id' AND timeline_like_master.user_id=users_master.user_id AND timeline_like_master.active_status=0");*/

					$like_details = $qlike_data[$timeline_id];
					$totalLikes = count($like_details);
					$feed["totalLikes"] = "$totalLikes";


					 

					/*$clike = $d->count_data_direct("like_id", "timeline_like_master", "timeline_id='$timeline_id' AND user_id = '$my_id' AND active_status=0");*/
					$clike = $clike_array[$timeline_id];
					if (count($like_details) > 0) {
						$feed["like"] = array();
						for ($ql=0; $ql < count($like_details) ; $ql++) { 
							$data_like = $like_details[$ql];
						 
							$like = array();
							$like["like_id"] = $data_like['like_id'];
							$like["timeline_id"] = $data_like['timeline_id'];
							$like["user_id"] = $data_like['user_id'];
							$like["user_name"] = $data_like['user_full_name'];
							$like["modify_date"] ="";// date("d M Y h:i A", strtotime($data_like['modify_date'])) ;
							
							if($data_like['user_profile_pic'] !=""){
								$like["user_profile_pic"] = $base_url . "img/users/members_profile/" . $data_like['user_profile_pic'];
							} else {
								$like["user_profile_pic"] ="";
							}

							$like["short_name"] =strtoupper(substr($data_like["user_first_name"], 0, 1).substr($data_like["user_last_name"], 0, 1) );
							array_push($feed["like"], $like);
						}
					}
					if ($clike > 0) {
						$feed["like_status"] = "1";
					} else {
						$feed["like_status"] = "0";
					}
					// $qcomment=$d->select("timeline_comments","feed_id='$feed_id'","ORDER BY comments_id DESC");
					/*$qcomment = $d->selectRow("timeline_comments.comments_id,timeline_comments.timeline_id,timeline_comments.msg,users_master.user_full_name,users_master.user_id,timeline_comments.modify_date,user_employment_details.company_logo","timeline_comments,users_master,user_employment_details", " user_employment_details.user_id=users_master.user_id and  timeline_comments.timeline_id='$timeline_id' AND timeline_comments.user_id=users_master.user_id AND timeline_comments.parent_comments_id=0", "ORDER BY timeline_comments.comments_id DESC");*/
					$commnet_status = "0";
					$c_data = $comment_data[$timeline_id];
					if (count($c_data) > 0) {
						$feed["comment"] = array();

						for ($k=0; $k <count($c_data) ; $k++) { 
							$data_comment = $c_data[$k];
						 
							$comment = array();
							$comment["comments_id"] = $data_comment['comments_id'];
							$comment["timeline_id"] = $data_comment['timeline_id'];
							$comment["msg"] = html_entity_decode($data_comment['msg']);
							$comment["company_name"] = html_entity_decode($data_comment['company_name']);

							
							$comment["user_name"] = $data_comment['user_full_name'];
							$comment["user_id"] = $data_comment['user_id'];
							$comment["modify_date"] = date("d M Y h:i A", strtotime($data_comment['modify_date']));
							
							if($data_comment['user_profile_pic'] !=""){
								$comment["user_profile_pic"] = $base_url . "img/users/members_profile/" . $data_comment['user_profile_pic'];
							} else {
								$comment["user_profile_pic"] ="";
							}

							$comment["short_name"] =strtoupper(substr($data_comment["user_first_name"], 0, 1).substr($data_comment["user_last_name"], 0, 1) );
							if($commnet_status=="0"){
								if ($my_id == $data_comment['user_id']) {
								$feed["comment_status"] = "1";
								$commnet_status=1;
								} else {
									$feed["comment_status"] = "0";
								}
							}
							
							$comment["sub_comment"] = array();
							/*$q4 = $d->selectRow("timeline_comments.comments_id,timeline_comments.timeline_id,timeline_comments.msg,users_master.user_full_name,users_master.user_id,user_employment_details.company_logo,timeline_comments.modify_date","timeline_comments,users_master,user_employment_details", " user_employment_details.user_id = users_master.user_id and timeline_comments.timeline_id='$timeline_id' AND timeline_comments.user_id=users_master.user_id AND timeline_comments.parent_comments_id='$data_comment[comments_id]'", "ORDER BY timeline_comments.comments_id DESC");*/

							$sub_com_da = $comment_sub_data[$timeline_id."__".$data_comment[comments_id]];
							for ($sc=0; $sc < count($sub_com_da) ; $sc++) { 
								$subCommentData =$sub_com_da[$sc];
							 
								$sub_comment = array();
								$sub_comment["comments_id"] = $subCommentData['comments_id'];
								$sub_comment["timeline_id"] = $subCommentData['timeline_id'];
								$sub_comment["msg"] = html_entity_decode($subCommentData['msg']);
								$sub_comment["company_name"] = html_entity_decode($subCommentData['company_name']);
								

								$sub_comment["user_name"] = $subCommentData['user_full_name'];
								$sub_comment["user_id"] = $subCommentData['user_id'];
								if($subCommentData['user_profile_pic'] !=""){
									$sub_comment["user_profile_pic"] = $base_url . "img/users/members_profile/" . $subCommentData['user_profile_pic'];
								} else {
									$sub_comment["user_profile_pic"] ="";
								}
								$sub_comment["short_name"] =strtoupper(substr($subCommentData["user_first_name"], 0, 1).substr($subCommentData["user_last_name"], 0, 1) );

								if($commnet_status=="0"){
									if ($my_id == $subCommentData['user_id']) {
									$feed["comment_status"] = "1";
									$commnet_status=1;
									} else {
										$feed["comment_status"] = "0";
									}
								}

							
								//$sub_comment["modify_date"] = time_elapsed_string($subCommentData['modify_date']);
								if(strtotime($subCommentData['modify_date']) < strtotime('-30 days')) {
									$sub_comment["modify_date"] = date("j M Y", strtotime($subCommentData['modify_date']));
								} else {
									$sub_comment["modify_date"]= time_elapsed_string($subCommentData['modify_date']);
								}
								array_push($comment["sub_comment"], $sub_comment);
							}
							array_push($feed["comment"], $comment);
						}
					} else {
							$feed["comment_status"] = "0";
						}
					array_push($response["feed"], $feed);
				}
				$q2222 = $d->selectRow("user_notification_id","user_notification", "user_id='$user_id' AND  notification_type=1 AND read_status=0  and status='Active' ");
				$response["unread_notification"] = mysqli_num_rows($q2222);
				$response["total_post"] = $total_post . '';
				$response["totalFeed"] = (string)$total_post;
				$response["followers"] = $followers . '';
				$response["following"] = $following . '';
				$response["follow_status"] = $follow_status;
				$response["totalSocietyFeedLimit"] =  $total_post;
				if(isset($pos1)){
					$response["pos1"] = $pos1 + 0;
				} else {
					$response["pos1"] = 0;
				}
				
				
				$response["totalSocietyFeedLimit"] =  $total_post;
				$response["pos1"] = 0;
				$response["message"] = "Get Feeds Success.";
				$response["status"] = "200";
				echo json_encode($response);
			} else {
				$response["unread_notification"] = 0;
				$response["total_post"] = $total_post . '';

				$response["totalFeed"] =(string) $total_post;
				$response["followers"] = $followers . '';
				$response["following"] = $following . '';
				$response["follow_status"] = $follow_status;
				$response["totalSocietyFeedLimit"] =  $total_post;
				$response["message"] = "No Timeline Data Available";
				$response["status"] = "201";
				echo json_encode($response);
			}
		} else if ($_POST['getMyFeed'] == "getOtherFeed") {

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
$blocked_users = implode(",", $blocked_users); 

			if(isset($limit_feed)){

				$qnotification = $d->selectRow("users_master.user_first_name,users_master.user_last_name,
timeline_master.meetup_user_id2,timeline_master.meetup_user_id1,timeline_master.timeline_id,timeline_master.timeline_text,users_master.user_full_name,users_master.user_id,user_employment_details.company_logo,timeline_master.timeline_id,timeline_master.feed_type,timeline_master.created_date,users_master.user_profile_pic,users_master.user_mobile, users_master.public_mobile","timeline_master,users_master,user_employment_details", "user_employment_details.user_id = users_master.user_id and   timeline_master.active_status = 0 AND timeline_master.user_id='$user_id' AND users_master.user_id='$user_id' and timeline_master.user_id not in ($blocked_users)
 ", "ORDER BY timeline_id DESC LIMIT $limit_feed, 10");

				 
				
			} else {
				$qnotification = $d->selectRow("users_master.user_first_name,users_master.user_last_name,
timeline_master.meetup_user_id2,timeline_master.meetup_user_id1,timeline_master.timeline_id,timeline_master.timeline_text,users_master.user_full_name,users_master.user_id,user_employment_details.company_logo,timeline_master.timeline_id,timeline_master.feed_type,timeline_master.created_date,users_master.user_profile_pic,users_master.user_mobile, users_master.public_mobile","timeline_master,users_master,user_employment_details", "user_employment_details.user_id = users_master.user_id and   timeline_master.active_status = 0 AND timeline_master.user_id='$user_id' AND users_master.user_id='$user_id' and timeline_master.user_id not in ($blocked_users)
", "ORDER BY timeline_id DESC LIMIT 500");
			}


			

			//code optimize

                $dataArray = array();
                $counter = 0 ;
                foreach ($qnotification as  $value) {
                    foreach ($value as $key => $valueNew) {
                        $dataArray[$counter][$key] = $valueNew;
                    }
                    $counter++;
                }
                $user_id_array = array('0');
                $timeline_id_array = array('0');
                for ($l=0; $l < count($dataArray) ; $l++) {
                    $user_id_array[] = $dataArray[$l]['user_id'];
                    $timeline_id_array[] = $dataArray[$l]['timeline_id'];
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


                $timeline_id_array = implode(",", $timeline_id_array);
                 

                  $video_main_qry = $d->selectRow("photo_name,feed_img_height,feed_img_width,video_name,timeline_id,user_id,feed_img_height,feed_img_width","timeline_photos_master", "timeline_id in($timeline_id_array)   AND user_id in ($user_id_array) ");

                $VArray = array();
                $Vcounter = 0 ;
                foreach ($video_main_qry as  $value) {
                    foreach ($value as $key => $valueNew) {
                        $VArray[$Vcounter][$key] = $valueNew;
                    }
                    $Vcounter++;
                }
                 $video_data_arr = array();
                 $video_data_arr2 = array();
                for ($dv=0; $dv < count($VArray) ; $dv++) {
                    $video_data_arr[$VArray[$dv]['timeline_id']."__".$VArray[$dv]['user_id']] = $VArray[$dv];
                    $video_data_arr2[$VArray[$dv]['timeline_id']."__".$VArray[$dv]['user_id']][] = $VArray[$dv];
                }

                $photo_qry = $d->selectRow("photo_name,feed_img_height,feed_img_width,timeline_id,user_id","timeline_photos_master", "timeline_id in ($timeline_id_array)   AND user_id in ($user_id_array) ");
                 $PArray = array();
                $Pcounter = 0 ;
                foreach ($photo_qry as  $value) {
                    foreach ($value as $key => $valueNew) {
                        $PArray[$Pcounter][$key] = $valueNew;
                    }
                    $Pcounter++;
                }
                $photo_array = array();
                for ($pd=0; $pd < count($PArray) ; $pd++) {
                    $photo_array[$PArray[$pd]['timeline_id']."__".$PArray[$pd]['user_id']][] = $PArray[$pd]; 
                }

                $qlike_qry = $d->selectRow("users_master.user_first_name,users_master.user_last_name,timeline_like_master.like_id,timeline_like_master.timeline_id,users_master.user_id,users_master.user_full_name,timeline_like_master.modify_date,user_employment_details.company_logo,users_master.user_profile_pic","timeline_like_master,users_master,user_employment_details", "user_employment_details.user_id = users_master.user_id and  timeline_like_master.timeline_id in ($timeline_id_array)  AND timeline_like_master.user_id=users_master.user_id AND timeline_like_master.active_status=0");
                $LArray = array();
                $Lcounter = 0 ;
                foreach ($qlike_qry as  $value) {
                    foreach ($value as $key => $valueNew) {
                        $LArray[$Lcounter][$key] = $valueNew;
                    }
                    $Lcounter++;
                }
                $qlike_data = array();
                for ($pd=0; $pd < count($LArray) ; $pd++) {
                    $qlike_data[$LArray[$pd]['timeline_id']][] = $LArray[$pd]; 
                }

                $qcomment_qry = $d->selectRow("users_master.user_first_name,users_master.user_last_name,timeline_comments.comments_id,timeline_comments.timeline_id,timeline_comments.msg,users_master.user_full_name,users_master.user_id,timeline_comments.modify_date,user_employment_details.company_logo , user_employment_details.company_name,users_master.user_profile_pic ","timeline_comments,users_master,user_employment_details", " user_employment_details.user_id=users_master.user_id and  timeline_comments.timeline_id in ($timeline_id_array)  AND timeline_comments.user_id=users_master.user_id AND timeline_comments.parent_comments_id=0", "group by timeline_comments.comments_id ORDER BY timeline_comments.comments_id DESC");
                $QArray = array();
                $Qcounter = 0 ;
                foreach ($qcomment_qry as  $value) {
                    foreach ($value as $key => $valueNew) {
                        $QArray[$Qcounter][$key] = $valueNew;
                    }
                    $Qcounter++;
                }
                $comment_data = array();
                $comments_id_array = array('0');
                for ($pq=0; $pq < count($QArray) ; $pq++) {
                    $comment_data[$QArray[$pq]['timeline_id']][] = $QArray[$pq]; 
                    $comments_id_array[] = $QArray[$pq]['comments_id'];
                }


                $clike_q = $d->selectRow("count(*) as cnt, like_id,timeline_id", "timeline_like_master", "timeline_id  in ($timeline_id_array) AND user_id = '$my_id' AND active_status=0 group by timeline_id");
                $clike_array = array();
                while($clike_data = mysqli_fetch_array($clike_q)){
                	$clike_array[$clike_data['timeline_id']] = $clike_data['cnt'];
                }



                $comments_id_array = implode(",", $comments_id_array);
                $sub_data_qry = $d->selectRow("users_master.user_first_name,users_master.user_last_name,timeline_comments.parent_comments_id,timeline_comments.comments_id,timeline_comments.timeline_id,timeline_comments.msg,users_master.user_full_name,users_master.user_id,user_employment_details.company_logo,timeline_comments.modify_date, user_employment_details.company_name,users_master.user_profile_pic","timeline_comments,users_master,user_employment_details", " user_employment_details.user_id = users_master.user_id and timeline_comments.timeline_id in ($timeline_id_array) AND timeline_comments.user_id=users_master.user_id AND timeline_comments.parent_comments_id in ($comments_id_array)  ", "group by timeline_comments.comments_id ORDER BY timeline_comments.comments_id DESC");

                $SDQArray = array();
                $SDQcounter = 0 ;
                foreach ($sub_data_qry as  $value) {
                    foreach ($value as $key => $valueNew) {
                        $SDQArray[$SDQcounter][$key] = $valueNew;
                    }
                    $SDQcounter++;
                }
                $comment_sub_data = array(); 
                for ($ps=0; $ps < count($SDQArray) ; $ps++) {
                    $comment_sub_data[$SDQArray[$ps]['timeline_id']."__".$SDQArray[$ps]['parent_comments_id']][] = $SDQArray[$ps];  
                } 
               // echo "<pre>";print_r($comment_sub_data);exit;


//code optimize



			$tq11 = $d->selectRow("timeline_id", "timeline_master", "user_id='$user_id' and timeline_master.user_id not in ($blocked_users)
 ");
			$total_post = mysqli_num_rows($tq11);
			$tq22 = $d->selectRow("follow_master.follow_id","users_master,follow_master,user_employment_details,business_categories,business_sub_categories", "business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id AND follow_master.follow_by=users_master.user_id AND follow_master.follow_to='$user_id'", "ORDER BY users_master.user_full_name ASC");
			// $tq22=$d->selectRow("follow_id","follow_master","follow_by!='$data_app[user_id]'");
			$followers = mysqli_num_rows($tq22);
			$tq33 = $d->selectRow("follow_master.follow_id","users_master,follow_master,user_employment_details,business_categories,business_sub_categories", "business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id AND follow_master.follow_to=users_master.user_id AND follow_master.follow_by='$user_id'", "ORDER BY users_master.user_full_name ASC");
			// $tq33=$d->selectRow("follow_id","follow_master","follow_by='$data_app[user_id]'");
			$following = mysqli_num_rows($tq33);
			$qche = $d->selectRow("follow_id","follow_master", "follow_by='$my_id' AND follow_to='$user_id'");
			if (mysqli_num_rows($qche) > 0) {
				$follow_status = true;
			} else {
				$follow_status = false;
			}

			if (count($dataArray) > 0) {
				$response["feed"] = array();
				 for ($l=0; $l < count($dataArray) ; $l++) {
				 	$data_notification = $dataArray[$l];
				//while ($data_notification = mysqli_fetch_array($qnotification)) {
					$feed = array();

					//11march
							$feed["user_mobile"] =  $data_notification["user_mobile"];
							if($data_notification['public_mobile'] =="0"){
								$feed["mobile_privacy"]=true;
							} else {
								$feed["mobile_privacy"]=false;
							}
							//11march

					$qche = $fol_array[$data_notification[user_id]];//  
					if (count($qche) > 0) {
						$follow_status = true;
					} else {
						$follow_status = false;
					}

					$feed["is_follow"] = $follow_status;
					 



					if($my_id==$user_id || $data_notification[user_id]==0 ){
						 $feed["show_follow_icon"] = false;
					} else {
						$feed["show_follow_icon"] = true;
					}



					
					$feed["timeline_id"] = $data_notification['timeline_id'];
					$feed["timeline_text"] = htmlspecialchars_decode (stripslashes(  html_entity_decode($data_notification['timeline_text'] )) );    

					$feed["timeline_text"] = html_entity_decode($feed["timeline_text"] , ENT_QUOTES); 

					 $feed["timeline_text"] = htmlspecialchars_decode($feed["timeline_text"], ENT_QUOTES);
						$feed["timeline_text"] =html_entity_decode ($feed["timeline_text"]);


					$feed["short_name"] =strtoupper(substr($data_notification["user_first_name"], 0, 1).substr($data_notification["user_last_name"], 0, 1) );
					$feed["user_name"] = $data_notification['user_full_name'];
					$feed["user_id"] = $data_notification['user_id'];
					
					if($data_notification['user_profile_pic'] !=""){
						$feed["user_profile_pic"] = $base_url . "img/users/members_profile/" . $data_notification['user_profile_pic'];
					} else {
						$feed["user_profile_pic"] ="";
					}
					$timeline_id = $data_notification['timeline_id'];
					$feed["feed_type"] = $data_notification['feed_type'];
					$feed["meetup_user_id2"] = $data_notification['meetup_user_id2'];
					$feed["meetup_user_id1"] = $data_notification['meetup_user_id1'];


					if($data_notification['feed_type'] == "2"){

							 
							$video_data = $video_data_arr[$timeline_id."__".$data_notification[user_id]];  
							$feed["video_thumb"] = $base_url . "img/timeline/" . $video_data['photo_name'];
							$feed["feed_video"] = $base_url . "img/timeline/" . $video_data['video_name'];
						}else {
							$feed["video_thumb"] ="";
							$feed["feed_video"] ="";
						}

					if(strtotime($data_notification['created_date']) < strtotime('-30 days')) {
						$feed["modify_date"] = date("j M Y", strtotime($data_notification['created_date']));
					} else {
						$feed["modify_date"] = time_elapsed_string($data_notification['created_date']);
					}

					
					/*$fi = $d->selectRow("photo_name,feed_img_height,feed_img_width","timeline_photos_master", "timeline_id='$timeline_id' AND user_id='$data_notification[user_id]'");*/
					$p_data_arr = $photo_array[$timeline_id."__".$data_notification['user_id']];
					$feed["timeline_photos"] = array();
					for ($pda=0; $pda < count($p_data_arr) ; $pda++) { 
						$feeData = $p_data_arr[$pda];


						$timeline_photos = array();
						$timeline_photos["photo_name"] = $base_url . "img/timeline/" . $feeData['photo_name'];
						$timeline_photos["feed_height"] = $feeData['feed_img_height'];
						$timeline_photos["feed_width"] = $feeData['feed_img_width'];
						array_push($feed["timeline_photos"], $timeline_photos);
					}
					/*$qlike = $d->selectRow("timeline_like_master.like_id,timeline_like_master.timeline_id,users_master.user_id,users_master.user_full_name,timeline_like_master.modify_date,user_employment_details.company_logo","timeline_like_master,users_master,user_employment_details", " user_employment_details.user_id = users_master.user_id and  timeline_like_master.timeline_id='$timeline_id' AND timeline_like_master.user_id=users_master.user_id AND timeline_like_master.active_status=0");*/

					$like_details = $qlike_data[$timeline_id];

					$totalLikes = count($like_details);
					$feed["totalLikes"] = "$totalLikes";
					$clike = $clike_array[$timeline_id];
					if (count($like_details) > 0) {
						$feed["like"] = array();
						for ($ql=0; $ql < count($like_details) ; $ql++) { 
							$data_like = $like_details[$ql];
							$like = array();
							$like["like_id"] = $data_like['like_id'];
							$like["timeline_id"] = $data_like['timeline_id'];
							$like["user_id"] = $data_like['user_id'];
							$like["user_name"] = $data_like['user_full_name'];
							$like["modify_date"] ="";// date("d M Y h:i A", strtotime($data_like['modify_date']));
							
							if($data_like['user_profile_pic'] !=""){
								$like["user_profile_pic"] = $base_url . "img/users/members_profile/" . $data_like['user_profile_pic'];
							} else {
								$like["user_profile_pic"] ="";
							}

							$like["short_name"] =strtoupper(substr($data_like["user_first_name"], 0, 1).substr($data_like["user_last_name"], 0, 1) );
							array_push($feed["like"], $like);
						}
					}
					if ($clike > 0) {
						$feed["like_status"] = "1";
					} else {
						$feed["like_status"] = "0";
					}
					// $qcomment=$d->select("timeline_comments","feed_id='$feed_id'","ORDER BY comments_id DESC");
					 

					$c_data = $comment_data[$timeline_id];
					if (count($c_data) > 0) {
						$feed["comment"] = array();
						for ($k=0; $k <count($c_data) ; $k++) { 
							$data_comment = $c_data[$k];

							$comment = array();
							$comment["comments_id"] = $data_comment['comments_id'];
							$comment["timeline_id"] = $data_comment['timeline_id'];
							$comment["msg"] = html_entity_decode($data_comment['msg']);
							$comment["company_name"] = html_entity_decode($data_comment['company_name']);
							

							$comment["user_name"] = $data_comment['user_full_name'];
							$comment["user_id"] = $data_comment['user_id'];
							$comment["modify_date"] = date("d M Y h:i A", strtotime($data_comment['modify_date']));
							
							if($data_comment['user_profile_pic'] !=""){
								$comment["user_profile_pic"] = $base_url . "img/users/members_profile/" . $data_comment['user_profile_pic'];
							} else {
								$comment["user_profile_pic"] ="";
							}

							$comment["short_name"] =strtoupper(substr($data_comment["user_first_name"], 0, 1).substr($data_comment["user_last_name"], 0, 1) );
							if ($user_id == $data_comment['user_id']) {
								$feed["comment_status"] = "1";
							} else {
								$feed["comment_status"] = "0";
							}
							$comment["sub_comment"] = array();
							 

								$sub_com_da = $comment_sub_data[$timeline_id."__".$data_comment[comments_id]];
							for ($sc=0; $sc < count($sub_com_da) ; $sc++) { 
								$subCommentData =$sub_com_da[$sc];


								$sub_comment = array();
								$sub_comment["comments_id"] = $subCommentData['comments_id'];
								$sub_comment["timeline_id"] = $subCommentData['timeline_id'];
								$sub_comment["msg"] = html_entity_decode($subCommentData['msg']);
								$sub_comment["company_name"] = html_entity_decode($subCommentData['company_name']);
								

								$sub_comment["user_name"] = $subCommentData['user_full_name'];
								$sub_comment["user_id"] = $subCommentData['user_id'];
								if($subCommentData['user_profile_pic'] !=""){
									$sub_comment["user_profile_pic"] = $base_url . "img/users/members_profile/" . $subCommentData['user_profile_pic'];
								} else {
									$sub_comment["user_profile_pic"] ="";
								}
								$sub_comment["short_name"] =strtoupper(substr($subCommentData["user_first_name"], 0, 1).substr($subCommentData["user_last_name"], 0, 1) );
								//$sub_comment["modify_date"] = time_elapsed_string($subCommentData['modify_date']);
								if(strtotime($subCommentData['modify_date']) < strtotime('-30 days')) {
									$sub_comment["modify_date"] = date("j M Y", strtotime($subCommentData['modify_date']));
								} else {
									$sub_comment["modify_date"] = time_elapsed_string($subCommentData['modify_date']);
								}
								array_push($comment["sub_comment"], $sub_comment);
							}
							array_push($feed["comment"], $comment);
						}
					} else {
							$feed["comment_status"] = "0";
						}
					array_push($response["feed"], $feed);
				}
				$response["total_post"] = $total_post . '';

				$response["totalFeed"] =(string) $total_post;
				$response["followers"] = $followers . '';
				$response["following"] = $following . '';
				$response["follow_status"] = $follow_status;
				$response["totalSocietyFeedLimit"] =  $total_post;
				if(isset($pos1)){
					$response["pos1"] = $pos1 + 0;
				} else {
					$response["pos1"] = 0;
				}
				$response["totalSocietyFeedLimit"] =   $total_post;
				 
				$response["message"] = "Get Feeds Success.";
				$response["status"] = "200";
				echo json_encode($response);
			} else {
				$response["total_post"] = $total_post . '';
				
				$response["totalFeed"] =(string) $total_post;
				$response["followers"] = $followers . '';
				$response["following"] = $following . '';
				$response["follow_status"] = $follow_status;
				$response["totalSocietyFeedLimit"] =   $total_post;
				$response["message"] = "No Timeline Data Available";
				$response["status"] = "201";
				echo json_encode($response);
			}
		} else if ($_POST['addFeed'] == "editFeed" && filter_var($user_id, FILTER_VALIDATE_INT) == true && filter_var($timeline_id, FILTER_VALIDATE_INT) == true) {
			$m->set_data('timeline_text', stripslashes(  html_entity_decode(($timeline_text))));
			$a1 = array(
				'timeline_text' => $m->get_data('timeline_text'),
			);
			$d->update("timeline_master", $a1, "timeline_id='$timeline_id'");
			if ($d == TRUE) {
				$d->insert_myactivity($user_id,"0","", $timeline_text."Post Updated","activity.png");
				$response["message"] = "Updated Successfully";
				$response["status"] = "200";
				echo json_encode($response);
			} else {
				$response["message"] = "Something Wrong";
				$response["status"] = "201";
				echo json_encode($response);
			}
		} else if ($_POST['getNotificationFeed'] == "getNotificationFeed" && filter_var($user_id, FILTER_VALIDATE_INT) == true && filter_var($timeline_id, FILTER_VALIDATE_INT) == true) {
			$qnotification = $d->selectRow("timeline_master.user_id,timeline_master.timeline_id,timeline_master.timeline_text,timeline_master.feed_type,timeline_master.created_date","timeline_master", "active_status = 0 and timeline_id='$timeline_id' ", " ");
			
 //code optimize

                $dataArray = array();
                $counter = 0 ;
                foreach ($qnotification as  $value) {
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

                $user_qry = $d->selectRow("users_master.user_profile_pic,users_master.user_first_name,users_master.user_last_name,user_employment_details.company_name,users_master.user_full_name,user_employment_details.company_name,users_master.user_id,company_logo,users_master.user_profile_pic","users_master,user_employment_details", "
							user_employment_details.user_id=users_master.user_id and
							users_master.user_id in ($user_id_array)  ", "");

                $UArray = array();
                $Ucounter = 0 ;
                foreach ($user_qry as  $value) {
                    foreach ($value as $key => $valueNew) {
                        $UArray[$Ucounter][$key] = $valueNew;
                    }
                    $Ucounter++;
                }
                $u_array = array();
                for ($l=0; $l < count($UArray) ; $l++) {
                    $u_array[$UArray[$l]['user_id']] = $UArray[$l];
                }

                $photos_qry = $d->selectRow("user_id,photo_name,feed_img_height,feed_img_width","timeline_photos_master", "timeline_id='$timeline_id' AND user_id in ($user_id_array) ");
                

                $PArray = array();
                $Pcounter = 0 ;
                foreach ($photos_qry as  $value) {
                    foreach ($value as $key => $valueNew) {
                        $PArray[$Pcounter][$key] = $valueNew;
                    }
                    $Pcounter++;
                }
               $photos_data = array();
                for ($l=0; $l < count($PArray) ; $l++) {
                    $photos_data[$PArray[$l]['user_id']][] = $PArray[$l];
                }

                 $qlike_q = $d->selectRow("timeline_like_master.like_id,timeline_like_master.timeline_id,users_master.user_id,users_master.user_full_name,timeline_like_master.modify_date,user_employment_details.company_logo,users_master.user_profile_pic","timeline_like_master,users_master,user_employment_details", "user_employment_details.user_id = users_master.user_id and  timeline_like_master.timeline_id='$timeline_id' AND timeline_like_master.user_id=users_master.user_id");
                 
                $LArray = array();
                $Lcounter = 0 ;
                foreach ($qlike_q as  $value) {
                    foreach ($value as $key => $valueNew) {
                        $LArray[$Lcounter][$key] = $valueNew;
                    }
                    $Lcounter++;
                }
               
               $qlike_data =array();
                for ($l=0; $l < count($LArray) ; $l++) {
                    $qlike_data[$LArray[$l]['timeline_id']][] = $LArray[$l];
                }

                $clike_new = $d->count_data_direct("like_id", "timeline_like_master", "timeline_id='$timeline_id' AND user_id = '$user_id' AND active_status=0");
 				

 				$qcomment_q = $d->selectRow("timeline_comments.comments_id,timeline_comments.timeline_id,timeline_comments.msg,users_master.user_full_name,users_master.user_id,timeline_comments.modify_date,user_employment_details.company_logo, user_employment_details.company_name,users_master.user_profile_pic","timeline_comments,users_master,user_employment_details", " user_employment_details.user_id = users_master.user_id and  timeline_comments.timeline_id='$timeline_id' AND timeline_comments.user_id=users_master.user_id AND timeline_comments.parent_comments_id=0", "group by timeline_comments.comments_id ORDER BY timeline_comments.comments_id DESC");


 				$QArray = array();
                $Qcounter = 0 ;
                foreach ($qcomment_q as  $value) {
                    foreach ($value as $key => $valueNew) {
                        $QArray[$Qcounter][$key] = $valueNew;
                    }
                    $Qcounter++;
                }
               
               $cmt_data =array();
               $comments_id_array = array('0');
                for ($cm=0; $cm < count($QArray) ; $cm++) {
                    $cmt_data[$QArray[$cm]['timeline_id']][] = $QArray[$cm];
                    $comments_id_array[] = $QArray[$cm]['comments_id'];
                }
                $comments_id_array = implode(",", $comments_id_array);

                $sub_qry = $d->selectRow("timeline_comments.parent_comments_id,timeline_comments.comments_id,timeline_comments.timeline_id,timeline_comments.msg,users_master.user_full_name,users_master.user_id,user_employment_details.company_logo,timeline_comments.modify_date, user_employment_details.company_name,users_master.user_profile_pic","timeline_comments,users_master,user_employment_details", "user_employment_details.user_id = users_master.user_id and  timeline_comments.timeline_id='$timeline_id' AND timeline_comments.user_id=users_master.user_id AND timeline_comments.parent_comments_id in ($comments_id_array)  ", "group by timeline_comments.comments_id ORDER BY timeline_comments.comments_id DESC");
                $SArray = array();
                $Scounter = 0 ;
                foreach ($sub_qry as  $value) {
                    foreach ($value as $key => $valueNew) {
                        $SArray[$Scounter][$key] = $valueNew;
                    }
                    $Scounter++;
                }
               
                $sub_cmt_data =array();
                for ($cm=0; $cm < count($SArray) ; $cm++) {
                    $sub_cmt_data[$SArray[$cm]['parent_comments_id']][] = $SArray[$cm]; 
                }
            // echo "<pre>";print_r($sub_cmt_data);exit;
//code optimize
			if (count($dataArray) > 0) {
				$response["feed"] = array();
				for ($l=0; $l < count($dataArray) ; $l++) {
					$data_notification =$dataArray[$l];
				//while ($data_notification = mysqli_fetch_array($qnotification)) {
					$feed = array();
					//23oct2020
					if($data_notification['user_id'] !="0"){
						$uid=$data_notification['user_id'];
						  
						$userData =$u_array[$uid];
						$userProfile = $base_url . "img/users/recident_profile/" . $userData['user_profile_pic'];
						$user_full_name = $userData['user_first_name'].' '.$userData['user_last_name'];
						$company = $userData['company_name'];
						$feed["user_name"] = $userData['user_full_name'];
						$feed["company_name"] = html_entity_decode($userData['company_name']);
						$feed["user_id"] = $userData['user_id'];
		 
						if($userData['user_profile_pic'] !=""){
							$feed["user_profile_pic"] = $base_url . "img/users/members_profile/" . $userData['user_profile_pic'];
						} else {
							$feed["user_profile_pic"] ="";
						}
					} else {
						$feed["user_profile_pic"] = $base_url . "img/fav.png";
						$feed["user_id"] = 0;
						$feed["user_name"] ='Admin';
						$feed["company_name"] = 'ZooBiz';
					}
//23oct2020
					
					$feed["timeline_id"] = $data_notification['timeline_id'];
					$feed["timeline_text"] = htmlspecialchars_decode (stripslashes(  html_entity_decode($data_notification['timeline_text'] )) );    

					$feed["timeline_text"] = html_entity_decode($feed["timeline_text"] , ENT_QUOTES);

					 $feed["timeline_text"] = htmlspecialchars_decode($feed["timeline_text"], ENT_QUOTES);
						$feed["timeline_text"] =html_entity_decode ($feed["timeline_text"]);
						
					$feed["short_name"] =strtoupper(substr($data_notification["user_first_name"], 0, 1).substr($data_notification["user_last_name"], 0, 1) );
					$timeline_id = $data_notification['timeline_id'];
					$feed["feed_type"] = $data_notification['feed_type'];
					$feed["modify_date"] = time_elapsed_string($data_notification['created_date']);
					/*$fi = $d->selectRow("photo_name,feed_img_height,feed_img_width","timeline_photos_master", "timeline_id='$timeline_id' AND user_id='$data_notification[user_id]'");*/
					$p_data = $photos_data[$data_notification['user_id']];
					$feed["timeline_photos"] = array();
					for ($n=0; $n < count($p_data) ; $n++) { 
						$feeData =$p_data[$n];
					 
						$timeline_photos = array();
						if($feeData['photo_name']!=""){
							$timeline_photos["photo_name"] = $base_url . "img/timeline/" . $feeData['photo_name'];
						} else {
							$timeline_photos["photo_name"] ="";
						}
						
						$timeline_photos["feed_height"] = $feeData['feed_img_height'];
						$timeline_photos["feed_width"] = $feeData['feed_img_width'];
						array_push($feed["timeline_photos"], $timeline_photos);
					}
					/*$qlike = $d->selectRow("timeline_like_master.like_id,timeline_like_master.timeline_id,users_master.user_id,users_master.user_full_name,timeline_like_master.modify_date,user_employment_details.company_logo","timeline_like_master,users_master,user_employment_details", "user_employment_details.user_id = users_master.user_id and  timeline_like_master.timeline_id='$timeline_id' AND timeline_like_master.user_id=users_master.user_id");*/

					$q_data = $qlike_data[$timeline_id];
 
					$totalLikes = count($q_data);
					$feed["totalLikes"] = "$totalLikes";
					$clike =$clike_new;// $d->count_data_direct("like_id", "timeline_like_master", "timeline_id='$timeline_id' AND user_id = '$user_id' AND active_status=0");
					if (count($q_data) > 0) {
						$feed["like"] = array();
						for ($lf=0; $lf < count($q_data) ; $lf++) { 
							$data_like = $q_data[$lf];
						 
							$like = array();
							$like["like_id"] = $data_like['like_id'];
							$like["timeline_id"] = $data_like['timeline_id'];
							$like["user_id"] = $data_like['user_id'];
							$like["user_name"] = $data_like['user_full_name'];
							$like["modify_date"] ="";// $data_like['modify_date'];
							
							if($data_like['user_profile_pic'] !=""){
								$like["user_profile_pic"] = $base_url . "img/users/members_profile/" . $data_like['user_profile_pic'];
							} else {
								$like["user_profile_pic"] ="";
							}

							$like["short_name"] =strtoupper(substr($data_like["user_first_name"], 0, 1).substr($data_like["user_last_name"], 0, 1) );
							array_push($feed["like"], $like);
						}
					}
					if ($clike > 0) {
						$feed["like_status"] = "1";
					} else {
						$feed["like_status"] = "0";
					}
					// $qcomment=$d->select("timeline_comments","feed_id='$feed_id'","ORDER BY comments_id DESC");
					/*$qcomment = $d->selectRow("timeline_comments.comments_id,timeline_comments.timeline_id,timeline_comments.msg,users_master.user_full_name,users_master.user_id,timeline_comments.modify_date,user_employment_details.company_logo","timeline_comments,users_master,user_employment_details", " user_employment_details.user_id = users_master.user_id and  timeline_comments.timeline_id='$timeline_id' AND timeline_comments.user_id=users_master.user_id AND timeline_comments.parent_comments_id=0", "ORDER BY timeline_comments.comments_id DESC");*/
					$comment_data = $cmt_data[$timeline_id];
					if (count($comment_data) > 0) {
						$feed["comment"] = array();
						for ($op=0; $op < count($comment_data) ; $op++) { 
							$data_comment = $comment_data[$op];
						 
							$comment = array();
							$comment["comments_id"] = $data_comment['comments_id'];
							$comment["timeline_id"] = $data_comment['timeline_id'];
							$comment["msg"] = html_entity_decode($data_comment['msg']);
							$comment["company_name"] = html_entity_decode( $data_comment['company_name']);
							
							$comment["user_name"] = $data_comment['user_full_name'];
							$comment["user_id"] = $data_comment['user_id'];
							$comment["modify_date"] = date("d M Y h:i A", strtotime($data_comment['modify_date']));
							
							if($data_comment['user_profile_pic'] !=""){
								$comment["user_profile_pic"] = $base_url . "img/users/members_profile/" . $data_comment['user_profile_pic'];
							} else {
								$comment["user_profile_pic"] ="";
							}

							$comment["short_name"] =strtoupper(substr($data_comment["user_first_name"], 0, 1).substr($data_comment["user_last_name"], 0, 1) );
							if ($user_id == $data_comment['user_id']) {
								$feed["comment_status"] = "1";
							} else {
								$feed["comment_status"] = "0";
							}
							$comment["sub_comment"] = array();
							/*$q4 = $d->selectRow("timeline_comments.comments_id,timeline_comments.timeline_id,timeline_comments.msg,users_master.user_full_name,users_master.user_id,user_employment_details.company_logo,timeline_comments.modify_date","timeline_comments,users_master,user_employment_details", "user_employment_details.user_id = users_master.user_id and  timeline_comments.timeline_id='$timeline_id' AND timeline_comments.user_id=users_master.user_id AND timeline_comments.parent_comments_id='$data_comment[comments_id]'", "ORDER BY timeline_comments.comments_id DESC");*/
							$sub_deta = $sub_cmt_data[$data_comment[comments_id]];

							for ($sc=0; $sc < count($sub_deta) ; $sc++) { 
								$subCommentData = $sub_deta[$sc];
							 
								$sub_comment = array();
								$sub_comment["comments_id"] = $subCommentData['comments_id'];
								$sub_comment["timeline_id"] = $subCommentData['timeline_id'];
								$sub_comment["msg"] = html_entity_decode($subCommentData['msg']);
								$sub_comment["company_name"] = html_entity_decode($subCommentData['company_name']);

								
								$sub_comment["user_name"] = $subCommentData['user_full_name'];
								$sub_comment["user_id"] = $subCommentData['user_id'];
								
								if($subCommentData['user_profile_pic'] !=""){
									$sub_comment["user_profile_pic"] = $base_url . "img/users/members_profile/" . $subCommentData['user_profile_pic'];
								} else {
									$sub_comment["user_profile_pic"] ="";
								}
								$sub_comment["short_name"] =strtoupper(substr($subCommentData["user_first_name"], 0, 1).substr($subCommentData["user_last_name"], 0, 1) );
								$sub_comment["modify_date"] = time_elapsed_string($subCommentData['modify_date']);
								array_push($comment["sub_comment"], $sub_comment);
							}
							array_push($feed["comment"], $comment);
						}
					}
					$response["totalSocietyFeedLimit"] =  $total_post;
					array_push($response["feed"], $feed);
				}
				$response["message"] = "Get Feeds Success.";
				$response["status"] = "200";
				echo json_encode($response);
			} else {
				$response["totalSocietyFeedLimit"] =   $total_post;
				$response["message"] = "Something Wrong";
				$response["status"] = "201";
				echo json_encode($response);
			}
		} 

//16dec2020
		else if ($_POST['saveTimeline'] == "saveTimeline" && filter_var($user_id, FILTER_VALIDATE_INT) == true && filter_var($timeline_id, FILTER_VALIDATE_INT) == true ) {
			
			if(isset($is_delete) && $is_delete=='true'){
				$d->delete("timeline_user_save_master", "user_id='$user_id' AND timeline_id='$timeline_id'");
				if($d == TRUE){ 
					$d->insert_myactivity($user_id,"0","", "Saved Post Removed","activity.png");
					$response["message"] = "Save Removed";
					$response["status"] = "200";
					echo json_encode($response);
				} else {
					$response["message"] = "Something Wrong";
					$response["status"] = "201";
					echo json_encode($response);
				}
			} else {



				$modify_date = date("Y-m-d H:i:s");
				$m->set_data('timeline_id', $timeline_id);
				$m->set_data('user_id', $user_id);
				$m->set_data('created_at', $modify_date);
				
				$a1 = array(
					'timeline_id' => $m->get_data('timeline_id'),
					'user_id' => $m->get_data('user_id'),
					'created_at' => $m->get_data('created_at')
				);
				$d->insert("timeline_user_save_master", $a1);


				if($d == TRUE){ 
					$d->insert_myactivity($user_id,"0","", "Post Saved","activity.png");
					$response["message"] = "Post Saved";
					$response["status"] = "200";
					echo json_encode($response);
				} else {
					$response["message"] = "Something Wrong";
					$response["status"] = "201";
					echo json_encode($response);
				}

			}

		}
//16dec2020

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
}?>