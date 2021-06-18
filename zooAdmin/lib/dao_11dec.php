<?php
include_once 'dbconnect.php';
include_once  'interface1.php';

class dao implements interface1 
{    
    private $conn;
    function __construct() 
    {
        //include_once './config.php';
       
        $db=new DbConnect();
        $this->conn=$db->connect();
    }

    function dbCon() {
      $db=new dbconnect();
      return  $this->conn=$db->connect();
    }

//5oct2020
    function cpn_code($limit=8){
        $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            $res = "ZB";
            for ($i = 0; $i < $limit; $i++) {
                $res .= $chars[mt_rand(0, strlen($chars)-1)];
            }

            $coupon_master=$this->select("coupon_master"," coupon_code ='$res'  ","");
            
             if(mysqli_num_rows($coupon_master) > 0  ){
                $this->cpn_code($limit);
             } else {
                return $res;
             }

            
    }
//5oct2020
    
    //data insert funtion
    function insert($table,$value)
    {
        $field="";
        $val="";
        $i=0;
        
        foreach ($value as $k => $v)
        {
            $v = $this->conn->real_escape_string($v);
            if($i == 0)
            {
                $field.=$k;
                $val.="'".$v."'";
            }
            
            else 
            {
                $field.=",".$k;
                $val.=",'".$v."'";
                
            }
            $i++;
            
        }
        mysqli_set_charset($this->conn,"utf8mb4");
        return mysqli_query($this->conn,"INSERT INTO $table($field) VALUES($val)") or die(mysqli_error($this->conn));
    }
    
    // insert log
    function insert_log($recident_user_id,$society_id,$user_id,$user_name,$log_name)
    {   
      $log_name = $this->conn->real_escape_string($log_name);
      $user_name = $this->conn->real_escape_string($user_name);
        $now=date("y-m-d H:i:s");
        $val="'$user_id','$user_name','$log_name','$now'";
        mysqli_set_charset($this->conn,"utf8mb4");
        return mysqli_query($this->conn,"INSERT INTO log_master(user_id,user_name,log_name,log_time) VALUES($val)") or die(mysqli_error($this->conn));
    }


     function insertFollowNotification($title,$description,$timeline_id,$other_user_id,$type,$click_action)
    { 
      
       date_default_timezone_set('Asia/Calcutta');
        $today=date('Y-m-d H:i');
          
        mysqli_set_charset($this->conn,"utf8mb4");

        //4nov 2020
        /*return mysqli_query($this->conn,"INSERT INTO user_notification(user_id,notification_title,notification_desc,notification_date,notification_action,notification_logo,notification_type,other_user_id,timeline_id) SELECT users_master.user_id, '$title','$description','$today','$click_action','','$type','$other_user_id','$timeline_id' FROM users_master,follow_master  WHERE users_master.user_id=follow_master.follow_by AND follow_master.follow_to='$other_user_id'") or die(mysqli_error($this->conn));*/


         return mysqli_query($this->conn,"INSERT INTO user_notification(user_id,notification_title,notification_desc,notification_date,notification_action,notification_logo,notification_type,timeline_id,other_user_id) SELECT users_master.user_id, '$title','$description','$today','$click_action','','$type','$timeline_id','$other_user_id' FROM users_master,follow_master  WHERE users_master.user_id=follow_master.follow_by AND follow_master.follow_to='$other_user_id'") or die(mysqli_error($this->conn));


    }

    //17SEPT2020
    function insertAllUserNotification($title,$description,$notification_action,$notification_icon=null,$append_query=null,$notification_type=0)
    { 

       
       date_default_timezone_set('Asia/Calcutta');
        $today=date('Y-m-d H:i');

        if ($append_query!="") {
            $append_query= "AND ".$append_query;
        }
          
        $title = $this->conn->real_escape_string($title);
        $description = $this->conn->real_escape_string($description);
        mysqli_set_charset($this->conn,"utf8mb4");
     return mysqli_query($this->conn,"INSERT INTO user_notification(user_id,notification_title,notification_desc,notification_date,notification_action,notification_logo,notification_type) SELECT   user_id,'$title','$description','$today','$notification_action','$notification_icon','$notification_type' FROM users_master   WHERE  active_status = 0 $append_query ") or die(mysqli_error($this->conn));
    }
    //17SEPT2020

