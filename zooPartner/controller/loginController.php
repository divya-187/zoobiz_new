<?php
 include '../common/objectController.php';
date_default_timezone_set('Asia/Calcutta');
 
if(isset($_POST) && !empty($_POST) )//it can be $_GET doesn't matter
{



	if(isset($_POST["partnerNumber"]) && $_POST['SendOPT'] =="yes") {
		extract(array_map("test_input" , $_POST));

	 
		$q=$d->select("zoobiz_partner_master,role_master","zoobiz_partner_master.role_id=role_master.role_id AND zoobiz_partner_master.partner_mobile='$partnerNumber'   ");


		if ( mysqli_num_rows($q) == 1) {

		 $bms_admin_master_data = mysqli_fetch_array($q);
		 
		 $digits = 4;
         $otp_web= rand(pow(10, $digits-1), pow(10, $digits)-1);
         $m->set_data('otp_web', $otp_web);
         $m->set_data('partnerNumber', $partnerNumber);   
         $a1= array (
          'otp'=> $m->get_data('otp_web'),
           
        );

          
	        $result=$d->update("zoobiz_partner_master",$a1,"partner_mobile='$partnerNumber'");
	     
       if($result){
        	 
			$d->partner_login_otp($partnerNumber,$otp_web);
			echo "1";
        } else {
        	echo "2";
        }
        
      } else {
      	echo "0";
      }

	}


	if(isset($_POST["verify_web_otp"]) && $_POST['verify_web_otp'] =="verify_web_otp" && $_POST['verify_mobile'] !="") {
		  
		extract(array_map("test_input" , $_POST));


		$mobile=mysqli_real_escape_string($con, $verify_mobile);
		$otp_web=mysqli_real_escape_string($con, $otp_web);
	  
		 
			$q=$d->select("zoobiz_partner_master, role_master","role_master.role_id =zoobiz_partner_master.role_id and   zoobiz_partner_master.partner_mobile='$mobile' AND zoobiz_partner_master.otp='$otp_web'");
		 


		$data = mysqli_fetch_array($q); 

        if(   mysqli_num_rows($q) > 0 ){
        	$m->set_data('country_id', $selected_country_id);
        	$m->set_data('state_id', $selected_state_id);
        	$m->set_data('city_id', $selected_city_id);
        	 $a = array( 
        	 	  'otp_web' => '',
        	      'ip_address' =>	$_SERVER['REMOTE_ADDR'],
        	      'browser' =>	$_SERVER['HTTP_USER_AGENT'],
		          'country_id'=> $m->get_data('country_id'),
		          'state_id'=> $m->get_data('state_id'),
		          'city_id'=> $m->get_data('city_id'),
		          'status' =>'1'
        	 );

        	  $cities=$d->select("cities","city_id='$selected_city_id'");
		      $cities_data = mysqli_fetch_array($cities); 
		      $_SESSION['city_name'] = $cities_data['city_name']; 

		      
             $d->update("partner_login_master",$a,"partnerNumber='$mobile'  ");

            


			$_SESSION['admin_name'] = $data['partner_name']; 
			$_SESSION['full_name'] = $data['partner_name']; 
			
			$_SESSION['secretary_mobile'] = $data['partner_mobile']; 
			$_SESSION['admin_profile'] = $data['partner_profile'];  
			$_SESSION['partner_login_id'] = $data['zoobiz_partner_id']; 	 
			$_SESSION['admin_type'] =$data['role_name']; 	  	
			$_SESSION['partner_role_id'] = $data['role_id']; 	


			$_SESSION['city_id'] =$selected_city_id; 	
			
		$_SESSION['msg']= "Welcome $_SESSION[admin_name]";
		$_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT']; # Save The User Agent
		$_SESSION['ip_address'] = $_SERVER['REMOTE_ADDR']; # Save The IP Address
		$_SESSION['loginTime']=date("d M,Y h:i:sa");//Login Time
		
		// Session Data insert
		$partner_login_id=$_SESSION['partner_login_id'];
		$ip_address=$_SESSION['ip_address'];
		$browser=$_SESSION['user_agent'];
		$loginTime=$_SESSION['loginTime'];
		$m->set_data('partner_login_id',$partner_login_id);
		$m->set_data('name',$_SESSION['admin_name']);

		 

		$m->set_data('role_name','Partner');
		$m->set_data('ip_address',$ip_address);
		$m->set_data('browser',$browser);
		$m->set_data('loginTime',$loginTime);
		$a1= array ('partner_login_id'=> $m->get_data('partner_login_id'),
			'name'=> $m->get_data('name'),
			'role_name'=> $m->get_data('role_name'),
			'ip_address'=> $m->get_data('ip_address'),
			'browser'=> $m->get_data('browser'),
			'loginTime'=> $m->get_data('loginTime'),
		);
		$insert=$d->insert('partner_session_log',$a1); 
       
		$_SESSION['msg']= "Welcome ".$data['admin_name'];
		unset($_SESSION['mobile']);
		header("location:../welcome");
	
        } else {
        	$_SESSION['mobile']= $mobile;
        
        	$_SESSION['msg1']= "Invalid OTP";
		header("location:../");
        	 
        }

	}

if(isset($_POST["mobile"])) {
	extract(array_map("test_input" , $_POST));

	$mobile=mysqli_real_escape_string($con, $mobile);
	$inputPass=mysqli_real_escape_string($con, $inputPass);

	$q=$d->select("zoobiz_admin_master,role_master","zoobiz_admin_master.role_id=role_master.role_id AND (zoobiz_admin_master.admin_mobile='$mobile' OR zoobiz_admin_master.admin_email='$mobile' )  ");
// / and zoobiz_admin_master.status=0
	$data = mysqli_fetch_array($q); 
	if ($data > 0 && mysqli_num_rows($q) > 0  && password_verify($inputPass, $data['admin_password']) ) {
		if($data['status'] !=0){
			$_SESSION['msg1']= "Your Admin Account is Deactivated";
		    header("location:../");
		    exit;
		}
		$_SESSION['partner_login_id'] = $data['partner_login_id'];
		$_SESSION['partner_role_id'] = $data['role_id'];
		$_SESSION['full_name'] = $data['admin_name'];
		$_SESSION['mobile_number'] = $data['admin_mobile'];
		$_SESSION['admin_email'] = $data['admin_email'];

		//11nov2020
		$_SESSION['admin_profile'] = $data['admin_profile'];
		$_SESSION['msg']= "Welcome $_SESSION[full_name]";
		$_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT']; # Save The User Agent
		$_SESSION['ip_address'] = $_SERVER['REMOTE_ADDR']; # Save The IP Address
		$_SESSION['loginTime']=date("d M,Y h:i:sa");//Login Time
	

	$m->set_data('admin_id', $data['partner_login_id']);
        $m->set_data('name',$data['admin_name']);
        $m->set_data('ip_address',$_SERVER['REMOTE_ADDR']);
        $m->set_data('browser',$_SERVER['HTTP_USER_AGENT']);
        $m->set_data('loginTime',date("d M,Y h:i:sa"));
        
        $role_id = $data['role_id'];
        $q1 = $d->select("role_master" ,"role_id= '$role_id'","");
        $data1111=mysqli_fetch_array($q1);
        $m->set_data('role_name',$data1111['role_name']);
         $a1= array (
            
          'admin_id'=> $m->get_data('admin_id'),
          'role_name'=> $m->get_data('role_name'),
          'update_by_admin_id'=> $m->get_data('admin_id'),
          'name'=> $m->get_data('name'),
          'ip_address'=> $m->get_data('ip_address'),
          'browser' => $m->get_data('browser'),
          'loginTime' => date("Y-m-d H:i:s")
        );


       $q=$d->insert("session_log",$a1);


	 	$_SESSION['msg']= "Welcome ".$data['admin_name'];

	 	
       	header("Location:../welcome");
	} 
	else {
	 	$_SESSION['msg1']= "Wrong Credentials Details";
		header("location:../");
	}
}


// forgot Password 
if(isset($_POST["forgot_mobile"])) {
	extract(array_map("test_input" , $_POST));
	$forgot_email=mysqli_real_escape_string($con, $forgot_email);

	$q=$d->select("zoobiz_admin_master","admin_mobile='$forgot_mobile' OR admin_email='$forgot_mobile'   ");
	$data = mysqli_fetch_array($q); 
 
	if ($data > 0) {
extract($data);
		if($data['status'] !=0){
			$_SESSION['msg1']= "Your Admin Account is Deactivated";
		    header("location:../forgot.php");
		    exit;
		}
		$full_name = $data['admin_name'];
		$mobile_number = $data['mobile_number'];
		$admin_email = $data['admin_email'];
		$token = bin2hex(openssl_random_pseudo_bytes(16));
		$forgotTime=date("Y-m-d");//Token Date
		$forgotLink=$base_url."zooAdmin/resetPassword.php?t=".$token."&f=".$data['partner_login_id'];

		$m->set_data('token',$token);
		$m->set_data('token_date',$forgotTime);
		$a1= array (
			'forgot_token'=> $m->get_data('token'),
			'token_date'=> $m->get_data('token_date')
		);
 
		$d->update('zoobiz_admin_master',$a1,"partner_login_id='$data[partner_login_id]' "); 

		$to = $admin_email;
		$subject = "Forgot Password - ZooBiz";

		include '../mail/forgotPasswordMail.php';
		include '../mail.php';
		 /*if($forgot_mobile=="ravaldivyaks@gmail.com"){
		 	echo $message;exit;
		 }*/
		/*$msg= "Dear $full_name\nYou have requested to reset your password for ZooBiz Admin Panel.\nPlease click below link to reset the same.\n\n$forgotLink\n\nThanks Team ZooBiz";
       	$d->send_sms($admin_mobile,$msg);*/
       	//$d->sms_admin_reset_password($admin_mobile,$full_name,$forgotLink);

        // Redirqt to homepage
		$_SESSION['msg']= "Password reset link sent to ".$admin_email;
		header("location:../forgot.php");
	} 
	else {
		$_SESSION['msg1']= "Wrong Email or Mobile";
		header("location:../forgot.php");
	}
}


//Reset Password
if(isset($_POST["password2"])) {

	extract(array_map("test_input" , $_POST));
	if ($password2==$passwordNew) {
	
	$passwordNew =  password_hash($passwordNew, PASSWORD_DEFAULT);
	$m->set_data('token',"");
	$m->set_data('token_date',"");
	$m->set_data('passwordNew',$passwordNew);
	$forgot= array (
		'admin_password'=> $m->get_data('passwordNew'),
		'forgot_token'=> $m->get_data('token'),
		'token_date'=> $m->get_data('token_date'),
	);
	
	$qForgot = $d->update("zoobiz_admin_master",$forgot,"partner_login_id= '$_SESSION[forgot_admin_id]'");
	if ($qForgot>0) {
		 $adm_data=$d->selectRow("admin_name","zoobiz_admin_master"," partner_login_id='$_SESSION[forgot_admin_id]'");
        $data_q=mysqli_fetch_array($adm_data);
		$_SESSION['msg']= $data_q['admin_name']." set new password.";
		$d->insert_log("","0","$_SESSION[partner_login_id]","$created_by",$_SESSION['msg']);
		header("location:../index.php");
	} 
	else {
		$_SESSION['msg1']= "Something Wrong...";
		header("location:../index.php");
	}
	} else {
		$_SESSION['msg1']= "Confirm Password Not Match";
		header("location:../index.php");
	}
}



} else  {
	header("location:../forgot.php");
}
?>