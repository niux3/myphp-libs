<?php
    session_start();
    if(!empty($_POST)){
        require_once "AsciiCaptcha.php";
        $salt = AsciiCaptcha::getSalt();
        if($_POST['token'] === hash('sha256', $_POST['answer'].$salt) && $_POST['answer'] === implode(array_keys($_SESSION['captcha']), '')){
            echo 'ok';
        }else{
            echo 'ko';
        }
    }
?>
