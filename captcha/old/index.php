<?php
    session_start();
    require_once "./AsciiCaptcha.php";

    $ascii_captcha = new AsciiCaptcha();
    $_SESSION = $ascii_captcha->getCaptcha()
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <!-- foundation-float.min.css: Compressed CSS with legacy Float Grid -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/foundation-sites@6.6.3/dist/css/foundation-float.min.css" integrity="sha256-4ldVyEvC86/kae2IBWw+eJrTiwNEbUUTmN0zkP4luL4=" crossorigin="anonymous">

    <!-- foundation-prototype.min.css: Compressed CSS with prototyping classes -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/foundation-sites@6.6.3/dist/css/foundation-prototype.min.css" integrity="sha256-BiKflOunI0SIxlTOOUCQ0HgwXrRrRwBkIYppEllPIok=" crossorigin="anonymous">

    <!-- foundation-rtl.min.css: Compressed CSS with right-to-left reading direction -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/foundation-sites@6.6.3/dist/css/foundation-rtl.min.css" integrity="sha256-F+9Ns8Z/1ZISonBbojH743hsmF3x3AlQdJEeD8DhQsE=" crossorigin="anonymous">
    <style>
        .container{
            max-width: 600px;
            width: 100%;
            margin: 50px auto;
        }
        pre{
            font-size: 5px;
        }
        .wrap{
            display: flex;
        }
        input[type="submit"]{
            width: 100%;
        }
        img{
            min-width: 300px;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="./image.php" alt="">
        <form action="controller.php" method="post">
            <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
            <div class="grid-x grid-padding-x">
                <div class="cell small-3 wrap">
                    <?php foreach($_SESSION['captcha'] as $v): ?>
                        <pre><?= $v ?></pre>
                    <?php endforeach; ?>
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
