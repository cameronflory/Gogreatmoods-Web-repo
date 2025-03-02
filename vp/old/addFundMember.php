<?php
   session_start();
   ob_start();
  if(!isset($_SESSION['authenticated']))
       {
            header('Location: ../index.php');
            exit;
       }
   include('../samplewebsites/imageFunctions.inc.php');
   include('../includes/connection.inc.php');
   $link = connectTo();
   $userID = $_SESSION['userId'];
   $query = "SELECT * FROM user_info WHERE userInfoID='$userID'";
   $result = mysqli_query($link, $query)or die ("couldn't execute query.".mysql_error());
   $row = mysqli_fetch_assoc($result);
     if(isset($_POST['submit']))
      {
          $message = '';
          $table1 = "user_info";
          $table2 = "users";
          $table3 = "Dealers";
          $table4 = "orgMembers";
          $salt = time();
          $bannerx = $_SESSION['banner'];
          $group = $_SESSION['groupid'];
          $rep = $_SESSION['userId'];

      function isUniqueEmail($link, $table1, $emails) 
      {
          $query = "SELECT * FROM $table1 WHERE email='$emails'";
	  $result = mysqli_query($link, $query);
	  if(mysqli_num_rows($result) >= 1) 
	  {
               $message .= "We're sorry, that email address is already being used, please use another one. <br />";
	       return false;
	  } 
	  else 
	  {
               return true;
	  }
      }
      
       function process_image($name, $id, $tmpPic, $baseDirPath){

		$cleanedPic = checkName($_FILES["$name"]["name"]);	
		if(!is_image($tmpPic)) {
    			// is not an image
    			$upload_msg .= $cleanedPic . " is not an image file. <br />";
    		} else {
    			if($_FILES['$name']['error'] > 0) {
				$upload_msg .= $_FILES['$name']['error'] . "<br />";
			} else {
				
				if (file_exists($baseDirPath.$id."/".$cleanedPic)){
					$imagePath = "images/dealers/".$id."/".$cleanedPic;
				} else {
					$picDirectory = $baseDirPath;
					
					
					if (!is_dir($picDirectory.$id)){
						mkdir($picDirectory.$id);
						
					}
					$picDirectory = $picDirectory.$id."/";
					move_uploaded_file($tmpPic, $picDirectory . $cleanedPic);
					$upload_msg .= "$cleanedPic uploaded.<br />";
					$imagePath = "images/dealers/".$id."/".$cleanedPic;
					
					
				}// end third inner else
				return $imagePath;
			} // end first inner else
		      } // end else
	     }// end process_image
          //get form data
          $tt = mysqli_real_escape_string($link, $_POST['title']);
          $setup = mysqli_real_escape_string($link, $_POST['groupid']);
          $repID = mysqli_real_escape_string($link, $_POST['rpid']);
          $scID = mysqli_real_escape_string($link, $_POST['scid']);
          $gd = mysqli_real_escape_string($link, $_POST['gender']);
          $fname = mysqli_real_escape_string($link, $_POST['fname']);
          $mname = mysqli_real_escape_string($link, $_POST['mname']);
          $lname = mysqli_real_escape_string($link, $_POST['lname']);
          $ad1 = mysqli_real_escape_string($link, $_POST['ad1']);
          $ad2 = mysqli_real_escape_string($link, $_POST['ad2']);
          $city = mysqli_real_escape_string($link, $_POST['city']);
          $state = mysqli_real_escape_string($link, $_POST['state']);
          $zip = mysqli_real_escape_string($link, $_POST['zip']);
          $phn = mysqli_real_escape_string($link, $_POST['phone']);
          $ext = mysqli_real_escape_string($link, $_POST['ext']);
          $email = mysqli_real_escape_string($link, $_POST['email']);
          $pass = mysqli_real_escape_string($link, $_POST['password']);
          $face = mysqli_real_escape_string($link, $_POST['fb']);
          $twt = mysqli_real_escape_string($link, $_POST['tw']);
          $imageDirPath = $_SERVER['DOCUMENT_ROOT'].'/images/dealers/';
          $memberPhoto = $_FILES['uploaded_file']['tmp_name'];
	  $memberPhotoPath = "";
	  $loginPass = sha1($pass.$salt); 	// encrypt the password and salt with SHA1
	  $landingPage = "fundMember/memberHome.php";
	  $role = "Member";
	  $ssn = "";
	  
	  
	  
	  //get the group info
	  $group_query = "SELECT * FROM Dealers WHERE loginid='$setup'";
	  $g_result = mysqli_query($link, $group_query)or die ("couldn't execute query group query.".mysql_error());
	  $group_row = mysqli_fetch_assoc($g_result);
	  
	  $dealer = $group_row['Dealer'];
	  $dealerdir = $group_row['DealerDir'];
	  $about = $group_row['About']; 
	  $reason = $group_row['FundraiserReasons'];
	  $goal = $group_row['FundraiserGoal']; 
	  $start = $group_row['FundraiserStartDate']; 
	  $endz = $group_row['FundraiserEndDate']; 
	  $phone = $group_row['Phone']; 
	  $address1 = $group_row['Address1']; 
	  $address2 = $group_row['Address2']; 
	  $ct = $group_row['City'];
	  $st = $group_row['State'];
	  $zp = $group_row['Zip'];
	  $signupType = $group_row['signuptype'];
	  $orgType = $group_row['orgtype'];
	  $payMail = $group_row['PaypalEmail'];
	  $banner = $group_row['banner_path'];
	  $leaderPic = $group_row['leader_pic'];
	  $locationPic = $group_row['location_pic'];
	  $groupPic = $group_row['group_team_pic'];
	  $url = $group_row['website'];
	  $clubType = $group_row['clubType'];
	  //$repID = $group_row['setuppersonid'];
	  $com = 0.35;
	  $user_page = "../membersite.php?group=";
	 
	    //if the email does not exist in DB accept form data and insert into users, user_info, Dealers
	    if(isUniqueEmail($link, $table1, $email)) {
		$query1 = "INSERT INTO $table2 (username, password, Security, landingPage, salt, created, lastLogin, role)";
		$query1 .= "VALUES('$email','$loginPass','1','$landingPage','$salt', now(), now(), '$role')";
		
		$query2 = "INSERT INTO $table1 (companyName, FName, LName, ssn, address1, address2, city, state, zip, email, homePhone, fbPage, twitter, salesPerson, workPhone, userPaypal, role, userBaseCommPct, title, gender)";
		$query2 .= " VALUES('$dealer','$fname','$lname','$ssn','$ad1','$ad2','$city','$state','$zip','$email','$phn','$face','$twt', '$setup','$phn',  '$payMail','$role', '$com', '$tt', '$gd')";
		
        $query3 = "INSERT INTO $table3 (Dealer, DealerDir, About, FundraiserReasons, FundraiserGoal, FundraiserStartDate, FundraiserEndDate, Address1, Address2, City, State, Zip, PaypalEmail, Banner, setuppersonid, setuppersonid2, signuptype, orgtype, email, website, facebook, twitter, leader_pic, location_pic,  group_team_pic, userName, banner_path, firstPass, clubType)";
		$query3 .= " VALUES('$dealer','$dealerdir','$about','$reason','$goal','$start','$endz', '$address1', '$address2', '$ct','$st','$zp','$payMail','$banner','$setup','$repID', '$signupType', '$orgType', '$email','$url','$face', '$twt','$leaderPic', '$locationPic', '$groupPic', '$email','$banner','$pass', '$clubType')";


		mysqli_query($link, "start transaction;");
		// insert data into users table
		$res1 = mysqli_query($link, $query1)or die ("couldn't execute query 1.".mysql_error($link));
		// insert data into distributors table
		$res2 = mysqli_query($link, $query2)or die ("couldn't execute query 2.".mysql_error($link));
		
		$res3 = mysqli_query($link, $query3)or die ("couldn't execute query 3.".mysql_error($link));
		
		if($res1 && $res2 && $res3){
			mysqli_query($link, "commit;");
			//get insert ID
			$query9 = "SELECT * FROM user_info WHERE email='$email'";
			$res4 = mysqli_query($link, $query9)or die ("couldn't execute query 9.".mysql_error($link));
			$row = mysqli_fetch_assoc($res4);
			$newUserID = $row['userInfoID'];
			
			
			//if they uploaded a photo
			if($memberPhoto != ''){
		    $personalPicPath = process_image('uploaded_file',$newUserID, $memberPhoto, $imageDirPath);
		    if($personalPicPath !=''){
		    $queryx = "UPDATE Dealers SET demo = '$newUserID ', contact_pic=']$personalPicPath' WHERE email = '$email'";      
		       $resultA = mysqli_query($link, $queryx)or die ("couldn't execute query x.".mysql_error($link)); 
		       
			$query10 = "UPDATE $table1 SET 
			bannerPath = '$banner',
			picPath = '$personalPicPath' 
			WHERE userInfoID = '$newUserID'";
			mysqli_query($link, $query10);
						}
						
						
		    }
		        
		        //get Dealer ID of user just inserted
		        $queryL = "SELECT * FROM Dealers WHERE setuppersonid = '$setup' AND email = '$email'";
		        $resultL = mysqli_query($link, $queryL)or die ("couldn't execute query L.".mysql_error($link));
		        $rowL = mysqli_fetch_assoc($resultL);
		        $logID = $rowL['loginid'];
		        
		        //insert into the orgMembers table
		        $queryH = "INSERT INTO orgMembers(Title, orgFName, orgLName, orgEmail, orgPhone,orgRel, fundraiserID, fund_owner_id, repID, scID, vpID)VALUES('$tt', '$fname','$lname','$email','$phn', '$role', '$logID','$setup','$repID', '$scID', '$userID')";
		        $resultH = mysqli_query($link, $queryH)or die ("couldn't execute query h.".mysql_error($link));
		     
		        //everything looks good
			//echo "Your account has been successfuly created.\n\n";
			//newDistributorEmail($email,$FName,$LName,$cellPhone);
    $subject = "Hello ".$fname." ".$lname." You Are Now a Member Of ".$dealer." ".$dealerdir." Fundraiser";
    $message = "Hey ".$fname."!";
    $message .= "<br />";
    $message .= "<br />";
    $message .= "You have a new account and fundraising website at GreatMoods! Check out your site:";
    $message .= "<br />";
    $message .= "<br />";
    $message .= "<a href='http://www.greatmoods.com/membersite.php?group='.$logID.' >Check out your fundraising website here!</a>";
    $message .= "<br />";
    $message .= "<br />";
    $message .= "Login to Manage Your Account";
    $message .= "<br />";
    $message .= "<br />";
    $message .= "User Name: ".$email;
    $message .= "<br />";
    $message .= "<br />";
    $message .= "Password: ".$pass; 
    
    $lower = strtolower($dealer);
    $cleanName = str_replace(' ', '', $lower);
    $from = $cleanName."@greatmoods.com";
    
    $to = $email; 
    $headers = "From: ".$from."\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
    mail($to, $subject, $message, $headers);
    header( 'Location: editMembers.php?group='.$setup );

		} 
	}
	  else
	  {
	     //email adress already exists
	     //find out if that user is already part of this group
	     $checkMember = "SELECT * FROM orgMembers WHERE fund_owner_id = '$group' AND orgEmail = '$email'";
	     $checkResult = mysqli_query($link, $checkMember)or die ("Couldn't execute query check member.".mysql_error($link));
	     
	     if(mysqli_num_rows($checkResult) > 0)
	     {
	        echo "This user already exists in this group.";
	        echo "User Cannot be added.";
	        exit;
	     }
	     else
	     {
	     $get_user = "SELECT * FROM user_info WHERE email='$email'";
	     $user_result = mysqli_query($link, $get_user);
	     $userRow = mysqli_fetch_assoc($user_result)or die ("couldn't execute query Get User.".mysql_error($link));
	     $foundUser = $userRow['userInfoID'];
	     
	      $query15 =  "INSERT INTO $table3 (Dealer, DealerDir, About, FundraiserReasons, FundraiserGoal, FundraiserStartDate, FundraiserEndDate, Address1, Address2, City, State, Zip, PaypalEmail, Banner, setuppersonid, setuppersonid2, signuptype, orgtype, demo, email, website, facebook, twitter, leader_pic, location_pic,  group_team_pic, userName, banner_path, firstPass, clubType)";
		$query15 .= " VALUES('$dealer','$dealerdir','$about','$reason','$goal','$start','$endz', '$address1', '$address2', '$ct','$st','$zp','$payMail','$banner','$setup','$repID', '$signupType', '$orgType', '$foundUser', '$email','$url','$face', '$twt','$leaderPic', '$locationPic', '$groupPic', '$email','$banner','$pass', '$clubType')";
	     $res15 = mysqli_query($link, $query15)or die ("couldn't execute query 15x.".mysql_error($link));
	     
	       //get Dealer ID of user just inserted
		        $queryL = "SELECT * FROM Dealers WHERE setuppersonid = '$setup' AND email = '$email'";
		        $resultL = mysqli_query($link, $queryL)or die ("couldn't execute query Lx.".mysql_error($link));
		        $rowL = mysqli_fetch_assoc($resultL);
		        $logID = $rowL['loginid'];
		         
		        
		        //insert into the orgMembers table
		        $queryH = "INSERT INTO orgMembers(Title,orgFName, orgLName, orgEmail, orgPhone,orgRel, fundraiserID, fund_owner_id, repID, scID, vpID)VALUES('$tt', '$fname','$lname','$email','$phn', '$role', '$logID','$setup', '$repID', '$scID', '$userID')";
		        $resultH = mysqli_query($link, $queryH)or die ("couldn't execute query hx.".mysql_error());
		        
		        //if they uploaded a photo
			if($memberPhoto !== ''){
		    $personalPicPath = process_image('uploaded_file', $foundUser, $memberPhoto, $imageDirPath);
		    if($personalPicPath !=''){
		    $queryx = "UPDATE Dealers SET  contact_pic='$personalPicPath' WHERE email = '$email'"; 
		    $resultA = mysqli_query($link, $queryx)or die ("couldn't execute query x.".mysql_error($link));      
		     }
		     }
		        

	     
	  }              
	  
    $subject = "Hello ".$fname." ".$lname." You Are Now a Member Of ".$dealer." ".$dealerdir." Fundraiser";
    $message = "Hey ".$fname."!";
    $message .= "<br />";
    $message .= "<br />";
    $message .= "<a href='http://www.greatmoods.com/membersite.php?group='.$logID.' >Check out your fundraising website here!</a>";
    $message .= "<br />";
    $message .= "<br />";
    //$message .= "http://www.greatmoods.com/membersite.php?group=".$logID;
    $message .= "<br />";
    $message .= "<br />";
    $message .= "Login to Manage Your Account";
    $message .= "<br />";
    $message .= "<br />";
    $message .= "User Name: ".$email;
    $message .= "<br />";
    $message .= "<br />";
    $message .= "Password: ".$pass; 
    
    $lower = strtolower($dealer);
    $cleanName = str_replace(' ', '', $lower);
    $from = $cleanName."@greatmoods.com";
    
    $to = $email; 
    $headers = "From: ".$from."\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
    mail($to, $subject, $message, $headers);
        /*
         if()
         {
           echo "sent";
         }
         else
         {
           echo "failed";
         }
         */
          
                         //everything looks good
			//echo "Your account has been successfuly created.\n\n";
			//newDistributorEmail($email,$FName,$LName,$cellPhone);
			 header( 'Location: editMembers.php?group='.$setup  );
      }//end check user
	    
     }// end if(isset($_POST['submit']))
     
   $pic = $row['picPath'];
   $group = $_GET['group'];
   $type = $_POST['RadioGroup1'];
   $fundtype = $_POST['fundtype'];
   $bob = 24503;
   
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
          <h1>Add Fundraiser Member</h1>
          <h3></h3>
		
		<form class="" action="addFundMember.php" method="Post">
			<div class="table">
				<!--<h3>--Option 1: Add One Member--</h3>-->
				<div class="row">
					<span id="hd_sc4">Sales Coordinator:</span>
					<span id="hd_rp4">Representive:</span>
					<span id="hd_gmfr4">Fundraiser Account:</span>
				</div> <!-- end row -->
					
				<div class="row">
					<select class="role4" name="scid" onChange="fetch_select2(this.value);" required>
						<option>Select Sales Coordinator</option>
						<option value="<?  echo $bob;?>">GreatMoods Coordinator</option>
						<?
						$sql = "SELECT * FROM distributors WHERE vpID = '$userID' AND role = 'SC'";
						$result2 = mysqli_query($link, $sql)or die ("couldn't execute query distrubutors.".mysql_error($link));
					
						while($row2 = mysqli_fetch_assoc($result2))
						{
					           echo '<option value="'.$row2[loginid].'">'.$row2['FName'].' '.$row2[LName].'</option>';
					        }
					        ?>
					</select>
			      		<select class="role4" name="rpid" id="rpid" onChange="fetch_select3(this.value);" required>
			      			<option>Select</option>	
			      		</select>
					<select class="role4" name="groupid" id="groupid" required>
						<option>Select</option>	
					</select>
				</div> <!-- end row -->
				
				<div class="simpleTabs">
					<!--<ul class="simpleTabsNavigation">
						<li><a href="#">Information</a></li>
						<li><a href="#">Account Login</a></li>
						<li><a href="#">Social Media</a></li>
						<li><a href="#">Profile Photo</a></li>
					</ul>-->
					
					<div class="interim-form">
						<div class="interim-header"><h2>Member Contact Information</h2></div> <!-- group based off selected value above -->
				
						<!--<span>Member Title:</span>
						<select name="">
							<option value="">Select Member Title</option>
							<option value="">-depends on group-</option>
							<option value=""></option>
							<option value=""></option>
							<option value=""></option>
						</select>-->
						
						<div class="tablerow"> <!-- titles -->									
							<span id="hd_fname">First</span>
							<!--<span id="hd_mname">Middle</span>-->
							<span id="hd_lname">Last</span>
							<!--<span id="hd_pname" title="Preferred First Name">Preferred</span>-->
							<span id="hd_title">Title</span>
							<span id="hd_title">Gender</span>
						</div> <!-- end row -->
						<div class="tablerow"> <!-- inputs -->
							<input id="fname" type="text" name="fname" required>
							<!--<input id="mname" type="text" name="">-->
							<input id="lname" type="text" name="lname" required>
							<!--<input id="pname" type="text" name="lname">-->
							<select name="title">
								<option value="">---</option>
								<option value="Mr.">Mr.</option>
								<option value="Ms.">Ms.</option>
								<option value="Mrs.">Mrs.</option>
								<option value="Miss">Miss</option>
								<option value="Dr.">Dr.</option>
								<option value="Rev.">Rev.</option>
							</select>
							
							<select id="gender" name="gender">
								<option value="na">Gender</option>
								<option value="Female">Female</option>
								<option value="Male">Male</option>
							</select>
						</div> <!-- end row -->
					
						<table>
							<tr>
								<td id="td_1">
									<div class="tablerow"> <!-- title -->
										<span id="hd_address1">Address 1</span>
									</div> <!-- end row -->
									<div class="tablerow"> <!-- input -->
										<input id="address1" type="text" name="ad1">
									</div> <!-- end row -->
									
									<div class="tablerow"> <!-- title -->
										<span id="hd_address2">Address 2</span>
									</div> <!-- end row -->
									<div class="tablerow"> <!-- input -->
										<input id="address2" type="text" name="ad2">
									</div> <!-- end row -->
													
									<div class="tablerow"> <!-- titles -->
										<span id="hd_city">City</span>
										<span id="hd_state">State</span>
										<span id="hd_zip">Zip</span>
									</div> <!-- end row -->
									<div class="tablerow"> <!-- inputs -->
										<input id="city" type="text" name="city">
										<select id="state" name="state" required>
											<option value="" selected="selected">--</option>
											<option value="AL">AL</option>
											<option value="AK">AK</option>
											<option value="AZ">AZ</option>
											<option value="AR">AR</option>
											<option value="CA">CA</option>
											<option value="CO">CO</option>
											<option value="CT">CT</option>
											<option value="DE">DE</option>
											<option value="DC">DC</option>
											<option value="FL">FL</option>
											<option value="GA">GA</option>
											<option value="HI">HI</option>
											<option value="ID">ID</option>
											<option value="IL">IL</option>
											<option value="IN">IN</option>
											<option value="IA">IA</option>
											<option value="KS">KS</option>
											<option value="KY">KY</option>
											<option value="LA">LA</option>
											<option value="ME">ME</option>
											<option value="MD">MD</option>
											<option value="MA">MA</option>
											<option value="MI">MI</option>
											<option value="MN">MN</option>
											<option value="MS">MS</option>
											<option value="MO">MO</option>
											<option value="MT">MT</option>
											<option value="NE">NE</option>
											<option value="NV">NV</option>
											<option value="NH">NH</option>
											<option value="NJ">NJ</option>
											<option value="NM">NM</option>
											<option value="NY">NY</option>
											<option value="NC">NC</option>
											<option value="ND">ND</option>
											<option value="OH">OH</option>
											<option value="OK">OK</option>
											<option value="OR">OR</option>
											<option value="PA">PA</option>
											<option value="RI">RI</option>
											<option value="SC">SC</option>
											<option value="SD">SD</option>
											<option value="TN">TN</option>
											<option value="TX">TX</option>
											<option value="UT">UT</option>
											<option value="VT">VT</option>
											<option value="VA">VA</option>
											<option value="WA">WA</option>
											<option value="WV">WV</option>
											<option value="WI">WI</option>
											<option value="WY">WY</option>
										</select>
										<input id="zip" type="text" name="zip" maxlength="5" required>
									</div> <!-- end row -->
								</td>
							
								<td id="td_2">
									<!--<div class="tablerow"> <!-- titles -->
										<!--<span id="hd_mphone">Mobile Phone</span>
									</div> <!-- end row -->
									<!--<div class="tablerow"> <!-- inputs -->
										<!--<input id="mphone1" type="text" name=""><input id="mphone2" type="text" name=""><input id="mphone3" type="text" name="">
										<select id="mcarrier" title="Needed To Receive Texts From Computer">
											<option>Select Carrier</option>
											<option>Verizon</option>
											<option>AT&T</option>
											<option>Sprint</option>
											<option>T-Mobile</option>
											<option>U.S. Cellular</option>
											<option>Other</option>
										</select>
									</div> <!-- end row -->
									<!--<div class="tablerow">
										<span id="hd_hphone">Home Phone</span>
									</div> <!-- end row -->
									<!--<div class="tablerow">
										<input id="phone" type="text" name="phone" ><input id="hphone2" type="text" name=""><input id="hphone3" type="text" name="">
									</div> <!-- end row -->
									<div class="tablerow"> <!-- titles -->
										<span id="hd_wphone">Primary Phone</span>
										<span id="ext">Ext</span>
									</div> <!-- end row -->
									<div class="tablerow">
										<input id="phone" type="text" name="phone" maxlength="14"><!--<input id="wphone2" type="text" name=""><input id="wphone3" type="text" name="">-->
										<input id="ext" type="text" name="ext" maxlength="5">
									</div> <!-- end row -->
								</td>
							</tr>
						</table>
										
						<!--<div class="tablerow"> <!-- titles -->
							<!--<span id="hd_bday">Birthday</span>
							<span id="hd_gender">Gender</span>
						</div> <!-- end row -->
						<!--<div class="tablerow"> <!-- inputs -->
							<!--<select id="month" name="">
								<option value="na">Month</option>
								<option value="1">January</option>
								<option value="2">February</option>
								<option value="3">March</option>
								<option value="4">April</option>
								<option value="5">May</option>
								<option value="6">June</option>
								<option value="7">July</option>
								<option value="8">August</option>
								<option value="9">September</option>
								<option value="10">October</option>
								<option value="11">November</option>
								<option value="12">December</option>
							</select>
							<select id="day" name="">
								<option value="na">Day</option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
								<option value="10">10</option>
								<option value="11">11</option>
								<option value="12">12</option>
								<option value="13">13</option>
								<option value="14">14</option>
								<option value="15">15</option>
								<option value="16">16</option>
								<option value="17">17</option>
								<option value="18">18</option>
								<option value="19">19</option>
								<option value="20">20</option>
								<option value="21">21</option>
								<option value="22">22</option>
								<option value="23">23</option>
								<option value="24">24</option>
								<option value="25">25</option>
								<option value="26">26</option>
								<option value="27">27</option>
								<option value="28">28</option>
								<option value="29">29</option>
								<option value="30">30</option>
								<option value="31">31</option>
							</select>
							<select id="year" name="">
								<option value="na">Year</option>
								<option value="2014">2014</option>
								<option value="2013">2013</option>
								<option value="2012">2012</option>
								<option value="2011">2011</option>
								<option value="2010">2010</option>
								<option value="2009">2009</option>
								<option value="2008">2008</option>
								<option value="2007">2007</option>
								<option value="2006">2006</option>
								<option value="2005">2005</option>
								<option value="2004">2004</option>
								<option value="2003">2003</option>
								<option value="2002">2002</option>
								<option value="2001">2001</option>
								<option value="2000">2000</option>
								<option value="1999">1999</option>
								<option value="1998">1998</option>
								<option value="1997">1997</option>
								<option value="1996">1996</option>
								<option value="1995">1995</option>
								<option value="1994">1994</option>
								<option value="1993">1993</option>
								<option value="1992">1992</option>
								<option value="1991">1991</option>
								<option value="1990">1990</option>
								<option value="1989">1989</option>
								<option value="1988">1988</option>
								<option value="1987">1987</option>
								<option value="1986">1986</option>
								<option value="1985">1985</option>
								<option value="1984">1984</option>
								<option value="1983">1983</option>
								<option value="1982">1982</option>
								<option value="1981">1981</option>
								<option value="1980">1980</option>
								<option value="1979">1979</option>
								<option value="1978">1978</option>
								<option value="1977">1977</option>
								<option value="1976">1976</option>
								<option value="1975">1975</option>
								<option value="1974">1974</option>
								<option value="1973">1973</option>
								<option value="1972">1972</option>
								<option value="1971">1971</option>
								<option value="1970">1970</option>
								<option value="1969">1969</option>
								<option value="1968">1968</option>
								<option value="1967">1967</option>
								<option value="1966">1966</option>
								<option value="1965">1965</option>
								<option value="1964">1964</option>
								<option value="1963">1963</option>
								<option value="1962">1962</option>
								<option value="1961">1961</option>
								<option value="1960">1960</option>
								<option value="1959">1959</option>
								<option value="1958">1958</option>
								<option value="1957">1957</option>
								<option value="1956">1956</option>
								<option value="1955">1955</option>
								<option value="1954">1954</option>
								<option value="1953">1953</option>
								<option value="1952">1952</option>
								<option value="1951">1951</option>
								<option value="1950">1950</option>
								<option value="1949">1949</option>
								<option value="1948">1948</option>
								<option value="1947">1947</option>
								<option value="1946">1946</option>
								<option value="1945">1945</option>
								<option value="1944">1944</option>
								<option value="1943">1943</option>
								<option value="1942">1942</option>
								<option value="1941">1941</option>
								<option value="1940">1940</option>
								<option value="1939">1939</option>
								<option value="1938">1938</option>
								<option value="1937">1937</option>
								<option value="1936">1936</option>
								<option value="1935">1935</option>
								<option value="1934">1934</option>
								<option value="1933">1933</option>
								<option value="1932">1932</option>
								<option value="1931">1931</option>
								<option value="1930">1930</option>
								<option value="1929">1929</option>
								<option value="1928">1928</option>
								<option value="1927">1927</option>
								<option value="1926">1926</option>
								<option value="1925">1925</option>
								<option value="1924">1924</option>
								<option value="1923">1923</option>
								<option value="1922">1922</option>
								<option value="1921">1921</option>
								<option value="1920">1920</option>
								<option value="1919">1919</option>
								<option value="1918">1918</option>
								<option value="1917">1917</option>
								<option value="1916">1916</option>
								<option value="1915">1915</option>
								<option value="1914">1914</option>
							</select>
							<select id="gender">
								<option value="na">Gender</option>
								<option value="female">Female</option>
								<option value="Male">Male</option>
							</select>
						</div> <!-- end row -->	
					</div> <!-- end  -->
					
					<div class="interim-form">
						<div class="interim-header"><h2>Account Login</h2></div>
						<div id="row"> <!-- titles -->
							<span id="hd_loginemail">Email Address</span>
						</div> <!-- end row -->
						<div id="row"> <!-- inputs -->
							<input id="email" type="email" name="email" value="" required>
						</div> <!-- end row -->
						
						<div id="row"> <!-- titles -->
						<span id="hd_password">Password</span>
						<span id="hd_cpassword">Confirm Password</span>
						</div> <!-- end row -->
						<div id="row"> <!-- inputs -->
							<input id="password" type="password" name="password" value="" required>
							<input id="cpassword" type="password" name="cpassword" value="" required>
						</div> <!-- end row -->
					</div> <!-- end  -->
					
					<div class="interim-form">
						<div class="interim-header"><h2>Social Media Connections</h2></div>
						<div id="row"> 
							<span id="hd_fb">Facebook</span>
							<input id="fb" type="text" name="fb" value="www.facebook.com">
						</div> <!-- end row -->
						<br>
						<div id="row"> 
							<span id="hd_tw">Twitter</span>
							<input id="tw" type="text" name="tw" value="www.twitter.com">
						</div> <!-- end row -->
						<br>
						<div id="row"> 
							<span id="hd_li">LinkedIn</span>
							<input id="li" type="text" name="li" value="www.linkedin.com">
						</div> <!-- end row -->
						<!--<div id="row"> 
							<span id="hd_pn">Pinterest</span>
							<input id="pn" type="text" name="" value="www.pinterest.com">
						</div> <!-- end row -->
						<!--<div id="row">
							<span id="hd_gp">Google+</span>
							<input id="gp" type="text" name="" value="plus.google.com">
						</div> <!-- end row -->
					</div> <!-- end  -->
					
					<div class="interim-form"> <!-- profile pic tab5 -->
						<div class="interim-header"><h2>Profile Photo</h2></div>
						<div class="tablerow"> 
							<span id="">Upload Profile Photo:</span>
							<input type="file" id="" name="uploaded_file">
							
							<br><br>
							
							
						</div> <!-- end row -->
					</div> <!-- end tab5 content (profile pic) -->
				</div> <!-- end simple tabs -->
			
				<div class="tablerow">
					<input type="submit" name="submit" class="redbutton" value="Save & Exit">
					<!--<input type="submit" class="redbutton" value="Save & Add Another">-->
				</div> <!-- end row -->
			</form>
			
			<!--<br>
			
			<form class="graybackground">
				<h3>--Option 2: Add Multiple Members--</h3>
				<h2>How To Add Multiple Members</h2><br>
				<ol>
					<li><a href="">Download</a> Our Member Setup Spreadsheet</li>
					<li>Input the Data for Each Member You want to Add</li>
					<li>Upload the Completed Spreadsheet...</li>
				</ol>
				<input type="file" name="">
				<input class="redbutton" type="submit" name="" value="Upload File">
			</form>-->
		</div> <!-- end table -->
		<br>

  </div> <!--end content -->
  
      <?php include 'footer.php' ; ?>   
</div> <!--end container-->

</body>
</html>

<?php
   ob_end_flush();
?>