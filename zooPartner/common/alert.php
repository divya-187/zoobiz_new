 <?php if(isset($_SESSION['msg'])) { ?>
  <script type="text/javascript">
    swal({
    	 title: "Success!",
		   icon: "success",
	     text: "<?php echo $_SESSION['msg']; ?>",
	     // type: "success",
	     timer: 3000
    });
  </script>
  <?php
	unset($_SESSION['msg']); 
   } elseif (isset($_SESSION['msg1'])) { ?>
  <script type="text/javascript">
    swal({
    	 title: "Error!",
		   icon: "error",
	     text: "<?php echo $_SESSION['msg1']; ?>",
	     // type: "error",
	     timer: 4000
    });
  </script>
  <?php 
	unset($_SESSION['msg1']); 
   } ?>