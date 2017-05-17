<?php 
require '../core/init.php';
$first_name = $user['first_name'];
$last_name = $user['last_name'];
$user_id = $user['user_id'];
$time = "300";

if(isset($_GET['username']) && empty($_GET['username']) === false) { // Putting everything in this if block.
 
 	$username = htmlentities($_GET['username']); // sanitizing the username inputed data (in the Url)
		
	$location = $username.'/video-cover-letter.mp4';				
	$users->video_cover_letter($location, $username);

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
	<?php include 'includes/menu.php';?>
	<div id="wrap">
	<div class="container container-white">
	<h1><?php echo $first_name . ' ' . $last_name; ?>'s Video Cover Letter</h1><br>
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
     		   <h3 class="modal-title" id="myModalLabel">Add Your Video Cover Letter:</h3>
     		 </div>
     		 <div class="modal-body">
     		 	<h3>Put text in here explaining how to record</h3>
     		 	<h5><?php echo 'You have 5 minutes to answer after you click record.';?></h5><br>
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
		recorderId: "<?php echo $username;?>/video-cover-letter",
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
	
	
	swfobject.embedSWF("VideoRecorder.swf", "flashContent", "640", "500", "10.3.0", "", flashvars, params, attributes);
</script>
<hr>		
	<div class="wrapper" style="width: 700px!important;">
		<div id="flashContent" >
		
		</div>
	</div>

	<div id="done">
 		<hr>		
		<p><a href="../profile?user=<?php echo $user['user_id'];?>" class="btn btn-primary btn-lg" style="float:right; margin-bottom:15px;">Go Back to Your Profile</a></p> 
	</div>
</div>
</div>        
	<!-- FOOTER -->
    <?php include 'includes/footer.php'; ?>

</body>
</html>