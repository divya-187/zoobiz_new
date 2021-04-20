<?php
include_once 'lib.php';
if (isset($_POST) && !empty($_POST)) {
    if ($key == $keydb) {
        $response = array();
        extract(array_map("test_input", $_POST));
        $today = date("Y-m-d");
        //26oct2020
        if ($_POST['getCllassifiedCategories'] == "getCllassifiedCategories") {

//getusers with dev category
              $dev_users = $d->select("user_employment_details,business_categories, business_sub_categories", "  user_employment_details.business_category_id  =business_categories.business_category_id and  user_employment_details.business_sub_category_id  =business_sub_categories.business_sub_category_id and business_categories.category_status = 2  and business_sub_categories.sub_category_status = 2   ");
            $silver_developer = array('0');
               while ($dev_users_data=mysqli_fetch_array($dev_users)) {
                $silver_developer[] = $dev_users_data['user_id'];
               }
               $silver_developer = implode(",", $silver_developer);
               
//getusers with dev category


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



            $queryAry    = array();
            $appendQuery = "";
            if ($city_id != 0) {
                $cityIdAry   = explode(",", $city_id);
                $ids         = join("','", $cityIdAry);
                $appendQuery = " AND  cllassifieds_city_master.city_id IN ('$ids')";
            }
            $q = $d->select("business_categories,cllassifieds_master, cllassifieds_city_master", " cllassifieds_master.active_status=0  AND  cllassifieds_master.cllassified_id=cllassifieds_city_master.cllassified_id 

                AND (cllassifieds_master.business_category_id  =business_categories.business_category_id  or cllassifieds_master.business_category_id  =0 ) and 



                business_categories.category_status = 0  and cllassifieds_master.user_id not in ($blocked_users) $appendQuery ", " group by  cllassifieds_master.cllassified_id   ORDER BY business_categories.category_name ASC ");

            
            if (mysqli_num_rows($q) > 0) {
                $response["classifiedCategories"] = array();
                if ($city_id != 0) {
                    /*$totalCls = $d->count_data_direct("cllassified_id","cllassifieds_master,cllassifieds_city_master", "cllassifieds_master.cllassified_id=cllassifieds_city_master.cllassified_id AND
                    cllassifieds_master.business_category_id=0 AND
                    cllassifieds_master.business_sub_category_id=0  $appendQuery    ");*/
                    $totalCls = $d->select("cllassifieds_master,cllassifieds_city_master", " cllassifieds_master.active_status=0  AND cllassifieds_master.cllassified_id=cllassifieds_city_master.cllassified_id AND  cllassifieds_master.user_id not in ($silver_developer) and 
	cllassifieds_master.business_category_id=0 AND
	cllassifieds_master.business_sub_category_id=0 and cllassifieds_master.user_id not in ($blocked_users)   $appendQuery  GROUP BY cllassifieds_master.cllassified_id  ");

                   
                } else {
                    /*$totalCls = $d->count_data_direct("cllassified_id","cllassifieds_master", "
                    cllassifieds_master.business_category_id=0 AND
                    cllassifieds_master.business_sub_category_id=0    ");*/
                    $totalCls = $d->select("cllassifieds_master", " cllassifieds_master.active_status=0  AND 
	cllassifieds_master.business_category_id=0 AND cllassifieds_master.user_id not in ($silver_developer) and 
	cllassifieds_master.business_sub_category_id=0 and cllassifieds_master.user_id not in ($blocked_users)  GROUP BY cllassifieds_master.cllassified_id    ");
                }
                $discussion = array();
                //mysqli_num_rows($q)
                //$discussion["calssified_main_cat_entries"] = $totalCls;
                $discussion["calssified_main_cat_entries"] = (string) mysqli_num_rows($totalCls);
                $discussion["business_category_id"]        = "0";
                $discussion["category_name"]               = "All";
                array_push($response["classifiedCategories"], $discussion);
                $cat_arr = array('0');
                $t = 1;
                while ($data = mysqli_fetch_array($q)) {
                    $discussion                                = array();
                    $discussion["cnt"]        = $t; $t++;
                    if(!in_array($data['business_category_id'], $cat_arr)){ 
                        $cat_arr[] = $data['business_category_id'];
                         $discussion["cat_arr"]        =  implode(",", $cat_arr);
                    $business_category_id                      = $data['business_category_id'];
                    /*$totalCls = $d->count_data_direct("cllassified_id","cllassifieds_master, cllassifieds_city_master", " cllassifieds_master.cllassified_id=cllassifieds_city_master.cllassified_id AND  cllassifieds_master.business_category_id='$business_category_id'   $appendQuery  ");*/
                    $totalCls                                  = $d->select("cllassifieds_master, cllassifieds_city_master", "  cllassifieds_master.active_status=0  AND cllassifieds_master.cllassified_id=cllassifieds_city_master.cllassified_id AND cllassifieds_master.user_id not in ($silver_developer) and   cllassifieds_master.business_category_id='$business_category_id' and cllassifieds_master.user_id not in ($blocked_users)    $appendQuery  GROUP BY cllassifieds_master.cllassified_id   ");


                     if(isset($debug)){
                        echo " cllassifieds_master.cllassified_id=cllassifieds_city_master.cllassified_id AND cllassifieds_master.user_id not in ($silver_developer) and   cllassifieds_master.business_category_id='$business_category_id' and cllassifieds_master.user_id not in ($blocked_users)   $appendQuery  GROUP BY cllassifieds_master.cllassified_id   "; 
                    }



                    
                    //$discussion["calssified_main_cat_entries"] = $totalCls;
                      //$discussion["qry"] = "AND  cllassifieds_master.business_category_id='$business_category_id' ".$appendQuery;
                    $discussion["calssified_main_cat_entries"] = (string) mysqli_num_rows($totalCls);
                    $discussion["business_category_id"]        = $data['business_category_id'];
                    $discussion["category_name"]               = html_entity_decode($data['category_name']);
                    array_push($response["classifiedCategories"], $discussion);
                }
            }
                $response["message"] = "Classified Main Categories";
                $response["status"]  = "200";
                echo json_encode($response);
            } else {
                $response["message"] = "No Data Available.";
                $response["status"]  = "201";
                echo json_encode($response);
            }
        } else if ($_POST['getCllassifiedSubCategories'] == "getCllassifiedSubCategories") {

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


            $queryAry    = array();
            $appendQuery = "";
            if ($city_id != 0) {
                $cityIdAry   = explode(",", $city_id);
                $ids         = join("','", $cityIdAry);
                $appendQuery = " AND  cllassifieds_city_master.city_id IN ('$ids')";
            }


            //getusers with dev category
              $dev_users = $d->select("user_employment_details,business_categories, business_sub_categories", "  user_employment_details.business_category_id  =business_categories.business_category_id and  user_employment_details.business_sub_category_id  =business_sub_categories.business_sub_category_id and business_categories.category_status = 2  and business_sub_categories.sub_category_status = 2   ");
            $silver_developer = array('0');
               while ($dev_users_data=mysqli_fetch_array($dev_users)) {
                $silver_developer[] = $dev_users_data['user_id'];
               }
               $silver_developer = implode(",", $silver_developer);
               
//getusers with dev category


            $where = "";
            if ($business_category_id == 0) {
                $where .= " and cllassifieds_master.business_category_id=0  ";
                $q = $d->select("cllassifieds_city_master,cllassifieds_master", "  cllassifieds_master.active_status=0  AND cllassifieds_master.user_id not in ($silver_developer) and   cllassifieds_master.cllassified_id=cllassifieds_city_master.cllassified_id and cllassifieds_master.user_id not in ($blocked_users)   $where $appendQuery   ", "GROUP BY cllassifieds_master.business_sub_category_id ORDER BY cllassifieds_master.cllassified_id ASC ");
            } else {
                $where .= " and cllassifieds_master.business_category_id='$business_category_id'  ";
                $q = $d->select("cllassifieds_city_master,cllassifieds_master", "   cllassifieds_master.active_status=0  AND cllassifieds_master.user_id not in ($silver_developer) and   cllassifieds_master.cllassified_id=cllassifieds_city_master.cllassified_id and cllassifieds_master.user_id not in ($blocked_users)   $where $appendQuery   ", "GROUP BY cllassifieds_master.business_sub_category_id ORDER BY cllassifieds_master.cllassified_id ASC ");
            }
            if (mysqli_num_rows($q) > 0) {
                $response["classifiedSubCategories"] = array();
                /*$totalClsSub = $d->count_data_direct("cllassified_id","cllassifieds_master, cllassifieds_city_master ", "  cllassifieds_master.cllassified_id=cllassifieds_city_master.cllassified_id AND      cllassifieds_master.business_category_id='$business_category_id'  and cllassifieds_master.business_sub_category_id=0  $appendQuery     ");*/
                $totalClsSub  = $d->select("cllassifieds_master, cllassifieds_city_master ", "    cllassifieds_master.active_status=0  AND cllassifieds_master.cllassified_id=cllassifieds_city_master.cllassified_id AND cllassifieds_master.user_id not in ($silver_developer) and      cllassifieds_master.business_category_id='$business_category_id'  and cllassifieds_master.business_sub_category_id=0 and cllassifieds_master.user_id not in ($blocked_users)   $appendQuery    GROUP BY cllassifieds_master.cllassified_id  ");
                if (mysqli_num_rows($totalClsSub) > 0 ) {
                    $discussion                               = array();
                    //$discussion["calssified_sub_cat_entries"] = (string)$totalClsSub;
                    $discussion["calssified_sub_cat_entries"] = (string) mysqli_num_rows($totalClsSub);
                    $discussion["business_sub_category_id"]   = "0";
                    $discussion["business_category_id"]       = (string) $business_category_id;
                    $discussion["sub_category_name"]          = "All";
                    array_push($response["classifiedSubCategories"], $discussion);
                }
                while ($data = mysqli_fetch_array($q)) {
                    if ($data['business_sub_category_id'] != 0) {
                        $business_sub_category_id         = $data['business_sub_category_id'];
                        /*$totalClsSub = $d->count_data_direct("cllassified_id","cllassifieds_city_master,cllassifieds_master", " cllassifieds_master.cllassified_id=cllassifieds_city_master.cllassified_id AND
                        cllassifieds_master.business_category_id='$business_category_id'  and
                        cllassifieds_master.business_sub_category_id='$business_sub_category_id'   $appendQuery   ");*/
                        $totalClsSub                      = $d->select("cllassifieds_city_master,cllassifieds_master", "  cllassifieds_master.active_status=0  AND  cllassifieds_master.cllassified_id=cllassifieds_city_master.cllassified_id AND cllassifieds_master.user_id not in ($silver_developer) and 
	cllassifieds_master.business_category_id='$business_category_id'  and
	cllassifieds_master.business_sub_category_id='$business_sub_category_id' and cllassifieds_master.user_id not in ($blocked_users)   $appendQuery  GROUP BY cllassifieds_master.cllassified_id    ");
                        $sub_cat_id                       = $data['business_sub_category_id'];
                        $business_sub_categories_new      = $d->select("business_sub_categories", " business_sub_category_id='$sub_cat_id'  ");
                        $business_sub_categories_data_new = mysqli_fetch_array($business_sub_categories_new);
                        $sub_category_name                = "";
                        if ($sub_category_name == "") {
                            $sub_category_name = $business_sub_categories_data_new['sub_category_name'];
                        }
                        $discussion                               = array();
                        //$discussion["calssified_sub_cat_entries"] = (string)$totalClsSub;
                        $discussion["calssified_sub_cat_entries"] = (string) mysqli_num_rows($totalClsSub);
                        $discussion["business_sub_category_id"]   = $data['business_sub_category_id'];
                        $discussion["business_category_id"]       = $data['business_category_id'];
                        $discussion["sub_category_name"]          = html_entity_decode($sub_category_name);
                        array_push($response["classifiedSubCategories"], $discussion);
                    }
                }
                $response["message"] = "Classified Sub Categories";
                $response["status"]  = "200";
                echo json_encode($response);
            } else {
                $response["message"] = "No Data Available.";
                $response["status"]  = "201";
                echo json_encode($response);
            }
        } else
        //26oct2020
            if ($_POST['getCllassified'] == "getCllassified" && filter_var($user_id, FILTER_VALIDATE_INT) == true) {


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


            if ($filter_date_from != '') {
                $from       = date("Y-m-d", strtotime($filter_date_from));
                $toDate     = date("Y-m-d", strtotime($filter_date_to));
                // $from = date('Y-m-d', strtotime($filter_date_from . ' -1 day'));
                // $toDate = date('Y-m-d', strtotime($filter_date_to . ' +1 day'));
                $date       = date_create($from);
                $dateTo     = date_create($toDate);
                $nFrom      = date_format($date, "Y-m-d 00:00:01");
                $nTo        = date_format($dateTo, "Y-m-d 23:59:59");
                $dateFilter = "cllassifieds_master.created_date BETWEEN '$nFrom' AND '$nTo'";
                array_push($queryAry, $dateFilter);
            }
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
            if ($business_category_id != 0) {
                $query = "cllassifieds_master.business_category_id='$business_category_id'";
                array_push($queryAry, $query);
            }
            /*if ($business_sub_category_id != 0) {
            $atchQuery = "cllassifieds_master.business_sub_category_id='$business_sub_category_id'";
            array_push($queryAry, $atchQuery);
            }*/
            $query2 = "";
            if ($business_category_id != 0) {
                $query2 .= " and cllassifieds_master.business_category_id='$business_category_id'";
            } 
if ($business_category_id == 0) {
                $query2 .= " and cllassifieds_master.business_category_id=0 ";
            }

            /*else {
                 $query2 .= " and cllassifieds_master.business_category_id=0 ";
            }*/
            if ($business_sub_category_id != 0) {
                $query2 .= " and cllassifieds_master.business_sub_category_id='$business_sub_category_id'";
            }

            if ($business_sub_category_id == 0) {
                $query2 .= " and cllassifieds_master.business_sub_category_id=0 ";
            }

            /* else {
                $query2 .= " and cllassifieds_master.business_sub_category_id=0 ";
            }*/
            if ($city_id != 0) {
                $query2 .= " and  cllassifieds_city_master.city_id IN ('$ids')";
            }
            $appendQuery    = implode(" AND ", $queryAry);
            // if ($filter_date_from!='') {
            //   $q=$d->select("cllassifieds_master,cllassifieds_city_master","cllassifieds_master.active_status=0  AND cllassifieds_master.cllassified_id=cllassifieds_city_master.cllassified_id AND cllassifieds_city_master.city_id='$city_id' AND  cllassifieds_master.created_date BETWEEN '$nFrom' AND '$nTo' ","ORDER BY cllassifieds_master.cllassified_id DESC");
            // }else {
            $q              = $d->select("cllassifieds_master,cllassifieds_city_master", "cllassifieds_master.active_status=0  AND cllassifieds_master.cllassified_id=cllassifieds_city_master.cllassified_id and cllassifieds_master.user_id not in ($blocked_users)   $query2  /*$appendQuery*/", "GROUP BY cllassifieds_master.cllassified_id ORDER BY cllassifieds_master.cllassified_id DESC ");

            if(isset($debug)){
                echo "cllassifieds_master.active_status=0  AND cllassifieds_master.cllassified_id=cllassifieds_city_master.cllassified_id  $query2  /*$appendQuery*/";exit;
            }
            // }
            $qchekc         = $d->selectRow("cllassified_mute", "users_master", "user_id='$user_id' ");
            $muteDataCommon = mysqli_fetch_array($qchekc);
            if (mysqli_num_rows($q) > 0) {
                $response["discussion"] = array();
                while ($data = mysqli_fetch_array($q)) {
                    $qch22                                  = $d->select("user_block_master", "user_id='$user_id' AND block_by='$data[user_id]' ");
                    $discussion                             = array();
                   // $discussion["appendQuery"]              = $query2;
                    $discussion["cllassified_id"]           = $data['cllassified_id'];
                    $discussion["business_category_id"]     = $data['business_category_id'];
                    $discussion["business_sub_category_id"] = $data['business_sub_category_id'];
                    $discussion["cllassified_title"]        = html_entity_decode($data['cllassified_title']);
                    $discussion["cllassified_description"]  = html_entity_decode($data['cllassified_description']);
                    $discussion["user_id"]                  = html_entity_decode($data['user_id']);
                    $discussion["created_date"]             = date('d M Y', strtotime($data['created_date']));
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
        } else if ($_POST['getCllassifiedDetails'] == "getCllassifiedDetails" && filter_var($user_id, FILTER_VALIDATE_INT) == true && filter_var($cllassified_id, FILTER_VALIDATE_INT) == true) {
            $q = $d->select("cllassifieds_master", "active_status=0 AND  cllassified_id='$cllassified_id'  ", "ORDER BY cllassified_id DESC");
            if (mysqli_num_rows($q) > 0) {
                $response["discussion"] = array();
                while ($data = mysqli_fetch_array($q)) {
                    $discussion                             = array();
                    $discussion["cllassified_id"]           = $data['cllassified_id'];
                    $discussion["business_category_id"]     = $data['business_category_id'];
                    $discussion["business_sub_category_id"] = $data['business_sub_category_id'];
                    $discussion["cllassified_title"]        = html_entity_decode($data['cllassified_title']);
                    $discussion["cllassified_description"]  = html_entity_decode($data['cllassified_description']);
                    $discussion["user_id"]                  = html_entity_decode($data['user_id']);
                    $discussion["created_date"]             = date('d M Y', strtotime($data['created_date']));
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
                    $qc11 = $d->select("cllassified_mute", "user_id='$user_id' AND cllassified_id='$cllassified_id'");
                    if (mysqli_num_rows($qc11) > 0) {
                        $discussion["mute_status"] = true;
                    } else {
                        $discussion["mute_status"] = false;
                    }
                    $discussion["city"] = array();
                    $fi                 = $d->select("cllassifieds_city_master,cities", "cities.city_id=cllassifieds_city_master.city_id AND  cllassifieds_city_master.cllassified_id='$cllassified_id' ");
                    while ($feeData = mysqli_fetch_array($fi)) {
                        $city              = array();
                        $city["city_id"]   = $feeData['city_id'];
                        $city["city_name"] = $feeData['city_name'];
                        array_push($discussion["city"], $city);
                    }
                    $q111                        = $d->select("users_master", "user_id='$data[user_id]'", "");
                    $userdata                    = mysqli_fetch_array($q111);
                    $created_by                  = $userdata['user_full_name'];
                    $user_profile                = $base_url . "img/users/members_profile/" . $userdata['user_profile_pic'];

                     if($userdata['user_profile_pic'] ==""){
                        $discussion["user_profile"] ="";
                    } else {
                        $discussion["user_profile"] = $user_profile;
                    }

                    $discussion["created_by"]    = html_entity_decode($created_by);
                    $discussion["total_coments"] = $d->count_data_direct("comment_id", "cllassified_comment", "prent_comment_id=0 AND cllassified_id='$data[cllassified_id]'") . '';
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
                        $user_profile                    = $base_url . "img/users/members_profile/" . $userdataComment['user_profile_pic'];
                        $comment["user_profile"]         = $user_profile . '';

                         if($userdataComment['user_profile_pic'] ==""){
                        $comment["user_profile"] ="";
                    } else {
                        $comment["user_profile"] = $user_profile. '';
                    }


                        $comment["created_by"]           = $created_by;
                        $comment["sub_comment"]          = array();
                        $q4                              = $d->select("cllassified_comment", "cllassified_id='$subData[cllassified_id]' AND prent_comment_id='$subData[comment_id]'", "ORDER BY comment_id   DESC");
                        while ($subCommentData = mysqli_fetch_array($q4)) {
                            $sub_comment                         = array();
                            $sub_comment["comment_id"]           = $subCommentData['comment_id'];
                            $sub_comment["prent_comment_id"]     = $subCommentData['prent_comment_id'];
                            $sub_comment["user_id"]              = $subCommentData['user_id'];
                            $sub_comment["comment_messaage"]     = html_entity_decode($subCommentData['comment_messaage']);
                            $sub_comment["comment_created_date"] = time_elapsed_string($subCommentData['created_date']);
                            $q111                                = $d->select("users_master", "user_id='$subCommentData[user_id]'", "");
                            $userdataComment                     = mysqli_fetch_array($q111);
                            $created_by                          = $userdataComment['user_full_name'];
                            $user_profile                        = $base_url . "img/users/members_profile/" . $userdataComment['user_profile_pic'];
                            $sub_comment["created_by"]           = $created_by;
                            $sub_comment["user_profile"]         = $user_profile . '';

                              if($userdataComment['user_profile_pic'] ==""){
                        $sub_comment["user_profile"] ="";
                    } else {
                        $sub_comment["user_profile"] = $user_profile. '';
                    }

                    
                            array_push($comment["sub_comment"], $sub_comment);
                        }
                        array_push($discussion["comment"], $comment);
                    }
                    array_push($response["discussion"], $discussion);
                }
                $response["message"] = "Get Successfully!";
                $response["status"]  = "200";
                echo json_encode($response);
            } else {
                $response["message"] = "Classified Removed";
                $response["status"]  = "201";
                echo json_encode($response);
            }
        } else if (isset($_POST['addCllassified']) && filter_var($user_id, FILTER_VALIDATE_INT) == true) {

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


            $maxsize = 10097152;
            $file11  = $_FILES["cllassified_file"]["tmp_name"];
            if (file_exists($file11)) {
                if (($_FILES['cllassified_file']['size'] >= $maxsize) || ($_FILES["cllassified_file"]["size"] == 0)) {
                    $response["message"] = "Document too large. Must be less than 10 MB";
                    $response["status"]  = "201";
                    echo json_encode($response);
                    exit();
                }
                $extId    = pathinfo($_FILES['cllassified_file']['name'], PATHINFO_EXTENSION);
                $extAllow = array(
                    "pdf",
                    "doc",
                    "docx",
                    "csv",
                    "xls",
                    "xlsx",
                    "jpg",
                    "png",
                    "jpeg"
                );
                if (in_array($extId, $extAllow)) {
                    $temp             = explode(".", $_FILES["cllassified_file"]["name"]);
                    $cllassified_file = "File_" . $user_id . round(microtime(true)) . '.' . end($temp);
                    move_uploaded_file($_FILES["cllassified_file"]["tmp_name"], "../img/cllassified/" . $cllassified_file);
                } else {
                    $response["message"] = "Invalid Document only JPG, PNG, JPEG, Doc,CSV,XLSX & PDF are allowed.";
                    $response["status"]  = "201";
                    echo json_encode($response);
                    exit();
                }
            } else {
                $cllassified_file = "";
            }
            $uploadedFile = $_FILES["cllassified_photo"]["tmp_name"];
            $ext          = pathinfo($_FILES['cllassified_photo']['name'], PATHINFO_EXTENSION);
            if (file_exists($uploadedFile)) {
                $sourceProperties = getimagesize($uploadedFile);
                $newFileName      = rand() . $user_id;
                $dirPath          = "../img/cllassified/";
                $imageType        = $sourceProperties[2];
                $imageHeight      = $sourceProperties[1];
                $imageWidth       = $sourceProperties[0];
                if ($imageWidth > 1000) {
                    $newWidthPercentage = 1000 * 100 / $imageWidth; //for maximum 1000 widht
                    $newImageWidth      = $imageWidth * $newWidthPercentage / 100;
                    $newImageHeight     = $imageHeight * $newWidthPercentage / 100;
                } else {
                    $newImageWidth  = $imageWidth;
                    $newImageHeight = $imageHeight;
                }
                switch ($imageType) {
                    case IMAGETYPE_PNG:
                        $imageSrc = imagecreatefrompng($uploadedFile);
                        $tmp      = imageResize($imageSrc, $sourceProperties[0], $sourceProperties[1], $newImageWidth, $newImageHeight);
                        imagepng($tmp, $dirPath . $newFileName . "_discussion." . $ext);
                        break;
                    case IMAGETYPE_JPEG:
                        $imageSrc = imagecreatefromjpeg($uploadedFile);
                        $tmp      = imageResize($imageSrc, $sourceProperties[0], $sourceProperties[1], $newImageWidth, $newImageHeight);
                        imagejpeg($tmp, $dirPath . $newFileName . "_discussion." . $ext);
                        break;
                    case IMAGETYPE_GIF:
                        $imageSrc = imagecreatefromgif($uploadedFile);
                        $tmp      = imageResize($imageSrc, $sourceProperties[0], $sourceProperties[1], $newImageWidth, $newImageHeight);
                        imagegif($tmp, $dirPath . $newFileName . "_discussion." . $ext);
                        break;
                    default:
                        break;
                }
                $cllassified_photo = $newFileName . "_discussion." . $ext;
                $notiUrl           = $base_url . 'img/cllassified/' . $cllassified_photo;
            } else {
                $cllassified_photo = '';
                $notiUrl           = "";
            }
            $m->set_data('cllassified_title', $cllassified_title);
            $m->set_data('cllassified_description', $cllassified_description);
            $m->set_data('created_date', date("Y-m-d H:i:s"));
            $m->set_data('user_id', $user_id);
            $m->set_data('business_category_id', $business_category_id);
            $m->set_data('business_sub_category_id', $business_sub_category_id);
            $m->set_data('cllassified_photo', $cllassified_photo);
            $m->set_data('cllassified_file', $cllassified_file);
            $a              = array(
                'cllassified_title' => $m->get_data('cllassified_title'),
                'cllassified_description' => $m->get_data('cllassified_description'),
                'created_date' => $m->get_data('created_date'),
                'user_id' => $m->get_data('user_id'),
                'cllassified_photo' => $m->get_data('cllassified_photo'),
                'cllassified_file' => $m->get_data('cllassified_file'),
                'business_category_id' => $m->get_data('business_category_id'),
                'business_sub_category_id' => $m->get_data('business_sub_category_id')
            );
            //8march21
            /*$last_auto_id   = $d->last_auto_id("cllassifieds_master");
            $res            = mysqli_fetch_array($last_auto_id);
            $cllassified_id = $res['Auto_increment'];*/
            $q1             = $d->insert("cllassifieds_master", $a);
            $cllassified_id = $con->insert_id;
            if ($q1 > 0) {
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