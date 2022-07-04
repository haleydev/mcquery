<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?= URL ?>/favicon.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
    <title><?= $title ?></title>
</head>
<body>   

<div class="main">
    <h1><?= $code ?></h1> 
</div> 

<div class="absolute"> 
    <p class="inf-msg" ><?= $msg ?></p>     
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

    .main{
        padding: 0px 8px;
        display: flex;
        flex-direction: column;
        margin: 0 auto;
        justify-content: center;
        min-height: 90vh;
        align-items: center;
    }

    .absolute {
        position: absolute;
        top: 10px;
        display: flex;
        flex-direction: column;
        width: 100%;
        align-items: center;
        justify-content: center;
    }

    body{
        background: rgb(31, 31, 31);
    }

    .inf-url{
        color: rgb(169 85 85);
        font-size: 16px;
    }

    .inf-msg {
        color: #bfbfbf;
        font-size: 20px;
        font-weight: bold;
        text-transform: uppercase;     
        margin-top: 5px; 
    }

    h1{
        padding: 5px 40px;
        text-align: center;
        text-transform: uppercase;
        font-size: 70px;
        border: 2px solid rgb(169 85 85);      
        border-radius: 60px;
    }
</style>
</body>
</html>