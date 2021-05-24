  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
      <div class="row pt-2 pb-2">
        <div class="col-sm-9">
          <h4 class="page-title">UPIs</h4>
          <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">UPIs</li>
         </ol>
       </div>
       <div class="col-sm-3">
         <div class="btn-group float-sm-right">
         
          <a href="#" data-toggle="modal" data-target="#addUPI" class="btn btn-sm btn-primary waves-effect waves-light"><i class="fa fa-plus mr-1"></i> Add New </a>
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
                    #
                  </th>
                 
                 <th>app ame</th>
                  <th>app package name</th>
                  <th>Created At</th>
                  <th>Status</th>
                 
                  
                   <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $i=1;
                  $q=$d->select("upi_app_master","","ORDER BY app_name ASC");
                  
              
               while ($data=mysqli_fetch_array($q)) {
                extract($data);
                ?>
                <tr>
                   
                    
<td class="text-right"><?php echo $i++; ?></td>
                   


                  
                  <td><?php echo $app_name; ?></td>
                  <td><?php echo $app_package_name; ?></td>
                    <td data-order="<?php echo date("U",strtotime($created_at)); ?>" ><?php echo date("d-m-Y", strtotime($created_at)); ?></td>
                 <td>
                     

                     <?php if($data['active_status']==0){ 
                        ?>
                          <input type="checkbox" checked class="js-switch" data-color="#15ca20" onchange ="changeStatus('<?php echo $data['app_id']; ?>','DisableUPI');" data-size="small"/>
                          <?php } else { ?>
                         <input type="checkbox"  class="js-switch" data-color="#15ca20" onchange ="changeStatus('<?php echo $data['app_id']; ?>','EnableUPI');" data-size="small"/>
                        <?php } ?> 
                    
                 </td>
                  <td>
                     <a data-toggle="modal" data-target="#editUpi" href="javascript:void();" onclick="editUPI('<?php echo $data['app_id']; ?>','<?php echo str_replace("'", "\\'",$data['app_name']); ?>','<?php echo str_replace("'", "\\'",$data['app_package_name']); ?>');" class="btn btn-sm btn-primary shadow-primary">Edit</a>
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

 


<div class="modal fade" id="addUPI">
  <div class="modal-dialog">
    <div class="modal-content border-fincasys">
      <div class="modal-header bg-fincasys">
        <h5 class="modal-title text-white">Add UPI</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form id="addUpiFrm" action="controller/upiController.php" method="post" enctype="multipart/form-data">
                <div class="form-group row">
                    <label for="input-10" class="col-sm-4 col-form-label">App Name <span class="required">*</span></label>
                    <div class="col-sm-8">
                      <input required="" type="text" name="app_name"  class="form-control" minlength="3" maxlength="50">
                    </div>
                </div>

              <div class="form-group row">
                    <label for="input-10" class="col-sm-4 col-form-label">App Package Name <span class="required">*</span></label>
                    <div class="col-sm-8">
                      <input required="" type="text" name="app_package_name"  class="form-control" minlength="3" maxlength="50">
                    </div>
                </div>


                
         
                <div class="form-footer text-center">
                  <input type="hidden" name="addupi" value="addupi">
                  <button type="submit" name="" value="" class="btn btn-sm btn-success"><i class="fa fa-check-square-o"></i> Add</button>
                </div>

          </form> 
      </div>
     
    </div>
  </div>
</div><!--End Modal -->



<div class="modal fade" id="editUpi">
  <div class="modal-dialog">
    <div class="modal-content border-fincasys">
      <div class="modal-header bg-fincasys">
        <h5 class="modal-title text-white">Edit UPI</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div> 
      <div class="modal-body">
          <form id="editUPIForm" action="controller/upiController.php" method="post" enctype="multipart/form-data">
                <div class="form-group row">
                    <label for="input-10" class="col-sm-4 col-form-label">App Name <span class="required">*</span></label>
                    <div class="col-sm-8">
                      <input type="hidden" name="app_id" id="app_id">
                      <input required="" id="app_name" type="text" name="app_name"  class="form-control" minlength="3" maxlength="50">
                    </div>
                </div>
                 <div class="form-group row">
                    <label for="input-10" class="col-sm-4 col-form-label">App Package Name <span class="required">*</span></label>
                    <div class="col-sm-8"> 
                      <input required="" id="app_package_name" type="text" name="app_package_name"  class="form-control" minlength="3" maxlength="50">
                    </div>
                </div>
 

                
         
                <div class="form-footer text-center">
                  <input type="hidden"  name="editUpi" value="editUpi">
                  <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-check-square-o"></i> Update</button>
                </div>

          </form> 
      </div>
     
    </div>
  </div>
</div><!--End Modal -->