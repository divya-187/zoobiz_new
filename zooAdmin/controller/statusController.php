<?php 
include '../common/objectController.php';
// print_r($_POST);
/*
  Develop By : Asif Hingora
*/


if(isset($_POST) && !empty($_POST) )//it can be $_GET doesn't matter
{

//17march2021
  if($_POST['status']=="DisableUPI") {
      $active_status="1";
        $m->set_data('active_status',$active_status);
        $a1= array ('active_status'=> $m->get_data('active_status')
      );
      $q=$d->update('upi_app_master',$a1,"app_id='$id'");
      if($q>0) {
          
        echo 1;
      } else {
        echo 0;
      }
  }

   if($_POST['status']=="EnableUPI") {
      $active_status="0";
        $m->set_data('active_status',$active_status);
        $a1= array ('active_status'=> $m->get_data('active_status')
      );
      $q=$d->update('upi_app_master',$a1,"app_id='$id'");
      if($q>0) {
          
        echo 1;
      } else {
        echo 0;
      }
  }
//17march2021
//11march21

 if($_POST['status']=="DisableClRem") {
      $classified_reminder_flag="0";
        $m->set_data('classified_reminder_flag',$classified_reminder_flag);
        $a1= array ('classified_reminder_flag'=> $m->get_data('classified_reminder_flag')
      );
      $q=$d->update('zoobiz_settings_master',$a1,"setting_id='$id'");
      if($q>0) {
         $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",ucwords('GLOBAL: classified reminder is disabled'));
        echo 1;
      } else {
        echo 0;
      }
  }

   if($_POST['status']=="EnableClRem") {
      $classified_reminder_flag="1";
        $m->set_data('classified_reminder_flag',$classified_reminder_flag);
        $a1= array ('classified_reminder_flag'=> $m->get_data('classified_reminder_flag')
      );
      $q=$d->update('zoobiz_settings_master',$a1,"setting_id='$id'");
      if($q>0) {
         $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",ucwords('GLOBAL: classified reminder is enabled'));
        echo 1;
      } else {
        echo 0;
      }
  }

    if($_POST['status']=="DisableMuRem") {
      $meetups_reminder_flag="0";
        $m->set_data('meetups_reminder_flag',$meetups_reminder_flag);
        $a1= array ('meetups_reminder_flag'=> $m->get_data('meetups_reminder_flag')
      );
      $q=$d->update('zoobiz_settings_master',$a1,"setting_id='$id'");
      if($q>0) {
         $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",ucwords('GLOBAL: Meetup reminder is disabled'));
        echo 1;
      } else {
        echo 0;
      }
  }

  if($_POST['status']=="EnableMuRem") {
      $meetups_reminder_flag="1";
        $m->set_data('meetups_reminder_flag',$meetups_reminder_flag);
        $a1= array ('meetups_reminder_flag'=> $m->get_data('meetups_reminder_flag')
      );
      $q=$d->update('zoobiz_settings_master',$a1,"setting_id='$id'");
      if($q>0) {
         $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",ucwords('GLOBAL: Meetup reminder is enabled'));
        echo 1;
      } else {
        echo 0;
      }
  }

  if($_POST['status']=="DisableTmRem") {
      $timeline_reminer_flag="0";
        $m->set_data('timeline_reminer_flag',$timeline_reminer_flag);
        $a1= array ('timeline_reminer_flag'=> $m->get_data('timeline_reminer_flag')
      );
      $q=$d->update('zoobiz_settings_master',$a1,"setting_id='$id'");
      if($q>0) {
         $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",ucwords('GLOBAL: Timeline reminder is disabled'));
        echo 1;
      } else {
        echo 0;
      }
  }

   if($_POST['status']=="EnableTmRem") {
      $timeline_reminer_flag="1";
        $m->set_data('timeline_reminer_flag',$timeline_reminer_flag);
        $a1= array ('timeline_reminer_flag'=> $m->get_data('timeline_reminer_flag')
      );
      $q=$d->update('zoobiz_settings_master',$a1,"setting_id='$id'");
      if($q>0) {
         $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",ucwords('GLOBAL: Timeline reminder is enabled'));
        echo 1;
      } else {
        echo 0;
      }
  }


  if($_POST['status']=="DisableMaxCapacity") {
      $enable_max_member_facility="0";
        $m->set_data('enable_max_member_facility',$enable_max_member_facility);
        $a1= array ('enable_max_member_facility'=> $m->get_data('enable_max_member_facility')
      );
      $q=$d->update('zoobiz_settings_master',$a1,"setting_id='$id'");
      if($q>0) {
         $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",ucwords('GLOBAL: Max Capacity for City/Sub Category is disabled'));
        echo 1;
      } else {
        echo 0;
      }
  }

  if($_POST['status']=="EnableMaxCapacity") {
      $enable_max_member_facility="1";
        $m->set_data('enable_max_member_facility',$enable_max_member_facility);
        $a1= array ('enable_max_member_facility'=> $m->get_data('enable_max_member_facility')
      );
      $q=$d->update('zoobiz_settings_master',$a1,"setting_id='$id'");
      if($q>0) {
         $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",ucwords('GLOBAL: Max Capacity for City/Sub Category is enabled'));
        echo 1;
      } else {
        echo 0;
      }
  }

  if($_POST['status']=="MemberCityWiseTrue") {
      $show_member_citywise="1";
        $m->set_data('show_member_citywise',$show_member_citywise);
        $a1= array ('show_member_citywise'=> $m->get_data('show_member_citywise')
      );
      $q=$d->update('zoobiz_settings_master',$a1,"setting_id='$id'");
      if($q>0) {
         $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",ucwords('GLOBAL: show city wise users set to true'));
        echo 1;
      } else {
        echo 0;
      }
  }

  if($_POST['status']=="MemberCityWiseFalse") {
      $show_member_citywise="0";
        $m->set_data('show_member_citywise',$show_member_citywise);
        $a1= array ('show_member_citywise'=> $m->get_data('show_member_citywise')
      );
      $q=$d->update('zoobiz_settings_master',$a1,"setting_id='$id'");
      if($q>0) {
         $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",ucwords('GLOBAL: show city wise users set to false'));
        echo 1;
      } else {
        echo 0;
      }
  }

  if($_POST['status']=="is_upiFalse") {
      $is_upi="0";
        $m->set_data('is_upi',$is_upi);
        $a1= array ('is_upi'=> $m->get_data('is_upi')
      );
      $q=$d->update('zoobiz_settings_master',$a1,"setting_id='$id'");
      if($q>0) {

        $m->set_data('active_status','1');
        $a1= array ('active_status'=> $m->get_data('active_status')
        );
        $q=$d->update('upi_app_master',$a1,"active_status=0");


         $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",ucwords('GLOBAL: upi set to false'));
        echo 1;
      } else {
        echo 0;
      }
  }

   if($_POST['status']=="is_upiTrue") {
      $is_upi="1";
        $m->set_data('is_upi',$is_upi);
        $a1= array ('is_upi'=> $m->get_data('is_upi')
      );
      $q=$d->update('zoobiz_settings_master',$a1,"setting_id='$id'");
      if($q>0) {
         $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",ucwords('GLOBAL: upi set to true'));

  //header("Location: ../upiList");exit;
        echo 1;
      } else {
        echo 0;
      }
  }
  //11march21
//23feb21
  if($_POST['status']=="SeasonalGreetImageDeactive") {
      $status="InActive";
        $m->set_data('status',$status);
        $a1= array ('status'=> $m->get_data('status')
      );
      $q=$d->update('seasonal_greet_image_master',$a1,"seasonal_greet_image_id='$id'");
      if($q>0) {

        echo 1;
      } else {
        echo 0;
      }
  }
  if($_POST['status']=="SeasonalGreetImageActive") {
      $status="Active";
        $m->set_data('status',$status);
        $a1= array ('status'=> $m->get_data('status')
      );
      $q=$d->update('seasonal_greet_image_master',$a1,"seasonal_greet_image_id='$id'");
      if($q>0) {
        echo 1;
      } else {
        echo 0;
      }
  }

   if($_POST['status']=="Is_IAP_PaymentFalse") {
      $status="false";
        $m->set_data('Is_IAP_Payment',$status);
        $a1= array ('Is_IAP_Payment'=> $m->get_data('Is_IAP_Payment')
      );
      $q=$d->update('zoobiz_settings_master',$a1,"setting_id='$id'");
      if($q>0) {
         $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",ucwords('GLOBAL: In App Payment set to false'));
        echo 1;
      } else {
        echo 0;
      }
  }
  if($_POST['status']=="Is_IAP_PaymentTrue") {
      $status="true";
        $m->set_data('Is_IAP_Payment',$status);
        $a1= array ('Is_IAP_Payment'=> $m->get_data('Is_IAP_Payment')
      );
      $q=$d->update('zoobiz_settings_master',$a1,"setting_id='$id'");
      if($q>0) {
         $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",ucwords('GLOBAL: In App Payment set to true'));
        echo 1;
      } else {
        echo 0;
      }
  }
//23feb21

//22dec2020
  if($_POST['status']=="OfficeMemberDeactive") {
      $office_member=0;
        $m->set_data('office_member',$office_member);
        $a1= array ('office_member'=> $m->get_data('office_member')
      );
      $q=$d->update('users_master',$a1,"user_id='$id'");
      if($q>0) {

        echo 1;
      } else {
        echo 0;
      }
  }

  if($_POST['status']=="OfficeMemberActive") {
      $office_member=1;
        $m->set_data('office_member',$office_member);
        $a1= array ('office_member'=> $m->get_data('office_member')
      );

      $q=$d->update('users_master',$a1,"user_id='$id'");
      if($q>0) {
        echo 1;
      } else {
        echo 0;
      }
  }
//22dec2020

//15dec2020
  
  if($_POST['status']=="adminDeactive") {
      $status=1;
        $m->set_data('status',$status);
        $a1= array ('status'=> $m->get_data('status')
      );
      $q=$d->update('zoobiz_admin_master',$a1,"zoobiz_admin_id='$id'");
      if($q>0) {
        $adm_data=$d->selectRow("admin_name","zoobiz_admin_master"," zoobiz_admin_id='$id'");
        $data_q=mysqli_fetch_array($adm_data);
        $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$data_q['admin_name']." is Deactivated");
        echo 1;
      } else {
        echo 0;
      }
  }

  if($_POST['status']=="adminActive") {
      $status=0;
        $m->set_data('status',$status);
        $a1= array ('status'=> $m->get_data('status')
      );

      $q=$d->update('zoobiz_admin_master',$a1,"zoobiz_admin_id='$id'");
      if($q>0) {
        $adm_data=$d->selectRow("admin_name","zoobiz_admin_master"," zoobiz_admin_id='$id'");
        $data_q=mysqli_fetch_array($adm_data);
        $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$data_q['admin_name']." is Activated");
        echo 1;
      } else {
        echo 0;
      }
  }
