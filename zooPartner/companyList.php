<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
    <div class="row pt-2 pb-2">
      <div class="col-sm-9">
        <h4 class="page-title">Company List</h4>
        <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Company List</li>
         </ol>
      </div>
      <div class="col-sm-3">
        <div class="btn-group float-sm-right">
           <a href="companyWiseUsersReport"  class="btn  btn-sm btn-secondary pull-right">Report</a>
          <a href="companies"  class="btn  btn-sm btn-primary pull-right"><i class="fa fa-plus fa-lg"></i> Add New </a>
        </button>
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
            <table id="exampleList" class="table table-bordered">
              <thead>
                <tr>
                  
                  <th class="text-right">#</th>
                  
                  <th>Company Name</th>
                  <th>City</th>
                  <th>Company Email</th>
                  <th>Company Contact</th>
                  <th>Company GST</th>
                  <th>Action</th>
                  
                </tr>
              </thead>
              <tbody>
                <?php
                $i=1;
                $q=$d->select("company_master,payment_getway_master,cities"," cities.city_id = company_master.city_id and payment_getway_master.company_id=company_master.company_id and company_master.status=0 group by company_master.company_id   order by company_master.company_name
                  asc ");
                while ($data=mysqli_fetch_array($q)) {
                  extract($data);
                  ?>
                  <tr>
                    
                    <td class="text-right"><?php echo $i++; ?></td>
                    <td><?php echo  $company_name; ?></td>
                    <td><?php echo  $city_name; ?></td>
                    <td><?php echo $company_email ; ?></td>
                    <td><?php echo $company_contact_number; ?></td>
                    <td><?php echo $comp_gst_number; ?></td>
                    <td>
                      <div style="display: inline-block;">
                        <form action="companies" method="post">
                          <input type="hidden" name="company_id" value="<?php echo $company_id; ?>">
                          <button type="submit" name="" class="btn btn-primary btn-sm "> Edit</button>
                        </form>
                      </div>
                      
                      <div style="display: inline-block;">
                        <form action="viewCompany" method="post">
                          <input type="hidden" name="company_id" value="<?php echo $company_id; ?>">
                          <button type="submit" name="" class="btn btn-secondary btn-sm "> View Profile</button>
                        </form>
                      </div>

                      <?php $users_master=$d->select("users_master","  company_id= '$company_id' ","");
                      if (mysqli_num_rows($users_master) <= 0 ) { ?>
                        <div style="display: inline-block;">
                        <form  action="controller/companyController.php" method="post">
                          <input type="hidden" name="delete_company_id" value="<?php echo $company_id; ?>">
                          <button type="submit" name="deleteCmp" class="form-btn btn btn-danger btn-sm "> Delete</button>
                        </form>
                      </div>
                      <?php }
                      //24nov2020
                      else { ?> 
                        <button type="button" disabled=""  class="form-btn btn btn-danger btn-sm " style="cursor: not-allowed;" > Delete</button>
                      <?php   } ?>
                      
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