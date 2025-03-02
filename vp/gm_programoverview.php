<?php
    include '../includes/autoload.php';
    if(!isset($_SESSION['authenticated']) || $_SESSION['role'] != "VP")
       {
            header('Location: ../index.php');
            exit;
       }
       if($_SESSION['freeze'] == "TRUE")
       {
          // echo "Account Frozen";
           header('Location: accountEdit.php');
       }
   
   $userID = $_SESSION['userId'];
   $query = "SELECT * FROM user_info WHERE userInfoID='$userID' and role='VP'";
   $result = mysqli_query($link, $query)or die ("couldn't execute query.".mysqli_error($link));
   $row = mysqli_fetch_assoc($result);
   $pic = $row['picPath'];

?>
<!DOCTYPE html>
<head>
	<title>GreatMoods | VP</title>
</head>

<body>
<div id="container">
      <?php include 'header.inc.php' ; ?>
      <?php include 'sidenav.php' ; ?>
  
  <div id="content">
    	<div class="presentation">
		<div id="slider">
			<div><img src="../images/presentation/gm_presentation6-1.jpg" alt="slide 1"></div>
			<div><img src="../images/presentation/gm_presentation6-2.jpg" alt="slide 2"></div>
			<div><img src="../images/presentation/gm_presentation6-3.jpg" alt="slide 3"></div>
			<div><img src="../images/presentation/gm_presentation6-4.jpg" alt="slide 4"></div>
			<div><img src="../images/presentation/gm_presentation6-5.jpg" alt="slide 5"></div>
			<div><img src="../images/presentation/gm_presentation6-6.jpg" alt="slide 6"></div>
			<div><img src="../images/presentation/gm_presentation6-7.jpg" alt="slide 7"></div>
			<div><img src="../images/presentation/gm_presentation6-8.jpg" alt="slide 8"></div>
			<div><img src="../images/presentation/gm_presentation6-9.jpg" alt="slide 9"></div>
			<div><img src="../images/presentation/gm_presentation6-10.jpg" alt="slide 10"></div>
			<div><img src="../images/presentation/gm_presentation6-11.jpg" alt="slide 11"></div>
			<div><img src="../images/presentation/gm_presentation6-12.jpg" alt="slide 12"></div>
			<div><img src="../images/presentation/gm_presentation6-13.jpg" alt="slide 13"></div>
			<div><img src="../images/presentation/gm_presentation6-14.jpg" alt="slide 14"></div>
			<div><img src="../images/presentation/gm_presentation6-15.jpg" alt="slide 15"></div>
			<div><img src="../images/presentation/gm_presentation6-16.jpg" alt="slide 16"></div>
			<div><img src="../images/presentation/gm_presentation6-17.jpg" alt="slide 17"></div>
			<div><img src="../images/presentation/gm_presentation6-18.jpg" alt="slide 18"></div>
			<div><img src="../images/presentation/gm_presentation6-19.jpg" alt="slide 19"></div>
			<div><img src="../images/presentation/gm_presentation6-20.jpg" alt="slide 20"></div>
			<div><img src="../images/presentation/gm_presentation6-21.jpg" alt="slide 21"></div>
			<div><img src="../images/presentation/gm_presentation6-22.jpg" alt="slide 22"></div>
			<div><img src="../images/presentation/gm_presentation6-23.jpg" alt="slide 23"></div>
			<div><img src="../images/presentation/gm_presentation6-24.jpg" alt="slide 24"></div>
			<div><img src="../images/presentation/gm_presentation6-25.jpg" alt="slide 25"></div>
			<div><img src="../images/presentation/gm_presentation6-26.jpg" alt="slide 26"></div>
			<div><img src="../images/presentation/gm_presentation6-27.jpg" alt="slide 27"></div>
			<div><img src="../images/presentation/gm_presentation6-28.jpg" alt="slide 28"></div>
			<div><img src="../images/presentation/gm_presentation6-29.jpg" alt="slide 29"></div>
			<div><img src="../images/presentation/gm_presentation6-30.jpg" alt="slide 30"></div>
			<div><img src="../images/presentation/gm_presentation6-31.jpg" alt="slide 31"></div>
			<div><img src="../images/presentation/gm_presentation6-32.jpg" alt="slide 32"></div>
			<div><img src="../images/presentation/gm_presentation6-33.jpg" alt="slide 33"></div>
			<div><img src="../images/presentation/gm_presentation6-34.jpg" alt="slide 34"></div>
			<div><img src="../images/presentation/gm_presentation6-35.jpg" alt="slide 35"></div>
		</div> <!-- end slider -->
	</div> <!-- end presentation -->
  </div>  <!--end content-->
  
  <?php include 'footer.php' ; ?>
</div><!--end container-->

</body>

<?php
ob_end_flush();
?>