    //using insert funtion for procedures 
    function insert1($table, $value)
    {
        $field="";
        $val="";
        $i = 0;
        
          foreach($value as $k => $v)
          {
            $v = $this->conn->real_escape_string($v);
              if($i==0)
             
               {
                  $field.=$k;
                  $val.="'" . $v . "'";
              }
              else 
              {
                  $field.="," . $k ;
                  $val.=", '" . $v . "'";
              }
              $i++;
          }
          mysqli_set_charset($this->conn,"utf8mb4");
          return mysqli_query($this->conn,"CALL $table($val)")or die(mysqli_error($this->conn));;
    }
    
      //select funtion display data
    function select($table, $where='', $other='')
    {
        if($where != '')
        {
            $where= 'where ' .$where;
        }
        mysqli_set_charset($this->conn,"utf8mb4");
        $select = mysqli_query($this->conn,"SELECT * FROM $table $where $other") or die(mysqli_error($this->conn));
        return $select;
    }

    function getRecentChatMember($table, $user_id)
    {
        
        mysqli_set_charset($this->conn,"utf8mb4");
        $select = mysqli_query($this->conn,"SELECT msg_for, MAX(max_date) AS max_date FROM( (SELECT chat_id,msg_by, msg_for, MAX(msg_date) AS max_date FROM $table WHERE msg_by = $user_id AND sent_to=0 AND send_by=0 GROUP BY msg_by, msg_for ORDER BY `max_date` DESC) union all (SELECT chat_id, msg_for,msg_by, MAX(msg_date) AS max_date FROM $table WHERE msg_for = $user_id AND sent_to=0 AND send_by=0 GROUP BY msg_by, msg_for ORDER BY `max_date` DESC) ) as newdata group by msg_for ORDER BY `max_date` DESC ") or die(mysqli_error($this->conn));
        return $select;
    }

     function getRecentChatMemberNew($table, $user_id)
    {
        
        mysqli_set_charset($this->conn,"utf8mb4");
         $select = mysqli_query($this->conn,"SELECT cm.*,um.salutation,um.user_full_name,um.user_first_name,um.user_last_name, um.gender, um.user_status, um.user_mobile, um.public_mobile, um.member_date_of_birth, um.user_profile_pic, um.member_status from(SELECT MAX(a.chat_id) as chat_id, a.msg_by as user_id , MAX(msg_date) as msg_date from( (SELECT MAX(chat_id) as chat_id, MAX(msg_date) as msg_date, msg_by from $table where msg_for = $user_id and send_by=0 and sent_to=0 GROUP by msg_by Order by chat_id desc) union all (SELECT MAX(chat_id) as chat_id, MAX(msg_date) as msg_date, msg_for from $table where msg_by= $user_id and send_by=0 and sent_to=0 GROUP by msg_for Order by chat_id desc)) as a GROUP by msg_by Order by chat_id desc) as f inner join $table as cm on cm.chat_id=f.chat_id inner join users_master as um on um.user_id=f.user_id  ") or die(mysqli_error($this->conn));
        return $select;
    }

    function getRecentChatGatekeeper($table, $user_id)
    {
        
        mysqli_set_charset($this->conn,"utf8mb4");
        $select = mysqli_query($this->conn,"SELECT msg_for, MAX(max_date) AS max_date FROM( (SELECT chat_id,msg_by, msg_for, MAX(msg_date) AS max_date FROM $table WHERE msg_by = $user_id AND sent_to=1 GROUP BY msg_by, msg_for ORDER BY `max_date` DESC) union all (SELECT chat_id, msg_for,msg_by, MAX(msg_date) AS max_date FROM $table WHERE msg_for = $user_id AND send_by=1 GROUP BY msg_by, msg_for ORDER BY `max_date` DESC) ) as newdata group by msg_for ORDER BY `max_date` DESC ") or die(mysqli_error($this->conn));
        return $select;
    }

