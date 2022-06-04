<?php
namespace App\Commands;
use Core\Database\Migration;

class Command_Model
{   
    public function model($model)
    {
        (new Migration)->new_model($model);               
    }
}