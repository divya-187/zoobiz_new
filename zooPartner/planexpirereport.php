<?php 
error_reporting(0);

 ?>
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
      <form action="" method="get">
      <div class="row pt-2 pb-2">
        <div class="col-sm-12">
          <h4 class="page-title">Membership Plan Expire Report</h4>
           <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Membership Plan Expire Report</li>
         </ol>

         <?php if ( !isset($_GET['from'])) { $_GET['from'] = date('Y-m-01');}
         if ( !isset($_GET['toDate'])) { $_GET['toDate'] = date('Y-m-t', strtotime('+1 month'));   }   ?>
       </div>

</div>
 <div class="row pt-2 pb-2">
<div class="col-sm-5"></div>
       <div class="col-sm-5"  >


        <div class="input-daterange input-group">
                <input readonly="" type="text" class="form-control" autocomplete="off"   placeholder="Start Date" id="FromDate" name="from" value="<?php if ( !isset($_GET['from'])) { echo date('Y-m-01');} else {  echo $_GET['from']; } ?>"  />
                <div class="input-group-prepend">
                 <span class="input-group-text">to</span>
                </div>
                <input readonly="" type="text" class="form-control" autocomplete="off"   placeholder="End Date" id="ToDate" name="toDate" value="<?php if ( !isset($_GET['toDate'])) { echo date('Y-m-t');} else { echo $_GET['toDate'];  } ?>" />
               </div>


        </div>

           


         


         <div class="col-lg-2 col-3">
            <label  class="form-control-label"> </label>
              <input  class="btn btn-success" type="submit" name="getReport" class="form-control" value="Get Report">
          </div>
     </div>
   </div>
   <!-- End Breadcrumb-->
    </form>


   <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <!-- <div class="card-header"><i class="fa fa-table"></i> Data Exporting</div> -->
        <div class="card-body">
          <div class="table-responsive">
            <?php if ($_GET['from']!='') {  ?>
            <table id="example" class="table table-bordered">
              <thead>
                <tr>
                 
                  <th class="text-right">#</th>
                 
                  
                  <th>Name</th>
                  <th>City</th>
                  <th>Email</th>
                  <th>Mobile</th>
                  <th>Business Name</th>
                   <th>Plan Expire Date</th>
                    
                </tr>
              </thead>
              <tbody>
                <?php 
                $i=1;

                 extract(array_map("test_input" , $_GET));
                $from = date('Y-m-d', strtotime($from));
                $toDate = date('Y-m-d', strtotime($toDate));
                $date=date_create($from);
                $dateTo=date_create($toDate);
                $nFrom= date_format($date,"Y-m-d");
                $nTo= date_format($dateTo,"Y-m-d");


                $q3=$d->select("users_master,user_employment_details,cities","cities.city_id= users_master.city_id and  user_employment_details.user_id =users_master.user_id and  users_master.active_status= 0 and  users_master.plan_renewal_date  BETWEEN '$nFrom' AND '$nTo' AND users_master.active_status=0  order by users_master.plan_renewal_date asc ","");
               while ($data=mysqli_fetch_array($q3)) {
                extract($data);
               
 
                 
                ?>
                <tr>
                  
                  <td class="text-right"><?php echo $i++; ?></td>
                   
                  <td><a target="_blank"   title="View Profile"  href="viewMember?id=<?php echo $user_id; ?>" ><?php echo  $salutation.' '.$user_full_name; ?></a></td>
                  <td><?php echo $city_name ; ?></td>
                  <td><?php echo $user_email ; ?></td>
                  <td><?php echo $user_mobile; ?></td>
                  <td><?php  echo $company_name;
                   ?></td>
                  <td data-order="<?php echo date("U",strtotime($plan_renewal_date)); ?>"><?php echo date("d-m-Y",strtotime($plan_renewal_date));  ?></td>
                   
                
                

               </tr>

             <?php  } ?> 
           </tbody>

         </table>
       <?php } else {

        echo "Select Date";
      }?>
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