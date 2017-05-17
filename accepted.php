<?php 
include 'core/init.php';

$general->company_logged_out_protect();

if(isset($_GET['user_id']) && empty($_GET['user_id']) === false) { 
  
  if(isset($_GET['job_id']) && empty($_GET['job_id']) === false) {

    $user_id   = htmlentities($_GET['user_id']); // sanitizing the user inputed data (in the Url)
    $job_id   = htmlentities($_GET['job_id']);

    $applications->accept_applicant($job_id, $user_id); 
 
  }
}

?>
	<!doctype html>
	<html lang="en">
	<head>	
		<meta charset="UTF-8">
		<?php include 'includes/bootstrap.php'; ?>
	 	<title>Applicant Accepted</title>
	</head>
	<body>

	<?php include 'includes/company-menu.php'; ?>
	<div id="wrap">
	<div class="container container-white">

      <div class="jumbotron">

      </div>
      <?php
             if (isset($_GET['accepted']) && empty($_GET['accepted'])) { ?>
                <h3>Accepted</h3>
                <h5>This is a placeholder. Put stuff here on how to schedule an interview.</h5>
                <script type="text/javascript">
                    $(document).ready(function(){
                         $("#accept-deny-form").hide();
                         $("#question-list").hide();
                    });
                </script>
        <?php }
        ?>

    </div> <!-- /container -->
	</div>

	  <!-- FOOTER -->
      <?php include 'includes/footer.php'; ?>
	</body>
	</html>