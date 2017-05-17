<?php 
require 'core/init.php';
$general->logged_out_protect();

$company_id = $company['company_id'];

$positions = $jobs->get_jobs($company_id);
$position_count = count($positions);

$applicants    =$users->get_users();
$applicant_count   = count($applicants);


$name   = $company['company_name'];

?>
<!DOCTYPE html>
<html class="html">
 <head>

  <meta http-equiv="Content-type" content="text/html;charset=UTF-8"/>
  <meta name="generator" content="7.1.329.244"/>
  <title><?php echo $name . "'s ";?>Job Postings</title>
  <!-- CSS -->
  <link rel="stylesheet" type="text/css" href="css/site_global.css?417434784"/>
  <link rel="stylesheet" type="text/css" href="css/master_a-master.css?4272584122"/>
  <link rel="stylesheet" type="text/css" href="css/index.css?44838189" id="pagesheet"/>
  <!-- Other scripts -->
  <script type="text/javascript">
   document.documentElement.className += ' js';
</script>
   </head>
 <body>

  <div class="Style clearfix" id="page"><!-- column -->
   <div class="position_content" id="page_position_content">
    <div class="browser_width colelem" id="u945"><!-- group -->
     <div class="clearfix" id="u945_align_to_page">
      <div class="clip_frame grpelem" id="u659"><!-- image -->
       <img class="block" id="u659_img" src="images/logo.png" alt="" width="197" height="35"/>
      </div>
      <?php 
 
	if($general->logged_in()){?>
      <ul class="MenuBar clearfix grpelem" id="menuu669"><!-- horizontal box -->
       <li class="MenuItemContainer clearfix grpelem" id="u694"><!-- vertical box -->
        <a class="nonblock nontext MenuItem MenuItemWithSubMenu clearfix colelem" id="u695" href="company-profile?name=<?php echo $company['company_username'];?>"><!-- horizontal box --><div class="MenuItemLabel NoWrap clearfix grpelem" id="u696-4"><!-- content --><p>Profile</p></div></a>
       </li>
       <li class="MenuItemContainer clearfix grpelem" id="u739"><!-- vertical box -->
        <a class="nonblock nontext MenuItem MenuItemWithSubMenu MuseMenuActive clearfix colelem" id="u740" href="job-list"><!-- horizontal box --><div class="MenuItemLabel NoWrap clearfix grpelem" id="u743-4"><!-- content --><p>Applicants</p></div></a>
       </li>
       <li class="MenuItemContainer clearfix grpelem" id="u670"><!-- vertical box -->
        <a class="nonblock nontext MenuItem MenuItemWithSubMenu clearfix colelem" id="u673" href="post-job"><!-- horizontal box --><div class="MenuItemLabel NoWrap clearfix grpelem" id="u675-4"><!-- content --><p>Add Job</p></div></a>
       </li>
       <li class="MenuItemContainer clearfix grpelem" id="u711"><!-- vertical box -->
        <a class="nonblock nontext MenuItem MenuItemWithSubMenu clearfix colelem" id="u714" href="logout"><!-- horizontal box --><div class="MenuItemLabel NoWrap clearfix grpelem" id="u717-4"><!-- content --><p>Sign Out</p></div></a>
       </li>
       <?php
	}else{?>
      <li><a href="register">Register</a></li>
		<li><a href="login">Login</a></li>
		<li><a href="company-login">Company Login</a></li>
      <?php
	}
	?>
      </ul>
      <div class="clip_frame grpelem" id="u649"><!-- image -->
       <img class="block" id="u649_img" src="images/settings.png" alt="" width="24" height="24"/>
      </div>
     </div>
    </div>
    <div class="browser_width colelem" id="u947"><!-- simple frame --></div>
    <div class="clearfix colelem" id="pu770"><!-- group -->
     <div class="shadow browser_width grpelem" id="u770"><!-- group -->
     	<div id="profile_picture">
 
	    		<?php 
	    			$image = $company['logo_location'];
	    			echo "<img src='$image'>";
	    		?>
	    	</div>
      <div class="clearfix" id="u770_align_to_page">
       <ul class="AccordionWidget clearfix grpelem" id="accordionu772"><!-- vertical box -->
        <li class="AccordionPanel clearfix colelem" id="u788"><!-- vertical box -->
         <div class="AccordionPanelTab clearfix colelem" id="u789-4"><!-- content -->
          <p>Job Postings</p>
         </div>
         <div class="AccordionPanelContent disn clearfix colelem" id="u790"><!-- group -->
          <div class="clearfix grpelem" id="u791-4"><!-- content -->
           <?php 
 
            foreach ($positions as $position) {
              $title = $position['job_title'];
              $description = $position['job_description'];
              $job_id = $position['job_id'];
            ?>
 
              <p><a href="company-jobs?job_id=<?php echo $job_id; ?>"><?php echo $title;?></a></p>
              <?php
            }
 
          ?>
          </div>
         </div>
        </li>
        <li class="AccordionPanel clearfix colelem" id="u784"><!-- vertical box -->
         <div class="AccordionPanelTab clearfix colelem" id="u787-4"><!-- content -->
          <p>Active Applicants</p>
         </div>
         <div class="AccordionPanelContent disn clearfix colelem" id="u785"><!-- group -->
          <div class="clearfix grpelem" id="u786-4"><!-- content -->
           <?php 
 
            foreach ($applicants as $applicant) {
              $user_id = $applicant['user_id'];
              $first_name = $applicant['first_name'];
              $last_name = $applicant['last_name'];
          ?>
 
            <p><a href="applicant-profile?user_id=<?php echo $user_id; ?>"><?php echo $first_name . ' ' . $last_name . '';?></a> joined: <?php echo date('F j, Y', $applicant['time']) ?></p>
          <?php
            }
 
          ?>
          </div>
         </div>
        </li>
       </ul>
      </div>
     </div>
     <div class="sbg clearfix grpelem" id="pu809"><!-- group -->
      <div class="rounded-corners clearfix grpelem" id="u809"><!-- content -->
       <div class="_u809 f3s_top" id="_u809-f3s_top"></div>
       <div class="_u809 f3s_mid clearfix" id="_u809-f3s_mid">
        <div class="position_content clearfix" id="u809position_content">
         <p id="u809-3">Calendar</p>
        </div>
       </div>
       <div class="_u809 f3s_bot" id="_u809-f3s_bot"></div>
      </div>
     </div>
     <div class="sbg clearfix grpelem" id="pu811"><!-- group -->
      <div class="rounded-corners clearfix grpelem" id="u811"><!-- content -->
       <div class="_u811 f3s_top" id="_u811-f3s_top"></div>
       <div class="_u811 f3s_mid clearfix" id="_u811-f3s_mid">
        <div class="position_content clearfix" id="u811position_content">
         <p id="u811-3">Manage</p>
        </div>
       </div>
       <div class="_u811 f3s_bot" id="_u811-f3s_bot"></div>
      </div>
     </div>
     <div class="sbg clearfix grpelem" id="pu813"><!-- group -->
      <div class="rounded-corners clearfix grpelem" id="u813"><!-- content -->
       <div class="_u813 f3s_top" id="_u813-f3s_top"></div>
       <div class="_u813 f3s_mid clearfix" id="_u813-f3s_mid">
        <div class="position_content clearfix" id="u813position_content">
         <p id="u813-3">Invite Applicants</p>
        </div>
       </div>
       <div class="_u813 f3s_bot" id="_u813-f3s_bot"></div>
      </div>
     </div>
    </div>
    <div class="verticalspacer"></div>
   </div>
  </div>
  <div class="preload_images">
   <img class="preload" src="images/u809-r-sprite.png" alt=""/>
   <img class="preload" src="images/u809-m-sprite.png" alt=""/>
   <img class="preload" src="images/u813-r-sprite.png" alt=""/>
   <img class="preload" src="images/u813-m-sprite.png" alt=""/>
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
  <script src="scripts/webpro.js?33264525" type="text/javascript"></script>
  <script src="scripts/musewpdisclosure.js?250538392" type="text/javascript"></script>
  <script src="scripts/jquery.watch.js?4199601726" type="text/javascript"></script>
  <!-- Other scripts -->
  <script type="text/javascript">
   $(document).ready(function() { try {
Muse.Utils.transformMarkupToFixBrowserProblemsPreInit();/* body */
$('.browser_width').toBrowserWidth();/* browser width elements */
Muse.Utils.prepHyperlinks(true);/* body */
Muse.Utils.initWidget('.MenuBar', function(elem) { return $(elem).museMenu(); });/* unifiedNavBar */
Muse.Utils.initWidget('#accordionu772', function(elem) { return new WebPro.Widget.Accordion(elem, {canCloseAll:true,defaultIndex:-1}); });/* #accordionu772 */
Muse.Utils.fullPage('#page');/* 100% height page */
Muse.Utils.showWidgetsWhenReady();/* body */
Muse.Utils.transformMarkupToFixBrowserProblems();/* body */
} catch(e) { Muse.Assert.fail('Error calling selector function:' + e); }});
</script>
<div style="text-align:center;">&copy; Screenlined 2014</div>
   </body>
</html>
