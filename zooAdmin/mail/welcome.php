<div class="content-wrapper">
    <div class="container-fluid">

      
    <div class="row mt-3">
        <div class="col-6 col-lg-6 col-xl-3">
          <div class="card gradient-bloody">
            <a href="mainCategories">
            <div class="p-2">
              <div class="media align-items-center">
              <div class="media-body">
                <p class="text-white">Category</p>
                <h4 class="text-white line-height-5"><?php echo $d->count_data_direct("business_category_id","business_categories"," business_category_id != 0    "); ?></h4>
              </div>
              <div class="w-circle-icon rounded-circle  border-white">
                <img class="myIcon" src="img/icons/block.png"></div>
            </div>
            </div>
            </a>
          </div>
        </div>
        <div class="col-6 col-lg-6 col-xl-3">
          <div class="card gradient-scooter">
            <a href="subCategories">
            <div class="p-2">
              <div class="media align-items-center">
              <div class="media-body">
                <p class="text-white"> Sub Category</p>
                <h4 class="text-white line-height-5"><?php echo $d->count_data_direct("business_sub_category_id","business_sub_categories",""); ?></h4>
              </div>
              <div class="w-circle-icon rounded-circle border-white">
                <img class="myIcon" src="img/icons/block.png"></div>
            </div>
            </div>
            </a>
          </div>
        </div>
        <div class="col-6 col-lg-6 col-xl-3">
          <div class="card gradient-blooker">
            <a href="plans">
            <div class="p-2">
              <div class="media align-items-center">
              <div class="media-body">
                <p class="text-white"> Member Plan</p>
                <h4 class="text-white line-height-5"> <?php echo $d->count_data_direct("package_id","package_master","package_status=0"); ?> </h4>
              </div>
              <div class="w-circle-icon rounded-circle border-white">
                <img class="myIcon" src="img/icons/plan-icon.png"></div>
            </div>
            </div>
            </a>
          </div>
        </div>
        <div class="col-6 col-lg-6 col-xl-3">
          <div class="card gradient-ohhappiness">
            <a href="manageMembers">
            <div class="p-2">
              <div class="media align-items-center">
              <div class="media-body">
                <p class="text-white">Users</p>
                <h4 class="text-white line-height-5"><?php echo $d->count_data_direct("user_id","users_master",""); ?></h4>
              </div>
              <div class="w-circle-icon rounded-circle border-white">
                 <img class="myIcon" src="img/icons/comittee.png"></div>
            </div>
            </div>
            </a>
          </div>
        </div>
    </div>
    <div class="row ">
      <div class="col-6 col-lg-6 col-xl-3">
        <div class="card gradient-bloody">
          <a href="businesHouses">
          <div class="p-2">
            <div class="media align-items-center">
            <div class="media-body">
              <p class="text-white">Business Houses </p>
              <h4 class="text-white line-height-5"><?php echo $d->count_data_direct("business_houses_id","business_houses",""); ?></h4>
            </div>
            <div class="w-circle-icon rounded-circle  border-white">
              <img class="myIcon" src="img/icons/owner.png"></div>
          </div>
          </div>
          </a>
        </div>
      </div>
      <div class="col-6 col-lg-6 col-xl-3">
        <div class="card gradient-scooter">
          <div class="p-2">
            <div class="media align-items-center">
            <div class="media-body">
              <p class="text-white"> Earning</p>
              <h4 class="text-white line-height-5"><i class="fa fa-inr"></i> 
                <?php 
                 // $count5=$d->sum_data("transection_amount","transection_master","payment_status='success' ");
                 //  while($row=mysqli_fetch_array($count5))
                 // {
                 //      $asif=$row['SUM(transection_amount)'];
                 // echo   $totalMain=number_format($asif,2,'.','');
                         
                 //  }
               ?>
             </h4>
            </div>
            <div class="w-circle-icon rounded-circle border-white">
              <img class="myIcon" src="img/icons/cash-icon.png"></div>
          </div>
          </div>
        </div>
      </div>
      <div class="col-6 col-lg-6 col-xl-3">
        <div class="card gradient-blooker">
          <div class="p-2">
            <div class="media align-items-center">
            <div class="media-body">
              <p class="text-white">SMS Credit Used</p>
              <h4 class="text-white line-height-5">
               <?php 
                $count5=$d->sum_data("used_credit","sms_log_master","");
                  while($row=mysqli_fetch_array($count5))
                 {  
                  if ($row['SUM(used_credit)']=='') {
                    echo "0";
                  } else {

                   echo   $asif=$row['SUM(used_credit)'];
                  }
                    
                  } ?>
              </h4>
            </div>
            <div class="w-circle-icon rounded-circle border-white">
              <img class="myIcon" src="img/icons/sms.png"></div>
          </div>
          </div>
        </div>
      </div>
      <div class="col-6 col-lg-6 col-xl-3">
        <div class="card gradient-ohhappiness">
          <a href="manageCirculers">
          <div class="p-2">
            <div class="media align-items-center">
            <div class="media-body">
              <p class="text-white">Circulers</p>
              <h4 class="text-white line-height-5">
                <?php echo $d->count_data_direct("circular_id","circulars_master",""); ?>
              </h4>
            </div>
            <div class="w-circle-icon rounded-circle border-white">
               <img class="myIcon" src="img/icons/digital-marketing.png"></div>
          </div>
          </div>
        </a>
        </div>
      </div>
    </div>
    <div class="row ">
      <div class="col-6 col-lg-6 col-xl-3">
        <div class="card gradient-bloody">
          <a href="sliderImages">
          <div class="p-2">
            <div class="media align-items-center">
            <div class="media-body">
              <p class="text-white">App Benner </p>
              <h4 class="text-white line-height-5"><?php echo $d->count_data_direct("slider_id","slider_master",""); ?></h4>
            </div>
            <div class="w-circle-icon rounded-circle  border-white">
              <img class="myIcon" src="img/icons/carousel.png"></div>
          </div>
          </div>
          </a>
        </div>
      </div>
      <div class="col-6 col-lg-6 col-xl-3">
        <div class="card gradient-scooter">
          <a href="classifieds">
          <div class="p-2">
            <div class="media align-items-center">
            <div class="media-body">
              <p class="text-white"> Classifieds</p>
               <h4 class="text-white line-height-5"><?php echo $d->count_data_direct("cllassified_id","cllassifieds_master",""); ?></h4>
            </div>
            <div class="w-circle-icon rounded-circle border-white">
              <img class="myIcon" src="img/icons/solution.png"></div>
          </div>
          </div>
        </a>
        </div>
      </div>
      <div class="col-6 col-lg-6 col-xl-3">
        <div class="card gradient-blooker">
          <a href="timeline">
          <div class="p-2">
            <div class="media align-items-center">
            <div class="media-body">
              <p class="text-white">Timeline </p>
              <h4 class="text-white line-height-5"><?php echo $d->count_data_direct("timeline_id","timeline_master",""); ?></h4>
            </div>
            <div class="w-circle-icon rounded-circle border-white">
              <img class="myIcon" src="img/icons/experience.png"></div>
          </div>
          </div>
        </a>
        </div>
      </div>
      <div class="col-6 col-lg-6 col-xl-3">
        <div class="card gradient-ohhappiness">
          <a href="feedback">
          <div class="p-2">
            <div class="media align-items-center">
            <div class="media-body">
              <p class="text-white">Feedback</p>
              <h4 class="text-white line-height-5">
                <?php echo $d->count_data_direct("feedback_id","feedback_master",""); ?>
              </h4>
            </div>
            <div class="w-circle-icon rounded-circle border-white">
               <img class="myIcon" src="img/icons/chat-complain.png"></div>
          </div>
          </div>
        </a>
        </div>
      </div>
    </div>
    <div class="row ">
      <div class="col-6 col-lg-6 col-xl-3">
        <div class="card gradient-bloody">
          <a href="areas">
          <div class="p-2">
            <div class="media align-items-center">
            <div class="media-body">
              <p class="text-white">Areas </p>
              <h4 class="text-white line-height-5"><?php echo $d->count_data_direct("area_id","area_master",""); ?></h4>
            </div>
            <div class="w-circle-icon rounded-circle  border-white">
              <img class="myIcon" src="img/icons/covid.png"></div>
          </div>
          </div>
          </a>
        </div>
      </div>
      <div class="col-6 col-lg-6 col-xl-3">
        <div class="card gradient-scooter">
          <a href="countries">
          <div class="p-2">
            <div class="media align-items-center">
            <div class="media-body">
              <p class="text-white"> Countries</p>
               <h4 class="text-white line-height-5"><?php echo $d->count_data_direct("country_id","countries",""); ?></h4>
            </div>
            <div class="w-circle-icon rounded-circle border-white">
              <img class="myIcon" src="img/icons/flag.png"></div>
          </div>
          </div>
        </a>
        </div>
      </div>
      <div class="col-6 col-lg-6 col-xl-3">
        <div class="card gradient-blooker">
          <a href="states">
          <div class="p-2">
            <div class="media align-items-center">
            <div class="media-body">
              <p class="text-white">States</p>
              <h4 class="text-white line-height-5"><?php echo $d->count_data_direct("state_id","states",""); ?></h4>
            </div>
            <div class="w-circle-icon rounded-circle border-white">
              <img class="myIcon" src="img/icons/house.png"></div>
          </div>
          </div>
          </a>
        </div>
      </div>
      <div class="col-6 col-lg-6 col-xl-3">
        <div class="card gradient-ohhappiness">
          <a href="cities">
          <div class="p-2">
            <div class="media align-items-center">
            <div class="media-body">
              <p class="text-white">Cities</p>
              <h4 class="text-white line-height-5">
                <?php echo $d->count_data_direct("city_id","cities",""); ?>
              </h4>
            </div>
            <div class="w-circle-icon rounded-circle border-white">
               <img class="myIcon" src="img/icons/antenna.png"></div>
          </div>
          </div>
        </a>
        </div>
      </div>
    </div>

   