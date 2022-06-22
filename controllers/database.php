<?php
namespace Controllers;
use Core\Controller;
use Core\Database\Query;
use Core\Model\DB;
use Core\Model\Options;
use Core\Model\OptionsSelect;
use Models\haley;
use Models\teste;
use Models\usuarios;

class database extends Controller
{
    public function render()
    {  
        // $insert = haley::insert([
        //     haley::nome => 'helo word'
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

        // $count = DB::count('usuarios',[
        //     'where' => [
        //         'nome' => 'warley'
        //     ]
        // ]);
        // return dd($count);

        // $select = DB::select('id,nome')           
        // ->where(['nome' => 'warley'],'!=')
        // ->where(['id' => 16])
        // ->limit(1)
        // ->order('RAND()')
        // ->execute();        
        // dd($select);

        $select = DB::selectOne('usuarios')
        ->coluns('count(id) as total') 
        ->execute();                  
        dd($select);

        // $join = new OptionsSelect;
        // $join->table = 'table';
        // $join->join('teste1',['usuarios' => 'id']);
        // dd($join->join('teste2',['usuarios' => 'id', 'table3' => 'id']));

        // $join = DB::select('usuarigos u')    
        // ->coluns(['m.execution_dt as date','u.*','h.nome as nome_haley']) 
        // ->join('migrations m',['u.id' => 'm.id', 'm.id' => 1])
        // ->join('haley h',['u.id' => 'h.id'])
        // ->execute(); 
        // dd($join);

        // $query1 = DB::select('usuarios')->coluns()->get_query();
        // $query2 = DB::select('teste')->coluns()->get_query();
        // $join = DB::query("$query1 UNION ALL $query2");                  
        // dd($join);


        // $teste = new Options;
        // $teste->where(['nome' => 'warley'],'!=');
        // dd($teste->where(['id' => 16]));

        
            

        dd(DB::select('usuarios')
            ->coluns('id,nome')
            ->where(['nome' => 'warley'])
            ->limit(30)->execute()
        );
    }
}