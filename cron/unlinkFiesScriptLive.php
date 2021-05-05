<?php   include '../zooAdmin/lib/dao.php';
include '../zooAdmin/lib/model.php';
include '../zooAdmin/fcm_file/user_fcm.php';
$d = new dao();
$m = new model();
http://localhost/cron/unlinkFiesScript.php
$con = $d->dbCon();

$base_url = $m->base_url();
extract(array_map("test_input", $_POST));

// img/promotion
if(0){ 
  echo "<h1>promotion_master</h1>";
   $files = scandir('../img/promotion/');
  foreach($files as $file) {
    $name= explode(".", $file);

    if ($name[1] !='') {
    
      $qqq=$d->select("promotion_master","event_frame='$file' OR event_image='$file' ");

      $qqq1=$d->select("seasonal_greet_image_master","cover_image='$file' OR background_image='$file' ");
      
         if ( mysqli_num_rows($qqq) <= 0 &&  mysqli_num_rows($qqq1) <= 0 ) {
         $abspath=$_SERVER['DOCUMENT_ROOT'];
         $path = $abspath."/img/promotion/".$file;
        // $path = $base_url."img/promotion/".$file;

          echo "<br>select * from promotion_master where event_frame='$file' OR event_image='$file';";
          echo "<br>select * from seasonal_greet_image_master where  cover_image='$file' OR background_image='$file' ;";
          echo ' <br> unused file: '.$path.'<br>';
         //  unlink($path);
        }
    }
    
  }
}
 

// img/api/ folder "
if(0){ 
echo "<h1>api_master</h1>";
 $files = scandir('../img/api/');
foreach($files as $file) {
  $name= explode(".", $file);

  if ($name[1] !='') {
  
    $qqq=$d->select("api_master","api_file='$file'");
       if ( mysqli_num_rows($qqq) <= 0 ) {
       $abspath=$_SERVER['DOCUMENT_ROOT'];
         $path = $abspath."/img/api/".$file; 
        echo "<br>select * from api_master where api_file='$file' ;";
        echo ' <br> unused file: '.$path.'<br>';
       // unlink($path);
      }
  }
  
}
}
 
 
// img/promotion/promotion_frames/
if(0){ 
echo "<h1>promotion_frame_master</h1>";
 $files = scandir('../img/promotion/promotion_frames/');
foreach($files as $file) {
  $name= explode(".", $file);

  if ($name[1] !='') {
  
    $qqq=$d->select("promotion_frame_master","promotion_frame='$file'");
       if ( mysqli_num_rows($qqq) <= 0 ) {
       $abspath=$_SERVER['DOCUMENT_ROOT'];
       $path = $abspath."/img/promotion/promotion_frames/".$file;

//$path = $base_url."img/promotion/promotion_frames/".$file;
        echo "<br>select * from promotion_frame_master where promotion_frame='$file' ;";
        echo ' <br> unused file: '.$path.'<br>';
       //unlink($path);
      }
  }
  
}
}






// img/promotion/promotion_center_image/
if(0){ 
echo "<h1>promotion_center_image_master</h1>";
 $files = scandir('../img/promotion/promotion_center_image/');
foreach($files as $file) {
  $name= explode(".", $file);

  if ($name[1] !='') {
  
    $qqq=$d->select("promotion_center_image_master","promotion_center_image='$file'");
       if ( mysqli_num_rows($qqq) <= 0 ) {
       $abspath=$_SERVER['DOCUMENT_ROOT'];
         $path = $abspath."/img/promotion/promotion_center_image/".$file;
//$path = $base_url."img/promotion/promotion_center_image/".$file;
        echo "<br>select * from promotion_center_image_master where promotion_center_image='$file' ;";
        echo ' <br> unused file: '.$path.'<br>';
        // unlink($path);
      } 
  }
  
}
}




// img/category/
if(0){ 
echo "<h1>business_categories - category_images</h1>";
 $files = scandir('../img/category/');
foreach($files as $file) {
  $name= explode(".", $file);

  if ($name[1] !='') {
  
    $qqq=$d->select("business_categories","category_images='$file'");
       if ( mysqli_num_rows($qqq) <= 0 ) {
       $abspath=$_SERVER['DOCUMENT_ROOT'];
        $path = $abspath."/img/category/".$file;

        echo "<br>select * from business_categories where category_images='$file' ;";
        echo ' <br> unused file: '.$path.'<br>';
        //unlink($path);
      }
  }
  
}
}


