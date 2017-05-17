<?php 
include_once 'core/init.php';
$general->logged_out_protect();

$email = $user["email"];
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
	<script src="js/tinymce/tinymce.min.js"></script>
	<script>
        tinymce.init({selector:'textarea'});
	</script>
    <title>Settings</title>    
</head>
<body>
		<?php include 'includes/menu.php'; ?>

		<?php
	    if (isset($_GET['success']) && empty($_GET['success'])) {
	                
	    } else{
 
            if(empty($_POST) === false) {		
			
				if (isset($_POST['first_name']) && !empty ($_POST['first_name'])){ // We only allow names with alphabets
					if (ctype_alpha($_POST['first_name']) === false) {
					$errors[] = 'Please enter your First Name with only letters!';
					}	
				}
				if (isset($_POST['last_name']) && !empty ($_POST['last_name'])){
					if (ctype_alpha($_POST['last_name']) === false) {
					$errors[] = 'Please enter your Last Name with only letters!';
					}	
				}
				if (isset($_POST['linked_in_profile']) && !empty ($_POST['linked_in_profile'])){
					if(!strstr($_POST['linked_in_profile'], 'www.linkedin.com')) {
	    			$errors[] = 'Invalid LinkedIn Profile Link';
	    			}
				}

				if (isset($_FILES['resume']) && !empty($_FILES['resume']['name'])) {// check if the user has uploaded a new file
					
					$name 			= $_FILES['resume']['name']; // getting the name of the file
					$tmp_name 		= $_FILES['resume']['tmp_name']; // getting the temporary file name.
					$allowed_ext 	= array('pdf' );// specifying the allowed extentions
					$a 				= explode('.', $name);
					$file_ext 		= strtolower(end($a)); unset($a);// getting the allowed extenstions
					$file_size 		= $_FILES['resume']['size'];
					$path 			= "resumes";// the folder in which we store the profile pictures or avatars of the user.
					
					if (in_array($file_ext, $allowed_ext) === false) {
						$errors[] = 'Image file type not allowed';	
					}
					
					if ($file_size > 2097152) {
						$errors[] = 'File size must be under 2mb';
					}
					
				} else {
					$resume_path = $user['resume_location']; // if user did not upload a file, then use the one stored in the database
				}
 
				if(empty($errors) === true) {
					
					if (isset($_FILES['resume']) && !empty($_FILES['resume']['name']) && $_POST['use_default'] != 'on') {
				
						$resume_path = $general->file_newpath($path, $name);
 
						move_uploaded_file($tmp_name, $resume_path);
 
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
					$newpath = $user['image_location']; // if user did not upload a file, then use the one stored in the database
				}
 
				if(empty($errors) === true) {
					
					if (isset($_FILES['myfile']) && !empty($_FILES['myfile']['name']) && $_POST['use_default'] != 'on') {
				
						$newpath = $general->file_newpath($path, $name);
 
						move_uploaded_file($tmp_name, $newpath);
 
					}else if(isset($_POST['use_default']) && $_POST['use_default'] === 'on'){
                        $newpath = 'avatars/default_avatar.png';
                    }
							
					$first_name 	= htmlentities(trim($_POST['first_name']));
					$last_name 		= htmlentities(trim($_POST['last_name']));
					$city 			= htmlentities(trim($_POST['city']));
					$state  		= htmlentities(trim($_POST['state']));	
					$bio 			= html_entity_decode(trim($_POST['bio']));
					$skills			= html_entity_decode(trim($_POST['skills']));
					$linked_in_profile 		= htmlentities(trim($_POST['linked_in_profile']));
					$image_location	= htmlentities(trim($newpath));
					$resume_location= htmlentities(trim($resume_path));
					
					$users->update_user($first_name, $last_name, $city, $state, $bio, $skills, $image_location, $resume_location, $linked_in_profile, $user_id);

					echo '<div class="container container-white"><h3>Your <a href="profile?user='.$user_id.'">Profile</a> has been updated!</h3></div>';	

					header('Location: settings?success');
					exit();
				
				} else if (empty($errors) === false) {
					echo '<p class="errors">' . implode('</p><p>', $errors) . '</p>';	
				}	
            }
    		?>
    <div id="wrap">		
      <div class="container container-white">

      <div class="jumbotron">
      	<h2>Edit Profile</h2> <p><b>Note: Information you post here is made viewable to others.</b></p>
      </div>

            <hr />
 
            <form action="" method="post" enctype="multipart/form-data">
                <div id="profile_picture">
                 
               		<h3>Change Profile Picture</h3>
                        
        				<?php
                        if(!empty ($user['image_location'])) {
                            $image = $user['image_location'];
                            echo "<img src='$image'>";
                        }
                        ?>
                        
                        <input type="file" name="myfile" />
                        <?php if($image != 'avatars/default_avatar.png'){ ?>
	                        <br>
	                            <input type="checkbox" name="use_default" id="use_default" /> <label for="use_default">Use default picture</label>
	                        <?php 
                        }
                        ?>
                </div>

                <div id="resume">
                 
               		<h3>Upload Resume</h3>
               		<span>PDF format only</span>
                        
        				<?php
                        if(!empty ($user['resume_location'])) {
                            $resume = $user['resume_location'];
                        }
                        ?>

                        <input type="file" name="resume" />
                </div>

                <div id="edit-video-cover-letter">
                 
               		<h3>Video Cover Letter</h3>
					<a href="video-cover-letters/video-cover-letter?username=<?php echo $user['username'];?>">Add a video cover letter!</a>
                </div>
            
            	<div id="personal_info">
	            	<h3 >Change Profile Information </h3>

	                        <h4>First name:</h4>
	                        <input type="text" class="form-control" name="first_name" value="<?php if (isset($_POST['first_name']) ){echo htmlentities(strip_tags($_POST['first_name']));} else { echo $user['first_name']; }?>">

	                        <h4>Last name: </h4>
	                        <input type="text" class="form-control" name="last_name" value="<?php if (isset($_POST['last_name']) ){echo htmlentities(strip_tags($_POST['last_name']));} else { echo $user['last_name']; }?>">

	                        <h4>Location:</h4>
	                        <label for="city">City</label>
	                        <input type="text" class="form-control" name="city" value="<?php if (isset($_POST['city']) ){echo htmlentities(strip_tags($_POST['city']));} else { echo $user['city']; }?>">
	                        <label for="state">State</label>
	                        <?php 
	                        $states = $users->statesList();  
    							echo '<select name="state">';  
        							echo '<option selected="selected">Select your state...</option>';  
        							foreach($states as $key=>$value) {  
                							echo '<option value="'.$key.'">'.$value.'</option>';  
        							}  
    							echo '</select>';  
							?>

	                    	<h4>LinkedIn Profile</h4>
	                    	<span class="linked_in"></span>
	                    	<input type="text" class="form-control" name="linked_in_profile" value="<?php if (isset($_POST['linked_in_profile']) ){echo htmlentities(strip_tags($_POST['linked_in_profile']));} else { echo $user['linked_in_profile']; }?>">

	                        <h4>Cover Letter:</h4>
	                        <textarea name="bio"><?php if (isset($_POST['bio']) ){echo htmlentities(strip_tags($_POST['bio']));} else { echo $user['bio']; }?></textarea>

	                        <h4>Special Skills:</h4>
	                        <textarea name="skills"><?php if (isset($_POST['skills']) ){echo htmlentities(strip_tags($_POST['skills']));} else { echo $user['skills']; }?></textarea>
   
            	</div>
            	<div class="clear"></div>
            	<hr>
                    <input type="submit" value="Update" class="btn btn-primary btn-lg">
               <hr>
            </form>
    </div>
	</div>
    <!-- FOOTER -->
    <?php include 'includes/footer.php'; ?>
</body>
</html>
<?php
}
?>	