<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>inpu testes</title>        
        <meta name="description" content="">
        <meta name="mcquery-token" content="<?= token() ?>" />
        <script src="<?= URL ?>/js/jquery.min.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="">
    </head>
    <body>
        <form id="form" method="POST" action="<?= route('ajax') ?>">
            <?= token_input() ?>
            <input value="<?= old('nome') ?>" type="text" name="nome" placeholder="nome">
            <input value="<?= old('email') ?>" type="text" name="email" placeholder="email">
            <input type="submit" value="enviar">
        </form>
        <div id="result"></div>
    </body>    

    <script>  
        $('#form').submit(function(e){
            e.preventDefault();  
            $.ajax({                
                type: $(this).attr('method'),
             
                url: $(this).attr('action'),    
                // headers: {'MCQUERY-TOKEN': $('meta[name="mcquery-token"]').attr('content')},     
                data: $(this).serialize(),    
                       
                success:function(result){
                    console.log(result);
                    $("#result").html(result);
                }
            });  
        });     
    </script>
</html>