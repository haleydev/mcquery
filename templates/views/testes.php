@layout(main)
@set(title)->(pagina de testes)

@set(head)
    <meta name="mcquery-token" content="<?= token() ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="<?= URL ?>/js/jquery.min.js"></script>
@end(head)

@set(main)
    <form id="form" method="POST" action="<?= route('ajax') ?>">
        <?= token_input() ?>
        <input class="input-teste" value="<?= old('nome') ?>" type="text" name="nome" placeholder="nome"><?= validator('nome') ?>        
        <input class="input-teste" value="<?= old('email') ?>" type="text" name="email" placeholder="email"><?= validator('email') ?>      
        <input class="input-teste" value="<?= old('idade') ?>" type="text" name="idade" placeholder="idade"><?= validator('idade') ?>       
        <input type="submit" value="enviar">
    </form>   
    <div id="result"></div>

    <!-- <script>  
        $('#form').submit(function(e){
            e.preventDefault() 
            $.ajax({      
                headers: {'MCQUERY-TOKEN' : $('meta[name="mcquery-token"]').attr('content')},     
                url: $(this).attr('action'),          
                type: $(this).attr('method'),
                data: $(this).serialize(), 
                // dataType: "json",  
                success:function(result){
                    console.log(result);
                    $("#result").html(result.nome + '<br>' + result.email)
                }
            }) 
        })     
    </script> -->   

    <style>
        .error {
            color: #bf4b4b;
            font-size: 12px;
            display: flex;
            width: 100%;
            border-radius: 3px;
        }

        .input-teste {
            display: flex;
            width: 100%;
            color: white;
            border-radius: 4px;
            background: #3a3a3a;
            padding: 4px;
            border: none;
            margin-bottom: 2px;
            margin-top: 5px;
            border-bottom: 2px solid royalblue !important;
        }
    </style>
@end(main)