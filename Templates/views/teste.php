<form id="form_pesquisa">
    <?=validate()?>
    <input autocomplete="off" name="pesquisa" id="pesquisa" class="form-control form-control-lg bg-dark text-white" type="text" placeholder="Procurar">  
</form>
<h4><?= session_mesage() ?></h4>

<form class="row g-3 container-sm" method="post" id="form_new" action="<?=router('login')?>"> 
    <?=validate()?>
    <input class="form-control form-control-lg bg-dark text-white" value="<?=old('nome')?>" type="text" name="nome" placeholder="nome">
    <input class="form-control form-control-lg bg-dark text-white" value="<?=old('email')?>" type="email" name="email" placeholder="E-mail">
    <input class="form-control form-control-lg bg-dark text-white" value="<?=old('senha')?>" type="password" name="senha" placeholder="Senha">
    <input class="btn btn-primary" type="submit" name="nova_conta" id="btn_new" value="Criar conta">
</form>

<br><br>                                                 

<div id="result"> </div><br>

<script>
 $("#form_pesquisa").keyup(function(){
    $.ajax({
        type: 'post',
        url: '<?= router('pesquisa') ?>',
        data: $(this).serialize(),        
        success: function (response) {
            $("#result").html(response);               
        }
    });
});
</script>
