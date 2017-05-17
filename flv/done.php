<?php 
require '../core/init.php';
$general->logged_out_protect();
 
$name 	= $user['first_name']; // using the $user variable defined in init.php and getting the username.
 
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include 'includes/bootstrap.php'; ?>
	<title>Home</title>
</head>
<body>	
		<?php include 'includes/menu.php'; ?>
	<div id="wrap">
	<div class="container container-white">

		<h1>Congrats <?php echo $name, '!'; ?></h1>
		<h3>You have completed applying for this job!</h3>
		<br>
		<a href="../profile?user=<?php echo $user['user_id'];?>" class="btn btn-primary btn-lg">Back to Profile</a>
		<br>
		<br>
	</div>
	</div>
	<!-- FOOTER -->
    <?php include 'includes/footer.php'; ?></body>
</html>