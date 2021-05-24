  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
      <div class="row pt-2 pb-2">
        <div class="col-sm-4">
          <h4 class="page-title">States</h4>
          <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">States</li>
         </ol>
          
       </div>
        <div class="col-sm-5">
        <form action="" method="geet`">
          <select type="text" required="" onchange="this.form.submit();"  class="form-control single-select" name="cId">
          <option value="">-- Select Country --</option>
          <?php 
            $q3=$d->select("countries","flag=1","");
             while ($blockRow=mysqli_fetch_array($q3)) {
           ?>
            <option <?php if(  isset($_GET['cId']) && $_GET['cId']==$blockRow['country_id']) {echo "selected";} ?> value="<?php echo $blockRow['country_id'];?>"><?php echo $blockRow['country_name'];?></option>
            <?php }?>
          </select>
        </form>
        </div>
       <div class="col-sm-3">
          <?php if (isset($_GET['cId'])) { ?>
          <a class="btn btn-danger btn-sm" href="states?cId=<?php echo $_GET['cId'];?>&t=Active" ><?php echo $d->count_data_direct("state_id","states,countries","states.state_flag=1 AND states.country_id=countries.country_id AND countries.country_id='$_GET[cId]'"); ?> States Activated</a>
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
            <?php if (isset($_GET['cId'])) { ?>
            <table id="exampleList2" class="table table-bordered">
              <thead>
                <tr>
                 
                  <th class="text-right">#</th>
                  <th>Name</th>
                  <th>Country</th>
                   <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $i=1;

                if (isset($_GET['t']) && $_GET['t']=="Active") {
                  $q=$d->select("states,countries","states.state_flag=1 AND states.country_id=countries.country_id AND countries.country_id='$_GET[cId]'","ORDER BY states.state_id ASC");
                } else {
                  $q=$d->select("states,countries"," states.country_id=countries.country_id AND countries.country_id='$_GET[cId]'","ORDER BY states.state_id ASC");
                }
                  
              
               while ($data=mysqli_fetch_array($q)) {
                extract($data);
                ?>
                <tr>
                  
                  <td class="text-right"><?php echo $i++; ?></td>
                  <td><?php echo $state_name; ?></td>
                  <td><?php echo $country_name; ?></td>
                  
                  <td>


                  <div style="display: inline-block;">
                   <button data-toggle="modal" data-target="#replyModal"
                   class="btn btn-primary btn-sm" onclick="replyFeedback('<?php echo $state_id; ?>','<?php echo $state_name; ?>');" ><i class="fa fa-pencil"></i>
                 </button>

                 </div>
                 <div style="display: inline-block;">
                      <?php
                      if($state_flag=="1" && $flag=="1"){
                      ?>
                        <input type="checkbox" checked class="js-switch" data-color="#15ca20" onchange ="changeStatus('<?php echo $state_id; ?>','stateDeactive');" data-size="small"/>
                        <?php } else { ?>
                       <input type="checkbox"  class="js-switch" data-color="#15ca20" onchange ="changeStatus('<?php echo $state_id; ?>','stateActive');" data-size="small"/>
                      <?php } ?>
                 </td>

                

               </tr>

             <?php } ?> 
           </tbody>

         </table>
       <?php } else {
        echo "Please Select Country";
       } ?>
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
        <h5 class="modal-title text-white">Edit State</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="stateFrm" action="controller/countryController.php" method="post">
          <input type="hidden" id="state_id" name="state_id">
          <input type="hidden" id="updateState" name="updateState">
          
          
          <div class="form-group row">
            <label for="input-10" class="col-sm-4 col-form-label">State Name</label>
            <div class="col-sm-8" id="">
              <input type="text" minlength="1" maxlength="100" class="form-control" required="" id="state_name" name="state_name">

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
  function replyFeedback (state_id,state_name) {
    $('#state_id').val(state_id);
    $('#state_name').val(state_name); 

  }
  
  
</script>