    function getRecentChatGatekeeperToUser($table, $emp_id)
    {
        
        mysqli_set_charset($this->conn,"utf8mb4");
        $select = mysqli_query($this->conn,"SELECT cm.*,um.user_full_name,um.user_first_name,um.user_last_name, um.gender, um.user_type, um.user_status, um.user_mobile, um.mobile_for_gatekeeper, um.member_date_of_birth, um.user_profile_pic, um.member_status, un.unit_name, un.unit_status, un.unit_id, un.floor_id, bm.block_name from(SELECT MAX(a.chat_id) as chat_id, a.msg_by as user_id , MAX(msg_date) as msg_date from( (SELECT MAX(chat_id) as chat_id, MAX(msg_date) as msg_date, msg_by from $table where msg_for = $emp_id and send_by=0 and sent_to=1 GROUP by msg_by Order by chat_id desc) union all (SELECT MAX(chat_id) as chat_id, MAX(msg_date) as msg_date, msg_for from $table where msg_by= $emp_id and send_by=1 and sent_to=0 GROUP by msg_for Order by chat_id desc)) as a GROUP by msg_by Order by chat_id desc) as f inner join $table as cm on cm.chat_id=f.chat_id inner join users_master as um on um.user_id=f.user_id inner join unit_master as un on un.unit_id=um.unit_id inner join block_master as bm on bm.block_id=um.block_id ") or die(mysqli_error($this->conn));
        return $select;
    }
      //select funtion display data
    function selectRow($colum,$table, $where='', $other='')
    {
        if($where != '')
        {
            $where= 'where ' .$where;
        }
        mysqli_set_charset($this->conn,"utf8mb4");
        $select = mysqli_query($this->conn,"SELECT $colum FROM $table $where $other") or die(mysqli_error($this->conn));
        return $select;
    }
    function select_row($table, $where='', $other='')
    {
        if($where != '')
        {
            $where= 'where ' .$where;
        }
        mysqli_set_charset($this->conn,"utf8mb4");
        $select = mysqli_query($this->conn,"SELECT COUNT(*) as num_rows FROM $table $where $other") or die(mysqli_error($this->conn));
        return $select;
    }
     //select funtion display data with DISTINCT  (not show duplicate)
    function select1($table, $column, $where='',$other='')
    {
        if($where != '')
        {
            $where= 'where ' .$where;
        }
        mysqli_set_charset($this->conn,"utf8mb4");
        $select = mysqli_query($this->conn,"SELECT DISTINCT $column FROM $table $where $other") or die(mysqli_error($this->conn));
        return $select;
    }
    function select2($table, $where='',$other='')
    {
        if($where != '')
        {
            $where= 'where ' .$where;
        }
        mysqli_set_charset($this->conn,"utf8mb4");
        $select = mysqli_query($this->conn,"SELECT DISTINCT * FROM $table $where $other") or die(mysqli_error($this->conn));
        return $select;
    }
    function selectColumnWise($table,$columnName='',$where=''){
        if($where != '')
        {
           $where= 'where ' .$where;
        }
        mysqli_set_charset($this->conn,"utf8mb4");
         $select = mysqli_query($this->conn,"SELECT $columnName FROM $table $where") or die(mysqli_error($this->conn));
        return $select;
    }
  
    // using sp   
    function selectSp($spName) {

      mysqli_set_charset($this->conn, "utf8mb4");
      $result = mysqli_query($this->conn, "CALL $spName");
      return $result;
      // return mysqli_query($this->conn,"CALL $table")or die(mysqli_error($this->conn));;
    }
   
    function selectSpArray($spName) {

      $dataArray=array();
      mysqli_set_charset($this->conn, "utf8mb4");
      $result = mysqli_query($this->conn, "CALL $spName");
      while($data_countries_list=mysqli_fetch_array($result)) {
        array_push($dataArray, $data_countries_list);
      }
      mysqli_next_result($this->conn);
      return $dataArray;
      // return mysqli_query($this->conn,"CALL $table")or die(mysqli_error($this->conn));;
    }
      //delete using update query(active_flag)
     function delete1($table ,$var, $where)
    {
        if($where != '')
        {
            $where= 'where ' .$where;
        }
        if($var != '')
        {
            $var= 'active_flag= ' .$var;
        }
        mysqli_set_charset($this->conn,"utf8mb4");
        return mysqli_query($this->conn,"update $table set $var $where");
    }

    //Update Product View (view_status)
     function view_status($table ,$var, $where)
    {
        if($where != '')
        {
            $where= 'where ' .$where;
        }
        if($var != '')
        {
            $var= 'view_status= ' .$var;
        }
        mysqli_set_charset($this->conn,"utf8mb4");
        return mysqli_query($this->conn,"update $table set $var $where");
    }


     //Comment ()
     function comment($table ,$var, $where)
    {
        if($where != '')
        {
            $where= 'where ' .$where;
        }
        if($var != '')
        {
            $var= 'status= ' .$var;
        }
        mysqli_set_charset($this->conn,"utf8mb4");
        return mysqli_query($this->conn,"update $table set $var $where");
    }
     //delete permanataly  function
    function delete($table , $where='')
    {
        if($where != '')
        {
        $where= 'where ' .$where;
        }
        mysqli_set_charset($this->conn,"utf8mb4");
        return mysqli_query($this->conn,"delete FROM $table $where")or die(mysqli_error($this->conn));
    }

