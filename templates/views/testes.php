@layout(main)
@set(title)->(pagina de testes)

@set(head)
    <meta name="mcquery-token" content="<?= token() ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="<?= URL ?>/js/jquery.min.js"></script>
    <script src="<?= URL ?>/js/jquery.mask.js"></script>  
@end(head)

@set(main)
    <form class="form" id="form" method="POST" action="<?= route('ajax') ?>">
        <?= token_input() ?>
        <input class="input-teste" value="<?= old('nome') ?>" type="text" name="nome" placeholder="nome"><?= validator('nome') ?>        
        <input class="input-teste" value="<?= old('email') ?>" type="text" name="email" placeholder="email"><?= validator('email') ?>  
        <input class="input-teste" value="<?= old('idade') ?>" type="text" name="idade" placeholder="idade"><?= validator('idade') ?>  
        <input class="input-teste" value="<?= old('telefone') ?>" type="text" name="telefone" id="telefone" placeholder="telefone"><?= validator('telefone') ?>  
        <input class="input-teste" value="<?= old('url') ?>" type="text" name="url" placeholder="url"><?= validator('url') ?>      
        <input class="input-teste" value="<?= old('money') ?>" type="text" name="money" id="money" placeholder="money"><?= validator('money') ?>  
        <input class="submit" type="submit" value="enviar">
    </form>   
       
    <div id="result"></div>

    <br>
    <p><?= money($money) ?></p>
    <p><?= $money ?></p>
    

    <!-- testes -->
   

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
        .form {
            width: 600px;
            max-width: 85%;
            display: flex;
            flex-direction: column;
        }

        .error {
            margin-left: 15px;
            margin-bottom: 10px;
            width: 100%;
            display: flex;
            color: royalblue;
            font-size: 12px;
            display: flex;
            width: 100%;
            border-radius: 3px;
        }

        .input-teste {
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 0 2px 1px #b9add79c;
            width: 100%;
            color: #959595;
            border-radius: 40px;
            background: #2c2c2c;
            padding: 8px 6px 6px 15px;
            border: none;
            font-size: 18px;
            margin-bottom: 4px;
            margin-top: 5px;
            border-bottom: 2px solid royalblue !important;
        }

        .submit {
            text-transform: uppercase;
            cursor: pointer;
            display: flex;
            box-shadow: 0 0 2px 1px #b9add79c;
            justify-content: center;
            align-items: center;
            width: 100%;
            color: royalblue;
            border-radius: 40px;
            background: #3a3a3a;
            padding: 8px 6px 6px 15px;
            border: none;
            font-size: 16px;
            margin-bottom: 4px;
            margin-top: 25px;
            font-weight: bold;
            border-bottom: 2px solid royalblue !important;
        }

        .submit:hover {
            box-shadow: 0 0 2px 1px #ad60609c;
            border-bottom: 2px solid #e14141 !important;
            color:#e14141;
            background: #262626;
        }        
    </style>
 
    <script>        
        $(document).ready(function(){  
            $('#telefone').mask('(00) 00000-0000');
            $('#money').mask('000.000.000.000.000,00', {reverse: true});
        });
    </script>
   
@end(main)