<?php error_reporting(0); ?> 
    <div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
    <div class="row pt-2 pb-2">
      <div class="col-sm-6">
        <h4 class="page-title">APKs</h4>
        
      </div>
      <div class="col-sm-6">
        
      </div>
    </div>
    <!-- End Breadcrumb-->
    <div class="row">
      <div class="col-lg-12">
        
      </div>
    </div>
    
    
      <!--End Row-->
      <!-- Msanage Slider -->
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
                <h4 class="form-header text-uppercase">
                <i class="fa fa-address-book-o"></i>
                APK List
                </h4>

               

                   <div class="table-responsive">
            <table id="example" class="table table-bordered">
              <thead>
                <tr>
                  
                  <th class="text-right">#</th>
                  
                  <th>APK</th>
                  <th>Version</th>
                  <th>Description</th>
                  <th>Created At</th>
                  <th>Action</th>
                    
                  
                </tr>
              </thead>
              <tbody>

                  <?php
                  $i =1;
                  $sq = $d->select("api_master","","order by created_at desc");
                  while ($sData11 = mysqli_fetch_array($sq)) {
                    extract($sData11);
                  ?>
                  <tr>
                    <td><?php echo $i; $i++; ?></td>
                    <td><?php echo $api_file;   ?></td>
                    <td><?php echo $api_version;  ?></td>
                    <td><?php echo wordwrap($description,30,"<br>\n");   ?></td>
                    <td data-order="<?php echo date("U",strtotime($created_at)); ?>" ><?php echo $created_at;  ?></td>
                    <td>
                       <a  class="btn btn-sm btn btn-secondary" href="../img/api/<?php echo $api_file; ?>" download><i class="fa fa-download" aria-hidden="true"></i> Download</a>

                        <form  style="display: inline-block;"  action="controller/apiController.php" method="post">
                      <input type="hidden" name="api_id" value="<?php echo $api_id; ?>">
                      <input type="hidden" name="deleteAPI" value="deleteAPI">
                      <button type="submit" class="btn btn-sm form-btn btn-danger" >Delete</button>
                    </form>

                    </td>
                  </tr>
  
                  
                   
                  <?php
                  }
                  ?>
                </tbody>
              </table>
                </div>
              
<hr>

       <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
            <div class="">
              <form  id="apiFrm" action="controller/apiController.php" method="post" enctype="multipart/form-data">
         
          <div class="form-group row">
            <label class="col-lg-3 col-form-label form-control-label">Add New APK</label>
            <div class="col-lg-9">
              <input required="" class="form-control-file border" id="api_file"   name="api_file" type="file" accept=".apk">
              
             
            </div>
          </div>
           <div class="form-group row">
              <label for="state" class="col-sm-3 col-form-label">apk version</label>
              <div class="col-sm-9">
                    <input required="" minlength="1" maxlength="50" class="form-control" name="api_version" type="text" value=""   accept="apk">
              </div>
            </div>
          
           
            <div class="form-group row">
              <label for="state" class="col-sm-3 col-form-label">Description</label>
              <div class="col-sm-9">
                    <textarea  minlength="1" maxlength="250" value=""  class="form-control" id="description" name="description"></textarea>
              </div>
            </div>

          <div class="form-group row">
            <label class="col-lg-3 col-form-label form-control-label"></label>
            <div class="col-lg-9">
              
              <input type="submit" class="btn btn-primary" name="addApi"  value="Add">
            </div>
          </div>
        </form>
      </div>
    </div></div>
        </div>
      </div>


</div>
</div>
</div>
</div>
</div>
</div>
