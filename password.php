<?php
include 'core/init.php';

if (isset($_GET['passwod']) || isset($_GET['verify'])) {
	if (!empty($_GET['passwod']) || !empty($_GET['verify'])) {
		$code = Validate::escape($_GET['verify']);
		$verify = $verifyObj->verifyResetCode($code);

		if ($verify) {
			if (date('Y-m-d', strtotime($verify->createdAt)) < date('Y-m-d')) {
				$errors['verify'] = "Your password reset link has been expired";
			} else {
				$userObj->update('recovery', array('status' => '1'), array('user_id' => $verify->user_id, 'code' => $code));
			}
		} else {
			$errors['verify'] = "Invalid password reset link";
		}
	} else {
		$userObj->redirect('index.php');
	}
}

if (isset($_POST['reset'])) {
	$password = $_POST['rPassword'];
	$rePassword = $_POST['rPasswordAgain'];

	if (!empty($password) && !empty($rePassword)) {
		if ($password !== $rePassword) {
			$errors['reset'] = "Password doesn't match!";
		} elseif (Validate::length($password, 20, 6)) {
			$errors['reset'] = "Password needs to be between 6-20 characters long";
		} else {
			$hash =$userObj->hash($password);
			$user = $userObj->update('users', array('password' => $hash), array('user_id' => $verify->user_id));
			$userObj->redirect('password.php?success=true');
		}
	} else {
		$errors['reset'] = "Enter your new password";
	}
	
}


?>

<!DOCTYPE html>
<html>

<head>
	<title>Create New Password</title>
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css" />
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">

</head>

<body class="body">
	<div class="home-nav">
		<a href="<?php echo BASE_URL; ?>home.php">Home</a>
	</div>
	<div class="wrapper">
		<div class="header-wrapper">
			<h1>Reset your password</h1>
			
		</div>
		<!--HEADER WRAPPER ENDS-->
		<div class="sign-div">
			<div class="sign-in">
				<?php if (isset($_GET['success'])) : ?>
					<div class="success-message">Your password has been changed. Now <a href="http://localhost/login-reg">Log in</a></div>
				<?php else : ?>
					<div class="signIn-inner">
						<?php if (isset($errors['verify'])) : ?>
							<center>
								<div class="success-message"><?php echo $errors['verify']; ?></div>
							</center>
						<?php else : ?>
							<center>
								<div class="success-message"><h4>Enter your new password to change!</h4></div>	
							</center>
							<form method="POST">
								<div class="input-div">
									<input type="password" name="rPassword" placeholder="Password">
									<input type="password" name="rPasswordAgain" placeholder="Confirm Password">
									<button type="submit" name="reset">Reset</button>
							</form>
					</div>
					<?php if (isset($errors['reset'])) : ?>
						<div class="error shake-horizontal"><?php echo $errors['reset']; ?></div>
					<?php endif; ?>
				<?php endif; ?>
			<?php endif; ?>
			</div>
		</div>
	</div>
	<!--CONTENT WRAPPER ENDS-->
	<div class="footer-wrapper">

	</div>
	<!--FOOTER WRAPPER ENDS-->
	</div>
	<!--WRAPPER ENDS-->
</body>

</html>