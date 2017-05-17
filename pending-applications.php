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

      <div class="jumbotron">
        <h1><?php echo $profile_data['first_name']. ' ' .$profile_data['last_name']; ?></h1>
      </div>

      <div class="row marketing">
        <div class="col-md-4">
          <div id="profile_picture" class="col-md-4">
 
	    		<?php 
	    			$image = $profile_data['image_location'];
	    			echo "<img src='$image'>";
	    		?>
	    </div>
		</div>

	    <div class="col-md-8">
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
	    </div>
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