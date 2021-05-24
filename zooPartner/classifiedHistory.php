<?php
error_reporting(0);
extract(array_map("test_input" , $_REQUEST));
$request_id = (int)$request_id;

 $q=$d->select("cllassifieds_master","cllassified_id='$id'","ORDER BY cllassified_id DESC");
 $data=mysqli_fetch_array($q);
?>
<link href="../zooAdmin/assets/plugins/vertical-timeline/css/vertical-timeline1.css" rel="stylesheet"/>
<div class="content-wrapper">
  <div class="container-fluid">
    <div class="row pt-2 pb-2">
      <div class="col-sm-12">
        <h4 class="page-title">View Classifieds</h4>
         <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li>
           <li class="breadcrumb-item"><a href="classifieds">Classifieds</a></li>
            <li class="breadcrumb-item active" aria-current="page">View Classifieds</li>
         </ol>
       
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
             <p><b>Title :</b> <?php echo $data['cllassified_title']; ?></p>
            <p class="text-justify"><b>Description :</b> <?php echo $data['cllassified_description']; ?></p>
            <p><b>Categories :</b> <?php 
                    if ($data['business_category_id']==0) {
                      echo "All Category";
                    } else {


                      $subCatCount =  $d->count_data_direct("business_category_id","classified_category_master","classified_id='$data[cllassified_id]'");
                      if($subCatCount > 0){
 echo "<br>";

                         $cats_qry = $d->selectRow(" business_categories.business_category_id, business_sub_categories.business_sub_category_id, sub_category_name,category_name ","business_sub_categories,classified_category_master,business_categories  ", "

                          business_categories.business_category_id =classified_category_master.business_category_id and  

                          business_sub_categories.business_sub_category_id =classified_category_master.business_sub_category_id and     classified_category_master.classified_id='$data[cllassified_id]'","");


                         
                           
 while ($cats_data = mysqli_fetch_array($cats_qry)) {
          echo    $cats_data['sub_category_name'].' - '.$cats_data['category_name']."<br>\n";
    }

                      
                       


                       } else {

                          $bq=$d->selectRow("sub_category_name, category_name","business_categories, business_sub_categories "," business_sub_categories.business_category_id =business_categories.business_category_id and     business_sub_categories.business_sub_category_id='$data[business_sub_category_id]'");
                          $catData=mysqli_fetch_array($bq);
                          echo $catData['sub_category_name'].' - '.$catData['category_name'];
                        }
                    }
             ?></p>
            <p><b>Created Date :</b> <?php echo  date('d M Y h:i A',strtotime($data['created_date'])); ?></p>
            <p><b>Total Cities:</b> <?php echo $d->count_data_direct("cllassifieds_city_id","cllassifieds_city_master","cllassified_id='$id'"); ?>  


             <?php 
              $qa=$d->select("cllassifieds_city_master,cities","cities.city_id=cllassifieds_city_master.city_id and cllassifieds_city_master.cllassified_id='$data[cllassified_id]' ");
               

                  if($id){ 
                  
                  $arr = array();
                  while ($dataa=mysqli_fetch_array($qa)) {
                    $arr[]= $dataa['city_name'];
                  }
                  /*for ($h=0; $h <count($relation_array) ; $h++) { 
                    $arr[]= $relation_array[$h];
                  }*/
                  $arr = implode(",", $arr);

                 // echo $arr;
$h=0;
                        if(strlen($arr) > 20 ||1) {
                          $data44 = substr($arr, 0, 20);
                       //   echo $data; 
                          ?>
                          <button class="btn btn-warning btn-sm"  data-toggle="collapse" data-target="#demo<?php echo $h;?>"><i class="fa fa-eye"></i></button>
                              <div id="demo<?php echo $h;?>" class="collapse">
                            <?php    echo  wordwrap($arr,30,"<br>\n") ;?>
                            </div>
                            <?php
                         } else {
                          echo wordwrap($arr,30,"<br>\n");
                         }


                } else {
                  echo "-";
                }
                   ?></p>
            <p><b>Created By :</b>
           <?php
           
               $q111=$d->select("users_master","user_id='$data[user_id]'","");
              $userdata=mysqli_fetch_array($q111);
              echo $userdata['salutation'].' '.$userdata['user_full_name'] ;
            ?>
          </p>
          <p><b>Status:</b>
             <?php if($data['active_status']=="0"){
                        ?>
                          <input type="checkbox" checked class="js-switch" data-color="#15ca20" onchange ="changeStatus('<?php echo $data['cllassified_id']; ?>','discussionDeactive');" data-size="small"/>
                          <?php } else { ?>
                         <input type="checkbox"  class="js-switch" data-color="#15ca20" onchange ="changeStatus('<?php echo $data['cllassified_id']; ?>','discussionActive');" data-size="small"/>
                        <?php } ?>
          </p>
          <p><b>Document</b> 
                <?php 
                $imgIcon2="";
          if ($data['cllassified_file']!='') { 
          $dFile= $data['cllassified_file'];
              $ext = pathinfo($dFile, PATHINFO_EXTENSION);
              if ($ext == 'pdf' || $ext == 'PDF') {
                $imgIcon = 'img/pdf.png';
                 $imgIcon2="fa fa-file-pdf-o";
              } elseif ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png') {
                $imgIcon = 'img/jpg.png';
                $imgIcon2="fa fa-picture-o";
              } elseif($ext == 'png'){
                $imgIcon = 'img/png.png';
                $imgIcon2="fa fa-picture-o";
              }elseif ($ext == 'doc' || $ext == 'docx') {
                $imgIcon = 'img/doc.png';
                $imgIcon2="fa fa-file";
              } else{
                $imgIcon = 'img/doc.png';
                $imgIcon2="fa fa-file";
              }

             ?>
            <a target="_blank" href="../img/cllassified/<?php echo $data['cllassified_file'];?>" >

              <i class="<?php echo $imgIcon2;?> fa-4x" aria-hidden="true"></i>
              </a>
         
          <?php }  

          $classified_document_master_q=$d->select("classified_document_master ","classified_id ='$data[cllassified_id]' ","ORDER BY  classified_id DESC");
                    $i = 0;
                    while($classified_document_master_data=mysqli_fetch_array($classified_document_master_q)) {
                      $dFile1= $classified_document_master_data['document_name'];
              $ext = pathinfo($dFile1, PATHINFO_EXTENSION);
              if ($ext == 'pdf' || $ext == 'PDF') {
                $imgIcon = 'img/pdf.png';
                 $imgIcon2="fa fa-file-pdf-o";
              } elseif ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png') {
                $imgIcon = 'img/jpg.png';
                $imgIcon2="fa fa-picture-o";
              } elseif($ext == 'png'){
                $imgIcon = 'img/png.png';
                $imgIcon2="fa fa-picture-o";
              }elseif ($ext == 'doc' || $ext == 'docx') {
                $imgIcon = 'img/doc.png';
                $imgIcon2="fa fa-file";
              } else{
                $imgIcon = 'img/doc.png';
                $imgIcon2="fa fa-file";
              }

             ?>
            <a target="_blank" href="../img/cllassified/docs/<?php echo $classified_document_master_data['document_name'];?>" >

              <i class="<?php echo $imgIcon2;?> fa-4x" aria-hidden="true"></i>
              </a>
                 <?php   } ?>
          
          </p>
           <p><b>Photos</b> 
          <?php if ($data['cllassified_photo']!='') { ?>
             
            <a href="../img/cllassified/<?php echo $data['cllassified_photo'];?>" data-fancybox="images" data-caption="Photo Name : <?php echo $data["cllassified_photo"]; ?>"><img width="300" height="250" src="../img/cllassified/<?php echo $data['cllassified_photo'];?>" alt=""></a>
          <?php } 
          $classified_photos_master_q=$d->select("classified_photos_master ","classified_id ='$data[cllassified_id]' ","ORDER BY  classified_id DESC");
                    $i = 0;
                    while($classified_photos_master_data=mysqli_fetch_array($classified_photos_master_q)) {
                      ?>
             
            <a href="../img/cllassified/<?php echo $classified_photos_master_data['photo_name'];?>" data-fancybox="images" data-caption="Photo Name : <?php echo $classified_photos_master_data["photo_name"]; ?>"><img width="150" height="200" src="../img/cllassified/<?php echo $classified_photos_master_data['photo_name'];?>" alt=""></a>
          <?php
                    }?>

        </p>
