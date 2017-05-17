<?php 
include_once 'core/init.php';
$general->logged_out_protect();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <?php include 'includes/bootstrap.php'; ?>
    <title>Change Password</title>
</head>
<body>
    	<?php
        include 'includes/menu.php';
        if(empty($_POST) === false) {
           
            if(empty($_POST['current_password']) || empty($_POST['password']) || empty($_POST['password_again'])){

                $errors[] = 'All fields are required';

            }else if($bcrypt->verify($_POST['current_password'], $user['password']) === true) {

                if (trim($_POST['password']) != trim($_POST['password_again'])) {
                    $errors[] = 'Your new passwords do not match';
                } else if (strlen($_POST['password']) < 6) { 
                    $errors[] = 'Your password must be at least 6 characters';
                } else if (strlen($_POST['password']) >18){
                    $errors[] = 'Your password cannot be more than 18 characters long';
                } 

            } else {
                $errors[] = 'Your current password is incorrect';
            }
        }

        if (isset($_GET['success']) === true && empty ($_GET['success']) === true ) {
    		echo '<p>Your password has been changed!</p>';
        } else {?>

        <div id="wrap">
        <div class="container container-white">

        <div class="jumbotron">
            <h2>Change Password</h2>
        </div>    
            <hr />
            
            <?php
            if (empty($_POST) === false && empty($errors) === true) {
                $users->change_password($user['user_id'], $_POST['password']);
                header('Location: change-password.php?success');
            } else if (empty ($errors) === false) {
                    
                echo '<p>' . implode('</p><p>', $errors) . '</p>';  
            
            }
            ?>
            <form action="" method="post" class="form-signin" role="form">
                <input type="password" class="form-control" name="current_password" placeholder="Current Password" required autofocus>
                <input type="password" class="form-control" name="password" placeholder="New Password" required>
                <input type="password" class="form-control" name="password_again" placeholder="New Password" required>
                <input type="submit" name="submit" class="btn btn-primary btn-lg btn-block" value="Change password">
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