// img/category/icon/
if(0){ 
echo "<h1>business_categories - menu_icon</h1>";
 $files = scandir('../img/category/icon/');
foreach($files as $file) {
  $name= explode(".", $file);

  if ($name[1] !='') {
  
    $qqq=$d->select("business_categories","menu_icon='$file'");
       if ( mysqli_num_rows($qqq) <= 0 ) {
       $abspath=$_SERVER['DOCUMENT_ROOT'];
        $path = $abspath."/img/category/icon/".$file;

        echo "<br>select * from business_categories where menu_icon='$file' ;";
        echo ' <br> unused file: '.$path.'<br>';
      //  unlink($path);
      }
  }
  
}
}


// img/sub_category
if(0){ 
echo "<h1>sub_category_images - sub_category</h1>";
 $files = scandir('../img/sub_category/');
foreach($files as $file) {
  $name= explode(".", $file);

  if ($name[1] !='') {
  
    $qqq=$d->select("business_sub_categories","sub_category_images='$file'");
       if ( mysqli_num_rows($qqq) <= 0 ) {
       $abspath=$_SERVER['DOCUMENT_ROOT'];
        $path = $abspath."/img/sub_category/".$file;

        echo "<br>select * from business_sub_categories where sub_category_images='$file' ;";
        echo ' <br> unused file: '.$path.'<br>';
      //  unlink($path);
      }
  }
  
}
}

 

// img/company
if(0){ 
echo "<h1>company_master</h1>";
 $files = scandir('../img/company/');
foreach($files as $file) {
  $name= explode(".", $file);

  if ($name[1] !='') {
  
    $qqq=$d->select("company_master","company_logo='$file'");

    $qqq2=$d->select("payment_getway_master","payment_getway_logo='$file'");
       if ( mysqli_num_rows($qqq) <= 0 && mysqli_num_rows($qqq2) <= 0) {
       $abspath=$_SERVER['DOCUMENT_ROOT'];
        $path = $abspath."/img/company/".$file;

        echo "<br>select * from company_master where company_logo='$file' ;";
        echo "<br>select * from payment_getway_master where payment_getway_logo='$file' ;";
        echo ' <br> unused file: '.$path.'<br>';
      //  unlink($path);
      }
  }
  
}
}

// img/deals
if(0){ 
echo "<h1>deal_master</h1>";
 $files = scandir('../img/deals/');
foreach($files as $file) {
  $name= explode(".", $file);

  if ($name[1] !='') {
  
    $qqq=$d->select("deal_master","deal_image='$file'");
       if ( mysqli_num_rows($qqq) <= 0 ) {
       $abspath=$_SERVER['DOCUMENT_ROOT'];
        $path = $abspath."/img/deals/".$file;

        echo "<br>select * from deal_master where deal_image='$file' ;";
        echo ' <br> unused file: '.$path.'<br>';
      //  unlink($path);
      }
  }
  
}
}


// img/timeline
if(0){ 
echo "<h1>timeline_photos_master</h1>";
 $files = scandir('../img/timeline/');
foreach($files as $file) {
  $name= explode(".", $file);

  if ($name[1] !='') {
  
    $qqq=$d->select("timeline_photos_master","photo_name='$file' or video_name = '$file'");
       if ( mysqli_num_rows($qqq) <= 0 ) {
       $abspath=$_SERVER['DOCUMENT_ROOT'];
        $path = $abspath."/img/timeline/".$file;

        echo "<br>select * from timeline_photos_master where photo_name='$file' or video_name = '$file' ;";
        echo ' <br> unused file: '.$path.'<br>';
      //  unlink($path);
      }
  }
  
}
}

// img/circuler
if(0){ 
echo "<h1>circulars_master</h1>";
 $files = scandir('../img/circuler/');
foreach($files as $file) {
  $name= explode(".", $file);

  if ($name[1] !='') {
  
    $qqq=$d->select("circulars_master","circular_description like'%$file%' ");
       if ( mysqli_num_rows($qqq) <= 0 ) {
       $abspath=$_SERVER['DOCUMENT_ROOT'];
        $path = $abspath."/img/circuler/".$file;

        echo "<br>select * from circulars_master where circular_description like'%$file%' ;";
        echo ' <br> unused file: '.$path.'<br>';
      //  unlink($path);
      }
  }
  
}
}