    //Upadate funtion
    function update($table ,$value, $where)
    {
        if($where != '')
        {
            $where= 'where ' .$where;
        }


        $val="";
        $i=0;
        foreach ($value as $k => $v)
        {
            $v = $this->conn->real_escape_string($v);
            if($i == 0)
            {
              $val.=$k."='".$v."'";    
            }
            
            else 
            {
              $val.=",".$k."='".$v."'";
            }
            $i++;
            
        }
        mysqli_set_charset($this->conn,"utf8mb4");
        return mysqli_query($this->conn,"update $table SET $val $where");
    }
     //select next auto_increment_id
    function last_auto_id($table)
    {
        mysqli_set_charset($this->conn,"utf8mb4");
        $select_id = mysqli_query($this->conn,"SHOW TABLE STATUS LIKE '$table'" ) or die(mysqli_error($this->conn));
        return $select_id;
    }

        //Count Data of Table
    function count_data($field='' ,$table ,$where='')
    {
        if($where != '')
        {
            $where= 'where ' .$where;
        }
        mysqli_set_charset($this->conn,"utf8mb4");
        $count_data = mysqli_query($this->conn,"SELECT $field,COUNT(*)  FROM $table $where" ) or die(mysqli_error($this->conn));
        return $count_data;

    }

    //Count Data of Table
    function count_data_direct($field='' ,$table ,$where='')
    {
        if($where != '')
        {
            $where= 'where ' .$where;
        }
        mysqli_set_charset($this->conn,"utf8mb4");
        // $temp = mysqli_query($this->conn,"SELECT $field,COUNT(*)  FROM $table $where" ) or die(mysqli_error($this->conn));
        // while($rowCount=mysqli_fetch_array($temp)) {
        // $totalCount=$rowCount['COUNT(*)'];
        
        $result=mysqli_query($this->conn,"SELECT count(*) as $field from $table $where") or die(mysqli_error($this->conn));
        $data=mysqli_fetch_assoc($result);
        $totalCount= $data[$field];
        return $totalCount;
        // }

    }
     //Count sum of  Table field
    function sum_data($field='' ,$table ,$where='')
    {
        if($where != '')
        {
            $where= 'where ' .$where;
        }
        mysqli_set_charset($this->conn,"utf8mb4");
        $sum_data = mysqli_query($this->conn,"SELECT SUM($field) from $table $where" ) or die(mysqli_error($this->conn));
        return $sum_data;

    }

// sms send 
   function send_sms($mobile,$message) {
       
       $msg=urlencode($message);
      //  $temp = mysqli_query($this->conn,"SELECT *  FROM sms" ) or die(mysqli_error($this->conn));
      //  $smsData=mysqli_fetch_array($temp);
      //  extract($smsData);
       
       $sms= file_get_contents("https://2factor.in/API/R1/?module=TRANS_SMS&apikey=2eb6de0f-3a58-11e9-8806-0200cd936042&to=$mobile&from=FINCAS&msg=$msg");

    }

    function send_otp($mobile,$otp) {
       
       $sms= file_get_contents("https://2factor.in/API/V1/2eb6de0f-3a58-11e9-8806-0200cd936042/SMS/$mobile/$otp/ZooBiz");
       

    }

    // get fcm token
    function getFcm($fildName,$table,$where){
     mysqli_set_charset($this->conn,"utf8mb4");
     $sql="SELECT $fildName FROM $table WHERE $where";
     $temp=mysqli_query($this->conn,$sql);
     $data=mysqli_fetch_array($temp);
       if($data > 0){
        $fcm=$data[$fildName];
        return $fcm;
       }
       else{
        return false;
       }
      }


   function get_android_fcm($table,$where) {
        if($where != '')
        {
            $where= 'where ' .$where;
        }
        mysqli_set_charset($this->conn,"utf8mb4");
        $select = mysqli_query($this->conn,"SELECT * FROM $table $where") or die(mysqli_error($this->conn));
        $totalUsers = mysqli_num_rows($select);
        $loopCount= $totalUsers/1000;
        $loopCount= round($loopCount)+1;

           for ($i=0; $i <$loopCount ; $i++) { 
                $limit_users = $i."000";
                $fcmArray=array();
                $q1 = mysqli_query($this->conn,"SELECT user_token FROM $table $where GROUP BY user_token") or die(mysqli_error($this->conn));
                  while ($row=mysqli_fetch_array($q1)) {
                    $user_token= $row['user_token'];
                    array_push($fcmArray, $user_token);
                  }
                 return $fcmArray;
              }
   }

