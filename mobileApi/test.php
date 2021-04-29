<?php 
    

 $blocked_users = array('0');
   $getBLockUserQry = $d->selectRow("user_id, block_by", "user_block_master", " block_by='$user_id' or user_id='$user_id'  ", "");
   while ($getBLockUserData = mysqli_fetch_array($getBLockUserQry)) {
    if ($user_id != $getBLockUserData['user_id']) {
     $blocked_users[] = $getBLockUserData['user_id'];
    }
    if ($user_id != $getBLockUserData['block_by']) {
     $blocked_users[] = $getBLockUserData['block_by'];
    }
   }
   $blocked_users = implode(",", $blocked_users);
   
   $queryAry = array();
   $query2 = "";
   if ( count($business_category_id) > 0 && !empty($business_category_id) )  {
    $query2 .= " and  cc.business_category_id IN ('$business_category_id')";
   }

   if ( count($business_sub_category_id) > 0 && !empty($business_sub_category_id) )  {
    $query2 .= " and  cc.business_sub_category_id IN ('$business_sub_category_id')";
   }
   $catSearch = '';
   $subCatSearch = '';
   if (trim($search) != '') {
    $search = trim($search);
    $query2 .= " and  ( c.cllassified_title LIKE '%$search%'    or c.cllassified_description LIKE '%$search%' or (business_categories.business_category_id = cc.business_category_id  or  business_sub_categories.business_sub_category_id = cc.business_sub_category_id) ) ";
    $catSearch = " and  (  business_categories.category_name LIKE '%$search%'  ) ";
    $subCatSearch = " and  (  business_sub_categories.sub_category_name LIKE '%$search%'  ) ";
   }
   $appendQuery = implode(" AND ", $queryAry);
   $q = $d->selectRow(
    "cllassifieds_city_master.*,c.*,business_categories.category_name,business_sub_categories.sub_category_name,cc.business_category_id ,cc.business_sub_category_id ","cllassifieds_city_master,  cllassifieds_master AS c LEFT JOIN classified_category_master cc ON c.cllassified_id = cc.classified_id left join business_categories on business_categories.business_category_id = cc.business_category_id $catSearch left join business_sub_categories on   business_sub_categories.business_sub_category_id = cc.business_sub_category_id  $subCatSearch "," c.active_status=0 AND c.cllassified_id=cllassifieds_city_master.cllassified_id and c.user_id not in ($blocked_users)   $query2  ",  "GROUP BY c.cllassified_id ORDER BY c.cllassified_id DESC "
   );
    if(isset($debug)){
    echo "cllassifieds_city_master,  cllassifieds_master AS c LEFT JOIN classified_category_master cc ON c.cllassified_id = cc.classified_id left join business_categories on business_categories.business_category_id = cc.business_category_id $catSearch left join business_sub_categories on   business_sub_categories.business_sub_category_id = cc.business_sub_category_id  $subCatSearch";
    echo  "c.active_status=0 AND c.cllassified_id=cllassifieds_city_master.cllassified_id and c.user_id not in ($blocked_users)   $query2  GROUP BY c.cllassified_id ORDER BY c.cllassified_id DESC ";exit;
}
   $dataArray = array();
   $counter = 0;
   foreach ($q as $value) {
    foreach ($value as $key => $valueNew) {
     $dataArray[$counter][$key] = $valueNew;
    }
    $counter++;
   }
   $qchekc = $d->selectRow("cllassified_mute", "users_master", "user_id='$user_id' ");
   $muteDataCommon = mysqli_fetch_array($qchekc);
   $user_id_array = array('0');
   $classified_id_array = array('0');
   for ($l = 0; $l < count($dataArray); $l++) {
    $user_id_array[] = $dataArray[$l]['user_id'];
    $classified_id_array[] = $dataArray[$l]['cllassified_id'];
   }
   $classified_id_array = implode(",", $classified_id_array);
   $user_id_array = implode(",", $user_id_array);
   $photo_qry = $d->selectRow("*", "classified_photos_master", "classified_id in ($classified_id_array)   AND user_id in ($user_id_array) ");
   $PArray = array();
   $Pcounter = 0;
   foreach ($photo_qry as $value) {
    foreach ($value as $key => $valueNew) {
     $PArray[$Pcounter][$key] = $valueNew;
    }
    $Pcounter++;
   }
   $photo_array = array();
   for ($pd = 0; $pd < count($PArray); $pd++) {
    $photo_array[$PArray[$pd]['classified_id'] . "__" . $PArray[$pd]['user_id']][] = $PArray[$pd];
   }
   $doc_qry = $d->selectRow("*", "classified_document_master", "classified_id in ($classified_id_array)   AND user_id in ($user_id_array) ");
   $DArray = array();
   $Dcounter = 0;
   foreach ($doc_qry as $value) {
    foreach ($value as $key => $valueNew) {
     $DArray[$Dcounter][$key] = $valueNew;
    }
    $Dcounter++;
   }
   $doc_array = array();
   for ($pd = 0; $pd < count($DArray); $pd++) {
    $doc_array[$DArray[$pd]['classified_id'] . "__" . $DArray[$pd]['user_id']][] = $DArray[$pd];
   }
   $user_qry = $d->selectRow("*", "users_master", " user_id in ($user_id_array) ");
   $UArray = array();
   $Ucounter = 0;
   foreach ($user_qry as $value) {
    foreach ($value as $key => $valueNew) {
     $UArray[$Ucounter][$key] = $valueNew;
    }
    $Ucounter++;
   }
   $user_array = array();
   $city_id_array = array('0');
   for ($pd = 0; $pd < count($UArray); $pd++) {
    $user_array[$UArray[$pd]['user_id']] = $UArray[$pd];
    $city_id_array[] = $UArray[$pd]['city_id'];
   }
   $city_id_array = implode(",", $city_id_array);
   $city_qry = $d->selectRow("city_name,city_id", "cities", " city_id in ($city_id_array) ");
   $city_array = array('0');
   while ($city_data = mysqli_fetch_array($city_qry)) {
    $city_array[$city_data['city_id']] = $city_data['city_name'];
   }
   $classified_user_save_master = $d->selectRow("classified_id", "classified_user_save_master", "user_id='$user_id'  ", "");
   $classified_timeline_array = array('0');
   while ($tclassified_user_save_master_data = mysqli_fetch_array($classified_user_save_master)) {
    $classified_timeline_array[] = $tclassified_user_save_master_data['classified_id'];
   }
   if (count($dataArray) > 0) {
    $response["discussion"] = array();
    /*while ($data = mysqli_fetch_array($q)) {*/
    for ($l = 0; $l < count($dataArray); $l++) {
     $data = $dataArray[$l];
     $discussion = array();
     if (in_array($data[cllassified_id], $classified_timeline_array)) {
      $discussion["is_saved"] = true;
     } else {
      $discussion["is_saved"] = false;
     }
     $discussion["classified_photos"] = array();
     if ($data['cllassified_photo'] != '') {
      $classified_photos1 = array();
      $classified_photos1["photo_name"] = $base_url . 'img/cllassified/' . $data['cllassified_photo'];
      $classified_photos1["classified_img_height"] = "";
      $classified_photos1["classified_img_width"] = "";
      array_push($discussion["classified_photos"], $classified_photos1);
     }
     $p_data_arr = $photo_array[$data[cllassified_id] . "__" . $data['user_id']];
     for ($pda = 0; $pda < count($p_data_arr); $pda++) {
      $ClsData = $p_data_arr[$pda];
      $classified_photos = array();
      if ($ClsData['photo_name'] != "") {
       $classified_photos["photo_name"] = $base_url . "img/cllassified/" . $ClsData['photo_name'];
      } else {
       $classified_photos["photo_name"] = "";
      }
      $classified_photos["classified_img_height"] = $ClsData['classified_img_height'];
      $classified_photos["classified_img_width"] = $ClsData['classified_img_width'];
      array_push($discussion["classified_photos"], $classified_photos);
     }
     $discussion["classified_docs"] = array();
     if ($data['cllassified_photo'] != '') {
      $classified_docs1 = array();
      $classified_docs1["document_name"] = $base_url . 'img/cllassified/' . $data['cllassified_file'];
      array_push($discussion["classified_docs"], $classified_docs1);
     }
     $d_data_arr = $doc_array[$data[cllassified_id] . "__" . $data['user_id']];
     for ($pda = 0; $pda < count($d_data_arr); $pda++) {
      $ClsDData = $d_data_arr[$pda];
      $classified_docs = array();
      if ($ClsDData['document_name'] != "") {
       $classified_docs["document_name"] = $base_url . "img/cllassified/docs/" . $ClsDData['document_name'];
      } else {
       $classified_docs["document_name"] = "";
      }
      array_push($discussion["classified_docs"], $classified_docs);
     }
     $qch22 = $d->select("user_block_master", "user_id='$user_id' AND block_by='$data[user_id]' ");
     if ($data['classified_audio'] != "") {
      $discussion["classified_audio"] = $base_url . "img/cllassified/audio/" . $data['classified_audio'];
     } else {
      $discussion["classified_audio"] = "";
     }
     $user_data_arr = $user_array[$data['user_id']];
     if ($user_data_arr['user_profile_pic'] != "") {
      $discussion["user_profile_pic"] = $base_url . "img/users/members_profile/" . $user_data_arr['user_profile_pic'];
     } else {
      $discussion["user_profile_pic"] = "";
     }
     $discussion["user_full_name"] = $user_data_arr['user_full_name'];
     $discussion["short_name"] = strtoupper(substr($user_data_arr["user_first_name"], 0, 1) . substr($user_data_arr["user_last_name"], 0, 1));
     $discussion["user_mobile"] = $user_data_arr['user_mobile'];
     $discussion["user_city"] = $city_array[$user_data_arr['city_id']];
     $discussion["cllassified_id"] = $data['cllassified_id'];
     $discussion["business_category_id"] = $data['business_category_id'];
     $discussion["business_sub_category_id"] = $data['business_sub_category_id'];
     $discussion["category_array"] = array();
     $fi1 = $d->selectRow(
      "business_categories.business_category_id,business_categories.category_name",
      "classified_category_master,business_categories",
      "business_categories.business_category_id=classified_category_master.business_category_id AND  classified_category_master.classified_id='$data[cllassified_id]' "
     );
     while ($feeData1 = mysqli_fetch_array($fi1)) {
      $category_array = array();
      $category_array["business_category_id"] = $feeData1['business_category_id'];
      $category_array["category_name"] = $feeData1['category_name'];
      array_push($discussion["category_array"], $category_array);
     }
     $discussion["sub_category_array"] = array();
     $fi1 = $d->selectRow(
      "business_sub_categories.business_sub_category_id,business_sub_categories.sub_category_name",
      "classified_category_master,business_sub_categories",
      "business_sub_categories.business_sub_category_id=classified_category_master.business_sub_category_id AND  classified_category_master.classified_id='$data[cllassified_id]' "
     );
     while ($feeData1 = mysqli_fetch_array($fi1)) {
      $sub_category_array = array();
      $sub_category_array["business_sub_category_id"] = $feeData1['business_sub_category_id'];
      $sub_category_array["sub_category_name"] = $feeData1['sub_category_name'];
      array_push($discussion["sub_category_array"], $sub_category_array);
     }
     $discussion["cllassified_title"] = html_entity_decode($data['cllassified_title']);
     $discussion["cllassified_description"] = html_entity_decode($data['cllassified_description']);
     $discussion["user_id"] = html_entity_decode($data['user_id']);
    //$discussion["created_date"]             = date('d M Y', strtotime($data['created_date']));
     if (strtotime($data['created_date']) < strtotime('-30 days')) {
      $discussion["created_date"] = date("j M Y", strtotime($data['created_date']));
     } else {
      $discussion["created_date"] = time_elapsed_string($data['created_date']);
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
     $fi = $d->select(
      "cllassifieds_city_master,cities",
      "cities.city_id=cllassifieds_city_master.city_id AND  cllassifieds_city_master.cllassified_id='$data[cllassified_id]' "
     );
     while ($feeData = mysqli_fetch_array($fi)) {
      $city = array();
      $city["city_id"] = $feeData['city_id'];
      $city["city_name"] = $feeData['city_name'];
      array_push($discussion["city"], $city);
     }
     $q111 = $d->select("users_master", "user_id='$data[user_id]'", "");
     $userdata = mysqli_fetch_array($q111);
     $created_by = $userdata['user_full_name'];
     $user_profile = $base_url . "img/users/members_profile/" . $userdata['user_profile_pic'];
     if ($userdata['user_profile_pic'] == "") {
      $discussion["user_profile"] = "";
     } else {
      $discussion["user_profile"] = $user_profile;
     }
     $discussion["created_by"] = html_entity_decode($created_by);
     $qc11 = $d->select("cllassified_mute", "user_id='$user_id' AND cllassified_id='$data[cllassified_id]'");
     if (mysqli_num_rows($qc11) > 0) {
      $discussion["mute_status"] = true;
     } else {
      $discussion["mute_status"] = false;
     }
     $discussion["total_coments"] = $d->count_data_direct("comment_id", "cllassified_comment", "cllassified_id='$data[cllassified_id]' AND prent_comment_id=0") . '';
     $discussion["comment"] = array();
     $q3 = $d->select("cllassified_comment", "cllassified_id='$data[cllassified_id]' AND prent_comment_id=0", "ORDER BY comment_id   DESC");
     while ($subData = mysqli_fetch_array($q3)) {
      $comment = array();
      $comment["comment_id"] = $subData['comment_id'];
      $comment["user_id"] = $subData['user_id'];
      $comment["comment_messaage"] = html_entity_decode($subData['comment_messaage']);
      $comment["comment_created_date"] = time_elapsed_string($subData['created_date']);
      $q111 = $d->select("users_master", "user_id='$subData[user_id]'", "");
      $userdataComment = mysqli_fetch_array($q111);
      $created_by = $userdataComment['user_full_name'];
      $comment["created_by"] = $created_by;
      array_push($discussion["comment"], $comment);
     }
     if (mysqli_num_rows($qch22) == 0) {
      array_push($response["discussion"], $discussion);
     }
    }
    $response["cllassified_mute"] = $muteDataCommon['cllassified_mute'];
    $response["message"] = "Classified Data";
    $response["status"] = "200";
    echo json_encode($response);
   } else {
    $response["message"] = "No Classifieds Available";
    $response["status"] = "201";
    echo json_encode($response);
   }

  