<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?= URL ?>/favicon.ico" type="image/x-icon">  
    <script src="<?= URL ?>/js/jquery.min.js"></script>
    <link rel="stylesheet" href="<?= URL ?>/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= URL ?>/css/main.css">  
    <title><?= $title ?></title>
</head>
<body> 

<div class="main">
    
@include($view)

</div> 

<script src="<?= URL ?>/js/bootstrap.min.js"></script>
</body>
</html>