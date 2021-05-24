<?php 
include '../common/objectController.php';

if(isset($_POST) && !empty($_POST) )//it can be $_GET doesn't matter
{

	if (isset($_POST['addVersionData'])) {

		$m->set_data('version_code_android',$version_code_android);
		$m->set_data('version_code_android_view',$version_code_android_view);
		$m->set_data('version_code_ios',$version_code_ios);
		$m->set_data('version_code_ios_view',$version_code_ios_view);
		$m->set_data('version_code_android_view',$version_code_android_view);
		$today= date("Y-m-d H:i:s");
        $m->set_data('created_date',$today);

		$a = array('version_code_android'=>$m->get_data('version_code_android'),
			'version_code_android_view'=>$m->get_data('version_code_android_view'),
			'version_code_ios'=>$m->get_data('version_code_ios'),
			'version_code_ios_view'=>$m->get_data('version_code_ios_view'),
 		 	'created_date'=>$m->get_data('created_date') );
		
		$q = $d->insert("app_version_master",$a);

		if($q==TRUE) {
            $_SESSION['msg']="App Version Inserted";
            $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
			header('location:../appVersion');
		} else {
			$_SESSION['msg1']="Something went wrong.";
			header('location:../appVersion');
		}
	} else if (isset($_POST['updateVersionData'])) {
         $m->set_data('version_code_android',$version_code_android);
		$m->set_data('version_code_android_view',$version_code_android_view);
		$m->set_data('version_code_ios',$version_code_ios);
		$m->set_data('version_code_ios_view',$version_code_ios_view);
		$m->set_data('version_code_android_view',$version_code_android_view);
		$today= date("Y-m-d H:i:s");
        $m->set_data('modify_date',$today);

		$a = array('version_code_android'=>$m->get_data('version_code_android'),
			'version_code_android_view'=>$m->get_data('version_code_android_view'),
			'version_code_ios'=>$m->get_data('version_code_ios'),
			'version_code_ios_view'=>$m->get_data('version_code_ios_view'),
 		 	'modify_date'=>$m->get_data('modify_date') );

		
		 $q = $d->update("app_version_master",$a,"version_id ='$version_id'");

		if($q==TRUE) {
            $_SESSION['msg']="App Version Updated";
            $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
			header('location:../appVersion');
		} else {
			$_SESSION['msg1']="Something went wrong.";
			header('location:../appVersion');
		}
	}
}
?>