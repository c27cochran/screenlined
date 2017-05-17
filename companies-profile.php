<?php 
include 'core/init.php';
$general->logged_out_protect();

if(isset($_GET['company']) && empty($_GET['company']) === false) { // Putting everything in this if block.
 
 	$company_username   = htmlentities($_GET['company']); // sanitizing the user inputed data (in the Url)
	if ($companies->company_exists($company_username) === false) { // If the user doesn't exist
		header('Location:home'); // redirect to index page. Alternatively you can show a message or 404 error
		die();
	}else{
		$profile_data 	= array();
		$user_id 		= $companies->company_fetch_info('company_id', 'company_username', $company_username); // Getting the user's id from the email in the Url.
		$profile_data	= $companies->companydata($user_id);
	} 

	$positions 		=$jobs->get_jobs($profile_data['company_id']);
	$position_count 	= count($positions);
	
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
	 	<title>Company</title>
	</head>
	<body>
			<?php include 'includes/menu.php'; ?>
			<div id="wrap">
			<div class="container container-white">

      		<div class="jumbotron">
      			<h1><?php echo $profile_data['company_name']; ?>'s Profile</h1>
      		</div>
 
	    	<div id="profile_picture">
 
	    		<?php 
	    			$image = $profile_data['logo_location'];
	    			echo "<img src='$image'>";
	    		?>
	    	</div>
	    	<div id="personal_info">
	    		<hr>
	    	<?php 
 
	    		#Is bio specified?
	    		if(!empty($profile_data['company_bio'])){
		    		?>
		    		<span><strong>Bio</strong>: </span>
		    		<span><?php echo $profile_data['company_bio']; ?></span>
		    		<?php 
	    		}
	    		?>
	    	</div>
	    	<div class="clear"></div>

	    	<p>There are <strong><?php echo $position_count; ?></strong> open positions. </p>
 
		<?php 
 
		foreach ($positions as $position) {
			$title = $position['job_title'];
			$description = $position['job_description'];
			$job_id = $position['job_id'];
 		
		?>
 
			<p><a href="job?job_id=<?php echo $job_id; ?>"><?php echo $title;?></a></p>
			<?php
		}
 
		?>
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