// img/sliders
if(0){ 
echo "<h1>advertisement_master, slider_master</h1>";
 $files = scandir('../img/sliders/');
foreach($files as $file) {
  $name= explode(".", $file);

  if ($name[1] !='') {
  
    $qqq=$d->select("advertisement_master","advertisement_url='$file'");

    $qqq1=$d->select("slider_master","slider_image='$file'");
       if ( mysqli_num_rows($qqq) <= 0  && mysqli_num_rows($qqq1) <= 0 ) {
       $abspath=$_SERVER['DOCUMENT_ROOT'];
        $path = $abspath."/img/sliders/".$file;

        echo "<br>select * from advertisement_master where advertisement_url='$file' ;";
        echo "<br>select * from slider_master where slider_image='$file' ;";
        echo ' <br> unused file: '.$path.'<br>';
      //  unlink($path);
      }
  }
  
}
}




// img/users/company_logo/
if(0){ 
echo "<h1>user_employment_details</h1>";
 $files = scandir('../img/users/company_logo/');
foreach($files as $file) {
  $name= explode(".", $file);

  if ($name[1] !='') {
  
    $qqq=$d->select("user_employment_details","company_logo='$file'");

     
       if ( mysqli_num_rows($qqq) <= 0   ) {
       $abspath=$_SERVER['DOCUMENT_ROOT'];
        $path = $abspath."/img/users/company_logo/".$file;

        echo "<br>select * from user_employment_details where company_logo='$file' ;";
         echo ' <br> unused file: '.$path.'<br>';
      //  unlink($path);
      }
  }
  
}
}


// img/users/company_broucher/
if(0){ 
echo "<h1>user_employment_details - company_broucher</h1>";
 $files = scandir('../img/users/company_broucher/');
foreach($files as $file) {
  $name= explode(".", $file);

  if ($name[1] !='') {
  
    $qqq=$d->select("user_employment_details","company_broucher='$file'");

     
       if ( mysqli_num_rows($qqq) <= 0   ) {
       $abspath=$_SERVER['DOCUMENT_ROOT'];
        $path = $abspath."/img/users/company_broucher/".$file;

        echo "<br>select * from user_employment_details where company_broucher='$file' ;";
         echo ' <br> unused file: '.$path.'<br>';
      //  unlink($path);
      }
  }
  
}
}

// img/users/comapany_profile/
if(0){ 
echo "<h1>user_employment_details - comapany_profile</h1>";
 $files = scandir('../img/users/comapany_profile/');
foreach($files as $file) {
  $name= explode(".", $file);

  if ($name[1] !='') {
  
    $qqq=$d->select("user_employment_details","company_profile='$file'");

     
       if ( mysqli_num_rows($qqq) <= 0   ) {
       $abspath=$_SERVER['DOCUMENT_ROOT'];
        $path = $abspath."/img/users/comapany_profile/".$file;

        echo "<br>select * from user_employment_details where company_profile='$file' ;";
         echo ' <br> unused file: '.$path.'<br>';
      //  unlink($path);
      }
  }
  
}
}

// img/users/members_profile/
if(0){ 
echo "<h1>users_master - user_profile_pic</h1>";
 $files = scandir('../img/users/members_profile/');
foreach($files as $file) {
  $name= explode(".", $file);

  if ($name[1] !='') {
  
    $qqq=$d->select("users_master","user_profile_pic='$file'");

     
       if ( mysqli_num_rows($qqq) <= 0   ) {
       $abspath=$_SERVER['DOCUMENT_ROOT'];
        $path = $abspath."/img/users/members_profile/".$file;

        echo "<br>select * from users_master where user_profile_pic='$file' ;";
         echo ' <br> unused file: '.$path.'<br>';
      //  unlink($path);
      }
  }
  
}
}


// img/zoobizz_support/
if(0){ 
echo "<h1>feedback_master - zoobizz_support</h1>";
 $files = scandir('../img/zoobizz_support/');
foreach($files as $file) {
  $name= explode(".", $file);

  if ($name[1] !='') {
  
    $qqq=$d->select("feedback_master","attachment='$file'");

     
       if ( mysqli_num_rows($qqq) <= 0   ) {
       $abspath=$_SERVER['DOCUMENT_ROOT'];
        $path = $abspath."/img/zoobizz_support/".$file;

        echo "<br>select * from feedback_master where attachment='$file' ;";
         echo ' <br> unused file: '.$path.'<br>';
      //  unlink($path);
      }
  }
  
}
}

 
echo "<h1>API starst from here</h1>";

