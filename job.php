<?php 
include 'core/init.php';

if(isset($_GET['job_id']) && empty($_GET['job_id']) === false) { // Putting everything in this if block.
 
 	$job_id = htmlentities($_GET['job_id']); // sanitizing the user inputed data (in the Url)
	if ($jobs->job_exists($job_id) === false) { // If the user doesn't exist
		header('Location:index'); // redirect to index page. Alternatively you can show a message or 404 error
		die();
	}else{
		$profile_data 	= array();
		$position_id 	= $jobs->jobs_fetch_info('job_id', 'job_id', $job_id); // Getting the user's id from the email in the Url.
		$profile_data	= $jobs->jobdata($position_id);

		$company_data 	= array();
		$company_data	= $jobs->company_job_data($position_id);
	} 

	$name = $company_data['company_username'];
	$title = $profile_data['job_title'];

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
	 	<title><?php echo $title; ?></title>
	</head>
	<body>
			<?php include 'includes/menu.php'; ?>
			<div id="wrap">
			<div class="container container-white">

      		<div class="jumbotron">
      			<h1><?php echo $profile_data['job_title']; ?> Position Description</h1>
      		</div>

      		<div id="profile_picture">
 
	    	<?php 
	   			$image = $company_data['logo_location'];
	   			echo "<img src='$image'>";
	   		?>
	    	</div>
 
	    	<div id="personal_info">
	    		<hr>
	    	<?php 
	    		if(!empty($profile_data['job_description'])){
		    		?>
		    		<span><strong>Position Description</strong>: </span>
		    		<span><?php echo $profile_data['job_description']; ?></span>
		    		<?php 
	    		}
	    		?>
	    	</div>
	    	<div class="clear"></div>
	    	<?php 
				$question_id = $profile_data['question_1'];
				$time = $profile_data['question_1_time'];
			?>

			<?php if($general->logged_in()){ ?>
			<p><a href="recorder-tutorial/recorder-tutorial?job_id=<?php echo $job_id; ?>&company_name=<?php echo $name;?>" class="btn btn-primary btn-lg"><?php echo 'Apply for the ' . $title . ' position';?></a></p>
			<?php } else { ?>
			<p><a href="login">Login</a> or <a href="register">Register</a> to Apply</p>
			<?php } ?>
		</div>
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