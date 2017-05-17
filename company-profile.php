<?php 
include 'core/init.php';
$general->company_logged_out_protect();

$name 	= $company['company_name'];

if(isset($_GET['company']) && empty($_GET['company']) === false) { // Putting everything in this if block.
 
 	$company_id   = htmlentities($_GET['company']); // sanitizing the user inputed data (in the Url)
	if ($companies->company_id_exists($company_id) === false) { // If the user doesn't exist
		header('Location:home'); // redirect to index page. Alternatively you can show a message or 404 error
		die();
	}else{
		$profile_data 	= array();
		$user_id 		= $companies->company_fetch_info('company_id', 'company_id', $company_id); // Getting the user's id from the email in the Url.
		$profile_data	= $companies->companydata($user_id);
	}

if (isset($_POST['mass_invite_submit'])) {

	if(empty($_POST['position'])) {

		$invite_errors[] = 'All fields are required.';

	}

	if(empty($mass_invite_errors) === true){
		
		$job_id = $_POST['position'];
		
		$to = $_POST['email1'] . ', ';
		$to .= $_POST['email2'] . ', ';
		$to .= $_POST['email3'] . ', ';
		$to .= $_POST['email4'] . ', ';
		$to .= $_POST['email5'];
		$message = $_POST['message']."\r\n\r\n Apply here: http://screenlined.com/job?job_id=".$job_id;
		$subject = $_POST['subject'];   
		$headers = 'From: '.$_POST['from']. "\r\n" .
   			'Reply-To: do-not-reply@'.$name.'.com' . "\r\n" .
   			'X-Mailer: PHP/' . phpversion();
			mail($to, $subject, $message, $headers) or die ("Failure");

		header('Location: company-profile?mass_invite-success&company='.$company_id);
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
		<?php include 'includes/bootstrap.php'; ?>
	 	<title><?php echo $name . "'s ";?>Profile</title>
	</head>
	<body>
	<?php include 'includes/company-menu.php'; ?>
	<div id="wrap">
	<div class="container container-white">


		<div class="modal fade" id="customInviteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display:none;">
  					<div class="modal-dialog">
    					<div class="modal-content">
      					<div class="modal-header">
        					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        					<h4 class="modal-title" id="myModalLabel">Invite candidates to apply</h4>
      					</div>
      					<div class="modal-body">
      						<form method="post" action="" class="form-signin" role="form">
        					<label for="position">Position:</label>
      						<select name="position">
      						<?php 

							$query = $db->prepare("SELECT c.company_name, c.company_email, j.job_title, j.job_id FROM company c join jobs j on c.company_id = j.company_id WHERE c.company_id = ?");
							$query->bindValue(1, $company_id);
							$query->execute();

							while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
								echo "<option value='" . $row['job_id'] . "'>" . $row['job_title'] . "</option>";
								// $query2 = $db->prepare("INSERT INTO `invitations` (`job_id`, `company_id`, `email`, `company_name`) VALUES (?,?,?,?)");
  						// 		$query->execute();		
							}
								
							?>
							</select>	
							<hr>
							<input type="text" class="form-control" placeholder="First email address" name="email1" value="<?php if(isset($_POST['email1'])) echo htmlentities($_POST['emai1l']); ?>" autofocus>
							<br>
							<input type="text" class="form-control" placeholder="Second email address" name="email2" value="<?php if(isset($_POST['email2'])) echo htmlentities($_POST['email2']); ?>">
							<br>
							<input type="text" class="form-control" placeholder="Third email address" name="email3" value="<?php if(isset($_POST['email3'])) echo htmlentities($_POST['email3']); ?>">
							<br>
							<input type="text" class="form-control" placeholder="Fourth email address" name="email4" value="<?php if(isset($_POST['email4'])) echo htmlentities($_POST['email4']); ?>">
							<br>
							<input type="text" class="form-control" placeholder="Fifth email address" name="email5" value="<?php if(isset($_POST['email5'])) echo htmlentities($_POST['email5']); ?>">
							<hr>
							<input type="text" class="form-control" placeholder="Your Name" name="from" value="<?php if(isset($_POST['from'])) echo htmlentities($_POST['from']); ?>">
							<input type="text" class="form-control" placeholder="Email Subject" name="subject" value="<?php if(isset($_POST['subject'])) echo htmlentities($_POST['subject']); ?>">
							<textarea type="text" class="form-control" placeholder="Custom Message" name="message" value="<?php if(isset($_POST['message'])) echo htmlentities($_POST['message']); ?>"></textarea>
							<p>(Link to application will be sent in this email)</p>
							<input type="submit" name="mass_invite_submit" class="btn btn-primary btn-lg btn-block" value="Send Mass Invitition">
							</form>
      					</div>
      					<div class="modal-footer">
        					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      					</div>
  				  		</div>
  					</div>
				</div>

<?php 
$email = $_POST['email1'];
$email2 = $_POST['email2'];

foreach( $email as $key => $n ) {
  print "The name is ".$n." and email is ".$email[$key].", thank you\n";
}
?>
      <div class="row marketing">
        <div class="col-sm-4">
        	<div id="profile_picture">
 
	    		<?php 
	    			$image = $profile_data['logo_location'];
	    			echo "<img src='$image'>";
	    		?>
	    	</div>
		</div>

        <div class="col-sm-8">
        <div class="companyHeader">
			<div>
				<h1><?php echo $profile_data['company_name']; ?>'s Profile</h1>
			</div>
			<?php
						if (isset($_GET['mass_invite-success']) && empty($_GET['mass_invite-success'])) {
			  				echo '<h3>Thank you. Your invitations have been sent.</h3>';
						}
					?>

					<?php 
						if(empty($mass_invite_errors) === false){
							echo '<p class="errors">' . implode('</p><p class="errors">', $mass_invite_errors) . '</p>';	
						}

					?>	

			<button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#customInviteModal">
					Invite Applicants
			</button>
        </div><!-- /companyHeader -->
      




        	<div id="personal_info">
	    		<hr>
	    	<?php 
 
	    		#Is bio specified?
	    		if(!empty($profile_data['company_bio'])){
		    		?>
		    		<span><strong>Company Bio</strong>: </span>
		    		<span><?php echo $profile_data['company_bio']; ?></span>
		    		<?php 
	    		}
	    		?>
	    		<br>
	    		<?php
	    		if(!empty($profile_data['company_hq'])){
		    		?>
		    		<span><strong>Company Headquarters</strong>: </span>
		    		<span><?php echo $profile_data['company_hq']; ?></span>
		    		<?php 
	    		}
	    		?>

	    		<?php 
	    		#Check if user has entered linked in profile link
	    		if(!empty($profile_data['company_linked_in_profile'])) {

	    			#Format link
	    			if(strstr($profile_data['company_linked_in_profile'], 'http')) {
	    				$linked_in = $profile_data['company_linked_in_profile'];
	    			} else {
	    				$linked_in = 'http://'.$profile_data['company_linked_in_profile'];
	    			}

	    		?>
		    		<span class="linked_in"></span>
		    		<span><strong><?php echo $name;?>'s LinkedIn Profile</strong>: </span>
		    		<span><a href="<?php echo $linked_in; ?>" target="_blank"><?php echo $profile_data['company_linked_in_profile']; ?></a></span>
		    		<br>
	    		<?php } 
	    		?>
	    		<br>
	    	</div>  
		</div>
      </div>

    </div> <!-- /container -->  
	     </div>
	</body>
	<!-- FOOTER -->
    <?php include 'includes/footer.php'; ?>
	</html>
	<?php  
}else{
	header('Location: company-home'); // redirect to index if there is no email in the Url
}
?>