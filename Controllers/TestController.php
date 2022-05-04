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
            usuarios::idade => 23.99,
            usuarios::nome => 'warley rodrigues',
            usuarios::sobrenome => 'rodrigues',
            usuarios::password => hash_create('teste')
        ]);
 

        // $delete = usuarios::delete([
           
        // ]);
        // dd($delete);

        $select = usuarios::select([
            'limit' => 5,
            'coluns' => [usuarios::nome,usuarios::idade],                
        ]);


        // dd(hash_check('teste',$select['password']));

        dd($select);

        // $update = usuarios::update([
        //     'update' => [usuarios::nome => 'helo word', usuarios::idade => 90],
        //     'where' => [usuarios::nome => 'warley rodrigues']
        // ]);
        // dd($update);


        return template("layouts/main", $this);
    }
}
