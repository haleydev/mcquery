<p align="center">
<img src="https://user-images.githubusercontent.com/88275533/162101242-a67eeb4a-ce27-48db-a868-570d9727d9d3.png" alt="mcquery">
</p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/haleydev/mcquery" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/haleydev/mcquery" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/haleydev/mcquery" alt="License"></a>
</p>

## Sobre o mcquery
O MCQUERY foi feito com a intenção de ser um framework que não dependa de outras bibliotecas ou frameworks para funcionar, sendo a única biblioteca utilizada por padrão no mcquery e o PHPMailer sendo essencial para envio de emails com o PHP, mas é claro sinta-se a vontade para instalar quantas dependências forem necessárias para seu projeto, confira a baixo a documentação desse maravilhoso projeto:

- [Comandos via terminal](#comandos-via-terminal)
- [Variáveis de ambiente](#variáveis-de-ambiente)
- [Router o basico](#router)
    - [Metodo URL](#url---este-metodo-não-permite-que-a-rota-tenha-parâmetros)
    - [Metodo GET](#get---este-metodo-permite-que-a-rota-tenha-parâmetros)
    - [Metodo POST](#post---para-utilizar-o-metodo-post-e-necessário-ter-um-token-de-segurança-em-seus-formulários)
    - [Metodo AJAX](#ajax---ao-contrario-do-metodo-post-o-metodo-ajax-não-atualiza-o-token-de-segurança-a-cada-requisição-mas-ainda-e-necessário-utilizar-o-token-de-segurança-em-seus-formulários)
    - [Metodo API](#api---metodo-dedicado-a-apis-seu-header-cabeçalho-ja-vem-com-content-typeapplicationjson)
## Comandos via terminal
![mcquery terminal](https://user-images.githubusercontent.com/88275533/162103945-9826d12d-e9bd-4bfd-bd45-061acff4740c.png)
- **php mcquery config** cria o arquivo de configurações (config.ini) e instala dependências
- **php mcquery controller:Nome** cria um novo controller, adicione 'pasta/NomeController' caso queira adicionar uma subpasta
- **php mcquery model:Nome** cria um novo model
- **php mcquery conexao** testa a conexão com o banco de dados
- **php mcquery autoload** atualiza o autoload de classes
## Variáveis de ambiente

Para iniciar esse projeto, você vai precisar rodar "php mcquery config" no terminal e configurar as variáveis de ambiente, caso não for utilizar o PHPMailer ou banco de dados, os campos podem ficar em branco.
## Router


Não é obrigatório nomear as rotas, mas é muito útil se você quiser obter a url completa da rota utilizando a função: router('nome');

Para passar parâmetros dinâmicos na url coloque entre chaves exemplo "post/{post}/{id}" em router, e para pegar esse valor utilize a função get('post') , get('id') que ira retornar o valor que esta na url.

Caso queira pegar uma url completa que contém parâmetros utilize router('post', 'php,15') separando os parâmetros a serem substituidos por ",".



Você pode chamar um arquivo diretamente, exemplo:
```
$app->url("post", "./Templates/views/post.php")->name('post');
```
ou chamar uma classe ou função, exemplo:
```
$app->post("post", function(){ 
    echo 'HELO WORD';
    view('post');
})->name('post');
```

### url - Este metodo não permite que a rota tenha parâmetros

Exemplo invalido: www.example.com/blog?p=414906

Exemplo valido: www.example.com/blog
```
$app->url("blog", function(){ 
    (new BlogController)->render();
})->name('blog');
```

### get - Este metodo permite que a rota tenha parâmetros

Exemplo valido: www.example.com/blog?p=414906

```
$app->get("blog", function(){ 
    (new BlogController)->render();
})->name('blog');
```

### post - Para utilizar o metodo POST e necessário ter um token de segurança em seus formulários

Função do mcquery: validate()

Exemplo:
```
$app->post("post", function(){ 
    (new PostController)->render();
})->name('post');
```

```
<form method="POST" action="<?=router('post')?>">
    <?=validate()?>
    <input type="text" name="email" placeholder="email">
    <input type="text" name="senha" placeholder="senha">
    <input type="submit" value="entrar">
</form>
```
O HTML ficará assim:
```
<form method="POST" action="http://localhost/post">
    <input type='hidden' name='token' value='2b32ee40f6ceaa69a91b39abc62c5ccf'/>
    <input type="text" name="email" placeholder="email">
    <input type="text" name="senha" placeholder="senha">
    <input type="submit" value="entrar">
</form> 
```

### ajax - Ao contrario do metodo POST o metodo AJAX não atualiza o token de segurança a cada requisição, mas ainda e necessário utilizar o token de segurança em seus formulários
Lembrando que este metodo AJAX é via POST.

Exemplo:
```
$app->ajax("search", function(){ 
     (new AjaxController)->pesquisa();
})->name('search');
```

### api - Metodo dedicado a APIs, seu header (cabeçalho) ja vem com "Content-Type:application/json"
Os metodos aceitos nas rotas de APIs podem ser varios separados por ",".

Exemplo:
```
$app->api("api/genero/{genero}", function(){
     (new ApiController)->genero();
},"get,post")->name('api.genero');
```
