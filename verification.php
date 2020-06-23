<?php

include 'core/init.php';
$user_id = $_SESSION['user_id'];
$user    = $userObj->userData($user_id);
$verifyObj->authOnly();


if (isset($_POST['email'])) {
	$link    = Verify::generateLink();
	$message = "$user->firstName $user->lastName, Account has been created. Visit this link to verify account .<a href='http://localhost/login-reg/verification/{$link}'>Verification Link</a>";
	$subject = "Account Verifiction";
	$verifyObj->sendToMail($user->email, $message, $subject);
	$userObj->insert('verification', array('user_id' => $user_id, 'code' => $link));
	$userObj->redirect('verification?mail=sent');
}

if(isset($_GET['verify'])){
	$code = Validate::escape($_GET['verify']);
	$verify = $verifyObj->verifyCode($code);

	if($verify){
		if(date('Y-m-d', strtotime($verify->createdAt)) < date('Y-m-d')){
			$errors['verify'] = "Your verification link has been expired";
		}else{
			$userObj->update('verification',array('status' => '1'), array('user_id' => $user_id,'code' => $code));
			$userObj->redirect('home.php');
		}
	}else{
		$errors['verify'] = "Invalid verification link";
	}
}

if (isset($_POST['phone'])) {
	$number = Validate::escape($_POST['number']);
  
	if (!empty($number)) {
		if (!preg_match('/^[0-9]+$/', $number)) {  //  '/^[0-9]{11}+$/' /'([+]?\d{1,2}[.-\s]?)?(\d{3}[.-]?){2}\d{7}'/
			$errors['phone'] = "Only Valid numbers are allowed";
		} else {
			$number = urlencode($number);
			$code = $verifyObj->generateCode();
			$message = "Hello $user->firstName $user->lastName, Your Account Verification Code is: {$code}";
			$result = $verifyObj->sendToPhone($number, $message);
			$userObj->insert('verification', array('user_id' => $user_id, 'code' => $code));

			if ($result) {
				$userObj->update('users', array('phone' => $number), array('user_id' => $user_id));
				$userObj->redirect('verification/phone');
			} else {
				$errors['phone'] = "Something went wrong, try other methods.";
			}
		}
		
	} else {
		$errors['phone'] = "Enter your number to get verification code!";
	}
	
}

?>

<!DOCTYPE html>
<html>

<head>
	<title>Verification</title>
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css" />
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">

</head>

<body class="body2">
	<div class="p2-wrapper">
		<div class="sign-up-wrapper">
			<div class="sign-up-inner">
				<div class="sign-up-div">
					<div class="name">
						<?php
						if (isset($_GET['verify']) || !empty($_GET['verify'])) {
							if (isset($errors['verify'])) {
								echo '<h4>'.$errors['verify'].'</h4>';
							}

						} else { ?>
						<h4>Your account has been created, you need to activate your account by following methods:</h4>
						<fieldset>
							<legend>Method 1</legend>
							<?php if (isset($_GET['mail'])) : ?>
								<h4>A Verification Code has been sent to your email. Check email to verify your account.</h4>
							<?php else : ?>
								<h4>Email verificaiton</h4>
								<form method="POST">
									<input type="email" name="email" disabled placeholder="User email" value="<?php echo $user->email; ?>" />
									<button type="submit" name="email" class="suc">Send me verification email</button>
								</form>
							<?php endif; ?>
						</fieldset>
					</div>
					<!-- Email error field -->
					<?php if (isset($errors['email'])) : ?>
						<span class="error-in"><b><?php echo $errors['email']; ?></b></span>
					<?php endif; ?>

					<fieldset>
						<legend>Method 2</legend>
						<div>
							<h3>Phone verificaiton</h3>
							<form method="POST">
								<input type="tel" name="number" placeholder="Enter your Phone number" value="<?php echo $user->phone; ?>" />
								<button type="submit" name="phone" class="suc">Send verification code via SMS</button>
							</form>
						</div>
					</fieldset>
					<!-- Phone error field -->
					<?php if (isset($errors['phone'])) : ?>
						<span class="error-in"><b><?php echo $errors['phone']; ?></b></span>
					<?php endif; ?>
				</div>
					<?php } ?>
			</div>
		</div>
	</div>
	<!--WRAPPER ENDS-->
</body>

</html>