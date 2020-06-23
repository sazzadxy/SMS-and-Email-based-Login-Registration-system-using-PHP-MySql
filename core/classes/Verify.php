<?php

use PHPMailer\PHPMailer\PHPMailer;

class Verify 
{

    private $db, $user;

    public function __construct()
    {
        $this->db = Database::instance();
        $this->user = new Users;
    }

    public static function generateLink()
    {
        return str_shuffle(substr(md5(time().mt_rand().time()), 0, 25));
    }

    public function generateCode()
    {
        return mb_strtoupper(substr(md5(mt_rand().time()),0,6)) ;
    }


    public function verifyCode($code)
    {
        return $this->user->get('verification', array('code' => $code));
    }

    public function verifyResetCode($code)
    {
        return $this->user->get('recovery', array('code' => $code));
    }

    public function authOnly()
    {
        $user_id = $_SESSION['user_id'];
        $stmt = $this->db->prepare("SELECT * FROM `verification` WHERE `user_id` = :user_id ORDER BY `createdAt` DESC" );
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_OBJ);
        $files = array('verification.php','phoneVerification.php');

        if (!$this->user->isLoggedIn()) {
            $this->user->redirect('index.php');
        }

        if (!empty($user)) {
            if ($user->status === '0' && !in_array(basename($_SERVER['SCRIPT_NAME']), $files)) {
                $this->user->redirect('verification');
            }

            if ($user->status === '1' && in_array(basename($_SERVER['SCRIPT_NAME']), $files)) {
                $this->user->redirect('home.php');
            }
        } elseif (!in_array(basename($_SERVER['SCRIPT_NAME']), $files)) {
            $this->user->redirect('verification');
            //$this->user->redirect('index.php');
        }    
    }

    public function sendToMail($email, $message, $subjecct)
    {

        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPDebug = 0;
        $mail->isHTML(true);
        $mail->Host = MAIL_HOST;
        $mail->Username = MAIL_USERNAME;
        $mail->Password = MAIL_PASSWORD;
        $mail->SMTPSecure = MAIL_SMTPSECURE;
        $mail->Port = MAIL_PORT;

        if (!empty($email)) {
            $mail->From = "your email address";
            $mail->FromName = "Admin";
            $mail->addReplyTo('noreplay@yourdomainemail.com');
            $mail->addAddress($email);

            $mail->Subject    = $subjecct;
            $mail->Body       = $message;
            $mail->AltBody    = $message;

            if (!$mail->send()) {
                return false;
            } else {
                return true;
            }

        }
    }

    public function sendToPhone($number, $message)  
    {
        $username = "Your textlocal email";
        $apiHash  = "Your textlocal api";
        $apiUrl   = "https://api.txtlocal.com/send/";
        $test     = '0';
        $data     = "username={$username}&hash={$apiHash}&message={$message}&numbers={$number}&test={$test}";

        if(!empty($number)){
            $ch = curl_init($apiUrl);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $respone = curl_exec($ch);

            $result = json_decode($respone);
            if($result->status === 'success'){
                return true;
            }else{
                return false;
            }
        }
        }
}