<p><b>Audio</b>
  <?php if($data['classified_audio']!=''){?>
<audio controls>
  <source src="../img/cllassified/audio/<?php echo $data['classified_audio'];?>" type="audio/mpeg">
</audio>
<?php } else {
  echo "N/A";
}?> 
 </p>
          <div class="row pt-2 pb-2">
      <div class="col-sm-12 text-center">
         <!-- <button data-toggle="modal" data-target="#vieComp"   class="btn btn-sm btn-primary" type="button"><i class="fa fa-comments"></i> Comment</button> -->
      </div>
    </div>
    <?php 
       
          $timelineQuery = $d->select("cllassified_comment","cllassified_id='$id' AND prent_comment_id=0","ORDER BY comment_id DESC"); 

          if(mysqli_num_rows($timelineQuery)  > 0    ){
            ?> 
    <section class="cd-timeline js-cd-timeline" >
      <div class="cd-timeline__container">
        <?php 
        $i11=0;
          
          while($timelineData = mysqli_fetch_array($timelineQuery)){
            $prent_comment_id= $timelineData['comment_id'];
            $coIndex= $i11++;
            if ($coIndex % 2 == 0) {
              $rightSide=true;
            } else {
              $rightSide=false;
            }
        ?>
        <?php

                   $q111=$d->select("users_master","user_id='$timelineData[user_id]'","");
                    $userdataComment=mysqli_fetch_array($q111);
                   $user_full_name= $userdataComment['salutation'].' '.$userdataComment['user_full_name'] ;
                ?>
          <div class="cd-timeline__block js-cd-block <?php if($rightSide==true){ echo "floatRight"; } ?>">
            <div class="cd-timeline__img cd-timeline__img--picture js-cd-img text-center ">
              <img class="rounded-circle" id="blah"  onerror="this.src='../zooAdmin/img/user.png'" src="../img/users/members_profile/<?php echo $userdataComment['user_profile_pic']; ?>"  width="30" height="30"   src="#" alt="your image" class='profile' />
            </div> 

            <div class="cd-timeline__content js-cd-content" style="border: 1px solid gray;">
              <p>
                <img class="rounded-circle" id="blah"  onerror="this.src='../zooAdmin/img/user.png'" src="../img/users/members_profile/<?php echo $userdataComment['user_profile_pic']; ?>"  width="30" height="30"   src="#" alt="your image" class='profile' />
                <?php echo $user_full_name;
               ?></p>
              <h6 style="word-wrap: break-word;"><?php echo $timelineData['comment_messaage']; ?></h6>
              
             <form action="controller/classifiedController.php" method="post" accept-charset="utf-8">
                <input type="hidden" name="cllassified_id" value="<?php echo $timelineData['cllassified_id'];?>">
                <input type="hidden" name="comment_id_delete" value="<?php echo $timelineData['comment_id'];?>">
              <p><?php echo date('d M Y, h:i A',strtotime($timelineData['created_date'])); ?> <button type="submit" class="btn form-btn btn btn-danger btn-sm pull-right ">  <i class="fa fa-trash "></i></button></p>
              </form>

              <span class="cd-timeline__date"><?php echo date('M d',strtotime($timelineData['created_date'])); ?></span>
              <span>
                <?php $subComment = $d->select("cllassified_comment","cllassified_id='$id' AND prent_comment_id='$prent_comment_id'","ORDER BY comment_id DESC");
                  $totalRepy= mysqli_num_rows($subComment);
                  if ($totalRepy>0) {
                    echo "<b>".$totalRepy.' Reply <i class="fa fa-reply" aria-hidden="true"></i></b>';
                 ?>
              </span>
                <?php while ($subData=mysqli_fetch_array($subComment)) {  ?>
                <div class="subCommentDiv pl-3">
                      <p><?php if($subData['admin_id']!=0){ 
                      $qad=$d->select("zoobiz_admin_master","zoobiz_admin_id='$subData[admin_id]'");
                      $adminData=mysqli_fetch_array($qad);
                      ?>
                      <img class="rounded-circle" id="blah"  onerror="this.src='../zooAdmin/img/user.png'" src="img/profile/<?php echo $adminData['admin_profile']; ?>"  width="30" height="30"   src="#" alt="your image" class='profile' />
                      <?php echo $adminData['admin_name'];} else {

                         $q111=$d->select("users_master","user_id='$subData[user_id]'","");
                          $userdataComment=mysqli_fetch_array($q111);
                         $user_full_name=$userdataComment['salutation'].' '.$userdataComment['user_full_name'];
                      ?>
                      <img class="rounded-circle" id="blah"  onerror="this.src='../zooAdmin/img/user.png'" src="../img/users/members_profile/<?php echo $userdataComment['user_profile_pic']; ?>"  width="30" height="30"   src="#" alt="your image" class='profile' />
                      <?php echo $user_full_name;
                    } ?></p>
                    <h6 style="word-wrap: break-word;"><?php echo $subData['comment_messaage']; ?></h6>
                    
                   <form action="controller/classifiedController.php" method="post" accept-charset="utf-8">
                      <input type="hidden" name="cllassified_id" value="<?php echo $subData['cllassified_id'];?>">
                      <input type="hidden" name="comment_id_delete" value="<?php echo $subData['comment_id'];?>">
                    <p><?php echo date('d M Y, h:i A',strtotime($subData['created_date'])); ?> <button type="submit" class="btn form-btn btn btn-danger btn-sm pull-right ">  <i class="fa fa-trash "></i></button></p>
                    </form>

                    <span class="cd-timeline__date"><?php echo date('M d',strtotime($subData['created_date'])); ?></span>
                </div>
                <?php } }?>
            </div>
          </div>
        <?php } ?>
      </div>
    </section>
    <?php } ?>
          </div>
        </div>
      </div>
    </div>


     
  </div>
