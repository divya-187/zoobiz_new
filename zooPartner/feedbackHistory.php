<?php
error_reporting(0);
extract(array_map("test_input" , $_REQUEST));
$request_id = (int)$request_id;

 $q=$d->select("feedback_master","feedback_id='$id'","ORDER BY feedback_id DESC");
 $data=mysqli_fetch_array($q);
?>
<link href="../zooAdmin/assets/plugins/vertical-timeline/css/vertical-timeline1.css" rel="stylesheet"/>
<div class="content-wrapper">
  <div class="container-fluid">
    <div class="row pt-2 pb-2">
      <div class="col-sm-12">
        <h4 class="page-title">View Feedbacks</h4>
         <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li>
           <li class="breadcrumb-item"><a href="feedback">Feedback</a></li>
            <li class="breadcrumb-item active" aria-current="page">View Feedbacks</li>
         </ol>
       
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
             
    <?php 
       
          $replyQuery = $d->select("feedback_reply_master","feedback_id='$id'","ORDER BY created_at DESC"); 

          if(mysqli_num_rows($replyQuery)  > 0    ){
            ?> 
    <section class="cd-timeline js-cd-timeline" >
      <div class="cd-timeline__container">
        <?php 
        $i11=0;
          
          while($replyData = mysqli_fetch_array($replyQuery)){
            
        ?>
        
          <div class="cd-timeline__block js-cd-block <?php if($i11 %2 ==0){ echo "floatRight"; } else { echo "floatleft"; }?>">
            <div class="cd-timeline__img cd-timeline__img--picture js-cd-img text-center ">
              <img class="rounded-circle" id="blah"  onerror="this.src='../zooAdmin/img/user.png'" src="../img/fav.png"  width="30" height="30"   src="#" alt="your image" class='profile' />
            </div> 

            <div class="cd-timeline__content js-cd-content" style="border: 1px solid gray;">
              
               <?php echo html_entity_decode($replyData['reply_msg']); ?> 
              <h6 style="word-wrap: break-word;"><?php echo $replyData['admin_name']; ?></h6>

              <span class="cd-timeline__date"><?php echo date('Y M d h:i A',strtotime($replyData['created_at'])); ?></span>
              
                 
            </div>
          </div>
        <?php $i11++; } ?>
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