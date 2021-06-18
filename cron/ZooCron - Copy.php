<?php  
/* $sms= file_get_contents("https://2factor.in/API/R1/?module=TRANS_SMS&apikey=2eb6de0f-3a58-11e9-8806-0200cd936042&to=9726686576&from=FINCAS&msg=demo100");
  $response["status"] = 200;
    $response["message"] = "Success";
      echo json_encode($response);*/
 date_default_timezone_set('Asia/Calcutta');

 
include '../zooAdmin/lib/dao.php';
include '../zooAdmin/lib/model.php';
include '../zooAdmin/fcm_file/user_fcm.php';

 

 



$d = new dao();
$m = new model();
$nResident = new firebase_resident();
$con=$d->dbCon();

 

require_once(dirname(__DIR__)."/zooAdmin/vendor/phpmailer/phpmailer/src/PHPMailer.php");
require_once(dirname(__DIR__)."/zooAdmin/vendor/phpmailer/phpmailer/src/SMTP.php");
require_once(dirname(__DIR__)."/zooAdmin/vendor/phpmailer/phpmailer/src/Exception.php"); 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


$mail = new PHPMailer(true);
$q=$d->select("email_configuration","");
$data=mysqli_fetch_array($q);
extract($data);


 if ($smtp_type!='') {
        $mail->$smtp_type();
    }else {
        $mail->isMail();
    }                      // Enable verbose debug output
                                            // Send using SMTP
    $mail->Host       = $email_smtp;                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = $sender_email_id;                     // SMTP username
    $mail->Password   = $email_password;                               // SMTP password


    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
    $mail->Port       = $email_port;                                    // TCP port  
    $mail->setFrom($sender_email_id, $sender_name);

    

extract(array_map("test_input" , $_POST));
$base_url=$m->base_url();

$current_date_time = date('Y-m-d H:i:s');

header('Access-Control-Allow-Origin: *'); //I have also tried the * wildcard and get the same response
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('content-type: application/json; charset=utf-8');
header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');

 

//$headers = apache_request_headers();

extract(array_map("test_input", $_POST));

//extract(array_map("test_input", $headers));

//$key = $m->api_key();

$response = array();

$todayDate = date('Y-m-d');

extract($_POST);
$result = 0 ;

$user_employment_details=$d->select("user_employment_details","","");
                $completed_users = array('0');

               while ($user_employment_details_data=mysqli_fetch_array($user_employment_details)) {
                $completed_users[] =$user_employment_details_data['user_id'];
               }

               $completed_users = implode(",", $completed_users);
               
                $q3=$d->select("users_master"," active_status= 0   and user_id not in ($completed_users)    ","");

