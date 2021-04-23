<?php 
include '../common/objectController.php';

if(isset($_POST) && !empty($_POST) )//it can be $_GET doesn't matter
{

	if (isset($_POST['addCustomData'])) {

		$m->set_data('send_fcm',$send_fcm);
		$m->set_data('share_within_city',$share_within_city);
		$m->set_data('fcm_content',$fcm_content);
		$today= date("Y-m-d H:i:s");
        $m->set_data('created_date',$today);

		$a = array('send_fcm'=>$m->get_data('send_fcm'),
			'share_within_city'=>$m->get_data('share_within_city'),
			'fcm_content'=>$m->get_data('fcm_content'),
			'created_date'=>$m->get_data('created_date') );
		
		$q = $d->insert("custom_settings_master",$a);

		if($q==TRUE) {
            $_SESSION['msg']="FCM Custom Data Inserted";

          $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
			header('location:../customSettings');
		} else {
			$_SESSION['msg1']="Something went wrong.";
			header('location:../customSettings');
		}
	} else if (isset($_POST['updateCustomData'])) {
         $m->set_data('fcm_content',$fcm_content);
		 $a = array('fcm_content'=>$m->get_data('fcm_content') );
		 $q = $d->update("custom_settings_master",$a,"custom_id ='$custom_id'");

		if($q==TRUE) {
            $_SESSION['msg']="FCM Custom Data Updated";
             $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
			header('location:../customSettings');
		} else {
			$_SESSION['msg1']="Something went wrong.";
			header('location:../customSettings');
		}
	} if (isset($_POST['addWelcomeData'])) {

		 $m->set_data('send_fcm',$send_fcm);
		$m->set_data('fcm_content',$fcm_content);
		$today= date("Y-m-d H:i:s");
        $m->set_data('created_date',$today);

		$a = array( 
			'send_fcm'=>$m->get_data('send_fcm'),
			'flag' => 1, 
			'fcm_content'=>$m->get_data('fcm_content'),
			'created_date'=>$m->get_data('created_date') );
		
		$q = $d->insert("custom_settings_master",$a);

		if($q==TRUE) {
            $_SESSION['msg']="Custom Welcome user message Inserted";

          $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
			header('location:../customSettings');
		} else {
			$_SESSION['msg1']="Something went wrong.";
			header('location:../customSettings');
		}
	} else if (isset($_POST['updateWelcomeData'])) {
         $m->set_data('fcm_content', $fcm_content );
		 $a = array('fcm_content'=>$m->get_data('fcm_content') );
		 $q = $d->update("custom_settings_master",$a,"custom_id ='$custom_id' and flag =1 ");

		if($q==TRUE) {
            $_SESSION['msg']="Custom Welcome user message  Updated";
             $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
			header('location:../customSettings');
		} else {
			$_SESSION['msg1']="Something went wrong.";
			header('location:../customSettings');
		}
	} else if (isset($_POST['adminNotificationData'])) {


		 //echo "<pre>";print_r($_POST['zoobiz_admin_id']);exit;
		$m->set_data('send_notification','0');
		 	$a = array('send_notification'=>$m->get_data('send_notification') );
		$q = $d->update("zoobiz_admin_master",$a,"admin_mobile != 0");

		for ($p=0; $p <count($_POST['zoobiz_admin_id']) ; $p++) { 

			$zoobiz_admin_id = $_POST['zoobiz_admin_id'][$p];
			$m->set_data('send_notification','1');
		 	$a = array('send_notification'=>$m->get_data('send_notification') );
			 $q = $d->update("zoobiz_admin_master",$a,"zoobiz_admin_id ='$zoobiz_admin_id'");
		}
               

		if($q==TRUE) {
            $_SESSION['msg']="Custom Zoobiz Admin Notification Updated";
             $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by", $_SESSION['msg']);
			header('location:../customSettings');
		} else {
			$_SESSION['msg1']="Something went wrong.";
			header('location:../customSettings');
		} 
	}

	//31dec2020
	else if (isset($_POST['editSMSConfData'])) {

		 
		$m->set_data('sms_api_link',$sms_api_link);
		$m->set_data('otp_api_link',$otp_api_link);
        $m->set_data('multiple_sms_link',$multiple_sms_link);
		 	$a = array(
		 		'sms_api_link'=>$m->get_data('sms_api_link'),
		 		'otp_api_link'=>$m->get_data('otp_api_link'),
		 		'multiple_sms_link'=>$m->get_data('multiple_sms_link')
		 		 );
		$q = $d->update("zoobiz_settings_master",$a,"setting_id=1");

		 
               

		if($q==TRUE) {
            $_SESSION['msg']="Custom SMS API Configuration Updated";
             $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by", $_SESSION['msg']);
			header('location:../customSettings');
		} else {
			$_SESSION['msg1']="Something went wrong.";
			header('location:../customSettings');
		} 
	}
	//31dec2020


	//11march2021
	else if (isset($_POST['updateMisc'])) {

		 $org_qry = $d->select("zoobiz_settings_master","setting_id ='$setting_id'");
		 $org_data=mysqli_fetch_array($org_qry);

         $m->set_data('max_member_per_subcategory',$max_member_per_subcategory);
		 $a = array('max_member_per_subcategory'=>$m->get_data('max_member_per_subcategory') );
		 $q = $d->update("zoobiz_settings_master",$a,"setting_id ='$setting_id'");

		if($q==TRUE) {
            $_SESSION['msg']="Max Member Per City/Subcategory is updated to ".$max_member_per_subcategory.' from '.$org_data['max_member_per_subcategory'];
             $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",ucwords('GLOBAL: '.$_SESSION['msg']));
			header('location:../customSettings');
		} else {
			$_SESSION['msg1']="Something went wrong.";
			header('location:../customSettings');
		}
	}

	else if (isset($_POST['updateMiscTimeline'])) {

		 $org_qry = $d->select("zoobiz_settings_master","setting_id ='$setting_id'");
		 $org_data=mysqli_fetch_array($org_qry);

         $m->set_data('timeline_reminder_days',$timeline_reminder_days);
		 $a = array('timeline_reminder_days'=>$m->get_data('timeline_reminder_days') );
		 $q = $d->update("zoobiz_settings_master",$a,"setting_id ='$setting_id'");

		if($q==TRUE) {
            $_SESSION['msg']="Timeline Reminder Days is updated to ".$timeline_reminder_days.' from '.$org_data['timeline_reminder_days'];
             $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",ucwords('GLOBAL: '.$_SESSION['msg']));
			header('location:../customSettings');
		} else {
			$_SESSION['msg1']="Something went wrong.";
			header('location:../customSettings');
		}
	}

	else if (isset($_POST['updateMiscMeet'])) {

		 $org_qry = $d->select("zoobiz_settings_master","setting_id ='$setting_id'");
		 $org_data=mysqli_fetch_array($org_qry);

         $m->set_data('meetup_reminder_days',$meetup_reminder_days);
		 $a = array('meetup_reminder_days'=>$m->get_data('meetup_reminder_days') );
		 $q = $d->update("zoobiz_settings_master",$a,"setting_id ='$setting_id'");

		if($q==TRUE) {
            $_SESSION['msg']="Meetup Reminder Days is updated to ".$meetup_reminder_days.' from '.$org_data['meetup_reminder_days'];
             $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",ucwords('GLOBAL: '.$_SESSION['msg']));
			header('location:../customSettings');
		} else {
			$_SESSION['msg1']="Something went wrong.";
			header('location:../customSettings');
		}
	}

	else if (isset($_POST['updateMiscCls'])) {

		 $org_qry = $d->select("zoobiz_settings_master","setting_id ='$setting_id'");
		 $org_data=mysqli_fetch_array($org_qry);

         $m->set_data('classified_reminder_days',$classified_reminder_days);
		 $a = array('classified_reminder_days'=>$m->get_data('classified_reminder_days') );
		 $q = $d->update("zoobiz_settings_master",$a,"setting_id ='$setting_id'");

		if($q==TRUE) {
            $_SESSION['msg']="Classified Reminder Days is updated to ".$classified_reminder_days.' from '.$org_data['classified_reminder_days'];
             $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",ucwords('GLOBAL: '.$_SESSION['msg']));
			header('location:../customSettings');
		} else {
			$_SESSION['msg1']="Something went wrong.";
			header('location:../customSettings');
		}
	}
	//11march2021


	//14april2021
	else if (isset($_POST['updateClassifieds'])) {

		 $org_qry = $d->select("zoobiz_settings_master","setting_id ='$setting_id'");
		 $org_data=mysqli_fetch_array($org_qry);

         $m->set_data('classified_max_audio_duration',$classified_max_audio_duration);
         $m->set_data('classified_max_document_select',$classified_max_document_select);
         $m->set_data('classified_max_image_select',$classified_max_image_select);
         $m->set_data('classifieds_sel_multiple_cities',$classifieds_sel_multiple_cities);
		 $a = array(
		 	'classified_max_audio_duration'=>$m->get_data('classified_max_audio_duration'),
		 	'classified_max_document_select'=>$m->get_data('classified_max_document_select'),
		 	'classified_max_image_select'=>$m->get_data('classified_max_image_select'),
		 	'classifieds_sel_multiple_cities'=>$m->get_data('classifieds_sel_multiple_cities')
		 	 );
		 $q = $d->update("zoobiz_settings_master",$a,"setting_id ='$setting_id'");

		if($q==TRUE) {
            $_SESSION['msg']="Classified Settings Updated";
             $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",ucwords('GLOBAL: '.$_SESSION['msg']));
			header('location:../customSettings');
		} else {
			$_SESSION['msg1']="Something went wrong.";
			header('location:../customSettings');
		}
	}
	//14april2021


	//23april21
	else if (isset($_POST['updateAppPop'])) {

		 $org_qry = $d->select("zoobiz_settings_master","setting_id ='$setting_id'");
		 $org_data=mysqli_fetch_array($org_qry);

         $m->set_data('show_youtube_video_poup',$show_youtube_video_poup);
         $m->set_data('youtube_video_poup_link',$youtube_video_poup_link); 
		 $a = array(
		 	'show_youtube_video_poup'=>$m->get_data('show_youtube_video_poup'),
		 	'youtube_video_poup_link'=>$m->get_data('youtube_video_poup_link') 
		 	 );
		 $q = $d->update("zoobiz_settings_master",$a,"setting_id ='$setting_id'");

		if($q==TRUE) {
            $_SESSION['msg']="App Pop Up Settings Updated";
             $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",ucwords('GLOBAL: '.$_SESSION['msg']));
			header('location:../customSettings');
		} else {
			$_SESSION['msg1']="Something went wrong.";
			header('location:../customSettings');
		}
	}
	//23april21
}
?>