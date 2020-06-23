<?php

use PHPMailer\PHPMailer\PHPMailer;
date_default_timezone_set('Asia/Dhaka');
include 'config.php';
include 'classes/PHPMailer.php';
include 'classes/SMTP.php';
include 'classes/Exception.php';


spl_autoload_register(function($class){
    require_once "classes/{$class}.php";
});

$userObj   = new Users;
$verifyObj = new Verify;

session_start();
?>