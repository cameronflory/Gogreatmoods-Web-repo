<?php
      session_start();
      if(!isset($_SESSION['authenticated']))
       {
            header('Location: ../index.php');
            exit;
       }
      ob_start();
      define("SITE_ROOT",$_SERVER["DOCUMENT_ROOT"].'/salesTest/');
      include("../includes/connection.inc.php");
      $link = connectTo();
      $groupID = $_GET['group'];
      $table = "sample_websites";
      $query = "SELECT * FROM $table WHERE samplewebID = $groupID";
      $result = mysqli_query($link, $query) or die(mysqli_error());
      $row_count = mysqli_num_rows($result);
      if($row_count == '0'){
        echo "<br />Sample Website Not Found.<br />";
      }else{
         $row = mysqli_fetch_assoc($result);
         $club_name = $row['sampleName'];
         $club = $row['club'];
         $goal = $row['goal'];
         $so_far = $goal*.2;
         $banner_path = $row['bannerPath'];
         $position = $row['samplePosition'];
         $leader = $row['sampleFname'].' '.$row['sampleLname'];
         $phone = $row['samplePhone'];
         $group_email = $row['sampleGroupEmail'];
         $contact_photo = $row['contact_group_photo'];
         $group_photo = $row['groupPhoto'];
         $leader_photo = $row['group_leader'];
         $student_photo = $row['student_leaders'];
         $reasons = $row['sampleReasons'];
         $student_leader_name = $row['student_leader'];
         $student_name = $row['student_name'];
         if($row['sampleTitle']==''){
           $title = $club;
         }else{
           $title = $row['sampleTitle'];
         }
      }
?>
<!DOCTYPE html>
<head>
<meta charset="UTF-8">
<title>Fitness & Fun | GreatMoods</title>
<link rel="stylesheet" type="text/css" href="../css/mainRecruitingStyles.css">
<link rel="stylesheet" type="text/css" href="../css/header_styles.css">
<link rel="stylesheet" type="text/css" href="../css/leftSidebarNav.css">
<link rel="shortcut icon" href="../images/favicon.ico">

<script>
$(document).ready(function() {
$(“.nav li:has(ul)”).hover(function(){
$(this).find(“ul”).slideDown();
}, function(){
$(this).find(“ul”).hide();
});
});
</script>
</head>

<body>
<div id="container">
<?php include 'header_sample.php'; ?>
<?php include 'leftSidebarSampleStores.php'; ?>

<div id="contentSample">
  	<div id="fitnessstore"> <!-- **Background: Store Image** -->
  		<div id="fitnessstoretable"><!-- CSS Table Grid -->
  			<div class="storerow"> </div><!-- CSS Blank Row -->
  			<div class="storerow2"> </div><!-- CSS Blank Row -->
  			<div class="storerow2"> <!-- CSS Row -->
  				<span class="storecell"> &nbsp; </span> <!-- CSS Blank Cell -->
  				<span class="storecell"> &nbsp; </span> <!-- CSS Blank Cell -->
  				<span class="storecell"> &nbsp; </span> <!-- CSS Blank Cell -->
  				<span class="storecell"> &nbsp; </span> <!-- CSS Blank Cell -->
  				<span class="storecell"> &nbsp; </span> <!-- CSS Blank Cell -->
  				<span class="storecell"> &nbsp; </span> <!-- CSS Blank Cell -->
  				<span class="storecell"> &nbsp; </span> <!-- CSS Blank Cell -->
  				<span class="storecell"><a href="greatmoodsMall.php?group=<?php echo $_GET['group']; ?>#!/~/category/id=8481172&offset=0&sort=priceDesc">Men's Apparel</a></span> <!-- CSS Cell -->
  				<span class="storecell"><a href="greatmoodsMall.php?group=<?php echo $_GET['group']; ?>#!/~/category/id=8481173&offset=0&sort=priceDesc">Women's Apparel</a></span> <!-- CSS Cell -->
  				
  			</div>
  			<div class="storerow"> 
  				<span class="storecell"> &nbsp; </span> <!-- CSS Blank Cell -->
  				<span class="storecell"><a href="greatmoodsMall.php?group=<?php echo $_GET['group']; ?>#!/~/category/id=8481175&offset=0&sort=priceDesc">Bags & Accessories</a></span> <!-- CSS Cell -->
  				<span class="storecell"> &nbsp; </span> <!-- CSS Blank Cell -->
  				<span class="storecell"> &nbsp; </span> <!-- CSS Blank Cell -->
  				<span class="storecell"> &nbsp; </span> <!-- CSS Blank Cell -->
  				<span class="storecell"> &nbsp; </span> <!-- CSS Blank Cell -->
  				<span class="storecell"> &nbsp; </span> <!-- CSS Blank Cell -->
  				<span class="storecell"> &nbsp; </span> <!-- CSS Blank Cell -->
  				<span class="storecell"><a href="greatmoodsMall.php?group=<?php echo $_GET['group']; ?>#!/~/category/id=8481174&offset=0&sort=priceDesc">Youth Apparel</a></span> <!-- CSS Cell -->
  			</div><!-- CSS Row -->
  		</div>
  	</div>
  <div>&nbsp;</div> <!-- white space -->
</div>  <!--end content-->
  
  <div class="clearfloat">  </div>
  <?php include 'footer.php' ; ?>
</div> <!--end container-->
</body>
</html>
<?php
   ob_end_flush();
?>