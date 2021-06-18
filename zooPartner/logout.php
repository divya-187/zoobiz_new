<?php 

  
             $partner_login_id= $_SESSION['partner_login_id'];
        	$a = array( 
        	 	  'logout_time' =>date("Y-m-d H:i:s")
        	 );
             $d->update("partner_session_log",$a,"partner_login_id='$partner_login_id'  ");
             
          
// session_destroy();
             unset($_SESSION['admin_name']); 
             unset($_SESSION['secretary_mobile']);
             unset($_SESSION['admin_profile']);
             unset($_SESSION['partner_login_id']);
             unset($_SESSION['admin_type']);
             unset($_SESSION['city_id']);
             unset($_SESSION['msg']);
             unset($_SESSION['user_agent']);
             unset($_SESSION['ip_address']);
             unset($_SESSION['loginTime']);
  

/*header("location:welcome");*/
 echo ("<script LANGUAGE='JavaScript'>
    window.location.href='index';
    </script>");
exit;
 ?>