<?php
require 'core/init.php';
$general->company_logged_in_protect();

$email 	= $company['company_email'];

if (empty($_POST) === false) {

	$username = trim($_POST['username']);
	$password = trim($_POST['password']);
	$name = trim($_POST['name']);
	$employee_name = trim($_POST['employee_name']);

	if (empty($username) === true || empty($password) === true || empty($name) === true) {
		$errors[] = 'Sorry, but we need your company name, username and password.';
	} else if ($companies->company_exists($username) === false) {
		$errors[] = 'Sorry that username doesn\'t exist.';
	} else {
		if (strlen($password) > 18) {
			$errors[] = 'The password should be less than 18 characters, without spacing.';
		}
		$login = $companies->company_login($name, $username, $password);
		if ($login === false) {
			$errors[] = 'Sorry, those credentials invalid';
		}else {
			session_regenerate_id(true);// destroying the old session id and creating a new one
			$_SESSION['company_id'] =  $login;
			$_SESSION['employee_name']=$employee_name;
			$company_data 	= array();
			$company_id 	= $companies->company_fetch_info('company_id', 'company_name', $name); // Getting the user's id from the email in the Url.
			$company_data	= $companies->companydata($company_id);
			header('Location: company-profile?company='.$company_data['company_id'].'');
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

			<form method="post" action="" class="form-signin" role="form">
        		<h2 class="form-signin-heading">Please sign in</h2>
        		<input type="text" class="form-control" name="employee_name" placeholder="Your Name (not required)" value="<?php if(isset($_POST['employee_name'])) echo htmlentities($_POST['employee_name']); ?>" autofocus>
        		<input type="text" class="form-control" placeholder="Company Name" name="name" required>
        		<input type="text" class="form-control" placeholder="Username" name="username" value="<?php if(isset($_POST['username'])) echo htmlentities($_POST['username']); ?>" required>
        		<input type="password" name="password" class="form-control" placeholder="Password" required>
        		<input type="submit" name="submit" class="btn btn-primary btn-lg btn-block" value="Sign In"/>
      		</form>

    </div> <!-- /container -->	
</div>

	<!-- FOOTER -->
    <?php include 'includes/footer.php'; ?>
</body>
</html>