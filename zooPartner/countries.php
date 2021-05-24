  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
      <div class="row pt-2 pb-2">
        <div class="col-sm-9">
          <h4 class="page-title">Countries</h4>
          <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Countries</li>
         </ol>
       </div>
       <div class="col-sm-3">
          <a class="btn btn-danger btn-sm" href="countries?t=Active" ><?php echo $d->count_data_direct("country_id","countries","flag=1"); ?> Country Activated</a>


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
            <table id="exampleList2" class="table table-bordered">
              <thead>
                <tr>
                 
                  <th class="text-right">#</th>
                  <th>Name</th>
                   <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $i=1;

                if (isset($_GET['t']) && $_GET['t']=="Active") {
                  $q=$d->select("countries","flag=1","ORDER BY country_id ASC");
                } else {
                  $q=$d->select("countries","","ORDER BY country_id ASC");
                }
                  
              
               while ($data=mysqli_fetch_array($q)) {
                extract($data);
                ?>
                <tr>
                  
                  <td class="text-right"><?php echo $i++; ?></td>
                  <td><?php echo $country_name; ?></td>
                  
                  <td>


                  <div style="display: inline-block;">
                   <button data-toggle="modal" data-target="#replyModal"
                   class="btn btn-primary btn-sm" onclick="replyFeedback('<?php echo $country_id; ?>','<?php echo $country_name; ?>');" ><i class="fa fa-pencil"></i>
                 </button>

                 </div>
                 <div style="display: inline-block;">
                      <?php
                      if($flag=="1"){
                      ?>
                        <input type="checkbox" checked class="js-switch" data-color="#15ca20" onchange ="changeStatus('<?php echo $country_id; ?>','countryDeactive');" data-size="small"/>
                        <?php } else { ?>
                       <input type="checkbox"  class="js-switch" data-color="#15ca20" onchange ="changeStatus('<?php echo $country_id; ?>','countryctive');" data-size="small"/>
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
        <h5 class="modal-title text-white">Edit Country</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="countryFrm" action="controller/countryController.php" method="post">
          <input type="hidden" id="country_id" name="country_id">
          <input type="hidden" id="updateContry" name="updateContry">
          
          
          <div class="form-group row">
            <label for="input-10" class="col-sm-4 col-form-label">Country Name</label>
            <div class="col-sm-8" id="">
              <input type="text" minlength="1" maxlength="100" class="form-control" required="" id="country_name" name="country_name">

            </div>
          </div>

          
          <div class="form-footer text-center">
            <button type="submit" name="" value="" class="btn btn-primary"><i class="fa fa-check-square-o"></i> Update</button>
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
  function replyFeedback (country_id,country_name) {
    $('#country_id').val(country_id);
    $('#country_name').val(country_name); 

  }
  
  
</script>