if (mysqli_num_rows($q3) > 0      ) {
$result = 1 ;
    $response["booking"] = array();
    $incomp_user = array();
$to = array();
             while ($data=mysqli_fetch_array($q3)) {

                $first_day = date('Y-m-d', strtotime($data['register_date'] . ' +1 day'));
                $third_day = date('Y-m-d', strtotime($data['register_date'] . ' +3 day'));
                $fifth_day = date('Y-m-d', strtotime($data['register_date'] . ' +5 day'));
                $seventh_day = date('Y-m-d', strtotime($data['register_date'] . ' +7 day'));
                $tenth_day = date('Y-m-d', strtotime($data['register_date'] . ' +10 day'));

                if($todayDate == $first_day || $todayDate == $third_day || $todayDate == $fifth_day || $todayDate == $seventh_day || $todayDate == $tenth_day  ||1 ){


                    $incomp_user['user_full_name'] =  $data['salutation']." ". $data['user_full_name'];
                    $incomp_user['user_mobile'] = $data['user_mobile'];
                    $incomp_user['user_email'] = $data['user_email'];
                   
                    $user_full_name = $data['salutation']." ". $data['user_full_name'];
                    $user_mobile = $data['user_mobile'];
 $to[] ="divya@silverwingteam.com";// $data['user_email'];
  $user_email ="divya@silverwingteam.com";// $data['user_email'];

  if($user_mobile=="8600993639"){
    $mail->addAddress("ravaldivyaks@gmail.com");
  } else {
    $mail->addAddress($user_email);
  }
  //$mail->addAddress($user_email);

      $subject ="ZooBiz - Profile Compelte Reminder...!";
                    //email start

      $message= "<html>
            <head>
            <meta name='viewport' content='width=device-width, initial-scale=1.0' />
            <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
            <title>ZooBiz:  Profile Compelte Reminder</title>


            </head>
            <body style='-webkit-text-size-adjust: none; box-sizing: border-box; color: #74787E; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; height: 100%; line-height: 1.4; margin: 0; width: 100% !important;' bgcolor='#F2F4F6'><style type='text/css'>
            body {
              width: 100% !important; height: 100%; margin: 0; line-height: 1.4; background-color: #F2F4F6; color: #74787E; -webkit-text-size-adjust: none;
            }

            @media only screen and (max-width: 600px) {
              .email-body_inner {
                width: 100% !important;
              }
              .email-footer {
                width: 100% !important;
              }
            }
            @media only screen and (max-width: 500px) {
              .button {
                width: 100% !important;
              }
            }
            </style>
            <table class='email-wrapper' width='100%' cellpadding='0' cellspacing='0' style='box-sizing: border-box; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; margin: 0; padding: 0; width: 100%;' bgcolor='#F2F4F6'>
            <tr>
            <td   style='box-sizing: border-box; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; word-break: break-word;'>
            <table class='email-content' width='100%' cellpadding='0' cellspacing='0' style='box-sizing: border-box; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; margin: 0; padding: 0; width: 100%;'>
            <tr>
            </tr>

            <tr>
            <td class='email-body' width='100%' cellpadding='0' cellspacing='0' style='-premailer-cellpadding: 0; -premailer-cellspacing: 0; border-bottom-color: #EDEFF2; border-bottom-style: solid; border-bottom-width: 1px; border-top-color: #EDEFF2; border-top-style: solid; border-top-width: 1px; box-sizing: border-box; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; margin: 0; padding: 0; width: 100%; word-break: break-word;' bgcolor='#FFFFFF'>
            <table class='email-body_inner' align='center' width='570' cellpadding='0' cellspacing='0' style='box-sizing: border-box; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; margin: 0 auto; padding: 0; width: 570px;' bgcolor='#FFFFFF'>
            <tr>
            <td align='center'><img src='https://zoobiz.in/img/zoobizLogo.png' width='100'></td>
            </tr>    
            <tr>
            <td class='content-cell' style='box-sizing: border-box; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; padding: 35px; word-break: break-word;'>

            <h1 style='box-sizing: border-box; color: #2F3133; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; font-size: 19px; font-weight: bold; margin-top: 0;' >Hello <span style='color:red;'>$user_full_name</span> !</h1>
            <p style='box-sizing: border-box; color: #74787E; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; font-size: 16px; line-height: 1.5em; margin-top: 0;' >Please complete your zoobiz profile by login via your registered mobile number $user_mobile.</p>
            
           
            <table class='body-action'  width='100%' cellpadding='0' cellspacing='0' style='box-sizing: border-box; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; margin: 30px auto; padding: 0; text-align: center; width: 100%;'>
            <tr>
            <td  style='box-sizing: border-box; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; word-break: break-word;'>
            <table width='100%' border='0' cellspacing='0' cellpadding='0' style='box-sizing: border-box; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif;'>
            <tr>
            <td  style='box-sizing: border-box; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; word-break: break-word;'>
            <table border='0' cellspacing='0' cellpadding='0' style='box-sizing: border-box; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif;'>
            <tr>
            <td style='box-sizing: border-box; font-family: Arial,; border: 1px solid;padding: 10px;; word-break: break-word;' >
                <p style='box-sizing: border-box; color: #74787E; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; font-size: 16px; line-height: 1.5em; margin-top: 0;' >Please download the Zoobiz App from Play store/App store or click on below link <br> </p>
                <a href='$androidLink' style='text-decoration: none;border: 1px solid;padding: 5px;background: red;color: white;border-radius: 10px;'>Download Android App</a>  <a href='$iosLink' style='text-decoration: none;border: 1px solid;padding: 5px;background: red;color: white;border-radius: 10px;'>Download IOS App</a>
            </td>
            </tr>
            </table>
            <p style='box-sizing: border-box; color: #74787E; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; font-size: 16px; line-height: 1.5em; margin-top: 0;' >If you did not request a for account create, please ignore this email or <a href='mailto:contact@zoobiz.in' style='box-sizing: border-box; color: #3869D4; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif;'>contact support</a> if you have questions.</p>
            <p style='box-sizing: border-box; color: #74787E; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; font-size: 16px; line-height: 1.5em; margin-top: 0;' >Thanks,
            <br/>The ZooBiz Team</p>
             
            </td>
            </tr>
            </table>
            </td>
            </tr>
            <tr>
            <td style='box-sizing: border-box; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; word-break: break-word;'>
            <table class='email-footer'  width='570' cellpadding='0' cellspacing='0' style='box-sizing: border-box; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; margin: 0 auto; padding: 0; text-align: center; width: 570px;'>
            <tr>
            <td class='content-cell'  style='box-sizing: border-box; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; padding: 35px; word-break: break-word;'>
            <p class='sub align-center' style='box-sizing: border-box; color: #AEAEAE; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; font-size: 12px; line-height: 1.5em; margin-top: 0;' align='center'>© ".date("Y")."  ZooBiz. All rights reserved.</p>
            <p class='sub align-center' style='box-sizing: border-box; color: #AEAEAE; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; font-size: 12px; line-height: 1.5em; margin-top: 0;' align='center'>
            ZooBiz
            </p>
            </td>
            </tr>
            </table>
            </td>
            </tr>
            </table>
            </td>
            </tr>
            </table>
            </body>
            </html>";
// include '../zooAdmin/mail.php';

   
           
 
/*  $fields = array(
            'to'=> $to,
            'subject' =>  $subject,
             'message'    => $message
        );
 $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://dev.zoobiz.in/mail_front.php');
        curl_setopt($ch, CURLOPT_POST, true); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
       $result = curl_exec($ch);
       echo  $result;exit;
        curl_close($ch);*/

           //    $d->send_email_curl($to,$subject,$message);


               
       
//include '../mail_front.php';
       // include '../zooAdmin/mail.php';

                    //email end
                    $notiAry = array(
                      'admin_id'=>0,
                      'notification_tittle'=>"Reminder Email Send",
                      'notification_description'=>"Profile Compelte Reminder send to ".$incomp_user['user_full_name'],
                      'notifiaction_date'=>date('Y-m-d H:i'),
                      'notification_action'=>'',
                      'admin_click_action '=>'profileCompleteReminder'
                    );
                    $d->insert("admin_notification",$notiAry);


               
 }

                array_push($response['booking'], $incomp_user);
                 
             }
// $to = implode(",", $to);
             
 

 /* if(is_array($to)){
       foreach($to as $add)
        {  
          $mail->addAddress($add);
        }   
    } else {
         
        $mail->addAddress($to);  
    }*/
      
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $subject;
      $mail->Body    = $message;
    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();


 }  




