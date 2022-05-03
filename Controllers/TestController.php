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

        // $max = 100;
        // $count = 0;

        // while($count <= $max){
            // usuarios::insert([
            //     usuarios::idade => 23.99,
            //     usuarios::nome => 'warley rodrigues',
            //     usuarios::sobrenome => 'rodrigues',
            //     usuarios::password => hash_create('teste')
            // ]);
        //     $count ++;
        // }

        $delete = usuarios::delete([
           
        ]);
        dd($delete);

        $select = usuarios::select([
                
        ]);


        // dd(hash_check('teste',$select['password']));

        dd($select);

        // $update = usuarios::update([
        //     'update' => [usuarios::nome => 'helo word', usuarios::idade => 90],
        //     'where' => [usuarios::nome => 'warley rodrigues']
        // ]);
        // dd($update);


        // return template("layouts/main", $this);
    }
}
