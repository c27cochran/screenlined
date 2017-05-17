<?php 
require '../core/init.php';
$first_name = $user['first_name'];
$last_name = $user['last_name'];
$username = $user['username'];
$company_name = $user['company_name'];

if(isset($_GET['job_id']) && empty($_GET['job_id']) === false) { // Putting everything in this if block.
 
 	$job_id = htmlentities($_GET['job_id']); // sanitizing the user inputed data (in the Url)
	if ($jobs->job_exists($job_id) === false) { // If the user doesn't exist
		header('Location:index'); // redirect to index page. Alternatively you can show a message or 404 error
		die();
	}else{
		$profile_data 	= array();
		$position_id 	= $jobs->jobs_fetch_info('job_id', 'job_id', $job_id); // Getting the user's id from the email in the Url.
		$profile_data	= $jobs->jobdata($position_id);
	} 
}	

$question = $_GET['question_id'];
$job = $_GET['job_id'];

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
<script type="text/javascript">
	var flashvars = {
		userId : "<?php echo $username; ?>",
		qualityurl: "audio_video_quality_profiles/wide/640x360x30x90.xml",
		recorderId: "<?php echo $question.'/'.$job; ?>",
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
<img src="logo.png" />
<div id="page">
	<?php include 'includes/menu.php';?>
	<h1>Candidate: <?php echo $first_name . ' ' . $last_name; ?></h1><br>
<hr>		
<h3><?php echo $question;?></h3>

	<div class="wrapper">
		<div id="flashContent" >
		
		</div>
	</div>
</div>
&copy;Screenlined 2014


</body>
</html>