//15dec2020

//4dec2020
  if($_POST['status']=="langDeactive") {
      $active_status=1;
        $m->set_data('active_status',$active_status);
        $a1= array ('active_status'=> $m->get_data('active_status')
      );
      $q=$d->update('language_master',$a1,"language_id='$id'");
      if($q>0) {

        echo 1;
      } else {
        echo 0;
      }
  }

  if($_POST['status']=="langActive") {
      $active_status=0;
        $m->set_data('active_status',$active_status);
        $a1= array ('active_status'=> $m->get_data('active_status')
      );

      $q=$d->update('language_master',$a1,"language_id='$id'");
      if($q>0) {
        echo 1;
      } else {
        echo 0;
      }
  }

  if($_POST['status']=="langKeyDeactive") {
      $key_status=1;
        $m->set_data('key_status',$key_status);
        $a1= array ('key_status'=> $m->get_data('key_status')
      );
      $q=$d->update('language_key_master',$a1,"language_key_id='$id'");
      if($q>0) {
        echo 1;
      } else {
        echo 0;
      }
  }

  if($_POST['status']=="langKeyActive") {
      $key_status=0;
        $m->set_data('key_status',$key_status);
        $a1= array ('key_status'=> $m->get_data('key_status')
      );

      $q=$d->update('language_key_master',$a1,"language_key_id='$id'");
      if($q>0) {
        echo 1;
      } else {
        echo 0;
      }
  }
