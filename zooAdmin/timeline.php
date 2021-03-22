<html>
  <head>
    <meta charset="uft-8">
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
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

        /*4march2020*/
        .facebook-card{
          margin-top: 30px !important;
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

           
        /*4march2020*/

        

     </style>
  <body style="background-image: url(img/nf-bg.jpg);">
    <div class="standard-padding">

    <div class="text-center" style="padding-top: 70px;">
      <a data-toggle="modal" data-target="#feed" class="btn btn-primary btn-sm" href="#">Add New Post</a>
    </div>
    <?php

date_default_timezone_set('Asia/Calcutta');

    $zoo_admin_qry=$d->selectRow("admin_name,admin_profile,zoobiz_admin_id","zoobiz_admin_master","");
    $adamin_array = array();
    while($zoo_admin_data=mysqli_fetch_array($zoo_admin_qry)) {
         $adamin_array[$zoo_admin_data['zoobiz_admin_id']] = $zoo_admin_data ;
    }
          
 


    $qn=$d->select("timeline_master","","ORDER BY timeline_id DESC LIMIT 100");
     
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

 <img  onerror="this.src='img/user.png'" class="imgRedonda lazyload"  src="../img/infinity.gif" data-src="../img/fav.png" width="10%">
       <?php  } else {?>
        <img  onerror="this.src='img/user.png'" class="imgRedonda lazyload" src="../img/infinity.gif"  data-src="../img/users/members_profile/<?php echo $userData['user_profile_pic']; ?>" width="10%">
      <?php } ?> 
        <a class="profileName" href="viewMember?id=<?php echo $data_notification['user_id']; ?>" target="_blank">
          <?php if($userData['user_full_name']=='') { echo 'Admin';//$admin_data['admin_name']; 
        } else { echo $userData['salutation'].' '. $userData['user_full_name']; } ?></a>

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

           <img  onerror="this.src='img/user.png'" class="imgRedonda lazyload" src="../img/infinity.gif"  data-src="../img/users/members_profile/<?php echo $meetup_user_id1_data['user_profile_pic']; ?>" width="10%">
           <p style="word-break: break-all !important;"><?php echo $meetup_user_id1_data['user_full_name']; ?></p>
           </a>
         </div>
         <div class="col-lg-2" style="text-align: center;"><p style="word-break: break-all !important;">Are <br>Saying </p><img  class="imgRedonda lazyload" src="../img/infinity.gif"   data-src="../img/lets_meet_icon.png" width="100%"></div>
         <div class="col-lg-5" style="text-align: center;">
            <a     href="viewMember?id=<?php echo $meetup_user_id2_data['user_id']; ?>"> 
           <img  onerror="this.src='img/user.png'" class="imgRedonda lazyload" src="../img/infinity.gif" data-src="../img/users/members_profile/<?php echo $meetup_user_id2_data['user_profile_pic']; ?>" width="10%">
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
      <source  src="../img/timeline/<?php echo $feeData22['video_name']; ?>"    type="video/mp4">
      
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


              /* if($feeData11['video_name']){
          ?>
           <video width="320" height="240" controls>
      <source src="../img/timeline/<?php echo $feeData11['video_name']; ?>"    type="video/mp4">
      
    </video>  
    <?php
        }*/

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
              <a    href="../img/timeline/<?php echo $feeData['photo_name']; ?>" data-fancybox="images<?php echo $timeline_id;?>" data-caption="Photo Name : <?php echo $feeData['photo_name']; ?>">
              <img style="max-height:450px;" class="d-block w-100 lazyload" src="../img/infinity.gif" data-src="../img/timeline/<?php echo $feeData['photo_name']; ?>" alt="">
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


                  <?php /* ?>
                  <a class="iconos" href="#" data-toggle="modal" data-target="#mymodal<?php echo $timeline_id;?>" ><i class="fa fa-comment-o"></i> Comment (<?php echo $totalCmt= $d->count_data_direct("ctimeline_commentsnews_comments","timeline_id='$timeline_id'"); ?>) </a>
                  <?php */ ?>

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
          <img  onerror="this.src='img/user.png'" class="imgRedonda1 lazyload" src="../img/infinity.gif"  data-src="../img/users/members_profile/<?php echo $data_comment['user_profile_pic']; ?>" width="10%">
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
          <img  onerror="this.src='img/user.png'" class="imgRedonda1 lazyload" src="../img/infinity.gif" data-src="../img/users/members_profile/<?php echo $data_Sub_comment['user_profile_pic']; ?>" width="10%">
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
          <img  onerror="this.src='img/user.png'" class="imgRedonda1 lazyload" src="../img/infinity.gif" data-src="../img/users/members_profile/<?php echo $data_comment['user_profile_pic']; ?>" width="10%">
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
          <img  onerror="this.src='img/user.png'" class="imgRedonda1 lazyload" src="../img/infinity.gif" data-src="../img/users/members_profile/<?php echo $data_Sub_comment['user_profile_pic']; ?>" width="10%">
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
          <img  onerror="this.src='img/user.png'" class="imgRedonda1 lazyload" src="../img/infinity.gif" data-src="img/profile/<?php echo $data_comment['admin_profile']; ?>"  width="10%">
            </span>  
            
            <span class=" cls-delete"  >
          <b><i title="Delete Comment" class="text-danger fa fa-trash-o "  data-toggle="modal" data-target="#editFloor" onclick="deleteComment('<?php echo $comments_id; ?>')"></i></b>
        </span>
        
        <p class=" cls-content text-justify ">
          <a   href="viewMember?id=<?php echo $data_comment['user_id']; ?>" target="_blank" class="profileName1 text-primary"> <?php echo $data_comment['user_name']; ?></a> <?php echo $data_comment['msg']; ?> at <?php echo date("d-m-Y H:i A", strtotime($data_comment['modify_date'])); ?>  
         </p>

           
          <br><br>
        </div>

       <!--   <div class="row">
          <div class="col-md-1 cls-pic"> <img  onerror="this.src='img/user.png'" class="imgRedonda1" src="img/profile/<?php echo $data_comment['admin_profile']; ?>" width="10%"></div>
           <div class="col-md-10 text-justify cls-content"> <a    href="viewOwner?id=<?php echo $data_comment['user_id']; ?>" target="_blank" class="profileName1 text-primary"> <?php echo $data_comment['user_name']; ?></a> <?php echo $data_comment['msg']; ?> at <?php echo date("d-m-Y H:i A", strtotime($data_comment['modify_date'])); ?>  </div>
            <div class="col-md-1 cls-delete">  <b><i title="Delete Comment" class="text-danger fa fa-trash-o "  data-toggle="modal" data-target="#editFloor" onclick="deleteComment('<?php echo $comments_id; ?>')"></i></b></div>
          
        </div> -->


        <?php  
      }
        //IS_248
         } ?>
                  </div>
                </div>
