<form id="form_pesquisa">
    <?=validate()?>
    <input autocomplete="off" name="pesquisa" id="pesquisa" class="form-control form-control-lg bg-dark text-white" type="text" placeholder="Procurar">  
</form>
<h4><?= session_mesage() ?></h4>

<form class="row g-3 container-sm" method="post" id="form_new" action="<?= router('ajax') ?>"> 
    <?=validate()?>
    <input class="form-control form-control-lg bg-dark text-white" value="<?=old('nome')?>" type="text" name="nome" placeholder="nome">
    <input class="form-control form-control-lg bg-dark text-white" value="<?=old('email')?>" type="text" name="id" placeholder="id">
    <input class="form-control form-control-lg bg-dark text-white" value="<?=old('senha')?>" type="text" name="quantidade" placeholder="quantidade">    
    <input class="btn btn-primary" type="submit" name="nova_conta" id="btn_new" value="Criar conta">
</form>

<br><br>                                                 

<div class="result"> </div><br>

<form action="<?=router('userdelete')?>" method="POST">
    <?= validate() ?>
    <input type="text" placeholder="id usuario para deletar" name="delete">
    <input type="submit" value="apagar">
</form>

<script>
$("#form_new").submit(function(event){
	event.preventDefault();
	var post_url = $(this).attr("action");
	var request_method = $(this).attr("method");
	var form_data = $(this).serialize();	
	$.ajax({
		url : post_url,
		type: request_method,
		data : form_data
	}).done(function(response){ //
        console.log(response);
		$(".result").html(response);
	});
});  


//  $("#form_pesquisa").keyup(function(){
//     $.ajax({
//         type: 'post',
//         url: '<?= router('pesquisa') ?>',
//         data: $(this).serialize(),        
//         success: function (response) {
//             $("#result").html(response);               
//         }
//     });
// });
</script>
