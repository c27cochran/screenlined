<?php 
include '../core/init.php';

if(isset($_GET['company_email']) && empty($_GET['company_email']) === false) { // Putting everything in this if block.
 
 	$email   = htmlentities($_GET['company_email']); // sanitizing the user inputed data (in the Url)
	if ($companies->company_email_exists($email) === false) { // If the user doesn't exist
		header('Location:home'); // redirect to index page. Alternatively you can show a message or 404 error
		die();
	}else{
		$profile_data 	= array();
		$user_id 		= $companies->company_fetch_info('company_id', 'company_email', $email); 
		$profile_data	= $companies->companydata($user_id);
	} 

}

	$positions 		=$jobs->get_jobs($profile_data['company_id']);
	$position_count 	= count($positions);
	
	?>
	<!doctype html>
	<html lang="en">
	<head>	
		<meta charset="UTF-8">
		<?php include '../includes/bootstrap.php'; ?>
	 	<title>Company</title>
	</head>
	<body>
	    <img src="logo.png">
		<div id="page">
			<?php include 'includes/menu.php'; ?>
			<h1><?php echo $profile_data['company_name']; ?>'s Profile</h1>
			
			<script type="text/javascript">
    			$(window).load(function(){
        			$('#myModal').modal('show');
    			});
			</script>
			
			<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display:none;">
  				<div class="modal-dialog">
    				<div class="modal-content">
      				<div class="modal-header">
       				 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
       				 <h4 class="modal-title" id="myModalLabel">Oops...</h4>
      				</div>
      				<div class="modal-body">
       				 <h4>You took too long to answer</h4>
     				 </div>
     				 <div class="modal-footer">
      				  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      				</div>
    				</div>
 				 </div>
			</div>
 
	    	<div id="profile_picture">
 
	    		<?php 
	    			$image = $profile_data['logo_location'];
	    			echo "<img src='../$image'>";
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
 
			<p><a href="../job?job_id=<?php echo $job_id; ?>"><?php echo $title;?></a></p>
			<?php
		}
 
		?>
	    </div>        
	     &copy;Screenlined 2014
	</body>
	</html>