    function get_emp_fcm($table,$where) {
        if($where != '')
        {
            $where= 'where ' .$where;
        }
        mysqli_set_charset($this->conn,"utf8mb4");
        $select = mysqli_query($this->conn,"SELECT * FROM $table $where") or die(mysqli_error($this->conn));
        $totalUsers = mysqli_num_rows($select);
        $loopCount= $totalUsers/1000;
        $loopCount= round($loopCount)+1;

           for ($i=0; $i <$loopCount ; $i++) { 
                $limit_users = $i."000";
                $fcmArray=array();
                $q1 = mysqli_query($this->conn,"SELECT emp_token FROM $table $where") or die(mysqli_error($this->conn));
                  while ($row=mysqli_fetch_array($q1)) {
                    $emp_token= $row['emp_token'];
                    array_push($fcmArray, $emp_token);
                  }
                 return $fcmArray;
              }
   }

   function get_admin_fcm($table,$where) {
        if($where != '')
        {
            $where= 'where ' .$where;
        }
        mysqli_set_charset($this->conn,"utf8mb4");
        $select = mysqli_query($this->conn,"SELECT * FROM $table $where") or die(mysqli_error($this->conn));
        $totalUsers = mysqli_num_rows($select);
        $loopCount= $totalUsers/1000;
        $loopCount= round($loopCount)+1;

           for ($i=0; $i <$loopCount ; $i++) { 
                $limit_users = $i."000";
                $fcmArray=array();
                $q1 = mysqli_query($this->conn,"SELECT token FROM $table $where") or die(mysqli_error($this->conn));
                  while ($row=mysqli_fetch_array($q1)) {
                    $token= $row['token'];
                    array_push($fcmArray, $token);
                  }
                 return $fcmArray;
              }
   }


   function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 0) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 0) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
}
  //update counter
  function updateCounter($table ,$value='')
    {
        mysqli_set_charset($this->conn,"utf8mb4");
        return mysqli_query($this->conn,"update $table SET $value");
    }


      //select funtion display data
    function dbSize()
    {
       
        mysqli_set_charset($this->conn,"utf8mb4");
        $select = mysqli_query($this->conn,"SHOW TABLE STATUS") or die(mysqli_error($this->conn));
        return $select;
    }

    
    function selectArray($table, $where='', $other='')
    {
      if($where != '')
      {
          $where= 'where ' .$where;
      }
      mysqli_set_charset($this->conn,"utf8");
      mysqli_set_charset($this->conn,"utf8");
      $select = mysqli_query($this->conn,"SELECT * FROM $table $where $other") or die(mysqli_error($this->conn));
      $data = mysqli_fetch_array($select);
      return $data;
    }

