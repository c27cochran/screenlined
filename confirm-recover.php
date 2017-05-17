<?php
require 'core/init.php';
$general->logged_in_protect();
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
	<title>Confirm password recover</title>
</head>
<body>	
		<?php include 'includes/menu.php'; ?>
		<div id="wrap">
		<div class="container container-white">
		<?php
		if (isset($_GET['success']) === true && empty($_GET['success']) === true) {
			?>	
			<h3>Thanks, please check your email to confirm your request for a password.</h3>
			<?php
		} else {
			?>
		    <h2>Recover Username / Password</h2>
		    <p>Enter your email below so we can confirm your request.</p>
		    <hr />
		    <?php
			if (isset($_POST['email']) === true && empty($_POST['email']) === false) {
				if ($users->email_exists($_POST['email']) === true){
					$users->confirm_recover($_POST['email']);

					header('Location:confirm-recover?success');
					exit();
					
				} else {
					echo 'Sorry, that email doesn\'t exist.';
				}
			}
			?>
			<form action="" method="post">
				<input type="text" required name="email">
				<br>
				<input type="submit" value="Recover" class="btn btn-primary btn-lg">
			</form>
			<?php	
		}
		?>

	</div>
	</div>
	<!-- FOOTER -->
    <?php include 'includes/footer.php'; ?>
</body>
</html>