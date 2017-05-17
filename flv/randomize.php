<?php 
require '../core/init.php';
$first_name = $user['first_name'];
$last_name = $user['last_name'];
$username = $user['username'];

if(isset($_GET['job_id']) && empty($_GET['job_id']) === false) { // Putting everything in this if block.
 
 	$job_id = htmlentities($_GET['job_id']); // sanitizing the user inputed data (in the Url)
	if ($jobs->job_exists($job_id) === false) { // If the user doesn't exist
		header('Location:index'); // redirect to index page. Alternatively you can show a message or 404 error
		die();
	}else{
		$job_data 	= array();
		$position_id 	= $jobs->jobs_fetch_info('job_id', 'job_id', $job_id); // Getting the user's id from the email in the Url.
		$job_data	= $jobs->jobdata($position_id);

		$application_data   = array();
    	$app_id        = $applications->applications_fetch_info('user_id', 'job_id', $user_id);
    	$application_data   = $applications->applicationdata($app_id, $job_id);

    	$company_data 	= array();
		$user_id 		= $companies->company_fetch_info('company_id', 'company_email', $email); // Getting the user's id from the email in the Url.
		$job_data	= $companies->companydata($user_id); 
		
		$user_id = $user['user_id'];
		$company_name = $company_data['company_name'];
		$company_id = $job_data['company_id'];
		$question = $job_data['question_id'];
		$job = $job_data['job_id'];
		$time = $job_data['question_1_time'];
		
		$applications->apply($job_id, $user_id, $company_id);

		$answer_location = $username.'/'.$company_name.'/'.$job.'/question_1.flv';
		$applications->set_answer1($answer_location, $job_id, $user_id);
	} 
}

?>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Video Application</title>
<style type="text/css">
.wrapper {margin: 0 auto;width:500px;text-align:center;}
#flashContent { display:none; }	
</style>
	<link rel="stylesheet" type="text/css" href="../css/style.css">

</head>
<body>
<script type="text/javascript" src="swfobject.js"></script>
<?php 

for ($i = 1; $i <= 10; $i++) {
	?>
<script type="text/javascript">
	var flashvars = {
		userId : "<?php echo $username; ?>",
		qualityurl: "audio_video_quality_profiles/wide/640x360x30x90.xml",
		recorderId: "<?php echo $time.'/'.$company_name.'/'.$job;?>/question_<?php $i;?>",
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
<?php }
?>
<img src="logo.png" />
<div id="page">
	<?php include 'includes/menu.php';?>
	<h1>Candidate: <?php echo $first_name . ' ' . $last_name; ?></h1><br>
<hr>		
<h3><?php echo $question?></h3>
<h3><?php echo 'You have '.$time.' seconds to answer';?></h3>
	<div class="wrapper">
		<div id="flashContent" >
		
		</div>
	</div>

	<div id="nextQuestion">
		<?php 
				$title = $job_data['job_title'];
				$question_id = $job_data['question_2'];
				$answer_time = $job_data['question_2_time'];
		?>

	</div>

</div>
&copy;Screenlined 2014


</body>
</html>