</div>
<!-- <script src="../zooAdmin/assets/js/jquery.min.js"></script> -->
<!-- <script src="../zooAdmin/assets/plugins/vertical-timeline/js/vertical-timeline.js"></script> -->





<div class="modal fade" id="vieComp">
  <div class="modal-dialog">
    <div class="modal-content border-success">
      <div class="modal-header bg-success">
        <h5 class="modal-title text-white">Discussion Comment </h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="">
            <form id="commentAddDiscusstion" method="POST" action="controller/classifiedController.php" enctype="multipart/form-data">
            <div class="row form-group">  
              <input type="hidden" id="" name="addComment" value="addComment">
              <input type="hidden" id="cllassified_id" name="cllassified_id" value="<?php echo $id;?>">
              <input type="hidden" id="discussion_forum_id" name="discussion_forum_for" value="<?php echo $data['discussion_forum_for'];?>">
              <label class="col-sm-3 form-control-label">Comment <span class="text-danger">*</span></label>
              <div class="col-sm-9">
                <textarea  maxlength="250" class="form-control text-capitalize" id="comment_messaage" required="" name="comment_messaage"></textarea>
              </div>
            </div>
           
            <div class="form-footer text-center">
              <button class="btn btn-sm btn-success"><i class="fa fa-check"></i> Send</button>
            </div>
          </form>
      </div>
     
    </div>
  </div>
</div>