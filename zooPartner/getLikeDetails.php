<?php //IS_754 wholefile
session_start();
$url=$_SESSION['url'] = $_SERVER['REQUEST_URI']; 
$activePage = basename($_SERVER['PHP_SELF'], ".php");
include_once 'lib/dao.php';
include 'lib/model.php';
$d = new dao();
$m = new model();
extract(array_map("test_input" , $_POST));
if (isset($timeline_id)) {
     
 


     $likes_qry=$d->select("timeline_like_master,users_master","timeline_like_master.timeline_id='$timeline_id' AND timeline_like_master.user_id=users_master.user_id AND users_master.office_member=0 and timeline_like_master.active_status=0 AND users_master.active_status=0     order by timeline_like_master.modify_date desc    ");
         while($likes_data=mysqli_fetch_array($likes_qry)) {
            

            
         ?>
        <div class="facebook-card-comments">
          <img  onerror="this.src='../zooAdmin/img/user.png'" class="imgRedonda1" src="../img/users/members_profile/<?php echo $likes_data['user_profile_pic']; ?>" width="10%">
           <a href="viewMember?id=<?php echo $likes_data['user_id']; ?>" target="_blank" class="profileName1 text-primary"><?php echo $likes_data['salutation']; ?> <?php echo $likes_data['user_full_name']; ?></a> 

          
           <br>
           <br>
        </div>
        <?php  
        } 

        /* $likes_qry=$d->select("timeline_like_master,zoobiz_admin_master","timeline_like_master.timeline_id='$timeline_id' AND timeline_like_master.user_id=zoobiz_admin_master.zoobiz_admin_id order by timeline_like_master.modify_date desc    ");
         while($likes_data=mysqli_fetch_array($likes_qry)) {
            

            
         ?>
        <div class="facebook-card-comments">
          <img  onerror="this.src='../zooAdmin/img/user.png'" class="imgRedonda1" src="img/profile/<?php echo $likes_data['admin_profile']; ?>" width="10%">
          <a href="#" target="_blank" class="profileName1 text-primary"> <?php echo $likes_data['admin_name']; ?></a> 

          
           <br>
           <br>
        </div>
        <?php  
        } */


  } ?>