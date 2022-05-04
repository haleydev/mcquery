<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?= ROOT ?>/favicon.ico" type="image/x-icon"> 
    <link rel="stylesheet" href="<?= ROOT ?>/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= ROOT ?>/css/main.css">  

    <title><?= $title ?></title>
</head>
<body> 

<div class="main">
    
@include($view)

</div> 

</body>
</html>