//4dec2020

//Center image start
  if($_POST['status']=="CenterImgDeactive") {
    $status=1;
    $m->set_data('status',$status);
    $a1= array ('status'=> $m->get_data('status')
  );
    $q=$d->update('promotion_rel_center_master',$a1,"promotion_rel_center_id='$id'");
    if($q>0) {
      echo 1;
    } else {
      echo 0;
    }
  }

  if($_POST['status']=="CenterImgActive") {
    $status=0;
    $m->set_data('status',$status);
    $a1= array ('status'=> $m->get_data('status')
  );
    $q=$d->update('promotion_rel_center_master',$a1,"promotion_rel_center_id='$id'");
    if($q>0) {
      echo 1;
    } else {
      echo 0;
    }
  }
// Center image end
//pro frm start
  if($_POST['status']=="ProFrmDeactive") {
    $status=1;
    $m->set_data('status',$status);
    $a1= array ('status'=> $m->get_data('status')
  );
    $q=$d->update('promotion_rel_frame_master',$a1,"promotion_rel_frame_id='$id'");
    if($q>0) {
      echo 1;
    } else {
      echo 0;
    }
  }

  if($_POST['status']=="ProFrmActive") {
    $status=0;
    $m->set_data('status',$status);
    $a1= array ('status'=> $m->get_data('status')
  );
    $q=$d->update('promotion_rel_frame_master',$a1,"promotion_rel_frame_id='$id'");
    if($q>0) {
      echo 1;
    } else {
      echo 0;
    }
  }
