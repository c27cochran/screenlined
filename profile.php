<?php 
include 'core/init.php';
$general->logged_out_protect();

if(isset($_GET['user']) && empty($_GET['user']) === false) { // Putting everything in this if block.
 
 	$email   = $user['email']; // sanitizing the user inputed data (in the Url)
	if ($users->email_exists($email) === false) { // If the user doesn't exist
		header('Location:index'); // redirect to index page. Alternatively you can show a message or 404 error
		die();
	}else{
		$profile_data 	= array();
		$user_id 		= $users->fetch_info('user_id', 'email', $email); // Getting the user's id from the email in the Url.
		$profile_data	= $users->userdata($user_id);
	} 
	?>
	<!doctype html>
	<html lang="en">
	<head>	
		<meta charset="utf-8">
    	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    	<meta name="description" content="">
    	<meta name="author" content="">
		<script type="text/javascript" src="player/flowplayer-3.2.13.min.js"></script>
		<?php include 'includes/bootstrap.php'; ?>
	 	<title><?php echo $profile_data['first_name']; ?>'s Profile</title>
	</head>
	<body>
	<!-- <span class="background-fade"></span> -->
	<?php include 'includes/menu.php'; ?>
	<div id="wrap">
	<div class="container container-white">
	


      <div class="row marketing">
        <div class="col-sm-4">
          <div id="profile_picture">
 
	    		<?php 
	    			$image = $profile_data['image_location'];
	    			echo "<img src='$image'>";
	    		?>
	    </div>
		</div>

	    <div class="col-sm-8">
			<div class="userProfileHeader">
			  <div>
			    <h1><?php echo $profile_data['first_name']. ' ' .$profile_data['last_name']; ?></h1>
			  </div>

			  <?php

			    	if(!empty($profile_data['video_cover_letter_location'])){?> 
					<div id="video-cover-letter">

			    		<!-- Button trigger modal-->
						<button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
								Video Cover Letter
						</button>
						<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display:none;">
								<div class="modal-dialog">
								<div class="modal-content">
			  					<div class="modal-header">
			    					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			    					<h4 class="modal-title" id="myModalLabel"><?php echo $profile_data['first_name'].' '.$profile_data['last_name'];?></h4>
			  					</div>
			  					<div class="modal-body">
			    					<div id="video-cover-letter-player" style="width:500px;height:320px;margin:20px auto;"></div>
			  					</div>
			  					<div class="modal-footer">
			    					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			  					</div>
							  		</div>
								</div>
						</div>

						<script>
						$f("video-cover-letter-player", "player/flowplayer-3.2.18.swf", {
							plugins: {
			    				rtmp: {
			        				url: "player/flowplayer.rtmp-3.2.11.swf",
			        				// netConnectionUrl: 'rtmp://localhost:1935/hdfvr_play/'
			        				netConnectionUrl: 'rtmp://54.209.139.207:1935/play/'
			    				},

			    				// default controls with the same background color as the page background
			    				controls:  {
			        				backgroundColor: '#254558',
			        				backgroundGradient: 'none',
			        				all:false,
			        				mute:true,
			        				volume:true,
			        				play:true,
			        				pause:true,
			        				stop:true,
			        				height:30,
			        				progressColor: '#6d9e6b',
			        				bufferColor: '#333333',
			        				autoHide: false
			    				},

			    				// time display positioned into upper right corner
			    				time: {
			        				url: "player/flowplayer.controls-3.2.16.swf",
			        				top:0,
			        				backgroundGradient: 'none',
			        				backgroundColor: 'transparent',
			        				buttonColor: '#254558',
			        				all: false,
			        				time: true,
			        				height:40,
			        				right:30,
			        				width:100,
			        				autoHide: false
			    				}
							},
							clip: {
			    				url: "mp4:<?php echo $profile_data['video_cover_letter_location']; ?>",
			    				provider: "rtmp",
			    				scaling: "fit",
			    				autoPlay: false
							},

							// canvas coloring and custom gradient setting
							canvas: {
			    				backgroundColor:'#254558',
			    				backgroundGradient: [0.1, 0]
							}
						});
						</script>
					</div>
					<?php 
			    		} 
			    		?>
			</div><!-- /userProfileHeader -->

			<div class="row">
				<div class="col-xs-6">
			    <div id="personal_info">

			    		<h4>Resume</h4>

			    		<?php

			    			if($profile_data['resume_location'] !== 'resumes/NoResume.pdf'){?> 
			    			<a href="<?php echo $profile_data['resume_location']; ?>" target="_blank">View Resume</a>
			    			<!-- <object data="<?php echo $profile_data['resume_location']; ?>" type="application/pdf" width="100%" height="500px">
							</object> -->

						<?php 
			    			} else {
				    			echo '<p>This applicant has not uploaded a resume.</p>';
				    		}
			    		?>
		 
						<?php 
			    		#Check if user has entered linked in profile link
			    		if(!empty($profile_data['linked_in_profile'])) {

			    			#Format link
			    			if(strstr($profile_data['linked_in_profile'], 'http')) {
			    				$linked_in = $profile_data['linked_in_profile'];
			    			} else {
			    				$linked_in = 'http://'.$profile_data['linked_in_profile'];
			    			}

			    		?>
				    		<!-- <span class="linked_in"></span> -->
				    		<h4>LinkedIn Profile</h4>
				    		<span><a href="<?php echo $linked_in; ?>" target="_blank"><?php echo $profile_data['linked_in_profile']; ?></a></span>
				    		<br>
			    		<?php } 		 
		 
			    		?>

			    		<?php 
			    		#Check if user has entered their location
			    		if(!empty($profile_data['city']) && !empty($profile_data['state'])) { ?>
				    		<h4>Location</h4>
				    		<span><?php echo $profile_data['city']; ?>,&nbsp;<?php echo $profile_data['state']; ?></span>
				    		<br>
			    		<?php } 		 
		 
			    		?>

			    	</div>
		        </div><!-- 6 -->

		        <div class="col-xs-6">
		          <div id="pending-applications">
			    	<h4>Application Status</h4>
			    	<?php 

						$query = $db->prepare("SELECT j.job_title, a.job_id, a.application_status, c.company_name FROM jobs j join applications a on j.job_id = a.job_id join company c on j.company_id = c.company_id where a.user_id = ?");
						$query->bindValue(1, $user_id);
						$query->execute();

							while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
		    					echo '<p>'.$row['job_title'].' at '.$row['company_name'].': <b>'.$row['application_status'].'</b></p>';
							}

							if (!empty($row['job_title'])) { ?>
								<h4>Application Status</h4>
					 <?php }

					?>

			    	</div>	
		        </div><!-- 6 -->
			</div><!-- /row -->
	        
	        <div class="userDescription">	
	    	<?php  

				#Is bio specified?
		    	if(!empty($profile_data['bio'])){
			   	?>
			   	<h4 class="cover-letter">Cover Letter</h4>
			   	<span><?php echo $profile_data['bio']; ?></span>
			<?php 
		   	}

		   		#Are skills specified?
		    	if(!empty($profile_data['skills'])){
			   	?>
			   	<h4 class="skills">Special Skills</h4>
			   	<span><?php echo $profile_data['skills']; ?></span>
			<?php
		   	}

		 	?>
			</div><!-- /userDescription -->
			</div><!-- /col-md-8 -->


      </div>

    </div> <!-- /container -->
</div>

	  <!-- FOOTER -->
      <?php include 'includes/footer.php'; ?>
	</body>
	</html>
	<?php  
}else{
	header('Location: index'); // redirect to index if there is no email in the Url
}
?>