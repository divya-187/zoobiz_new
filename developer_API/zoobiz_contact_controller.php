<?php
include_once 'lib.php';
if(isset($_POST) && !empty($_POST)){
    if ($key==$keydb) {
        $response = array();
        extract(array_map("test_input" , $_POST));
        $today = date('Y-m-d');
        if (isset($zoobiz_contacts) && $zoobiz_contacts=='zoobiz_contacts') {
            $user_mobile=mysqli_real_escape_string($con, $user_mobile);
            $otp=mysqli_real_escape_string($con, $otp);
            $q=$d->selectRow("fincasys_id,fincasys_mobile,fincasys_alternate_no,fincasys_email,fincasys_website,availble_time","zoobiz_contacts","fincasys_id ='1'");

            $user_data = mysqli_fetch_array($q);
            if($user_data==TRUE && mysqli_num_rows($q) == 1){
                //if($user_data['unit_status']!='4'  && $user_data['user_status']!='2'){

                $response["fincasys_id"]=$user_data['fincasys_id'];
                $response["fincasys_mobile"]=$user_data['fincasys_mobile'];
                $response["fincasys_alternate_no"]=$user_data['fincasys_alternate_no'];
                $response["fincasys_email"]=$user_data['fincasys_email'];
                $response["fincasys_website"]=$user_data['fincasys_website'];
                $response["availble_time"]=$user_data['availble_time'];


                $q=$d->selectRow("*","zoo_people_master,users_master","users_master.user_id =zoo_people_master.user_id");

                $response['zooPeople'] = array();
                while ($data3 = mysqli_fetch_array($q)) {
                    extract($data3);
                    $zooPeople = array();
                    if($data3['type'] == 'Partner'){
                        $zooPeople["title"] = $data3['people_name']; 
                        $zooPeople["userType"] =  "0";
                        $zooPeople["userId"] = $data3['user_id'];
                        if($user_profile_pic !=""){
                            $user_profile = $base_url . "img/users/members_profile/" . $user_profile_pic;
                        } else {
                            $user_profile = "";
                        }
                        $zooPeople["userProfile"] = $user_profile;
                        $zooPeople["userName"] = $user_full_name;
                        $short_name =strtoupper(substr($data3["user_first_name"], 0, 1).substr($data3["user_last_name"], 0, 1) );
                        $zooPeople["short_name"] = $short_name;
                        $zooPeople["from"] = "1";
                        $zooPeople["sentTo"] = "0";
                        $zooPeople["memberMobile"] = $user_mobile;
                        if($public_mobile == 0){
                            $public_mobile = true;
                        } else {
                            $public_mobile = false;
                        }
                        $zooPeople["publicMobile"] = $public_mobile;
                    } else {
                        $zooPeople["title"] = $data3['people_name']; 
                        $zooPeople["userType"] =  "1";
                        $zooPeople["userId"] = $data3['user_id'];
                        if($user_profile_pic !=""){
                            $user_profile = $base_url . "img/users/members_profile/" . $user_profile_pic;
                        } else {
                            $user_profile = "";
                        }
                        $zooPeople["userProfile"] = $user_profile;
                        $zooPeople["userName"] = $user_full_name;
                        $short_name =strtoupper(substr($data3["user_first_name"], 0, 1).substr($data3["user_last_name"], 0, 1) );
                        $zooPeople["short_name"] = $short_name;
                        $zooPeople["from"] = "1";
                        $zooPeople["sentTo"] = "0";
                        $zooPeople["memberMobile"] = $user_mobile;
                        if($public_mobile == 0){
                            $public_mobile = true;
                        } else {
                            $public_mobile = false;
                        }
                        $zooPeople["publicMobile"] = $public_mobile;
                    }
                    array_push($response["zooPeople"], $zooPeople); 
                }
                $response["message"]="Zoobiz Contact Data";
                $response["status"]="200";
                echo json_encode($response);
            } else {
                $response["message"]="Please Try Again";
                $response["status"]="201";
                echo json_encode($response);
            }
        } else if($_POST['send_feedback']=="send_feedback" ) {
            if ($feedback_msg=='') {
                $response["message"] = "Please Enter Your Message";
                $response["status"] = "201";
                echo json_encode($response);
                exit();
            }
            $maxsize    =50000000;
            $file11=$_FILES["attachment"]["tmp_name"];
            if (file_exists($file11)) {
                if(($_FILES['attachment']['size'] >= $maxsize) || ($_FILES["attachment"]["size"] == 0)) {
                    $response["message"]="Attachment too large. Must be less than 50 MB";
                    $response["status"]="201";
                    echo json_encode($response);
                    exit();
                }
                $extId = pathinfo($_FILES['attachment']['name'], PATHINFO_EXTENSION);
                $extAllow=array("mp4","m4a","m4v","f4v","f4a","m4b","m4r","f4b","mov","3gp","avi","png","jpg","jpeg","gif","JPG","JPEG","PNG");
                if(in_array($extId,$extAllow)) {
                    $temp = explode(".", $_FILES["attachment"]["name"]);
                    $attachment = "Support_".$name.round(microtime(true)) . '.' . end($temp);
                    move_uploaded_file($_FILES["attachment"]["tmp_name"], "../img/zoobizz_support/" . $attachment);
                } else {
                    $response["message"]="Invalid Attachment only Photo & Video are allowed.";
                    $response["status"]="201";
                    echo json_encode($response);
                    exit();
                }
            } else {
                $attachment="";
            }
            $m->set_data('name', $name);
            $m->set_data('email', $email);
            $m->set_data('mobile', $mobile);
            $m->set_data('feedback_msg', $feedback_msg);
            $m->set_data('subject', $subject);
            $m->set_data('attachment', $attachment);
            $m->set_data('feedback_date_time',  date("d-m-Y H:i"));
            $a = array(
                'name' => $m->get_data('name'),
                'email' => $m->get_data('email'),
                'mobile' => $m->get_data('mobile'),
                'feedback_msg' => $m->get_data('feedback_msg'),
                'subject' => $m->get_data('subject'),
                'attachment' => $m->get_data('attachment'),
                'feedback_date_time' => $m->get_data('feedback_date_time'),
            );
            $q = $d->insert("feedback_master", $a);
            if ($q == true) {
                $d->insert_myactivity($user_id,"0","","Feeddback Added.","activity.png");
                $response["message"] = "Thank You";
                $response["status"] = "200";
                echo json_encode($response);
            } else {
                $response["message"] = "wrong data.";
                $response["status"] = "201";
                echo json_encode($response);
            }
        } else if (isset($get_questions) && $get_questions=='get_questions') {
            $user_mobile=mysqli_real_escape_string($con, $user_mobile);
            $otp=mysqli_real_escape_string($con, $otp);
            $q=$d->selectRow("*","faq_master","");
            $response["question_arr"] = array();
            if(mysqli_num_rows($q) > 0 )  {

                while ($data3=mysqli_fetch_array($q)) {
                    $question_arr = array();

                    $question_arr["question"]=$data3['question'];
                    array_push($response["question_arr"], $question_arr);
                }

                $response["message"]="Data";
                $response["status"]="200";
                echo json_encode($response);
            } else {
                $response["message"]="No Question Found";
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
?>