// pro frm end

//promotion
  if($_POST['status']=="promotionDeactive") {
    $status=1;
    $m->set_data('status',$status);
    $a1= array ('status'=> $m->get_data('status')
  );
    $q=$d->update('promotion_master',$a1,"promotion_id='$id'");
    if($q>0) {
      echo 1;
    } else {
      echo 0;
    }
  }

  if($_POST['status']=="promotionActive") {
    $status=0;
    $m->set_data('status',$status);
    $a1= array ('status'=> $m->get_data('status')
  );
    $q=$d->update('promotion_master',$a1,"promotion_id='$id'");
    if($q>0) {
      echo 1;
    } else {
      echo 0;
    }
  }
//promotion

//FRAME toggle start
  if($_POST['status']=="frameDeactive") {
    $status=1;
    $m->set_data('status',$status);
    $a1= array ('status'=> $m->get_data('status')
  );
    $q=$d->update('frame_master',$a1,"frame_id='$id'");
    if($q>0) {
      echo 1;
    } else {
      echo 0;
    }
  }

  if($_POST['status']=="frameActive") {
    $status=0;
    $m->set_data('status',$status);
    $a1= array ('status'=> $m->get_data('status')
  );
    $q=$d->update('frame_master',$a1,"frame_id='$id'");
    if($q>0) {
      echo 1;
    } else {
      echo 0;
    }
  }
//FRAME toggle end

