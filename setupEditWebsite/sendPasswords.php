<?php
    session_start(); // session start
    ob_start();
    ini_set('display_errors', '0'); // errors reporting on
    error_reporting(E_ALL); // all errors
    require_once('../includes/functions.php');
    require_once('../includes/connection.inc.php');
    require_once('../includes/imageFunctions.inc.php');
    $link = connectTo();
     if(!isset($_SESSION['authenticated']) || $_SESSION['role'] != "RP")
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
  
     $query = "SELECT * FROM user_info 	WHERE userInfoID='$userID'";
     $result = mysqli_query($link, $query)or die ("couldn't execute query.".mysqli_error($link));
     $row = mysqli_fetch_assoc($result);
     $pic = $row['picPath'];
?>


<!DOCTYPE html>
<head>
	<title>Launch Fundraiser</title> 
</head>
	
<body>
<div id="container">
      <?php include 'header.inc.php' ; ?>
      <?php include 'sideLeftNav.php' ; ?>

      
    <div id="content">
    <br />
     <h3>Send Member Passwords</h3>
       <form action="newEmail.php" method="get" name="" id="">
 		<div class="graybackground50">
 		<select class="" name="groupid" id="groupid" onChange="fetch_select9(this.value);" required>
	        <option value="">Select FR Account</option>
		<?php 
		     $getAccount = "SELECT * FROM Dealers WHERE setuppersonid = '$userID' AND isMainGroup = 0 ORDER BY Dealer";
		     $result = mysqli_query($link, $getAccount)
		     or die("MySQL ERROR om query 1: ".mysqli_error($link));
		     while($row = mysqli_fetch_assoc($result)) {
		  			$dealerName = $row['Dealer'];
		  			echo ' <option value="'.$row['loginid'].'">'.$dealerName.' '.$row[DealerDir].' '.$row[City].' '.$row[State].'</option>	';
	        		}
			?>
			
		</select>
		<div id="recipients">
		<br />
		<b>Members who have not had their password sent will appear here.</b>
		<br />
		<br />
		</div>
	
		<input type="submit" name="submit" value="Send Passwords" />
		<br />
		<br />
		</form>
 		</div>
    	
	
      </div>  <!--end content-->
      
	<?php include 'footer.php' ; ?>
</div> <!--end container-->

</body>
</html>
<pre>
<?php if ($_POST && $mailSent){
	echo htmlentities($message, ENT_COMPAT, 'UTF-8')."\n";
	echo 'Headers: '.htmlentities($headers, ENT_COMPAT, 'UTF-8');
} ?>
</pre>
<?php
   ob_end_flush();
?>