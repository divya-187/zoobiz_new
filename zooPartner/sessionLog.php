  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
     <div class="row pt-2 pb-2">
        <div class="col-sm-9">
        <h4 class="page-title">Session Logs</h4>
        <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Session Logs</li>
         </ol>
     </div>
     <?php 
      $q = $d->select("session_log" ,"status=0","order by sessionId  DESC");
      if(  mysqli_num_rows($q) > 0 ) { ?>  
     
     <div class="col-sm-3">
       <div class="btn-group float-sm-right">
        <?php /* ?> 
        <a href="javascript:void(0)" onclick="DeleteAll('deleteSessionlog');"  class="btn btn-sm btn-danger shadow-danger waves-effect waves-light"><i class="fa fa-trash-o mr-1"></i> Delete</a>
       <?php */ ?> 
        
        
      </div>
     </div>
   <?php } ?> 
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
                      <th>Name</th>
                      <th>User Role</th>
                      <th>Ip Address</th>
                      <th>Browser</th>
                      <th>Login Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $i=1;
                   
                    while ($data=mysqli_fetch_array($q)) {
                      // print_r($data);
                     ?>
                    <tr>
                   
                      <td class="text-right"><?php echo $i++; ?></td>
                        <td><?php echo $data["name"]; ?></td>
                        <td><?php echo $data["role_name"]; ?></td>
                        <td><a target="_blank" href="https://www.iptrackeronline.com/index.php?ip_address=<?php echo $data["ip_address"]; ?>&k="><?php echo $data["ip_address"]; ?></a></td>
                        <td><?php echo  wordwrap($data["browser"],30,"<br>\n"); ?></td>
                        <td data-order="<?php echo date("U",strtotime($data["loginTime"])); ?>"><?php echo $data["loginTime"]; ?></td>
                        <!-- <td></td> -->
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



