<?php 
include 'core/init.php';
$user_id = $_SESSION['user_id'];
$user = $userObj->userData($user_id);
$verifyObj->authOnly();



if (isset($_POST['delete'])) {
    $required = array('password');
	foreach ($_POST as $key => $value) {
		if (empty($value) && in_array($key, $required)) {
			$errors['password'] = "Password is required!";
		break;
        }
    }

    if (empty($errors['password'])) {
        $password = $_POST['password'];
        if (password_verify($password, $user->password)) {
            $userObj->delete('users', array('user_id' => $user_id));
            $userObj->delete('verification', array('user_id' => $user_id));
            $userObj->redirect('thank.php');
            $userObj->logout();    
        } else {
            $errors['password'] = "Password is incorrect!";
        }
    }     
    
}


?>

<!DOCTYPE html>
<html>
<head>
	<title>Delete your account</title>
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css"/>
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">

</head>
<body class="body2">
<div class="home-nav">
	<a href="<?php echo BASE_URL; ?>home.php">Home</a>
</div>
<div class="p2-wrapper">
	<div class="sign-up-wrapper">
		<div class="sign-up-inner">
			<div class="sign-up-div">
			  <form method="POST">
				

				<div>
				<h3>Enter your password to delete your account</h3>
				<input type="password" name="password" placeholder="Password"/>
				
				<!-- Password Errors -->
				<?php if(isset($errors['password'])): ?>
				<span class="error-in"><?php echo $errors['password']; ?></span>
				<?php endif; ?>	
                </div>
                	
				<div class="btn-div">
				<button value="sign-up" name="delete">Delete</button>
				</div>
				</form>
			</div>
		</div>
	</div>
</div><!--WRAPPER ENDS-->
</body>
</html>