<?php 
require 'core/init.php';
$general->logged_out_protect();

$positions = $jobs->list_jobs();
$position_count = count($positions);

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
	<title>Job Postings</title>
</head>
<body>	
		<?php include 'includes/menu.php';?>
		<div id="wrap">
		<div class="container container-white">

      <div class="jumbotron">
      	<h1>Open Positions</h1>
      </div>

      <div class="row marketing">

	    <div class="col-md-8">
	    	<p>There are <strong><?php echo $position_count; ?></strong> open positions. </p>
        </div>

        <div class="col-md-4">
        	<div class="input-group">
            <input type="text" id="job-search" class="form-control" placeholder="Search Jobs" name="srch-term" autocomplete="off">
            <ul class="dropdown-menu" id="job-results"></ul>
            <div class="input-group-btn">
              <span class="btn btn-default search-hover"><span class="glyphicon glyphicon-search"></span></span>
            </div>
          </div>

        </div>
        <div class="col-md-8">	
        <hr>

    <?php 
    $query = $db->prepare("SELECT distinct company_username, company_id, company_name, logo_location FROM company");
    $query->execute();

          while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $company_id = $row['company_id'];
            $company_name = $row['company_name'];
            ?>
              <div id="profile_picture">
              <?php 
                $image = $row['logo_location'];
                echo "<img src='$image'>";
              ?>
              </div>
              <br>

            <?php 
              $query2 = $db->prepare("SELECT * FROM company c join jobs j on c.company_id = j.company_id WHERE c.company_id = $company_id ORDER BY c.company_name ASC, j.job_title ASC ");
              $query2->execute();

              while ($row2 = $query2->fetch(PDO::FETCH_ASSOC)) {
            ?>

            <ul class="job">
              <li class="name"><a href="job?job_id=<?php echo $row2['job_id']; ?>"><?php echo $row2['job_title'];?></a> - <?php echo $row2['company_name']?></li>
            </ul>
          <?php
          } ?> <hr>
       <?php }
        ?>
		</div>
      </div>

    </div> <!-- /container -->
</div>

	<!-- FOOTER -->
    <?php include 'includes/footer.php'; ?>
    <script type="text/javascript" src="js/job-search.js"></script>
</body>
</html>
