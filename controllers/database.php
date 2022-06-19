<?php
namespace Controllers;
use Core\Controller;
use Core\Database\Query;
use Core\Model\DB;
use Models\usuarios;

class database extends Controller
{
    public function render()
    {  
        // $insert = usuarios::insert([
        //     usuarios::nome => 'haley'
        // ]);

        // return dd($insert);

        // $delete = usuarios::delete();
        // return dd($delete);

        // $update = usuarios::update([
        //     'update' => [usuarios::nome => 'warley']
        // ]);

        // return dd($update);


        // $select = usuarios::selectOne([
        //     'where' => [
        //         usuarios::id => 17
        //     ] 
        // ]);
        // return dd($select);

        // $id = 20;

        // // $query = 'DELETE FROM usuarios WHERE id = ?';
        // $query = 'SELECT * FROM usuarios';

        // // return dd($query);

        // $teste = (new Query)->query($query);
        // return dd($teste);

        $count = DB::count('usuarios',[
            'where' => [
                'nome' => 'warley'
            ]
        ]);
        return dd($count);
    }
}