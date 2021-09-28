<?php
    header('content-type text/html charset=utf-8');
    session_start();

    if(!empty($_POST)){
        require_once "Captcha.php";
        $captcha = new Captcha();
        $response = $captcha->check($_POST['answer']);
        echo $response? 'ok' : 'ko';
    }
?>
