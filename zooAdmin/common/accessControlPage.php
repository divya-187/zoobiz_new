<?php 
    // main menu
    $pageName=$_GET['f'];
    $accessPage=$d->select("master_menu","status=0 and menu_link='$pageName'");
    $accessPageData=mysqli_fetch_array($accessPage);
    $pageMenuId=$accessPageData['menu_id'];  
     if( $pageName=="userInterests" OR $pageName=="partner" OR  $pageName=="userTimeline" OR $pageName=="feedbackHistory" OR $pageName=="approveBusinessName" OR $pageName== "manageSubCatKeywords" OR   $pageName== "clickUsersDetails" OR $pageName== "addAppMenu" OR $pageName== "interestApproval" OR $pageName== "planExpired" OR  $pageName== "planExpiring" OR $pageName== "memberApp" OR $pageName== "useSeasonalGreetingReportNew" OR  $pageName== "unlinkFiesScript" OR  $pageName== "manageSeasonalGreet" OR  $pageName== "seasonalGreetImage" OR  $pageName== "seasonalGreetList" OR  $pageName== "seasonalGreet" OR  $pageName== "approveInterest" OR  $pageName=="approveMember" OR $pageName=="noUseTimelineReport" OR $pageName== "currency" OR $pageName== "script5nov" OR $pageName== "userInfo" OR   $pageName== "importArea" OR $pageName== "viewSubCategory" OR   $pageName== "planexpirereport" OR  $pageName== "language_key_master_value_list" OR  $pageName== "language_key_value_master" OR $pageName== "keyValue" OR $pageName== "addSubmenu" OR  $pageName==  "manageMainCategory2" OR $pageName== "currencyList" OR  $pageName== "manageMainCategory2" OR  $pageName== "manageMainCategory" OR  $pageName== "vevrUsageMemberDetails" OR $pageName== "manageSubCategory2" OR   $pageName== "userInfoEmpty" OR  $pageName=="memberView"  OR  $pageName== "viewOwner" OR $pageName== "menu" OR $pageName== "api" OR $pageName== "address" OR  $pageName== "memberFollowers" OR $pageName== "memberFollowing" OR  $pageName== "language" OR $pageName== "languageKey"  OR $pageName== "edit_language_key_value" OR $pageName== "classifiedHistory" OR $pageName== "memberReferDetails" OR  $pageName== "notUseLetsMeet" OR  $pageName== "useSeasonalGreetingReport" OR  $pageName== "adminNotification" OR $pageName== "area" OR $pageName== "manageFrame" OR $pageName== "business_promotions" OR  $pageName== "manageCenterImage" OR $pageName== "manageSubCategory" OR $pageName== "viewCompany" OR  $pageName=="categorywiseFollowDetails" OR  $pageName=="companyWiseUsersDetail"  OR $pageName=="categoryWiseUsersReportDetails"  OR  $pageName=="viewMember"  OR $pageName=="subCategoryWiseUsersDetails"  OR $pageName=="admin"  OR $pageName=="promote" OR $pageName=="managePromotionImages"    OR $pageName=="profile"  OR $pageName=="welcome" OR $pageName=="success" OR $pageName=="failure" OR $pageName=="readNotification.php" OR   in_array($pageMenuId, $pagePrivilegeArr) OR in_array($pageMenuId, $accessMenuIdArr)){
    
    } else {
        $_SESSION['msg2']="Sorry! Access denied, You don't have permission to open this page.";
        // $_SESSION['403']="Sorry! Access denied, You don't have permission to open this page.";

 

        ?>
<script language="javascript"> 
alert("Sorry! Access Denied <?php echo  $pageName;?>!"); 
window.location = "welcome"; 
</script> 
        
<?php  
}
?>