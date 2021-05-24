  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
      <div class="row pt-2 pb-2">
        <div class="col-sm-9">
          <h4 class="page-title">Company Wise Users</h4>
          <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Company Wise Users</li>
         </ol>
       </div>
       <div class="col-sm-3">
         <div class="btn-group float-sm-right">
           <a class="btn btn-sm btn-secondary" href="companyWiseUsersDetail">View User Details</a>
       </div>
     </div>
   </div>


   <form action="" method="get">
      <div class="row pt-2 pb-2">
         
         <div class="col-sm-4">
          <div class="">
           
             <select type="text"   multiple="multiple" id="company_id"     class="form-control single-select" name="company_id[]">


             
                            <option value="">-- Select --</option>
                            <option  <?php if( isset($_GET['company_id']) &&   in_array("0", $_GET['company_id'])  ) { echo 'selected';} ?>  value="0">All</option>
                            <?php $qb=$d->select("company_master"," status = 0 ","");
                            while ($bData=mysqli_fetch_array($qb)) {?>
                              <option  <?php if ( isset($_REQUEST['company_id']) &&   in_array($bData['company_id'], $_GET['company_id'])   ) { echo 'selected';} ?>    value="<?php echo $bData['company_id']; ?>"><?php echo $bData['company_name']; ?></option>
                            <?php } ?> 
                          </select>
          </div>
        </div>

         <div class="col-lg-2 col-3">
            <label  class="form-control-label"> </label>
              <input  class="btn btn-success" type="submit" name="getReport" class="form-control" value="Search">
          </div>

      </div>
    </form>
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
                  <th class="text-right">Members</th>
                   <th>View Member Details</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $i=1;

                $where="";
                  if(isset($_GET['company_id']) &&  !in_array("0", $_GET['company_id']) ){
                    $company_id = implode(",", $_GET['company_id']) ;
                    $where .=" and   company_id in ($company_id) ";
                  }
 
                  $q=$d->select("company_master","status=0 $where ","ORDER BY company_name ASC");
                  
              
               while ($data=mysqli_fetch_array($q)) {
                extract($data);
                ?>
                <tr>
                  
                  <td class="text-right"><?php echo $i++; ?></td>
                  <td><?php echo $company_name; ?></td>
                 <td class="text-right">
                   <?php 
                   
                   $q3=$d->select("users_master"," company_id='$company_id'    AND office_member=0 AND active_status=0  ","");
                  echo mysqli_num_rows($q3);

                  ?>  
 </td>
 <td>
   <?php if( mysqli_num_rows($q3) > 0 ){?>  
 <form style="display: inline-block;" action="companyWiseUsersDetail" method="get">    
                          <input type="hidden" name="company_id" value="<?php echo $company_id; ?>">    
                          <button type="submit" name="" class="btn btn-info btn-sm "> View Details</button>
                        </form>       
                          <?php }?>              </td>
                          
                

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