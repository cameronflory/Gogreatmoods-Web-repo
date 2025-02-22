<?php
    session_start();

  if(!isset($_SESSION['authenticated']))
       {
            header('Location: ../index.php');
            exit;
       }
   include('../samplewebsites/imageFunctions.inc.php');
   include('../includes/connection.inc.php');
   include '../includes/functions.php';
   $userID = $_SESSION['userId'];
   $link = connectTo();
   $group = $_SESSION['groupid'];
       
   $user = $_SESSION['userId'];
   $userName = $_SESSION['email'];
   $query1 = "SELECT * FROM Dealers WHERE loginid='$group'";
   $result1 = mysqli_query($link, $query1)or die("MySQL ERROR query 1: ".mysqli_error($link));
   $row1 = mysqli_fetch_assoc($result1);
   $groupPic = $row1['location_pic'];
   $repID = $row1['setuppersonid'];
   $groupName = $row1['Dealer'];
   $club_type = $row1['DealerDir'];
   //$salesTotal = getGroupSales($group);
   $salesGoal = $row1['FundraiserGoal'];
   $banner_path = $row1['banner_path'];
   $fb = $row1['facebook'];
   $tw = $row1['twitter'];
       
?>

<!DOCTYPE html>
<head>
	<title>Add New Leaders</title> 
	<style>
ul.tab {
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
    border: 1px solid #FFF;
    background-color: #cc0000;
}

/* Float the list items side by side */
ul.tab li {float: left;}

/* Style the links inside the list items */
ul.tab li a {
    display: inline-block;
    color: white;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
    transition: 0.3s;
    font-size: 17px;
}

/* Change background color of links on hover */
ul.tab li a:hover {
    background-color: #ddd;
}

/* Create an active/current tablink class */
ul.tab li a:focus, .active {
    background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
    display: none;
    padding: 2px 12px;
    border: 1px solid #ccc;
    border-top: none;
}
.tabcontent{
padding-right:4em;
padding-left:4em;
}
#newLeader{
    margin-top:2em;
}
.form-control{
    margin-bottom:1rem;
}
label{
    margin-top:1rem;
}
.interim-header{
    margin: -2rem 0 -2rem 0;
}
</style>
</head>
	
<body>
      <?php include 'header.php' ; ?>
      <?php include 'fundSidebar.php' ; ?>
	
    <div class="container" id="getStartedContent" >
        <div class="row-fluid">
     <div class=" col-md-7 col-md-push-2" id="newLeaderWrap">
      <ul class="tab">
  <li><a href="javascript:void(0)" class="tablinks" onclick="openCity(event, 'Single')" id="defaultOpen">Add Single Leader</a></li>
  <li><a href="javascript:void(0)" class="tablinks" onclick="openCity(event, 'Multiple')">Upload Multiple Leaders</a></li>
