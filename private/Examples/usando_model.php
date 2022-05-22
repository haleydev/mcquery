<?php
use Models\usuarios;

// para criar uma model use o comando do mcquery:
// se estiver criando a partir do database:
// php mcquery migrate
// se quiser apenas uma model:
// php mcquery model:nome


$select = usuarios::select([
    // todos os itens são opcionais:
    "coluns" => "id,nome,email",
    "limit" => 10,
    "order" => "RAND()", // ou id DESC / id ASC

    // so e possivel usar um de cada vez where ou like
    "where" => [
        "nome" => "mcquery",
        "sobrenome" => "haley"
    ],

    // "like" => [
    //     "nome" => "mc"        
    // ]

    // "join" => "id = outra_tabela.coluna,id = outra_tabela.coluna",
    // ao usar join e necessario especificar os outros argumentos ex: ( "where" => ["usuarios.nome" => "mcquery","usuarios.id" => 1] )
]);
dd($select);


$insert = usuarios::insert([
    // bem simples :)
    "nome" => "mcquery",
    "idade" => "55",
    "sobrenome" => "haley"
]);
dd($insert);


$update = usuarios::update([
    // e bom especificar :)
    "where" => [
        "id" => 5
    ],

    "limit" => 1,

    // array update obrigatorio
    "update" => [
        "nome" => 'novo nome',
        "sobrenome" => 'mudei'
    ]
]);
dd($update);


$delete = usuarios::delete([
    // cuidado! se não especificar toda tabela vai ser apagada
    "limit" => 1,

    "where" => [
        "id" => 1,
        "name" => 'haley'
    ]
]);
dd($delete);