@layout(main)
@set(title)->(MCQUERY)

@set(main)
   <img class="logo" src="<?= URL ?>/img/logo.png">

   <div class="info">
      <p>Bem vindo ao mcquery , leia a <a href="https://github.com/haleydev/mcquery">documentação</a> e crie algo grande!</p>
   </div>   
  
   <div class="div-versão">
      <p class="versao">mcquery v2.4.00 beta - PHP <?= phpversion() ?></p>
   </div>  
@end(main)