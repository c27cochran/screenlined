<?php 
require 'core/init.php';
$general->company_logged_out_protect();

$company_id = $company['company_id'];

$positions = $jobs->get_jobs($company_id);
$position_count = count($positions);


$name 	= $company['company_name'];

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
	<title><?php echo $name . "'s ";?>Job Postings</title>
</head>
<body>	
		<?php include 'includes/company-menu.php';?>
		<div id="wrap">
		<div class="container container-white">

      <div class="jumbotron">
      	<h1>Your jobs</h1>
      </div>

       <?php
			if (isset($_GET['remove-success']) && empty($_GET['remove-success'])) {
		  		echo '<h3>Thank you. The position has been removed.</h3>';
			}
		?>

		<?php
		if (isset($_GET['post-success']) && empty($_GET['post-success'])) {
		  echo '<h3>Thank you. Your job has been posted.</h3>';
		}
		?>

      <div class="row marketing">
        <div class="col-md-4">
        <div id="profile_picture">
 
	    	<?php 
	   			$image = $company['logo_location'];
	   			echo "<img src='$image'>";
	   		?>
	    </div>
		</div>

	    <div class="col-md-4">
	    	<p>You have a total of <strong><?php echo $position_count; ?></strong> open positions. </p>
        </div>

        <div class="col-md-4">

        </div>
        <div class="col-md-8">	
        <hr>
       	<?php 
 
		foreach ($positions as $position) {
			$title = $position['job_title'];
			$description = $position['job_description'];
			$job_id = $position['job_id'];
		?>
 
			<p><a href="company-applicants?job_id=<?php echo $job_id; ?>"><?php echo $title;?></a></p>
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
