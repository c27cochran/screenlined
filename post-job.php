<?php 
require 'core/init.php';
$general->company_logged_out_protect();

$name 	= $company['company_name'];

if (isset($_POST['submit'])) {

	if(empty($_POST['job_title']) || empty($_POST['job_description']) || empty($_POST['question_1'])){

		$errors[] = 'All fields are required.';

	}else{
        
        if (strlen($_POST['job_title']) <2){
            $errors[] = 'Please enter a vaid job title';
        } else if (strlen($_POST['job_title']) >50){
            $errors[] = 'Your job title cannot be more than 50 characters long';
        }
        if (strlen($_POST['job_description']) <2) {
            $errors[] = 'Please enter a valid job description';
        }else if (strlen($_POST['job_description']) >500000){
            $errors[] = 'The job description cannot be more than 500000 characters long';
        }
        if (strlen($_POST['question_1']) <2){
            $errors[] = 'Please enter at least one question';
        } else if (strlen($_POST['job_title']) >255){
            $errors[] = 'Your question cannot be more than 255 characters long';
        }
	}

	if(empty($errors) === true){
		
		$job_id = $_POST['job_id'];
		$company_id 	= $company['company_id'];
		$job_title = $_POST['job_title'];
		$job_description = html_entity_decode($_POST['job_description']);
		$question_1 = $_POST['question_1'];
		$question_2 = $_POST['question_2'];
		$question_3 = $_POST['question_3'];
		$question_4 = $_POST['question_4'];
		$question_5 = $_POST['question_5'];
		$question_6 = $_POST['question_6'];
		$question_7 = $_POST['question_7'];
		$question_8 = $_POST['question_8'];
		$question_9 = $_POST['question_9'];
		$question_10 = $_POST['question_10'];
		$question_1_time = $_POST['question_1_time'];
		$question_2_time = $_POST['question_2_time'];
		$question_3_time = $_POST['question_3_time'];
		$question_4_time = $_POST['question_4_time'];
		$question_5_time = $_POST['question_5_time'];
		$question_6_time = $_POST['question_6_time'];
		$question_7_time = $_POST['question_7_time'];
		$question_8_time = $_POST['question_8_time'];
		$question_9_time = $_POST['question_9_time'];
		$question_10_time = $_POST['question_10_time'];

		$jobs->post_job($job_id, $company_id, $job_title, $job_description, $question_1, 
			$question_2, $question_3, $question_4, $question_5, $question_6, $question_7, 
			$question_8, $question_9, $question_10, $question_1_time, $question_2_time, 
			$question_3_time, $question_4_time, $question_5_time, $question_6_time, $question_7_time, 
			$question_8_time, $question_9_time, $question_10_time);
		header('Location: company-jobs?post-success');
		exit();
	}
}

?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
	<script src="js/tinymce/tinymce.min.js"></script>
	<script>
        tinymce.init({selector:'textarea'});
	</script>
	<?php include 'includes/bootstrap.php'; ?>
	<title><?php echo $name . "'s ";?>Job Postings</title>

	<script type="text/javascript">
    	$(window).load(function(){
       		$( "#question_1" ).show();
    	});
	</script>
</head>
<body>	
		<?php include 'includes/company-menu.php'; ?>
		<div id="wrap">
		<div class="container container-white">

      <div class="jumbotron">
      	<h1>Post a Job</h1>
      </div>
		<div id="profile_picture">
 
	    		<?php 
	    			$image = $company['logo_location'];
	    			echo "<img src='$image'>";
	    		?>
	    </div>

		<form method="post" action="">
			<h4>Job Title:</h4>
			<input type="text" class="form-control" name="job_title" value="<?php if(isset($_POST['job_title'])) echo htmlentities($_POST['job_title']); ?>" >
			<h4>Insert Job Description</h4>
	    	<textarea name="job_description"><?php if (isset($_POST['job_description']) ){echo htmlentities(strip_tags($_POST['job_description']));}?></textarea>  
	    	
	    	<?php 

			for ($i = 1; $i <= 10; $i++) {
			?>
	    	<div id="question_<?php echo $i;?>" style="display:none;">
	    		<h4>Question <?php echo $i;?>:</h4>
				<input type="text" class="form-control" name="question_<?php echo $i;?>" value="<?php if(isset($_POST['question_'.$i.''])) echo htmlentities($_POST['question_'.$i.'']); ?>" >
				<span class="time">
					<h4>Time Limit:</h4>
					<select name="question_<?php echo $i;?>_time">
  						<option value="30">30 Seconds</option>
  						<option value="60">1 Minute</option>
  						<option value="120">2 Minutes</option>
  						<option value="180">3 Minutes</option>
  						<option value="240">4 Minutes</option>
  						<option value="300">5 Minutes</option>
					</select>
				</span>
				<input type="button" id="add_q<?php echo $i + 1;?>" class="btn btn-primary" value="Add another question" />
			</div>
			<?php
			}
			?>
			<br>
			<input type="submit" name="submit" class="btn btn-primary btn-lg" />
			<hr>
		</form>

		<!-- Add a for loop here in the future -->
		<script type="text/javascript">
			$( "#add_q2").click(function() {
  				$( "#question_2" ).show();
			});
			$( "#add_q3").click(function() {
  				$( "#question_3" ).show();
			});
			$( "#add_q4").click(function() {
  				$( "#question_4" ).show();
			});
			$( "#add_q5").click(function() {
  				$( "#question_5" ).show();
			});
			$( "#add_q6").click(function() {
  				$( "#question_6" ).show();
			});
			$( "#add_q7").click(function() {
  				$( "#question_7" ).show();
			});
			$( "#add_q8").click(function() {
  				$( "#question_8" ).show();
			});
			$( "#add_q9").click(function() {
  				$( "#question_9" ).show();
			});
			$( "#add_q10").click(function() {
  				$( "#question_10" ).show();
			});
		</script>

		<?php 
		if(empty($errors) === false){
			echo '<p class="errors">' . implode('</p><p class="errors">', $errors) . '</p>';	
		}

		?>
	</div>
	</div>
	<!-- FOOTER -->
    <?php include 'includes/footer.php'; ?>
</body>
</html>