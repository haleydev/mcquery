<h1><?=session_mesage()?></h1>

<form class="row g-3 container-sm" method="post" id="form_new" action="<?=router('login')?>"> 
    <?=validate()?>
    <input class="form-control form-control-lg bg-dark text-white" value="<?=old('novo_usuario')?>" type="text" name="novo_usuario" placeholder="Usuario">
    <input class="form-control form-control-lg bg-dark text-white" value="<?=old('novo_email')?>" type="email" name="novo_email" placeholder="E-mail">
    <input class="form-control form-control-lg bg-dark text-white" value="<?=old('nova_senha')?>" type="password" name="nova_senha" placeholder="Senha">
    <input class="btn btn-primary" type="submit" name="nova_conta" id="btn_new" value="Criar conta">
</form>