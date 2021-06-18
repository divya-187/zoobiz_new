  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
      <div class="row pt-2 pb-2">
        <div class="col-sm-9">
          <h4 class="page-title">Feedback</h4>
          <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Feedback</li>
         </ol>
       </div>
       <div class="col-sm-3">
         <div class="btn-group float-sm-right">
          <?php 
          $q=$d->select("feedback_master","","ORDER BY feedback_id DESC");
          if (mysqli_num_rows($q) > 0  ){ ?>
           <a href="javascript:void(0)" onclick="DeleteAll('deleteFeedback');" class="btn  btn-sm btn-danger pull-right"><i class="fa fa-trash-o fa-lg"></i> Delete </a>
           <?php } ?> 
        

       </div>
     </div>
   </div>
   <!-- End Breadcrumb-->


   <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <!-- <div class="card-header"><i class="fa fa-table"></i> Data Exporting</div> -->
        <div class="card-body">
          <div class="table-responsive">
            <table id="example" class="table table-bordered">
              <thead>
                <tr>
                  <th class="deleteTh">
                   Select
                  </th>
                  <th class="text-right">#</th>
                 
                  <th>Name</th>
                  <th>Email</th>
                  <th>Mobile</th>
                  <th>Message</th>
                  <th>Subject</th>
                  <th>Date</th>
                  <th>Attachment</th>
                   <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $i=1;
                  
                  
              
               while ($data=mysqli_fetch_array($q)) {
                extract($data);
                ?>
                <tr>
                  <td class='text-center'>
                    <input type="checkbox" class="multiDelteCheckbox"  value="<?php echo $data['feedback_id']; ?>">
                  </td>
                  <td class="text-right"><?php echo $i++; ?></td>
                  <td><?php echo $name; ?></td>
                  <td><?php echo $email; ?></td>
                  <td><?php echo $mobile; ?></td>
                  <td><?php  $content = $feedback_msg;
                   
                  
                    $feedback_msg_new = (strlen($feedback_msg) > 20) ? substr($feedback_msg,0,20) : $feedback_msg;
                    echo   $feedback_msg_new;
                    if(strlen($content) > 20){ 
                      echo "...";
                     ?>
                     &nbsp;
                     <button data-toggle="modal" data-target="#ContentModal"
                   class="btn btn-primary btn-sm" onclick="contemtModal('<?php echo $feedback_id; ?>')" >See Message</button>
                   <?php 
                  }  
                   ?></td>
                    <td><?php echo custom_echo($subject,30); ?></td>
                    <td data-order="<?php echo date("U",strtotime($feedback_date_time)); ?>"><?php echo date("d-m-Y h:i A", strtotime($feedback_date_time)); ?></td>
                     <td><?php  if ($attachment!='') { ?>
                      <a target="_blank" href="../img/zoobizz_support/<?php echo $attachment;?>">View </a>
                     <?php } ?></td>
                  <td>


                    <div style="display: inline-block;">
                   <button data-toggle="modal" data-target="#replyModal"
                   class="btn btn-primary btn-sm" onclick="replyFeedback('<?php echo $feedback_id; ?>','<?php echo $email; ?>');" ><i class="fa fa-reply"></i></button>

                 </div>

                   <?php  $replyQuery = $d->select("feedback_reply_master","feedback_id='$feedback_id'","ORDER BY created_at DESC"); 

          if(mysqli_num_rows($replyQuery)  > 0    ){ ?>
                            <a href="feedbackHistory?id=<?php echo $feedback_id;?>" class="btn btn-primary btn-sm" name="pullingReport">View</a>
                           <?php } ?> 
                           
                         

                 <div style="display: inline-block;">
                    <form action="controller/feedbackController.php" method="post">    
                          <input type="hidden" name="feedback_id" value="<?php echo $feedback_id; ?>">    
                          <input type="hidden" name="deleteFeedback" value="deleteFeedback">                 
                          <button type="submit" name="" class="btn btn-danger btn-sm form-btn"><i class="fa fa-trash-o fa-lg"> </i></button>
                        </form>
                      </div>
                 </td>

                

               </tr>

             <?php } ?> 
           </tbody>

         </table>
       </div>
     </div>
   </div>
 </div>
</div><!-- End Row-->

</div>
<!-- End container-fluid-->

</div><!--End content-wrapper-->
<!--Start Back To Top Button-->


<div class="modal fade" id="replyModal">
  <div class="modal-dialog">
    <div class="modal-content border-fincasys">
      <div class="modal-header bg-fincasys">
        <h5 class="modal-title text-white">Reply Feedback</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="replyFeedbackFrm" action="controller/feedbackController.php" method="post">
          <input type="hidden" id="society_id" name="society_id" value="<?php echo $society_id;?>">
          <input type="hidden" id="feedback_id" name="feedback_id">
          <input type="hidden" id="feedback_email" name="feedback_email">
          
          
          <div class="form-group row">
            <label for="input-10" class="col-sm-4 col-form-label">Reply <span class="required">*</span></label>
            <div class="col-sm-8" id="">
              <textarea maxlength="300" class="form-control" required="" id="reply" name="reply"></textarea>
            </div>
          </div>

          
          <div class="form-footer text-center">
            <button type="submit" name="replyFeedback" value="replyFeedback" class="btn btn-primary"><i class="fa fa-check-square-o"></i> Reply</button>
          </div>

        </form>
      </div>
      
    </div>
  </div>
</div><!--End Modal -->

<div class="modal fade" id="ContentModal">
  <div class="modal-dialog">
    <div class="modal-content border-fincasys">
      <div class="modal-header bg-fincasys">
        <h5 class="modal-title text-white">Message</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group row">
             <div class="col-sm-12" id="content">  </div>
          </div>
      </div>
      
    </div>
  </div>
</div><!--End Modal -->
<script type="text/javascript">
  function replyFeedback (feedback_id,email,name) {
    $('#feedback_id').val(feedback_id);
    $('#feedback_email').val(email); 

  }
  function contemtModal(feedback_id){
     // $('#content').html(content); 
      $.ajax({
      url: "viewFeedbackMessage.php",
      cache: false,
      type: "POST",
      data: {feedback_id:feedback_id},
      success: function(response){
        $('#content').html(response);

      }
    });
  }
</script>