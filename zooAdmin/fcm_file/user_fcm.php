<?php
error_reporting(0);
class firebase_resident
{
    
    function  noti($menuClick,$image,$society_id,$registrationIds, $title, $body, $activity,$is_profile = 0,$profile=NULL,$short_name=NULL)
    {
        $title = html_entity_decode($title);
         $body = html_entity_decode($body);
       /* if (is_array($registrationIds)) {
            $registrationIds=$registrationIds;
        } else {
            $registrationIds = array($registrationIds);
            $registrationIds = array_unique($registrationIds);
        }*/

        

        if (is_array($registrationIds)) {
            $registrationIds=$registrationIds;
            $registrationIds = array_unique($registrationIds);
            $registrationIds = array_values($registrationIds);

             /* //15february2021
          $d = new dao();
        $today_date_for_token = date('Y-m-d');
         for ($xd=0; $xd <count($registrationIds) ; $xd++) { 
             $users_master_token_qry = $d->select("users_master, user_employment_details"," user_employment_details.user_id =users_master.user_id and   users_master.user_token = '$registrationIds[$xd]' ");
             $users_master_token_data = mysqli_fetch_array($users_master_token_qry);
              
             if( $today_date_for_token > $users_master_token_data['plan_renewal_date']){
                        $pos = array_search($users_master_token_data['user_token'], $registrationIds);
                        unset($registrationIds[$pos]);
                      }
         }
        //15february2021
         $registrationIds = implode(",", $registrationIds);
          $registrationIds = explode(",", $registrationIds);

 */
        
 //$registrationIds = array($registrationIds);


           $d = new dao();
        $today_date_for_token = date('Y-m-d');
         for ($xd=0; $xd <count($registrationIds) ; $xd++) { 
             $users_master_token_qry = $d->select("users_master, user_employment_details"," user_employment_details.user_id =users_master.user_id and   users_master.user_token = '$registrationIds[$xd]' ");
             $users_master_token_data = mysqli_fetch_array($users_master_token_qry);
              if( $users_master_token_data['business_category_id'] == '-1' && $users_master_token_data['business_sub_category_id'] == '-1' ){
                        $pos = array_search($users_master_token_data['user_token'], $registrationIds);
                        unset($registrationIds[$pos]);
              }
         }
          $registrationIds = implode(",", $registrationIds);
          $registrationIds = explode(",", $registrationIds);
        } else {
            $registrationIds = array($registrationIds);
        }

 

        if ($image=='' && $profile=='') {
            $image= "https://www.zoobiz.in/img/logo.png";
        }

        if ($image=='' ) {
            $image= "https://www.zoobiz.in/img/logo.png";
        }

        
        define('API_ACCESS_KEY', 'AAAA-0MhEyc:APA91bHRxzp9RlZPFa_4jF0cfGN6nQCYKt15iSNqlaHA2uOKglSizt0e77iQmlF3E5PFJ3Rm9tVE-TgT75u8PaKrJ9Ip-LLjSC9TQQ7IBBNhqJBCFIrwyNGBs-Pd6v0sIClNKChWyoR5');
           
        $alert = array(
             'body'  => $body,
            'click_action'     => $activity,
            'title'    => $title,
            'society_id' => $society_id,
            'sound'=>'iphone_notification',
        );


        $data = array(
            'menuClick' => $menuClick,
            'image' => $image,
            'body'     => $body,
            'click_action'     => $activity,
            'title'    => $title,
            'society_id' => $society_id,
            'sound'=>'iphone_notification',
            'is_profile' =>$is_profile,
            'profile' =>$profile,
            'short_name' =>$short_name
        );
    
        $fields = array(
            'title'=> $title,
            'registration_ids' =>  $registrationIds,
             // 'notification'     => $alert,
             'priority' => 'high',
             'data'    => $data
        );
   /*if($title=="ZooBiz"){
    echo "<pre>";print_r($registrationIds);
 
echo "<pre>";print_r(json_encode($fields));
             
        }*/
        // echo "<pre>";print_r( json_encode($fields));
         $headers = array(
            'Authorization: key=' . API_ACCESS_KEY,
            'Content-Type: application/json'
        );
        #Send Reponse To FireBase Server    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        /*if($title=="ZooBiz"){
              echo "<pre>";print_r($registrationIds);
 
echo "<pre>";print_r(json_encode($fields));
echo "<pre>";print_r($result);
            exit;
        }*/
        curl_close($ch);
        $result = json_decode($result, true);