//11dec2020
    function get_profile_percentage($user_id){
        ////address per start

        $add_fields = "adress,pincode,add_latitude,add_longitude";
        $select = mysqli_query($this->conn,"SELECT $add_fields FROM business_adress_master WHERE user_id='$user_id' group by user_id") or die(mysqli_error($this->conn));
        $data=  mysqli_fetch_assoc($select);
        
        $address_total_fields = mysqli_num_fields($select) ;
        $address_not_empty_fields = 0 ;
        foreach ($data as $key => $Newvalue) {
            //$address_total_fields++;
            if($data[$key] !=""  && $data[$key] !="0" && $data[$key] != NULL && $data[$key] != '0000-00-00'){
                $address_not_empty_fields++;
            }
        }
        //address per end

//user per start
        $user_fields = "user_profile_pic,user_full_name,salutation,user_first_name,user_last_name,refer_by,gender,user_mobile,whatsapp_number,user_email,member_date_of_birth,facebook,instagram,linkedin,twitter,alt_mobile,user_social_media_name";
        $user_select = mysqli_query($this->conn,"SELECT $user_fields FROM users_master WHERE user_id='$user_id' group by user_id") or die(mysqli_error($this->conn));
       // echo mysqli_num_fields($user_select) ;exit;
        $data2=  mysqli_fetch_assoc($user_select);
         
        $users_total_fields = mysqli_num_fields($user_select) ;
        $users_not_empty_fields = 0 ;
        
        foreach ($data2 as $key => $Newvalue) {
           // $users_total_fields++;
             
            if($data2[$key] !="" && $data2[$key] !="0" && $data2[$key] != NULL && $data2[$key] != '0000-00-00' ){
                $users_not_empty_fields++;
            }
        }
//user per end
//employement details per start
        $user_emp_fields = "company_email,business_category_id,business_sub_category_id,business_description,company_name,designation,company_contact_number,company_website,company_logo,company_broucher,company_profile,billing_address,gst_number,billing_pincode,bank_name,bank_account_number,ifsc_code,billing_contact_person,billing_contact_person_name";
        $user_emp_select = mysqli_query($this->conn,"SELECT $user_emp_fields FROM user_employment_details WHERE user_id='$user_id' group by user_id") or die(mysqli_error($this->conn));
        $data3=  mysqli_fetch_assoc($user_emp_select);
        
        $users_emp_total_fields = mysqli_num_fields($user_emp_select) ;
        $users_emp_not_empty_fields = 0 ;
        foreach ($data3 as $key => $Newvalue) {
           // $users_emp_total_fields++;
            if($data3[$key] !="" && $data3[$key] !="0" && $data3[$key] != NULL && $data3[$key] != '0000-00-00' ){
                $users_emp_not_empty_fields++;
            }
        }
//employment details per end
        $user_per = 40;
        $user_emp_per =40;
        $user_address_per =20;
         $add_per_actual = (($address_not_empty_fields*100) / $address_total_fields);
         $user_per_actual = (($users_not_empty_fields*100) / $users_total_fields); 
         $user_emp_per_actual = (($users_emp_not_empty_fields*100) / $users_emp_total_fields);
         $add_per_val = (($add_per_actual*$user_address_per) / 100);
         $user_per_val = (($user_per_actual*$user_per) / 100);
         $user_emp_per_val = (($user_emp_per_actual*$user_emp_per) / 100);
 //echo $add_per_val.'+'.$user_per_val.'+'.$user_emp_per_val;exit;
         return number_format(($add_per_val+$user_per_val+$user_emp_per_val),2,'.',''); ;

     
}
    function check_auth($auth_user_name,$auth_password){
          mysqli_set_charset($this->conn,"utf8");
        mysqli_set_charset($this->conn,"utf8");
        $select = mysqli_query($this->conn,"SELECT * FROM users_master WHERE user_id='$auth_user_name'") or die(mysqli_error($this->conn));
       
        if(mysqli_num_rows($select)){
            $data=  mysqli_fetch_array($select);
                $last3Digit=  $newstring = substr($data['user_mobile'], -3);
                //$myPassword= $data['user_id'].'@'.$last3Digit.'@'.$data['society_id'];
                $myPassword = $data['user_id'].'@'.$last3Digit;
                if($myPassword == $auth_password){
                    return true;
                } else {
                    return false;
                }
            
        }else {
            return false;
        }
         /*if(mysqli_num_rows($select)<=0){
            return false;
         }
        if(mysqli_num_rows($select)>0){
           return true;
        }​​​​​​​*/
    }
  
 //11dec2020


    function GetCurrencySymbol($currency_char){
        // $fmt = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
        // $fmt->setTextAttribute(NumberFormatter::CURRENCY_CODE, $currency_char);
        // $fmt->setAttribute(NumberFormatter::FRACTION_DIGITS, 0);
        // $temp=$fmt->formatCurrency("0",$currency_char);
        // $temp = preg_replace('/[0-9]+/', '', $temp);
        return '₹';
    }


    function send_sms_multiple($mobiles,$message) {
      $curl = curl_init();
      curl_setopt_array($curl, array(
        CURLOPT_URL => "http://2factor.in/API/V1/2eb6de0f-3a58-11e9-8806-0200cd936042/ADDON_SERVICES/SEND/TSMS",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "{\"From\": \"FINCAS\",\"To\": \"$mobiles\", \"Msg\": \"$message\"}",
      ));
      $response = curl_exec($curl);
      $err = curl_error($curl);
      curl_close($curl);
      if ($err) {
        echo "cURL Error #:" . $err;
      } else {
        echo $response;
      }
      return $error;
    }


    
    function haversineGreatCircleDistance(
      $latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000)
    {
      // convert from degrees to radians
      $latFrom = deg2rad($latitudeFrom);
      $lonFrom = deg2rad($longitudeFrom);
      $latTo = deg2rad($latitudeTo);
      $lonTo = deg2rad($longitudeTo);

      $latDelta = $latTo - $latFrom;
      $lonDelta = $lonTo - $lonFrom;

      $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
        cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
      return $angle * $earthRadius;
    }




}
?>