 <ul class="sidebar-menu do-nicescrol" >
    <?php
        $i=1;
        $q=$d->select("master_menu","page_status='0'","ORDER BY order_no ASC");
        while ($data=mysqli_fetch_array($q)) {
         if($data['parent_menu_id']==0 && $data['sub_menu']==0) {
         $menu_id=$data['menu_id']; 
         if(in_array($menu_id, $accessMenuIdArr)){
         ?>
         <li class="<?= ($_GET['f'] == $data['menu_link']) ? 'active':''; ?>">
          <a href="<?php echo $data['menu_link']; ?>" class="waves-effect ">
            <i class="<?php echo $data['menu_icon']; ?>"></i> <span><?php echo $data['menu_name']; ?></span> 
          </a>
          
        </li>
        <!-- main menu end no sub menu -->
       <?php } } else if($data['sub_menu']==1) {
       $menu_id=$data['menu_id'];
        // echo $data['parent_menu_id'];
        // print_r($accessMenuIdArr);
        $accAry=array();
        $qs=$d->selectRow("menu_id","master_menu","parent_menu_id='$menu_id' AND page_status='0'");
        while ($temData=mysqli_fetch_array($qs)) {
            array_unique($temData);
            array_push($accAry, $temData);
        }
        // print_r($accAry);
        $singleArray = array();
        foreach ($accAry as $key => $value){
          $singleArray[$key] = $value['menu_id'];
        }
        if(array_intersect($singleArray, $accessMenuIdArr)){
         
        ?>
        <li class="<?php  $q1=$d->select("master_menu","parent_menu_id='$menu_id' AND page_status='0' AND menu_link='$_GET[f]'","");
            $dataSub=mysqli_fetch_array($q1);
             $actStatus=$dataSub['menu_link'];
              if($_GET['f'] ==$actStatus) {
                echo 'active';
              }
              ?>">
          <a href="javaScript:void();" class="waves-effect">
            <i class="<?php echo $data['menu_icon']; ?>"></i>
            <span><?php echo  $data['menu_name']; ?></span> <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="sidebar-submenu" >
            <?php
              $q1=$d->select("master_menu","parent_menu_id='$menu_id' AND page_status='0'","ORDER BY order_no ASC");
            while ($dataSub=mysqli_fetch_array($q1)) {
              $menu_id1=$dataSub['menu_id'];
            if(in_array($menu_id1, $accessMenuIdArr)){
              ?>
              <li class="<?php 
                  $s7=$d->select("master_menu","menu_id='$menu_id1' AND status=0 AND page_status=0");
                  while ($sdata7=mysqli_fetch_array($s7)) {
                    $abc=$sdata7['menu_link'];
                    if($_GET['f']==$abc) { echo "active"; }
                  } ?>"><a href="<?php echo $dataSub['menu_link']; ?>"><i class="fa fa-angle-double-right"></i><?php echo  $dataSub['menu_name']; ?></a>
              </li>
            <?php } } ?>
          </ul>
        </li>
       
        <?php } } } ?>
     
      
     
      <li class="sidebar-header no-border"></li>
      <li class="sidebar-header no-border"></li>
      <li class="sidebar-header no-border"></li>
      
    </ul>