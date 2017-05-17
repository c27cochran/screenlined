<?php 
include 'core/init.php';
$general->company_logged_out_protect();

$name 	= $company['company_name'];
$company_id = $company['company_id'];

if(isset($_GET['job_id']) && empty($_GET['job_id']) === false) { // Putting everything in this if block.
 
 	$job_id = htmlentities($_GET['job_id']); // sanitizing the inputed data (in the Url)
	if ($jobs->job_exists($job_id) === false) { // If the job doesn't exist
		header('Location:index'); // redirect to index page. Alternatively you can show a message or 404 error
		die();
	}else{
		$profile_data 	= array();
		$position_id 	= $jobs->jobs_fetch_info('job_id', 'job_id', $job_id); // Getting the user's id from the email in the Url.
		$profile_data	= $jobs->jobdata($position_id);
	} 
}else{
	header('Location: index'); // redirect to index if there is no email in the Url
}	


if (isset($_POST['remove-job-submit'])) {

		$jobs->remove_job($job_id);
		header('Location: company-jobs?remove-success');
		exit();
}


if (isset($_POST['submit'])) {

	if(empty($_POST['update_job_description'])) {

		$errors[] = 'All fields are required.';

	}else{
        
        if (strlen($_POST['update_job_description']) <2) {
            $errors[] = 'Please enter a valid job description';
        }else if (strlen($_POST['update_job_description']) >500000){
            $errors[] = 'The job description cannot be more than 500000 characters long';
        }

	}

	if(empty($errors) === true){
		
		$update_job_description = $_POST['update_job_description'];

		$jobs->update_job($update_job_description, $job_id);
		header('Location: company-applicants?success&job_id='.$job_id.'#update-job-description');
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
    	<script src="js/tinymce/tinymce.min.js"></script>
		<script>
        	tinymce.init({selector:'textarea'});
		</script>
		<?php include 'includes/bootstrap.php'; ?>
	 	<title><?php echo $name; ?></title>
	</head>
	<body>
			<?php include 'includes/company-menu.php'; ?>
			<div id="wrap">
		<div class="container container-white">

      	<div class="jumbotron">
      		<h1><?php echo $profile_data['job_title']; ?></h1>
 	     </div>

 	     <?php
			if (isset($_GET['success']) && empty($_GET['success'])) {
		  		echo '<h3>Thank you. The job description has been updated.</h3>';
			}
		?>

		<?php 
			if(empty($errors) === false){
				echo '<p class="errors">' . implode('</p><p class="errors">', $errors) . '</p>';	
			}

		?>
 	
 			<form method="post" action="">
 				<input type="submit" name="remove-job-submit" value="Remove This Job" class="btn btn-primary btn-lg" style="float:right;" />
 			</form>

	    	<div id="profile_picture">
 
	    		<?php 
	    			$image = $company['logo_location'];
	    			echo "<img src='$image'>";
	    		?>
	    	</div>
	    	<div id="applications">
				<h4>Active Applicants</h4>
				<?php 

				$query = $db->prepare("SELECT j.job_title, a.job_id, u.first_name, u.last_name, u.user_id, REPLACE( a.application_status, 'Applied', 'New Interview' ) AS status FROM jobs j 
					join applications a on j.job_id = a.job_id join users u on u.user_id = a.user_id where a.job_id =? and j.company_id = ?");
				$query->bindValue(1, $job_id);
				$query->bindValue(2, $company_id);
				$query->execute();

					while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
						echo '<a href="player/player?job_id='.$row['job_id'].'&user_id='.$row['user_id'].'"?><b>'.$row['first_name'].' '.$row['last_name'].'</b></a>.....'.$row['status'].'';
    					echo '<br>';
					}

				?>
			</div>
			<br>
			<div id="edit-job-description"><a href="#" class="btn btn-primary btn-lg">Edit Job Description</a></div>

			<div id="update-job-description" style="display:none;">
	    		<div id="update-job-description">
				<form method="post" action="">
					<h4>Update Job Description</h4>
	    			<textarea name="update_job_description" value="<?php echo $profile_data['job_description'];?>"></textarea>  
					<br>
					<input type="submit" name="submit" class="btn btn-primary btn-lg" />
					<hr>
				</form>
				</div>
			</div>
			<br><br>
	    	<div id="job_info">
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
	    	<div id="question_info">
	    		<hr>
	    		<?php 
	    		if(!empty($profile_data['question_1'])){
		    		?>
		    		<h4>Interview Questions:</h4>
		    		<?php 

						for ($i = 1; $i <= 10; $i++) {
					?>
		    			<p><?php echo $profile_data['question_'.$i.'']; ?></p>
		    		<?php 
		    			}
	    		}
	    		?>
	    	</div>	
	    </div>        
	</div>
	  <!-- FOOTER -->
      <?php include 'includes/footer.php'; ?>
      <script type="text/javascript">
			$(document).ready(
    			function(){
        			$("#edit-job-description").click(function () {
            			 $("#update-job-description").show("slow");
        		});
    		});
		</script>
	</body>
	</html>
