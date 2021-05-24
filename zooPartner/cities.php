  <div class="content-wrapper">
    <div class="container-fluid">
        <form action="" method="geet`">
      <!-- Breadcrumb-->
      <div class="row pt-2 pb-2">
        <div class="col-sm-3">
          <h4 class="page-title">Cities </h4>
          <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Cities</li>
         </ol>
       </div>
        <div class="col-sm-3">
          <select type="text" required="" id="country_id" onchange="getStates();" class="form-control single-select" name="cId">
          <option value="">-- Select Country --</option>
          <?php 
            $q3=$d->select("countries","flag=1","");
             while ($blockRow=mysqli_fetch_array($q3)) {
           ?>
            <option <?php if(  isset($_GET['cId']) && $_GET['cId']==$blockRow['country_id']) {echo "selected";} ?> value="<?php echo $blockRow['country_id'];?>"><?php echo $blockRow['country_name'];?></option>
            <?php }?>
          </select>
        </div>
        <div class="col-sm-3">
           <?php  if(isset($_GET['cId'])) { ?>
          <select type="text"  onchange="this.form.submit();"  required="" class="form-control single-select" id="state_id" name="sId">
            <?php
               $q31=$d->select("states","country_id='$_GET[cId]'","");
              while ($blockRow11=mysqli_fetch_array($q31)) {
               ?>
               <option <?php if( isset($_GET['sId']) && $_GET['sId']==$blockRow11['state_id']) {echo "selected";} ?> value="<?php echo $blockRow11['state_id'];?>"><?php echo $blockRow11['state_name'];?></option>
              <?php }  ?>
          </select>
          <?php } else { ?>
          <select type="text" required="" onchange="this.form.submit();" id="state_id" class="form-control single-select" name="sId">
          <option value="">-- Select State --</option>
          
          </select>
          <?php } ?>
        </div>
       <div class="col-sm-3">
          <?php if (isset($_GET['cId'])) { ?>
          <a class="btn btn-danger btn-sm" href="cities?cId=<?php echo $_GET['cId']; ?>&sId=<?php echo $_GET['sId']; ?>&t=Active" ><?php echo $d->count_data_direct("city_id","states,countries,cities","cities.city_flag=1 AND cities.state_id=states.state_id AND states.country_id=countries.country_id AND countries.country_id='$_GET[cId]' AND states.state_id='$_GET[sId]'"); ?> City Activated</a>
        <?php } ?>

       </div>
        </form>
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
                  <th>State</th>
                  <th>Country</th>
                   <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $i=1;

                if (isset($_GET['t']) && $_GET['t']=="Active") {
                  $q=$d->select("states,countries,cities","cities.city_flag=1 AND states.country_id=countries.country_id AND countries.country_id='$_GET[cId]' AND states.state_id='$_GET[sId]' AND cities.state_id=states.state_id","ORDER BY states.state_id ASC");
                } else {
                  $q=$d->select("states,countries,cities"," states.country_id=countries.country_id AND countries.country_id='$_GET[cId]' AND states.state_id='$_GET[sId]' AND cities.state_id=states.state_id","ORDER BY states.state_id ASC");
                }
                  
              
               while ($data=mysqli_fetch_array($q)) {
                extract($data);
                ?>
                <tr>
                  
                  <td class="text-right"><?php echo $i++; ?></td>
                  <td><?php echo $city_name; ?></td>
                  <td><?php echo $state_name; ?></td>
                  <td><?php echo $country_name; ?></td>
                  
                  <td>


                  <div style="display: inline-block;">
                   <button data-toggle="modal" data-target="#replyModal"
                   class="btn btn-primary btn-sm" onclick="replyFeedback('<?php echo $city_id; ?>','<?php echo $city_name; ?>');" ><i class="fa fa-pencil"></i>
                 </button>

                 </div>
                 <div style="display: inline-block;">
                      <?php
                      if($city_flag==1 ){
                      ?>
                        <input type="checkbox" checked class="js-switch" data-color="#15ca20" onchange ="changeStatus('<?php echo $city_id; ?>','cityDeactive');" data-size="small"/>
                        <?php } else { ?>
                       <input type="checkbox"  class="js-switch" data-color="#15ca20" onchange ="changeStatus('<?php echo $city_id; ?>','cityActive');" data-size="small"/>
                      <?php } ?>
                 </td>

                

               </tr>

             <?php } ?> 
           </tbody>

         </table>
       <?php } else {
        echo "Please Select Country & State";
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
        <h5 class="modal-title text-white">Edit City</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="cityFrm" action="controller/countryController.php" method="post">
          <input type="hidden" id="city_id" name="city_id">
          <input type="hidden" id="cityUpdate" name="cityUpdate">
          
          
          <div class="form-group row">
            <label for="input-10" class="col-sm-4 col-form-label">City Name</label>
            <div class="col-sm-8" id="">
              <input type="text" minlength="1" maxlength="100" class="form-control" required="" id="city_name" name="city_name">

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
  function replyFeedback (city_id,city_name) {
    $('#city_id').val(city_id);
    $('#city_name').val(city_name); 

  }
  
  
</script>