//fcm toggle start
  if($_POST['status']=="fcmDeactive") {
    $send_fcm=0;
    $m->set_data('send_fcm',$send_fcm);
    $a1= array ('send_fcm'=> $m->get_data('send_fcm')
  );
    $q=$d->update('custom_settings_master',$a1,"custom_id='$id'");
    if($q>0) {
      echo 1;
    } else {
      echo 0;
    }
  }

  if($_POST['status']=="fcmActive") {
    $send_fcm=1;
    $m->set_data('send_fcm',$send_fcm);
    $a1= array ('send_fcm'=> $m->get_data('send_fcm')
  );
    $q=$d->update('custom_settings_master',$a1,"custom_id='$id'");
    if($q>0) {

      $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",ucwords('Send FCM set to true'));
      echo 1;
    } else {
      echo 0;
    }
  }
//fcm toggle end


//within city start
  if($_POST['status']=="withinCityDeactive") {
    $share_within_city=0;
    $m->set_data('share_within_city',$share_within_city);
    $a1= array ('share_within_city'=> $m->get_data('share_within_city')
  );
    $q=$d->update('custom_settings_master',$a1,"custom_id='$id'");
    if($q>0) {
       $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",ucwords('Share within city set to false'));
      echo 1;
    } else {
      echo 0;
    }
  }

  if($_POST['status']=="withinCityActive") {
    $share_within_city=1;
    $m->set_data('share_within_city',$share_within_city);
    $a1= array ('share_within_city'=> $m->get_data('share_within_city')
  );
    $q=$d->update('custom_settings_master',$a1,"custom_id='$id'");
    if($q>0) {
       $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",ucwords('Share within city set to true'));
      echo 1;
    } else {
      echo 0;
    }
  }
//within city end

//utility banner start
  //privacy start
  if($_POST['status']=="inActiveBanner") {
    $active_status=1;
    $m->set_data('active_status',$active_status);
    $a1= array ('active_status'=> $m->get_data('active_status')
  );
    $q=$d->update('utility_banner_master',$a1,"banner_id='$id'");
    if($q>0) {
      echo 1;
    } else {
      echo 0;
    }
  }

  if($_POST['status']=="activeBanner") {
    $active_status=0;
    $m->set_data('active_status',$active_status);
    $a1= array ('active_status'=> $m->get_data('active_status')
  );
    $q=$d->update('utility_banner_master',$a1,"banner_id='$id'");
    if($q>0) {
      echo 1;
    } else {
      echo 0;
    }
  }
//privacy end
//utility banner end


//privacy start
  if($_POST['status']=="userPrivacyDeactive") {
    $isActive=0;
    $m->set_data('email_privacy',$isActive);
    $a1= array ('email_privacy'=> $m->get_data('email_privacy')
  );
    $q=$d->update('users_master',$a1,"user_id='$id'");
    if($q>0) {
      $notiAry = array(
              'user_id'=>$id,
              'notification_title'=>'Email Privacy InActivated',
              'notification_desc'=>" By Admin $created_by",    
              'notification_date'=>date('Y-m-d H:i'),
              'notification_action'=>'email_privacy',
              'notification_logo'=>'',
              );
              $d->insert("user_notification",$notiAry);
      echo 1;
    } else {
      echo 0;
    }
  }

  if($_POST['status']=="userPrivacyActive") {
    $isActive=1;
    $m->set_data('email_privacy',$isActive);
    $a1= array ('email_privacy'=> $m->get_data('email_privacy')
  );
    $q=$d->update('users_master',$a1,"user_id='$id'");
    if($q>0) {
      $notiAry = array(
              'user_id'=>$id,
              'notification_title'=>'Email Privacy Activated',
              'notification_desc'=>" By Admin $created_by",    
              'notification_date'=>date('Y-m-d H:i'),
              'notification_action'=>'email_privacy',
              'notification_logo'=>'',
              );
              $d->insert("user_notification",$notiAry);

      echo 1;
    } else {
      echo 0;
    }
  }