      //  echo "<pre>";print_r( $result);exit;
        $re = $result['success'];
        if ($re == 1) {
            // header("location:$url");
            return true;
        } else {
            // header("location:$url");
            return false;
        }
    }
    function  noti_ios($menuClick,$image,$society_id,$registrationIds, $title, $body, $activity,$is_profile = 0, $profile =NULL, $short_name =NULL)
    {


      $title = html_entity_decode($title);
         $body = html_entity_decode($body);

         
        if (is_array($registrationIds)) {
            $registrationIds=$registrationIds;
            $registrationIds = array_unique($registrationIds);
          //   $registrationIds = array_values($registrationIds);

               //15february2021
         /* $d = new dao();
        $today_date_for_token = date('Y-m-d');
         for ($xd=0; $xd <count($registrationIds) ; $xd++) { 
             $users_master_token_qry = $d->select("users_master, user_employment_details"," user_employment_details.user_id =users_master.user_id and   users_master.user_token = '$registrationIds[$xd]' ");

             
             $users_master_token_data = mysqli_fetch_array($users_master_token_qry);
              
             if( $today_date_for_token > $users_master_token_data['plan_renewal_date']){
                        $pos = array_search($users_master_token_data['user_token'], $registrationIds);
                        unset($registrationIds[$pos]);
                      }
         }
        //15february2021
$registrationIds = implode(",", $registrationIds);
          $registrationIds = explode(",", $registrationIds);*/
//$registrationIds = array($registrationIds);


           $d = new dao();
        $today_date_for_token = date('Y-m-d');
         for ($xd=0; $xd <count($registrationIds) ; $xd++) { 
             $users_master_token_qry = $d->select("users_master, user_employment_details"," user_employment_details.user_id =users_master.user_id and   users_master.user_token = '$registrationIds[$xd]' ");
             $users_master_token_data = mysqli_fetch_array($users_master_token_qry);
              if( $users_master_token_data['business_category_id'] == '-1' && $users_master_token_data['business_sub_category_id'] == '-1' ){
                        $pos = array_search($users_master_token_data['user_token'], $registrationIds);
                        unset($registrationIds[$pos]);
              }
         }
          $registrationIds = implode(",", $registrationIds);
          $registrationIds = explode(",", $registrationIds);
        } else {
            $registrationIds = array($registrationIds);
        }
 
       // echo "<pre>";print_r( $registrationIds); 
        if ($image=='') {
            $image= "https://www.zoobiz.in/img/logo.png";
        }
        define('API_ACCESS_KEY', 'AAAA-0MhEyc:APA91bHRxzp9RlZPFa_4jF0cfGN6nQCYKt15iSNqlaHA2uOKglSizt0e77iQmlF3E5PFJ3Rm9tVE-TgT75u8PaKrJ9Ip-LLjSC9TQQ7IBBNhqJBCFIrwyNGBs-Pd6v0sIClNKChWyoR5');
          
        if ($title=='sos') {
            $alert = array(
                'body'  => $body,
                'click_action'     => $activity,
                'title'    => $title,
                'society_id' => $society_id,
                'sound'=>'beep_beep_beep.caf',
                'image' => $image,
                'menuClick' => $menuClick,
                'style' => 'picture',
                'picture' => $image,
            );
        } else if ($title=='New Visitor Arrived') {
            $alert = array(
                'body'  => $body,
                'click_action'     => $activity,
                'title'    => $title,
                'society_id' => $society_id,
                'sound'=>'Doorbell.caf',
                'image' => $image,
                'menuClick' => $menuClick,
                'style' => 'picture',
                'picture' => $image,
            );

        } else {
            $alert = array(
                'body'  => $body,
                'click_action'     => $activity,
                'title'    => $title,
                'society_id' => $society_id,
                'sound'=>'just-saying.caf',
                'image' => $image,
                'menuClick' => $menuClick,
                'style' => 'picture',
                'picture' => $image,
                'is_profile' =>$is_profile,
                'profile' =>$profile,
                'short_name' =>$short_name
            );
        }   

        $data = array(
            'image' =>$image,
            'body'     => $body,
            'click_action'     => $activity,
            'title'    => $title,
            'society_id' => $society_id,
            'menuClick' => $menuClick,
            'is_profile' =>$is_profile,
            'profile' =>$profile,
            'short_name' =>$short_name
        );
      
        $fields = array(
             'title'=> $title,
             'registration_ids' =>  $registrationIds,
             'priority' => 'high',
             'notification' => $alert,
             'data'    => $data
        );

      //   echo "<pre>";print_r( json_encode($fields)); 
        $headers = array(
            'Authorization: key=' . API_ACCESS_KEY,
            'Content-Type: application/json'
        );
        #Send Reponse To FireBase Server    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
 /* if($title=="ZooBiz"){
    echo "<pre>";print_r($registrationIds);
 
echo "<pre>";print_r(json_encode($fields));
             
        }

        if($title=="ZooBiz"){
echo "<pre>";print_r($result);
            exit;
        }*/ 
        //echo "<pre>";print_r($result );exit;
        curl_close($ch);
        $result = json_decode($result, true);
        $re = $result['success'];
        if ($re == 1) {
            // header("location:$url");
            return true;
        } else {
            // header("location:$url");
            return false;
        }
    }
}