// img/chatImg/
if(0){ 
echo "<h1>chat_master - chatImg</h1>";
 $files = scandir('../img/chatImg/');
foreach($files as $file) {
  $name= explode(".", $file);

  if ($name[1] !='') {
  
    $qqq=$d->select("chat_master","msg_img='$file'");

     
       if ( mysqli_num_rows($qqq) <= 0   ) {
       $abspath=$_SERVER['DOCUMENT_ROOT'];
        $path = $abspath."/img/chatImg/".$file;

        echo "<br>select * from chat_master where msg_img='$file' ;";
         echo ' <br> unused file: '.$path.'<br>';
      //  unlink($path);
      }
  }
  
}
}


// img/cllassified/audio/
if(0){ 
echo "<h1>cllassifieds_master - chatImg</h1>";
 $files = scandir('../img/cllassified/audio/');
foreach($files as $file) {
  $name= explode(".", $file);

  if ($name[1] !='') {
  
    $qqq=$d->select("cllassifieds_master","classified_audio='$file'");

     
       if ( mysqli_num_rows($qqq) <= 0   ) {
       $abspath=$_SERVER['DOCUMENT_ROOT'];
        $path = $abspath."/img/cllassified/audio/".$file;

        echo "<br>select * from cllassifieds_master where classified_audio='$file' ;";
         echo ' <br> unused file: '.$path.'<br>';
      //  unlink($path);
      }
  }
  
}
}

// img/cllassified/
if(0){ 
echo "<h1>classified_photos_master , cllassifieds_master</h1>";
 $files = scandir('../img/cllassified/');
foreach($files as $file) {
  $name= explode(".", $file);

  if ($name[1] !='') {
  
    $qqq=$d->select("classified_photos_master","photo_name='$file'");
$qqq2=$d->select("cllassifieds_master","cllassified_photo='$file' or cllassified_file ='$file' ");

     
       if ( mysqli_num_rows($qqq) <= 0 && mysqli_num_rows($qqq2) <= 0   ) {
       $abspath=$_SERVER['DOCUMENT_ROOT'];
        $path = $abspath."/img/cllassified/".$file;

        echo "<br>select * from classified_photos_master where photo_name='$file' ;";
         echo "<br>select * from cllassifieds_master where cllassified_photo='$file' or cllassified_file ='$file' ;";
        echo ' <br> unused file: '.$path.'<br>';
      //  unlink($path);
      }
  }
  
}
}


// img/cllassified/docs/
if(0){ 
echo "<h1>classified_document_master - cllassified</h1>";
 $files = scandir('../img/cllassified/docs/');
foreach($files as $file) {
  $name= explode(".", $file);

  if ($name[1] !='') {
  
    $qqq=$d->select("classified_document_master","document_name='$file'");
  
       if ( mysqli_num_rows($qqq) <= 0   ) {
       $abspath=$_SERVER['DOCUMENT_ROOT'];
        $path = $abspath."/img/cllassified/docs/".$file;

        echo "<br>select * from classified_document_master where document_name='$file' ;";
         
        echo ' <br> unused file: '.$path.'<br>';
      //  unlink($path);
      }
  }
  
}
}





// zooAdmin/img/profile  
if(0){ 
echo "<h1>zoobiz_admin_master</h1>";
 $files = scandir('../zooAdmin/img/profile/');
foreach($files as $file) {
  $name= explode(".", $file);

  if ($name[1] !='') {
  
    $qqq=$d->select("zoobiz_admin_master","admin_profile='$file'  ");
       if ( mysqli_num_rows($qqq) <= 0 ) {
       $abspath=$_SERVER['DOCUMENT_ROOT'];
        $path = $abspath."/zooAdmin/img/profile/".$file;

        echo "<br>select * from zoobiz_admin_master where admin_profile='$file';";
        echo ' <br> unused file: '.$path.'<br>';
      //  unlink($path);
      }
  }
  
}
}
 
                exit;
  
 ?>