</ul>

    <div id="Single" class="tabcontent">
    
    <div class="page-header col-md-12">
        <h1>Add Fundraiser Leader</h1>
    </div>
        
		<form class="" action="addFundLeader.php" method="Post" id="myForm" name="myForm" onsubmit="return checkForm(this);" enctype="multipart/form-data">
			<div class="table">
				<!--<h3>--Option 1: Add One Leader--</h3>-->
				<div class="row">
						
					</div> <!-- end row -->
					
				<div class="row">
					
				<label for="rpid" id="hd_rp4">Representive:</label>
			    <select class="role4 form-control" name="rpid" id="rpid" onChange="fetch_select6(this.value);" required>
			        <option value="">Select Representative</option>
			        <?
				      		$sql = "SELECT * FROM distributors WHERE setupID = '$userID' AND role = 'RP'";
						$result2 = mysqli_query($link, $sql)or die ("couldn't execute query distrubutors.".mysqli_error($link));
					
						while($row2 = mysqli_fetch_assoc($result2))
						{
				            echo '<option value="'.$row2[loginid].'">'.$row2['FName'].' '.$row2[LName].'</option>';
					    }
					 ?>
				      		
			      		</select>
			      	<label for="groupid" id="hd_gmfr4">Fundraiser Account:</label>
					<select class="role4 form-control" name="groupid" id="groupid" required>
						<option value="">Select Group</option>	
					</select>
							<!--<select class="role4" id="new_select" name="new_select">
							
						</select>-->
					</div> <!-- end row -->
				
					

				<div class="simpleTabs">
					<!--<ul class="simpleTabsNavigation">
						<li><a href="#">Information</a></li>
						<li><a href="#">Account Login</a></li>
						<li><a href="#">Social Media</a></li>
						<li><a href="#">Profile Photo</a></li>
					</ul>-->
					
					<div class="interim-form">
					    <div class="page-header interim-header"><h2>Contact Information</h2></div>
					    </div>
						<div class="row">
							<!--<span>[Group] Leader Type: </span>--> <!-- [Group] = same as the selected group above -->
							<!--<select name="">
								<option value="" selected>Select Leader</option>
								<option value="">-depends on group-</option>
								<option value=""></option>
								<option value=""></option>
								<option value=""></option>
								<option value="">Other/Custom (Specify)</option>--> <!-- If Other/Custom is selected, then display input field below -->
							<!--</select>
							<span>Other/Custom:</span>
							<input id="fltype" type="text" name="" value="">-->
						</div> <!-- end row -->

						<div class="row"> <!-- inputs -->
							<label for="fname" id="hd_fname">First</label>
							<input class="form-control" id="fname" type="text" name="fname" required>
							
							<label for="lname" id="hd_lname">Last</label>
							<input class="form-control" id="lname" type="text" name="lname" required>
							<!--<input id="pname" type="text" name="">-->
						
							<label for="title" id="hd_title">Title</label>
							<select class="form-control" name="title">
								<option value="">---</option>
								<option value="Mr.">Mr.</option>
								<option value="Ms.">Ms.</option>
								<option value="Mrs.">Mrs.</option>
								<option value="Miss">Miss</option>
								<option value="Dr.">Dr.</option>
								<option value="Rev.">Rev.</option>
							</select>
							
							<label for="gender" id="hd_gender">Gender</label>
							<select class="form-control" name="gender">
								<option value="">---</option>
								<option value="Male">Male</option>
								<option value="Female">Female</option>
							</select>
						</div> <!-- end row -->
					
						<table>
							<tr>
								<td id="td_1">
								<div class="row"> <!-- input -->
								    <label for="address1" id="hd_address1">Address 1</label>
									<input class="form-control" id="address1" type="text" name="address1">
									</div> <!-- end row -->
									
									<div class="row"> <!-- input -->
										<label for="address2" id="hd_address2">Address 2</label>
										<input class="form-control" id="address2" type="text" name="address2">
									</div> <!-- end row -->
													
                					<div class="row"> <!-- INFORMATION ROW FOUR -->
                    					<div class="col-md-12 col-lg-5">
                    						<label for="city" id="hd_city">City</label>
                    						<input class="form-control" id="city" type="text" name="city" required>
                    				    </div>
                									
                						<div class="col-md-3">
                							<label for="state" id="hd_state">State</label>
                							<select class="form-control" id="state" name="state" required>
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
                						</div>
                    									
                    					<div class="col-md-4">
                    						<label for="zip" id="hd_zip">Zip</label>
                    						<input class="form-control" id="zip" type="text" name="zip" maxlength="5" required>
                    					</div>
                				    </div> 
                				    
                        			<div class="row">
                        			    <div class="col-md-8">
                        					<label for="phone" id="hd_wphone">Primary Phone</label>
                        					<input class="form-control" id="phone" type="text" name="phone" maxlength="14"><!--<input id="wphone2" type="text" name=""><input id="wphone3" type="text" name="">-->
                        				</div>
                        				
                        			    <div class="col-md-4">
                        					<label for="ext" id="hd_ext">Ext</label>
                        					<input class="form-control" id="ext" type="text" name="ext" maxlength="5">
                        				</div>
                        			</div> 
									
								</td>
							
								<td id="td_2">
									<!--<div class="row"> <!-- titles -->
										<!--<span id="hd_mphone">Mobile Phone</span>
									</div> <!-- end row -->
									<!--<div class="row"> <!-- inputs -->
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
									<!--<div class="row">
										<span id="hd_hphone">Home Phone</span>
									</div> <!-- end row -->
									<!--<div class="row">
										<input id="hphone1" type="text" name=""><input id="hphone2" type="text" name=""><input id="hphone3" type="text" name="">
									</div> <!-- end row -->
									
								</td>
							</tr>
						</table>
										
						<!--<div class="row"> <!-- titles -->
							<!--<span id="hd_bday">Birthday</span>
							<span id="hd_gender">Gender</span>
						</div> <!-- end row -->
						<!--<div class="row"> <!-- inputs -->
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
								<option value="male">Male</option>
							</select>
						</div> <!-- end row -->	
					</div> <!-- end tab 1 -->
					
					<div class="interim-form">
						<div class="interim-header page-header"><h2>Account Login</h2></div>
						<div id="row"> <!-- inputs -->
							<label for="email" id="hd_loginemail">Email Address</label>
							<input class="form-control" id="email" type="text" name="email" value="" required>
						</div> <!-- end row -->
						
						<div id="row"> <!-- inputs -->
    							<label for="pass1" id="hd_password">Password</label>
    							<input class="form-control" id="pass1" type="password" name="password" value="" required>
    							<label for="pass2" id="hd_cpassword">Confirm Password</label>
    							<input class="form-control" id="pass2" type="password" name="cpassword" value="" onkeyup="checkPass(); return false;" required>
    						<span id="error"></span>
						</div> <!-- end row -->
					</div> <!-- end tab 2 -->
					
					<div class="interim-form"><!-- SOCIAL MEDIA FORMS -->
						<div class="interim-header page-header"><h2>Social Media Connections</h2></div>
						<div id="row"> 
							<label for="fb" id="hd_fb">Facebook</label>
							<input class="form-control" id="fb" type="text" name="fb" value="" placeholder="www.facebook.com">
						</div> <!-- end row -->
						<div id="row"> 
							<label for="tw" id="hd_tw">Twitter</label>
							<input class="form-control" id="tw" type="text" name="tw" value="" placeholder="www.twitter.com">
						</div> <!-- end row -->
						<div id="row"> 
							<label for="li" id="hd_li">LinkedIn</label>
							<input class="form-control" id="li" type="text" name="" value="" placeholder="www.linkedin.com">
						</div> <!-- end row -->
						<!--<div id="row"> 
							<span id="hd_pn">Pinterest</span>
							<input id="pn" type="text" name="" value="" placeholder="www.pinterest.com">
						</div> <!-- end row -->
						<!--<div id="row">
							<span id="hd_gp">Google+</span>
							<input id="gp" type="text" name="" value="" placeholder="plus.google.com">
						</div> <!-- end row -->
					</div> <!-- end social media forms -->
					
					<div class="interim-form"> <!-- profile pic  -->
						<div class="interim-header page-header"><h2>Profile Photo</h2></div>
						<div class="row"> 
						<div class="col-md-6 col-md-push-2">
							<label for="uploaded_file" id="">Upload Profile Photo:</label>
							<input class="btn btn-default" type="file" id="" name="uploaded_file">
						</div>	
						</div> <!-- end row -->
					</div> <!-- end tab4 content (profile pic) -->
				</div> <!-- end simple tabs -->
				
					<section class="row" style="margin:4rem 0" id="submitButtonSection-form"><!-- SUBMIT BUTTON SECTION ROW -->
        				<div class="pull-right">
    						<input type="submit" name="submit" class="redbutton" value="Add New Leader">
		        		</div>
				    </section> <!-- end SUBMIT BUTTON SECTION ROW -->
			
				</div> <!-- end row -->
			</div> <!-- end table -->
		</form>
    </div>


