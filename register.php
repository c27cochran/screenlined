<?php 
require 'core/init.php';
$general->logged_in_protect();

if (isset($_POST['submit'])) {

	if(empty($_POST['username']) || empty($_POST['first_name']) || empty($_POST['last_name']) || empty($_POST['password']) || empty($_POST['email'])){

		$errors[] = 'All fields are required.';

	}else{
        
        if ($users->user_exists($_POST['username']) === true) {
            $errors[] = 'That username already exists';
        }
        if(!ctype_alnum($_POST['username'])){
            $errors[] = 'Please enter a username with only alphabets and numbers';	
        }
        if (strlen($_POST['first_name']) <2){
            $errors[] = 'Please your first name';
        } else if (strlen($_POST['first_name']) >50){
            $errors[] = 'Your name cannot be more than 50 characters long';
        }
        if (strlen($_POST['last_name']) <2){
            $errors[] = 'Please your last name';
        } else if (strlen($_POST['last_name']) >50){
            $errors[] = 'Your name cannot be more than 50 characters long';
        }
        if (strlen($_POST['password']) <6){
            $errors[] = 'Your password must be atleast 6 characters';
        } else if (strlen($_POST['password']) >18){
            $errors[] = 'Your password cannot be more than 18 characters long';
        }
        if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
            $errors[] = 'Please enter a valid email address';
        }else if ($users->email_exists($_POST['email']) === true) {
            $errors[] = 'That email already exists.';
        }
	}

	if(empty($errors) === true){
		
		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		$username = $_POST['username'];
		$password 	= $_POST['password'];
		$email 		= htmlentities($_POST['email']);

		$users->register($first_name, $last_name, $password, $email, $username);
		header('Location: register?success');
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
	<?php include 'includes/bootstrap.php'; ?>
	<title>Register</title>
</head>
<body>	
		<?php include 'includes/menu.php'; ?>
		<div id="wrap">
			<div class="container container-white">
		
		<?php
		if (isset($_GET['success']) && empty($_GET['success'])) {
		  echo '<h1>Thank you for registering. Please check your email.</h1>';
		}
		?>

		<form method="post" action="" class="form-signin" role="form">
			<h2 class="form-signin-heading">Register</h2>
			<input type="text" name="username" class="form-control" placeholder="Username" value="<?php if(isset($_POST['username'])) echo htmlentities($_POST['username']); ?>" required autofocus>
			<input type="text" name="first_name" class="form-control" placeholder="First Name" value="<?php if(isset($_POST['first_name'])) echo htmlentities($_POST['first_name']); ?>" required>
			<input type="text" name="last_name" class="form-control" placeholder="Last Name" value="<?php if(isset($_POST['last_name'])) echo htmlentities($_POST['last_name']); ?>" required>
			<input type="text" name="email" class="form-control" placeholder="Email Address" value="<?php if(isset($_POST['email'])) echo htmlentities($_POST['email']); ?>" required>	
			<input type="password" name="password" class="form-control" placeholder="Password" required>
			<input type="submit" name="submit" class="btn btn-primary btn-lg btn-block" value="Register" />
		</form>
		<br>

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

