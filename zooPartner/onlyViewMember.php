  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
      <div class="row pt-2 pb-2">
        <div class="col-sm-9">
          <h4 class="page-title">Only View Members List</h4>
          <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li> 
            <li class="breadcrumb-item active" aria-current="page">Only View Members List</li>
         </ol>
       </div>
       <div class="col-sm-3">
         <div class="btn-group float-sm-right">
           

         </button>

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
                 
                  <th class="text-right">#</th>
                 
                  <th>Name</th>
                  <th>Business Name</th>
                  <th>Mobile</th> 
                   
                   
                </tr>
              </thead>
              <tbody>
                <?php 
                $i=1;
                  $q=$d->select("users_master,user_employment_details,business_categories,business_sub_categories"," business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id AND users_master.active_status=0  AND users_master.office_member=0  ","ORDER BY users_master.user_id DESC");
               while ($data=mysqli_fetch_array($q)) {
                extract($data);
                ?>
                <tr>
                  <!-- <td class='text-center'>
                    <input type="checkbox" class="multiDelteCheckbox"  value="<?php echo $data['feedback_id']; ?>">
                  </td> -->
                  <td class="text-right"><?php echo $i++; ?></td>
                  <td> <a href="memberView?id=<?php echo $user_id; ?>"><?php echo  $salutation.' '.$user_full_name; ?></td> 
                    <td><?php echo html_entity_decode($company_name) ; ?></td>
                  <td><?php echo $user_mobile; ?></td> 
                     

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
            <label for="input-10" class="col-sm-4 col-form-label">Reply</label>
            <div class="col-sm-8" id="">
              <textarea maxlength="300" class="form-control" required="" id="reply" name="reply">

              </textarea>
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