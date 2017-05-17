<?php 
require 'core/init.php';
$general->company_logged_out_protect();

$members 		=$users->get_users();
$member_count 	= count($members);
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
	<title>Applicants</title>
</head>
<body>	
		<?php include 'includes/company-menu.php';?>
		<div id="wrap">
		<div class="container container-white">

      <div class="jumbotron">
      	<h1>Your Applicants</h1>
      </div>

      <div class="row marketing">
        <div class="col-md-4">
        	<p>You have a total of <strong><?php echo $member_count; ?></strong> registered applicants. </p>

        	<?php 
 
			foreach ($members as $member) {
				$user_id = $member['user_id'];
				$first_name = $member['first_name'];
				$last_name = $member['last_name'];
			?>
 
			<p><a href="applicant-profile?user_id=<?php echo $user_id; ?>"><?php echo $first_name . ' ' . $last_name . '';?></a> joined: <?php echo date('F j, Y', $member['time']) ?></p>
			<?php
			}
 
			?>
		</div>
      </div>

    </div> <!-- /container -->
	</div>
	<!-- FOOTER -->
    <?php include 'includes/footer.php'; ?>
</body>
</html>