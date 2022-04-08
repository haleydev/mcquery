<p align="center">
<img src="https://user-images.githubusercontent.com/88275533/162101242-a67eeb4a-ce27-48db-a868-570d9727d9d3.png" alt="mcquery">
</p>

<!-- <p align="center">
<a href="https://travis-ci.org/haleydev/mcquery"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/haleydev/mcquery"><img src="https://img.shields.io/packagist/dt/haleydev/mcquery" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/haleydev/mcquery"><img src="https://img.shields.io/packagist/v/haleydev/mcquery" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/haleydev/mcquery"><img src="https://img.shields.io/packagist/l/haleydev/mcquery" alt="License"></a>
</p> -->

## Sobre o mcquery
O MCQUERY foi feito com a intenção de ser um framework que não dependa de outras bibliotecas ou frameworks para funcionar, sendo a única biblioteca utilizada por padrão no mcquery e o PHPMailer sendo essencial para envio de emails com o PHP, mas é claro sinta-se a vontade para instalar quantas dependências forem necessárias para seu projeto, confira a baixo a documentação do mcquery:

- [Comandos via terminal](#comandos-via-terminal)
- [Variáveis de ambiente](#variáveis-de-ambiente)
- [Router o básico](#router)
    - [Metodo URL](#url---este-metodo-não-permite-que-a-rota-tenha-parâmetros)
    - [Metodo GET](#get---este-metodo-permite-que-a-rota-tenha-parâmetros)
    - [Metodo POST](#post---para-utilizar-o-metodo-post-e-necessário-ter-um-token-de-segurança-em-seus-formulários)
    - [Metodo AJAX](#ajax---ao-contrario-do-metodo-post-o-metodo-ajax-não-atualiza-o-token-de-segurança-a-cada-requisição-mas-ainda-e-necessário-utilizar-o-token-de-segurança-em-seus-formulários)
    - [Metodo API](#api---metodo-dedicado-a-apis-seu-header-cabeçalho-ja-vem-com-content-typeapplicationjson)
- [Controllers](#controllers)
- [Models e conexão](#models-e-conexão)
- [Enviando e-mails](#enviando--e-mails)
- [Funções mcquery](#funções-mcquery)


## Comandos via terminal
![mcquery terminal](https://user-images.githubusercontent.com/88275533/162547010-691681c9-898f-4707-b8ce-e6fa8f7f85eb.png)

- **php mcquery controller:Nome** cria um novo controller, adicione 'pasta/NomeController' caso queira adicionar uma subpasta
- **php mcquery model:Nome** cria um novo model
- **php mcquery env** cria um novo arquivo de configurações (.env)
- **php mcquery conexao** testa a conexão com o banco de dados
- **php mcquery autoload** atualiza o autoload de classes
- **php mcquery install** instala as dependências do composer

## Variáveis de ambiente
```php
// retorna o valor do item declarado em .env
env('timezone'); // america/sao_paulo
```
```php
// verifica se o item foi declaro em .env retornando true ou false
// se o item estiver com seu valor vazio retornará false
// varios valores podem ser passados separados por , exemplo:
if(env_required('db_database,db_username')){
    // ...
}

```

## Router

Não é obrigatório nomear as rotas, mas é muito útil se você quiser obter a url completa da rota utilizando a função: router('nome');

Para passar parâmetros dinâmicos na url coloque entre chaves exemplo "post/{post}/{id}" em router, e para pegar esse valor utilize a função get('post') , get('id') que ira retornar o valor que esta na url.

Caso queira pegar uma url completa que contém parâmetros utilize router('post', 'php,15') separando os parâmetros a serem substituidos por ",".



Você pode chamar um arquivo diretamente, exemplo:
```php
$route->url('/post/{id}', "./Templates/views/post.php")->name('post');
```
ou chamar uma classe ou função, exemplo:
```php
$route->post('/post'", function(){ 
    echo 'HELO WORD';
    view('post');
})->name('post');
```

### URL - Este metodo não permite que a rota tenha parâmetros

Exemplo invalido: www.example.com/blog?p=414906

Exemplo valido: www.example.com/blog
```php
$route->url('/blog', function(){ 
    (new BlogController)->render();
})->name('blog');
```

### GET - Este metodo permite que a rota tenha parâmetros

Exemplo valido: www.example.com/blog?p=414906

```php
$route->get('/blog', function(){ 
    (new BlogController)->render();
})->name('blog');
```

### POST - Para utilizar o metodo POST e necessário ter um token de segurança em seus formulários

Função do mcquery: validate()

Exemplo:
```php
$route->post('/post', function(){ 
    (new PostController)->render();
})->name('post');
```

```php
<form method="POST" action="<?=router('post')?>">
    <?=validate()?>
    <input type="text" name="email" placeholder="email">
    <input type="text" name="senha" placeholder="senha">
    <input type="submit" value="entrar">
</form>
```
O HTML ficará assim:
```html
<form method="POST" action="http://localhost/post">
    <input type='hidden' name='token' value='2b32ee40f6ceaa69a91b39abc62c5ccf'/>
    <input type="text" name="email" placeholder="email">
    <input type="text" name="senha" placeholder="senha">
    <input type="submit" value="entrar">
</form> 
```

### AJAX - Ao contrario do metodo POST o metodo AJAX não atualiza o token de segurança a cada requisição, mas ainda e necessário utilizar o token de segurança em seus formulários
Lembrando que este metodo AJAX é via POST.

Exemplo:
```php
$route->ajax('/search', function(){ 
     (new AjaxController)->pesquisa();
})->name('search');
```

### API - Metodo dedicado a APIs, seu header (cabeçalho) ja vem com "Content-Type:application/json"
Os metodos aceitos nas rotas de APIs podem ser varios separados por ",".

Exemplo:
```php
$route->api('/api/genero/{genero}', function(){
     (new ApiController)->genero();
},"get,post")->name('api.genero');
```
## Controllers
O mcquery agiliza a criação de controllers com o comando ( php mcquery controller:NomeController ) caso queira adionar o controller a uma sub pastas basta adicionar "/" , ( php mcquery controller:Pasta/OutraPasta/NomeController ) o resultado será:

```php
namespace Controllers\Pasta\OutraPasta;
use App\Controller;

class NomeController extends Controller
{        
    public $title = "NomeController";
    public $view = "";    

    public function render()
    {
        $this->layout("main");         
    }
}
```
Para adiocionar um layout,view ou include em um controller utilize as seguintes funções do controller:

OBS: Se layout,view ou include estiverem especificados ( ex: $this->layout = 'main' ) não é necessário especificar o nome nas funções abaixo. 
- $this->layout('nome-do-layout')
- $this->view('nome-da-view')
- $this->include('nome-do-include')

Lembrando que estes arquivos devem estar na pasta Templates.

## Models e conexão
Um model pode ser criado com o comando ( php mcquery model:NomeModel )

Para ajudar o mcquery cria as models com algumas funções, que podem ser alteradas de acordo com as suas necessidades:

- select
- insert
- update
- delete

Lembrando que o banco de dados deve estar devidamente configurado em .env

Você pode acessar o banco de dados diretamente dessa forma:

```php
use App\Conexao;
$conexao = new Conexao;
$conexao->pdo(); // ou $conexao->mysqli();
$conexao->conect; // para conectar
$conexao->close(); // para fechar a conexao
```

Exemplo: Acessando o resultado de model em uma view usando controller.
```php
// model Sitemap
public function select()
{    
    $query = "SELECT * FROM sitemap LIMIT 100";       

    $sql = $this->conexao->conect->prepare($query);
    $sql->execute();

    if($sql->rowCount() > 0){
        $this->result = $sql->fetchAll();
    }
    $this->conexao->close();
    return;
}

// SitemapController
class SitemapController extends Controller
{   
    public $view = "sitemap";
    
    public function sitemap()
    { 
        $this->query = new Sitemap;
        $this->query->select();
        
        $this->view();
    }    
}

// acessando o resultado na view sitemap
foreach($this->query->result as $sitemap){
echo
"<url>
    <loc>https://yousite/post?p=".$sitemap['titulo']."</loc>        
    <lastmod>".$sitemap['data']."</lastmod>
    <priority>1.0</priority>
</url>";
}   
```

## Enviando  e-mails
Enviar e-mails no mcquery e bem simples, veja o exemplo abaixo:

```php
use App\Mailer;
$conteudo = "<h1>Helo Word</h1>";

$email = new Mailer;
$email->send("email_destinatario@hotmail.com","nome_destinatario", "titulo", $conteudo); 

// para enviar e-mails com anexos:
// $email->send("email_destinatario@hotmail.com","nome_destinatario", "titulo", $conteudo,"Public/images/example.png"); 
        
if($email->result == true){
    echo "email enviado com sucesso";
}
```
Lembrando que o arquivo .env deve estar configurado para enviar e-mails.

## Funções mcquery
router()
```php
// retorna a URL da rota nomeada
// se for uma rota com parâmetros, os parâmetros podem ser especificados como o segundo parâmetro da função

router('blog') // retorna http://localhost/blog

// rota com parâmetros
router('blog','post,11') // retorna http://localhost/blog/post/11
```


active()
```php
// verifica se a url atual é a mesma que a url passada, retornando true ou false
// deve ser passado a url completa
// Exemplo:

active(router('home')) // retorna true
```

view()
```php
// retorna uma view localizada em Templates/views
view('index')
```

get()
```php
// retorna o valor do parâmetro passado em router
get('id')
```

validate()
```php
// cria e imprime um token para segurança de formularios, exemplo:
<input type='hidden' name='token' value='2b32ee40f6ceaa69a91b39abc62c5ccf'/>
```
token()
```php
// retorna o token atual ou cria um novo, exemplo:
2b32ee40f6ceaa69a91b39abc62c5ccf
```
unsetToken()
```php
// Desvalida o token atual se existir
```
getCheck() / postCheck()
```php
// checa se o $_GET ou $_POST existe e se seu valor e nulo, retornando true ou false
// pode ser passado varios $_GET/$_POST separados por ,
// e muito útil para validar formulários,evita que um usuário cause um erro ao modificar o name de um campo no formulário
// exemplo
if(postCheck('name,email,senha')){
    echo "logado";
}else{
    echo "preencha todos os campos";
}
```
