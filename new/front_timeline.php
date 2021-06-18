<?php include("common/front_header.php");
 
 if(isset($_GET['zoobiz_admin_id']) &&  $_GET['zoobiz_admin_id'] == 4){
  $_SESSION['zoobiz_admin_id_new'] = $_GET['zoobiz_admin_id'];
 } else {
  header("Location: register");
 }
 ?> 
 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" href="img/fav.png" type="image/png">
  <!-- simplebar CSS-->
  <link href="zooAdmin/assets/plugins/simplebar/css/simplebar.css" rel="stylesheet"/>
  <!-- Bootstrap core CSS-->
  <link href="zooAdmin/assets/css/bootstrap.min.css" rel="stylesheet"/>
  <!-- animate CSS-->
  <link href="zooAdmin/assets/css/animate.css" rel="stylesheet" type="text/css"/>
  <!-- Icons CSS-->
  <link href="zooAdmin/assets/css/icons.css" rel="stylesheet" type="text/css"/>
  <!-- Sidebar CSS-->
  <link href="zooAdmin/assets/css/sidebar-menu3.css" rel="stylesheet"/>
  <!-- Custom Style-->
  <link href="zooAdmin/assets/css/app-style13.css" rel="stylesheet"/>

  <link href="zooAdmin/assets/plugins/bootstrap-datatable/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css">
  <link href="zooAdmin/assets/plugins/bootstrap-datatable/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css">
  <!--Lightbox Css-->
  <link href="zooAdmin/assets/plugins/fancybox/css/jquery.fancybox.min.css" rel="stylesheet" type="text/css"/>

  <!-- notifications css -->
  <link rel="stylesheet" href="zooAdmin/assets/plugins/notifications/css/lobibox.min.css"/>

  <!--Select Plugins-->
  <link href="zooAdmin/assets/plugins/select2/css/select2.min.css" rel="stylesheet"/>
  <!--inputtags-->
  <link href="zooAdmin/assets/plugins/inputtags/css/bootstrap-tagsinput.css" rel="stylesheet" />
  <!--multi select-->
  <link href="zooAdmin/assets/plugins/jquery-multi-select/multi-select.css" rel="stylesheet" type="text/css">
  <!--Bootstrap Datepicker-->
  <link href="zooAdmin/assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css">

  <!--material datepicker css-->
  <link rel="stylesheet" href="zooAdmin/assets/plugins/material-datepicker/css/bootstrap-material-datetimepicker.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

  <!--Select Plugins-->
  <link href="zooAdmin/assets/plugins/select2/css/select2.min.css" rel="stylesheet"/>
  <link href="zooAdmin/assets/plugins/bootstrap-switch/bootstrap-switch.min.css" rel="stylesheet">

  
   <!--Switchery-->
  <link href="zooAdmin/assets/plugins/switchery/css/switchery.min.css" rel="stylesheet" />

  <link href="zooAdmin/assets/plugins/bootstrap-switch/bootstrap-switch.min.css" rel="stylesheet">
     </head>
     <style type="text/css">
        ul.horizontal{
            margin: 0;
            padding: 0;
        }
        ul.horizontal li{
            display: block;
            float: left;
            padding: 0 10px
        }
        .facebook-card{
          max-width:600px;
          margin: 0 auto;
          border: 15px solid #ffffff; 
          background: #fff;
          border-radius: 4px;
          margin-top: 70px;
          margin-bottom: 80px;
        }

        .imgRedonda{
            width:75px;
            height:75px;
            border-radius:150px;
        }
        .imgRedonda1{
            width:50px;
            height:50px;
            border-radius:150px;
        }
        .profileName {
            font-style: inherit;
            font-size: 20px;
            color: #365899;
          text-decoration: none;
        }
        .profileName1 {
            font-style: inherit;
            font-size: 18px;
            color: #365899;
          text-decoration: none;
        }
        .textbox{
          border-radius:150px;
          size:100px;
        }
        .time{
            font-size: 15px;
            color:gray;
        }
        .facebook-card-content{
          border-radius: 150px;
        }

        .facebook-card-header{
          padding: 15px;
          align-items: right;
        }

        .facebook-card-user-image{
          width: 40px;
          height: 40px;
          border-radius: 50%;
          margin-right: 15px;
        }

        .facebook-card-user-name{
          font-size: 18px;
          font-weight: bold;
          text-decoration: none;
          color: #000;
        }

        .facebook-card-image img{
          width: 100%;
        }

        .facebook-card-content{
          padding: 15px;  
          padding-top: 5px !important;  
        }

        .facebook-card-content a{
          color: #000;
          text-decoration: none;
          font-weight: bold;
        }

        .iconos{
          color: gray;
        }
        .like{
          color: blue;
        }
        .kokoro{
          color:red;
        }
        .smile{
          color:yellow;
        }
        .other{
          color:#365899;
        }

        .facebook-comments{
          float: left;
          margin: 0; 
        }

        
        .facebook-card{
          margin-top: 10px !important;
          margin-bottom: 25px !important;
        }
        .standard-padding{
          padding-top: 50px !important;
        }
        @media screen and (max-width: 480px) {
          
            .standard-padding{
              padding-left: 5px !important;
              padding-right: 5px !important;
            }
        }
         .cls-pic{
          padding-right: 10px !important;
          float: left;
          } 
          .cls-content{
               word-break: break-all !important;
          }
          .cls-delete{
           float: right;
           padding-left: 10px !important;
            padding-right: 10px !important;
           font-weight: bold;
             
          }

           .container {
    width: 100%;
     
     margin-right: 0px !important; 
    margin-left: 1px !important;  
     padding-right: 0px !important; 
    padding-left: 6px !important;  
}
         

        
  @media screen and (max-width: 480px) {
  .time {
   width: 100% !important;
    float: left !important;
    text-align: right !important;
    font-weight: bold !important;
  }
}
     </style>
