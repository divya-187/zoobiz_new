<?php 
include '../common/objectController.php';

if(isset($_POST) && !empty($_POST) )//it can be $_GET doesn't matter
{

		
	if (isset($_POST['sender_email_id'])) {

		$m->set_data('sender_email_id',$sender_email_id);
		$m->set_data('email_password',$email_password);
		$m->set_data('email_smtp',$email_smtp);
		$m->set_data('smtp_type',$smtp_type);
		$m->set_data('email_port',$email_port);
		$m->set_data('sender_name',$sender_name);

		$a = array('sender_email_id'=>$m->get_data('sender_email_id'),
			'email_password'=>$m->get_data('email_password'),
			'email_smtp'=>$m->get_data('email_smtp'),
			'smtp_type'=>$m->get_data('smtp_type'),
			'email_port' => $m->get_data('email_port'),
			'sender_name' => $m->get_data('sender_name'));
		


		$q = $d->update("email_configuration",$a,"configuration_id='1'");

		if($q==TRUE)
		{

			$_SESSION['msg']="Data Updated Successfully";

        $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by","Email Configuration Updated");
			header('location:../emailConfigration');
		}
		else
		{
			$_SESSION['msg1']="Something went wrong.";
			header('location:../emailConfigration');
		}
	}
}
?>