<?php // IS_387?>

    </div>
  
    <?php } } else { ?>
      <div class="text-center m-5">
        <img src='img/no_data_found3.png'>
      </div>
   <?php } ?>

</div>
</div>
 

<div class="modal fade" id="feed">
  <div class="modal-dialog">
    <div class="modal-content border-fincasys">
      <div class="modal-header bg-fincasys">
        <h5 class="modal-title text-white">Add News Feed</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form id="addTimelineFrm" action="controller/newsFeedController.php" method="post" enctype="multipart/form-data">
            
            <div class="form-group row">
              <div class="col-sm-12" id="PaybleAmount">
                <textarea required="" maxlength="2000" type="text" name="feed_msg" placeholder="Whats Your Mind"  class="form-control"></textarea>
              </div>  
           </div> 
             
                <div class="form-group row">
                    <div class="col-sm-12" id="PaybleAmount">
                      <input  type="file" accept="image/*" name="image"  class="form-control-file border photoOnly">
                    </div>
                </div>
                <div class="form-group row">
                 <label class="col-lg-5 col-form-label form-control-label">Send User Notification</label>
                      <div class="col-lg-7              ">
                        <div class="form-check-inline">
                          <label class="form-check-label">
                            <input type="radio"  class="form-check-input" value="0" name="send_notification_to_user"> No
                          </label>
                        </div>
                        <div class="form-check-inline">
                          <label class="form-check-label">
                            <input type="radio" checked=""  class="form-check-input" value="1" name="send_notification_to_user"> Yes
                          </label>
                        </div>
                      </div>
                    </div>

         
                <div class="form-footer text-center">
                  <button type="submit" name="addFeed" value="addFeed" class="btn btn-sm btn-success"><i class="fa fa-check-square-o"></i> Send</button>
                </div>

          </form> 
      </div>
     
    </div>
  </div>
</div><!--End Modal -->

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
<script src="assets/js/jquery.min.js"></script>
<script type="text/javascript">
  function viewLikes(timeline_id) {
      $.ajax({
          url: "getLikeDetails.php",
          cache: false,
          type: "POST",
          data: {timeline_id : timeline_id},
          success: function(response){
              $('#likeResp').html(response);
            
              
          }
       });
  } 
$(function(){
 // $("a[rel=group224]").fancybox();
  $(".fancybox").fancybox();
   });
  </script>