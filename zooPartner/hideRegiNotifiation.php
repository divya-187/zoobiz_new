  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
      <div class="row pt-2 pb-2">
        <div class="col-sm-9">
          <h4 class="page-title">Hide Registration Notification</h4>
          <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Hide Registration Notification</li>
         </ol>
         
       </div>
       <div class="col-sm-3">
         <div class="btn-group float-sm-right">
           
           <a href="javascript:void(0)" onclick="DeleteAll('deleteHideNumber');" class="btn  btn-sm btn-danger pull-right"><i class="fa fa-trash-o fa-lg"></i> Delete </a>
          <a href="#" data-toggle="modal" data-target="#addNumber" class="btn btn-sm btn-primary waves-effect waves-light"><i class="fa fa-plus mr-1"></i> Add New </a>
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
                  <th class="deleteTh">
                    Select
                  </th>
                  <th class="text-right">#</th>
                 <th >MObile Number</th>
                
                 
                  
                   <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $i=1;
                  $q=$d->select("hide_number_master","status=0","ORDER BY created_at desc");
                  
              
               while ($data=mysqli_fetch_array($q)) {
                extract($data);
                ?>
                <tr>
                  <td class='text-center'>
                     
                    <input type="checkbox" class="multiDelteCheckbox"  value="<?php echo $data['id']; ?>">
                   
                  </td>
                  <td class="text-right"><?php echo $i++; ?></td>
                  
                  
                  <td><?php echo $mobile_number; ?></td>
                  
                   <td>
                     <a data-toggle="modal" data-target="#editHideNumber" href="javascript:void();" onclick="editHideNumber('<?php echo $data['id']; ?>','<?php echo $data['mobile_number']; ?>');" class="btn btn-sm btn-primary shadow-primary">Edit</a>

                     
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

 
<div class="modal fade" id="addNumber">
  <div class="modal-dialog">
    <div class="modal-content border-fincasys">
      <div class="modal-header bg-fincasys">
        <h5 class="modal-title text-white">Add Number</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form id="addNumberForm" action="controller/commonController.php" method="post" enctype="multipart/form-data">
                <div class="form-group row">
                    <label for="input-10" class="col-sm-4 col-form-label">Mobile Number<span class="required">*</span></label>
                    <div class="col-sm-8">
                      <input required="" type="text" name="hide_mobile_number"  class="form-control onlyNumber"  maxlength="10" minlength="10">
                    </div>
                </div>
 
                <div class="form-footer text-center">

                  <input type="hidden"  name="addHideNumber" value="addHideNumber">
                  <button type="submit" name="" value="" class="btn btn-sm btn-success"><i class="fa fa-check-square-o"></i> Add</button>
                </div>

          </form> 
      </div>
     
    </div>
  </div>
</div><!--End Modal -->



<div class="modal fade" id="editHideNumber">
  <div class="modal-dialog">
    <div class="modal-content border-fincasys">
      <div class="modal-header bg-fincasys">
        <h5 class="modal-title text-white">Edit Number</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form id="addNumberForm" action="controller/commonController.php" method="post" enctype="multipart/form-data">
                 <div class="form-group row">
                    <label for="input-10" class="col-sm-4 col-form-label">Mobile Number<span class="required">*</span></label>
                    <div class="col-sm-8">
                      <input required="" type="text" name="hide_mobile_number" id="hide_mobile_number"  class="form-control onlyNumber"  maxlength="10" minlength="10">
                    </div>
                </div>
 
                <div class="form-footer text-center">

                  <input type="hidden"  name="id" value="" id="id">
                  <input type="hidden"  name="editHideNumber" value="editHideNumber">
                  <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-check-square-o"></i> Update</button>
                </div>

          </form> 
      </div>
     
    </div>
  </div>
</div><!--End Modal -->

  