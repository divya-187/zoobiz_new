<?php
include_once 'lib.php';
if (isset($_POST) && !empty($_POST)) {
    if ($key == $keydb) {
        $response = array();
        extract(array_map("test_input", $_POST));
        $today = date("Y-m-d");
          if ($_POST['getCllassifiedNew'] == "getCllassifiedNew" && filter_var($user_id, FILTER_VALIDATE_INT) == true) {


                $blocked_users = array('0'); 
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


            
            $queryAry = array();
            if ($state_id != 0) {
                $atchQueryCity = "cllassifieds_city_master.state_id ='$state_id'";
                array_push($queryAry, $atchQueryCity);
            }
            if ($city_id != 0) {
                $cityIdAry     = explode(",", $city_id);
                $ids           = join("','", $cityIdAry);
                $atchQueryCity = "cllassifieds_city_master.city_id IN ('$ids')";
                array_push($queryAry, $atchQueryCity);
            }
            
             
            $query2 = "";
             

             
            
            if ($city_id != 0) {
                $query2 .= " and  cllassifieds_city_master.city_id IN ('$ids')";
            }
            $appendQuery    = implode(" AND ", $queryAry);
            
            $q              = $d->select("cllassifieds_master,cllassifieds_city_master", "cllassifieds_master.active_status=0  AND cllassifieds_master.cllassified_id=cllassifieds_city_master.cllassified_id and cllassifieds_master.user_id not in ($blocked_users)   $query2  /*$appendQuery*/", "GROUP BY cllassifieds_master.cllassified_id ORDER BY cllassifieds_master.cllassified_id DESC ");
 
           
           $dataArray = array();
                $counter = 0 ;
                foreach ($q as  $value) {
                    foreach ($value as $key => $valueNew) {
                        $dataArray[$counter][$key] = $valueNew;
                    }
                    $counter++;
                }

            $qchekc         = $d->selectRow("cllassified_mute", "users_master", "user_id='$user_id' ");
            $muteDataCommon = mysqli_fetch_array($qchekc);

            $user_id_array = array('0');
             $classified_id_array = array('0');
                for ($l=0; $l < count($dataArray) ; $l++) {
                    $user_id_array[] = $dataArray[$l]['user_id'];
                    $classified_id_array[] = $dataArray[$l]['cllassified_id'];
                }

                 $classified_id_array = implode(",", $classified_id_array);
                 $user_id_array = implode(",", $user_id_array);
             $photo_qry = $d->selectRow("*","classified_photos_master", "classified_id in ($classified_id_array)   AND user_id in ($user_id_array) ");
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
                    $photo_array[$PArray[$pd]['classified_id']."__".$PArray[$pd]['user_id']][] = $PArray[$pd]; 
                }


                $doc_qry = $d->selectRow("*","classified_document_master", "classified_id in ($classified_id_array)   AND user_id in ($user_id_array) ");
                 $DArray = array();
                $Dcounter = 0 ;
                foreach ($doc_qry as  $value) {
                    foreach ($value as $key => $valueNew) {
                        $DArray[$Dcounter][$key] = $valueNew;
                    }
                    $Dcounter++;
                }
                $doc_array = array();
                for ($pd=0; $pd < count($DArray) ; $pd++) {
                    $doc_array[$DArray[$pd]['classified_id']."__".$DArray[$pd]['user_id']][] = $DArray[$pd]; 
                }


                 $user_qry = $d->selectRow("*","users_master", " user_id in ($user_id_array) ");
                 $UArray = array();
                $Ucounter = 0 ;
                foreach ($user_qry as  $value) {
                    foreach ($value as $key => $valueNew) {
                        $UArray[$Ucounter][$key] = $valueNew;
                    }
                    $Ucounter++;
                }

                $user_array = array();
                $city_id_array = array('0');
                for ($pd=0; $pd < count($UArray) ; $pd++) {
                    $user_array[$UArray[$pd]['user_id']] = $UArray[$pd]; 
                     $city_id_array[] =$UArray[$pd]['city_id'];
                }

                $city_id_array = implode(",", $city_id_array);
                 
                $city_qry = $d->selectRow("city_name,city_id","cities", " city_id in ($city_id_array) ");
                $city_array = array('0');
                while ($city_data = mysqli_fetch_array($city_qry)) {
                $city_array[$city_data['city_id']] =$city_data['city_name'];
               }

                $classified_user_save_master = $d->selectRow("classified_id","classified_user_save_master", "user_id='$user_id'  ", ""); 
            $classified_timeline_array = array('0');
            while ($tclassified_user_save_master_data = mysqli_fetch_array($classified_user_save_master)) {
                $classified_timeline_array[] = $tclassified_user_save_master_data['classified_id'];
            }

            if (count($dataArray) > 0) {
                $response["discussion"] = array();
                /*while ($data = mysqli_fetch_array($q)) {*/
for ($l=0; $l < count($dataArray) ; $l++) {
                    $data =$dataArray[$l];
                      $discussion                             = array();

                      if(in_array($data[cllassified_id], $classified_timeline_array)){
                            $discussion["is_saved"] = true;
                        }else {
                            $discussion["is_saved"] = false;
                        }

                    $discussion["classified_photos"] = array();

                    $p_data_arr = $photo_array[$data[cllassified_id]."__".$data['user_id']]; 
                    for ($pda=0; $pda < count($p_data_arr) ; $pda++) { 
                        $ClsData = $p_data_arr[$pda];
                     
                        $classified_photos = array();
                        if($ClsData['photo_name']!=""){
                            $classified_photos["photo_name"] = $base_url . "img/cllassified/" . $ClsData['photo_name'];
                        } else {
                            $classified_photos["photo_name"] ="";
                        }
                        
                        $classified_photos["classified_img_height"] = $ClsData['classified_img_height'];
                        $classified_photos["classified_img_width"] = $ClsData['classified_img_width'];
                        array_push($discussion["classified_photos"], $classified_photos);
                    }

                     $discussion["classified_docs"] = array();

                    $d_data_arr = $doc_array[$data[cllassified_id]."__".$data['user_id']]; 
                    for ($pda=0; $pda < count($d_data_arr) ; $pda++) { 
                        $ClsDData = $d_data_arr[$pda];
                     
                        $classified_docs = array();
                        if($ClsDData['document_name']!=""){
                            $classified_docs["document_name"] = $base_url . "img/cllassified/docs/" . $ClsDData['document_name'];
                        } else {
                            $classified_docs["document_name"] ="";
                        }
                        
                        
                        array_push($discussion["classified_docs"], $classified_docs);
                    }

                    $qch22                                  = $d->select("user_block_master", "user_id='$user_id' AND block_by='$data[user_id]' ");
                  
                   

                    if($data['classified_audio']!=""){
                            $discussion["classified_audio"] = $base_url . "img/cllassified/audio/" . $data['classified_audio'];
                        } else {
                            $discussion["classified_audio"] ="";
                        }

                    $user_data_arr = $user_array[$data['user_id']]; 
                     if($user_data_arr['user_profile_pic']!=""){
                            $discussion["user_profile_pic"] = $base_url . "img/users/members_profile/" . $user_data_arr['user_profile_pic'];
                        } else {
                            $discussion["user_profile_pic"] ="";
                        }
                        $discussion["user_full_name"] =$user_data_arr['user_full_name'];
                    $discussion["user_mobile"] =$user_data_arr['user_mobile'];
                    $discussion["user_city"] =$city_array[$user_data_arr['city_id']];


                    $discussion["cllassified_id"]           = $data['cllassified_id'];
                    $discussion["business_category_id"]     = $data['business_category_id'];
                    $discussion["business_sub_category_id"] = $data['business_sub_category_id'];
                    $discussion["cllassified_title"]        = html_entity_decode($data['cllassified_title']);
                    $discussion["cllassified_description"]  = html_entity_decode($data['cllassified_description']);
                    $discussion["user_id"]                  = html_entity_decode($data['user_id']);
                    //$discussion["created_date"]             = date('d M Y', strtotime($data['created_date']));

                    if(strtotime($data['created_date']) < strtotime('-30 days')) {
                        $discussion["created_date"] = date("j M Y", strtotime($data['created_date']));
                    } else {
                        $discussion["created_date"]= time_elapsed_string($data['created_date']);
                    }


                    if ($data['cllassified_photo'] != '') {
                        $discussion["cllassified_photo"] = $base_url . 'img/cllassified/' . $data['cllassified_photo'];
                    } else {
                        $discussion["cllassified_photo"] = "";
                    }
                    if ($data['cllassified_file'] != '') {
                        $discussion["cllassified_file"] = $base_url . 'img/cllassified/' . $data['cllassified_file'];
                    } else {
                        $discussion["cllassified_file"] = "";
                    }
                    $discussion["city"] = array();
                    $fi                 = $d->select("cllassifieds_city_master,cities", "cities.city_id=cllassifieds_city_master.city_id AND  cllassifieds_city_master.cllassified_id='$data[cllassified_id]' ");
                    while ($feeData = mysqli_fetch_array($fi)) {
                        $city              = array();
                        $city["city_id"]   = $feeData['city_id'];
                        $city["city_name"] = $feeData['city_name'];
                        array_push($discussion["city"], $city);
                    }
                    $q111                       = $d->select("users_master", "user_id='$data[user_id]'", "");
                    $userdata                   = mysqli_fetch_array($q111);
                    $created_by                 = $userdata['user_full_name'];
                    $user_profile               = $base_url . "img/users/members_profile/" . $userdata['user_profile_pic'];

                    if($userdata['user_profile_pic'] ==""){
                        $discussion["user_profile"] ="";
                    } else {
                        $discussion["user_profile"] = $user_profile;
                    }
                    

                    

                    $discussion["created_by"]   = html_entity_decode($created_by);
                    $qc11                       = $d->select("cllassified_mute", "user_id='$user_id' AND cllassified_id='$data[cllassified_id]'");
                    if (mysqli_num_rows($qc11) > 0) {
                        $discussion["mute_status"] = true;
                    } else {
                        $discussion["mute_status"] = false;
                    }
                    $discussion["total_coments"] = $d->count_data_direct("comment_id", "cllassified_comment", "cllassified_id='$data[cllassified_id]' AND prent_comment_id=0") . '';
                    $discussion["comment"]       = array();
                    $q3                          = $d->select("cllassified_comment", "cllassified_id='$data[cllassified_id]' AND prent_comment_id=0", "ORDER BY comment_id   DESC");
                    while ($subData = mysqli_fetch_array($q3)) {
                        $comment                         = array();
                        $comment["comment_id"]           = $subData['comment_id'];
                        $comment["user_id"]              = $subData['user_id'];
                        $comment["comment_messaage"]     = html_entity_decode($subData['comment_messaage']);
                        $comment["comment_created_date"] = time_elapsed_string($subData['created_date']);
                        $q111                            = $d->select("users_master", "user_id='$subData[user_id]'", "");
                        $userdataComment                 = mysqli_fetch_array($q111);
                        $created_by                      = $userdataComment['user_full_name'];
                        $comment["created_by"]           = $created_by;
                        array_push($discussion["comment"], $comment);
                    }
                    if (mysqli_num_rows($qch22) == 0) {
                        array_push($response["discussion"], $discussion);
                    }
                }
                $response["cllassified_mute"] = $muteDataCommon['cllassified_mute'];
                $response["message"]          = "Classified Data";
                $response["status"]           = "200";
                echo json_encode($response);
            } else {
                $response["message"] = "No Classifieds Available";
                $response["status"]  = "201";
                echo json_encode($response);
            }
        }  else if ($_POST['saveClassified'] == "saveClassified" && filter_var($user_id, FILTER_VALIDATE_INT) == true && filter_var($classified_id, FILTER_VALIDATE_INT) == true ) {
            
            if(isset($is_delete) && $is_delete=='true'){
                $d->delete("classified_user_save_master", "user_id='$user_id' AND classified_id='$classified_id'");
                if($d == TRUE){ 
                    $d->insert_myactivity($user_id,"0","", "Saved Classified Removed","activity.png");
                    $response["message"] = "Saved Classified Removed";
                    $response["status"] = "200";
                    echo json_encode($response);
                } else {
                    $response["message"] = "Something Wrong";
                    $response["status"] = "201";
                    echo json_encode($response);
                }
            } else {



                $modify_date = date("Y-m-d H:i:s");
                $m->set_data('classified_id', $classified_id);
                $m->set_data('user_id', $user_id);
                $m->set_data('created_at', $modify_date);
                
                $a1 = array(
                    'classified_id' => $m->get_data('classified_id'),
                    'user_id' => $m->get_data('user_id'),
                    'created_at' => $m->get_data('created_at')
                );
                $d->insert("classified_user_save_master", $a1);


                if($d == TRUE){ 
                    $d->insert_myactivity($user_id,"0","", "Classified Saved","activity.png");
                    $response["message"] = "Classified Saved";
                    $response["status"] = "200";
                    echo json_encode($response);
                } else {
                    $response["message"] = "Something Wrong";
                    $response["status"] = "201";
                    echo json_encode($response);
                }

            }

        }    else if (isset($_POST['addCllassifiedNew']) && filter_var($user_id, FILTER_VALIDATE_INT) == true) { 
            $blocked_users = array('0'); 
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

                            $newFileNameAaudio = rand() . $user_id;
                            $dirPathAud = "../img/cllassified/audio/";
                            $ext = pathinfo($_FILES['classified_audio']['name'], PATHINFO_EXTENSION);
                            move_uploaded_file($_FILES["classified_audio"]["tmp_name"],$dirPathAud . $newFileNameAaudio."_audio." . $ext);
                            $classified_audio =  $newFileNameAaudio."_audio." . $ext;
             
            $m->set_data('cllassified_title', $cllassified_title);
            $m->set_data('cllassified_description', $cllassified_description);
            $m->set_data('created_date', date("Y-m-d H:i:s"));
            $m->set_data('user_id', $user_id);
            $m->set_data('business_category_id', $business_category_id);
            $m->set_data('business_sub_category_id', $business_sub_category_id);
            $m->set_data('cllassified_photo', $cllassified_photo);
            $m->set_data('cllassified_file', $cllassified_file);
            $m->set_data('classified_audio', $classified_audio);
            $a              = array(
                'cllassified_title' => $m->get_data('cllassified_title'),
                'cllassified_description' => $m->get_data('cllassified_description'),
                'classified_audio'=> $m->get_data('classified_audio'),
                'created_date' => $m->get_data('created_date'),
                'user_id' => $m->get_data('user_id'),
                'cllassified_file' => $m->get_data('cllassified_file'),
                'business_category_id' => $m->get_data('business_category_id'),
                'business_sub_category_id' => $m->get_data('business_sub_category_id')
            );
            //8march21
            
            $q1             = $d->insert("cllassifieds_master", $a);
            $cllassified_id = $con->insert_id;

            $total = count($_FILES['classified_photos']['tmp_name']);

            $total_docs = count($_FILES['classified_docs']['tmp_name']);

            if ($q1 > 0) {

                //add multiple image start
                for ($i = 0; $i < $total; $i++) {
                        $uploadedFile = $_FILES['classified_photos']['tmp_name'][$i];
                        if ($uploadedFile != "") {
                            $sourceProperties = getimagesize($uploadedFile);
                            $newFileName = rand() . $user_id;
                            $dirPath = "../img/cllassified/";
                            $ext = pathinfo($_FILES['classified_photos']['name'][$i], PATHINFO_EXTENSION);
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
                            $myfilesize= filesize($dirPath . $newFileName . "_cls." . $ext); 
                            $cls_img = $newFileName . "_cls." . $ext;

                            if($i == 0){
                                $classified_photo=$base_url.'../img/cllassified/'.$cls_img.'.'. $ext;

                            }
                            $a1 = array(
                                'classified_id' => $cllassified_id,
                                'user_id' => $user_id,
                                'photo_name' => $cls_img,
                                'classified_img_height' => $newImageHeight,
                                'classified_img_width' => $newImageWidth,
                                'size' =>$myfilesize
                            );
                            $d->insert("classified_photos_master", $a1);
                        } else {
                            $response["message"] = "faild.";
                            $response["status"] = "201";
                            echo json_encode($response);
                            exit();
                        }
                    }
                //add multiple image end

                    //add multiple doc start
                    for ($i = 0; $i < $total_docs; $i++) {
                        $uploadedFile = $_FILES['classified_docs']['tmp_name'][$i];
                        if ($uploadedFile != "") {
                             
                            $newFileName = rand() . $user_id;
                            $dirPath = "../img/cllassified/docs/";
                            $ext = pathinfo($_FILES['classified_docs']['name'][$i], PATHINFO_EXTENSION);
                         $upload =   move_uploaded_file($_FILES["classified_docs"]["tmp_name"][$i],$dirPath . $newFileName."_doc." . $ext);
                            $myfilesize= filesize($dirPath . $newFileName . "_doc." . $ext);
                            
 
                            
                            $a1 = array(
                                'classified_id' => $cllassified_id,
                                'user_id' => $user_id,                                  
                                'document_name' => $newFileName . "_doc." . $ext,
                                'size' =>($myfilesize)
                            );
                            $d->insert("classified_document_master", $a1);
                        } else {
                            $response["message"] = "faild.";
                            $response["status"] = "201";
                            echo json_encode($response);
                            exit();
                        }
                    }
                    //add multiple doc end

                $cityAry = explode(",", $city_id);
                for ($i = 0; $i < count($cityAry); $i++) {
                    $aCity = array(
                        'cllassified_id' => $cllassified_id,
                        'city_id' => $cityAry[$i],
                        'state_id' => $state_id
                    );
                    $d->insert("cllassifieds_city_master", $aCity);
                }
                $title       = "Classified";
                $description = "New Classified Added By $user_name";

                //4nov2020
                //$d->insertFollowNotification($title, $description, $timeline_id, $user_id, 0, "classified");
                $d->insertFollowNotification($title, $description, $cllassified_id, $user_id,4, "classified");


                $fcmArrayAndroid       = $d->get_android_fcm("users_master,follow_master", "users_master.user_id=follow_master.follow_by AND follow_master.follow_to='$user_id' AND users_master.user_token!='' AND  lower(users_master.device) ='android' and users_master.user_id not in ($blocked_users) ");
                $fcmArrayIos           = $d->get_android_fcm("users_master,follow_master", "users_master.user_id=follow_master.follow_by AND follow_master.follow_to='$user_id' AND users_master.user_token!='' AND  lower(users_master.device)='ios' and users_master.user_id not in ($blocked_users)  ");
                //----------------------------------------------------
                //--------------------------------------------------------
                $idsAndroid            = join("','", $fcmArrayAndroid);
                $idsIos                = join("','", $fcmArrayIos);
                $fcmArray              = $d->get_android_fcm("users_master,user_employment_details", "user_employment_details.user_id=users_master.user_id AND user_employment_details.business_category_id='$business_category_id' AND  users_master.user_id!='$user_id' AND users_master.cllassified_mute=0 AND users_master.user_token!='' AND  lower(users_master.device) ='android' OR users_master.user_token IN ('$idsAndroid') AND users_master.cllassified_mute=0 and users_master.user_id not in ($blocked_users) ");
                $fcmArrayIos           = $d->get_android_fcm("users_master,user_employment_details", "user_employment_details.user_id=users_master.user_id AND user_employment_details.business_category_id='$business_category_id' AND  users_master.user_id!='$user_id' AND users_master.cllassified_mute=0 AND users_master.user_token!='' AND  lower(users_master.device)='ios' OR users_master.user_token IN ('$idsIos') AND users_master.cllassified_mute=0 and users_master.user_id not in ($blocked_users) ");
                $fcmArrayAndroidFollow = $d->get_android_fcm("users_master,category_follow_master", "users_master.user_id=category_follow_master.user_id AND category_follow_master.category_id='$business_category_id' AND users_master.user_token!='' AND  lower(users_master.device) ='android' and users_master.user_id not in ($blocked_users) ");
                $fcmArrayIosFollow     = $d->get_android_fcm("users_master,category_follow_master", "users_master.user_id=category_follow_master.user_id AND category_follow_master.category_id='$business_category_id' AND users_master.user_token!='' AND  lower(users_master.device) ='ios' and users_master.user_id not in ($blocked_users) ");
                $fcmArray              = array_merge($fcmArrayAndroidFollow, $fcmArray);
                $fcmArrayIos           = array_merge($fcmArrayIosFollow, $fcmArrayIos);


                //4nov
                
                /*$nResident->noti("classified", $notiUrl, 0, $fcmArray, $title, $description, 'classified');
                $nResident->noti_ios("ClassifiedVC", $notiUrl, 0, $fcmArrayIos, $title, $description, 'classified');*/

                $nResident->noti("viewClassified", $notiUrl, 0, $fcmArray, $title, $description, $cllassified_id);
                $nResident->noti_ios("viewClassified", $notiUrl, 0, $fcmArrayIos, $title, $description, $cllassified_id);



                // $d->insert_myactivity($user_id,"$society_id","0","$user_name","New discussion forum created","menu_fourm.png");
                $response["message"] = "Classified Added";
                $response["status"]  = '200';
                echo json_encode($response);
            } else {
                $response["message"] = "Something Wrong.";
                $response["status"]  = '201';
                echo json_encode($response);
            }
        } else if (isset($_POST['addCllassifiedComment']) && filter_var($user_id, FILTER_VALIDATE_INT) == true) {
            $m->set_data('cllassified_id', $cllassified_id);
            $m->set_data('comment_messaage', $comment_messaage);
            $m->set_data('created_date', date("Y-m-d H:i:s"));
            $m->set_data('user_id', $user_id);
            $a                = array(
                'cllassified_id' => $m->get_data('cllassified_id'),
                'comment_messaage' => $m->get_data('comment_messaage'),
                'created_date' => $m->get_data('created_date'),
                'user_id' => $m->get_data('user_id')
            );
            $q1               = $d->insert("cllassified_comment", $a);
            $comment_messaage = html_entity_decode($comment_messaage);
            if ($q1 > 0) {
                //23oct2020
                $cllassifieds_master      = $d->select("cllassifieds_master", "cllassified_id='$cllassified_id'");
                $cllassifieds_master_data = mysqli_fetch_array($cllassifieds_master);
                $classified_user_id       = $cllassifieds_master_data['user_id'];

                $cllassified_title = $cllassifieds_master_data['cllassified_title'];
                //23oct2020
                $notiAry                  = array(
                    'user_id' => $classified_user_id,
                    'other_user_id' => $user_id,
                    'timeline_id' => $cllassified_id,
                    'notification_type' => 4,
                    'notification_title' => "Comment On Classified By $user_name",
                    'notification_desc' => "Comment: $comment_messaage",
                    'notification_date' => date('Y-m-d H:i'),
                    'notification_action' => 'classified',
                    'notification_logo' => 'menu_fourm.png'
                );
                if($classified_user_id !=$user_id){
                    $d->insert("user_notification", $notiAry);
                }
                
                $muteArray = array();
                $qc11      = $d->select("cllassified_mute", "cllassified_id='$cllassified_id'");
                while ($muteData = mysqli_fetch_array($qc11)) {
                    array_push($muteArray, $muteData['user_id']);
                }
                $qct                  = $d->selectRow("business_category_id", "cllassifieds_master", "cllassified_id='$cllassified_id'");
                $cData                = mysqli_fetch_array($qct);
                $business_category_id = $cData['business_category_id'];
                $ids                  = join("','", $muteArray);
                //23oct2020
                /*$fcmArray = $d->get_android_fcm("users_master,user_employment_details", "user_employment_details.user_id=users_master.user_id AND  users_master.user_id NOT IN ('$ids') AND users_master.cllassified_mute=0 AND users_master.user_mobile!='$user_mobile' AND users_master.user_token!='' AND  users_master.device='android'  AND users_master.user_id!='$user_id'  AND user_employment_details.business_category_id='$business_category_id'");
                $fcmArrayIos = $d->get_android_fcm("users_master,user_employment_details", "user_employment_details.user_id=users_master.user_id AND  users_master.user_id NOT IN ('$ids') AND users_master.cllassified_mute=0 AND users_master.user_mobile!='$user_mobile' AND users_master.user_token!='' AND  users_master.device='ios'  AND users_master.user_id!='$user_id' AND user_employment_details.business_category_id='$business_category_id'");*/
                $fcmArray             = $d->get_android_fcm("users_master", " user_id='$classified_user_id' and user_token!='' and lower(device)='android' AND  user_id!='$user_id' and  cllassified_mute=0    ");
                $fcmArrayIos          = $d->get_android_fcm("users_master ", " user_id='$classified_user_id' and     user_token!='' AND  lower(device)='ios'  AND  user_id!='$user_id' and cllassified_mute=0    ");
                //23oct2020

                //4nov 2020
                /*$nResident->noti("classified", "", 0, $fcmArray, "$comment_messaage", "Comment On Classified By $user_name", 'classified');
                $nResident->noti_ios("ClassifiedVC", "", 0, $fcmArrayIos, "$comment_messaage", "Comment On Classified By $user_name", 'classified');*/
                $nResident->noti("viewClassified", "", 0, $fcmArray, "Comment On Classified By $user_name", "Comment: $comment_messaage", $cllassified_id);
                $nResident->noti_ios("viewClassified", "", 0, $fcmArrayIos,  "Comment On Classified By $user_name", "Comment: $comment_messaage", $cllassified_id);

               //4nov 2020

                // $d->insert_log($user_id,"$society_id","0","$user_name","Comment on discussion forum");
                $response["message"] = "Comment Added";
                $response["status"]  = '200';
                echo json_encode($response);
            } else {
                $response["message"] = "Something Wrong.";
                $response["status"]  = '201';
                echo json_encode($response);
            }
        } else if (isset($_POST['addReplyComment']) && filter_var($user_id, FILTER_VALIDATE_INT) == true && filter_var($comment_id, FILTER_VALIDATE_INT) == true) {
            $m->set_data('prent_comment_id', $comment_id);
            $m->set_data('cllassified_id', $cllassified_id);
            $m->set_data('comment_messaage', $comment_messaage);
            $m->set_data('created_date', date("Y-m-d H:i:s"));
            $m->set_data('user_id', $user_id);
            $a                = array(
                'prent_comment_id' => $m->get_data('prent_comment_id'),
                'cllassified_id' => $m->get_data('cllassified_id'),
                'comment_messaage' => $m->get_data('comment_messaage'),
                'created_date' => $m->get_data('created_date'),
                'user_id' => $m->get_data('user_id')
            );
            //8march21
           /* $last_auto_id     = $d->last_auto_id("cllassified_comment");
            $res              = mysqli_fetch_array($last_auto_id);
            $comment_id11     = $res['Auto_increment'];*/

            $q1               = $d->insert("cllassified_comment", $a);
            $comment_id11 = $con->insert_id;
            $comment_messaage = html_entity_decode($comment_messaage);
            if ($q1 > 0) {
                $q111            = $d->selectRow("user_full_name,salutation", "users_master", "user_id='$user_id'");
                $userdataComment = mysqli_fetch_array($q111);
                $user_name       = $userdataComment['user_full_name'];
                $qct             = $d->select("cllassified_comment", "cllassified_id='$cllassified_id' AND comment_id='$comment_id'");
                $comentUser      = mysqli_fetch_array($qct);
                $comment_user_id = $comentUser['user_id'];
                //5 nov 2020 'other_user_id' => $cllassified_id, 'notification_type' => 4,
                $notiAry         = array(
                    'user_id' => $comment_user_id,
                    'other_user_id' => $user_id,
                    'timeline_id' => $cllassified_id,
                    'notification_type' => 4,
                    'notification_title' => "Comment Reply By $user_name" ,
                    'notification_desc' =>"Comment: $comment_messaage",
                    'notification_date' => date('Y-m-d H:i'),
                    'notification_action' => 'classified',
                    'notification_logo' => 'menu_fourm.png'
                );


                $cllassifieds_master2      = $d->select("cllassifieds_master", "cllassified_id='$cllassified_id'");
                $cllassifieds_master_data2 = mysqli_fetch_array($cllassifieds_master2);
                $classified_user_id2       = $cllassifieds_master_data2['user_id'];
                 if($classified_user_id2 !=$user_id){
                        $d->insert("user_notification", $notiAry);
                 }
                $muteArray = array();
                $qc11      = $d->select("cllassified_mute", "cllassified_id='$cllassified_id'");
                while ($muteData = mysqli_fetch_array($qc11)) {
                    array_push($muteArray, $muteData['user_id']);
                }
                $qct                  = $d->selectRow("business_category_id", "cllassifieds_master", "cllassified_id='$cllassified_id'");
                $cData                = mysqli_fetch_array($qct);
                $business_category_id = $cData['business_category_id'];
                $ids                  = join("','", $muteArray);
                $fcmArray             = $d->get_android_fcm("users_master", "  cllassified_mute=0 AND user_id='$comment_user_id' AND user_token!='' AND  lower(device)='android' AND user_id!='$user_id'");
                $fcmArrayIos          = $d->get_android_fcm("users_master", "  cllassified_mute=0 AND user_id='$comment_user_id'  AND user_token!='' AND  lower(device) ='ios' AND user_id!='$user_id'");

                //4NOV 2020
                /*$nResident->noti("classified", "", $society_id, $fcmArray, "$comment_messaage", "Comment Reply By $user_name", 'classified');
                $nResident->noti_ios("ClassifiedVC", "", $society_id, $fcmArrayIos, "$comment_messaage", "Comment Reply By $user_name", 'classified');*/

                $nResident->noti("viewClassified", "", $society_id, $fcmArray, "Comment Reply By $user_name", "Reply: $comment_messaage", $cllassified_id);
                $nResident->noti_ios("viewClassified", "", $society_id, $fcmArrayIos, "Comment Reply By $user_name", "Reply: $comment_messaage", $cllassified_id);


                // $d->insert_log($user_id,"$society_id","0","$user_name","Reply in comment of discussion forum");
                $response["comment_id"] = $comment_id11;
                $response["message"]    = "Comment Reply Added";
                $response["status"]     = '200';
                echo json_encode($response);
            } else {
                $response["message"] = "Something Wrong.";
                $response["status"]  = '201';
                echo json_encode($response);
            }
        } else if (isset($_POST['addMute']) && filter_var($user_id, FILTER_VALIDATE_INT) == true && filter_var($cllassified_id, FILTER_VALIDATE_INT) == true) {
            $m->set_data('cllassified_id', $cllassified_id);
            $m->set_data('user_id', $user_id);
            $a = array(
                'cllassified_id' => $m->get_data('cllassified_id'),
                'user_id' => $m->get_data('user_id')
            );
            if ($mute_type == 0) {
                $qc = $d->select("cllassified_mute", "user_id='$user_id' AND cllassified_id='$cllassified_id'");
                if (mysqli_num_rows($qc) > 0) {
                    $q1 = $d->update("cllassified_mute", $a, "user_id='$user_id' AND cllassified_id='$cllassified_id'");
                } else {
                    $q1 = $d->insert("cllassified_mute", $a);
                }
                $response["message"] = "Muted Successfully";
            } else {
                $response["message"] = "Unmute Successfully";
                $q1                  = $d->delete("cllassified_mute", "user_id='$user_id' AND cllassified_id='$cllassified_id'");
            }
            if ($q1 > 0) {
                $response["status"] = '200';
                echo json_encode($response);
            } else {
                $response["message"] = "Something Wrong.";
                $response["status"]  = '201';
                echo json_encode($response);
            }
        } else if ($_POST['muteAllDiscussion'] == "muteAllDiscussion" && filter_var($user_id, FILTER_VALIDATE_INT) == true && filter_var($user_mobile, FILTER_VALIDATE_INT) == true) {
            $m->set_data('cllassified_mute', $cllassified_mute);
            $a = array(
                'cllassified_mute' => $m->get_data('cllassified_mute')
            );
            $q = $d->update("users_master", $a, "user_mobile='$user_mobile'  ");
            if ($q == true) {
                if ($cllassified_mute == 1) {
                    $response["message"] = "All Classified Muted";
                } else {
                    $response["message"] = "All Classified Unmuted";
                }
                // $response["message"] = "Mobile Privacy Changed ";
                $response["status"] = "200";
                echo json_encode($response);
            } else {
                $response["message"] = "Something Wrong";
                $response["status"]  = "201";
                echo json_encode($response);
            }
        } else if (isset($_POST['deleteCllassified']) && filter_var($user_id, FILTER_VALIDATE_INT) == true && filter_var($cllassified_id, FILTER_VALIDATE_INT) == true) {
            $q1 = $d->delete("cllassifieds_master", "cllassified_id='$cllassified_id' AND user_id='$user_id'");
            if ($q1 > 0) {
                $d->delete("cllassified_comment", "cllassified_id='$cllassified_id' ");
                $d->delete("cllassifieds_city_master", "cllassified_id='$cllassified_id' ");
                $response["message"] = "Classified Deleted";
                $response["status"]  = '200';
                echo json_encode($response);
            } else {
                $response["message"] = "Something Wrong.";
                $response["status"]  = '201';
                echo json_encode($response);
            }
        } else if (isset($_POST['deleteComment']) && filter_var($user_id, FILTER_VALIDATE_INT) == true && filter_var($comment_id, FILTER_VALIDATE_INT) == true) {
            $q1 = $d->delete("cllassified_comment", "comment_id='$comment_id' AND user_id='$user_id'");
            if ($q1 > 0) {
                $q1                  = $d->delete("cllassified_comment", "prent_comment_id='$comment_id' AND user_id='$user_id'");
                $response["message"] = "Comment Deleted";
                $response["status"]  = '200';
                echo json_encode($response);
            } else {
                $response["message"] = "Something Wrong.";
                $response["status"]  = '201';
                echo json_encode($response);
            }
        } else {
            $response["message"] = "wrong tag";
            $response["status"]  = "201";
            echo json_encode($response);
        }
    } else {
        $response["message"] = "wrong api key";
        $response["status"]  = "201";
        echo json_encode($response);
    }
}