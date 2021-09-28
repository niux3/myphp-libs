<?php
    $files = array_filter(scandir('.'), function($item){
        return strstr($item, 'example');
    });
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <ul>
        <?php foreach($files as $file): ?>
        <li><a href="./<?= $file ?>"><?= substr($file, 0, strrpos($file, '.')) ?></a></li>
        <?php endforeach ?>
    </ul>
</body>
</html>
