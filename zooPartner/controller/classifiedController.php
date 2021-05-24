<?php
include '../common/objectController.php'; 
if (isset($_POST) && !empty($_POST)) {
 
 
  

 
if (isset($comment_id_delete)) {
    

      $q1=$d->delete("cllassified_comment","comment_id='$comment_id_delete' ");

      if ($q1>0) {
          $_SESSION['msg']="Comment Deleted";
          $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by","Classified Comment Deleted");
         header("location:../classifiedHistory?id=$cllassified_id");
      }else{
        $_SESSION['msg1']="Soenthing Wrong.";
         header("location:../classifiedHistory?id=$cllassified_id");
      }




 } 


}
            ?>