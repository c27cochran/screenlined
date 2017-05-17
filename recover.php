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
    <title>Recover Password</title>
</head>
<body>
        <?php include 'includes/menu.php'; ?>
        <div id="wrap">
        <div class="container container-white">
    	<?php
        if (isset($_GET['success']) === true && empty ($_GET['success']) === true) {
            ?>
            <h3>Thank you, we've send you a randomly generated password in your email.</h3>
            <?php
            
        } else if (isset ($_GET['email'], $_GET['generated_string']) === true) {
            
            $email		=trim($_GET['email']);
            $string	    =trim($_GET['generated_string']);	
            
            if ($users->email_exists($email) === false || $users->recover($email, $string) === false) {
                $errors[] = 'Sorry, something went wrong and we couldn\'t recover your password.';
            }
            
            if (empty($errors) === false) {    		

        		echo '<p class="errors">' . implode('</p><p>', $errors) . '</p>';
    			
            } else {

                header('Location: recover?success');
                exit();
            }
        
        } else {
            header('Location: index'); // If the required parameters are not there in the url. redirect to index
            exit();
        }
        ?>
    </div>
</div>
    <!-- FOOTER -->
    <?php include 'includes/footer.php'; ?>
</body>
</html>