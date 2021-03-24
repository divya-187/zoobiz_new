<?php
 include '../common/objectController.php';
date_default_timezone_set('Asia/Calcutta');
if(isset($_SESSION['zoobiz_admin_id']))
{
   header("location:../welcome");
}
if(isset($_POST) && !empty($_POST) )//it can be $_GET doesn't matter
{
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
		$_SESSION['zoobiz_admin_id'] = $data['zoobiz_admin_id'];
		$_SESSION['role_id'] = $data['role_id'];
		$_SESSION['full_name'] = $data['admin_name'];
		$_SESSION['mobile_number'] = $data['admin_mobile'];
		$_SESSION['admin_email'] = $data['admin_email'];

		//11nov2020
		$_SESSION['admin_profile'] = $data['admin_profile'];
		$_SESSION['msg']= "Welcome $_SESSION[full_name]";
		$_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT']; # Save The User Agent
		$_SESSION['ip_address'] = $_SERVER['REMOTE_ADDR']; # Save The IP Address
		$_SESSION['loginTime']=date("d M,Y h:i:sa");//Login Time
	

	$m->set_data('admin_id', $data['zoobiz_admin_id']);
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

	$q=$d->select("zoobiz_admin_master","admin_mobile='$forgot_mobile' OR admin_email='$forgot_mobile' /*and zoobiz_admin_master.status=0*/ ");
	$data = mysqli_fetch_array($q); 
	extract($data);
	if ($data > 0) {

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
		$forgotLink=$base_url."zooAdmin/resetPassword.php?t=".$token."&f=".$data['zoobiz_admin_id'];

		$m->set_data('token',$token);
		$m->set_data('token_date',$forgotTime);
		$a1= array (
			'forgot_token'=> $m->get_data('token'),
			'token_date'=> $m->get_data('token_date')
		);
 
		$d->update('zoobiz_admin_master',$a1,"zoobiz_admin_id='$data[zoobiz_admin_id]' "); 

		$to = $admin_email;
		$subject = "Forgot Password - ZooBiz";

		include '../mail/forgotPasswordMail.php';
		include '../mail.php';
		 /*if($forgot_mobile=="ravaldivyaks@gmail.com"){
		 	echo $message;exit;
		 }*/
		/*$msg= "Dear $full_name\nYou have requested to reset your password for ZooBiz Admin Panel.\nPlease click below link to reset the same.\n\n$forgotLink\n\nThanks Team ZooBiz";
       	$d->send_sms($admin_mobile,$msg);*/
       	$d->sms_admin_reset_password($admin_mobile,$full_name,$forgotLink);

        // Redirqt to homepage
		$_SESSION['msg']= "Password reset link sent";
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
	
	$qForgot = $d->update("zoobiz_admin_master",$forgot,"zoobiz_admin_id= '$_SESSION[forgot_admin_id]'");
	if ($qForgot>0) {
		 $adm_data=$d->selectRow("admin_name","zoobiz_admin_master"," zoobiz_admin_id='$_SESSION[forgot_admin_id]'");
        $data_q=mysqli_fetch_array($adm_data);
		$_SESSION['msg']= $data_q['admin_name']." set new password.";
		$d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
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