<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?= ROOT ?>/favicon.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
    <title><?= $title ?></title>
</head>
<body>   

<div class="main">
    <h1><?= $title ?></h1>
    <p class="inf-url"><?= router_error() ?></p>
</div> 

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        outline: none;
        -webkit-tap-highlight-color: rgba(255, 255, 255, 0);
        scroll-behavior: smooth;
        font-family: 'Lato', sans-serif;
        color: rgb(221, 221, 221);
    }

    body{
        background: rgb(31, 31, 31);
    }

    .inf-url{
        color: rgb(169 85 85);
        font-size: 14px;
        margin-top: 4px;
    }

    .main{
        padding: 0px 8px;
        display: flex;
        flex-direction: column;
        margin: 0 auto;
        justify-content: center;
        min-height: 90vh;
        align-items: center;
    }

    h1{
        text-align: center;
        text-transform: uppercase;
    }

    @media(max-width: 900px){
        h1{
            font-size: 20px;
        }
    }
</style>
</body>
</html>