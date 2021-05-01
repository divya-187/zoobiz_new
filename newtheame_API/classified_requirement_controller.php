    <?php
    include_once 'lib.php';
    if (isset($_POST) && !empty($_POST)) {
    if ($key == $keydb) {
      $response = array();
      extract(array_map("test_input", $_POST));
      $today = date("Y-m-d");
      if ($_POST['getCllassifiedNew'] == "getCllassifiedNew" && filter_var($user_id, FILTER_VALIDATE_INT) == true) {
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
        if ($state_id != 0) {
          $atchQueryCity = "cllassifieds_city_master.state_id ='$state_id'";
          array_push($queryAry, $atchQueryCity);
        }
        if ($city_id != 0) {
          $cityIdAry = explode(",", $city_id);
          $ids = join("','", $cityIdAry);
          $atchQueryCity = "cllassifieds_city_master.city_id IN ('$ids')";
          array_push($queryAry, $atchQueryCity);
        }
        $query2 = "";
        if ($city_id != 0) {
          $query2 .= " and  cllassifieds_city_master.city_id IN ('$ids')";
        }
        $appendQuery = implode(" AND ", $queryAry);
        $q = $d->select(
          "cllassifieds_master,cllassifieds_city_master,users_master",
          "users_master.user_id =cllassifieds_master.user_id AND users_master.active_status=0 and  cllassifieds_master.active_status=0  AND cllassifieds_master.cllassified_id=cllassifieds_city_master.cllassified_id and cllassifieds_master.user_id not in ($blocked_users)   $query2  /*$appendQuery*/",
          "GROUP BY cllassifieds_master.cllassified_id ORDER BY cllassifieds_master.cllassified_id DESC "
        );
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
                list($width1, $height1) = getimagesize($base_url . 'img/cllassified/' . $data['cllassified_photo']);
                $classified_photos1["classified_img_height"] = (string)$width1;
                $classified_photos1["classified_img_width"] = (string)$height1;
    /*  $classified_photos1["classified_img_height"] = "";
    $classified_photos1["classified_img_width"] = "";*/
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
    if ($data['cllassified_file'] != '') {
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
    } else if ($_POST['getCllassifiedSearchNew'] == "getCllassifiedSearchNew" && filter_var($user_id, FILTER_VALIDATE_INT) == true) {
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
    /* if ($city_id != 0) {
    $query2 .= " and  cllassifieds_city_master.city_id IN ('$ids')";
    }*/
    $catSearch = '';
    $subCatSearch = '';
    $citiesSearch = '';
    if (trim($search) != '') {
    $search = trim($search);
    $query2 .= " and  ( c.cllassified_title LIKE '%$search%'    or c.cllassified_description LIKE '%$search%'  or users_master.user_full_name LIKE '%$search%'  or (business_categories.business_category_id = cc.business_category_id  or  business_sub_categories.business_sub_category_id = cc.business_sub_category_id) or (cities.city_id = cm.city_id )  ) ";
    $catSearch = " and  (  business_categories.category_name LIKE '%$search%'  ) ";
    $subCatSearch = " and  (  business_sub_categories.sub_category_name LIKE '%$search%'  ) ";
    $citiesSearch = " and  (  cities.city_name LIKE '%$search%'  ) ";
    }
    $appendQuery = implode(" AND ", $queryAry);
    $q = $d->selectRow(
    "cm.*,c.*,business_categories.category_name,business_sub_categories.sub_category_name,cc.business_category_id ,cc.business_sub_category_id ","users_master, cllassifieds_master AS c LEFT JOIN classified_category_master cc ON c.cllassified_id = cc.classified_id LEFT JOIN cllassifieds_city_master cm ON cm.cllassified_id = c.cllassified_id  left join business_categories on business_categories.business_category_id = cc.business_category_id $catSearch left join business_sub_categories on   business_sub_categories.business_sub_category_id = cc.business_sub_category_id  $subCatSearch  left join cities on   cities.city_id = cm.city_id  $citiesSearch  "," c.active_status=0 AND  users_master.user_id = c.user_id  and  c.user_id not in ($blocked_users)   $query2  ",  "GROUP BY c.cllassified_id ORDER BY c.cllassified_id DESC "
    );
    if(isset($debug)){
    echo "users_master, cllassifieds_master AS c LEFT JOIN classified_category_master cc ON c.cllassified_id = cc.classified_id LEFT JOIN cllassifieds_city_master cm ON cm.cllassified_id = c.cllassified_id  left join business_categories on business_categories.business_category_id = cc.business_category_id $catSearch left join business_sub_categories on   business_sub_categories.business_sub_category_id = cc.business_sub_category_id  $subCatSearch  left join cities on   cities.city_id = cm.city_id  $citiesSearch  ";
    echo  " c.active_status=0 AND  users_master.user_id = c.user_id  and  c.user_id not in ($blocked_users)   $query2  GROUP BY c.cllassified_id ORDER BY c.cllassified_id DESC ";exit;
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
          list($width1, $height1) = getimagesize($base_url . 'img/cllassified/' . $data['cllassified_photo']);
          $classified_photos1["classified_img_height"] = (string)$width1;
          $classified_photos1["classified_img_width"] = (string)$height1;
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
        if ($data['cllassified_file'] != '') {
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
    }  else if ($_POST['getCllassifiedSearchCityNew'] == "getCllassifiedSearchCityNew" && filter_var($user_id, FILTER_VALIDATE_INT) == true) {
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
    $city_id = explode(",", $city_id);
    $city_id = implode(",", $city_id);
    if ( count($city_id) > 0 && !empty($city_id) )  {
      $query2 .= " and  cllassifieds_city_master.city_id IN ($city_id)";
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
            list($width1, $height1) = getimagesize($base_url . 'img/cllassified/' . $data['cllassified_photo']);
            $classified_photos1["classified_img_height"] = (string)$width1;
            $classified_photos1["classified_img_width"] = (string)$height1;
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
          if ($data['cllassified_file'] != '') {
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

    }  else if ($_POST['getCllassifiedSearchCategoryNew'] == "getCllassifiedSearchCategoryNew" && filter_var($user_id, FILTER_VALIDATE_INT) == true) {
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

      $business_category_id = explode(",", $business_category_id);
      $business_category_id = implode(",", $business_category_id);
      $business_sub_category_id = explode(",", $business_sub_category_id);
      $business_sub_category_id = implode(",", $business_sub_category_id);
      $queryAry = array();
      $query2 = "";
      if ( count($business_category_id) > 0 && !empty($business_category_id) )  {
        $query2 .= " and  ( cc.business_category_id IN ($business_category_id)";
        if ( count($business_sub_category_id) > 0 && !empty($business_sub_category_id) )  {
          $query2 .= " and   cc.business_sub_category_id IN ($business_sub_category_id)";
        }
        $query2 .= " )";
      }

      $catSearch = '';
      $subCatSearch = '';
      $citiesSearch = '';
      if (trim($search) != '') {
        $search = trim($search);
        $query2 .= " and  ( c.cllassified_title LIKE '%$search%'    or c.cllassified_description LIKE '%$search%' or (business_categories.business_category_id = cc.business_category_id  or  business_sub_categories.business_sub_category_id = cc.business_sub_category_id) or (cities.city_id = cm.city_id )  ) ";
        $catSearch = " and  (  business_categories.category_name LIKE '%$search%'  ) ";
        $subCatSearch = " and  (  business_sub_categories.sub_category_name LIKE '%$search%'  ) ";
        $citiesSearch = " and  (  cities.city_name LIKE '%$search%'  ) ";
      }
      $appendQuery = implode(" AND ", $queryAry);
      $q = $d->selectRow(
        "cm.*,c.*,business_categories.category_name,business_sub_categories.sub_category_name,cc.business_category_id ,cc.business_sub_category_id ","cllassifieds_master AS c LEFT JOIN classified_category_master cc ON c.cllassified_id = cc.classified_id LEFT JOIN cllassifieds_city_master cm ON cm.cllassified_id = c.cllassified_id  left join business_categories on business_categories.business_category_id = cc.business_category_id $catSearch left join business_sub_categories on   business_sub_categories.business_sub_category_id = cc.business_sub_category_id  $subCatSearch  left join cities on   cities.city_id = cm.city_id  $citiesSearch  "," c.active_status=0 AND  c.user_id not in ($blocked_users)   $query2  ",  "GROUP BY c.cllassified_id ORDER BY c.cllassified_id DESC "
      );
      if(isset($debug)){
        echo "cllassifieds_master AS c LEFT JOIN classified_category_master cc ON c.cllassified_id = cc.classified_id LEFT JOIN cllassifieds_city_master cm ON cm.cllassified_id = c.cllassified_id  left join business_categories on business_categories.business_category_id = cc.business_category_id $catSearch left join business_sub_categories on   business_sub_categories.business_sub_category_id = cc.business_sub_category_id  $subCatSearch  left join cities on   cities.city_id = cm.city_id  $citiesSearch  ";
        echo  " c.active_status=0 AND  c.user_id not in ($blocked_users)     $query2  GROUP BY c.cllassified_id ORDER BY c.cllassified_id DESC ";exit;
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
              list($width1, $height1) = getimagesize($base_url . 'img/cllassified/' . $data['cllassified_photo']);
              $classified_photos1["classified_img_height"] = (string)$width1;
              $classified_photos1["classified_img_width"] = (string)$height1;
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
            if ($data['cllassified_file'] != '') {
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

      } else   if ($_POST['getSelectedClassified'] == "getSelectedClassified" && filter_var($user_id, FILTER_VALIDATE_INT) == true && filter_var($cllassified_id, FILTER_VALIDATE_INT) == true) {
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
        if ($state_id != 0) {
          $atchQueryCity = "cllassifieds_city_master.state_id ='$state_id'";
          array_push($queryAry, $atchQueryCity);
        }
        if ($city_id != 0) {
          $cityIdAry = explode(",", $city_id);
          $ids = join("','", $cityIdAry);
          $atchQueryCity = "cllassifieds_city_master.city_id IN ('$ids')";
          array_push($queryAry, $atchQueryCity);
        }
        $query2 = "";
        if ($city_id != 0) {
          $query2 .= " and  cllassifieds_city_master.city_id IN ('$ids')";
        }
        $appendQuery = implode(" AND ", $queryAry);
        $q = $d->select(
          "cllassifieds_master,cllassifieds_city_master,users_master",
          "users_master.user_id =cllassifieds_master.user_id AND users_master.active_status=0 and  cllassifieds_master.active_status=0  AND cllassifieds_master.cllassified_id=cllassifieds_city_master.cllassified_id and cllassifieds_master.user_id not in ($blocked_users)  and cllassifieds_master.cllassified_id ='$cllassified_id'  $query2  /*$appendQuery*/",
          "GROUP BY cllassifieds_master.cllassified_id ORDER BY cllassifieds_master.cllassified_id DESC "
        );
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
                list($width1, $height1) = getimagesize($base_url . 'img/cllassified/' . $data['cllassified_photo']);
                $classified_photos1["classified_img_height"] = (string)$width1;
                $classified_photos1["classified_img_width"] = (string)$height1;
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
              if ($data['cllassified_file'] != '') {
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
        } else if ($_POST['getSavedCllassified'] == "getSavedCllassified" && filter_var($user_id, FILTER_VALIDATE_INT) == true) {
          $classified_user_save_master = $d->selectRow("classified_id", "classified_user_save_master", "user_id='$user_id'  ", "");
          $classified_timeline_array = array('0');
          while ($tclassified_user_save_master_data = mysqli_fetch_array($classified_user_save_master)) {
            $classified_timeline_array[] = $tclassified_user_save_master_data['classified_id'];
          }
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
          if ($state_id != 0) {
            $atchQueryCity = "cllassifieds_city_master.state_id ='$state_id'";
            array_push($queryAry, $atchQueryCity);
          }
          if ($city_id != 0) {
            $cityIdAry = explode(",", $city_id);
            $ids = join("','", $cityIdAry);
            $atchQueryCity = "cllassifieds_city_master.city_id IN ('$ids')";
            array_push($queryAry, $atchQueryCity);
          }
          $query2 = "";
          if ($city_id != 0) {
            $query2 .= " and  cllassifieds_city_master.city_id IN ('$ids')";
          }
          $appendQuery = implode(" AND ", $queryAry);
          $saved_cls_array = implode(",", $classified_timeline_array);
          $q = $d->select(
            "cllassifieds_master,cllassifieds_city_master,users_master",
            "users_master.user_id =cllassifieds_master.user_id AND users_master.active_status=0 and  cllassifieds_master.active_status=0  AND cllassifieds_master.cllassified_id=cllassifieds_city_master.cllassified_id and cllassifieds_master.user_id not in ($blocked_users) and cllassifieds_master.cllassified_id in ($saved_cls_array)  $query2  /*$appendQuery*/",
            "GROUP BY cllassifieds_master.cllassified_id ORDER BY cllassifieds_master.cllassified_id DESC "
          );
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
                  list($width1, $height1) = getimagesize($base_url . 'img/cllassified/' . $data['cllassified_photo']);
                  $classified_photos1["classified_img_height"] = (string)$width1;
                  $classified_photos1["classified_img_width"] = (string)$height1;
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
                if ($data['cllassified_file'] != '') {
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
          } else if ($_POST['getCommentsNew'] == "getCommentsNew" && filter_var($user_id, FILTER_VALIDATE_INT) == true && filter_var($classified_id, FILTER_VALIDATE_INT) == true) {
            $qcomment = $d->selectRow(
              "users_master.user_profile_pic,users_master.user_full_name,users_master.user_first_name,users_master.user_last_name, cllassified_comment.*  ",
              "cllassified_comment,users_master,user_employment_details",
              " user_employment_details.user_id = users_master.user_id and cllassified_comment.cllassified_id='$classified_id' AND cllassified_comment.user_id=users_master.user_id AND cllassified_comment.prent_comment_id=0",
              "ORDER BY cllassified_comment.cllassified_id DESC"
            );
    //code opt start
            $CArray = array();
            $Ccounter = 0;
            foreach ($qcomment as $value) {
              foreach ($value as $key => $valueNew) {
                $CArray[$Ccounter][$key] = $valueNew;
              }
              $Ccounter++;
            }
            $cllassified_id_array = array('0');
            $comment_id_array = array('0');
            for ($l = 0; $l < count($CArray); $l++) {
              $cllassified_id_array[] = $CArray[$l]['cllassified_id'];
              $comment_id_array[] = $CArray[$l]['comment_id'];
            }
            $cllassified_id_array = implode(",", $cllassified_id_array);
            $comment_id_array = implode(",", $comment_id_array);
            $sub_q = $d->selectRow(
              "users_master.user_profile_pic,users_master.user_full_name,users_master.user_first_name,users_master.user_last_name, cllassified_comment.*",
              "cllassified_comment,users_master ",
              "  cllassified_comment.cllassified_id in ($cllassified_id_array) AND cllassified_comment.user_id=users_master.user_id AND cllassified_comment.prent_comment_id in ($comment_id_array) ",
              " group by cllassified_comment.comment_id ORDER BY cllassified_comment.comment_id DESC"
            );
            $SCArray = array();
            $SCcounter = 0;
            foreach ($sub_q as $value) {
              foreach ($value as $key => $valueNew) {
                $SCArray[$SCcounter][$key] = $valueNew;
              }
              $SCcounter++;
            }
            $sub_cmt_array = array();
            for ($l = 0; $l < count($SCArray); $l++) {
              $sub_cmt_array[$SCArray[$l]['cllassified_id'] . "__" . $SCArray[$l]['prent_comment_id']][] = $SCArray[$l];
            }
            if (count($CArray) > 0) {
              $response["comment"] = array();
              for ($mc = 0; $mc < count($CArray); $mc++) {
                $data_comment = $CArray[$mc];
                $comment = array();
                $comment["comment_id"] = $data_comment['comment_id'];
                $comment["cllassified_id"] = $data_comment['cllassified_id'];
                $comment["comment_messaage"] = html_entity_decode($data_comment['comment_messaage']);
                $comment["user_name"] = $data_comment['user_full_name'];
                $comment["user_id"] = $data_comment['user_id'];
                if (strtotime($data_comment['created_date']) < strtotime('-30 days')) {
                  $comment["created_date"] = date("j M Y", strtotime($data_comment['modify_date']));
                } else {
                  $comment["created_date"] = time_elapsed_string($data_comment['created_date']);
                }
                if ($data_comment['user_profile_pic'] != "") {
                  $comment["user_profile_pic"] = $base_url . "img/users/members_profile/" . $data_comment['user_profile_pic'];
                } else {
                  $comment["user_profile_pic"] = "";
                }
                $comment["short_name"] = strtoupper(substr($data_comment["user_first_name"], 0, 1) . substr($data_comment["user_last_name"], 0, 1));
                $comment["sub_comment"] = array();
                $sub_data = $sub_cmt_array[$data_comment['cllassified_id'] . "__" . $data_comment['comment_id']];
    /*  echo $data_comment['cllassified_id']."__".$data_comment['comment_id'];
    echo "<pre>";print_r($sub_cmt_array);exit;*/
    for ($sd = 0; $sd < count($sub_data); $sd++) {
    $subCommentData = $sub_data[$sd];
    $sub_comment = array();
    $sub_comment["comment_id"] = $subCommentData['comment_id'];
    $sub_comment["cllassified_id"] = $subCommentData['cllassified_id'];
    $sub_comment["comment_messaage"] = html_entity_decode($subCommentData['comment_messaage']);
    $sub_comment["user_name"] = $subCommentData['user_full_name'];
    $sub_comment["user_id"] = $subCommentData['user_id'];
    if ($subCommentData['user_profile_pic'] != "") {
     $sub_comment["user_profile_pic"] = $base_url . "img/users/members_profile/" . $subCommentData['user_profile_pic'];
    } else {
     $sub_comment["user_profile_pic"] = "";
    }
    $sub_comment["short_name"] = strtoupper(substr($subCommentData["user_first_name"], 0, 1) . substr($subCommentData["user_last_name"], 0, 1));
    if (strtotime($subCommentData['created_date']) < strtotime('-30 days')) {
     $sub_comment["created_date"] = date("j M Y", strtotime($subCommentData['created_date']));
    } else {
     $sub_comment["created_date"] = time_elapsed_string($subCommentData['created_date']);
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
    } else if ($_POST['saveClassified'] == "saveClassified" && filter_var($user_id, FILTER_VALIDATE_INT) == true && filter_var($classified_id, FILTER_VALIDATE_INT) == true) {
    if (isset($is_save) && $is_save == 'true') {
    $d->delete("classified_user_save_master", "user_id='$user_id' AND classified_id='$classified_id'");
    if ($d == TRUE) {
     $d->insert_myactivity($user_id, "0", "", "Saved Classified Removed", "activity.png");
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
     'classified_id' => $m->get_data('classified_id'), 'user_id' => $m->get_data('user_id'), 'created_at' => $m->get_data('created_at')
    );
    $d->insert("classified_user_save_master", $a1);
    if ($d == TRUE) {
     $d->insert_myactivity($user_id, "0", "", "Classified Saved", "activity.png");
     $response["message"] = "Classified Saved";
     $response["status"] = "200";
     echo json_encode($response);
    } else {
     $response["message"] = "Something Wrong";
     $response["status"] = "201";
     echo json_encode($response);
    }
    }
    } else if (isset($_POST['addCllassifiedNew']) && filter_var($user_id, FILTER_VALIDATE_INT) == true) {
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
    if (!isset($user_name)) {
    $uQry = $d->selectRow("*", "users_master", " user_id='$user_id'", "");
    $uData = mysqli_fetch_array($uQry);
    $user_name = $uData['user_full_name'];
    }
         $newFileNameAaudio = $_FILES['classified_audio']['name']; // rand() . $user_id;
         $dirPathAud = "../img/cllassified/audio/";
         $ext = pathinfo($_FILES['classified_audio']['name'], PATHINFO_EXTENSION);
         move_uploaded_file($_FILES["classified_audio"]["tmp_name"], $dirPathAud . $newFileNameAaudio);
                          //."." . $ext
         $classified_audio = $newFileNameAaudio; //."." . $ext;
         $m->set_data('cllassified_title', $cllassified_title);
         $m->set_data('cllassified_description', $cllassified_description);
         $m->set_data('created_date', date("Y-m-d H:i:s"));
         $m->set_data('user_id', $user_id);
         $m->set_data('business_category_id', $business_category_id);
         $m->set_data('business_sub_category_id', $business_sub_category_id);
         $m->set_data('cllassified_photo', $cllassified_photo);
         $m->set_data('cllassified_file', $cllassified_file);
         $m->set_data('classified_audio', $classified_audio);
         $a = array(
          'cllassified_title' => $m->get_data('cllassified_title'), 'cllassified_description' => $m->get_data('cllassified_description'),
          'classified_audio' => $m->get_data('classified_audio'), 'created_date' => $m->get_data('created_date'), 'user_id' => $m->get_data('user_id'),
          'cllassified_file' => $m->get_data('cllassified_file'), 'business_category_id' => $m->get_data('business_category_id'),
          'business_sub_category_id' => $m->get_data('business_sub_category_id')
        );
                          //8march21
         $q1 = $d->insert("cllassifieds_master", $a);
         $cllassified_id = $con->insert_id;
         $total = count($_FILES['classified_photos']['tmp_name']);
         $total_docs = count($_FILES['classified_docs']['tmp_name']);
         $_POST['business_category_id'] = explode(",", $_POST['business_category_id']);
         $_POST['business_sub_category_id'] = explode(",", $_POST['business_sub_category_id']);
         $total_categories = count($_POST['business_category_id']);
         if ($q1 > 0) {
                              //add multiple categories start
          for ($k = 0; $k < $total_categories; $k++) {
           $a1 = array(
            'classified_id' => $cllassified_id, 'user_id' => $user_id, 'business_category_id' => $_POST['business_category_id'][$k], 'business_sub_category_id' => $_POST['business_sub_category_id'][$k], 'created_at' => date("Y-m-d H:i:s")
          );
           $d->insert("classified_category_master", $a1);
         }
                              //add multiple categories end
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
             if ($ext == '') {
               $ext = 'png';
             }
             $tmp = imageResize($imageSrc, $sourceProperties[0], $sourceProperties[1], $newImageWidth, $newImageHeight);
             imagepng($tmp, $dirPath . $newFileName . "_cls." . $ext);
             break;
             case IMAGETYPE_JPEG:
             $imageSrc = imagecreatefromjpeg($uploadedFile);
             if ($ext == '') {
               $ext = 'jpeg';
             }
             $tmp = imageResize($imageSrc, $sourceProperties[0], $sourceProperties[1], $newImageWidth, $newImageHeight);
             imagejpeg($tmp, $dirPath . $newFileName . "_cls." . $ext);
             break;
             case IMAGETYPE_GIF:
             $imageSrc = imagecreatefromgif($uploadedFile);
             imagegif($tmp, $dirPath . $newFileName . "_cls." . $ext);
             break;
             default:
             $response["message"] = "Invalid Image type.";
             $response["status"] = "201";
             echo json_encode($response);
             exit;
             break;
           }
           if ($ext == '') {
             $ext = 'jpeg';
           }
           $myfilesize = filesize($dirPath . $newFileName . "_cls." . $ext);
           $cls_img = $newFileName . "_cls." . $ext;
           if ($i == 0) {
             $classified_photo = $base_url . '../img/cllassified/' . $cls_img . '.' . $ext;
           }
           $a1 = array(
             'classified_id' => $cllassified_id, 'user_id' => $user_id, 'photo_name' => $cls_img, 'classified_img_height' => $newImageHeight,
             'classified_img_width' => $newImageWidth, 'size' => $myfilesize
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
        $upload = move_uploaded_file($_FILES["classified_docs"]["tmp_name"][$i], $dirPath . $newFileName . "_doc." . $ext);
        $myfilesize = filesize($dirPath . $newFileName . "_doc." . $ext);
        $a1 = array(
         'classified_id' => $cllassified_id, 'user_id' => $user_id, 'document_name' => $newFileName . "_doc." . $ext, 'size' => ($myfilesize)
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
     $aCity = array('cllassified_id' => $cllassified_id, 'city_id' => $cityAry[$i], 'state_id' => $state_id);
     $d->insert("cllassifieds_city_master", $aCity);
    }
    $title = "Classified";
    $description = "New Classified Added By $user_name";

    $d->insertFollowNotificationBelow39($title, $description, $cllassified_id, $user_id,4, "classified");
    $d->insertFollowNotificationabove39($title, $description, $cllassified_id, $user_id, 4, "view_classified_new");

    $d->insertFollowNotificationIos($title, $description, $cllassified_id, $user_id,4, "classified");

          //ANDROID CODE START
    $fcmArrayAndroid = $d->get_android_fcm(
     "users_master,follow_master",
     " users_master.version_code>=39 and users_master.user_id=follow_master.follow_by AND follow_master.follow_to='$user_id' AND users_master.user_token!='' AND  lower(users_master.device) ='android' and users_master.user_id not in ($blocked_users) "
    );
    $idsAndroid = join("','", $fcmArrayAndroid);

    $fcmArray = $d->get_android_fcm(
     "users_master,user_employment_details",
     " users_master.version_code>=39 and  user_employment_details.user_id=users_master.user_id AND user_employment_details.business_category_id='$business_category_id' AND  users_master.user_id!='$user_id' AND users_master.cllassified_mute=0 AND users_master.user_token!='' AND  lower(users_master.device) ='android' OR users_master.user_token IN ('$idsAndroid') AND users_master.cllassified_mute=0 and users_master.user_id not in ($blocked_users) "
    );

    $fcmArrayAndroidFollow = $d->get_android_fcm(
     "users_master,category_follow_master",
     "users_master.version_code>=39 and  users_master.user_id=category_follow_master.user_id AND category_follow_master.category_id='$business_category_id' AND users_master.user_token!='' AND  lower(users_master.device) ='android' and users_master.user_id not in ($blocked_users) "
    );
    $fcmArray = array_merge($fcmArrayAndroidFollow, $fcmArray);
    $nResident->noti("view_classified_new", $notiUrl, 0, $fcmArray, $title, $description, $cllassified_id);

          //VERSION CODE BELOW 39
    $fcmArrayAndroid11 = $d->get_android_fcm(
     "users_master,follow_master",
     " users_master.version_code<=39 and users_master.user_id=follow_master.follow_by AND follow_master.follow_to='$user_id' AND users_master.user_token!='' AND  lower(users_master.device) ='android' and users_master.user_id not in ($blocked_users) "
    );
    $idsAndroid11 = join("','", $fcmArrayAndroid11);

    $fcmArray11 = $d->get_android_fcm(
     "users_master,user_employment_details",
     " users_master.version_code<=39 and  user_employment_details.user_id=users_master.user_id AND user_employment_details.business_category_id='$business_category_id' AND  users_master.user_id!='$user_id' AND users_master.cllassified_mute=0 AND users_master.user_token!='' AND  lower(users_master.device) ='android' OR users_master.user_token IN ('$idsAndroid11') AND users_master.cllassified_mute=0 and users_master.user_id not in ($blocked_users) "
    );

    $fcmArrayAndroidFollow11 = $d->get_android_fcm(
     "users_master,category_follow_master",
     "users_master.version_code<=39 and  users_master.user_id=category_follow_master.user_id AND category_follow_master.category_id='$business_category_id' AND users_master.user_token!='' AND  lower(users_master.device) ='android' and users_master.user_id not in ($blocked_users) "
    );
    $fcmArray11 = array_merge($fcmArrayAndroidFollow11, $fcmArray11);
    $nResident->noti("viewClassified", $notiUrl, 0, $fcmArray11, $title, $description, $cllassified_id);
          //ANDROID CODE END
          //IOS CODE START
    $fcmArrayIos = $d->get_android_fcm(
     "users_master,follow_master",
     "users_master.user_id=follow_master.follow_by AND follow_master.follow_to='$user_id' AND users_master.user_token!='' AND  lower(users_master.device)='ios' and users_master.user_id not in ($blocked_users)  "
    );
    $idsIos = join("','", $fcmArrayIos);
    $fcmArrayIos = $d->get_android_fcm(
     "users_master,user_employment_details",
     "user_employment_details.user_id=users_master.user_id AND user_employment_details.business_category_id='$business_category_id' AND  users_master.user_id!='$user_id' AND users_master.cllassified_mute=0 AND users_master.user_token!='' AND  lower(users_master.device)='ios' OR users_master.user_token IN ('$idsIos') AND users_master.cllassified_mute=0 and users_master.user_id not in ($blocked_users) "
    );

    $fcmArrayIosFollow = $d->get_android_fcm(
     "users_master,category_follow_master",
     "users_master.user_id=category_follow_master.user_id AND category_follow_master.category_id='$business_category_id' AND users_master.user_token!='' AND  lower(users_master.device) ='ios' and users_master.user_id not in ($blocked_users) "
    );
    $fcmArrayIos = array_merge($fcmArrayIosFollow, $fcmArrayIos);
    $nResident->noti_ios("view_classified_new", $notiUrl, 0, $fcmArrayIos, $title, $description, $cllassified_id);
          //IOS CODE END                  
    $response["message"] = "Classified Added";
    $response["status"] = '200';
    echo json_encode($response);
    } else {
    $response["message"] = "Something Wrong.";
    $response["status"] = '201';
    echo json_encode($response);
    }
    } else if (isset($_POST['addCllassifiedCommentNew']) && filter_var($user_id, FILTER_VALIDATE_INT) == true) {
    $m->set_data('cllassified_id', $cllassified_id);
    $m->set_data('comment_messaage', $comment_messaage);
    $m->set_data('created_date', date("Y-m-d H:i:s"));
    $m->set_data('user_id', $user_id);
    $a = array(
    'cllassified_id' => $m->get_data('cllassified_id'), 'comment_messaage' => $m->get_data('comment_messaage'), 'created_date' => $m->get_data('created_date'),
    'user_id' => $m->get_data('user_id')
    );
    $q1 = $d->insert("cllassified_comment", $a);
    $comment_messaage = html_entity_decode($comment_messaage);
    if ($q1 > 0) {
                              //23oct2020
    $cllassifieds_master = $d->select("cllassifieds_master", "cllassified_id='$cllassified_id'");
    $cllassifieds_master_data = mysqli_fetch_array($cllassifieds_master);
    $classified_user_id = $cllassifieds_master_data['user_id'];
    $cllassified_title = $cllassifieds_master_data['cllassified_title'];


    $users_master_qry = $d->selectRow("*", "users_master", "user_id='$classified_user_id'");
    $uDetails = mysqli_fetch_array($users_master_qry);
    $notification_action ="classified";
    if($uDetails['version_code'] >=39){
      $notification_action ="view_classified_new_comment";
    }

    $notiAry = array(
     'user_id' => $classified_user_id,
     'other_user_id' => $user_id,
     'timeline_id' => $cllassified_id,
     'notification_type' => 4,
     'notification_title' => "Comment On Classified By $user_name",
     'notification_desc' => "Comment: $comment_messaage",
     'notification_date' => date('Y-m-d H:i'),
     'notification_action' => $notification_action,
     'notification_logo' => 'menu_fourm.png'
    );
    if ($classified_user_id != $user_id) {
     $d->insert("user_notification", $notiAry);
    }
    $muteArray = array();
    $qc11 = $d->select("cllassified_mute", "cllassified_id='$cllassified_id'");
    while ($muteData = mysqli_fetch_array($qc11)) {
     array_push($muteArray, $muteData['user_id']);
    }
    $qct = $d->selectRow("business_category_id", "cllassifieds_master", "cllassified_id='$cllassified_id'");
    $cData = mysqli_fetch_array($qct);
    $business_category_id = $cData['business_category_id'];
    $ids = join("','", $muteArray);

           //android start                  
    $fcmArray = $d->get_android_fcm(
     "users_master",
     " version_code>=39 and user_id='$classified_user_id' and user_token!='' and lower(device)='android' AND  user_id!='$user_id' and  cllassified_mute=0    "
    );
    $nResident->noti("view_classified_new_comment","",0,$fcmArray,"Comment On Classified By $user_name","Comment: $comment_messaage",$cllassified_id);


    $fcmArray11 = $d->get_android_fcm(
     "users_master",
     " version_code<=39 and user_id='$classified_user_id' and user_token!='' and lower(device)='android' AND  user_id!='$user_id' and  cllassified_mute=0    "
    );
    $nResident->noti("viewClassified","",0,$fcmArray11,"Comment On Classified By $user_name","Comment: $comment_messaage",$cllassified_id);

          //ios start
    $fcmArrayIos = $d->get_android_fcm(
     "users_master ",
     " user_id='$classified_user_id' and     user_token!='' AND  lower(device)='ios'  AND  user_id!='$user_id' and cllassified_mute=0    "
    );
    $nResident->noti_ios("view_classified_new_comment", "", 0,$fcmArrayIos,"Comment On Classified By $user_name","Comment: $comment_messaage",$cllassified_id);

    $response["message"] = "Comment Added";
    $response["status"] = '200';
    echo json_encode($response);
    } else {
    $response["message"] = "Something Wrong.";
    $response["status"] = '201';
    echo json_encode($response);
    }
    } else if (isset($_POST['addReplyCommentNew']) && filter_var($user_id, FILTER_VALIDATE_INT) == true && filter_var($comment_id, FILTER_VALIDATE_INT) == true) {
    $m->set_data('prent_comment_id', $comment_id);
    $m->set_data('cllassified_id', $cllassified_id);
    $m->set_data('comment_messaage', $comment_messaage);
    $m->set_data('created_date', date("Y-m-d H:i:s"));
    $m->set_data('user_id', $user_id);
    $a = array(
    'prent_comment_id' => $m->get_data('prent_comment_id'), 'cllassified_id' => $m->get_data('cllassified_id'), 'comment_messaage' => $m->get_data('comment_messaage'),
    'created_date' => $m->get_data('created_date'), 'user_id' => $m->get_data('user_id')
    );
    $q1 = $d->insert("cllassified_comment", $a);
    $comment_id11 = $con->insert_id;
    $comment_messaage = html_entity_decode($comment_messaage);
    if ($q1 > 0) {
    $q111 = $d->selectRow("user_full_name,salutation", "users_master", "user_id='$user_id'");
    $userdataComment = mysqli_fetch_array($q111);
    $user_name = $userdataComment['user_full_name'];
    $qct = $d->select("cllassified_comment", "cllassified_id='$cllassified_id' AND comment_id='$comment_id'");
    $comentUser = mysqli_fetch_array($qct);
    $comment_user_id = $comentUser['user_id'];


    $users_master_qry = $d->selectRow("*", "users_master", "user_id='$comment_user_id'");
    $uDetails = mysqli_fetch_array($users_master_qry);
    $notification_action ="classified";
    if($uDetails['version_code'] >=39){
      $notification_action ="view_classified_new_comment";
    }

    $notiAry = array(
     'user_id' => $comment_user_id,
     'other_user_id' => $user_id,
     'timeline_id' => $cllassified_id,
     'notification_type' => 4,
     'notification_title' => "Comment Reply By $user_name",
     'notification_desc' => "Comment: $comment_messaage",
     'notification_date' => date('Y-m-d H:i'),
     'notification_action' => $notification_action,
     'notification_logo' => 'menu_fourm.png'
    );
    $cllassifieds_master2 = $d->select("cllassifieds_master", "cllassified_id='$cllassified_id'");
    $cllassifieds_master_data2 = mysqli_fetch_array($cllassifieds_master2);
    $classified_user_id2 = $cllassifieds_master_data2['user_id'];
    if ($classified_user_id2 != $user_id) {
     $d->insert("user_notification", $notiAry);
    }
    $muteArray = array();
    $qc11 = $d->select("cllassified_mute", "cllassified_id='$cllassified_id'");
    while ($muteData = mysqli_fetch_array($qc11)) {
     array_push($muteArray, $muteData['user_id']);
    }
    $qct = $d->selectRow("business_category_id", "cllassifieds_master", "cllassified_id='$cllassified_id'");
    $cData = mysqli_fetch_array($qct);
    $business_category_id = $cData['business_category_id'];
    $ids = join("','", $muteArray);

          //android
    $fcmArray = $d->get_android_fcm("users_master"," version_code>=39 and  cllassified_mute=0 AND user_id='$comment_user_id' AND user_token!='' AND  lower(device)='android' AND user_id!='$user_id'"
    );
    $nResident->noti("view_classified_new_comment","",$society_id,$fcmArray,"Comment Reply By $user_name","Reply: $comment_messaage",$cllassified_id);


    $fcmArray11 = $d->get_android_fcm("users_master"," version_code<=39 and  cllassified_mute=0 AND user_id='$comment_user_id' AND user_token!='' AND  lower(device)='android' AND user_id!='$user_id'"
    );
    $nResident->noti("viewClassified","",$society_id,$fcmArray11,"Comment Reply By $user_name","Reply: $comment_messaage",$cllassified_id);

         //ios code
    $fcmArrayIos = $d->get_android_fcm("users_master","  cllassified_mute=0 AND user_id='$comment_user_id'  AND user_token!='' AND  lower(device) ='ios' AND user_id!='$user_id'"
    );
    $nResident->noti_ios("view_classified_new_comment","",$society_id,$fcmArrayIos,"Comment Reply By $user_name","Reply: $comment_messaage",$cllassified_id);
    $response["comment_id"] = $comment_id11;
    $response["message"] = "Comment Reply Added";
    $response["status"] = '200';
    echo json_encode($response);
    } else {
    $response["message"] = "Something Wrong.";
    $response["status"] = '201';
    echo json_encode($response);
    }
    } else if (isset($_POST['addMuteNew']) && filter_var($user_id, FILTER_VALIDATE_INT) == true && filter_var($cllassified_id, FILTER_VALIDATE_INT) == true) {
    $m->set_data('cllassified_id', $cllassified_id);
    $m->set_data('user_id', $user_id);
    $a = array('cllassified_id' => $m->get_data('cllassified_id'), 'user_id' => $m->get_data('user_id'));
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
    $q1 = $d->delete("cllassified_mute", "user_id='$user_id' AND cllassified_id='$cllassified_id'");
    }
    if ($q1 > 0) {
    $response["status"] = '200';
    echo json_encode($response);
    } else {
    $response["message"] = "Something Wrong.";
    $response["status"] = '201';
    echo json_encode($response);
    }
    } else if ($_POST['muteAllDiscussion'] == "muteAllDiscussion" && filter_var($user_id, FILTER_VALIDATE_INT) == true && filter_var($user_mobile, FILTER_VALIDATE_INT) == true) {
    $m->set_data('cllassified_mute', $cllassified_mute);
    $a = array('cllassified_mute' => $m->get_data('cllassified_mute'));
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
    $response["status"] = "201";
    echo json_encode($response);
    }
    } else if (isset($_POST['deleteCllassifiedNew']) && filter_var($user_id, FILTER_VALIDATE_INT) == true && filter_var($cllassified_id, FILTER_VALIDATE_INT) == true) {
    $q1 = $d->delete("cllassifieds_master", "cllassified_id='$cllassified_id' AND user_id='$user_id'");
    if ($q1 > 0) {
    $d->delete("cllassified_comment", "cllassified_id='$cllassified_id' ");
    $d->delete("cllassifieds_city_master", "cllassified_id='$cllassified_id' ");
    $response["message"] = "Classified Deleted";
    $response["status"] = '200';
    echo json_encode($response);
    } else {
    $response["message"] = "Something Wrong.";
    $response["status"] = '201';
    echo json_encode($response);
    }
    } else if (isset($_POST['deleteCommentNew']) && filter_var($user_id, FILTER_VALIDATE_INT) == true && filter_var($comment_id, FILTER_VALIDATE_INT) == true) {
    $q1 = $d->delete("cllassified_comment", "comment_id='$comment_id' AND user_id='$user_id'");
    if ($q1 > 0) {
    $q1 = $d->delete("cllassified_comment", "prent_comment_id='$comment_id' AND user_id='$user_id'");
    $response["message"] = "Comment Deleted";
    $response["status"] = '200';
    echo json_encode($response);
    } else {
    $response["message"] = "Something Wrong.";
    $response["status"] = '201';
    echo json_encode($response);
    }
    } else {
    $response["message"] = "wrong tag";
    $response["status"] = "201";
    echo json_encode($response);
    }
    } else {
    $response["message"] = "wrong api key";
    $response["status"] = "201";
    echo json_encode($response);
    }
    }