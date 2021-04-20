<?php
include_once 'lib.php';
/*ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);*/
if(isset($_POST) && !empty($_POST)){

    if ($key==$keydb) {
        $response = array();
        extract(array_map("test_input" , $_POST));


 $zoobiz_settings_master=$d->selectRow("max_api_notification_line","zoobiz_settings_master","max_api_notification_line > 0 ","");
$zoobiz_settings_master_data=mysqli_fetch_array($zoobiz_settings_master);
$response["max_notification_line"] = $zoobiz_settings_master_data['max_api_notification_line'];



        if($_POST['getMeetupNotification']=="getMeetupNotification" && filter_var($user_id, FILTER_VALIDATE_INT) == true ){

            $m->set_data('read_status', '1');
                $arrayName = array('read_status' => $m->get_data('read_status'));
                $q2 = $d->update("user_notification", $arrayName, "user_id='$user_id'  and notification_type=10  and status='Active'  ");


            $start = microtime(true);
            $app_data_new=$d->selectRow("is_seen,user_id,user_notification_id,user_id,notification_title,notification_desc,other_user_id,notification_logo,notification_date,notification_status,timeline_id,notification_action,notification_type,timeline_id","user_notification"," user_id='$user_id'  AND  notification_type=10  and status='Active'     ","ORDER BY user_notification_id DESC");

            if(mysqli_num_rows($app_data_new)>0){
//code optimize 
                $dataArray = array();
                $counter = 0 ;
                foreach ($app_data_new as  $value) {
                    foreach ($value as $key => $valueNew) {
                        $dataArray[$counter][$key] = $valueNew;
                    }
                    $counter++;
                }
                $user_id_array = array('0');
                 $meeting_id_array = array('0');
                for ($l=0; $l < count($dataArray) ; $l++) {
                    $user_id_array[] = $dataArray[$l]['other_user_id'];
                    $meeting_id_array[] = $dataArray[$l]['timeline_id'];
                }
                $user_id_array = implode(",", $user_id_array);
                $users_master_fo = $d->selectRow("user_profile_pic,user_id","users_master", " user_id in ($user_id_array)");
                $user_arr = array();
                while($users_master_fo_d=mysqli_fetch_array($users_master_fo)) {
                    $user_arr[$users_master_fo_d['user_id']] = $users_master_fo_d['user_profile_pic'];
                }


                 $meeting_id_array = implode(",", $meeting_id_array);
                $meeting_master_qry = $d->selectRow("meeting_id,date","meeting_master", " meeting_id in ($meeting_id_array)");
                $meet_arr = array();
                while($meeting_master_data=mysqli_fetch_array($meeting_master_qry)) {
                    $meet_arr[$meeting_master_data['meeting_id']] = $meeting_master_data['date'];
                }


                $response["notification"] = array();
                for ($l=0; $l < count($dataArray) ; $l++) {
                    $data_app = $dataArray[$l];

                    $notification=array();
                    $notification["user_notification_id"]=$data_app["user_notification_id"];
                    $notification["user_id"]=$data_app["user_id"];
                    $notification["notification_title"]=ucwords($data_app["notification_title"]);
                    $notification["notification_desc"]=$data_app["notification_desc"];
                    if($data_app["other_user_id"] !=0){
                        $other_user_id = $data_app["other_user_id"];

                        if($user_arr[$other_user_id] !="") {
                            $user_profile_pic =$user_arr[$other_user_id];
                            $notification["notification_logo"]=$base_url . "img/users/members_profile/" . $user_profile_pic;

                            if($user_profile_pic ==""){
                        $notification["notification_logo"] ="";
                    } else {
                        $notification["notification_logo"] =$base_url . "img/users/members_profile/" . $user_profile_pic;
                    }


                        } else {
                            $notification["notification_logo"] ="";
                        }
                    }  else {
                        $notification["notification_logo"]=$base_url."img/app_icon/".$data_app["notification_logo"];
                    }

                     $meeting_date =$meet_arr[$data_app["timeline_id"]];
                     if($meeting_date != ""){
                        $notification["meetup_date"]=date("Y-m-d", strtotime($meeting_date));
                    } else {
                        $notification["meetup_date"]="";
                    }
                      
                    if($data_app["is_seen"]==0){
                        $notification["is_seen"]=false;
                    } else {
                        $notification["is_seen"]=true;
                    }
                     


                    $notification["notification_date"]=date("d M Y h:i A", strtotime($data_app['notification_date']));
                    $notification["notification_status"]=$data_app["notification_status"];
                    $notification["notification_type"]=$data_app["notification_type"];
                    $notification["other_user_id"]=$data_app["other_user_id"];
                    $notification["timeline_id"]=$data_app["timeline_id"];
                    $notification["notification_action"]=$data_app["notification_action"];
 
                    if ( $data_app['notification_action']=="custom_notification") {

                        if($data_app["notification_type"]==5){
                            if($data_app["notification_logo"]=="logo.png" || $data_app["notification_logo"]=="ic_business_card.png"){

                                $notification["notification_img_url"] =$base_url.'img/app_icon/ic_business_card.png';
                                $notification["notification_logo"] = $base_url.'img/app_icon/ic_business_card.png' ;
                            }   else{
                                $notification["notification_img_url"] =$base_url.'img/deals/'.$data_app["notification_logo"];
                                $notification["notification_logo"] = $base_url.'img/deals/'.$data_app["notification_logo"];
                            }


                        } else{
                            $notification["notification_img_url"] =$base_url.'img/logo.png';
                            $notification["notification_logo"] = $base_url.'img/logo.png';
                        }

                        $notification["notification_title"] = ucwords($data_app['notification_title']) ;
                        $notification["notification_desc"] = $data_app['notification_desc'];

                    } else {
                        if($data_app['notification_action']=='circulars'){
                            $notification["notification_img_url"] =$base_url.'img/ic_circulars.png';
                        } else if($data_app['notification_action']=='classified'){
                            $notification["notification_img_url"] =$base_url.'img/ic_fourm.png';
                        } else {
                            $notification["notification_img_url"] =$base_url.'img/logo.png';
                        }

                    }
            
                    if($data_app["notification_type"] ==4){
                        $notification["notification_logo"]=$base_url . "img/app_icon/ic_fourm.png";
                        $notification["notification_img_url"] =$base_url.'img/app_icon/ic_fourm.png';
                    }

                    array_push($response["notification"], $notification);
                }
                $m->set_data('read_status', '1');
                $arrayName = array('read_status' => $m->get_data('read_status'));
                $q2 = $d->update("user_notification", $arrayName, "user_id='$user_id' and notification_type=10  and status='Active'   ");

                $end = microtime(true);
                $response["message"]="Meetup Notifications";
                $response["time_taken"]=(string)($end-$start);
                $response["status"]="200";
                echo json_encode($response);
            }else{
                $response["message"]="Faild.";
                $response["status"]="201";
                echo json_encode($response);
            }

        } else if($_POST['getOtherNotification']=="getOtherNotification" && filter_var($user_id, FILTER_VALIDATE_INT) == true ){

            $start = microtime(true);
            
            $app_data_new=$d->selectRow("is_seen,user_id,user_notification_id,user_id,notification_title,notification_desc,other_user_id,notification_logo,notification_date,notification_status,timeline_id,notification_action,notification_type","user_notification"," user_id='$user_id'  AND  notification_type!=10   and status='Active'     ","ORDER BY user_notification_id DESC");

            if(mysqli_num_rows($app_data_new)>0){ 
                $dataArray = array();
                $counter = 0 ;
                foreach ($app_data_new as  $value) {
                    foreach ($value as $key => $valueNew) {
                        $dataArray[$counter][$key] = $valueNew;
                    }
                    $counter++;
                }
                $user_id_array = array('0');
                for ($l=0; $l < count($dataArray) ; $l++) {
                    $user_id_array[] = $dataArray[$l]['other_user_id'];
                }
                $user_id_array = implode(",", $user_id_array);
                $users_master_fo = $d->selectRow("user_profile_pic,user_id","users_master", " user_id in ($user_id_array)");
                $user_arr = array();
                while($users_master_fo_d=mysqli_fetch_array($users_master_fo)) {
                    $user_arr[$users_master_fo_d['user_id']] = $users_master_fo_d['user_profile_pic'];
                } 

                $response["notification"] = array();
                for ($l=0; $l < count($dataArray) ; $l++) {
                    $data_app = $dataArray[$l]; 
                    $notification=array();

                   if($data_app["is_seen"]==0){
                        $notification["is_seen"]=false;
                    } else {
                        $notification["is_seen"]=true;
                    }


                    $notification["user_notification_id"]=$data_app["user_notification_id"];
                    $notification["user_id"]=$data_app["user_id"];
                    $notification["notification_title"]=ucwords($data_app['notification_title']) ;  
                    $notification["notification_desc"]=$data_app["notification_desc"];
                    if($data_app["other_user_id"] !=0){
                        $other_user_id = $data_app["other_user_id"];

                        if($user_arr[$other_user_id] !="") {
                            $user_profile_pic =$user_arr[$other_user_id];
                            $notification["notification_logo"]=$base_url . "img/users/members_profile/" . $user_profile_pic;

                            if($user_profile_pic ==""){
                        $notification["notification_logo"] ="";
                    } else {
                        $notification["notification_logo"] =$base_url . "img/users/members_profile/" . $user_profile_pic;
                    }


                        } else {
                            $notification["notification_logo"] ="";
                        } 
                    }  else {
                        $notification["notification_logo"]=$base_url."img/app_icon/".$data_app["notification_logo"];
                    }

                    $notification["notification_date"]=date("d M Y h:i A", strtotime($data_app['notification_date']));
                    $notification["notification_status"]=$data_app["notification_status"];
                    $notification["notification_type"]=$data_app["notification_type"];
                    $notification["other_user_id"]=$data_app["other_user_id"];
                    $notification["timeline_id"]=$data_app["timeline_id"];
                    $notification["notification_action"]=$data_app["notification_action"]; 
                    if ( $data_app['notification_action']=="custom_notification") {

                        if($data_app["notification_type"]==5){
                            if($data_app["notification_logo"]=="logo.png" || $data_app["notification_logo"]=="ic_business_card.png"){

                                $notification["notification_img_url"] =$base_url.'img/app_icon/ic_business_card.png';
                                $notification["notification_logo"] = $base_url.'img/app_icon/ic_business_card.png' ;
                            }   else{
                                $notification["notification_img_url"] =$base_url.'img/deals/'.$data_app["notification_logo"];
                                $notification["notification_logo"] = $base_url.'img/deals/'.$data_app["notification_logo"];
                            } 
                        }  else if($data_app["notification_type"]==11){
                                $notification["notification_logo"] = $base_url.'img/users/members_profile/'.$data_app["notification_logo"];
                                $notification["notification_img_url"] =$base_url.'img/users/members_profile/'.$data_app["notification_logo"];
                                 
                           
                        } else{
                            $notification["notification_img_url"] =$base_url.'img/logo.png';
                            $notification["notification_logo"] = $base_url.'img/logo.png';
                        } 
                        $notification["notification_title"] =ucwords($data_app['notification_title']) ;  
                        $notification["notification_desc"] = $data_app['notification_desc'];

                    } else {
                        if($data_app['notification_action']=='circulars'){
                            $notification["notification_img_url"] =$base_url.'img/ic_circulars.png';
                        } else if($data_app['notification_action']=='classified'){
                            $notification["notification_img_url"] =$base_url.'img/ic_fourm.png';
                        } else {
                            $notification["notification_img_url"] =$base_url.'img/logo.png';
                        }

                    }

                    if($data_app["notification_type"] ==4){
                        $notification["notification_logo"]=$base_url . "img/app_icon/ic_fourm.png";
                        $notification["notification_img_url"] =$base_url.'img/app_icon/ic_fourm.png';
                    }

                    array_push($response["notification"], $notification);
                }
                $m->set_data('read_status', '1');
                $arrayName = array('read_status' => $m->get_data('read_status'));
                $q2 = $d->update("user_notification", $arrayName, "user_id='$user_id'  and notification_type!=10  and status='Active' ");

                $end = microtime(true);
                $response["message"]="Other Notifications";
                $response["time_taken"]=(string)($end-$start);
                $response["status"]="200";
                echo json_encode($response);
            }else{
                $response["message"]="Faild.";
                $response["status"]="201";
                echo json_encode($response);
            }

        }

        else if($_POST['getNotification']=="getNotification"){
            $start = microtime(true);
            
            $app_data_new=$d->selectRow("is_seen,user_id,user_notification_id,user_id,notification_title,notification_desc,other_user_id,notification_logo,notification_date,notification_status,timeline_id,notification_action,notification_type","user_notification"," user_id='$user_id'  AND (notification_type=0 or notification_type=2  or notification_type=3 or notification_type=4 or notification_type=5 )   and status='Active'    ","ORDER BY user_notification_id DESC");

            if(mysqli_num_rows($app_data_new)>0){
//code optimize

                $dataArray = array();
                $counter = 0 ;
                foreach ($app_data_new as  $value) {
                    foreach ($value as $key => $valueNew) {
                        $dataArray[$counter][$key] = $valueNew;
                    }
                    $counter++;
                }
                $user_id_array = array('0');
                for ($l=0; $l < count($dataArray) ; $l++) {
                    $user_id_array[] = $dataArray[$l]['other_user_id'];
                }
                $user_id_array = implode(",", $user_id_array);
                $users_master_fo = $d->selectRow("user_profile_pic,user_id","users_master", " user_id in ($user_id_array)");
                $user_arr = array();
                while($users_master_fo_d=mysqli_fetch_array($users_master_fo)) {
                    $user_arr[$users_master_fo_d['user_id']] = $users_master_fo_d['user_profile_pic'];
                }

//code optimize
                $response["notification"] = array();
                for ($l=0; $l < count($dataArray) ; $l++) {
                    $data_app = $dataArray[$l];

                    $notification=array();
                    if($data_app["is_seen"]==0){
                        $notification["is_seen"]=false;
                    } else {
                        $notification["is_seen"]=true;
                    }
                    $notification["user_notification_id"]=$data_app["user_notification_id"];
                    $notification["user_id"]=$data_app["user_id"];
                    $notification["notification_title"]= ucwords($data_app['notification_title']) ;  
                    $notification["notification_desc"]=$data_app["notification_desc"];
                    if($data_app["other_user_id"] !=0){
                        $other_user_id = $data_app["other_user_id"];
/*$users_master_fo = $d->select("users_master", " user_id='$other_user_id'");
$users_master_fo_data=mysqli_fetch_array($users_master_fo);*/
if($user_arr[$other_user_id] !="") {
    $user_profile_pic =$user_arr[$other_user_id];
    $notification["notification_logo"]=$base_url . "img/users/members_profile/" . $user_profile_pic;

    if($user_profile_pic ==""){
                        $notification["notification_logo"] ="";
                    } else {
                        $notification["notification_logo"] =$base_url . "img/users/members_profile/" . $user_profile_pic;
                    }


} else {
    $notification["notification_logo"] ="";
}


}  else {
    $notification["notification_logo"]=$base_url."img/app_icon/".$data_app["notification_logo"];
}

$notification["notification_date"]=date("d M Y h:i A", strtotime($data_app['notification_date']));
$notification["notification_status"]=$data_app["notification_status"];
$notification["notification_type"]=$data_app["notification_type"];
$notification["other_user_id"]=$data_app["other_user_id"];
$notification["timeline_id"]=$data_app["timeline_id"];
$notification["notification_action"]=$data_app["notification_action"];
//23oct2020
if ( $data_app['notification_action']=="custom_notification") {

    if($data_app["notification_type"]==5){
        if($data_app["notification_logo"]=="logo.png" || $data_app["notification_logo"]=="ic_business_card.png"){

            $notification["notification_img_url"] =$base_url.'img/app_icon/ic_business_card.png';
            $notification["notification_logo"] = $base_url.'img/app_icon/ic_business_card.png' ;
        }   else{
            $notification["notification_img_url"] =$base_url.'img/deals/'.$data_app["notification_logo"];
            $notification["notification_logo"] = $base_url.'img/deals/'.$data_app["notification_logo"];
        }


    }  else if($data_app["notification_type"]==11){
                                $notification["notification_logo"] = $base_url.'img/users/members_profile/'.$data_app["notification_logo"];
                                $notification["notification_img_url"] =$base_url.'img/users/members_profile/'.$data_app["notification_logo"];
                                 
                           
                        } else{
        $notification["notification_img_url"] =$base_url.'img/logo.png';
        $notification["notification_logo"] = $base_url.'img/logo.png';
    }

    $notification["notification_title"] =ucwords($data_app['notification_title']) ;  
    $notification["notification_desc"] = $data_app['notification_desc'];

} else {
    if($data_app['notification_action']=='circulars'){
        $notification["notification_img_url"] =$base_url.'img/ic_circulars.png';
    } else if($data_app['notification_action']=='classified'){
        $notification["notification_img_url"] =$base_url.'img/ic_fourm.png';
    } else {
        $notification["notification_img_url"] =$base_url.'img/logo.png';
    }

}
            //4nov 2020
if($data_app["notification_type"] ==4){
    $notification["notification_logo"]=$base_url . "img/app_icon/ic_fourm.png";
    $notification["notification_img_url"] =$base_url.'img/app_icon/ic_fourm.png';
}
                        //4nov 2020
                        //23oct2020
array_push($response["notification"], $notification);
}
$m->set_data('read_status', '1');
$arrayName = array('read_status' => $m->get_data('read_status'));
$q2 = $d->update("user_notification", $arrayName, "user_id='$user_id'  and status='Active'  ");

$end = microtime(true);
$response["message"]="Success.";
$response["time_taken"]=(string)($end-$start);
$response["status"]="200";
echo json_encode($response);
}else{
    $response["message"]="Faild.";
    $response["status"]="201";
    echo json_encode($response);
}
}else if($_POST['getNotificationTimeline']=="getNotificationTimeline"){
    $start = microtime(true);

    $app_data_new=$d->selectRow("is_seen,user_id,other_user_id,user_notification_id,user_id,notification_title,notification_desc,notification_date,notification_status,notification_type,other_user_id,timeline_id","user_notification","user_id='$user_id' AND notification_type=1  and status='Active' ","ORDER BY user_notification_id DESC");

    if(mysqli_num_rows($app_data_new)>0){

        $dataArray = array();
        $counter = 0 ;
        foreach ($app_data_new as  $value) {
            foreach ($value as $key => $valueNew) {
                $dataArray[$counter][$key] = $valueNew;
            }
            $counter++;
        }
        $user_id_array = array('0');
        for ($l=0; $l < count($dataArray) ; $l++) {
            $user_id_array[] = $dataArray[$l]['other_user_id'];
        }
        $user_id_array = implode(",", $user_id_array);
        $users_master_fo = $d->selectRow("user_profile_pic,user_id","users_master", " user_id in ($user_id_array)");
        $user_arr = array();
        while($users_master_fo_d=mysqli_fetch_array($users_master_fo)) {
            $user_arr[$users_master_fo_d['user_id']] = $users_master_fo_d['user_profile_pic'];
        }
//code optimize
        $response["notification"] = array();
        for ($l=0; $l < count($dataArray) ; $l++) {
            $data_app = $dataArray[$l];

                /* $qcd=$d->selectRow("user_profile_pic","users_master","user_id='$data_app[other_user_id]'");
                $userData=mysqli_fetch_array($qcd);*/
                $notification=array();
                $notification["user_notification_id"]=$data_app["user_notification_id"];
               if($data_app["is_seen"]==0){
                        $notification["is_seen"]=false;
                    } else {
                        $notification["is_seen"]=true;
                    }
                $notification["user_id"]=$data_app["user_id"];
                $notification["notification_title"]=ucwords($data_app['notification_title']) ;  
                $notification["notification_desc"]=$data_app["notification_desc"];

                if($user_arr[$data_app['other_user_id']] !="") {
                    $user_profile_pic =$user_arr[$data_app['other_user_id']];
                    $notification["notification_logo"]=$base_url."img/users/members_profile/".$user_profile_pic;

                    if($user_profile_pic ==""){
                        $notification["notification_logo"] ="";
                    } else {
                        $notification["notification_logo"] =$base_url . "img/users/members_profile/" . $user_profile_pic;
                    }

                    
                } else {
                    $notification["notification_logo"]="";
                }

                $notification["notification_date"]=time_elapsed_string($data_app['notification_date']);
                $notification["notification_status"]=$data_app["notification_status"];
                $notification["notification_type"]=$data_app["notification_type"];
                $notification["other_user_id"]=$data_app["other_user_id"];
                $notification["timeline_id"]=$data_app["timeline_id"];
                $notification["notification_action"]="";
                array_push($response["notification"], $notification);
            }
            $m->set_data('read_status', '1');
            $arrayName = array('read_status' => $m->get_data('read_status'));
            $q2 = $d->update("user_notification", $arrayName, "user_id='$user_id' and status='Active'  ");
            $end = microtime(true);
            $response["time_taken"]=(string)($end-$start);
            $response["message"]="Success.";
            $response["status"]="200";
            echo json_encode($response);
        }else{
            $response["message"]="Faild, No Data Found";
            $response["status"]="201";
            echo json_encode($response);
        }
    }else if ($_POST['DeleteUserNotification'] == "DeleteUserNotification" && $user_notification_id != '' && filter_var($user_notification_id, FILTER_VALIDATE_INT) == true) {
        $qdelete = $d->delete("user_notification", "user_notification_id='$user_notification_id' AND user_id!=0 and status='Active' ");
        if ($qdelete == TRUE) {

            $response["message"] = "Notification Deleted";
            $response["status"] = "200";
            echo json_encode($response);
        } else {
            $response["message"] = "Fail.";
            $response["status"] = "201";
            echo json_encode($response);
        }
    } else if ($_POST['seenNotification'] == "seenNotification" &&   filter_var($user_notification_id, FILTER_VALIDATE_INT) == true) {
         $m->set_data('is_seen', '1');
            $arrayName = array('is_seen' => $m->get_data('is_seen'));
            $q2 = $d->update("user_notification", $arrayName, "user_notification_id='$user_notification_id' and status='Active'  ");
        if ($q2 == TRUE) {
            //$d->insert_myactivity($user_id,"0","", "All Notification Deleted","activity.png"); 
            $response["message"] = "Seen";
            $response["status"] = "200";
            echo json_encode($response);
        } else {
            $response["message"] = "Fail.";
            $response["status"] = "201";
            echo json_encode($response);
        }
    }  else if ($_POST['DeleteAllMeetupNotification'] == "DeleteAllMeetupNotification" && $user_id != '' && filter_var($user_id, FILTER_VALIDATE_INT) == true ) {
        $qdelete = $d->delete("user_notification", "user_id='$user_id' AND user_id!=0  and notification_type =10 and status='Active' ");
        if ($qdelete == TRUE) {

            $response["message"] = "All Meetup Notification Deleted";
            $response["status"] = "200";
            echo json_encode($response);
        } else {
            $response["message"] = "Fail";
            $response["status"] = "201";
            echo json_encode($response);
        }
    } else if ($_POST['DeleteUserNotificationAll'] == "DeleteUserNotificationAll" && $user_id != '' && filter_var($user_id, FILTER_VALIDATE_INT) == true) {
        $qdelete = $d->delete("user_notification", "user_id='$user_id' AND user_id!=0  and status='Active' ");
        if ($qdelete == TRUE) {
            $d->insert_myactivity($user_id,"0","", "All Notification Deleted","activity.png");
            $response["message"] = "Notifications Deleted";
            $response["status"] = "200";
            echo json_encode($response);
        } else {
            $response["message"] = "Fail";
            $response["status"] = "201";
            echo json_encode($response);
        }
    } else if ($_POST['DeleteUserNotificationAllTimeline'] == "DeleteUserNotificationAllTimeline" && $user_id != '' && filter_var($user_id, FILTER_VALIDATE_INT) == true) {
        $qdelete = $d->delete("user_notification", "user_id='$user_id' AND user_id!=0 and status='Active'  ");
        if ($qdelete == TRUE) {
            $d->insert_myactivity($user_id,"0","", "All Timeline Notification Deleted","activity.png");
            $response["message"] = "Notifications Deleted";
            $response["status"] = "200";
            echo json_encode($response);
        } else {
            $response["message"] = "Fail";
            $response["status"] = "201";
            echo json_encode($response);
        }
    }else {
        $response["message"]="wrong tag.";
        $response["status"]="201";
        echo json_encode($response);
    }
}else{
    $response["message"]="wrong api key.";
    $response["status"]="201";
    echo json_encode($response);
}
}
?>