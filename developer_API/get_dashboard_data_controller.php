<?php //NEWAPI
include_once 'lib.php';
if (isset($_POST) && !empty($_POST)) {
    if ($key == $keydb    ) {
        $response = array();
        extract(array_map("test_input", $_POST));
        $today = date('Y-m-d');
        if (isset($user_id) && isset($dashboardData) && $dashboardData == 'dashboardData' && filter_var($user_mobile, FILTER_VALIDATE_INT) == true  ) {
            if(isset($app_version_code)){
                $response["app_version_code"] =$app_version_code;
            }
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
            $response["rating_dialogue"] =false;
//check login start
            $q = $d->selectRow("company_id,user_id, plan_renewal_date,user_token,active_status,city_id","users_master", "user_id='$user_id' AND user_mobile='$user_mobile' AND user_id!=0  ");
            if (mysqli_num_rows($q) > 0) {
                $response["LoginDetails"] = array();
                $LoginDetails=array();
                $data = mysqli_fetch_array($q);
                $plan_expire_date = $data['plan_renewal_date'];

$response["message"] = 'Success';

               //  $difference_days= $d->plan_days_left($plan_expire_date);
$currDate = date("Y-m-d");
$startTimeStamp = strtotime($plan_expire_date);
$endTimeStamp = strtotime($currDate);
$timeDiff = abs($endTimeStamp - $startTimeStamp);
$numberDays = $timeDiff/86400;  // 86400 seconds in one day
$difference_days = intval($numberDays);
 if($difference_days == 0){
        $difference_days = 1;
    }
$dayCnt = $difference_days;
   
    

$response["message"]="success.";

if($difference_days < 0 || $difference_days==0 ){
     $response["difference_days"] =$difference_days;

    $response["renew_message"] ="Your subscription is Expired. Please renew!";
    $response["show_renew"] =false;
     $response["message_title"] ="Renew Plan";
     $msg = "Your subscription is Expired, Choose to renew from below options.";
} else  if ($difference_days <= 30) {
    $response["difference_days"] =$difference_days;

 if($dayCnt == 1){
        $response["renew_message"] ="Your subscription is going to expire today. Please renew soon!";
         $msg = "Your subscription is going to expire today. Please renew soon!";

    } else {
         $response["renew_message"] ="Your subscription is expiring in ".($dayCnt+1)." days. Please renew soon!" ;
          $msg = "Your subscription is expiring in ".($dayCnt+1)." days, Choose to renew from below options.";
    }
   
    $response["show_renew"] =true;
     $response["message_title"] ="Renew Plan";
    
$response["message"] = $msg;
} else {
     $response["difference_days"] =$difference_days;
     $response["renew_message"] ="";
    $response["show_renew"] =false;
}


$todayDate= date('Y-m-d'); 
    $response["is_plan_expired"] =false;
    if (strtotime($todayDate)>strtotime($plan_expire_date)) {
       $response["is_plan_expired"] =true;
       $response["show_renew"] =false;
    }

                $qqq = $d->selectRow("version_code_android,version_code_android_view,version_code_ios,version_code_ios_view","app_version_master", "");
                $dataqqq = mysqli_fetch_array($qqq);
                if (mysqli_num_rows($qqq) > 0) {
                    if (strtolower($device) == 'android' && $dataqqq['version_code_android'] > $version_code) {
                        $response["message_title"] = "Update Available";
                        $response["message"] = "Please Update Latest Version $dataqqq[version_code_android_view]";
                        $response["status"] = "204";
                        echo json_encode($response);
                        exit();
                    }
                    if (strtolower($device) == 'ios' && $dataqqq['version_code_ios'] > $version_code) {
                        $response["message_title"] = "Update Available";
                        $response["message"] = "Please Update Latest Version $dataqqq[version_code_ios_view]";
                        $response["status"] = "204";
                        echo json_encode($response);
                        exit();
                    }
                }

                
//13APRIL2021
 

                    //package info start
                    $response["package"] = array();
                    $app_data = $d->selectRow("inapp_ios_purchase_id, package_amount,package_id,gst_slab_id,package_name,package_amount,packaage_description,package_amount,package_amount,no_of_month,time_slab","package_master", "package_status=0 and is_cpn_package= 0", "");


                     $company_id = $data['company_id'];
                        $city_id = $data['city_id'];
                         $cur_qry = $d->selectRow("currency_symbol","company_master, payment_getway_master, currency_master", "company_master.company_id = '$company_id' and  payment_getway_master.company_id = company_master.company_id and currency_master.currency_id = payment_getway_master.currency_id ", "");
                         $cur_data = mysqli_fetch_array($cur_qry);
                         
                    while ($pkgdata = mysqli_fetch_array($app_data)) {
                        $gst_amount = $pkgdata["package_amount"] * 18 / 100;
                        $package = array();

                       

                         $package["currency_symbol"] = $cur_data['currency_symbol'];
                        $package["package_id"] = $pkgdata["package_id"];
                        $package["slab_percentage"] = '';
                        if($pkgdata['gst_slab_id'] !="0"){
                            $gst_slab_id = $pkgdata['gst_slab_id'];
                            $gst_master=$d->selectRow("slab_percentage,slab_id","gst_master","slab_id = '$gst_slab_id'","");
                            $gst_master_data=mysqli_fetch_array($gst_master);
                            $slab_percentage=  str_replace(".00","",$gst_master_data['slab_percentage']) .'% GST' ;
                            $gst_amount= (($pkgdata["package_amount"]*$gst_master_data['slab_percentage']) /100);
                            $package["slab_percentage"] = '+ '.$slab_percentage;
                        } else {
                            $slab_percentage= "" ;
                            $gst_amount= 0 ;
                        }


                        $package["package_name"] = $pkgdata["package_name"];
                        $package["package_full_name"] = $pkgdata["package_name"] . ' ( '.$package["currency_symbol"] . $pkgdata["package_amount"] . ' + '.$slab_percentage.') ( '.$package["currency_symbol"].number_format($pkgdata["package_amount"] + $gst_amount, 2, '.', '').')';
                        $package["package_description"] = $pkgdata["packaage_description"];
                        $package["package_amount"] = $package["currency_symbol"].' '.$pkgdata["package_amount"];
                        $package["package_with_amount"] = number_format($pkgdata["package_amount"] + $gst_amount, 2, '.', '');
                        $package["gst_amount"] = number_format($gst_amount, 2, '.', '');
                        $package["no_of_month"] = $pkgdata["no_of_month"];
                        $package["time_slab"] = $pkgdata["time_slab"];
                        $package["Apple_IAP_ProductID"] = $pkgdata["inapp_ios_purchase_id"];
                        array_push($response["package"], $package);
                    }
                    if (strtolower($device) == 'android' ) {
                        $response["Is_IAP_Payment"] = false;
                    }
                    if (strtolower($device) == 'ios') {
                        $response["Is_IAP_Payment"] = true;
                    }
                    $zoobiz_settings_master = $d->select("zoobiz_settings_master","","");
                    if( mysqli_num_rows($zoobiz_settings_master) > 0){
                        $zoobiz_settings_masterData = mysqli_fetch_array($zoobiz_settings_master);
                        $response["Is_IAP_Payment"] =filter_var($zoobiz_settings_masterData['Is_IAP_Payment'], FILTER_VALIDATE_BOOLEAN);
                    } else {
                        $response["Is_IAP_Payment"] = filter_var($zoobiz_settings_masterData['Is_IAP_Payment'], FILTER_VALIDATE_BOOLEAN);
                    }
                    //package info end
                    //payment gateway infor start
                    if (isset($city_id)) {
                        $company_master_qry = $d->selectRow("city_id,company_id","company_master", " city_id ='$city_id' and is_master = 0  ", "");
                        $response["payment_gateway_array"] = array();
                        if (mysqli_num_rows($company_master_qry) > 0) {
                            $company_master_data = mysqli_fetch_array($company_master_qry);
                            $company_id = $company_master_data['company_id'];
                        } else {
                            $company_id = 1;
                        }
                        $payment_getway_master_qry = $d->selectRow("*","payment_getway_master", " company_id ='$company_id' ", "");
                        if (mysqli_num_rows($payment_getway_master_qry) > 0) {
                            $payment_getway_master_data = mysqli_fetch_array($payment_getway_master_qry);
                            $currency_id = $payment_getway_master_data['currency_id'];
                            $currency_master_qry = $d->selectRow("currency_code,currency_id","currency_master", " currency_id ='$currency_id' ", "");
                            $currency_master_data = mysqli_fetch_array($currency_master_qry);
                            $keyId = $payment_getway_master_data['merchant_id'];
                            $keySecret = $payment_getway_master_data['merchant_key'];
                            $upi_id = $payment_getway_master_data['upi_id'];
                            $upi_name = $payment_getway_master_data['upi_name'];
                            $displayCurrency = $currency_master_data['currency_code'];
                            if($payment_getway_master_data['merchant_id']!=""){
                                $payment_gateway_array = array();
                                $payment_gateway_array['gateway_name'] ="Razorpay";
                                $payment_gateway_array['keyId'] = $payment_getway_master_data['merchant_id'];
                                $payment_gateway_array['keySecret'] = $payment_getway_master_data['merchant_key'];
                                $payment_gateway_array['is_upi'] =false;
                                $payment_gateway_array['logo_url'] =$base_url.'img/razor_pay_logo1.png';
                                $payment_gateway_array["displayCurrency"] = $displayCurrency;
                                array_push($response["payment_gateway_array"], $payment_gateway_array);
                            }
                            if($payment_getway_master_data['paytm_merchant_id']!=""){
                                $payment_gateway_array = array();
                            $payment_gateway_array['gateway_name'] ='paytm';//$payment_getway_master_data['paytm_name'];
                            $payment_gateway_array['is_upi'] =false;
                            $payment_gateway_array['logo_url'] =$base_url.'img/PaytmLogo.png';
                            $payment_gateway_array["displayCurrency"] = $displayCurrency;
                            $zoobiz_settings_master_qry = $d->select("zoobiz_settings_master","","");
                            $zoobiz_settings_master_data=mysqli_fetch_array($zoobiz_settings_master_qry);
                            $payment_gateway_array['PaytmChecksumCode'] = $zoobiz_settings_master_data['PaytmChecksumCode'];
                            if($payment_getway_master_data['paytm_is_live_mode']=="Yes"){
                                $payment_gateway_array["host_url"] = "https://securegw.paytm.in/";
                                $payment_gateway_array["call_back_url"] = "https://securegw.paytm.in/theia/paytmCallback";
                                $payment_gateway_array["show_payment_url"] = "https://securegw.paytm.in/theia/api/v1/showPaymentPage";
                                $payment_gateway_array['paytm_merchant_id'] = $payment_getway_master_data['paytm_merchant_id'];
                                $payment_gateway_array['paytm_merrchant_key'] =html_entity_decode( $payment_getway_master_data['paytm_merrchant_key']);
                                $payment_gateway_array['paytm_is_live_mode'] = true;
                            } else {
                                $payment_gateway_array['paytm_is_live_mode'] = false;
                                $payment_gateway_array["host_url"] = "https://securegw-stage.paytm.in/";
                                $payment_gateway_array["call_back_url"] =   "https://securegw-stage.paytm.in/theia/paytmCallback";

                                $payment_gateway_array["show_payment_url"] = "https://securegw-stage.paytm.in/theia/api/v1/showPaymentPage";
                                $payment_gateway_array['paytm_merchant_id'] = $payment_getway_master_data['test_paytm_merchant_id'];
                                $payment_gateway_array['paytm_merrchant_key'] =html_entity_decode( $payment_getway_master_data['test_paytm_merrchant_key']);
                            }
                            array_push($response["payment_gateway_array"], $payment_gateway_array);
                            }
                                    if($payment_getway_master_data['ccav_merchant_id'] !=""){
                                        $payment_gateway_array = array();
                                        $payment_gateway_array['gateway_name'] ="CCAvenue";
                                        $payment_gateway_array['ccav_working_key'] = $payment_getway_master_data['ccav_working_key'];
                                        $payment_gateway_array['ccav_access_code'] = $payment_getway_master_data['ccav_access_code'];
                                        $payment_gateway_array['ccav_merchant_id'] = $payment_getway_master_data['ccav_merchant_id'];
                                        $payment_gateway_array['logo_url'] =$base_url.'img/new.png';
                                        $payment_gateway_array['redirect_url'] = $base_url.'/controller/ccavResponseHandlerAndroid.php';
                                        $payment_gateway_array['cancel_url'] = $base_url.'/controller/ccavResponseHandlerAndroid.php';
                                        if($payment_getway_master_data['ccav_live_mode']=="Yes"){
                                            $payment_gateway_array["ccav_mode_url"]=  "https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction";
                                            $payment_gateway_array["ccav_rsa_url"]=  $base_url.'/controller/GetRSA.php';
                                            $payment_gateway_array['trans_url'] ="https://secure.ccavenue.com/transaction/initTrans";
                                            $payment_gateway_array['ccav_live_mode'] = true;
                                        } else {
                                            $payment_gateway_array["ccav_mode_url"]= "https://test.ccavenue.com/transaction/transaction.do?command=initiateTransaction";
                                            $payment_gateway_array["ccav_rsa_url"]=  $base_url.'/controller/GetRSA.php';
                                            $payment_gateway_array['trans_url'] ="https://test.ccavenue.com/transaction/initTrans";
                                            $payment_gateway_array['ccav_live_mode'] = false;
                                        }
                                        $payment_gateway_array['is_upi'] =false;
                                        $payment_gateway_array["displayCurrency"] = $displayCurrency;
                                        array_push($response["payment_gateway_array"], $payment_gateway_array);
                                    }

                                    } else {
                                        $payment_getway_master_qry = $d->selectRow("*","payment_getway_master", " company_id ='1' ", "");
                                        $payment_getway_master_data = mysqli_fetch_array($payment_getway_master_qry);
                                        $currency_id = $payment_getway_master_data['currency_id'];
                                        $currency_master_qry = $d->selectRow("currency_code,currency_id","currency_master", " currency_id ='$currency_id' ", "");
                                        $currency_master_data = mysqli_fetch_array($currency_master_qry);
                                        $keyId = $payment_getway_master_data['merchant_id'];
                                        $keySecret = $payment_getway_master_data['merchant_key'];

                                        $displayCurrency = 'INR';


                                    }
                                    } else {
                                        $payment_getway_master_qry = $d->selectRow("*","payment_getway_master", " company_id ='1' ", "");
                                        $payment_getway_master_data = mysqli_fetch_array($payment_getway_master_qry);
                                        $currency_id = $payment_getway_master_data['currency_id'];
                                        $currency_master_qry = $d->selectRow("currency_code,currency_id","currency_master", " currency_id ='$currency_id' ", "");
                                        $currency_master_data = mysqli_fetch_array($currency_master_qry);
                                        $keyId = $payment_getway_master_data['merchant_id'];
                                        $keySecret = $payment_getway_master_data['merchant_key'];

                                        $displayCurrency = 'INR';


                                    }
                                    $response["upiList"] = array();
                                    $qA = $d->select("upi_app_master","active_status=0","");
                                    if (mysqli_num_rows($qA) > 0) {
                                            while($data_app=mysqli_fetch_array($qA)) {
                                                $upiList=array();
                                                $upiList["app_id"] = $data_app['app_id'];
                                                $upiList["app_name"] = $data_app['app_name'];
                                                $upiList["app_package_name"] = $data_app['app_package_name'];
                                                $upiList['is_upi'] =true;
                                                array_push($response["upiList"], $upiList); 
                                            }
                                    }
                                    $zoobiz_settings_master_qry = $d->select("zoobiz_settings_master","","");
                                    $zoobiz_settings_master_data=mysqli_fetch_array($zoobiz_settings_master_qry);
                                        $response['is_upi'] =filter_var($zoobiz_settings_master_data['is_upi'], FILTER_VALIDATE_BOOLEAN); 
                                        
                                        $response["keyId"] = $keyId;
                                        $response["keySecret"] = $keySecret;
                            $response["displayCurrency"] = $displayCurrency;
                                    //paymenet gateway info end

                                    //13APRIL2021
                if ($today > $plan_expire_date) {
                    $msg = "Your Subscription has expired on  $plan_expire_date, Please choose to renew from below options.";
                    $response["message"] = $msg;
                    $msg_title = "Plan Expired.";
                    $response["message"] = $msg;
                    $response["message_title"] = $msg_title;
                    $response["status"] = "202";
                    
                            echo json_encode($response);
                            exit();
                            }
if ($data['active_status'] == 1) {
    $msg_title = "Account Is Deactive.";
    $response["message_title"] = $msg_title;
    $msg = "Your Account Is Deactive, Please Contact ZooBiz Support Team";
    $response["message"] = $msg;
    $response["status"] = "202";
    echo json_encode($response);
    exit();
}
if ($user_token == '') {
    $response["message"] = "Please Login";
    $response["status"] = "201";
    echo json_encode($response);
    exit();
}
if ($user_token != '') {
    $msg = "";
    if ($data['user_token'] == '') {
        $msg = "Login authentication faild, please try again";
    }
    if ($data['user_token'] != $user_token && $data['user_token'] !='') {
        $msg = "Detected login already with other device please try login again";
    }
/*if ($today > $plan_expire_date) {
$msg = "Your Plan Has been Expired on $plan_expire_date, Please Contact ZooBiz Sales Team";
}
if ($data['active_status'] == 1) {
$msg = "Your Account Is Deactive, Please Contact ZooBiz Support Team";
}*/
if ($msg != "") {
    $response["message"] = $msg;
    $response["status"] = "201";
    echo json_encode($response);
    exit();
}
}
$todayTime = date('Y-m-d H:i:s');
$a = array(
    'last_login' => $todayTime,
    'version_code' => $version_code,
);
$d->update("users_master", $a, "user_id='$user_id'");
$q2 = $d->selectRow("user_notification_id","user_notification", "user_id='$user_id' AND notification_type !=10  AND   read_status=0  and status='Active' ");
$q3 = $d->selectRow("user_notification_id","user_notification", "user_id='$user_id' AND notification_type=1 AND   read_status=0  and status='Active' ");
$chatCount=$d->count_data_direct("chat_id","chat_master","msg_for='$user_id'   AND msg_status='0'");
$qa = $d->selectRow("view_status,active_status,advertisement_url","advertisement_master", "");
$advData = mysqli_fetch_array($qa);
$LoginDetails["view_status"] = $advData['view_status'];
$LoginDetails["active_status"] = $advData['active_status'];
$LoginDetails["advertisement_url"] = $base_url . "img/sliders/" . $advData['advertisement_url'];
/*$LoginDetails["unread_notification"] = mysqli_num_rows($q2) . '';
$LoginDetails["unread_timeline_notification"] = mysqli_num_rows($q3) . '';
$LoginDetails["unread_chat"] =$chatCount.'';*/
array_push($response["LoginDetails"], $LoginDetails);

//check login end
//refer by start
$memberAdded=$d->selectRow("users_master.user_profile_pic,users_master.user_id as uid,users_master.user_full_name,users_master.refer_by,users_master.refere_by_name,users_master.refere_by_phone_number,users_master.remark,users_master.register_date,user_employment_details.company_name,user_employment_details.designation ","users_master,user_employment_details"," user_employment_details.user_id = users_master.user_id and  users_master.refere_by_phone_number  = '$user_mobile'  AND users_master.office_member=0 AND users_master.active_status=0   ","");
if($memberAdded > 0 ){

    $response["memberAdded"] = mysqli_num_rows($memberAdded);

    $q3= $d->selectRow("users_master.user_first_name, users_master.user_last_name, users_master.user_profile_pic,users_master.user_id as uid,users_master.user_full_name,users_master.refer_by,users_master.refere_by_name,users_master.refere_by_phone_number,users_master.remark,users_master.register_date,user_employment_details.company_name,user_employment_details.designation ","users_master,user_employment_details"," user_employment_details.user_id = users_master.user_id and  users_master.refere_by_phone_number  = '$user_mobile' AND users_master.office_member=0 AND users_master.active_status=0    ","");
    $response["member_added_details"] = array();
    while ($data=mysqli_fetch_array($q3)) {
        extract($data);
        $member_added_details = array();
        if($user_profile_pic != ""){
            $member_added_details["user_profile_pic"] = $base_url . "img/users/members_profile/" . $user_profile_pic;
        } else {
            $member_added_details["user_profile_pic"]= "";
        }
        $member_added_details["short_name"] =strtoupper(substr($data["user_first_name"], 0, 1).substr($data["user_last_name"], 0, 1) );
        $member_added_details["user_id"] = $uid;
        $member_added_details["user_full_name"] = $user_full_name;
        $member_added_details["company_name"] = html_entity_decode( $company_name);
        $member_added_details["designation"] = html_entity_decode( $designation);

        if($refer_by=="1") {
            $member_added_details["refer_by"] = "Social Media";}
            else if($refer_by=="2") {$member_added_details["refer_by"]=  "Member / Friend";}
            else if($refer_by=="3") {$member_added_details["refer_by"] =  "Other";}
            $member_added_details["refere_by_name"] = $refere_by_name;
            $member_added_details["refere_by_phone_number"] = $refere_by_phone_number;
            $member_added_details["remark"] = $remark;
            $member_added_details["register_date"] = date("d-m-Y h:i:s A",strtotime($register_date));
            $member_added_details["refere_by_name"] = $refere_by_name;

            array_push($response["member_added_details"], $member_added_details);
        }
    } else {
        $response["member_added_details"] = array();
        $response["memberAdded"] ="0";
    }
//refer by end
    $notmal_noti = $d->select("user_notification", "user_id='$user_id' AND   notification_type !=10      AND   read_status=0  and status='Active' ");
    $meetup_noti = $d->select("user_notification", "user_id='$user_id' AND   notification_type =10    AND   read_status=0  and status='Active' ");
    $timeline_noti = $d->select("user_notification", "user_id='$user_id' AND notification_type=1 AND   read_status=0  and status='Active' ");
    $chatCount=$d->count_data_direct("chat_id","chat_master,users_master"," users_master.user_id =chat_master.msg_by and   chat_master.msg_for='$user_id'   AND chat_master.msg_status='0' AND users_master.office_member=0
        ");
    $response["unread_notification"] = mysqli_num_rows($notmal_noti) . '';
    $response["unread_meetup_notification"] = mysqli_num_rows($meetup_noti) . '';
    $response["unread_timeline_notification"] = mysqli_num_rows($timeline_noti) . '';
    $response["unread_chat"] =$chatCount.'';
    $tq = $d->selectRow("timeline_id", "timeline_master", "active_status = 0  and user_id not in ($blocked_users) ", "ORDER BY timeline_id DESC ");
    $timelineData = mysqli_fetch_array($tq);
    if ($timelineData > 0) {
        $last_timeline_id = $timelineData['timeline_id'] . '';
    } else {
        $last_timeline_id = '0';
    }
    $response["last_timeline_id"] = $last_timeline_id;
//user allocated and occupied space details start
    $gb_devider = 1073741824;
    $timeline_photos_master_det = $d->selectRow("round(sum(size)/".$gb_devider.",1) as used_space","timeline_photos_master", "user_id='$user_id' group by `user_id`  ", "");
    $timeline_photos_master_d = mysqli_fetch_array($timeline_photos_master_det);
    $zoobiz_settings_master_q = $d->selectRow("user_timeline_upload_limit_in_gb","zoobiz_settings_master", "", "");
    $zoobiz_settings_master_d = mysqli_fetch_array($zoobiz_settings_master_q);
    $response["user_timeline_space_details"] = array();

    $space_arr = array();
    $space_arr['is_show'] = false;
    if($timeline_photos_master_d['used_space']!= NULL){
        $kb_devider = 1024;
        $timeline_photos_master_det_kb = $d->selectRow("round(sum(size)/".$kb_devider.",2) as used_space_kb","timeline_photos_master", "user_id='$user_id' group by `user_id`  ", "");
        $timeline_photos_master_d_kb = mysqli_fetch_array($timeline_photos_master_det_kb);
        $space_arr['used_space_kb'] = $timeline_photos_master_d_kb['used_space_kb'];
        $mb_devider = (1024*1024);
        $timeline_photos_master_det_mb = $d->selectRow("round(sum(size)/".$mb_devider.",2) as used_space_mb","timeline_photos_master", "user_id='$user_id' group by `user_id`  ", "");
        $timeline_photos_master_d_mb = mysqli_fetch_array($timeline_photos_master_det_mb);
        $space_arr['used_space_mb'] = $timeline_photos_master_d_mb['used_space_mb'];
        $space_arr['used_space'] = $timeline_photos_master_d['used_space'];
    } else {
        $space_arr['used_space_kb']="0";
        $space_arr['used_space_mb']="0";
        $space_arr['used_space'] = '0';
    }
    if( $space_arr['used_space'] >= $zoobiz_settings_master_d['user_timeline_upload_limit_in_gb']){
//$space_arr['is_full'] = true;
        $space_arr['is_full'] = true;
    } else {
        $space_arr['is_full'] = false;
    }
    $space_arr["is_full_message"] ="Timeline Storage Limit Exceeded, Please remove Older Videos and Photos to Upload New.";
    $space_arr['allocated_space_in_gb'] = $zoobiz_settings_master_d['user_timeline_upload_limit_in_gb'];
    array_push($response["user_timeline_space_details"], $space_arr);
//user allocated and occupied space details end
//social media details
    $social_media_master = $d->selectRow("id,media_name,media_link","social_media_master", "status=0");
    $response["social_media"] = array();
    while($social_media_master_data=mysqli_fetch_array($social_media_master)) {
        $social_media = array();
        $social_media['id'] = $social_media_master_data['id'];
        $social_media['media_name'] = $social_media_master_data['media_name'];
        $social_media['media_link'] = $social_media_master_data['media_link'];
        array_push($response["social_media"], $social_media);
    }

//social media details
    $user_detail_qry = $d->selectRow("users_master.facebook,users_master.linkedin,users_master.twitter,users_master.instagram,
        users_master.user_id,business_categories.business_category_id,business_sub_categories.business_sub_category_id,users_master.user_full_name,users_master.zoobiz_id,users_master.public_mobile,users_master.user_mobile,users_master.user_profile_pic,business_categories.category_name,business_sub_categories.sub_category_name,user_employment_details.company_name","users_master,user_employment_details,business_categories,business_sub_categories,business_adress_master", " ( business_categories.category_status = 0 OR business_categories.category_status = 2) and
        business_adress_master.user_id=users_master.user_id AND business_adress_master.adress_type=0 AND users_master.user_id='$user_id'  AND business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id  ", "");

    $user_detail_data = mysqli_fetch_array($user_detail_qry);
    $response["userDetails"] = array();
    $userDetails=array();
    $userDetails["user_full_name"] = $user_detail_data["user_full_name"];
    $userDetails["facebook"] = $user_detail_data["facebook"];
    $userDetails["linkedin"] = $user_detail_data["linkedin"];
    $userDetails["twitter"] = $user_detail_data["twitter"];
    $userDetails["instagram"] = $user_detail_data["instagram"];
//new
    $userDetails["user_id"] = $user_detail_data["user_id"];
    $userDetails["business_category_id"] = $user_detail_data["business_category_id"];
    $userDetails["business_sub_category_id"] = $user_detail_data["business_sub_category_id"];
    $userDetails["user_full_name"] = $user_detail_data["user_full_name"];
    $userDetails["zoobiz_id"] = $user_detail_data["zoobiz_id"];
    $userDetails["public_mobile"] = $user_detail_data["public_mobile"];
    $userDetails["user_mobile"] = $user_detail_data["user_mobile"];
    $userDetails["user_profile_pic"] = $base_url . "img/users/members_profile/" . $user_detail_data['user_profile_pic'];
    if($user_detail_data['user_profile_pic'] ==""){
        $userDetails["user_profile_pic"] ="";
    } else {
        $userDetails["user_profile_pic"] =$base_url . "img/users/members_profile/" . $user_detail_data['user_profile_pic'];
    }

    $userDetails["bussiness_category_name"] = html_entity_decode($user_detail_data["category_name"]);
    $userDetails["sub_category_name"] = html_entity_decode($user_detail_data["sub_category_name"]) . '';
    $userDetails["company_name"] = html_entity_decode($user_detail_data["company_name"]) . '';
//new
    $user_mobile = $user_detail_data["user_mobile"];
    $memberAdded=$d->count_data_direct("user_mobile"," users_master  "," refere_by_phone_number ='$user_mobile'   AND office_member=0 AND active_status=0  ");
    $userDetails["user_added"] = $memberAdded;
//get profile percentage start
    $userDetails["profile_percentage"] =        $profile_percentage = $d->get_profile_percentage($user_id);
//get profile percentage end
//get last timeline id start
    $tq = $d->selectRow("timeline_id", "timeline_master", "active_status = 0 and user_id not in ($blocked_users) ", "ORDER BY timeline_id DESC ");
    $timelineData = mysqli_fetch_array($tq);
    if ($timelineData > 0) {
        $last_timeline_id = $timelineData['timeline_id'] . '';
    } else {
        $last_timeline_id = '0';
    }
    $userDetails["last_timeline_id"] = $last_timeline_id;
//get last timeline id end
//get last timeline id start
    $tq = $d->selectRow("cllassified_id", "cllassifieds_master", "active_status = 0 ", "ORDER BY cllassified_id DESC ");
    $classifiedData = mysqli_fetch_array($tq);
    if ($classifiedData > 0) {
        $last_cllassified_id = $classifiedData['cllassified_id'] . '';
    } else {
        $last_cllassified_id = '0';
    }
    $userDetails["last_cllassified_id"] = $last_cllassified_id;
//get last timeline id end
    array_push($response["userDetails"], $userDetails);
//get menu start
    if (strtolower($device)=='android') {
        $app_data=$d->selectRow("app_menu_id,menu_title,menu_click,ios_menu_click,menu_icon_new,menu_icon,menu_icon_ios,menu_sequence,tutorial_video","resident_app_menu","menu_status='0' AND menu_status_android='0' AND parent_menu_id=0 and menu_icon_new!='' ","ORDER BY menu_sequence ASC");
    }else  if (strtolower($device)=='ios') {
        $app_data=$d->selectRow("app_menu_id,menu_title,menu_click,ios_menu_click,menu_icon_new,menu_icon,menu_icon_ios,menu_sequence,tutorial_video","resident_app_menu","menu_status='0' AND menu_status_ios='0' AND parent_menu_id=0 and menu_icon_new!='' ","ORDER BY menu_sequence ASC");
    }else {
        $app_data=$d->selectRow("app_menu_id,menu_title,menu_click,ios_menu_click,menu_icon_new,menu_icon,menu_icon_ios,menu_sequence,tutorial_video","resident_app_menu","menu_status='0'  AND parent_menu_id=0 and menu_icon_new!='' ","ORDER BY menu_sequence ASC");
    }
    $response["appmenu"] = array();
//code optimize
    $dataArray = array();
    $counter = 0 ;
    foreach ($app_data as  $value) {
        foreach ($value as $key => $valueNew) {
            $dataArray[$counter][$key] = $valueNew;
        }
        $counter++;
    }
    $app_menu_id_array = array('0');
    $android_device_array = array('0');
    $general_device_array = array('0');
    $ios_device_array = array('0');
    for ($l=0; $l < count($dataArray) ; $l++) {
        $app_menu_id_array[] = $dataArray[$l]['app_menu_id'];
        if (strtolower($dataArray[$l]['device']) =='android') {
            $android_device_array[] = $dataArray[$l]['app_menu_id'];
        }else  if (strtolower($dataArray[$l]['device'])=='ios') {
            $ios_device_array[] = $dataArray[$l]['app_menu_id'];
        }else {
            $general_device_array[] = $dataArray[$l]['app_menu_id'];
        }
    }
    $android_device_array = implode(",", $android_device_array);
    $and_qry=$d->selectRow("parent_menu_id,app_menu_id,menu_title,menu_click,ios_menu_click,menu_icon,menu_icon_ios,menu_sequence,tutorial_video","resident_app_menu","menu_status='0' AND menu_status_android='0' AND parent_menu_id in ($android_device_array) ");
    $AArray = array();
    $Acounter = 0 ;
    foreach ($and_qry as  $value) {
        foreach ($value as $key => $valueNew) {
            $AArray[$Acounter][$key] = $valueNew;
        }
        $Acounter++;
    }
    $and_data = array();
    for ($an=0; $an < count($AArray) ; $an++) {
        $and_data[$AArray[$an]['parent_menu_id']][] = $AArray[$an];
    }
    $ios_device_array = implode(",", $ios_device_array);
    $ios_qry=$d->selectRow("parent_menu_id,app_menu_id,menu_title,menu_click,ios_menu_click,menu_icon,menu_icon_ios,menu_sequence,tutorial_video","resident_app_menu","menu_status='0' AND menu_status_ios='0' AND parent_menu_id in ($ios_device_array) ");
    $IArray = array();
    $Icounter = 0 ;
    foreach ($ios_qry as  $value) {
        foreach ($value as $key => $valueNew) {
            $IArray[$Icounter][$key] = $valueNew;
        }
        $Icounter++;
    }
    $ios_data = array();
    for ($ios=0; $ios < count($IArray) ; $ios++) {
        $ios_data[$IArray[$ios]['parent_menu_id']][] = $IArray[$ios];
    }
    $general_device_array = implode(",", $general_device_array);

    $gen_qry=$d->selectRow("parent_menu_id,app_menu_id,menu_title,menu_click,ios_menu_click,menu_icon,menu_icon_ios,menu_sequence,tutorial_video","resident_app_menu","menu_status='0' AND parent_menu_id in ($general_device_array) ");
    $GArray = array();
    $Gcounter = 0 ;
    foreach ($gen_qry as  $value) {
        foreach ($value as $key => $valueNew) {
            $GArray[$Gcounter][$key] = $valueNew;
        }
        $Gcounter++;
    }
    $gen_data = array();
    for ($gen=0; $gen < count($GArray) ; $gen++) {
        $gen_data[$GArray[$gen]['parent_menu_id']][] = $GArray[$gen];
    }
  /*echo "<pre>"; 
                    print_r($gen_data);
                    exit; */ 
    //code optimize
                    if(count($dataArray)>0){
                       $appmenu_sub = array();
                       for ($l=0; $l < count($dataArray) ; $l++) {
                        $data_app=$dataArray[$l];
                        $appmenu=array();
                        $appmenu["app_menu_id"]=$data_app["app_menu_id"];
                        $appmenu["menu_title"]=$data_app["menu_title"];
                        $appmenu["menu_click"]=$data_app["menu_click"];
                        $appmenu["ios_menu_click"]=$data_app["ios_menu_click"];
                        if($_POST['version_code'] > 21 && strtolower($device)=='android'){
                            $appmenu["menu_icon"]=$base_url."img/app_icon/".$data_app["menu_icon_new"];
                        } else{
                            $appmenu["menu_icon"]=$base_url."img/app_icon/".$data_app["menu_icon"];
                        }
                        if($_POST['version_code'] > 14 && strtolower($device)=='ios'  ){
                            $appmenu["menu_icon_ios"]=$base_url."img/app_icon/".$data_app["menu_icon_new"];
                        } else {
                           $appmenu["menu_icon_ios"]=$base_url."img/app_icon/".$data_app["menu_icon_ios"];
                       }
                       $appmenu["menu_sequence"]=$data_app["menu_sequence"];
                       $appmenu["tutorial_video"]=$data_app["tutorial_video"].'';
                       if ($data_app["is_new"]==1) {
                          $appmenu["is_new"]=true;
                      } else {
                        $appmenu["is_new"]=false;
                    }
                    $appmenu["appmenu_sub"] = array();
                    if (strtolower($device) =='android') {
                       $sub_data_arr =  $and_data[$data_app[app_menu_id]];
                   }else  if (strtolower($device)=='ios') {
                       $sub_data_arr =  $ios_data[$data_app[app_menu_id]];
                   }else {
                    $sub_data_arr =  $gen_data[$data_app[app_menu_id]];
                }
                for ($sub=0; $sub < count($sub_data_arr) ; $sub++) { 
                  $subData= $sub_data_arr[$sub];

                  $appmenu_sub["app_menu_id"]=$subData["app_menu_id"];
                  $appmenu_sub["menu_title"]=$subData["menu_title"];
                  $appmenu_sub["menu_click"]=$subData["menu_click"];
                  $appmenu_sub["ios_menu_click"]=$subData["ios_menu_click"];
                  $appmenu_sub["menu_icon"]=$base_url."img/app_icon/".$subData["menu_icon"];
                  $appmenu_sub["menu_icon_ios"]=$base_url."img/app_icon/".$appmenu_sub["menu_icon_ios"];
                  $appmenu_sub["menu_sequence"]=$subData["menu_sequence"];
                  $appmenu_sub["tutorial_video"]=$subData["tutorial_video"].'';
                  if ($subData["is_new"]==1) {
                      $appmenu_sub["is_new"]=true;
                  } else {
                    $appmenu_sub["is_new"]=false;
                }
                array_push($appmenu["appmenu_sub"], $appmenu_sub); 
            }
            array_push($response["appmenu"], $appmenu); 
        }
    }  
    //get menu end
    //get slider data start
    $qnotification=$d->selectRow("slider_id,slider_image,slider_description,slider_url,slider_mobile,slider_video_url,user_id","slider_master","status=0","order by RAND()");
    $response["slider"] = array();
    if(mysqli_num_rows($qnotification)>0  ){
        while($data_notification=mysqli_fetch_array($qnotification)) {
                            // print_r($data_notification);
            $slider = array(); 
            $slider["app_slider_id"]=$data_notification['slider_id'];
            $slider["slider_image_name"]=$base_url."img/sliders/".$data_notification['slider_image'];
            $slider["slider_description"]=$data_notification['slider_description'];
            $slider["slider_url"]=$data_notification['slider_url'].'';
            if ($data_notification['slider_mobile']!=0) {
                $slider["slider_mobile"]=$data_notification['slider_mobile'].'';
            } else {
                $slider["slider_mobile"]='';
            }
            $slider["slider_video_url"]=$data_notification['slider_video_url'].'';
            $slider["user_id"]=$data_notification['user_id'].'';
            array_push($response["slider"], $slider); 
        }
                    } /*else {
                        $slider = array(); 
                        array_push($response["slider"], $slider); 
                    }*/
    //get slider data end                
    //interested category person start
                    $user_employment_details = $d->select("business_sub_categories,user_employment_details"," business_sub_categories.business_sub_category_id =user_employment_details.business_sub_category_id and    user_employment_details.user_id = $user_id     ","");
                //order by RAND() limit 0,4
                    $user_employment_details_data = mysqli_fetch_array($user_employment_details);

                    $business_sub_category_id =$user_employment_details_data['business_sub_category_id'];
                    /*business_sub_ctagory_relation_master.business_sub_category_id = '$business_sub_category_id'  and */
                    $business_sub_ctagory_relation_master = $d->selectRow("users_master.user_first_name,users_master.user_last_name, users_master.user_id,user_employment_details.company_name,user_employment_details.company_contact_number,user_employment_details.gst_number,business_sub_categories.sub_category_name,user_employment_details.company_logo ,users_master.user_full_name,users_master.user_mobile,users_master.user_email,users_master.user_profile_pic ","business_sub_categories,business_sub_ctagory_relation_master,user_employment_details,users_master ","
                        users_master.user_id = user_employment_details.user_id and
                        user_employment_details.business_sub_category_id = business_sub_ctagory_relation_master.related_sub_category_id and
                        business_sub_ctagory_relation_master.business_sub_category_id = business_sub_categories.business_sub_category_id  and
                        business_sub_ctagory_relation_master.business_sub_category_id = '$business_sub_category_id'  and

                        business_sub_ctagory_relation_master.related_sub_category_id != '$business_sub_category_id' and 
                        users_master.user_id!=$user_id   and user_employment_details.user_id!=$user_id  AND users_master.office_member=0 AND users_master.active_status=0   group by users_master.user_id  order by rand() limit 4    ","");

                    $response["interestedUserDetails"] = array();
                    if(mysqli_num_rows($business_sub_ctagory_relation_master)  > 0    ){
                        while ($business_sub_ctagory_relation_master_data = mysqli_fetch_array($business_sub_ctagory_relation_master)) {
                           $uid = $business_sub_ctagory_relation_master_data["user_id"];

                           $userDetails = array();
                           $userDetails["user_id"] = $business_sub_ctagory_relation_master_data["user_id"];
                           $userDetails["user_full_name"] = $business_sub_ctagory_relation_master_data["user_full_name"];
                           $userDetails["short_name"] =strtoupper(substr($business_sub_ctagory_relation_master_data["user_first_name"], 0, 1).substr($business_sub_ctagory_relation_master_data["user_last_name"], 0, 1) );
                           $userDetails["type"] = "0";
                           $userDetails["user_mobile"] = $business_sub_ctagory_relation_master_data["user_mobile"];
                           $userDetails["user_email"] = $business_sub_ctagory_relation_master_data["user_email"];
                           $userDetails["company_name"] = html_entity_decode($business_sub_ctagory_relation_master_data["company_name"] );
                           $userDetails["company_contact_number"] = $business_sub_ctagory_relation_master_data["company_contact_number"];
                           if($business_sub_ctagory_relation_master_data["gst_number"] !=''){
                              $userDetails["gst_number"] = $business_sub_ctagory_relation_master_data["gst_number"];    
                          } else {
                              $userDetails["gst_number"] = '';
                          }
                          $userDetails["sub_category_name"] = $business_sub_ctagory_relation_master_data["sub_category_name"];
                          if($business_sub_ctagory_relation_master_data['user_profile_pic'] !=""){
                              $userDetails["user_profile_pic"] =$base_url . "img/users/members_profile/" . $business_sub_ctagory_relation_master_data['user_profile_pic'];
                          }else {
                              $userDetails["user_profile_pic"] ="";
                          }
                          if($business_sub_ctagory_relation_master_data['company_logo']!=''){
                              $userDetails["company_logo"] =$base_url . "img/users/company_logo/" . $business_sub_ctagory_relation_master_data['company_logo'];
                          } else {
                              $userDetails["company_logo"] ="";
                          }
                          array_push($response["interestedUserDetails"], $userDetails);
                      }
                } /*else {
                    $userDetails = array();
                    array_push($response["interestedUserDetails"], $userDetails);
                }*/
    //interest Bind start
                $user_interests = $d->select("interest_relation_master","member_id = $user_id","");
                $related_interest_id_array = array('0');
                while ($user_interests_data = mysqli_fetch_array($user_interests)) {
                    $related_interest_id_array[] = $user_interests_data['interest_id'];
                }
                $related_interest_id_array = implode(",", $related_interest_id_array);
                //order by RAND() limit 0,4

                $similar_interest_qry = $d->selectRow("users_master.user_first_name,users_master.user_last_name, users_master.user_id,user_employment_details.company_name,user_employment_details.company_contact_number,user_employment_details.gst_number,user_employment_details.company_logo ,users_master.user_full_name,users_master.user_mobile,users_master.user_email,users_master.user_profile_pic ","interest_relation_master,user_employment_details,users_master ","
                    users_master.user_id = user_employment_details.user_id and
                    users_master.user_id = interest_relation_master.member_id and
                    interest_relation_master.member_id !=$user_id  and 
                    interest_relation_master.interest_id in ($related_interest_id_array)  and users_master.user_id!=$user_id   and user_employment_details.user_id!=$user_id  AND users_master.office_member=0 AND users_master.active_status=0 group by   interest_relation_master.member_id     order by rand() limit 4   ","");

                $response["similarInterestUserArray"] = array();
                if(mysqli_num_rows($similar_interest_qry)  > 0    ){
                    while ($similar_interest_data = mysqli_fetch_array($similar_interest_qry)) {
                       $uid = $business_sub_ctagory_relation_master_data["user_id"];

                       $similarIntUserDetails = array();
                       $similarIntUserDetails["user_id"] = $similar_interest_data["user_id"];
                       $similarIntUserDetails["user_full_name"] = $similar_interest_data["user_full_name"];
                       $similarIntUserDetails["short_name"] =strtoupper(substr($similar_interest_data["user_first_name"], 0, 1).substr($data["user_last_name"], 0, 1) );
                       $similarIntUserDetails["type"] = "0";
                       $similarIntUserDetails["user_mobile"] = $similar_interest_data["user_mobile"];
                       $similarIntUserDetails["user_email"] = $similar_interest_data["user_email"];
                       $similarIntUserDetails["company_name"] = html_entity_decode($similar_interest_data["company_name"] );
                       $similarIntUserDetails["company_contact_number"] = $similar_interest_data["company_contact_number"];
                       if($similar_interest_data["gst_number"] !=''){
                          $similarIntUserDetails["gst_number"] = $similar_interest_data["gst_number"];    
                      } else {
                          $similarIntUserDetails["gst_number"] = '';
                      }

                      if($similar_interest_data['user_profile_pic'] !=""){
                          $similarIntUserDetails["user_profile_pic"] =$base_url . "img/users/members_profile/" . $similar_interest_data['user_profile_pic'];
                      }else {
                          $similarIntUserDetails["user_profile_pic"] ="";
                      }
                      if($similar_interest_data['company_logo']!=''){
                          $similarIntUserDetails["company_logo"] =$base_url . "img/users/company_logo/" . $similar_interest_data['company_logo'];
                      } else {
                          $similarIntUserDetails["company_logo"] ="";
                      }
                      array_push($response["similarInterestUserArray"], $similarIntUserDetails);
                  }
              }
    //interest bind end
    //set usage time start
              $today = date('Y-m-d');

              if($_POST['setUsage'] == 0 && $user_id != ''){
                $aUsage = array(
                    'user_id' => $user_id,
                    'usage_date_time' => $todayTime,
                );
                $d->insert("app_usage_master", $aUsage);
            }

    //set usage time end
            

           




                
             
            $response["status"]="200";
            echo json_encode($response);
        }else {
            $response["message"] = "No User Found.";
            $response["status"] = "201";
            echo json_encode($response);
            exit;
        }
    //interested category person end
    }   else {
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