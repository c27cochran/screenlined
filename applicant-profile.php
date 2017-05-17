<?php 
include 'core/init.php';
$general->company_logged_out_protect();

$company_id = $company['company_id'];
$company_name = $company['company_name'];

if(isset($_GET['user_id']) && empty($_GET['user_id']) === false) { // Putting everything in this if block.
 
 	$user   = htmlentities($_GET['user_id']); // sanitizing the user inputed data (in the Url)
	if ($users->user_profile_exists($user) === false) { // If the user doesn't exist
		header('Location:index'); // redirect to index page. Alternatively you can show a message or 404 error
		die();
	}else{
		$profile_data 	= array();
		$user_id 		= $users->fetch_info('user_id', 'user_id', $user); // Getting the user's id from the email in the Url.
		$profile_data	= $users->userdata($user_id);

	} 

}else{
	header('Location: index'); // redirect to index if there is no email in the Url
}	

if (isset($_POST['comment_submit'])) {

	if(empty($_POST['employee_name'])  || empty($_POST['profile_comment'])) {

		$comment_errors[] = 'All fields are required to comment.';

	}else{
        
        if (empty($_SESSION['employee_name'])) {
        	if (strlen($_POST['employee_name']) <2){
            	$comment_errors[] = 'Please enter your name';
            }
         	else if (strlen($_POST['employee_name']) >50){
            	$comment_errors[] = 'Your name cannot be more than 50 characters long';
        	}
        }
        if (strlen($_POST['profile_comment']) <2) {
            $comment_errors[] = 'Please enter a comment';
        }else if (strlen($_POST['profile_comment']) >1000){
            $comment_errors[] = 'Your comment cannot be more than 1000 characters long';
        }

	}

	if(empty($comment_errors) === true){
		
		if (empty($_SESSION['employee_name'])) {
			$employee_name = $_POST['employee_name'];
		} else {
			$employee_name = $_SESSION['employee_name'];
		}
		
		$comment = $_POST['profile_comment'];
		$profile_opinion = $_POST['profile_opinion'];

		$comments->post_profile_comment($employee_name, $comment, $user_id, $profile_opinion);
		header('Location: applicant-profile?success&user_id='.$user_id.'#comments');
		exit();
	}
}

if (isset($_POST['invite_submit'])) {

	if(empty($_POST['job_invite'])) {

		$invite_errors[] = 'All fields are required.';

	}

	if(empty($invite_errors) === true){
		
		$job_id = $_POST['job_invite'];
		$email = $profile_data['email'];	

		$companies->easy_invite($job_id, $company_id, $email, $company_name);
		header('Location: applicant-profile?invite-success&user_id='.$user_id);
		exit();
	}
}

