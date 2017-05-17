<?php 
include 'core/init.php';
$general->logged_out_protect();

$name 	= $company['company_name'];

if(isset($_GET['name']) && empty($_GET['name']) === false) { // Putting everything in this if block.
 
 	$username   = htmlentities($_GET['name']); // sanitizing the user inputed data (in the Url)
 	$email 		= $company['company_email'];
	if ($companies->company_email_exists($email) === false) { // If the user doesn't exist
		header('Location:home'); // redirect to index page. Alternatively you can show a message or 404 error
		die();
	}else{
		$profile_data 	= array();
		$user_id 		= $companies->company_fetch_info('company_id', 'company_email', $email); // Getting the user's id from the email in the Url.
		$profile_data	= $companies->companydata($user_id);
	} 
?>
<!DOCTYPE html>
<html class="html">
 <head>

  <meta http-equiv="Content-type" content="text/html;charset=UTF-8"/>
  <meta name="generator" content="7.1.329.244"/>
  <title><?php echo $name . "'s ";?>Profile</title>
  <!-- CSS -->
  <link rel="stylesheet" type="text/css" href="css/site_global.css?417434784"/>
  <link rel="stylesheet" type="text/css" href="css/master_a-master.css?4272584122"/>
  <link rel="stylesheet" type="text/css" href="css/messages.css?4208501187" id="pagesheet"/>
  <!-- Other scripts -->
  <script type="text/javascript">
   document.documentElement.className += ' js';
</script>
   </head>
 <body>

  <div class="clearfix" id="page"><!-- column -->
   <div class="position_content" id="page_position_content">
    <div class="browser_width colelem" id="u945"><!-- group -->
     <div class="clearfix" id="u945_align_to_page">
      <div class="clip_frame grpelem" id="u659"><!-- image -->
       <img class="block" id="u659_img" src="images/logo.png" alt="" width="197" height="35"/>
      </div>

      <ul class="MenuBar clearfix grpelem" id="menuu669"><!-- horizontal box -->
       <li class="MenuItemContainer clearfix grpelem" id="u694"><!-- vertical box -->
        <a class="nonblock nontext MenuItem MenuItemWithSubMenu MuseMenuActive clearfix colelem" id="u695" href="company-profile?name=<?php echo $company['company_username'];?>"><!-- horizontal box --><div class="MenuItemLabel NoWrap clearfix grpelem" id="u696-4"><!-- content --><p>Profile</p></div></a>
       </li>
       <li class="MenuItemContainer clearfix grpelem" id="u739"><!-- vertical box -->
        <a class="nonblock nontext MenuItem MenuItemWithSubMenu clearfix colelem" id="u740" href="job-list"><!-- horizontal box --><div class="MenuItemLabel NoWrap clearfix grpelem" id="u743-4"><!-- content --><p>Applicants</p></div></a>
       </li>
       <li class="MenuItemContainer clearfix grpelem" id="u670"><!-- vertical box -->
        <a class="nonblock nontext MenuItem MenuItemWithSubMenu clearfix colelem" id="u673" href="post-job"><!-- horizontal box --><div class="MenuItemLabel NoWrap clearfix grpelem" id="u675-4"><!-- content --><p>Add Job</p></div></a>
       </li>
       <li class="MenuItemContainer clearfix grpelem" id="u711"><!-- vertical box -->
        <a class="nonblock nontext MenuItem MenuItemWithSubMenu clearfix colelem" id="u714" href="logout"><!-- horizontal box --><div class="MenuItemLabel NoWrap clearfix grpelem" id="u717-4"><!-- content --><p>Sign Out</p></div></a>
       </li>
      </ul>
      <div class="clip_frame grpelem" id="u649"><!-- image -->
       <img class="block" id="u649_img" src="images/settings.png" alt="" width="24" height="24"/>
      </div>
     </div>
    </div>
    <div class="browser_width colelem" id="u947"><!-- simple frame -->
    </div>
    <div class="shadow browser_width colelem" id="u944"><!-- simple frame -->
    	<div id="profile_picture">
 
	    		<?php 
	    			$image = $company['logo_location'];
	    			echo "<img src='$image'>";
	    		?>
	    </div>

	    <div id="company_info">
	    	<?php 
 
	    		#Is bio specified?
	    		if(!empty($profile_data['company_bio'])){
		    		?>
		    		<h4><strong>Company Bio</strong>: </h4>
		    		<span><?php echo $profile_data['company_bio']; ?></span>
		    		<?php 
	    		}
	    		?>
	    </div>	
    </div>
    <div class="verticalspacer"></div>
   </div>
  </div>
  <!-- JS includes -->
  <script type="text/javascript">
   if (document.location.protocol != 'https:') document.write('\x3Cscript src="http://musecdn.businesscatalyst.com/scripts/4.0/jquery-1.8.3.min.js" type="text/javascript">\x3C/script>');
</script>
  <script type="text/javascript">
   window.jQuery || document.write('\x3Cscript src="scripts/jquery-1.8.3.min.js" type="text/javascript">\x3C/script>');
</script>
  <script src="scripts/museutils.js?117816282" type="text/javascript"></script>
  <script src="scripts/jquery.musemenu.js?32367222" type="text/javascript"></script>
  <script src="scripts/jquery.tobrowserwidth.js?152985095" type="text/javascript"></script>
  <script src="scripts/jquery.watch.js?4199601726" type="text/javascript"></script>
  <!-- Other scripts -->
  <script type="text/javascript">
   $(document).ready(function() { try {
Muse.Utils.transformMarkupToFixBrowserProblemsPreInit();/* body */
$('.browser_width').toBrowserWidth();/* browser width elements */
Muse.Utils.prepHyperlinks(true);/* body */
Muse.Utils.initWidget('.MenuBar', function(elem) { return $(elem).museMenu(); });/* unifiedNavBar */
Muse.Utils.fullPage('#page');/* 100% height page */
Muse.Utils.showWidgetsWhenReady();/* body */
Muse.Utils.transformMarkupToFixBrowserProblems();/* body */
} catch(e) { Muse.Assert.fail('Error calling selector function:' + e); }});
</script>
   </body>
</html>
	<?php  
}else{
	header('Location: company-home'); // redirect to index if there is no email in the Url
}
?>
