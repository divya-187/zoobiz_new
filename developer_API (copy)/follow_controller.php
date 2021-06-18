<?php
include_once 'lib.php';

/*ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);*/

if (isset($_POST) && !empty($_POST)) {

    if ($key == $keydb) {
        
    $response = array();
    extract(array_map("test_input" , $_POST));

        if ($_POST['addFollow'] == "addFollow" && filter_var($user_id, FILTER_VALIDATE_INT) == true && filter_var($follow_to, FILTER_VALIDATE_INT) == true) {

            if ($user_id==$follow_to) {
              $response["message"] = "You Can't";
              $response["status"] = "201";
              echo json_encode($response);
              exit();
            }

            //5nov 2020
            if($user_id==$follow_to){
              $response["message"] = "You Can't";
                $response["status"] = "201";
                echo json_encode($response);
                exit();
            }
            //5nov 2020

            $quc=$d->select("users_master","user_id='$follow_to'   ");
                $userData=mysqli_fetch_array($quc);


            $qche=$d->selectRow("follow_id","follow_master","follow_by='$user_id' AND follow_to='$follow_to'");
            if (mysqli_num_rows($qche)>0 ) {

              $d->delete("follow_master","follow_by='$user_id' AND follow_to='$follow_to'");

              $qucN=$d->selectRow("user_full_name,user_token,device,user_id","users_master","user_id='$user_id'   ");
                $userDataN=mysqli_fetch_array($qucN);
                
                $sos_user_token=$userData['user_token'];
                $device=$userData['device'];
                $feed_user_id=$userData['user_id'];
                $title= $userDataN['user_full_name'];
                $msg= "UnFollowed You";

                 /*$notiAry = array(
                  'user_id'=>$follow_to,
                  'notification_title'=>$title,
                  'notification_desc'=>$msg,    
                  'notification_date'=>date('Y-m-d H:i'),
                  'notification_action'=>'viewMemeber',
                  'notification_logo'=>'profile.png',
                  'notification_type'=>'3',
                  'other_user_id'=>$user_id,
                  'timeline_id'=>'',
                  );
                  $d->insert("user_notification",$notiAry);*/


                /*if (strtolower($device) =='android') {
                   $nResident->noti("viewMemeber","",0,$sos_user_token,$title,$msg,$user_id);
                }  else if(strtolower($device) =='ios') {
                  $nResident->noti_ios("viewMemeber","",0,$sos_user_token,$title,$msg,$user_id);
                }*/

              $d->insert_myactivity($user_id,"0","", ucfirst($userData['user_full_name'])." unfollowed by you.","activity.png");

                $response["message"] = "Unfollowed Successfully";
                $response["status"] = "200";
                echo json_encode($response);
                exit();
            } else {

                $m->set_data('follow_by', $user_id);
                $m->set_data('follow_to', $follow_to);
                $a = array(
                    'follow_by' => $m->get_data('follow_by'), 
                    'follow_to' => $m->get_data('follow_to'),
                    'created_at' =>date('Y-m-d h:i:s')
                );

                $d->insert("follow_master",$a);

$qucN=$d->selectRow("user_full_name,user_token,device,user_id","users_master","user_id='$user_id'   ");
                $userDataN=mysqli_fetch_array($qucN);
                
                $sos_user_token=$userData['user_token'];
                $device=$userData['device'];
                $feed_user_id=$userData['user_id'];
                $title="Follow";  
                $msg= ucfirst($userDataN['user_full_name']). " is Following You";

                 $notiAry = array(
                  'user_id'=>$follow_to,
                  'notification_title'=>$title,
                  'notification_desc'=>$msg,    
                  'notification_date'=>date('Y-m-d H:i'),
                  'notification_action'=>'viewMemeber',
                  'notification_logo'=>'profile.png',
                  'notification_type'=>'3',
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
                   $nResident->noti("viewMemeber","",0,$sos_user_token,$title,$msg,$user_id,1,$profile_u);
                }  else if(strtolower($device) =='ios') {
                  $nResident->noti_ios("viewMemeber","",0,$sos_user_token,$title,$msg,$user_id,1,$profile_u);
                }


                $d->insert_myactivity($user_id,"0","", '"'.ucfirst($userData['user_full_name']).'" Followed',"activity.png");
                $response["message"] = '"'.ucfirst($userData['user_full_name']).'" Followed..';
                $response["status"] = "200";
                echo json_encode($response);
                exit();

            }

        }else if ($_POST['unFollow'] == "unFollow" && filter_var($user_id, FILTER_VALIDATE_INT) == true && filter_var($follow_to, FILTER_VALIDATE_INT) == true) {


          //5nov 2020
            if($user_id==$follow_to){
              $response["message"] = "You Can't";
                $response["status"] = "201";
                echo json_encode($response);
                exit();
            }
            //5nov 2020


                $d->delete("follow_master","follow_by='$user_id' AND follow_to='$follow_to'");

                 $quc=$d->selectRow("user_token,device,user_id,user_full_name","users_master","user_id='$follow_to'  ");
                $userData=mysqli_fetch_array($quc);
                $sos_user_token=$userData['user_token'];
                $device=$userData['device'];
                $feed_user_id=$userData['user_id'];
                $title= "$user_name";
                $msg= "Un Followed You";

                //14dec2020
                 /*$notiAry = array(
                  'user_id'=>$follow_to,
                  'notification_title'=>$title,
                  'notification_desc'=>$msg,    
                  'notification_date'=>date('Y-m-d H:i'),
                  'notification_action'=>'viewMemeber',
                  'notification_logo'=>'profile.png',
                   
                  'other_user_id'=>$user_id,
                  'timeline_id'=>'',
                  );
                  $d->insert("user_notification",$notiAry);


                if ($device=='android') {
                   $nResident->noti("viewMemeber","",0,$sos_user_token,$title,$msg,$user_id);
                }  else if($device=='ios') {
                  $nResident->noti_ios("viewMemeber","",0,$sos_user_token,$title,$msg,$user_id);
                }*/

                $d->insert_myactivity($user_id,"0","", "You are not following ".ucfirst($userData['user_full_name']),"activity.png");
                $response["message"] = "Un Follow Successfully";
                $response["status"] = "200";
                echo json_encode($response);
                exit();


          
        }

        else if ($_POST['getFollowing'] == "getFollowing" && filter_var($user_id, FILTER_VALIDATE_INT) == true) {
            $start = microtime(true);
$app_data=$d->selectRow("users_master.user_first_name,users_master.user_last_name,
 users_master.user_id,users_master.user_full_name,users_master.user_profile_pic,business_categories.category_name,business_sub_categories.sub_category_name,user_employment_details.company_name,user_employment_details.designation","users_master,follow_master,user_employment_details,business_categories,business_sub_categories","
  business_categories.category_status = 0 and  
business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id AND follow_master.follow_to=users_master.user_id   AND users_master.office_member=0 AND users_master.active_status=0 AND follow_master.follow_by='$user_id'","ORDER BY users_master.user_full_name ASC");

                if(mysqli_num_rows($app_data)>0){

 $dataArray = array();
                $counter = 0 ;
                foreach ($app_data as  $value) {
                    foreach ($value as $key => $valueNew) {
                        $dataArray[$counter][$key] = $valueNew;
                    }
                    $counter++;
                }
                $user_id_array = array('0');
                $follow_to_array = array('0');
                for ($l=0; $l < count($dataArray) ; $l++) {
                    $user_id_array[] = $dataArray[$l]['user_id'];
                    //$follow_to_array[] = $dataArray[$l]['follow_to'];
                }
                $user_id_array = implode(",", $user_id_array);
                 $follow_to_array = implode(",", $follow_to_array);
                  
                $users_master_fo = $d->selectRow("follow_by,follow_to","follow_master", " follow_by ='$user_id' and follow_to in ($user_id_array)    ");
                $user_arr = array();
                while($users_master_fo_d=mysqli_fetch_array($users_master_fo)) {
                    $user_arr[$users_master_fo_d['follow_by'].'_'.$users_master_fo_d['follow_to']] = $users_master_fo_d['follow_by'];
                }


                    $response["following"] = array();

 for ($l=0; $l < count($dataArray) ; $l++) {
  $data_app = $dataArray[$l];
                    
                        //$qche=$d->select("follow_master","follow_by='$user_id' AND follow_to='$data_app[user_id]'");
$flw2 = $user_arr[$user_id.'_'.$data_app['user_id']];
                        if (!empty($flw2)) { 
                            $follow_status= true;
                        } else {
                            $follow_status= false;
                        }

                      $following=array();
                      $following["user_id"]=$data_app["user_id"];
                      $following["user_full_name"]=$data_app["user_full_name"];
                       $following["short_name"] =strtoupper(substr($data_app["user_first_name"], 0, 1).substr($data_app["user_last_name"], 0, 1) );
                      $following["user_profile_pic"]=$base_url."img/users/members_profile/".$data_app['user_profile_pic'];

                       if($data_app['user_profile_pic'] ==""){
                        $following["user_profile_pic"] ="";
                    } else {
                        $following["user_profile_pic"] = $base_url."img/users/members_profile/".$data_app['user_profile_pic'];

                    }



                      $following["follow_status"]=$follow_status;
                      $following["bussiness_category_name"]=html_entity_decode($data_app["category_name"]);
                      $following["sub_category_name"]=html_entity_decode($data_app["sub_category_name"]).'';
                      $following["company_name"]=html_entity_decode($data_app["company_name"]).'';
                      $following["designation"]=html_entity_decode($data_app["designation"]).'';
                      
                      array_push($response["following"], $following); 
                    }
                  $timp1=true;
                }else{
                    $timp1=false;
                }

                 if ($timp1==true  ) {
                   $end = microtime(true);
 $response["time_taken"]=(string)($end-$start);
                  $response["message"]="Get Success.";
                  $response["status"]="200";
                  echo json_encode($response);
                } else {
                  $response["message"]="No Data Found";
                  $response["status"]="201";
                  echo json_encode($response); 
                }
        }
else if ($_POST['getFollowers'] == "getFollowers" && filter_var($user_id, FILTER_VALIDATE_INT) == true) {

                $start = microtime(true);

               $app_data=$d->selectRow("users_master.user_first_name,users_master.user_last_name,    users_master.user_id,users_master.user_full_name,users_master.user_profile_pic,business_categories.category_name,business_sub_categories.sub_category_name,user_employment_details.company_name,user_employment_details.designation","users_master,follow_master,user_employment_details,business_categories,business_sub_categories","
  business_categories.category_status = 0 and  
business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id AND follow_master.follow_by=users_master.user_id AND users_master.office_member=0 AND users_master.active_status=0   AND follow_master.follow_to='$user_id'","ORDER BY users_master.user_full_name ASC");

                if(mysqli_num_rows($app_data)>0){

//opt start
                  $dataArray = array();
                $counter = 0 ;
                foreach ($app_data as  $value) {
                    foreach ($value as $key => $valueNew) {
                        $dataArray[$counter][$key] = $valueNew;
                    }
                    $counter++;
                }
                $user_id_array = array('0');
                $follow_to_array = array('0');
                for ($l=0; $l < count($dataArray) ; $l++) {
                    $user_id_array[] = $dataArray[$l]['user_id'];
                    //$follow_to_array[] = $dataArray[$l]['follow_to'];
                }


                $user_id_array = implode(",", $user_id_array);
                 $follow_to_array = implode(",", $follow_to_array);
                  
                $users_master_fo = $d->selectRow("follow_by,follow_to","follow_master", " follow_by ='$user_id' and follow_to in ($user_id_array)     ");
                $user_arr = array();
                while($users_master_fo_d=mysqli_fetch_array($users_master_fo)) {
                    $user_arr[$users_master_fo_d['follow_by'].'_'.$users_master_fo_d['follow_to']] = $users_master_fo_d['follow_by'];
                }

                 
//opt end
                    $response["followers"] = array();

 for ($l=0; $l < count($dataArray) ; $l++) {
  $data_app=$dataArray[$l];
                   // while($data_app=mysqli_fetch_array($app_data)) {
                     

                        //$qche=$d->select("follow_master","follow_by='$user_id' AND follow_to='$data_app[user_id]'");
                        $flw = $user_arr[$user_id.'_'.$data_app['user_id']];
                        if (!empty($flw)) {
                            $follow_status= true;
                        } else {
                            $follow_status= false;
                        }

                      $followers=array();

                      $followers["short_name"] =strtoupper(substr($data_app["user_first_name"], 0, 1).substr($data_app["user_last_name"], 0, 1) );

                      
                      $followers["user_id"]=$data_app["user_id"];
                      $followers["user_full_name"]=$data_app["user_full_name"];
                      $followers["user_profile_pic"]=$base_url."img/users/members_profile/".$data_app['user_profile_pic'];

                       if($data_app['user_profile_pic'] ==""){
                        $followers["user_profile_pic"] ="";
                    } else {
                        $followers["user_profile_pic"] =$base_url."img/users/members_profile/".$data_app['user_profile_pic'];

                    }


                      $followers["follow_status"]=$follow_status;
                      $followers["bussiness_category_name"]=html_entity_decode($data_app["category_name"]);
                      $followers["sub_category_name"]=html_entity_decode($data_app["sub_category_name"]).'';
                      $followers["company_name"]=html_entity_decode($data_app["company_name"]).'';
                      $followers["designation"]=html_entity_decode($data_app["designation"]).'';
                      array_push($response["followers"], $followers); 
                    }
                  $temp=true;
                }else{
                    $temp=false;
                } 

                

                if ($temp==true  ) {
                   $end = microtime(true);
 $response["time_taken"]=(string)($end-$start);
                  $response["message"]="Get Success.";
                  $response["status"]="200";
                  echo json_encode($response);
                } else {
                  $response["message"]="No Data Found";
                  $response["status"]="201";
                  echo json_encode($response); 
                }

        
}
        else if ($_POST['getFollowDetails'] == "getFollowDetails" && filter_var($user_id, FILTER_VALIDATE_INT) == true) {
                $start = microtime(true);

               $app_data=$d->selectRow("users_master.user_id,users_master.user_full_name,users_master.user_profile_pic,business_categories.category_name,business_sub_categories.sub_category_name,user_employment_details.company_name,user_employment_details.designation","users_master,follow_master,user_employment_details,business_categories,business_sub_categories","
  business_categories.category_status = 0 and  
business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id AND follow_master.follow_by=users_master.user_id AND follow_master.follow_to='$user_id' AND users_master.office_member=0 AND users_master.active_status=0  ","ORDER BY users_master.user_full_name ASC");

                if(mysqli_num_rows($app_data)>0){

//opt start
                  $dataArray = array();
                $counter = 0 ;
                foreach ($app_data as  $value) {
                    foreach ($value as $key => $valueNew) {
                        $dataArray[$counter][$key] = $valueNew;
                    }
                    $counter++;
                }
                $user_id_array = array('0');
                $follow_to_array = array('0');
                for ($l=0; $l < count($dataArray) ; $l++) {
                    $user_id_array[] = $dataArray[$l]['user_id'];
                    //$follow_to_array[] = $dataArray[$l]['follow_to'];
                }


                $user_id_array = implode(",", $user_id_array);
                 $follow_to_array = implode(",", $follow_to_array);
                  
                $users_master_fo = $d->selectRow("follow_by,follow_to","follow_master", " follow_by ='$user_id' and follow_to in ($user_id_array)      ");
                $user_arr = array();
                while($users_master_fo_d=mysqli_fetch_array($users_master_fo)) {
                    $user_arr[$users_master_fo_d['follow_by'].'_'.$users_master_fo_d['follow_to']] = $users_master_fo_d['follow_by'];
                }

                 
//opt end
                    $response["followers"] = array();

 for ($l=0; $l < count($dataArray) ; $l++) {
  $data_app=$dataArray[$l];
                   // while($data_app=mysqli_fetch_array($app_data)) {
                     

                        //$qche=$d->select("follow_master","follow_by='$user_id' AND follow_to='$data_app[user_id]'");
                        $flw = $user_arr[$user_id.'_'.$data_app['user_id']];
                        if (!empty($flw)) {
                            $follow_status= true;
                        } else {
                            $follow_status= false;
                        }

                      $followers=array();
                      $followers["user_id"]=$data_app["user_id"];
                      $followers["user_full_name"]=$data_app["user_full_name"];
                      $followers["user_profile_pic"]=$base_url."img/users/members_profile/".$data_app['user_profile_pic'];

                      if($data_app['user_profile_pic'] ==""){
                        $followers["user_profile_pic"] ="";
                    } else {
                        $followers["user_profile_pic"] =$base_url."img/users/members_profile/".$data_app['user_profile_pic'];


                    }


                      $followers["follow_status"]=$follow_status;
                      $followers["bussiness_category_name"]=html_entity_decode($data_app["category_name"]);
                      $followers["sub_category_name"]=html_entity_decode($data_app["sub_category_name"]).'';
                      $followers["company_name"]=html_entity_decode($data_app["company_name"]).'';
                      $followers["designation"]=html_entity_decode($data_app["designation"]).'';
                      array_push($response["followers"], $followers); 
                    }
                  $temp=true;
                }else{
                    $temp=false;
                } 

                $app_data=$d->selectRow("users_master.user_id,users_master.user_full_name,users_master.user_profile_pic,business_categories.category_name,business_sub_categories.sub_category_name,user_employment_details.company_name,user_employment_details.designation","users_master,follow_master,user_employment_details,business_categories,business_sub_categories","
  business_categories.category_status = 0 and  
business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id AND follow_master.follow_to=users_master.user_id AND follow_master.follow_by='$user_id' AND users_master.office_member=0 AND users_master.active_status=0    ","ORDER BY users_master.user_full_name ASC");

                if(mysqli_num_rows($app_data)>0){

 $dataArray = array();
                $counter = 0 ;
                foreach ($app_data as  $value) {
                    foreach ($value as $key => $valueNew) {
                        $dataArray[$counter][$key] = $valueNew;
                    }
                    $counter++;
                }
                $user_id_array = array('0');
                $follow_to_array = array('0');
                for ($l=0; $l < count($dataArray) ; $l++) {
                    $user_id_array[] = $dataArray[$l]['user_id'];
                    //$follow_to_array[] = $dataArray[$l]['follow_to'];
                }
                $user_id_array = implode(",", $user_id_array);
                 $follow_to_array = implode(",", $follow_to_array);
                  
                $users_master_fo = $d->selectRow("follow_by,follow_to","follow_master", " follow_by ='$user_id' and follow_to in ($user_id_array)   ");
                $user_arr = array();
                while($users_master_fo_d=mysqli_fetch_array($users_master_fo)) {
                    $user_arr[$users_master_fo_d['follow_by'].'_'.$users_master_fo_d['follow_to']] = $users_master_fo_d['follow_by'];
                }


                    $response["following"] = array();

 for ($l=0; $l < count($dataArray) ; $l++) {
  $data_app = $dataArray[$l];
                    
                        //$qche=$d->select("follow_master","follow_by='$user_id' AND follow_to='$data_app[user_id]'");
$flw2 = $user_arr[$user_id.'_'.$data_app['user_id']];
                        if (!empty($flw2)) { 
                            $follow_status= true;
                        } else {
                            $follow_status= false;
                        }

                      $following=array();
                      $following["user_id"]=$data_app["user_id"];
                      $following["user_full_name"]=$data_app["user_full_name"];
                      $following["user_profile_pic"]=$base_url."img/users/members_profile/".$data_app['user_profile_pic'];

                      if($data_app['user_profile_pic'] ==""){
                        $following["user_profile_pic"] ="";
                    } else {
                        $following["user_profile_pic"] =$base_url."img/users/members_profile/".$data_app['user_profile_pic'];


                    }

                    
                      $following["follow_status"]=$follow_status;
                      $following["bussiness_category_name"]=html_entity_decode($data_app["category_name"]);
                      $following["sub_category_name"]=html_entity_decode($data_app["sub_category_name"]).'';
                      $following["company_name"]=html_entity_decode($data_app["company_name"]).'';
                      $following["designation"]=html_entity_decode($data_app["designation"]).'';
                      
                      array_push($response["following"], $following); 
                    }
                  $timp1=true;
                }else{
                    $timp1=false;
                }

                if ($temp==true || $timp1==true) {
                   $end = microtime(true);
 $response["time_taken"]=(string)($end-$start);
                  $response["message"]="Get Success.";
                  $response["status"]="200";
                  echo json_encode($response);
                } else {
                  $response["message"]="No Data Found";
                  $response["status"]="201";
                  echo json_encode($response); 
                }

        }else {
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
 