<?php
include_once 'lib.php';

if(isset($_POST) && !empty($_POST)){

    $response = array();
    extract(array_map("test_input" , $_POST));

    
    if ($key==$keydb) {


        if (isset($getMemberList) && $getMemberList=='getMemberList' && filter_var($user_id, FILTER_VALIDATE_INT) == true) { 

           $q3=$d->selectRow("users_master.user_id,users_master.user_full_name,users_master.user_first_name,users_master.user_last_name,users_master.gender,user_employment_details.company_name,users_master.user_mobile,users_master.public_mobile,users_master.member_date_of_birth,users_master.alt_mobile,users_master.user_profile_pic","users_master,user_employment_details,business_categories","
               business_categories.category_status = 0 and business_categories.business_category_id = user_employment_details.business_category_id and   user_employment_details.user_id=users_master.user_id AND users_master.user_id!='$user_id' AND users_master.office_member=0 AND users_master.active_status=0 
 ","ORDER BY users_master.user_first_name ASC");

         //code optimize

           $dataArray = array();
           $counter = 0 ;
           foreach ($q3 as  $value) {
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

        $cq_qry=$d->selectRow("block_by,block_for","chat_block_master"," (block_for='$user_id' AND block_by in ($user_id_array) ) OR  (block_by='$user_id' AND block_for in ($user_id_array) ) ");

        $BArray = array();
        $Bcounter = 0 ;
        foreach ($cq_qry as  $value) {
            foreach ($value as $key => $valueNew) {
                $BArray[$Bcounter][$key] = $valueNew;
            }
            $Bcounter++;
        }
        $block_chat_arr = array('0');
        for ($l=0; $l < count($BArray) ; $l++) {
            $block_chat_arr[] = $BArray[$l]['block_by'];
            $block_chat_arr[] = $BArray[$l]['block_for'];
        }



        $qch11_qry=$d->selectRow("block_by","user_block_master","user_id='$user_id' AND block_by in ($user_id_array) ");
        $CArray = array();
        $Ccounter = 0 ;
        foreach ($qch11_qry as  $value) {
            foreach ($value as $key => $valueNew) {
                $CArray[$Ccounter][$key] = $valueNew;
            }
            $Ccounter++;
        }
        $block_u_arr = array('0');
        for ($l=0; $l < count($CArray) ; $l++) {
            $block_u_arr[] = $CArray[$l]['block_by']; 
        }
//code optimize

        if (count($dataArray)>0) {
            $response["member"]=array();
            for ($l=0; $l < count($dataArray) ; $l++) {
                $data=$dataArray[$l];
                $member = array(); 
                $member["user_id"]=$data['user_id'];
                $member["user_full_name"]=$data['user_full_name'];
                $member["user_first_name"]=$data['user_first_name'];
                $member["user_last_name"]=$data['user_last_name'];
                $member["gender"]=$data['gender'];
                $member["company_name"]=html_entity_decode($data['company_name']);
                $member["user_mobile"]=$data['user_mobile'];
                $member["public_mobile"]=$data['public_mobile'];
                $member["member_date_of_birth"]="".$data['member_date_of_birth'];
                $member["alt_mobile"] = $data['alt_mobile'];

                if($data['user_profile_pic']==""){
                    $member["user_profile_pic"]="";
                } else {
                    $member["user_profile_pic"]=$base_url."img/users/members_profile/".$data['user_profile_pic'];
                }
                
                
                if (  in_array($data[user_id], $block_u_arr)  || in_array($data[user_id], $block_chat_arr) ) {
                    $member["block_status"] = true;
                } else {
                    $member["block_status"] = false;
                }


                array_push($response["member"], $member); 
            }

            $response["message"]="Member List";
            $response["status"]="200";

            echo json_encode($response);

        }else{
            $response["message"]="No Member Found!";
            $response["status"]="201";
            echo json_encode($response);
        }


    }  else if (isset($getRecentChatMember) && $getRecentChatMember=='getRecentChatMember' && filter_var($user_id, FILTER_VALIDATE_INT) == true) { 



        $q4=$d->getRecentChatMemberNew("chat_master",$user_id);
        
        $dataArray = array();
        $counter = 0 ;
        foreach ($q4 as  $value) {
            foreach ($value as $key => $valueNew) {
                $dataArray[$counter][$key] = $valueNew;
            }
            $counter++;
        }
        $msg_for_array = array('0');
        for ($l=0; $l < count($dataArray) ; $l++) {
            $msg_for_array[] = $dataArray[$l]['msg_by'];
            $msg_for_array[] = $dataArray[$l]['msg_for'];
            
        }
        $msg_for_array = implode(",", $msg_for_array);


        $user_employment_details = $d->selectRow("company_name,designation,user_id","user_employment_details", "user_id in ($msg_for_array )  ", "");



        $dataArray3 = array();
        $counter4 = 0 ;
        foreach ($user_employment_details as  $value) {
            foreach ($value as $key => $valueNew) {
                $dataArray3[$counter4][$key] = $valueNew;
            }
            $counter4++;
        }
        $user_emp_arr = array('0');
        for ($l=0; $l < count($dataArray3) ; $l++) {
            $user_emp_arr[$dataArray3[$l]['user_id']] = $dataArray3[$l];
        }

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

// echo "<pre>";print_r($user_favorite_master_array_user);exit;


 
        //recent memmber data start
        $user_recent_master_qry = $d->selectRow("users_master.user_first_name , users_master.user_last_name, users_master.public_mobile,users_master.user_id,business_categories.business_category_id,business_sub_categories.business_sub_category_id,users_master.user_full_name,users_master.zoobiz_id,users_master.public_mobile,users_master.user_mobile,users_master.user_profile_pic,business_categories.category_name,business_sub_categories.sub_category_name,user_employment_details.company_name, user_employment_details.company_logo   ,user_recent_master.id,user_recent_master.member_id,user_recent_master.user_id,user_recent_master.flag,user_employment_details.company_name,user_employment_details.company_logo, users_master.user_full_name, users_master.user_profile_pic","user_recent_master,users_master,user_employment_details, business_categories,business_sub_categories",
            "user_employment_details.user_id=user_recent_master.member_id and  business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND  users_master.user_id =user_recent_master.member_id and   user_recent_master.user_id ='$user_id' and   user_recent_master.member_id != $user_id and user_recent_master.member_id not in($msg_for_array) AND users_master.office_member=0 AND users_master.active_status=0 
  ", " GROUP by user_recent_master.user_id, user_recent_master.member_id, user_recent_master.flag      order by user_recent_master.id desc limit 0,4 ");




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
$recentMember["short_name"] =strtoupper(substr($user_recent_master_data["user_first_name"], 0, 1).substr($user_recent_master_data["user_last_name"], 0, 1) );
                    if($user_recent_master_data['public_mobile'] =="0"){
                        $recentMember["mobile_privacy"]=true;
                    } else {
                        $recentMember["mobile_privacy"]=false;
                    }
                    if ($user_recent_master_data["public_mobile"] == 0) {
                            $recentMember["user_mobile"] = "" . substr($user_recent_master_data['user_mobile'], 0, 3) . '****' . substr($user_recent_master_data['user_mobile'], -3);
                        } else {
                            $recentMember["user_mobile"] = $user_recent_master_data["user_mobile"];
                        }

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




    if (count($dataArray)>0) {
        $response["chatMemberList"]=array();

        for ($l=0; $l < count($dataArray) ; $l++) {
            $data1= $dataArray[$l];
            if ($data1['msg_for']==$user_id) {
                $recentUser= $data1['msg_by'];

            }else if ($data1['msg_by']==$user_id) {
                $recentUser= $data1['msg_for'];
            }
            if ($recentUser!='') {
              $member = array(); 
              $member["chat_id"]=$data1['chat_id'];
              $member["msg_type"]=$data1['msg_type'];

              if ($data1['msg_type']=='1') {
                $member["msg_data"]="📸 Image";
            }else if ($data1['msg_type']=='2') {
                $member["msg_data"]="📃 Document";
            }else if ($data1['msg_type']=='3') {
             $member["msg_data"]="🎧 Audio";
         }else if ($data1['msg_type']=='4') {
             $member["msg_data"]="📌 Location";
         }else if ($data1['msg_type']=='5') {
             $member["msg_data"]="👤 Contact";
         }else if ($data1['msg_type']=='6') {
            $member["msg_data"]="🎞️ Video";
        }else {
           $member["msg_data"]=$data1['msg_data'];
       }

       if(strtotime($data1['msg_date']) < strtotime('-2 days')) {
         $member["msg_date"] = date("d/m/Y", strtotime($data1['msg_date']));
     } else if(strtotime($data1['msg_date']) < strtotime('-1 days')) {
         $member["msg_date"] = "Yesterday";
     } else {
                             //$member["msg_date"] = time_elapsed_string($data1['msg_date']);
        $member["msg_date"] =date("h:i a", strtotime($data1['msg_date']));
    }



    $member["user_id"]=$recentUser;
    $arr_new = $user_emp_arr[$recentUser];

    $member["company_name"]=$arr_new['company_name'];
    $member["designation"]=$arr_new['designation'];


    if(in_array($recentUser, $user_favorite_master_array_user)){
        $member["is_fevorite"] = "1";
    }else {
        $member["is_fevorite"] = "0";
    }

 if($data1['public_mobile'] =="0"){
                        $member["mobile_privacy"]=true;
                    } else {
                        $member["mobile_privacy"]=false;
                    }
                    if ($data1["public_mobile"] == 0) {
                            $member["user_mobile"] = "" . substr($data1['user_mobile'], 0, 3) . '****' . substr($data1['user_mobile'], -3);
                        } else {
                            $member["user_mobile"] = $data1["user_mobile"];
                        }

    $member["user_full_name"]=$data1['user_full_name'];
$member["short_name"] =strtoupper(substr($data1["user_first_name"], 0, 1).substr($data1["user_last_name"], 0, 1) );
    if($data1['user_profile_pic'] !=""){
        $member["user_profile_pic"]=$base_url."img/users/members_profile/".$data1['user_profile_pic'];

    } else {
        $member["user_profile_pic"]="";
    }
    
    $chatCount=$d->count_data_direct("chat_id","chat_master","msg_for='$user_id' AND msg_by='$recentUser' AND msg_status='0'");



    $member["chatCount"] = $chatCount.'';

    array_push($response["chatMemberList"], $member); 
}
}

$response["message"]="Member List";
$response["status"]="200";
echo json_encode($response);
} else {
  $response["message"]="No Recent Chat Found";
  $response["status"]="201";
  echo json_encode($response);
}





} else if ($_POST['getPrvChatNew'] == "getPrvChatNew"  && filter_var($user_id, FILTER_VALIDATE_INT) == true && filter_var($userId, FILTER_VALIDATE_INT) == true) {



    $qnotification = $d->selectRow("chat_id,chat_id_reply,msg_by,msg_for,msg_data,msg_type,msg_img,file_original_name,location_lat_long,file_size,file_duration,msg_status,msg_delete,msg_date","chat_master", "((msg_by='$user_id' AND msg_for='$userId') OR (msg_by='$userId' AND msg_for='$user_id')) AND send_by='0' AND sent_to='0'", "ORDER BY chat_id ASC limit 1500");
 
    //code optimize

                $dataArray = array();
                $counter = 0 ;
                foreach ($qnotification as  $value) {
                    foreach ($value as $key => $valueNew) {
                        $dataArray[$counter][$key] = $valueNew;
                    }
                    $counter++;
                }
                $chat_id_reply_array = array('0');
                for ($l=0; $l < count($dataArray) ; $l++) {
                    if($dataArray[$l]['chat_id_reply']!="0")
                    $chat_id_reply_array[] = $dataArray[$l]['chat_id_reply'];
                }
                $chat_id_reply_array = implode(",", $chat_id_reply_array);
                $qs_qry=$d->selectRow("msg_data,msg_img,msg_type,chat_id","chat_master","chat_id in ($chat_id_reply_array)  ");
 
                $CArray = array();
                $Ccounter = 0 ;
                foreach ($qs_qry as  $value) {
                    foreach ($value as $key => $valueNew) {
                        $CArray[$Ccounter][$key] = $valueNew;
                    }
                    $Ccounter++;
                }
                $cht_array = array();
                for ($l=0; $l < count($CArray) ; $l++) {
                    $cht_array[$CArray[$l]['chat_id']] = $CArray[$l];
                }
 //echo "<pre>";print_r($cht_array);exit;
//code optimize

    $cq = $d->selectRow("block_for","chat_block_master", "block_for='$user_id' AND block_by='$userId'");

    $cq11 = $d->selectRow("block_for","chat_block_master", "block_for='$userId' AND block_by='$user_id'");


    $qch11=$d->selectRow("user_id","user_block_master","user_id='$userId' AND block_by='$user_id' ");
    $qch22=$d->selectRow("user_id","user_block_master","user_id='$user_id' AND block_by='$userId' ");



    if (count($dataArray) > 0) {
        $response["chat"] = array();

        $tempPrvDate = "";
 for ($l=0; $l < count($dataArray) ; $l++) {
    $data_notification =$dataArray[$l];
         
            $chat = array();
            $chat["chat_id"] = $data_notification['chat_id'];
            $chat["chat_id_reply"] = $data_notification['chat_id_reply'];
            if ($data_notification['chat_id_reply']!=0) {
                // $qs=$d->selectRow("msg_data,msg_img,msg_type","chat_master","chat_id='$data_notification[chat_id_reply]'");

                $replyData=$cht_array[$data_notification[chat_id_reply]]; //mysqli_fetch_array($qs);
                $chat["reply_msg"] = $replyData['msg_data'];
                if($replyData['msg_img']!=''){
                    $chat["reply_msg_img"] = $base_url."img/chatImg/".$replyData['msg_img'];
                } else {
                    $chat["reply_msg_img"] = "";
                }
                
                $chat["reply_msg_type"] = $replyData['msg_type'].'';
            } else {
                $chat["reply_msg"] = "";
                $chat["reply_msg_img"]="";
                $chat["reply_msg_type"]="";
            }
            $chat_id = $data_notification['chat_id'];
            $chat["msg_by"] = $data_notification['msg_by'];
            $chat["msg_for"] = $data_notification['msg_for'];
            $chat["msg_data"] = html_entity_decode($data_notification['msg_data']);
            $chat["msg_type"] = $data_notification['msg_type'];
            if ($data_notification['msg_img']!='') {
                $chat["msg_img"] = $base_url."img/chatImg/".$data_notification['msg_img'];
            } else {
                $chat["msg_img"] = "";
            }
            $chat["file_original_name"] = $data_notification['file_original_name'].'';
            $chat["location_lat_long"] = $data_notification['location_lat_long'].'';
            $chat["file_size"] = $data_notification['file_size'].'';
            $chat["file_duration"] = $data_notification['file_duration'].'';
            $chat["msg_status"] = $data_notification['msg_status'];
            $chat["msg_delete"] = $data_notification['msg_delete'];
            $chat["msg_date"] = date("h:i A", strtotime($data_notification['msg_date']));
            $chatDate = date("d M Y", strtotime($data_notification['msg_date']));
            $chat["isDate"] = false;
            $chat["msg_date_view"] = $chatDate;

            if ($data_notification['msg_by'] == $user_id) {

                $chat["my_msg"] = '1';
            } else {
                $chat["my_msg"] = '0';

                $m->set_data('msg_status', '1');

                $a1 = array(
                    'msg_status' => $m->get_data('msg_status')
                );

                $d->update('chat_master', $a1, "chat_id='$chat_id'");
            }
            if($tempPrvDate!=""){

                if($tempPrvDate != $chatDate){
                    $tempPrvDate = $chatDate;
                    $chatD = array();
                    $chatD["msg_date"] = $tempPrvDate;
                    $chatD["isDate"] = true;
                    $chatD["msg_date_view"] = $chatDate;

                    array_push($response["chat"], $chatD);
                }

            }else{
                $tempPrvDate = $chatDate;
                $chatD = array();
                $chatD["msg_date"] = $tempPrvDate;
                $chatD["isDate"] = true;
                $chatD["msg_date_view"] = $chatDate;
                array_push($response["chat"], $chatD);
            }
            array_push($response["chat"], $chat);
        }

        if (mysqli_num_rows($cq) > 0 || mysqli_num_rows($cq11) > 0) {
            if (mysqli_num_rows($cq) > 0) {
                        // blocked by other user
                $response["block_status"] = "1";
            } else if (mysqli_num_rows($cq11) > 0) {
                        // blocked by me
                $response["block_status"] = "2";
            }
        } else if (mysqli_num_rows($qch11) > 0) {
            $response["block_status"] = "2";
        }else if (mysqli_num_rows($qch22) > 0) {
            $response["block_status"] = "1";
        }  else {
                    //No Bloked
            $response["block_status"] = "0";
        }

        if ($isRead==1) {
            $qsm = $d->select("users_master", "user_id='$userId'  AND office_member=0 AND active_status=0  ");
            $data_notification = mysqli_fetch_array($qsm);
            $sos_user_token = $data_notification['user_token'];
            $device = $data_notification['device'];
            if (strtolower($device) == 'android') {
                $nResident->noti("chatMsg","", 0, $sos_user_token, "", "", 'chatMsg');
            } else if (strtolower($device) == 'ios') {
                $nResident->noti_ios("chatMsg","", 0, $sos_user_token, "", "", 'chatMsg');
            }
        }

        $response["message"] = "Get Chat.";

        $response["status"] = "200";
        echo json_encode($response);
    } else {
        if (mysqli_num_rows($cq) > 0 || mysqli_num_rows($cq11) > 0) {
            if (mysqli_num_rows($cq) > 0) {
                        // blocked by other user
                $response["block_status"] = "1";
            } else if (mysqli_num_rows($cq11) > 0) {
                        // blocked by me
                $response["block_status"] = "2";
            }
        } else if (mysqli_num_rows($qch11) > 0) {
            $response["block_status"] = "1";
        } else {
                    //No Bloked
            $response["block_status"] = "0";
        }

        $response["message"] = "No Chat Found.";

        $response["status"] = "201";
        echo json_encode($response);
        exit;
    }
} else if ($_POST['addChat'] == "addChat" && filter_var($msg_by, FILTER_VALIDATE_INT) == true) {
 
    if ($msg_data == '') {
        $response["message"] = "Enter message";
        $response["status"] = "201";
        echo json_encode($response);
        exit();
    }
    $msg_data = html_entity_decode($msg_data);

    $m->set_data('chat_id_reply', $chat_id_reply);
    $m->set_data('msg_by', $msg_by);
    $m->set_data('msg_for', $msg_for);
    $m->set_data('msg_data', $msg_data);
    $m->set_data('msg_status', '0');
    $m->set_data('send_by', '0');
    $m->set_data('sent_to', '0');
    $m->set_data('msg_type', $msgType);
    $m->set_data('msg_date', date("Y-m-d H:i:s"));
    $m->set_data('location_lat_long', $location_lat_long);

    $a1 = array(
        'chat_id_reply' => $m->get_data('chat_id_reply'),
        'msg_by' => $m->get_data('msg_by'),
        'msg_for' => $m->get_data('msg_for'),
        'msg_data' => $m->get_data('msg_data'),
        'msg_type' => $m->get_data('msg_type'),
        'location_lat_long' => $m->get_data('location_lat_long'),
        'msg_status' => $m->get_data('msg_status'),
        'send_by' => $m->get_data('send_by'),
        'sent_to' => $m->get_data('sent_to'),
        'msg_date' => $m->get_data('msg_date')
    );

    $q = $d->insert('chat_master', $a1);


    if ($q == true) {

       if ($msgType=='1') {
        $notiDescription="📸 Image";
      $notiDescription2=$notiDescription;
    }else if ($msgType=='2') {
     $notiDescription="📃 Document";
      $notiDescription2=$notiDescription;
 }else if ($msgType=='3') {
     $notiDescription="🎧 Audio";
      $notiDescription2=$notiDescription;
 }else if ($msgType=='4') {
     $notiDescription="📌 Location";
      $notiDescription2=$notiDescription;
 }else if ($msgType=='5') {
     $notiDescription="👤 Contact";
      $notiDescription2=$notiDescription;
 }else if ($msgType=='6') {
     $notiDescription="🎞️ Video";
      $notiDescription2=$notiDescription;
 }else {

    $notiDescription =  $msg_data;
    $notiDescription2 =  $msg_data;

     $notiDescription2 = substr($notiDescription2, 0, 150).'...';
}
if(trim($msg_data) !=''){
       $notiDescription2=$msg_data;
 }

 

 if(!isset($short_name)){
    $short_name="";
}

$notAry = array(
    'userType' => "0",
    'userId' => $m->get_data('msg_by'),
    'userProfile' => $user_profile,
    'userName' => $user_name,
    'short_name' => $short_name,
    'from' => "1",
    'sentTo' => "0",
    'memberMobile' => $user_mobile,
    'publicMobile' => $public_mobile,
);



$users_master_by = $d->select("users_master", "user_id='$msg_by'   AND active_status=0  ");
$users_master_by_data = mysqli_fetch_array($users_master_by);
if($users_master_by_data['user_profile_pic']!=""){

    $profile_u = $base_url . "img/users/members_profile/" . $users_master_by_data['user_profile_pic'];
  } else {
    $profile_u ="https://zoobiz.in/zooAdmin/img/user.png";
  }





$qUserToken = $d->select("users_master", "user_id='$msg_for' AND office_member=0 AND active_status=0  ");
$data_notification = mysqli_fetch_array($qUserToken);
$sos_user_token = $data_notification['user_token'];
$device = $data_notification['device'];


if($data_notification['chat_alerts'] =="true"){
        if (strtolower($device) == 'android') {
        $nResident->noti("chatMsg","", 0, $sos_user_token, "$user_name 💬",  $notiDescription2, $notAry,1,$profile_u);
    } else if (strtolower($device) == 'ios') {
        $nResident->noti_ios("chatMsg","", 0, $sos_user_token, "$user_name 💬",  $notiDescription2, $notAry,1,$profile_u);
    }
}



$response["message"] = "Message Sent";
$response["status"] = "200";
echo json_encode($response);
} else {

    $response["message"] = "Fail to add chat.";
    $response["status"] = "201";
    echo json_encode($response);
}
}else if ($_POST['addChatWithDoc'] == "addChatWithDoc" && filter_var($msg_by, FILTER_VALIDATE_INT) == true) {
$photo_name ="";
$is_profile = 1; 
    $total = count($_FILES['chat_doc']['tmp_name']);


    $message_data = '';
    for ($i = 0; $i < $total; $i++) {
      $uploadedFile = $_FILES['chat_doc']['name'][$i];
      if ($uploadedFile != "") {
        $temp = explode(".", $uploadedFile);
        $feed_img = "Chat_" . round(microtime(true)) .$i.'.' . end($temp);
        move_uploaded_file($_FILES['chat_doc']['tmp_name'][$i], "../img/chatImg/" . $feed_img);
        $file_original_name = $uploadedFile;


$extcc = pathinfo($_FILES['chat_doc']['name'][$i], PATHINFO_EXTENSION);
$extensionResume=array("png","jpg","jpeg","PNG","JPG","JPEG");
 
 
if($i == 0 && in_array($extcc, $extensionResume)  ){
     $photo_name = $base_url . "img/chatImg/" . $feed_img; 
$is_profile = 0;
}
       


        $bytesSize = $_FILES['chat_doc']['size'][$i];
        $file_size= $d->formatSizeUnits($bytesSize);
        $m->set_data('chat_id_reply', $chat_id_reply);
        $m->set_data('msg_by', $msg_by);
        $m->set_data('msg_for', $msg_for);
        $m->set_data('msg_data', $_POST['msg_data'][$i]);

        if(trim($message_data) ==''){
             $message_data = $_POST['msg_data'][$i];
        }
        $m->set_data('msg_status', '0');
        $m->set_data('send_by', '0');
        $m->set_data('sent_to', $sent_to);
        $m->set_data('msg_date', date("Y-m-d H:i:s"));
        $m->set_data('msg_type', $msgType);
        $m->set_data('msg_img', $feed_img);
        $m->set_data('file_original_name', $file_original_name);
        $m->set_data('location_lat_long', $location_lat_long);
        $m->set_data('file_size', $file_size);
        $m->set_data('file_duration', $file_duration);

        $a1 = array(
            'chat_id_reply' => $m->get_data('chat_id_reply'),
            'msg_by' => $m->get_data('msg_by'),
            'msg_for' => $m->get_data('msg_for'),
            'msg_data' => $m->get_data('msg_data'),
            'msg_type' => $m->get_data('msg_type'),
            'msg_img' => $m->get_data('msg_img'),
            'file_original_name' => $m->get_data('file_original_name'),
            'location_lat_long' => $m->get_data('location_lat_long'),
            'file_size' => $m->get_data('file_size'),
            'file_duration' => $m->get_data('file_duration'),
            'msg_status' => $m->get_data('msg_status'),
            'send_by' => $m->get_data('send_by'),
            'sent_to' => $m->get_data('sent_to'),
            'msg_date' => $m->get_data('msg_date')
        );

        $q = $d->insert('chat_master', $a1);

    }
}


$users_master_by = $d->select("users_master", "user_id='$msg_by'   AND active_status=0  ");
$users_master_by_data = mysqli_fetch_array($users_master_by);
if($users_master_by_data['user_profile_pic']!=""){

    $profile_u = $base_url . "img/users/members_profile/" . $users_master_by_data['user_profile_pic'];
  } else {
    $profile_u ="https://zoobiz.in/zooAdmin/img/user.png";
  }
 

if ($msgType=='1') {
    $notiDescription="📸 Image";
    if(trim($message_data) !=''){
       $notiDescription="📸 ".$message_data;
    }
}else if ($msgType=='2') {
 $notiDescription="📃 Document";
 if(trim($message_data) !=''){
       $notiDescription="📃 ".$message_data;
    }
}else if ($msgType=='3') {
 $notiDescription="🎧 Audio";
  if(trim($message_data) !=''){
       $notiDescription="🎧 ".$message_data;
    }
}else if ($msgType=='4') {
 $notiDescription="📌 Location";
  if(trim($message_data) !=''){
       $notiDescription="📌 ".$message_data;
    }
}else if ($msgType=='5') {
 $notiDescription="👤 Contact";
 if(trim($message_data) !=''){
       $notiDescription="👤 ".$message_data;
    }
}else if ($msgType=='6') {
 $notiDescription="🎞️ Video";
 if(trim($message_data) !=''){
       $notiDescription="🎞️ ".$message_data;
    }
}else {
    $notiDescription = "📃 Document";
    if(trim($message_data) !=''){
       $notiDescription="📃 ".$message_data;
    }
}


 


 if(!isset($short_name)){
    $short_name="";
}


$notAry = array(
    'userType' => "Resident",
    'userId' => $m->get_data('msg_by'),
    'userProfile' => $user_profile,
    'userName' => $user_name,
    'short_name' => $short_name,
    'from' => "1",
    'sentTo' => "0",
    'recidentMobile' => $user_mobile,
    'publicMobile' => $public_mobile,
);

$qUserToken = $d->select("users_master", "user_id='$msg_for' AND office_member=0 AND active_status=0 ");
$data_notification = mysqli_fetch_array($qUserToken);
$sos_user_token = $data_notification['user_token'];
$device = $data_notification['device'];
/*if(isset($debug))
echo $photo_name;exit;*/

 if($data_notification['chat_alerts'] =="true"){
        if (strtolower($device) == 'android') {
            $nResident->noti("chatMsg",$photo_name, 0, $sos_user_token, "$user_name 💬", $notiDescription, $notAry,$is_profile,$profile_u);
        } else if (strtolower($device) == 'ios') {
            $nResident->noti_ios("chatMsg",$photo_name, 0, $sos_user_token, "$user_name 💬", $notiDescription, $notAry,$is_profile,$profile_u);
        }
}
$response["message"] = "Message Sent";
$response["status"] = "200";
echo json_encode($response);

}  else if ($_POST['chatBlock'] == "chatBlock" && filter_var($block_by, FILTER_VALIDATE_INT) == true && filter_var($block_for, FILTER_VALIDATE_INT) == true) {


   $block1 = $d->select("chat_block_master,users_master", " users_master.user_id = chat_block_master.block_by and  chat_block_master.block_by='$block_for' AND chat_block_master.block_for='$block_by'");

    if (mysqli_num_rows($block1) > 0) {
        $block1_data = mysqli_fetch_array($block1);

        $response["message"] = "Blocked";//$block1_data['user_full_name']." Blocked You.";
        $response["status"] = "201";
        echo json_encode($response);
        exit();
    }


    $q1 = $d->select("chat_block_master", "block_by='$block_by' AND block_for='$block_for'");

    if (mysqli_num_rows($q1) > 0) {

        $response["message"] = "User Already Blocked.";
        $response["status"] = "201";
        echo json_encode($response);
        exit();
    }
    $m->set_data('block_by', $block_by);
    $m->set_data('block_for', $block_for);

    $a1 = array(
        'block_by' => $m->get_data('block_by'),
        'block_for' => $m->get_data('block_for')
    );

    $q = $d->insert('chat_block_master', $a1);


    if ($q == true) {

//block member if chat blocked start
           /* $m->set_data('user_id', $block_for);
            $m->set_data('my_id', $block_by);
            $a2 = array('user_id' => $m->get_data('user_id'),
                'block_by' => $m->get_data('my_id'),
            );
            $q5 = $d->insert("user_block_master", $a2);   */  
//block member if chat blocked end



      $users_master_q=$d->select("users_master","user_mobile='$block_for' AND office_member=0 AND active_status=0  ");
      $users_master_data=mysqli_fetch_array($users_master_q);
      $d->insert_myactivity($user_id,"0","", "You Blocked ".$users_master_data['user_full_name'],"activity.png");

      $response["message"] = "User Blocked.";
      $response["status"] = "200";
      echo json_encode($response);
  } else {

    $response["message"] = "Fail to Block.";
    $response["status"] = "201";
    echo json_encode($response);
}
} else if ($_POST['chatUnBlock'] == "chatUnBlock" && filter_var($block_for, FILTER_VALIDATE_INT) == true && filter_var($block_by, FILTER_VALIDATE_INT) == true) {

    $q1 = $d->select("chat_block_master", "block_by='$block_by' AND block_for='$block_for'");

    $q2 = $d->select("user_block_master","user_id='$block_for' AND block_by='$block_by' ");


    if (mysqli_num_rows($q1) > 0) {
        $q = $d->delete('chat_block_master', "block_by='$block_by' AND block_for='$block_for'");

        if ($q == true) {
            //delete blocked member
           /* $q = $d->delete("user_block_master", "user_id='$block_for' AND block_by='$block_by' ");*/
            //delete blocked member

            $users_master_q=$d->select("users_master","user_mobile='$block_for' AND office_member=0 AND active_status=0  ");
            $users_master_data=mysqli_fetch_array($users_master_q);
            $d->insert_myactivity($user_id,"0","", "You unblocked ".$users_master_data['user_full_name'],"activity.png");
            $response["message"] = "User Unblocked.";
            $response["status"] = "200";
            echo json_encode($response);
        } else {

            $response["message"] = "Fail to Unblock.";
            $response["status"] = "201";
            echo json_encode($response);
        }
    }else if (mysqli_num_rows($q2) > 0) {

       $d->delete("user_block_master","user_id='$block_for' AND block_by='$block_by' ");
       $users_master_q=$d->select("user_full_name","users_master","user_mobile='$block_for' AND office_member=0 AND active_status=0  ");
       $users_master_data=mysqli_fetch_array($users_master_q);
       $d->insert_myactivity($user_id,"0","", "You unblocked ".$users_master_data['user_full_name'],"activity.png");
       $response["message"] = "User Unblocked.";
       $response["status"] = "200";
       echo json_encode($response);
   } else {
    $response["message"] = "User Already Unblocked.";
    $response["status"] = "201";
    echo json_encode($response);
}
} elseif (isset($deleteChatMulti) && $deleteChatMulti=="deleteChatMulti" && filter_var($user_id, FILTER_VALIDATE_INT) == true) {


   $chat_idAry = explode(",",$chat_id);
   for ($i=0; $i <count($chat_idAry); $i++) { 
      $q=$d->delete("chat_master","chat_id='$chat_idAry[$i]' AND chat_id!=0  AND msg_by='$user_id'");
  }

  if($q==true){
    $d->insert_myactivity($user_id,"0","", "Multiple Chat Deleted ","activity.png");
    $response["message"]="Deleted Successfully";
    $response["status"]="200";
    echo json_encode($response);

}else {
    $response["message"]="Something Wrong";
    $response["status"]="201";
    echo json_encode($response);                        
}


} else{
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