<div class="row-fluid">
    <div class=" col-md-7 col-md-push-2" id="newLeaderWrap">
    <div id="Multiple" class="tabcontent">
     <div class="page-header"><h1>Upload Leaders</h1></div>
   
          <form name="import" method="post" action="uploadLeaders.php" enctype="multipart/form-data">
				
				<h3>How To Add Multiple Leaders</h3><br>
				<ol>
					<li><a href="download.php">Download</a> Our Member Setup Spreadsheet</li>
					<li>Input the Data for Each Member You want to Add.</li>
					<li>Enter a 6 character password for each leader.</li>
					<li>Select Fundraiser Account from Drop Down Menu</li>
					<li>Upload the Completed Spreadsheet...</li>
				</ol>
				<br>
			
			<p class="nospace">Label your spreadsheet columns from left to right as follows:</p>
		          <table>
		          	<tr>
			          <th>Title</th>
			          <th>First Name</th>
			          <th>Last Name</th>
			          <th>Phone Number</th>
			          <th>Email Address</th>
			          <th>Password</th>
			          </tr>
		          </table>
          
          		<br>
			
          <div class="table">

				<div class="row">
    				<label for="rpid2" id="hd_rp4">Representive:</label>
    			    <select class="role4 form-control" name="rpid2" id="rpid2" onChange="fetch_select17(this.value);" required>
    			     <option value="">Select Representative</option>
    			     <?
    				      	$sql = "SELECT * FROM distributors WHERE setupID = '$userID' AND role = 'RP'";
    						$result2 = mysqli_query($link, $sql)or die ("couldn't execute query distrubutors.".mysql_error());
    					
    						while($row2 = mysqli_fetch_assoc($result2))
    						{
    				                   echo '<option value="'.$row2[loginid].'">'.$row2['FName'].' '.$row2[LName].'</option>';
    					        }
    				?>
    			     </select>
    			     
    		      	<label for="groupid4" id="hd_gmfr4">Fundraiser Account:</label>
    				<select class="role4 form-control" name="groupid2" id="groupid2" required>
    					<option value="">Select Group</option>	
    				</select>
    							<!--<select class="role4" id="new_select" name="new_select">
    							
    						</select>-->
			    </div> <!-- end row -->
			</div> <!-- end table -->

      
                <label for="file">Upload File</label>
                <input type="file" name="file" required>
            <section class="row" style="margin:4rem 0" id="submitButtonSection-form"><!-- SUBMIT BUTTON SECTION ROW -->
    			<div class="pull-right">  
                    <input type="submit" name="submit" value="Submit" class="redbutton" />
                </div>
            </section> <!-- end SUBMIT BUTTON SECTION ROW -->
</form>

    </div>
</div>
</div>

<script>
function openCity(evt, cityName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
}

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();
</script>

</div> <!--end container-->	<?php include 'footer.php' ; ?>

</body>
</html>
<!--<pre>
<?php if ($_POST && $mailSent){
	echo htmlentities($message, ENT_COMPAT, 'UTF-8')."\n";
	echo 'Headers: '.htmlentities($headers, ENT_COMPAT, 'UTF-8');
} ?>
</pre>-->
<?php
   ob_end_flush();
?>