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
    <title>Account Activation</title>
</head>
<body>  
    <?php include 'includes/menu.php'; ?>
    <div id="wrap">
        <div class="container container-white">
            <div class="jumbotron">
                <h1>Activate your account</h1>
            </div>

        <?php
        
        if (isset($_GET['success']) === true && empty ($_GET['success']) === true) {
            
                
        } else if (isset ($_GET['email'], $_GET['email_code']) === true) {
            $email      =trim($_GET['email']);
            $email_code =trim($_GET['email_code']); 
            
            if ($users->email_exists($email) === false) {
                $errors[] = 'Sorry, we couldn\'t find that email address';
            } else if ($users->activate($email, $email_code) === false) {
                $errors[] = 'Sorry, we have failed to activate your account';
            }
            
            if(empty($errors) === false){
            
                echo '<p class="errors">' . implode('</p><p class="errors">', $errors) . '</p>';  
        
            } else {
                echo "<h3>Thank you, we've activated your account. You're free to <a href='login'>log in</a>!</h3>";
                header('Location: activate?success');
                exit();
            }
        
        } else {
            header('Location: index');
            exit();
        }
        ?>

    </div>
</div>
    <!-- FOOTER -->
    <?php include 'includes/footer.php'; ?>
</body>
</html>