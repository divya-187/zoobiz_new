  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
      <div class="row pt-2 pb-2">
        <div class="col-sm-6">
          <h4 class="page-title">Company Wise Users Details</h4>
          <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li>
           <li class="breadcrumb-item"><a href="companyWiseUsersReport">Company Wise Users</a></li>
            <li class="breadcrumb-item active" aria-current="page">Company Wise Users Details</li>
         </ol>
       </div>
       <div class="col-sm-6">
         
            <form action=""   method="post" accept-charset="utf-8">
        <?php 
        
   
          $qry=$d->select("company_master"," status=0","ORDER BY company_name ASC");
          ?>
       
        <select name="company_id" onchange="this.form.submit();" class="form-control single-select">
          
           <option  value="0">All</option>
          <?php   
           while ($blockRow=mysqli_fetch_array($qry)) {
         ?>
          <option <?php if ( isset($_REQUEST['company_id']) &&  $blockRow['company_id']==$_REQUEST['company_id'] ) { echo 'selected';} ?> value="<?php echo $blockRow['company_id'];?>"><?php echo $blockRow['company_name'];?></option>
          <?php }?>
        </select>
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
            <table id="example" class="table table-bordered">
              <thead>
                <tr>
                  
                  <th class="text-right">#</th>
                 
                  <th>Company Name</th>
                  <th>User Name</th>
                   
                </tr>
              </thead>
              <tbody>
                <?php 
                $i=1;
                extract($_REQUEST);

                if( !isset($_REQUEST['company_id']) ||  $_REQUEST['company_id']==0 ){

                  $q=$d->select("company_master,users_master","company_master.company_id = users_master.company_id and   company_master.status=0 and users_master.office_member = 0 AND users_master.office_member=0 AND users_master.active_status=0  ","ORDER BY company_master.company_name ASC");
                } else {
                  $q=$d->select("company_master,users_master","company_master.company_id = users_master.company_id and company_master.company_id=$_REQUEST[company_id] and  company_master.status=0 and users_master.office_member = 0 AND users_master.office_member=0 AND users_master.active_status=0  ","ORDER BY company_master.company_name ASC");
                }
                  
              
               while ($data=mysqli_fetch_array($q)) {
                extract($data);
                ?>
                <tr>
                  
                  <td class="text-right"><?php echo $i++; ?></td>
                  <td><?php echo $company_name; ?></td>
                  <td> <a href="viewMember?id=<?php echo $user_id; ?>"><?php echo $user_full_name; ?> </a></td>
                  
                

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