<div class="row-fluid">    
    <div class="col-md-3 col-lg-2">
     
        <div class="profile-block"><!--START PROFILE BLOCK -->
            <div class="panel text-center"><!-- START profile block PANEL -->
                <div class="user-heading">  <!--START profile block user HEADING -->                        
    
                    <!-- hidden icons shows on xs sm viewports | social btns show on small only to avoid clutter -->
                    <a href="#" class="pull-right hidden-md hidden-lg" id="accountIconSidebarHeader" role="button" data-toggle="modal" data-target="#login-modal"><i data-toggle="tooltip" data-placement="left" title="Account" class="hidden-lg fa fa-user-circle fa-3x" aria-hidden="true"></i></a>
                    <div id="social-btns-sm" class="center-block"><!-- visible social icons inside user-heading at sm view -->
                        <a target="_blank" href="<? echo $face; ?>" class="hidden-xs hidden-md hidden-lg" role="button"><i id="fbicon" class="white fa fa-facebook-square fa-4x" title="Facebook" style="padding-right:10px;"></i></a>
                        <a target="_blank" href="<? echo $twit; ?>" class="hidden-xs hidden-md hidden-lg" role="button"><i id="twittericon" class="white fa fa-twitter-square fa-4x" title="Twitter" style="padding-right:10px;"></i></a>
                        <a href="salesContact.php?group=<? echo $_SESSION['groupid'];?>" class="hidden-xs hidden-md hidden-lg" role="button"><i id="emailicon" class="white fa fa-envelope-square fa-4x" title="Email" ></i></a>
                    </div>
                        
                    
                    <img src="../<?php echo $myPic;?>" class="img-rounded img-responsive center-block profileimgcrop" alt="Profile Pics"/>
                  	<h1><? 
                  	   if(!isset($_SESSION['authenticated']))
                            {
                               echo $fn.' '.$ln; 
                            }
                          else
                          {
                               echo $_SESSION['firstName'].' '.$_SESSION['lastname']; 
                          }
                  
                  	 ?></h1>
                  	<h2><? 
                  	   if(!isset($_SESSION['authenticated']))
                            {
                               echo $club_type; 
                            }
                          else
                          {
                               echo $_SESSION['club']; 
                          }
                  
                  	 ?></h2>

                    	<h3>My Goal:<span style="margin-left: -16px;">$<?php echo $goal; ?><span></h3>
                    	<h3>Raised So Far:<span>$<?php echo $so_far; ?></span></h3>
                </div> <!--END profile block user heading -->
                
                
                <!--START social-btns list block | NON collapsible -->
                <div id="social-btns" class="hidden-sm">
                    <a target="_blank" href="<? echo $face; ?>"> <i id="fbicon" class="fa fa-facebook-square fa-3x" title="Facebook"></i> </a>
                    <a target="_blank" href="<? echo $twit; ?>"> <i id="twittericon" class="fa fa-twitter-square fa-3x" title="Twitter"></i> </a>
                    <a href="salesContact.php?group=<? echo $_SESSION['groupid'];?>"><i id="emailicon" class="fa fa-envelope-square fa-3x" title="Email"></i></a>
                    <!--<a href="#" target="_blank"><i id="liicon" class="fa fa-linkedin-square" title="LinkedIn"></i></a>
                    <a href="#" target="_blank"><i id="pnicon" class="fa fa-pinterest-square" title="Pinterest"></i></a>
                    <a href="#" target="_blank"><i id="gpicon" class="fa fa-google-plus-square" title="Google+"></i></a>-->
                </div> <!--END social-btns list block | NON collapsible -->


                <!-- START MY ACCOUNTS | 1st Collapsible -->
                <div id="myAccounts-sideNav" class="sidenavList nav nav-pills nav-stacked"> 
                    <li class="sidenavTitle" data-target="#sidenavSectionAccounts" data-toggle="collapse"> <!-- title for sidenavSection lists - when clicked, toggles collapse for sidenavSection list items -->
                        <h4><a href="#/">My Accounts<span class="fa fa-chevron-up darkredText"></span><span class="hidden fa fa-chevron-down redText"></span></a></h4>
                    </li>
                    
                    <ul id="sidenavSectionAccounts" class="nav nav-pills nav-stacked collapse in">
                        <div class="accountsBtn center-block">
                                <?
                                getAccounts1($userID);
                                ?>
                        </div><!-- end accountBtn div | red btns listed in profile block -->
                    </ul><!-- end sidebar/nav account btns unordered list -->
                </div> <!-- END sidenav list MY ACCOUNTS -->
                
                
                <!-- START program overview list block | 2nd Collapsible -->
                <div class="sidenavList nav nav-pills nav-stacked">
                    <li class="sidenavTitle" data-target="#sidenavSection2" data-toggle="collapse" aria-expanded="false">
                        <h4><a href="#/">Getting Started <span class="hidden fa fa-chevron-up darkredText"></span><span class="hidden fa fa-chevron-down redText"></span></a></h4>
                    </li>
    
                    <ul id="sidenavSection2" class="nav nav-pills nav-stacked collapse">
                        <li><a href="fundgettingstarted11.php"><i class="fa fa-desktop navicon"></i> GreatMoods Program Overview</a></li>
                        <li><a href="fundgettingstarted14.php?group=<?php echo $_SESSION['groupid']; ?>"><i class="fa fa-list-ul navicon"></i> Fundraiser Setup Steps</a></li>
                        <li><a href="fundgettingstarted1.php?group=<?php echo $_SESSION['groupid']; ?>"><i class="fa fa-smile-o navicon"></i> About GreatMoods</a></li>
                        <li><a href="salesContact.php?group=<?php echo $_SESSION['groupid']; ?>"><i class="fa fa-check navicon"></i>Contact Your Rep!</a></li>
                    </ul><!-- end sidenav section2 list -->
                </div><!-- END getting started list block -->
            
            
              	<!-- START Program Overview- list block | 3rd Collapsible -->
                <div class="sidenavList nav nav-pills nav-stacked">
                    <li class="sidenavTitle" data-target="#sidenavSection3" data-toggle="collapse" aria-expanded="false">
                        <h4><a href="#/">Program Overview <span class="hidden fa fa-chevron-up darkredText"></span><span class="hidden fa fa-chevron-down redText"></span></a></h4>
                    </li>
                        
                    <ul id="sidenavSection3" class="nav nav-pills nav-stacked collapse">
                        <li><a href="gm_mission.php" title=""><i class="fa fa-heart navicon"></i> Mission</a></li>
                        <li><a href="gm_program.php" title=""><i class="fa fa-list-ol navicon"></i> GreatMoods Program</a></li> 
                        <li><a href="gm_getStarted.php" title=""><i class="fa fa-calendar-check-o navicon"></i> Get Started Today!</a></li>
                    </ul><!-- end sidenav  list -->
                </div>  <!-- END program overview list block -->
              	 
    
          	 
    
    
              	<!-- START Account admin list block | 4th Collapsible -->
                <div class="sidenavList nav nav-pills nav-stacked">
                    <li class="sidenavTitle" data-target="#sidenavSection4" data-toggle="collapse">
                        <h4><a href="#/">Account Administration <span class="fa fa-chevron-up darkredText"></span><span class="hidden fa fa-chevron-down redText"></span></a></h4>
                    </li>
                    
                    <ul id="sidenavSection4" class="nav nav-pills nav-stacked collapse in">
    
        	       		<li><a href="membersite.php?group=<?php echo $_SESSION['groupid']; ?>"><i class="fa fa-home navicon"></i> My Web Page</a></li>
        	       		<!--<li><a href="membersite.php?group=</? echo $_SESSION['fundid'];?>"><i class="fa fa-home navicon"></i> View My Homepage</a></li>-->
        	            <!-- <li><a href="goalsAchievements.php" title=""><i class="fa fa-calculator navicon"></i> Goals & Achievements</a></li>-->
    	            	<!-- <li><a href="goalsAchievements.php" title=""><i class="fa fa-calculator navicon"></i> Goals & Achievements</a></li>-->
    	             	<li><a href="fundTools.php" title=""><i class="fa fa-wrench navicon"></i> Fundraising Tools</a></li>
    	             	<li><a href="viewReports2.php"><i class="fa fa-dollar navicon"></i> View Reports</a></li>
    	             	<li><a href="emails2.php"><i class="fa fa-envelope navicon"></i> Send Emails</a></li>
    	             	<li><a href="contacts.php" title="Account Home"><i class="fa fa-users navicon"></i> Add/Edit Contacts</a></li>  
    	             	<!--<li><a href="addFriendFamily.php" title=""><i class="fa fa-plus-square navicon"></i> Add Friend & Family</a></li> 
    	             	<li><a href="addBusinessSupporter.php" title=""><i class="fa fa-plus-square navicon"></i> Add Business Supporter</a></li> 
    	             	<li><a href="addBusinessAssociate.php" title=""><i class="fa fa-plus-square navicon"></i> Add Business Associate</a></li> -->
    	             	<li><a href="memberHome.php" title=""><i class="fa fa-pencil navicon"></i> Edit My Account</a></li> 
    	             	<!--<li><a href="myRep.php" title=""><i class="fa fa-pencil navicon"></i> Get Started Today!<br>Contact Your Rep!</a></li> -->
    
        	      	    <!-- <li><a href="memberLogin.php" title="">Login Home</a></li> -->
        	      	</ul><!-- end sidenav section4 list -->
                </div> <!-- END account admin list block -->
                
            </div><!-- end panel text center / profile content for sidebar -->
        </div> <!--end profile block -->
    </div><!--end column -->
</div><!--end row -->