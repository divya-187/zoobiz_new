  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
      <div class="row pt-2 pb-2">
        <div class="col-sm-9">
          <h4 class="page-title">Interests</h4>
          <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Interests</li>
         </ol>
       </div>
       <div class="col-sm-3">
         <div class="btn-group float-sm-right">
           <a href="javascript:void(0)" onclick="DeleteAll6('deleteInterest');" class="btn  btn-sm btn-danger pull-right"><i class="fa fa-trash-o fa-lg"></i> Delete </a>
          <a href="#" data-toggle="modal" data-target="#addInterest" class="btn btn-sm btn-primary waves-effect waves-light"><i class="fa fa-plus mr-1"></i> Add New </a>
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
            <table id="example6" class="table table-bordered">
              <thead>
                <tr>
                  <th class="deleteTh">
                    <input type="checkbox" class="selectAll" label="check all"  />       
                  </th>
                  <th class="text-right">#</th>
                 <th>Members</th>
                  <th>Name</th>
                  <th>Status</th>
                 
                  
                   <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $i=1;
                  $q=$d->select("interest_master"," status=0 and int_status !='User Added' ","ORDER BY interest_name ASC");
                  
              
               while ($data=mysqli_fetch_array($q)) {
                extract($data);
                ?>
                <tr>
                  <td class='text-center'>
                     <?php 
                   
                    $q3=$d->select("interest_relation_master,users_master","users_master.user_id =interest_relation_master.member_id and   interest_relation_master.interest_id='$interest_id'",""); 
                 $totalCategory =   mysqli_num_rows($q3);
                  if ($totalCategory==0) {
                  ?>  
                    <input type="checkbox" class="multiDelteCheckbox"  value="<?php echo $data['interest_id']; ?>">
                  <?php } else {
                     ?>  
                    <input type="checkbox" disabled="">
                  <?php } ?>
                  </td>
<td class="text-right"><?php echo $i++; ?></td>
                   <td class='text-center'>
                     <?php 
                   
                   
                  if ($totalCategory==0) {
                    echo "0";
                    } else {
                     echo $totalCategory;
                     ?>
                      <button class="btn btn-secondary btn-sm"  data-toggle="collapse" data-target="#demo<?php echo $interest_id; ?>">View</button>
                      <div id="demo<?php echo $interest_id; ?>" class="collapse">
                     <?php
                     while ($data3=mysqli_fetch_array($q3)) {
                      ?>
                      <a  target="_blank"  title="View Profile"  href="viewMember?id=<?php echo $data3['member_id']; ?>" ><?php echo  $data3['user_full_name']; ?></a><br>
                      <?php
                     }
                  } ?>
                </div>
                  </td>


                  
                  <td><?php echo $interest_name; ?></td>
                  <td><?php echo $int_status; ?></td>
                 
                 <td>
                     <a data-toggle="modal" data-target="#editInterest" href="javascript:void();" onclick="editInterest('<?php echo $data['interest_id']; ?>','<?php echo $data['interest_name']; ?>');" class="btn btn-sm btn-primary shadow-primary">Edit</a>

                    
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

 


<div class="modal fade" id="addInterest">
  <div class="modal-dialog">
    <div class="modal-content border-fincasys">
      <div class="modal-header bg-fincasys">
        <h5 class="modal-title text-white">Add Interest</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form id="addinterestForm" action="controller/interestController.php" method="post" enctype="multipart/form-data">
                <div class="form-group row">
                    <label for="input-10" class="col-sm-4 col-form-label">Interest Name <span class="required">*</span></label>
                    <div class="col-sm-8">
                      <input required="" type="text" name="interest_name"  class="form-control" minlength="3" maxlength="50">
                    </div>
                </div>

             


                
         
                <div class="form-footer text-center">
                  <input type="hidden" name="addinterest" value="addinterest">
                  <button type="submit" name="" value="" class="btn btn-sm btn-success"><i class="fa fa-check-square-o"></i> Add</button>
                </div>

          </form> 
      </div>
     
    </div>
  </div>
</div><!--End Modal -->



<div class="modal fade" id="editInterest">
  <div class="modal-dialog">
    <div class="modal-content border-fincasys">
      <div class="modal-header bg-fincasys">
        <h5 class="modal-title text-white">Edit Interest</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div> 
      <div class="modal-body">
          <form id="editInterestForm" action="controller/interestController.php" method="post" enctype="multipart/form-data">
                <div class="form-group row">
                    <label for="input-10" class="col-sm-4 col-form-label">Interest Name <span class="required">*</span></label>
                    <div class="col-sm-8">
                      <input type="hidden" name="interest_id" id="interest_id">
                      <input required="" id="interest_name" type="text" name="interest_name"  class="form-control" minlength="3" maxlength="50">
                    </div>
                </div>


                
         
                <div class="form-footer text-center">
                  <input type="hidden"  name="editInterest" value="editInterest">
                  <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-check-square-o"></i> Update</button>
                </div>

          </form> 
      </div>
     
    </div>
  </div>
</div><!--End Modal -->