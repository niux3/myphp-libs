<?php
    session_start();
    require_once './Captcha.php';

    $captcha = new Captcha();
    $response_captcha = $captcha->getCaptcha('captcha.png');
    $_SESSION = $response_captcha;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/foundation-sites@6.6.3/dist/css/foundation-float.min.css" integrity="sha256-4ldVyEvC86/kae2IBWw+eJrTiwNEbUUTmN0zkP4luL4=" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/foundation-sites@6.6.3/dist/css/foundation-prototype.min.css" integrity="sha256-BiKflOunI0SIxlTOOUCQ0HgwXrRrRwBkIYppEllPIok=" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/foundation-sites@6.6.3/dist/css/foundation-rtl.min.css" integrity="sha256-F+9Ns8Z/1ZISonBbojH743hsmF3x3AlQdJEeD8DhQsE=" crossorigin="anonymous">
    <style>
        .container{
            max-width: 600px;
            width: 100%;
            margin: 50px auto;
        }
        img{
            width: 100%;
            height: 39px;
            display: block;
        }
        input[type="submit"]{
            width: 100%;
        }
        input{
            margin: 0 !important;
        }
    </style>
</head>
<body>
    <div class="container">
        <form action="controller.php" method="post">
            <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
            <div class="grid-x grid-padding-x">
                <div class="cell small-3">
                    <img src="captcha.png" alt="captcha">
                </div>
                <div class="cell small-5">
                    <input type="text" name="answer">
                </div>
                <div class="cell small-4">
                    <input type="submit" class="button" value="envoyer">
                </div>
            </div>
        </form>
    </div>
</body>
</html>
