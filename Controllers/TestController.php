<?php
namespace Controllers;

use Core\Controller;
use Models\usuarios;

class TestController extends Controller
{
    public function render()
    {
        $this->title = "testes";
        $this->view = "views/teste";

        usuarios::insert([
            usuarios::$idade => 23.99,
            usuarios::$nome => 'warley rodrigues',
            usuarios::$sobrenome => 'rodrigues'
        ]);

        $delete = usuarios::delete([
            'where' => [
                usuarios::$nome => 'warley rodrigues',
                usuarios::$id => 4
            ]
        ]);
        dd($delete);

        $select = usuarios::select([
            'coluns' => [usuarios::$nome, usuarios::$id, usuarios::$idade],
            'limit' => 5
        ]);
        dd($select);

        $update = usuarios::update([
            'update' => [usuarios::$nome => 'helo word', usuarios::$idade => 90],
            'where' => [usuarios::$nome => 'warley rodrigues']
        ]);
        dd($update);





        // return template("layouts/main", $this);
    }
}
