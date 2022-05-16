<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?= ROOT ?>/favicon.ico" type="image/x-icon">  
    <script src="<?= ROOT ?>/js/jquery.min.js""></script>
    <link rel="stylesheet" href="<?= ROOT ?>/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= ROOT ?>/css/main.css">  
 
    <script src="http://jqueryvalidation.org/files/dist/jquery.validate.js"></script>

    <title>Validate</title>
</head>
<body> 

<div class="main">
    <form class="row g-3 container-sm" method="post" id="form_new" action="<?= router('validate') ?>"> 
        <?=validate()?>
        <input class="form-control form-control-lg bg-dark text-white" value="<?=old('email')?>" type="text" name="nome" placeholder="nome">
        <input class="form-control form-control-lg bg-dark text-white" value="<?=old('senha')?>" type="text" name="email" placeholder="email">    
        <input class="btn btn-primary" type="submit" name="nova_conta" id="btn_new" value="go">
    </form>
</div> 

<style>
    .error {
        margin-top: 2px !important;
    }
</style>


<!-- https://jqueryvalidation.org/documentation/ -->
<script>
  var form_usuario = $("#form_new").validate({
  rules: {
    // simple rule, converted to {required:true}
    nome: {required:true,number: true},
    // compound rule
    email: {
      required: true,  
      email:true   
    }
  },
  
  
  messages: {
        // firstname: "Enter your firstname",
        // lastname: "Enter your lastname",
        // username: {
        //     required: "Enter a username",
        //     minlength: jQuery.validator.format("Enter at least {0} characters"),
        //     remote: jQuery.validator.format("{0} is already in use")
        // },
        // password: {
        //     required: "Provide a password",
        //     minlength: jQuery.validator.format("Enter at least {0} characters")
        // },
        // password_confirm: {
        //     required: "Repeat your password",
        //     minlength: jQuery.validator.format("Enter at least {0} characters"),
        //     equalTo: "Enter the same password as above"
        // },
        nome : {
            
        },

        email: {
            required: "insira seu email",
            email: "sdfsdfsdf",
            // remote: jQuery.validator.format("{0} is already in use")
        },
        // dateformat: "Choose your preferred dateformat",
        // terms: " "

       
	},
  
});

$("#form_new").submit(function(event){
	event.preventDefault();    
        if (form_usuario.numberOfInvalids() == 0) {
            console.log(true);
        }    
});  
</script>
<script src="<?=ROOT?>/js/bootstrap.min.js"></script>
</body>
</html>