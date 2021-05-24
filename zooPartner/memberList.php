  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
      <div class="row pt-2 pb-2">
        <div class="col-sm-6">
          <h4 class="page-title">Member List</h4>
          <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li> 
            <li class="breadcrumb-item active" aria-current="page">Members List</li>
         </ol>
       </div>
       <div class="col-sm-3">
           <form action="" method="gee">
          <select type="text"  onchange="this.form.submit();"  required="" class="form-control single-select" id="showOfficeMember" name="showOfficeMember">

            <option <?php if( isset($_GET['showOfficeMember']) && $_GET['showOfficeMember']=="0") {echo "selected";} ?> value="0">All Members</option>
                 <option <?php if( isset($_GET['showOfficeMember']) && $_GET['showOfficeMember']=="No") {echo "selected";} ?> value="No">Only Genuine Member</option>
               <option <?php if( isset($_GET['showOfficeMember']) && $_GET['showOfficeMember']=="Yes") {echo "selected";} ?> value="Yes">Only Office Member</option>
               
               
          </select>
            </form>
       </div>
       <div class="col-sm-3">
         <div class="btn-group float-sm-right">
           <a href="member"  class="btn  btn-sm btn-primary pull-right"><i class="fa fa-plus fa-lg"></i> Add New </a>

         </div>

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
                   <th>Action</th>
                   <th>Active Status</th>
                   <th>Office Member</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $i=1;
                $where =" ";
                 if( isset($_GET['showOfficeMember']) && $_GET['showOfficeMember']=="Yes") { 
                  $where =" and users_master.office_member = '1' ";
                 } else  if( isset($_GET['showOfficeMember']) && $_GET['showOfficeMember']=="No") { 
                  $where =" and users_master.office_member = '0' ";
                 }  


                  $q=$d->select("users_master,user_employment_details,business_categories,business_sub_categories"," business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id AND users_master.active_status=0  $where   ","ORDER BY users_master.user_id DESC");
               while ($data=mysqli_fetch_array($q)) {
                extract($data);
                ?>
                <tr>
                  <!-- <td class='text-center'>
                    <input type="checkbox" class="multiDelteCheckbox"  value="<?php echo $data['feedback_id']; ?>">
                  </td> -->
                  <td class="text-right"><?php echo $i++; ?></td>
                  <td><?php echo  $salutation.' '.$user_full_name; ?></td>
                  <td><?php echo html_entity_decode($company_name) ; ?></td>
                  <td><?php echo $user_mobile; ?></td> 
                   <td>
                    <form action="viewMember" method="get">    
                          <input type="hidden" name="id" value="<?php echo $user_id; ?>">    
                          <button type="submit" name="" class="btn btn-danger btn-sm "> View Profile</button>
                        </form>
                    </div>
                 </td>
                 <td>
                    <?php if($data['active_status']=="0"){
                        ?>
                          <input type="checkbox" checked class="js-switch" data-color="#15ca20" onchange ="changeStatus('<?php echo $data['user_id']; ?>','userDeactive');" data-size="small"/>
                          <?php } else { ?>
                         <input type="checkbox"  class="js-switch" data-color="#15ca20" onchange ="changeStatus('<?php echo $data['user_id']; ?>','userActive');" data-size="small"/>
                        <?php } ?>
                 </td>

                <td>
                    <?php if($data['office_member']=="1"){
                        ?>
                          <input type="checkbox" checked class="js-switch" data-color="#15ca20" onchange ="changeStatus('<?php echo $data['user_id']; ?>','OfficeMemberDeactive');" data-size="small"/>
                          <?php } else { ?>
                         <input type="checkbox"  class="js-switch" data-color="#15ca20" onchange ="changeStatus('<?php echo $data['user_id']; ?>','OfficeMemberActive');" data-size="small"/>
                        <?php } ?>
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