<header class="site-header" id="header" style="background: #fff;">
    <nav class="navbar navbar-expand-lg   ">
        <div class="container">
            <a class="navbar-brand" href="index">
                <img height="50"  style="width: 150px !important;"  src="img/zoobizLogo.png" alt="logo" class="logo-default">
                <img height="50"  style="width: 150px !important;"  src="img/zoobizLogo.png" alt="logo" class="logo-scrolled">
            </a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav mx-auto ml-xl-auto mr-xl-0">
                    <li class="nav-item">
                        <?php //1july2020 ?>
                           <!--  <li class="nav-item">
                                <a class="nav-link " style="color: #2abcaa !important;" href="register">     <i class="fas fa-plus"></i> <b>Register in ZooBiz</b></a>
                            </li>
                            --> <?php //1july2020 ?>
                            <a class="nav-link active pagescroll text-lowercase" style="color: #2abcaa !important;" href="#">  <!-- <button type="submit" id="submit_btn1" class="button gradient-btn w-60"> contact@zoobiz.com</button> --> <i class="fas fa-envelope"></i> <b>contact@zoobiz.in</b></a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link active pagescroll scrollupto" style="color: #2abcaa !important;" href="#"><i class="fas fa-phone"></i><b> +91 98252 93889</b></a>
                        </li>

                    </ul>
                </div>
            </div>
            
        </nav>
        
    </header>


        <section class="bglight" id="contact" style="background-image: url(zooAdmin/img/nf-bg.jpg);">
        <div class="container">
            <div class="row" style="margin-bottom: -30px !important;">
                <div class="col-md-12 text-center">
                    <div class="heading-title darkcolor wow fadeInUp" data-wow-delay="100ms">
                        <br>
                        <h3 class="font-normal darkcolor heading_space_half font-xlight ">   Timeline   </h3>
                    </div>
                    
                </div>
            </div>
 
    <?php