//privacy end

  //download invoice start
  if($_POST['status']=="userDownloadInvoiceOff") {
    $isActive=0;
    $m->set_data('invoice_download',$isActive);
    $a1= array ('invoice_download'=> $m->get_data('invoice_download')
  );
    $q=$d->update('users_master',$a1,"user_id='$id'");
    if($q>0) {
       $notiAry = array(
              'user_id'=>$id,
              'notification_title'=>'Invoice Download InActivated',
              'notification_desc'=>" By Admin $created_by",    
              'notification_date'=>date('Y-m-d H:i'),
              'notification_action'=>'invoice',
              'notification_logo'=>'',
              );
              $d->insert("user_notification",$notiAry);
      echo 1;
    } else {

      echo 0;
    }
  }

  if($_POST['status']=="userDownloadInvoiceOn") {
    $isActive=1;
    $m->set_data('invoice_download',$isActive);
    $a1= array ('invoice_download'=> $m->get_data('invoice_download')
  );
    $q=$d->update('users_master',$a1,"user_id='$id'");
    if($q>0) {
      $notiAry = array(
              'user_id'=>$id,
              'notification_title'=>'Invoice Download Activated',
              'notification_desc'=>" By Admin $created_by",    
              'notification_date'=>date('Y-m-d H:i'),
              'notification_action'=>'invoice',
              'notification_logo'=>'',
              );
              $d->insert("user_notification",$notiAry);
      echo 1;
    } else {
      echo 0;
    }
  }
  //download invoice end

  if($_POST['status']=="userActive") {
    $isActive=0;
    $m->set_data('active_status',$isActive);
    $a1= array ('active_status'=> $m->get_data('active_status')
  );
    $q=$d->update('users_master',$a1,"user_id='$id'");
    if($q>0) {

      $gu=$d->select("users_master","user_id='$id'  ");
      $userData=mysqli_fetch_array($gu);
      $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$userData['user_full_name']." Activated");

      echo 1;
    } else {
      echo 0;
    }
  }

  if($_POST['status']=="userDeactive") {
    $isActive=1;
    $m->set_data('active_status',$isActive);
    $a1= array ('active_status'=> $m->get_data('active_status')
  );
    $q=$d->update('users_master',$a1,"user_id='$id'");
    if($q>0) {

      $gu=$d->select("users_master","user_id='$id'  ");
      $userData=mysqli_fetch_array($gu);
      $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$userData['user_full_name']." Deactivated");

      echo 1;
    } else {
      echo 0;
    }
  }
  
  if($_POST['status']=="countryctive") {
    $isActive=1;
    $m->set_data('active_status',$isActive);
    $a1= array ('flag'=> $m->get_data('active_status')
  );
    $q=$d->update('countries',$a1,"country_id='$id'");
    if($q>0) {
       $adm_data=$d->selectRow("country_name","countries"," country_id='$id'");
        $data_q=mysqli_fetch_array($adm_data);
        $_SESSION['msg'] =$data_q['country_name']." activated";
        $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
      echo 1;
    } else {
      echo 0;
    }
  }

  if($_POST['status']=="countryDeactive") {
    $isActive=0;
    $m->set_data('active_status',$isActive);
    $a1= array ('flag'=> $m->get_data('active_status')
  );
    $q=$d->update('countries',$a1,"country_id='$id'");
    if($q>0) {
       $adm_data=$d->selectRow("country_name","countries"," country_id='$id'");
        $data_q=mysqli_fetch_array($adm_data);
        $_SESSION['msg'] =$data_q['country_name']." deactivated";
        $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
      echo 1;
    } else {
      echo 0;
    }
  }

   if($_POST['status']=="stateActive") {
    $isActive=1;
    $m->set_data('active_status',$isActive);
    $a1= array ('state_flag'=> $m->get_data('active_status')
  );
    $q=$d->update('states',$a1,"state_id='$id'");
    if($q>0) {
       $adm_data=$d->selectRow("state_name","states"," state_id='$id'");
        $data_q=mysqli_fetch_array($adm_data);
        $_SESSION['msg'] =$data_q['state_name']." activated";
        $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);

      echo 1;
    } else {
      echo 0;
    }
  }

  if($_POST['status']=="stateDeactive") {
    $isActive=0;
    $m->set_data('active_status',$isActive);
    $a1= array ('state_flag'=> $m->get_data('active_status')
  );
    $q=$d->update('states',$a1,"state_id='$id'");
    if($q>0) {
      $adm_data=$d->selectRow("state_name","states"," state_id='$id'");
        $data_q=mysqli_fetch_array($adm_data);
        $_SESSION['msg'] =$data_q['state_name']." deactivated";
        $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
      echo 1;
    } else {
      echo 0;
    }
  }

    if($_POST['status']=="cityActive") {
    $isActive=1;
    $m->set_data('active_status',$isActive);
    $a1= array ('city_flag'=> $m->get_data('active_status')
  );
    $q=$d->update('cities',$a1,"city_id='$id'");
    if($q>0) {
       $adm_data=$d->selectRow("city_name","cities"," city_id='$id'");
        $data_q=mysqli_fetch_array($adm_data);
        $_SESSION['msg'] =$data_q['city_name']." activated";
        $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
      echo 1;
    } else {
      echo 0;
    }
  }

  if($_POST['status']=="cityDeactive") {
    $isActive=0;
    $m->set_data('active_status',$isActive);
    $a1= array ('city_flag'=> $m->get_data('active_status')
  );
    $q=$d->update('cities',$a1,"city_id='$id'");
    if($q>0) {
      $adm_data=$d->selectRow("city_name","cities"," city_id='$id'");
        $data_q=mysqli_fetch_array($adm_data);
        $_SESSION['msg'] =$data_q['city_name']." deactivated";
        $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
      echo 1;
    } else {
      echo 0;
    }
  }

    if($_POST['status']=="areaActive") {
    $isActive=1;
    $m->set_data('active_status',$isActive);
    $a1= array ('area_flag'=> $m->get_data('active_status')
  );
    $q=$d->update('area_master',$a1,"area_id='$id'");
    if($q>0) {
      $adm_data=$d->selectRow("area_name","area_master"," area_id='$id'");
        $data_q=mysqli_fetch_array($adm_data);
        $_SESSION['msg'] =$data_q['area_name']." activated";
        $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
      echo 1;
    } else {
      echo 0;
    }
  }

  if($_POST['status']=="areaDeactive") {
    $isActive=0;
    $m->set_data('active_status',$isActive);
    $a1= array ('area_flag'=> $m->get_data('active_status')
  );
    $q=$d->update('area_master',$a1,"area_id='$id'");
    if($q>0) {
      $adm_data=$d->selectRow("area_name","area_master"," area_id='$id'");
        $data_q=mysqli_fetch_array($adm_data);
        $_SESSION['msg'] =$data_q['area_name']." deactivated";
        $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
      echo 1;
    } else {
      echo 0;
    }
  }

  if($_POST['status']=="discussionDeactive") {
    $isActive=1;
    $m->set_data('active_status',$isActive);
    $a1= array ('active_status'=> $m->get_data('active_status')
  );
    $q=$d->update('cllassifieds_master',$a1,"cllassified_id='$id'");
    if($q>0) {
      echo 1;
    } else {
      echo 0;
    }
  }

   if($_POST['status']=="discussionActive") {
    $isActive=0;
    $m->set_data('active_status',$isActive);
    $a1= array ('active_status'=> $m->get_data('active_status')
  );
    $q=$d->update('cllassifieds_master',$a1,"cllassified_id='$id'");
    if($q>0) {
      echo 1;
    } else {
      echo 0;
    }
  }

}