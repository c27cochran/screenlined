<?php
require 'core/init.php';
$general->logged_in_protect();

if (empty($_POST) === false) {

	$email = trim($_POST['email']);
	$password = trim($_POST['password']);

	if (empty($email) === true || empty($password) === true) {
		$errors[] = 'Sorry, but we need your email and password.';
	} else if ($users->email_exists($email) === false) {
		$errors[] = 'Sorry that email doesn\'t exist.';
	} else if ($users->email_confirmed($email) === false) {
		$errors[] = 'Sorry, but you need to activate your account. 
					 Please check your email.';
	} else {
		if (strlen($password) > 18) {
			$errors[] = 'The password should be less than 18 characters, without spacing.';
		}
		$login = $users->login($email, $password);
		if ($login === false) {
			$errors[] = 'Sorry, that email/password is invalid';
		}else {
			$profile_data 	= array();
			$user_id 		= $users->fetch_info('user_id', 'email', $email); // Getting the user's id from the email in the Url.
			$profile_data	= $users->userdata($user_id);

			session_regenerate_id(true);// destroying the old session id and creating a new one
			$_SESSION['id'] =  $login;
			header('Location: profile?user='.$profile_data['user_id'].'');
			exit();
		}
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
	<title>Login</title>
</head>
<body>	
	<?php include 'includes/menu.php'; ?>
	<div id="wrap">
	<div class="container container-white">
		<?php 
		if(empty($errors) === false){
			echo '<p class="errors">' . implode('</p><p class="errors">', $errors) . '</p>';	
		}
		?>

		<a href="auth">Login With LinkedIn (Beta)</a>

			<form method="post" action="" class="form-signin" role="form">
        		<h2 class="form-signin-heading">Please sign in</h2>
        		<input type="text" class="form-control" placeholder="Email address" name="email" value="<?php if(isset($_POST['email'])) echo htmlentities($_POST['email']); ?>" required autofocus>
        		<input type="password" name="password" class="form-control" placeholder="Password" required>
        		<input type="submit" name="submit" class="btn btn-primary btn-lg btn-block" value="Sign In">
        		<br>
				<a href="confirm-recover" class="form-signin">Forgot your username/password?</a>
      		</form>

    </div> <!-- /container -->
</div>

	<!-- FOOTER -->
    <?php include 'includes/footer.php'; ?>
</body>
</html>