date_default_timezone_set('Asia/Calcutta');
    $zoo_admin_qry=$d->selectRow("admin_name,admin_profile,zoobiz_admin_id","zoobiz_admin_master","");
    $adamin_array = array();
    while($zoo_admin_data=mysqli_fetch_array($zoo_admin_qry)) {
         $adamin_array[$zoo_admin_data['zoobiz_admin_id']] = $zoo_admin_data ;
    }

    $qn=$d->select("timeline_master","","ORDER BY timeline_id DESC LIMIT 50");
     
         if(mysqli_num_rows($qn)>0){

          $feedCount=1;
         while($data_notification=mysqli_fetch_array($qn)) {
          $user_id=$data_notification['user_id'];
          $qad=$d->select("users_master","user_id='$user_id' AND active_status=0 ");
          $userData=mysqli_fetch_array($qad);


if($data_notification['user_id'] == 0 && $data_notification['admin_id'] != 0 ){
$admin_data =  $adamin_array[$data_notification['admin_id']];
 
}
          $timeline_id = $data_notification['timeline_id'];
          $fedCount1=$feedCount++;
          
     ?>

    <div class="facebook-card"  >
      <div class="facebook-card-header">

        <?php if($data_notification['user_id'] == 0 && $data_notification['admin_id'] != 0 ){ 
          //src="img/profile/<?php echo $admin_data['admin_profile']; 
         
          ?>

 <img  onerror="this.src='zooAdmin/img/user.png'" class="imgRedonda"  src="img/fav.png" width="10%">
       <?php     } else {
         ?>
        <img  onerror="this.src='zooAdmin/img/user.png'" class="imgRedonda" src="img/users/members_profile/<?php echo $userData['user_profile_pic']; ?>" width="10%">
      <?php    }  ?> 
        <a class="profileName" href="#"  >
          <?php   if($userData['user_full_name']=='') { echo 'ZooBiz Admin'; //echo 'Admin';//$admin_data['admin_name']; 
        } else { echo $userData['salutation'].' '. $userData['user_full_name']; }  ?></a>

<!-- <div style="margin-left: 12px;">
<form   action="controller/newsFeedController.php" method="post">
                          <input type="hidden" name="feed_id_delete" value="<?php echo $timeline_id; ?>">
                          <button type="submit" name="deleteCmp" class="form-btn btn btn-danger btn-sm "> <i title="Delete Post" class="fa fa-trash-o"  ></i></button>
                        </form>
</div> -->
        <a style="margin-left: 12px;" href="#" class="btn btn-sm btn-danger  pull-right" onclick="deletePost('<?php echo $timeline_id; ?>')"><i title="Delete Post" class="fa fa-trash-o"  ></i></a>  

        <a class="time pull-right"> <?php 
        if(strtotime($data_notification['created_date']) < strtotime('-30 days')) {
                     echo  date("j M Y", strtotime($data_notification['created_date']));
                 } else {
                  
                  echo time_elapsed_string($data_notification['created_date']);
                 }

                 // echo time_elapsed_string($data_notification['created_date']); ?></a> 
        <br>
        <p style="word-break: break-all !important;">  <?php echo $data_notification['timeline_text']; ?> </p>
        <?php 
        if($data_notification['meetup_user_id1'] != 0  &&  $data_notification['meetup_user_id2'] != 0 ){
          $meetup_user_id1 = $data_notification['meetup_user_id1'];
          $meetup_user_id2 = $data_notification['meetup_user_id2'];
          $meetup_user_id1_q=$d->select("users_master","user_id='$meetup_user_id1' AND active_status=0 ");
          $meetup_user_id1_data=mysqli_fetch_array($meetup_user_id1_q);

          $meetup_user_id2_q=$d->select("users_master","user_id='$meetup_user_id2' AND active_status=0 ");
          $meetup_user_id2_data=mysqli_fetch_array($meetup_user_id2_q);

           ?>
           <p style="word-break: break-all !important;">#iamzoobiz</p>
           <div class="form-group row">
            <div class="col-lg-5" style="text-align: center;">
           
            <a      href="viewMember?id=<?php echo $meetup_user_id1_data['user_id']; ?>"> 
<?php  ?> 
           <img  onerror="this.src='zooAdmin/img/user.png'" class="imgRedonda" src="img/users/members_profile/<?php echo $meetup_user_id1_data['user_profile_pic']; ?>" width="10%">
           <?php  ?> 
           <p style="word-break: break-all !important;"><?php echo $meetup_user_id1_data['user_full_name']; ?></p>
           </a>
         </div>
         <div class="col-lg-2" style="text-align: center;"><p style="word-break: break-all !important;">Are <br>Saying </p>

          <?php   ?> 
          <img  class="imgRedonda"   src="img/lets_meet_icon.png" width="100%"></div>
         <div class="col-lg-5" style="text-align: center;">
            <a     href="viewMember?id=<?php echo $meetup_user_id2_data['user_id']; ?>"> 
           <img  onerror="this.src='zooAdmin/img/user.png'" class="imgRedonda" src="img/users/members_profile/<?php echo $meetup_user_id2_data['user_profile_pic']; ?>" width="10%">
             <?php   ?> 
           <p style="word-break: break-all !important;"><?php echo $meetup_user_id2_data['user_full_name']; ?></p>
         </a>
       </div>
       </div>
        <?php }
        ?>
          
      </div>
      <?php 

       $video_qry=$d->select("timeline_photos_master","timeline_id='$data_notification[timeline_id]' and video_name!='' ");
        
       if (mysqli_num_rows($video_qry)>0) {
        while($feeData22=mysqli_fetch_array($video_qry)) {
          ?>
           <div id="carousel-4<?php echo $fedCount1; ?>" class="carousel slide" data-ride="carousel">
            <video style="max-height:450px;" class="d-block w-100" controls controlsList="nodownload">
      <source src="img/timeline/<?php echo $feeData22['video_name']; ?>"    type="video/mp4">
      
    </video>  </div>
     <br>
          <?php
        }

       } else { 
        $fi=$d->select("timeline_photos_master","timeline_id='$data_notification[timeline_id]' ");
        $i=1;
       if (mysqli_num_rows($fi)>0) {



       ?>
     
       <div id="carousel-4<?php echo $fedCount1; ?>" class="carousel slide" data-ride="carousel">
          <ul class="carousel-indicators">
            <?php while($feeData11=mysqli_fetch_array($fi)) {



              $i1= $i++;


               if($feeData11['video_name']){
          ?>
           <video width="320" height="240" controls>
      <source src="../img/timeline/<?php echo $feeData11['video_name']; ?>"    type="video/mp4">
      
    </video>  
    <?php
        } 

        ?>
            <li data-target="#demo" data-slide-to="0" class="<?php if($i1==1){ echo "active"; } ?>"></li>
            <?php } ?>
          </ul>
          <div class="carousel-inner">
            <?php 
            $x=1;
             $fi11=$d->select("timeline_photos_master","timeline_id='$data_notification[timeline_id]' ");
            while($feeData=mysqli_fetch_array($fi11)) {
             $x1=$x++;
             ?>
            <div style="background-color: white;" class="carousel-item <?php if($x1==1) { echo 'active';} else if($imageCount==1) { echo 'active';} ?>">
              <a    href="img/timeline/<?php echo $feeData['photo_name']; ?>" data-fancybox="images<?php echo $timeline_id;?>" data-caption="Photo Name : <?php echo $feeData['photo_name']; ?>">
                <?php   ?>
              <img style="max-height:450px;" class="d-block w-100" src="img/timeline/<?php echo $feeData['photo_name']; ?>" alt="">
                <?php  ?> 
              </a>
            </div>
            <?php } ?>
          </div>
          <a class="carousel-control-prev" href="#carousel-4<?php echo $fedCount1; ?>" data-slide="prev">
            <span class="carousel-control-prev-icon"></span>
          </a>
          <a class="carousel-control-next" href="#carousel-4<?php echo $fedCount1; ?>" data-slide="next">
            <span class="carousel-control-next-icon"></span>
          </a>
        </div>
       <br>
    <?php } 
  }?>




        <ul class="horizontal">
           
        
                <li>
          <?php

$qlike=$d->select("timeline_like_master,users_master","timeline_like_master.user_id =users_master.user_id and    timeline_like_master.timeline_id='$timeline_id' AND timeline_like_master.active_status = 0      AND users_master.active_status=0  "); 
 
$likesCount = mysqli_num_rows($qlike);


            //  $likesCount = $d->count_data_direct("like_id","timeline_like_master","timeline_id='$timeline_id' AND active_status = 0");
              ?>
              <span  data-toggle="modal"  <?php if( $likesCount >0) {?> data-target="#viewLikesModal" onclick="viewLikes('<?php echo $timeline_id; ?>');" <?php }?> class=" pointerCursor">Like (<?php echo  $likesCount; ?>)</span> 
                </li>



                  
                <li> 


                 

                  <?php  $qcomment=$d->select("timeline_comments,users_master","timeline_comments.timeline_id='$timeline_id' AND timeline_comments.user_id=users_master.user_id AND timeline_comments.parent_comments_id=0   AND users_master.active_status=0   order by timeline_comments.comments_id desc  "); 

$totalCmt = mysqli_num_rows($qcomment);
                   ?>
                   <?php if($totalCmt>0) {  ?>
<button class="collapsed " <?php if($totalCmt>1) {  ?> onclick="hideNewsFeedInfo('<?php echo $timeline_id;?>');"     data-toggle="collapse" data-target="#collapse<?php echo $timeline_id;?>" aria-expanded="false" <?php } ?> aria-controls="collapse-6" style="border:none !important; background-color: #fff !important; color:gray !important; " title="View All">Comment (<?php 


 echo $totalCmt=mysqli_num_rows($qcomment);// $d->count_data_direct("comments_id","timeline_comments","timeline_id='$timeline_id' group by comments_id"); ?>)</button>
    <?php } ?> 

                </li>
           </ul> 


 
          <br>
            
          <div class="facebook-card-footer">
          </div>
          <br>
        <!-- <input type="textbox" class="textbox form-control" placeholder="Write a comment" size="45">    <br> <br> -->

<span id="showNewsFeedIfo<?php echo $timeline_id;?>" style="display: block;">
        <?php 
        $counterCmt = 1;
        if ($totalCmt>0) {
         $qcomment=$d->select("timeline_comments,users_master","timeline_comments.timeline_id='$timeline_id' AND timeline_comments.user_id=users_master.user_id AND timeline_comments.parent_comments_id=0  AND users_master.active_status=0 order by timeline_comments.comments_id desc  ");
         while($data_comment=mysqli_fetch_array($qcomment)) {
            $comments_id=$data_comment['comments_id'];

            if($counterCmt==1){
         ?>
        <div class="facebook-card-comments">

           <span style="float: left; ">
          <img  onerror="this.src='zooAdmin/img/user.png'" class="imgRedonda1" src="img/users/members_profile/<?php echo $data_comment['user_profile_pic']; ?>" width="10%">
        </span>
          <span style="float: right;">
          <i title="Delete Comment" class=" text-danger fa fa-trash-o "  data-toggle="modal" data-target="#editFloor" onclick="deleteComment('<?php echo $comments_id; ?>')"></i>
        </span>



           <p>
          <a style="padding-left: 5px !important;" href="viewMember?id=<?php echo $data_comment['user_id']; ?>" target="_blank" class="profileName1 text-primary"> <?php echo $data_comment['user_name']; ?> </a> <span class="pull-right"><?php echo time_elapsed_string($data_comment['modify_date']); ?></span>
          <br> <?php echo $data_comment['msg']; ?>    
         </p>
        
 

          <br><br>
        </div>
         <?php  $subComment=$d->select("timeline_comments,users_master","timeline_comments.timeline_id='$timeline_id' AND timeline_comments.user_id=users_master.user_id AND timeline_comments.parent_comments_id='$comments_id'  AND users_master.active_status=0 order by timeline_comments.modify_date asc  limit 0,100 ");

         while($data_Sub_comment=mysqli_fetch_array($subComment)) {
            $comments_id=$data_Sub_comment['comments_id'];?>
        <div class="facebook-card-comments" style="margin-left: 46px;">
          <span style="float: left; ">
          <img  onerror="this.src='zooAdmin/img/user.png'" class="imgRedonda1" src="img/users/members_profile/<?php echo $data_Sub_comment['user_profile_pic']; ?>" width="10%">
        </span>

        <span style="float: right;">
          <i title="Delete Comment" class="text-danger fa fa-trash-o "  data-toggle="modal" data-target="#editFloor" onclick="deleteComment('<?php echo $comments_id; ?>')"></i>
        </span>
            <p>
          <a style="padding-left: 5px !important;"  href="viewMember?id=<?php echo $data_Sub_comment['user_id']; ?>" target="_blank" class="profileName1 text-primary"> <?php echo $data_Sub_comment['user_name']; ?></a><span class="pull-right"><?php echo time_elapsed_string($data_Sub_comment['modify_date']); ?></span> <br><?php echo $data_Sub_comment['msg']; ?> 
          </p>

          

          <br><br>
        </div>
        <?php }
        }
        $counterCmt++;
        } 
        //IS_248

        
        //IS_248
         } ?>
</span>
<?php //IS_387 ?>
   <div id="collapse<?php echo $timeline_id;?>" class="collapse"   style="">
                  <div class="">
                    <?php 
        
        if ($totalCmt>0) {
          $qcomment=$d->select("timeline_comments,users_master","timeline_comments.timeline_id='$timeline_id' AND timeline_comments.user_id=users_master.user_id AND timeline_comments.parent_comments_id=0  AND users_master.active_status=0  group by timeline_comments.comments_id order by timeline_comments.modify_date asc  limit 0,100 ");

         while($data_comment=mysqli_fetch_array($qcomment)) {
            $comments_id=$data_comment['comments_id'];

           
         ?>
        <div class="facebook-card-comments">
          <span style="float: left; ">
          <img  onerror="this.src='zooAdmin/img/user.png'" class="imgRedonda1" src="img/users/members_profile/<?php echo $data_comment['user_profile_pic']; ?>" width="10%">
        </span>

        <span style="float: right;">
          <i title="Delete Comment" class="text-danger fa fa-trash-o "  data-toggle="modal" data-target="#editFloor" onclick="deleteComment('<?php echo $comments_id; ?>')"></i>
        </span>
            <p>
          <a style="padding-left: 5px !important;"  href="viewMember?id=<?php echo $data_comment['user_id']; ?>" target="_blank" class="profileName1 text-primary"> <?php echo $data_comment['user_name']; ?></a><span class="pull-right"><?php echo time_elapsed_string($data_comment['modify_date']); ?></span> <br><?php echo $data_comment['msg']; ?> 
          </p>

          

          <br><br>
        </div>
        <!-- sub comment -->
        <?php  $subComment=$d->select("timeline_comments,users_master","timeline_comments.timeline_id='$timeline_id' AND timeline_comments.user_id=users_master.user_id AND timeline_comments.parent_comments_id='$comments_id'  AND users_master.active_status=0 order by timeline_comments.modify_date asc  limit 0,100 ");

         while($data_Sub_comment=mysqli_fetch_array($subComment)) {
            $comments_id=$data_Sub_comment['comments_id'];?>
        <div class="facebook-card-comments" style="margin-left: 46px;">
          <span style="float: left; ">
          <img  onerror="this.src='zooAdmin/img/user.png'" class="imgRedonda1" src="img/users/members_profile/<?php echo $data_Sub_comment['user_profile_pic']; ?>" width="10%">
        </span>

        <span style="float: right;">
          <i title="Delete Comment" class="text-danger fa fa-trash-o "  data-toggle="modal" data-target="#editFloor" onclick="deleteComment('<?php echo $comments_id; ?>')"></i>
        </span>
            <p>
          <a style="padding-left: 5px !important;"  href="viewMember?id=<?php echo $data_Sub_comment['user_id']; ?>" target="_blank" class="profileName1 text-primary"> <?php echo $data_Sub_comment['user_name']; ?></a><span class="pull-right"><?php echo time_elapsed_string($data_Sub_comment['modify_date']); ?></span> <br><?php echo $data_Sub_comment['msg']; ?> 
          </p>

          

          <br><br>
        </div>
        <?php }
        } 
        //IS_248

        $qcomment=$d->select("timeline_comments,zoobiz_admin_master ","timeline_comments.timeline_id='$timeline_id' AND timeline_comments.user_id=zoobiz_admin_master.zoobiz_admin_id order by timeline_comments.modify_date asc limit 0,100");
         while($data_comment=mysqli_fetch_array($qcomment)) {
            $comments_id=$data_comment['comments_id'];
            
         ?>
        <div class="facebook-card-comments">
          <span class="cls-pic">
          <img  onerror="this.src='zooAdmin/img/user.png'" class="imgRedonda1" src="zooAdmin/img/profile/<?php echo $data_comment['admin_profile']; ?>" width="10%">
            </span>  
            
            <span class=" cls-delete"  >
          <b><i title="Delete Comment" class="text-danger fa fa-trash-o "  data-toggle="modal" data-target="#editFloor" onclick="deleteComment('<?php echo $comments_id; ?>')"></i></b>
        </span>
        
        <p class=" cls-content text-justify ">
          <a   href="viewMember?id=<?php echo $data_comment['user_id']; ?>" target="_blank" class="profileName1 text-primary"> <?php echo $data_comment['user_name']; ?></a> <?php echo $data_comment['msg']; ?> at <?php echo date("d-m-Y H:i A", strtotime($data_comment['modify_date'])); ?>  
         </p>

           
          <br><br>
        </div>

        


        <?php  
      }
        //IS_248
         } ?>
                  </div>
                </div>
<?php // IS_387?>

    </div>
  
    <?php } 

         }
  ?>

</div>
</div>
 
 </section>
 <div class="modal fade" id="viewLikesModal">
  <div class="modal-dialog">
    <div class="modal-content border-fincasys">
      <div class="modal-header bg-fincasys">
        <h5 class="modal-title text-white">Likes</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="likeResp">
          
      </div>
     
    </div>
  </div>
</div><!--End Modal -->

 <?php 
include("common/front_footer.php"); 
?>