<?php 
require '../core/init.php';
$first_name = $user['first_name'];
$last_name = $user['last_name'];
$username = $user['username'];
$user_id = $user['user_id'];

if(isset($_GET['job_id']) && empty($_GET['job_id']) === false) { // Putting everything in this if block.
 
 	$job_id = htmlentities($_GET['job_id']); // sanitizing the jobs inputed data (in the Url)
 	$company_name = htmlentities($_GET['company_name']); // sanitizing the company name inputed data (in the Url)
		
 		$profile_data 	= array();
		$position_id 	= $jobs->jobs_fetch_info('job_id', 'job_id', $job_id); // Getting the user's id from the email in the Url.
		$profile_data	= $jobs->jobdata($position_id); 

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

</head>
<body>
	<?php
		if ($applications->application_exists($job_id, $user_id) === true) { // If the user has already applied ?>
		<script type="text/javascript">
    			$(window).load(function(){
        			$('#myModal2').modal('show');
    			});
			</script>
			
			<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display:none;">
  				<div class="modal-dialog">
    				<div class="modal-content">
      				<div class="modal-header">
       				 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
       				 <h4 class="modal-title" id="myModalLabel">Oops...</h4>
      				</div>
      				<div class="modal-body">
       				 <h4>You've already applied for this position</h4>
     				 </div>
     				 <div class="modal-footer">
      				  <a href="../profile?user=<?php echo $user_id;?>" class="btn btn-default">Close</a>
      				</div>
    				</div>
 				 </div>
			</div>
	<?php 
		} else { 
	?>	

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
     		   <h3 class="modal-title" id="myModalLabel">Test Your Camera Before Interviewing:</h3>
     		 </div>
     		 <div class="modal-body">
     		 	<h3>Add instructions on what to do.</h3>
     		 </div>
     		 <div class="modal-footer">
     		   <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
     		 </div>
    		</div>
  		</div>
	</div>

	<?php 
		}
	?>

<script type="text/javascript" src="swfobject.js"></script>
<script type="text/javascript">
	var flashvars = {
		userId : "<?php echo $username; ?>",
		qualityurl: "audio_video_quality_profiles/wide/640x360x30x90.xml",
		recorderId: "tutorial",
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
	<div class="container container-white">

      <div class="jumbotron">
      	<h1>Candidate: <?php echo $first_name . ' ' . $last_name; ?></h1>
      </div>
<hr>		
<h3>This is a practice question</h3>
	<div class="wrapper">
		<div id="flashContent" >
		
		</div>
	</div>

	<div id="nextQuestion">
		<?php 
				$title = $profile_data['job_title'];
			?>

				<p><a href="../flv/recorder1?job_id=<?php echo $job_id; ?>&company_name=<?php echo $company_name;?>" class="btn btn-primary btn-lg">Start Your Interview</a></p>

	</div>

</div>
 	<!-- FOOTER -->
    <?php include 'includes/footer.php'; ?>

</body>
</html>