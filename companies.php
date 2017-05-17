<?php 
require 'core/init.php';
$general->logged_out_protect();
$members 		=$companies->get_companies();
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
	<title>Companies</title>
</head>
<body>	
	<?php include 'includes/menu.php';?>
	<div id="wrap">
	<div class="container container-white">

      <div class="jumbotron">
      	<h1>Our members</h1>
      </div>

		
		<p>We have a total of <strong><?php echo $member_count; ?></strong> registered users. </p>
 
		<?php 
 
		foreach ($members as $member) {
			$email = $member['company_email'];
			$company_name = $member['company_name'];
			$company_id = $member['company_id'];
			$company_username = $member['company_username']
			?>
 
			<p><a href="companies-profile?company=<?php echo $company_username; ?>"><?php echo $company_name?></a> joined: <?php echo date('F j, Y', $member['company_time']) ?></p>
			<?php
		}
 
		?>
	</div>
	</div>
	<!-- FOOTER -->
    <?php include 'includes/footer.php'; ?>
</body>
</html>