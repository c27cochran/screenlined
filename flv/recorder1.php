<?php 
require '../core/init.php';
$first_name = $user['first_name'];
$last_name = $user['last_name'];
$username = $user['username'];
$user_id = $user['user_id'];

if(isset($_GET['job_id']) && empty($_GET['job_id']) === false) { // Putting everything in this if block.
 
 	$job_id = htmlentities($_GET['job_id']); // sanitizing the user inputed data (in the Url)
		
 		$profile_data 	= array();
		$position_id 	= $jobs->jobs_fetch_info('job_id', 'job_id', $job_id); // Getting the user's id from the email in the Url.
		$profile_data	= $jobs->jobdata($position_id);
		
		$company_name = $_GET['company_name'];
		$company_id = $profile_data['company_id'];

		$company_data 	= array();
		$company_id 	= $companies->company_fetch_info('company_id', 'company_id', $company_id); 
		$company_data	= $companies->companydata($company_id);

		$company_email = $company_data['company_email'];

	if ($applications->application_exists($job_id, $user_id) === true) { // If the user has already applied
		header('Location:already-applied?company_email='.$company_email); // redirect page. Alternatively you can show a message or 404 error
		die();
	}else{
		
		header('refresh:'.$time.';url=time-limit-reached?company_email='.$company_email);
		$question = $profile_data['question_1'];
		$job = $_GET['job_id'];
		$time = $profile_data['question_1_time'];
		$status = 'Applied';

		$applications->apply($job_id, $user_id, $company_id, $status);

		$answer_location = $username.'/'.$company_name.'/'.$job.'/question_1.mp4';
		$applications->set_answer1($answer_location, $job_id, $user_id);
	} 
}

	#Format time for modal
	if ($time == '30') {
		$formatted_time = '30 seconds';
	}
	else if ($time == '60') {
		$formatted_time = '1 minute';	
	}
	else if ($time == '120') {
		$formatted_time = '2 minutes';	
	}
	else if ($time == '180') {
		$formatted_time = '3 minutes';	
	}
	else if ($time == '240') {
		$formatted_time = '4 minutes';	
	}
	else if ($time == '300') {
		$formatted_time = '5 minutes';	
	}
	else {
		$formatted_time = 'error';
	}

?>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php include 'includes/bootstrap.php'; ?>
<title>Video Application</title>
<style type="text/css">
.wrapper {margin: 0 auto;width:500px;text-align:center;}
#flashContent { display:none; }	
</style>
	<link rel="stylesheet" type="text/css" href="../css/style.css">

</head>
<body>
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
     		   <h3 class="modal-title" id="myModalLabel">Question:</h3>
     		 </div>
     		 <div class="modal-body">
     		 	<h3><?php echo $question;?></h3>
     		 	<h5><?php echo 'You have '.$formatted_time.' to answer after you click record.';?></h5><br>
     		 </div>
     		 <div class="modal-footer">
     		   <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
     		 </div>
    		</div>
  		</div>
	</div>

<script type="text/javascript" src="swfobject.js"></script>
<script type="text/javascript">
	var flashvars = {
		userId : "<?php echo $username; ?>",
		qualityurl: "audio_video_quality_profiles/wide/640x360x30x90.xml",
		recorderId: "<?php echo $time.'/'.$company_name.'/'.$job;?>/question_1",
		sscode: "php"	
	};
	var params = {
		quality : "high",
		bgcolor : "#333333",
		play : "true",
		loop : "false",
		allowscriptaccess: "sameDomain"
	};
	var attributes = {
		name : "VideoRecorder",
		id :   "VideoRecorder",
		align : "middle"
	};
	
	
	swfobject.embedSWF("VideoRecorder.swf", "flashContent", "500", "426", "10.3.0", "", flashvars, params, attributes);
</script>
	<?php include 'includes/menu.php';?>
	<div id="wrap">
	<div class="container container-white">
<hr>		
<h3><?php echo $question?></h3>
	<div class="wrapper">
		<div id="flashContent" >
		
		</div>
	</div>

	<div id="nextQuestion">
		<?php 
				$title = $profile_data['job_title'];
				$question_id = $profile_data['question_2'];
				$answer_time = $profile_data['question_2_time'];
			?>
 

			<?php 

			if (!empty($question_id)) {
				?>

				<p><a href="recorder2?job_id=<?php echo $job_id; ?>&company_name=<?php echo $company_name;?>" class="btn btn-primary btn-lg">Next Question</a></p>
			<?php } else { ?>
 
				<p><a href="done" class="btn btn-primary btn-lg">You're Done!</a></p> 
			<?php } ?>

	</div>

</div>
</div>
	<!-- FOOTER -->
    <?php include 'includes/footer.php'; ?>


</body>
</html>