$today=date("Y-m-d");
$promotion_master=$d->select("promotion_master","status=0 and event_date>='$today' ","");
$promotion_array = array();
  while ($data=mysqli_fetch_array($promotion_master)) {
        $promotion_array[] =$data;
  }
 

     $fcmArray=$d->get_android_fcm("users_master","user_token!='' AND  device='android' and user_status=0 and user_id in (115,112)  ");
         
        $fcmArrayIos=$d->get_android_fcm("users_master "," user_token!='' AND  device='ios' and user_status=0 and user_id in (115,112)   ");


         
            $response["booking"] = array();
 
            for ($p=0; $p < count($promotion_array) ; $p++) { 
                 $result = 1 ;
                $data = $promotion_array[$p];
                 $before_2_days = date('Y-m-d', strtotime($data['event_date'] . ' -2 day'));
                $same_day = date('Y-m-d', strtotime($data['event_date']));
              
               if(strtotime($before_2_days) == strtotime($today) || strtotime($same_day) == strtotime($today) ){
                 $title= $data['event_name'];
                 $description= $data['description'];

                if($data['event_frame']!=''){
                    $notiUrl = $base_url.'img/promotion/'. $data['event_frame'];
                } else {
                    $notiUrl = $base_url.'img/app_icon/ic_greetings.png';
                }
                
                $nResident->noti("promote_business",$notiUrl,0,$fcmArray,$title,$description,'PromoteBusinessVC');
                   
                
                     $nResident->noti_ios("promote_business",$notiUrl,0,$fcmArrayIos,$title,$description,"PromoteBusinessVC");
                 
                

                }
               
           
         
  
      
 }
  

if($result !=1){
    $response["status"] = 201;
    $response["message"] = "No data to execute";
    echo json_encode($response);
} else {
    $response["status"] = 200;
    $response["message"] = "Success";
      echo json_encode($response);
} 

       ?>
