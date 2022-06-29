<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?= URL ?>/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="<?= URL ?>/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= URL ?>/css/main.css">
    <script src="<?= URL ?>/js/jquery.min.js"></script>
    <title>MCQUERY</title>
</head>
<body>
    
<div class="main">
    
   <img class="logo" src="<?= URL ?>/img/logo.png">

   <div class="info">
      <p>Bem vindo ao mcquery , leia a <a href="https://github.com/haleydev/mcquery">documentação</a> e crie algo grande!</p>
   </div>   
  
   <div class="div-versão">
      <p class="versao">mcquery v2.4.00 beta - PHP <?= phpversion() ?></p>
   </div>  

</div>

{{ $echo }}
<script src="<?= URL ?>/js/bootstrap.min.js"></script>
</body>
</html>