if (isset($_POST['custom_invite_submit'])) {

	if(empty($_POST['custom_job_invite']) || empty($_POST['custom_message'])) {

		$invite_errors[] = 'All fields are required.';

	}

	if(empty($invite_errors) === true){
		
		$job_id = $_POST['custom_job_invite'];
		$email = $profile_data['email'];
		$custom_message = $_POST['custom_message'];	

		$companies->custom_invite($job_id, $company_id, $email, $company_name, $custom_message);
		header('Location: applicant-profile?custom_invite-success&user_id='.$user_id);
		exit();
	}
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

	<?php include 'includes/company-menu.php'; ?>

	<div id="wrap">
	<div class="container container-white">

      <div class="jumbotron">
      	<h1><?php echo $profile_data['first_name']. ' ' .$profile_data['last_name']; ?></h1>
      </div>
      			<?php
					if (isset($_GET['invite-success']) && empty($_GET['invite-success'])) {
		  				echo '<h3>Thank you. Your invitation has been sent.</h3>';
					}
				?>

				<?php 
					if(empty($invite_errors) === false){
						echo '<p class="errors">' . implode('</p><p class="errors">', $invite_errors) . '</p>';	
					}

				?>
				<?php
					if (isset($_GET['custom_invite-success']) && empty($_GET['custom_invite-success'])) {
		  				echo '<h3>Thank you. Your custom invitation has been sent.</h3>';
					}
				?>

				<?php 
					if(empty($custom_invite_errors) === false){
						echo '<p class="errors">' . implode('</p><p class="errors">', $custom_invite_errors) . '</p>';	
					}

				?>
				<?php 
					if(empty($comment_errors) === false){
						echo '<p class="errors">' . implode('</p><p class="errors">', $comment_errors) . '</p>';	
					}

				?>
	<h3>Your team's responses:</h3>
	<div id="negative-responses">
		<h4>Negative: 

			<?php 

				$query = $db->prepare("SELECT
					(SELECT COUNT(*) FROM video_comments WHERE video_opinion = 'No' and user_id = ?) +
					(SELECT COUNT(*) FROM profile_comments WHERE profile_opinion = 'No' and user_id = ?) AS no");
				$query->bindValue(1, $user);
				$query->bindValue(2, $user);
				$query->execute();

				while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
					echo "<span>" . $row['no'] . "</span>";						
				}				
			?>
		</h4>
	</div>
	<div id="positive-responses">
		<h4>Positive: 

			<?php 

				$query = $db->prepare("SELECT
					(SELECT COUNT(*) FROM video_comments WHERE video_opinion = 'Yes' and user_id = ?) +
					(SELECT COUNT(*) FROM profile_comments WHERE profile_opinion = 'Yes' and user_id = ?) AS yes");
				$query->bindValue(1, $user);
				$query->bindValue(2, $user);
				$query->execute();

				while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
					echo "<span>" . $row['yes'] . "</span>";						
				}				
			?>
		</h4>
	</div>				
	<div class="row marketing">				
      	<div class="col-md-4">
      	<button class="btn btn-primary btn-lg btn-block" data-toggle="modal" data-target="#inviteModal">
  			Send Easy Invitation
		</button>
		<div class="modal fade" id="inviteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display:none;">
  					<div class="modal-dialog">
    					<div class="modal-content">
      					<div class="modal-header">
        					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        					<h4 class="modal-title" id="myModalLabel">Ask <?php echo $profile_data['first_name'].' '.$profile_data['last_name'];?> to apply</h4>
      					</div>
      					<div class="modal-body">
      						<form method="post" action="" class="form-signin" role="form">
        					<label for="job_invite">Position:</label>
      						<select name="job_invite">
      						<?php 

							$query = $db->prepare("SELECT c.company_name, c.company_email, j.job_title, j.job_id FROM company c join jobs j on c.company_id = j.company_id WHERE c.company_id = ?");
							$query->bindValue(1, $company_id);
							$query->execute();

							while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
								echo "<option value='" . $row['job_id'] . "'>" . $row['job_title'] . "</option>";
  										
							}
								
							?>
							</select>	
							<input type="submit" name="invite_submit" class="btn btn-primary btn-lg" value="Send This Easy Invite">
							</form>
      					</div>
      					<div class="modal-footer">
        					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      					</div>
  				  		</div>
  					</div>
				</div>
		</div>

		<div class="col-md-4">
			<button class="btn btn-primary btn-lg btn-block" data-toggle="modal" data-target="#customInviteModal">
  			Send Custom Invitition
		</button>
		<div class="modal fade" id="customInviteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display:none;">
  					<div class="modal-dialog">
    					<div class="modal-content">
      					<div class="modal-header">
        					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        					<h4 class="modal-title" id="myModalLabel">Ask <?php echo $profile_data['first_name'].' '.$profile_data['last_name'];?> to apply</h4>
      					</div>
      					<div class="modal-body">
      						<form method="post" action="" class="form-signin" role="form">
        					<label for="job_invite">Position:</label>
      						<select name="custom_job_invite">
      						<?php 

							$query = $db->prepare("SELECT c.company_name, c.company_email, j.job_title, j.job_id FROM company c join jobs j on c.company_id = j.company_id WHERE c.company_id = ?");
							$query->bindValue(1, $company_id);
							$query->execute();

							while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
								echo "<option value='" . $row['job_id'] . "'>" . $row['job_title'] . "</option>";
  										
							}
								
							?>
							</select>	
							<textarea rows="10" cols="40" type="text" name="custom_message" value="<?php if(isset($_POST['custom_message'])) echo htmlentities($_POST['custom_message']); ?>"></textarea>
							<p>(Link to application will be appened to your message)</p>
							<input type="submit" name="custom_invite_submit" class="btn btn-primary btn-lg btn-block" value="Send Custom Invite">
							</form>
      					</div>
      					<div class="modal-footer">
        					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      					</div>
  				  		</div>
  					</div>
				</div>
		</div>	

		<div class="col-md-4">
      <?php

	    	if(!empty($profile_data['video_cover_letter_location'])){?> 
			<div id="applicant-video-cover-letter">
	    		<!-- Button trigger modal-->
				<button class="btn btn-primary btn-lg btn-block" data-toggle="modal" data-target="#myModal">
  					Watch Video Cover Letter
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
	    </div>
	</div>
      <div class="row marketing">
        <div class="col-md-4">
        	<div id="profile_picture">
 
	    		<?php 
	    			$image = $profile_data['image_location'];
	    			echo "<img src='$image'>";
	    		?>
	    	</div>
		</div>

	    <div class="col-md-4">
	    	<div id="resume">

	    		<h4>Resume</h4>

	    		<?php

	    		if($profile_data['resume_location'] !== 'resumes/NoResume.pdf'){?> 
	    		<a href="<?php echo $profile_data['resume_location']; ?>" target="_blank">View Resume</a>

				<?php 
	    		} else {
	    			echo '<p>This applicant has not uploaded a resume.</p>';
	    		}
	    		?>
			</div>
	    	<div id="personal_info">
	    		
 
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

	    		#Check if user has entered their location
	    		if(!empty($profile_data['city']) && !empty($profile_data['state'])) { ?>
		    		<h4>Location</h4>
		    		<span><?php echo $profile_data['city']; ?>,&nbsp;<?php echo $profile_data['state']; ?></span>
		    		<br>
	    		<?php } 


				?> 
	    	</div>

        </div>

        <div class="col-md-4">
        	<h4>Current Applications</h4>
			<div id="applications">
				<?php 

				$query = $db->prepare("SELECT j.job_title, a.application_status, a.job_id FROM jobs j join applications a on j.job_id = a.job_id where a.user_id = ? and j.company_id = ?");
				$query->bindValue(1, $user_id);
				$query->bindValue(2, $company_id);
				$query->execute();

					while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
						echo '<b>'.$row['job_title'].' ('.$row['application_status'].'): </b>';
    					echo '<a href="player/player?job_id='.$row['job_id'].'&user_id='.$user_id.'"?>Watch Interview</a><br>';
					}

				?>
			</div>

        </div>
        <div class="col-md-8">	
        	<?php #Is bio specified?
	    		if(!empty($profile_data['bio'])){
		    		?>
		    		<h4>Cover Letter</h4>
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
		</div>
      </div>
      <hr>
      <div id="profile-comments">
      <h4>Post a comment</h4> 
		<form id="commentForm" class="commentForm" method="post" action="">
			<h4>Your Name:</h4>
			<?php if (empty($_SESSION['employee_name'])) {?>
			<input type="text" name="employee_name" value="<?php if(isset($_POST['employee_name'])) echo htmlentities($_POST['employee_name']); ?>" >
			<?php 
				} else {
					echo $_SESSION['employee_name'];
					echo '<input type="hidden" name="employee_name" value="'.$_SESSION['employee_name'].'" />';
				}
			?>

			<h4>Comment:</h4>
			<textarea type="text" name="profile_comment" value="<?php if(isset($_POST['profile_comment'])) echo htmlentities($_POST['profile_comment']); ?>"></textarea>
			<span class="yes-no">
					<h4>Do you think <?php echo $profile_data['first_name']; ?> be a good fit?</h4>
					<select name="profile_opinion">
  						<option value="Yes">Yes</option>
  						<option value="No">No</option>
					</select>
			</span>
			<br>
			<input type="submit" id="submit" name="comment_submit" class="btn btn-primary btn-sm btn-top" />
		</form>	

		<div id="comments">
				<?php
					if (isset($_GET['success']) && empty($_GET['success'])) {
		  				echo 'Thank you. Your comment has been posted.';
					}
				?>

				<?php 

				$query = $db->prepare("SELECT * FROM `profile_comments` WHERE `user_id` = $user_id ORDER BY `profile_comment_time` DESC ");
				$query->execute();

					while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
						?>
						<div class="comment">
							<div class="name"><?php echo $row['employee_name']?></div>
							<div class="date">Added on <?php echo date('F j, Y', $row['profile_comment_time']);?>
								at <?php echo date('h:i A', $row['profile_comment_time']);?></div>
							<p><?php echo $row['profile_comment'];?></p>
							<span>Reply: <?php echo $row['profile_opinion']?></span>
						</div>
					<?php
				}
				?>
		</div>
		</div>

    </div> <!-- /container -->	
    </div>	
  
	  <!-- FOOTER -->
      <?php include 'includes/footer.php'; ?>
	</body>
	</html>