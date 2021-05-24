  <div class="content-wrapper">
    <div class="container-fluid">
        <form action="" method="geet`">
      <!-- Breadcrumb-->
      <div class="row pt-2 pb-2">
        <div class="col-sm-2">
          <h4 class="page-title">Areas </h4>
          <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Areas</li>
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
          <select type="text"  required="" onchange="getCity();" class="form-control single-select" id="state_id" name="sId">
            <?php
               $q31=$d->select("states","country_id='$_GET[cId]'","");
              while ($blockRow11=mysqli_fetch_array($q31)) {
               ?>
               <option <?php if( isset($_GET['sId']) && $_GET['sId']==$blockRow11['state_id']) {echo "selected";} ?> value="<?php echo $blockRow11['state_id'];?>"><?php echo $blockRow11['state_name'];?></option>
              <?php }  ?>
          </select>
          <?php } else { ?>
          <select type="text" required=""  onchange="getCity();"   id="state_id" class="form-control single-select" name="sId">
          <option value="">-- Select State --</option>
          
          </select>
          <?php } ?>
        </div>
         <div class="col-sm-3">
           <?php  if(isset($_GET['cId'])) { ?>
          <select type="text"  onchange="this.form.submit();"  required="" class="form-control single-select" id="city_id" name="cityId">
            <?php
               $q31=$d->select("cities","state_id='$_GET[sId]'","");
              while ($blockRow11=mysqli_fetch_array($q31)) {
               ?>
               <option <?php if( isset($_GET['cityId']) && $_GET['cityId']==$blockRow11['city_id']) {echo "selected";} ?> value="<?php echo $blockRow11['city_id'];?>"><?php echo $blockRow11['city_name'];?></option>
              <?php }  ?>
          </select>
          <?php } else { ?>
          <select type="text" required="" onchange="this.form.submit();" id="city_id" class="form-control single-select" name="cityId">
          <option value="">-- Select City --</option>
          
          </select>
          <?php } ?>
        </div>
        </form>
     </div>
     <div class="row pt-2 text-right pb-2">

       <div class="col-sm-12">
          <?php if (isset($_GET['cId'])) { ?>
          <a class="btn btn-danger btn-sm" href="areas?cId=<?php echo $_GET['cId']; ?>&sId=<?php echo $_GET['sId']; ?>&cityId=<?php echo $_GET['cityId']; ?>&t=Active" ><?php echo $d->count_data_direct("city_id","states,countries,cities,area_master","area_master.city_id=cities.city_id AND  area_master.area_flag=1 AND cities.state_id=states.state_id AND states.country_id=countries.country_id AND countries.country_id='$_GET[cId]' AND states.state_id='$_GET[sId]' AND cities.city_id='$_GET[cityId]'"); ?> Area Activated</a>

          <a class="btn btn-primary btn-sm" href="area" > Add New</a>

        <a href="#" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#bulkUpload">Import Bulk Areas</a>

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
            <table id="exampleList" class="table table-bordered">
              <thead>
                <tr>
                 
                  <th class="text-right">#</th>
                  <th>Area</th>
                  <th>City</th>
                  <th>State</th>
                  <th>Country</th>
                  <th class="text-center">Pincode</th>
                   <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $i=1;

                if (isset($_GET['t']) && $_GET['t']=="Active") {
                  $q=$d->select("states,countries,cities,area_master","area_master.city_id=cities.city_id AND  area_master.area_flag=1 AND states.country_id=countries.country_id AND countries.country_id='$_GET[cId]' AND states.state_id='$_GET[sId]' AND cities.state_id=states.state_id AND cities.city_id='$_GET[cityId]'","ORDER BY states.state_id ASC");
                } else {
                  $q=$d->select("states,countries,cities,area_master","area_master.city_id=cities.city_id AND   states.country_id=countries.country_id AND countries.country_id='$_GET[cId]' AND states.state_id='$_GET[sId]' AND cities.state_id=states.state_id AND cities.city_id='$_GET[cityId]'","ORDER BY states.state_id ASC");
                }
                  
              
               while ($data=mysqli_fetch_array($q)) {
                extract($data);
                ?>
                <tr>
                  
                  <td class="text-right"><?php echo $i++; ?></td>
                  <td><?php echo $area_name; ?></td>
                  <td><?php echo $city_name; ?></td>
                  <td><?php echo $state_name; ?></td>
                  <td><?php echo $country_name; ?></td>
                  <td class="text-center"><?php echo $pincode; ?></td>
                  
                  <td>


                  <div style="display: inline-block;">
                  <form action="area" method="post" accept-charset="utf-8">
                    <input type="hidden" name="area_id" value="<?php echo $area_id; ?>">
                    <input type="hidden" name="editArea" value="<?php echo 'editArea'; ?>">
                   <button  type="submit"  class="btn btn-primary btn-sm" ><i class="fa fa-pencil"></i>
                   </button>
                  </form>

                 </div>
                  <div style="display: inline-block;">
                  <form action="controller/countryController.php" method="post" accept-charset="utf-8">
                    <input type="hidden" name="area_id" value="<?php echo $area_id; ?>">
                    <input type="hidden" name="deleteArea" value="<?php echo 'deleteArea'; ?>">
                   <button  type="submit"  class="btn btn-danger btn-sm form-btn" ><i class="fa fa-trash-o"></i>
                   </button>
                  </form>

                 </div>
                 <div style="display: inline-block;">
                      <?php
                      if($area_flag==1 ){
                      ?>
                        <input type="checkbox" checked class="js-switch" data-color="#15ca20" onchange ="changeStatus('<?php echo $area_id; ?>','areaDeactive');" data-size="small"/>
                        <?php } else { ?>
                       <input type="checkbox"  class="js-switch" data-color="#15ca20" onchange ="changeStatus('<?php echo $area_id; ?>','areaActive');" data-size="small"/>
                      <?php } ?>
                 </td>

                

               </tr>

             <?php } ?> 
           </tbody>

         </table>
       <?php } else {
        echo "Please Select Country, State & City";
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
        <h5 class="modal-title text-white">Edit Country</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="replyFeedbackFrm" action="controller/countryController.php" method="post">
          <input type="hidden" id="city_id" name="area_id">
          <input type="hidden" id="areaUpdate" name="areaUpdate">
          
          
          <div class="form-group row">
            <label for="input-10" class="col-sm-4 col-form-label">Area Name</label>
            <div class="col-sm-8" id="">
              <input type="text" class="form-control" required="" id="city_name" name="area_name">

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

<div class="modal fade" id="bulkUpload">
  <div class="modal-dialog">
    <div class="modal-content border-fincasys">
      <div class="modal-header bg-fincasys">
        <h5 class="modal-title text-white">Import Bulk Users</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form action="controller/countryController.php" method="post" enctype="multipart/form-data">
            
               <div class="form-group row">
                    <label class="col-sm-12 col-form-label">Step 1 -> DOWNLOAD CSV FORMAT  <button type="submit" name="ExportArea" value="ExportArea" class="btn btn-sm btn-primary"><i class="fa fa-check-square-o"></i> Download</button></label>
                    <label class="col-sm-12 col-form-label">Step 2 -> FILL AREA DATA</label>
                    <label class="col-sm-12 col-form-label">Step 3 -> Import This File Here</label>
                    <label class="col-sm-12 col-form-label">Step 4 -> Click on Upload Button</label>
                    <label class="col-sm-12 col-form-label text-danger">Note: Import Only Selected City Areas</label>

              </div> 
             
          </form> 
            <form id="importValidation" action="controller/countryController.php" method="post" enctype="multipart/form-data">
              <input type="hidden" name="country_id" value="<?php echo $_GET['cId']; ?>">
              <input type="hidden" name="state_id" value="<?php echo $_GET['sId']; ?>">
              <input type="hidden" name="city_id" value="<?php echo $_GET['cityId']; ?>">
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Import CSV File *</label>
                    <div class="col-sm-8" id="PaybleAmount">
                      <input required="" type="file" name="file"  accept=".csv" class="form-control-file border">
                    </div>
                </div>
         
                <div class="form-footer text-center">
                  <button type="submit" name="importArea" value="importArea" class="btn btn-sm btn-success"><i class="fa fa-check-square-o"></i> Upload</button>
                </div>

          </form> 
      </div>
     
    </div>
  </div>
</div><!--End Modal -->