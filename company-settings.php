<?php 
require 'core/init.php';
$general->company_logged_out_protect();


$company_id 	= $company['company_id'];
$company_user	= $company['company_username'];

if (isset($_POST['submit'])) {

	if(empty($_POST['company_bio']) || empty($_POST['company_hq'])) {

		$errors[] = 'Your company bio and headquarter fields are required.';

	}else{

		if (isset($_POST['company_linked_in_profile']) && !empty ($_POST['company_linked_in_profile'])){
			if(!strstr($_POST['company_linked_in_profile'], 'www.linkedin.com')) {
	    		$errors[] = 'Invalid LinkedIn Profile Link';
	    	}
		}

		if (isset($_FILES['myfile']) && !empty($_FILES['myfile']['name'])) {// check if the user has uploaded a new file
					
			$name 			= $_FILES['myfile']['name']; // getting the name of the file
			$tmp_name 		= $_FILES['myfile']['tmp_name']; // getting the temporary file name.
			$allowed_ext 	= array('jpg', 'jpeg', 'png', 'gif' );// specifying the allowed extentions
			$a 				= explode('.', $name);
			$file_ext 		= strtolower(end($a)); unset($a);// getting the allowed extenstions
			$file_size 		= $_FILES['myfile']['size'];
			$path 			= "avatars";// the folder in which we store the profile pictures or avatars of the user.
					
			if (in_array($file_ext, $allowed_ext) === false) {
				$errors[] = 'Image file type not allowed';	
			}
					
			if ($file_size > 2097152) {
						$errors[] = 'File size must be under 2mb';
			}
					
		} else {
			$newpath = $company['logo_location']; // if user did not upload a file, then use the one stored in the database
		}
	}

	if(empty($errors) === true){
		
		if (isset($_FILES['myfile']) && !empty($_FILES['myfile']['name']) && $_POST['use_default'] != 'on') {
				
			$newpath = $general->file_newpath($path, $name);
 
			move_uploaded_file($tmp_name, $newpath);
 
		} else if(isset($_POST['use_default']) && $_POST['use_default'] === 'on'){
                     $newpath = 'avatars/default_avatar.png';
        }
					
		$bio 			= html_entity_decode(trim($_POST['company_bio']));
		$company_hq 	= html_entity_decode(trim($_POST['company_hq']));
		$linked_in_profile 		= htmlentities(trim($_POST['company_linked_in_profile']));
		$image_location	= htmlentities(trim($newpath));
		$linked_in_profile 		= htmlentities(trim($_POST['company_linked_in_profile']));
					
		$companies->update_company($bio, $company_hq, $image_location, $linked_in_profile, $company_id);
		header('Location: company-settings?success');
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
	<title>Edit Your Profile</title>
</head>
<body>	
		<?php include 'includes/company-menu.php'; ?>
		<div id="wrap">
		<div class="container container-white">
		<?php
			if (isset($_GET['success']) && empty($_GET['success'])) {
		  		echo '<h3>Your <a href="company-profile?company='.$company_id.'">Profile</a> has been updated!</h3>';
			}
		?>

		<?php 
		if(empty($errors) === false){
			echo '<p class="errors">' . implode('</p><p class="errors">', $errors) . '</p>';	
		}

		?>

      <div class="jumbotron">
      	<h2>Edit Profile</h2> <p><b>Note: Information you post here is made viewable to others.</b></p>
      </div>
      <form action="" method="post" enctype="multipart/form-data">
                <div id="profile_picture">
                 
               		<h3>Change Profile Picture</h3>
                        
        				<?php
                        if(!empty ($company['logo_location'])) {
                            $image = $company['logo_location'];
                            echo "<img src='$image'>";
                        }
                        ?>
                        
                        <input type="file" name="myfile" />
                        <?php if($image != 'avatars/default_avatar.png'){ ?>
	                            <br>
	                            <input type="checkbox" name="use_default" id="use_default" /> 
	                            <label for="use_default">Use default picture</label>
	                        <?php 
                        }
                        ?>
                    </ul>
                </div>
            
            	<div id="profile-info">
	            	<h3 >Change Profile Information </h3>

	                    	<h4>LinkedIn Profile:</h4>
	                    	<span class="linked_in"></span>
	                    	<input type="text" class="form-control" name="company_linked_in_profile" value="<?php if (isset($_POST['company_linked_in_profile']) ){echo htmlentities(strip_tags($_POST['company_linked_in_profile']));} else { echo $company['company_linked_in_profile']; }?>">

	                        <h4>Company Bio:</h4>
	                        <textarea name="company_bio"><?php if (isset($_POST['company_bio']) ){echo htmlentities(strip_tags($_POST['company_bio']));} else { echo $company['company_bio']; }?></textarea> 

	                        <h4>Company Headquarters:</h4>
	                        <textarea name="company_hq"><?php if (isset($_POST['company_hq']) ){echo htmlentities(strip_tags($_POST['company_hq']));} else { echo $company['company_hq']; }?></textarea> 
            	</div>
            	<hr>
                <input type="submit" name="submit" value="Update" class="btn btn-primary btn-lg">
               	<hr>
            </form>

    </div> <!-- /container -->
</div>

		<!-- FOOTER -->
      <?php include 'includes/footer.php'; ?>
</body>
</html>
