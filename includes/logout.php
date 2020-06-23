<?php
include '../core/init.php';

if (!$userObj->isLoggedIn()) {
    $userObj->redirect('home.php');
} else {
    $userObj->logout();
}

?>