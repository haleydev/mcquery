@layout(main)
@set(title)->(pagina de testes)

@set(head)
    <meta name="mcquery-token" content="<?= token() ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="<?= URL ?>/js/jquery.min.js"></script>
@end(head)

@set(main)
    <form id="form" method="POST" action="<?= route('ajax') ?>">          
        <input value="<?= old('nome') ?>" type="text" name="nome" placeholder="nome">
        <input value="<?= old('email') ?>" type="text" name="email" placeholder="email">
        <input type="submit" value="enviar">
    </form>
    <div id="result"></div>

    <script>  
        $('#form').submit(function(e){
            e.preventDefault() 
            $.ajax({      
                headers: {'MCQUERY-TOKEN' : $('meta[name="mcquery-token"]').attr('content')},     
                url: $(this).attr('action'),          
                type: $(this).attr('method'),
                data: $(this).serialize(), 
                dataType: "json",  
                success:function(result){
                    console.log(result);
                    $("#result").html(result.nome + '<br>' + result.email)
                }
            }) 
        })     
    </script>
@end(main)