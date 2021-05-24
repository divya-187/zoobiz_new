<?php   
// ini_set('session.cache_limiter','public');
// session_cache_limiter(false);
session_start();
// error_reporting(0);
include 'object.php';
include 'checkLogin.php';
include 'accessControl.php';
include 'accessControlPage.php';
date_default_timezone_set('Asia/Calcutta');
if (isset($_SESSION['zoobiz_admin_id'])) {
    $zoobiz_admin_id = $_SESSION['zoobiz_admin_id'];
}

if(isset($_SESSION['role_id']) && $_SESSION['role_id'] ==1   ){ 
  $arr_get = array();

  //echo "<pre>";print_r($_GET);exit;
$aa = array('social_media','map_view_filter_city_id');

if(!isset($_GET['map_view_filter_city_id'])){ 
   foreach ($_GET as  $key => $valueNew) {

  
          if( !in_array($key, $aa)  ){ 
            if(strpos($valueNew, '\'') !== false){

              $valueNew = str_ireplace( array( '\'','"'),'', $valueNew);
                 $arr_get[$key] = $valueNew;
                 
              /* $url2= explode("&", $_SERVER['QUERY_STRING']);
               $pageName = explode("=", $url2[0]);
                header("Location: $pageName[1]?test=test");
                exit;*/
               
            } else {
              $valueNew = str_ireplace( array( '\'','"'),'', $valueNew);
                 $arr_get[$key] = $valueNew;
            }
    }


         
   }

   if(!empty($arr_get)){
    $_GET = $arr_get;
   }
  }

  
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
  <meta name="description" content=""/>
  <meta name="author" content=""/>
  <title><?php  echo ucwords($_GET['f']); ?> | ZooBiz - Partner</title>
  <!--favicon-->
  <link rel="icon" href="../img/fav.png" type="image/png">
  <!-- simplebar CSS-->
  <link href="../zooAdmin/assets/plugins/simplebar/css/simplebar.css" rel="stylesheet"/>
  <!-- Bootstrap core CSS-->
  <link href="../zooAdmin/assets/css/bootstrap.min.css" rel="stylesheet"/>
  <!-- animate CSS-->
  <link href="../zooAdmin/assets/css/animate.css" rel="stylesheet" type="text/css"/>
  <!-- Icons CSS-->
  <link href="../zooAdmin/assets/css/icons.css" rel="stylesheet" type="text/css"/>
  <!-- Sidebar CSS-->
  <link href="../zooAdmin/assets/css/sidebar-menu3.css" rel="stylesheet"/>
  <!-- Custom Style-->
  <link href="../zooAdmin/assets/css/app-style13.css" rel="stylesheet"/>
  <link href="../zooAdmin/assets/css/custom2.css" rel="stylesheet"/>
  <link href="../zooAdmin/assets/plugins/bootstrap-datatable/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css">
  <link href="../zooAdmin/assets/plugins/bootstrap-datatable/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css">
  <!--Lightbox Css-->
  <link href="../zooAdmin/assets/plugins/fancybox/css/jquery.fancybox.min.css" rel="stylesheet" type="text/css"/>

  <!-- notifications css -->
  <link rel="stylesheet" href="../zooAdmin/assets/plugins/notifications/css/lobibox.min.css"/>

  <!--Select Plugins-->
  <link href="../zooAdmin/assets/plugins/select2/css/select2.min.css" rel="stylesheet"/>
  <!--inputtags-->
  <link href="../zooAdmin/assets/plugins/inputtags/css/bootstrap-tagsinput.css" rel="stylesheet" />
  <!--multi select-->
  <link href="../zooAdmin/assets/plugins/jquery-multi-select/multi-select.css" rel="stylesheet" type="text/css">
  <!--Bootstrap Datepicker-->
  <link href="../zooAdmin/assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css">

  <!--material datepicker css-->
  <link rel="stylesheet" href="../zooAdmin/assets/plugins/material-datepicker/css/bootstrap-material-datetimepicker.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

  <!--Select Plugins-->
  <link href="../zooAdmin/assets/plugins/select2/css/select2.min.css" rel="stylesheet"/>
  <link href="../zooAdmin/assets/plugins/bootstrap-switch/bootstrap-switch.min.css" rel="stylesheet">

  
   <!--Switchery-->
  <link href="../zooAdmin/assets/plugins/switchery/css/switchery.min.css" rel="stylesheet" />

  <link href="../zooAdmin/assets/plugins/bootstrap-switch/bootstrap-switch.min.css" rel="stylesheet">

   <link href="../zooAdmin/assets/css/custom2.css" rel="stylesheet" />
 
  
</head>

<body>


<div class="ajax-loader">
  <img src="../img/ajax-loader-zoobiz.gif" class="img-responsive" />
</div>

<div id="spinner">  </div>


<!-- Start wrapper-->
 <div id="wrapper">
 
  <!--Start sidebar-wrapper-->
   <div id="sidebar-wrapper" data-simplebar="" data-simplebar-auto-hide="true">
     <div class="brand-logo">
      <a href="welcome">
       <img style="width:165px !important;" src="../img/logo.png" class="logo-icon" alt="logo">
       <h5 class="logo-text"></h5>
     </a>
   </div>
    <?php include 'sidebar.php'; ?>
   
   </div>
   <!--End sidebar-wrapper-->

<!--Start topbar header-->

<header class="topbar-nav">
 <nav class="navbar navbar-expand fixed-top bg-fincasys">
  <ul class="navbar-nav mr-auto align-items-center">
    <li class="nav-item">
      <a class="nav-link toggle-menu" href="javascript:void();">
       <i class="icon-menu menu-icon"></i>
     </a>
    </li>
    <li class="nav-item">
      <!-- Plan Expire : <?php //echo  date("d/m/Y", strtotime($_SESSION['plan_expire_date']));?> -->
      <!-- <form class="search-bar">
        <input type="text" class="form-control" placeholder="Enter keywords">
         <a href="javascript:void();"><i class="icon-magnifier"></i></a>
      </form> -->
    </li>
  </ul>
     
  <ul class="navbar-nav align-items-center right-nav-link">

    <li class="nav-item dropdown-lg">
      <a   href="<?php echo $base_url;?>" target="_blank" class="nav-link dropdown-toggle dropdown-toggle-nocaret waves-effect"  ><i class="fa fa-globe"></i></a>
    </li> 

<?php  if($_SESSION['role_id'] == 1     ){  ?>
    <li class="nav-item dropdown-lg">
      <a  data-toggle="modal" data-target="#dealModal"  class="nav-link dropdown-toggle dropdown-toggle-nocaret waves-effect"  href="javascript:void();"><i class="fa fa-certificate"></i><span class="badge badge-warning badge-up">+</span> </a>
    </li> 
     <li class="nav-item dropdown-lg">
      <a  data-toggle="modal" data-target="#notification"  class="nav-link dropdown-toggle dropdown-toggle-nocaret waves-effect"  href="javascript:void();">
      <i class="fa fa-bullhorn"></i><span class="badge badge-warning badge-up">+</span></a>
    </li> 
<?php }?> 
     

    <li class="nav-item">
      <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown" href="#">
        <span class="user-profile"> <img onerror="this.src='../zooAdmin/img/user.png'"  src="../img/users/members_profile/<?php echo $_SESSION['admin_profile']; ?>" class="img-circle" alt="user avatar"> 
          <?php
        echo  $_SESSION['admin_name'] ;
        ?>  </span>
      </a>
     
    </li>
    <li class="nav-item dropdown-lg">
      <a class="nav-link dropdown-toggle dropdown-toggle-nocaret waves-effect" href="logout.php">
      <i class="fa fa-power-off"></i></a>
    </li>
    <li class="nav-item dropdown-lg">
      <a class="nav-link dropdown-toggle dropdown-toggle-nocaret waves-effect" href="welcome">
      <i class="fa fa-home"></i></a>
    </li>
  </ul>
</nav>
</header>
<!--End topbar header-->

<div class="clearfix"></div>
	