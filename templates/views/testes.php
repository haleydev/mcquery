<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>inpu testes</title>
        <script src="<?= URL ?>/js/jquery.min.js"></script>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="">
    </head>
    <body>
        <form id="form" method="POST" action="<?= router('post') ?>">
            <?= validate() ?>
            <input type="text" name="nome" placeholder="nome">
            <input type="text" name="email" placeholder="email">
            <input type="submit" value="enviar">
        </form> 

        <div id="result"></div>

    </body>

    <script>
        $(function(){
            $('#form').submit(function(e){
                e.preventDefault();  
                $.ajax({
                    type: $(this).attr('method'),
                    url: $(this).attr('action'),                
                    data: $(this).serialize(),                    
                    success:function(result){
                        console.log(result);
                        $("#result").html(result);
                    }
                });  
            });
        });  
    </script>
</html>